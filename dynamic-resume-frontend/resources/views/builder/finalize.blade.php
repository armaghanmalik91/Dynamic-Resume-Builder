<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalize - Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-blue: #073f70;
            --ghost-green: #34d399;
            --ghost-pink: #db1b83;
            --ghost-dark: #071022;
            --ghost-blue: #2563eb;
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

        /* SAME BLUE SIDEBAR STYLE AS SKILLS/SUMMARY PAGE */
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
            background: repeating-linear-gradient(
                to bottom,
                rgba(255,255,255,.22) 0px,
                rgba(255,255,255,.22) 9px,
                transparent 9px,
                transparent 17px
            );
        }

        /* Finalize page: white line reaches current step only */
        .builder-sidebar .steps::after {
            content: "";
            position: absolute;
            left: 19px;
            top: 39px;
            width: 3px;
            height: 325px;
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

        .step.done .step-circle,
        .step.active .step-circle { background: #ffffff; color: #111827; }

        .step.done .step-circle { font-size: 0; }

        .step.done .step-circle::after {
            content: "✓";
            font-size: 24.5px;
            font-weight: 950;
            color: #111827;
        }

        .step.active,
        .step.active span:last-child {
            color: #ffffff;
            font-weight: 950;
            text-shadow: 0 0 1px rgba(255,255,255,.18);
        }

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

        .progress-track {
            width: 205px;
            height: 10px;
            border-radius: 999px;
            background: #ffffff;
            overflow: hidden;
            flex: 0 0 205px;
        }

        .progress-fill {
            width: 80%;
            height: 100%;
            border-radius: 999px;
            background: #34d399;
        }

        .progress-number {
            font-size: 16px;
            line-height: 1;
            font-weight: 900;
            color: #ffffff;
        }

        .sidebar-footer {
            position: absolute;
            left: 48px;
            top: 570px;
            bottom: auto;
            width: 260px;
            color: #ffffff;
        }

        .sidebar-footer nav { display: flex; flex-direction: column; gap: 8px; }

        .sidebar-footer a {
            color: #34d399;
            text-decoration: none;
            font-size: 17.5px;
            line-height: 1.08;
            font-weight: 850;
            white-space: nowrap;
            letter-spacing: 0;
            transition: color .18s ease, text-shadow .18s ease;
        }

        .sidebar-footer a:hover { color: #ec4899; text-shadow: 0 0 12px rgba(236,72,153,.30); }

        .copyright {
            margin-top: 46px;
            max-width: 260px;
            color: #ffffff;
            font-size: 16px;
            line-height: 1.32;
            font-weight: 500;
            white-space: normal;
        }

        /* MAIN FINALIZE AREA */
        .finalize-main {
            margin-left: 360px;
            width: calc(133.3333333333vw - 360px);
            height: 133.3333333333vh;
            background: #ffffff;
            overflow: hidden;
            position: relative;
            display: flex;
        }

        .finalize-left {
            width: 60%;
            height: 100%;
            padding: 92px 54px 180px 48px;
            overflow-y: auto;
            background: #ffffff;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .finalize-left::-webkit-scrollbar { display: none; width: 0; }
        .finalize-left-inner { max-width: 940px; }

        .top-back {
            color: #2563eb;
            font-size: 18px;
            font-weight: 900;
            margin-bottom: 28px;
            letter-spacing: 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .top-back:hover { color: #2563eb; text-decoration: none; }

        .page-title {
            font-size: 42px;
            line-height: 1.12;
            font-weight: 950;
            letter-spacing: 0;
            margin: 0 0 18px;
            color: #071022;
        }

        .page-subtitle {
            font-size: 22px;
            line-height: 1.38;
            font-weight: 400;
            margin: 0 0 36px;
            color: #334155;
        }

        .optional-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px 34px;
            max-width: 980px;
        }

        .option-row {
            display: flex;
            align-items: center;
            gap: 18px;
            min-height: 54px;
            color: #071022;
            font-size: 27px;
            line-height: 1.1;
            font-weight: 500;
        }

        .option-check {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            border-radius: 5px;
            border: 1.8px solid #94a3b8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            color: #0969da;
            font-size: 22px;
            cursor: pointer;
            user-select: none;
        }

        .option-check.checked {
            border-color: #0969da;
            color: #0969da;
        }

        .option-check.checked::after {
            content: "✓";
            font-weight: 950;
        }

        .new-pill {
            margin-left: 12px;
            background: #f9a8d4;
            color: #071022;
            font-size: 18px;
            font-weight: 950;
            font-style: italic;
            padding: 5px 17px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(219,27,131,.16);
        }

        .custom-block {
            transform: translateX(-120px) !important;
            display: grid;
            grid-template-columns: 34px 1fr;
            gap: 18px;
            align-items: center;
        }

        .custom-field label {
            display: block;
            color: #071022;
            font-size: 16px;
            font-weight: 950;
            margin-bottom: 8px;
        }

        .custom-field input {
            width: 100%;
            height: 64px;
            border: 1.8px solid #94a3b8;
            border-radius: 8px;
            padding: 0 18px;
            font-size: 21px;
            color: #071022;
            outline: none;
            background: #ffffff;
        }

        .custom-field input:focus {
            border-color: #0969da;
            box-shadow: 0 0 0 2px rgba(9,105,218,.14);
        }

        .finalize-hint {
            margin-top: 34px;
            color: #64748b;
            font-size: 17px;
            line-height: 1.45;
            max-width: 760px;
            font-weight: 700;
        }

        .finalize-right {
            width: 40%;
            max-width: 40%;
            flex: 0 0 40%;
            height: 133.3333333333vh;
            background: #ffffff;
            border-left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 112px 30px 34px 26px;
            overflow: hidden;
            position: relative;
        }

        .preview-box {
            width: min(100%, 560px);
            height: 540px;
            min-height: 540px;
            max-height: 540px;
            padding: 0;
            margin-top: 24px;
            background: #fff;
            border: 0;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .core-cv-scrollbox {
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 0;
        }

        .core-cv-live {
            --cv-accent:#7ca342;
            width: 430px;
            min-height: 548px;
            height: auto;
            background: #fff;
            border-radius: 6px;
            border: 1px solid #dbe3ef;
            box-shadow: none;
            padding: 30px 40px 34px;
            color: #111827;
            font-family: "Times New Roman", Georgia, serif;
            overflow: visible;
            flex: 0 0 auto;
        }

        .core-cv-live.modal-size {
            width: 520px;
            min-height: 735px;
            padding: 44px 54px;
            box-shadow: 0 20px 60px rgba(15,23,42,.22);
        }

        .core-cv-name {
            text-align: center;
            font-size: 17px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #6b8e23;
            line-height: 1.18;
            margin-bottom: 5px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .core-cv-contact {
            text-align: center;
            font-size: 6.8px;
            color: #4b5563;
            font-weight: 700;
            line-height: 1.45;
            padding-bottom: 8px;
            margin-bottom: 10px;
            border-bottom: 1.4px solid var(--cv-accent);
            font-family: Arial, Helvetica, sans-serif;
        }

        .core-cv-section { margin-top: 9px; }

        .core-cv-title {
            font-size: 7.4px;
            font-weight: 900;
            color: #6b8e23;
            text-transform: uppercase;
            letter-spacing: .045em;
            border-bottom: 1.35px solid var(--cv-accent);
            padding-bottom: 3px;
            margin-bottom: 5px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .core-cv-text,
        .core-cv-li,
        .core-cv-list {
            font-size: 6.65px;
            line-height: 1.43;
            color: #374151;
        }

        .core-cv-bold { font-weight: 900; color: #111827; }
        .core-cv-muted { color: #4b5563; font-style: italic; }

        .core-cv-list { margin: 0; padding-left: 11px; }
        .core-cv-list li { margin-bottom: 1.5px; }

        .core-cv-grid-3 {
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:2px 14px;
            margin-top:2px;
        }

        .core-cv-history-row,
        .core-cv-edu-row {
            display:grid;
            grid-template-columns:1.1fr .75fr .75fr;
            gap:10px;
            margin-bottom:4px;
            align-items:start;
        }

        .bottom-buttons {
            position:relative;
            z-index:4;
            max-width:390px;
            width:100%;
            gap:18px;
            padding:0;
            margin-top:10px;
            transform:translateY(-12px);
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .preview-btn,
        .next-btn {
            height:54px;
            border-radius:999px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            white-space:nowrap;
            font-size:13px;
            font-weight:950;
            letter-spacing:.08em;
            padding:0 26px;
            text-transform:uppercase;
            cursor:pointer;
            transition:all .18s ease;
        }

        .preview-btn {
            min-width:138px;
            border:2px solid #0f172a;
            color:#0f172a;
            background:#fff;
            box-shadow:none;
        }

        .next-btn {
            min-width:188px;
            border:0;
            background:#db1b83;
            color:#fff;
            box-shadow:none;
        }

        .preview-btn:hover,
        .next-btn:hover { transform:translateY(-1px); }

        .finalize-alert {
            position:fixed;
            top:22px;
            left:calc(360px + 50%);
            transform:translateX(-50%) translateY(-120%);
            min-width:420px;
            max-width:680px;
            padding:17px 22px;
            border-radius:12px;
            background:#fee2e2;
            border:1px solid #fecaca;
            color:#991b1b;
            font-size:16px;
            font-weight:900;
            line-height:1.35;
            box-shadow:0 18px 45px rgba(15,23,42,.18);
            opacity:0;
            pointer-events:none;
            z-index:9998;
            transition:all .24s ease;
        }

        .finalize-alert.show {
            opacity:1;
            transform:translateX(-50%) translateY(0);
        }

        .finalize-alert.success {
            background:#dcfce7;
            border-color:#bbf7d0;
            color:#166534;
        }

        .finalize-preview-modal {
            position:fixed;
            inset:0;
            z-index:999999;
            display:none;
            align-items:center;
            justify-content:center;
            background:rgba(15,23,42,.72);
            padding:22px;
        }

        .finalize-preview-modal.show { display:flex; }

        .finalize-preview-card {
            position:relative;
            width:min(560px,94vw);
            height:min(780px,92vh);
            background:#fff;
            border-radius:16px;
            box-shadow:0 30px 80px rgba(0,0,0,.35);
            overflow-y:auto;
            overflow-x:hidden;
            padding:28px;
        }

        .finalize-preview-card .core-cv-live {
            width:100%;
            min-height:720px;
            border:0;
            margin:0 auto;
        }

        .finalize-preview-close {
            position:fixed;
            top:26px;
            right:28px;
            width:42px;
            height:42px;
            border:0;
            border-radius:999px;
            background:#fff;
            color:#0f172a;
            font-size:18px;
            cursor:pointer;
            box-shadow:0 12px 32px rgba(0,0,0,.22);
            z-index:1000000;
        }

        @media (max-width:1024px) {
            body { zoom:1; width:100%; height:auto; min-width:0; min-height:0; overflow:auto; }
            .builder-sidebar { position:relative; width:100%; height:82px; min-height:82px; box-shadow:none; }
            .steps, .sidebar-progress, .sidebar-footer { display:none; }
            .sidebar-logo { top:25px; left:24px; font-size:22px; }
            .sidebar-logo i { font-size:27px; }
            .finalize-main { margin-left:0; width:100%; height:auto; min-height:calc(100vh - 82px); overflow:visible; display:block; }
            .finalize-left { width:100%; height:auto; padding:34px 24px 100px; overflow:visible; }
            .finalize-right { display:none; }
            .optional-grid { grid-template-columns:1fr; }
            .page-title { font-size:32px; }
            .page-subtitle { font-size:18px; }
        }
    </style>


<!-- GHOST FINAL PATCH: Finalize optional section UI only. Sidebar/logic/preview template untouched. -->
<style id="ghost-finalize-options-ui-only-final">
    /* Go Back underline only */
    .finalize-main .top-back {
        text-decoration: underline !important;
        text-underline-offset: 2px !important;
        text-decoration-thickness: 1.5px !important;
    }

    .finalize-main .top-back i {
        text-decoration: none !important;
    }

    /* Keep options in one left column; Add Your Own stays in its own right-side place */
    .optional-grid {
        display: grid !important;
        grid-template-columns: minmax(0, 430px) minmax(0, 520px) !important;
        column-gap: 70px !important;
        row-gap: 22px !important;
        align-items: start !important;
        max-width: 980px !important;
    }

    .optional-grid .option-row {
        grid-column: 1 / 2 !important;
        min-height: 46px !important;
        gap: 16px !important;
        font-size: 25px !important;
        line-height: 1.1 !important;
        width: 100% !important;
    }

    .optional-grid .custom-block {
        grid-column: 2 / 3 !important;
        grid-row: 1 / 2 !important;
        align-self: start !important;
        display: grid !important;
        grid-template-columns: 28px minmax(0, 1fr) !important;
        gap: 16px !important;
        width: 100% !important;
        margin-top: 0 !important;
    }

    /* Checkbox slightly smaller */
    .option-check,
    .custom-block .option-check {
        width: 28px !important;
        height: 28px !important;
        flex: 0 0 28px !important;
        border-radius: 5px !important;
        font-size: 18px !important;
    }

    .custom-field label {
        font-size: 16px !important;
        margin-bottom: 8px !important;
    }

    .custom-field input {
        height: 62px !important;
        font-size: 21px !important;
    }

    /* Keep right template and buttons same page style */
    .finalize-right .preview-box {
        width: min(100%, 560px) !important;
        height: 540px !important;
        min-height: 540px !important;
        max-height: 540px !important;
    }

    .finalize-right .core-cv-live {
        width: 430px !important;
        min-height: 548px !important;
        padding: 30px 40px 34px !important;
    }

    .bottom-buttons {
        max-width: 390px !important;
        gap: 18px !important;
        margin-top: 10px !important;
        transform: translateY(-12px) !important;
    }

    .preview-btn,
    .next-btn {
        height: 54px !important;
        font-size: 13px !important;
        font-weight: 950 !important;
        padding: 0 26px !important;
        letter-spacing: .08em !important;
        text-transform: uppercase !important;
    }

    .preview-btn { min-width: 138px !important; }
    .next-btn { min-width: 188px !important; }
</style>



<!-- GHOST FINAL PATCH: finalize optional rows alignment only; sidebar/template/buttons/logic untouched -->
<style id="ghost-finalize-options-row-alignment-only-final">
    /* Main optional section layout: left options in one clean column, Add Your Own stays on right */
    .optional-grid {
        display: grid !important;
        grid-template-columns: minmax(0, 520px) minmax(0, 520px) !important;
        column-gap: 42px !important;
        row-gap: 18px !important;
        align-items: start !important;
        max-width: 1080px !important;
    }

    /* All normal options stay in left column with equal gap */
    .optional-grid .option-row {
        grid-column: 1 / 2 !important;
        min-height: 42px !important;
        height: 42px !important;
        gap: 16px !important;
        font-size: 25px !important;
        line-height: 1.05 !important;
        font-weight: 500 !important;
        width: 100% !important;
        display: flex !important;
        align-items: center !important;
        white-space: nowrap !important;
        margin: 0 !important;
    }

    /* Keep Websites, Portfolios, Profiles in one line */
    .optional-grid .option-row[data-section="websites"] span:last-child {
        white-space: nowrap !important;
        display: inline-block !important;
    }

    /* Add Your Own stays right side, top aligned with first row */
    .optional-grid .custom-block {
        grid-column: 2 / 3 !important;
        grid-row: 1 / 2 !important;
        align-self: start !important;
        display: grid !important;
        grid-template-columns: 28px minmax(0, 1fr) !important;
        gap: 16px !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        align-items: start !important;
    }

    /* Add Your Own checkbox stays in same row as Websites checkbox */
    .custom-block .option-check {
        margin-top: 0 !important;
        align-self: start !important;
    }

    /* Checkbox small and consistent */
    .option-check,
    .custom-block .option-check {
        width: 28px !important;
        height: 28px !important;
        flex: 0 0 28px !important;
        border-radius: 5px !important;
        font-size: 18px !important;
        margin-right: 0 !important;
    }

    .custom-field {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .custom-field label {
        display: block !important;
        font-size: 16px !important;
        line-height: 1 !important;
        font-weight: 950 !important;
        margin: 0 0 10px !important;
        color: #071022 !important;
    }

    .custom-field input {
        width: 60px !important;
        height: 62px !important;
        font-size: 21px !important;
        border-radius: 8px !important;
    }

    .new-pill {
        margin-left: 12px !important;
        vertical-align: middle !important;
    }
</style>



<!-- GHOST FINAL PATCH: optional list compact gap + Add Your Own slightly up only. Sidebar/template/buttons/logic untouched. -->
<style id="ghost-finalize-compact-options-custom-up-final">
    .optional-grid {
        position: relative !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 18px !important;
        row-gap: 18px !important;
        column-gap: 0 !important;
        max-width: 1080px !important;
        width: 1080px !important;
    }

    .optional-grid .option-row {
        width: 520px !important;
        min-height: 34px !important;
        height: 34px !important;
        margin: 0 !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 16px !important;
        white-space: nowrap !important;
    }

    .optional-grid .option-row[data-section="websites"] span:last-child {
        white-space: nowrap !important;
        display: inline-block !important;
    }

    .optional-grid .custom-block {
        position: absolute !important;
        left: 560px !important;
        top: 0 !important;
        width: 520px !important;
        display: grid !important;
        grid-template-columns: 28px minmax(0, 1fr) !important;
        gap: 16px !important;
        align-items: start !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .custom-block .option-check {
        margin-top: 0 !important;
        align-self: start !important;
    }

    .custom-block .custom-field {
        transform: translateY(-8px) !important;
    }

    .option-check,
    .custom-block .option-check {
        width: 28px !important;
        height: 28px !important;
        flex: 0 0 28px !important;
    }
</style>



<!-- GHOST FINAL PATCH: Restore Add Your Own original position only. Sidebar/template/buttons/logic untouched. -->
<style id="ghost-finalize-restore-add-your-own-position-only">
    .optional-grid .custom-block {
        top: 0 !important;
        align-items: start !important;
    }

    .custom-block .custom-field {
        transform: none !important;
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .custom-block .option-check {
        margin-top: 0 !important;
        align-self: start !important;
    }
</style>



<!-- GHOST FINAL PATCH: move Add Your Own block slightly left so full text field shows. Sidebar/template/buttons/logic untouched. -->
<style id="ghost-finalize-add-your-own-left-fit-only">
    .optional-grid .custom-block {
        left: 480px !important;
        width: 430px !important;
        grid-template-columns: 28px 360px !important;
        gap: 16px !important;
    }

    .custom-block .custom-field {
        width: 360px !important;
        max-width: 360px !important;
    }

    .custom-block .custom-field input {
        width: 250px !important;
        max-width: 360px !important;
    }
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
            <div id="summaryStep" class="step"><span class="step-circle">5</span><span>Summary</span><span class="step-missing">Add missing information</span></div>
            <div id="finalizeStep" class="step active"><span class="step-circle">6</span><span>Finalize</span></div>
        </div>

        <div class="sidebar-progress">
            <div class="sidebar-progress-title">Resume Completeness:</div>
            <div class="progress-row"><div class="progress-track"><div class="progress-fill" id="progressFill"></div></div><div class="progress-number" id="progressNumber">80%</div></div>
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

    <div id="finalizeAlert" class="finalize-alert"></div>

    <main class="finalize-main">
        <section class="finalize-left">
            <div class="finalize-left-inner">
                <a href="/builder/summary" class="top-back"><i class="fa-solid fa-arrow-left"></i> Go Back</a>

                <h1 class="page-title">Do you have anything else to add?</h1>
                <p class="page-subtitle">To stand out, consider including these optional sections.</p>

                <div class="optional-grid">
                    <div class="option-row" data-section="websites"><span class="option-check"></span><span>Websites & Portfolios</span></div>
                    <div class="custom-block">
                        <span class="option-check" id="customCheck"></span>
                        <div class="custom-field">
                            <label for="customSectionInput">Add Your Own</label>
                            <input id="customSectionInput" type="text" placeholder="Hobbies"><span class="new-pill">NEW!</span>
                        </div>
                    </div>
                    <div class="option-row" data-section="languages"><span class="option-check"></span><span>Languages </span></div>
                    <div class="option-row" data-section="accomplishments"><span class="option-check"></span><span>Accomplishments</span></div>
                    <div class="option-row" data-section="additional_information"><span class="option-check"></span><span>Additional Information</span></div>
                    <div class="option-row" data-section="affiliations"><span class="option-check"></span><span>Affiliations</span></div>
                </div>

                <p class="finalize-hint">
                    
                </p>
            </div>
        </section>

        <section class="finalize-right">
            <div class="preview-box" id="previewBox"><div class="core-cv-scrollbox" id="previewHost"></div></div>

            <div class="bottom-buttons">
                <button id="btnPreview" type="button" class="preview-btn">Preview</button>
                <button id="btnNextFinalize" type="button" class="next-btn">Next</button>
            </div>
        </section>
    </main>

    <div id="finalizePreviewModal" class="finalize-preview-modal" aria-hidden="true">
        <button type="button" id="closeFinalizePreview" class="finalize-preview-close"><i class="fa-solid fa-xmark"></i></button>
        <div class="finalize-preview-card"><div id="finalizePreviewModalContent"></div></div>
    </div>

    <script>
        const API_BASE = "https://resume-backend-54se.onrender.com";
        const token = localStorage.getItem("resume_token");
        const resumeId = localStorage.getItem("current_resume_id");

        if (!token || !resumeId) window.location.href = "/login";

        let previewContact = null;
        let previewEducation = null;
        let previewWorkItems = [];
        let skills = [];
        let optionalSections = [];

        function scoped(base){ return base + "_" + (resumeId || "no_resume"); }
        function cleanText(value){ return String(value || "").trim(); }
        function safeJson(key, fallback){ try { return JSON.parse(localStorage.getItem(key) || JSON.stringify(fallback)); } catch { return fallback; } }
        function esc(str){ return String(str || '').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'",'&#039;'); }

        function showAlert(message, type = "error"){
            const alertBox = document.getElementById("finalizeAlert");
            alertBox.textContent = message;
            alertBox.classList.toggle("success", type === "success");
            alertBox.classList.add("show");
            setTimeout(() => alertBox.classList.remove("show"), 2600);
        }

        function isMeaningfulWork(work){ return !!(work && (work.job_title || work.employer || work.city || work.start_year || work.extra_info)); }
        function isMeaningfulEducation(edu){ return !!(edu && (edu.school_name || edu.school || edu.schoolName || edu.degree || edu.field_of_study || edu.field || edu.graduation_year || edu.year)); }

        function getContactSnapshot(){
            return safeJson("resume_contact_snapshot_" + resumeId, null) ||
                   safeJson(scoped("resume_contact_snapshot"), null) ||
                   safeJson("resume_contact_snapshot", null) ||
                   safeJson("resume_contact_data_" + resumeId, null) ||
                   safeJson("resume_contact_data", null);
        }

        function getSelectedWorkHistory(){
            const selectedList = safeJson(scoped("resume_work_history_selected_for_education"), null) ||
                safeJson("resume_work_history_selected_for_education_" + resumeId, null) ||
                safeJson("resume_work_history_selected_for_education", null);

            if (Array.isArray(selectedList) && selectedList.some(isMeaningfulWork)) return selectedList.filter(isMeaningfulWork);

            const scopedEntries = safeJson(scoped("resume_work_history_entries"), []);
            const globalEntries = safeJson("resume_work_history_entries", []);
            const entries = Array.isArray(scopedEntries) && scopedEntries.length ? scopedEntries : globalEntries;
            const indexes = safeJson(scoped("resume_work_history_use_this_indexes"), null) || safeJson("resume_work_history_use_this_indexes", []);

            if (Array.isArray(indexes) && indexes.length) return indexes.map(i => entries[Number(i)]).filter(isMeaningfulWork);
            return [];
        }

        function getSelectedEducationId(){
            return localStorage.getItem(scoped("resume_education_selected_id")) ||
                localStorage.getItem("resume_education_selected_id_" + resumeId) ||
                localStorage.getItem(scoped("resume_selected_education_id")) ||
                localStorage.getItem("resume_selected_education_id_" + resumeId) ||
                localStorage.getItem("resume_selected_education_id") ||
                localStorage.getItem("selected_education_id") ||
                "";
        }

        function getEducationList(){
            const keys = [
                "resume_education_summary_list_" + resumeId,
                scoped("resume_education_summary_list"),
                "resume_education_entries_" + resumeId,
                scoped("resume_education_entries"),
                "resume_education_list_" + resumeId
            ];
            for (const key of keys) {
                const value = safeJson(key, null);
                if (Array.isArray(value) && value.length) return value;
            }
            return [];
        }

        function getSelectedEducationSnapshot(){
            const selectedId = getSelectedEducationId();
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
            for (const key of snapshotKeys) {
                const snap = safeJson(key, null);
                if (isMeaningfulEducation(snap) && selectedId) return snap;
            }
            return null;
        }

        function normalizeSkillItem(skill){
            if (typeof skill === "string") return { skill_name: cleanText(skill), skill_level: "" };
            return {
                skill_name: cleanText(skill && (skill.skill_name || skill.name || skill.title || skill.label)),
                skill_level: cleanText(skill && (skill.skill_level || skill.level || skill.proficiency))
            };
        }

        function loadSkillsFromLocal(){
            const keys = [
                scoped("resume_skills_backup"),
                "resume_skills_backup",
                "resume_skills_backup_" + resumeId,
                scoped("resume_skills"),
                "resume_skills_" + resumeId,
                "selected_skills_" + resumeId,
                "selected_skills",
                "skills"
            ];

            for (const key of keys) {
                const value = safeJson(key, null);
                if (Array.isArray(value) && value.length > 0) {
                    skills = value.map(normalizeSkillItem).filter(s => s.skill_name);
                    if (skills.length > 0) return;
                }
            }
            skills = [];
        }

        async function loadSkillsFromDatabase(){
            try {
                const res = await fetch(`${API_BASE}/api/resumes/skills/${resumeId}`, { headers:{ "Authorization":"Bearer " + token } });
                const data = await res.json();
                if (data.success && Array.isArray(data.skills) && data.skills.length > 0) {
                    skills = data.skills.map(normalizeSkillItem).filter(s => s.skill_name);
                    localStorage.setItem(scoped("resume_skills_backup"), JSON.stringify(skills));
                    localStorage.setItem("resume_skills_backup", JSON.stringify(skills));
                    setupSidebarFlow();
                    renderPreview();
                }
            } catch(error){ console.error("Skills load failed:", error); }
        }

        function loadOptionalSections(){
            optionalSections = safeJson(scoped("resume_finalize_optional_sections"), []);
            if (!Array.isArray(optionalSections)) optionalSections = [];
            document.querySelectorAll(".option-row").forEach(row => {
                const key = row.dataset.section;
                row.querySelector(".option-check").classList.toggle("checked", optionalSections.includes(key));
            });
            const custom = safeJson(scoped("resume_finalize_custom_section"), "");
            document.getElementById("customSectionInput").value = custom || "";
            document.getElementById("customCheck").classList.toggle("checked", !!custom);
        }

        function saveOptionalSections(){
            const chosen = [];
            document.querySelectorAll(".option-row").forEach(row => {
                if (row.querySelector(".option-check").classList.contains("checked")) chosen.push(row.dataset.section);
            });
            optionalSections = chosen;
            const custom = cleanText(document.getElementById("customSectionInput").value);
            localStorage.setItem(scoped("resume_finalize_optional_sections"), JSON.stringify(optionalSections));
            localStorage.setItem("resume_finalize_optional_sections", JSON.stringify(optionalSections));
            localStorage.setItem(scoped("resume_finalize_custom_section"), JSON.stringify(custom));
            localStorage.setItem("resume_finalize_custom_section", JSON.stringify(custom));
        }

        function setupSidebarFlow(){
            const workStep = document.getElementById("workHistoryStep");
            const educationStep = document.getElementById("educationStep");
            const skillsStep = document.getElementById("skillsStep");
            const summaryStep = document.getElementById("summaryStep");

            const hasWork = getSelectedWorkHistory().length > 0;
            const hasEdu = !!(getSelectedEducationId() && isMeaningfulEducation(getSelectedEducationSnapshot()));
            const hasSkills = skills.length > 0;
            const hasSummary = !!cleanText(localStorage.getItem(scoped("resume_summary_text")) || localStorage.getItem("resume_summary_text"));

            workStep.classList.toggle("done", hasWork);
            workStep.classList.toggle("missing", !hasWork);

            educationStep.classList.toggle("done", hasEdu);
            educationStep.classList.toggle("missing", !hasEdu);

            skillsStep.classList.toggle("done", hasSkills);
            skillsStep.classList.toggle("missing", !hasSkills);

            summaryStep.classList.toggle("done", hasSummary);
            summaryStep.classList.toggle("missing", !hasSummary);

            let percent = 60;
            if (hasWork) percent += 8;
            if (hasEdu) percent += 8;
            if (hasSkills) percent += 8;
            if (hasSummary) percent += 8;
            percent = Math.min(percent, 95);

            document.getElementById("progressFill").style.width = percent + "%";
            document.getElementById("progressNumber").textContent = percent + "%";
        }

        function contactDataForTemplate(){
            const c = previewContact || getContactSnapshot() || {};
            const fullName = cleanText(c.fullName) || cleanText(`${c.first_name || c.firstName || ''} ${c.last_name || c.lastName || ''}`) || 'YOUR NAME';
            return {
                fullName,
                city: cleanText(c.city) || cleanText(c.location || '').split(',')[0] || 'City',
                country: cleanText(c.country) || (cleanText(c.location || '').includes(',') ? cleanText(c.location).split(',').slice(1).join(',').trim() : 'Country'),
                postal: cleanText(c.postal_code || c.postal || c.zip),
                phone: cleanText(c.phoneFull || c.phone || c.phone_number),
                email: cleanText(c.email || c.email_address)
            };
        }

        function educationForTemplate(){
            const e = previewEducation || getSelectedEducationSnapshot() || {};
            return {
                school: cleanText(e.school_name || e.school || e.schoolName) || 'School / College Name',
                location: cleanText(e.city || e.location || e.school_location) || 'Study Location',
                degree: cleanText(e.degree || e.qualification) || 'Qualification',
                field: cleanText(e.field_of_study || e.field || e.subject) || 'Subject',
                date: cleanText([e.graduation_month || e.month, e.graduation_year || e.year || e.grad_year].filter(Boolean).join(' ')) || 'Study dates',
                detailsHtml: e.description || e.extra_info || e.coursework || e.highlights || ''
            };
        }

        function formatWorkMeta(work){
            const loc = [work.city, work.country].filter(Boolean).join(", ");
            const start = [work.start_month, work.start_year].filter(Boolean).join(" ");
            const end = work.currently_working ? "Current" : [work.end_month, work.end_year].filter(Boolean).join(" ");
            return [loc, [start,end].filter(Boolean).join(" - ")].filter(Boolean).join(" · ");
        }

        function stripHtml(html){
            const div = document.createElement("div");
            div.innerHTML = html || "";
            return div.textContent || div.innerText || "";
        }

        function summaryTextForTemplate(){
            return cleanText(localStorage.getItem(scoped("resume_summary_text")) || localStorage.getItem("resume_summary_text")) ||
                "Use this space to express your career aspirations and goals, and quickly connect with an employer.";
        }

        function optionalSectionLabels(){
            const labelMap = {
                websites: "Websites / Portfolio",
                languages: "Languages",
                accomplishments: "Accomplishments",
                additional_information: "Additional Information",
                affiliations: "Affiliations"
            };
            const labels = optionalSections.map(k => labelMap[k]).filter(Boolean);
            const custom = cleanText(document.getElementById("customSectionInput").value);
            if (custom) labels.push(custom);
            return labels;
        }

        function coreFinalizeMarkup(modal = false){
            const c = contactDataForTemplate();
            const e = educationForTemplate();
            const work = (previewWorkItems && previewWorkItems[0]) || {};
            const hasWork = getSelectedWorkHistory().length > 0;
            const hasEdu = !!(getSelectedEducationId() && isMeaningfulEducation(getSelectedEducationSnapshot()));
            const skillNames = skills.map(s => cleanText(s.skill_name)).filter(Boolean).slice(0, 9);
            const col1 = skillNames.slice(0,3), col2 = skillNames.slice(3,6), col3 = skillNames.slice(6,9);
            const renderCol = arr => `<ul class="core-cv-list">${arr.map(s => `<li>${esc(s)}</li>`).join('')}</ul>`;

            const workTitle = hasWork ? cleanText(work.job_title) || 'Your Most Recent Job Title' : 'Your Most Recent Job Title';
            const employer = hasWork ? cleanText(work.employer) || 'Employer name' : 'Employer name';
            const workDate = hasWork ? formatWorkMeta(work) || 'Employment dates' : 'Employment dates';
            const details = hasWork ? (stripHtml(work.extra_info || '').slice(0, 170) || 'Responsibilities and achievements') : 'In concise sentences describe the daily tasks you undertook.';

            const optionLabels = optionalSectionLabels();

            return `
                <div class="core-cv-live ${modal ? 'modal-size' : ''}">
                    <div class="core-cv-name">${esc(c.fullName)}</div>
                    <div class="core-cv-contact">${esc([c.city, c.country].filter(Boolean).join(', '))} ${esc(c.postal)} | ${esc(c.phone || 'Phone')} | ${esc(c.email || 'Email')}</div>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Career Objective</div>
                        <div class="core-cv-text">${esc(summaryTextForTemplate())}</div>
                    </section>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Skills</div>
                        <div class="core-cv-grid-3">${renderCol(col1)}${renderCol(col2)}${renderCol(col3)}</div>
                    </section>

                    ${optionLabels.length ? `
                    <section class="core-cv-section">
                        <div class="core-cv-title">References / Extra Sections</div>
                        <ul class="core-cv-list">${optionLabels.map(label => `<li>${esc(label)}</li>`).join('')}</ul>
                    </section>` : `
                    <section class="core-cv-section">
                        <div class="core-cv-title">References</div>
                        <div class="core-cv-text">Available on request.</div>
                    </section>`}

                    <section class="core-cv-section">
                        <div class="core-cv-title">Work History</div>
                        <div class="core-cv-history-row core-cv-text">
                            <div><span class="core-cv-bold">${esc(workTitle)}</span><br>Duties</div>
                            <div>${esc(employer)}</div>
                            <div class="core-cv-muted">${esc(workDate)}</div>
                        </div>
                        <div class="core-cv-text">${esc(details)}</div>
                    </section>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Education</div>
                        <div class="core-cv-edu-row core-cv-text">
                            <div><span class="core-cv-bold">${esc(hasEdu ? e.school : 'School / College Name')}</span><br>${esc(hasEdu ? e.degree + ' / ' + e.field : 'Qualification / subject')}</div>
                            <div>${esc(hasEdu ? e.location : 'Grade')}</div>
                            <div class="core-cv-muted">${esc(hasEdu ? e.date : 'Study dates')}</div>
                        </div>
                    </section>
                </div>`;
        }

        function renderPreview(){
            saveOptionalSections();
            const markup = coreFinalizeMarkup(false);
            const modalMarkup = coreFinalizeMarkup(true);
            document.getElementById("previewHost").innerHTML = markup;
            document.getElementById("finalizePreviewModalContent").innerHTML = modalMarkup;
            setupSidebarFlow();
        }

        function finalSnapshotPayload(){
            return {
                resume_id: resumeId,
                contact: previewContact || getContactSnapshot() || {},
                selected_work_history: getSelectedWorkHistory(),
                selected_education: getSelectedEducationSnapshot(),
                skills: skills,
                summary_text: summaryTextForTemplate(),
                optional_sections: optionalSections,
                custom_section: cleanText(document.getElementById("customSectionInput").value),
                final_snapshot: {
                    contact: previewContact || getContactSnapshot() || {},
                    work_history: getSelectedWorkHistory(),
                    education: getSelectedEducationSnapshot(),
                    skills,
                    summary_text: summaryTextForTemplate(),
                    optional_sections: optionalSections,
                    custom_section: cleanText(document.getElementById("customSectionInput").value)
                }
            };
        }

        async function saveFinalizeToDatabase(){
            saveOptionalSections();
            const payload = finalSnapshotPayload();

            localStorage.setItem(scoped("resume_final_snapshot"), JSON.stringify(payload));
            localStorage.setItem("resume_final_snapshot", JSON.stringify(payload));
            localStorage.setItem(scoped("resume_finalize_completed"), "true");
            localStorage.setItem("resume_finalize_completed", "true");

            try {
                const res = await fetch(`${API_BASE}/api/resumes/finalize`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + token
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok || data.success === false) {
                    console.warn(data.message || "Finalize API not ready, local snapshot saved.");
                    showAlert("Final resume saved locally. Add backend finalize API to save in database.", "success");
                    return true;
                }

                showAlert("Final resume saved successfully.", "success");
                return true;
            } catch(error) {
                console.error("Finalize save failed, local snapshot kept:", error);
                showAlert("Final resume saved locally. Backend API not connected yet.", "success");
                return true;
            }
        }

        async function loadResumePreviewInfo(){
            previewContact = getContactSnapshot();

            try {
                const res = await fetch(`${API_BASE}/api/resumes/get/${resumeId}`, {
                    headers:{ "Authorization":"Bearer " + token }
                });
                const data = await res.json();
                if (data.success && data.resume) previewContact = Object.assign({}, previewContact || {}, data.resume);
            } catch(error) {
                console.error("Resume preview load failed:", error);
            }

            previewEducation = getSelectedEducationSnapshot();
            previewWorkItems = getSelectedWorkHistory();
            renderPreview();
        }

        document.querySelectorAll(".option-row").forEach(row => {
            row.addEventListener("click", () => {
                row.querySelector(".option-check").classList.toggle("checked");
                renderPreview();
            });
        });

        document.getElementById("customCheck").addEventListener("click", () => {
            const input = document.getElementById("customSectionInput");
            document.getElementById("customCheck").classList.toggle("checked");
            if (document.getElementById("customCheck").classList.contains("checked") && !cleanText(input.value)) input.value = "Hobbies";
            if (!document.getElementById("customCheck").classList.contains("checked")) input.value = "";
            renderPreview();
        });

        document.getElementById("customSectionInput").addEventListener("input", () => {
            document.getElementById("customCheck").classList.toggle("checked", !!cleanText(document.getElementById("customSectionInput").value));
            renderPreview();
        });

        document.getElementById("btnPreview").addEventListener("click", () => {
            renderPreview();
            const modal = document.getElementById("finalizePreviewModal");
            modal.classList.add("show");
            modal.setAttribute("aria-hidden", "false");
        });

        document.getElementById("closeFinalizePreview").addEventListener("click", () => {
            const modal = document.getElementById("finalizePreviewModal");
            modal.classList.remove("show");
            modal.setAttribute("aria-hidden", "true");
        });

        document.getElementById("finalizePreviewModal").addEventListener("click", e => {
            if (e.target && e.target.id === "finalizePreviewModal") e.currentTarget.classList.remove("show");
        });

        document.getElementById("btnNextFinalize").addEventListener("click", async () => {
            await saveFinalizeToDatabase();
            // If you build a download page later, uncomment this:
            // window.location.href = "/builder/download";
        });

        loadSkillsFromLocal();
        loadOptionalSections();
        setupSidebarFlow();
        loadResumePreviewInfo();
        loadSkillsFromDatabase();
    </script>
</body>
</html>
