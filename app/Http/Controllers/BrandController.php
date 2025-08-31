<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BrandController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Brand::with('user');

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $brands = $query->paginate(5)->withQueryString();

        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:brands|max:50',
            'name' => 'required|max:100',
            'status' => 'required|in:Active,Inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Brand::create([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $request->status,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        $this->authorize('update', $brand);
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $this->authorize('update', $brand);

        $validator = Validator::make($request->all(), [
            'code' => 'required|max:50|unique:brands,code,' . $brand->id,
            'name' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $brand->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return redirect()->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $this->authorize('delete', $brand);

        if ($brand->items()->count() > 0) {
            return redirect()->route('brands.index')
                ->with('error', 'Cannot delete brand. It has associated items.');
        }

        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'Brand deleted successfully.');
    }

    public function export()
    {
        $query = Brand::with('user');

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $brands = $query->get();

        $fileName = 'brands_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($brands) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['Code', 'Name', 'Status', 'Created By', 'Created At']);

            // Add data
            foreach ($brands as $brand) {
                fputcsv($file, [
                    $brand->code,
                    $brand->name,
                    $brand->status,
                    $brand->user->name,
                    $brand->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
