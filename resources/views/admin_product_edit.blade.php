@extends('app')

@section('content')
    <div class="container py-5">

        <div class="mb-5">
            <h1 class="fw-bold" style="color:#5e2b63;">
                Edit Product
            </h1>
            <p class="text-muted">Update product details</p>
        </div>

        <div class="card shadow-sm border-0 p-4">

            <form action="/admin/products/update" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="sku" value="{{ $product->sku }}">

                <div class="row g-4">

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">Current Image</label>

                        <div class="text-center p-3 mb-3" style="background:#f9f4fb; border-radius:12px;">
                            <img src="{{ file_exists($product->image) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($product->image)) : '' }}"
                                class="img-fluid rounded" style="max-height:250px; object-fit:contain;">
                        </div>

                        <label class="form-label">Upload New Image</label>
                        <input type="file" class="form-control mb-2" name="image" accept="image/*">

                        <small class="text-muted">
                            Leave blank to keep current image.
                        </small>

                        <input type="hidden" name="current_image" value="{{ $product->image }}" />

                    </div>

                    <div class="col-md-8">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" value="{{ $product->sku }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" name="price" value="{{ $product->price }}"
                                    required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $product->name }}"
                                    required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required>{{ $product->description }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Material</label>
                                <input type="text" class="form-control" name="material" value="{{ $product->material }}"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Length</label>
                                <input type="text" class="form-control" name="length" value="{{ $product->length }}"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Gemstone</label>
                                <input type="text" class="form-control" name="gemstone" value="{{ $product->gemstone }}"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Clasp Type</label>
                                <input type="text" class="form-control" name="clasp_type"
                                    value="{{ $product->clasp_type }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Style</label>
                                <input type="text" class="form-control" name="style" value="{{ $product->style }}"
                                    required>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn px-4" style="background-color:#b66ec0; color:white;">
                        Update Product
                    </button>
                </div>

            </form>

        </div>

    </div>
@endsection
