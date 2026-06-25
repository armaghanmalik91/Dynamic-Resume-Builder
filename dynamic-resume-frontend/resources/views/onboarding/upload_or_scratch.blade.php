<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Options - Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        .card-selected {
            border-color: #f472b6 !important;
            background: linear-gradient(135deg, #ffffff, #fdf2f8) !important;
            box-shadow: 0 18px 35px -12px rgba(236, 72, 153, 0.35) !important;
        }

        .modal-overlay {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(6px);
        }

        .animation-fade-in {
            animation: fadeIn 0.25s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.96);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .selected-flow-template-preview {
            border: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #ffffff, #fff7fb);
            border-radius: 22px;
            padding: 14px;
            display: none;
            align-items: center;
            gap: 14px;
            max-width: 520px;
            margin: 0 auto 26px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.08);
        }

        .selected-flow-template-preview img {
            width: 76px;
            height: 96px;
            object-fit: contain;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            padding: 4px;
        }

        .selected-flow-template-placeholder {
            width: 76px;
            height: 96px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            display: none;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 22px;
        }

        .flow-shell {
            background:
                radial-gradient(circle at top left, rgba(236, 72, 153, 0.08), transparent 32%),
                radial-gradient(circle at bottom right, rgba(37, 99, 235, 0.08), transparent 30%),
                #ffffff;
        }

        /* PAGE SCROLL FIX: makes bottom buttons visible without changing old logic */
        html,
        body {
            min-height: 100%;
            height: auto !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        body {
            min-height: 100vh;
        }

        #mainContent {
            min-height: calc(100vh - 74px);
            justify-content: flex-start !important;
            overflow-y: visible !important;
            padding-top: 34px !important;
        }

        body > .absolute.bottom-0 {
            position: static !important;
            flex-shrink: 0;
        }

    
        /* ===== GHOST VIDEO-2 MATCH UI OVERRIDE - UI ONLY, OLD LOGIC UNCHANGED ===== */
        html,
        body {
            width: 100% !important;
            min-height: 100% !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            background: #ffffff !important;
            font-family: "Inter", "Poppins", Arial, sans-serif !important;
        }

        body {
            height: auto !important;
            min-height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-start !important;
        }

        /* Hide top navbar and selected-template strip to match the clean video layout */
        body > nav,
        #selectedFlowTemplatePreview {
            display: none !important;
        }

        .flow-shell {
            background: #ffffff !important;
            min-height: calc(100vh - 74px) !important;
            padding: 58px 120px 36px !important;
            justify-content: flex-start !important;
            align-items: center !important;
        }

        #mainContent {
            min-height: calc(100vh - 74px) !important;
            padding-top: 58px !important;
            padding-bottom: 26px !important;
            overflow: visible !important;
        }

        #mainContent > .max-w-5xl {
            max-width: 1660px !important;
            width: 100% !important;
            margin: 0 auto !important;
            text-align: center !important;
        }

        #mainContent h1 {
            font-size: clamp(42px, 3.5vw, 54px) !important;
            line-height: 1.1 !important;
            font-weight: 950 !important;
            letter-spacing: 0.04em !important;
            color: #0f172a !important;
            margin: 0 0 20px !important;
        }

        #mainContent h1 + p {
            font-size: clamp(22px, 1.7vw, 30px) !important;
            line-height: 1.35 !important;
            color: #111827 !important;
            font-weight: 450 !important;
            margin-bottom: 56px !important;
            letter-spacing: 0.02em !important;
        }

        /* Big two-card layout */
        #mainContent .flex.flex-col.sm\:flex-row.justify-center {
            max-width: 1660px !important;
            width: 100% !important;
            gap: 42px !important;
            padding: 0 !important;
            margin: 0 auto 76px !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            align-items: stretch !important;
        }

        .option-card {
            width: 100% !important;
            min-height: 405px !important;
            border: 1.8px solid #111827 !important;
            border-radius: 13px !important;
            background: #ffffff !important;
            box-shadow: none !important;
            padding: 92px 56px 56px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            position: relative !important;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease !important;
        }

        .option-card:hover {
            border-color: #00005f !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08) !important;
        }

        .option-card.card-selected {
            border-color: #00005f !important;
            border-width: 5px !important;
            background: #ffffff !important;
            box-shadow: 0 18px 44px rgba(0, 0, 95, 0.10) !important;
        }

        .option-card > div:first-child {
            position: absolute !important;
            top: 84px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: 86px !important;
            height: 86px !important;
            margin: 0 !important;
            border-radius: 50% !important;
            background: #fff2e9 !important;
            color: #cf159a !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 58px !important;
        }

        .option-card > div:first-child i {
            font-size: 58px !important;
            line-height: 1 !important;
            color: #cf159a !important;
            filter: none !important;
        }

        .option-card h3 {
            margin-top: 112px !important;
            margin-bottom: 22px !important;
            color: #0f172a !important;
            font-size: clamp(24px, 2.1vw, 34px) !important;
            line-height: 1.12 !important;
            font-weight: 950 !important;
            letter-spacing: .02em !important;
        }

        .option-card p {
            max-width: 600px !important;
            margin: 0 auto !important;
            color: #111827 !important;
            font-size: clamp(18px, 1.45vw, 27px) !important;
            line-height: 1.35 !important;
            font-weight: 450 !important;
            letter-spacing: .03em !important;
        }

        /* Bottom button row */
        #mainContent .border-t {
            max-width: 1660px !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 auto !important;
            border-top: 0 !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            align-items: center !important;
        }

        #mainContent .border-t a[href="/templates"] {
            justify-self: start !important;
            min-width: 244px !important;
            height: 72px !important;
            padding: 0 38px !important;
            border-radius: 999px !important;
            border: 3px solid #00005f !important;
            color: #00005f !important;
            background: #ffffff !important;
            font-size: 28px !important;
            font-weight: 950 !important;
            line-height: 1 !important;
            letter-spacing: .02em !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-transform: none !important;
            box-shadow: none !important;
        }

        #mainContent .border-t a[href="/templates"] i {
            margin-right: 18px !important;
            font-size: 28px !important;
        }

        #nextBtn {
            justify-self: end !important;
            min-width: 244px !important;
            height: 72px !important;
            padding: 0 42px !important;
            border-radius: 999px !important;
            background: #c90091 !important;
            color: #ffffff !important;
            font-size: 28px !important;
            font-weight: 950 !important;
            line-height: 1 !important;
            letter-spacing: .02em !important;
            text-transform: none !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        #nextBtn:disabled {
            background: #c90091 !important;
            color: #ffffff !important;
            opacity: .55 !important;
            cursor: not-allowed !important;
        }

        #nextBtn:not(:disabled):hover {
            background: #a8007c !important;
            transform: translateY(-2px) !important;
        }

        /* Footer like video target */
        body > .absolute.bottom-0 {
            position: static !important;
            width: 100% !important;
            min-height: 74px !important;
            padding: 16px 132px 18px !important;
            background: #ffffff !important;
            border: 0 !important;
            color: #0f172a !important;
            display: grid !important;
            grid-template-columns: 1fr auto !important;
            align-items: center !important;
            gap: 28px !important;
            z-index: 1 !important;
            font-size: 0 !important;
        }

        body > .absolute.bottom-0 > div:first-child {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 18px !important;
            flex-wrap: wrap !important;
        }

        body > .absolute.bottom-0 a {
            color: #0f172a !important;
            font-size: 18px !important;
            font-weight: 950 !important;
            line-height: 1 !important;
            letter-spacing: .03em !important;
        }

        body > .absolute.bottom-0 span {
            display: inline !important;
            color: #0f172a !important;
            font-size: 18px !important;
            font-weight: 400 !important;
        }

        body > .absolute.bottom-0 > div:last-child {
            color: #0f172a !important;
            font-size: 16px !important;
            font-weight: 450 !important;
            line-height: 1.2 !important;
            white-space: nowrap !important;
        }

        /* Modal/loading logic unchanged, only visual polish */
        #actionModal .bg-white {
            border-radius: 22px !important;
        }

        @media (max-width: 1100px) {
            .flow-shell {
                padding: 40px 22px 30px !important;
            }

            #mainContent .flex.flex-col.sm\:flex-row.justify-center {
                grid-template-columns: 1fr !important;
                gap: 24px !important;
            }

            .option-card {
                min-height: 290px !important;
                padding: 68px 26px 34px !important;
            }

            .option-card > div:first-child {
                top: 48px !important;
            }

            .option-card h3 {
                margin-top: 90px !important;
            }

            #mainContent .border-t {
                grid-template-columns: 1fr !important;
                gap: 18px !important;
            }

            #mainContent .border-t a[href="/templates"],
            #nextBtn {
                justify-self: center !important;
                width: min(320px, 100%) !important;
            }

            body > .absolute.bottom-0 {
                padding: 22px !important;
                grid-template-columns: 1fr !important;
                text-align: center !important;
            }

            body > .absolute.bottom-0 > div:first-child {
                justify-content: center !important;
            }
        }

    

        /* ===== GHOST FINAL SIZE + LOGO FIX - UI ONLY, OLD LOGIC UNCHANGED ===== */
        /* Navbar ko blue/dark se remove karke sirf old logo/icon visible rakha */
        body > nav {
            display: flex !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 50 !important;
            height: 68px !important;
            min-height: 68px !important;
            padding: 0 44px !important;
            background: #ffffff !important;
            border-bottom: 1px solid #eef2f7 !important;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04) !important;
            align-items: center !important;
            justify-content: flex-start !important;
        }

        body > nav > div {
            display: flex !important;
            align-items: center !important;
        }

        body > nav .text-xl {
            font-size: 23px !important;
            font-weight: 950 !important;
            letter-spacing: -0.04em !important;
            color: transparent !important;
            background: linear-gradient(90deg, #7c3aed, #ec4899) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            white-space: nowrap !important;
        }

        body > nav .fa-layer-group {
            font-size: 31px !important;
            color: #ec4899 !important;
            margin-right: 10px !important;
        }

        /* Selected template strip abhi bhi hidden rahega, logic same */
        #selectedFlowTemplatePreview {
            display: none !important;
        }

        .flow-shell {
            min-height: calc(100vh - 136px) !important;
            padding: 34px 110px 24px !important;
            background: #ffffff !important;
        }

        #mainContent {
            min-height: calc(100vh - 136px) !important;
            padding-top: 34px !important;
            padding-bottom: 24px !important;
        }

        #mainContent > .max-w-5xl {
            max-width: 1420px !important;
        }

        #mainContent h1 {
            font-size: clamp(34px, 2.7vw, 44px) !important;
            line-height: 1.12 !important;
            margin-bottom: 12px !important;
            letter-spacing: 0.02em !important;
        }

        #mainContent h1 + p {
            font-size: clamp(18px, 1.25vw, 23px) !important;
            line-height: 1.38 !important;
            margin-bottom: 38px !important;
            color: #111827 !important;
        }

        #mainContent .flex.flex-col.sm\:flex-row.justify-center {
            max-width: 1400px !important;
            gap: 34px !important;
            margin-bottom: 46px !important;
        }

        .option-card {
            min-height: 315px !important;
            padding: 66px 44px 38px !important;
            border-width: 1.8px !important;
            border-radius: 12px !important;
        }

        .option-card.card-selected {
            border-width: 4px !important;
        }

        .option-card > div:first-child {
            top: 50px !important;
            width: 68px !important;
            height: 68px !important;
            font-size: 42px !important;
            background: #fff2e9 !important;
            color: #cf159a !important;
        }

        .option-card > div:first-child i {
            font-size: 42px !important;
        }

        .option-card h3 {
            margin-top: 82px !important;
            margin-bottom: 16px !important;
            font-size: clamp(21px, 1.55vw, 28px) !important;
            line-height: 1.14 !important;
            letter-spacing: .01em !important;
        }

        .option-card p {
            max-width: 520px !important;
            font-size: clamp(15px, 1.08vw, 20px) !important;
            line-height: 1.38 !important;
            letter-spacing: .02em !important;
        }

        #mainContent .border-t {
            max-width: 1400px !important;
        }

        #mainContent .border-t a[href="/templates"],
        #nextBtn {
            min-width: 190px !important;
            height: 58px !important;
            padding: 0 30px !important;
            font-size: 22px !important;
            border-radius: 999px !important;
        }

        #mainContent .border-t a[href="/templates"] {
            border-width: 2.5px !important;
        }

        #mainContent .border-t a[href="/templates"] i {
            margin-right: 13px !important;
            font-size: 22px !important;
        }

        body > .absolute.bottom-0 {
            min-height: 68px !important;
            padding: 14px 110px !important;
            background: #ffffff !important;
        }

        body > .absolute.bottom-0 a,
        body > .absolute.bottom-0 span {
            font-size: 15px !important;
        }

        body > .absolute.bottom-0 > div:last-child {
            font-size: 14px !important;
        }

        @media (max-width: 1100px) {
            body > nav {
                height: 64px !important;
                min-height: 64px !important;
                padding: 0 24px !important;
            }

            .flow-shell {
                padding: 30px 22px 24px !important;
            }

            .option-card {
                min-height: 260px !important;
                padding: 58px 24px 30px !important;
            }

            .option-card > div:first-child {
                top: 38px !important;
            }
        }

