<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Status - Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --purple: #a855f7;
            --pink: #ec4899;
            --dark: #07152f;
            --muted: #5f6b7a;
            --border: #9ca3af;
            --blue: #2563eb;
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
            overflow-x: hidden;
            overflow-y: auto;
        }

        body.compact-page {
            overflow-y: hidden;
        }

        body.expanded-page {
            overflow-y: auto;
        }

        .page-shell {
            width: 100%;
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            flex-direction: column;
        }

        .top-header {
            height: 95px;
            padding: 0 130px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border-bottom: 1px solid #eef2f7;
            flex-shrink: 0;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            white-space: nowrap;
        }

        .brand-wrap i {
            font-size: 30px;
            background: linear-gradient(180deg, #7c3aed 0%, #ec4899 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
            filter: none;
            line-height: 1;
        }

        .brand-text {
            font-size: 27px;
            font-weight: 950;
            letter-spacing: -0.045em;
            background: linear-gradient(90deg, #7c3aed 0%, #ec4899 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
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
            padding: 0 120px 50px;
        }

        body.expanded-page .main-area {
            align-items: flex-start;
            padding-top: 34px;
            padding-bottom: 42px;
        }

        .content-card {
            width: 100%;
            max-width: 1280px;
            text-align: center;
            transform: translateY(-56px);
        }

        body.expanded-page .content-card {
            transform: translateY(0);
        }

        .go-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-bottom: 30px;
            color: var(--blue);
            text-decoration: none;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 0.02em;
            transition: 0.2s ease;
        }

        .go-back:hover {
            color: #1d4ed8;
            transform: translateX(-3px);
        }

        .main-title {
            margin: 0 0 30px;
            color: #07152f;
            font-size: 48px;
            line-height: 1.08;
            font-weight: 900;
            letter-spacing: 0.045em;
        }

        .student-options {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 22px;
            margin: 0 auto 72px;
        }

        body.expanded-page .student-options {
            margin-bottom: 36px;
        }

        .student-btn {
            width: 185px;
            height: 64px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #1f2937;
            border-radius: 13px;
            font-size: 23px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.22s ease;
        }

        .student-btn:hover {
            border-color: #ec4899;
            background: #fff7fb;
            color: #db2777;
            transform: translateY(-2px);
        }

        .student-btn.btn-selected {
            border-color: #ec4899 !important;
            background: #fdf2f8 !important;
            color: #db2777 !important;
            box-shadow: 0 18px 34px rgba(236, 72, 153, 0.16);
        }

        .education-section {
            display: none;
            margin-top: -18px;
            animation: fadeIn 0.35s ease-in-out;
        }

        .education-section.show {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .education-title {
            margin: 0;
            color: #07152f;
            font-size: 32px;
            line-height: 1.2;
            font-weight: 900;
            letter-spacing: 0.02em;
        }

        .education-subtitle {
            margin: 12px 0 30px;
            color: #64748b;
            font-size: 16px;
            font-weight: 600;
        }

        .education-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1040px;
            margin: 0 auto 22px;
        }

        .edu-btn {
            min-height: 76px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #1f2937;
            border-radius: 14px;
            padding: 16px 20px;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.28;
            cursor: pointer;
            transition: 0.22s ease;
        }

        .edu-btn:hover {
            border-color: #ec4899;
            background: #fff7fb;
            color: #db2777;
            transform: translateY(-2px);
        }

        .edu-btn.edu-selected {
            border-color: #ec4899 !important;
            background: #fdf2f8 !important;
            color: #db2777 !important;
            box-shadow: 0 16px 32px rgba(236, 72, 153, 0.14);
        }

        .education-bottom-row {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .education-bottom-row .edu-btn {
            width: 320px;
        }

        .prefer-link {
            display: inline-block;
            margin-top: 8px;
            color: #2563eb;
            font-size: 13px;
            font-weight: 900;
            text-decoration: underline;
            transition: 0.2s ease;
        }

        .prefer-link:hover {
            color: #1d4ed8;
        }

        .divider-line {
            width: 100%;
            height: 1px;
            background: #eef2f7;
            margin: 0 0 22px;
        }

        body.expanded-page .divider-line {
            margin-top: 22px;
        }

        .next-wrap {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            padding-right: 70px;
        }

        .next-btn {
            min-width: 175px;
            height: 66px;
            border: none;
            border-radius: 999px;
            background: #ec4899;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 0.02em;
            cursor: pointer;
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

        .next-btn:disabled {
            opacity: 0.75;
            cursor: not-allowed;
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

        body.expanded-page .bottom-footer {
            margin-top: auto;
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

        @media (max-width: 1200px) {
            .top-header {
                padding: 0 70px;
            }

            .main-area {
                padding-left: 70px;
                padding-right: 70px;
            }

            .content-card {
                transform: translateY(-35px);
            }

            body.expanded-page .content-card {
                transform: translateY(0);
            }

            .main-title {
                font-size: 40px;
            }

            .education-grid {
                max-width: 920px;
                grid-template-columns: repeat(3, minmax(210px, 1fr));
                gap: 18px;
            }

            .bottom-footer {
                padding: 0 70px;
            }
        }

        @media (max-width: 900px) {
            body,
            body.compact-page,
            body.expanded-page {
                overflow-y: auto;
            }

            .top-header {
                height: 88px;
                padding: 0 24px;
            }

            .brand-text {
                font-size: 22px;
            }

            .step-text {
                font-size: 15px;
            }

            .main-area,
            body.expanded-page .main-area {
                padding: 30px 22px 50px;
                align-items: flex-start;
            }

            .content-card,
            body.expanded-page .content-card {
                transform: none;
            }

            .main-title {
                font-size: 32px;
            }

            .student-options {
                flex-direction: column;
                margin-bottom: 45px;
            }

            body.expanded-page .student-options {
                margin-bottom: 28px;
            }

            .student-btn {
                width: 100%;
                max-width: 330px;
            }

            .education-grid {
                grid-template-columns: 1fr;
                max-width: 560px;
            }

            .education-bottom-row {
                flex-direction: column;
            }

            .education-bottom-row .edu-btn {
                width: 100%;
            }

            .next-wrap {
                justify-content: center;
                padding-right: 0;
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

<body class="compact-page">
    <div class="page-shell">
        <header class="top-header">
            <a href="/" class="brand-wrap">
                <i class="fa-solid fa-layer-group"></i>
                <span class="brand-text">Resume Builder</span>
            </a>

            <div class="step-text">Step 2 of 4</div>
        </header>

        <main class="main-area">
            <section class="content-card">
                <a href="/experience-level" class="go-back">
                    <i class="fa-solid fa-arrow-left"></i>
                    Go Back
                </a>

                <h1 class="main-title">Are you a student?</h1>

                <div class="student-options">
                    <button id="btnYes" type="button" class="student-btn">
                        Yes
                    </button>

                    <button id="btnNo" type="button" class="student-btn">
                        No
                    </button>
                </div>
                <br>
                <br>

                <div id="educationSection" class="education-section">
                    <h2 class="education-title">
                        What education level are you currently pursuing?
                    </h2>

                    <p class="education-subtitle">
                        Select the highest level you are working toward so we can organize your resume correctly.
                    </p>

                    <div class="education-grid" id="educationGrid">
                        <button type="button" class="edu-btn">
                            Post-Secondary Certificate or High School diploma
                        </button>

                        <button type="button" class="edu-btn">
                            Technical or Vocational
                        </button>

                        <button type="button" class="edu-btn">
                            Related Courses
                        </button>

                        <button type="button" class="edu-btn">
                            Certificates or diplomas
                        </button>

                        <button type="button" class="edu-btn">
                            Associates
                        </button>

                        <button type="button" class="edu-btn">
                            Bachelors
                        </button>

                        <div class="education-bottom-row">
                            <button type="button" class="edu-btn">
                                Masters or Specialized
                            </button>

                            <button type="button" class="edu-btn">
                                Doctoral or J.D.
                            </button>
                        </div>
                    </div>

                    <button id="preferNotToAnswer" type="button" class="prefer-link">
                        Prefer not to answer
                    </button>
                </div>

                <div class="divider-line"></div>

                <div class="next-wrap">
                    <button id="nextBtn" type="button" class="next-btn">
                        Next
                    </button>
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
        if (!token) window.location.href = '/login';

        const btnYes = document.getElementById('btnYes');
        const btnNo = document.getElementById('btnNo');
        const educationSection = document.getElementById('educationSection');
        const eduButtons = document.querySelectorAll('.edu-btn');
        const nextBtn = document.getElementById('nextBtn');
        const preferNotToAnswer = document.getElementById('preferNotToAnswer');

        let isStudent = null;
        let educationLevel = null;

        function showNextButton() {
            nextBtn.classList.add('show');
        }

        function enableExpandedScroll() {
            document.body.classList.remove('compact-page');
            document.body.classList.add('expanded-page');
        }

        function enableCompactView() {
            document.body.classList.remove('expanded-page');
            document.body.classList.add('compact-page');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Yes / No Toggle Logic
        btnYes.addEventListener('click', () => {
            btnYes.classList.add('btn-selected');
            btnNo.classList.remove('btn-selected');

            isStudent = true;
            educationSection.classList.add('show');

            enableExpandedScroll();
            showNextButton();
        });

        btnNo.addEventListener('click', () => {
            btnNo.classList.add('btn-selected');
            btnYes.classList.remove('btn-selected');

            isStudent = false;
            educationLevel = null;

            educationSection.classList.remove('show');
            eduButtons.forEach(b => b.classList.remove('edu-selected'));

            enableCompactView();
            showNextButton();
        });

        // Education Level Selection Logic
        eduButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                eduButtons.forEach(b => b.classList.remove('edu-selected'));
                btn.classList.add('edu-selected');
                educationLevel = btn.innerText.trim();

                showNextButton();
            });
        });

        // Abstracted Submit API Call logic function to prevent repetition
        async function submitOnboardingData() {
            try {
                const response = await fetch('http://localhost:5000/api/auth/onboarding', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify({
                        is_student: isStudent,
                        education_level: educationLevel
                    })
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = "/templates";
                } else {
                    alert("Error: " + data.message);
                    resetButton();
                }
            } catch (error) {
                alert("Server connection failed.");
                resetButton();
            }
        }

        // Prefer not to answer action hook acts exactly like next step loader triggers
        preferNotToAnswer.addEventListener('click', async () => {
            eduButtons.forEach(b => b.classList.remove('edu-selected'));
            educationLevel = "Prefer not to answer";

            nextBtn.classList.add('show');
            nextBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...';
            nextBtn.disabled = true;

            await submitOnboardingData();
        });

        // Save and Proceed Logic for Next Button
        nextBtn.addEventListener('click', async () => {
            if (isStudent === null) {
                alert("Please let us know if you are a student.");
                return;
            }

            if (isStudent && !educationLevel) {
                alert("Please select your education level.");
                return;
            }

            nextBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...';
            nextBtn.disabled = true;

            await submitOnboardingData();
        });

        function resetButton() {
            nextBtn.innerHTML = 'Next';
            nextBtn.disabled = false;
            nextBtn.classList.add('show');
        }
    </script>
</body>
</html>