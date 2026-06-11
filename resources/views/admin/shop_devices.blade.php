<!DOCTYPE html>
<html>
<head>
    <title>{{ $shop->shop_name }} - Devices</title>
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
        .back-btn {
            background: #6c757d;
            color: white;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover { background: #5a6268; }
        .card-table {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        .status-active { color: #28a745; font-weight: bold; }
        .status-blocked { color: #dc3545; font-weight: bold; }
        .action-btn {
            padding: 4px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 2px;
        }
        .lock-btn { background: #dc3545; color: white; }
        .unlock-btn { background: #28a745; color: white; }
        .location-btn { background: #17a2b8; color: white; }
        .delete-btn { background: #ffc107; color: #333; }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
        }
        .modal-content {
            background: white;
            width: 600px;
            margin: 100px auto;
            padding: 25px;
            border-radius: 12px;
        }
        .map-container { height: 250px; background: #f0f0f0; margin: 15px 0; border-radius: 8px; }
        iframe { width: 100%; height: 100%; border: none; }
        .cancel-btn {
            background: #6c757d;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏪 {{ $shop->shop_name }} - Devices</h1>
            <a href="/admin/dashboard" class="back-btn">← Back to Dashboard</a>
        </div>

        <div class="card-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Device ID</th>
                        <th>Customer Name</th>
                        <th>Mobile Name</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devices as $device)
                    <tr>
                        <td>{{ $device->id }}</td>
                        <td>{{ $device->device_id }}</td>
                        <td>{{ $device->customer_name ?? 'N/A' }}</td>
                        <td>{{ $device->mobile_name ?? 'N/A' }}</td>
                        <td>{{ $device->phone_number ?? 'N/A' }}</td>
                        <td class="{{ $device->is_blocked ? 'status-blocked' : 'status-active' }}">
                            {{ $device->is_blocked ? 'BLOCKED' : 'ACTIVE' }}
                        </td>
                        <td>
                            @if($device->is_blocked)
                                <form method="POST" action="/admin/unlock/{{ $device->id }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="action-btn unlock-btn">🔓 Unlock</button>
                                </form>
                            @else
                                <form method="POST" action="/admin/lock/{{ $device->id }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="action-btn lock-btn">🔒 Lock</button>
                                </form>
                            @endif
                            <button type="button" class="action-btn location-btn" onclick="showLocation('{{ $device->device_id }}')">📍 Location</button>
                            <form method="POST" action="/admin/delete-device/{{ $device->id }}" style="display:inline" onsubmit="return confirm('Delete this device?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn">🗑️ Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(count($devices) == 0)
                <p style="text-align: center; margin-top: 50px;">No devices found for this shop.</p>
            @endif
        </div>
    </div>

    <!-- Location Modal -->
    <div id="locationModal" class="modal">
        <div class="modal-content">
            <h3>📍 Device Location</h3>
            <div id="locationMap" class="map-container">Loading...</div>
            <div id="locationDetails" style="margin: 10px 0;"></div>
            <button type="button" class="cancel-btn" onclick="closeLocationModal()">Close</button>
        </div>
    </div>

    <script>
        function showLocation(deviceId) {
            document.getElementById('locationModal').style.display = 'block';
            fetch(`/admin/device-location/${deviceId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.latitude && data.longitude) {
                        document.getElementById('locationDetails').innerHTML = `<p>📍 Lat: ${data.latitude} | Lon: ${data.longitude}</p>`;
                        document.getElementById('locationMap').innerHTML = `<iframe src="https://maps.google.com/maps?q=${data.latitude},${data.longitude}&z=15&output=embed"></iframe>`;
                    } else {
                        document.getElementById('locationDetails').innerHTML = '<p>❌ No location data available</p>';
                    }
                });
        }
        function closeLocationModal() {
            document.getElementById('locationModal').style.display = 'none';
        }
        window.onclick = function(event) {
            var modal = document.getElementById('locationModal');
            if (event.target == modal) closeLocationModal();
        }
    </script>
</body>
</html>
