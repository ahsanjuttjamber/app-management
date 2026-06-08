<!DOCTYPE html>
<html>
<head>
    <title>Shop Dashboard</title>
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
        h1 { color: #333; font-size: 24px; }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-btn {
            background: #4CAF50;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
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
        .device-id {
            font-size: 12px;
            color: #666;
            background: #f5f5f5;
            padding: 4px 8px;
            border-radius: 5px;
            font-family: monospace;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-blocked {
            background: #ffebee;
            color: #dc3545;
        }
        .status-active {
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
        .card-buttons {
            display: flex;
            gap: 8px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            flex-wrap: wrap;
        }
        .lock-btn {
            background: #dc3545;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            flex: 1;
        }
        .unlock-btn {
            background: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            flex: 1;
        }
        .delete-btn {
            background: #ffc107;
            color: #333;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            flex: 1;
        }
        .location-btn {
            background: #17a2b8;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            flex: 1;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        .modal-content {
            background: white;
            width: 500px;
            margin: 80px auto;
            padding: 25px;
            border-radius: 12px;
        }
        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .save-btn {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-btn {
            background: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .map-container { height: 250px; background: #f0f0f0; margin: 15px 0; border-radius: 8px; }
        iframe { width: 100%; height: 100%; border: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏪 {{ $shop->shop_name }} - Dashboard</h1>
            <a href="/shop-logout" class="logout-btn">Logout</a>
        </div>

        <button class="add-btn" onclick="openAddModal()">➕ Add New Device</button>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="cards-grid">
            @foreach($devices as $device)
            <div class="card">
                <div class="card-header">
                    <span class="device-id">📱 {{ $device->device_id }}</span>
                    <span class="status-badge {{ $device->is_blocked ? 'status-blocked' : 'status-active' }}">
                        {{ $device->is_blocked ? 'BLOCKED' : 'ACTIVE' }}
                    </span>
                </div>
                <div class="card-info">
                    <p><strong>Customer:</strong> {{ $device->customer_name ?? 'N/A' }}</p>
                    <p><strong>Mobile:</strong> {{ $device->mobile_name ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $device->phone_number ?? 'N/A' }}</p>
                </div>
                <div class="card-buttons">
                    @if($device->is_blocked)
                        <form method="POST" action="/shop/unlock/{{ $device->id }}" style="flex:1">
                            @csrf
                            <button type="submit" class="unlock-btn">🔓 Unlock</button>
                        </form>
                    @else
                        <form method="POST" action="/shop/lock/{{ $device->id }}" style="flex:1">
                            @csrf
                            <button type="submit" class="lock-btn">🔒 Lock</button>
                        </form>
                    @endif
                    <button type="button" class="location-btn" onclick="showLocation('{{ $device->device_id }}')">📍 Location</button>
                    <form method="POST" action="/shop/delete-device/{{ $device->id }}" style="flex:1" onsubmit="return confirm('Delete this device?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">🗑️ Delete</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        @if(count($devices) == 0)
            <p style="text-align: center; margin-top: 50px;">No devices added yet. Click "Add New Device" to add.</p>
        @endif
    </div>

    <!-- Add Device Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h3>➕ Add New Device</h3>
            <form method="POST" action="/shop/add-device">
                @csrf
                <input type="text" name="customer_name" placeholder="Customer Name" required>
                <input type="text" name="mobile_name" placeholder="Mobile Name" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <input type="text" name="device_id" placeholder="Phone Device ID" required>
                <button type="submit" class="save-btn">Save</button>
                <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Location Modal -->
    <div id="locationModal" class="modal">
        <div class="modal-content" style="width: 600px;">
            <h3>📍 Device Location</h3>
            <div id="locationMap" class="map-container">Loading...</div>
            <div id="locationDetails" style="margin: 10px 0;"></div>
            <button type="button" class="cancel-btn" onclick="closeLocationModal()">Close</button>
        </div>
    </div>

    <script>
        function openAddModal() { document.getElementById('addModal').style.display = 'block'; }
        function closeAddModal() { document.getElementById('addModal').style.display = 'none'; }

        function showLocation(deviceId) {
            document.getElementById('locationModal').style.display = 'block';
            fetch(`/shop/device-location/${deviceId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.latitude && data.longitude) {
                        document.getElementById('locationDetails').innerHTML = `<p>📍 Lat: ${data.latitude} | Lon: ${data.longitude}</p>`;
                        document.getElementById('locationMap').innerHTML = `<iframe src="https://maps.google.com/maps?q=${data.latitude},${data.longitude}&z=15&output=embed"></iframe>`;
                    } else {
                        document.getElementById('locationDetails').innerHTML = '<p>❌ No location data</p>';
                    }
                });
        }
        function closeLocationModal() { document.getElementById('locationModal').style.display = 'none'; }

        window.onclick = function(event) {
            if (event.target == document.getElementById('addModal')) closeAddModal();
            if (event.target == document.getElementById('locationModal')) closeLocationModal();
        }
    </script>
</body>
</html>
