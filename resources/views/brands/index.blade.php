@extends('layouts.app')

@section('title', 'Brands - MDM System')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Brand Management</h2>
                <a href="{{ route('brands.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add New Brand
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card glass-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Brands</h5>
                </div>
                <div class="card-body">
                    @if($brands->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $brand)
                                        <tr>
                                            <td>{{ $brand->code }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>
                                                <form action="{{ route('brands.toggle-status', $brand) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm @if($brand->status === 'Active') btn-success @else btn-secondary @endif">
                                                        {{ $brand->status }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $brand->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteBrandModal{{ $brand->id }}">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete the brand "{{ $brand->name }}"?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('brands.destroy', $brand) }}" method="POST">
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
                            {{ $brands->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-tags display-4 text-muted"></i>
                            <p class="mt-3 text-muted">No brands found. Create your first brand to get started.</p>
                            <a href="{{ route('brands.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Create Brand
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
