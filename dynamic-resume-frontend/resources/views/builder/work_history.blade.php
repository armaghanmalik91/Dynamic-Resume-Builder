<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work History - Resume Builder</title>

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

        /* LEFT BLUE SIDEBAR - UNCHANGED */
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

        .step span:last-child {
            font-weight: 500;
            color: rgba(255,255,255,.92);
            text-shadow: none;
        }

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
            z-index: 2;
        }

        .step.done .step-circle,
        .step.active .step-circle {
            background: #ffffff;
            color: #111827;
        }

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

        .step.active .step-circle {
            background: #ffffff;
            color: #111827;
            font-weight: 950;
        }

        /* GHOST UPDATE: completed progress connector line bright white */
        .builder-sidebar .steps::after {
            content: "";
            position: absolute;
            left: 19px;
            top: 39px;
            width: 3px;
            height: 65px;
            border-radius: 999px;
            background: #ffffff;
            box-shadow: 0 0 8px rgba(255,255,255,.35);
            z-index: 1;
        }

        .builder-sidebar .step-circle {
            position: relative;
            z-index: 3;
        }

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
            width: 20%;
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

        /* RIGHT AREA */
        .work-main {
            margin-left: 360px;
            width: calc(133.3333333333vw - 360px);
            height: 133.3333333333vh;
            background: #ffffff;
            overflow: hidden;
            position: relative;
        }

        .top-back {
            position: absolute;
            top: 78px;
            left: 48px;
            color: #2563eb;
            font-size: 18px;
            font-weight: 900;
            text-decoration: none;
            letter-spacing: 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            z-index: 5;
        }

        .top-back i { font-size: 18px; text-decoration: none; }
        .top-back:hover { color: #ec4899; }

        .choice-view {
            width: 100%;
            max-width: 1080px;
            margin: 0 auto;
            padding-top: 132px;
            text-align: center;
        }

        .page-title {
            font-size: 42px;
            line-height: 1.12;
            font-weight: 950;
            letter-spacing: 0;
            word-spacing: 0;
            margin: 0 0 18px;
            color: #071022;
            white-space: nowrap;
        }

        .page-subtitle {
            font-size: 24px;
            line-height: 1.32;
            font-weight: 400;
            letter-spacing: 0;
            word-spacing: 0;
            margin: 0 0 45px;
            color: #071022;
            white-space: nowrap;
            transform: scaleX(1.08);
            transform-origin: center;
        }

        .option-row { display: flex; align-items: center; justify-content: center; gap: 20px; margin-top: 0; }

        .reason-btn {
            width: 330px;
            height: 86px;
            border: 1.5px solid #94a3b8;
            border-radius: 10px;
            background: #ffffff;
            color: #071022;
            font-size: 26px;
            font-weight: 400;
            letter-spacing: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .18s ease;
            user-select: none;
            white-space: nowrap;
            box-shadow: none;
        }

        .reason-btn:hover { border-color: #2563eb; transform: translateY(-1px); }

        .reason-btn.selected {
            background: #15168f;
            border-color: #15168f;
            color: #ffffff;
            font-weight: 900;
            box-shadow: none;
        }

        .choice-actions {
            position: absolute;
            top: 450px;
            bottom: auto;
            right: 70px;
            display: flex;
            align-items: center;
            gap: 34px;
            z-index: 10;
        }

        .skip-link {
            color: #071022;
            font-size: 30px;
            font-weight: 950;
            text-decoration: underline;
            letter-spacing: 0;
            background: none;
            border: 0;
            cursor: pointer;
            padding: 0;
            white-space: nowrap;
            line-height: 1;
        }

        .skip-link:hover { color: #2563eb; }

        .next-btn {
            width: 232px;
            height: 72px;
            border: 0;
            border-radius: 999px;
            background: #e5e7eb;
            color: #9ca3af;
            font-size: 23px;
            font-weight: 950;
            cursor: not-allowed;
            transition: all .18s ease;
        }

        .next-btn.enabled {
            background: #db1b83;
            color: #ffffff;
            cursor: pointer;
            box-shadow: none;
        }

        .next-btn.enabled:hover { background: #c91675; transform: translateY(-1px); }

        /* FOLLOW-UP SAME PAGE SCREENS */
        .detail-view {
            display: none;
            height: 100%;
            grid-template-columns: minmax(0, 1fr) 520px;
            gap: 42px;
            padding: 150px 62px 120px 48px;
        }

        .work-main.detail-mode .choice-view,
        .work-main.detail-mode .choice-actions {
            display: none !important;
        }

        .work-main.detail-mode .detail-view {
            display: grid;
        }

        .detail-copy { min-width: 0; padding-top: 10px; }

        .detail-title {
            font-size: 44px;
            line-height: 1.28;
            font-weight: 950;
            letter-spacing: .02em;
            color: #071022;
            margin: 0 0 28px;
            max-width: 650px;
        }

        .detail-strong {
            font-size: 24px;
            line-height: 1.25;
            font-weight: 950;
            color: #071022;
            margin: 0 0 10px;
        }

        .detail-text {
            font-size: 25px;
            line-height: 1.5;
            color: #071022;
            font-weight: 400;
            max-width: 760px;
            margin: 0;
        }

        .detail-template-side {
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 0;
        }

        .template-preview-frame {
            position: relative;
            width: 360px;
            height: 480px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            overflow: hidden;
            box-shadow: none;
        }

        .template-preview-frame img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            background: #ffffff;
        }

        .selected-template-img { display: none; }
        .template-preview-frame.has-image .selected-template-img { display: block; }
        .template-preview-frame.has-image .mock-resume-preview { display: none; }

        .work-highlight-box {
            position: absolute;
            left: 3%;
            right: 3%;
            top: 41%;
            height: 30.5%;
            border: 3px solid #34d399;
            background: rgba(52, 211, 153, .14);
            pointer-events: none;
            z-index: 5;
        }

        .mock-resume-preview {
            width: 100%;
            height: 100%;
            font-family: Georgia, 'Times New Roman', serif;
            color: #4b5563;
            background: #ffffff;
            overflow: hidden;
        }

        .mock-top-bar { height: 13px; background: #638b2d; }
        .mock-resume-inner { padding: 30px 46px; }
        .mock-name { text-align: center; color: #6b8e23; font-size: 18px; font-weight: 900; letter-spacing: .08em; }
        .mock-role { text-align: center; font-size: 8px; margin-top: 3px; color: #64748b; }
        .mock-contact { display: flex; justify-content: space-between; color: #6b8e23; font-size: 7px; margin-top: 13px; }
        .mock-line { height: 1px; background: #6b8e23; margin: 7px 0 10px; }
        .mock-section-title { color: #6b8e23; text-align: center; font-size: 11px; font-weight: 900; margin: 8px 0 6px; }
        .mock-small { font-size: 7px; line-height: 1.45; color: #475569; }
        .mock-skills { display: grid; grid-template-columns: 1fr 1fr; gap: 5px 18px; margin-top: 8px; }
        .mock-work { margin: 14px -36px 10px; padding: 9px 36px; border: 3px solid #34d399; background: rgba(52, 211, 153, .13); }
        .mock-work-title { color: #6b8e23; text-align: center; font-size: 10px; font-weight: 900; margin-bottom: 7px; }
        .mock-job-row { display: flex; justify-content: space-between; gap: 10px; margin: 7px 0; }
        .mock-job-title { font-size: 8px; font-weight: 900; color: #64748b; }
        .mock-date { font-size: 7px; color: #64748b; font-style: italic; text-align: right; }
        .mock-bullets { font-size: 7px; color: #64748b; margin: 5px 0 0 10px; padding: 0; }
        .mock-bullets li { margin: 2px 0; }

        .detail-actions {
            position: absolute;
            right: 70px;
            bottom: 66px;
            display: none;
            align-items: center;
            gap: 26px;
            z-index: 20;
        }

        .work-main.detail-mode .detail-actions { display: flex; }

        .preview-outline-btn {
            width: 220px;
            height: 64px;
            border-radius: 999px;
            border: 2.5px solid #15168f;
            background: #ffffff;
            color: #15168f;
            font-size: 24px;
            font-weight: 950;
            cursor: pointer;
            transition: all .18s ease;
        }

        .preview-outline-btn:hover { background: #f8fafc; transform: translateY(-1px); }

        .detail-next-btn {
            width: 220px;
            height: 64px;
            border: 0;
            border-radius: 999px;
            background: #db1b83;
            color: #ffffff;
            font-size: 24px;
            font-weight: 950;
            cursor: pointer;
            transition: all .18s ease;
        }

        .detail-next-btn:hover { background: #c91675; transform: translateY(-1px); }

        .preview-modal-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, .72);
            z-index: 9999;
            padding: 22px;
        }

        .preview-modal-overlay.show { display: flex; }

        .preview-modal-card {
            position: relative;
            width: min(520px, 94vw);
            height: min(760px, 90vh);
            background: #ffffff;
            border-radius: 16px;
            padding: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 30px 80px rgba(0,0,0,.35);
        }

        .preview-modal-close {
            position: absolute;
            top: -14px;
            right: -14px;
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 999px;
            background: #ffffff;
            color: #0f172a;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 12px 32px rgba(0,0,0,.20);
        }

        .preview-modal-card .template-preview-frame { width: 100%; height: 100%; border: 0; }

        @media (max-width: 1200px) {
            .detail-view { grid-template-columns: minmax(0, 1fr) 430px; padding-right: 38px; }
            .detail-title { font-size: 38px; }
            .detail-text { font-size: 22px; }
            .template-preview-frame { width: 300px; height: 400px; }
            .detail-actions { right: 44px; }
        }

        @media (max-width: 1024px) {
            body {
                zoom: 1;
                width: 100%;
                height: auto;
                min-width: 0;
                min-height: 0;
                overflow: auto;
            }

            .builder-sidebar {
                position: relative;
                width: 100%;
                height: 82px;
                min-height: 82px;
                box-shadow: none;
            }

            .steps,
            .sidebar-progress,
            .sidebar-footer { display: none; }

            .sidebar-logo { top: 25px; left: 24px; font-size: 22px; }
            .sidebar-logo i { font-size: 27px; }

            .work-main {
                margin-left: 0;
                width: 100%;
                height: auto;
                min-height: calc(100vh - 82px);
                overflow: visible;
                padding: 34px 24px 80px;
            }

            .top-back { position: static; margin-bottom: 38px; font-size: 16px; }
            .choice-view { padding-top: 20px; max-width: 100%; }
            .page-title { font-size: 32px; white-space: normal; }
            .page-subtitle { font-size: 18px; margin-bottom: 36px; white-space: normal; transform: none; }
            .option-row { flex-direction: column; }
            .reason-btn { width: 100%; max-width: 420px; height: 78px; font-size: 22px; }
            .choice-actions { position: static; margin-top: 70px; justify-content: center; }
            .skip-link { font-size: 24px; }
            .next-btn { width: 210px; height: 64px; font-size: 22px; }
            .detail-view { grid-template-columns: 1fr; padding: 20px 0 100px; gap: 35px; }
            .detail-actions { position: static; justify-content: center; margin-top: 20px; }
        }
    
        /* GHOST FIX: Work History form screen - added without changing old screens */
        .job-form-view {
            display: none;
            height: 100%;
            padding: 112px 76px 80px 48px;
            overflow: hidden;
        }

        .work-main.job-form-mode .choice-view,
        .work-main.job-form-mode .choice-actions,
        .work-main.job-form-mode .detail-view,
        .work-main.job-form-mode .detail-actions,
        .work-main.job-form-mode .work-info-view {
            display: none !important;
        }

        .work-main.job-form-mode .job-form-view {
            display: block;
        }

        .job-form-wrap {
            width: min(100%, 980px);
            margin: 0 auto;
        }

        .job-form-title {
            color: #071022;
            font-size: 42px;
            line-height: 1.12;
            font-weight: 950;
            letter-spacing: .01em;
            margin: 0 0 10px;
        }

        .job-form-subtitle {
            color: #334155;
            font-size: 19px;
            line-height: 1.45;
            font-weight: 500;
            margin: 0 0 34px;
        }

        .job-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px 24px;
        }

        .job-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .job-field.full {
            grid-column: 1 / -1;
        }

        .job-field label {
            color: #071022;
            font-size: 15px;
            font-weight: 900;
            letter-spacing: .01em;
        }

        .job-field input,
        .job-field select {
            width: 100%;
            height: 54px;
            border: 1.6px solid #cbd5e1;
            border-radius: 10px;
            padding: 0 15px;
            color: #071022;
            font-size: 17px;
            font-weight: 600;
            outline: none;
            background: #ffffff;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .job-field input:focus,
        .job-field select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,.10);
        }

        .job-check-row {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #071022;
            font-size: 16px;
            font-weight: 800;
            margin-top: 2px;
            user-select: none;
        }

        .job-check-row input {
            width: 18px;
            height: 18px;
            accent-color: #db1b83;
        }

        .job-date-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .job-form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 22px;
            margin-top: 42px;
        }

        .job-save-note {
            margin-right: auto;
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
        }

        .job-preview-btn {
            width: 204px;
            height: 62px;
            border-radius: 999px;
            border: 2.5px solid #15168f;
            background: #ffffff;
            color: #15168f;
            font-size: 23px;
            font-weight: 950;
            cursor: pointer;
            transition: all .18s ease;
        }

        .job-preview-btn:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .job-next-btn {
            width: 204px;
            height: 62px;
            border: 0;
            border-radius: 999px;
            background: #db1b83;
            color: #ffffff;
            font-size: 23px;
            font-weight: 950;
            cursor: pointer;
            transition: all .18s ease;
        }

        .job-next-btn:hover {
            background: #c91675;
            transform: translateY(-1px);
        }

        .job-next-btn:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        @media (max-width: 1024px) {
            .job-form-view {
                padding: 20px 0 80px;
                overflow: visible;
            }

            .job-form-grid {
                grid-template-columns: 1fr;
            }

            .job-form-title {
                font-size: 32px;
            }

            .job-form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .job-save-note {
                margin-right: 0;
                text-align: center;
            }

            .job-preview-btn,
            .job-next-btn {
                width: 100%;
            }
        }

    </style>

<style id="ghost-job-form-ui-validation-final">
    /* GHOST FINAL: Work history form screen UI + validation, blue sidebar untouched */
    .work-main.job-form-mode {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        scroll-behavior: smooth !important;
    }

    .work-main.job-form-mode::-webkit-scrollbar {
        width: 12px !important;
    }

    .work-main.job-form-mode::-webkit-scrollbar-track {
        background: #f8fafc !important;
    }

    .work-main.job-form-mode::-webkit-scrollbar-thumb {
        background: #9ca3af !important;
        border-radius: 999px !important;
        border: 3px solid #f8fafc !important;
    }

    .job-form-view {
        min-height: 133.3333333333vh !important;
        height: auto !important;
        padding: 132px 54px 72px 54px !important;
        overflow: visible !important;
        background: #ffffff !important;
    }

    .work-main.job-form-mode .top-back {
        top: 76px !important;
        left: 48px !important;
        font-size: 18px !important;
        z-index: 30 !important;
    }

    .job-form-header {
        width: min(100%, 1320px) !important;
        margin: 0 auto 58px !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: space-between !important;
        gap: 30px !important;
    }

    .job-form-title {
        font-size: 52px !important;
        line-height: 1.12 !important;
        font-weight: 950 !important;
        letter-spacing: .08em !important;
        color: #071022 !important;
        margin: 0 0 24px !important;
    }

    .job-form-subtitle {
        font-size: 28px !important;
        line-height: 1.28 !important;
        color: #071022 !important;
        font-weight: 400 !important;
        margin: 0 !important;
    }

    .job-tips-link {
        margin-top: 72px !important;
        border: 0 !important;
        background: transparent !important;
        color: #0969da !important;
        font-size: 20px !important;
        font-weight: 900 !important;
        text-decoration: underline !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
        cursor: pointer !important;
    }

    .job-tips-link i {
        font-size: 22px !important;
        color: #0969da !important;
    }

    .required-note {
        width: min(100%, 1320px) !important;
        margin: 0 auto 36px !important;
        font-size: 21px !important;
        line-height: 1.2 !important;
        font-weight: 900 !important;
        color: #071022 !important;
    }

    #workHistoryForm {
        width: min(100%, 1320px) !important;
        margin: 0 auto !important;
    }

    .job-form-grid {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 34px 46px !important;
        width: 100% !important;
    }

    .job-field {
        display: flex !important;
        flex-direction: column !important;
        gap: 9px !important;
        min-width: 0 !important;
    }

    .job-field.full {
        grid-column: 1 / -1 !important;
    }

    .job-field.location-field {
        grid-column: 1 / 2 !important;
    }

    .job-field label:not(.job-check-row) {
        font-size: 22px !important;
        line-height: 1.1 !important;
        font-weight: 950 !important;
        color: #071022 !important;
        letter-spacing: 0 !important;
    }

    .job-field label span {
        color: #071022 !important;
    }

    .job-field input[type="text"],
    .job-field select {
        width: 100% !important;
        height: 72px !important;
        border: 1.8px solid #94a3b8 !important;
        border-radius: 4px !important;
        padding: 0 22px !important;
        color: #071022 !important;
        font-size: 24px !important;
        line-height: 1 !important;
        font-weight: 400 !important;
        background: #ffffff !important;
        outline: none !important;
        box-shadow: none !important;
        transition: border-color .18s ease, box-shadow .18s ease !important;
    }

    .job-field input::placeholder {
        color: #64748b !important;
        opacity: .95 !important;
    }

    .job-field input[type="text"]:focus,
    .job-field select:focus {
        border-color: #0969da !important;
        box-shadow: 0 0 0 2px rgba(9,105,218,.14) !important;
    }

    .job-field.has-error input[type="text"],
    .job-field.has-error select {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 2px rgba(220,38,38,.12) !important;
    }

    .field-error {
        min-height: 18px !important;
        color: #dc2626 !important;
        font-size: 14px !important;
        line-height: 1.2 !important;
        font-weight: 800 !important;
        display: block !important;
    }

    .job-date-row {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 38px !important;
    }

    .job-field select {
        appearance: none !important;
        -webkit-appearance: none !important;
        background-image:
            linear-gradient(45deg, transparent 50%, #8b95a1 50%),
            linear-gradient(135deg, #8b95a1 50%, transparent 50%) !important;
        background-position:
            calc(100% - 32px) 31px,
            calc(100% - 20px) 31px !important;
        background-size: 12px 12px, 12px 12px !important;
        background-repeat: no-repeat !important;
    }

    .job-check-row {
        display: inline-flex !important;
        align-items: center !important;
        gap: 15px !important;
        color: #071022 !important;
        font-size: 28px !important;
        line-height: 1 !important;
        font-weight: 400 !important;
        margin-top: 2px !important;
        user-select: none !important;
        width: fit-content !important;
        cursor: pointer !important;
    }

    .job-check-row input[type="checkbox"] {
        position: absolute !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }

    .custom-check {
        width: 36px !important;
        height: 36px !important;
        border: 1.8px solid #94a3b8 !important;
        border-radius: 4px !important;
        background: #ffffff !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex: 0 0 36px !important;
        transition: all .18s ease !important;
    }

    .job-check-row input[type="checkbox"]:checked + .custom-check {
        background: #db1b83 !important;
        border-color: #db1b83 !important;
    }

    .job-check-row input[type="checkbox"]:checked + .custom-check::after {
        content: "✓" !important;
        color: #ffffff !important;
        font-size: 26px !important;
        font-weight: 950 !important;
        line-height: 1 !important;
    }

    .remote-info-icon {
        font-size: 26px !important;
        color: #071022 !important;
        margin-left: 4px !important;
    }

    .current-check-field {
        margin-top: 26px !important;
        grid-column: 2 / 3 !important;
    }

    .job-form-actions {
        display: flex !important;
        justify-content: flex-end !important;
        align-items: center !important;
        gap: 28px !important;
        margin-top: 62px !important;
        padding-bottom: 40px !important;
    }

    .job-preview-btn,
    .job-next-btn {
        width: 260px !important;
        height: 72px !important;
        border-radius: 999px !important;
        font-size: 28px !important;
        font-weight: 950 !important;
        cursor: pointer !important;
        transition: all .18s ease !important;
    }

    .job-preview-btn {
        border: 2.8px solid #15168f !important;
        background: #ffffff !important;
        color: #15168f !important;
    }

    .job-preview-btn:hover {
        background: #f8fafc !important;
        transform: translateY(-1px) !important;
    }

    .job-next-btn {
        border: 0 !important;
        background: #db1b83 !important;
        color: #ffffff !important;
    }

    .job-next-btn:hover {
        background: #c91675 !important;
        transform: translateY(-1px) !important;
    }

    .job-next-btn:disabled {
        opacity: .65 !important;
        cursor: not-allowed !important;
        transform: none !important;
    }

    .job-form-alert {
        position: fixed !important;
        top: 22px !important;
        left: calc(360px + 50%) !important;
        transform: translateX(-50%) translateY(-120%) !important;
        min-width: 420px !important;
        max-width: 680px !important;
        padding: 17px 22px !important;
        border-radius: 12px !important;
        background: #fee2e2 !important;
        border: 1px solid #fecaca !important;
        color: #991b1b !important;
        font-size: 16px !important;
        font-weight: 900 !important;
        line-height: 1.35 !important;
        box-shadow: 0 18px 45px rgba(15,23,42,.18) !important;
        opacity: 0 !important;
        pointer-events: none !important;
        z-index: 9998 !important;
        transition: all .24s ease !important;
    }

    .job-form-alert.show {
        opacity: 1 !important;
        transform: translateX(-50%) translateY(0) !important;
    }

    .job-form-alert.success {
        background: #dcfce7 !important;
        border-color: #bbf7d0 !important;
        color: #166534 !important;
    }

    .job-save-note {
        display: none !important;
    }

    @media (max-width: 1280px) {
        .job-form-title {
            font-size: 46px !important;
        }

        .job-form-subtitle {
            font-size: 24px !important;
        }

        .job-field input[type="text"],
        .job-field select {
            height: 66px !important;
            font-size: 22px !important;
        }

        .job-check-row {
            font-size: 25px !important;
        }
    }
</style>


<style id="ghost-remote-info-tooltip-final">
    /* GHOST FINAL: Remote small info icon tooltip only */
    .remote-info-icon {
        position: relative !important;
        cursor: pointer !important;
        z-index: 50 !important;
    }

    .remote-tooltip-box {
        position: absolute !important;
        left: -22px !important;
        top: 46px !important;
        width: 360px !important;
        padding: 22px 24px !important;
        background: #ffffff !important;
        color: #071022 !important;
        border-radius: 4px !important;
        box-shadow: 0 8px 28px rgba(15, 23, 42, .22) !important;
        font-size: 22px !important;
        line-height: 1.32 !important;
        font-weight: 400 !important;
        text-align: left !important;
        opacity: 0 !important;
        visibility: hidden !important;
        transform: translateY(-8px) !important;
        pointer-events: none !important;
        transition: opacity .18s ease, transform .18s ease, visibility .18s ease !important;
        z-index: 9999 !important;
    }

    .remote-tooltip-box::before {
        content: "" !important;
        position: absolute !important;
        top: -13px !important;
        left: 156px !important;
        width: 26px !important;
        height: 26px !important;
        background: #ffffff !important;
        transform: rotate(45deg) !important;
        box-shadow: -4px -4px 8px rgba(15, 23, 42, .04) !important;
    }

    .remote-info-wrap {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    .remote-info-wrap:hover .remote-tooltip-box,
    .remote-info-wrap.tooltip-open .remote-tooltip-box {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
    }
</style>


<style id="ghost-work-ready-examples-from-education-fix">
    .work-ready-card {
        width: 100% !important;
        background: #ffffff !important;
        border: 1.8px solid #cbd5e1 !important;
        border-radius: 18px !important;
        padding: 22px !important;
        box-shadow: 0 16px 38px rgba(15, 23, 42, .06) !important;
    }

    .work-ready-eyebrow {
        margin: 0 0 6px !important;
        color: #64748b !important;
        font-size: 13px !important;
        font-weight: 950 !important;
        text-transform: uppercase !important;
        letter-spacing: .11em !important;
    }

    .work-ready-head h2 {
        margin: 0 0 8px !important;
        color: #071022 !important;
        font-size: 30px !important;
        line-height: 1.12 !important;
        font-weight: 950 !important;
        letter-spacing: -.03em !important;
    }

    .work-ready-sub {
        margin: 0 0 16px !important;
        color: #475569 !important;
        font-size: 16px !important;
        line-height: 1.45 !important;
        font-weight: 650 !important;
    }

    .work-protip-box {
        display: flex !important;
        gap: 12px !important;
        align-items: flex-start !important;
        background: #eff6ff !important;
        border-left: 5px solid #2563eb !important;
        border-radius: 12px !important;
        padding: 15px 16px !important;
        margin-bottom: 18px !important;
    }

    .work-protip-box i {
        color: #0f172a !important;
        font-size: 18px !important;
        margin-top: 3px !important;
    }

    .work-protip-box p {
        margin: 0 !important;
        color: #334155 !important;
        font-size: 14px !important;
        line-height: 1.48 !important;
        font-weight: 700 !important;
    }

    .work-protip-box strong { color: #071022 !important; font-weight: 950 !important; }

    .work-example-accordion {
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        overflow: hidden !important;
        background: #ffffff !important;
    }

    .work-example-item + .work-example-item { border-top: 1px solid #e2e8f0 !important; }

    .work-example-header {
        width: 100% !important;
        border: 0 !important;
        background: #ffffff !important;
        color: #0f172a !important;
        padding: 15px 16px !important;
        font-size: 16px !important;
        font-weight: 950 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        cursor: pointer !important;
        text-align: left !important;
    }

    .work-example-header:hover { background: #f8fafc !important; }
    .work-example-header i { color: #64748b !important; transition: transform .22s ease !important; }
    .work-example-header.open i { transform: rotate(180deg) !important; }

    .work-example-body {
        padding: 14px 16px 16px !important;
        background: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
    }

    .hidden-work-example { display: none !important; }

    .work-example-body p {
        margin: 0 0 10px !important;
        color: #64748b !important;
        font-size: 13px !important;
        line-height: 1.35 !important;
        font-weight: 750 !important;
    }

    .work-example-list {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
    }

    .work-example-list button {
        border: 1.6px solid #cbd5e1 !important;
        border-radius: 999px !important;
        background: #ffffff !important;
        color: #334155 !important;
        padding: 8px 12px !important;
        font-size: 13px !important;
        line-height: 1 !important;
        font-weight: 850 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 7px !important;
        cursor: pointer !important;
        transition: all .18s ease !important;
    }

    .work-example-list button:hover {
        border-color: #2563eb !important;
        background: #eff6ff !important;
        color: #0f172a !important;
        transform: translateY(-1px) !important;
    }

    .work-example-list span {
        width: 18px !important;
        height: 18px !important;
        border-radius: 999px !important;
        background: #dbeafe !important;
        color: #2563eb !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 13px !important;
        font-weight: 950 !important;
    }

    .work-info-view .work-info-left {
        align-self: flex-start !important;
        padding-top: 10px !important;
    }

    .work-info-view .work-info-right {
        padding-top: 10px !important;
    }

    .more-info-summary h1 {
        margin-bottom: 12px !important;
    }

    .more-info-summary p {
        margin-bottom: 22px !important;
    }
</style>


<!-- GHOST FINAL PATCH: align IT achievement example buttons in clean 2-column grid -->
<style id="ghost-it-achievements-button-alignment-final">
    .work-example-body .work-example-list {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        column-gap: 14px !important;
        row-gap: 10px !important;
        align-items: stretch !important;
        width: 100% !important;
    }

    .work-example-body .work-example-list button {
        width: 100% !important;
        min-height: 40px !important;
        height: 40px !important;
        justify-content: flex-start !important;
        align-items: center !important;
        padding: 0 13px !important;
        margin: 0 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        line-height: 1 !important;
    }

    .work-example-body .work-example-list button span {
        flex: 0 0 18px !important;
        margin-right: 1px !important;
    }

    @media (max-width: 980px) {
        .work-example-body .work-example-list {
            grid-template-columns: 1fr !important;
        }
    }
</style>

</head>

<body>
    <aside class="builder-sidebar">
        <div class="sidebar-logo">
            <i class="fa-solid fa-layer-group"></i>
            <span>Resume Builder</span>
        </div>

        <div class="steps">
            <div class="step done"><span class="step-circle">1</span><span>Heading</span></div>
            <div class="step active"><span class="step-circle">2</span><span>Work history</span></div>
            <div class="step"><span class="step-circle">3</span><span>Education</span></div>
            <div class="step"><span class="step-circle">4</span><span>Skills</span></div>
            <div class="step"><span class="step-circle">5</span><span>Summary</span></div>
            <div class="step"><span class="step-circle">6</span><span>Finalize</span></div>
        </div>

        <div class="sidebar-progress">
            <div class="sidebar-progress-title">Resume Completeness:</div>
            <div class="progress-row">
                <div class="progress-track"><div class="progress-fill"></div></div>
                <div class="progress-number">20%</div>
            </div>
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

    <main class="work-main" id="workMain">
        <a href="/builder/contact" class="top-back" id="topBackLink">
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
        </a>

        <section class="choice-view" id="choiceView">
            <h1 class="page-title">Why do you need a resume?</h1>
            <p class="page-subtitle">We'll show you a personalized experience based on your response.</p>

            <div class="option-row">
                <button type="button" class="reason-btn" data-reason="job_seeking">Job Seeking</button>
                <button type="button" class="reason-btn" data-reason="different_reason">A Different reason</button>
            </div>
        </section>

        <div class="choice-actions" id="choiceActions">
            <button type="button" id="btnSkip" class="skip-link">Skip for now</button>
            <button type="button" id="btnNextWorkHistory" class="next-btn" disabled>Next</button>
        </div>

        <section class="detail-view" id="detailView">
            <div class="detail-copy">
                <h1 class="detail-title" id="detailTitle">Now, let’s fill out your<br>Work history</h1>
                <p class="detail-strong">Here’s what you need to know:</p>
                <p class="detail-text" id="detailText">Employers scan your resume to see if you’re a match.<br>We'll suggest bullet points that make a great impression.</p>
            </div>

            <aside class="detail-template-side">
                <div class="template-preview-frame" id="templatePreviewFrame">
                    <img id="selectedTemplateImage" class="selected-template-img" alt="Selected resume template preview">

                    <div class="mock-resume-preview" id="mockResumePreview">
                        <div class="mock-top-bar"></div>
                        <div class="mock-resume-inner">
                            <div class="mock-name" id="mockName">ARMAGHAN SHAHZAD</div>
                            <div class="mock-role">Typing Pakistan</div>
                            <div class="mock-contact">
                                <span id="mockPhone">+9230 5356621</span>
                                <span id="mockEmail">23-se-051@student.hitec.edu.pk</span>
                            </div>
                            <div class="mock-line"></div>
                            <p class="mock-small">Use this section to give recruiters a quick glimpse of your professional profile.</p>
                            <div class="mock-section-title">Skills</div>
                            <div class="mock-line"></div>
                            <div class="mock-skills">
                                <span class="mock-small">Skill 1</span><span class="mock-small">Skill 2</span>
                                <span class="mock-small">Skill 3</span><span class="mock-small">Skill 4</span>
                            </div>
                            <div class="mock-work">
                                <div class="mock-work-title">Work History</div>
                                <p class="mock-small">Summarize your work experience by listing each job and responsibilities.</p>
                                <div class="mock-job-row">
                                    <div>
                                        <div class="mock-job-title">Job Title 1</div>
                                        <div class="mock-small">Company Name</div>
                                    </div>
                                    <div class="mock-date">Time employed<br>Month/year</div>
                                </div>
                                <ul class="mock-bullets"><li>Responsibilities</li><li>Responsibilities</li></ul>
                                <div class="mock-job-row">
                                    <div>
                                        <div class="mock-job-title">Job Title 2</div>
                                        <div class="mock-small">Company Name</div>
                                    </div>
                                    <div class="mock-date">Time employed<br>Month/year</div>
                                </div>
                                <ul class="mock-bullets"><li>Responsibilities</li><li>Responsibilities</li></ul>
                            </div>
                            <div class="mock-section-title">Education</div>
                            <div class="mock-line"></div>
                            <p class="mock-small">Include your school name and the year you graduated.</p>
                        </div>
                    </div>

                    <div class="work-highlight-box" id="templateHighlightBox"></div>
                </div>
            </aside>
        </section>


        <section class="job-form-view" id="jobFormView">
            <div id="jobFormAlert" class="job-form-alert" role="alert"></div>

            <div class="job-form-header">
                <div>
                    <h1 class="job-form-title">Tell us about your most<br>recent job</h1>
                    <p class="job-form-subtitle">We’ll start there and work backward.</p>
                </div>

                <button type="button" class="job-tips-link" id="jobTipsBtn">
                    <i class="fa-regular fa-lightbulb"></i>
                    <span>Tips</span>
                </button>
            </div>

            <div class="required-note">* indicates a required field</div>

            <form id="workHistoryForm" autocomplete="off" novalidate>
                <div class="job-form-grid">
                    <div class="job-field">
                        <label for="jobTitle">Title <span>*</span></label>
                        <input type="text" id="jobTitle" name="job_title" placeholder="Sales Manager" data-required="true">
                        <small class="field-error" id="jobTitleError"></small>
                    </div>

                    <div class="job-field">
                        <label for="employer">Employer <span>*</span></label>
                        <input type="text" id="employer" name="employer" placeholder="Peshawar Agriculture Cooperative" data-required="true">
                        <small class="field-error" id="employerError"></small>
                    </div>

                    <div class="job-field location-field">
                        <label for="jobCity">Location</label>
                        <input type="text" id="jobCity" name="city" placeholder="Peshawar, Pakistan">
                        <input type="hidden" id="jobCountry" name="country" value="">
                    </div>

                    <div class="job-field full">
                        <label class="job-check-row">
                            <input type="checkbox" id="isRemote" name="is_remote">
                            <span class="custom-check"></span>
                            <span>Remote</span>
                            <span class="remote-info-wrap" id="remoteInfoWrap">
                                <i class="fa-solid fa-circle-info remote-info-icon" id="remoteInfoIcon"></i>
                                <span class="remote-tooltip-box" id="remoteTooltipBox">
                                    Was this job remote? Checking this box will let employers know by showing the status in parenthesis. This selection is optional.
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="job-field">
                        <label>Start Date <span id="startDateRequiredStar" class="start-date-required-star">*</span></label>
                        <div class="job-date-row">
                            <select id="startMonth" name="start_month">
                                <option value="">Month</option>
                                <option>January</option><option>February</option><option>March</option>
                                <option>April</option><option>May</option><option>June</option>
                                <option>July</option><option>August</option><option>September</option>
                                <option>October</option><option>November</option><option>December</option>
                            </select>
                            <input type="text" id="startYear" name="start_year" maxlength="4" placeholder="Year">
                        </div>
                        <small class="field-error" id="startYearError"></small>
                    </div>

                    <div class="job-field">
                        <label>End Date</label>
                        <div class="job-date-row">
                            <select id="endMonth" name="end_month">
                                <option value="">Month</option>
                                <option>January</option><option>February</option><option>March</option>
                                <option>April</option><option>May</option><option>June</option>
                                <option>July</option><option>August</option><option>September</option>
                                <option>October</option><option>November</option><option>December</option>
                            </select>
                            <input type="text" id="endYear" name="end_year" maxlength="4" placeholder="Year">
                        </div>
                    </div>

                    <div class="job-field full current-check-field">
                        <label class="job-check-row currently-row">
                            <input type="checkbox" id="currentlyWorking" name="currently_working">
                            <span class="custom-check"></span>
                            <span>I currently work here</span>
                        </label>
                    </div>
                </div>

                <div class="job-form-actions">
                    <button type="button" class="job-preview-btn" id="btnPreviewJobForm">Preview</button>
                    <button type="submit" class="job-next-btn" id="btnSaveWorkHistory">Next</button>
                </div>
            </form>
        </section>


        <!-- GHOST FINAL: Add More Info screen like reference video -->
        <section class="work-info-view" id="workInfoView">
            <div class="work-info-topbar" id="workInfoTopbar">
                <div class="work-info-top-copy">
                    <h1>What did you do as a <span id="workInfoQuestionRole">Sales Manager</span>?</h1>
                    <p>To get started, you can choose from our personalized suggestions which we've tailored to your experience.</p>
                </div>
                <button type="button" class="work-info-tips" id="workInfoTipsBtn">
                    <i class="fa-regular fa-lightbulb"></i>
                    <span>Tips</span>
                </button>
            </div>
            <div class="work-info-left">
                <div class="work-search-card" id="workSearchCard">
                    <h2>Search by job title for pre-written examples</h2>
                    <div class="work-search-row">
                        <input type="text" id="moreInfoSearchTitle" value="Sales Manager" placeholder="Job title">
                        <button type="button" id="btnMoreInfoSearch"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <div class="related-title">Related job title</div>
                    <div class="related-grid">
                        <button type="button" id="moreInfoResultTitle">Sales Manager</button>
                    </div>
                </div>
                <div class="work-ready-card">
                    <div class="work-ready-head">
                        <p class="work-ready-eyebrow">Ready to use examples</p>
                        <h2>Add achievements and responsibilities</h2>
                        <p class="work-ready-sub">Choose strong bullet points below. Click any example and it will be added to the editor on the right.</p>
                    </div>

                    <div class="work-protip-box">
                        <i class="fa-solid fa-lightbulb"></i>
                        <p><strong>Pro Tip</strong> Use 3-5 clear points that show results, responsibilities, teamwork, tools, and customer impact.</p>
                    </div>

                    <div class="work-example-accordion">
                        <div class="work-example-item">
                            <button type="button" class="work-example-header" onclick="toggleWorkExampleCategory('work-cat-it', this)">
                                IT achievements <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div id="work-cat-it" class="work-example-body">
                                <p>Use these examples for software, web, database, support, and IT project work.</p>
                                <div class="work-example-list">
                                    <button type="button" onclick="addWorkBullet('Developed responsive web pages using HTML, CSS, JavaScript, and modern UI practices to improve user experience.')"><span>+</span> Built responsive pages</button>
                                    <button type="button" onclick="addWorkBullet('Created and maintained backend APIs to connect frontend forms with database records securely and efficiently.')"><span>+</span> Built backend APIs</button>
                                    <button type="button" onclick="addWorkBullet('Integrated authentication and authorization features to protect user accounts and role-based access.')"><span>+</span> Added secure auth</button>
                                    <button type="button" onclick="addWorkBullet('Designed database tables and relationships to store user, project, and transaction data in an organized structure.')"><span>+</span> Designed databases</button>
                                    <button type="button" onclick="addWorkBullet('Optimized SQL queries and database operations to improve page loading speed and data retrieval performance.')"><span>+</span> Optimized queries</button>
                                    <button type="button" onclick="addWorkBullet('Fixed frontend layout issues, form validation errors, and responsive design problems across multiple pages.')"><span>+</span> Fixed UI issues</button>
                                    <button type="button" onclick="addWorkBullet('Implemented client-side and server-side validation to reduce incorrect data entry and improve form reliability.')"><span>+</span> Added validation</button>
                                    <button type="button" onclick="addWorkBullet('Tested application features, identified bugs, and documented issues for faster debugging and maintenance.')"><span>+</span> Tested features</button>
                                    <button type="button" onclick="addWorkBullet('Used Git and GitHub to manage source code, track changes, and collaborate on project updates.')"><span>+</span> Managed Git workflow</button>
                                    <button type="button" onclick="addWorkBullet('Deployed web application updates and verified live functionality after configuration changes.')"><span>+</span> Deployed updates</button>
                                    <button type="button" onclick="addWorkBullet('Connected application forms with REST APIs to save, update, and display user data dynamically.')"><span>+</span> Connected REST APIs</button>
                                    <button type="button" onclick="addWorkBullet('Improved application security by handling tokens, protected routes, and authenticated API requests.')"><span>+</span> Improved security</button>
                                    <button type="button" onclick="addWorkBullet('Troubleshot server, database, and environment configuration issues to keep the application running smoothly.')"><span>+</span> Troubleshot systems</button>
                                    <button type="button" onclick="addWorkBullet('Created reusable components to reduce repeated code and improve maintainability across the project.')"><span>+</span> Reused components</button>
                                    <button type="button" onclick="addWorkBullet('Implemented dynamic preview features to show user-entered information in real time.')"><span>+</span> Built live preview</button>
                                    <button type="button" onclick="addWorkBullet('Configured file upload and preview functionality to improve user interaction with documents and templates.')"><span>+</span> Added file upload</button>
                                    <button type="button" onclick="addWorkBullet('Analyzed error logs and browser console messages to diagnose application issues quickly.')"><span>+</span> Debugged errors</button>
                                    <button type="button" onclick="addWorkBullet('Improved page navigation and user flow by updating buttons, redirects, and popup interactions.')"><span>+</span> Improved user flow</button>
                                    <button type="button" onclick="addWorkBullet('Built admin-side features to manage records, monitor users, and control project data more efficiently.')"><span>+</span> Built admin features</button>
                                    <button type="button" onclick="addWorkBullet('Documented setup steps, project workflow, and technical changes for easier future maintenance.')"><span>+</span> Wrote documentation</button>
                                </div>
                            </div>
                        </div>

                        <div class="work-example-item">
                            <button type="button" class="work-example-header" onclick="toggleWorkExampleCategory('work-cat-1', this)">
                                Sales achievements <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div id="work-cat-1" class="work-example-body hidden-work-example">
                                <p>Show measurable wins and sales growth.</p>
                                <div class="work-example-list">
                                    <button type="button" onclick="addWorkBullet('Increased monthly sales by building strong customer relationships and following up on qualified leads.')"><span>+</span> Increased monthly sales</button>
                                    <button type="button" onclick="addWorkBullet('Consistently met or exceeded sales targets through effective product presentations and client communication.')"><span>+</span> Exceeded sales targets</button>
                                    <button type="button" onclick="addWorkBullet('Identified new business opportunities and converted prospects into repeat customers.')"><span>+</span> Converted prospects</button>
                                </div>
                            </div>
                        </div>

                        <div class="work-example-item">
                            <button type="button" class="work-example-header" onclick="toggleWorkExampleCategory('work-cat-projects', this)">
                                Project achievements <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div id="work-cat-projects" class="work-example-body hidden-work-example">
                                <p>Show project delivery, planning, teamwork, and problem solving.</p>
                                <div class="work-example-list">
                                    <button type="button" onclick="addWorkBullet('Completed semester and client-style projects by planning tasks, dividing work, and meeting project deadlines.')"><span>+</span> Completed projects</button>
                                    <button type="button" onclick="addWorkBullet('Converted project requirements into working features by analyzing user needs and applying practical development steps.')"><span>+</span> Built features</button>
                                    <button type="button" onclick="addWorkBullet('Improved project quality by reviewing design, fixing issues, and testing important user flows before submission.')"><span>+</span> Improved quality</button>
                                </div>
                            </div>
                        </div>

                        <div class="work-example-item">
                            <button type="button" class="work-example-header" onclick="toggleWorkExampleCategory('work-cat-support', this)">
                                Technical support <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div id="work-cat-support" class="work-example-body hidden-work-example">
                                <p>Use these examples for troubleshooting, system setup, and user support.</p>
                                <div class="work-example-list">
                                    <button type="button" onclick="addWorkBullet('Resolved technical issues by checking errors, testing possible fixes, and applying stable solutions.')"><span>+</span> Resolved issues</button>
                                    <button type="button" onclick="addWorkBullet('Configured development tools, databases, and local servers to support smooth project execution.')"><span>+</span> Configured tools</button>
                                    <button type="button" onclick="addWorkBullet('Supported users and team members by explaining technical steps clearly and documenting common fixes.')"><span>+</span> Supported users</button>
                                </div>
                            </div>
                        </div>

                        <div class="work-example-item">
                            <button type="button" class="work-example-header" onclick="toggleWorkExampleCategory('work-cat-2', this)">
                                Customer service <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div id="work-cat-2" class="work-example-body hidden-work-example">
                                <p>Highlight customer handling and communication.</p>
                                <div class="work-example-list">
                                    <button type="button" onclick="addWorkBullet('Assisted customers with product selection, pricing details, and after-sales support to improve satisfaction.')"><span>+</span> Assisted customers</button>
                                    <button type="button" onclick="addWorkBullet('Resolved customer concerns professionally while maintaining company service standards.')"><span>+</span> Resolved concerns</button>
                                    <button type="button" onclick="addWorkBullet('Maintained positive client relationships through clear communication and timely follow-ups.')"><span>+</span> Client relationships</button>
                                </div>
                            </div>
                        </div>

                        <div class="work-example-item">
                            <button type="button" class="work-example-header" onclick="toggleWorkExampleCategory('work-cat-3', this)">
                                Team leadership <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div id="work-cat-3" class="work-example-body hidden-work-example">
                                <p>Use these if you guided people or coordinated work.</p>
                                <div class="work-example-list">
                                    <button type="button" onclick="addWorkBullet('Coordinated daily team activities to ensure smooth workflow and timely task completion.')"><span>+</span> Coordinated team</button>
                                    <button type="button" onclick="addWorkBullet('Trained new staff members on product knowledge, customer handling, and company procedures.')"><span>+</span> Trained staff</button>
                                    <button type="button" onclick="addWorkBullet('Supported team members in meeting performance targets and improving service quality.')"><span>+</span> Supported targets</button>
                                </div>
                            </div>
                        </div>

                        <div class="work-example-item">
                            <button type="button" class="work-example-header" onclick="toggleWorkExampleCategory('work-cat-4', this)">
                                Reporting and operations <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div id="work-cat-4" class="work-example-body hidden-work-example">
                                <p>Show organization, reporting, and daily operations.</p>
                                <div class="work-example-list">
                                    <button type="button" onclick="addWorkBullet('Prepared daily sales reports and maintained accurate records of customer interactions and transactions.')"><span>+</span> Sales reports</button>
                                    <button type="button" onclick="addWorkBullet('Monitored inventory levels and coordinated with team members to keep products available for customers.')"><span>+</span> Inventory support</button>
                                    <button type="button" onclick="addWorkBullet('Followed company policies and operational procedures to maintain accurate and efficient workflow.')"><span>+</span> Operational workflow</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="work-info-right">
                <div class="more-info-summary">
                    <h1><span id="moreInfoJobTitle">Sales Manager</span> <span>|</span> <span id="moreInfoEmployer">Employer</span></h1>
                    <p id="moreInfoMeta">Location - Start Date - Current</p>
                </div>

                <div class="more-info-editor">
                    <div class="more-info-toolbar">
                        <button type="button"><b>B</b></button>
                        <button type="button"><i>I</i></button>
                        <button type="button"><u>U</u></button>
                        <button type="button"><i class="fa-solid fa-list-ul"></i></button>
                        <button type="button" class="toolbar-active">A<span>B</span></button>
                        <button type="button"><i class="fa-solid fa-text-slash"></i></button>
                        <button type="button"><i class="fa-solid fa-link"></i></button>
                        <button type="button"><i class="fa-solid fa-rotate-left"></i></button>
                        <button type="button"><i class="fa-solid fa-rotate-right"></i></button>
                    </div>

                    <button type="button" class="enhance-ai-btn">✦ Smart suggestions (will be applied soon)</button>
                    <div id="workAchievementsEditor" class="work-achievements-editor" contenteditable="true" data-placeholder="Type your achievements and responsibilities here."></div>
                </div>

                <div class="work-info-actions">
                    <button type="button" class="job-preview-btn" id="btnPreviewMoreInfo">Preview</button>
                    <button type="button" class="job-next-btn" id="btnNextMoreInfo">Next</button>
                </div>
            </div>
        </section>

        <div class="detail-actions" id="detailActions">
            <button type="button" class="preview-outline-btn" id="btnPreviewWork">Preview</button>
            <button type="button" class="detail-next-btn" id="btnFinalNextWork">Next</button>
        </div>
    </main>

    <!-- GHOST FINAL: other work experience popup before moving to Education -->
    <div class="other-experience-overlay" id="otherExperiencePopup" aria-hidden="true">
        <div class="other-experience-card" role="dialog" aria-modal="true">
            <button type="button" class="other-experience-close" id="closeOtherExperiencePopup" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="other-experience-left">
                <h2 id="otherPopupTitle">Don't forget to include other<br>work experience</h2>
                <p id="otherPopupText">You can add internships,<br>professional licenses, volunteer<br>work and unpaid jobs.</p>

                <button type="button" class="other-add-btn" id="btnAddAnotherExperience">Add experience</button>
                <button type="button" class="other-no-thanks" id="btnNoThanksExperience">Skip now</button>
            </div>

            <div class="other-experience-right">
                <div class="other-template-frame">
                    <img id="otherExperienceTemplateImage" class="other-template-img" alt="Resume template preview">
                    <div class="other-template-fallback">Resume Preview</div>
                    <div class="other-highlight-box"></div>
                </div>
            </div>
        </div>
    </div>



    <!-- GHOST UPDATE: choose what extra info to add before opening Add More Info screen -->
    <div class="more-info-choice-overlay" id="moreInfoChoicePopup" aria-hidden="true">
        <div class="more-info-choice-card" role="dialog" aria-modal="true">
            <button type="button" class="more-info-choice-close" id="closeMoreInfoChoicePopup" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h2>What would you like to add?</h2>
            <p>Choose the extra information you want to improve for this work experience.</p>

            <div class="more-info-choice-list">
                <button type="button" class="more-info-choice-option active" id="btnChooseAchievements">
                    <span class="choice-icon"><i class="fa-solid fa-list-check"></i></span>
                    <span>
                        <strong>Achievements & responsibilities</strong>
                        <small>Add bullet points and job details for this role.</small>
                    </span>
                </button>

                <button type="button" class="more-info-choice-option soon" disabled>
                    <span class="choice-icon"><i class="fa-regular fa-lightbulb"></i></span>
                    <span>
                        <strong>Smart wording help</strong>
                        <small>Will be applied soon.</small>
                    </span>
                </button>
            </div>

            <button type="button" class="more-info-choice-main" id="btnContinueMoreInfoChoice">Continue</button>
            <button type="button" class="more-info-choice-skip" id="btnSkipMoreInfoChoice">Skip now</button>
        </div>
    </div>

    <div class="preview-modal-overlay" id="workPreviewModal">
        <div class="preview-modal-card">
            <button type="button" class="preview-modal-close" id="closeWorkPreview"><i class="fa-solid fa-xmark"></i></button>
            <div class="template-preview-frame" id="modalTemplateFrame">
                <img id="modalTemplateImage" class="selected-template-img" alt="Selected resume template large preview">
                <div class="mock-resume-preview" id="modalMockResumePreview"></div>
                <div class="work-highlight-box"></div>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('resume_token');
        const resumeId = localStorage.getItem('current_resume_id');

        if (!token || !resumeId) {
            window.location.href = '/login';
        }

        let detailModeOpen = localStorage.getItem('resume_work_history_detail_open') === 'true';
        let formModeOpen = localStorage.getItem('resume_work_history_form_open') === 'true';
        let selectedReason = localStorage.getItem('resume_work_history_reason') || '';

        // Fresh entry from Contact page should not auto-select old button.
        // Selection is preserved only while same-page detail/form flow is open.
        if (!detailModeOpen && !formModeOpen) {
            selectedReason = '';
            localStorage.removeItem('resume_work_history_reason');
        }

        const workMain = document.getElementById('workMain');
        const topBackLink = document.getElementById('topBackLink');
        const reasonButtons = document.querySelectorAll('.reason-btn');
        const nextBtn = document.getElementById('btnNextWorkHistory');
        const skipBtn = document.getElementById('btnSkip');
        const detailTitle = document.getElementById('detailTitle');
        const detailText = document.getElementById('detailText');
        const btnFinalNextWork = document.getElementById('btnFinalNextWork');
        const btnPreviewWork = document.getElementById('btnPreviewWork');
        const workPreviewModal = document.getElementById('workPreviewModal');
        const closeWorkPreview = document.getElementById('closeWorkPreview');
        const templatePreviewFrame = document.getElementById('templatePreviewFrame');
        const selectedTemplateImage = document.getElementById('selectedTemplateImage');
        const modalTemplateFrame = document.getElementById('modalTemplateFrame');
        const modalTemplateImage = document.getElementById('modalTemplateImage');
        const modalMockResumePreview = document.getElementById('modalMockResumePreview');
        const mockResumePreview = document.getElementById('mockResumePreview');

        const workHistoryForm = document.getElementById('workHistoryForm');
        const btnPreviewJobForm = document.getElementById('btnPreviewJobForm');
        const btnSaveWorkHistory = document.getElementById('btnSaveWorkHistory');
        const currentlyWorking = document.getElementById('currentlyWorking');
        const endMonth = document.getElementById('endMonth');
        const endYear = document.getElementById('endYear');
        const jobAlert = document.getElementById('jobFormAlert');
        const jobTipsBtn = document.getElementById('jobTipsBtn');
        const startYearField = document.getElementById('startYear');
        const otherExperiencePopup = document.getElementById('otherExperiencePopup');
        const closeOtherExperiencePopup = document.getElementById('closeOtherExperiencePopup');
        const btnAddAnotherExperience = document.getElementById('btnAddAnotherExperience');
        const btnNoThanksExperience = document.getElementById('btnNoThanksExperience');
        const otherExperienceTemplateImage = document.getElementById('otherExperienceTemplateImage');
        const startDateRequiredStar = document.getElementById('startDateRequiredStar');
        const moreInfoChoicePopup = document.getElementById('moreInfoChoicePopup');
        const closeMoreInfoChoicePopup = document.getElementById('closeMoreInfoChoicePopup');
        const btnContinueMoreInfoChoice = document.getElementById('btnContinueMoreInfoChoice');
        const btnSkipMoreInfoChoice = document.getElementById('btnSkipMoreInfoChoice');
        const otherPopupTitle = document.getElementById('otherPopupTitle');
        const otherPopupText = document.getElementById('otherPopupText');
        const workInfoView = document.getElementById('workInfoView');
        const moreInfoSearchTitle = document.getElementById('moreInfoSearchTitle');
        const moreInfoResultTitle = document.getElementById('moreInfoResultTitle');
        const moreInfoJobTitle = document.getElementById('moreInfoJobTitle');
        const moreInfoEmployer = document.getElementById('moreInfoEmployer');
        const moreInfoMeta = document.getElementById('moreInfoMeta');
        const workAchievementsEditor = document.getElementById('workAchievementsEditor');
        const btnPreviewMoreInfo = document.getElementById('btnPreviewMoreInfo');
        const btnNextMoreInfo = document.getElementById('btnNextMoreInfo');
        let otherExperiencePopupMode = 'addExperience';

        const TEMPLATE_API_BASE = 'http://localhost:5000';

        function stripRemoteFromLocation(value) {
            let clean = String(value || '').trim();
            clean = clean.replace(/\s*\(Remote\)\s*$/i, '').trim();
            if (/^remote$/i.test(clean)) return '';
            return clean;
        }

        function formatLocationWithRemote(value, isRemote) {
            const base = stripRemoteFromLocation(value);
            if (!isRemote) return base;
            return base ? base + ' (Remote)' : 'Remote';
        }

        function refreshSelection() {
            reasonButtons.forEach(btn => {
                btn.classList.toggle('selected', btn.dataset.reason === selectedReason);
            });

            if (selectedReason) {
                nextBtn.disabled = false;
                nextBtn.classList.add('enabled');
            } else {
                nextBtn.disabled = true;
                nextBtn.classList.remove('enabled');
            }
        }

        function getTemplateImageUrl(thumbnail) {
            if (!thumbnail) return '';
            let clean = String(thumbnail).trim().replace(/\\\\/g, '/').replace(/\\/g, '/');
            if (!clean) return '';
            if (clean.startsWith('http://') || clean.startsWith('https://')) return clean;
            if (clean.startsWith('/uploads/')) return TEMPLATE_API_BASE + clean;
            if (clean.startsWith('uploads/')) return TEMPLATE_API_BASE + '/' + clean;
            return TEMPLATE_API_BASE + '/uploads/templates/' + clean;
        }

        function getStoredTemplateKey() {
            return (
                localStorage.getItem('selected_template') ||
                localStorage.getItem('selectedTemplate') ||
                localStorage.getItem('resume_template') ||
                localStorage.getItem('template_id') ||
                ''
            );
        }

        function templateMatches(template, key) {
            if (!template || !key) return false;
            return String(template.template_key) === String(key) ||
                   String(template.id) === String(key) ||
                   String(template._id) === String(key);
        }

        async function getTemplates() {
            try {
                const res = await fetch(TEMPLATE_API_BASE + '/api/templates/all');
                const data = await res.json();
                return data.success && Array.isArray(data.templates) ? data.templates : [];
            } catch (error) {
                console.warn('Template API load failed:', error);
                return [];
            }
        }

        async function getResumeFromApi() {
            try {
                const res = await fetch(TEMPLATE_API_BASE + '/api/resumes/get/' + resumeId, {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                const data = await res.json();
                return data.success && data.resume ? data.resume : null;
            } catch (error) {
                console.warn('Resume template data could not be loaded:', error);
                return null;
            }
        }

        async function resolveSelectedTemplate() {
            const templates = await getTemplates();
            const resume = await getResumeFromApi();
            const storedKey = getStoredTemplateKey();

            let selected = null;

            if (storedKey) {
                selected = templates.find(t => templateMatches(t, storedKey));
            }

            if (!selected && resume) {
                const resumeKey = resume.template_key || resume.template_id || resume.template || '';
                selected = templates.find(t => templateMatches(t, resumeKey));
            }

            if (!selected && resume && (resume.template_name || resume.name)) {
                const rName = String(resume.template_name || resume.name || '').toLowerCase().trim();
                const rCat = String(resume.template_category || resume.category || '').toLowerCase().trim();
                selected = templates.find(t => {
                    const tName = String(t.name || '').toLowerCase().trim();
                    const tCat = String(t.category || '').toLowerCase().trim();
                    return tName === rName && (!rCat || tCat === rCat);
                });
            }

            if (!selected && templates.length) selected = templates[0];

            if (selected) {
                localStorage.setItem('selected_template', selected.template_key || String(selected.id || selected._id || ''));
                return selected;
            }

            if (resume) {
                return {
                    name: resume.template_name || 'Selected Template',
                    category: resume.template_category || 'Professional',
                    thumbnail_url: resume.template_thumbnail_url || resume.thumbnail_url || '',
                    template_key: resume.template_key || resume.template_id || ''
                };
            }

            return null;
        }

        function updateMockResumeUserData() {
            const first = localStorage.getItem('resume_first_name') || localStorage.getItem('first_name') || localStorage.getItem('contact_first_name') || 'ARMAGHAN';
            const last = localStorage.getItem('resume_last_name') || localStorage.getItem('last_name') || localStorage.getItem('contact_last_name') || 'SHAHZAD';
            const email = localStorage.getItem('resume_email') || localStorage.getItem('email') || localStorage.getItem('contact_email') || '23-se-051@student.hitec.edu.pk';
            const phone = localStorage.getItem('resume_phone') || localStorage.getItem('phone') || localStorage.getItem('contact_phone') || '+9230 5356621';
            const mockName = document.getElementById('mockName');
            const mockEmail = document.getElementById('mockEmail');
            const mockPhone = document.getElementById('mockPhone');
            if (mockName) mockName.textContent = (first + ' ' + last).toUpperCase();
            if (mockEmail) mockEmail.textContent = email;
            if (mockPhone) mockPhone.textContent = phone;
        }

        function setImageOrFallback(imgEl, frameEl, url) {
            if (!imgEl || !frameEl) return;
            if (!url) {
                imgEl.removeAttribute('src');
                frameEl.classList.remove('has-image');
                return;
            }
            imgEl.onload = function () {
                frameEl.classList.add('has-image');
            };
            imgEl.onerror = function () {
                imgEl.removeAttribute('src');
                frameEl.classList.remove('has-image');
            };
            imgEl.src = url;
        }

        async function applySelectedTemplatePreview() {
            updateMockResumeUserData();
            const selectedTemplate = await resolveSelectedTemplate();
            const thumbnail = selectedTemplate?.thumbnail_url || selectedTemplate?.template_thumbnail_url || '';
            const url = getTemplateImageUrl(thumbnail);

            setImageOrFallback(selectedTemplateImage, templatePreviewFrame, url);
            setImageOrFallback(modalTemplateImage, modalTemplateFrame, url);

            if (modalMockResumePreview && mockResumePreview) {
                modalMockResumePreview.innerHTML = mockResumePreview.innerHTML;
            }
        }

        function setDetailContent() {
            if (selectedReason === 'different_reason' || selectedReason === 'skipped') {
                detailTitle.innerHTML = 'Now, let’s fill out your<br>Experience';
                detailText.innerHTML = 'You can include any work experience, internships, scholarships, relevant coursework and academic achievements.';
            } else {
                detailTitle.innerHTML = 'Now, let’s fill out your<br>Work history';
                detailText.innerHTML = 'Employers scan your resume to see if you’re a match.<br>We’ll suggest bullet points that make a great impression.';
            }
        }

        function openDetailMode() {
            if (!selectedReason) return;
            detailModeOpen = true;
            formModeOpen = false;
            localStorage.setItem('resume_work_history_detail_open', 'true');
            localStorage.removeItem('resume_work_history_form_open');
            workMain.classList.remove('job-form-mode');
            workMain.classList.remove('work-info-mode');
            workMain.classList.add('detail-mode');
            topBackLink.href = '#';
            setDetailContent();
            applySelectedTemplatePreview();
        }

        function closeDetailMode() {
            detailModeOpen = false;
            formModeOpen = false;
            localStorage.removeItem('resume_work_history_detail_open');
            localStorage.removeItem('resume_work_history_form_open');
            workMain.classList.remove('detail-mode');
            workMain.classList.remove('job-form-mode');
            workMain.classList.remove('work-info-mode');
            topBackLink.href = '/builder/contact';
        }

        function openJobFormMode() {
            if (!selectedReason) return;
            detailModeOpen = false;
            formModeOpen = true;
            localStorage.removeItem('resume_work_history_detail_open');
            localStorage.setItem('resume_work_history_form_open', 'true');
            workMain.classList.remove('detail-mode');
            workMain.classList.remove('work-info-mode');
            workMain.classList.add('job-form-mode');
            topBackLink.href = '#';

            setTimeout(() => {
                workMain.scrollTo({ top: 0, behavior: 'smooth' });
            }, 50);
        }

        function closeJobFormMode() {
            formModeOpen = false;
            detailModeOpen = true;
            localStorage.removeItem('resume_work_history_form_open');
            localStorage.setItem('resume_work_history_detail_open', 'true');
            workMain.classList.remove('job-form-mode');
            workMain.classList.remove('work-info-mode');
            workMain.classList.add('detail-mode');
            topBackLink.href = '#';
            setDetailContent();
            applySelectedTemplatePreview();
        }

        function showJobAlert(message, type = 'error') {
            if (!jobAlert) {
                alert(message);
                return;
            }

            jobAlert.textContent = message;
            jobAlert.classList.toggle('success', type === 'success');
            jobAlert.classList.add('show');

            clearTimeout(showJobAlert.timer);
            showJobAlert.timer = setTimeout(() => {
                jobAlert.classList.remove('show');
            }, 3600);
        }

        function clearFieldError(field) {
            if (!field) return;
            const wrapper = field.closest('.job-field');
            const err = document.getElementById(field.id + 'Error');
            if (wrapper) wrapper.classList.remove('has-error');
            if (err) err.textContent = '';
        }

        function setFieldError(field, message) {
            if (!field) return;
            const wrapper = field.closest('.job-field');
            const err = document.getElementById(field.id + 'Error');
            if (wrapper) wrapper.classList.add('has-error');
            if (err) err.textContent = message;
        }

        function clearStartYearError() {
            if (!startYearField) return;
            const err = document.getElementById('startYearError');
            startYearField.classList.remove('field-error-border');
            if (err) err.textContent = '';
        }

        function setStartYearError(message) {
            if (!startYearField) return;
            const err = document.getElementById('startYearError');
            startYearField.classList.add('field-error-border');
            if (err) err.textContent = message;
        }

        async function showOtherExperiencePopup(mode = 'addExperience') {
            otherExperiencePopupMode = mode || 'addExperience';

            if (!otherExperiencePopup) {
                window.location.href = '/builder/education';
                return;
            }

            if (otherPopupTitle) {
                otherPopupTitle.innerHTML = "Don't forget to include other<br>work experience";
            }

            if (otherPopupText) {
                otherPopupText.innerHTML = "You can add internships,<br>professional licenses, volunteer<br>work and unpaid jobs.";
            }

            if (btnAddAnotherExperience) {
                btnAddAnotherExperience.textContent = otherExperiencePopupMode === 'moreInfo'
                    ? 'Add more info'
                    : 'Add experience';
            }

            if (btnNoThanksExperience) {
                btnNoThanksExperience.textContent = 'Skip now';
            }

            // Always fetch/show the same template that the user selected earlier.
            // This avoids showing a fixed/static template inside this popup.
            try {
                const selectedTemplate = await resolveSelectedTemplate();
                const thumbnail = selectedTemplate?.thumbnail_url || selectedTemplate?.template_thumbnail_url || '';
                const selectedUrl = getTemplateImageUrl(thumbnail) || (selectedTemplateImage ? selectedTemplateImage.getAttribute('src') : '');

                if (otherExperienceTemplateImage && selectedUrl) {
                    otherExperienceTemplateImage.onload = function () {
                        const frame = otherExperienceTemplateImage.closest('.other-template-frame');
                        if (frame) frame.classList.add('has-image');
                    };
                    otherExperienceTemplateImage.onerror = function () {
                        const frame = otherExperienceTemplateImage.closest('.other-template-frame');
                        if (frame) frame.classList.remove('has-image');
                        otherExperienceTemplateImage.removeAttribute('src');
                    };
                    otherExperienceTemplateImage.src = selectedUrl;
                }
            } catch (error) {
                console.warn('Popup selected template could not be loaded:', error);
            }

            otherExperiencePopup.classList.add('show');
            otherExperiencePopup.setAttribute('aria-hidden', 'false');
        }

        function hideOtherExperiencePopup() {
            if (!otherExperiencePopup) return;
            otherExperiencePopup.classList.remove('show');
            otherExperiencePopup.setAttribute('aria-hidden', 'true');
        }

        function clearWorkHistoryForAnotherEntry() {
            if (!workHistoryForm) return;
            workHistoryForm.reset();
            toggleCurrentWorkFields();
            ['jobTitle', 'employer', 'startYear'].forEach(id => {
                const field = document.getElementById(id);
                clearFieldError(field);
            });
            clearStartYearError();
            hideOtherExperiencePopup();
            const first = document.getElementById('jobTitle');
            if (first) first.focus();
        }

        function hasAnyWorkHistoryInput() {
            const fieldIds = [
                'jobTitle',
                'employer',
                'jobCity',
                'jobCountry',
                'startMonth',
                'startYear',
                'endMonth',
                'endYear'
            ];

            const hasTypedOrSelectedValue = fieldIds.some(id => {
                const field = document.getElementById(id);
                return field && String(field.value || '').trim().length > 0;
            });

            const hasCheckedBox =
                (document.getElementById('isRemote') && document.getElementById('isRemote').checked) ||
                (document.getElementById('currentlyWorking') && document.getElementById('currentlyWorking').checked);

            return hasTypedOrSelectedValue || hasCheckedBox;
        }


        function isOnlyRequiredWorkInfoEntered() {
            const title = document.getElementById('jobTitle')?.value.trim() || '';
            const employerValue = document.getElementById('employer')?.value.trim() || '';

            if (!title || !employerValue) return false;

            const optionalFieldIds = [
                'jobCity',
                'jobCountry',
                'startMonth',
                'startYear',
                'endMonth',
                'endYear'
            ];

            const hasOptionalValue = optionalFieldIds.some(id => {
                const field = document.getElementById(id);
                return field && String(field.value || '').trim().length > 0;
            });

            const hasOptionalCheckbox =
                (document.getElementById('isRemote') && document.getElementById('isRemote').checked) ||
                (document.getElementById('currentlyWorking') && document.getElementById('currentlyWorking').checked);

            return !hasOptionalValue && !hasOptionalCheckbox;
        }

        function fillMoreInfoScreenFromForm() {
            const title = document.getElementById('jobTitle')?.value.trim() || 'Sales Manager';
            const employerValue = document.getElementById('employer')?.value.trim() || 'Employer';
            const city = formatLocationWithRemote(document.getElementById('jobCity')?.value.trim() || '', !!(document.getElementById('isRemote') && document.getElementById('isRemote').checked));
            const startMonthValue = document.getElementById('startMonth')?.value.trim() || '';
            const startYearValue = document.getElementById('startYear')?.value.trim() || '';
            const currently = document.getElementById('currentlyWorking')?.checked;
            const endMonthValue = document.getElementById('endMonth')?.value.trim() || '';
            const endYearValue = document.getElementById('endYear')?.value.trim() || '';

            const startText = [startMonthValue, startYearValue].filter(Boolean).join(' ');
            const endText = currently ? 'Current' : [endMonthValue, endYearValue].filter(Boolean).join(' ');
            const dateText = [startText, endText].filter(Boolean).join(' - ');
            const metaParts = [];

            if (city) metaParts.push(city);
            if (dateText) metaParts.push(dateText);

            if (moreInfoSearchTitle) moreInfoSearchTitle.value = title;
            if (moreInfoResultTitle) moreInfoResultTitle.textContent = title;
            if (moreInfoJobTitle) moreInfoJobTitle.textContent = title;
            if (moreInfoEmployer) moreInfoEmployer.textContent = employerValue;
            if (moreInfoMeta) moreInfoMeta.textContent = metaParts.length ? metaParts.join(' - ') : 'Add achievements and responsibilities';
        }


        function showMoreInfoChoicePopup() {
            hideOtherExperiencePopup();
            if (!moreInfoChoicePopup) {
                openMoreInfoMode();
                return;
            }
            moreInfoChoicePopup.classList.add('show');
            moreInfoChoicePopup.setAttribute('aria-hidden', 'false');
        }

        function hideMoreInfoChoicePopup() {
            if (!moreInfoChoicePopup) return;
            moreInfoChoicePopup.classList.remove('show');
            moreInfoChoicePopup.setAttribute('aria-hidden', 'true');
        }

        function openMoreInfoMode() {
            hideOtherExperiencePopup();
            fillMoreInfoScreenFromForm();

            formModeOpen = false;
            detailModeOpen = false;

            localStorage.setItem('resume_work_history_form_open', 'true');
            localStorage.removeItem('resume_work_history_detail_open');

            workMain.classList.remove('detail-mode');
            workMain.classList.remove('job-form-mode');
            workMain.classList.add('work-info-mode');

            topBackLink.href = '#';

            setTimeout(() => {
                workMain.scrollTo({ top: 0, behavior: 'smooth' });
                if (workAchievementsEditor) workAchievementsEditor.focus();
            }, 50);
        }

        function closeMoreInfoMode() {
            workMain.classList.remove('work-info-mode');
            workMain.classList.add('job-form-mode');
            formModeOpen = true;
            detailModeOpen = false;
            localStorage.setItem('resume_work_history_form_open', 'true');
            topBackLink.href = '#';
        }

        function validateRequiredWorkFields() {
            const userEnteredAnyData = hasAnyWorkHistoryInput();

            ['jobTitle', 'employer'].forEach(id => {
                const field = document.getElementById(id);
                clearFieldError(field);
            });
            clearStartYearError();

            // If user directly clicks Next with empty Work History form,
            // do not force data entry. Show the "other work experience" popup instead.
            if (!userEnteredAnyData) {
                return true;
            }

            const requiredFields = [
                {
                    el: document.getElementById('jobTitle'),
                    label: 'Title'
                },
                {
                    el: document.getElementById('employer'),
                    label: 'Employer'
                }
            ];

            let firstInvalid = null;

            requiredFields.forEach(item => {
                if (!item.el.value.trim()) {
                    setFieldError(item.el, item.label + ' is required.');
                    if (!firstInvalid) firstInvalid = item.el;
                }
            });

            if (currentlyWorking && currentlyWorking.checked && startYearField && !startYearField.value.trim()) {
                setStartYearError('In order to proceed, you must enter start year.');
                if (!firstInvalid) firstInvalid = startYearField;
            }

            if (firstInvalid) {
                showJobAlert('Please fill all required fields before moving to Education.');
                firstInvalid.focus();
                return false;
            }

            return true;
        }

        function collectWorkHistoryFormData() {
            return {
                resume_id: resumeId,
                reason: selectedReason || localStorage.getItem('resume_work_history_reason') || '',
                job_title: document.getElementById('jobTitle').value.trim(),
                employer: document.getElementById('employer').value.trim(),
                city: stripRemoteFromLocation(document.getElementById('jobCity').value.trim()),
                country: document.getElementById('jobCountry').value.trim(),
                is_remote: document.getElementById('isRemote').checked ? 1 : 0,
                start_month: document.getElementById('startMonth').value.trim(),
                start_year: document.getElementById('startYear').value.trim(),
                end_month: document.getElementById('currentlyWorking').checked ? '' : document.getElementById('endMonth').value.trim(),
                end_year: document.getElementById('currentlyWorking').checked ? '' : document.getElementById('endYear').value.trim(),
                currently_working: document.getElementById('currentlyWorking').checked ? 1 : 0
            };
        }

        function toggleCurrentWorkFields() {
            if (!currentlyWorking || !endMonth || !endYear) return;
            const checked = currentlyWorking.checked;
            endMonth.disabled = checked;
            endYear.disabled = checked;

            if (startDateRequiredStar) {
                startDateRequiredStar.style.display = checked ? 'inline' : 'none';
            }

            if (checked) {
                endMonth.value = '';
                endYear.value = '';
            } else {
                clearStartYearError();
            }
        }

        async function saveWorkHistoryToDatabase(payload) {
            const res = await fetch(TEMPLATE_API_BASE + '/api/resumes/work-history', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json().catch(() => ({}));
            if (!res.ok || data.success === false) {
                throw new Error(data.message || 'Work history save failed.');
            }
            return data;
        }

        reasonButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                selectedReason = btn.dataset.reason;
                localStorage.setItem('resume_work_history_reason', selectedReason);
                localStorage.removeItem('resume_work_history_detail_open');
                localStorage.removeItem('resume_work_history_form_open');
                detailModeOpen = false;
                formModeOpen = false;
                workMain.classList.remove('detail-mode');
                workMain.classList.remove('job-form-mode');
                workMain.classList.remove('work-info-mode');
                refreshSelection();
            });
        });

        skipBtn.addEventListener('click', () => {
            selectedReason = 'skipped';
            localStorage.setItem('resume_work_history_reason', 'skipped');
            localStorage.setItem('resume_work_history_detail_open', 'true');
            refreshSelection();
            openDetailMode();
        });

        nextBtn.addEventListener('click', () => {
            if (!selectedReason) return;
            openDetailMode();
        });

        topBackLink.addEventListener('click', (event) => {
            if (workMain.classList.contains('work-info-mode')) {
                event.preventDefault();
                closeMoreInfoMode();
                return;
            }

            if (formModeOpen || workMain.classList.contains('job-form-mode')) {
                event.preventDefault();
                closeJobFormMode();
                return;
            }

            if (detailModeOpen || workMain.classList.contains('detail-mode')) {
                event.preventDefault();
                closeDetailMode();
            }
        });

        btnFinalNextWork.addEventListener('click', () => {
            if (!selectedReason) return;
            localStorage.setItem('resume_work_history_reason', selectedReason);
            openJobFormMode();
        });

        btnPreviewWork.addEventListener('click', () => {
            if (modalMockResumePreview && mockResumePreview) {
                modalMockResumePreview.innerHTML = mockResumePreview.innerHTML;
            }
            workPreviewModal.classList.add('show');
        });

        if (btnPreviewJobForm) {
            btnPreviewJobForm.addEventListener('click', () => {
                if (modalMockResumePreview && mockResumePreview) {
                    modalMockResumePreview.innerHTML = mockResumePreview.innerHTML;
                }
                workPreviewModal.classList.add('show');
            });
        }

        if (currentlyWorking) {
            currentlyWorking.addEventListener('change', toggleCurrentWorkFields);
            toggleCurrentWorkFields();
        }

        ['jobTitle', 'employer'].forEach(id => {
            const field = document.getElementById(id);
            if (field) {
                field.addEventListener('input', () => clearFieldError(field));
            }
        });

        if (startYearField) {
            startYearField.addEventListener('input', clearStartYearError);
        }

        ['jobCity', 'startMonth', 'endMonth', 'endYear'].forEach(id => {
            const field = document.getElementById(id);
            if (field) {
                field.addEventListener('input', () => {
                    // Keep old validation quiet while user is typing.
                    // Required red fields appear only after Next is clicked.
                });
                field.addEventListener('change', () => {
                    // No instant required error. Validation happens on Next only.
                });
            }
        });

        if (jobTipsBtn) {
            jobTipsBtn.addEventListener('click', () => {
                showJobAlert('Tip: Add your most recent job first. You can include internships, freelance work, or academic experience too.', 'success');
            });
        }

        if (workHistoryForm) {
            workHistoryForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                if (!validateRequiredWorkFields()) {
                    return;
                }

                const userEnteredAnyData = hasAnyWorkHistoryInput();

                // Empty form is allowed. User can skip Work History from the popup.
                if (!userEnteredAnyData) {
                    localStorage.setItem('resume_work_history_form_open', 'true');
                    localStorage.removeItem('resume_work_history_detail_open');
                    showOtherExperiencePopup('addExperience');
                    return;
                }

                const payload = collectWorkHistoryFormData();
                localStorage.setItem('resume_work_history_data', JSON.stringify(payload));

                // GHOST FINAL: do NOT save to database here.
                // Next only stores this page data locally and must offer Add More Info first.
                localStorage.setItem('resume_work_history_form_open', 'true');
                localStorage.removeItem('resume_work_history_detail_open');
                showOtherExperiencePopup('moreInfo');
            });
        }


        const remoteInfoWrap = document.getElementById('remoteInfoWrap');
        const remoteInfoIcon = document.getElementById('remoteInfoIcon');

        if (remoteInfoWrap && remoteInfoIcon) {
            remoteInfoIcon.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                remoteInfoWrap.classList.toggle('tooltip-open');
            });

            document.addEventListener('click', (event) => {
                if (!remoteInfoWrap.contains(event.target)) {
                    remoteInfoWrap.classList.remove('tooltip-open');
                }
            });
        }

        if (closeOtherExperiencePopup) {
            closeOtherExperiencePopup.addEventListener('click', hideOtherExperiencePopup);
        }

        if (btnAddAnotherExperience) {
            btnAddAnotherExperience.addEventListener('click', () => {
                if (otherExperiencePopupMode === 'moreInfo') {
                    showMoreInfoChoicePopup();
                    return;
                }
                clearWorkHistoryForAnotherEntry();
            });
        }

        if (btnNoThanksExperience) {
            btnNoThanksExperience.addEventListener('click', () => {
                const rid = localStorage.getItem('current_resume_id') || 'no_resume';
                const noWorkData = !hasAnyWorkHistoryInput();
                if (noWorkData) {
                    localStorage.setItem('resume_work_history_missing_information_' + rid, 'true');
                    localStorage.setItem('resume_work_history_skip_without_data', 'true');
                } else {
                    localStorage.removeItem('resume_work_history_missing_information_' + rid);
                    localStorage.removeItem('resume_work_history_skip_without_data');
                }
                localStorage.removeItem('resume_work_history_form_open');
                localStorage.removeItem('resume_work_history_detail_open');
                window.location.href = '/builder/education';
            });
        }

        if (otherExperiencePopup) {
            otherExperiencePopup.addEventListener('click', (event) => {
                if (event.target === otherExperiencePopup) {
                    hideOtherExperiencePopup();
                }
            });
        }


        if (btnPreviewMoreInfo) {
            btnPreviewMoreInfo.addEventListener('click', () => {
                if (modalMockResumePreview && mockResumePreview) {
                    modalMockResumePreview.innerHTML = mockResumePreview.innerHTML;
                }
                workPreviewModal.classList.add('show');
            });
        }

        if (btnNextMoreInfo) {
            btnNextMoreInfo.addEventListener('click', () => {
                const extraInfo = workAchievementsEditor ? workAchievementsEditor.innerHTML.trim() : '';
                localStorage.setItem('resume_work_history_extra_info', extraInfo);
                showOtherExperiencePopup('addExperience');
            });
        }

        if (moreInfoSearchTitle) {
            moreInfoSearchTitle.addEventListener('input', () => {
                const value = moreInfoSearchTitle.value.trim() || 'Sales Manager';
                if (moreInfoResultTitle) moreInfoResultTitle.textContent = value;
            });
        }


        if (closeMoreInfoChoicePopup) {
            closeMoreInfoChoicePopup.addEventListener('click', hideMoreInfoChoicePopup);
        }

        if (btnContinueMoreInfoChoice) {
            btnContinueMoreInfoChoice.addEventListener('click', () => {
                hideMoreInfoChoicePopup();
                openMoreInfoMode();
            });
        }

        if (btnSkipMoreInfoChoice) {
            btnSkipMoreInfoChoice.addEventListener('click', () => {
                hideMoreInfoChoicePopup();
                localStorage.removeItem('resume_work_history_form_open');
                localStorage.removeItem('resume_work_history_detail_open');
                window.location.href = '/builder/education';
            });
        }

        if (moreInfoChoicePopup) {
            moreInfoChoicePopup.addEventListener('click', (event) => {
                if (event.target === moreInfoChoicePopup) {
                    hideMoreInfoChoicePopup();
                }
            });
        }



        function toggleWorkExampleCategory(id, headerBtn) {
            const body = document.getElementById(id);
            if (!body) return;
            const isHidden = body.classList.contains('hidden-work-example');
            document.querySelectorAll('.work-example-body').forEach(el => el.classList.add('hidden-work-example'));
            document.querySelectorAll('.work-example-header').forEach(el => el.classList.remove('open'));
            if (isHidden) {
                body.classList.remove('hidden-work-example');
                if (headerBtn) headerBtn.classList.add('open');
            }
        }

        function addWorkBullet(text) {
            const editor = document.getElementById('workAchievementsEditor');
            if (!editor || !text) return;
            editor.focus();

            const cleanText = String(text).trim();
            let ul = editor.querySelector('ul');
            if (!ul) {
                editor.innerHTML = '<ul></ul>';
                ul = editor.querySelector('ul');
            }

            const li = document.createElement('li');
            li.textContent = cleanText;
            ul.appendChild(li);

            const range = document.createRange();
            range.selectNodeContents(editor);
            range.collapse(false);
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
        }

        closeWorkPreview.addEventListener('click', () => {
            workPreviewModal.classList.remove('show');
        });

        workPreviewModal.addEventListener('click', (event) => {
            if (event.target === workPreviewModal) {
                workPreviewModal.classList.remove('show');
            }
        });

        refreshSelection();

        if (selectedReason && formModeOpen) {
            openJobFormMode();
        } else if (selectedReason && detailModeOpen) {
            openDetailMode();
        }
    </script>

<!-- GHOST FINAL UPDATE: same-page detail template preview smaller only -->
<style id="ghost-detail-template-size-smaller-only">
    .detail-view .template-preview-frame {
        width: 360px !important;
        height: 480px !important;
    }

    .preview-modal-card .template-preview-frame {
        width: 100% !important;
        height: 100% !important;
    }

    @media (max-width: 1200px) {
        .detail-view .template-preview-frame {
            width: 300px !important;
            height: 400px !important;
        }
    }
</style>


<style id="ghost-remote-tooltip-arrow-center-final">
    /* GHOST FINAL: Remote tooltip arrow exactly centered under info icon */
    .remote-info-wrap {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .remote-tooltip-box {
        left: 50% !important;
        top: 50px !important;
        transform: translateX(-50%) translateY(-8px) !important;
        width: 390px !important;
        z-index: 99999 !important;
    }

    .remote-tooltip-box::before {
        left: 50% !important;
        top: -13px !important;
        transform: translateX(-50%) rotate(45deg) !important;
    }

    .remote-info-wrap:hover .remote-tooltip-box,
    .remote-info-wrap.tooltip-open .remote-tooltip-box {
        transform: translateX(-50%) translateY(0) !important;
    }
</style>


<style id="ghost-job-form-title-letter-gap-contact-same">
    /* GHOST FINAL: reduce title letter spacing like Contact page - only white form title */
    .work-main.job-form-mode .job-form-title {
        letter-spacing: 0 !important;
        word-spacing: 0 !important;
    }
</style>


<style id="ghost-workhistory-label-size-less-bold-final">
    /* GHOST FINAL: reduce only Work History form label font size + remove heavy bold */
    .work-main.job-form-mode .job-field label:not(.job-check-row),
    .work-main.job-form-mode .job-field label:not(.job-check-row) span,
    .work-main.job-form-mode .required-note {
        font-size: 18px !important;
        line-height: 1.15 !important;
        font-weight: 700 !important;
        letter-spacing: 0 !important;
    }

    .work-main.job-form-mode .required-note {
        margin-bottom: 28px !important;
    }
</style>


<style id="ghost-workhistory-year-required-and-popup-final">
    /* GHOST FINAL: Start Year required only when 'I currently work here' is checked */
    .work-main.job-form-mode #startYear.field-error-border {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 2px rgba(220,38,38,.12) !important;
    }

    .work-main.job-form-mode #startYearError {
        margin-top: 4px !important;
        padding-left: calc(50% + 19px) !important;
        color: #991b1b !important;
        font-size: 14px !important;
        line-height: 1.25 !important;
        font-weight: 900 !important;
        min-height: 18px !important;
        display: block !important;
    }


    .start-date-required-star {
        display: none;
        color: #dc2626 !important;
        font-weight: 950 !important;
    }

    .field-error-border {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 2px rgba(220,38,38,.12) !important;
    }

    .other-template-frame.has-image .other-template-fallback {
        display: none !important;
    }

    /* GHOST FINAL: Popup before going to Education */
    .other-experience-overlay {
        position: fixed !important;
        inset: 0 !important;
        display: none !important;
        align-items: center !important;
        justify-content: center !important;
        background: rgba(0, 0, 0, .45) !important;
        z-index: 100000 !important;
        padding: 22px !important;
    }

    .other-experience-overlay.show {
        display: flex !important;
    }

    .other-experience-card {
        position: relative !important;
        width: 1000px !important;
        max-width: calc(100vw - 120px) !important;
        min-height: 555px !important;
        background: #ffffff !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        box-shadow: 0 28px 85px rgba(15, 23, 42, .32) !important;
    }

    .other-experience-close {
        position: absolute !important;
        top: 22px !important;
        right: 22px !important;
        width: 42px !important;
        height: 42px !important;
        border: 0 !important;
        background: transparent !important;
        color: #071022 !important;
        font-size: 32px !important;
        cursor: pointer !important;
        z-index: 5 !important;
    }

    .other-experience-left {
        padding: 58px 58px 48px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        justify-content: flex-start !important;
        background: #ffffff !important;
    }

    .other-experience-left h2 {
        margin: 0 0 18px !important;
        color: #071022 !important;
        font-size: 28px !important;
        line-height: 1.12 !important;
        font-weight: 950 !important;
        letter-spacing: 0 !important;
    }

    .other-experience-left p {
        margin: 0 !important;
        color: #071022 !important;
        font-size: 26px !important;
        line-height: 1.32 !important;
        font-weight: 400 !important;
    }

    .other-add-btn {
        width: 385px !important;
        max-width: 100% !important;
        height: 70px !important;
        margin-top: 180px !important;
        border: 0 !important;
        border-radius: 999px !important;
        background: #db1b83 !important;
        color: #ffffff !important;
        font-size: 24px !important;
        font-weight: 950 !important;
        cursor: pointer !important;
    }

    .other-no-thanks {
        align-self: center !important;
        margin-top: 34px !important;
        border: 0 !important;
        background: transparent !important;
        color: #15168f !important;
        font-size: 24px !important;
        font-weight: 950 !important;
        text-decoration: underline !important;
        cursor: pointer !important;
    }

    .other-experience-right {
        background: #eef4fb !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 62px 48px !important;
    }

    .other-template-frame {
        position: relative !important;
        width: 298px !important;
        height: 438px !important;
        background: #ffffff !important;
        overflow: hidden !important;
        box-shadow: none !important;
    }

    .other-template-img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
        background: #ffffff !important;
        display: block !important;
        position: relative !important;
        z-index: 1 !important;
    }

    .other-template-img:not([src]),
    .other-template-img[src=""] {
        display: none !important;
    }

    .other-template-fallback {
        position: absolute !important;
        inset: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: #64748b !important;
        font-size: 18px !important;
        font-weight: 900 !important;
        z-index: 0 !important;
    }

    .other-highlight-box {
        position: absolute !important;
        left: 0 !important;
        right: 0 !important;
        top: 36.5% !important;
        height: 26% !important;
        border: 3px solid #ec4899 !important;
        background: rgba(236, 72, 153, .13) !important;
        z-index: 3 !important;
        pointer-events: none !important;
    }

    @media (max-width: 1024px) {
        .other-experience-card {
            grid-template-columns: 1fr !important;
            max-width: calc(100vw - 28px) !important;
            min-height: 0 !important;
        }
        .other-experience-left { padding: 42px 28px !important; }
        .other-add-btn { margin-top: 42px !important; }
        .other-experience-right { display: none !important; }
    }
</style>


<style id="ghost-add-more-info-video-style-final">
    /* GHOST FINAL: Add More Info screen from video */
    .work-info-view {
        display: none;
        min-height: 133.3333333333vh;
        padding: 34px 54px 72px 54px;
        background: #ffffff;
        grid-template-columns: minmax(520px, 1fr) minmax(560px, .92fr);
        gap: 32px;
    }

    .work-main.work-info-mode {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        scroll-behavior: smooth !important;
    }

    .work-main.work-info-mode .choice-view,
    .work-main.work-info-mode .choice-actions,
    .work-main.work-info-mode .detail-view,
    .work-main.work-info-mode .detail-actions,
    .work-main.work-info-mode .job-form-view {
        display: none !important;
    }

    .work-main.work-info-mode .work-info-view {
        display: grid !important;
    }

    .work-info-left,
    .work-info-right {
        min-width: 0;
    }

    .work-search-card {
        width: 100%;
        background: #ffffff;
        border-radius: 2px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, .10);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .work-search-card h2 {
        margin: 0;
        padding: 24px 30px 10px;
        font-size: 22px;
        line-height: 1.15;
        font-weight: 950;
        color: #071022;
    }

    .work-search-row {
        display: grid;
        grid-template-columns: 1fr 74px;
        gap: 18px;
        padding: 0 30px 22px;
        border-bottom: 1px solid #cbd5e1;
    }

    .work-search-row input {
        height: 74px;
        border: 1.7px solid #94a3b8;
        border-radius: 5px;
        padding: 0 64px 0 22px;
        font-size: 28px;
        color: #071022;
        outline: none;
        background: #ffffff;
    }

    .work-search-row::after {
        content: "×";
        position: absolute;
        left: 567px;
        top: 110px;
        font-size: 42px;
        color: #8b95a1;
        pointer-events: none;
    }

    .work-search-row button {
        height: 74px;
        width: 74px;
        border: 0;
        border-radius: 999px;
        background: #346da6;
        color: #ffffff;
        font-size: 32px;
        cursor: pointer;
    }

    .related-title {
        padding: 26px 30px 14px;
        font-size: 22px;
        font-weight: 950;
        color: #071022;
    }

    .related-grid {
        padding: 0 30px 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px 24px;
    }

    .related-grid button {
        border: 0;
        background: transparent;
        color: #0969da;
        text-align: left;
        font-size: 18px;
        font-weight: 900;
        text-decoration: underline;
        cursor: pointer;
        white-space: nowrap;
    }

    .related-grid button i {
        margin-right: 10px;
        text-decoration: none;
    }

    .related-grid .see-more {
        font-size: 19px;
    }

    .example-results-box {
        margin: 0 30px 34px;
        min-height: 350px;
        border: 1.7px solid #94a3b8;
        border-radius: 10px;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .example-results-header {
        height: 58px;
        display: flex;
        align-items: center;
        padding: 0 26px;
        border-bottom: 1.5px solid #94a3b8;
        font-size: 20px;
        color: #071022;
    }

    .example-loader {
        position: absolute;
        left: 50%;
        top: 55%;
        width: 86px;
        height: 86px;
        border-radius: 999px;
        border: 10px solid #d1d5db;
        border-left-color: #071022;
        transform: translate(-50%, -50%);
        animation: ghostSpin 1s linear infinite;
    }

    @keyframes ghostSpin {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .more-info-summary {
        padding-top: 0;
        margin-bottom: 28px;
    }

    .more-info-summary h1 {
        margin: 0 0 14px;
        color: #071022;
        font-size: 28px;
        line-height: 1.15;
        font-weight: 950;
    }

    .more-info-summary h1 span:first-child {
        font-weight: 950;
    }

    .more-info-summary p {
        margin: 0;
        color: #071022;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 400;
    }

    .more-info-editor {
        border: 1.6px solid #94a3b8;
        border-radius: 12px;
        min-height: 620px;
        background: #ffffff;
        overflow: hidden;
        position: relative;
    }

    .more-info-toolbar {
        height: 90px;
        display: flex;
        align-items: center;
        gap: 24px;
        padding: 0 26px;
        border-bottom: 1.5px solid #94a3b8;
    }

    .more-info-toolbar button {
        width: 38px;
        height: 38px;
        border: 0;
        background: transparent;
        color: #071022;
        font-size: 26px;
        font-weight: 950;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .more-info-toolbar .toolbar-active {
        width: 44px;
        height: 44px;
        border-radius: 6px;
        background: #dbeafe;
        font-size: 16px;
        flex-direction: column;
        gap: 0;
        line-height: 1;
    }

    .more-info-toolbar .toolbar-active span {
        font-size: 13px;
        font-weight: 700;
    }

    .enhance-ai-btn {
        position: absolute;
        left: 24px;
        top: 112px;
        height: 36px;
        padding: 0 18px;
        border: 1.5px solid #db1b83;
        border-radius: 999px;
        background: #f9d5ef;
        color: #071022;
        font-size: 17px;
        font-weight: 950;
        cursor: pointer;
    }

    .work-achievements-editor {
        min-height: 500px;
        padding: 78px 24px 24px;
        color: #071022;
        font-size: 22px;
        line-height: 1.5;
        outline: none;
    }

    .work-achievements-editor:empty::before {
        content: attr(data-placeholder);
        color: #7b8794;
    }

    .work-info-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 28px;
        margin-top: 46px;
        padding-bottom: 40px;
    }

    @media (max-width: 1200px) {
        .work-info-view {
            grid-template-columns: 1fr;
        }
    }
</style>



<style id="ghost-work-info-alignment-choice-popup-final">
    /* GHOST UPDATE: align Add More Info page and remove AI wording */
    .work-info-view {
        padding: 58px 62px 80px 58px !important;
        grid-template-columns: minmax(560px, 1fr) minmax(585px, .95fr) !important;
        gap: 44px !important;
        align-items: start !important;
    }

    .work-info-left,
    .work-info-right {
        padding-top: 6px !important;
    }

    .work-search-card {
        border-radius: 8px !important;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .08) !important;
    }

    .work-search-card h2 {
        padding: 28px 32px 14px !important;
        font-size: 24px !important;
        line-height: 1.22 !important;
        letter-spacing: -0.015em !important;
    }

    .work-search-row {
        position: relative !important;
        grid-template-columns: 1fr 76px !important;
        padding: 0 32px 24px !important;
        gap: 18px !important;
    }

    .work-search-row::after {
        left: auto !important;
        right: 132px !important;
        top: 13px !important;
        font-size: 38px !important;
    }

    .related-title {
        padding: 24px 32px 14px !important;
    }

    .related-grid {
        padding: 0 32px 24px !important;
        gap: 18px 28px !important;
    }

    .related-grid button {
        font-size: 17px !important;
        line-height: 1.25 !important;
    }

    .example-results-box {
        margin: 0 32px 34px !important;
        min-height: 330px !important;
    }

    .more-info-summary {
        margin-bottom: 22px !important;
    }

    .more-info-summary h1 {
        font-size: 27px !important;
        line-height: 1.22 !important;
        letter-spacing: -0.01em !important;
    }

    .more-info-summary p {
        font-size: 21px !important;
        color: #475569 !important;
    }

    .more-info-editor {
        min-height: 590px !important;
    }

    .more-info-toolbar {
        height: 78px !important;
        gap: 20px !important;
    }

    .enhance-ai-btn {
        top: 96px !important;
        height: 38px !important;
        min-width: 270px !important;
        padding: 0 18px !important;
        background: #f8d5ec !important;
        border-color: #db1b83 !important;
        font-size: 15px !important;
        letter-spacing: .01em !important;
        text-align: center !important;
        cursor: default !important;
    }

    .work-achievements-editor {
        min-height: 500px !important;
        padding: 72px 24px 24px !important;
        font-size: 20px !important;
    }

    .work-info-actions {
        margin-top: 38px !important;
        justify-content: flex-end !important;
    }

    /* GHOST UPDATE: small popup before opening Add More Info screen */
    .more-info-choice-overlay {
        position: fixed !important;
        inset: 0 !important;
        z-index: 100000 !important;
        display: none !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 24px !important;
        background: rgba(15, 23, 42, .62) !important;
        backdrop-filter: blur(2px) !important;
    }

    .more-info-choice-overlay.show {
        display: flex !important;
    }

    .more-info-choice-card {
        position: relative !important;
        width: min(620px, calc(100vw - 42px)) !important;
        background: #ffffff !important;
        border-radius: 18px !important;
        padding: 44px 48px 38px !important;
        box-shadow: 0 28px 75px rgba(15, 23, 42, .28) !important;
    }

    .more-info-choice-close {
        position: absolute !important;
        top: 18px !important;
        right: 20px !important;
        border: 0 !important;
        background: transparent !important;
        color: #071022 !important;
        font-size: 28px !important;
        cursor: pointer !important;
    }

    .more-info-choice-card h2 {
        margin: 0 0 12px !important;
        color: #071022 !important;
        font-size: 30px !important;
        line-height: 1.18 !important;
        font-weight: 950 !important;
        letter-spacing: -0.02em !important;
    }

    .more-info-choice-card p {
        margin: 0 0 24px !important;
        color: #475569 !important;
        font-size: 18px !important;
        line-height: 1.45 !important;
    }

    .more-info-choice-list {
        display: grid !important;
        gap: 14px !important;
        margin-bottom: 28px !important;
    }

    .more-info-choice-option {
        width: 100% !important;
        border: 1.8px solid #cbd5e1 !important;
        border-radius: 14px !important;
        background: #ffffff !important;
        padding: 18px 18px !important;
        display: flex !important;
        align-items: center !important;
        gap: 16px !important;
        text-align: left !important;
        color: #071022 !important;
    }

    .more-info-choice-option.active {
        border-color: #db1b83 !important;
        background: #fdf2f8 !important;
        cursor: pointer !important;
    }

    .more-info-choice-option.soon {
        opacity: .72 !important;
        cursor: not-allowed !important;
        background: #f8fafc !important;
    }

    .choice-icon {
        width: 46px !important;
        height: 46px !important;
        border-radius: 999px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex: 0 0 46px !important;
        font-size: 20px !important;
    }

    .more-info-choice-option.soon .choice-icon {
        background: #94a3b8 !important;
    }

    .more-info-choice-option strong {
        display: block !important;
        font-size: 19px !important;
        line-height: 1.2 !important;
        font-weight: 950 !important;
        margin-bottom: 5px !important;
    }

    .more-info-choice-option small {
        display: block !important;
        font-size: 14px !important;
        line-height: 1.35 !important;
        color: #64748b !important;
        font-weight: 700 !important;
    }

    .more-info-choice-main {
        width: 100% !important;
        height: 62px !important;
        border: 0 !important;
        border-radius: 999px !important;
        background: #db1b83 !important;
        color: #ffffff !important;
        font-size: 20px !important;
        font-weight: 950 !important;
        cursor: pointer !important;
    }

    .more-info-choice-skip {
        width: 100% !important;
        margin-top: 18px !important;
        border: 0 !important;
        background: transparent !important;
        color: #15168f !important;
        font-size: 19px !important;
        font-weight: 950 !important;
        text-decoration: underline !important;
        cursor: pointer !important;
    }

    @media (max-width: 1200px) {
        .work-info-view {
            grid-template-columns: 1fr !important;
            padding: 44px 34px 80px !important;
        }
    }
</style>



<!-- GHOST FINAL PATCH: toolbar working + Ready examples card lower; old logic unchanged -->
<style id="ghost-toolbar-ready-examples-final-patch">
    /* Keep Go Back where it is; only push the Ready To Use Examples card/screen content lower */
    .work-main.work-info-mode .top-back {
        top: 78px !important;
        left: 48px !important;
        z-index: 999 !important;
    }

    .work-main.work-info-mode .work-info-view {
        padding-top: 104px !important;
    }

    .work-main.work-info-mode .work-ready-card {
        margin-top: 14px !important;
    }

    .work-main.work-info-mode .work-info-right {
        padding-top: 14px !important;
    }

    .more-info-toolbar button {
        border-radius: 8px !important;
        transition: background .16s ease, transform .16s ease, color .16s ease !important;
    }

    .more-info-toolbar button:hover {
        background: #eef2ff !important;
        transform: translateY(-1px) !important;
    }

    .more-info-toolbar button.toolbar-btn-active,
    .more-info-toolbar button:focus-visible {
        background: #dbeafe !important;
        outline: none !important;
    }

    .work-achievements-editor ul,
    .work-achievements-editor ol {
        margin: 0 0 10px 22px !important;
        padding-left: 22px !important;
    }

    .work-achievements-editor li {
        margin: 7px 0 !important;
    }

    @media (max-width: 1200px) {
        .work-main.work-info-mode .work-info-view {
            padding-top: 92px !important;
        }
    }
</style>

<script id="ghost-toolbar-working-final-patch">
(function () {
    function getEditor() {
        return document.getElementById('workAchievementsEditor');
    }

    function focusEditor() {
        const editor = getEditor();
        if (!editor) return null;
        editor.focus();
        return editor;
    }

    function runEditorCommand(command, value) {
        const editor = focusEditor();
        if (!editor) return;
        try {
            document.execCommand(command, false, value || null);
        } catch (error) {
            console.warn('Editor command failed:', command, error);
        }
    }

    function createLinkFromSelection() {
        const editor = focusEditor();
        if (!editor) return;
        const url = prompt('Enter link URL');
        if (!url) return;
        const safeUrl = /^https?:\/\//i.test(url.trim()) ? url.trim() : 'https://' + url.trim();
        runEditorCommand('createLink', safeUrl);
    }

    function toggleToolbarButton(button) {
        if (!button) return;
        button.classList.add('toolbar-btn-active');
        setTimeout(() => button.classList.remove('toolbar-btn-active'), 220);
    }

    function initWorkInfoToolbar() {
        const toolbar = document.querySelector('.more-info-toolbar');
        if (!toolbar || toolbar.dataset.ghostToolbarReady === 'true') return;
        toolbar.dataset.ghostToolbarReady = 'true';

        const buttons = toolbar.querySelectorAll('button');
        const commands = [
            'bold',
            'italic',
            'underline',
            'insertUnorderedList',
            'removeFormat',
            'strikeThrough',
            'createLink',
            'undo',
            'redo'
        ];

        buttons.forEach((button, index) => {
            const cmd = commands[index];
            if (!cmd) return;
            button.setAttribute('title', cmd === 'insertUnorderedList' ? 'Bullet list' : cmd.replace(/([A-Z])/g, ' $1'));
            button.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                toggleToolbarButton(button);

                if (cmd === 'createLink') {
                    createLinkFromSelection();
                    return;
                }

                runEditorCommand(cmd);
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWorkInfoToolbar);
    } else {
        initWorkInfoToolbar();
    }

    window.addEventListener('load', initWorkInfoToolbar);
})();
</script>



<!-- GHOST FINAL PATCH: Custom Add Link popup + persistent active toolbar boxes + clear-format reset -->
<style id="ghost-link-popup-active-toolbar-final">
    .more-info-toolbar button.toolbar-btn-active,
    .more-info-toolbar button.ghost-toolbar-selected {
        background: #dbeafe !important;
        color: #2563eb !important;
        border: 1px solid #bfdbfe !important;
        box-shadow: 0 0 0 1px rgba(37, 99, 235, .08) inset !important;
    }

    .more-info-toolbar button.ghost-clear-format-btn {
        color: #0f172a !important;
    }

    .ghost-link-modal-overlay {
        position: fixed !important;
        inset: 0 !important;
        background: rgba(15, 23, 42, .42) !important;
        backdrop-filter: blur(4px) !important;
        z-index: 999999 !important;
        display: none !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 22px !important;
    }

    .ghost-link-modal-overlay.show {
        display: flex !important;
    }

    .ghost-link-modal-card {
        width: min(520px, calc(100vw - 34px)) !important;
        background: #ffffff !important;
        border-radius: 12px !important;
        box-shadow: 0 28px 80px rgba(15, 23, 42, .28) !important;
        padding: 38px 38px 36px !important;
        position: relative !important;
        color: #0f172a !important;
    }

    .ghost-link-modal-close {
        position: absolute !important;
        top: 28px !important;
        right: 30px !important;
        border: 0 !important;
        background: transparent !important;
        color: #9ca3af !important;
        font-size: 28px !important;
        line-height: 1 !important;
        cursor: pointer !important;
        padding: 0 !important;
    }

    .ghost-link-modal-close:hover {
        color: #0f172a !important;
    }

    .ghost-link-modal-title {
        font-size: 24px !important;
        font-weight: 950 !important;
        margin: 0 0 26px !important;
        color: #111827 !important;
        letter-spacing: -0.02em !important;
    }

    .ghost-link-modal-label {
        display: block !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #111827 !important;
        margin: 0 0 10px !important;
    }

    .ghost-link-modal-input {
        width: 100% !important;
        height: 68px !important;
        border: 1.6px solid #cbd5e1 !important;
        border-radius: 8px !important;
        background: #f8fbff !important;
        outline: none !important;
        padding: 0 22px !important;
        font-size: 22px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin-bottom: 20px !important;
        transition: border-color .18s ease, box-shadow .18s ease !important;
    }

    .ghost-link-modal-input::placeholder {
        color: #98a2b3 !important;
        font-weight: 800 !important;
    }

    .ghost-link-modal-input:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .12) !important;
    }

    .ghost-link-modal-actions {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        gap: 18px !important;
        margin-top: 18px !important;
    }

    .ghost-link-cancel-btn {
        border: 0 !important;
        background: transparent !important;
        color: #1d4ed8 !important;
        font-size: 15px !important;
        font-weight: 900 !important;
        cursor: pointer !important;
        padding: 12px 18px !important;
    }

    .ghost-link-add-btn {
        min-width: 206px !important;
        height: 50px !important;
        border: 0 !important;
        border-radius: 7px !important;
        background: #07003a !important;
        color: #ffffff !important;
        font-size: 16px !important;
        font-weight: 950 !important;
        cursor: pointer !important;
        box-shadow: 0 12px 25px rgba(7, 0, 58, .18) !important;
    }

    .ghost-link-add-btn:hover {
        background: #0b0552 !important;
    }
    .work-achievements-editor a,
    #workAchievementsEditor a {
        color: #2563eb !important;
        text-decoration: underline !important;
        font-weight: 800 !important;
        cursor: pointer !important;
    }

    .work-achievements-editor a:hover,
    #workAchievementsEditor a:hover {
        color: #1d4ed8 !important;
    }

</style>

<div class="ghost-link-modal-overlay" id="ghostLinkModal" aria-hidden="true">
    <div class="ghost-link-modal-card" role="dialog" aria-modal="true" aria-labelledby="ghostLinkModalTitle">
        <button type="button" class="ghost-link-modal-close" id="ghostLinkClose" aria-label="Close">×</button>
        <h2 class="ghost-link-modal-title" id="ghostLinkModalTitle">Add link</h2>

        <label class="ghost-link-modal-label" for="ghostLinkText">Link Text</label>
        <input class="ghost-link-modal-input" id="ghostLinkText" type="text" placeholder="WebCo">

        <label class="ghost-link-modal-label" for="ghostLinkUrl">Link (URL)</label>
        <input class="ghost-link-modal-input" id="ghostLinkUrl" type="text" placeholder="www.website.com">

        <div class="ghost-link-modal-actions">
            <button type="button" class="ghost-link-cancel-btn" id="ghostLinkCancel">Cancel</button>
            <button type="button" class="ghost-link-add-btn" id="ghostLinkAdd">Add Link</button>
        </div>
    </div>
</div>

<script id="ghost-link-popup-active-toolbar-final-script">
(function () {
    let savedRange = null;

    function editor() {
        return document.getElementById('workAchievementsEditor');
    }

    function toolbar() {
        return document.querySelector('.more-info-toolbar');
    }

    function saveSelection() {
        const sel = window.getSelection();
        if (sel && sel.rangeCount > 0) {
            savedRange = sel.getRangeAt(0).cloneRange();
        }
    }

    function restoreSelection() {
        const ed = editor();
        if (!ed) return;
        ed.focus();
        if (savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);
        }
    }

    function normalizeUrl(url) {
        const clean = String(url || '').trim();
        if (!clean) return '';
        return /^https?:\/\//i.test(clean) ? clean : 'https://' + clean;
    }

    function runCommand(command, value) {
        const ed = editor();
        if (!ed) return;
        ed.focus();
        try {
            document.execCommand(command, false, value || null);
        } catch (error) {
            console.warn('Toolbar command failed:', command, error);
        }
        updateToolbarStates();
    }

    function clearAllToolbarStates() {
        const tb = toolbar();
        if (!tb) return;
        tb.querySelectorAll('button').forEach(btn => btn.classList.remove('toolbar-btn-active', 'ghost-toolbar-selected'));
    }

    function clearFormatting() {
        restoreSelection();
        try { document.execCommand('removeFormat', false, null); } catch (e) {}
        try { document.execCommand('unlink', false, null); } catch (e) {}
        clearAllToolbarStates();
        const ed = editor();
        if (ed) ed.focus();
    }

    function selectedText() {
        const sel = window.getSelection();
        return sel ? String(sel.toString() || '') : '';
    }

    function showLinkModal() {
        saveSelection();
        const modal = document.getElementById('ghostLinkModal');
        const textInput = document.getElementById('ghostLinkText');
        const urlInput = document.getElementById('ghostLinkUrl');
        if (!modal || !textInput || !urlInput) return;
        textInput.value = selectedText().trim();
        urlInput.value = '';
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        setTimeout(() => (textInput.value ? urlInput.focus() : textInput.focus()), 40);
    }

    function hideLinkModal() {
        const modal = document.getElementById('ghostLinkModal');
        if (!modal) return;
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function addLinkFromModal() {
        const textInput = document.getElementById('ghostLinkText');
        const urlInput = document.getElementById('ghostLinkUrl');
        const ed = editor();
        if (!textInput || !urlInput || !ed) return;

        const url = normalizeUrl(urlInput.value);
        const linkText = String(textInput.value || '').trim();

        if (!linkText) {
            textInput.focus();
            return;
        }

        if (!url) {
            urlInput.focus();
            return;
        }

        restoreSelection();

        const safeHref = escapeHtml(url);
        const safeText = escapeHtml(linkText);
        const html = '<a href="' + safeHref + '" target="_blank" rel="noopener noreferrer" style="color:#2563eb;text-decoration:underline;font-weight:800;cursor:pointer;">' + safeText + '</a>&nbsp;';

        try {
            document.execCommand('insertHTML', false, html);
        } catch (error) {
            const sel = window.getSelection();
            if (sel && sel.rangeCount > 0) {
                const range = sel.getRangeAt(0);
                range.deleteContents();
                const a = document.createElement('a');
                a.href = url;
                a.target = '_blank';
                a.rel = 'noopener noreferrer';
                a.style.color = '#2563eb';
                a.style.textDecoration = 'underline';
                a.style.fontWeight = '800';
                a.style.cursor = 'pointer';
                a.textContent = linkText;
                range.insertNode(a);
                range.setStartAfter(a);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }

        hideLinkModal();
        ed.focus();
        updateToolbarStates();
    }

    function updateToolbarStates() {
        const tb = toolbar();
        const ed = editor();
        if (!tb || !ed) return;
        const buttons = tb.querySelectorAll('button');
        const stateMap = [
            { idx: 0, cmd: 'bold' },
            { idx: 1, cmd: 'italic' },
            { idx: 2, cmd: 'underline' },
            { idx: 3, cmd: 'insertUnorderedList' },
            { idx: 6, cmd: 'createLink' }
        ];
        stateMap.forEach(item => {
            const btn = buttons[item.idx];
            if (!btn) return;
            let active = false;
            try { active = document.queryCommandState(item.cmd); } catch (e) { active = false; }
            btn.classList.toggle('toolbar-btn-active', !!active);
        });
    }

    function initToolbar() {
        const tb = toolbar();
        if (!tb || tb.dataset.ghostLinkToolbarReady === 'true') return;
        tb.dataset.ghostLinkToolbarReady = 'true';

        const cleanTb = tb.cloneNode(true);
        tb.parentNode.replaceChild(cleanTb, tb);
        const buttons = cleanTb.querySelectorAll('button');
        buttons.forEach(btn => btn.classList.remove('toolbar-active', 'toolbar-btn-active', 'ghost-toolbar-selected'));

        const actions = [
            () => runCommand('bold'),
            () => runCommand('italic'),
            () => runCommand('underline'),
            () => runCommand('insertUnorderedList'),
            (btn) => btn.classList.toggle('ghost-toolbar-selected'),
            () => clearFormatting(),
            () => showLinkModal(),
            () => runCommand('undo'),
            () => runCommand('redo')
        ];

        buttons.forEach((button, index) => {
            if (index === 5) button.classList.add('ghost-clear-format-btn');
            button.addEventListener('mousedown', saveSelection);
            button.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                const action = actions[index];
                if (!action) return;
                action(button);
                if (index === 7 || index === 8) {
                    button.classList.add('toolbar-btn-active');
                    setTimeout(() => button.classList.remove('toolbar-btn-active'), 180);
                }
            });
        });

        const ed = editor();
        if (ed) {
            ['keyup', 'mouseup', 'input', 'focus'].forEach(evt => ed.addEventListener(evt, updateToolbarStates));

            if (ed.dataset.ghostLinkOpenReady !== 'true') {
                ed.dataset.ghostLinkOpenReady = 'true';
                ed.addEventListener('click', function (event) {
                    const link = event.target.closest('a');
                    if (!link || !ed.contains(link)) return;
                    const href = link.getAttribute('href');
                    if (!href) return;
                    event.preventDefault();
                    window.open(href, '_blank', 'noopener,noreferrer');
                });
            }
        }
        document.addEventListener('selectionchange', function () {
            const ed2 = editor();
            if (ed2 && document.activeElement === ed2) updateToolbarStates();
        });
    }

    function initLinkModal() {
        const modal = document.getElementById('ghostLinkModal');
        const close = document.getElementById('ghostLinkClose');
        const cancel = document.getElementById('ghostLinkCancel');
        const add = document.getElementById('ghostLinkAdd');
        const urlInput = document.getElementById('ghostLinkUrl');
        if (!modal || modal.dataset.ghostReady === 'true') return;
        modal.dataset.ghostReady = 'true';

        [close, cancel].forEach(btn => btn && btn.addEventListener('click', hideLinkModal));
        add && add.addEventListener('click', addLinkFromModal);
        modal.addEventListener('click', function (event) {
            if (event.target === modal) hideLinkModal();
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('show')) hideLinkModal();
        });
        urlInput && urlInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                addLinkFromModal();
            }
        });
    }

    function boot() {
        initToolbar();
        initLinkModal();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
    window.addEventListener('load', boot);
})();
</script>



<!-- GHOST FINAL PATCH: Career History highlight + extra example categories, old logic untouched -->
<style id="ghost-career-history-highlight-extra-categories-final">
    /* Put the highlight exactly on the Career History area of the resume preview */
    .template-preview-frame .work-highlight-box,
    #modalTemplateFrame .work-highlight-box {
        left: 0% !important;
        right: 0% !important;
        top: 31.5% !important;
        height: 34.5% !important;
        border: 3px solid #34d399 !important;
        background: rgba(52, 211, 153, .14) !important;
        z-index: 8 !important;
    }

    .other-template-frame .other-highlight-box {
        left: 0% !important;
        right: 0% !important;
        top: 31.5% !important;
        height: 34.5% !important;
        border: 3px solid #34d399 !important;
        background: rgba(52, 211, 153, .14) !important;
        z-index: 8 !important;
    }

    /* Keep new Ready-to-use categories visually same as old ones */
    #work-cat-projects .work-example-list,
    #work-cat-support .work-example-list {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        column-gap: 14px !important;
        row-gap: 10px !important;
    }
</style>


<!-- GHOST FINAL PATCH: preview visible + top question/search/tips on Add More Info screen -->
<style id="ghost-preview-top-question-search-final">
    .work-info-view {
        grid-template-columns: minmax(560px, 1fr) minmax(585px, .95fr) !important;
        gap: 34px 44px !important;
        padding-top: 70px !important;
    }

    .work-info-topbar {
        grid-column: 1 / -1 !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: space-between !important;
        gap: 28px !important;
        padding: 0 6px 18px 0 !important;
    }

    .work-info-top-copy h1 {
        margin: 0 0 18px !important;
        color: #071022 !important;
        font-size: 50px !important;
        line-height: 1.08 !important;
        font-weight: 950 !important;
        letter-spacing: -0.045em !important;
    }

    .work-info-top-copy p {
        margin: 0 !important;
        max-width: 980px !important;
        color: #0b3168 !important;
        font-size: 28px !important;
        line-height: 1.25 !important;
        font-weight: 500 !important;
        letter-spacing: .06em !important;
    }

    .work-info-tips {
        margin-top: 50px !important;
        border: 0 !important;
        background: transparent !important;
        color: #0969da !important;
        font-size: 20px !important;
        font-weight: 900 !important;
        text-decoration: underline !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 9px !important;
        cursor: pointer !important;
        white-space: nowrap !important;
    }

    .work-info-tips i { font-size: 21px !important; color: #0969da !important; }

    .work-search-card {
        margin-bottom: 26px !important;
        background: #ffffff !important;
        border-radius: 8px !important;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .08) !important;
        border: 1px solid #e5e7eb !important;
        overflow: hidden !important;
    }

    .work-search-card h2 {
        padding: 28px 32px 14px !important;
        margin: 0 !important;
        font-size: 24px !important;
        line-height: 1.22 !important;
        font-weight: 950 !important;
        letter-spacing: -0.015em !important;
        color: #071022 !important;
    }

    .work-search-row {
        position: relative !important;
        display: grid !important;
        grid-template-columns: 1fr 76px !important;
        padding: 0 32px 24px !important;
        gap: 18px !important;
        border-bottom: 1px solid #cbd5e1 !important;
    }

    .work-search-row input {
        height: 74px !important;
        border: 1.7px solid #94a3b8 !important;
        border-radius: 5px !important;
        padding: 0 64px 0 22px !important;
        font-size: 28px !important;
        color: #071022 !important;
        outline: none !important;
        background: #ffffff !important;
    }

    .work-search-row::after {
        content: "×" !important;
        position: absolute !important;
        right: 132px !important;
        top: 11px !important;
        font-size: 42px !important;
        color: #8b95a1 !important;
        pointer-events: none !important;
        line-height: 1 !important;
    }

    .work-search-row button {
        width: 76px !important;
        height: 76px !important;
        border: 0 !important;
        border-radius: 999px !important;
        background: #2463ad !important;
        color: #ffffff !important;
        font-size: 34px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
    }

    .related-title {
        padding: 24px 32px 14px !important;
        color: #64748b !important;
        font-size: 18px !important;
        font-weight: 950 !important;
        text-transform: uppercase !important;
        letter-spacing: .10em !important;
    }

    .related-grid {
        padding: 0 32px 24px !important;
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 12px !important;
    }

    .related-grid button {
        min-height: 44px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 999px !important;
        background: #ffffff !important;
        color: #071022 !important;
        font-size: 16px !important;
        font-weight: 900 !important;
        text-align: left !important;
        padding: 0 18px !important;
        cursor: pointer !important;
    }

    /* Keep the modal preview visible instead of showing a broken image */
    #workPreviewModal .preview-modal-card {
        width: min(760px, 92vw) !important;
        height: min(830px, 90vh) !important;
        border-radius: 18px !important;
        padding: 26px !important;
        background: #ffffff !important;
        overflow: hidden !important;
    }

    #modalTemplateFrame {
        width: 100% !important;
        height: 100% !important;
        border: 0 !important;
        background: #ffffff !important;
        box-shadow: none !important;
        overflow: hidden !important;
    }

    #modalTemplateFrame:not(.has-image) #modalTemplateImage {
        display: none !important;
    }

    #modalTemplateFrame:not(.has-image) #modalMockResumePreview {
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        background: #ffffff !important;
        transform: scale(1) !important;
        transform-origin: top center !important;
    }

    #modalTemplateFrame .mock-resume-inner {
        padding: 54px 86px !important;
    }

    #modalTemplateFrame .mock-name {
        font-size: 28px !important;
    }

    #modalTemplateFrame .mock-role,
    #modalTemplateFrame .mock-small,
    #modalTemplateFrame .mock-contact,
    #modalTemplateFrame .mock-date,
    #modalTemplateFrame .mock-bullets {
        font-size: 13px !important;
    }

    #modalTemplateFrame .mock-section-title,
    #modalTemplateFrame .mock-work-title {
        font-size: 17px !important;
    }

    #modalTemplateFrame .mock-job-title {
        font-size: 14px !important;
    }

    /* Career History green highlight exact area for selected image/mock preview */
    #modalTemplateFrame .work-highlight-box,
    .template-preview-frame .work-highlight-box {
        left: 0% !important;
        right: 0% !important;
        top: 31.5% !important;
        height: 34.5% !important;
        border: 3px solid #34d399 !important;
        background: rgba(52, 211, 153, .14) !important;
        z-index: 25 !important;
        pointer-events: none !important;
    }

    @media (max-width: 1024px) {
        .work-info-topbar { display: block !important; }
        .work-info-top-copy h1 { font-size: 34px !important; }
        .work-info-top-copy p { font-size: 18px !important; letter-spacing: 0 !important; }
        .work-info-tips { margin-top: 22px !important; }
        .related-grid { grid-template-columns: 1fr !important; }
    }
