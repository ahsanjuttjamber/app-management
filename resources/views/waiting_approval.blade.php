<!DOCTYPE html>
<html>
<head>
    <title>Waiting for Approval</title>
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
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        h1 {
            color: #ffc107;
            font-size: 28px;
            margin-bottom: 15px;
        }
        p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .contact-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            margin-top: 20px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .contact-item:last-child {
            border-bottom: none;
        }
        .contact-icon {
            font-size: 24px;
            width: 40px;
            text-align: center;
        }
        .contact-info {
            flex: 1;
        }
        .contact-label {
            font-size: 12px;
            color: #888;
            margin-bottom: 2px;
        }
        .contact-value {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }
        .contact-value a {
            color: #667eea;
            text-decoration: none;
        }
        .btn {
            display: inline-block;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: 500;
        }
        .btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">⏳</div>
        <h1>Waiting for Approval</h1>
        <p>Your account has been registered successfully!<br>Please wait for admin approval before you can login.</p>
        <p>You will receive an email once your account is approved.</p>

        <div class="contact-box">
            <div class="contact-item">
                <div class="contact-icon">📧</div>
                <div class="contact-info">
                    <div class="contact-label">Contact Admin</div>
                    <div class="contact-value"><a href="mailto:ahsanjuttjamber@gmail.com">ahsanjuttjamber@gmail.com</a></div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">💬</div>
                <div class="contact-info">
                    <div class="contact-label">WhatsApp</div>
                    <div class="contact-value"><a href="https://wa.me/923193841820">03193841820</a></div>
                </div>
            </div>
        </div>

        <a href="/shop-login" class="btn">Back to Login</a>
    </div>
</body>
</html>
