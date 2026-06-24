<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three Easy Steps - Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --rb-dark: #0f172a;
            --rb-muted: #64748b;
            --rb-border: #e5e7eb;
            --rb-pink: #ec4899;
            --rb-purple: #7c3aed;
            --rb-blue: #2563eb;
        }

        * { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            background: #ffffff;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* ===== Custom page scrollbar / slide bar ===== */
        body::-webkit-scrollbar {
            width: 12px;
        }

        body::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-left: 1px solid #e5e7eb;
        }

        body::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #7c3aed, #ec4899);
            border-radius: 999px;
            border: 3px solid #f1f5f9;
        }

        body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #6d28d9, #db2777);
        }

        .rb-page-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(circle at 83% 22%, rgba(236, 72, 153, 0.055), transparent 24%),
                radial-gradient(circle at 78% 72%, rgba(124, 58, 237, 0.045), transparent 28%),
                #ffffff;
        }

        .rb-topbar {
            height: 76px;
            flex: 0 0 76px;
            background: #ffffff;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 52px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .rb-logo {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            font-size: 25px;
            font-weight: 950;
            letter-spacing: 0.005em;
            line-height: 1;
            color: transparent;
            background: linear-gradient(90deg, #7c3aed 0%, #ec4899 100%);
            -webkit-background-clip: text;
            background-clip: text;
            user-select: none;
            text-decoration: none;
        }

        /* Smaller clean layered logo - same Resume Builder brand feel */
        .rb-logo-icon {
            width: 32px;
            height: 30px;
            position: relative;
            flex: 0 0 32px;
            filter: drop-shadow(0 7px 13px rgba(124, 58, 237, 0.16));
        }

        .rb-logo-icon,
        .rb-logo-icon::before,
        .rb-logo-icon::after {
            background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
            border-radius: 5px;
            transform: skewY(-26deg);
        }

        .rb-logo-icon {
            height: 9px;
            margin-top: -9px;
        }

        .rb-logo-icon::before,
        .rb-logo-icon::after {
            content: "";
            position: absolute;
            left: 0;
            width: 32px;
            height: 9px;
        }

        .rb-logo-icon::before { top: 10px; opacity: .92; }
        .rb-logo-icon::after { top: 20px; opacity: .84; }

        .rb-back-link {
            color: #8b95a5;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .rb-back-link:hover { color: #111827; }

        .rb-main {
            flex: 1;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 26px 88px 28px;
        }

        .rb-card {
            width: min(100%, 1630px);
            min-height: min(700px, calc(100vh - 172px));
            border: 1px solid #f9a8d4;
            border-radius: 34px;
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 55%, #fff7fb 100%);
            box-shadow: 0 26px 70px rgba(236, 72, 153, 0.13);
            display: grid;
            grid-template-columns: 0.47fr 0.53fr;
            overflow: hidden;
            position: relative;
        }

        .rb-card::after {
            content: "";
            position: absolute;
            right: -160px;
            top: 50px;
            width: 430px;
            height: 430px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(124,58,237,0.055), rgba(236,72,153,0.055));
            filter: blur(20px);
            pointer-events: none;
        }

        .rb-left {
            position: relative;
            z-index: 2;
            padding: 76px 58px 54px 78px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }

        #builderIntroSelectedTemplate,
        .builder-intro-selected-template {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }

        .rb-title {
            font-size: clamp(54px, 5vw, 76px);
            line-height: 0.98;
            letter-spacing: -0.055em;
            color: #831843;
            font-weight: 950;
            margin: 0 0 54px;
        }

        .rb-steps {
            display: grid;
            gap: 42px;
            width: min(100%, 560px);
        }

        .rb-step {
            display: grid;
            grid-template-columns: 60px minmax(0, 1fr);
            align-items: start;
            gap: 25px;
        }

        .rb-step-number {
            width: 58px;
            height: 58px;
            border-radius: 999px;
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 900;
            flex-shrink: 0;
            transition: 0.25s ease;
        }

        .rb-step:hover .rb-step-number {
            background: #2563eb;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .rb-step-text {
            font-size: clamp(21px, 1.75vw, 30px);
            line-height: 1.28;
            color: #334155;
            font-weight: 900;
            letter-spacing: 0.005em;
            margin: 5px 0 0;
        }

        .rb-next {
            width: 218px;
            height: 58px;
            border-radius: 999px;
            background: #2563eb;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 950;
            letter-spacing: 0.12em;
            box-shadow: 0 18px 34px rgba(37, 99, 235, 0.26);
            transition: 0.22s ease;
            margin-top: 50px;
        }

        .rb-next:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 22px 40px rgba(37, 99, 235, 0.34);
        }

        .rb-right {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 74px 38px 28px;
            perspective: 1300px;
        }

        .steps-lottie-wrap {
            position: relative;
            width: min(100%, 650px);
            height: min(100%, 610px);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: stackEnter 0.72s cubic-bezier(0.19, 1, 0.22, 1) both;
        }

        .steps-lottie-card {
            width: min(560px, 92%);
            height: min(560px, 92%);
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(249, 168, 212, 0.85);
            box-shadow: 0 24px 55px rgba(131, 24, 67, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .steps-lottie-card video {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
            background: #ffffff;
        }

        .resume-stack {
            position: relative;
            width: min(100%, 650px);
            height: min(100%, 610px);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: stackEnter 0.72s cubic-bezier(0.19, 1, 0.22, 1) both;
        }

        @keyframes stackEnter {
            from { opacity: 0; transform: translateX(80px) scale(0.96); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }

        .resume-sheet {
            position: absolute;
            width: min(520px, 86%);
            height: min(610px, 95%);
            border-radius: 16px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 30px 70px rgba(15, 23, 42, 0.12);
            transition: 0.55s cubic-bezier(0.19, 1, 0.22, 1);
            overflow: hidden;
        }

        .resume-sheet.back-left {
            transform: translateX(-78px) translateY(12px) rotate(-7deg) scale(0.92);
            opacity: 0.52;
            z-index: 1;
            background: #fbfdff;
        }

        .resume-sheet.back-right {
            transform: translateX(78px) translateY(12px) rotate(7deg) scale(0.92);
            opacity: 0.50;
            z-index: 1;
            background: #fbfdff;
        }

        .resume-sheet.main-sheet {
            transform: translateX(34px) rotate(2deg);
            z-index: 4;
            box-shadow: 0 38px 90px rgba(15, 23, 42, 0.16);
        }

        .resume-stack:hover .back-left { transform: translateX(-108px) translateY(-2px) rotate(-9deg) scale(0.92); opacity: 0.64; }
        .resume-stack:hover .back-right { transform: translateX(104px) translateY(-2px) rotate(9deg) scale(0.92); opacity: 0.62; }
        .resume-stack:hover .main-sheet { transform: translateX(18px) translateY(-12px) rotate(0deg) scale(1.015); }

        .resume-inner {
            padding: 54px 58px;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .resume-head {
            padding-bottom: 22px;
            border-bottom: 3px solid #111827;
        }

        .resume-name {
            font-size: 31px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: 0.32em;
            color: #0f172a;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .resume-subtitle {
            margin-top: 10px;
            color: #9aa3b2;
            text-transform: uppercase;
            letter-spacing: 0.20em;
            font-size: 12px;
            font-weight: 900;
        }

        .resume-grid {
            display: grid;
            grid-template-columns: 0.34fr 0.66fr;
            gap: 36px;
            font-size: 13px;
            line-height: 1.7;
            color: #64748b;
        }

        .section-title {
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 16px;
            font-weight: 950;
            padding-bottom: 8px;
            border-bottom: 1px solid #d8dee8;
            margin-bottom: 12px;
        }

        .job-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            color: #111827;
            font-weight: 900;
        }

        .job-date { color: #9aa3b2; white-space: nowrap; }
        .job-place { color: #64748b; font-style: italic; font-weight: 700; margin-top: 4px; }

        .spell-chip {
            position: absolute;
            left: -43px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 8;
            height: 52px;
            min-width: 144px;
            padding: 0 18px;
            border-radius: 14px;
            background: rgba(255,255,255,0.96);
            border: 1px solid #eef2f7;
            box-shadow: 0 22px 45px rgba(15, 23, 42, 0.12);
            display: flex;
            align-items: center;
            gap: 12px;
            color: #6b7280;
            font-size: 14px;
            font-weight: 900;
            animation: chipFloat 2.6s ease-in-out infinite;
        }

        .spell-chip i { color: #a855f7; }

        @keyframes chipFloat {
            0%, 100% { transform: translateY(-50%) translateX(0); }
            50% { transform: translateY(calc(-50% - 8px)) translateX(5px); }
        }

        .ghost-lines .line {
            height: 12px;
            border-radius: 999px;
            background: #e2e8f0;
            margin-bottom: 12px;
        }
        .ghost-lines .line:nth-child(1) { width: 44%; }
        .ghost-lines .line:nth-child(2) { width: 72%; }
        .ghost-lines .line:nth-child(3) { width: 62%; }
        .ghost-lines .line:nth-child(4) { width: 86%; }
        .ghost-lines .line:nth-child(5) { width: 55%; }

        .rb-footer {
            height: 70px;
            flex: 0 0 70px;
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 92px;
            font-size: 14px;
            font-weight: 950;
            letter-spacing: 0.045em;
            color: #0f172a;
            text-transform: uppercase;
        }

        .rb-footer-links {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .rb-footer a {
            color: #0f172a;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .rb-footer a:hover { color: #ec4899; }

        .rb-footer-divider {
            width: 1px;
            height: 24px;
            background: #cbd5e1;
        }

        .rb-copy {
            color: #0f172a;
            text-transform: none;
            letter-spacing: 0;
            font-weight: 500;
            font-size: 14px;
        }

        @media (max-width: 1180px) {
            body { overflow: auto; }
            .rb-topbar { padding: 0 24px; }
            .rb-main { padding: 24px; }
            .rb-card { height: auto; min-height: 0; grid-template-columns: 1fr; }
            .rb-left { padding: 52px 34px 24px; }
            .rb-right { padding: 20px 30px 52px; min-height: 560px; }
            .rb-footer { height: auto; padding: 20px 28px; gap: 14px; flex-direction: column; align-items: flex-start; }
        }

        @media (max-width: 680px) {
            .rb-title { font-size: 44px; margin-bottom: 38px; }
            .rb-step { grid-template-columns: 50px 1fr; gap: 16px; }
            .rb-step-number { width: 48px; height: 48px; }
            .rb-step-text { font-size: 20px; }
            .resume-sheet { width: 92%; height: 500px; }
            .resume-inner { padding: 36px 34px; }
            .resume-grid { grid-template-columns: 1fr; gap: 20px; }
            .resume-name { font-size: 20px; letter-spacing: 0.20em; }
            .spell-chip { left: 18px; top: auto; bottom: 24px; transform: none; }
            .steps-lottie-card { width: 94%; height: 500px; }
        }
    

        /* GHOST FINAL LOGO + CENTER SIZE TUNE - UI ONLY */
        .rb-logo {
            gap: 13px !important;
            font-size: 30px !important;
            font-weight: 950 !important;
            letter-spacing: -0.025em !important;
            background: linear-gradient(90deg, #7c3aed 0%, #ec4899 100%) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            color: transparent !important;
        }

        .rb-logo-icon {
            width: 42px !important;
            height: 34px !important;
            flex: 0 0 42px !important;
            margin-top: 0 !important;
            position: relative !important;
            background: transparent !important;
            filter: drop-shadow(0 8px 16px rgba(124,58,237,.16)) !important;
            transform: none !important;
        }

        .rb-logo-icon,
        .rb-logo-icon::before,
        .rb-logo-icon::after {
            border-radius: 0 !important;
        }

        .rb-logo-icon::before,
        .rb-logo-icon::after {
            content: "" !important;
            position: absolute !important;
            left: 0 !important;
            width: 42px !important;
            height: 11px !important;
            background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%) !important;
            clip-path: polygon(50% 0%, 100% 38%, 50% 100%, 0% 38%) !important;
            transform: none !important;
        }

        .rb-logo-icon::before { top: 0 !important; opacity: 1 !important; }
        .rb-logo-icon::after { top: 22px !important; opacity: .90 !important; }

        .rb-logo-icon span,
        .rb-logo-icon::selection { background: transparent !important; }

        .rb-logo-icon {
            clip-path: none !important;
        }

        .rb-logo-icon::marker { display: none !important; }

        .rb-logo-icon {
            --middle-layer: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
        }

        .rb-logo-icon:after { top: 22px !important; }

        .rb-logo-icon {
            background-image: var(--middle-layer) !important;
            background-size: 42px 11px !important;
            background-repeat: no-repeat !important;
            background-position: 0 11px !important;
            clip-path: polygon(50% 11px, 100% 15px, 50% 22px, 0 15px) !important;
        }

        .rb-main {
            padding: 20px 82px 22px !important;
        }

        .rb-card {
            width: min(100%, 1460px) !important;
            min-height: min(625px, calc(100vh - 166px)) !important;
            border-radius: 30px !important;
        }

        .rb-left {
            padding: 58px 48px 46px 64px !important;
        }

        .rb-title {
            font-size: clamp(46px, 4.1vw, 64px) !important;
            margin-bottom: 38px !important;
        }

        .rb-steps {
            gap: 30px !important;
            width: min(100%, 505px) !important;
        }

        .rb-step {
            grid-template-columns: 52px minmax(0, 1fr) !important;
            gap: 18px !important;
        }

        .rb-step-number {
            width: 50px !important;
            height: 50px !important;
            font-size: 16px !important;
        }

        .rb-step-text {
            font-size: clamp(18px, 1.45vw, 24px) !important;
            line-height: 1.25 !important;
            margin-top: 4px !important;
        }

        .rb-next {
            width: 188px !important;
            height: 52px !important;
            font-size: 12px !important;
            margin-top: 38px !important;
        }

        .rb-right {
            padding: 34px 58px 34px 22px !important;
        }

        .steps-lottie-wrap {
            width: min(100%, 555px) !important;
            height: min(100%, 525px) !important;
        }

        .steps-lottie-card {
            width: min(485px, 90%) !important;
            height: min(485px, 90%) !important;
            border-radius: 20px !important;
        }

    

        /* GHOST FINAL EXACT DASHBOARD LOGO + SMALLER CENTER - UI ONLY */
        .rb-logo{
            display:flex!important;
            align-items:center!important;
            gap:12px!important;
            font-size:25px!important;
            font-weight:950!important;
            letter-spacing:-.045em!important;
            line-height:1!important;
            text-decoration:none!important;
            background:none!important;
            color:inherit!important;
        }
        .rb-logo span{
            background:linear-gradient(90deg,#7c3aed 0%,#ec4899 100%)!important;
            -webkit-background-clip:text!important;
            background-clip:text!important;
            color:transparent!important;
        }
        .rb-logo i{
            font-size:30px!important;
            background:linear-gradient(180deg,#7c3aed 0%,#ec4899 100%)!important;
            -webkit-background-clip:text!important;
            background-clip:text!important;
            color:transparent!important;
            -webkit-text-fill-color:transparent!important;
            filter:none!important;
            transform:none!important;
        }
        .rb-logo-icon{display:none!important;}

        .rb-main{padding:18px 82px 20px!important;}
        .rb-card{
            width:min(100%,1500px)!important;
            min-height:min(625px,calc(100vh - 170px))!important;
            border-radius:30px!important;
        }
        .rb-left{padding:56px 48px 44px 62px!important;}
        .rb-title{font-size:clamp(44px,4.2vw,64px)!important;margin-bottom:38px!important;}
        .rb-steps{gap:30px!important;width:min(100%,510px)!important;}
        .rb-step{grid-template-columns:52px minmax(0,1fr)!important;gap:20px!important;}
        .rb-step-number{width:50px!important;height:50px!important;font-size:16px!important;}
        .rb-step-text{font-size:clamp(18px,1.45vw,24px)!important;line-height:1.26!important;}
        .rb-next{width:190px!important;height:52px!important;margin-top:36px!important;font-size:13px!important;}
        .rb-right{padding:30px 58px 30px 20px!important;}
        .steps-lottie-wrap,.intro-video-wrap{width:min(100%,560px)!important;height:min(100%,520px)!important;}
        .steps-lottie-card,.intro-video-card{width:min(495px,90%)!important;height:min(495px,90%)!important;}



        /* GHOST FINAL: Next button pink style like screenshot - UI ONLY */
        .rb-next{
            background:#ff405c!important;
            color:#ffffff!important;
            border-radius:999px!important;
            box-shadow:0 18px 34px rgba(255,64,92,.24)!important;
        }
        .rb-next:hover{
            background:#ec4899!important;
            transform:translateY(-2px)!important;
            box-shadow:0 22px 42px rgba(236,72,153,.32)!important;
        }
        .rb-step:hover .rb-step-number{
            background:#ec4899!important;
            border-color:#f9a8d4!important;
            color:#ffffff!important;
        }

</style>
</head>

<body>
    <div class="rb-page-shell">
        <nav class="rb-topbar">
            <a href="/" class="rb-logo" aria-label="Resume Builder home">
                <i class="fa-solid fa-layer-group"></i>
                <span>Resume Builder</span>
            </a>

            <a href="/dashboard" class="rb-back-link">Back to Dashboard</a>
        </nav>

        <main class="rb-main">
            <section class="rb-card">
                <div class="rb-left">
                    <!-- Selected template hidden on this intro page -->
                    <div id="builderIntroSelectedTemplate" class="builder-intro-selected-template" aria-hidden="true"></div>

                    <h1 class="rb-title">
                        Just three<br>
                        easy steps
                    </h1>

                    <div class="rb-steps">
                        <div class="rb-step">
                            <div class="rb-step-number">1</div>
                            <p class="rb-step-text">Select a template from our library of professional designs</p>
                        </div>

                        <div class="rb-step">
                            <div class="rb-step-number">2</div>
                            <p class="rb-step-text">Build your resume with our industry-specific bullet points</p>
                        </div>

                        <div class="rb-step">
                            <div class="rb-step-number">3</div>
                            <p class="rb-step-text">Customize the details and wrap it up. You're ready to send!</p>
                        </div>
                    </div>

                    <a href="/experience-level" class="rb-next">Next</a>
                </div>

                <div class="rb-right">
                    <div class="steps-lottie-wrap">
                        <div class="steps-lottie-card">
                            <video
                                src="/videos/builder-intro-animation.mp4.mp4"
                                autoplay
                                muted
                                loop
                                playsinline>
                            </video>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="rb-footer">
            <div class="rb-footer-links">
                <a href="/legal#terms" target="_blank">Terms & Conditions</a>
                <span class="rb-footer-divider"></span>
                <a href="/legal#privacy" target="_blank">Privacy Policy</a>
                <span class="rb-footer-divider"></span>
                <a href="/legal#accessibility" target="_blank">Accessibility</a>
                <span class="rb-footer-divider"></span>
                <a href="/legal#contact" target="_blank">Contact Us</a>
            </div>

            <div class="rb-copy">&copy; 2026, Bold Limited. All rights reserved.</div>
        </footer>
    </div>

    <script>
        if (!localStorage.getItem('resume_token')) {
            window.location.href = '/login';
        }
    </script>
</body>
</html>