</style>
<script id="ghost-preview-top-question-search-script-final">
(function () {
    function q(id) { return document.getElementById(id); }

    function syncWorkInfoTopText() {
        const title = (q('jobTitle') && q('jobTitle').value.trim()) || 'Sales Manager';
        const employer = (q('employer') && q('employer').value.trim()) || 'Employer';
        const role = q('workInfoQuestionRole');
        const search = q('moreInfoSearchTitle');
        const result = q('moreInfoResultTitle');
        const headerTitle = q('moreInfoJobTitle');
        const headerEmployer = q('moreInfoEmployer');

        if (role) role.textContent = title;
        if (search && !search.value.trim()) search.value = title;
        if (result) result.textContent = search && search.value.trim() ? search.value.trim() : title;
        if (headerTitle) headerTitle.textContent = title;
        if (headerEmployer) headerEmployer.textContent = employer;
    }

    function useMockPreviewInModal() {
        const frame = q('modalTemplateFrame');
        const img = q('modalTemplateImage');
        const modalMock = q('modalMockResumePreview');
        const mock = q('mockResumePreview');
        if (!frame) return;

        if (modalMock && mock) {
            modalMock.innerHTML = mock.innerHTML;
        }

        const realImg = q('selectedTemplateImage');
        const usableRealImage = realImg && realImg.getAttribute('src') && realImg.complete && realImg.naturalWidth > 0;

        if (usableRealImage && img) {
            img.src = realImg.getAttribute('src');
            frame.classList.add('has-image');
            img.style.display = 'block';
        } else {
            if (img) {
                img.removeAttribute('src');
                img.style.display = 'none';
            }
            frame.classList.remove('has-image');
        }
    }

    async function openPreviewFixed(event) {
        if (event) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
        try {
            if (typeof applySelectedTemplatePreview === 'function') {
                await applySelectedTemplatePreview();
            }
        } catch (e) {
            console.warn('Preview template refresh failed:', e);
        }
        useMockPreviewInModal();
        const modal = q('workPreviewModal');
        if (modal) modal.classList.add('show');
    }

    function bindPreviewButtons() {
        ['btnPreviewWork', 'btnPreviewJobForm', 'btnPreviewMoreInfo'].forEach(function (id) {
            const btn = q(id);
            if (!btn || btn.dataset.previewFixed === 'true') return;
            btn.dataset.previewFixed = 'true';
            btn.addEventListener('click', openPreviewFixed, true);
        });
    }

    function bindTopControls() {
        const search = q('moreInfoSearchTitle');
        const result = q('moreInfoResultTitle');
        const searchBtn = q('btnMoreInfoSearch');
        const tipsBtn = q('workInfoTipsBtn');

        if (search && search.dataset.topReady !== 'true') {
            search.dataset.topReady = 'true';
            search.addEventListener('input', function () {
                if (result) result.textContent = search.value.trim() || 'Sales Manager';
            });
        }

        if (result && result.dataset.topReady !== 'true') {
            result.dataset.topReady = 'true';
            result.addEventListener('click', function () {
                if (search) search.value = result.textContent.trim();
            });
        }

        if (searchBtn && searchBtn.dataset.topReady !== 'true') {
            searchBtn.dataset.topReady = 'true';
            searchBtn.addEventListener('click', function () {
                if (result && search) result.textContent = search.value.trim() || 'Sales Manager';
            });
        }

        if (tipsBtn && tipsBtn.dataset.topReady !== 'true') {
            tipsBtn.dataset.topReady = 'true';
            tipsBtn.addEventListener('click', function () {
                alert('Tip: Add 3-5 strong bullet points showing tools, responsibilities, teamwork, and measurable results.');
            });
        }
    }

    function boot() {
        syncWorkInfoTopText();
        bindPreviewButtons();
        bindTopControls();
    }

    ['input', 'change'].forEach(function (evt) {
        document.addEventListener(evt, function (event) {
            if (event.target && ['jobTitle', 'employer'].includes(event.target.id)) {
                syncWorkInfoTopText();
            }
        }, true);
    });

    document.addEventListener('click', function () {
        setTimeout(syncWorkInfoTopText, 30);
    }, true);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
    window.addEventListener('load', boot);
})();
</script>


