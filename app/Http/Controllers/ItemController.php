<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ItemController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Item::with(['user', 'brand', 'category']);

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('brand', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('brand') && !empty($request->brand)) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $items = $query->paginate(5)->withQueryString();
        $brands = Brand::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();

        return view('items.index', compact('items', 'brands', 'categories'));
    }

    public function create()
    {
        $brands = Brand::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();

        return view('items.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:items|max:50',
            'name' => 'required|max:100',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:Active,Inactive',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('items', 'public');
        }

        Item::create([
            'code' => $request->code,
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'file_path' => $filePath,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function edit(Item $item)
    {
        $this->authorize('update', $item);

        $brands = Brand::where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();

        return view('items.edit', compact('item', 'brands', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $validator = Validator::make($request->all(), [
            'code' => 'required|max:50|unique:items,code,' . $item->id,
            'name' => 'required|max:100',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $filePath = $item->file_path;
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }

            $filePath = $request->file('file')->store('items', 'public');
        }

        $item->update([
            'code' => $request->code,
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        // Delete associated file if exists
        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Item deleted successfully.');
    }

    public function export()
    {
        $query = Item::with(['user', 'brand', 'category']);

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $items = $query->get();

        $fileName = 'items_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($items) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['Code', 'Name', 'Brand', 'Category', 'Status', 'Created By', 'Created At']);

            // Add data
            foreach ($items as $item) {
                fputcsv($file, [
                    $item->code,
                    $item->name,
                    $item->brand->name,
                    $item->category->name,
                    $item->status,
                    $item->user->name,
                    $item->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
