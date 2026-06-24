<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary - Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-blue: #073f70;
            --ghost-green: #34d399;
            --ghost-pink: #db1b83;
            --ghost-dark: #071022;
            --ghost-blue: #2563eb;
            --sidebar-width: 360px;
        }

        * { box-sizing: border-box; }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            color: #0f172a;
        }

        body {
            zoom: 0.75;
            width: 133.3333333333vw;
            height: 133.3333333333vh;
            min-width: 1680px;
            min-height: 995px;
            overflow: hidden;
            background: #ffffff;
        }

        /* SAME BLUE SIDEBAR STYLE AS SKILLS PAGE */
        .builder-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 360px;
            height: 133.3333333333vh;
            min-height: 133.3333333333vh;
            background: #073f70;
            color: #ffffff;
            overflow: hidden;
            z-index: 100;
            border-right: 1px solid rgba(255,255,255,.08);
            box-shadow: 18px 0 46px rgba(15,23,42,.10);
        }
        .sidebar-logo {
            position: absolute;
            top: 40px;
            left: 48px;
            width: 260px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            font-size: 23px;
            font-weight: 950;
            line-height: 1;
            letter-spacing: -0.04em;
            white-space: nowrap;
        }
        .sidebar-logo i {
            color: #ec4899;
            font-size: 29px;
            filter: drop-shadow(0 10px 22px rgba(236,72,153,.22));
        }
        .steps {
            position: absolute;
            top: 104px;
            left: 48px;
            width: 260px;
            height: 430px;
            overflow: visible;
        }
        .steps::before {
            content: "";
            position: absolute;
            left: 19px;
            top: 39px;
            width: 3px;
            height: 320px;
            border-radius: 999px;
            background: repeating-linear-gradient(to bottom, rgba(255,255,255,.22) 0px, rgba(255,255,255,.22) 9px, transparent 9px, transparent 17px);
        }
        .builder-sidebar .steps::after {
            content: "";
            position: absolute;
            left: 19px;
            top: 39px;
            width: 260px;
            width: 3px;
            height: 260px;
            border-radius: 999px;
            background: #ffffff;
            box-shadow: 0 0 8px rgba(255,255,255,.35);
            z-index: 1;
        }
        .step {
            position: absolute;
            left: 0;
            width: 270px;
            height: 39px;
            display: flex;
            align-items: center;
            gap: 13px;
            color: rgba(255,255,255,.92);
            font-size: 21px;
            line-height: 1;
            font-weight: 500;
            white-space: nowrap;
            letter-spacing: .01em;
            text-shadow: none;
        }
        .step span:last-child { font-weight: 500; color: rgba(255,255,255,.92); text-shadow: none; }
        .step:nth-child(1) { top: 0; }
        .step:nth-child(2) { top: 65px; }
        .step:nth-child(3) { top: 130px; }
        .step:nth-child(4) { top: 195px; }
        .step:nth-child(5) { top: 260px; }
        .step:nth-child(6) { top: 325px; }
        .step-circle {
            width: 39px;
            height: 39px;
            flex: 0 0 39px;
            border-radius: 999px;
            background: #0f172a;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24.5px;
            font-weight: 950;
            border: 3px solid rgba(226,232,240,.48);
            box-shadow: 0 0 0 3px rgba(15,23,42,.16);
            position: relative;
            z-index: 3;
        }
        .step.done .step-circle, .step.active .step-circle { background: #ffffff; color: #111827; }
        .step.done .step-circle { font-size: 0; }
        .step.done .step-circle::after { content: "✓"; font-size: 24.5px; font-weight: 950; color: #111827; }
        .step.active, .step.active span:last-child { color: #ffffff; font-weight: 950; text-shadow: 0 0 1px rgba(255,255,255,.18); }
        .step.active .step-circle { background: #ffffff; color: #111827; font-weight: 950; }
        .step-missing {
            position: absolute;
            left: 52px;
            top: 30px;
            color: #34d399;
            font-size: 12px;
            line-height: 2;
            font-weight: 400;
            letter-spacing: 0;
            white-space: nowrap;
            display: none;
        }
        .step.missing .step-missing { display: block; }
        .sidebar-progress {
            position: absolute;
            left: 48px;
            top: 518px;
            width: 264px;
            color: #ffffff;
        }
        .sidebar-progress-title {
            font-size: 21px;
            line-height: 1.05;
            font-weight: 980;
            letter-spacing: -0.04em;
            white-space: nowrap;
            margin-bottom: 10px;
            color: #ffffff;
        }
        .progress-row { display: flex; align-items: center; gap: 10px; }
        .progress-track { width: 205px; height: 10px; border-radius: 999px; background: #ffffff; overflow: hidden; flex: 0 0 205px; }
        .progress-fill { width: 70%; height: 100%; border-radius: 999px; background: #34d399; }
        .progress-number { font-size: 16px; line-height: 1; font-weight: 900; color: #ffffff; }
        .sidebar-footer { position: absolute; left: 48px; top: 570px; bottom: auto; width: 260px; color: #ffffff; }
        .sidebar-footer nav { display: flex; flex-direction: column; gap: 8px; }
        .sidebar-footer a { color: #34d399; text-decoration: none; font-size: 17.5px; line-height: 1.08; font-weight: 850; white-space: nowrap; letter-spacing: 0; transition: color .18s ease, text-shadow .18s ease; }
        .sidebar-footer a:hover { color: #ec4899; text-shadow: 0 0 12px rgba(236,72,153,.30); }
        .copyright { margin-top: 46px; max-width: 260px; color: #ffffff; font-size: 16px; line-height: 1.32; font-weight: 500; white-space: normal; }

        /* MAIN SUMMARY AREA */
        .summary-main {
            margin-left: 360px;
            width: calc(133.3333333333vw - 360px);
            height: 133.3333333333vh;
            background: #ffffff;
            overflow: hidden;
            position: relative;
            display: flex;
        }
        .summary-left {
            width: 60%;
            height: 100%;
            padding: 92px 54px 180px 48px;
            overflow-y: auto;
            background: #ffffff;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .summary-left::-webkit-scrollbar { display: none; width: 0; }
        .summary-left-inner { max-width: 920px; }
        .top-back { color: #2563eb; font-size: 18px; font-weight: 900; margin-bottom: 28px; letter-spacing: 0; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .top-back:hover { color: #2563eb; text-decoration: none; }
        .page-title { font-size: 42px; line-height: 1.12; font-weight: 950; letter-spacing: 0; margin: 0 0 14px; color: #071022; }
        .page-subtitle { font-size: 22px; line-height: 1.38; font-weight: 400; margin: 0 0 38px; color: #334155; }
        .summary-intro-view {
            display: block;
            margin-top: 16px;
            padding-top: 8px;
        }
        .summary-intro-title {
            font-size: 42px;
            line-height: 1.12;
            font-weight: 950;
            letter-spacing: 0;
            margin: 0 0 22px;
            color: #071022;
        }
        .summary-intro-title .nice-line {
            display: block;
            font-size: 26px;
            line-height: 1.2;
            margin-bottom: 12px;
        }
        .summary-intro-row {
            display: flex;
            align-items: flex-start;
            gap: 22px;
            max-width: 780px;
            margin-top: 28px;
        }
        .summary-intro-icon {
            width: 66px;
            height: 66px;
            border-radius: 999px;
            background: #ffd8c7;
            color: #db1b83;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 66px;
            font-size: 38px;
        }
        .summary-intro-copy {
            font-size: 22px;
            line-height: 1.45;
            font-weight: 400;
            color: #071022;
            margin: 0;
            max-width: 760px;
        }
        .summary-editor-view.hidden,
        .summary-intro-view.hidden {
            display: none !important;
        }
        body.summary-intro-active .summary-left {
            padding-top: 92px !important;
        }
        body.summary-intro-active .summary-right {
            padding-top: 92px !important;
        }
        body.summary-intro-active .preview-box {
            height: 560px !important;
            min-height: 560px !important;
            max-height: 560px !important;
            margin-top: 12px !important;
        }
        body.summary-intro-active .bottom-buttons {
            margin-top: 22px !important;
            transform: translateY(-6px) !important;
        }
        body.summary-intro-active .preview-btn,
        body.summary-intro-active .next-btn {
            height: 58px !important;
            font-size: 15px !important;
        }

        .summary-card { border: 1.8px solid #cbd5e1; border-radius: 18px; background: #ffffff; padding: 24px; box-shadow: 0 16px 38px rgba(15, 23, 42, .04); }
        .form-label { display:block; color:#071022; font-size:19px; font-weight:900; margin-bottom:9px; }
        .summary-textarea {
            width: 100%;
            min-height: 182px;
            border: 1.8px solid #94a3b8;
            border-radius: 10px;
            padding: 18px;
            font-size: 19px;
            line-height: 1.5;
            color: #071022;
            outline: none;
            resize: vertical;
            background: #ffffff;
        }
        .summary-textarea:focus { border-color:#0969da; box-shadow:0 0 0 2px rgba(9,105,218,.14); }
        .summary-tools { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-top:14px; }
        .counter { font-size:13px; color:#64748b; font-weight:800; }
        .save-mini-btn { height:42px; border:0; border-radius:999px; background:#db1b83; color:#fff; padding:0 24px; font-size:14px; font-weight:950; cursor:pointer; }
        .save-mini-btn:hover { background:#c91675; }
        .suggestion-box { margin-top:22px; padding:18px; border-radius:16px; background:#f8fafc; border:1px solid #e2e8f0; }
        .suggestion-title { font-size:14px; font-weight:950; color:#64748b; margin-bottom:12px; text-transform:uppercase; letter-spacing:.11em; }
        .summary-suggestion { width:100%; text-align:left; border:1.6px solid #cbd5e1; background:#fff; color:#334155; border-radius:14px; padding:14px 15px; font-size:14px; line-height:1.42; font-weight:800; cursor:pointer; transition:all .18s ease; margin-bottom:10px; }
        .summary-suggestion:hover { border-color:#2563eb; background:#eff6ff; color:#0f172a; transform:translateY(-1px); }

        .summary-right { width:40%; max-width:40%; flex:0 0 40%; height:133.3333333333vh; background:#ffffff; border-left:0; display:flex; flex-direction:column; align-items:center; justify-content:flex-start; padding:112px 30px 34px 26px; overflow:hidden; position:relative; }
        .preview-box { width:min(100%,560px); height:540px; min-height:540px; max-height:540px; padding:0; margin-top:24px; background:#fff; border:0; border-radius:0; box-shadow:none; overflow:hidden; display:flex; align-items:flex-start; justify-content:center; }
        .core-cv-scrollbox { width:100%; height:100%; overflow:hidden; display:flex; align-items:flex-start; justify-content:center; padding:0; }
        .core-cv-live { --cv-accent:#2563eb; width:430px; min-height:548px; height:auto; background:#fff; border-radius:6px; border:1px solid #f1f5f9; box-shadow:none; padding:30px 40px 34px; color:#111827; font-family:"Times New Roman", Georgia, serif; overflow:visible; flex:0 0 auto; }
        .core-cv-name { text-align:center; font-size:17px; font-weight:900; letter-spacing:.14em; text-transform:uppercase; color:#111827; line-height:1.18; margin-bottom:5px; font-family:Arial, Helvetica, sans-serif; }
        .core-cv-contact { text-align:center; font-size:6.8px; color:#4b5563; font-weight:700; line-height:1.45; padding-bottom:8px; margin-bottom:10px; border-bottom:1.4px solid var(--cv-accent); font-family:Arial, Helvetica, sans-serif; }
        .core-cv-section { margin-top:9px; }
        /* GHOST FINAL: green border only on intro fake template, not on editor template */
        .fake-summary-cv {
            --cv-accent: #7ca342;
            width: 430px;
            min-height: 548px;
            background: #ffffff;
            border: 1px solid #dbe3ef;
            padding: 30px 40px 34px;
            color: #111827;
            font-family: "Times New Roman", Georgia, serif;
            flex: 0 0 auto;
        }
        .fake-summary-cv .fake-current-title {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10.5px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #111827;
            margin-bottom: 6px;
        }
        .fake-summary-cv .fake-name {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 17px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #6b8e23;
            line-height: 1.18;
            margin-bottom: 4px;
        }
        .fake-summary-cv .fake-contact {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 6.8px;
            color: #4b5563;
            font-weight: 700;
            line-height: 1.45;
            padding-bottom: 8px;
            margin-bottom: 9px;
            border-bottom: 1.35px solid var(--cv-accent);
        }
        .fake-summary-cv .fake-section { margin-top: 8px; }
        .fake-summary-cv .fake-title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 7.4px;
            font-weight: 900;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: .045em;
            border-bottom: 1.35px solid var(--cv-accent);
            padding-bottom: 3px;
            margin-bottom: 5px;
        }
        .fake-summary-cv .fake-text,
        .fake-summary-cv li {
            font-size: 6.65px;
            line-height: 1.43;
            color: #374151;
        }
        .fake-summary-cv .fake-summary-highlight {
            border: 2px solid #34d399;
            background: rgba(52, 211, 153, 0.08);
            padding: 5px 7px 6px;
            margin-left: -7px;
            margin-right: -7px;
            border-radius: 2px;
        }
        .fake-summary-cv .fake-summary-highlight .fake-title { border-bottom-color: #34d399; }
        .fake-summary-cv .fake-grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:2px 14px; margin-top:2px; }
        .fake-summary-cv ul { margin:0; padding-left:11px; }
        .fake-summary-cv .fake-row { display:grid; grid-template-columns:1.1fr .75fr .75fr; gap:10px; margin-bottom:4px; align-items:start; }
        .fake-summary-cv .fake-bold { font-weight:900; color:#111827; }
        .fake-summary-cv .fake-muted { color:#4b5563; font-style:italic; }

        .core-cv-title { font-size:7.4px; font-weight:900; color:#111827; text-transform:uppercase; letter-spacing:.045em; border-bottom:1.35px solid var(--cv-accent); padding-bottom:3px; margin-bottom:5px; font-family:Arial, Helvetica, sans-serif; }
        .core-cv-text, .core-cv-li, .core-cv-list, .core-cv-editor-html { font-size:6.65px; line-height:1.43; color:#374151; }
        .core-cv-bold { font-weight:900; color:#111827; }
        .core-cv-muted { color:#4b5563; font-style:italic; }
        .core-cv-list { margin:0; padding-left:11px; }
        .core-cv-list li { margin-bottom:1.5px; }
        .core-cv-grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:2px 14px; margin-top:2px; }
        .core-cv-history-row, .core-cv-edu-row { display:grid; grid-template-columns:1.1fr .75fr .75fr; gap:10px; margin-bottom:4px; align-items:start; }
        .bottom-buttons { position:relative; z-index:4; max-width:390px; width:100%; gap:18px; padding:0; margin-top:10px; transform:translateY(-12px); display:flex; justify-content:center; align-items:center; }
        .preview-btn, .next-btn { height:54px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; text-align:center; white-space:nowrap; font-size:13px; font-weight:950; letter-spacing:.08em; padding:0 26px; text-transform:uppercase; cursor:pointer; transition:all .18s ease; }
        .preview-btn { min-width:138px; border:2px solid #0f172a; color:#0f172a; background:#fff; box-shadow:none; }
        .next-btn { min-width:188px; border:0; background:#ec4899; color:#fff; box-shadow:none; }
        .preview-btn:hover, .next-btn:hover { transform:translateY(-1px); }
        .summary-alert { position:fixed; top:22px; left:calc(360px + 50%); transform:translateX(-50%) translateY(-120%); min-width:420px; max-width:680px; padding:17px 22px; border-radius:12px; background:#fee2e2; border:1px solid #fecaca; color:#991b1b; font-size:16px; font-weight:900; line-height:1.35; box-shadow:0 18px 45px rgba(15,23,42,.18); opacity:0; pointer-events:none; z-index:9998; transition:all .24s ease; }
        .summary-alert.show { opacity:1; transform:translateX(-50%) translateY(0); }
        .summary-alert.success { background:#dcfce7; border-color:#bbf7d0; color:#166534; }
        .summary-preview-modal { position:fixed; inset:0; z-index:999999; display:none; align-items:center; justify-content:center; background:rgba(15,23,42,.72); padding:22px; }
        .summary-preview-modal.show { display:flex; }
        .summary-preview-card { position:relative; width:min(560px,94vw); height:min(780px,92vh); background:#fff; border-radius:16px; box-shadow:0 30px 80px rgba(0,0,0,.35); overflow-y:auto; overflow-x:hidden; padding:28px; }
        .summary-preview-card .core-cv-live { width:100%; min-height:720px; border:0; margin:0 auto; }
        .summary-preview-close { position:fixed; top:26px; right:28px; width:42px; height:42px; border:0; border-radius:999px; background:#fff; color:#0f172a; font-size:18px; cursor:pointer; box-shadow:0 12px 32px rgba(0,0,0,.22); z-index:1000000; }
        @media (max-width:1024px) {
            body { zoom:1; width:100%; height:auto; min-width:0; min-height:0; overflow:auto; }
            .builder-sidebar { position:relative; width:100%; height:82px; min-height:82px; box-shadow:none; }
            .steps, .sidebar-progress, .sidebar-footer { display:none; }
            .sidebar-logo { top:25px; left:24px; font-size:22px; }
            .sidebar-logo i { font-size:27px; }
            .summary-main { margin-left:0; width:100%; height:auto; min-height:calc(100vh - 82px); overflow:visible; display:block; }
            .summary-left { width:100%; height:auto; padding:34px 24px 100px; overflow:visible; }
            .summary-right { display:none; }
            .page-title { font-size:32px; }
            .page-subtitle { font-size:18px; }
        }
    

/* GHOST FINAL ONLY: fake education-style template on Summary intro; editor/live preview untouched */
.fake-summary-cv {
    --cv-accent: #7ca342;
    width: 430px !important;
    min-height: 548px !important;
    background: #ffffff !important;
    border: 1px solid #dbe3ef !important;
    padding: 30px 40px 34px !important;
    color: #111827 !important;
    font-family: "Times New Roman", Georgia, serif !important;
    flex: 0 0 auto !important;
    box-shadow: none !important;
}
.fake-summary-cv .fake-current-title {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10.5px;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #111827;
    margin-bottom: 6px;
}
.fake-summary-cv .fake-name {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 17px;
    font-weight: 900;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #6b8e23;
    line-height: 1.18;
    margin-bottom: 4px;
}
.fake-summary-cv .fake-contact {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 6.8px;
    color: #4b5563;
    font-weight: 700;
    line-height: 1.45;
    padding-bottom: 8px;
    margin-bottom: 9px;
    border-bottom: 1.35px solid var(--cv-accent);
}
.fake-summary-cv .fake-section { margin-top: 8px; }
.fake-summary-cv .fake-title {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 7.4px;
    font-weight: 900;
    color: #111827;
    text-transform: uppercase;
    letter-spacing: .045em;
    border-bottom: 1.35px solid var(--cv-accent);
    padding-bottom: 3px;
    margin-bottom: 5px;
}
.fake-summary-cv .fake-text,
.fake-summary-cv li {
    font-size: 6.65px;
    line-height: 1.43;
    color: #374151;
}
.fake-summary-cv .fake-summary-highlight {
    border: 2px solid #34d399 !important;
    background: rgba(52, 211, 153, 0.08) !important;
    padding: 5px 7px 6px !important;
    margin-left: -7px !important;
    margin-right: -7px !important;
    border-radius: 2px !important;
}
.fake-summary-cv .fake-summary-highlight .fake-title { border-bottom-color: #34d399 !important; }
.fake-summary-cv .fake-grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:2px 14px; margin-top:2px; }
.fake-summary-cv ul { margin:0; padding-left:11px; }
.fake-summary-cv .fake-row { display:grid; grid-template-columns:1.1fr .75fr .75fr; gap:10px; margin-bottom:4px; align-items:start; }
.fake-summary-cv .fake-bold { font-weight:900; color:#111827; }
.fake-summary-cv .fake-muted { color:#4b5563; font-style:italic; }
body.summary-intro-active .preview-box { overflow: hidden !important; }
body.summary-intro-active .core-cv-scrollbox { overflow: hidden !important; padding: 0 !important; }

</style>
</head>
<body>
    <aside class="builder-sidebar">
        <div class="sidebar-logo"><i class="fa-solid fa-layer-group"></i><span>Resume Builder</span></div>
        <div class="steps">
            <div id="headingStep" class="step done"><span class="step-circle">1</span><span>Heading</span></div>
            <div id="workHistoryStep" class="step"><span class="step-circle">2</span><span>Work history</span><span class="step-missing">Add missing information</span></div>
            <div id="educationStep" class="step"><span class="step-circle">3</span><span>Education</span><span class="step-missing">Add missing information</span></div>
            <div id="skillsStep" class="step"><span class="step-circle">4</span><span>Skills</span><span class="step-missing">Add missing information</span></div>
            <div id="summaryStep" class="step active"><span class="step-circle">5</span><span>Summary</span></div>
            <div class="step"><span class="step-circle">6</span><span>Finalize</span></div>
        </div>
        <div class="sidebar-progress">
            <div class="sidebar-progress-title">Resume Completeness:</div>
            <div class="progress-row"><div class="progress-track"><div class="progress-fill" id="progressFill"></div></div><div class="progress-number" id="progressNumber">70%</div></div>
        </div>
        <div class="sidebar-footer">
            <nav>
                <a href="/legal#terms" target="_blank">Terms & Conditions</a>
                <a href="/legal#privacy" target="_blank">Privacy Policy</a>
                <a href="/legal#accessibility" target="_blank">Accessibility</a>
                <a href="/legal#contact" target="_blank">Contact Us</a>
            </nav>
            <div class="copyright">© 2026, Bold Limited. All rights reserved.</div>
        </div>
    </aside>

    <div id="summaryAlert" class="summary-alert"></div>

    <main class="summary-main">
        <section class="summary-left">
            <div class="summary-left-inner">
                <a href="/builder/skills" class="top-back"><i class="fa-solid fa-arrow-left"></i> Go Back</a>

                <section id="summaryIntroView" class="summary-intro-view">
                    <h1 class="summary-intro-title">
                        <span class="nice-line">Nice job!</span>
                        Now let’s work on your Summary
                    </h1>
                    <div class="summary-intro-row">
                        <div class="summary-intro-icon"><i class="fa-solid fa-pencil"></i></div>
                        <p class="summary-intro-copy">
                            Your summary shows employers you’re right for their job.<br>
                            We’ll help you write a great one with expert content you can customize.
                        </p>
                    </div>
                </section>

                <section id="summaryEditorView" class="summary-editor-view hidden">
                    <h1 class="page-title">Now, let’s write your professional summary</h1>
                    <p class="page-subtitle">Add a short summary that highlights your strengths, experience, and career goal.</p>
                    <div class="summary-card">
                        <label class="form-label" for="summaryInput">Professional Summary</label>
                        <textarea id="summaryInput" class="summary-textarea" placeholder="e.g. Motivated software engineering student with strong teamwork, problem-solving and web development skills. Passionate about building clean, user-friendly applications and learning modern technologies."></textarea>
                        <div class="summary-tools">
                            <div id="summaryCounter" class="counter">0 characters</div>
                            <button id="saveSummaryBtn" type="button" class="save-mini-btn">Save Summary</button>
                        </div>
                        <div class="suggestion-box">
                            <div class="suggestion-title">Suggested summaries</div>
                            <button type="button" class="summary-suggestion">Motivated student with strong communication, teamwork, and problem-solving skills. Eager to apply academic knowledge in a professional environment and contribute to meaningful projects.</button>
                            <button type="button" class="summary-suggestion">Detail-oriented software engineering student with hands-on interest in web development, databases, and modern application design. Focused on building clean and user-friendly digital solutions.</button>
                            <button type="button" class="summary-suggestion">Dedicated learner with strong organizational skills, technical curiosity, and the ability to work effectively in teams. Seeking opportunities to grow through practical experience and professional challenges.</button>
                        </div>
                    </div>
                </section>
            </div>
        </section>

        <section class="summary-right">
            <div class="preview-box" id="previewBox"><div class="core-cv-scrollbox" id="previewHost"></div></div>
            <div class="bottom-buttons">
                <button id="btnPreview" type="button" class="preview-btn">Preview</button>
                <button id="btnNextSummary" type="button" class="next-btn">Next</button>
            </div>
        </section>
    </main>

    <div id="summaryPreviewModal" class="summary-preview-modal" aria-hidden="true">
        <button type="button" id="closeSummaryPreview" class="summary-preview-close"><i class="fa-solid fa-xmark"></i></button>
        <div class="summary-preview-card"><div id="summaryPreviewModalContent"></div></div>
    </div>

    <script>
        const API_BASE = "http://localhost:5000";
        const token = localStorage.getItem("resume_token");
        const resumeId = localStorage.getItem("current_resume_id");
        if (!token || !resumeId) window.location.href = "/login";

        const summaryInput = document.getElementById("summaryInput");
        const summaryCounter = document.getElementById("summaryCounter");
        let summaryText = "";
        let previewContact = null;
        let previewEducation = null;
        let previewWorkItems = [];
        let skills = [];
        let isSummaryIntroMode = true;

        function scoped(base){ return base + "_" + (resumeId || "no_resume"); }
        function cleanText(value){ return String(value || "").trim(); }
        function safeJson(key, fallback){ try { return JSON.parse(localStorage.getItem(key) || JSON.stringify(fallback)); } catch { return fallback; } }
        function esc(str){ return String(str || '').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'",'&#039;'); }
        function showAlert(message, type = "error"){
            const alertBox = document.getElementById("summaryAlert");
            alertBox.textContent = message;
            alertBox.classList.toggle("success", type === "success");
            alertBox.classList.add("show");
            setTimeout(() => alertBox.classList.remove("show"), 2300);
        }

        function loadSummaryFromLocal(){
            summaryText = localStorage.getItem(scoped("resume_summary_text")) || localStorage.getItem("resume_summary_text") || "";
            summaryInput.value = summaryText;
            updateCounter();
        }
        function saveSummaryToLocal(){
            summaryText = cleanText(summaryInput.value);
            localStorage.setItem(scoped("resume_summary_text"), summaryText);
            localStorage.setItem("resume_summary_text", summaryText);
            localStorage.setItem(scoped("resume_summary_completed"), summaryText ? "true" : "false");
            localStorage.setItem("resume_summary_completed", summaryText ? "true" : "false");
        }
        function updateCounter(){ summaryCounter.textContent = cleanText(summaryInput.value).length + " characters"; }

        async function loadSummaryFromDatabase(){
            try {
                const res = await fetch(`${API_BASE}/api/resumes/summary/${resumeId}`, { headers:{ "Authorization":"Bearer " + token } });
                const data = await res.json();
                if (data.success && data.summary && cleanText(data.summary.summary_text || data.summary.professional_summary)) {
                    summaryInput.value = data.summary.summary_text || data.summary.professional_summary;
                    saveSummaryToLocal();
                    renderPreview();
                }
            } catch(error){ console.error("Summary load failed:", error); }
        }
        async function saveSummaryToDatabase(){
            saveSummaryToLocal();
            try {
                const res = await fetch(`${API_BASE}/api/resumes/summary`, {
                    method:"POST",
                    headers:{ "Content-Type":"application/json", "Authorization":"Bearer " + token },
                    body: JSON.stringify({ resume_id: resumeId, summary_text: cleanText(summaryInput.value) })
                });
                const data = await res.json().catch(() => ({}));
                if (!res.ok || data.success === false) {
                    console.warn(data.message || "Summary API not ready, local backup kept.");
                    return true;
                }
                return true;
            } catch(error){
                console.error("Summary save failed, local backup kept:", error);
                return true;
            }
        }

        function isMeaningfulWork(work){ return !!(work && (work.job_title || work.employer || work.city || work.start_year || work.extra_info)); }
        function isMeaningfulEducation(edu){ return !!(edu && (edu.school_name || edu.school || edu.schoolName || edu.degree || edu.field_of_study || edu.field || edu.graduation_year || edu.year)); }
        function getSelectedEducationId(){ return localStorage.getItem(scoped("resume_education_selected_id")) || localStorage.getItem("resume_education_selected_id_" + resumeId) || localStorage.getItem(scoped("resume_selected_education_id")) || localStorage.getItem("resume_selected_education_id_" + resumeId) || localStorage.getItem("resume_selected_education_id") || localStorage.getItem("selected_education_id") || ""; }
        function getEducationList(){
            const keys = ["resume_education_summary_list_" + resumeId, scoped("resume_education_summary_list"), "resume_education_entries_" + resumeId, scoped("resume_education_entries"), "resume_education_list_" + resumeId];
            for (const key of keys){ const value = safeJson(key, null); if (Array.isArray(value) && value.length) return value; }
            return [];
        }
        function getSelectedEducationSnapshot(){
            /* Summary must use Education data only when Education Summary checkbox selected it. */
            const selectedId = getSelectedEducationId();
            if (!selectedId) return null;

            const list = getEducationList();
            if (Array.isArray(list) && selectedId) {
                const found = list.find(e => e && (String(e._ghost_id || e.id || e.education_id || "") === String(selectedId)));
                if (found) return found;
            }

            const snapshotKeys = [
                "resume_education_summary_snapshot_" + resumeId,
                scoped("resume_education_summary_snapshot"),
                "resume_selected_education_snapshot_" + resumeId,
                scoped("resume_selected_education_snapshot")
            ];
            for (const key of snapshotKeys){
                const snap = safeJson(key, null);
                if (isMeaningfulEducation(snap)) return snap;
            }
            return null;
        }
        function hasWorkHistoryMissingFlag(){
            return (
                localStorage.getItem(scoped("resume_work_history_missing_info")) === "true" ||
                localStorage.getItem("resume_work_history_missing_info_" + resumeId) === "true" ||
                localStorage.getItem("resume_work_history_missing_info") === "true" ||
                localStorage.getItem(scoped("resume_work_history_missing_information")) === "true" ||
                localStorage.getItem("resume_work_history_missing_information_" + resumeId) === "true" ||
                localStorage.getItem("resume_work_history_missing_information") === "true"
            );
        }

        function getSelectedWorkHistory(){
            /* Summary sidebar must only mark Work History completed when user selected/ticked it.
               If user skipped or did not tick WorkHistory summary, show Add missing information and keep preview empty. */
            if (hasWorkHistoryMissingFlag()) return [];

            const selectedList = safeJson(scoped("resume_work_history_selected_for_education"), null) ||
                safeJson("resume_work_history_selected_for_education_" + resumeId, null) ||
                safeJson("resume_work_history_selected_for_education", null);

            if (Array.isArray(selectedList) && selectedList.some(isMeaningfulWork)) {
                return selectedList.filter(isMeaningfulWork);
            }

            const scopedEntries = safeJson(scoped("resume_work_history_entries"), []);
            const globalEntries = safeJson("resume_work_history_entries", []);
            const entries = Array.isArray(scopedEntries) && scopedEntries.length ? scopedEntries : globalEntries;
            const indexes = safeJson(scoped("resume_work_history_use_this_indexes"), null) ||
                safeJson("resume_work_history_use_this_indexes_" + resumeId, null) ||
                safeJson("resume_work_history_use_this_indexes", []);

            if (Array.isArray(indexes) && indexes.length) {
                return indexes.map(i => entries[Number(i)]).filter(isMeaningfulWork);
            }

            return [];
        }
        function getContactSnapshot(){ return safeJson("resume_contact_snapshot_" + resumeId, null) || safeJson(scoped("resume_contact_snapshot"), null) || safeJson("resume_contact_snapshot", null) || safeJson("resume_contact_data_" + resumeId, null) || safeJson("resume_contact_data", null); }
        function normalizeSkillItem(skill){
            if (typeof skill === "string") {
                return { skill_name: cleanText(skill), skill_level: "" };
            }
            return {
                skill_name: cleanText(skill && (skill.skill_name || skill.name || skill.title || skill.label)),
                skill_level: cleanText(skill && (skill.skill_level || skill.level || skill.proficiency))
            };
        }

        function loadSkillsFromLocal(){
            const skillKeys = [
                scoped("resume_skills_backup"),
                "resume_skills_backup",
                "resume_skills_backup_" + resumeId,
                scoped("resume_skills"),
                "resume_skills_" + resumeId,
                "selected_skills_" + resumeId,
                "selected_skills",
                "skills"
            ];

            for (const key of skillKeys) {
                const value = safeJson(key, null);
                if (Array.isArray(value) && value.length > 0) {
                    skills = value.map(normalizeSkillItem).filter(s => s.skill_name);
                    if (skills.length > 0) {
                        localStorage.setItem(scoped("resume_skills_backup"), JSON.stringify(skills));
                        localStorage.setItem("resume_skills_backup", JSON.stringify(skills));
                        return;
                    }
                }
            }

            skills = [];
        }
        async function loadSkillsFromDatabase(){
            try {
                const res = await fetch(`${API_BASE}/api/resumes/skills/${resumeId}`, { headers:{ "Authorization":"Bearer " + token } });
                const data = await res.json();
                if (data.success && Array.isArray(data.skills) && data.skills.length > 0) {
                    const dbSkills = data.skills.map(normalizeSkillItem).filter(s => s.skill_name);
                    if (dbSkills.length > 0) {
                        skills = dbSkills;
                        localStorage.setItem(scoped("resume_skills_backup"), JSON.stringify(skills));
                        localStorage.setItem("resume_skills_backup", JSON.stringify(skills));
                        setupSidebarFlow();
                        renderPreview();
                    }
                } else {
                    setupSidebarFlow();
                    renderPreview();
                }
            } catch(error){ console.error("Skills load failed:", error); }
        }
        function contactDataForTemplate(){
            const c = previewContact || getContactSnapshot() || {};
            const fullName = cleanText(c.fullName) || cleanText(`${c.first_name || c.firstName || ''} ${c.last_name || c.lastName || ''}`) || 'YOUR NAME';
            return { fullName, city: cleanText(c.city) || cleanText(c.location || '').split(',')[0] || 'City', country: cleanText(c.country) || (cleanText(c.location || '').includes(',') ? cleanText(c.location).split(',').slice(1).join(',').trim() : 'Country'), postal: cleanText(c.postal_code || c.postal || c.zip), phone: cleanText(c.phoneFull || c.phone || c.phone_number), email: cleanText(c.email || c.email_address) };
        }
        function educationForTemplate(){
            const e = previewEducation || getSelectedEducationSnapshot();
            if (!isMeaningfulEducation(e)) {
                return { school: 'NILL', location: '', degree: '', field: '', date: '', detailsHtml: '' };
            }
            return { school: cleanText(e.school_name || e.school || e.schoolName) || 'School / College Name', location: cleanText(e.city || e.location || e.school_location), degree: cleanText(e.degree || e.qualification), field: cleanText(e.field_of_study || e.field || e.subject), date: cleanText([e.graduation_month || e.month, e.graduation_year || e.year || e.grad_year].filter(Boolean).join(' ')), detailsHtml: e.description || e.extra_info || e.coursework || e.highlights || '' };
        }
        function formatWorkMeta(work){
            const loc = [work.city, work.country].filter(Boolean).join(", ");
            const start = [work.start_month, work.start_year].filter(Boolean).join(" ");
            const end = work.currently_working ? "Current" : [work.end_month, work.end_year].filter(Boolean).join(" ");
            return [loc, [start,end].filter(Boolean).join(" - ")].filter(Boolean).join(" · ");
        }
        function stripHtml(html){ const div = document.createElement("div"); div.innerHTML = html || ""; return div.textContent || div.innerText || ""; }
        function setupSidebarFlow(){
            const workStep = document.getElementById("workHistoryStep");
            const educationStep = document.getElementById("educationStep");
            const skillsStep = document.getElementById("skillsStep");
            const hasWork = getSelectedWorkHistory().length > 0;
            const hasEdu = !!(getSelectedEducationId() && isMeaningfulEducation(getSelectedEducationSnapshot()));
            const hasSkills = skills.length > 0;
            workStep.classList.toggle("done", hasWork); workStep.classList.toggle("missing", !hasWork);
            educationStep.classList.toggle("done", hasEdu); educationStep.classList.toggle("missing", !hasEdu);
            skillsStep.classList.toggle("done", hasSkills); skillsStep.classList.toggle("missing", !hasSkills);
            let percent = 50;
            if (hasWork) percent += 10;
            if (hasEdu) percent += 10;
            if (hasSkills) percent += 10;
            if (cleanText(summaryInput.value)) percent += 10;
            percent = Math.min(percent, 90);
            document.getElementById("progressFill").style.width = percent + "%";
            document.getElementById("progressNumber").textContent = percent + "%";
        }
        function fakeSummaryIntroMarkup(modal = false){
            return `
                <div class="fake-summary-cv ${modal ? 'modal-size' : ''}">
                    <div class="fake-current-title">YOUR CURRENT / PREFERRED JOB TITLE</div>
                    <div class="fake-name">YOUR NAME</div>
                    <div class="fake-contact">Your address &nbsp;&nbsp;|&nbsp;&nbsp; Email address / Telephone number</div>

                    <section class="fake-section fake-summary-highlight">
                        <div class="fake-title">Career Objective</div>
                        <div class="fake-text">Use this space to express your career aspirations and goals, and quickly connect with an employer. Stress your most relevant experience and skills.</div>
                    </section>

                    <section class="fake-section">
                        <div class="fake-title">Professional Competencies</div>
                        <ul><li>Use these bullet points to define and explain what you believe to be your key skills and abilities.</li></ul>
                    </section>

                    <section class="fake-section">
                        <div class="fake-title">Personal Competencies</div>
                        <ul><li>Create a list of the personal skills and qualities that you will bring to a new employer.</li></ul>
                    </section>

                    <section class="fake-section">
                        <div class="fake-title">Areas of Expertise</div>
                        <div class="fake-grid-3">
                            <ul><li>Keyword</li><li>Keyword</li><li>Keyword</li></ul>
                            <ul><li>Keyword</li><li>Keyword</li><li>Keyword</li></ul>
                            <ul><li>Keyword</li><li>Keyword</li><li>Keyword</li></ul>
                        </div>
                    </section>

                    <section class="fake-section">
                        <div class="fake-title">Career History</div>
                        <div class="fake-row fake-text"><div><span class="fake-bold">YOUR MOST RECENT JOB TITLE</span><br>Duties</div><div></div><div class="fake-muted">Employment dates</div></div>
                        <ul><li>In concise sentences describe the daily tasks you undertook.</li></ul>
                        <div class="fake-row fake-text"><div><span class="fake-bold">PREVIOUS JOB TITLE</span><br>Duties</div><div></div><div class="fake-muted">Employment dates</div></div>
                        <div class="fake-row fake-text"><div><span class="fake-bold">PREVIOUS JOB TITLE</span><br>Duties</div><div></div><div class="fake-muted">Employment dates</div></div>
                    </section>

                    <section class="fake-section">
                        <div class="fake-title">Academic Qualifications</div>
                        <div class="fake-row fake-text"><div><span class="fake-bold">SCHOOL / COLLEGE NAME</span><br>Qualification / subject</div><div>Grade</div><div class="fake-muted">Study dates</div></div>
                        <div class="fake-row fake-text"><div><span class="fake-bold">UNIVERSITY NAME</span><br>Degree name</div><div>Grade</div><div class="fake-muted">Study dates</div></div>
                    </section>

                    <section class="fake-section"><div class="fake-title">References</div></section>
                </div>`;
        }


        function coreSummaryMarkup(modal = false){
            const c = contactDataForTemplate();
            const e = educationForTemplate();
            const work = (previewWorkItems && previewWorkItems[0]) || {};
            const skillNames = skills.map(s => cleanText(s.skill_name)).filter(Boolean).slice(0, 9);
            const col1 = skillNames.slice(0,3), col2 = skillNames.slice(3,6), col3 = skillNames.slice(6,9);
            const workTitle = cleanText(work.job_title) || 'Your Most Recent Job Title';
            const employer = cleanText(work.employer) || 'Employer name';
            const workDate = formatWorkMeta(work) || 'Employment date';
            const details = stripHtml(work.extra_info || '').slice(0, 170) || 'In concise sentences describe the daily tasks you undertook.';
            const summary = cleanText(summaryInput.value) || 'Use this area to express your career aspirations and goals, and quickly connect with an employer.';
            const renderCol = arr => `<ul class="core-cv-list">${arr.map(s => `<li>${esc(s)}</li>`).join('')}</ul>`;
            return `
                <div class="core-cv-live ${modal ? 'modal-size' : ''}">
                    <div class="core-cv-name">${esc(c.fullName)}</div>
                    <div class="core-cv-contact">${esc([c.city, c.country].filter(Boolean).join(', '))} ${esc(c.postal)} | ${esc(c.phone || 'Phone')} | ${esc(c.email || 'Email')}</div>
                    <section class="core-cv-section"><div class="core-cv-title">Professional Summary</div><div class="core-cv-text">${esc(summary)}</div></section>
                    <section class="core-cv-section"><div class="core-cv-title">Personal Competencies</div><div class="core-cv-text">Create a list of the personal skills and qualities that you will bring to a new employer.</div></section>
                    <section class="core-cv-section"><div class="core-cv-title">Areas of Expertise</div><div class="core-cv-grid-3">${renderCol(col1)}${renderCol(col2)}${renderCol(col3)}</div></section>
                    <section class="core-cv-section"><div class="core-cv-title">Career History</div><div class="core-cv-history-row core-cv-text"><div><span class="core-cv-bold">${esc(workTitle)}</span><br>Duties</div><div>${esc(employer)}</div><div class="core-cv-muted">${esc(workDate)}</div></div><div class="core-cv-text">${esc(details)}</div></section>
                    <section class="core-cv-section"><div class="core-cv-title">Academic Qualifications</div><div class="core-cv-edu-row core-cv-text"><div><span class="core-cv-bold">${esc(e.school)}</span><br>${esc(e.degree)} / ${esc(e.field)}</div><div>${esc(e.location)}</div><div class="core-cv-muted">${esc(e.date)}</div></div></section>
                    <section class="core-cv-section"><div class="core-cv-title">Education Highlights</div><div class="core-cv-text">${e.detailsHtml ? e.detailsHtml : 'Extra education details will automatically align inside this template.'}</div></section>
                </div>`;
        }
        function renderPreview(){
            const host = document.getElementById("previewHost");
            const markup = isSummaryIntroMode ? fakeSummaryIntroMarkup(false) : coreSummaryMarkup(false);
            const modalMarkup = isSummaryIntroMode ? fakeSummaryIntroMarkup(true) : coreSummaryMarkup(true);
            host.innerHTML = markup;
            document.getElementById("summaryPreviewModalContent").innerHTML = modalMarkup;
            updateCounter();
            setupSidebarFlow();
        }
        async function loadResumePreviewInfo(){
            previewContact = getContactSnapshot();
            try {
                const res = await fetch(`${API_BASE}/api/resumes/get/${resumeId}`, { headers:{ "Authorization":"Bearer " + token } });
                const data = await res.json();
                if (data.success && data.resume) previewContact = Object.assign({}, previewContact || {}, data.resume);
            } catch(error){ console.error("Resume preview load failed:", error); }
            previewEducation = getSelectedEducationSnapshot();
            previewWorkItems = getSelectedWorkHistory();
            renderPreview();
        }

        summaryInput.addEventListener("input", () => { saveSummaryToLocal(); renderPreview(); });
        document.querySelectorAll(".summary-suggestion").forEach(btn => btn.addEventListener("click", () => { summaryInput.value = btn.textContent.trim(); saveSummaryToLocal(); renderPreview(); }));
        document.getElementById("saveSummaryBtn").addEventListener("click", async () => { await saveSummaryToDatabase(); showAlert("Summary saved successfully.", "success"); });
        function showSummaryIntroMode(){
            isSummaryIntroMode = true;
            document.body.classList.add("summary-intro-active");
            document.getElementById("summaryIntroView").classList.remove("hidden");
            document.getElementById("summaryEditorView").classList.add("hidden");
            document.getElementById("btnNextSummary").textContent = "Next";
            renderPreview();
        }

        function showSummaryEditorMode(){
            isSummaryIntroMode = false;
            document.body.classList.remove("summary-intro-active");
            document.getElementById("summaryIntroView").classList.add("hidden");
            document.getElementById("summaryEditorView").classList.remove("hidden");
            document.getElementById("btnNextSummary").textContent = "Next: Finalize";
            renderPreview();
        }

        document.getElementById("btnNextSummary").addEventListener("click", async () => {
            if (isSummaryIntroMode) {
                showSummaryEditorMode();
                return;
            }
            await saveSummaryToDatabase();
            window.location.href = "/builder/finalize";
        });
        document.getElementById("btnPreview").addEventListener("click", () => { renderPreview(); const modal = document.getElementById("summaryPreviewModal"); modal.classList.add("show"); modal.setAttribute("aria-hidden", "false"); });
        document.getElementById("closeSummaryPreview").addEventListener("click", () => { const modal = document.getElementById("summaryPreviewModal"); modal.classList.remove("show"); modal.setAttribute("aria-hidden", "true"); });
        document.getElementById("summaryPreviewModal").addEventListener("click", e => { if (e.target && e.target.id === "summaryPreviewModal") e.currentTarget.classList.remove("show"); });

        loadSummaryFromLocal();
        loadSkillsFromLocal();
        setupSidebarFlow();
        loadResumePreviewInfo();
        loadSkillsFromDatabase();
        loadSummaryFromDatabase();
        showSummaryIntroMode();
    </script>

<!-- GHOST SUMMARY STRICT PREVIOUS-SECTIONS LOGIC APPLIED: WorkHistory/Education/Skills show tick only when selected/saved, otherwise Add missing information. -->
</body>
</html>
