<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; }
        .navbar {
            background: white; padding: 12px 30px; display: flex;
            justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: fixed;
            top: 0; left: 0; right: 0; z-index: 1000;
        }
        .logo { font-size: 20px; font-weight: bold; color: #4CAF50; }
        .nav-center { font-size: 18px; font-weight: 500; color: #333; }
        .user-menu { display: flex; align-items: center; gap: 15px; position: relative; }
        .user-icon {
            width: 40px; height: 40px; background: #4CAF50; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: bold; cursor: pointer;
        }
        .user-name { cursor: pointer; color: #333; }
        .dropdown {
            position: absolute; top: 50px; right: 0; background: white;
            border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            width: 150px; display: none; z-index: 1001;
        }
        .dropdown a { display: block; padding: 10px 15px; text-decoration: none;
            color: #333; border-bottom: 1px solid #eee; }
        .dropdown a:hover { background: #f5f5f5; }
        .dropdown .logout { color: #dc3545; }
        .main-container { display: flex; margin-top: 64px; min-height: calc(100vh - 64px); }
        .sidebar {
            width: 220px; background: white; box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            padding: 20px 0;
        }
        .sidebar-btn {
            display: block; width: 100%; padding: 12px 20px; text-align: left;
            background: none; border: none; cursor: pointer; font-size: 15px;
            color: #555; transition: all 0.3s;
        }
        .sidebar-btn:hover { background: #f0f2f5; color: #4CAF50; }
        .sidebar-btn.active { background: #e8f5e9; color: #4CAF50; border-left: 3px solid #4CAF50; }
        .content { flex: 1; padding: 20px; }
        .card-table {
            background: white; border-radius: 12px; padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; color: #333; }
        .see-more-btn {
            background: #4CAF50; color: white; border: none;
            padding: 5px 12px; border-radius: 5px; cursor: pointer;
        }
        .see-more-btn:hover { background: #45a049; }
        .show-devices-btn {
            background: #17a2b8; color: white; text-decoration: none;
            padding: 5px 12px; border-radius: 5px; margin-left: 5px;
            display: inline-block; font-size: 12px;
        }
        .show-devices-btn:hover { background: #138496; }
        .status-active { color: #28a745; font-weight: bold; }
        .status-inactive { color: #dc3545; font-weight: bold; }
        .modal {
            display: none; position: fixed; top: 0; left: 0;
            width: 100%; height: 100%; background: rgba(0,0,0,0.5);
            z-index: 2000;
        }
        .modal-content {
            background: white; width: 400px; margin: 100px auto;
            padding: 25px; border-radius: 12px; text-align: center;
        }
        .modal-buttons { display: flex; gap: 10px; margin-top: 20px; justify-content: center; }
        .modal-btn { padding: 8px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .modal-active { background: #28a745; color: white; }
        .modal-inactive { background: #ffc107; color: #333; }
        .modal-delete { background: #dc3545; color: white; }
        .modal-close { background: #6c757d; color: white; }

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
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
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
        <div class="logo">🏪 Admin Dashboard</div>
        <div class="nav-center">Admin Control All User</div>
        <div class="user-menu">
            <span class="user-name">Ahsan</span>
            <div class="user-icon" onclick="toggleDropdown()">A</div>
            <div id="dropdown" class="dropdown">
                <a href="/admin/logout" class="logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="sidebar">
            <button class="sidebar-btn" id="btnAll" onclick="filterShops('all', this)">🏪 All Shops</button>
            <button class="sidebar-btn" id="btnActive" onclick="filterShops('active', this)">🟢 Active Shops</button>
            <button class="sidebar-btn" id="btnInactive" onclick="filterShops('inactive', this)">🔴 Inactive Shops</button>
            <button class="sidebar-btn" id="btnPending" onclick="showPendingRequests(this)">⏳ Pending Requests</button>
        </div>

        <div class="content">
            <div class="card-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th><th>Owner Name</th><th>Email</th>
                            <th>Phone</th><th>Address</th><th>Shop Name</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach($shops as $shop)
                        <tr data-status="{{ $shop->is_active ? 'active' : 'inactive' }}">
                            <td>{{ $shop->id }}</td>
                            <td>{{ $shop->name }}</td>
                            <td>{{ $shop->email }}</td>
                            <td>{{ $shop->phone }}</td>
                            <td>{{ $shop->address }}</td>
                            <td>{{ $shop->shop_name }}</td>
                            <td>
                                <button class="see-more-btn" onclick="openModal({{ $shop->id }}, '{{ addslashes($shop->shop_name) }}', {{ $shop->is_active ? 'true' : 'false' }})">See More</button>
                                <a href="/admin/shop-devices/{{ $shop->id }}" class="show-devices-btn" onclick="showButtonLoader(this)">📱 Show Devices</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(count($shops) == 0)
                    <p style="text-align: center; margin-top: 50px;">No shops found.</p>
                @endif
            </div>
        </div>
    </div>

    <div id="shopModal" class="modal">
        <div class="modal-content">
            <h3 id="modalShopName">Shop Name</h3>
            <p id="modalStatus" style="margin: 15px 0;"></p>
            <div class="modal-buttons">
                <button class="modal-btn modal-active" onclick="activateCurrentShop(this)">🟢 Activate</button>
                <button class="modal-btn modal-inactive" onclick="deactivateCurrentShop(this)">🔴 Deactivate</button>
                <button class="modal-btn modal-delete" onclick="deleteCurrentShop(this)">🗑️ Delete</button>
            </div>
            <div class="modal-buttons">
                <button class="modal-btn modal-close" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        let currentShopId = null;

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

        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        window.onclick = function(event) {
            var dropdown = document.getElementById('dropdown');
            if (dropdown && !event.target.matches('.user-icon') && !event.target.matches('.user-name')) {
                dropdown.style.display = 'none';
            }
            var modal = document.getElementById('shopModal');
            if (event.target == modal) closeModal();
        }

        function filterShops(type, btnElement) {
            showButtonLoader(btnElement);
            var rows = document.querySelectorAll('#tableBody tr');
            var buttons = document.querySelectorAll('.sidebar-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            if (btnElement) btnElement.classList.add('active');
            rows.forEach(row => {
                var status = row.getAttribute('data-status');
                if (type === 'all') row.style.display = '';
                else if (type === 'active') row.style.display = status === 'active' ? '' : 'none';
                else if (type === 'inactive') row.style.display = status === 'inactive' ? '' : 'none';
            });
            setTimeout(() => hideButtonLoader(btnElement), 200);
        }

        function showPendingRequests(btn) {
            showButtonLoader(btn);
            window.location.href = '/admin/pending-requests';
        }

        function openModal(id, name, isActive) {
            currentShopId = id;
            document.getElementById('modalShopName').innerHTML = '🏪 ' + name;
            document.getElementById('modalStatus').innerHTML = 'Current Status: ' + (isActive ? '<span class="status-active">ACTIVE</span>' : '<span class="status-inactive">INACTIVE</span>');
            document.getElementById('shopModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('shopModal').style.display = 'none';
            currentShopId = null;
        }

        function activateCurrentShop(btn) {
            if (currentShopId) {
                showButtonLoader(btn);
                fetch(`/admin/toggle-shop/${currentShopId}`, {
                    method: 'PUT',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json' }
                }).then(() => location.reload());
            }
        }

        function deactivateCurrentShop(btn) {
            if (currentShopId) {
                showButtonLoader(btn);
                fetch(`/admin/toggle-shop/${currentShopId}`, {
                    method: 'PUT',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json' }
                }).then(() => location.reload());
            }
        }

        function deleteCurrentShop(btn) {
            if (currentShopId && confirm('Delete this shop permanently? All devices will also be deleted.')) {
                showButtonLoader(btn);
                fetch(`/admin/delete-shop/${currentShopId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json' }
                }).then(() => location.reload());
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var allBtn = document.getElementById('btnAll');
            if (allBtn) allBtn.classList.add('active');
            filterShops('all', allBtn);
        });
    </script>
</body>
</html>
