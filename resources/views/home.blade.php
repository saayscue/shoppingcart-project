@extends('app')

@section('content')
    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="fw-bold" style="color:#5e2b63;">The Necklace Loft</h1>
                <p class="text-muted">Browse products</p>
            </div>

            <a href="/cart" class="btn btn-lg shadow-sm" style="background-color:#b66ec0; border:none; color:white;">
                View Cart
            </a>
        </div>

        <div class="row g-4">

            @foreach ($rs as $row)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">

                        <div class="text-center p-3" style="background:#f9f4fb;">
                            <img src="{{ file_exists($row->image) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($row->image)) : '' }}"
                                class="img-fluid rounded" style="max-height:200px; object-fit:contain;">
                        </div>

                        <div class="card-body d-flex flex-column">

                            <h5 class="fw-bold">{{ $row->name }}</h5>

                            <p class="text-muted small mb-2">
                                {{ $row->description }}
                            </p>

                            <div class="mb-2">
                                <strong style="color:#5e2b63;">
                                    ${{ number_format($row->price, 2) }}
                                </strong>
                            </div>

                            <small class="text-muted mb-3">
                                {{ $row->material }} · {{ $row->length }} · {{ $row->style }}
                            </small>

                            <a href="/products/{{ $row->sku }}" class="btn mt-auto"
                                style="background-color:#b66ec0; color:white;">
                                View Details
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
@endsection