<!-- GHOST FINAL PATCH: lower top question + compact smarter search card -->
<style id="ghost-top-question-search-smart-final">
    /* Move the whole Add More Info heading area a little down */
    .work-main.work-info-mode .work-info-view,
    .work-info-view {
        padding-top: 112px !important;
    }

    .work-info-topbar {
        padding-bottom: 22px !important;
    }

    .work-info-top-copy h1 {
        margin-top: 0 !important;
        margin-bottom: 18px !important;
    }

    /* Search card: same width, longer input space, less height, cleaner look */
    .work-search-card {
        width: 100% !important;
        margin-bottom: 20px !important;
        border-radius: 14px !important;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .07) !important;
        border: 1px solid #e2e8f0 !important;
        overflow: hidden !important;
        background: #ffffff !important;
    }

    .work-search-card h2 {
        padding: 22px 24px 10px !important;
        font-size: 22px !important;
        line-height: 1.14 !important;
        letter-spacing: -0.012em !important;
        max-width: 560px !important;
    }

    .work-search-row {
        grid-template-columns: minmax(0, 1fr) 68px !important;
        gap: 14px !important;
        padding: 0 24px 16px !important;
        border-bottom: 1px solid #e2e8f0 !important;
        align-items: center !important;
    }

    .work-search-row input {
        height: 62px !important;
        min-height: 62px !important;
        border-radius: 6px !important;
        padding: 0 58px 0 20px !important;
        font-size: 24px !important;
    }

    .work-search-row::after {
        right: 112px !important;
        top: 8px !important;
        font-size: 36px !important;
    }

    .work-search-row button {
        width: 68px !important;
        height: 68px !important;
        font-size: 30px !important;
        box-shadow: 0 10px 24px rgba(36, 99, 173, .20) !important;
    }

    .related-title {
        padding: 18px 24px 10px !important;
        font-size: 16px !important;
        letter-spacing: .12em !important;
    }

    .related-grid {
        padding: 0 24px 18px !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 10px !important;
    }

    .related-grid button {
        min-height: 38px !important;
        font-size: 15px !important;
        padding: 0 16px !important;
    }

    @media (max-width: 1024px) {
        .work-main.work-info-mode .work-info-view,
        .work-info-view {
            padding-top: 64px !important;
        }
    }
