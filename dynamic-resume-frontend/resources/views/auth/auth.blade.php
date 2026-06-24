<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back - Dynamic Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --rb-pink: #ec4899;
            --rb-purple: #8b5cf6;
            --rb-dark: #0f172a;
            --rb-muted: #64748b;
            --rb-border: #e5e7eb;
        }

        * { box-sizing: border-box; }

        /* Desktop view fix:
           Browser 100% par page ko wahi visual size deta hai jo tumhe 67% zoom par acha lag raha tha.
           Mobile/tablet par ye off rahega taake responsive layout break na ho. */
        @media (min-width: 1051px) {
            body {
                zoom: 67%;
            }
        }

        html { scroll-behavior: smooth; }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 12% 16%, rgba(139, 92, 246, 0.16), transparent 28%),
                radial-gradient(circle at 90% 10%, rgba(236, 72, 153, 0.14), transparent 25%),
                linear-gradient(135deg, #f8fafc 0%, #ffffff 45%, #fdf2f8 100%);
            overflow-x: hidden;
            color: #0f172a;
        }

        body::-webkit-scrollbar { width: 11px; }
        body::-webkit-scrollbar-track { background: #f1f5f9; }
        body::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #8b5cf6, #ec4899);
            border-radius: 999px;
            border: 3px solid #f1f5f9;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 42px 24px;
        }

        .auth-shell {
            width: min(1180px, 100%);
            min-height: 650px;
            display: grid;
            grid-template-columns: 1.04fr 0.96fr;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 34px 90px rgba(15, 23, 42, 0.16);
            backdrop-filter: blur(14px);
        }

        .auth-visual {
            position: relative;
            background:
                linear-gradient(145deg, rgba(139, 92, 246, 0.10), rgba(236, 72, 153, 0.08)),
                #ffffff;
            padding: 50px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-right: 1px solid #edf2f7;
            overflow: hidden;
        }

        .auth-visual::before {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.18), rgba(236, 72, 153, 0.16));
            left: -150px;
            top: -120px;
            filter: blur(8px);
        }

        .auth-visual::after {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.09);
            right: -100px;
            bottom: -70px;
            filter: blur(10px);
        }

        .visual-content { position: relative; z-index: 2; }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .brand-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #8b5cf6, #ec4899);
            color: #ffffff;
            font-size: 24px;
            box-shadow: 0 16px 32px rgba(139, 92, 246, 0.24);
        }

        .brand-name {
            font-size: 28px;
            font-weight: 950;
            letter-spacing: -0.03em;
            background: linear-gradient(90deg, #7c3aed, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .visual-title {
            font-size: clamp(34px, 3.4vw, 54px);
            line-height: 1.03;
            font-weight: 950;
            letter-spacing: -0.055em;
            color: #0f172a;
            margin: 0 0 14px;
        }

        .visual-subtitle {
            max-width: 560px;
            color: #64748b;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .animation-card {
            position: relative;
            background: rgba(255,255,255,0.84);
            border: 1px solid #e5e7eb;
            border-radius: 26px;
            min-height: 330px;
            box-shadow: 0 26px 60px rgba(15, 23, 42, 0.09);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .animation-card lottie-player {
            width: 100%;
            height: 340px;
            max-width: 520px;
        }

        .visual-points {
            margin-top: 26px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .visual-point {
            background: rgba(255,255,255,0.76);
            border: 1px solid #edf2f7;
            border-radius: 18px;
            padding: 16px;
            color: #334155;
            font-weight: 800;
            font-size: 13px;
            line-height: 1.45;
        }

        .visual-point i { color: #ec4899; margin-right: 7px; }

        .visual-emoji {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 7px;
            font-size: 15px;
            line-height: 1;
        }

        .auth-form-side {
            background: rgba(255,255,255,0.98);
            padding: 54px 52px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-card { width: 100%; max-width: 470px; }

        .form-kicker {
            color: #ec4899;
            font-size: 13px;
            font-weight: 950;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        #formTitle {
            font-size: 32px;
            line-height: 1.12;
            font-weight: 950;
            letter-spacing: -0.04em;
            color: #0f172a;
            margin-bottom: 9px;
        }

        .form-subtitle {
            color: #64748b;
            font-size: 14px;
            line-height: 1.65;
            margin-bottom: 24px;
        }

        .social-box { 
            display: grid; 
            gap: 12px; 
            margin-bottom: 22px; 
            width: 100%;
            justify-items: center;
        }

        .g_id_signin {
            width: 100% !important;
            min-height: 43px;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            overflow: visible !important;
        }

        .g_id_signin > div {
            width: auto !important;
            max-width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
            display: flex !important;
            justify-content: center !important;
        }

        .g_id_signin iframe {
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
            border-radius: 999px !important;
        }

        .facebook-btn {
            width: 86.5%;
            min-height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 1px solid #d7dee8;
            border-radius: 999px;
            color: #334155;
            font-weight: 800;
            background: #ffffff;
            transition: 0.2s ease;
        }

        .facebook-btn:hover { background: #f8fafc; transform: translateY(-1px); }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 800;
            margin: 20px 0;
        }

        .divider::before, .divider::after {
            content: "";
            height: 1px;
            background: #e2e8f0;
            flex: 1;
        }

        .message-box {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 14px;
            text-align: center;
            font-size: 13px;
            font-weight: 800;
        }

        .input-group input {
            width: 100%;
            height: 52px;
            border: 1px solid #d7dee8;
            border-radius: 14px;
            padding: 0 16px;
            outline: none;
            color: #0f172a;
            background: #f8fafc;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .input-group input:focus {
            border-color: #ec4899;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.10);
        }

        .input-group input::placeholder { color: #94a3b8; font-weight: 700; }

        .name-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }


        @media (max-width: 620px) {
            .g_id_signin > div {
                max-width: 100% !important;
            }
        }

        @media (max-width: 620px) {
            .name-row {
                grid-template-columns: 1fr;
            }
        }


        .submit-btn {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: 999px;
            color: #ffffff;
            font-weight: 950;
            letter-spacing: 0.045em;
            background: linear-gradient(90deg, #ec4899, #9333ea);
            box-shadow: 0 18px 34px rgba(236, 72, 153, 0.26);
            transition: 0.22s ease;
        }

        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 22px 42px rgba(147, 51, 234, 0.25); }
        .register-btn { background: linear-gradient(90deg, #7c3aed, #ec4899); }
        .otp-btn { background: linear-gradient(90deg, #10b981, #059669); }

        .toggle-area {
            margin-top: 26px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
        }

        .toggle-area button {
            color: #7c3aed;
            font-weight: 950;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .terms-text {
            margin-top: 22px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.6;
        }

        .terms-text a { color: #64748b; text-decoration: underline; }

        .input-group {
            position: relative;
        }

        .input-group.has-left-icon input {
            padding-left: 48px;
        }

        .input-group.has-right-icon input {
            padding-right: 56px;
        }

        .input-icon-left {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #ec4899;
            font-size: 16px;
            pointer-events: none;
            z-index: 2;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border: none;
            background: transparent;
            color: #ec4899;
            display: grid;
            place-items: center;
            cursor: pointer;
            border-radius: 999px;
            transition: 0.2s ease;
            z-index: 3;
        }

        .password-toggle:hover {
            background: rgba(236, 72, 153, 0.10);
            color: #db2777;
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear,
        input[type="text"]::-ms-reveal,
        input[type="text"]::-ms-clear {
            display: none;
            width: 0;
            height: 0;
        }

        .forgot-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .secondary-btn {
            width: 100%;
            height: 50px;
            border-radius: 999px;
            border: 1px solid #d7dee8;
            background: #ffffff;
            color: #334155;
            font-weight: 950;
            transition: 0.2s ease;
        }

        .secondary-btn:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }


        @media (max-width: 1050px) {
            .auth-shell { grid-template-columns: 1fr; }
            .auth-visual { min-height: 520px; border-right: none; border-bottom: 1px solid #edf2f7; }
            .auth-form-side { padding: 44px 28px; }
        }

        @media (max-width: 620px) {
            .auth-page { padding: 18px; }
            .auth-shell { border-radius: 24px; }
            .auth-visual { padding: 34px 22px; min-height: auto; }
            .visual-points { grid-template-columns: 1fr; }
            .animation-card { min-height: 260px; }
            .animation-card lottie-player { height: 260px; }
            .auth-form-side { padding: 34px 22px; }
            #formTitle { font-size: 27px; }
        }
    </style>
</head>

<body>
    <main class="auth-page">
        <section class="auth-shell">
            <aside class="auth-visual">
                <div class="visual-content">
                    <div class="brand-row">
                        <div class="brand-icon"><i class="fa-solid fa-layer-group"></i></div>
                        <div class="brand-name">ResumeBuilder</div>
                    </div>

                    <h1 class="visual-title">Build your resume with a smarter flow.</h1>
                    <p class="visual-subtitle">
                        Follow a simple guided process, save your progress, and continue from dashboard anytime.
                    </p>

                    <div class="animation-card">
                        <lottie-player
                            src="/animations/admin-login.json"
                            background="transparent"
                            speed="1"
                            loop
                            autoplay>
                        </lottie-player>
                    </div>

                    <div class="visual-points">
<div class="visual-point"><span class="visual-emoji">🔐</span>Secure account access</div>
<div class="visual-point"><i class="fa-solid fa-wand-magic-sparkles"></i>Guided resume builder</div>
<div class="visual-point"><i class="fa-solid fa-file-lines"></i>Live resume preview</div>
                    </div>
                </div>
            </aside>

            <section class="auth-form-side">
                <div class="form-card">
                    <div class="form-kicker">Account Access</div>
                    <h2 id="formTitle">Welcome back! Please sign in.</h2>
                    <p class="form-subtitle">Login to continue your Dynamic Resume Builder workspace.</p>

                    <div class="social-box">
                        <div id="g_id_onload"
                             data-client_id="783911901039-di5j465edrasqhl2r7cg760drhlpn6bc.apps.googleusercontent.com"
                             data-context="signin"
                             data-ux_mode="popup"
                             data-callback="handleGoogleCredentialResponse"
                             data-auto_prompt="false"></div>
                        <div class="g_id_signin w-full flex justify-center"
                             data-type="standard"
                             data-size="large"
                             data-theme="outline"
                             data-text="sign_in_with"
                             data-shape="pill"
                             data-logo_alignment="left"
                             data-width="420"></div>

                        <button class="facebook-btn" type="button">
                            <i class="fa-brands fa-facebook text-blue-600 text-lg"></i>
                            Sign in with Facebook
                        </button>
                    </div>

                    <div class="divider">OR</div>

                    <div id="messageBox" class="hidden message-box"></div>

                    <form id="loginForm" class="space-y-4" autocomplete="off">
                        <div class="input-group has-left-icon">
                            <i class="fa-solid fa-envelope input-icon-left"></i>
                            <input type="email" id="loginEmail" placeholder="Email Address" autocomplete="off" value="" required>
                        </div>
                        <div class="input-group has-left-icon has-right-icon">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" id="loginPassword" placeholder="Password" autocomplete="new-password" value="" required>
                            <button type="button" class="password-toggle" data-target="loginPassword" aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div class="text-right">
                            <button type="button" id="forgotPasswordBtn" class="text-sm text-pink-500 font-bold hover:underline bg-transparent border-0 cursor-pointer">Forgot your password?</button>
                        </div>
                        <button type="submit" class="submit-btn">SUBMIT</button>
                    </form>

                    <form id="registerForm" class="space-y-4 hidden" autocomplete="off">
                        <div class="name-row">
                            <div class="input-group has-left-icon">
                                <i class="fa-solid fa-user input-icon-left"></i>
                                <input type="text" id="regFirstName" placeholder="First Name" autocomplete="off" value="" required>
                            </div>

                            <div class="input-group has-left-icon">
                                <i class="fa-solid fa-user input-icon-left"></i>
                                <input type="text" id="regLastName" placeholder="Last Name" autocomplete="off" value="" required>
                            </div>
                        </div>

                        <div class="input-group has-left-icon">
                            <i class="fa-solid fa-envelope input-icon-left"></i>
                            <input type="email" id="regEmail" placeholder="Email Address" autocomplete="off" value="" required>
                        </div>

                        <div class="input-group has-left-icon has-right-icon">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" id="regPassword" placeholder="Password (min 6 characters)" autocomplete="new-password" value="" required minlength="6">
                            <button type="button" class="password-toggle" data-target="regPassword" aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        <div class="input-group has-left-icon has-right-icon">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" id="regConfirmPassword" placeholder="Confirm Password" autocomplete="new-password" value="" required minlength="6">
                            <button type="button" class="password-toggle" data-target="regConfirmPassword" aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="submit-btn register-btn">CREATE ACCOUNT</button>
                    </form>

                    <form id="otpForm" class="space-y-4 hidden" autocomplete="off">
                        <p class="text-sm text-gray-600 text-center">The verification code has been sent to your email. Please enter it below.</p>
                        <div class="input-group">
                            <input type="text" id="otpCode" placeholder="6-Digit OTP" autocomplete="off" value="" required maxlength="6">
                        </div>
                        <button type="submit" class="submit-btn otp-btn">VERIFY & SIGN IN</button>
                    </form>

                    <form id="forgotEmailForm" class="space-y-4 hidden" autocomplete="off">
                        <p class="text-sm text-gray-600 text-center">
                            Enter your registered email address. We will send a 6-digit password reset code.
                        </p>

                        <div class="input-group has-left-icon">
                            <i class="fa-solid fa-envelope input-icon-left"></i>
                            <input type="email" id="forgotEmail" placeholder="Registered Email Address" autocomplete="off" value="" required>
                        </div>

                        <div class="forgot-actions">
                            <button type="button" id="backToLoginFromEmail" class="secondary-btn">BACK</button>
                            <button type="submit" class="submit-btn">SEND CODE</button>
                        </div>
                    </form>

                    <form id="forgotCodeForm" class="space-y-4 hidden" autocomplete="off">
                        <p class="text-sm text-gray-600 text-center">
                            Enter the 6-digit code sent to your registered email.
                        </p>

                        <div class="input-group">
                            <input type="text" id="forgotCode" placeholder="6-Digit Reset Code" autocomplete="off" value="" required maxlength="6">
                        </div>

                        <div class="forgot-actions">
                            <button type="button" id="backToForgotEmail" class="secondary-btn">BACK</button>
                            <button type="submit" class="submit-btn otp-btn">VERIFY CODE</button>
                        </div>
                    </form>

                    <form id="resetPasswordForm" class="space-y-4 hidden" autocomplete="off">
                        <p class="text-sm text-gray-600 text-center">
                            Create a new password for your account.
                        </p>

                        <div class="input-group has-left-icon has-right-icon">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" id="newPassword" placeholder="New Password" autocomplete="new-password" value="" required minlength="6">
                            <button type="button" class="password-toggle" data-target="newPassword" aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        <div class="input-group has-left-icon has-right-icon">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" id="confirmNewPassword" placeholder="Confirm Password" autocomplete="new-password" value="" required minlength="6">
                            <button type="button" class="password-toggle" data-target="confirmNewPassword" aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        <div class="forgot-actions">
                            <button type="button" id="backToForgotCode" class="secondary-btn">BACK</button>
                            <button type="submit" class="submit-btn register-btn">UPDATE PASSWORD</button>
                        </div>
                    </form>


                    <div class="toggle-area">
                        <span id="toggleText">Need an account?</span>
                        <button id="toggleBtn" type="button">Sign up for free</button>
                    </div>

                    <div class="terms-text">
                        By clicking submit you agree to our <a href="about:blank" target="_blank">Terms</a> and <a href="about:blank" target="_blank">Privacy Policy</a>.
                    </div>
                </div>
            </section>
        </section>
    </main>

    <script>
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const otpForm = document.getElementById('otpForm');
        const toggleBtn = document.getElementById('toggleBtn');
        const formTitle = document.getElementById('formTitle');
        const toggleText = document.getElementById('toggleText');
        const messageBox = document.getElementById('messageBox');
        const forgotPasswordBtn = document.getElementById('forgotPasswordBtn');
        const forgotEmailForm = document.getElementById('forgotEmailForm');
        const forgotCodeForm = document.getElementById('forgotCodeForm');
        const resetPasswordForm = document.getElementById('resetPasswordForm');
        const backToLoginFromEmail = document.getElementById('backToLoginFromEmail');
        const backToForgotEmail = document.getElementById('backToForgotEmail');
        const backToForgotCode = document.getElementById('backToForgotCode');
        let resetEmailValue = '';
        let resetOtpValue = '';

        let isLogin = true;

        function clearAllAuthFields() {
            document.querySelectorAll('form').forEach((form) => form.reset());

            [
                'loginEmail',
                'loginPassword',
                'regFirstName',
                'regLastName',
                'regEmail',
                'regPassword',
                'regConfirmPassword',
                'otpCode',
                'forgotEmail',
                'forgotCode',
                'newPassword',
                'confirmNewPassword'
            ].forEach((id) => {
                const input = document.getElementById(id);
                if (input) input.value = '';
            });

            resetEmailValue = '';
            resetOtpValue = '';
        }

        window.addEventListener('DOMContentLoaded', () => {
            clearAllAuthFields();
        });

        window.addEventListener('pageshow', () => {
            clearAllAuthFields();
        });


        function hideAllAuthForms() {
            loginForm.classList.add('hidden');
            registerForm.classList.add('hidden');
            if (otpForm) otpForm.classList.add('hidden');
            if (forgotEmailForm) forgotEmailForm.classList.add('hidden');
            if (forgotCodeForm) forgotCodeForm.classList.add('hidden');
            if (resetPasswordForm) resetPasswordForm.classList.add('hidden');
        }

        function showLoginForm() {
            hideAllAuthForms();
            loginForm.reset();
            document.getElementById('loginEmail').value = '';
            document.getElementById('loginPassword').value = '';
            loginForm.classList.remove('hidden');
            formTitle.innerText = 'Welcome back! Please sign in.';
            toggleText.innerText = 'Need an account?';
            toggleBtn.innerText = 'Sign up for free';
            toggleBtn.classList.remove('hidden');
            toggleBtn.removeAttribute('data-mode');
            isLogin = true;
        }

        function showForgotEmailForm() {
            hideAllAuthForms();
            forgotEmailForm.reset();
            document.getElementById('forgotEmail').value = '';
            forgotEmailForm.classList.remove('hidden');
            formTitle.innerText = 'Reset your password';
            toggleText.innerText = 'Remembered your password?';
            toggleBtn.innerText = 'Sign in';
            toggleBtn.classList.remove('hidden');
            toggleBtn.setAttribute('data-mode', 'forgot-login');
            messageBox.classList.add('hidden');
        }

        function showForgotCodeForm() {
            hideAllAuthForms();
            forgotCodeForm.reset();
            document.getElementById('forgotCode').value = '';
            forgotCodeForm.classList.remove('hidden');
            formTitle.innerText = 'Verify reset code';
            toggleBtn.classList.add('hidden');
        }

        function showResetPasswordForm() {
            hideAllAuthForms();
            resetPasswordForm.reset();
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmNewPassword').value = '';
            resetPasswordForm.classList.remove('hidden');
            formTitle.innerText = 'Create new password';
            toggleBtn.classList.add('hidden');
        }

        // Smooth Toggle Between Forms
        toggleBtn.addEventListener('click', () => {
            if (toggleBtn.getAttribute('data-mode') === 'forgot-login') {
                showLoginForm();
                messageBox.classList.add('hidden');
                return;
            }

            isLogin = !isLogin;
            messageBox.classList.add('hidden'); // Clear messages on toggle
            if (forgotEmailForm) forgotEmailForm.classList.add('hidden');
            if (forgotCodeForm) forgotCodeForm.classList.add('hidden');
            if (resetPasswordForm) resetPasswordForm.classList.add('hidden');
            toggleBtn.classList.remove('hidden');

            // Reset all forms when toggling
            loginForm.reset();
            registerForm.reset();
            if(otpForm) otpForm.reset();
            if(forgotEmailForm) forgotEmailForm.reset();
            if(forgotCodeForm) forgotCodeForm.reset();
            if(resetPasswordForm) resetPasswordForm.reset();

            if (isLogin) {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                if(otpForm) otpForm.classList.add('hidden');
                formTitle.innerText = 'Welcome back! Please sign in.';
                toggleText.innerText = 'Need an account?';
                toggleBtn.innerText = 'Sign up for free';
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                if(otpForm) otpForm.classList.add('hidden');
                formTitle.innerText = 'Create your free account.';
                toggleText.innerText = 'Already have an account?';
                toggleBtn.innerText = 'Sign in';
            }
        });

        // Show Messages Function with Smoothness
        function showMessage(msg, isSuccess) {
            messageBox.innerText = msg;
            messageBox.className = `message-box transition-all duration-300 ease-in-out ${isSuccess ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`;
            messageBox.classList.remove('hidden');
        }

        // Button State Manager for Smooth UI
        function setButtonState(button, isLoading, text) {
            if (isLoading) {
                button.disabled = true;
                button.innerHTML = `<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> ${text}`;
                button.classList.add('opacity-70', 'cursor-not-allowed');
            } else {
                button.disabled = false;
                button.innerHTML = text;
                button.classList.remove('opacity-70', 'cursor-not-allowed');
            }
        }

        // Handle Registration
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = registerForm.querySelector('button[type="submit"]');
            setButtonState(btn, true, 'CREATING ACCOUNT...');

            const firstName = document.getElementById('regFirstName').value.trim();
            const lastName = document.getElementById('regLastName').value.trim();
            const name = `${firstName} ${lastName}`.trim();
            const email = document.getElementById('regEmail').value.trim().toLowerCase();
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;

            if (!firstName || !lastName) {
                showMessage('Please enter both first name and last name.', false);
                setButtonState(btn, false, 'CREATE ACCOUNT');
                return;
            }

            if (password !== confirmPassword) {
                showMessage('Password and confirm password do not match.', false);
                setButtonState(btn, false, 'CREATE ACCOUNT');
                return;
            }

            try {
                const res = await fetch('http://localhost:5000/api/auth/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, email, password })
                });
                const data = await res.json();

                if(data.success) {
                    // Save email in local storage temporarily for OTP verification
                    localStorage.setItem('temp_email', email);
                    registerForm.reset(); // Fields clear karna

                    showMessage('OTP sent to your email!', true);

                    // Smoothly switch to OTP form
                    registerForm.classList.add('hidden');
                    otpForm.classList.remove('hidden');
                    formTitle.innerText = 'Verify Your Email';
                } else {
                    showMessage(data.message, false);
                }
            } catch (err) {
                showMessage('Server error. Is Node.js running?', false);
            } finally {
                setButtonState(btn, false, 'CREATE ACCOUNT');
            }
        });

        // Handle OTP Verification
        if(otpForm) {
            otpForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const btn = otpForm.querySelector('button[type="submit"]');
                setButtonState(btn, true, 'VERIFYING...');

                // Form reset hone ki waja se email local storage se uthayein
                const email = localStorage.getItem('temp_email') || document.getElementById('regEmail').value;
                const otp = document.getElementById('otpCode').value;

                try {
                    // Original API verification logic preserved
                    const res = await fetch('http://localhost:5000/api/auth/verify-otp', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ email, otp })
                    });
                    const data = await res.json();

                    if(data.success) {
                        otpForm.reset(); // Fields clear karna
                        showMessage('Email verified successfully! You can now log in.', true);
                        localStorage.removeItem('temp_email'); // Clear temp email

                        // After email verification, safely show login form
                        setTimeout(() => { showLoginForm(); }, 1500);
                    } else {
                        showMessage(data.message, false);
                    }
                } catch (err) {
                    showMessage('Server error. Is Node.js running?', false);
                } finally {
                    setButtonState(btn, false, 'VERIFY & SIGN IN');
                }
            });
        }

        // Handle Login
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = loginForm.querySelector('button[type="submit"]');
            setButtonState(btn, true, 'LOGGING IN...');

            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            try {
                const res = await fetch('http://localhost:5000/api/auth/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const data = await res.json();

                if(data.success) {
                    // Explicitly clearing fields for login
                    document.getElementById('loginEmail').value = '';
                    document.getElementById('loginPassword').value = '';
                    loginForm.reset(); // Form reset

                    showMessage('Login Successful! Redirecting...', true);
                    localStorage.setItem('resume_token', data.token);

                    setTimeout(() => { window.location.href = "/dashboard"; }, 1000);
                } else {
                    showMessage(data.message, false);
                }
            } catch (err) {
                showMessage('Server error. Is Node.js running?', false);
            } finally {
                // Agar successful nahi hua tou button ko dobara normal state par layein
                if(messageBox.className.includes('text-red-700')) {
                    setButtonState(btn, false, 'SUBMIT');
                }
            }
        });



        if (forgotPasswordBtn) {
            forgotPasswordBtn.addEventListener('click', () => {
                if (forgotEmailForm) forgotEmailForm.reset();
                document.getElementById('forgotEmail').value = '';
                showForgotEmailForm();
            });
        }

        if (backToLoginFromEmail) {
            backToLoginFromEmail.addEventListener('click', () => {
                showLoginForm();
                messageBox.classList.add('hidden');
            });
        }

        if (backToForgotEmail) {
            backToForgotEmail.addEventListener('click', () => {
                showForgotEmailForm();
            });
        }

        if (backToForgotCode) {
            backToForgotCode.addEventListener('click', () => {
                showForgotCodeForm();
            });
        }

        if (forgotEmailForm) {
            forgotEmailForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const btn = forgotEmailForm.querySelector('button[type="submit"]');
                setButtonState(btn, true, 'SENDING CODE...');

                const email = document.getElementById('forgotEmail').value.trim().toLowerCase();

                try {
                    const res = await fetch('http://localhost:5000/api/auth/forgot-password', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ email })
                    });

                    const data = await res.json();

                    if (data.success) {
                        resetEmailValue = email;
                        showMessage(data.message || 'Password reset code sent to your registered email.', true);
                        showForgotCodeForm();
                    } else {
                        showMessage(data.message || 'This email is not registered. Please sign up first.', false);
                    }
                } catch (err) {
                    showMessage('Server error. Is Node.js running?', false);
                } finally {
                    setButtonState(btn, false, 'SEND CODE');
                }
            });
        }

        if (forgotCodeForm) {
            forgotCodeForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const btn = forgotCodeForm.querySelector('button[type="submit"]');
                setButtonState(btn, true, 'VERIFYING...');

                const otp = document.getElementById('forgotCode').value.trim();

                try {
                    const res = await fetch('http://localhost:5000/api/auth/verify-reset-code', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ email: resetEmailValue, otp })
                    });

                    const data = await res.json();

                    if (data.success) {
                        resetOtpValue = otp;
                        showMessage(data.message || 'Code verified successfully.', true);
                        showResetPasswordForm();
                    } else {
                        showMessage(data.message || 'Invalid or expired reset code.', false);
                    }
                } catch (err) {
                    showMessage('Server error. Is Node.js running?', false);
                } finally {
                    setButtonState(btn, false, 'VERIFY CODE');
                }
            });
        }

        if (resetPasswordForm) {
            resetPasswordForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const btn = resetPasswordForm.querySelector('button[type="submit"]');
                setButtonState(btn, true, 'UPDATING...');

                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmNewPassword').value;

                try {
                    const res = await fetch('http://localhost:5000/api/auth/reset-password', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            email: resetEmailValue,
                            otp: resetOtpValue,
                            newPassword,
                            confirmPassword
                        })
                    });

                    const data = await res.json();

                    if (data.success) {
                        resetPasswordForm.reset();
                        document.getElementById('loginEmail').value = '';
                        document.getElementById('loginPassword').value = '';
                        showLoginForm();
                        showMessage(data.message || 'Password updated successfully. You can now sign in.', true);
                        resetEmailValue = '';
                        resetOtpValue = '';
                    } else {
                        showMessage(data.message || 'Failed to reset password.', false);
                    }
                } catch (err) {
                    showMessage('Server error. Is Node.js running?', false);
                } finally {
                    setButtonState(btn, false, 'UPDATE PASSWORD');
                }
            });
        }

        // Password show/hide toggle
        document.querySelectorAll('.password-toggle').forEach((toggleBtn) => {
            toggleBtn.addEventListener('click', () => {
                const targetId = toggleBtn.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = toggleBtn.querySelector('i');

                if (!input || !icon) return;

                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';

                icon.classList.toggle('fa-eye', !isHidden);
                icon.classList.toggle('fa-eye-slash', isHidden);
                toggleBtn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            });
        });

        // Google Login Callback yahan aakhir mein add kiya gaya hai
        async function handleGoogleCredentialResponse(response) {
            showMessage('Verifying Google Account...', true);

            try {
                const res = await fetch('http://localhost:5000/api/auth/google', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ token: response.credential })
                });

                const data = await res.json();

                if(data.success) {
                    showMessage('Google Login Successful! Redirecting...', true);
                    localStorage.setItem('resume_token', data.token);
                    setTimeout(() => { window.location.href = "/dashboard"; }, 1000);
                } else {
                    showMessage(data.message, false);
                }
            } catch (err) {
                showMessage('Server error. Is Node.js running?', false);
            }
        }
    </script>
</body>
</html>
