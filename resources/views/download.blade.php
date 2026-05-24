<!DOCTYPE html>
<html>
<head>
    <title>Download App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: #4CAF50;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
        }
        .download-btn {
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            font-size: 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Installment Lock App</h1>
        <a href="{{ asset('app-release.apk') }}" class="download-btn">
            ⬇️ Download APK
        </a>
        <p>Installment miss hone par phone lock</p>
    </div>
</body>
</html>