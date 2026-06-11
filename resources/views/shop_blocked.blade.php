<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deactivated — Professional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
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
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon {
            width: 80px;
            height: 80px;
            background: #e74c3c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 32px;
        }
        h1 {
            color: #2c3e50;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        p {
            color: #5a6c7d;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .contact-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-top: 20px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .contact-item:last-child {
            border-bottom: none;
        }
        .contact-icon {
            width: 40px;
            height: 40px;
            background: #e9ecef;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5a6c7d;
            font-size: 18px;
        }
        .contact-info {
            flex: 1;
        }
        .contact-label {
            font-size: 12px;
            color: #868e96;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .contact-value {
            font-size: 16px;
            font-weight: 500;
            color: #2c3e50;
        }
        .contact-value a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.2s;
        }
        .contact-value a:hover {
            color: #2980b9;
        }
        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            margin-top: 25px;
        }
        .btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <i class="fas fa-user-slash"></i>
        </div>
        <h1>Account Deactivated</h1>
        <p>Your account has been deactivated by the administrator.<br>Please contact support to resolve this issue.</p>

        <div class="contact-box">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-info">
                    <div class="contact-label">Email</div>
                    <div class="contact-value"><a href="mailto:ahsanjuttjamber@gmail.com">ahsanjuttjamber@gmail.com</a></div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="contact-info">
                    <div class="contact-label">WhatsApp</div>
                    <div class="contact-value"><a href="https://wa.me/923193841820">03193841820</a></div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="contact-info">
                    <div class="contact-label">Phone</div>
                    <div class="contact-value">03193841820</div>
                </div>
            </div>
        </div>

        <a href="/shop-login" class="btn">Back to Login</a>
    </div>
</body>
</html>
