@extends('app')

@section('content')
    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold" style="color:#5e2b63;">Admin Dashboard</h2>
                <p class="text-muted">Manage your items</p>
            </div>

            <a href="/admin/order" class="btn shadow-sm" style="background-color:#b66ec0; color:white;">
                Order List
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">

                <h4 class="mb-4 fw-bold" style="color:#5e2b63;">Add New Product</h4>

                <form action="/admin/products/add" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-3">
                            <label class="form-label">SKU</label>
                            <input type="text" class="form-control" name="sku" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Price</label>
                            <input type="text" class="form-control" name="price" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Material</label>
                            <input type="text" class="form-control" name="material" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Length</label>
                            <input type="text" class="form-control" name="length" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Gemstone</label>
                            <input type="text" class="form-control" name="gemstone" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Clasp Type</label>
                            <input type="text" class="form-control" name="clasp_type" required>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Style</label>
                            <input type="text" class="form-control" name="style" required>
                        </div>

                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn" style="background-color:#b66ec0; color:white;">
                            Add Product
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <h4 class="mb-4 fw-bold" style="color:#5e2b63;">Product Inventory</h4>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead style="background:#f4ecf7;">
                            <tr>
                                <th>Image</th>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Material</th>
                                <th>Style</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($rs as $row)
                                <tr>

                                    <td>
                                        <img src="{{ file_exists($row->image) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($row->image)) : '' }}"
                                            class="rounded" style="height:60px; object-fit:cover;">
                                    </td>

                                    <td>{{ $row->sku }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>${{ number_format($row->price, 2) }}</td>
                                    <td>{{ $row->material }}</td>
                                    <td>{{ $row->style }}</td>

                                    <td class="text-end">

                                        <a href="/admin/products/edit/{{ $row->sku }}" class="btn btn-sm me-2"
                                            style="background:#5e2b63; color:white;">
                                            Edit
                                        </a>

                                        <form action="/admin/products" method="post" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="sku" value="{{ $row->sku }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
