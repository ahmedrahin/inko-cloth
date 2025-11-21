@extends('frontend.layout.app')

@section('page-title')
    Order Confirmed | {{ config('app.name') }}
@endsection

@section('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #009742 ;
            --success-color: #10b981;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --border-color: #e5e7eb;
            --text-color: #374151;
            --text-muted: #6b7280;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: #f5f7fa;
        }

        .success-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 15px;
        }

        .success-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .success-header {
            background: linear-gradient(190deg, #219554, #8989898c);
            color: white;
            padding: 2.5rem;
            text-align: center;
            position: relative;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: white;
            color: var(--success-color);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
        }

        .success-header h2 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }

       .success-container .success-header p {
            opacity: 0.9;
            margin-bottom: 0;
            font-size: 1.1rem;
        }

       .success-container .order-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 1.5rem 0;
            background: var(--light-color);
            border-bottom: 1px solid var(--border-color);
        }

       .success-container .detail-item {
            text-align: center;
            padding: 0 1rem;
            margin: 0.5rem 0;
        }

       .success-container .detail-item strong {
            display: block;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
            font-size: 1.1rem;
        }

       .success-container .detail-item span {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

       .success-container .order-content {
            display: flex;
            flex-wrap: wrap;
            padding: 0;
        }

        .success-container .order-items {
            flex: 1 1 60%;
            padding: 2rem;
            border-right: 1px solid var(--border-color);
            min-width: 300px;
        }

       .success-container .order-summary {
            flex: 1 1 40%;
            padding: 2rem;
            background: var(--light-color);
            min-width: 300px;
        }

       .success-container .section-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

       .success-container .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

       .success-container .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

      .success-container  .order-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

       .success-container .item-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1.5rem;
            border: 1px solid var(--border-color);
            flex-shrink: 0;
        }

       .success-container  .item-details {
            flex-grow: 1;
        }

        .success-container .item-name {
            font-weight: 500;
            margin-bottom: 0.25rem;
            color: var(--dark-color);
        }

        .success-container .item-name a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .success-container .item-name a:hover {
            color: var(--primary-color);
        }

        .success-container .item-variants {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .success-container .item-meta {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .success-container .item-price {
            font-weight: 600;
            color: var(--dark-color);
            min-width: 80px;
            text-align: right;
        }

        .success-container .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .success-container .summary-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .success-container .summary-label {
            color: var(--text-muted);
        }

        .success-container .summary-value {
            font-weight: 500;
        }

       .success-container  .summary-total {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark-color);
        }

        .success-container .shipping-info {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

         .success-container .shipping-address {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1rem;
            border: 1px solid var(--border-color);
        }

        .success-container .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .success-container .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex: 1;
            min-width: 200px;
        }

        .success-container .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .success-container .btn-primary:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .success-container .btn-outline {
            background: white;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .success-container .btn-outline:hover {
            background: #f5f3ff;
            transform: translateY(-2px);
        }

        .success-container .btn i {
            margin-right: 8px;
        }

        .order-date {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.5rem;
            display: block;
        }

        #cart, #cmpr-btn, .mc-wishlist {
            display: none;
        }

        @media (max-width: 768px) {
            .order-content {
                flex-direction: column;
            }

            .order-items {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .success-header {
                padding: 1.5rem;
            }

            .success-header h2 {
                font-size: 1.5rem;
                line-height: 33px;
            }

            .order-details {
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem;
            }

            .detail-item {
                text-align: left;
                margin: 0.5rem 0;
                padding: 0;
                width: 100%;
            }

            .item-image {
                width: 60px;
                height: 60px;
                margin-right: 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .success-container .btn {
                width: 100%;
                padding: 4px;
            }
            .success-icon{
                width: 50px;
                 height: 50px;
                 font-size: 28px;
            }
        }
    </style>
@endsection

@section('body-content')
    @php
        $payment = match ($order->payment_type) {
            'cod' => 'Cash On Delivery',
            'sslcommerz' => 'Online Payment',
            default => 'Unknown',
        };
    @endphp

    <div class="success-container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h2>Thank You For Your Order!</h2>
                <p>Your order has been confirmed and will be processed shortly</p>
            </div>

            <div class="order-details">
                <div class="detail-item">
                    <strong>Order Number</strong>
                    <span>#{{ $order->order_id }}</span>
                </div>
                <div class="detail-item">
                    <strong>Date</strong>
                    <span>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</span>
                </div>
                <div class="detail-item">
                    <strong>Total</strong>
                    <span>৳{{ number_format($order->grand_total, 2) }}</span>
                </div>
                <div class="detail-item">
                    <strong>Payment Method</strong>
                    <span>{{ $payment }}</span>
                </div>
            </div>

            <div class="order-content">
                <div class="order-items">
                    <h3 class="section-title">Your Order</h3>

                    @foreach ($order->orderItems as $item)
                        <div class="order-item">
                            <img src="{{ asset($item->product->thumb_image) }}" alt="{{ $item->product->name }}" class="item-image">
                            <div class="item-details">
                                <h4 class="item-name">
                                    <a href="{{ route('product-details', $item->product->slug) }}">
                                        {{ $item->product->name }}
                                    </a>
                                </h4>
                                @if ($item->orderItemVariations->count())
                                    <div class="item-variants">
                                        @foreach ($item->orderItemVariations as $variant)
                                            {{ ucfirst($variant->attribute_name) }}: {{ ucfirst($variant->attribute_value) }}
                                            @if (!$loop->last) - @endif
                                        @endforeach
                                    </div>
                                @endif
                                <div class="item-meta">Qty: {{ $item->quantity }} | Unit Price: ৳{{ $item->price }}</div>
                            </div>
                            <div class="item-price">৳{{ $item->price * $item->quantity }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="order-summary">
                    <h3 class="section-title">Order Summary</h3>

                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">৳{{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Shipping</span>
                        <span class="summary-value">৳{{ number_format($order->shipping_cost, 0) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Discount</span>
                        <span class="summary-value">-৳{{ number_format($order->coupon_discount, 0) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-total">Total</span>
                        <span class="summary-total">৳{{ number_format($order->grand_total, 0) }}</span>
                    </div>

                    <div class="shipping-info">
                        <h3 class="section-title">Shipping Information</h3>
                        <div class="shipping-address">
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->district->name ?? '' }}</p>
                            <span class="order-date">
                                <i class="far fa-clock"></i> Ordered on {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y - h:i A') }}
                            </span>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('order.invoice.pdf', $order->order_id) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> Download Invoice
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline">
                            <i class="fas fa-shopping-bag"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
            }).showToast();
        </script>
    @endif
@endsection
