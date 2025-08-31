<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Category::with('user');

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

        $categories = $query->paginate(5)->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:categories|max:50',
            'name' => 'required|max:100',
            'status' => 'required|in:Active,Inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Category::create([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $request->status,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $validator = Validator::make($request->all(), [
            'code' => 'required|max:50|unique:categories,code,' . $category->id,
            'name' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        if ($category->items()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category. It has associated items.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function export()
    {
        $query = Category::with('user');

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $categories = $query->get();

        $fileName = 'categories_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['Code', 'Name', 'Status', 'Created By', 'Created At']);

            // Add data
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->code,
                    $category->name,
                    $category->status,
                    $category->user->name,
                    $category->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
