@extends('app')

@section('content')
    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold" style="color:#5e2b63;">
                    Checkout
                </h2>
                <p class="text-muted">Shipping Information</p>
            </div>

            <a href="/cart" class="btn shadow-sm" style="background-color:#b66ec0; border:none; color:white;">
                Back to Cart
            </a>
        </div>

        <div class="card shadow-sm border-0 p-4" style="background:#faf7fc;">

            <form action="/checkout" method="post">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}"
                            required>
                        @error('first_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Contact -->
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}"
                            required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Street Number</label>
                        <input type="text" name="street_number" class="form-control" value="{{ old('street_number') }}"
                            required>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">Street Name</label>
                        <input type="text" name="street_name" class="form-control" value="{{ old('street_name') }}"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Apartment</label>
                        <input type="text" name="apt" class="form-control" value="{{ old('apt') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Zip Code</label>
                        <input type="text" name="zip" class="form-control" value="{{ old('zip') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Shipping Method</label>
                        <select name="shipping_method" class="form-select" required>
                            <option value="standard" {{ old('shipping_method') == 'standard' ? 'selected' : '' }}>
                                Standard Shipping
                            </option>
                            <option value="expedited" {{ old('shipping_method') == 'expedited' ? 'selected' : '' }}>
                                Expedited Shipping
                            </option>
                        </select>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-lg w-100 shadow-sm"
                            style="background-color:#b66ec0; color:white; border:none;">
                            Place Order
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
