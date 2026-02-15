@extends('app')

@section('content')

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="fw-bold" style="color:#5e2b63;">Order Management</h1>
                <p class="text-muted">Review and manage customer purchases</p>
            </div>

            <a href="/admin/products" class="btn shadow-sm" style="background-color:#b66ec0; color:white; border:none;">
                Admin Product Page
            </a>
        </div>

        @if (count($orders) > 0)
            <div class="row g-4">

                @foreach ($orders as $order)
                    <div class="col-12">
                        <div class="card shadow-sm border-0">

                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <h5 class="fw-bold mb-1" style="color:#5e2b63;">
                                            Order #{{ $order->order_id }}
                                        </h5>
                                        <small class="text-muted">
                                            Cart ID: {{ $order->cart_id }}
                                        </small>
                                    </div>

                                    <div class="text-end">
                                        <strong style="color:#5e2b63;">
                                            ${{ number_format($order->total_cost, 2) }}
                                        </strong><br>
                                        <small class="text-muted">
                                            {{ $order->total_quantity }} items
                                        </small>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Customer</strong><br>
                                        {{ $order->first_name }} {{ $order->last_name }}<br>
                                        <span class="text-muted">{{ $order->email }}</span><br>
                                        <span class="text-muted">{{ $order->phone_number }}</span>
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Shipping Address</strong><br>
                                        {{ $order->street_number }} {{ $order->street_name }}
                                        @if ($order->apt_number)
                                            Apt. {{ $order->apt_number }}
                                        @endif
                                        <br>
                                        {{ $order->city }}, {{ $order->state }} {{ $order->zip }}
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Shipping Method</strong><br>
                                        <span class="badge" style="background-color:#f0d9f5; color:#5e2b63;">
                                            {{ $order->shipping_method }}
                                        </span>
                                    </div>
                                </div>

                                <hr>

                                <div>
                                    <strong>Products Purchased</strong>
                                    <div class="mt-2 text-muted">
                                        {!! $order->products !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @else
            <div class="text-center py-5">
                <h5 class="text-muted">No orders found.</h5>
            </div>
        @endif

    </div>

@endsection
