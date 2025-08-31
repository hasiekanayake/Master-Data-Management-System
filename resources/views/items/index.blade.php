@extends('layouts.app')

@section('title', 'Items - MDM System')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Item Management</h2>
                <a href="{{ route('items.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add New Item
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter Form -->
            <div class="card glass-card mb-4">
                <div class="card-body">
                    <form action="{{ route('items.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by code, name or status..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-download me-1"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('items.export', ['type' => 'csv']) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}">CSV</a></li>
                                    <li><a class="dropdown-item" href="{{ route('items.export', ['type' => 'xlsx']) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}">Excel</a></li>
                                    <li><a class="dropdown-item" href="{{ route('items.export', ['type' => 'pdf']) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}">PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card glass-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Items</h5>
                </div>
                <div class="card-body">
                    @if($items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->brand->name }}</td>
                                            <td>{{ $item->category->name }}</td>
                                            <td>
                                                <form action="{{ route('items.toggle-status', $item) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm @if($item->status === 'Active') btn-success @else btn-secondary @endif">
                                                        {{ $item->status }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $item->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteItemModal{{ $item->id }}">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteItemModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete the item "{{ $item->name }}"?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('items.destroy', $item) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $items->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam display-4 text-muted"></i>
                            <p class="mt-3 text-muted">No items found.</p>
                            @if(request()->has('search') || request()->has('status'))
                                <a href="{{ route('items.index') }}" class="btn btn-secondary mt-2">
                                    <i class="bi bi-arrow-left me-1"></i> Clear Filters
                                </a>
                            @endif
                            <a href="{{ route('items.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Create Item
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