</style>



<!-- GHOST FINAL PATCH: simple grey active search clear button, old preview kept unchanged -->
<style id="ghost-simple-search-clear-old-preview-final">
    /* Keep old preview modal CSS untouched; only make search X a real grey clear button */
    .work-search-row {
        position: relative !important;
    }

    .work-search-row::after {
        display: none !important;
        content: none !important;
    }

    .work-search-clear-simple {
        position: absolute !important;
        right: 118px !important;
        top: 18px !important;
        width: 28px !important;
        height: 28px !important;
        min-width: 28px !important;
        min-height: 28px !important;
        padding: 0 !important;
        margin: 0 !important;
        border: 0 !important;
        border-radius: 0 !important;
        background: transparent !important;
        color: #94a3b8 !important;
        box-shadow: none !important;
        font-size: 34px !important;
        line-height: 28px !important;
        font-weight: 400 !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 25 !important;
        transform: none !important;
    }

    .work-search-clear-simple:hover,
    .work-search-clear-simple:focus {
        color: #64748b !important;
        background: transparent !important;
        box-shadow: none !important;
        outline: none !important;
        transform: none !important;
    }

    @media (max-width: 820px) {
        .work-search-clear-simple {
            right: 112px !important;
            top: 18px !important;
        }
    }
</style>

