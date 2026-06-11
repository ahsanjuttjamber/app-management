<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installment Lock System | Remote Phone Lock Solution</title>
    <meta name="description" content="Complete installment management system for shop owners. Remote phone lock, location tracking, installment tracking. Trusted by 500+ shops.">
    <meta name="keywords" content="installment lock, phone lock, remote lock, shop management, installment tracking">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1e293b;
            line-height: 1.5;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 16px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .logo {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .logo i {
            background: none;
            -webkit-background-clip: unset;
            background-clip: unset;
            color: #4F46E5;
        }
        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            color: #475569;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: #4F46E5;
        }
        .nav-buttons {
            display: flex;
            gap: 12px;
        }
        .btn-outline {
            padding: 8px 20px;
            border: 2px solid #4F46E5;
            background: transparent;
            color: #4F46E5;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-outline:hover {
            background: #4F46E5;
            color: white;
        }
        .btn-primary {
            padding: 8px 20px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(79,70,229,0.4);
        }
        .menu-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }

        /* ========== HERO SECTION ========== */
        .hero {
            padding: 140px 5% 80px;
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
        }
        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
        }
        .hero-text {
            flex: 1;
        }
        .hero-badge {
            background: #e0e7ff;
            color: #4F46E5;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }
        .hero-text h1 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            color: #0f172a;
        }
        .hero-text h1 span {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .hero-text p {
            font-size: 18px;
            color: #475569;
            margin-bottom: 30px;
            max-width: 500px;
        }
        .hero-buttons {
            display: flex;
            gap: 16px;
        }
        .btn-large {
            padding: 14px 32px;
            font-size: 16px;
        }
        .hero-image {
            flex: 1;
            text-align: center;
        }
        .phone-mock {
            background: #1e293b;
            border-radius: 40px;
            padding: 20px 10px;
            width: 280px;
            margin: 0 auto;
            box-shadow: 0 20px 35px -10px rgba(0,0,0,0.2);
        }
        .phone-screen {
            background: #ffffff;
            border-radius: 30px;
            padding: 20px;
            text-align: center;
        }
        .qr-demo {
            background: #f0f2f5;
            padding: 20px;
            border-radius: 16px;
            margin: 10px 0;
        }

        /* ========== FEATURES SECTION ========== */
        .features {
            padding: 80px 5%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-header h2 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 16px;
        }
        .section-header p {
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
            gap: 30px;
        }
        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid #e2e8f0;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -10px rgba(0,0,0,0.1);
            border-color: #4F46E5;
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .feature-icon i {
            font-size: 28px;
            color: white;
        }
        .feature-card h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .feature-card p {
            color: #64748b;
            line-height: 1.6;
        }

        /* ========== HOW IT WORKS ========== */
        .how-it-works {
            background: #f8fafc;
            padding: 80px 5%;
        }
        .steps-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            text-align: center;
        }
        .step {
            position: relative;
        }
        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            font-weight: 700;
            color: white;
        }
        .step h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .step p {
            color: #64748b;
        }

        /* ========== STATS SECTION ========== */
        .stats {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            padding: 60px 5%;
            color: white;
        }
        .stats-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }
        .stat-item h3 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .stat-item p {
            font-size: 16px;
            opacity: 0.9;
        }

        /* ========== PRICING SECTION ========== */
        .pricing {
            padding: 80px 5%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        .pricing-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -10px rgba(0,0,0,0.1);
        }
        .pricing-card.popular {
            border: 2px solid #4F46E5;
            position: relative;
        }
        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #4F46E5;
            color: white;
            padding: 4px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
        .pricing-card h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .price {
            font-size: 48px;
            font-weight: 800;
            color: #4F46E5;
            margin: 20px 0;
        }
        .price span {
            font-size: 16px;
            font-weight: 400;
            color: #64748b;
        }
        .pricing-card ul {
            list-style: none;
            margin: 20px 0;
            text-align: left;
        }
        .pricing-card li {
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .pricing-card li i {
            color: #4F46E5;
        }
        .pricing-btn {
            display: block;
            padding: 12px;
            background: #f1f5f9;
            color: #4F46E5;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s;
        }
        .pricing-btn:hover {
            background: #4F46E5;
            color: white;
        }
        .pricing-btn.pro {
            background: #4F46E5;
            color: white;
        }

        /* ========== TESTIMONIALS ========== */
        .testimonials {
            background: #f8fafc;
            padding: 80px 5%;
        }
        .testimonials-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        .testimonial-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .testimonial-text {
            font-size: 16px;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 20px;
            font-style: italic;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .author-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        .author-info h4 {
            font-size: 16px;
            font-weight: 700;
        }
        .author-info p {
            font-size: 12px;
            color: #64748b;
        }

        /* ========== CTA SECTION ========== */
        .cta {
            padding: 80px 5%;
            text-align: center;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
        }
        .cta h2 {
            font-size: 36px;
            margin-bottom: 16px;
        }
        .cta p {
            margin-bottom: 30px;
            opacity: 0.9;
        }
        .cta .btn-primary {
            background: white;
            color: #4F46E5;
            padding: 14px 32px;
            font-size: 16px;
        }
        .cta .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2);
        }

        /* ========== FOOTER ========== */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 60px 5% 30px;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-logo {
            font-size: 24px;
            font-weight: 800;
            color: white;
            margin-bottom: 16px;
        }
        .footer-logo i {
            color: #4F46E5;
        }
        .footer-about p {
            line-height: 1.6;
        }
        .footer-column h4 {
            color: white;
            margin-bottom: 20px;
            font-size: 18px;
        }
        .footer-column a {
            display: block;
            color: #94a3b8;
            text-decoration: none;
            margin-bottom: 12px;
            transition: color 0.3s;
        }
        .footer-column a:hover {
            color: #4F46E5;
        }
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .social-links a:hover {
            background: #4F46E5;
            transform: translateY(-2px);
        }
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #1e293b;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 968px) {
            .nav-links {
                display: none;
            }
            .menu-btn {
                display: block;
            }
            .hero-content {
                flex-direction: column;
                text-align: center;
            }
            .hero-text h1 {
                font-size: 36px;
            }
            .hero-buttons {
                justify-content: center;
            }
            .steps-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .pricing-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin: 0 auto;
            }
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- ========== NAVBAR ========== -->
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-lock"></i> InstallmentLock
        </div>
        <div class="menu-btn" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="#home">Home</a>
            <a href="#features">Features</a>
            <a href="#how-it-works">How It Works</a>
            <a href="#pricing">Pricing</a>
            <div class="nav-buttons">
                <a href="/shop-login" class="btn-outline">Login</a>
                <a href="/shop-signup" class="btn-primary">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- ========== HERO SECTION ========== -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <span class="hero-badge"><i class="fas fa-shield-alt"></i> Trusted by 500+ Shops</span>
                <h1>Phone Lock in Case of <span>Missed Installment Payment</span></h1>
                <p>Complete installment management system for shop owners. Remote phone lock, real-time location tracking, and automated installment tracking.</p>
                <div class="hero-buttons">
                    <a href="#pricing" class="btn-primary btn-large">Get Started</a>
                    <a href="/shop-login" class="btn-outline btn-large">Shop Login</a>
                </div>
            </div>
            <div class="hero-image">
                <div class="phone-mock">
                    <div class="phone-screen">
                        <i class="fas fa-qrcode" style="font-size: 80px; color: #4F46E5;"></i>
                        <div class="qr-demo">
                            <i class="fas fa-camera"></i> Scan QR Code
                        </div>
                        <div style="font-size: 12px; color: #64748b;">Device ID: INFINIX-12345</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FEATURES SECTION ========== -->
    <section class="features" id="features">
        <div class="section-header">
            <h2>Powerful Features</h2>
            <p>Everything you need to manage your installment business</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-lock"></i></div>
                <h3>Remote Phone Lock</h3>
                <p>Instantly lock customer's phone when installment is missed. Camera and calls will be disabled automatically.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3>Live Location Tracking</h3>
                <p>Track customer's phone location in real-time. Helps recover device in case of theft or fraud.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-calendar-alt"></i></div>
                <h3>Installment Management</h3>
                <p>Track all customer payments, due dates, and history. Know exactly who paid and who didn't.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-store"></i></div>
                <h3>Multi-Shop Support</h3>
                <p>Manage multiple shops from one account. Each shop has its own separate database for data isolation.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-trash-alt"></i></div>
                <h3>Undeletable App</h3>
                <p>Customer cannot uninstall the app. Device Admin permission makes it permanent until full payment.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                <h3>24/7 Customer Support</h3>
                <p>Get help anytime via email or WhatsApp. Our support team is always ready to assist you.</p>
            </div>
        </div>
    </section>

    <!-- ========== HOW IT WORKS ========== -->
    <section class="how-it-works" id="how-it-works">
        <div class="section-header">
            <h2>How It Works</h2>
            <p>Three simple steps to get started</p>
        </div>
        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Customer Downloads App</h3>
                <p>Customer downloads the app on their phone and shows you the QR code.</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Scan QR Code</h3>
                <p>Scan the customer's QR code using your dashboard. Customer is automatically linked.</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Control Phone Remotely</h3>
                <p>Lock/unlock customer's phone anytime, track location, and manage installments.</p>
            </div>
        </div>
    </section>

    <!-- ========== STATS SECTION ========== -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>500+</h3>
                <p>Active Shops</p>
            </div>
            <div class="stat-item">
                <h3>10,000+</h3>
                <p>Devices Protected</p>
            </div>
            <div class="stat-item">
                <h3>99.9%</h3>
                <p>Uptime</p>
            </div>
            <div class="stat-item">
                <h3>24/7</h3>
                <p>Support</p>
            </div>
        </div>
    </section>

    <!-- ========== PRICING SECTION ========== -->
    <section class="pricing" id="pricing">
        <div class="section-header">
            <h2>Simple Pricing</h2>
            <p>Choose the plan that works for your business</p>
        </div>
        <div class="pricing-grid">
            <div class="pricing-card">
                <h3>Free</h3>
                <div class="price">$0<span>/month</span></div>
                <ul>
                    <li><i class="fas fa-check"></i> Basic Features</li>
                    <li><i class="fas fa-check"></i> 1 Shop</li>
                    <li><i class="fas fa-check"></i> 10 Devices</li>
                    <li><i class="fas fa-times" style="color: #cbd5e1;"></i> Priority Support</li>
                </ul>
                <a href="/shop-signup" class="pricing-btn">Get Started</a>
            </div>
            <div class="pricing-card popular">
                <div class="popular-badge">Most Popular</div>
                <h3>Pro</h3>
                <div class="price">$29<span>/month</span></div>
                <ul>
                    <li><i class="fas fa-check"></i> All Features</li>
                    <li><i class="fas fa-check"></i> Unlimited Shops</li>
                    <li><i class="fas fa-check"></i> Unlimited Devices</li>
                    <li><i class="fas fa-check"></i> Priority Support</li>
                </ul>
                <a href="/shop-signup" class="pricing-btn pro">Get Started</a>
            </div>
            <div class="pricing-card">
                <h3>Enterprise</h3>
                <div class="price">Custom</div>
                <ul>
                    <li><i class="fas fa-check"></i> Everything in Pro</li>
                    <li><i class="fas fa-check"></i> Dedicated Support</li>
                    <li><i class="fas fa-check"></i> Custom Features</li>
                    <li><i class="fas fa-check"></i> SLA Agreement</li>
                </ul>
                <a href="#" class="pricing-btn">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- ========== TESTIMONIALS ========== -->
    <section class="testimonials">
        <div class="section-header">
            <h2>What Our Customers Say</h2>
            <p>Trusted by shop owners across the country</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-text">
                    "My business is now completely secure. When a customer misses an installment, I can remotely lock their phone immediately. Fantastic system!"
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">A</div>
                    <div class="author-info">
                        <h4>Ahmed Raza</h4>
                        <p>Mobile Shop Owner, Lahore</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-text">
                    "The location tracking feature saved me when a customer tried to run away. I was able to recover the device easily. Highly recommended!"
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">S</div>
                    <div class="author-info">
                        <h4>Saima Khan</h4>
                        <p>Electronics Shop, Karachi</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-text">
                    "Installment tracking has become so easy. No more missed payments. This is the best system for any shop owner."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">B</div>
                    <div class="author-info">
                        <h4>Bilal Ahmed</h4>
                        <p>Bike Showroom, Islamabad</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CTA SECTION ========== -->
    <section class="cta">
        <h2>Ready to Secure Your Business?</h2>
        <p>Join 500+ shop owners who trust Installment Lock System</p>
        <a href="/shop-signup" class="btn-primary">Get Started Today →</a>
    </section>

    <!-- ========== FOOTER ========== -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-about">
                <div class="footer-logo">
                    <i class="fas fa-lock"></i> InstallmentLock
                </div>
                <p>Complete installment management solution for shop owners. Remote phone lock, location tracking, and more.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Product</h4>
                <a href="#features">Features</a>
                <a href="#pricing">Pricing</a>
                <a href="#">Download App</a>
            </div>
            <div class="footer-column">
                <h4>Company</h4>
                <a href="#">About Us</a>
                <a href="#">Contact</a>
                <a href="#">Blog</a>
            </div>
            <div class="footer-column">
                <h4>Support</h4>
                <a href="#">Help Center</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#"><i class="fas fa-envelope"></i> ahsanjuttjamber@gmail.com</a>
                <a href="#"><i class="fab fa-whatsapp"></i> +92 319 3841820</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Installment Lock System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            var navLinks = document.getElementById('navLinks');
            if (navLinks.style.display === 'flex') {
                navLinks.style.display = 'none';
            } else {
                navLinks.style.display = 'flex';
                navLinks.style.flexDirection = 'column';
                navLinks.style.position = 'absolute';
                navLinks.style.top = '70px';
                navLinks.style.left = '0';
                navLinks.style.right = '0';
                navLinks.style.background = 'white';
                navLinks.style.padding = '20px';
                navLinks.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            }
        }
    </script>
</body>
</html>
