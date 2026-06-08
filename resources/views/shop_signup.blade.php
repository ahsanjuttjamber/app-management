<!DOCTYPE html>
<html>
<head>
    <title>Shop Owner Signup</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            width: 100%;
            background: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover { background: #45a049; }
        .login-link { text-align: center; margin-top: 20px; }
        .login-link a { color: #667eea; text-decoration: none; }
        .error { color: red; margin-bottom: 15px; text-align: center; }
        .success { color: green; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📝 Shop Owner Registration</h2>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/shop-register">
            @csrf
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="shop_name" placeholder="Shop Name" required>
            <input type="text" name="address" placeholder="Shop Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="/shop-login">Login here</a>
        </div>
    </div>
</body>
</html>