<script id="ghost-simple-search-clear-script-final">
(function () {
    function bootSimpleSearchClear() {
        var row = document.querySelector('.work-search-row');
        var input = document.getElementById('moreInfoSearchTitle');
        var relatedTitle = document.getElementById('moreInfoResultTitle');
        if (!row || !input) return;

        var oldBlueClear = document.getElementById('btnClearMoreInfoSearch');
        if (oldBlueClear) oldBlueClear.remove();

        var clearBtn = document.getElementById('btnClearMoreInfoSearchSimple');
        if (!clearBtn) {
            clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.id = 'btnClearMoreInfoSearchSimple';
            clearBtn.className = 'work-search-clear-simple';
            clearBtn.setAttribute('aria-label', 'Clear search');
            clearBtn.innerHTML = '&times;';
            row.appendChild(clearBtn);
        }

        if (clearBtn.dataset.bound === 'true') return;
        clearBtn.dataset.bound = 'true';
        clearBtn.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            input.value = '';
            if (relatedTitle) relatedTitle.textContent = 'Sales Manager';
            input.focus();
            input.dispatchEvent(new Event('input', { bubbles: true }));
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootSimpleSearchClear);
    } else {
        bootSimpleSearchClear();
    }
    window.addEventListener('load', bootSimpleSearchClear);
    document.addEventListener('click', function () {
        setTimeout(bootSimpleSearchClear, 25);
    }, true);
})();
</script>



