<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MDM System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --brand-color: #a47ae8;
            --brand-gradient: linear-gradient(135deg, #a47ae8, #6c2bd9);
            --dark-bg: #0f172a;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --accent-color: #ec4899;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1e293b 100%);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Geometric background elements */
        .geometric-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            overflow: hidden;
        }

        .geo-shape {
            position: absolute;
            opacity: 0.05;
            animation: geoRotate 30s infinite linear;
        }

        .geo-shape:nth-child(1) {
            width: 400px;
            height: 400px;
            background: var(--brand-color);
            top: -200px;
            left: -200px;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            animation-delay: 0s;
            animation-duration: 40s;
        }

        .geo-shape:nth-child(2) {
            width: 300px;
            height: 300px;
            background: var(--accent-color);
            bottom: -150px;
            right: 10%;
            clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%);
            animation-delay: 5s;
            animation-duration: 35s;
        }

        .geo-shape:nth-child(3) {
            width: 250px;
            height: 250px;
            background: #0ea5e9;
            top: 20%;
            right: -125px;
            clip-path: circle(50% at 50% 50%);
            animation-delay: 10s;
            animation-duration: 30s;
        }

        @keyframes geoRotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Floating connection lines */
        .connection-lines {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .line {
            position: absolute;
            background: rgba(164, 122, 232, 0.1);
            transform-origin: 0 0;
        }

        /* Floating UI elements */
        .floating-ui {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            backdrop-filter: blur(5px);
            animation: floatElement 15s infinite ease-in-out;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 15%;
            left: 10%;
            animation-delay: 0s;
            animation-duration: 20s;
        }

        .floating-element:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 65%;
            left: 15%;
            animation-delay: 2s;
            animation-duration: 18s;
        }

        .floating-element:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 30%;
            right: 10%;
            animation-delay: 4s;
            animation-duration: 22s;
        }

        .floating-element:nth-child(4) {
            width: 70px;
            height: 70px;
            top: 75%;
            right: 15%;
            animation-delay: 6s;
            animation-duration: 17s;
        }

        @keyframes floatElement {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(15px, 20px) rotate(5deg);
            }
            50% {
                transform: translate(-10px, 15px) rotate(-5deg);
            }
            75% {
                transform: translate(5px, -10px) rotate(3deg);
            }
        }

        /* Main login container */
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            perspective: 1000px;
        }

        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.05);
            padding: 2.5rem;
            transform-style: preserve-3d;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            opacity: 0.8;
        }

        .login-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: 0.5s;
        }

        .login-card:hover::after {
            left: 100%;
        }

        /* Header styles */
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
            transform: translateZ(20px);
        }

        .logo-container {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            perspective: 500px;
        }

        .logo-inner {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            animation: logoRotate 20s infinite linear;
        }

        .logo-face {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            backface-visibility: hidden;
            background: rgba(164, 122, 232, 0.1);
            border: 2px solid rgba(164, 122, 232, 0.3);
        }

        .logo-face i {
            font-size: 2rem;
            color: var(--brand-color);
        }

        .logo-face:nth-child(1) { transform: rotateY(0deg) translateZ(40px); }
        .logo-face:nth-child(2) { transform: rotateY(90deg) translateZ(40px); }
        .logo-face:nth-child(3) { transform: rotateY(180deg) translateZ(40px); }
        .logo-face:nth-child(4) { transform: rotateY(270deg) translateZ(40px); }

        @keyframes logoRotate {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }

        /* Form styles */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
            transform: translateZ(10px);
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .input-container {
            position: relative;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--brand-color);
            box-shadow: 0 0 0 3px rgba(164, 122, 232, 0.15);
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            transition: color 0.3s ease;
        }

        .form-control:focus + .input-icon {
            color: var(--brand-color);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--brand-color);
        }

        /* Checkbox styling */
        .form-check {
            margin-bottom: 1.5rem;
            transform: translateZ(5px);
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-check-input:checked {
            background-color: var(--brand-color);
            border-color: var(--brand-color);
        }

        .form-check-label {
            color: var(--text-secondary);
        }

        /* Button styles */
        .btn-login {
            width: 100%;
            background: var(--brand-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.875rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            transform: translateZ(15px);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(124, 58, 237, 0.3);
        }

        /* Footer links */
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            transform: translateZ(10px);
        }

        .auth-footer p {
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .auth-link {
            color: var(--brand-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--brand-color);
            transition: width 0.3s ease;
        }

        .auth-link:hover {
            color: var(--accent-color);
        }

        .auth-link:hover::after {
            width: 100%;
        }

        /* Alert styles */
        .alert {
            border-radius: 12px;
            padding: 0.875rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            animation: fadeIn 0.5s ease;
            transform: translateZ(10px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px) translateZ(10px); }
            to { opacity: 1; transform: translateY(0) translateZ(10px); }
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #f8d7da;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-container {
                padding: 15px;
            }

            .login-card {
                padding: 2rem 1.5rem;
            }

            .logo-container {
                width: 70px;
                height: 70px;
            }
        }

        /* Particle background */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -3;
        }
    </style>
