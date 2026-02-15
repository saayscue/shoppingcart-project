@extends('app')

@section('content')

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="fw-bold" style="color:#5e2b63;">Your Cart</h1>
                <p class="text-muted">Review your selected pieces</p>
            </div>

            <div>
                <a href="/" class="btn me-2" style="background-color:#b66ec0; color:white;">
                    ← Browse Products
                </a>

                <a href="/checkout" class="btn shadow-sm" style="background-color:#5e2b63; color:white;">
                    Proceed to Checkout
                </a>
            </div>
        </div>

        @if (count($cartItems) > 0)
            <div class="row g-4">

                @foreach ($cartItems as $item)
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">

                            <div class="row g-0 align-items-center">

                                <div class="col-4 text-center p-3" style="background:#f9f4fb;">
                                    <img src="{{ file_exists($item->image) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($item->image)) : '' }}"
                                        class="img-fluid rounded" style="max-height:150px; object-fit:contain;">
                                </div>

                                <div class="col-8 p-4">

                                    <h5 class="fw-bold mb-1">{{ $item->name }}</h5>
                                    <small class="text-muted d-block mb-2">SKU: {{ $item->sku }}</small>

                                    <p class="mb-2">
                                        <strong style="color:#5e2b63;">
                                            ${{ number_format($item->price, 2) }}
                                        </strong>
                                    </p>

                                    <form action="/cart/update" method="post" class="d-flex align-items-center mb-2">
                                        @csrf
                                        <input type="hidden" name="sku" value="{{ $item->sku }}">

                                        <select name="quantity" class="form-select me-2" style="width:80px;" required>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->quantity == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>

                                        <button type="submit" class="btn btn-sm"
                                            style="background-color:#b66ec0; color:white;">
                                            Update
                                        </button>
                                    </form>

                                    <form action="/cart" method="post">
                                        @csrf
                                        <input type="hidden" name="sku" value="{{ $item->sku }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Remove
                                        </button>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

            <div class="card mt-5 shadow-sm border-0">
                <div class="card-body text-end">

                    <h5>Total Items: {{ $totalItems }}</h5>
                    <h4 class="fw-bold" style="color:#5e2b63;">
                        Total Cost: ${{ number_format($totalCost, 2) }}
                    </h4>

                </div>
            </div>
        @else
            <div class="text-center py-5">
                <h4 class="text-muted">Your cart is currently empty</h4>
                <a href="/" class="btn mt-3" style="background-color:#b66ec0; color:white;">
                    Start Shopping
                </a>
            </div>
        @endif

    </div>

@endsection
