<!DOCTYPE html>
<html>
<head>
    <title>Pending Requests</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        h1 { margin-bottom: 20px; }
        .card { background: #f9f9f9; padding: 15px; margin: 10px 0; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; }
        .accept { background: green; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .reject { background: red; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="/admin/dashboard">Dashboard</a>
            <a href="/admin/pending-requests">Pending Requests</a>
            <a href="/admin/logout">Logout</a>
        </div>
        <h1>📋 Pending Shop Requests</h1>

        @foreach($pendingShops as $shop)
        <div class="card">
            <div>
                <strong>{{ $shop->shop_name }}</strong><br>
                Name: {{ $shop->name }}<br>
                Email: {{ $shop->email }}<br>
                Phone: {{ $shop->phone }}<br>
                Address: {{ $shop->address }}
            </div>
            <div>
                <form method="POST" action="/admin/approve-shop/{{ $shop->id }}" style="display:inline">
                    @csrf
                    <button type="submit" class="accept">✓ Accept</button>
                </form>
                <form method="POST" action="/admin/reject-shop/{{ $shop->id }}" style="display:inline" onsubmit="return confirm('Reject this shop?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="reject">✗ Reject</button>
                </form>
            </div>
        </div>
        @endforeach

        @if(count($pendingShops) == 0)
            <p>No pending requests.</p>
        @endif
    </div>
</body>
</html>