</head>
<body>
    <!-- Geometric background -->
    <div class="geometric-bg">
        <div class="geo-shape"></div>
        <div class="geo-shape"></div>
        <div class="geo-shape"></div>
    </div>

    <!-- Floating UI elements -->
    <div class="floating-ui">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <!-- Particles background -->
    <div id="particles-js"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="auth-header">
                <div class="logo-container">
                    <div class="logo-inner">
                        <div class="logo-face"><i class="bi bi-database"></i></div>
                        <div class="logo-face"><i class="bi bi-gear"></i></div>
                        <div class="logo-face"><i class="bi bi-cpu"></i></div>
                        <div class="logo-face"><i class="bi bi-code-slash"></i></div>
                    </div>
                </div>
                <h2>Welcome Back</h2>
                <p class="text-secondary">Sign in to your MDM System</p>
            </div>

            <div id="login-alert" class="alert alert-danger d-none" role="alert">
                Invalid email or password. Please try again.
            </div>

            <form id="login-form">
                <div class="form-group">
                    <label for="login-email" class="form-label">Email Address</label>
                    <div class="input-container">
                        <input type="email" class="form-control" id="login-email" placeholder="Enter your email" required>
                        <i class="bi bi-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="login-password" class="form-label">Password</label>
                    <div class="input-container">
                        <input type="password" class="form-control" id="login-password" placeholder="Enter your password" required>
                        <i class="bi bi-lock input-icon"></i>
                        <i class="bi bi-eye-slash password-toggle" id="login-toggle-password"></i>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember-me">
                    <label class="form-check-label" for="remember-me">Remember me</label>
                </div>

                <button type="submit" class="btn btn-login" id="login-button">
                    <span id="login-button-text">Sign In</span>
                    <span id="login-button-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account?
                    <a href="{{ route('register') }}" class="auth-link" id="show-register">Sign Up</a>
                </p>
                <p><a href="#" class="auth-link">Forgot your password?</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize particles.js
            particlesJS('particles-js', {
                particles: {
                    number: { value: 80, density: { enable: true, value_area: 800 } },
                    color: { value: "#a47ae8" },
                    shape: { type: "circle" },
                    opacity: {
                        value: 0.3,
                        random: true,
                        anim: { enable: true, speed: 1, opacity_min: 0.1, sync: false }
                    },
                    size: {
                        value: 3,
                        random: true,
                        anim: { enable: true, speed: 2, size_min: 0.1, sync: false }
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#a47ae8",
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 1,
                        direction: "none",
                        random: true,
                        straight: false,
                        out_mode: "out",
                        bounce: false
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: { enable: true, mode: "grab" },
                        onclick: { enable: true, mode: "push" },
                        resize: true
                    },
                    modes: {
                        grab: { distance: 140, line_linked: { opacity: 0.4 } },
                        push: { particles_nb: 4 }
                    }
                },
                retina_detect: true
            });

            // Toggle password visibility
            function setupPasswordToggle() {
                const toggle = document.getElementById('login-toggle-password');
                const input = document.getElementById('login-password');

                toggle.addEventListener('click', function() {
                    if (input.type === 'password') {
                        input.type = 'text';
                        toggle.classList.remove('bi-eye-slash');
                        toggle.classList.add('bi-eye');
                    } else {
                        input.type = 'password';
                        toggle.classList.remove('bi-eye');
                        toggle.classList.add('bi-eye-slash');
                    }
                });
            }

            // Form submission
            function setupFormSubmission() {
                const form = document.getElementById('login-form');
                const buttonText = document.getElementById('login-button-text');
                const buttonSpinner = document.getElementById('login-button-spinner');
                const alert = document.getElementById('login-alert');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = document.getElementById('login-email').value;
                    const password = document.getElementById('login-password').value;

                    // Show loading state
                    buttonText.classList.add('d-none');
                    buttonSpinner.classList.remove('d-none');

                    // Simulate API call
                    setTimeout(() => {
                        if (email === 'admin@example.com' && password === 'password') {
                            // Successful login - redirect to dashboard
                            window.location.href = 'dashboard.html';
                        } else {
                            // Show error message
                            alert.classList.remove('d-none');

                            // Hide loading state
                            buttonText.classList.remove('d-none');
                            buttonSpinner.classList.add('d-none');
                        }
                    }, 1500);
                });
            }

            // Initialize everything
            setupPasswordToggle();
            setupFormSubmission();

        });
    </script>
</body>
</html>
