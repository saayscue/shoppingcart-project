@extends('app')

@section('content')
    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold" style="color:#5e2b63;">Product Details</h2>

            <div>
                <a href="/" class="btn me-2" style="background-color:#b66ec0; color:white;">
                    ← Back to Products
                </a>

                <a href="/cart" class="btn" style="background-color:#b66ec0; color:white;">
                    🛒 View Cart
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4">

            <div class="row g-5 align-items-center">

                <div class="col-md-5 text-center">
                    <div style="background:#f9f4fb; padding:30px; border-radius:12px;">
                        <img src="{{ file_exists($products->image) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($products->image)) : '' }}"
                            class="img-fluid rounded" style="max-height:350px; object-fit:contain;">
                    </div>
                </div>

                <div class="col-md-7">

                    <h2 class="fw-bold mb-3">{{ $products->name }}</h2>

                    <p class="text-muted mb-4">
                        {{ $products->description }}
                    </p>

                    <h4 class="fw-bold mb-4" style="color:#5e2b63;">
                        ${{ number_format($products->price, 2) }}
                    </h4>

                    <div class="row mb-4">
                        <div class="col-6">
                            <small class="text-muted">Material</small>
                            <div>{{ $products->material }}</div>
                        </div>

                        <div class="col-6">
                            <small class="text-muted">Length</small>
                            <div>{{ $products->length }}</div>
                        </div>

                        <div class="col-6 mt-3">
                            <small class="text-muted">Gemstone</small>
                            <div>{{ $products->gemstone }}</div>
                        </div>

                        <div class="col-6 mt-3">
                            <small class="text-muted">Clasp Type</small>
                            <div>{{ $products->clasp_type }}</div>
                        </div>

                        <div class="col-6 mt-3">
                            <small class="text-muted">Style</small>
                            <div>{{ $products->style }}</div>
                        </div>

                        <div class="col-6 mt-3">
                            <small class="text-muted">SKU</small>
                            <div>{{ $products->sku }}</div>
                        </div>
                    </div>

                    <form action="/products/{{ $products->sku }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-lg w-100 shadow-sm"
                            style="background-color:#b66ec0; color:white;">
                            Add to Cart
                        </button>
                    </form>

                </div>

            </div>
        </div>

    </div>
@endsection
