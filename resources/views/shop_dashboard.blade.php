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
        }

        /* ========== NAVBAR STYLES ========== */
        .navbar {
            background: white;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 6px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover { background: #c82333; }

        /* ========== MAIN CONTAINER ========== */
        .main-container {
            display: flex;
            margin-top: 64px;
            min-height: calc(100vh - 64px);
        }

        /* ========== SIDEBAR STYLES ========== */
        .sidebar {
            width: 220px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            padding: 20px 0;
        }
        .sidebar-btn {
            display: block;
            width: 100%;
            padding: 12px 20px;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
            color: #555;
            transition: all 0.3s;
        }
        .sidebar-btn:hover {
            background: #f0f2f5;
            color: #4CAF50;
        }
        .sidebar-btn.active {
            background: #e8f5e9;
            color: #4CAF50;
            border-left: 3px solid #4CAF50;
        }

        /* ========== CONTENT STYLES ========== */
        .content {
            flex: 1;
            padding: 20px;
        }
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
        .status-active {
            color: #28a745;
            font-weight: bold;
        }
        .status-blocked {
            color: #dc3545;
            font-weight: bold;
        }
        .action-btn {
            padding: 5px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 2px;
            font-size: 13px;
        }
        .lock-btn { background: #dc3545; color: white; }
        .unlock-btn { background: #28a745; color: white; }
        .location-btn { background: #17a2b8; color: white; }
        .delete-btn { background: #ffc107; color: #333; }

        /* ========== MODAL STYLES ========== */
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
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* ========== BUTTON LOADER (Button ke andar) ========== */
        .btn-loading {
            opacity: 0.7;
            pointer-events: none;
            position: relative;
        }
        .btn-loading .btn-text {
            visibility: hidden;
        }
        .btn-loading::after {
            content: "";
            position: absolute;
            width: 14px;
            height: 14px;
            top: 50%;
            left: 50%;
            margin-left: -7px;
            margin-top: -7px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">🏪 {{ $shop->shop_name }} - Dashboard</div>
        <div class="user-menu">
            <a href="/shop-logout" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="main-container">
        <div class="sidebar">
            <button class="sidebar-btn active" id="btnAll" onclick="filterDevices('all', this)">📱 All Devices</button>
            <button class="sidebar-btn" id="btnActive" onclick="filterDevices('active', this)">🟢 Active Devices</button>
            <button class="sidebar-btn" id="btnBlocked" onclick="filterDevices('blocked', this)">🔴 Blocked Devices</button>
            <button class="sidebar-btn" id="btnAdd" onclick="openAddModal()">➕ Add New Device</button>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            <div class="card-table">
                <table id="devicesTable">
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
                    <tbody id="tableBody">
                        @foreach($devices as $device)
                        <tr data-status="{{ $device->is_blocked ? 'blocked' : 'active' }}">
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
                                    <form method="POST" action="/shop/unlock/{{ $device->id }}" style="display:inline" onsubmit="showButtonLoader(this.querySelector('button'));">
                                        @csrf
                                        <button type="submit" class="action-btn unlock-btn">🔓 Unlock</button>
                                    </form>
                                @else
                                    <form method="POST" action="/shop/lock/{{ $device->id }}" style="display:inline" onsubmit="showButtonLoader(this.querySelector('button'));">
                                        @csrf
                                        <button type="submit" class="action-btn lock-btn">🔒 Lock</button>
                                    </form>
                                @endif
                                <button type="button" class="action-btn location-btn" onclick="showLocation(this, '{{ $device->device_id }}')">📍 Location</button>
                                <form method="POST" action="/shop/delete-device/{{ $device->id }}" style="display:inline" onsubmit="showButtonLoader(this.querySelector('button')); return confirm('Delete this device?')">
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
                    <p style="text-align: center; margin-top: 50px;">No devices added yet. Click "Add New Device" to add.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Device Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content" style="width: 450px;">
            <h3>➕ Add New Device</h3>
            <form method="POST" action="/shop/add-device" onsubmit="showButtonLoader(this.querySelector('button[type=submit]'));">
                @csrf
                <input type="text" name="customer_name" placeholder="Customer Name" required style="width:100%; padding:10px; margin:8px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="text" name="mobile_name" placeholder="Mobile Name" required style="width:100%; padding:10px; margin:8px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="text" name="phone_number" placeholder="Phone Number" required style="width:100%; padding:10px; margin:8px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="text" name="device_id" placeholder="Phone Device ID" required style="width:100%; padding:10px; margin:8px 0; border:1px solid #ddd; border-radius:5px;">
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <button type="submit" class="action-btn" style="background:#4CAF50; color:white; padding:10px 20px; margin-top:10px; width:100%;">Save</button>
                <button type="button" class="cancel-btn" onclick="closeAddModal()" style="margin-top:10px; width:100%;">Cancel</button>
            </form>
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
        // ========== BUTTON LOADER FUNCTIONS ==========
        function showButtonLoader(btn) {
            if (!btn) return;
            var originalText = btn.innerHTML;
            btn.setAttribute('data-original-text', originalText);
            btn.classList.add('btn-loading');
            btn.innerHTML = '<span class="btn-text" style="visibility: hidden;">' + originalText + '</span>';
            btn.disabled = true;
        }

        function hideButtonLoader(btn) {
            if (!btn) return;
            var originalText = btn.getAttribute('data-original-text');
            btn.classList.remove('btn-loading');
            if (originalText) btn.innerHTML = originalText;
            btn.disabled = false;
        }

        // ========== FILTER DEVICES ==========
        function filterDevices(type, btnElement) {
            showButtonLoader(btnElement);
            var rows = document.querySelectorAll('#tableBody tr');
            var buttons = document.querySelectorAll('.sidebar-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            if (btnElement) btnElement.classList.add('active');

            rows.forEach(row => {
                var status = row.getAttribute('data-status');
                if (type === 'all') row.style.display = '';
                else if (type === 'active') row.style.display = status === 'active' ? '' : 'none';
                else if (type === 'blocked') row.style.display = status === 'blocked' ? '' : 'none';
            });
            setTimeout(() => hideButtonLoader(btnElement), 200);
        }

        // ========== MODAL FUNCTIONS ==========
        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
        }
        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function showLocation(btn, deviceId) {
            showButtonLoader(btn);
            document.getElementById('locationModal').style.display = 'block';
            fetch(`/shop/device-location/${deviceId}`)
                .then(res => res.json())
                .then(data => {
                    hideButtonLoader(btn);
                    if (data.latitude && data.longitude) {
                        document.getElementById('locationDetails').innerHTML = `<p>📍 Lat: ${data.latitude} | Lon: ${data.longitude}</p>`;
                        document.getElementById('locationMap').innerHTML = `<iframe src="https://maps.google.com/maps?q=${data.latitude},${data.longitude}&z=15&output=embed"></iframe>`;
                    } else {
                        document.getElementById('locationDetails').innerHTML = '<p>❌ No location data available</p>';
                    }
                })
                .catch(() => hideButtonLoader(btn));
        }

        function closeLocationModal() {
            document.getElementById('locationModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('addModal')) closeAddModal();
            if (event.target == document.getElementById('locationModal')) closeLocationModal();
        }

        // Initialize active class on All Devices button
        document.addEventListener('DOMContentLoaded', function() {
            var allBtn = document.getElementById('btnAll');
            if (allBtn) allBtn.classList.add('active');
        });
    </script>
</body>
</html>
