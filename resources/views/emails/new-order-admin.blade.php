<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Order Received - {{ $companyName }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 10px 10px; }
        .order-info { background: white; border-radius: 8px; padding: 15px; margin: 15px 0; }
        .btn { display: inline-block; background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .urgent { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🚨 New Order Received</h2>
        </div>

        <div class="content">
            <p><strong>New order has been placed and requires processing.</strong></p>

            <div class="order-info">
                <h3>Order Details</h3>
                <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
                <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Total Amount:</strong> ৳{{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>

                <h4>Shipping Address:</h4>
                <p>{{ $order->shipping_address }}</p>

                <h4>Order Items ({{ count($orderItems) }}):</h4>
                <ul>
                    @foreach($orderItems as $item)
                    <li>{{ $item->product_name }} - {{ $item->quantity }} × ৳{{ number_format($item->unit_price, 2) }}</li>
                    @endforeach
                </ul>
            </div>

            <p class="urgent">⚠️ Please process this order promptly.</p>

            <a href="{{ url('/admin/orders/' . $order->id) }}" class="btn">View Order in Dashboard</a>

            <p>This is an automated notification from {{ $companyName }} Order System.</p>
        </div>
    </div>
</body>
</html>