<!-- GHOST FINAL FIX: revert preview to first old modal style + force simple grey X -->
<style id="ghost-final-preview-revert-and-x-force">
    /* Search X: force it to stay a small grey text cross, never blue circle */
    .work-search-row {
        position: relative !important;
    }

    .work-search-row::after {
        display: none !important;
        content: none !important;
    }

    .work-search-row > button#btnClearMoreInfoSearchSimple,
    #btnClearMoreInfoSearchSimple.work-search-clear-simple,
    button#btnClearMoreInfoSearchSimple {
        all: unset !important;
        position: absolute !important;
        right: 112px !important;
        top: 19px !important;
        width: 24px !important;
        height: 24px !important;
        min-width: 24px !important;
        min-height: 24px !important;
        max-width: 24px !important;
        max-height: 24px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: #94a3b8 !important;
        background: transparent !important;
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        outline: none !important;
        font-size: 32px !important;
        line-height: 24px !important;
        font-family: Arial, Helvetica, sans-serif !important;
        font-weight: 400 !important;
        cursor: pointer !important;
        z-index: 80 !important;
        transform: none !important;
    }

    .work-search-row > button#btnClearMoreInfoSearchSimple:hover,
    .work-search-row > button#btnClearMoreInfoSearchSimple:focus,
    #btnClearMoreInfoSearchSimple.work-search-clear-simple:hover,
    #btnClearMoreInfoSearchSimple.work-search-clear-simple:focus {
        color: #64748b !important;
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        outline: none !important;
        transform: none !important;
    }

    /* Old preview modal style restored */
    #workPreviewModal.preview-modal-overlay {
        position: fixed !important;
        inset: 0 !important;
        display: none !important;
        align-items: center !important;
        justify-content: center !important;
        background: rgba(15, 23, 42, .72) !important;
        z-index: 9999 !important;
        padding: 22px !important;
    }

    #workPreviewModal.preview-modal-overlay.show {
        display: flex !important;
    }

    #workPreviewModal .preview-modal-card {
        position: relative !important;
        width: min(520px, 94vw) !important;
        height: min(760px, 90vh) !important;
        background: #ffffff !important;
        border-radius: 16px !important;
        padding: 18px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: visible !important;
        box-shadow: 0 30px 80px rgba(0,0,0,.35) !important;
    }

    #workPreviewModal .preview-modal-close {
        position: absolute !important;
        top: -14px !important;
        right: -14px !important;
        width: 40px !important;
        height: 40px !important;
        border: 0 !important;
        border-radius: 999px !important;
        background: #ffffff !important;
        color: #0f172a !important;
        font-size: 18px !important;
        cursor: pointer !important;
        box-shadow: 0 12px 32px rgba(0,0,0,.20) !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    #workPreviewModal .preview-modal-card .template-preview-frame,
    #modalTemplateFrame {
        width: 100% !important;
        height: 100% !important;
        border: 0 !important;
        background: #ffffff !important;
        overflow: hidden !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        position: relative !important;
    }

    #modalTemplateImage {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
        background: #ffffff !important;
    }

    #modalTemplateFrame.has-image #modalTemplateImage {
        display: block !important;
    }

    #modalTemplateFrame.has-image #modalMockResumePreview {
        display: none !important;
    }

    #modalTemplateFrame:not(.has-image) #modalTemplateImage {
        display: none !important;
    }

    #modalTemplateFrame:not(.has-image) #modalMockResumePreview {
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        background: #ffffff !important;
    }

    /* Put green box back only around Career History area */
    #modalTemplateFrame .work-highlight-box {
        left: 3% !important;
        right: 3% !important;
        top: 41% !important;
        height: 30.5% !important;
        border: 3px solid #34d399 !important;
        background: rgba(52, 211, 153, .14) !important;
        z-index: 25 !important;
        pointer-events: none !important;
    }

    @media (max-width: 820px) {
        .work-search-row > button#btnClearMoreInfoSearchSimple,
        #btnClearMoreInfoSearchSimple.work-search-clear-simple,
        button#btnClearMoreInfoSearchSimple {
            right: 106px !important;
            top: 19px !important;
        }
    }
</style>

<script id="ghost-final-search-clear-force-script">
(function () {
    function bootFinalGreyX() {
        var row = document.querySelector('.work-search-row');
        var input = document.getElementById('moreInfoSearchTitle');
        var relatedTitle = document.getElementById('moreInfoResultTitle');
        if (!row || !input) return;

        var btn = document.getElementById('btnClearMoreInfoSearchSimple');
        if (!btn) {
            btn = document.createElement('button');
            btn.type = 'button';
            btn.id = 'btnClearMoreInfoSearchSimple';
            btn.className = 'work-search-clear-simple';
            btn.setAttribute('aria-label', 'Clear search');
            btn.innerHTML = '&times;';
            row.appendChild(btn);
        }

        btn.innerHTML = '&times;';
        btn.className = 'work-search-clear-simple';

        if (btn.dataset.finalGreyXBound !== 'true') {
            btn.dataset.finalGreyXBound = 'true';
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                input.value = '';
                if (relatedTitle) relatedTitle.textContent = 'Sales Manager';
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.focus();
            }, true);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootFinalGreyX);
    } else {
        bootFinalGreyX();
    }
    window.addEventListener('load', bootFinalGreyX);
    document.addEventListener('click', function () { setTimeout(bootFinalGreyX, 20); }, true);
})();
</script>



<!-- GHOST FINAL ADD: Work History Summary page after Add More Info, old logic preserved -->


