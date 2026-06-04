<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        h1 { margin-bottom: 20px; color: #333; }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            float: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th { background: #4CAF50; color: white; }
        .lock-btn {
            background: #dc3545;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .unlock-btn {
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .status-blocked {
            color: red;
            font-weight: bold;
        }
        .status-active {
            color: green;
            font-weight: bold;
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
        <a href="/admin/logout" class="logout-btn">Logout</a>
        <h1>Admin Dashboard</h1>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Device ID</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                <tr>
                    <td>{{ $device->id }}</td>
                    <td>{{ $device->device_id }}</td>
                    <td>{{ $device->customer_name ?? 'N/A' }}</td>
                    <td>{{ $device->phone_number ?? 'N/A' }}</td>
                    <td class="{{ $device->is_blocked ? 'status-blocked' : 'status-active' }}">
                        {{ $device->is_blocked ? 'BLOCKED' : 'ACTIVE' }}
                    </td>
                    <td>
                        @if($device->is_blocked)
                            <form method="POST" action="/admin/unlock/{{ $device->id }}" style="display:inline">
                                @csrf
                                <button type="submit" class="unlock-btn">Unlock</button>
                            </form>
                        @else
                            <form method="POST" action="/admin/lock/{{ $device->id }}" style="display:inline">
                                @csrf
                                <button type="submit" class="lock-btn">Lock</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