</style>
</head>

<body class="bg-white font-sans text-gray-900 h-screen overflow-hidden flex flex-col justify-between">

    <nav class="bg-[#0F172A] border-b border-gray-700 py-3.5 px-8 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="flex items-center space-x-6">
            <div class="text-xl font-black text-white tracking-tight flex items-center cursor-pointer">
                <i class="fa-solid fa-layer-group text-pink-500 mr-2"></i>
                ResumeBuilder
            </div>
        </div>
    </nav>

    <div class="flex-grow flex flex-col items-center justify-center p-6 pb-28 flow-shell" id="mainContent">
        <div class="max-w-5xl w-full text-center">

            <div id="selectedFlowTemplatePreview" class="selected-flow-template-preview">
                <img id="selectedFlowTemplateImg" src="" alt="Selected template">

                <div id="selectedFlowTemplatePlaceholder" class="selected-flow-template-placeholder">
                    <i class="fa-solid fa-image"></i>
                </div>

                <div class="text-left min-w-0 flex-1">
                    <p class="text-[10px] font-black uppercase tracking-[0.22em] text-pink-500">
                        Selected Editable Template
                    </p>
                    <h3 id="selectedFlowTemplateName" class="text-lg font-black text-slate-900 truncate">
                        Template
                    </h3>
                    <p id="selectedFlowTemplateCategory" class="text-sm font-bold text-slate-500">
                        Category
                    </p>
                    <p id="selectedFlowTemplateLayout" class="text-[11px] mt-1 font-extrabold text-blue-600 uppercase tracking-wider">
                        Modern Sidebar Layout
                    </p>
                </div>

                <div class="hidden md:flex flex-col items-end">
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wider">
                        Ready
                    </span>
                    <span class="text-[11px] font-semibold text-slate-400 mt-2">
                        This layout will be used in builder
                    </span>
                </div>
            </div>

            <h1 class="text-[36px] font-black mb-2 leading-tight tracking-tight text-gray-900">
                Are you uploading an existing resume?
            </h1>

            <p class="text-slate-500 text-[15px] mb-10 font-medium">
                Just review, edit, and update it with new information
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-6 mb-10 max-w-4xl mx-auto px-4">
                <div
                    class="option-card bg-white border-2 border-slate-200 rounded-2xl p-8 cursor-pointer hover:border-pink-300 transition w-full sm:w-1/2 group relative text-left shadow-sm"
                    data-mode="upload"
                >
                    <div class="w-14 h-14 bg-pink-50 text-pink-500 rounded-2xl flex items-center justify-center text-2xl mb-5 group-hover:scale-105 transition">
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </div>

                    <h3 class="text-xl font-black text-gray-900 mb-2">
                        Yes, upload from my resume
                    </h3>

                    <p class="text-sm text-slate-500 font-medium leading-relaxed">
                        We'll give you expert guidance to fill out your info and enhance your resume, from start to finish
                    </p>
                </div>

                <div
                    class="option-card bg-white border-2 border-slate-200 rounded-2xl p-8 cursor-pointer hover:border-pink-300 transition w-full sm:w-1/2 group relative text-left shadow-sm"
                    data-mode="scratch"
                >
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-5 group-hover:scale-105 transition">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>

                    <h3 class="text-xl font-black text-gray-900 mb-2">
                        No, start from scratch
                    </h3>

                    <p class="text-sm text-slate-500 font-medium leading-relaxed">
                        We'll guide you through the whole process so your skills can shine
                    </p>
                </div>
            </div>

            <div class="flex justify-between items-center max-w-4xl mx-auto border-t border-slate-200 pt-6 px-4">
                <a
                    href="/templates"
                    class="px-6 py-2.5 border-2 border-blue-900 text-blue-900 font-extrabold rounded-full hover:bg-slate-50 transition text-xs tracking-wider inline-flex items-center uppercase select-none"
                >
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    <span>Back</span>
                </a>

                <button
                    id="nextBtn"
                    disabled
                    class="px-12 py-3 bg-gray-200 text-gray-400 font-extrabold text-xs uppercase tracking-wider rounded-full cursor-not-allowed transition min-w-[130px]"
                >
                    <span style="position:relative; z-index:2;">Next</span>
                </button>
            </div>
        </div>
    </div>

    <div id="actionModal" class="fixed inset-0 modal-overlay hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-7 max-w-md w-full text-center relative transform transition-all animation-fade-in">
            <button id="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h2 class="text-2xl font-black text-gray-900 mb-2 tracking-tight">
                Continue with selected template?
            </h2>

            <p class="text-sm text-slate-500 mb-6 font-semibold leading-relaxed">
                You can continue editing the current draft or create a fresh resume draft using this selected template.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-3">
                <button
                    id="btnCreateNew"
                    class="text-blue-800 font-bold hover:underline px-4 py-2 text-xs uppercase tracking-wide"
                >
                    Create new resume
                </button>

                <button
                    id="btnContinue"
                    class="px-6 py-3 bg-pink-500 text-white font-bold rounded-full shadow hover:bg-pink-600 transition text-xs uppercase tracking-wide"
                >
                    Continue editing
                </button>
            </div>
        </div>
    </div>

    <div id="loadingOverlay" class="fixed inset-0 bg-white z-[100] hidden flex-col items-center justify-center">
        <div class="relative w-64 h-80 bg-gray-50 border border-gray-100 shadow-sm rounded-2xl p-6 flex flex-col justify-center overflow-hidden">
            <div class="absolute inset-0 opacity-20 pointer-events-none p-6 space-y-4">
                <div class="w-1/2 h-3 bg-gray-400 rounded"></div>
                <div class="w-full h-1.5 bg-gray-300 rounded"></div>
                <div class="w-full h-1.5 bg-gray-300 rounded"></div>
                <div class="w-3/4 h-1.5 bg-gray-300 rounded"></div>
                <div class="w-1/3 h-3 bg-gray-400 rounded mt-6"></div>
                <div class="w-full h-1.5 bg-gray-300 rounded"></div>
            </div>

            <div class="relative z-10 w-full bg-white/90 p-4 rounded-xl shadow-lg text-center backdrop-blur-sm">
                <div id="successIcon" class="hidden w-12 h-12 bg-emerald-100 text-emerald-500 rounded-full items-center justify-center text-2xl mx-auto mb-3">
                    <i class="fa-solid fa-check"></i>
                </div>

                <h2 id="loadingText" class="text-base font-extrabold text-gray-800 mb-3">
                    Applying editable template...
                </h2>

                <div id="progressContainer" class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                    <div id="progressBar" class="h-full bg-emerald-500 w-0" style="transition: width 0.1s linear;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 right-0 left-0 bg-[#0F172A] border-t border-gray-800 py-4 px-8 flex justify-between items-center z-40 text-[11px] font-bold text-gray-400 select-none">
        <div class="flex space-x-6">
            <a href="/legal#terms" target="_blank" class="hover:text-pink-500 transition">TERMS & CONDITIONS</a>
            <span class="text-gray-700">|</span>
            <a href="/legal#privacy" target="_blank" class="hover:text-pink-500 transition">PRIVACY POLICY</a>
            <span class="text-gray-700">|</span>
            <a href="/legal#accessibility" target="_blank" class="hover:text-pink-500 transition">ACCESSIBILITY</a>
            <span class="text-gray-700">|</span>
            <a href="/legal#contact" target="_blank" class="hover:text-pink-500 transition">CONTACT US</a>
        </div>

        <div class="text-gray-500">
            &copy; 2026, Bold Limited. All rights reserved.
        </div>
    </div>

    <script>
        const API_BASE = "https://resume-backend-54se.onrender.com";

        const token = localStorage.getItem("resume_token");
        let resumeId = localStorage.getItem("current_resume_id");

        if (!token) {
            window.location.href = "/login";
        }

        const cards = document.querySelectorAll(".option-card");
        const nextBtn = document.getElementById("nextBtn");
        const actionModal = document.getElementById("actionModal");
        const closeModal = document.getElementById("closeModal");

        let selectedMode = null;

        function makeImageUrl(thumbnail) {
            if (!thumbnail) return "";

            const clean = String(thumbnail).trim();

            if (clean.startsWith("http://") || clean.startsWith("https://")) {
                return clean;
            }

            if (clean.startsWith("/uploads/")) {
                return API_BASE + clean;
            }

            if (clean.startsWith("uploads/")) {
                return API_BASE + "/" + clean;
            }

            return API_BASE + "/uploads/templates/" + clean;
        }

        function setSelectedTemplateBox(template) {
            const box = document.getElementById("selectedFlowTemplatePreview");
            const img = document.getElementById("selectedFlowTemplateImg");
            const placeholder = document.getElementById("selectedFlowTemplatePlaceholder");
            const name = document.getElementById("selectedFlowTemplateName");
            const category = document.getElementById("selectedFlowTemplateCategory");
            const layout = document.getElementById("selectedFlowTemplateLayout");

            if (!box || !template) return;

            const imageUrl = makeImageUrl(template.thumbnail_url || template.template_thumbnail_url);

            name.textContent = template.name || template.template_name || "Selected Template";
            category.textContent = template.category || template.template_category || "Professional";

            const layoutKey = template.layout_key || template.template_layout_key || "modern_sidebar";
            layout.textContent = layoutKey === "modern_sidebar"
                ? "Modern Sidebar Editable Layout"
                : layoutKey;

            if (imageUrl) {
                img.onload = function () {
                    img.style.display = "block";
                    placeholder.style.display = "none";
                };

                img.onerror = function () {
                    img.style.display = "none";
                    placeholder.style.display = "flex";
                };

                img.src = imageUrl;
            } else {
                img.style.display = "none";
                placeholder.style.display = "flex";
            }

            box.style.display = "flex";
        }

        async function loadSelectedTemplatePreviewForFlow() {
            const selectedTemplate = localStorage.getItem("selected_template");
            const currentResumeId = localStorage.getItem("current_resume_id");

            if (!selectedTemplate) return;

            try {
                const templateRes = await fetch(API_BASE + "/api/templates/all");
                const templateData = await templateRes.json();

                let selectedFromList = null;

                if (templateData.success && Array.isArray(templateData.templates)) {
                    selectedFromList = templateData.templates.find(function (t) {
                        return String(t.template_key) === String(selectedTemplate) ||
                               String(t.id) === String(selectedTemplate);
                    });
                }

                if (selectedFromList) {
                    setSelectedTemplateBox(selectedFromList);
                    return;
                }

                if (currentResumeId) {
                    const resumeRes = await fetch(API_BASE + `/api/resumes/get/${currentResumeId}`, {
                        headers: {
                            "Authorization": "Bearer " + token
                        }
                    });

                    const resumeData = await resumeRes.json();

                    if (resumeData.success && resumeData.resume) {
                        setSelectedTemplateBox({
                            name: resumeData.resume.template_name,
                            category: resumeData.resume.template_category,
                            thumbnail_url: resumeData.resume.template_thumbnail_url,
                            layout_key: resumeData.resume.layout_key || "modern_sidebar"
                        });
                    }
                }
            } catch (error) {
                console.error("Selected template flow preview failed:", error);
            }
        }

        loadSelectedTemplatePreviewForFlow();

        cards.forEach(function (card) {
            card.addEventListener("click", function () {
                cards.forEach(function (c) {
                    c.classList.remove("card-selected");
                });

                card.classList.add("card-selected");
                selectedMode = card.getAttribute("data-mode");

                nextBtn.disabled = false;
                nextBtn.classList.remove("bg-gray-200", "text-gray-400", "cursor-not-allowed");
                nextBtn.classList.add("bg-slate-900", "text-white", "hover:bg-slate-800", "shadow-md");
            });
        });

        nextBtn.addEventListener("click", function () {
            if (!selectedMode) return;

            if (selectedMode === "scratch") {
                actionModal.classList.remove("hidden");
                actionModal.classList.add("flex");
            } else {
                alert("Upload feature integration next!");
            }
        });

        closeModal.addEventListener("click", function () {
            actionModal.classList.add("hidden");
            actionModal.classList.remove("flex");
        });

        document.getElementById("btnContinue").addEventListener("click", function () {
            actionModal.classList.add("hidden");
            startAnimationAndRedirect();
        });

        document.getElementById("btnCreateNew").addEventListener("click", async function () {
            const btn = document.getElementById("btnCreateNew");
            btn.innerText = "Creating...";

            try {
                const response = await fetch(API_BASE + "/api/resumes/create", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + token
                    },
                    body: JSON.stringify({
                        template_id: localStorage.getItem("selected_template")
                    })
                });

                const data = await response.json();

                if (data.success) {
                    resumeId = data.resume_id;
                    localStorage.setItem("current_resume_id", resumeId);

                    actionModal.classList.add("hidden");
                    actionModal.classList.remove("flex");

                    startAnimationAndRedirect();
                } else {
                    alert("Error creating new resume: " + (data.message || "Unknown error"));
                    btn.innerText = "Create new resume";
                }
            } catch (error) {
                console.error("Backend error", error);
                alert("Backend error while creating new resume.");
                btn.innerText = "Create new resume";
            }
        });

        async function startAnimationAndRedirect() {
            try {
                await fetch(API_BASE + "/api/resumes/update-mode", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + token
                    },
                    body: JSON.stringify({
                        resume_id: resumeId,
                        mode: selectedMode
                    })
                });
            } catch (error) {
                console.error("Mode update failed:", error);
            }

            const loadingOverlay = document.getElementById("loadingOverlay");
            const mainContent = document.getElementById("mainContent");
            const progressBar = document.getElementById("progressBar");

            mainContent.classList.add("hidden");
            loadingOverlay.classList.remove("hidden");
            loadingOverlay.classList.add("flex");

            let progress = 0;

            const interval = setInterval(function () {
                progress += Math.floor(Math.random() * 10) + 2;

                if (progress >= 100) {
                    progress = 100;
                }

                progressBar.style.width = progress + "%";

                if (progress === 100) {
                    clearInterval(interval);

                    setTimeout(function () {
                        document.getElementById("progressContainer").classList.add("hidden");
                        document.getElementById("loadingText").classList.add("hidden");
                        document.getElementById("successIcon").classList.remove("hidden");
                        document.getElementById("successIcon").classList.add("flex");

                        setTimeout(function () {
                            sessionStorage.setItem("resume_preview_entrance", "fromScratch");
                            window.location.href = "/builder/contact";
                        }, 800);
                    }, 300);
                }
            }, 150);
        }
    </script>

