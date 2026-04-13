<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation - {{ $companyName }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .order-details { background: white; border-radius: 8px; padding: 20px; margin: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .order-item { border-bottom: 1px solid #eee; padding: 10px 0; }
        .order-item:last-child { border-bottom: none; }
        .total-row { font-weight: bold; font-size: 1.1em; }
        .btn { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Your Order!</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>

        <div class="content">
            <p>Dear {{ $order->customer_name }},</p>

            <p>Thank you for shopping with {{ $companyName }}! We have received your order and it is being processed.</p>

            <div class="order-details">
                <h2>Order Summary</h2>
                <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</p>

                <h3>Shipping Address</h3>
                <p>{{ $order->shipping_address }}</p>

                <h3>Order Items</h3>
                @foreach($orderItems as $item)
                <div class="order-item">
                    <p><strong>{{ $item->product_name }}</strong> ({{ $item->product_code }})</p>
                    <p>Quantity: {{ $item->quantity }} × ৳{{ number_format($item->unit_price, 2) }}</p>
                    <p>Total: ৳{{ number_format($item->total_price, 2) }}</p>
                </div>
                @endforeach

                <div class="order-item total-row">
                    <p>Subtotal: ৳{{ number_format($order->subtotal, 2) }}</p>
                    <p>Tax: ৳{{ number_format($order->tax_amount, 2) }}</p>
                    <p>Shipping: ৳{{ number_format($order->shipping_charge, 2) }}</p>
                    <p><strong>Total: ৳{{ number_format($order->total_amount, 2) }}</strong></p>
                </div>
            </div>

            <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>

            @if($order->order_notes)
            <p><strong>Your Notes:</strong> {{ $order->order_notes }}</p>
            @endif

            <p>You can track your order status by visiting your account dashboard or contacting our support team.</p>

            <p>If you have any questions about your order, please don't hesitate to contact our customer support:</p>
            <p>📞 {{ $supportPhone }}<br>
               📧 {{ $supportEmail }}</p>

            <a href="{{ url('/orders/' . $order->id) }}" class="btn">View Order Details</a>

            <p>Best regards,<br>
            The {{ $companyName }} Team</p>
        </div>

        <div class="footer">
            <p>{{ $companyName }}<br>
            © {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