<!-- GHOST FINAL FIX: deferred save + required validation + working summary actions -->
<style id="ghost-summary-working-final-css">
    .work-summary-view{display:none;height:100%;padding:132px 58px 96px 48px;overflow-y:auto;background:#fff;}
    .work-main.work-summary-mode .choice-view,
    .work-main.work-summary-mode .choice-actions,
    .work-main.work-summary-mode .detail-view,
    .work-main.work-summary-mode .detail-actions,
    .work-main.work-summary-mode .job-form-view,
    .work-main.work-summary-mode .work-info-view{display:none!important;}
    .work-main.work-summary-mode .work-summary-view{display:block!important;}
    .work-main.work-summary-mode{overflow-y:auto!important;overflow-x:hidden!important;}
    .work-summary-wrap{width:min(100%,1420px);margin:0 auto;}
    .work-summary-top{display:flex;align-items:flex-start;justify-content:space-between;gap:24px;position:relative;margin-bottom:30px;}
    .work-summary-title{font-size:46px;line-height:1.08;font-weight:950;letter-spacing:-.045em;color:#071022;margin:0;}
    .work-summary-tips{border:0;background:transparent;color:#0969da;font-size:24px;font-weight:900;text-decoration:underline;display:inline-flex;align-items:center;gap:8px;cursor:pointer;margin-top:10px;}
    .summary-card-list{display:flex;flex-direction:column;gap:22px;}
    .summary-job-card{display:grid;grid-template-columns:48px minmax(0,1fr) 174px;gap:22px;min-height:150px;padding:22px 24px 18px;border:1.8px solid #cbd5e1;border-radius:8px;background:#fff;box-shadow:0 12px 30px rgba(15,23,42,.04);}
    .summary-number{width:34px;height:34px;border-radius:6px;background:#f1f5f9;border:1px solid #dbe3ef;color:#071022;font-size:18px;font-weight:900;display:inline-flex;align-items:center;justify-content:center;}
    .summary-job-title-row{display:flex;align-items:center;gap:12px;margin-bottom:8px;}
    .summary-job-title-row h2{margin:0;font-size:24px;line-height:1.15;font-weight:950;color:#071022;}
    .summary-current-pill{border-radius:999px;background:#dcfce7;color:#166534;font-size:12px;font-weight:900;padding:5px 9px;}
    .summary-meta-line{font-size:15px;color:#475569;font-weight:750;margin:0 0 10px;}
    .summary-extra-html{font-size:15px;line-height:1.55;color:#334155;max-width:980px;min-height:24px;}
    .summary-extra-html ul,.summary-extra-html ol{margin:0;padding-left:22px;}
    .summary-extra-html a{color:#0969da;text-decoration:underline;font-weight:800;}
    .summary-missing-row{margin-top:15px;padding-top:15px;border-top:1px solid #e2e8f0;display:flex;align-items:center;flex-wrap:wrap;gap:10px 14px;}
    .missing-label{font-size:14px;font-weight:950;color:#be123c;}
    .missing-chip{border:0;background:transparent;color:#0969da;text-decoration:underline;font-size:14px;font-weight:900;cursor:pointer;padding:0;}
    .summary-complete-text{font-size:14px;font-weight:900;color:#166534;}
    .summary-side-actions{display:flex;align-items:flex-start;justify-content:flex-end;gap:14px;padding-top:2px;}
    .summary-icon-btn{width:42px;height:42px;border:0;border-radius:8px;background:transparent;color:#0969da;font-size:24px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;}
    .summary-icon-btn:hover{background:#eff6ff;}
    .summary-move-btn{cursor:move!important;}
    .summary-add-section{width:100%;min-height:64px;margin-top:22px;border:2px dashed #cbd5e1;border-radius:6px;background:#fff;color:#0969da;font-size:20px;font-weight:950;display:flex;align-items:center;justify-content:center;gap:10px;cursor:pointer;}
    .summary-add-section:hover{border-color:#0969da;background:#f8fafc;}
    .work-summary-actions{display:flex;justify-content:flex-end;align-items:center;gap:28px;margin-top:42px;}
    .summary-preview-btn,.summary-next-btn{width:250px;height:68px;border-radius:999px;font-size:25px;font-weight:950;cursor:pointer;}
    .summary-preview-btn{background:#fff;color:#15168f;border:2.8px solid #15168f;}
    .summary-next-btn{background:#db1b83;color:#fff;border:0;}
    .summary-tips-popover{position:absolute;top:54px;right:0;width:520px;max-width:520px;background:#fff;border:1.8px solid #34d399;border-radius:7px;padding:18px 22px 20px;box-shadow:0 18px 42px rgba(15,23,42,.18);color:#071022;z-index:9997;display:none;}
    .summary-tips-popover.show{display:block;}
    .summary-tips-popover:before{content:"";position:absolute;top:-13px;right:62px;width:24px;height:24px;background:#fff;border-left:1.8px solid #34d399;border-top:1.8px solid #34d399;transform:rotate(45deg);}
    .summary-tips-popover h3{margin:0 0 8px;font-size:22px;line-height:1.15;font-weight:950;color:#071022;}
    .summary-tips-popover p,.summary-tips-popover li{font-size:16px;line-height:1.36;font-weight:400;color:#071022;}
    .summary-tips-popover ul{margin:12px 0 0;padding-left:22px;}
    .summary-tips-popover li{margin-bottom:8px;padding-left:4px;}

    /* GHOST FINAL: summary page fixed back, draggable cards, summary shortcut */
    .work-main.work-summary-mode .top-back{
        position:static!important;top:auto!important;left:auto!important;z-index:20!important;
        color:#2563eb!important;font-size:20px!important;font-weight:900!important;
        margin:0 0 34px 0!important;
    }
    .work-summary-view{padding-top:52px!important;}
    .summary-job-card{transition:transform .16s ease, box-shadow .16s ease, opacity .16s ease!important;}
    .summary-job-card.dragging-summary-card{opacity:.72!important;transform:scale(.992)!important;box-shadow:0 24px 55px rgba(15,23,42,.18)!important;border-color:#0969da!important;}
    .summary-job-card.drag-over-summary-card{outline:3px dashed rgba(9,105,218,.45)!important;outline-offset:5px!important;}
    .summary-move-btn{cursor:grab!important;touch-action:none!important;}
    .summary-move-btn:active{cursor:grabbing!important;}
    .summary-job-card.drag-ready{cursor:grab!important;}
    .summary-open-link{
        margin-top:14px!important;border:0!important;background:transparent!important;color:#0969da!important;
        font-size:20px!important;font-weight:900!important;text-decoration:underline!important;
        display:inline-flex!important;align-items:center!important;gap:9px!important;cursor:pointer!important;
    }
    .remote-selected-note{display:none;color:#0969da;font-size:18px;font-weight:900;margin-left:8px;}
    .job-check-row.remote-is-checked .remote-selected-note{display:inline!important;}

    @media(max-width:980px){.summary-job-card{grid-template-columns:42px minmax(0,1fr)}.summary-side-actions{grid-column:2;justify-content:flex-start}.work-summary-actions{flex-direction:column;align-items:stretch}.summary-preview-btn,.summary-next-btn{width:100%;}.summary-tips-popover{right:auto;left:0;max-width:calc(100vw - 40px);}}
</style>

<script id="ghost-work-history-final-working-logic">
(function(){
    function q(id){return document.getElementById(id);} 
    function esc(s){return String(s||'').replace(/[&<>"']/g,function(m){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m];});}
    function stripRemoteLocation(v){var clean=String(v||'').trim();clean=clean.replace(/\s*\(Remote\)\s*$/i,'').trim();if(/^remote$/i.test(clean))return '';return clean;}
    function displayRemoteLocation(v,isRemote){var base=stripRemoteLocation(v);if(!isRemote)return base;return base?base+' (Remote)':'Remote';}
    function plain(html){var d=document.createElement('div');d.innerHTML=html||'';return (d.textContent||d.innerText||'').trim();}
    function getVal(id){var el=q(id);return el?String(el.value||'').trim():'';}
    function setVal(id,val){var el=q(id);if(!el)return;if(el.type==='checkbox')el.checked=!!val;else el.value=val||'';el.dispatchEvent(new Event('input',{bubbles:true}));el.dispatchEvent(new Event('change',{bubbles:true}));}
    function token(){return localStorage.getItem('resume_token')||'';}
    function resumeId(){return localStorage.getItem('current_resume_id')||'';}
    function scopedKey(base){return base+'_'+(resumeId()||'no_resume');}
    function editorHtml(){var e=q('workAchievementsEditor');return e?e.innerHTML.trim():(localStorage.getItem(scopedKey('resume_work_history_extra_info'))||localStorage.getItem('resume_work_history_extra_info')||'');}
    function getDraft(){var stored={};try{stored=JSON.parse(localStorage.getItem(scopedKey('resume_work_history_data'))||localStorage.getItem('resume_work_history_data')||'{}')||{};}catch(e){}
        return {resume_id:resumeId()||stored.resume_id||'',reason:localStorage.getItem('resume_work_history_reason')||stored.reason||'',job_title:getVal('jobTitle')||stored.job_title||'',employer:getVal('employer')||stored.employer||'',city:stripRemoteLocation(getVal('jobCity')||stored.city||''),country:getVal('jobCountry')||stored.country||'',is_remote:!!(q('isRemote')&&q('isRemote').checked)||!!stored.is_remote,start_month:getVal('startMonth')||stored.start_month||'',start_year:getVal('startYear')||stored.start_year||'',end_month:(q('currentlyWorking')&&q('currentlyWorking').checked)?'':(getVal('endMonth')||stored.end_month||''),end_year:(q('currentlyWorking')&&q('currentlyWorking').checked)?'':(getVal('endYear')||stored.end_year||''),currently_working:!!(q('currentlyWorking')&&q('currentlyWorking').checked)||!!stored.currently_working,extra_info:editorHtml()||stored.extra_info||'',_draft:true};}
    function clean(x){var y=Object.assign({},x||{});delete y._draft;return y;}
    function meaningful(d){return !!(d&&(d.job_title||d.employer||d.city||d.start_month||d.start_year||d.end_month||d.end_year||d.is_remote||d.currently_working||plain(d.extra_info)));}
    function entries(){try{return JSON.parse(localStorage.getItem(scopedKey('resume_work_history_entries'))||'[]')||[];}catch(e){return[];}}
    function saveEntries(arr){localStorage.setItem(scopedKey('resume_work_history_entries'),JSON.stringify(arr||[]));}
    function visibleCards(){var arr=entries().slice();var d=getDraft();if(meaningful(d))arr.push(d);return arr.length?arr:[d];}
    function clearErrors(){['jobTitle','employer'].forEach(function(id){var f=q(id);if(f&&f.closest('.job-field'))f.closest('.job-field').classList.remove('has-error');var er=q(id+'Error');if(er)er.textContent='';});var sy=q('startYear');if(sy){sy.classList.remove('field-error-border');if(sy.closest('.job-field'))sy.closest('.job-field').classList.remove('has-error');}var se=q('startYearError');if(se)se.textContent='';}
    function setErr(id,msg){var f=q(id);if(f&&f.closest('.job-field'))f.closest('.job-field').classList.add('has-error');var er=q(id+'Error');if(er)er.textContent=msg;if(id==='startYear'){var sy=q('startYear');if(sy)sy.classList.add('field-error-border');var se=q('startYearError');if(se)se.textContent=msg;}}
    function anyFormInput(){return ['jobTitle','employer','jobCity','jobCountry','startMonth','startYear','endMonth','endYear'].some(function(id){return !!getVal(id);})||!!(q('isRemote')&&q('isRemote').checked)||!!(q('currentlyWorking')&&q('currentlyWorking').checked)||!!plain(editorHtml());}
    function requiredOk(){clearErrors();if(!anyFormInput())return true;var first=null;if(!getVal('jobTitle')){setErr('jobTitle','Title is required.');first=first||q('jobTitle');}if(!getVal('employer')){setErr('employer','Employer is required.');first=first||q('employer');}if(q('currentlyWorking')&&q('currentlyWorking').checked&&!getVal('startYear')){setErr('startYear','In order to proceed, you must enter start year.');first=first||q('startYear');}if(first){if(typeof showJobAlert==='function')showJobAlert('Please fill all required fields before moving to Education.');else alert('Please fill all required fields before moving to Education.');setTimeout(function(){first.focus();},20);return false;}return true;}
    function storeDraft(){var d=clean(getDraft());localStorage.setItem(scopedKey('resume_work_history_data'),JSON.stringify(d));localStorage.setItem(scopedKey('resume_work_history_extra_info'),d.extra_info||'');localStorage.setItem('resume_work_history_data',JSON.stringify(d));localStorage.setItem('resume_work_history_extra_info',d.extra_info||'');return d;}
    function showPopup(mode){if(typeof showOtherExperiencePopup==='function')showOtherExperiencePopup(mode);else if(mode==='addExperience')window.location.href='/builder/education';}

    function ensureSummary(){var wm=q('workMain');if(!wm)return null;var sec=q('workSummaryView');if(sec)return sec;sec=document.createElement('section');sec.id='workSummaryView';sec.className='work-summary-view';sec.innerHTML='<div class="work-summary-wrap"><div class="work-summary-top"><h1 class="work-summary-title">Work history summary</h1><button type="button" class="work-summary-tips" id="workSummaryTips"><i class="fa-regular fa-lightbulb"></i><span>Tips</span></button></div><div class="summary-card-list" id="summaryCardList"></div><button type="button" class="summary-add-section" id="btnSummaryAddPosition"><i class="fa-solid fa-plus"></i><span>Add another position</span></button><div class="work-summary-actions"><button type="button" class="summary-preview-btn" id="btnSummaryPreview">Preview</button><button type="button" class="summary-next-btn" id="btnSummaryNextEducation">Next: Education</button></div></div>';wm.appendChild(sec);return sec;}
    function dateText(d){var st=[d.start_month,d.start_year].filter(Boolean).join(' ');var en=d.currently_working?'Current':[d.end_month,d.end_year].filter(Boolean).join(' ');return [st,en].filter(Boolean).join(' - ');}
    function missing(d){var m=[];if(!d.city)m.push(['location','Add location']);if(!d.start_month||!d.start_year)m.push(['start','Add start date']);if(!d.currently_working&&(!d.end_month||!d.end_year))m.push(['end','Add end date']);if(!d.is_remote)m.push(['remote','Add remote status']);if(!plain(d.extra_info))m.push(['info','Add description']);return m;}
    function cardHtml(d,i){var meta=[];var dt=dateText(d);var locText=displayRemoteLocation(d.city,d.is_remote);if(locText)meta.push(locText);if(dt)meta.push(dt);var miss=missing(d);var missHtml=miss.length?'<div class="summary-missing-row"><span class="missing-label">Missing details:</span>'+miss.map(function(x){return '<button type="button" class="missing-chip" data-index="'+i+'" data-missing="'+x[0]+'">'+x[1]+'</button>';}).join('')+'</div>':'<div class="summary-missing-row"><span class="summary-complete-text">All optional details completed.</span></div>';var extra=plain(d.extra_info)?'<div class="summary-extra-html">'+d.extra_info+'</div>':'<div class="summary-extra-html" style="color:#64748b;font-weight:700;">No achievements added yet.</div>';return '<article class="summary-job-card" draggable="true" data-index="'+i+'"><div><span class="summary-number">'+(i+1)+'</span></div><div class="summary-job-main"><div class="summary-job-title-row"><h2>'+esc(d.job_title||'Job title')+', '+esc(d.employer||'Employer')+'</h2>'+(d.currently_working?'<span class="summary-current-pill">Current</span>':'')+'</div><p class="summary-meta-line">'+(meta.length?esc(meta.join(' · ')):'Add location and employment dates')+'</p>'+extra+missHtml+'</div><div class="summary-side-actions"><button type="button" class="summary-icon-btn summary-edit-btn" data-index="'+i+'" title="Edit"><i class="fa-solid fa-pen"></i></button><button type="button" class="summary-icon-btn summary-delete-btn" data-index="'+i+'" title="Delete"><i class="fa-solid fa-trash"></i></button><button type="button" class="summary-icon-btn summary-move-btn" data-index="'+i+'" title="Move"><i class="fa-solid fa-arrows-up-down-left-right"></i></button></div></article>';}
    function render(){ensureSummary();var list=q('summaryCardList');if(!list)return;var cards=visibleCards();list.innerHTML=cards.map(cardHtml).join('');initSummaryDragging();}
    function openSummary(){var editIndex=localStorage.getItem('resume_work_history_edit_index');if(editIndex!==null&&editIndex!==''&&!isNaN(Number(editIndex))){var arr=entries();var d=clean(getDraft());if(meaningful(d)){arr[Number(editIndex)]=d;saveEntries(arr);localStorage.removeItem('resume_work_history_edit_index');localStorage.setItem(scopedKey('resume_work_history_data'),'{}');localStorage.setItem('resume_work_history_data','{}');}}
        render();var wm=q('workMain');if(wm){['detail-mode','job-form-mode','work-info-mode'].forEach(function(c){wm.classList.remove(c);});wm.classList.add('work-summary-mode');setTimeout(function(){wm.scrollTo({top:0,behavior:'smooth'});},25);}localStorage.setItem('resume_work_history_summary_open','true');}
    function populate(d){d=d||{};setVal('jobTitle',d.job_title||'');setVal('employer',d.employer||'');setVal('jobCity',displayRemoteLocation(d.city,!!d.is_remote));setVal('jobCountry',d.country||'');setVal('isRemote',!!d.is_remote);setVal('startMonth',d.start_month||'');setVal('startYear',d.start_year||'');setVal('endMonth',d.end_month||'');setVal('endYear',d.end_year||'');setVal('currentlyWorking',!!d.currently_working);var ed=q('workAchievementsEditor');if(ed)ed.innerHTML=d.extra_info||'';localStorage.setItem(scopedKey('resume_work_history_data'),JSON.stringify(clean(d)));localStorage.setItem(scopedKey('resume_work_history_extra_info'),d.extra_info||'');localStorage.setItem('resume_work_history_data',JSON.stringify(clean(d)));localStorage.setItem('resume_work_history_extra_info',d.extra_info||'');}
    function openFormFor(index,key){var cards=visibleCards();var d=cards[index]||{};populate(d);if(index<entries().length)localStorage.setItem('resume_work_history_edit_index',String(index));else localStorage.removeItem('resume_work_history_edit_index');var wm=q('workMain');if(wm){wm.classList.remove('work-summary-mode');wm.classList.remove('work-info-mode');wm.classList.add(key==='info'?'work-info-mode':'job-form-mode');setTimeout(function(){wm.scrollTo({top:0,behavior:'smooth'});},25);}var map={location:'jobCity',start:'startMonth',end:'endMonth',remote:'isRemote',info:'workAchievementsEditor'};var target=q(map[key]||'jobTitle');setTimeout(function(){if(target)target.focus();},100);}
    function commitDraftAndFresh(){var arr=entries();var d=clean(getDraft());var editIndex=localStorage.getItem('resume_work_history_edit_index');if(meaningful(d)){if(editIndex!==null&&editIndex!==''&&!isNaN(Number(editIndex)))arr[Number(editIndex)]=d;else arr.push(d);saveEntries(arr);}var form=q('workHistoryForm');if(form)form.reset();var ed=q('workAchievementsEditor');if(ed)ed.innerHTML='';localStorage.removeItem('resume_work_history_edit_index');localStorage.removeItem(scopedKey('resume_work_history_extra_info'));localStorage.removeItem('resume_work_history_extra_info');localStorage.setItem(scopedKey('resume_work_history_data'),'{}');localStorage.setItem('resume_work_history_data','{}');var wm=q('workMain');if(wm){wm.classList.remove('work-summary-mode');wm.classList.remove('work-info-mode');wm.classList.add('job-form-mode');setTimeout(function(){wm.scrollTo({top:0,behavior:'smooth'});},25);}setTimeout(function(){if(q('jobTitle'))q('jobTitle').focus();},100);}
    function deleteCard(index){var cards=visibleCards().map(clean).filter(meaningful);cards.splice(index,1);saveEntries(cards);var form=q('workHistoryForm');if(form)form.reset();var ed=q('workAchievementsEditor');if(ed)ed.innerHTML='';localStorage.setItem(scopedKey('resume_work_history_data'),'{}');localStorage.setItem('resume_work_history_data','{}');localStorage.removeItem(scopedKey('resume_work_history_extra_info'));localStorage.removeItem('resume_work_history_extra_info');render();}
    function moveCard(index){var cards=visibleCards().map(clean).filter(meaningful);if(cards.length<2)return;var item=cards.splice(index,1)[0];var ni=index===0?cards.length:index-1;cards.splice(ni,0,item);saveEntries(cards);var form=q('workHistoryForm');if(form)form.reset();var ed=q('workAchievementsEditor');if(ed)ed.innerHTML='';localStorage.setItem(scopedKey('resume_work_history_data'),'{}');localStorage.setItem('resume_work_history_data','{}');localStorage.removeItem(scopedKey('resume_work_history_extra_info'));localStorage.removeItem('resume_work_history_extra_info');render();}
    function tips(e){if(e){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();}var top=document.querySelector('.work-summary-top');if(!top)return;var pop=q('summaryTipsPopover');if(!pop){pop=document.createElement('div');pop.id='summaryTipsPopover';pop.className='summary-tips-popover';pop.innerHTML='<h3>Expert Insights</h3><p>Hiring managers scan this information for career progression, job length, growth, promotions, similar experience, and employment gaps.</p><ul><li>Enter basic information about your previous jobs so employers can see where you worked.</li><li>Do not abbreviate job titles. Full titles look more professional.</li><li>Include start and end dates for each position.</li><li>Use your best guess if you cannot remember exact details; you can edit later.</li></ul>';top.appendChild(pop);}pop.classList.toggle('show');}
    async function saveAllAndEducation(e){if(e){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();}var cards=visibleCards().map(clean).filter(meaningful);var next=q('btnSummaryNextEducation');if(next){next.disabled=true;next.textContent='Saving...';}try{for(var i=0;i<cards.length;i++){var c=Object.assign({},cards[i]);c.resume_id=resumeId();var res=await fetch('http://localhost:5000/api/resumes/work-history',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+token()},body:JSON.stringify(c)});var data=await res.json().catch(function(){return{};});if(!res.ok||data.success===false)throw new Error(data.message||'Save failed');}}catch(err){console.error(err);if(typeof showJobAlert==='function')showJobAlert('Work history final save failed. Please check backend then try again.');else alert('Work history final save failed.');if(next){next.disabled=false;next.textContent='Next: Education';}return;}saveEntries(cards);localStorage.removeItem('resume_work_history_form_open');localStorage.removeItem('resume_work_history_detail_open');localStorage.removeItem('resume_work_history_summary_open');window.location.href='/builder/education';}


    function addSummaryShortcut(){
        var header=document.querySelector('.job-form-header');
        if(!header||q('btnOpenWorkSummaryFromForm'))return;
        var box=document.createElement('div');
        box.style.display='flex';box.style.flexDirection='column';box.style.alignItems='flex-end';box.style.gap='8px';
        var tips=q('jobTipsBtn');
        if(tips&&tips.parentNode){tips.parentNode.insertBefore(box,tips);box.appendChild(tips);}
        else header.appendChild(box);
        var b=document.createElement('button');b.type='button';b.id='btnOpenWorkSummaryFromForm';b.className='summary-open-link';
        b.innerHTML='<i class="fa-solid fa-list-check"></i><span>Work history summary</span>';
        box.appendChild(b);
    }
    function syncRemoteText(){
        var r=q('isRemote');var city=q('jobCity');if(!r||!city)return;
        city.value = displayRemoteLocation(city.value, !!r.checked);
        var row=r.closest('.job-check-row');
        if(row) row.classList.toggle('remote-is-checked', false);
    }
    function resetIfResumeChanged(){
        var rid=resumeId()||'no_resume';var last=localStorage.getItem('resume_work_history_last_resume_id');
        if(last&&last!==rid){
            ['resume_work_history_summary_open','resume_work_history_form_open','resume_work_history_detail_open','resume_work_history_edit_index'].forEach(function(k){localStorage.removeItem(k);});
            localStorage.setItem('resume_work_history_data','{}');localStorage.removeItem('resume_work_history_extra_info');
        }
        localStorage.setItem('resume_work_history_last_resume_id',rid);
    }
    function formResetForFresh(){
        var f=q('workHistoryForm');if(f)f.reset();var ed=q('workAchievementsEditor');if(ed)ed.innerHTML='';
        localStorage.removeItem('resume_work_history_edit_index');localStorage.setItem(scopedKey('resume_work_history_data'),'{}');localStorage.setItem('resume_work_history_data','{}');
        localStorage.removeItem(scopedKey('resume_work_history_extra_info'));localStorage.removeItem('resume_work_history_extra_info');syncRemoteText();
    }
    function moveArrayItem(arr,from,to){if(from===to||from<0||to<0||from>=arr.length||to>=arr.length)return arr;var item=arr.splice(from,1)[0];arr.splice(to,0,item);return arr;}
    function initSummaryDragging(){
        var list=q('summaryCardList');if(!list||list.dataset.dragReady==='1')return;list.dataset.dragReady='1';var dragIndex=null;
        list.addEventListener('dragstart',function(e){var card=e.target.closest('.summary-job-card');var handle=e.target.closest('.summary-move-btn');if(!card||!handle){e.preventDefault();return;}dragIndex=Number(card.dataset.index);card.classList.add('dragging-summary-card');try{e.dataTransfer.effectAllowed='move';e.dataTransfer.setData('text/plain',String(dragIndex));}catch(err){}},true);
        list.addEventListener('dragover',function(e){var card=e.target.closest('.summary-job-card');if(!card)return;e.preventDefault();card.classList.add('drag-over-summary-card');try{e.dataTransfer.dropEffect='move';}catch(err){}},true);
        list.addEventListener('dragleave',function(e){var card=e.target.closest('.summary-job-card');if(card)card.classList.remove('drag-over-summary-card');},true);
        list.addEventListener('drop',function(e){var card=e.target.closest('.summary-job-card');if(!card)return;e.preventDefault();var to=Number(card.dataset.index);var from=dragIndex;document.querySelectorAll('.summary-job-card').forEach(function(c){c.classList.remove('dragging-summary-card','drag-over-summary-card');});if(isNaN(from)||isNaN(to)||from===to)return;var cards=visibleCards().map(clean).filter(meaningful);moveArrayItem(cards,from,to);saveEntries(cards);var f=q('workHistoryForm');if(f)f.reset();var ed=q('workAchievementsEditor');if(ed)ed.innerHTML='';localStorage.setItem(scopedKey('resume_work_history_data'),'{}');localStorage.setItem('resume_work_history_data','{}');render();initSummaryDragging();},true);
        list.addEventListener('dragend',function(){dragIndex=null;document.querySelectorAll('.summary-job-card').forEach(function(c){c.classList.remove('dragging-summary-card','drag-over-summary-card');});},true);
    }

    document.addEventListener('submit',function(e){if(e.target&&e.target.id==='workHistoryForm'){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();if(!requiredOk())return;if(!anyFormInput()){localStorage.setItem('resume_work_history_form_open','true');showPopup('addExperience');return;}storeDraft();localStorage.setItem('resume_work_history_form_open','true');localStorage.removeItem('resume_work_history_detail_open');showPopup('moreInfo');}},true);
    document.addEventListener('click',function(e){var t=e.target;if(t.closest&&t.closest('#btnOpenWorkSummaryFromForm')){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();openSummary();return;}if(t.closest&&t.closest('#btnNextMoreInfo')){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();storeDraft();openSummary();return;}if(t.closest&&t.closest('#btnSummaryPreview')){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();var m=q('modalMockResumePreview'), mock=q('mockResumePreview'), modal=q('workPreviewModal');if(m&&mock)m.innerHTML=mock.innerHTML;if(modal)modal.classList.add('show');return;}if(t.closest&&t.closest('#btnSummaryNextEducation'))return saveAllAndEducation(e);var wm=q('workMain');if(!wm||!wm.classList.contains('work-summary-mode'))return;if(t.closest&&t.closest('#workSummaryTips'))return tips(e);if(t.closest&&t.closest('#btnSummaryAddPosition')){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();return commitDraftAndFresh();}var edit=t.closest&&t.closest('.summary-edit-btn');if(edit){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();return openFormFor(Number(edit.dataset.index),null);}var del=t.closest&&t.closest('.summary-delete-btn');if(del){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();return deleteCard(Number(del.dataset.index));}var mov=t.closest&&t.closest('.summary-move-btn');if(mov){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();return moveCard(Number(mov.dataset.index));}var miss=t.closest&&t.closest('.missing-chip');if(miss){e.preventDefault();e.stopPropagation();e.stopImmediatePropagation();return openFormFor(Number(miss.dataset.index),miss.dataset.missing);}},true);
    function boot(){resetIfResumeChanged();ensureSummary();addSummaryShortcut();syncRemoteText();var r=q('isRemote');if(r&&!r.dataset.remoteWatch){r.dataset.remoteWatch='1';r.addEventListener('change',syncRemoteText);r.addEventListener('click',function(){setTimeout(syncRemoteText,0);});}var wm=q('workMain');if(wm&&localStorage.getItem('resume_work_history_summary_open')==='true'&&entries().length>0){openSummary();}else if(wm&&localStorage.getItem('resume_work_history_summary_open')==='true'&&entries().length===0){localStorage.removeItem('resume_work_history_summary_open');}}
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',boot);else boot();
    window.addEventListener('load',boot);
})();
</script>



<!-- GHOST FINAL SMALL PATCH: Remote text stays inside Location field only -->
<style id="ghost-remote-inside-location-only-final">
    .remote-selected-note { display: none !important; }
</style>
<script id="ghost-remote-inside-location-only-final-script">
(function(){
    function q(id){return document.getElementById(id);}
    function stripRemote(v){var clean=String(v||'').trim();clean=clean.replace(/\s*\(Remote\)\s*$/i,'').trim();if(/^remote$/i.test(clean))return '';return clean;}
    function format(v,on){var base=stripRemote(v);return on?(base?base+' (Remote)':'Remote'):base;}
    function sync(){var c=q('jobCity'), r=q('isRemote');if(!c||!r)return;c.value=format(c.value,r.checked);}
    function boot(){var c=q('jobCity'), r=q('isRemote');if(r && r.dataset.remoteInsideLocationReady!=='1'){r.dataset.remoteInsideLocationReady='1';r.addEventListener('change',sync);r.addEventListener('click',function(){setTimeout(sync,0);});}
        if(c && c.dataset.remoteInsideLocationReady!=='1'){c.dataset.remoteInsideLocationReady='1';c.addEventListener('blur',sync);c.addEventListener('input',function(){if(q('isRemote')&&q('isRemote').checked){var base=stripRemote(c.value);if(base)c.dataset.remoteBase=base;}});}
        sync();}
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',boot);else boot();
    window.addEventListener('load',boot);
})();
</script>



<!-- GHOST FINAL FIX 2: Summary Go Back exact position + real drag handle + missing flag only on empty skip -->
<style id="ghost-summary-back-drag-missing-fix-v2">
    /* Summary page Go Back: normal page-flow above Work history summary, scrolls with summary text */
    .work-main.work-summary-mode .top-back,
    body .work-main.work-summary-mode a.top-back#topBackLink {
        position: static !important;
        left: auto !important;
        top: auto !important;
        right: auto !important;
        bottom: auto !important;
        z-index: 20 !important;
        color: #2563eb !important;
        font-size: 20px !important;
        font-weight: 950 !important;
        line-height: 1 !important;
        background: transparent !important;
        padding: 0 !important;
        margin: 0 0 34px 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        text-decoration: none !important;
    }

    .work-main.work-summary-mode .work-summary-view {
        padding-top: 52px !important;
    }

    /* New drag handle class. Old click-move class is removed by JS. */
    .summary-drag-handle {
        cursor: grab !important;
        touch-action: none !important;
        user-select: none !important;
    }
    .summary-drag-handle:active { cursor: grabbing !important; }

    .summary-job-card.ghost-dragging-card {
        opacity: .92 !important;
        transform: scale(.995) !important;
        box-shadow: 0 26px 60px rgba(15,23,42,.20) !important;
        border-color: #0969da !important;
        z-index: 99999 !important;
    }

    .summary-job-card.ghost-drop-before {
        border-top: 4px solid #0969da !important;
    }

    .summary-job-card.ghost-drop-after {
        border-bottom: 4px solid #0969da !important;
    }
</style>

<script id="ghost-summary-back-drag-missing-fix-v2-script">
(function(){
    function q(id){ return document.getElementById(id); }
    function rid(){ return localStorage.getItem('current_resume_id') || 'no_resume'; }
    function scoped(base){ return base + '_' + rid(); }
    function plain(html){ var d=document.createElement('div'); d.innerHTML=html||''; return (d.textContent||d.innerText||'').trim(); }
    function readJson(key, fallback){ try { return JSON.parse(localStorage.getItem(key) || fallback); } catch(e){ return JSON.parse(fallback); } }
    function getEntries(){ return readJson(scoped('resume_work_history_entries'), '[]') || []; }
    function saveEntries(arr){ localStorage.setItem(scoped('resume_work_history_entries'), JSON.stringify(arr || [])); }
    function getDraft(){ return readJson(scoped('resume_work_history_data'), '{}') || readJson('resume_work_history_data','{}') || {}; }
    function hasMeaningfulWorkData(obj){
        obj = obj || {};
        return !!(
            String(obj.job_title||'').trim() ||
            String(obj.employer||'').trim() ||
            String(obj.city||'').trim() ||
            String(obj.country||'').trim() ||
            String(obj.start_month||'').trim() ||
            String(obj.start_year||'').trim() ||
            String(obj.end_month||'').trim() ||
            String(obj.end_year||'').trim() ||
            obj.is_remote || obj.currently_working || plain(obj.extra_info)
        );
    }
    function hasAnySavedOrDraftData(){
        if ((getEntries() || []).some(hasMeaningfulWorkData)) return true;
        if (hasMeaningfulWorkData(getDraft())) return true;
        var ids=['jobTitle','employer','jobCity','jobCountry','startMonth','startYear','endMonth','endYear'];
        if (ids.some(function(id){ var el=q(id); return el && String(el.value||'').trim(); })) return true;
        if (q('isRemote') && q('isRemote').checked) return true;
        if (q('currentlyWorking') && q('currentlyWorking').checked) return true;
        var ed=q('workAchievementsEditor');
        if(ed && plain(ed.innerHTML)) return true;
        return false;
    }
    function clearMissingFlag(){
        localStorage.removeItem('resume_work_history_missing_information_' + rid());
        localStorage.removeItem('resume_work_history_skip_without_data');
    }
    function setMissingFlagIfEmpty(){
        if (hasAnySavedOrDraftData()) clearMissingFlag();
        else {
            localStorage.setItem('resume_work_history_missing_information_' + rid(), 'true');
            localStorage.removeItem('resume_work_history_skip_without_data');
        }
    }

    function ensureBackPosition(){
        var wm=q('workMain'), back=q('topBackLink'), wrap=document.querySelector('.work-summary-wrap');
        if(!wm || !back) return;

        if(!window.__ghostBackOriginalParent && back.parentNode){
            window.__ghostBackOriginalParent = back.parentNode;
            window.__ghostBackOriginalNext = back.nextSibling;
        }

        if(wm.classList.contains('work-summary-mode')){
            if(wrap && back.parentNode !== wrap){
                wrap.insertBefore(back, wrap.firstChild);
            }
            back.style.setProperty('position','static','important');
            back.style.setProperty('left','auto','important');
            back.style.setProperty('top','auto','important');
            back.style.setProperty('right','auto','important');
            back.style.setProperty('bottom','auto','important');
            back.style.setProperty('z-index','20','important');
            back.style.setProperty('background','transparent','important');
            back.style.setProperty('margin','0 0 34px 0','important');
            back.style.setProperty('display','inline-flex','important');
        } else if(window.__ghostBackOriginalParent && back.parentNode !== window.__ghostBackOriginalParent){
            window.__ghostBackOriginalParent.insertBefore(back, window.__ghostBackOriginalNext || window.__ghostBackOriginalParent.firstChild);
            back.removeAttribute('style');
        }
    }

    function normalizeDragHandles(){
        document.querySelectorAll('.summary-move-btn').forEach(function(btn){
            btn.classList.remove('summary-move-btn');
            btn.classList.add('summary-drag-handle');
            btn.setAttribute('draggable','false');
            btn.setAttribute('title','Drag to move');
        });
        document.querySelectorAll('.summary-job-card').forEach(function(card){
            card.setAttribute('draggable','false');
        });
    }

    var drag = null;
    function cardsList(){ return Array.from(document.querySelectorAll('#summaryCardList .summary-job-card')); }
    function currentCardsData(){
        var all = getEntries().slice();
        var draft = getDraft();
        if (hasMeaningfulWorkData(draft)) all.push(draft);
        return all.filter(hasMeaningfulWorkData);
    }
    function clearDraftAfterReorder(){
        localStorage.setItem(scoped('resume_work_history_data'), '{}');
        localStorage.setItem('resume_work_history_data', '{}');
        localStorage.removeItem(scoped('resume_work_history_extra_info'));
        localStorage.removeItem('resume_work_history_extra_info');
        localStorage.removeItem('resume_work_history_edit_index');
    }
    function finishDrag(save){
        if(!drag) return;
        var list=q('summaryCardList');
        document.removeEventListener('pointermove', onPointerMove, true);
        document.removeEventListener('pointerup', onPointerUp, true);
        document.removeEventListener('pointercancel', onPointerUp, true);
        cardsList().forEach(function(c){ c.classList.remove('ghost-dragging-card','ghost-drop-before','ghost-drop-after'); });
        if(save && list){
            var original = drag.data;
            var ordered = cardsList().map(function(card){ return original[Number(card.dataset.dragOriginalIndex)]; }).filter(Boolean);
            saveEntries(ordered);
            clearDraftAfterReorder();
            clearMissingFlag();
            setTimeout(function(){ if(typeof window.renderCoreSummary === 'function') window.renderCoreSummary(); }, 0);
        }
        drag = null;
    }
    function onPointerUp(e){
        e.preventDefault();
        finishDrag(true);
    }
    function onPointerMove(e){
        if(!drag) return;
        e.preventDefault();
        var list=q('summaryCardList'); if(!list) return;
        var target = cardsList().find(function(card){
            if(card === drag.card) return false;
            var r = card.getBoundingClientRect();
            return e.clientY >= r.top && e.clientY <= r.bottom;
        });
        cardsList().forEach(function(c){ c.classList.remove('ghost-drop-before','ghost-drop-after'); });
        if(target){
            var r=target.getBoundingClientRect();
            if(e.clientY < r.top + r.height/2){
                target.classList.add('ghost-drop-before');
                list.insertBefore(drag.card, target);
            } else {
                target.classList.add('ghost-drop-after');
                list.insertBefore(drag.card, target.nextSibling);
            }
        }
    }
    function startDrag(e){
        var handle = e.target.closest && e.target.closest('.summary-drag-handle');
        if(!handle) return;
        var card = handle.closest('.summary-job-card');
        var list = q('summaryCardList');
        if(!card || !list) return;
        e.preventDefault();
        e.stopPropagation();
        normalizeDragHandles();
        var data = currentCardsData();
        cardsList().forEach(function(c,i){ c.dataset.dragOriginalIndex = String(i); });
        drag = { card: card, data: data };
        card.classList.add('ghost-dragging-card');
        try { handle.setPointerCapture && handle.setPointerCapture(e.pointerId); } catch(err) {}
        document.addEventListener('pointermove', onPointerMove, true);
        document.addEventListener('pointerup', onPointerUp, true);
        document.addEventListener('pointercancel', onPointerUp, true);
    }

    function boot(){
        ensureBackPosition();
        normalizeDragHandles();
        var list=q('summaryCardList');
        if(list && list.dataset.ghostPointerDragReady !== '1'){
            list.dataset.ghostPointerDragReady = '1';
            list.addEventListener('pointerdown', startDrag, true);
        }
        var observerTarget=q('workMain') || document.body;
        if(observerTarget && observerTarget.dataset.ghostSummaryObserverReady !== '1'){
            observerTarget.dataset.ghostSummaryObserverReady = '1';
            new MutationObserver(function(){ ensureBackPosition(); normalizeDragHandles(); }).observe(observerTarget,{childList:true,subtree:true,attributes:true,attributeFilter:['class']});
        }
    }

    /* Stop the old click-to-move behavior from firing on the new drag handle. */
    document.addEventListener('click', function(e){
        var h=e.target.closest && e.target.closest('.summary-drag-handle');
        if(h){ e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation(); return false; }
    }, true);

    /* Missing note flag: only when user goes Education with completely empty Work History. */
    document.addEventListener('click', function(e){
        var noThanks = e.target.closest && e.target.closest('#btnNoThanksExperience');
        if(noThanks){ setMissingFlagIfEmpty(); }

        var finalNext = e.target.closest && e.target.closest('#btnSummaryNextEducation');
        if(finalNext){
            if(hasAnySavedOrDraftData()) clearMissingFlag();
            else setMissingFlagIfEmpty();
        }

        var moreInfoNext = e.target.closest && e.target.closest('#btnNextMoreInfo, #btnContinueMoreInfoChoice, #btnSkipMoreInfoChoice, #btnAddAnotherExperience');
        if(moreInfoNext && hasAnySavedOrDraftData()) clearMissingFlag();
    }, true);

    document.addEventListener('input', function(e){
        if(e.target && ['jobTitle','employer','jobCity','jobCountry','startMonth','startYear','endMonth','endYear','workAchievementsEditor'].includes(e.target.id)){
            if(hasAnySavedOrDraftData()) clearMissingFlag();
        }
    }, true);
    document.addEventListener('change', function(e){
        if(e.target && ['isRemote','currentlyWorking','startMonth','endMonth'].includes(e.target.id)){
            if(hasAnySavedOrDraftData()) clearMissingFlag();
        }
    }, true);

    window.renderCoreSummary = function(){
        /* Let existing render keep UI if available through old click flows; this just re-normalizes after DOM changes. */
        setTimeout(function(){ ensureBackPosition(); normalizeDragHandles(); }, 30);
    };

    if(document.readyState==='loading') document.addEventListener('DOMContentLoaded', boot); else boot();
    window.addEventListener('load', boot);
    setInterval(function(){ var wm=q('workMain'); if(wm && wm.classList.contains('work-summary-mode')) boot(); }, 700);
})();
</script>





<!-- GHOST CLEAN FINAL PATCH: one stable Use This Work checkbox + no duplicate cards + no Go Back touch -->
<style id="ghost-clean-use-this-work-checkbox-only-final">
    /* Hide any old radio/checkbox rows if old code exists somewhere. Only our clean row remains. */
    #workMain.work-summary-mode .summary-use-work-row,
    #workMain.work-summary-mode .summary-use-work-row-v8,
    #workMain.work-summary-mode .summary-use-work-row-v9,
    #workMain.work-summary-mode .summary-use-work-row-final,
    #workMain.work-summary-mode .summary-use-work-input {
        display: none !important;
    }

    #workMain.work-summary-mode .summary-use-work-row-clean {
        margin-top: 13px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
        cursor: pointer !important;
        user-select: none !important;
        color: #0969da !important;
        font-size: 15px !important;
        font-weight: 900 !important;
        text-decoration: underline !important;
        line-height: 1 !important;
    }

    #workMain.work-summary-mode .summary-use-work-row-clean input[type="checkbox"] {
        display: inline-block !important;
        width: 18px !important;
        height: 18px !important;
        min-width: 18px !important;
        min-height: 18px !important;
        margin: 0 !important;
        padding: 0 !important;
        accent-color: #0969da !important;
        cursor: pointer !important;
    }

    #workMain.work-summary-mode .summary-use-work-row-clean span {
        color: #0969da !important;
        text-decoration: underline !important;
        font-weight: 900 !important;
    }
</style>

<script id="ghost-clean-use-this-work-checkbox-only-final-script">
(function () {
    function q(id) { return document.getElementById(id); }
    function rid() { return localStorage.getItem('current_resume_id') || 'no_resume'; }
    function scopedKey(base) { return base + '_' + rid(); }

    function readJSON(key, fallback) {
        try {
            var raw = localStorage.getItem(key);
            if (!raw) return fallback;
            var parsed = JSON.parse(raw);
            return parsed == null ? fallback : parsed;
        } catch (e) {
            return fallback;
        }
    }

    function writeJSON(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    }

    function plain(html) {
        var div = document.createElement('div');
        div.innerHTML = html || '';
        return String(div.textContent || div.innerText || '').replace(/\s+/g, ' ').trim();
    }

    function cleanWork(item) {
        var x = Object.assign({}, item || {});
        delete x._draft;
        return x;
    }

    function hasWorkData(item) {
        item = item || {};
        return !!(
            String(item.job_title || '').trim() ||
            String(item.employer || '').trim() ||
            String(item.city || '').trim() ||
            String(item.country || '').trim() ||
            String(item.start_month || '').trim() ||
            String(item.start_year || '').trim() ||
            String(item.end_month || '').trim() ||
            String(item.end_year || '').trim() ||
            item.is_remote ||
            item.currently_working ||
            plain(item.extra_info)
        );
    }

    function signature(item) {
        item = cleanWork(item || {});
        return [
            item.job_title || '',
            item.employer || '',
            item.city || '',
            item.country || '',
            item.is_remote ? '1' : '0',
            item.start_month || '',
            item.start_year || '',
            item.end_month || '',
            item.end_year || '',
            item.currently_working ? '1' : '0',
            plain(item.extra_info || '')
        ].map(function (v) { return String(v).trim().toLowerCase(); }).join('|');
    }

    function uniqueWorks(list) {
        var seen = new Set();
        var out = [];
        (list || []).forEach(function (item) {
            item = cleanWork(item);
            if (!hasWorkData(item)) return;
            var sig = signature(item);
            if (seen.has(sig)) return;
            seen.add(sig);
            out.push(item);
        });
        return out;
    }

    function getCurrentDraft() {
        return readJSON(scopedKey('resume_work_history_data'), null) || readJSON('resume_work_history_data', null) || {};
    }

    function getWorksFromStorage() {
        var entries = readJSON(scopedKey('resume_work_history_entries'), []);
        if (!Array.isArray(entries)) entries = [];

        var draft = getCurrentDraft();
        var all = entries.map(cleanWork);
        if (hasWorkData(draft)) all.push(cleanWork(draft));
        return uniqueWorks(all);
    }

    function saveDedupedWorks(works) {
        works = uniqueWorks(works || []);
        writeJSON(scopedKey('resume_work_history_entries'), works);
        /* Clear duplicate draft only after it is safely copied to entries. */
        writeJSON(scopedKey('resume_work_history_data'), {});
        writeJSON('resume_work_history_data', {});
        return works;
    }

    function selectedIndexes() {
        var scoped = readJSON(scopedKey('resume_work_history_use_this_indexes'), null);
        var global = readJSON('resume_work_history_use_this_indexes', []);
        var arr = Array.isArray(scoped) ? scoped : (Array.isArray(global) ? global : []);
        return Array.from(new Set(arr.map(Number).filter(function (n) { return !isNaN(n); })));
    }

    function setEducationTransfer(selectedWorks) {
        selectedWorks = Array.isArray(selectedWorks) ? selectedWorks : [];

        writeJSON(scopedKey('resume_work_history_selected_for_education'), selectedWorks);
        writeJSON('resume_work_history_selected_for_education_' + rid(), selectedWorks);
        writeJSON('resume_work_history_selected_for_education', selectedWorks);

        /* Education page will read this. If nothing is checked, Work History must be treated as missing. */
        var missing = selectedWorks.length === 0;
        localStorage.setItem(scopedKey('resume_work_history_missing_info'), missing ? 'true' : 'false');
        localStorage.setItem('resume_work_history_missing_info', missing ? 'true' : 'false');
        localStorage.setItem('resume_work_history_has_missing_for_education', missing ? 'true' : 'false');
    }

    function saveCheckboxSelection() {
        var works = getWorksFromStorage();
        var indexes = Array.from(document.querySelectorAll('#summaryCardList .summary-use-this-work-check-clean'))
            .map(function (cb) {
                return cb.checked ? Number(cb.dataset.index) : null;
            })
            .filter(function (v) {
                return v !== null && !isNaN(v) && works[v];
            });

        indexes = Array.from(new Set(indexes)).sort(function (a, b) { return a - b; });
        var selectedWorks = indexes.map(function (i) { return works[i]; }).filter(Boolean);

        writeJSON(scopedKey('resume_work_history_use_this_indexes'), indexes);
        writeJSON('resume_work_history_use_this_indexes', indexes);
        setEducationTransfer(selectedWorks);
        return selectedWorks;
    }

    function removeDuplicateCardsFromDom() {
        var list = q('summaryCardList');
        if (!list) return;
        var seen = new Set();

        Array.from(list.querySelectorAll('.summary-job-card')).forEach(function (card) {
            var title = (card.querySelector('.summary-job-title-row h2') || {}).textContent || '';
            var meta = (card.querySelector('.summary-meta-line') || {}).textContent || '';
            var extra = (card.querySelector('.summary-extra-html') || {}).textContent || '';
            var dummy = /^\s*Job title\s*,\s*Employer\s*$/i.test(title) && /Add location and employment dates/i.test(meta) && /No achievements added yet/i.test(extra);
            var sig = [title, meta, extra].map(function (v) { return String(v).replace(/\s+/g, ' ').trim().toLowerCase(); }).join('|');

            if (dummy || seen.has(sig)) {
                card.remove();
                return;
            }
            seen.add(sig);
        });
    }

    function renumberCards() {
        Array.from(document.querySelectorAll('#summaryCardList .summary-job-card')).forEach(function (card, index) {
            card.dataset.index = String(index);
            var number = card.querySelector('.summary-number');
            if (number) number.textContent = String(index + 1);
            card.querySelectorAll('[data-index]').forEach(function (node) {
                node.dataset.index = String(index);
            });
        });
    }

    function removeAllOldUseRows(card) {
        Array.from(card.querySelectorAll('.summary-use-work-row, .summary-use-work-row-v8, .summary-use-work-row-v9, .summary-use-work-row-final')).forEach(function (row) {
            row.remove();
        });
        Array.from(card.querySelectorAll('input.summary-use-work-input[type="radio"]')).forEach(function (radio) {
            var parent = radio.closest('label') || radio.parentElement;
            if (parent) parent.remove();
            else radio.remove();
        });
    }

    function ensureOneCheckboxPerCard() {
        var wm = q('workMain');
        var list = q('summaryCardList');
        if (!wm || !wm.classList.contains('work-summary-mode') || !list) return;

        var works = getWorksFromStorage();
        if (works.length) saveDedupedWorks(works);

        removeDuplicateCardsFromDom();
        renumberCards();

        var checked = selectedIndexes();
        var cards = Array.from(list.querySelectorAll('.summary-job-card'));

        if (!works.length || !cards.length) {
            list.innerHTML = '';
            setEducationTransfer([]);
            return;
        }

        cards.forEach(function (card, index) {
            if (!works[index]) return;

            removeAllOldUseRows(card);

            var main = card.querySelector('.summary-job-main') || card;
            var row = main.querySelector('.summary-use-work-row-clean');
            if (!row) {
                row = document.createElement('label');
                row.className = 'summary-use-work-row-clean';
                row.innerHTML = '<input type="checkbox" class="summary-use-this-work-check-clean"><span>Use This Work</span>';
                main.appendChild(row);
            }

            var cb = row.querySelector('.summary-use-this-work-check-clean');
            if (cb) {
                cb.dataset.index = String(index);
                cb.checked = checked.includes(index);
            }
        });
    }

    function scheduleEnsure() {
        if (window.__ghostCleanUseWorkTimer) cancelAnimationFrame(window.__ghostCleanUseWorkTimer);
        window.__ghostCleanUseWorkTimer = requestAnimationFrame(ensureOneCheckboxPerCard);
    }

    /* Checkbox click should not trigger older document click handlers that recreate rows and blur Go Back. */
    document.addEventListener('click', function (e) {
        var cb = e.target && e.target.closest ? e.target.closest('.summary-use-this-work-check-clean') : null;
        if (!cb) return;
        saveCheckboxSelection();
        e.stopPropagation();
    }, true);

    document.addEventListener('change', function (e) {
        var cb = e.target && e.target.closest ? e.target.closest('.summary-use-this-work-check-clean') : null;
        if (!cb) return;
        saveCheckboxSelection();
        e.stopPropagation();
    }, true);

    /* Before going Education, save only checked cards. If nothing checked, clear transfer data. */
    document.addEventListener('click', function (e) {
        var next = e.target && e.target.closest ? e.target.closest('#btnSummaryNextEducation') : null;
        if (!next) return;
        ensureOneCheckboxPerCard();
        saveCheckboxSelection();
    }, true);

    function boot() {
        ensureOneCheckboxPerCard();
        var list = q('summaryCardList');
        if (list && list.dataset.ghostCleanUseWorkObserver !== '1') {
            list.dataset.ghostCleanUseWorkObserver = '1';
            new MutationObserver(scheduleEnsure).observe(list, { childList: true, subtree: true });
        }
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();
    window.addEventListener('load', boot);
    document.addEventListener('click', function (e) {
        if (e.target && e.target.closest && e.target.closest('#btnNextMoreInfo, #btnSummaryAddPosition, .summary-edit-btn, .summary-delete-btn, .summary-drag-handle, #btnSummaryNextEducation')) {
            setTimeout(scheduleEnsure, 80);
        }
    }, true);
})();
</script>

</body>
</html>