<!-- GHOST FINAL UPDATE: footer links smaller one-line only -->
<style id="ghost-footer-one-line-smaller-only">
    body > .absolute.bottom-0 {
        min-height: 56px !important;
        padding: 10px 95px !important;
        grid-template-columns: minmax(0, 1fr) auto !important;
        gap: 18px !important;
        white-space: nowrap !important;
        overflow: hidden !important;
    }

    body > .absolute.bottom-0 > div:first-child {
        flex-wrap: nowrap !important;
        gap: 12px !important;
        min-width: 0 !important;
        overflow: hidden !important;
    }

    body > .absolute.bottom-0 a,
    body > .absolute.bottom-0 span {
        font-size: 12px !important;
        line-height: 1 !important;
        white-space: nowrap !important;
        letter-spacing: .02em !important;
    }

    body > .absolute.bottom-0 > div:last-child {
        font-size: 12px !important;
        line-height: 1 !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
    }
</style>


<!-- GHOST FINAL UPDATE: end buttons pink hover/click animation only -->
<style id="ghost-end-buttons-pink-animation-only">
    /* Back + Next bottom buttons animation */
    #mainContent .border-t a[href="/templates"],
    #nextBtn {
        position: relative !important;
        overflow: hidden !important;
        transition:
            transform .22s ease,
            box-shadow .22s ease,
            background .22s ease,
            color .22s ease,
            border-color .22s ease !important;
    }

    #mainContent .border-t a[href="/templates"]::before,
    #nextBtn::before {
        content: "" !important;
        position: absolute !important;
        inset: 0 !important;
        background: linear-gradient(90deg, #ec4899, #db1b83, #f97316) !important;
        opacity: 0 !important;
        transform: translateX(-100%) !important;
        transition: transform .38s ease, opacity .22s ease !important;
        z-index: 0 !important;
    }

    #mainContent .border-t a[href="/templates"] > *,
    #nextBtn {
        z-index: 1 !important;
    }

    #mainContent .border-t a[href="/templates"] {
        z-index: 1 !important;
    }

    #mainContent .border-t a[href="/templates"] i,
    #mainContent .border-t a[href="/templates"] span {
        position: relative !important;
        z-index: 2 !important;
    }

    #mainContent .border-t a[href="/templates"]:hover::before,
    #nextBtn:hover::before {
        opacity: 1 !important;
        transform: translateX(0) !important;
    }

    #mainContent .border-t a[href="/templates"]:hover {
        border-color: #ec4899 !important;
        color: #ffffff !important;
        transform: translateY(-3px) scale(1.025) !important;
        box-shadow: 0 18px 38px rgba(236,72,153,.26) !important;
    }

    #mainContent .border-t a[href="/templates"]:hover i {
        color: #ffffff !important;
        transform: translateX(-3px) !important;
        transition: transform .22s ease, color .22s ease !important;
    }

    #nextBtn:not(:disabled):hover {
        background: #ec4899 !important;
        color: #ffffff !important;
        transform: translateY(-3px) scale(1.025) !important;
        box-shadow: 0 18px 38px rgba(236,72,153,.28) !important;
    }

    #mainContent .border-t a[href="/templates"]:active,
    #nextBtn:not(:disabled):active {
        transform: translateY(0) scale(.96) !important;
        box-shadow: 0 8px 18px rgba(236,72,153,.18) !important;
    }

    #nextBtn:disabled:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    #nextBtn:disabled::before {
        display: none !important;
    }

    /* Footer links subtle pink hover/click */
    body > .absolute.bottom-0 a {
        position: relative !important;
        transition: color .2s ease, transform .2s ease, text-shadow .2s ease !important;
    }

    body > .absolute.bottom-0 a::after {
        content: "" !important;
        position: absolute !important;
        left: 0 !important;
        right: 0 !important;
        bottom: -4px !important;
        height: 2px !important;
        border-radius: 999px !important;
        background: #ec4899 !important;
        transform: scaleX(0) !important;
        transform-origin: left !important;
        transition: transform .22s ease !important;
    }

    body > .absolute.bottom-0 a:hover {
        color: #ec4899 !important;
        transform: translateY(-2px) !important;
        text-shadow: 0 0 14px rgba(236,72,153,.22) !important;
    }

    body > .absolute.bottom-0 a:hover::after {
        transform: scaleX(1) !important;
    }

    body > .absolute.bottom-0 a:active {
        transform: translateY(0) scale(.96) !important;
        color: #db1b83 !important;
    }
</style>

</body>
</html>