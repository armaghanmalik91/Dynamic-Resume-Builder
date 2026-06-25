<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills - Resume Builder</title>

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

        /* EXACT WORK HISTORY LEFT BLUE SIDEBAR SIZE */
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

        /* current user position: Skills, so white progress line reaches Skills step only */
        .builder-sidebar .steps::after {
            content: "";
            position: absolute;
            left: 19px;
            top: 39px;
            width: 3px;
            height: 195px;
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
            position: relative;
            z-index: 3;
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
            width: 60%;
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

        /* SKILLS RIGHT AREA - WorkHistory sidebar sizes unchanged */
        .skills-main {
            margin-left: 360px;
            width: calc(133.3333333333vw - 360px);
            height: 133.3333333333vh;
            background: #ffffff;
            overflow: hidden;
            position: relative;
            display: flex;
        }

        .skills-left {
            width: 60%;
            height: 100%;
            padding: 92px 54px 180px 48px;
            overflow-y: auto;
            background: #ffffff;
        }

        .skills-left::-webkit-scrollbar { width: 8px; }
        .skills-left::-webkit-scrollbar-track { background: #ffffff; }
        .skills-left::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }

        .skills-left-inner { max-width: 920px; }

        .top-back {
            color: #2563eb;
            font-size: 18px;
            font-weight: 900;
            margin-bottom: 1px;
            letter-spacing: 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .top-back:hover { color: #ec4899; }

        .page-title {
            font-size: 42px;
            line-height: 1.12;
            font-weight: 950;
            letter-spacing: 0;
            margin: 0 0 14px;
            color: #071022;
        }

        .page-subtitle {
            font-size: 22px;
            line-height: 1.38;
            font-weight: 400;
            margin: 0 0 38px;
            color: #334155;
        }

        .skills-card {
            border: 1.8px solid #cbd5e1;
            border-radius: 18px;
            background: #ffffff;
            padding: 24px;
            box-shadow: 0 16px 38px rgba(15, 23, 42, .04);
        }

        .skill-input-row {
            display: grid;
            grid-template-columns: 1fr 200px 150px;
            gap: 16px;
            align-items: end;
        }

        .form-label {
            display: block;
            color: #071022;
            font-size: 19px;
            font-weight: 900;
            margin-bottom: 9px;
        }

        .form-input,
        .form-select {
            width: 100%;
            height: 62px;
            border: 1.8px solid #94a3b8;
            border-radius: 8px;
            padding: 0 18px;
            font-size: 20px;
            color: #071022;
            outline: none;
            background: #ffffff;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #0969da;
            box-shadow: 0 0 0 2px rgba(9,105,218,.14);
        }

        .add-btn {
            height: 62px;
            border: 0;
            border-radius: 999px;
            background: #db1b83;
            color: #ffffff;
            font-size: 18px;
            font-weight: 950;
            cursor: pointer;
            transition: all .18s ease;
        }

        .add-btn:hover { background: #c91675; transform: translateY(-1px); }

        .suggestion-box {
            margin-top: 22px;
            padding: 18px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .suggestion-title {
            font-size: 14px;
            font-weight: 950;
            color: #64748b;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: .11em;
        }

        .suggestion-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .suggestion-chip {
            border: 1.6px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            border-radius: 999px;
            padding: 9px 13px;
            font-size: 14px;
            line-height: 1;
            font-weight: 850;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            transition: all .18s ease;
        }

        .suggestion-chip span {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #dbeafe;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 950;
        }

        .suggestion-chip:hover {
            border-color: #2563eb;
            background: #eff6ff;
            color: #0f172a;
            transform: translateY(-1px);
        }

        .selected-skills-title {
            margin: 26px 0 12px;
            color: #071022;
            font-size: 21px;
            font-weight: 950;
        }

        .selected-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            min-height: 58px;
        }

        .skill-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 999px;
            background: #0f172a;
            color: #ffffff;
            font-size: 14px;
            font-weight: 850;
        }

        .skill-pill small {
            color: #cbd5e1;
            font-size: 11px;
            font-weight: 800;
        }

        .remove-skill {
            width: 22px;
            height: 22px;
            border-radius: 999px;
            border: 0;
            background: rgba(255,255,255,.18);
            color: #ffffff;
            cursor: pointer;
            font-size: 12px;
        }

        .empty-skills {
            color: #64748b;
            font-size: 15px;
            font-weight: 700;
            padding: 15px 0;
        }

        .skills-right {
            width: 40%;
            height: 100%;
            background: #ffffff;
            border-left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 126px 30px 100px 26px;
            overflow: hidden;
        }

        .preview-box {
            width: min(100%, 560px);
            height: 620px;
            min-height: 620px;
            max-height: 620px;
            background: #ffffff;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            overflow-y: auto;
            padding: 0;
        }

        .preview-box::-webkit-scrollbar { width: 8px; }
        .preview-box::-webkit-scrollbar-track { background: #ffffff; }
        .preview-box::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }

        .cv-paper {
            width: 430px;
            min-height: 602px;
            background: #ffffff;
            border-radius: 6px;
            padding: 34px 40px;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            border: 1px solid #f1f5f9;
        }

        .cv-name {
            text-align: center;
            font-size: 17px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .cv-contact {
            text-align: center;
            font-size: 7px;
            color: #4b5563;
            font-weight: 700;
            padding-bottom: 8px;
            margin-bottom: 10px;
            border-bottom: 1.4px solid #2563eb;
        }

        .cv-section { margin-top: 12px; }

        .cv-title {
            font-size: 8px;
            font-weight: 900;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 1.4px solid #2563eb;
            padding-bottom: 4px;
            margin-bottom: 7px;
        }

        .cv-text,
        .cv-list li {
            font-size: 7px;
            line-height: 1.45;
            color: #374151;
        }

        .cv-skills-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 4px 14px;
            margin: 0;
            padding-left: 12px;
        }

        .bottom-buttons {
            width: 100%;
            max-width: 390px;
            display: flex;
            justify-content: center;
            gap: 18px;
            margin-top: 44px;
        }

        .preview-btn,
        .next-btn {
            height: 54px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            font-size: 13px;
            font-weight: 950;
            letter-spacing: .08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .18s ease;
        }

        .preview-btn {
            min-width: 138px;
            border: 2px solid #0f172a;
            color: #0f172a;
            background: #ffffff;
        }

        .next-btn {
            min-width: 188px;
            border: 0;
            background: #ec4899;
            color: #ffffff;
        }

        .next-btn:hover,
        .preview-btn:hover { transform: translateY(-1px); }

        .skills-alert {
            position: fixed;
            top: 22px;
            left: calc(360px + 50%);
            transform: translateX(-50%) translateY(-120%);
            min-width: 420px;
            max-width: 680px;
            padding: 17px 22px;
            border-radius: 12px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            font-size: 16px;
            font-weight: 900;
            line-height: 1.35;
            box-shadow: 0 18px 45px rgba(15,23,42,.18);
            opacity: 0;
            pointer-events: none;
            z-index: 9998;
            transition: all .24s ease;
        }

        .skills-alert.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .skills-alert.success {
            background: #dcfce7;
            border-color: #bbf7d0;
            color: #166534;
        }



        /* GHOST SKILLS PAGE FINAL PATCH: preview/scroll only, blue sidebar untouched */
        .top-back:hover {
            color: #2563eb !important;
            text-decoration: none !important;
        }

        .selected-skills {
            max-height: 128px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            padding: 6px 8px 8px 0 !important;
            scrollbar-gutter: stable !important;
        }
        .selected-skills::-webkit-scrollbar { width: 8px !important; }
        .selected-skills::-webkit-scrollbar-track { background: #f8fafc !important; border-radius: 999px !important; }
        .selected-skills::-webkit-scrollbar-thumb { background: #cbd5e1 !important; border-radius: 999px !important; }

        .skills-left {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        .skills-left::-webkit-scrollbar { display: none !important; width: 0 !important; }

        .skills-right {
            background: #ffffff !important;
            padding-top: 110px !important;
        }
        .preview-box {
            width: min(100%, 560px) !important;
            height: 620px !important;
            min-height: 620px !important;
            max-height: 620px !important;
            background: #ffffff !important;
            border: 0 !important;
            box-shadow: none !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-gutter: stable !important;
            padding: 0 10px 0 0 !important;
        }
        .preview-box::-webkit-scrollbar { width: 8px !important; }
        .preview-box::-webkit-scrollbar-track { background: #ffffff !important; }
        .preview-box::-webkit-scrollbar-thumb { background: #cbd5e1 !important; border-radius: 999px !important; }

        .cv-paper {
            width: 430px !important;
            min-height: 602px !important;
            border-radius: 6px !important;
            box-shadow: none !important;
            border: 1px solid #f1f5f9 !important;
        }
        .cv-mini-row {
            display: grid;
            grid-template-columns: 1.1fr .8fr .8fr;
            gap: 8px;
            margin-bottom: 5px;
        }
        .cv-mini-title { font-weight: 900; color: #111827; }
        .cv-mini-meta { color: #4b5563; font-style: italic; }
        .cv-editor-html ul, .cv-editor-html ol { margin: 3px 0 0 10px; padding: 0; }
        .cv-editor-html p, .cv-editor-html div { margin: 0 0 3px; }

        .skills-preview-modal {
            position: fixed;
            inset: 0;
            z-index: 999999;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, .72);
            padding: 22px;
        }
        .skills-preview-modal.show { display: flex; }
        .skills-preview-card {
            position: relative;
            width: min(560px, 94vw);
            height: min(780px, 92vh);
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 30px 80px rgba(0,0,0,.35);
            overflow-y: auto;
            overflow-x: hidden;
            padding: 28px;
        }
        .skills-preview-card .cv-paper {
            width: 100% !important;
            min-height: 720px !important;
            border: 0 !important;
            margin: 0 auto;
        }
        .skills-preview-close {
            position: fixed;
            top: 26px;
            right: 28px;
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 999px;
            background: #ffffff;
            color: #0f172a;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 12px 32px rgba(0,0,0,.22);
            z-index: 1000000;
        }



        /* GHOST FINAL SKILLS LIVE PREVIEW MATCH EDUCATION PAGE - BLUE SIDEBAR UNTOUCHED */
        .top-back:hover {
            color: #2563eb !important;
            text-decoration: none !important;
        }

        .skills-right {
            width: 40% !important;
            max-width: 40% !important;
            flex: 0 0 40% !important;
            height: 133.3333333333vh !important;
            background: #ffffff !important;
            border-left: 0 !important;
            padding: 126px 30px 100px 26px !important;
            overflow: hidden !important;
            align-items: center !important;
            justify-content: flex-start !important;
            position: relative !important;
        }

        .preview-box {
            width: min(100%, 560px) !important;
            height: 620px !important;
            min-height: 620px !important;
            max-height: 620px !important;
            padding: 0 !important;
            margin-top: 34px !important;
            background: #ffffff !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            overflow: hidden !important;
            display: flex !important;
            align-items: flex-start !important;
            justify-content: center !important;
        }

        .core-cv-scrollbox {
            width: 100% !important;
            height: 100% !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            display: flex !important;
            align-items: flex-start !important;
            justify-content: center !important;
            padding: 0 10px 20px !important;
            scrollbar-gutter: stable !important;
        }
        .core-cv-scrollbox::-webkit-scrollbar { width: 8px !important; }
        .core-cv-scrollbox::-webkit-scrollbar-track { background: #ffffff !important; }
        .core-cv-scrollbox::-webkit-scrollbar-thumb { background: #cbd5e1 !important; border-radius: 999px !important; }

        .core-cv-live {
            --cv-accent: #2563eb;
            width: 430px !important;
            min-height: 602px !important;
            height: auto !important;
            background: #ffffff !important;
            border-radius: 6px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: none !important;
            padding: 34px 40px !important;
            color: #111827 !important;
            font-family: "Times New Roman", Georgia, serif !important;
            overflow: visible !important;
            flex: 0 0 auto !important;
        }
        .core-cv-live.modal-size {
            width: 520px !important;
            min-height: 735px !important;
            padding: 44px 54px !important;
            box-shadow: 0 20px 60px rgba(15,23,42,.22) !important;
        }
        .core-cv-top-line { font-size: 6.7px; line-height: 1.35; color: #4b5563; text-align: center; margin-bottom: 8px; }
        .core-cv-header-line { height: 1.6px; background: var(--cv-accent); margin: 0 auto 10px; width: 88%; }
        .core-cv-name { text-align: center; font-size: 17px; font-weight: 900; letter-spacing: .14em; text-transform: uppercase; color: #111827; line-height: 1.18; margin-bottom: 5px; font-family: Arial, Helvetica, sans-serif; }
        .core-cv-contact { text-align: center; font-size: 6.8px; color: #4b5563; font-weight: 700; line-height: 1.45; padding-bottom: 8px; margin-bottom: 10px; border-bottom: 1.4px solid var(--cv-accent); font-family: Arial, Helvetica, sans-serif; }
        .core-cv-section { margin-top: 9px; }
        .core-cv-title { font-size: 7.4px; font-weight: 900; color: #111827; text-transform: uppercase; letter-spacing: .045em; border-bottom: 1.35px solid var(--cv-accent); padding-bottom: 3px; margin-bottom: 5px; font-family: Arial, Helvetica, sans-serif; }
        .core-cv-text, .core-cv-li, .core-cv-list, .core-cv-editor-html { font-size: 6.65px; line-height: 1.43; color: #374151; }
        .core-cv-bold { font-weight: 900; color: #111827; }
        .core-cv-muted { color: #4b5563; font-style: italic; }
        .core-cv-list, .core-cv-editor-html ul, .core-cv-editor-html ol { margin: 0; padding-left: 11px; }
        .core-cv-list li, .core-cv-editor-html li { margin-bottom: 1.5px; }
        .core-cv-editor-html p, .core-cv-editor-html div { margin: 0 0 3px; }
        .core-cv-grid-3 { display:grid; grid-template-columns:repeat(3, 1fr); gap:2px 14px; margin-top:2px; }
        .core-cv-history-row, .core-cv-edu-row { display:grid; grid-template-columns:1.1fr .75fr .75fr; gap:10px; margin-bottom:4px; align-items:start; }
        .core-cv-live.modal-size .core-cv-top-line { font-size: 8.4px; }
        .core-cv-live.modal-size .core-cv-name { font-size: 22px; }
        .core-cv-live.modal-size .core-cv-contact { font-size: 8.5px; }
        .core-cv-live.modal-size .core-cv-title { font-size: 9.2px; }
        .core-cv-live.modal-size .core-cv-text, .core-cv-live.modal-size .core-cv-li, .core-cv-live.modal-size .core-cv-list, .core-cv-live.modal-size .core-cv-editor-html { font-size: 8.2px; }

        .bottom-buttons {
            position: relative !important;
            z-index: 4 !important;
            max-width: 390px !important;
            width: 100% !important;
            gap: 18px !important;
            padding: 0 !important;
            margin-top: 44px !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }
        .preview-btn, .next-btn {
            height: 54px !important;
            border-radius: 999px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            white-space: nowrap !important;
            font-size: 13px !important;
            font-weight: 950 !important;
            letter-spacing: .08em !important;
            padding: 0 26px !important;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease !important;
        }
        .preview-btn { min-width: 138px !important; border: 2px solid #0f172a !important; color: #0f172a !important; background: #ffffff !important; box-shadow: none !important; }
        .next-btn { min-width: 188px !important; background: #ec4899 !important; color: #ffffff !important; box-shadow: none !important; }

        .selected-skills {
            max-height: 138px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            padding: 6px 8px 8px 0 !important;
            scrollbar-gutter: stable !important;
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

            .skills-main {
                margin-left: 0;
                width: 100%;
                height: auto;
                min-height: calc(100vh - 82px);
                overflow: visible;
                display: block;
            }

            .skills-left {
                width: 100%;
                height: auto;
                padding: 34px 24px 100px;
                overflow: visible;
            }

            .skills-right { display: none; }
            .skill-input-row { grid-template-columns: 1fr; }
            .page-title { font-size: 32px; }
            .page-subtitle { font-size: 18px; }
        }
    </style>


<style id="ghost-skills-final-template-cleanup-no-blue-change">
    /* GHOST FINAL: remove top preview line, hide right scrollbar, move buttons up. Blue sidebar untouched. */
    .core-cv-top-line {
        display: none !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    .skills-right {
        padding-top: 118px !important;
        padding-bottom: 56px !important;
    }

    .preview-box {
        height: 560px !important;
        min-height: 560px !important;
        max-height: 560px !important;
        margin-top: 24px !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    .preview-box::-webkit-scrollbar,
    .preview-box::-webkit-scrollbar-track,
    .preview-box::-webkit-scrollbar-thumb {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        background: transparent !important;
    }

    .core-cv-scrollbox {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
        scrollbar-gutter: auto !important;
        padding-right: 0 !important;
    }

    .core-cv-scrollbox::-webkit-scrollbar,
    .core-cv-scrollbox::-webkit-scrollbar-track,
    .core-cv-scrollbox::-webkit-scrollbar-thumb {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        background: transparent !important;
    }

    .core-cv-live {
        min-height: 548px !important;
        padding-top: 28px !important;
    }

    .core-cv-header-line {
        margin-top: 0 !important;
    }

    .bottom-buttons {
        margin-top: 18px !important;
        transform: translateY(-4px) !important;
    }
</style>



<style id="ghost-skills-user-final-adjustments">
    /* GHOST USER FINAL: Blue sidebar untouched. */
    .core-cv-header-line {
        display: none !important;
        height: 0 !important;
        min-height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
        background: transparent !important;
        overflow: hidden !important;
    }

    .core-cv-live {
        padding-top: 30px !important;
    }

    .core-cv-grid-3:empty {
        min-height: 0 !important;
        display: block !important;
    }

    .skill-name-field-wrap {
        min-width: 0 !important;
    }

    .selected-skills-title {
        margin: 14px 0 9px !important;
        font-size: 17px !important;
        line-height: 1.15 !important;
    }

    .selected-skills {
        min-height: 0 !important;
        max-height: none !important;
        overflow: visible !important;
        padding-bottom: 2px !important;
    }

    .skill-pill {
        white-space: nowrap !important;
    }

    .skills-card {
        overflow: visible !important;
    }

    .skill-input-row {
        align-items: start !important;
    }

    .skills-right {
        padding-top: 112px !important;
        padding-bottom: 42px !important;
    }

    .preview-box {
        height: 540px !important;
        min-height: 540px !important;
        max-height: 540px !important;
        overflow: hidden !important;
    }

    .core-cv-scrollbox {
        overflow: hidden !important;
        padding: 0 !important;
    }

    .bottom-buttons {
        margin-top: 14px !important;
        transform: translateY(-8px) !important;
    }

    .top-back:hover {
        color: #2563eb !important;
    }
</style>



<style id="ghost-skills-intro-user-size-button-scroll-final">
    /* GHOST FINAL: Intro page polish only. Blue sidebar and old data logic untouched. */
    body.skills-intro-active .skills-left {
        padding-top: 92px !important;
        padding-left: 48px !important;
        padding-right: 54px !important;
        overflow: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    body.skills-intro-active .skills-left::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    body.skills-intro-active .skills-left-inner {
        max-width: 980px !important;
    }

    body.skills-intro-active .skills-intro-view {
        display: block !important;
        margin-top: 20px !important;
        padding-top: 0 !important;
    }

    body.skills-intro-active .skills-intro-title {
        color: #071022 !important;
        font-size: 38px !important;
        line-height: 1.26 !important;
        font-weight: 950 !important;
        letter-spacing: .010em !important;
        margin: 0 0 20px !important;
        max-width: 880px !important;
    }

    body.skills-intro-active .skills-intro-subtitle {
        color: #071022 !important;
        font-size: 20px !important;
        line-height: 1.38 !important;
        font-weight: 400 !important;
        margin: 0 0 28px !important;
        max-width: 850px !important;
        letter-spacing: .01em !important;
    }

    body.skills-intro-active .skills-ai-row {
        display: flex !important;
        align-items: flex-start !important;
        gap: 18px !important;
        margin-top: 0 !important;
        max-width: 760px !important;
    }

    body.skills-intro-active .skills-ai-icon {
        width: 40px !important;
        height: 40px !important;
        border-radius: 999px !important;
        flex: 0 0 40px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: linear-gradient(135deg, #60a5fa, #2563eb) !important;
        color: #ffffff !important;
        box-shadow: 0 10px 24px rgba(37,99,235,.22) !important;
    }

    body.skills-intro-active .skills-ai-copy h2 {
        margin: 0 0 12px !important;
        color: #071022 !important;
        font-size: 26px !important;
        line-height: 1.15 !important;
        font-weight: 950 !important;
        letter-spacing: .02em !important;
    }

    body.skills-intro-active .skills-ai-copy p {
        margin: 0 !important;
        color: #071022 !important;
        font-size: 22px !important;
        line-height: 1.42 !important;
        font-weight: 400 !important;
        max-width: 660px !important;
    }

    body.skills-intro-active .skills-right {
        padding-top: 88px !important;
        padding-bottom: 54px !important;
        overflow: hidden !important;
    }

    body.skills-intro-active .preview-box {
        width: min(100%, 610px) !important;
        height: 642px !important;
        min-height: 642px !important;
        max-height: 642px !important;
        margin-top: 22px !important;
        overflow: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    body.skills-intro-active .preview-box::-webkit-scrollbar,
    body.skills-intro-active .core-cv-scrollbox::-webkit-scrollbar,
    body.skills-intro-active .skills-preview-card::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    body.skills-intro-active .core-cv-scrollbox {
        overflow: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
        padding: 0 !important;
    }

    body.skills-intro-active .core-cv-live {
        width: 440px !important;
        min-height: 620px !important;
        padding: 34px 40px !important;
        transform: none !important;
    }

    body.skills-intro-active .bottom-buttons {
        max-width: 520px !important;
        gap: 24px !important;
        margin-top: 26px !important;
        transform: translateY(-2px) !important;
    }

    body.skills-intro-active .preview-btn,
    body.skills-intro-active .next-btn {
        height: 72px !important;
        border-radius: 999px !important;
        font-size: 24px !important;
        font-weight: 950 !important;
        letter-spacing: 0 !important;
        text-transform: none !important;
        padding: 0 34px !important;
    }

    body.skills-intro-active .preview-btn {
        min-width: 230px !important;
        border: 3px solid #15168f !important;
        color: #15168f !important;
        background: #ffffff !important;
    }

    body.skills-intro-active .next-btn {
        min-width: 260px !important;
        background: #db1b83 !important;
        color: #ffffff !important;
    }

    .skills-preview-card {
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
</style>



<!-- GHOST FINAL FIX: move intro Preview/Next buttons upward only; blue sidebar and logic unchanged -->
<style id="ghost-skills-intro-buttons-up-final">
    body.skills-intro-active .skills-right {
        padding-top: 74px !important;
        padding-bottom: 26px !important;
    }

    body.skills-intro-active .preview-box {
        height: 560px !important;
        min-height: 560px !important;
        max-height: 560px !important;
        margin-top: 10px !important;
        overflow: hidden !important;
    }

    body.skills-intro-active .core-cv-live,
    body.skills-intro-active .cv-paper {
        max-height: 548px !important;
        min-height: 548px !important;
    }

    body.skills-intro-active .bottom-buttons {
        margin-top: 12px !important;
        transform: translateY(-18px) !important;
        position: relative !important;
        z-index: 5 !important;
    }

    body.skills-intro-active .preview-btn,
    body.skills-intro-active .next-btn {
        height: 66px !important;
    }

    /* Form screen buttons also stay visible, without touching old logic */
    body:not(.skills-intro-active) .skills-right {
        padding-top: 112px !important;
        padding-bottom: 34px !important;
    }

    body:not(.skills-intro-active) .preview-box {
        height: 540px !important;
        min-height: 540px !important;
        max-height: 540px !important;
    }

    body:not(.skills-intro-active) .bottom-buttons {
        margin-top: 10px !important;
        transform: translateY(-12px) !important;
    }
</style>



<style id="ghost-final-selected-skills-row-fix-only">
    /* Only fixes selected skills row layout + Add button vertical alignment. Blue/sidebar/data logic untouched. */
    .skill-input-row {
        align-items: end !important;
    }

    #addSkillBtn.add-btn,
    .add-btn {
        align-self: end !important;
        margin-top: 0 !important;
        transform: translateY(-2px) !important;
    }

    .selected-skills-title {
        width: 100% !important;
        margin: 22px 0 10px !important;
        font-size: 18px !important;
        line-height: 1.15 !important;
        font-weight: 950 !important;
        color: #071022 !important;
        display: block !important;
    }

    #selectedSkills.selected-skills {
        width: 100% !important;
        max-width: 100% !important;
        min-height: 0 !important;
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        align-content: flex-start !important;
        justify-content: flex-start !important;
        gap: 10px 10px !important;
        overflow: visible !important;
        max-height: none !important;
        padding: 0 !important;
        margin: 0 0 20px 0 !important;
        scrollbar-width: none !important;
    }

    #selectedSkills.selected-skills::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    #selectedSkills .skill-pill {
        flex: 0 0 auto !important;
        width: auto !important;
        max-width: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        white-space: nowrap !important;
        padding: 9px 12px !important;
        border-radius: 999px !important;
        font-size: 13px !important;
        line-height: 1 !important;
        margin: 0 !important;
    }

    #selectedSkills .skill-pill small {
        font-size: 10px !important;
        line-height: 1 !important;
    }

    #selectedSkills .remove-skill {
        width: 20px !important;
        height: 20px !important;
        flex: 0 0 20px !important;
    }

    #selectedSkills .empty-skills {
        width: 100% !important;
        padding: 4px 0 !important;
        font-size: 14px !important;
    }


/* GHOST FINAL ONLY: fake education-style template on Skills intro; live/editing preview untouched */
.skills-fake-template {
    --fake-accent: #7ca342;
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
.skills-fake-template .fake-current-title {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10.5px;
    font-weight: 900;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #111827;
    margin-bottom: 6px;
}
.skills-fake-template .fake-name {
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
.skills-fake-template .fake-contact {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 6.8px;
    color: #4b5563;
    font-weight: 700;
    line-height: 1.45;
    padding-bottom: 8px;
    margin-bottom: 9px;
    border-bottom: 1.35px solid var(--fake-accent);
}
.skills-fake-template .fake-section { margin-top: 8px; }
.skills-fake-template .fake-title {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 7.4px;
    font-weight: 900;
    color: #111827;
    text-transform: uppercase;
    letter-spacing: .045em;
    border-bottom: 1.35px solid var(--fake-accent);
    padding-bottom: 3px;
    margin-bottom: 5px;
}
.skills-fake-template .fake-text,
.skills-fake-template li {
    font-size: 6.65px;
    line-height: 1.43;
    color: #374151;
}
.skills-fake-template .fake-green-highlight {
    border: 2px solid #34d399;
    background: rgba(52, 211, 153, 0.08);
    padding: 5px 7px 6px;
    margin-left: -7px;
    margin-right: -7px;
    border-radius: 2px;
}
.skills-fake-template .fake-green-highlight .fake-title { border-bottom-color: #34d399; }
.skills-fake-template .fake-grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:2px 14px; margin-top:2px; }
.skills-fake-template ul { margin:0; padding-left:11px; }
.skills-fake-template .fake-row { display:grid; grid-template-columns:1.1fr .75fr .75fr; gap:10px; margin-bottom:4px; align-items:start; }
.skills-fake-template .fake-bold { font-weight:900; color:#111827; }
.skills-fake-template .fake-muted { color:#4b5563; font-style:italic; }
body.skills-intro-active .preview-box { overflow: hidden !important; }
body.skills-intro-active .core-cv-scrollbox { overflow: hidden !important; padding: 0 !important; }

</style>


<!-- GHOST FINAL PATCH: Skills intro template/buttons use exact Education intro sizes only. Blue sidebar and logic untouched. -->
<style id="ghost-skills-intro-education-exact-size-final">
    /* Education page right preview box exact sizing */
    body.skills-intro-active .skills-right {
        padding-top: 126px !important;
        padding-bottom: 100px !important;
        overflow: hidden !important;
    }

    body.skills-intro-active .preview-box {
        width: min(100%, 560px) !important;
        height: 620px !important;
        min-height: 620px !important;
        max-height: 620px !important;
        margin-top: 34px !important;
        padding: 0 !important;
        background: #ffffff !important;
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
    }

    body.skills-intro-active .core-cv-scrollbox {
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    body.skills-intro-active .core-cv-scrollbox::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    /* Exact Education intro template size */
    body.skills-intro-active .skills-fake-template {
        --fake-accent: #7ca342;
        width: 430px !important;
        height: 610px !important;
        min-height: 610px !important;
        max-height: 610px !important;
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        padding: 30px 40px 34px !important;
        color: #111827 !important;
        font-family: "Times New Roman", Georgia, serif !important;
        flex: 0 0 430px !important;
        box-shadow: none !important;
        overflow: hidden !important;
        transform: none !important;
        transform-origin: top center !important;
    }

    /* Education intro buttons exact sizing */
    body.skills-intro-active .bottom-buttons {
        margin-top: 72px !important;
        transform: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 28px !important;
        width: 100% !important;
        max-width: none !important;
        padding: 0 !important;
        position: relative !important;
        z-index: 5 !important;
    }

    body.skills-intro-active .preview-btn,
    body.skills-intro-active .next-btn {
        height: 74px !important;
        width: 258px !important;
        min-width: 258px !important;
        max-width: 258px !important;
        border-radius: 999px !important;
        font-size: 27px !important;
        font-weight: 950 !important;
        letter-spacing: 0 !important;
        text-transform: none !important;
        padding: 0 !important;
        cursor: pointer !important;
        transition: all .18s ease !important;
    }

    body.skills-intro-active .preview-btn {
        border: 3px solid #15168f !important;
        background: #ffffff !important;
        color: #15168f !important;
    }

    body.skills-intro-active .next-btn {
        border: 0 !important;
        background: #c4007a !important;
        color: #ffffff !important;
    }

    body.skills-intro-active .preview-btn:hover,
    body.skills-intro-active .next-btn:hover {
        transform: translateY(-1px) !important;
    }
</style>



<!-- GHOST FINAL FIX: Skills intro size/position only - blue sidebar and logic untouched -->
<style id="ghost-skills-intro-size-position-final-fix">
    /* Move Go Back and intro text slightly upward; keep same text/content */
    body.skills-intro-active .skills-left {
        padding-top: 78px !important;
        padding-left: 48px !important;
        padding-right: 54px !important;
        overflow: hidden !important;
    }

    body.skills-intro-active .top-back {
        color: #2563eb !important;
        text-decoration: underline !important;
        text-underline-offset: 2px !important;
        font-size: 18px !important;
        font-weight: 900 !important;
        margin-bottom: 18px !important;
        transform: translateY(-2px) !important;
    }

    body.skills-intro-active .skills-intro-view {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    body.skills-intro-active .skills-intro-title {
        margin-top: 0 !important;
        margin-bottom: 22px !important;
    }

    /* Right side template: reduce width/height like requested */
    body.skills-intro-active .skills-right {
        padding-top: 94px !important;
        padding-bottom: 58px !important;
        overflow: hidden !important;
    }

    body.skills-intro-active .preview-box {
        width: min(100%, 500px) !important;
        height: 560px !important;
        min-height: 560px !important;
        max-height: 560px !important;
        margin-top: 0 !important;
        padding: 0 !important;
        background: #ffffff !important;
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
    }

    body.skills-intro-active .core-cv-scrollbox {
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    body.skills-intro-active .core-cv-scrollbox::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    body.skills-intro-active .skills-fake-template {
        width: 390px !important;
        height: 540px !important;
        min-height: 540px !important;
        max-height: 540px !important;
        flex: 0 0 390px !important;
        padding: 26px 36px 30px !important;
        border: 1px solid #cbd5e1 !important;
        background: #ffffff !important;
        box-shadow: none !important;
        overflow: hidden !important;
        transform: none !important;
    }

    /* Slightly reduce fake-template internal text so the same template fits cleanly */
    body.skills-intro-active .skills-fake-template .fake-current-title { font-size: 9.2px !important; margin-bottom: 5px !important; }
    body.skills-intro-active .skills-fake-template .fake-name { font-size: 15.5px !important; margin-bottom: 3px !important; }
    body.skills-intro-active .skills-fake-template .fake-contact { font-size: 6px !important; padding-bottom: 7px !important; margin-bottom: 8px !important; }
    body.skills-intro-active .skills-fake-template .fake-section { margin-top: 7px !important; }
    body.skills-intro-active .skills-fake-template .fake-title { font-size: 6.7px !important; padding-bottom: 2px !important; margin-bottom: 4px !important; }
    body.skills-intro-active .skills-fake-template .fake-text,
    body.skills-intro-active .skills-fake-template li { font-size: 5.95px !important; line-height: 1.35 !important; }
    body.skills-intro-active .skills-fake-template .fake-grid-3 { gap: 1px 12px !important; }
    body.skills-intro-active .skills-fake-template .fake-row { gap: 8px !important; margin-bottom: 3px !important; }
    body.skills-intro-active .skills-fake-template .fake-green-highlight {
        border: 2px solid #34d399 !important;
        padding: 4px 6px 5px !important;
        margin-left: -6px !important;
        margin-right: -6px !important;
    }

    /* Buttons: reduce size slightly and keep them under template */
    body.skills-intro-active .bottom-buttons {
        margin-top: 16px !important;
        transform: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 24px !important;
        width: 100% !important;
        max-width: 460px !important;
        padding: 0 !important;
        position: relative !important;
        z-index: 5 !important;
    }

    body.skills-intro-active .preview-btn,
    body.skills-intro-active .next-btn {
        height: 60px !important;
        width: 220px !important;
        min-width: 220px !important;
        max-width: 220px !important;
        border-radius: 999px !important;
        font-size: 24px !important;
        font-weight: 950 !important;
        letter-spacing: 0 !important;
        text-transform: none !important;
        padding: 0 !important;
    }

    body.skills-intro-active .preview-btn {
        border: 3px solid #15168f !important;
        background: #ffffff !important;
        color: #15168f !important;
    }

    body.skills-intro-active .next-btn {
        border: 0 !important;
        background: #db1b83 !important;
        color: #ffffff !important;
    }
</style>



<!-- GHOST FINAL PATCH: make only Skills intro template one more step smaller; buttons/sidebar/logic untouched -->
<style id="ghost-skills-intro-template-only-more-small-final">
    body.skills-intro-active .preview-box {
        width: min(100%, 460px) !important;
        height: 500px !important;
        min-height: 500px !important;
        max-height: 500px !important;
        margin-top: 0 !important;
        overflow: hidden !important;
    }

    body.skills-intro-active .skills-fake-template {
        width: 350px !important;
        height: 470px !important;
        min-height: 470px !important;
        max-height: 470px !important;
        flex: 0 0 350px !important;
        padding: 22px 30px 26px !important;
        overflow: hidden !important;
        transform: none !important;
    }

    body.skills-intro-active .skills-fake-template .fake-current-title { font-size: 8.2px !important; margin-bottom: 4px !important; }
    body.skills-intro-active .skills-fake-template .fake-name { font-size: 13.8px !important; margin-bottom: 2px !important; }
    body.skills-intro-active .skills-fake-template .fake-contact { font-size: 5.2px !important; padding-bottom: 6px !important; margin-bottom: 6px !important; }
    body.skills-intro-active .skills-fake-template .fake-section { margin-top: 5.5px !important; }
    body.skills-intro-active .skills-fake-template .fake-title { font-size: 5.9px !important; padding-bottom: 2px !important; margin-bottom: 3px !important; }
    body.skills-intro-active .skills-fake-template .fake-text,
    body.skills-intro-active .skills-fake-template li { font-size: 5.2px !important; line-height: 1.28 !important; }
    body.skills-intro-active .skills-fake-template .fake-grid-3 { gap: 1px 10px !important; }
    body.skills-intro-active .skills-fake-template .fake-row { gap: 7px !important; margin-bottom: 2px !important; }
    body.skills-intro-active .skills-fake-template .fake-green-highlight {
        border: 2px solid #34d399 !important;
        padding: 3px 5px 4px !important;
        margin-left: -5px !important;
        margin-right: -5px !important;
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
            <div id="headingStep" class="step done"><span class="step-circle">1</span><span>Heading</span></div>
            <div id="workHistoryStep" class="step"><span class="step-circle">2</span><span>Work history</span><span class="step-missing">Add missing information</span></div>
            <div id="educationStep" class="step"><span class="step-circle">3</span><span>Education</span><span class="step-missing">Add missing information</span></div>
            <div id="skillsStep" class="step active"><span class="step-circle">4</span><span>Skills</span></div>
            <div class="step"><span class="step-circle">5</span><span>Summary</span></div>
            <div class="step"><span class="step-circle">6</span><span>Finalize</span></div>
        </div>

        <div class="sidebar-progress">
            <div class="sidebar-progress-title">Resume Completeness:</div>
            <div class="progress-row">
                <div class="progress-track"><div class="progress-fill" id="progressFill"></div></div>
                <div class="progress-number" id="progressNumber">60%</div>
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

    <div id="skillsAlert" class="skills-alert"></div>

    <main class="skills-main">
        <section class="skills-left">
            <div class="skills-left-inner">
                <a href="/builder/education" class="top-back">
                    <i class="fa-solid fa-arrow-left"></i> Go Back
                </a>

                <section id="skillsIntroView" class="skills-intro-view">
                    <h1 class="skills-intro-title">Next, let's take care of your Skills</h1>
                    <p class="skills-intro-subtitle">Employers scan skills for relevant keywords.<br>We'll help you choose the best ones.</p>

                    <div class="skills-ai-row">
                        <div class="skills-ai-icon"><i class="fa-solid fa-list-check"></i></div>
                        <div class="skills-ai-copy">
                            <h2>Choose skills that match your target job</h2>
                            <p>Add clear, relevant skills so employers can quickly understand your strengths.</p>
                        </div>
                    </div>
                </section>

                <section id="skillsAddView" class="skills-add-view hidden">
                    <h1 class="page-title">What skills do you want to highlight?</h1>
                    <p class="page-subtitle">Add your strongest skills. These will update your resume preview live.</p>

                    <div class="skills-card">
                        <div class="skill-input-row">
                            <div class="skill-name-field-wrap">
                                <label class="form-label">Skill Name</label>
                                <input id="skillNameInput" class="form-input" type="text" placeholder="e.g. JavaScript">
                            </div>

                            <div>
                                <label class="form-label">Skill Level</label>
                                <select id="skillLevelInput" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert">Expert</option>
                                </select>
                            </div>

                            <button id="addSkillBtn" type="button" class="add-btn">Add</button>
                        </div>

                        <div class="selected-skills-title">Selected skills</div>
                        <div id="selectedSkills" class="selected-skills"></div>

                        <div class="suggestion-box">
                            <div class="suggestion-title">Suggested skills</div>
                            <div class="suggestion-list">
                                <button type="button" class="suggestion-chip"><span>+</span>Communication</button>
                                <button type="button" class="suggestion-chip"><span>+</span>Teamwork</button>
                                <button type="button" class="suggestion-chip"><span>+</span>Problem Solving</button>
                                <button type="button" class="suggestion-chip"><span>+</span>Leadership</button>
                                <button type="button" class="suggestion-chip"><span>+</span>Microsoft Office</button>
                                <button type="button" class="suggestion-chip"><span>+</span>HTML</button>
                                <button type="button" class="suggestion-chip"><span>+</span>CSS</button>
                                <button type="button" class="suggestion-chip"><span>+</span>JavaScript</button>
                                <button type="button" class="suggestion-chip"><span>+</span>React</button>
                                <button type="button" class="suggestion-chip"><span>+</span>Laravel</button>
                                <button type="button" class="suggestion-chip"><span>+</span>Node.js</button>
                                <button type="button" class="suggestion-chip"><span>+</span>MySQL</button>
                                <button type="button" class="suggestion-chip"><span>+</span>REST APIs</button>
                                <button type="button" class="suggestion-chip"><span>+</span>GitHub</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>

        <section class="skills-right">
            <div class="preview-box">
                <div class="cv-paper">
                    <div id="cvName" class="cv-name">YOUR NAME</div>
                    <div id="cvContact" class="cv-contact">City, Country | Phone | Email</div>

                    <section class="cv-section">
                        <div class="cv-title">Professional Competencies</div>
                        <div class="cv-text">Use bullet points to define and explain your strongest abilities.</div>
                    </section>

                    <section class="cv-section">
                        <div class="cv-title">Areas of Expertise</div>
                        <ul id="cvSkillsList" class="cv-skills-grid"></ul>
                    </section>

                    <section class="cv-section">
                        <div class="cv-title">Academic Qualifications</div>
                        <div id="cvEducation" class="cv-text">School / College Name — Degree, Field of Study</div>
                    </section>

                    <section class="cv-section">
                        <div class="cv-title">Career History</div>
                        <div id="cvCareerHistory" class="cv-text">Your work history will appear here after you add it.</div>
                    </section>
                </div>
            </div>

            <div class="bottom-buttons">
                <button id="btnPreview" type="button" class="preview-btn">Preview</button>
                <button id="btnNextSkills" type="button" class="next-btn">Next: Summary</button>
            </div>
        </section>
    </main>



    <div id="skillsPreviewModal" class="skills-preview-modal" aria-hidden="true">
        <button type="button" id="closeSkillsPreview" class="skills-preview-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="skills-preview-card">
            <div id="skillsPreviewModalContent"></div>
        </div>
    </div>

    <script>
        const API_BASE = "https://resume-backend-54se.onrender.com";
        const token = localStorage.getItem("resume_token");
        const resumeId = localStorage.getItem("current_resume_id");

        if (!token || !resumeId) {
            window.location.href = "/login";
        }

        const skillNameInput = document.getElementById("skillNameInput");
        const skillLevelInput = document.getElementById("skillLevelInput");
        const selectedSkillsBox = document.getElementById("selectedSkills");
        let cvSkillsList = document.getElementById("cvSkillsList");

        let skills = [];
        let previewContact = null;
        let previewEducation = null;
        let previewWorkItems = [];

        function scoped(base) {
            return base + "_" + (resumeId || "no_resume");
        }

        function cleanText(value) {
            return String(value || "").trim();
        }

        function showAlert(message, type = "error") {
            const alertBox = document.getElementById("skillsAlert");
            alertBox.textContent = message;
            alertBox.classList.toggle("success", type === "success");
            alertBox.classList.add("show");
            setTimeout(() => alertBox.classList.remove("show"), 2300);
        }

        function safeJson(key, fallback) {
            try {
                return JSON.parse(localStorage.getItem(key) || JSON.stringify(fallback));
            } catch {
                return fallback;
            }
        }

        function shouldShowSkillsIntro() {
            /* Always show the Skills intro first when user comes from Education page. */
            return true;
        }

        function showSkillsIntroMode() {
            isSkillsIntroMode = true;
            document.body.classList.add("skills-intro-active");
            skillsIntroView.classList.remove("hidden");
            skillsAddView.classList.add("hidden");
            btnNextSkills.textContent = "Next";
            renderCoreSkillsPreview();
        }

        function showSkillsAddMode() {
            isSkillsIntroMode = false;
            document.body.classList.remove("skills-intro-active");
            skillsIntroView.classList.add("hidden");
            skillsAddView.classList.remove("hidden");
            btnNextSkills.textContent = "Next: Summary";
            renderCoreSkillsPreview();
        }

        function setupSkillsMode() {
            if (shouldShowSkillsIntro()) showSkillsIntroMode();
            else showSkillsAddMode();
        }

        function isMeaningfulWork(work) {
            return !!(work && (work.job_title || work.employer || work.city || work.start_year || work.extra_info));
        }

        function normalizeArray(value) {
            if (Array.isArray(value)) return value;
            if (value && typeof value === "object") return [value];
            return [];
        }

        function getWorkEntries() {
            const scopedEntries = safeJson(scoped("resume_work_history_entries"), []);
            const globalEntries = safeJson("resume_work_history_entries", []);
            const selectedList = safeJson(scoped("resume_work_history_selected_for_education"), null) ||
                safeJson("resume_work_history_selected_for_education_" + resumeId, null) ||
                safeJson("resume_work_history_selected_for_education", null);

            if (Array.isArray(selectedList) && selectedList.some(isMeaningfulWork)) {
                return selectedList.filter(isMeaningfulWork);
            }

            if (Array.isArray(scopedEntries) && scopedEntries.length) return scopedEntries.filter(isMeaningfulWork);
            if (Array.isArray(globalEntries) && globalEntries.length) return globalEntries.filter(isMeaningfulWork);

            const draft = safeJson(scoped("resume_work_history_data"), null) || safeJson("resume_work_history_data", null);
            return isMeaningfulWork(draft) ? [draft] : [];
        }

        function getSelectedWorkIndexes() {
            const scopedIndexes = safeJson(scoped("resume_work_history_use_this_indexes"), null);
            const globalIndexes = safeJson("resume_work_history_use_this_indexes", null);
            if (Array.isArray(scopedIndexes)) return scopedIndexes.map(Number).filter(n => !Number.isNaN(n));
            if (Array.isArray(globalIndexes)) return globalIndexes.map(Number).filter(n => !Number.isNaN(n));
            return [];
        }

        function getSelectedWorkHistory() {
            const selectedList = safeJson(scoped("resume_work_history_selected_for_education"), null) ||
                safeJson("resume_work_history_selected_for_education_" + resumeId, null) ||
                safeJson("resume_work_history_selected_for_education", null);
            if (Array.isArray(selectedList) && selectedList.some(isMeaningfulWork)) {
                return selectedList.filter(isMeaningfulWork);
            }

            const allEntries = getWorkEntries();
            const indexes = getSelectedWorkIndexes();
            if (!indexes.length) return [];
            return indexes.map(i => allEntries[i]).filter(isMeaningfulWork);
        }

        function hasMeaningfulWorkHistory() {
            return getSelectedWorkHistory().length > 0;
        }

        function getSelectedEducationId() {
            return (
                localStorage.getItem(scoped("resume_education_selected_id")) ||
                localStorage.getItem("resume_education_selected_id_" + resumeId) ||
                localStorage.getItem(scoped("resume_selected_education_id")) ||
                localStorage.getItem("resume_selected_education_id_" + resumeId) ||
                localStorage.getItem("resume_selected_education_id") ||
                localStorage.getItem("selected_education_id") ||
                ""
            );
        }

        function getEducationList() {
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

        function isMeaningfulEducation(edu) {
            return !!(edu && (edu.school_name || edu.school || edu.schoolName || edu.degree || edu.field_of_study || edu.field || edu.graduation_year || edu.year));
        }

        function getSelectedEducationSnapshot() {
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
                if (isMeaningfulEducation(snap) && (selectedId || localStorage.getItem(key + "_checked") === "true")) return snap;
            }
            return null;
        }

        function hasSelectedEducation() {
            return !!(getSelectedEducationId() && isMeaningfulEducation(getSelectedEducationSnapshot()));
        }

        function setupSidebarFlow() {
            const workStep = document.getElementById("workHistoryStep");
            const educationStep = document.getElementById("educationStep");

            if (hasMeaningfulWorkHistory()) {
                workStep.classList.add("done");
                workStep.classList.remove("missing");
            } else {
                workStep.classList.remove("done");
                workStep.classList.add("missing");
            }

            if (hasSelectedEducation()) {
                educationStep.classList.add("done");
                educationStep.classList.remove("missing");
            } else {
                educationStep.classList.remove("done");
                educationStep.classList.add("missing");
            }

            let percent = 40;
            if (hasMeaningfulWorkHistory()) percent += 10;
            if (hasSelectedEducation()) percent += 10;
            if (skills.length > 0) percent += 10;
            percent = Math.min(percent, 70);

            document.getElementById("progressFill").style.width = percent + "%";
            document.getElementById("progressNumber").textContent = percent + "%";
        }

        function loadSkillsFromLocal() {
            const localSkills = safeJson(scoped("resume_skills_backup"), null) || safeJson("resume_skills_backup", []);
            skills = Array.isArray(localSkills) ? localSkills : [];
        }

        function saveSkillsToLocal() {
            localStorage.setItem(scoped("resume_skills_backup"), JSON.stringify(skills));
            localStorage.setItem("resume_skills_backup", JSON.stringify(skills));
        }

        function renderSkills() {
            cvSkillsList = document.getElementById("cvSkillsList");
            selectedSkillsBox.innerHTML = "";

            if (skills.length === 0) {
                selectedSkillsBox.innerHTML = `<div class="empty-skills">No skills added yet.</div>`;
                if (cvSkillsList) cvSkillsList.innerHTML = "";
                setupSidebarFlow();
                renderCoreSkillsPreview();
                return;
            }

            if (cvSkillsList) cvSkillsList.innerHTML = "";

            skills.forEach((skill, index) => {
                const pill = document.createElement("div");
                pill.className = "skill-pill";
                pill.innerHTML = `
                    <span>${skill.skill_name}</span>
                    ${skill.skill_level ? `<small>${skill.skill_level}</small>` : ""}
                    <button type="button" class="remove-skill" data-index="${index}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;
                selectedSkillsBox.appendChild(pill);

                const li = document.createElement("li");
                li.textContent = skill.skill_level
                    ? `${skill.skill_name} (${skill.skill_level})`
                    : skill.skill_name;
                if (cvSkillsList) cvSkillsList.appendChild(li);
            });

            document.querySelectorAll(".remove-skill").forEach(btn => {
                btn.addEventListener("click", () => {
                    const index = Number(btn.dataset.index);
                    skills.splice(index, 1);
                    saveSkillsToLocal();
                    renderSkills();
                });
            });

            setupSidebarFlow();
            renderCoreSkillsPreview();
        }

        function addSkill(name, level = "") {
            const finalName = cleanText(name);
            const finalLevel = cleanText(level);

            if (!finalName) {
                showAlert("Please enter a skill name.");
                return;
            }

            const exists = skills.some(skill =>
                String(skill.skill_name || "").toLowerCase() === finalName.toLowerCase()
            );

            if (exists) {
                showAlert("This skill is already added.");
                return;
            }

            skills.push({
                skill_name: finalName,
                skill_level: finalLevel
            });

            skillNameInput.value = "";
            skillLevelInput.value = "";
            saveSkillsToLocal();
            renderSkills();
        }

        async function loadSkillsFromDatabase() {
            try {
                const res = await fetch(`${API_BASE}/api/resumes/skills/${resumeId}`, {
                    headers: { "Authorization": "Bearer " + token }
                });

                const data = await res.json();

                if (data.success && Array.isArray(data.skills) && data.skills.length > 0) {
                    skills = data.skills.map(skill => ({
                        skill_name: skill.skill_name || skill.name || "",
                        skill_level: skill.skill_level || skill.level || ""
                    })).filter(s => s.skill_name);

                    saveSkillsToLocal();
                    renderSkills();
                }
            } catch (error) {
                console.error("Skills load failed:", error);
            }
        }

        async function saveSkillsToDatabase() {
            saveSkillsToLocal();
            if (skills.length === 0) {
                localStorage.setItem(scoped("resume_skills_completed"), "false");
                localStorage.setItem("resume_skills_completed", "false");
                return true;
            }

            try {
                const res = await fetch(`${API_BASE}/api/resumes/skills`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + token
                    },
                    body: JSON.stringify({
                        resume_id: resumeId,
                        skills: skills
                    })
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok || data.success === false) {
                    console.warn(data.message || "Skills could not be saved on API, local backup kept.");
                    localStorage.setItem(scoped("resume_skills_completed"), "true");
                    localStorage.setItem("resume_skills_completed", "true");
                    return true;
                }

                localStorage.setItem(scoped("resume_skills_completed"), "true");
                localStorage.setItem("resume_skills_completed", "true");
                return true;
            } catch (error) {
                console.error("Skills save failed, local backup kept:", error);
                localStorage.setItem(scoped("resume_skills_completed"), skills.length > 0 ? "true" : "false");
                localStorage.setItem("resume_skills_completed", skills.length > 0 ? "true" : "false");
                return true;
            }
        }

        function stripHtml(html) {
            const div = document.createElement("div");
            div.innerHTML = html || "";
            return div.textContent || div.innerText || "";
        }

        function formatWorkMeta(work) {
            const loc = [work.city, work.country].filter(Boolean).join(", ");
            const start = [work.start_month, work.start_year].filter(Boolean).join(" ");
            const end = work.currently_working ? "Current" : [work.end_month, work.end_year].filter(Boolean).join(" ");
            return [loc, [start, end].filter(Boolean).join(" - ")].filter(Boolean).join(" · ");
        }

        function renderWorkPreview(works) {
            const box = document.getElementById("cvCareerHistory");
            if (!box) return;
            if (!Array.isArray(works) || works.length === 0) {
                box.textContent = "Your selected work history will appear here.";
                return;
            }
            box.innerHTML = works.map(work => {
                const title = cleanText(work.job_title) || "Job Title";
                const employer = cleanText(work.employer) || "Employer";
                const meta = formatWorkMeta(work);
                const details = stripHtml(work.extra_info || "");
                return `
                    <div class="cv-mini-row">
                        <div><span class="cv-mini-title">${title}</span><br>${employer}</div>
                        <div class="cv-mini-meta">${meta || "Employment date"}</div>
                        <div>${details ? details.slice(0, 110) : "Responsibilities and achievements"}</div>
                    </div>
                `;
            }).join("");
        }

        function renderEducationPreview(education) {
            const box = document.getElementById("cvEducation");
            if (!box) return;
            if (!isMeaningfulEducation(education)) {
                box.textContent = "School / College Name — Degree, Field of Study";
                return;
            }
            const school = education.school_name || education.school || education.schoolName || "School / College Name";
            const city = education.city || education.location || "";
            const degree = education.degree || education.qualification || "";
            const field = education.field_of_study || education.field || education.subject || "";
            const year = education.graduation_year || education.year || education.grad_year || "";
            box.innerHTML = `
                <div class="cv-mini-row">
                    <div><span class="cv-mini-title">${school}</span><br>${city}</div>
                    <div>${[degree, field].filter(Boolean).join(", ") || "Grade"}</div>
                    <div class="cv-mini-meta">${year || "Study dates"}</div>
                </div>
            `;
        }


        function esc(str) {
            return String(str || '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function selectedAccent() {
            return cleanText(localStorage.getItem('resume_accent_color')) || cleanText(localStorage.getItem('selected_template_default_color')) || '#2563eb';
        }

        function getSkillNamesForPreview() {
            const names = skills.map(s => cleanText(s.skill_name)).filter(Boolean);
            return names.slice(0, 9);
        }

        function splitSkillsColumns() {
            const names = getSkillNamesForPreview();
            return [names.slice(0,3), names.slice(3,6), names.slice(6,9)];
        }

        function contactDataForTemplate() {
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

        function educationForTemplate() {
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

        function workForTemplate() {
            const items = Array.isArray(previewWorkItems) && previewWorkItems.length ? previewWorkItems : getSelectedWorkHistory();
            return items.length ? items[0] : null;
        }

        function workDetailsHtml(work) {
            if (!work) return 'In concise sentences describe the daily tasks you undertook.';
            const raw = work.extra_info || work.description || work.responsibilities || '';
            const text = stripHtml(raw);
            return text ? esc(text).slice(0, 180) : 'Responsibilities and achievements';
        }

        function coreSkillsMarkup(modalMode = false) {
            const c = contactDataForTemplate();
            const e = educationForTemplate();
            const work = workForTemplate();
            const cols = splitSkillsColumns();
            const skillColumns = getSkillNamesForPreview().length
                ? cols.map(col => `<ul class="core-cv-list">${col.map(name => `<li>${esc(name)}</li>`).join('')}</ul>`).join('')
                : '';
            const workTitle = work ? cleanText(work.job_title) || 'Your Most Recent Job Title' : 'Your Most Recent Job Title';
            const employer = work ? cleanText(work.employer) || 'Employer name' : 'Employer name';
            const workDate = work ? cleanText([work.start_month, work.start_year].filter(Boolean).join(' ') + (work.currently_working ? ' - Current' : (work.end_month || work.end_year ? ' - ' + [work.end_month, work.end_year].filter(Boolean).join(' ') : ''))) || 'Employment dates' : 'Employment dates';
            return `
                <div class="core-cv-live ${modalMode ? 'modal-size' : ''}" style="--cv-accent:${esc(selectedAccent())}">
                    <div class="core-cv-name" id="cvName">${esc(c.fullName).toUpperCase()}</div>
                    <div class="core-cv-contact" id="cvContact">${esc([c.city, c.country, c.postal].filter(Boolean).join(', '))}<br>${esc(c.phone || 'Phone')} &nbsp; | &nbsp; ${esc(c.email || 'Email')}</div>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Professional Competencies</div>
                        <ul class="core-cv-list"><li>Use these bullet points to define and explain what you believe to be your key skills and abilities.</li></ul>
                    </section>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Personal Competencies</div>
                        <ul class="core-cv-list"><li>Create a list of the personal skills and qualities that you will bring to a new employer.</li></ul>
                    </section>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Areas of Expertise</div>
                        <div class="core-cv-grid-3 core-cv-text" id="cvSkillsList">${skillColumns}</div>
                    </section>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Career History</div>
                        <div class="core-cv-history-row core-cv-text" id="cvCareerHistory">
                            <div><span class="core-cv-bold">${esc(workTitle)}</span><br>Duties</div>
                            <div>${esc(employer)}</div>
                            <div class="core-cv-muted">${esc(workDate)}</div>
                        </div>
                        <div class="core-cv-text">${workDetailsHtml(work)}</div>
                    </section>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Academic Qualifications</div>
                        <div class="core-cv-edu-row core-cv-text" id="cvEducation">
                            <div><span class="core-cv-bold">${esc(e.school)}</span><br>${esc(e.degree)} / ${esc(e.field)}</div>
                            <div>${esc(e.location)}</div>
                            <div class="core-cv-muted">${esc(e.date)}</div>
                        </div>
                    </section>

                    <section class="core-cv-section">
                        <div class="core-cv-title">Education Highlights</div>
                        <div class="core-cv-editor-html">${e.detailsHtml ? e.detailsHtml : 'Extra education details will automatically align inside this preview.'}</div>
                    </section>
                </div>
            `;
        }


        function fakeSkillsIntroMarkup(modalMode = false) {
            return `
                <div class="skills-fake-template ${modalMode ? 'modal-size' : ''}">
                    <div class="fake-current-title">YOUR CURRENT / PREFERRED JOB TITLE</div>
                    <div class="fake-name">YOUR NAME</div>
                    <div class="fake-contact">Your address &nbsp;&nbsp;|&nbsp;&nbsp; Email address / Telephone number</div>

                    <section class="fake-section">
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

                    <section class="fake-section fake-green-highlight">
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
                </div>
            `;
        }

        function renderCoreSkillsPreview() {
            const host = document.querySelector('.preview-box');
            if (!host) return;
            const oldScrollBox = host.querySelector('.core-cv-scrollbox');
            const scrollTop = oldScrollBox ? oldScrollBox.scrollTop : 0;
            const isIntro = document.body.classList.contains("skills-intro-active");
            const markup = isIntro ? fakeSkillsIntroMarkup(false) : coreSkillsMarkup(false);
            host.innerHTML = `<div class="core-cv-scrollbox">${markup}</div>`;
            const newScrollBox = host.querySelector('.core-cv-scrollbox');
            if (newScrollBox && !isIntro) requestAnimationFrame(() => { newScrollBox.scrollTop = scrollTop; });
            updatePreviewModalContent();
        }

        function updatePreviewModalContent() {
            const content = document.getElementById("skillsPreviewModalContent");
            if (!content) return;
            const isIntro = document.body.classList.contains("skills-intro-active");
            content.innerHTML = isIntro ? fakeSkillsIntroMarkup(true) : coreSkillsMarkup(true);
        }

        function getContactSnapshot() {
            return safeJson("resume_contact_snapshot_" + resumeId, null) ||
                safeJson(scoped("resume_contact_snapshot"), null) ||
                safeJson("resume_contact_snapshot", null) ||
                safeJson("resume_contact_data_" + resumeId, null) ||
                safeJson("resume_contact_data", null);
        }

        function applyContactToPreview(contact) {
            if (!contact) return;
            previewContact = Object.assign({}, previewContact || {}, contact);
            renderCoreSkillsPreview();
        }

        async function loadResumePreviewInfo() {
            applyContactToPreview(getContactSnapshot());

            try {
                const res = await fetch(`${API_BASE}/api/resumes/get/${resumeId}`, {
                    headers: { "Authorization": "Bearer " + token }
                });
                const data = await res.json();
                if (data.success && data.resume) applyContactToPreview(data.resume);
            } catch (error) {
                console.error("Resume preview load failed:", error);
            }

            let selectedEducation = getSelectedEducationSnapshot();
            if (!selectedEducation && hasSelectedEducation()) {
                try {
                    const eduRes = await fetch(`${API_BASE}/api/resumes/education/${resumeId}`, {
                        headers: { "Authorization": "Bearer " + token }
                    });
                    const eduData = await eduRes.json();
                    if (eduData.success && eduData.education) selectedEducation = eduData.education;
                } catch (error) {
                    console.error("Education preview load failed:", error);
                }
            }
            previewEducation = selectedEducation || null;
            previewWorkItems = getSelectedWorkHistory();
            renderCoreSkillsPreview();
        }

        document.getElementById("addSkillBtn").addEventListener("click", () => {
            addSkill(skillNameInput.value, skillLevelInput.value);
        });

        skillNameInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                addSkill(skillNameInput.value, skillLevelInput.value);
            }
        });

        document.querySelectorAll(".suggestion-chip").forEach(chip => {
            chip.addEventListener("click", () => {
                const clone = chip.cloneNode(true);
                clone.querySelectorAll("span").forEach(s => s.remove());
                addSkill(clone.textContent, "");
            });
        });

        btnNextSkills.addEventListener("click", async () => {
            if (isSkillsIntroMode) {
                showSkillsAddMode();
                return;
            }

            const ok = await saveSkillsToDatabase();
            if (ok) window.location.href = "/builder/summary";
        });

        document.getElementById("btnPreview").addEventListener("click", () => {
            updatePreviewModalContent();
            const modal = document.getElementById("skillsPreviewModal");
            if (modal) {
                modal.classList.add("show");
                modal.setAttribute("aria-hidden", "false");
            }
        });

        document.getElementById("closeSkillsPreview").addEventListener("click", () => {
            const modal = document.getElementById("skillsPreviewModal");
            if (modal) {
                modal.classList.remove("show");
                modal.setAttribute("aria-hidden", "true");
            }
        });

        document.getElementById("skillsPreviewModal").addEventListener("click", (e) => {
            if (e.target && e.target.id === "skillsPreviewModal") {
                e.currentTarget.classList.remove("show");
                e.currentTarget.setAttribute("aria-hidden", "true");
            }
        });

        setupSkillsMode();
        setupSidebarFlow();
        loadSkillsFromLocal();
        renderSkills();
        loadResumePreviewInfo();
        loadSkillsFromDatabase();
    </script>
</body>
</html>
