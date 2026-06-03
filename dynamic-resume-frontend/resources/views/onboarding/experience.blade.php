<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience Level - Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --purple: #a855f7;
            --pink: #ec4899;
            --dark: #07152f;
            --muted: #5f6b7a;
            --border: #9ca3af;
            --blue: #075985;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            width: 100%;
            min-height: 100%;
            background: #ffffff;
            color: var(--dark);
            font-family: Arial, Helvetica, sans-serif;
            overflow: hidden;
        }

        html.expanded-page,
        body.expanded-page {
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .page-shell {
            width: 100%;
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            flex-direction: column;
        }

        html.expanded-page .page-shell,
        body.expanded-page .page-shell {
            min-height: 112vh;
        }

        .top-header {
            height: 95px;
            padding: 0 130px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            flex-shrink: 0;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .brand-icon {
            width: 40px;
            height: 48px;
            position: relative;
            display: inline-block;
        }

        .brand-icon::before,
        .brand-icon::after {
            content: "";
            position: absolute;
            border-radius: 11px 12px 15px 11px;
            transform: skewY(-22deg);
        }

        .brand-icon::before {
            width: 27px;
            height: 42px;
            left: 4px;
            top: 2px;
            background: #8b5cf6;
        }

        .brand-icon::after {
            width: 25px;
            height: 36px;
            right: 3px;
            bottom: 2px;
            background: #ec4899;
            opacity: 0.92;
        }

        .brand-text {
            font-size: 27px;
            font-weight: 800;
            letter-spacing: 0.06em;
            color: #a855f7;
            line-height: 1;
        }

        .step-text {
            font-size: 18px;
            font-weight: 900;
            color: #5e6673;
            letter-spacing: 0.04em;
        }

        .main-area {
            flex: 1;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 120px 55px;
        }

        html.expanded-page .main-area,
        body.expanded-page .main-area {
            align-items: flex-start;
            padding-top: 45px;
            padding-bottom: 70px;
        }

        .content-card {
            width: 100%;
            max-width: 1580px;
            text-align: center;
            transform: translateY(-24px);
        }

        html.expanded-page .content-card,
        body.expanded-page .content-card {
            transform: translateY(0);
        }

        .go-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-bottom: 26px;
            color: #2563eb;
            text-decoration: none;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            transition: 0.2s ease;
        }

        .go-back:hover {
            color: #1d4ed8;
            transform: translateX(-3px);
        }

        .main-title {
            margin: 0;
            color: #07152f;
            font-size: 50px;
            line-height: 1.08;
            font-weight: 900;
            letter-spacing: 0.075em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            white-space: nowrap;
        }

        .info-icon {
            width: 27px;
            height: 27px;
            border-radius: 50%;
            background: #075985;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            line-height: 1;
            transform: translateY(-6px);
        }

        .subtitle {
            margin: 18px 0 84px;
            color: #07152f;
            font-size: 28px;
            line-height: 1.25;
            font-weight: 400;
            letter-spacing: 0.018em;
        }

        .options-row {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(5, minmax(230px, 1fr));
            gap: 46px;
            margin: 0 auto;
        }

        .option-btn {
            height: 88px;
            border: 1.6px solid #9ca3af;
            background: #ffffff;
            color: #07152f;
            border-radius: 13px;
            font-size: 27px;
            font-weight: 400;
            letter-spacing: 0.01em;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.22s ease;
            box-shadow: none;
            white-space: nowrap;
        }

        .option-btn:hover {
            border-color: #ec4899;
            background: #fff7fb;
            color: #db2777;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(236, 72, 153, 0.12);
        }

        .option-btn.active {
            border-color: #111827 !important;
            background: #11158f !important;
            color: #ffffff !important;
            box-shadow: 0 20px 38px rgba(17, 21, 143, 0.18);
        }

        .twenty-years-section {
            display: none;
            margin-top: 105px;
            padding-bottom: 44px;
            animation: smoothIn 0.35s ease;
        }

        .twenty-years-section.show {
            display: block;
        }

        @keyframes smoothIn {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .twenty-title {
            margin: 0 0 42px;
            color: #07152f;
            font-size: 46px;
            line-height: 1.1;
            font-weight: 900;
            letter-spacing: 0.055em;
        }

        .twenty-options {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 46px;
        }

        .twenty-btn {
            width: 300px;
            height: 88px;
            border: 1.6px solid #9ca3af;
            background: #ffffff;
            color: #07152f;
            border-radius: 13px;
            font-size: 27px;
            font-weight: 400;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: 0.22s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .twenty-btn:hover {
            border-color: #ec4899;
            background: #fff7fb;
            color: #db2777;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(236, 72, 153, 0.12);
        }

        .twenty-btn.active {
            border-color: #11158f !important;
            background: #11158f !important;
            color: #ffffff !important;
            box-shadow: 0 20px 38px rgba(17, 21, 143, 0.18);
        }

        .next-wrap {
            width: 100%;
            margin-top: 72px;
            display: flex;
            justify-content: flex-end;
        }

        .next-btn {
            min-width: 248px;
            height: 68px;
            border-radius: 999px;
            background: #ec4899;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 15px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            box-shadow: 0 20px 38px rgba(236, 72, 153, 0.28);
            transition: 0.22s ease;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(10px);
        }

        .next-btn.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0);
        }

        .next-btn:hover {
            background: #db2777;
            transform: translateY(-2px);
            box-shadow: 0 24px 44px rgba(236, 72, 153, 0.35);
        }

        .bottom-footer {
            height: 78px;
            padding: 0 132px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .footer-links {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 15px;
            font-weight: 900;
            letter-spacing: 0.025em;
            color: #07152f;
        }

        .footer-links a {
            color: #07152f;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .footer-links a:hover {
            color: #ec4899;
        }

        .footer-sep {
            color: #07152f;
            opacity: 0.8;
            font-weight: 500;
        }

        .copyright {
            color: #07152f;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.015em;
        }

        ::-webkit-scrollbar {
            width: 9px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        @media (max-width: 1450px) {
            .top-header {
                padding: 0 90px;
            }

            .main-area {
                padding-left: 80px;
                padding-right: 80px;
            }

            .main-title {
                font-size: 42px;
            }

            .subtitle {
                font-size: 24px;
                margin-bottom: 62px;
            }

            .options-row {
                gap: 26px;
                grid-template-columns: repeat(5, minmax(180px, 1fr));
            }

            .option-btn {
                font-size: 22px;
                height: 78px;
            }

            .twenty-years-section {
                margin-top: 82px;
            }

            .twenty-title {
                font-size: 38px;
            }

            .twenty-options {
                gap: 26px;
            }

            .twenty-btn {
                width: 280px;
                height: 78px;
                font-size: 22px;
            }

            .bottom-footer {
                padding: 0 90px;
            }
        }

        @media (max-width: 1050px) {
            html,
            body {
                overflow-y: auto;
            }

            .top-header {
                height: 90px;
                padding: 0 28px;
            }

            .brand-text {
                font-size: 22px;
            }

            .step-text {
                font-size: 15px;
            }

            .main-area,
            html.expanded-page .main-area,
            body.expanded-page .main-area {
                padding: 35px 24px 50px;
            }

            .content-card,
            html.expanded-page .content-card,
            body.expanded-page .content-card {
                transform: none;
            }

            .main-title {
                font-size: 32px;
                white-space: normal;
                letter-spacing: 0.04em;
            }

            .subtitle {
                font-size: 19px;
                margin-bottom: 34px;
            }

            .options-row {
                grid-template-columns: 1fr;
                max-width: 560px;
                gap: 15px;
            }

            .option-btn {
                height: 66px;
                font-size: 19px;
            }

            .twenty-years-section {
                margin-top: 45px;
            }

            .twenty-title {
                font-size: 30px;
            }

            .twenty-options {
                flex-direction: column;
                gap: 15px;
            }

            .twenty-btn {
                width: 100%;
                max-width: 560px;
                height: 66px;
                font-size: 19px;
            }

            .next-wrap {
                justify-content: center;
                margin-top: 32px;
            }

            .bottom-footer {
                height: auto;
                padding: 22px 24px;
                flex-direction: column;
                gap: 14px;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
                flex-wrap: wrap;
                font-size: 12px;
            }

            .copyright {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="page-shell">
        <header class="top-header">
            <a href="/" class="brand-wrap">
                <span class="brand-icon"></span>
                <span class="brand-text">Resume Builder</span>
            </a>

            <div class="step-text">Step 1 of 4</div>
        </header>

        <main class="main-area">
            <section class="content-card">
                <a href="/builder-intro" id="backBtn" class="go-back">
                    <i class="fa-solid fa-arrow-left"></i>
                    Go Back
                </a>

                <h1 class="main-title">
                    How long have you been working?
                    <span class="info-icon">
                        <i class="fa-solid fa-info"></i>
                    </span>
                </h1>

                <p class="subtitle">
                    We'll find the best templates for your experience level.
                </p>

                <div class="options-row" id="experience-options">
                    <button type="button" class="option-btn">No Experience</button>
                    <button type="button" class="option-btn">Less Than 3 Years</button>
                    <button type="button" class="option-btn">3-5 Years</button>
                    <button type="button" class="option-btn">5-10 Years</button>
                    <button type="button" class="option-btn">10+ Years</button>
                </div>

                <div id="twentyYearsSection" class="twenty-years-section">
                    <h2 class="twenty-title">
                        Do you have more than 20 years of experience?
                    </h2>

                    <div class="twenty-options">
                        <button type="button" class="twenty-btn" data-answer="Yes">Yes</button>
                        <button type="button" class="twenty-btn" data-answer="No">No</button>
                    </div>
                </div>

                <div class="next-wrap">
                    <a href="#" id="nextBtn" class="next-btn">
                        Next
                    </a>
                </div>
            </section>
        </main>

        <footer class="bottom-footer">
            <div class="footer-links">
                <a href="/legal">TERMS & CONDITIONS</a>
                <span class="footer-sep">|</span>
                <a href="/legal">PRIVACY POLICY</a>
                <span class="footer-sep">|</span>
                <a href="/legal">ACCESSIBILITY</a>
                <span class="footer-sep">|</span>
                <a href="/legal">CONTACT US</a>
            </div>

            <div class="copyright">
                &copy; 2026, Bold Limited. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
        const token = localStorage.getItem('resume_token');
        if (!token) {
            window.location.href = '/login';
        }

        const buttons = document.querySelectorAll('.option-btn');
        const twentyButtons = document.querySelectorAll('.twenty-btn');
        const nextBtn = document.getElementById('nextBtn');
        const twentyYearsSection = document.getElementById('twentyYearsSection');

        let selectedExperience = null;
        let moreThanTwentyYears = null;

        function resetNextButton() {
            nextBtn.innerHTML = 'Next';
            nextBtn.style.opacity = '1';
            nextBtn.style.pointerEvents = 'auto';
            nextBtn.classList.add('show');
        }

        function setLoadingOnButton(button) {
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...';
            button.style.opacity = '0.75';
            button.style.pointerEvents = 'none';
        }

        function enablePageScroll() {
            document.documentElement.classList.add('expanded-page');
            document.body.classList.add('expanded-page');
        }

        function disablePageScroll() {
            document.documentElement.classList.remove('expanded-page');
            document.body.classList.remove('expanded-page');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function scrollToTwentyYearsQuestion() {
            const targetTop = twentyYearsSection.getBoundingClientRect().top + window.pageYOffset - 120;

            window.scrollTo({
                top: targetTop,
                behavior: 'smooth'
            });
        }

        async function saveExperienceAndRedirect(redirectPath) {
            try {
                const payload = {
                    experience_level: selectedExperience
                };

                if (selectedExperience === "10+ Years") {
                    payload.more_than_20_years = moreThanTwentyYears;
                }

                const response = await fetch('http://localhost:5000/api/auth/onboarding', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (data.success) {
                    localStorage.setItem('selected_experience_level', selectedExperience);

                    if (selectedExperience === "10+ Years") {
                        localStorage.setItem('more_than_20_years', moreThanTwentyYears);
                    }

                    window.location.href = redirectPath;
                } else {
                    alert("Error: " + data.message);
                    resetNextButton();

                    twentyButtons.forEach(btn => {
                        btn.style.opacity = '1';
                        btn.style.pointerEvents = 'auto';
                        btn.innerHTML = btn.getAttribute('data-answer');
                    });
                }
            } catch (error) {
                alert("Server connection failed.");
                resetNextButton();

                twentyButtons.forEach(btn => {
                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                    btn.innerHTML = btn.getAttribute('data-answer');
                });
            }
        }

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                selectedExperience = btn.innerText.trim();
                localStorage.setItem('selected_experience_level', selectedExperience);

                twentyButtons.forEach(b => {
                    b.classList.remove('active');
                    b.style.opacity = '1';
                    b.style.pointerEvents = 'auto';
                    b.innerHTML = b.getAttribute('data-answer');
                });

                moreThanTwentyYears = null;

                if (selectedExperience === "10+ Years") {
                    enablePageScroll();
                    twentyYearsSection.classList.add('show');
                    nextBtn.classList.remove('show');

                    setTimeout(() => {
                        scrollToTwentyYearsQuestion();
                    }, 180);

                    return;
                }

                twentyYearsSection.classList.remove('show');
                disablePageScroll();

                nextBtn.classList.add('show');
            });
        });

        twentyButtons.forEach(btn => {
            btn.addEventListener('click', async () => {
                if (selectedExperience !== "10+ Years") {
                    return;
                }

                twentyButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                moreThanTwentyYears = btn.getAttribute('data-answer');

                setLoadingOnButton(btn);

                await saveExperienceAndRedirect("/templates");
            });
        });

        nextBtn.addEventListener('click', async (e) => {
            e.preventDefault();

            if (!selectedExperience) {
                alert("Please select your experience level first.");
                return;
            }

            if (selectedExperience === "10+ Years") {
                alert("Please select Yes or No first.");
                return;
            }

            nextBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...';
            nextBtn.style.opacity = '0.75';
            nextBtn.style.pointerEvents = 'none';

            if (selectedExperience === "No Experience" || selectedExperience === "Less Than 3 Years") {
                await saveExperienceAndRedirect("/student-status");
            } else {
                await saveExperienceAndRedirect("/templates");
            }
        });
    </script>
</body>
</html>