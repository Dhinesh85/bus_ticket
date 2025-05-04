<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Digital Bus Pass System">
        <title>Digital Bus Pass System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="apple-touch-icon" href="{{ asset('logo.jpg') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">

        <style>
            /* Base Styles */
            :root {
                --primary: #2563eb;
                --primary-dark: #1d4ed8;
                --secondary: #0f172a;
                --accent: #f97316;
                --light: #f8fafc;
                --dark: #1e293b;
                --success: #16a34a;
                --danger: #dc2626;
                --warning: #eab308;
                --info: #06b6d4;
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Figtree', sans-serif;
            }
            
            body {
                background-color: #f1f5f9;
                color: var(--dark);
                line-height: 1.6;
            }
            
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 1rem;
            }
            
            /* Header */
            .header {
                background-color: var(--primary);
                color: white;
                padding: 1rem 0;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .logo {
                font-size: 1.5rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .logo svg {
                height: 2rem;
                width: 2rem;
            }
            
            .nav-links {
                display: flex;
                gap: 1.5rem;
            }
            
            .nav-link {
                color: white;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            
            .nav-link:hover {
                color: rgba(255, 255, 255, 0.8);
            }
            
            .btn {
                display: inline-block;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-weight: 500;
                text-align: center;
                text-decoration: none;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .btn-light {
                background-color: white;
                color: var(--primary);
            }
            
            .btn-light:hover {
                background-color: rgba(255, 255, 255, 0.9);
            }
            
            /* Hero Section */
            .hero {
                padding: 4rem 0;
                text-align: center;
            }
            
            .hero-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
                color: var(--secondary);
            }
            
            .hero-subtitle {
                font-size: 1.25rem;
                color: #64748b;
                margin-bottom: 2rem;
                max-width: 700px;
                margin-left: auto;
                margin-right: auto;
            }
            
            /* Features Section */
            .features {
                padding: 4rem 0;
                background-color: white;
            }
            
            .section-title {
                font-size: 2rem;
                font-weight: 700;
                text-align: center;
                margin-bottom: 3rem;
                color: var(--secondary);
            }
            
            .feature-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
            }
            
            .feature-card {
                background-color: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                padding: 2rem;
                transition: all 0.3s ease;
                border: 1px solid #e2e8f0;
            }
            
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            }
            
            .feature-icon {
                background-color: rgba(37, 99, 235, 0.1);
                height: 3rem;
                width: 3rem;
                border-radius: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
            }
            
            .feature-icon svg {
                height: 1.5rem;
                width: 1.5rem;
                color: var(--primary);
            }
            
            .feature-title {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 0.75rem;
                color: var(--secondary);
            }
            
            .feature-desc {
                color: #64748b;
            }
            
            /* Bus Pass Demo */
            .bus-pass-section {
                padding: 4rem 0;
            }
            
            .bus-pass {
                max-width: 450px;
                margin: 0 auto;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                border-radius: 1rem;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                overflow: hidden;
                color: white;
            }
            
            .bus-pass-header {
                padding: 1.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .pass-logo {
                font-weight: 700;
                font-size: 1.25rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .pass-type {
                background-color: rgba(255, 255, 255, 0.2);
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 500;
            }
            
            .bus-pass-body {
                padding: 1.5rem;
            }
            
            .pass-user {
                display: flex;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .user-avatar {
                height: 4rem;
                width: 4rem;
                background-color: rgba(255, 255, 255, 0.3);
                border-radius: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .user-info h3 {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 0.25rem;
            }
            
            .user-info p {
                opacity: 0.8;
                font-size: 0.875rem;
            }
            
            .pass-details {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .detail-item h4 {
                font-size: 0.75rem;
                text-transform: uppercase;
                opacity: 0.8;
                margin-bottom: 0.25rem;
            }
            
            .detail-item p {
                font-weight: 600;
            }
            
            .pass-barcode {
                background-color: white;
                padding: 1rem;
                border-radius: 0.5rem;
                text-align: center;
            }
            
            .barcode-img {
                height: 3rem;
                width: 100%;
                background-color: #f1f5f9;
                margin-bottom: 0.5rem;
                position: relative;
                overflow: hidden;
            }
            
            .barcode-img::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: repeating-linear-gradient(
                    90deg,
                    #000,
                    #000 2px,
                    transparent 2px,
                    transparent 4px,
                    #000 4px,
                    #000 6px,
                    transparent 6px,
                    transparent 8px
                );
            }
            
            .pass-number {
                color: var(--secondary);
                font-weight: 600;
                letter-spacing: 0.1em;
            }
            
            /* Call to Action */
            .cta {
                padding: 4rem 0;
                text-align: center;
                background-color: var(--secondary);
                color: white;
            }
            
            .cta-title {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            
            .cta-desc {
                font-size: 1.125rem;
                margin-bottom: 2rem;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
                opacity: 0.8;
            }
            
            .btn-primary {
                background-color: var(--primary);
                color: white;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
            
            .btn-primary:hover {
                background-color: var(--primary-dark);
            }
            
            .btn-secondary {
                background-color: transparent;
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.5);
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                margin-left: 1rem;
            }
            
            .btn-secondary:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }
            
            /* Footer */
            .footer {
                background-color: white;
                padding: 2rem 0;
                border-top: 1px solid #e2e8f0;
            }
            
            .footer-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .footer-logo {
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--secondary);
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .footer-links {
                display: flex;
                gap: 2rem;
            }
            
            .footer-link {
                color: #64748b;
                text-decoration: none;
                transition: all 0.3s ease;
            }
            
            .footer-link:hover {
                color: var(--primary);
            }
            
            /* Responsive */
            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2rem;
                }
                
                .feature-grid {
                    grid-template-columns: 1fr;
                }
                
                .footer-content {
                    flex-direction: column;
                    gap: 1.5rem;
                    text-align: center;
                }
                
                .pass-details {
                    grid-template-columns: 1fr;
                }
                
                .cta .btn-secondary {
                    margin-left: 0;
                    margin-top: 1rem;
                    display: block;
                    width: 200px;
                    margin-left: auto;
                    margin-right: auto;
                }
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header class="header">
            <div class="container navbar">
                <div class="logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="9" y1="3" x2="9" y2="21"></line>
                        <path d="M3 9h18"></path>
                    </svg>
                    <h6 style="color: white; font-size: 50px; margin: 0; font-family: 'Brush Script MT', cursive; font-weight: normal;">
    Sky Pass
</h6>

                </div>
                <div class="nav-links">
                    <a href="#features" class="nav-link">Features</a>
                    <a href="#demo" class="nav-link">Demo</a>
                    <a href="#contact" class="nav-link">Contact</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-light">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>
        
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
            <h6 class="hero-title" style=" font-size: 50px; margin: 0; font-family: 'Brush Script MT', cursive; font-weight: normal;">
            Your Digital Sky Pass Solution</h6>
               
                <p class="hero-subtitle">
                    Simplify your commute with our smart digital bus pass system. 
                    Easy to manage, secure to use, and always accessible.
                </p>
                <div>
                    <a href="#" class="btn btn-primary">Get Started</a>
                </div>
            </div>
        </section>
        
        <!-- Features Section -->
        <section class="features" id="features">
            <div class="container">
                <h2 class="section-title" style=" font-size: 50px; margin: 0; font-family: 'Brush Script MT', cursive; font-weight: normal;">Why Choose Digital Sky Pass</h2>
                <div class="feature-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <h3 class="feature-title">Secure Access</h3>
                        <p class="feature-desc">
                            Advanced encryption ensures your pass information is always secure and protected from unauthorized access.
                        </p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <h3 class="feature-title">Easy Management</h3>
                        <p class="feature-desc">
                            Renew passes, check validity, and manage multiple passes for your family all from a single dashboard.
                        </p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <h3 class="feature-title">GPS Integration</h3>
                        <p class="feature-desc">
                            View real-time bus locations, get ETA updates, and find the nearest bus stops with our GPS integration.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Bus Pass Demo -->
        <section class="bus-pass-section" id="demo">
            <div class="container">
                <h2 class="section-title" style=" font-size: 50px; margin: 0; font-family: 'Brush Script MT', cursive; font-weight: normal;">Your Digital Sky Pass</h2>
                <div class="bus-pass">
                    <div class="bus-pass-header">
                        <div class="pass-logo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="9" y1="3" x2="9" y2="21"></line>
                                <path d="M3 9h18"></path>
                            </svg>
                            BusPass
                        </div>
                        <div class="pass-type">
                            Monthly
                        </div>
                    </div>
                    <div class="bus-pass-body">
                        <div class="pass-user">
                            <div class="user-avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="user-info">
                                <h3>John Doe</h3>
                                <p>Premium Passenger</p>
                            </div>
                        </div>
                        <div class="pass-details">
                            <div class="detail-item">
                                <h4>Pass ID</h4>
                                <p>BP40598231</p>
                            </div>
                            <div class="detail-item">
                                <h4>Valid Until</h4>
                                <p>May 31, 2025</p>
                            </div>
                            <div class="detail-item">
                                <h4>Zone</h4>
                                <p>All Zones</p>
                            </div>
                            <div class="detail-item">
                                <h4>Status</h4>
                                <p>Active</p>
                            </div>
                        </div>
                        <div class="pass-barcode">
                            <div class="barcode-img"></div>
                            <p class="pass-number">4059 8231 7629 1081</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Call to Action -->
        <section class="cta" id="contact">
            <div class="container">
                <h2 class="cta-title">Ready to Get Started?</h2>
                <p class="cta-desc">
                    Join thousands of commuters who have already made the switch to our digital bus pass system.
                </p>
                <div>
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up Now</a>
                    <a href="#" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container footer-content">
                <div class="footer-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="9" y1="3" x2="9" y2="21"></line>
                        <path d="M3 9h18"></path>
                    </svg>
                    <h6 style="font-family: 'Brush Script MT', cursive; font-weight: normal;">
    Sky Pass
</h6>
                </div>
                <div class="footer-links">
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Terms of Service</a>
                    <a href="#" class="footer-link">Contact Us</a>
                    <a href="#" class="footer-link">FAQ</a>
                </div>
            </div>
        </footer>
        
        <!-- Service Worker Registration -->
        <script src="{{ asset('/sw.js') }}"></script>
        <script>
            if ("serviceWorker" in navigator) {
                navigator.serviceWorker.register("/sw.js").then(
                    (registration) => {
                        console.log("Service worker registration succeeded:", registration);
                    },
                    (error) => {
                        console.error(`Service worker registration failed: ${error}`);
                    },
                );
            } else {
                console.error("Service workers are not supported.");
            }
        </script>
    </body>
</html>