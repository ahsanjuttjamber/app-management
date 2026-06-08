<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Installment Lock App - Download</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #667eea;
        }
        .nav-buttons {
            display: flex;
            gap: 10px;
        }
        .nav-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 500;
            transition: transform 0.3s;
        }
        .nav-btn:hover {
            transform: scale(1.05);
        }

        .card {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
            margin-top: 80px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
            text-align: center;
        }

        .icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .features {
            text-align: left;
            margin: 30px 0;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 20px;
        }

        .features h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 18px;
        }

        .features ul {
            list-style: none;
            padding: 0;
        }

        .features li {
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #555;
        }

        .features li::before {
            content: "✓";
            color: #4CAF50;
            font-weight: bold;
            font-size: 18px;
        }

        .download-btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 50px;
            margin: 20px 0 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.4);
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(102, 126, 234, 0.5);
        }

        .version {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }

        .footer {
            background: #f1f3f4;
            padding: 15px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }

        .badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">🔒 Installment Lock</div>
        <div class="nav-buttons">
            <a href="/shop-login" class="nav-btn">Login</a>
            <a href="/shop-signup" class="nav-btn">Signup</a>
        </div>
    </nav>

    <div class="card">
        <div class="header">
            <div class="icon">🔒</div>
            <h1>Installment Lock App</h1>
            <p>Secure • Reliable • Fast</p>
            <div class="badge">Version 2.0.0</div>
        </div>
        <div class="content">
            <h3 style="margin-bottom: 10px;">📱 Installment Miss Hone Par Phone Lock</h3>
            <p style="color: #666; font-size: 14px;">100% secure and trusted app</p>

            <a href="https://comfortable-unity-production-7a5f.up.railway.app/app-release.apk" class="download-btn">
                ⬇️ DOWNLOAD APK
            </a>

            <div class="features">
                <h3>✨ Features:</h3>
                <ul>
                    <li>Remote Phone Lock</li>
                    <li>Camera Disable</li>
                    <li>Live Location Tracking</li>
                    <li>Cannot be Uninstalled</li>
                    <li>24/7 Support</li>
                </ul>
            </div>

            <div class="version">
                ⚠️ Only for installment customers
            </div>
        </div>
        <div class="footer">
            © 2026 Installment Lock System | All Rights Reserved
        </div>
    </div>
</body>
</html>
