<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: auto;
        }
        .header {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        h1 { color: #333; font-size: 24px; margin: 0; }
        .pending-link {
            background: #ffc107;
            color: #333;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .shop-name {
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            background: #e8f5e9;
            color: #4CAF50;
        }
        .card-info p {
            margin: 8px 0;
            color: #555;
            font-size: 14px;
        }
        .card-info strong {
            color: #333;
            width: 100px;
            display: inline-block;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <h1>🏪 Admin Dashboard</h1>
                <a href="/admin/pending-requests" class="pending-link">📋 Pending Requests</a>
            </div>
            <a href="/admin/logout" class="logout-btn">Logout</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="cards-grid">
            @foreach($shops as $shop)
            <div class="card">
                <div class="card-header">
                    <span class="shop-name">🏪 {{ $shop->shop_name }}</span>
                    <span class="status-badge">✓ Approved</span>
                </div>
                <div class="card-info">
                    <p><strong>Owner:</strong> {{ $shop->name }}</p>
                    <p><strong>Email:</strong> {{ $shop->email }}</p>
                    <p><strong>Phone:</strong> {{ $shop->phone }}</p>
                    <p><strong>Address:</strong> {{ $shop->address }}</p>
                </div>
            </div>
            @endforeach
        </div>

        @if(count($shops) == 0)
            <p style="text-align: center; margin-top: 50px;">No approved shops yet.</p>
        @endif
    </div>
</body>
</html>
