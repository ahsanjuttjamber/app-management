<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Shop Registration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 16px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .email-display {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #667eea;
            font-weight: 500;
            word-break: break-all;
        }

        input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 20px;
            text-align: center;
            letter-spacing: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        button {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            text-align: left;
            font-size: 14px;
        }

        .success {
            background: #e8f5e9;
            color: #4caf50;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #4caf50;
            text-align: left;
            font-size: 14px;
        }

        .resend {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 14px;
        }

        .resend a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .resend a:hover {
            text-decoration: underline;
        }

        .timer {
            color: #764ba2;
            font-weight: bold;
            margin-top: 15px;
            font-size: 13px;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            color: #999;
            text-decoration: none;
            font-size: 13px;
        }

        .back-link:hover {
            color: #667eea;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }

            h2 {
                font-size: 24px;
            }

            input {
                font-size: 18px;
                letter-spacing: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">📧</div>
        <h2>Verify Your Email</h2>
        <p>Please enter the 6-digit verification code sent to your email address</p>

        @if(isset($email) || session('otp_email'))
            <div class="email-display">
                📭 {{ $email ?? session('otp_email') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="error">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        @if(session('success'))
            <div class="success">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify.form') }}" id="otpForm">
            @csrf
            <input type="hidden" name="email" value="{{ $email ?? session('otp_email') }}">
            <input
                type="text"
                name="otp"
                placeholder="Enter 6-digit OTP"
                maxlength="6"
                pattern="[0-9]{6}"
                title="Please enter 6 digits"
                autofocus
                required
                id="otpInput"
            >
            <button type="submit" id="verifyBtn">Verify OTP</button>
        </form>

        <div class="resend">
            Didn't receive the verification code?
            <a href="#" onclick="resendOtp(event)">Resend OTP</a>
        </div>

        <div class="timer" id="timer"></div>

        <a href="/shop-signup" class="back-link">← Back to Signup</a>
    </div>

    <script>
        let countdownTimer = null;
        let canResend = true;

        // Auto format OTP input
        const otpInput = document.getElementById('otpInput');
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });

        // Start countdown timer (60 seconds)
        function startTimer() {
            let timeLeft = 60;
            const timerElement = document.getElementById('timer');
            const resendLink = document.querySelector('.resend a');

            if (countdownTimer) clearInterval(countdownTimer);
            canResend = false;
            resendLink.style.pointerEvents = 'none';
            resendLink.style.opacity = '0.5';

            countdownTimer = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    timerElement.textContent = '';
                    canResend = true;
                    resendLink.style.pointerEvents = 'auto';
                    resendLink.style.opacity = '1';
                } else {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerElement.textContent = `Resend available in ${minutes}:${seconds.toString().padStart(2, '0')}`;
                    timeLeft--;
                }
            }, 1000);
        }

        // Resend OTP function
        async function resendOtp(event) {
            event.preventDefault();

            if (!canResend) {
                alert('Please wait before requesting another OTP');
                return;
            }

            const email = document.querySelector('input[name="email"]').value;

            if (!email) {
                alert('Email not found. Please go back to signup.');
                return;
            }

            const resendBtn = event.target;
            const originalText = resendBtn.textContent;
            resendBtn.textContent = 'Sending...';
            resendBtn.style.pointerEvents = 'none';

            try {
                const response = await fetch('/resend-otp', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();

                if (data.success) {
                    alert('New OTP has been sent to your email address');
                    startTimer();
                } else {
                    alert(data.message || 'Failed to resend OTP. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Network error. Please check your connection and try again.');
            } finally {
                resendBtn.textContent = originalText;
                resendBtn.style.pointerEvents = 'auto';
            }
        }

        // Start timer on page load
        startTimer();

        // Prevent form double submission
        let isSubmitting = false;
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            const otp = document.getElementById('otpInput').value;
            if (otp.length !== 6) {
                e.preventDefault();
                alert('Please enter a valid 6-digit OTP');
                return;
            }

            isSubmitting = true;
            const verifyBtn = document.getElementById('verifyBtn');
            verifyBtn.textContent = 'Verifying...';
            verifyBtn.disabled = true;
        });
    </script>
</body>
</html>
