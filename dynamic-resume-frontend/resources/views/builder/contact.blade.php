<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Info - Resume Builder (Awesome Design)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* FIXED ZOOM PREVIEW WRAPPER ARCHITECTURE */
        .preview-pane-container {
            width: 100%;
            height: 290px; /* EXACT MATCH: Education layout height specifications */
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
            padding-top: 0.25rem;
            overflow: hidden;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.02);
        }
        .a4-page {
            width: 210mm;
            height: 297mm;
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: scale(0.32); /* EXACT MATCH: Mini view micro scale profile wrapper */
            transform-origin: top center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        .form-label {
            display: block;
            font-size: 11px; /* EXACT MATCH: Compressed micro size font */
            font-weight: 700;
            color: #475569;
            margin-bottom: 3px;
        }
        .form-input {
            width: 100%;
            padding: 7px 11px; /* EXACT MATCH: Compact structural cell sizing padding */
            border: 1.5px solid #cbd5e1;
            border-radius: 6px;
            outline: none;
            font-size: 13px;
            color: #1e293b;
            transition: all 0.2s ease;
            background: #fff;
        }
        .form-input:focus {
            border-color: #f472b6;
            box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.12);
        }
        /* Country Code Select Dropdown integrated in input group style mapping */
        .country-select {
            padding: 7px 11px;
            border: 1.5px solid #cbd5e1;
            border-right: none;
            border-radius: 6px 0 0 6px;
            background: #f8fafc;
            font-size: 13px;
            font-weight: bold;
            outline: none;
            cursor: pointer;
        }
        .country-select:focus {
            border-color: #f472b6;
        }
        /* Modal Fade-in Animation Engine */
        .animation-fade-in { 
            animation: fadeIn 0.3s ease-in-out; 
        }
        @keyframes fadeIn { 
            from { opacity: 0; transform: scale(0.95); } 
            to { opacity: 1; transform: scale(1); } 
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    

        

        /* STABLE PROFESSIONAL PREVIEW MODAL: fixed scrolling + selected template image preview */
        #previewModal {
            position: fixed !important;
            inset: 0 !important;
            z-index: 999999 !important;
            background: rgba(2, 6, 23, 0.74) !important;
            backdrop-filter: blur(5px) !important;
            padding: 14px !important;
            overflow: hidden !important;
        }
        #previewModal.hidden { display: none !important; }
        #previewModal.flex { display: flex !important; align-items: center !important; justify-content: center !important; }
        .preview-modal-shell {
            width: min(1180px, calc(100vw - 28px));
            height: min(820px, calc(100vh - 28px));
            max-height: calc(100vh - 28px);
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, .5);
        }
        .preview-modal-header {
            flex: 0 0 auto;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 20px;
        }
        .preview-modal-body {
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
            display: grid;
            grid-template-columns: minmax(0, 1.12fr) minmax(360px, .88fr);
        }
        .preview-left-panel {
            min-width: 0;
            min-height: 0;
            overflow: hidden;
            display: grid;
            grid-template-rows: auto minmax(0, 1fr);
            background: linear-gradient(135deg, #e2e8f0, #f8fafc);
        }
        .modal-selected-template-strip {
            margin: 14px;
            background: rgba(255,255,255,.96);
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 12px;
            display: grid;
            grid-template-columns: 118px minmax(0,1fr);
            gap: 13px;
            box-shadow: 0 12px 28px rgba(15,23,42,.10);
        }
        .modal-selected-template-large-frame {
            width: 118px;
            height: 142px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #dbe3ef;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-selected-template-large-frame img,
        .modal-current-template-img,
        .selected-template-badge-frame img,
        .template-thumb-frame img {
            width: 100%;
            height: 100%;
            object-fit: contain !important;
            background: #f8fafc;
        }
        .template-image-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #64748b;
            font-size: 11px;
            font-weight: 900;
            padding: 8px;
            background: #f1f5f9;
        }
        .preview-paper-stage {
            min-height: 0;
            overflow: hidden;
            padding: 8px 14px 14px;
            display: grid;
            grid-template-columns: minmax(210px, 270px) minmax(0, 1fr);
            gap: 14px;
            align-items: stretch;
        }
        .template-full-view-card {
            background: rgba(255,255,255,.92);
            border: 1px solid #dbe3ef;
            border-radius: 18px;
            padding: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 0;
            box-shadow: 0 14px 32px rgba(15,23,42,.10);
        }
        .template-full-view-frame {
            flex: 1 1 auto;
            min-height: 0;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .template-full-view-frame img {
            max-width: 100%;
            max-height: 100%;
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #f8fafc;
        }
        .preview-paper-wrap {
            min-height: 0;
            overflow: hidden;
            border-radius: 18px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            background: rgba(255,255,255,.55);
            border: 1px solid rgba(226,232,240,.9);
            box-shadow: inset 0 1px 4px rgba(15,23,42,.04);
        }
        .preview-paper-compact {
            width: 210mm;
            height: 297mm;
            background: #ffffff;
            box-shadow: 0 18px 45px rgba(15,23,42,.18);
            transform: scale(.255);
            transform-origin: top center;
            flex-shrink: 0;
        }
        .template-side-panel {
            min-width: 0;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #ffffff;
            border-left: 1px solid #e5e7eb;
        }
        .modal-current-template-card {
            border: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #faf5ff, #fff1f2);
            border-radius: 16px;
            padding: 10px;
        }
        .modal-current-template-img {
            width: 60px;
            height: 78px;
            object-fit: contain;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            flex-shrink: 0;
        }
        .template-panel-scroll-area {
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 14px;
        }
        .template-preview-scroll {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 2px 6px 12px 2px;
            scrollbar-gutter: stable;
        }
        .template-preview-scroll::-webkit-scrollbar { width: 7px; }
        .template-preview-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 999px; }
        .template-preview-scroll::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 999px; }
        .preview-template-card {
            border: 2px solid transparent;
            border-radius: 14px;
            padding: 8px;
            background: #ffffff;
            cursor: pointer;
            transition: all .18s ease;
            position: relative;
        }
        .preview-template-card:hover {
            border-color: #93c5fd;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(15,23,42,.08);
        }
        .preview-template-card.selected-template-card {
            border-color: #ec4899 !important;
            background: #fdf2f8 !important;
            box-shadow: 0 12px 26px rgba(236,72,153,.14);
        }
        .preview-template-card.pending-template-card {
            border-color: #2563eb !important;
            background: #eff6ff !important;
            box-shadow: 0 12px 26px rgba(37,99,235,.13);
        }
        .template-status-pill {
            position: absolute;
            top: 7px;
            left: 7px;
            z-index: 3;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 4px 7px;
            border-radius: 999px;
            background: rgba(15,23,42,.90);
            color: #fff;
        }
        .template-status-pill.pending { background: rgba(37,99,235,.92); }
        .template-thumb-frame {
            width: 100%;
            height: 120px;
            border-radius: 10px;
            overflow: hidden;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .color-btn.active-color {
            outline: 3px solid rgba(15,23,42,.22);
            outline-offset: 3px;
            transform: scale(1.08);
        }
        .selected-template-badge-frame {
            width: 64px;
            height: 78px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .modal-action-footer {
            flex: 0 0 auto;
            border-top: 1px solid #e5e7eb;
            background: #f8fafc;
            padding: 13px 16px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }
        @media (max-width: 1050px) {
            #previewModal { padding: 8px !important; overflow-y: auto !important; align-items: flex-start !important; }
            .preview-modal-shell { height: auto; min-height: 0; max-height: none; width: calc(100vw - 16px); }
            .preview-modal-body { display: block; overflow: visible; }
            .preview-left-panel { display: block; overflow: visible; }
            .preview-paper-stage { grid-template-columns: 1fr; }
            .template-full-view-card { height: 280px; }
            .preview-paper-wrap { height: 450px; }
            .preview-paper-compact { transform: scale(.30); }
            .template-side-panel { border-left: 0; border-top: 1px solid #e5e7eb; height: 540px; }
        }


        /* EXACT SELECTED PNG TEMPLATE LIVE PREVIEW OVERLAY */
        .exact-template-preview {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 0;
            overflow: hidden;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .exact-template-preview img.exact-template-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #f8fafc;
            z-index: 1;
        }
        .exact-template-fallback {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 14px;
            color: #64748b;
            font-size: 12px;
            font-weight: 900;
            background: #f1f5f9;
            z-index: 2;
        }
        .exact-live-text-layer {
            position: absolute;
            inset: 0;
            z-index: 3;
            pointer-events: none;
            font-family: Arial, sans-serif;
        }
        .exact-live-chip {
            position: absolute;
            background: rgba(255,255,255,.84);
            border: 1px solid rgba(226,232,240,.90);
            box-shadow: 0 8px 22px rgba(15,23,42,.10);
            color: #0f172a;
            border-radius: 10px;
            padding: 4px 8px;
            max-width: 72%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .exact-live-name { top: 10%; left: 50%; transform: translateX(-50%); font-size: 14px; font-weight: 900; letter-spacing: .10em; text-transform: uppercase; }
        .exact-live-contact { top: 19%; left: 50%; transform: translateX(-50%); font-size: 9px; font-weight: 800; color: #475569; }
        .exact-live-section { top: 35%; left: 14%; font-size: 9px; font-weight: 900; color: #2563eb; text-transform: uppercase; letter-spacing: .12em; }
        .exact-live-info { top: 42%; left: 14%; font-size: 8px; font-weight: 800; color: #334155; max-width: 55%; }
        .exact-template-preview.big .exact-live-name { top: 9%; font-size: 26px; padding: 7px 14px; }
        .exact-template-preview.big .exact-live-contact { top: 18%; font-size: 13px; padding: 6px 12px; }
        .exact-template-preview.big .exact-live-section { top: 34%; left: 13%; font-size: 14px; padding: 6px 12px; }
        .exact-template-preview.big .exact-live-info { top: 42%; left: 13%; font-size: 12px; padding: 6px 12px; }
        .exact-template-preview.mini .exact-live-chip { opacity: .92; }
        .preview-pane-container {
            height: 370px !important;
            padding: 10px !important;
            background: linear-gradient(135deg, #eef2f7, #ffffff) !important;
        }
        .preview-paper-wrap {
            padding: 12px;
        }
        .preview-paper-wrap .exact-template-preview {
            width: min(360px, 96%);
            height: 100%;
            min-height: 520px;
            margin: 0 auto;
            box-shadow: 0 18px 45px rgba(15,23,42,.18);
            background: white;
        }


        /* REAL EDITABLE HTML/CSS RESUME TEMPLATE - first layout: modern_sidebar */
        .preview-pane-container.real-template-mode {
            height: 370px !important;
            padding: 10px !important;
            background: #eef2f7 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            overflow: hidden !important;
        }
        .modern-live-preview {
            --resume-accent: #2563eb;
            width: 280px;
            height: 360px;
            background: white;
            box-shadow: 0 18px 45px rgba(15,23,42,.16);
            border-radius: 8px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 34% 66%;
            font-family: Arial, sans-serif;
            color: #111827;
        }
        .modern-live-preview .mlp-sidebar {
            background: #1f2937;
            color: #ffffff;
            padding: 18px 11px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .modern-live-preview .mlp-avatar {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: #ffffff;
            color: #1f2937;
            margin: 0 auto 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 900;
            border: 3px solid var(--resume-accent);
        }
        .modern-live-preview .mlp-side-title {
            font-size: 7px;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--resume-accent);
            margin-bottom: 5px;
            border-bottom: 1px solid rgba(255,255,255,.25);
            padding-bottom: 3px;
        }
        .modern-live-preview .mlp-side-text {
            font-size: 6.8px;
            line-height: 1.55;
            color: #e5e7eb;
            word-break: break-word;
        }
        .modern-live-preview .mlp-main {
            padding: 20px 18px;
            background: #ffffff;
        }
        .modern-live-preview .mlp-name {
            font-size: 17px;
            font-weight: 900;
            letter-spacing: .13em;
            text-transform: uppercase;
            color: #111827;
            line-height: 1.1;
        }
        .modern-live-preview .mlp-role {
            margin-top: 4px;
            height: 8px;
            background: var(--resume-accent);
            color: white;
            font-size: 5.5px;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            padding: 0 6px;
            border-radius: 999px;
        }
        .modern-live-preview .mlp-summary {
            margin-top: 10px;
            font-size: 6.8px;
            line-height: 1.6;
            color: #4b5563;
        }
        .modern-live-preview .mlp-section {
            margin-top: 13px;
        }
        .modern-live-preview .mlp-section-title {
            font-size: 7px;
            font-weight: 900;
            letter-spacing: .13em;
            text-transform: uppercase;
            color: #111827;
            border-bottom: 2px solid var(--resume-accent);
            padding-bottom: 3px;
            margin-bottom: 6px;
        }
        .modern-live-preview .mlp-item-title {
            font-size: 7.5px;
            font-weight: 900;
            color: #111827;
        }
        .modern-live-preview .mlp-item-meta {
            font-size: 6.2px;
            color: var(--resume-accent);
            font-weight: 900;
            margin: 2px 0;
        }
        .modern-live-preview .mlp-item-text {
            font-size: 6.6px;
            color: #4b5563;
            line-height: 1.55;
        }
        .modern-live-preview .mlp-skill-pill {
            display: inline-block;
            margin: 2px 2px 0 0;
            padding: 2px 4px;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            font-size: 5.8px;
            font-weight: 800;
            color: #e5e7eb;
        }
        .preview-paper-wrap .modern-live-preview {
            width: 420px;
            height: 590px;
            transform: scale(.78);
            transform-origin: top center;
        }
        .preview-paper-wrap .modern-live-preview .mlp-name { font-size: 25px; }
        .preview-paper-wrap .modern-live-preview .mlp-side-text,
        .preview-paper-wrap .modern-live-preview .mlp-summary,
        .preview-paper-wrap .modern-live-preview .mlp-item-text { font-size: 9px; }
        .preview-paper-wrap .modern-live-preview .mlp-section-title,
        .preview-paper-wrap .modern-live-preview .mlp-item-title { font-size: 10px; }



        /* GHOST FINAL VIDEO-STYLE OVERRIDE: direct large live preview, no duplicate selected-template card */
        #selectedTemplateBadge {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }
        .builder-right-preview-panel {
            justify-content: center !important;
            align-items: center !important;
            overflow: hidden !important;
            padding: 18px 26px 88px !important;
            gap: 18px !important;
        }
        .builder-right-preview-panel .preview-pane-container.real-template-mode {
            width: min(100%, 620px) !important;
            height: min(590px, calc(100vh - 205px)) !important;
            min-height: 440px !important;
            max-height: 590px !important;
            padding: 18px !important;
            background: linear-gradient(135deg, #eef2f7 0%, #f8fafc 48%, #ffffff 100%) !important;
            border: 1px solid #dbe3ef !important;
            border-radius: 18px !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
        }
        .builder-right-preview-panel .modern-live-preview {
            width: 390px !important;
            height: 545px !important;
            max-width: 96% !important;
            max-height: 100% !important;
            transform: none !important;
            transform-origin: center center !important;
            border-radius: 10px !important;
            box-shadow: 0 20px 50px rgba(15, 23, 42, .18) !important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-sidebar {
            padding: 24px 14px !important;
            gap: 14px !important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-main {
            padding: 28px 22px !important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-name {
            font-size: 24px !important;
            line-height: 1.05 !important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-role {
            height: 14px !important;
            font-size: 7px !important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-side-title,
        .builder-right-preview-panel .modern-live-preview .mlp-section-title {
            font-size: 9px !important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-side-text,
        .builder-right-preview-panel .modern-live-preview .mlp-summary,
        .builder-right-preview-panel .modern-live-preview .mlp-item-text {
            font-size: 8.5px !important;
            line-height: 1.55 !important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-item-title,
        .builder-right-preview-panel .modern-live-preview .mlp-item-meta {
            font-size: 9px !important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-skill-pill {
            font-size: 7px !important;
            padding: 3px 6px !important;
        }
        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            max-width: 420px !important;
            margin-top: 0 !important;
            justify-content: center !important;
            align-items: center !important;
        }
        @media (max-width: 1280px) {
            .builder-right-preview-panel .modern-live-preview {
                width: 350px !important;
                height: 500px !important;
            }
        }

        /* GHOST CONTACT PAGE UI UPGRADE - UI ONLY, OLD LOGIC UNCHANGED */
        :root { --ghost-dark:#0f172a; --ghost-pink:#ec4899; --ghost-blue:#2563eb; --ghost-border:#dbe3ef; }

        body { background:#fff!important; overflow:hidden!important; }

        nav {
            height:78px!important; min-height:78px!important; padding:0 52px!important;
            background:#0f172a!important; border-bottom:1px solid rgba(148,163,184,.16)!important;
            box-shadow:0 10px 32px rgba(15,23,42,.16)!important;
        }
        nav .text-xl { font-size:26px!important; letter-spacing:-.035em!important; }
        nav .fa-layer-group { font-size:25px!important; margin-right:11px!important; }
        nav .space-x-8 { gap:42px!important; }
        nav .text-xs { font-size:13px!important; letter-spacing:.11em!important; }
        nav .pb-2 { padding-bottom:18px!important; }
        nav .-mb-2\.5 { margin-bottom:-22px!important; }
        #progressText { font-size:13px!important; font-weight:900!important; }

        body > .flex.flex-grow {
            height:calc(100vh - 78px)!important;
            background:linear-gradient(90deg,#fff 0%,#fff 61.5%,#f3f6fa 61.5%,#f8fafc 100%)!important;
        }

        body > .flex.flex-grow > div:first-child {
            width:62%!important; background:#fff!important; padding:46px 72px 120px!important; overflow-y:auto!important;
        }
        body > .flex.flex-grow > div:first-child .max-w-2xl {
            max-width:930px!important; margin-left:0!important; margin-right:auto!important;
        }

        a[href="/upload-or-scratch"] {
            color:#2563eb!important; font-size:14px!important; margin-bottom:26px!important;
            letter-spacing:.06em!important; display:inline-flex!important; align-items:center!important;
            transition:.2s ease!important;
        }
        a[href="/upload-or-scratch"]:hover { color:#ec4899!important; transform:translateX(-2px); }

        h1 {
            font-size:clamp(30px,2.2vw,42px)!important; line-height:1.14!important;
            letter-spacing:-.055em!important; color:#0f172a!important; margin-bottom:8px!important; max-width:920px!important;
        }
        h1 + p {
            font-size:20px!important; line-height:1.45!important; color:#64748b!important;
            margin-bottom:34px!important; letter-spacing:.01em!important;
        }
        p.text-red-500 { font-size:14px!important; margin-bottom:22px!important; color:#ef4444!important; }

        #contactForm { max-width:920px!important; display:flex!important; flex-direction:column!important; gap:22px!important; }
        #contactForm .flex { gap:22px!important; }

        .form-label {
            font-size:14px!important; font-weight:850!important; color:#334155!important;
            margin-bottom:9px!important; letter-spacing:-.01em!important;
        }
        .form-input, .country-select {
            height:56px!important; padding:0 18px!important; border:1.8px solid #cfd8e3!important;
            border-radius:9px!important; background:#fff!important; color:#0f172a!important;
            font-size:17px!important; font-weight:500!important; box-shadow:0 1px 0 rgba(15,23,42,.02)!important;
            transition:border-color .2s ease, box-shadow .2s ease, transform .2s ease!important;
        }
        .form-input::placeholder { color:#98a2b3!important; font-weight:400!important; }
        .form-input:focus, .country-select:focus {
            border-color:#ec4899!important; box-shadow:0 0 0 4px rgba(236,72,153,.11)!important; transform:translateY(-1px);
        }
        .country-select {
            min-width:148px!important; border-right:0!important; border-radius:9px 0 0 9px!important;
            background:#f8fafc!important; font-size:16px!important; font-weight:900!important; color:#111827!important;
        }
        #inp_phone { border-radius:0 9px 9px 0!important; }
        #inp_email { background:#f8fbff!important; }

        .builder-right-preview-panel {
            width:38%!important;
            background:radial-gradient(circle at 50% 36%,rgba(255,255,255,.96),rgba(248,250,252,.88) 42%,rgba(226,232,240,.78) 100%)!important;
            border-left:1px solid #e5e7eb!important; padding:28px 38px 86px!important;
            justify-content:center!important; align-items:center!important; overflow:hidden!important; position:relative!important;
        }
        .builder-right-preview-panel::before {
            content:""; position:absolute; inset:26px 30px 120px; border-radius:22px;
            background:rgba(255,255,255,.46); border:1px solid rgba(226,232,240,.9);
            box-shadow:0 18px 50px rgba(15,23,42,.06); pointer-events:none;
        }
        .builder-right-preview-panel .preview-pane-container.real-template-mode {
            position:relative!important; z-index:2!important; width:min(100%,660px)!important;
            height:min(640px,calc(100vh - 226px))!important; min-height:475px!important; max-height:640px!important;
            padding:20px!important; background:transparent!important; border:0!important; border-radius:20px!important;
            box-shadow:none!important; overflow:hidden!important; display:flex!important; align-items:flex-start!important; justify-content:center!important;
        }
        .builder-right-preview-panel .modern-live-preview {
            width:430px!important; height:602px!important; max-width:96%!important; max-height:100%!important;
            transform:none!important; border-radius:8px!important; box-shadow:0 28px 68px rgba(15,23,42,.17)!important;
        }
        .builder-right-preview-panel .modern-live-preview .mlp-sidebar { padding:28px 16px!important; gap:15px!important; }
        .builder-right-preview-panel .modern-live-preview .mlp-main { padding:30px 24px!important; }
        .builder-right-preview-panel .modern-live-preview .mlp-name { font-size:25px!important; line-height:1.05!important; }
        .builder-right-preview-panel .modern-live-preview .mlp-role { height:15px!important; font-size:7px!important; }
        .builder-right-preview-panel .modern-live-preview .mlp-side-title,
        .builder-right-preview-panel .modern-live-preview .mlp-section-title { font-size:9px!important; }
        .builder-right-preview-panel .modern-live-preview .mlp-side-text,
        .builder-right-preview-panel .modern-live-preview .mlp-summary,
        .builder-right-preview-panel .modern-live-preview .mlp-item-text { font-size:8.8px!important; line-height:1.56!important; }
        .builder-right-preview-panel .modern-live-preview .mlp-item-title,
        .builder-right-preview-panel .modern-live-preview .mlp-item-meta { font-size:9px!important; }

        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            position:relative!important; z-index:4!important; max-width:440px!important; width:100%!important;
            gap:16px!important; padding:0!important; margin-top:18px!important;
        }
        #btnPreview, #btnNext {
            height:54px!important; border-radius:999px!important; display:inline-flex!important; align-items:center!important;
            justify-content:center!important; text-align:center!important; white-space:nowrap!important; font-size:13px!important;
            font-weight:950!important; letter-spacing:.08em!important; padding:0 28px!important;
            transition:transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease!important;
        }
        #btnPreview { min-width:140px!important; border:2px solid #0f172a!important; color:#0f172a!important; background:#fff!important; }
        #btnPreview:hover { transform:translateY(-2px); box-shadow:0 12px 24px rgba(15,23,42,.12); }
        #btnNext { min-width:190px!important; background:#ec4899!important; color:#fff!important; box-shadow:0 16px 32px rgba(236,72,153,.22)!important; }
        #btnNext:hover { background:#db2777!important; transform:translateY(-2px); box-shadow:0 20px 40px rgba(236,72,153,.30)!important; }

        body > .absolute.bottom-0 {
            height:66px!important; padding:0 52px!important; background:#0f172a!important;
            border-top:1px solid rgba(148,163,184,.18)!important; font-size:13px!important; letter-spacing:.02em!important;
        }
        body > .absolute.bottom-0 .flex { gap:28px!important; }
        body > .absolute.bottom-0 a:hover { color:#ec4899!important; }

        @media (max-width:1280px) {
            body > .flex.flex-grow > div:first-child { padding-left:52px!important; padding-right:52px!important; }
            .builder-right-preview-panel .modern-live-preview { width:385px!important; height:548px!important; }
            h1 { font-size:34px!important; }
        }
        @media (max-width:1024px) {
            body { overflow:auto!important; }
            body > .flex.flex-grow { display:block!important; height:auto!important; }
            body > .flex.flex-grow > div:first-child { width:100%!important; padding:34px 24px 120px!important; }
            .builder-right-preview-panel { display:none!important; }
            body > .absolute.bottom-0 {
                position:relative!important; height:auto!important; min-height:70px!important; padding:18px 24px!important;
                flex-direction:column!important; gap:14px!important; align-items:flex-start!important;
            }
            #contactForm .flex { flex-direction:column!important; }
            #contactForm .w-1\\/2, #contactForm .w-2\\/3, #contactForm .w-1\\/3 { width:100%!important; }
        }


        /* GHOST LEFT SIDEBAR CONTACT UI - UI ONLY, OLD LOGIC UNCHANGED */
        :root {
            --sidebar-blue: #073f70;
            --sidebar-blue-dark: #063966;
            --sidebar-text: #ffffff;
            --sidebar-muted: rgba(255,255,255,.72);
            --sidebar-line: rgba(255,255,255,.24);
            --ghost-pink: #ec4899;
            --ghost-green: #34d399;
        }

        body {
            background: #ffffff !important;
            overflow: hidden !important;
        }

        /* Turn existing top navbar into the fixed left panel */
        body > nav {
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            bottom: 0 !important;
            width: 360px !important;
            height: 100vh !important;
            min-height: 100vh !important;
            z-index: 80 !important;
            background: #073f70 !important;
            border: 0 !important;
            border-right: 1px solid rgba(255,255,255,.08) !important;
            box-shadow: 18px 0 46px rgba(15,23,42,.10) !important;
            padding: 42px 48px 240px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            justify-content: flex-start !important;
            overflow: hidden !important;
        }

        body > nav > div:first-child {
            width: 100% !important;
            margin-bottom: 46px !important;
        }

        body > nav .text-xl {
            color: #ffffff !important;
            font-size: 27px !important;
            font-weight: 950 !important;
            letter-spacing: -0.04em !important;
            white-space: nowrap !important;
        }

        body > nav .fa-layer-group {
            font-size: 34px !important;
            color: #ec4899 !important;
            margin-right: 14px !important;
            filter: drop-shadow(0 10px 22px rgba(236,72,153,.22));
        }

        /* Vertical steps */
        body > nav > div:nth-child(2) {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 31px !important;
            width: 100% !important;
            margin: 0 !important;
            color: #ffffff !important;
            text-transform: none !important;
            letter-spacing: 0 !important;
            font-weight: 500 !important;
            font-size: 0 !important;
            position: relative !important;
        }

        body > nav > div:nth-child(2)::before {
            content: "";
            position: absolute;
            left: 21px;
            top: 43px;
            bottom: 44px;
            width: 3px;
            border-radius: 999px;
            background: repeating-linear-gradient(
                to bottom,
                rgba(255,255,255,.22) 0px,
                rgba(255,255,255,.22) 9px,
                transparent 9px,
                transparent 17px
            );
        }

        body > nav > div:nth-child(2) > div {
            position: relative !important;
            width: 100% !important;
            min-height: 42px !important;
            display: flex !important;
            align-items: center !important;
            padding-left: 54px !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            color: #ffffff !important;
            opacity: 1 !important;
            cursor: default !important;
            text-transform: none !important;
            letter-spacing: .01em !important;
            font-size: 23px !important;
            line-height: 1 !important;
            font-weight: 500 !important;
        }

        body > nav > div:nth-child(2) > div::before {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            border-radius: 999px;
            background: #0f172a;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 900;
            border: 3px solid rgba(226,232,240,.48);
            box-shadow: 0 0 0 4px rgba(15,23,42,.16);
            z-index: 2;
        }

        body > nav > div:nth-child(2) > div:nth-child(1)::before { content: "1"; background: #f8fafc; color: #111827; }
        body > nav > div:nth-child(2) > div:nth-child(2)::before { content: "2"; }
        body > nav > div:nth-child(2) > div:nth-child(3)::before { content: "3"; }
        body > nav > div:nth-child(2) > div:nth-child(4)::before { content: "4"; }
        body > nav > div:nth-child(2) > div:nth-child(5)::before { content: "5"; }

        body > nav > div:nth-child(2) > div:nth-child(1) {
            font-weight: 850 !important;
        }

        body > nav > div:nth-child(2) > div:nth-child(1)::after {
            content: none !important;
        }

        body > nav > div:nth-child(2) > div:nth-child(5)::after {
            content: "Finalize";
            position: absolute;
            left: 54px;
            top: 72px;
            color: #ffffff;
            font-size: 23px;
            font-weight: 500;
            letter-spacing: .01em;
        }

        body > nav > div:nth-child(2) > div:nth-child(5) {
            margin-bottom: 50px !important;
        }

        body > nav > div:nth-child(2) > div:nth-child(5) span,
        body > nav > div:nth-child(2) > div:nth-child(5) * {
            pointer-events: none;
        }

        body > nav > div:nth-child(2)::after {
            content: "6";
            position: absolute;
            left: 0;
            top: 351px;
            width: 42px;
            height: 42px;
            border-radius: 999px;
            background: #0f172a;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 900;
            border: 3px solid rgba(226,232,240,.48);
            box-shadow: 0 0 0 4px rgba(15,23,42,.16);
            z-index: 2;
        }

        /* Progress area at bottom of sidebar */
        body > nav > div:last-child {
            position: absolute !important;
            left: 48px !important;
            right: 48px !important;
            bottom: 295px !important;
            width: auto !important;
            display: block !important;
            color: #ffffff !important;
        }

        body > nav > div:last-child .relative {
            display: none !important;
        }

        body > nav > div:last-child .text-xs {
            font-size: 24px !important;
            font-weight: 950 !important;
            letter-spacing: -0.04em !important;
            color: #ffffff !important;
            margin-bottom: 10px !important;
        }

        body > nav > div:last-child::after {
            content: "";
            display: block;
            height: 11px;
            width: 220px;
            border-radius: 999px;
            background: linear-gradient(90deg, #34d399 0%, #34d399 22%, #ffffff 22%, #ffffff 100%);
            margin-top: 13px;
        }

        body > nav > div:last-child::before {
            content: "20%";
            position: absolute;
            left: 228px;
            top: 43px;
            font-size: 18px;
            font-weight: 900;
            color: #ffffff;
        }

        /* Main content starts after sidebar */
        body > .flex.flex-grow {
            margin-left: 360px !important;
            width: calc(100vw - 360px) !important;
            height: 100vh !important;
            background: #ffffff !important;
        }

        body > .flex.flex-grow > div:first-child {
            width: 62% !important;
            padding: 92px 54px 110px 48px !important;
            background: #ffffff !important;
            overflow-y: auto !important;
        }

        body > .flex.flex-grow > div:first-child .max-w-2xl {
            max-width: 760px !important;
            margin-left: 0 !important;
            margin-right: auto !important;
        }

        a[href="/upload-or-scratch"] {
            position: absolute !important;
            top: 98px !important;
            left: 410px !important;
            color: #2563eb !important;
            font-size: 22px !important;
            font-weight: 900 !important;
            z-index: 20 !important;
        }

        a[href="/upload-or-scratch"] i {
            margin-right: 10px !important;
        }

        h1 {
            font-size: clamp(30px, 2.4vw, 44px) !important;
            line-height: 1.13 !important;
            letter-spacing: -0.055em !important;
            color: #0f172a !important;
            margin-top: 48px !important;
            margin-bottom: 8px !important;
        }

        h1 + p {
            font-size: 20px !important;
            color: #64748b !important;
            margin-bottom: 34px !important;
        }

        p.text-red-500 {
            font-size: 14px !important;
            margin-bottom: 26px !important;
        }

        #contactForm {
            max-width: 720px !important;
            gap: 24px !important;
        }

        #contactForm .flex {
            gap: 24px !important;
        }

        .form-label {
            font-size: 15px !important;
            font-weight: 850 !important;
            color: #334155 !important;
            margin-bottom: 9px !important;
        }

        .form-input,
        .country-select {
            height: 58px !important;
            font-size: 18px !important;
            border: 1.8px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 0 18px !important;
            background: #ffffff !important;
        }

        .form-input:focus,
        .country-select:focus {
            border-color: #ec4899 !important;
            box-shadow: 0 0 0 4px rgba(236,72,153,.10) !important;
        }

        .country-select {
            min-width: 132px !important;
            border-right: 0 !important;
            border-radius: 8px 0 0 8px !important;
            font-weight: 900 !important;
            background: #f8fafc !important;
        }

        #inp_phone {
            border-radius: 0 8px 8px 0 !important;
        }

        .builder-right-preview-panel {
            width: 38% !important;
            background: #f1f5f9 !important;
            padding: 36px 34px 104px !important;
            border-left: 1px solid #e5e7eb !important;
            justify-content: center !important;
            align-items: center !important;
            overflow: hidden !important;
        }

        .builder-right-preview-panel .preview-pane-container.real-template-mode {
            width: min(100%, 640px) !important;
            height: min(620px, calc(100vh - 210px)) !important;
            min-height: 470px !important;
            padding: 16px !important;
            border-radius: 18px !important;
            border: 1px solid #dbe3ef !important;
            background: linear-gradient(135deg, #eef2f7, #ffffff) !important;
        }

        .builder-right-preview-panel .modern-live-preview {
            width: 420px !important;
            height: 590px !important;
            max-width: 96% !important;
            max-height: 100% !important;
            transform: none !important;
            box-shadow: 0 24px 60px rgba(15,23,42,.16) !important;
        }

        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            max-width: 430px !important;
            width: 100% !important;
            gap: 16px !important;
            padding: 0 !important;
            margin-top: 18px !important;
        }

        #btnPreview,
        #btnNext {
            height: 54px !important;
            border-radius: 999px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            white-space: nowrap !important;
            font-size: 13px !important;
            font-weight: 950 !important;
            letter-spacing: .08em !important;
        }

        #btnPreview {
            min-width: 138px !important;
            border: 2px solid #0f172a !important;
            background: #ffffff !important;
            color: #0f172a !important;
        }

        #btnNext {
            min-width: 188px !important;
            background: #ec4899 !important;
            color: #ffffff !important;
            box-shadow: 0 16px 32px rgba(236,72,153,.22) !important;
        }

        /* Footer links move into sidebar */
        body > .absolute.bottom-0 {
            position: fixed !important;
            left: 48px !important;
            bottom: 46px !important;
            width: 260px !important;
            height: auto !important;
            z-index: 90 !important;
            background: transparent !important;
            border: 0 !important;
            padding: 0 !important;
            color: #ffffff !important;
            display: block !important;
            font-size: 0 !important;
        }

        body > .absolute.bottom-0 > div:first-child {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }

        body > .absolute.bottom-0 a {
            color: #34d399 !important;
            font-size: 20px !important;
            font-weight: 850 !important;
            line-height: 1.2 !important;
        }

        body > .absolute.bottom-0 span {
            display: none !important;
        }

        body > .absolute.bottom-0 > div:last-child {
            margin-top: 32px !important;
            color: #ffffff !important;
            font-size: 16px !important;
            line-height: 1.35 !important;
            font-weight: 600 !important;
            max-width: 240px !important;
        }

        @media (max-width: 1200px) {
            body > nav { width: 318px !important; padding-left: 36px !important; padding-right: 36px !important; }
            body > .flex.flex-grow { margin-left: 318px !important; width: calc(100vw - 318px) !important; }
            a[href="/upload-or-scratch"] { left: 362px !important; }
            body > .absolute.bottom-0 { left: 36px !important; }
            body > .flex.flex-grow > div:first-child { padding-left: 42px !important; padding-right: 38px !important; }
        }

        @media (max-width: 1024px) {
            body { overflow: auto !important; }
            body > nav {
                position: relative !important;
                width: 100% !important;
                height: auto !important;
                min-height: 82px !important;
                padding: 22px 24px !important;
                flex-direction: row !important;
            }
            body > nav > div:nth-child(2),
            body > nav > div:last-child,
            body > .absolute.bottom-0 {
                display: none !important;
            }
            body > .flex.flex-grow {
                margin-left: 0 !important;
                width: 100% !important;
                height: auto !important;
                display: block !important;
            }
            body > .flex.flex-grow > div:first-child {
                width: 100% !important;
                padding: 34px 24px 110px !important;
            }
            a[href="/upload-or-scratch"] {
                position: static !important;
                font-size: 15px !important;
            }
            .builder-right-preview-panel {
                display: none !important;
            }
            #contactForm .flex {
                flex-direction: column !important;
            }
            #contactForm .w-1\/2,
            #contactForm .w-2\/3,
            #contactForm .w-1\/3 {
                width: 100% !important;
            }
        }


        /* GHOST FINAL: SHOW 75% BROWSER VIEW AT 100% - UI ONLY */
        html {
            width: 100% !important;
            height: 100% !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }

        body {
            zoom: 0.75 !important;
            width: 133.3333333333vw !important;
            height: 133.3333333333vh !important;
            min-width: 1680px !important;
            min-height: 995px !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }

        body > nav {
            height: 133.3333333333vh !important;
            min-height: 133.3333333333vh !important;
        }

        body > .flex.flex-grow {
            height: 133.3333333333vh !important;
        }

        body > .flex.flex-grow > div:first-child {
            height: 133.3333333333vh !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .builder-right-preview-panel {
            height: 133.3333333333vh !important;
        }

        /* keep the preview card position like the good 75% screenshot */
        .builder-right-preview-panel .preview-pane-container.real-template-mode {
            margin-top: 82px !important;
        }

        @media (max-width: 1024px) {
            body {
                zoom: 1 !important;
                width: 100% !important;
                height: auto !important;
                min-width: 0 !important;
                min-height: 0 !important;
                overflow: auto !important;
            }

            body > nav,
            body > .flex.flex-grow,
            body > .flex.flex-grow > div:first-child,
            .builder-right-preview-panel {
                height: auto !important;
                min-height: auto !important;
            }
        }



        /* GHOST FINAL LABEL/TOP TEXT SIZE ONLY - requested screenshot words */
        body > .flex.flex-grow > div:first-child h1 {
            font-size: 52px !important;
            line-height: 1.08 !important;
            letter-spacing: -0.055em !important;
            font-weight: 950 !important;
        }

        body > .flex.flex-grow > div:first-child h1 + p {
            font-size: 25px !important;
            line-height: 1.35 !important;
            font-weight: 500 !important;
        }

        body > .flex.flex-grow > div:first-child p.text-red-500 {
            font-size: 20px !important;
            line-height: 1.25 !important;
            font-weight: 850 !important;
        }

        #contactForm .form-label {
            font-size: 18px !important;
            line-height: 1.2 !important;
            font-weight: 850 !important;
            margin-bottom: 10px !important;
            white-space: nowrap !important;
        }
</style>

<style id="ghost-final-contact-label-size-like-workhistory">
    /* GHOST FINAL: Contact labels same size as Work History labels */
    form#contactForm label.form-label,
    #contactForm .form-label,
    .contact-final-layout label.form-label,
    body form#contactForm .form-label {
        font-size: 22px !important;
        line-height: 1.1 !important;
        font-weight: 950 !important;
        color: #071022 !important;
        letter-spacing: 0 !important;
        margin-bottom: 9px !important;
        white-space: nowrap !important;
        display: block !important;
    }

    /* Keep required star same label size */
    form#contactForm label.form-label *,
    #contactForm .form-label * {
        font-size: inherit !important;
        line-height: inherit !important;
        font-weight: inherit !important;
    }

    /* Make Resume Builder logo text and icon white only */
    body > nav .text-xl,
    body > nav .text-xl span,
    body > nav .text-xl div,
    body > nav .text-xl i,
    body > nav .fa-layer-group {
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
        background: none !important;
        -webkit-background-clip: initial !important;
        background-clip: initial !important;
        text-shadow: none !important;
        filter: none !important;
    }
</style>


<style id="ghost-contact-required-red-border-strong-final">
    /* Required (*) contact fields: Work History style red border + red text */
    #contactForm input.form-input.contact-field-error,
    #contactForm input.form-input.contact-field-error:focus,
    body #contactForm input.form-input.contact-field-error {
        border: 2px solid #ef4444 !important;
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 1px rgba(239, 68, 68, .18) !important;
        background: #ffffff !important;
    }

    #contactForm .contact-field-error-text {
        display: block !important;
        min-height: 18px !important;
        margin-top: 8px !important;
        color: #dc2626 !important;
        font-size: 14px !important;
        line-height: 1.2 !important;
        font-weight: 900 !important;
        letter-spacing: .01em !important;
    }
</style>
</head>
<body class="bg-white font-sans text-gray-900 h-screen overflow-hidden flex flex-col">
    <nav class="bg-[#0F172A] border-b border-gray-700 py-2.5 px-8 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div class="flex items-center space-x-6">
            <div class="text-xl font-black text-white tracking-tight flex items-center cursor-pointer">
                <i class="fa-solid fa-layer-group text-pink-500 mr-2"></i> ResumeBuilder
            </div>
        </div>
        <div class="flex items-center space-x-8 text-xs font-bold uppercase tracking-wide text-gray-400">
            <div class="text-pink-500 border-b-2 border-pink-500 pb-2 -mb-2.5 transition cursor-pointer">Contact</div>
            <div class="hover:text-white transition cursor-not-allowed opacity-50">Education</div>
            <div class="hover:text-white transition cursor-not-allowed opacity-50">Experience</div>
            <div class="hover:text-white transition cursor-not-allowed opacity-50">Skills</div>
            <div class="hover:text-white transition cursor-not-allowed opacity-50">Summary</div>
        </div>
        <div class="flex items-center space-x-3 text-white">
            <div class="relative w-10 h-10 flex items-center justify-center">
                <svg class="w-full h-full" viewBox="0 0 36 36">
                    <path class="text-gray-700 stroke-current" stroke-width="2" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <path id="progressCircle" class="text-pink-500 stroke-current" stroke-width="2" stroke-linecap="round" fill="none" stroke-dasharray="100, 100" stroke-dashoffset="100" style="transition: stroke-dashoffset 0.5s ease;" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                </svg>
                <div class="absolute font-bold text-xs" id="progressText">0%</div>
            </div>
            <div class="text-xs font-semibold">Resume Completeness</div>
        </div>
    </nav>

    <div class="flex flex-grow overflow-hidden relative">
        <div class="w-full lg:w-[62%] bg-gray-50 overflow-y-auto p-8 lg:px-16 pb-40">
            <div class="max-w-2xl mx-auto">
                <a href="/upload-or-scratch" class="text-blue-700 font-bold flex items-center mb-4 hover:underline w-fit text-xs tracking-wide">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i> Go Back
                </a>
                <h1 class="text-[25px] font-black mb-0.5 leading-tight tracking-tight text-gray-900">What's the best way for employers to contact you?</h1>
                <p class="text-gray-500 mb-5 text-[14px]">We suggest including an email and phone number.</p>
                <p class="text-[11px] font-bold text-red-500 mb-3">* indicates a required field</p>
                
                <form id="contactForm" class="space-y-3.5 contact-final-layout">
                    <div class="flex gap-4 contact-row contact-two-col-row">
                        <div class="w-1/2 contact-col">
                            <label class="form-label">First Name *</label>
                            <input type="text" id="inp_fname" class="form-input" placeholder="e.g. Armaghan" required>
                            <small class="contact-field-error-text" id="inp_fname_error"></small>
                        </div>
                        <div class="w-1/2 contact-col">
                            <label class="form-label">Last Name *</label>
                            <input type="text" id="inp_lname" class="form-input" placeholder="e.g. Shahzad" required>
                            <small class="contact-field-error-text" id="inp_lname_error"></small>
                        </div>
                    </div>

                    <div class="flex gap-4 contact-row contact-two-col-row">
                        <div class="w-1/2 contact-col">
                            <label class="form-label">City</label>
                            <input type="text" id="inp_city" class="form-input" placeholder="e.g. Talagang">
                        </div>
                        <div class="w-1/2 contact-col">
                            <label class="form-label">Postal Code</label>
                            <input type="text" id="inp_postal" class="form-input" placeholder="e.g. 25000">
                        </div>
                    </div>

                    <div class="contact-full-row">
                        <label class="form-label">Email *</label>
                        <input type="email" id="inp_email" class="form-input bg-blue-50/50" placeholder="your.email@example.com" required>
                        <small class="contact-field-error-text" id="inp_email_error"></small>
                    </div>
                    
                    <div class="flex gap-4 contact-row contact-two-col-row">
                        <div class="w-1/2 contact-col relative">
                            <label class="form-label">Phone</label>
                            <div class="flex">
                                <input type="hidden" id="inp_country_code" value="">
                                <input type="tel" id="inp_phone" class="form-input" style="border-radius: 8px; width: 100%;" placeholder="0300 1234567">
                            </div>
                        </div>
                        <div class="w-1/2 contact-col">
                            <label class="form-label">Country</label>
                            <input type="text" id="inp_country" class="form-input" placeholder="e.g. Pakistan">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="builder-right-preview-panel hidden lg:flex w-[38%] bg-[#f3f4f6] border-l border-gray-200 flex-col items-center justify-center overflow-hidden pt-5 pb-24 select-none">
            <div id="selectedTemplateBadge" class="w-full max-w-sm bg-white border border-slate-200 rounded-2xl shadow-sm p-3 mb-4 hidden">
                <div class="flex items-center gap-3">
                    <div class="selected-template-badge-frame">
                        <img id="selectedTemplateThumb" src="" alt="Selected Template">
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-black text-pink-500 uppercase tracking-widest">Selected Template</p>
                        <h4 id="selectedTemplateName" class="text-sm font-black text-slate-900 truncate">Template</h4>
                        <p id="selectedTemplateCategory" class="text-xs font-bold text-slate-500">Category</p>
                        <p class="text-[10px] font-bold text-slate-400 mt-1">This preview follows your selected design.</p>
                    </div>
                </div>
            </div>
<div class="preview-pane-container real-template-mode">
    <div id="modernLivePreview" class="modern-live-preview" data-layout="modern_sidebar">
        <aside class="mlp-sidebar">
            <div class="mlp-avatar"><i class="fa-solid fa-user"></i></div>

            <div>
                <div class="mlp-side-title">Contact</div>
                <div class="mlp-side-text">
                    <div id="prev_phone">Phone</div>
                    <div id="prev_email">Email</div>
                    <div><span id="prev_city">City</span>, <span id="prev_country">Country</span> <span id="prev_postal"></span></div>
                </div>
            </div>

            <div>
                <div class="mlp-side-title">Skills</div>
                <span class="mlp-skill-pill">Communication</span>
                <span class="mlp-skill-pill">Teamwork</span>
                <span class="mlp-skill-pill">Problem Solving</span>
            </div>

            <div>
                <div class="mlp-side-title">Languages</div>
                <div class="mlp-side-text">English<br>Urdu</div>
            </div>
        </aside>

        <main class="mlp-main">
            <h1 id="prev_name" class="mlp-name">Your Name</h1>
            <div class="mlp-role">Student Resume</div>

            <p class="mlp-summary">
                Motivated student with strong communication, learning ability and interest in professional growth.
            </p>

            <section class="mlp-section">
                <div class="mlp-section-title">Education</div>
                <div class="mlp-item-title" id="shared_preview_school">Institution Name</div>
                <div class="mlp-item-meta" id="shared_preview_degree">Degree, Field of Study</div>
                <div class="mlp-item-text" id="shared_preview_year">Graduation Year</div>
            </section>

            <section class="mlp-section">
                <div class="mlp-section-title">Experience</div>
                <div class="mlp-item-title">Project / Internship</div>
                <div class="mlp-item-meta">Role or achievement</div>
                <div class="mlp-item-text">Add your experience in the next steps. This layout will stay editable.</div>
            </section>
        </main>
    </div>
</div>
            <div class="w-full max-w-sm flex justify-center gap-3 px-6 mt-5 z-30">
                <button id="btnPreview" class="px-6 py-2 bg-white border-2 border-slate-800 text-slate-800 font-extrabold rounded-full hover:bg-slate-50 transition text-[11px] uppercase tracking-wide min-w-[110px]">
                    Preview
                </button>
                <button id="btnNext" class="px-8 py-2 bg-pink-500 text-white font-extrabold rounded-full shadow hover:bg-pink-600 transition text-[11px] uppercase tracking-wide min-w-[130px]">
                    Work History
                </button>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 right-0 left-0 bg-[#0F172A] border-t border-gray-800 py-3.5 px-8 flex justify-between items-center z-40 text-[11px] font-bold text-gray-400 select-none">
        <div class="flex space-x-6">
            <a href="/legal#terms" target="_blank" class="hover:text-pink-500 transition">TERMS & CONDITIONS</a>
            <span class="text-gray-700">|</span>
            <a href="/legal#privacy" target="_blank" class="hover:text-pink-500 transition">PRIVACY POLICY</a>
            <span class="text-gray-700">|</span>
            <a href="/legal#accessibility" target="_blank" class="hover:text-pink-500 transition">ACCESSIBILITY</a>
            <span class="text-gray-700">|</span>
            <a href="/legal#contact" target="_blank" class="hover:text-pink-500 transition">CONTACT US</a>
        </div>
        <div class="text-gray-500"><br><br>
            &copy; 2026, Bold Limited. All rights reserved.
        </div>
    </div>


    

    <div id="previewModal" class="fixed inset-0 hidden items-center justify-center">
        <div class="preview-modal-shell animation-fade-in">
            <div class="preview-modal-header flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-black text-gray-900">Preview & Customize</h2>
                    <p id="modalSelectedTemplateText" class="text-xs font-bold text-slate-500 mt-1">Current: Selected Template</p>
                </div>
                <button id="closePreviewTop" type="button" class="text-gray-400 hover:text-red-500 text-2xl transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="preview-modal-body">
                <div class="preview-left-panel">
                    <div class="modal-selected-template-strip">
                        <div class="modal-selected-template-large-frame">
                            <img id="modalCurrentTemplateLargeImg" src="" alt="Selected Template Preview">
                            <div id="modalCurrentTemplateLargeFallback" class="template-image-fallback hidden"><i class="fa-solid fa-image text-xl mb-1"></i>Template preview not found</div>
                        </div>
                        <div class="min-w-0 flex flex-col justify-center">
                            <p class="text-[10px] font-black text-pink-500 uppercase tracking-[0.20em]">Selected template preview</p>
                            <h3 id="modalLargeTemplateName" class="text-lg font-black text-slate-950 truncate mt-1">Selected Template</h3>
                            <p id="modalLargeTemplateCategory" class="text-xs font-bold text-slate-500 mt-1">Professional</p>
                            <p class="text-[11px] text-slate-500 font-semibold mt-3 leading-relaxed">The selected template stays visible here. Pick another template from the right side and press Change template.</p>
                        </div>
                    </div>
                    <div class="preview-paper-stage">
                        <div class="template-full-view-card">
                            <div class="flex items-center justify-between mb-2 flex-shrink-0">
                                <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Full template view</p>
                                <span class="text-[10px] font-black text-pink-500">Selected</span>
                            </div>
                            <div class="template-full-view-frame">
                                <img id="modalFullTemplateImg" src="" alt="Full Selected Template">
                                <div id="modalFullTemplateFallback" class="template-image-fallback hidden"><i class="fa-solid fa-file-image text-xl mb-1"></i>Full template preview</div>
                            </div>
                        </div>
                        <div class="preview-paper-wrap">
                            <div class="exact-template-preview big" id="bigPreviewPaper">
                                <img id="liveTemplateBgModal" class="exact-template-bg" src="" alt="Selected Template Large Live Preview">
                                <div id="liveTemplateBgModalFallback" class="exact-template-fallback hidden">
                                    <div><i class="fa-solid fa-file-image text-3xl mb-2"></i><br>Selected template preview will appear here</div>
                                </div>
                                <div class="exact-live-text-layer">
                                    <div class="exact-live-chip exact-live-name prev_name_big">YOUR NAME</div>
                                    <div class="exact-live-chip exact-live-contact">
                                        <span class="prev_city_big">City</span>, <span class="prev_country_big">Country</span> |
                                        <span class="prev_phone_big">Phone</span> |
                                        <span class="prev_email_big theme-text">Email</span>
                                    </div>
                                    <div class="exact-live-chip exact-live-section theme-text">Contact</div>
                                    <div class="exact-live-chip exact-live-info">Live data is layered over your selected PNG template.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="template-side-panel">
                    <div class="p-4 border-b border-gray-100 flex-shrink-0">
                        <div class="modal-current-template-card flex items-center gap-3 mb-4">
                            <img id="modalCurrentTemplateImg" src="" class="modal-current-template-img" alt="Current Template">
                            <div class="min-w-0">
                                <p class="text-[10px] font-black text-pink-500 uppercase tracking-widest">Already selected</p>
                                <h3 id="modalCurrentTemplateName" class="text-sm font-black text-slate-900 truncate">Selected Template</h3>
                                <p id="modalCurrentTemplateCategory" class="text-xs font-bold text-slate-500">Professional</p>
                            </div>
                        </div>
                        <h3 class="text-sm font-black text-gray-800 mb-3 uppercase tracking-wider">Colors</h3>
                        <div class="flex gap-3 flex-wrap">
                            <button type="button" data-color="#1e293b" class="w-8 h-8 rounded-full bg-[#1e293b] color-btn ring-2 ring-offset-2 ring-transparent" title="Slate"></button>
                            <button type="button" data-color="#2563eb" class="w-8 h-8 rounded-full bg-[#2563eb] color-btn ring-2 ring-offset-2 ring-transparent" title="Blue"></button>
                            <button type="button" data-color="#0891b2" class="w-8 h-8 rounded-full bg-[#0891b2] color-btn ring-2 ring-offset-2 ring-transparent" title="Cyan"></button>
                            <button type="button" data-color="#059669" class="w-8 h-8 rounded-full bg-[#059669] color-btn ring-2 ring-offset-2 ring-transparent" title="Emerald"></button>
                            <button type="button" data-color="#16a34a" class="w-8 h-8 rounded-full bg-[#16a34a] color-btn ring-2 ring-offset-2 ring-transparent" title="Green"></button>
                            <button type="button" data-color="#dc2626" class="w-8 h-8 rounded-full bg-[#dc2626] color-btn ring-2 ring-offset-2 ring-transparent" title="Red"></button>
                            <button type="button" data-color="#e11d48" class="w-8 h-8 rounded-full bg-[#e11d48] color-btn ring-2 ring-offset-2 ring-transparent" title="Rose"></button>
                            <button type="button" data-color="#7c3aed" class="w-8 h-8 rounded-full bg-[#7c3aed] color-btn ring-2 ring-offset-2 ring-transparent" title="Violet"></button>
                            <button type="button" data-color="#db2777" class="w-8 h-8 rounded-full bg-[#db2777] color-btn ring-2 ring-offset-2 ring-transparent" title="Pink"></button>
                            <button type="button" data-color="#f59e0b" class="w-8 h-8 rounded-full bg-[#f59e0b] color-btn ring-2 ring-offset-2 ring-transparent" title="Amber"></button>
                            <button type="button" data-color="#ea580c" class="w-8 h-8 rounded-full bg-[#ea580c] color-btn ring-2 ring-offset-2 ring-transparent" title="Orange"></button>
                            <button type="button" data-color="#111827" class="w-8 h-8 rounded-full bg-[#111827] color-btn ring-2 ring-offset-2 ring-transparent" title="Black"></button>
                        </div>
                    </div>
                    <div class="template-panel-scroll-area">
                        <div class="flex justify-between items-end gap-3 mb-3 flex-shrink-0">
                            <div>
                                <h3 class="text-sm font-black text-gray-800 uppercase tracking-wider">Templates</h3>
                                <p class="text-[11px] font-bold text-slate-500">Selected template stays on top. Select one, then click Change template.</p>
                            </div>
                            <select id="templateSortSelect" class="border border-slate-200 rounded-lg px-2 py-1 text-xs font-bold outline-none focus:border-pink-400">
                                <option value="selected">Selected first</option>
                                <option value="name">Name A-Z</option>
                                <option value="category">Category</option>
                            </select>
                        </div>
                        <div id="dynamicTemplatesGrid" class="grid grid-cols-2 gap-3 template-preview-scroll">
                            <div class="text-center text-sm text-gray-400 py-10 w-full col-span-2"><i class="fa-solid fa-spinner fa-spin"></i> Loading templates...</div>
                        </div>
                    </div>
                    <div class="modal-action-footer">
                        <button id="closePreviewBtn" type="button" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-full hover:bg-gray-100 transition shadow-sm">Close preview</button>
                        <button id="changeTemplateBtn" type="button" class="px-6 py-2.5 bg-pink-600 text-white font-bold rounded-full shadow hover:bg-pink-700 transition">Change template</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const token = localStorage.getItem('resume_token');
        const resumeId = localStorage.getItem('current_resume_id');
        if (!token || !resumeId) window.location.href = '/login';

        // Pointers for Inputs
        const inps = {
            fname: document.getElementById('inp_fname'),
            lname: document.getElementById('inp_lname'),
            city: document.getElementById('inp_city'),
            postal: document.getElementById('inp_postal'),
            country: document.getElementById('inp_country'),
            phoneCode: document.getElementById('inp_country_code'),
            phone: document.getElementById('inp_phone'),
            email: document.getElementById('inp_email'),
        };

        // Pointers for Preview Elements
        const prevs = {
            name: document.getElementById('prev_name'),
            city: document.getElementById('prev_city'),
            postal: document.getElementById('prev_postal'),
            country: document.getElementById('prev_country'),
            phone: document.getElementById('prev_phone'),
            email: document.getElementById('prev_email'),
        };

        // Pointer for Circular Slider
        const progressCircle = document.getElementById('progressCircle');
        const progressText = document.getElementById('progressText');

        // Step 1: User data fetch karein aur Saved fields populate karein (Data Persistence)
        async function loadResumeData() {
            try {
                // Node.js Backend API Call `getResume` humne banayi thi
                const res = await fetch(`https://resume-backend-54se.onrender.com/api/resumes/get/${resumeId}`, {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                const data = await res.json();
                if (data.success && data.resume) {
                    const r = data.resume;
                    applySelectedTemplateBadge(r);
                    inps.fname.value = r.first_name || '';
                    inps.lname.value = r.last_name || '';
                    inps.city.value = r.city || '';
                    inps.postal.value = r.postal_code || '';
                    inps.country.value = r.country || '';
                    
                    // Phone logic (Simple split Implementation here)
                    if(r.phone) {
                        let parts = r.phone.split(" ");
                        if(parts.length > 1 && parts[0].includes("+")) {
                            inps.phoneCode.value = parts[0];
                            inps.phone.value = parts.slice(1).join(" ");
                        } else {
                            inps.phone.value = r.phone;
                        }
                    }
                    
                    // Email logic (Custom Email first, then fallback to auth profile)
                    if(r.email) inps.email.value = r.email;
                    
                    // Agar resume me Name available nahi hai, tabhi auth profile fetch karein fallback ke liye
                    if (!r.first_name && !r.email) {
                        const profileRes = await fetch('https://resume-backend-54se.onrender.com/api/auth/profile', {
                            headers: { 'Authorization': 'Bearer ' + token }
                        });
                        const profileData = await profileRes.json();
                        if(profileData.success) {
                            inps.email.value = profileData.user.email;
                            let parts = profileData.user.name.split(" ");
                            inps.fname.value = parts[0] || '';
                            inps.lname.value = parts.slice(1).join(" ") || '';
                        }
                    }
                    updateAllPreviews(); // Form fill hone ke baad preview aur slider update karein
                }
            } catch(e) {
                console.error("Error loading resume data:", e);
            }
        }

        loadResumeData();
function getTemplateImageUrl(thumbnail) {
    if (!thumbnail) return "";

    if (thumbnail.startsWith("http://") || thumbnail.startsWith("https://")) {
        return thumbnail;
    }

    if (thumbnail.startsWith("/uploads")) {
        return "https://resume-backend-54se.onrender.com" + thumbnail;
    }

    return "https://resume-backend-54se.onrender.com/uploads/templates/" + thumbnail;
}

function setSelectedTemplateLivePreview(thumbnail) {
    const img = document.getElementById("selectedTemplateLiveImage");
    const fallback = document.getElementById("selectedTemplateLiveFallback");

    if (!img || !fallback) return;

    const imageUrl = getTemplateImageUrl(thumbnail);

    if (!imageUrl) {
        img.classList.add("hidden");
        fallback.classList.remove("hidden");
        return;
    }

    img.onload = function () {
        img.classList.remove("hidden");
        fallback.classList.add("hidden");
    };

    img.onerror = function () {
        console.error("Template image failed:", imageUrl);
        img.classList.add("hidden");
        fallback.classList.remove("hidden");
    };

    img.src = imageUrl;
}

function applySelectedTemplateBadge(resume) {
    const badge = document.getElementById("selectedTemplateBadge");
    const thumb = document.getElementById("selectedTemplateThumb");
    const name = document.getElementById("selectedTemplateName");
    const category = document.getElementById("selectedTemplateCategory");

    if (!badge || !thumb || !name || !category || !resume) return;

    const thumbnail = resume.template_thumbnail_url || resume.thumbnail_url || "";
    const templateName = resume.template_name || resume.name || "Selected Template";
    const templateCategory = resume.template_category || resume.category || "Professional";
    const imageUrl = getTemplateImageUrl(thumbnail);

    name.textContent = templateName;
    category.textContent = templateCategory;

    thumb.onerror = function () {
        console.error("Badge image failed:", imageUrl);
        this.src = "data:image/svg+xml;utf8," + encodeURIComponent(`
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="150">
                <rect width="100%" height="100%" fill="#f1f5f9"/>
                <text x="50%" y="46%" text-anchor="middle" font-size="12" fill="#64748b" font-family="Arial" font-weight="700">Selected</text>
                <text x="50%" y="59%" text-anchor="middle" font-size="12" fill="#64748b" font-family="Arial" font-weight="700">Template</text>
            </svg>
        `);
        this.onerror = null;
    };

    if (imageUrl) {
        thumb.src = imageUrl;
    }

    setSelectedTemplateLivePreview(thumbnail);
    badge.classList.remove("hidden");

    if (typeof updateModalCurrentTemplateInfo === "function") {
        updateModalCurrentTemplateInfo(resume);
    }
}

async function updateSelectedTemplateFromPreview(template) {
    if (!template || !template.template_key) {
        alert("Template key missing.");
        return;
    }

    try {
        const res = await fetch("https://resume-backend-54se.onrender.com/api/resumes/update-template", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify({
                resume_id: resumeId,
                template_id: template.template_key
            })
        });

        const data = await res.json();

        if (data.success && data.resume) {
            localStorage.setItem("selected_template", template.template_key);

            applySelectedTemplateBadge(data.resume);

            document.querySelectorAll(".preview-template-card").forEach(card => {
                card.classList.remove("border-pink-500", "bg-pink-50");
                card.classList.add("border-transparent");
            });

            const activeCard = document.querySelector(`[data-preview-template="${template.template_key}"]`);
            if (activeCard) {
                activeCard.classList.remove("border-transparent");
                activeCard.classList.add("border-pink-500", "bg-pink-50");
            }

            alert("Template changed successfully.");
        } else {
            alert(data.message || "Template update failed.");
        }
    } catch (error) {
        console.error("Template update error:", error);
        alert("Server error while updating template.");
    }
}

        // Step 2: Slider Logic & Previews Update
        function updateSlider(percentage) {
            percentage = Math.min(100, Math.max(0, percentage)); // Clamp between 0-100
            const circumference = 2 * Math.PI * 15.9155; // circumference of circle in SVG
            const offset = circumference - (percentage / 100 * circumference);
            
            // stroke-dashoffset animate karein (CSS me delay laga hua ha)
            progressCircle.style.strokeDashoffset = offset;
            progressText.innerText = Math.round(percentage) + '%';
        }

        // Calculate Resume Form Progress Tracker Context
        function calculateCompleteness() {
            let majorFields = ['fname', 'lname', 'email', 'phone'];
            let filledCount = majorFields.filter(f => inps[f].value.trim() !== '').length;
            let stepPercentage = (filledCount / majorFields.length) * 30; // 30% max for this step
            updateSlider(stepPercentage);
        }

        // Live Typing Binding (Pixel Perfect implementation)
        function updateAllPreviews() {
            let fullName = (inps.fname.value + " " + inps.lname.value).trim();
            prevs.name.innerText = fullName || "YOUR NAME";
            prevs.city.innerText = inps.city.value || "City";
            prevs.postal.innerText = inps.postal.value ? inps.postal.value : "";
            prevs.country.innerText = inps.country.value || "Country";
            prevs.phone.innerText = (inps.phone.value) ? inps.phoneCode.value + " " + inps.phone.value : "Phone";
            prevs.email.innerText = inps.email.value || "Email";
            calculateCompleteness(); // Har update par compleatness bhi update karein
        }

        // Add listeners to all inputs for real-time update
        Object.values(inps).forEach(input => {
            input.addEventListener('input', updateAllPreviews);
        });

        // Step 3: Next Button -> Backend API Save -> Move to Next Form
        const btnNext = document.getElementById('btnNext');
        btnNext.addEventListener('click', async (e) => {
            e.preventDefault();
            
            // Basic validation
            if(!inps.fname.value || !inps.email.value) {
                showContactRequiredPopup && showContactRequiredPopup();
                return;
            }
            btnNext.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...';
            btnNext.disabled = true;
            
            const payload = {
                resume_id: resumeId,
                first_name: inps.fname.value,
                last_name: inps.lname.value,
                city: inps.city.value,
                postal_code: inps.postal.value,
                country: inps.country.value,
                phone: inps.phoneCode.value + " " + inps.phone.value, // Save code + number
                email: inps.email.value // Custom email save (Backend controller accepts this now)
            };
            try {
                // API Call
                const res = await fetch('https://resume-backend-54se.onrender.com/api/resumes/update-contact', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if(data.success) {
                    window.location.href = "/builder/work-history"; // Proceed to work history question
                } else {
                    alert(data.message);
                    resetBtn();
                }
            } catch(e) {
                alert("Server error.");
                resetBtn();
            }
        });

        function resetBtn() {
            btnNext.innerHTML = 'Next: Education';
            btnNext.disabled = false;
        }


        // --- FINAL PREVIEW MODAL LOGIC: no page-scroll issue, selected template top, modal selection, color sync ---
        const previewModal = document.getElementById('previewModal');
        const openPreviewBtn = document.getElementById('btnPreview');
        const closePreviewBtn = document.getElementById('closePreviewBtn');
        const closePreviewTop = document.getElementById('closePreviewTop');
        const dynamicTemplatesGrid = document.getElementById('dynamicTemplatesGrid');
        const templateSortSelect = document.getElementById('templateSortSelect');
        const changeTemplateBtn = document.getElementById('changeTemplateBtn');
        let previewTemplatesCache = [];
        let pendingPreviewTemplate = null;

        function getTemplateKeyValue(template) {
            return template?.template_key || String(template?.id || '');
        }
        function getTemplateImageUrl(thumbnail) {
            if (!thumbnail) return '';
            return thumbnail.startsWith('http') ? thumbnail : 'https://resume-backend-54se.onrender.com' + thumbnail;
        }
        function setImageOrFallback(img, fallback, thumbnail) {
            if (!img) return;
            const imageUrl = getTemplateImageUrl(thumbnail);
            if (!imageUrl) {
                img.classList.add('hidden');
                if (fallback) fallback.classList.remove('hidden');
                return;
            }
            img.classList.remove('hidden');
            if (fallback) fallback.classList.add('hidden');
            img.onerror = function () {
                this.classList.add('hidden');
                if (fallback) fallback.classList.remove('hidden');
            };
            img.src = imageUrl;
        }

        function setExactLiveTemplateBackground(thumbnail) {
            const miniImg = document.getElementById('liveTemplateBgMini');
            const miniFallback = document.getElementById('liveTemplateBgMiniFallback');
            const modalImg = document.getElementById('liveTemplateBgModal');
            const modalFallback = document.getElementById('liveTemplateBgModalFallback');

            if (typeof setImageOrFallback === 'function') {
                setImageOrFallback(miniImg, miniFallback, thumbnail);
                setImageOrFallback(modalImg, modalFallback, thumbnail);
                return;
            }

            const imageUrl = thumbnail && thumbnail.startsWith('http') ? thumbnail : (thumbnail ? 'https://resume-backend-54se.onrender.com' + thumbnail : '');
            [
                [miniImg, miniFallback],
                [modalImg, modalFallback]
            ].forEach(([img, fallback]) => {
                if (!img) return;
                if (!imageUrl) {
                    img.classList.add('hidden');
                    if (fallback) fallback.classList.remove('hidden');
                    return;
                }
                img.classList.remove('hidden');
                if (fallback) fallback.classList.add('hidden');
                img.onerror = function () {
                    this.classList.add('hidden');
                    if (fallback) fallback.classList.remove('hidden');
                };
                img.src = imageUrl;
            });
        }

        function getActiveTemplateKey() {
            return localStorage.getItem('selected_template') || '';
        }
        function applySelectedTemplateBadge(resume) {
            const badge = document.getElementById('selectedTemplateBadge');
            const thumb = document.getElementById('selectedTemplateThumb');
            const name = document.getElementById('selectedTemplateName');
            const category = document.getElementById('selectedTemplateCategory');
            if (!badge || !thumb || !name || !category || !resume) return;
            const thumbnail = resume.template_thumbnail_url || resume.thumbnail_url;
            const templateName = resume.template_name || resume.name || 'Selected Template';
            const templateCategory = resume.template_category || resume.category || 'Professional';
            name.textContent = templateName;
            category.textContent = templateCategory;
            thumb.onerror = function () {
                this.src = 'data:image/svg+xml;utf8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="120" height="150"><rect width="100%" height="100%" fill="#f1f5f9"/><text x="50%" y="46%" text-anchor="middle" font-size="12" fill="#64748b" font-family="Arial" font-weight="700">Selected</text><text x="50%" y="59%" text-anchor="middle" font-size="12" fill="#64748b" font-family="Arial" font-weight="700">Template</text></svg>');
                this.onerror = null;
            };
            const badgeImageUrl = getTemplateImageUrl(thumbnail);
            if (badgeImageUrl) {
                thumb.src = badgeImageUrl;
            } else {
                thumb.src = 'data:image/svg+xml;utf8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="120" height="150"><rect width="100%" height="100%" fill="#f1f5f9"/><text x="50%" y="46%" text-anchor="middle" font-size="12" fill="#64748b" font-family="Arial" font-weight="700">Selected</text><text x="50%" y="59%" text-anchor="middle" font-size="12" fill="#64748b" font-family="Arial" font-weight="700">Template</text></svg>');
            }
            badge.classList.remove('hidden');
            setExactLiveTemplateBackground(thumbnail);
        }
        function updateModalCurrentTemplateInfo(templateOrResume = null) {
            const name = templateOrResume?.template_name || templateOrResume?.name || document.getElementById('selectedTemplateName')?.textContent || 'Selected Template';
            const category = templateOrResume?.template_category || templateOrResume?.category || document.getElementById('selectedTemplateCategory')?.textContent || 'Professional';
            const thumbnail = templateOrResume?.template_thumbnail_url || templateOrResume?.thumbnail_url || document.getElementById('selectedTemplateThumb')?.src || '';
            ['modalCurrentTemplateName','modalLargeTemplateName'].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = name; });
            ['modalCurrentTemplateCategory','modalLargeTemplateCategory'].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = category; });
            const textNode = document.getElementById('modalSelectedTemplateText');
            if (textNode) textNode.textContent = 'Current: ' + name + ' • ' + category;
            setImageOrFallback(document.getElementById('modalCurrentTemplateImg'), null, thumbnail);
            setImageOrFallback(document.getElementById('modalCurrentTemplateLargeImg'), document.getElementById('modalCurrentTemplateLargeFallback'), thumbnail);
            setImageOrFallback(document.getElementById('modalFullTemplateImg'), document.getElementById('modalFullTemplateFallback'), thumbnail);
            setExactLiveTemplateBackground(thumbnail);
        }
        function sortTemplatesForPreview(templates) {
            const sortMode = templateSortSelect?.value || 'selected';
            const active = getActiveTemplateKey();
            const pending = getTemplateKeyValue(pendingPreviewTemplate);
            return [...templates].sort((a, b) => {
                const ak = getTemplateKeyValue(a), bk = getTemplateKeyValue(b);
                if (pending && ak === pending && bk !== pending) return -1;
                if (pending && bk === pending && ak !== pending) return 1;
                if (active && ak === active && bk !== active) return -1;
                if (active && bk === active && ak !== active) return 1;
                if (sortMode === 'name') return String(a.name || '').localeCompare(String(b.name || ''));
                if (sortMode === 'category') return String(a.category || '').localeCompare(String(b.category || ''));
                return 0;
            });
        }
        function renderPreviewTemplates() {
            if (!dynamicTemplatesGrid) return;
            const templates = sortTemplatesForPreview(previewTemplatesCache);
            const active = getActiveTemplateKey();
            const pending = getTemplateKeyValue(pendingPreviewTemplate);
            dynamicTemplatesGrid.innerHTML = '';
            if (!templates.length) {
                dynamicTemplatesGrid.innerHTML = '<div class="text-center text-sm text-gray-400 py-10 w-full col-span-2">No templates found.</div>';
                return;
            }
            templates.forEach(tpl => {
                const key = getTemplateKeyValue(tpl);
                const isActive = active && key === active;
                const isPending = pending && key === pending;
                const card = document.createElement('div');
                card.dataset.previewTemplate = key;
                card.className = 'preview-template-card ' + (isPending ? 'pending-template-card' : isActive ? 'selected-template-card' : '');
                card.innerHTML = `
                    ${isPending ? '<span class="template-status-pill pending">Selected now</span>' : isActive ? '<span class="template-status-pill">Already selected</span>' : ''}
                    <div class="template-thumb-frame">
                        <img src="${getTemplateImageUrl(tpl.thumbnail_url)}" alt="${tpl.name || 'Template'}" onerror="this.classList.add('hidden'); this.parentElement.querySelector('.template-image-fallback').classList.remove('hidden');">
                        <div class="template-image-fallback hidden"><i class="fa-solid fa-image text-lg mb-1"></i>Preview not found</div>
                    </div>
                    <p class="text-center text-xs font-black mt-2 text-gray-800 truncate">${tpl.name || 'Template'}</p>
                    <p class="text-center text-[10px] font-black text-pink-500 uppercase tracking-wider">${tpl.category || 'Professional'}</p>
                `;
                card.addEventListener('click', () => {
                    pendingPreviewTemplate = tpl;
                    updateModalCurrentTemplateInfo(tpl);
                    renderPreviewTemplates();
                });
                dynamicTemplatesGrid.appendChild(card);
            });
        }
        async function loadResumeTemplateForModal() {
            try {
                const res = await fetch(`https://resume-backend-54se.onrender.com/api/resumes/get/${resumeId}`, { headers: { 'Authorization': 'Bearer ' + token } });
                const data = await res.json();
                if (data.success && data.resume) {
                    if (data.resume.template_key || data.resume.template_id) localStorage.setItem('selected_template', data.resume.template_key || data.resume.template_id);
                    applySelectedTemplateBadge(data.resume);
                    updateModalCurrentTemplateInfo(data.resume);
                }
            } catch (e) { console.error('Template resume load failed:', e); }
        }
        async function confirmTemplateChangeFromPreview() {
            if (!pendingPreviewTemplate || !getTemplateKeyValue(pendingPreviewTemplate)) {
                alert('Please select a template first.');
                return;
            }
            const oldHtml = changeTemplateBtn.innerHTML;
            changeTemplateBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Updating...';
            changeTemplateBtn.disabled = true;
            try {
                const res = await fetch('https://resume-backend-54se.onrender.com/api/resumes/update-template', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
                    body: JSON.stringify({ resume_id: resumeId, template_id: getTemplateKeyValue(pendingPreviewTemplate) })
                });
                const data = await res.json();
                if (data.success && data.resume) {
                    localStorage.setItem('selected_template', getTemplateKeyValue(pendingPreviewTemplate));
                    applySelectedTemplateBadge(data.resume);
                    updateModalCurrentTemplateInfo(data.resume);
                    pendingPreviewTemplate = null;
                    renderPreviewTemplates();
                } else {
                    alert(data.message || 'Template update failed.');
                }
            } catch (error) {
                console.error('Template update error:', error);
                alert('Server error while updating template.');
            } finally {
                changeTemplateBtn.innerHTML = oldHtml;
                changeTemplateBtn.disabled = false;
            }
        }
        function syncBigPreviewContact() {
            document.querySelector('.prev_name_big').innerText = (inps.fname.value + ' ' + inps.lname.value).trim() || 'YOUR NAME';
            document.querySelector('.prev_email_big').innerText = inps.email.value || 'Email';
            document.querySelector('.prev_city_big').innerText = inps.city.value || 'City';
            document.querySelector('.prev_phone_big').innerText = inps.phone.value ? inps.phoneCode.value + ' ' + inps.phone.value : 'Phone';
            document.querySelector('.prev_country_big').innerText = inps.country.value || 'Country';
        }
        openPreviewBtn.addEventListener('click', async () => {
            document.body.style.overflow = 'hidden';
            previewModal.classList.remove('hidden');
            previewModal.classList.add('flex');
            pendingPreviewTemplate = null;
            syncBigPreviewContact();
            await loadResumeTemplateForModal();
            try {
                const res = await fetch('https://resume-backend-54se.onrender.com/api/templates/all');
                const data = await res.json();
                previewTemplatesCache = data.success ? (data.templates || []) : [];
                if (!previewTemplatesCache.length) dynamicTemplatesGrid.innerHTML = '<div class="text-center text-sm text-gray-400 py-10 w-full col-span-2">No templates found.</div>';
                renderPreviewTemplates();
            } catch (error) {
                dynamicTemplatesGrid.innerHTML = '<p class="text-red-500 text-xs">Failed to load templates.</p>';
            }
        });
        function closeModal() {
            previewModal.classList.add('hidden');
            previewModal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        closePreviewBtn.addEventListener('click', closeModal);
        closePreviewTop.addEventListener('click', closeModal);
        changeTemplateBtn.addEventListener('click', confirmTemplateChangeFromPreview);
        
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !previewModal.classList.contains('hidden')) closeModal(); });
        previewModal.addEventListener('click', function(e){ if(e.target === previewModal) closeModal(); });
        if (templateSortSelect) templateSortSelect.addEventListener('change', renderPreviewTemplates);
        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const selectedColor = btn.dataset.color || window.getComputedStyle(btn).backgroundColor;
                document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active-color'));
                btn.classList.add('active-color');
                document.querySelectorAll('.theme-text').forEach(el => el.style.color = selectedColor);
                document.querySelectorAll('.theme-border').forEach(el => el.style.borderColor = selectedColor);
            });
        });
    

        /* =========================================================
           SELECTED TEMPLATE IMAGE PATH + BADGE FIX
           Added safely at the end so old logic stays intact.
           It supports both local uploads paths and full URLs.
        ========================================================= */
        function getTemplateImageUrl(thumbnail) {
            if (!thumbnail) return "";

            let clean = String(thumbnail).trim();

            if (clean.startsWith("http://") || clean.startsWith("https://")) {
                return clean;
            }

            if (clean.startsWith("/uploads/")) {
                return "https://resume-backend-54se.onrender.com" + clean;
            }

            if (clean.startsWith("uploads/")) {
                return "https://resume-backend-54se.onrender.com/" + clean;
            }

            return "https://resume-backend-54se.onrender.com/uploads/templates/" + clean;
        }

        function resolveElement(ref) {
            if (!ref) return null;
            if (typeof ref === "string") return document.getElementById(ref);
            return ref;
        }

        function setImageOrFallback(imgId, fallbackId, thumbnail) {
            const img = resolveElement(imgId);
            const fallback = resolveElement(fallbackId);

            if (!img) return;

            const imageUrl = getTemplateImageUrl(thumbnail);

            if (!imageUrl) {
                img.classList.add("hidden");
                if (fallback) fallback.classList.remove("hidden");
                return;
            }

            img.onload = function () {
                img.classList.remove("hidden");
                if (fallback) fallback.classList.add("hidden");
            };

            img.onerror = function () {
                console.error("Template image failed to load:", imageUrl);
                img.classList.add("hidden");
                if (fallback) fallback.classList.remove("hidden");
            };

            img.src = imageUrl;
        }

        function setSelectedTemplateLivePreviewFromResume(resume) {
            if (!resume) return;

            const thumbnail =
                resume.template_thumbnail_url ||
                resume.thumbnail_url ||
                resume.template?.thumbnail_url ||
                "";

            setImageOrFallback(
                "selectedTemplateLiveImage",
                "selectedTemplateLiveFallback",
                thumbnail
            );

            setImageOrFallback(
                "selectedTemplateThumb",
                null,
                thumbnail
            );

            setImageOrFallback(
                "modalCurrentTemplateLargeImg",
                "modalCurrentTemplateLargeFallback",
                thumbnail
            );

            setImageOrFallback(
                "modalFullTemplateImg",
                "modalFullTemplateFallback",
                thumbnail
            );

            setImageOrFallback(
                "modalCurrentTemplateImg",
                null,
                thumbnail
            );

            if (typeof setExactLiveTemplateBackground === "function") {
                setExactLiveTemplateBackground(thumbnail);
            }
        }

        async function loadSelectedTemplateDirectly() {
            const selectedTemplate = localStorage.getItem("selected_template");

            if (!selectedTemplate) {
                return null;
            }

            try {
                const res = await fetch("https://resume-backend-54se.onrender.com/api/templates/all");
                const data = await res.json();

                if (!data.success || !Array.isArray(data.templates)) {
                    return null;
                }

                const found = data.templates.find(t =>
                    String(t.template_key) === String(selectedTemplate) ||
                    String(t.id) === String(selectedTemplate)
                );

                if (!found) {
                    return null;
                }

                return {
                    template_name: found.name,
                    template_category: found.category,
                    template_thumbnail_url: found.thumbnail_url,
                    template_key: found.template_key || found.id
                };
            } catch (error) {
                console.error("Direct selected template load failed:", error);
                return null;
            }
        }

        async function applySelectedTemplateBadge(resume) {
            let finalResume = resume;

            if (!finalResume || !finalResume.template_thumbnail_url) {
                const directTemplate = await loadSelectedTemplateDirectly();
                if (directTemplate) {
                    finalResume = {
                        ...(finalResume || {}),
                        ...directTemplate
                    };
                }
            }

            if (!finalResume) return;

            const badge = document.getElementById("selectedTemplateBadge");
            const name = document.getElementById("selectedTemplateName");
            const category = document.getElementById("selectedTemplateCategory");

            const templateName =
                finalResume.template_name ||
                finalResume.name ||
                "Selected Template";

            const templateCategory =
                finalResume.template_category ||
                finalResume.category ||
                "Professional";

            if (name) name.textContent = templateName;
            if (category) category.textContent = templateCategory;

            const modalText = document.getElementById("modalSelectedTemplateText");
            if (modalText) {
                modalText.textContent = "Current: " + templateName;
            }

            const modalLargeName = document.getElementById("modalLargeTemplateName");
            if (modalLargeName) {
                modalLargeName.textContent = templateName;
            }

            const modalLargeCategory = document.getElementById("modalLargeTemplateCategory");
            if (modalLargeCategory) {
                modalLargeCategory.textContent = templateCategory;
            }

            const modalCurrentName = document.getElementById("modalCurrentTemplateName");
            if (modalCurrentName) {
                modalCurrentName.textContent = templateName;
            }

            const modalCurrentCategory = document.getElementById("modalCurrentTemplateCategory");
            if (modalCurrentCategory) {
                modalCurrentCategory.textContent = templateCategory;
            }

            setSelectedTemplateLivePreviewFromResume(finalResume);

            if (typeof updateModalCurrentTemplateInfo === "function") {
                updateModalCurrentTemplateInfo(finalResume);
            }

            if (badge) {
                badge.classList.remove("hidden");
            }
        }

        // Fallback load: agar resume API me template na aaye lekin localStorage me selected_template ho,
        // to template API se load karke badge/live preview show kar dega.
        

    
        /* FINAL FIX: robust selected-template image resolver for live preview + modal */
        const TEMPLATE_API_BASE_FINAL = "https://resume-backend-54se.onrender.com";

        function finalTemplateUrl(thumbnail) {
            if (!thumbnail) return "";
            let clean = String(thumbnail).trim();
            if (!clean) return "";
            clean = clean.replace(/\\\\/g, "/");
            if (clean.startsWith("http://") || clean.startsWith("https://")) return clean;
            if (clean.startsWith("/uploads/")) return TEMPLATE_API_BASE_FINAL + clean;
            if (clean.startsWith("uploads/")) return TEMPLATE_API_BASE_FINAL + "/" + clean;
            return TEMPLATE_API_BASE_FINAL + "/uploads/templates/" + clean;
        }

        function finalEl(target) {
            if (!target) return null;
            return typeof target === "string" ? document.getElementById(target) : target;
        }

        async function finalGetTemplates() {
            try {
                const res = await fetch(TEMPLATE_API_BASE_FINAL + "/api/templates/all");
                const data = await res.json();
                return data.success && Array.isArray(data.templates) ? data.templates : [];
            } catch (error) {
                console.error("Template API load failed:", error);
                return [];
            }
        }

        function finalGetStoredTemplateKey() {
            return (
                localStorage.getItem("selected_template") ||
                localStorage.getItem("selectedTemplate") ||
                localStorage.getItem("resume_template") ||
                localStorage.getItem("template_id") ||
                ""
            );
        }

        function finalTemplateMatches(template, key) {
            if (!template || !key) return false;
            return String(template.template_key) === String(key) || String(template.id) === String(key);
        }

        async function finalResolveTemplate(resume) {
            const templates = await finalGetTemplates();
            const storedKey = finalGetStoredTemplateKey();

            let found = null;

            // 1) Browser selected template has top priority because user selected it in current flow.
            if (storedKey) {
                found = templates.find(t => finalTemplateMatches(t, storedKey));
            }

            // 2) Then database resume template.
            if (!found && resume) {
                const resumeKey = resume.template_key || resume.template_id || resume.template || "";
                found = templates.find(t => finalTemplateMatches(t, resumeKey));
            }

            // 3) Then match by name/category if backend returned old joined data.
            if (!found && resume && (resume.template_name || resume.name)) {
                const rName = String(resume.template_name || resume.name || "").toLowerCase().trim();
                const rCat = String(resume.template_category || resume.category || "").toLowerCase().trim();
                found = templates.find(t => {
                    const tName = String(t.name || "").toLowerCase().trim();
                    const tCat = String(t.category || "").toLowerCase().trim();
                    return tName === rName && (!rCat || tCat === rCat);
                });
            }

            // 4) Last fallback: latest active uploaded template, so preview never remains empty.
            if (!found && templates.length) {
                found = templates[0];
            }

            if (found) {
                localStorage.setItem("selected_template", found.template_key || String(found.id));
                return {
                    ...(resume || {}),
                    template_name: found.name || resume?.template_name || "Selected Template",
                    template_category: found.category || resume?.template_category || "Professional",
                    template_thumbnail_url: found.thumbnail_url || resume?.template_thumbnail_url || "",
                    template_key: found.template_key || String(found.id),
                    id: found.id || resume?.id
                };
            }

            return resume || null;
        }

        function finalSetImage(target, fallbackTarget, thumbnail, fallbackTemplates = []) {
            const img = finalEl(target);
            const fallback = finalEl(fallbackTarget);
            if (!img) return;

            const url = finalTemplateUrl(thumbnail);
            if (!url) {
                img.removeAttribute("src");
                img.classList.add("hidden");
                if (fallback) fallback.classList.remove("hidden");
                return;
            }

            img.onload = function () {
                img.classList.remove("hidden");
                if (fallback) fallback.classList.add("hidden");
            };

            img.onerror = async function () {
                console.error("Template image failed to load:", url);
                const templates = fallbackTemplates.length ? fallbackTemplates : await finalGetTemplates();
                const replacement = templates.find(t => t.thumbnail_url && finalTemplateUrl(t.thumbnail_url) !== url);

                if (replacement) {
                    localStorage.setItem("selected_template", replacement.template_key || String(replacement.id));
                    img.onerror = function () {
                        img.classList.add("hidden");
                        if (fallback) fallback.classList.remove("hidden");
                    };
                    img.src = finalTemplateUrl(replacement.thumbnail_url);
                    return;
                }

                img.classList.add("hidden");
                if (fallback) fallback.classList.remove("hidden");
            };

            img.src = url;
        }

        function finalSetAllTemplateImages(template) {
            const thumbnail = template?.template_thumbnail_url || template?.thumbnail_url || "";
            finalSetImage("selectedTemplateThumb", null, thumbnail);
            finalSetImage("selectedTemplateLiveImage", "selectedTemplateLiveFallback", thumbnail);
            finalSetImage("modalCurrentTemplateLargeImg", "modalCurrentTemplateLargeFallback", thumbnail);
            finalSetImage("modalFullTemplateImg", "modalFullTemplateFallback", thumbnail);
            finalSetImage("modalCurrentTemplateImg", null, thumbnail);
            finalSetImage("liveTemplateBgModal", "liveTemplateBgModalFallback", thumbnail);
        }

        function finalSetTemplateText(template) {
            const templateName = template?.template_name || template?.name || "Selected Template";
            const templateCategory = template?.template_category || template?.category || "Professional";

            const map = {
                selectedTemplateName: templateName,
                selectedTemplateCategory: templateCategory,
                modalSelectedTemplateText: "Current: " + templateName,
                modalLargeTemplateName: templateName,
                modalLargeTemplateCategory: templateCategory,
                modalCurrentTemplateName: templateName,
                modalCurrentTemplateCategory: templateCategory
            };

            Object.entries(map).forEach(([id, value]) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value;
            });

            const badge = document.getElementById("selectedTemplateBadge");
            if (badge) badge.classList.remove("hidden");
        }

        // Override old function name used by existing Contact/Education logic.
        async function applySelectedTemplateBadge(resume) {
            const resolved = await finalResolveTemplate(resume);
            if (!resolved) return;
            finalSetTemplateText(resolved);
            finalSetAllTemplateImages(resolved);

            if (typeof updateModalCurrentTemplateInfo === "function") {
                try { updateModalCurrentTemplateInfo(resolved); } catch (e) {}
            }
        }

        // Override old background helper too.
        function setExactLiveTemplateBackground(thumbnail) {
            finalSetImage("liveTemplateBgModal", "liveTemplateBgModalFallback", thumbnail);
            finalSetImage("selectedTemplateLiveImage", "selectedTemplateLiveFallback", thumbnail);
        }

        // Force run after full page is rendered and after old scripts complete.
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(function () {
                applySelectedTemplateBadge(null);
            }, 250);
        });

        setTimeout(function () {
            applySelectedTemplateBadge(null);
        }, 400);


        /* REAL HTML/CSS template rendering override: PNG thumbnail stays only in badge/modal; editable preview uses layout_key */
        function setModernAccent(color) {
            const root = document.getElementById("modernLivePreview");
            if (root && color) root.style.setProperty("--resume-accent", color);
        }

        function updateModernContactPreview() {
            const first = (document.getElementById("inp_fname")?.value || "").trim();
            const last = (document.getElementById("inp_lname")?.value || "").trim();
            const city = (document.getElementById("inp_city")?.value || "").trim();
            const country = (document.getElementById("inp_country")?.value || "").trim();
            const postal = (document.getElementById("inp_postal")?.value || "").trim();
            const code = (document.getElementById("inp_country_code")?.value || "").trim();
            const phone = (document.getElementById("inp_phone")?.value || "").trim();
            const email = (document.getElementById("inp_email")?.value || "").trim();

            const fullName = (first + " " + last).trim() || "Your Name";

            const set = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value;
            };

            set("prev_name", fullName);
            set("prev_city", city || "City");
            set("prev_country", country || "Country");
            set("prev_postal", postal ? postal : "");
            set("prev_phone", phone ? `${code} ${phone}` : "Phone");
            set("prev_email", email || "Email");

            document.querySelectorAll(".prev_name_big").forEach(el => el.textContent = fullName.toUpperCase());
            document.querySelectorAll(".prev_city_big").forEach(el => el.textContent = city || "City");
            document.querySelectorAll(".prev_country_big").forEach(el => el.textContent = country || "Country");
            document.querySelectorAll(".prev_phone_big").forEach(el => el.textContent = phone ? `${code} ${phone}` : "Phone");
            document.querySelectorAll(".prev_email_big").forEach(el => el.textContent = email || "Email");
        }

        function attachModernContactPreview() {
            ["inp_fname","inp_lname","inp_city","inp_country","inp_postal","inp_country_code","inp_phone","inp_email"].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.removeEventListener("input", updateModernContactPreview);
                    el.removeEventListener("change", updateModernContactPreview);
                    el.addEventListener("input", updateModernContactPreview);
                    el.addEventListener("change", updateModernContactPreview);
                }
            });

            const savedColor = localStorage.getItem("resume_accent_color") || "#2563eb";
            setModernAccent(savedColor);
            updateModernContactPreview();
        }

        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(attachModernContactPreview, 250);
            setTimeout(updateModernContactPreview, 700);
        });
        setTimeout(attachModernContactPreview, 500);



        /* GHOST FINAL SAFE OVERRIDES: keep old logic but hide duplicate badge and keep direct live preview updated */
        (function () {
            function safeText(id, value) {
                const el = document.getElementById(id);
                if (el) el.textContent = value;
            }
            function safeHTML(id, value) {
                const el = document.getElementById(id);
                if (el) el.innerHTML = value;
            }
            function getValue(id) {
                return (document.getElementById(id)?.value || '').trim();
            }
            function getStoredAccent() {
                return localStorage.getItem('resume_accent_color') || localStorage.getItem('selected_template_color') || '#2563eb';
            }
            window.forceVideoStylePreview = function () {
                const badge = document.getElementById('selectedTemplateBadge');
                if (badge) badge.style.display = 'none';
                const rightPanel = document.querySelector('.builder-right-preview-panel');
                if (rightPanel) rightPanel.scrollTop = 0;
                const root = document.getElementById('modernLivePreview');
                if (root) root.style.setProperty('--resume-accent', getStoredAccent());
            };
            const oldApply = window.applySelectedTemplateBadge;
            window.applySelectedTemplateBadge = async function (resume) {
                if (typeof oldApply === 'function') {
                    try { await oldApply(resume); } catch (e) { console.warn('Old template badge logic skipped safely:', e); }
                }
                window.forceVideoStylePreview();
            };
            const oldUpdateAll = window.updateAllPreviews;
            window.updateAllPreviews = function () {
                if (typeof oldUpdateAll === 'function') {
                    try { oldUpdateAll(); } catch (e) { console.warn('Old preview updater skipped safely:', e); }
                }
                const first = getValue('inp_fname') || 'Your';
                const last = getValue('inp_lname') || 'Name';
                const fullName = (first + ' ' + last).trim();
                safeText('prev_name', fullName || 'Your Name');
                safeText('prev_city', getValue('inp_city') || 'City');
                safeText('prev_postal', getValue('inp_postal'));
                safeText('prev_country', getValue('inp_country') || 'Country');
                const phoneCode = document.getElementById('inp_country_code')?.value || '';
                safeText('prev_phone', ((phoneCode + ' ' + getValue('inp_phone')).trim()) || 'Phone');
                safeText('prev_email', getValue('inp_email') || 'Email');
                localStorage.setItem('resume_preview_name', fullName);
                localStorage.setItem('resume_preview_contact', JSON.stringify({
                    phone: ((phoneCode + ' ' + getValue('inp_phone')).trim()),
                    email: getValue('inp_email'),
                    city: getValue('inp_city'),
                    country: getValue('inp_country'),
                    postal: getValue('inp_postal')
                }));
                window.forceVideoStylePreview();
            };
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('#inp_fname,#inp_lname,#inp_city,#inp_postal,#inp_country,#inp_country_code,#inp_phone,#inp_email').forEach(function (el) {
                    el.addEventListener('input', window.updateAllPreviews);
                    el.addEventListener('change', window.updateAllPreviews);
                });
                setTimeout(window.updateAllPreviews, 200);
                setTimeout(window.forceVideoStylePreview, 500);
            });
            setTimeout(window.forceVideoStylePreview, 700);
        })();
</script>
<style>
    .selected-template-badge-frame,
    #selectedTemplateBadge,
    .modal-selected-template-strip,
    .template-full-view-card,
    .exact-template-preview,
    .a4-page,
    .preview-paper-compact {
        display: none !important;
    }

    .preview-pane-container {
        width: 100% !important;
        height: calc(100vh - 185px) !important;
        min-height: 590px !important;
        padding: 16px !important;
        background: linear-gradient(135deg, #eef2ff, #f8fafc) !important;
        border: 0 !important;
        box-shadow: none !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 24px !important;
    }

    .resume-video-preview {
        width: 500px;
        height: 705px;
        background: #ffffff;
        display: grid;
        grid-template-columns: 34% 66%;
        overflow: hidden;
        border-radius: 16px;
        box-shadow: 0 28px 75px rgba(15, 23, 42, 0.22);
        font-family: Arial, sans-serif;
        color: #111827;
        transform: scale(0.82);
        transform-origin: center center;
        --resume-accent: #2563eb;
    }

    .resume-video-preview.enter-from-left {
        animation: resumeEnterFromLeft 0.75s cubic-bezier(.2,.9,.2,1) forwards;
    }

    @keyframes resumeEnterFromLeft {
        0% {
            transform: translateX(-520px) scale(1.18);
            opacity: 0;
        }
        65% {
            transform: translateX(16px) scale(0.86);
            opacity: 1;
        }
        100% {
            transform: translateX(0) scale(0.82);
            opacity: 1;
        }
    }

    .rv-side {
        background: #182235;
        color: #ffffff;
        padding: 30px 18px;
        display: flex;
        flex-direction: column;
        gap: 17px;
    }

    .rv-avatar {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        background: white;
        color: #182235;
        border: 5px solid var(--resume-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        margin: 0 auto 6px;
    }

    .rv-side-title {
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--resume-accent);
        border-bottom: 1px solid rgba(255,255,255,.25);
        padding-bottom: 7px;
        margin-bottom: 8px;
    }

    .rv-side-text {
        font-size: 10.5px;
        line-height: 1.55;
        color: #e5e7eb;
        font-weight: 700;
        word-break: break-word;
    }

    .rv-pill {
        display: inline-block;
        background: rgba(255,255,255,.13);
        border-radius: 999px;
        padding: 5px 8px;
        margin: 4px 4px 0 0;
        font-size: 8.5px;
        font-weight: 800;
    }

    .rv-main {
        padding: 38px 30px;
        background: #ffffff;
    }

    .rv-name {
        font-size: 31px;
        line-height: 1.08;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #111827;
        word-break: break-word;
    }

    .rv-role {
        margin-top: 10px;
        display: inline-flex;
        background: var(--resume-accent);
        color: white;
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 8.5px;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    .rv-summary {
        margin-top: 18px;
        font-size: 11px;
        line-height: 1.65;
        color: #4b5563;
        font-weight: 600;
    }

    .rv-section {
        margin-top: 22px;
    }

    .rv-section-title {
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        border-bottom: 3px solid var(--resume-accent);
        padding-bottom: 6px;
        margin-bottom: 11px;
    }

    .rv-item-title {
        font-size: 12px;
        font-weight: 900;
        color: #111827;
    }

    .rv-item-meta {
        font-size: 10px;
        color: var(--resume-accent);
        font-weight: 900;
        margin: 4px 0;
    }

    .rv-item-text {
        font-size: 10px;
        line-height: 1.55;
        color: #4b5563;
        font-weight: 600;
    }
</style>

<script>
(function () {
    function findInput(ids) {
        for (const id of ids) {
            const el = document.getElementById(id);
            if (el) return el;
        }
        return null;
    }

    function valueOf(ids) {
        const el = findInput(ids);
        return el ? String(el.value || el.textContent || "").trim() : "";
    }

    function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    }

    function getContactData() {
        const firstName = valueOf(["inp_fname", "firstName", "fname", "first_name"]);
        const lastName = valueOf(["inp_lname", "lastName", "lname", "last_name"]);
        const city = valueOf(["inp_city", "city"]);
        const postal = valueOf(["inp_postal", "postalCode", "postal_code"]);
        const country = valueOf(["inp_country", "country"]);
        const code = valueOf(["inp_country_code", "countryCode"]) || "+92";
        const phone = valueOf(["inp_phone", "phone"]);
        const email = valueOf(["inp_email", "email"]);

        const fullName = `${firstName} ${lastName}`.trim() || "YOUR NAME";
        const phoneFull = phone ? `${code} ${phone}` : "Phone";
        const location = [city, country, postal].filter(Boolean).join(", ") || "City, Country";

        return {
            firstName,
            lastName,
            fullName,
            city,
            postal,
            country,
            code,
            phone,
            phoneFull,
            email: email || "Email",
            location
        };
    }

    function saveSnapshot(data) {
        localStorage.setItem("resume_contact_snapshot", JSON.stringify(data));
        localStorage.setItem("resume_preview_name", data.fullName);
        localStorage.setItem("resume_preview_email", data.email);
        localStorage.setItem("resume_preview_phone", data.phoneFull);
        localStorage.setItem("resume_preview_city", data.city);
        localStorage.setItem("resume_preview_country", data.country);
    }

    function createPreviewOnce() {
        const container = document.querySelector(".preview-pane-container");
        if (!container) return;

        if (document.getElementById("stableContactPreview")) return;

        const shouldAnimate = sessionStorage.getItem("resume_preview_entrance") === "fromScratch";
        sessionStorage.removeItem("resume_preview_entrance");

        container.innerHTML = `
            <div id="stableContactPreview" class="resume-video-preview ${shouldAnimate ? "enter-from-left" : ""}">
                <aside class="rv-side">
                    <div class="rv-avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div>
                        <div class="rv-side-title">Contact</div>
                        <div class="rv-side-text">
                            <span id="rvContactPhone">Phone</span><br>
                            <span id="rvContactEmail">Email</span><br>
                            <span id="rvContactLocation">City, Country</span>
                        </div>
                    </div>

                    <div>
                        <div class="rv-side-title">Skills</div>
                        <span class="rv-pill">Communication</span>
                        <span class="rv-pill">Teamwork</span>
                        <span class="rv-pill">Problem Solving</span>
                    </div>

                    <div>
                        <div class="rv-side-title">Languages</div>
                        <div class="rv-side-text">English<br>Urdu</div>
                    </div>
                </aside>

                <main class="rv-main">
                    <div id="rvContactName" class="rv-name">YOUR NAME</div>
                    <div class="rv-role">Student Resume</div>

                    <p class="rv-summary">
                        Motivated student with strong communication, learning ability and interest in professional growth.
                    </p>

                    <section class="rv-section">
                        <div class="rv-section-title">Education</div>
                        <div class="rv-item-title">Institution Name</div>
                        <div class="rv-item-meta">Degree, Field of Study</div>
                        <div class="rv-item-text">Education details will appear in the next step.</div>
                    </section>

                    <section class="rv-section">
                        <div class="rv-section-title">Experience</div>
                        <div class="rv-item-title">Project / Internship</div>
                        <div class="rv-item-meta">Role or achievement</div>
                        <div class="rv-item-text">Add your experience in upcoming builder steps.</div>
                    </section>
                </main>
            </div>
        `;
    }

    function updatePreviewOnlyText() {
        const data = getContactData();
        saveSnapshot(data);

        setText("rvContactName", data.fullName);
        setText("rvContactPhone", data.phoneFull);
        setText("rvContactEmail", data.email);
        setText("rvContactLocation", data.location);

        const preview = document.getElementById("stableContactPreview");
        if (preview) {
            preview.style.setProperty("--resume-accent", localStorage.getItem("resume_accent_color") || "#2563eb");
        }
    }

    function bindInputs() {
        [
            "inp_fname", "firstName", "fname", "first_name",
            "inp_lname", "lastName", "lname", "last_name",
            "inp_city", "city",
            "inp_postal", "postalCode", "postal_code",
            "inp_country", "country",
            "inp_country_code", "countryCode",
            "inp_phone", "phone",
            "inp_email", "email"
        ].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener("input", updatePreviewOnlyText);
                el.addEventListener("change", updatePreviewOnlyText);
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        createPreviewOnce();
        bindInputs();
        updatePreviewOnlyText();
        setTimeout(updatePreviewOnlyText, 500);
    });
})();
</script>



<!-- ===== GHOST FINAL CORE CV ONE COLUMN LIVE EDITABLE PREVIEW ===== -->
<style>
    .ghost-corecv-stage {
        width: min(100%, 680px) !important;
        height: min(600px, calc(100vh - 205px)) !important;
        min-height: 460px !important;
        border-radius: 18px !important;
        background: linear-gradient(135deg, #eef2f7 0%, #ffffff 100%) !important;
        border: 1px solid #dbe3ef !important;
        box-shadow: 0 18px 45px rgba(15, 23, 42, .08) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: hidden !important;
        padding: 18px !important;
    }

    .ghost-corecv-paper {
        --core-accent: #16a34a;
        width: 390px;
        height: 552px;
        background: #ffffff;
        color: #111827;
        box-shadow: 0 22px 55px rgba(15, 23, 42, .18);
        border-radius: 7px;
        padding: 34px 38px 30px;
        font-family: Arial, Helvetica, sans-serif;
        overflow: hidden;
    }

    .ghost-corecv-name {
        text-align: center;
        font-size: 17px;
        font-weight: 900;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #111827;
        line-height: 1.2;
        margin-bottom: 5px;
    }

    .ghost-corecv-contact {
        text-align: center;
        font-size: 6.7px;
        color: #4b5563;
        font-weight: 700;
        line-height: 1.45;
        padding-bottom: 8px;
        margin-bottom: 10px;
        border-bottom: 1.5px solid var(--core-accent);
    }

    .ghost-corecv-objective {
        font-size: 6.8px;
        line-height: 1.5;
        color: #374151;
        text-align: justify;
        margin-bottom: 10px;
    }

    .ghost-corecv-section {
        margin-top: 9px;
    }

    .ghost-corecv-title {
        font-size: 7.4px;
        font-weight: 900;
        color: #111827;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: 1.4px solid var(--core-accent);
        padding-bottom: 3px;
        margin-bottom: 5px;
    }

    .ghost-corecv-text,
    .ghost-corecv-li {
        font-size: 6.6px;
        line-height: 1.45;
        color: #374151;
    }

    .ghost-corecv-list {
        margin: 0;
        padding-left: 11px;
    }

    .ghost-corecv-list li {
        margin-bottom: 2px;
    }

    .ghost-corecv-expertise-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2px 14px;
        margin-top: 2px;
    }

    .ghost-corecv-job-row,
    .ghost-corecv-edu-row {
        display: grid;
        grid-template-columns: 1.1fr .75fr .75fr;
        gap: 10px;
        margin-bottom: 5px;
        align-items: start;
    }

    .ghost-corecv-bold {
        font-weight: 900;
        color: #111827;
    }

    .ghost-corecv-muted {
        color: #4b5563;
        font-style: italic;
    }

    @media (max-width: 1280px) {
        .ghost-corecv-paper {
            width: 350px;
            height: 505px;
            padding: 28px 32px;
        }
        .ghost-corecv-name { font-size: 15px; }
        .ghost-corecv-title { font-size: 6.8px; }
        .ghost-corecv-text, .ghost-corecv-li, .ghost-corecv-contact, .ghost-corecv-objective { font-size: 6px; }
    }
</style>

<script>
(function () {
    const CORE_LAYOUT_KEY = "core_cv_one_column";

    function clean(v) {
        return String(v || "").replace(/\s+/g, " ").trim();
    }

    function getVal(ids) {
        for (const id of ids) {
            const el = document.getElementById(id);
            if (el) return clean(el.value || el.textContent);
        }
        return "";
    }

    function selectedLayout() {
        return clean(localStorage.getItem("selected_template_layout_key")) || "modern_sidebar";
    }

    function shouldUseCoreCv() {
        const layout = selectedLayout();
        const name = clean(localStorage.getItem("selected_template_name")).toLowerCase();
        return layout === CORE_LAYOUT_KEY || name.includes("core cv");
    }

    function getContactDataForCore() {
        const first = getVal(["inp_fname", "firstName", "fname", "first_name"]);
        const last = getVal(["inp_lname", "lastName", "lname", "last_name"]);
        const city = getVal(["inp_city", "city"]);
        const postal = getVal(["inp_postal", "postalCode", "postal_code"]);
        const country = getVal(["inp_country", "country"]);
        const code = getVal(["inp_country_code", "countryCode"]);
        const phone = getVal(["inp_phone", "phone"]);
        const email = getVal(["inp_email", "email"]);

        const fullName = clean([first, last].filter(Boolean).join(" ")) || "Your Name";
        const location = clean([city, country, postal].filter(Boolean).join(", ")) || "City, Country";
        const phoneFull = clean([code, phone].filter(Boolean).join(" ")) || "Phone";

        const snapshot = { fullName, first, last, city, postal, country, phoneFull, email, location };
        localStorage.setItem("resume_contact_snapshot", JSON.stringify(snapshot));
        localStorage.setItem("resume_preview_name", fullName);
        localStorage.setItem("resume_preview_email", email);
        localStorage.setItem("resume_preview_phone", phoneFull);
        localStorage.setItem("resume_preview_city", city);
        localStorage.setItem("resume_preview_country", country);
        return snapshot;
    }

    function coreCvMarkup(data) {
        const accent = clean(localStorage.getItem("selected_template_default_color")) || "#16a34a";
        return `
            <div id="ghostCoreCvPaper" class="ghost-corecv-paper" style="--core-accent:${accent}">
                <div class="ghost-corecv-name" id="coreCvName">${data.fullName}</div>
                <div class="ghost-corecv-contact" id="coreCvContact">
                    ${data.location} | ${data.phoneFull} | ${data.email || "your.email@example.com"}
                </div>

                <div class="ghost-corecv-objective" id="coreCvObjective">
                    Use this space to express your career aspiration and goal and to quickly connect with an employer. Stress your most relevant experience and skills for the position you are applying for.
                </div>

                <section class="ghost-corecv-section">
                    <div class="ghost-corecv-title">Professional Competencies</div>
                    <ul class="ghost-corecv-list">
                        <li class="ghost-corecv-li">Use bullet points to define and explain what you believe to be your key skills and abilities.</li>
                    </ul>
                </section>

                <section class="ghost-corecv-section">
                    <div class="ghost-corecv-title">Personal Competencies</div>
                    <ul class="ghost-corecv-list">
                        <li class="ghost-corecv-li">Create a list of the personal skills and qualities that will bring value to a new employer.</li>
                    </ul>
                </section>

                <section class="ghost-corecv-section">
                    <div class="ghost-corecv-title">Areas of Expertise</div>
                    <div class="ghost-corecv-expertise-grid">
                        <div class="ghost-corecv-li">• Keyword</div><div class="ghost-corecv-li">• Keyword</div><div class="ghost-corecv-li">• Keyword</div>
                        <div class="ghost-corecv-li">• Keyword</div><div class="ghost-corecv-li">• Keyword</div><div class="ghost-corecv-li">• Keyword</div>
                    </div>
                </section>

                <section class="ghost-corecv-section">
                    <div class="ghost-corecv-title">Career History</div>
                    <div class="ghost-corecv-job-row ghost-corecv-text">
                        <div><span class="ghost-corecv-bold">Your Most Recent Job Title</span><br>Duties</div>
                        <div class="ghost-corecv-muted">Employment date</div>
                        <div>In concise sentences describe the daily tasks you undertook.</div>
                    </div>
                    <div class="ghost-corecv-job-row ghost-corecv-text">
                        <div><span class="ghost-corecv-bold">Previous Job Title</span><br>Employer name</div>
                        <div class="ghost-corecv-muted">Employment dates</div>
                        <div></div>
                    </div>
                </section>

                <section class="ghost-corecv-section">
                    <div class="ghost-corecv-title">Academic Qualifications</div>
                    <div class="ghost-corecv-edu-row ghost-corecv-text">
                        <div><span class="ghost-corecv-bold" id="coreCvSchool">School / College Name</span><br><span id="coreCvDegree">Qualification / subject</span></div>
                        <div id="coreCvGrade">Grade</div>
                        <div class="ghost-corecv-muted" id="coreCvStudyDate">Study dates</div>
                    </div>
                </section>
            </div>
        `;
    }

    function renderCoreCvContactPreview() {
        if (!shouldUseCoreCv()) return;
        const container = document.querySelector(".preview-pane-container");
        if (!container) return;
        const data = getContactDataForCore();
        container.classList.add("ghost-corecv-stage");
        container.classList.add("real-template-mode");
        container.innerHTML = coreCvMarkup(data);
    }

    function bindCoreCvContact() {
        const ids = [
            "inp_fname", "firstName", "fname", "first_name",
            "inp_lname", "lastName", "lname", "last_name",
            "inp_city", "city",
            "inp_postal", "postalCode", "postal_code",
            "inp_country", "country",
            "inp_country_code", "countryCode",
            "inp_phone", "phone",
            "inp_email", "email"
        ];
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener("input", renderCoreCvContactPreview);
                el.addEventListener("change", renderCoreCvContactPreview);
            }
        });
        renderCoreCvContactPreview();
    }

    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(bindCoreCvContact, 950);
        setTimeout(renderCoreCvContactPreview, 1400);
    });
})();
</script>


<style id="ghost-final-compact-ui">
/* GHOST FINAL COMPACT UI - appended safely, no JS removed */
html,body{width:100%!important;height:100%!important;margin:0!important;overflow:hidden!important;background:#fff!important;box-sizing:border-box!important}
*,*::before,*::after{box-sizing:border-box!important}
body{zoom:1!important;min-width:1180px!important;min-height:700px!important;transform:none!important;font-family:Arial,Helvetica,sans-serif!important}

/* LEFT BLUE AREA SMALLER */
body>nav{position:fixed!important;inset:0 auto 0 0!important;width:250px!important;height:100vh!important;min-height:100vh!important;padding:24px 28px 20px!important;background:#073f70!important;border:0!important;z-index:100!important;overflow:hidden!important;box-shadow:none!important;display:flex!important;flex-direction:column!important;align-items:flex-start!important}
body>nav>div:first-child{width:100%!important;margin:0 0 23px!important;padding:0!important;transform:none!important}
body>nav .text-xl{color:#fff!important;font-size:17px!important;line-height:1!important;font-weight:950!important;letter-spacing:-.04em!important;white-space:nowrap!important}
body>nav .fa-layer-group{color:#ec4899!important;font-size:22px!important;margin-right:9px!important}

body>nav>div:nth-child(2){position:relative!important;display:flex!important;flex-direction:column!important;align-items:flex-start!important;gap:11px!important;width:100%!important;margin:0!important;padding:0!important;font-size:0!important}
body>nav>div:nth-child(2)::before{content:"";position:absolute;left:15px;top:28px;bottom:28px;width:2px;border-radius:999px;background:repeating-linear-gradient(to bottom,rgba(255,255,255,.24) 0 7px,transparent 7px 14px)}
body>nav>div:nth-child(2)>div{position:relative!important;width:100%!important;height:31px!important;min-height:31px!important;display:flex!important;align-items:center!important;padding:0 0 0 42px!important;margin:0!important;border:0!important;color:#fff!important;opacity:1!important;text-transform:none!important;letter-spacing:.01em!important;font-size:15px!important;line-height:1!important;font-weight:700!important;cursor:default!important}
body>nav>div:nth-child(2)>div::before{position:absolute;left:0;top:50%;transform:translateY(-50%);width:30px;height:30px;border-radius:999px;background:#0f172a;color:#fff;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:900;border:2.5px solid rgba(226,232,240,.48);box-shadow:0 0 0 3px rgba(15,23,42,.16);z-index:2}
body>nav>div:nth-child(2)>div:nth-child(1)::before{content:"1";background:#fff;color:#111827}
body>nav>div:nth-child(2)>div:nth-child(2)::before{content:"2"}body>nav>div:nth-child(2)>div:nth-child(3)::before{content:"3"}body>nav>div:nth-child(2)>div:nth-child(4)::before{content:"4"}body>nav>div:nth-child(2)>div:nth-child(5)::before{content:"5"}
body>nav>div:nth-child(2)>div:nth-child(1){font-weight:850!important}
body>nav>div:nth-child(2)>div:nth-child(1)::after{content:none!important}
body>nav>div:nth-child(2)>div:nth-child(5)::after{content:"Finalize";position:absolute;left:42px;top:44px;color:#fff;font-size:15px;line-height:1;font-weight:700;letter-spacing:.01em}
body>nav>div:nth-child(2)::after{content:"6";position:absolute;left:0;top:214px;width:30px;height:30px;border-radius:999px;background:#0f172a;color:#fff;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:900;border:2.5px solid rgba(226,232,240,.48);box-shadow:0 0 0 3px rgba(15,23,42,.16);z-index:2}

body>nav>div:last-child{position:absolute!important;left:28px!important;right:28px!important;top:348px!important;bottom:auto!important;width:auto!important;display:block!important;color:#fff!important;z-index:5!important;margin:0!important;padding:0!important}
body>nav>div:last-child .relative{display:none!important}
body>nav>div:last-child .text-xs{display:block!important;color:#fff!important;font-size:14px!important;line-height:1.05!important;font-weight:950!important;letter-spacing:-.02em!important;margin:0 0 7px!important;padding:0!important}
body>nav>div:last-child::after{content:"";display:block;width:145px;height:7px;border-radius:999px;background:linear-gradient(90deg,#34d399 0%,#34d399 22%,#fff 22%,#fff 100%);margin-top:7px}
body>nav>div:last-child::before{content:"20%";position:absolute;left:154px;top:25px;color:#fff;font-size:12px;line-height:1;font-weight:900}

body>.absolute.bottom-0{position:fixed!important;left:28px!important;bottom:18px!important;width:190px!important;height:auto!important;background:transparent!important;border:0!important;padding:0!important;display:block!important;z-index:120!important;font-size:0!important;color:#fff!important}
body>.absolute.bottom-0>div:first-child{display:flex!important;flex-direction:column!important;gap:7px!important;margin:0!important;padding:0!important}
body>.absolute.bottom-0 a{color:#34d399!important;font-size:12px!important;line-height:1.12!important;font-weight:850!important;white-space:nowrap!important;text-decoration:none!important}
body>.absolute.bottom-0 span{display:none!important}
body>.absolute.bottom-0>div:last-child{margin-top:14px!important;color:#fff!important;font-size:10.5px!important;line-height:1.3!important;font-weight:600!important;max-width:180px!important}

/* MAIN AREA */
body>.flex.flex-grow{margin-left:250px!important;width:calc(100vw - 250px)!important;height:100vh!important;display:grid!important;grid-template-columns:minmax(0,1fr) 405px!important;overflow:hidden!important;background:#fff!important}
body>.flex.flex-grow>div:first-child{width:100%!important;min-width:0!important;height:100vh!important;padding:52px 34px 42px 36px!important;overflow-y:auto!important;overflow-x:hidden!important;background:#fff!important}
body>.flex.flex-grow>div:first-child::-webkit-scrollbar{width:0!important;display:none!important}
body>.flex.flex-grow>div:first-child .max-w-2xl{max-width:740px!important;margin-left:0!important;margin-right:0!important}

a[href="/upload-or-scratch"]{position:static!important;display:inline-flex!important;align-items:center!important;width:fit-content!important;margin:0 0 20px!important;color:#2563eb!important;font-size:14px!important;font-weight:900!important;letter-spacing:.02em!important;line-height:1!important}
a[href="/upload-or-scratch"] i{margin-right:8px!important}
h1{max-width:720px!important;margin:0 0 8px!important;color:#0f172a!important;font-size:clamp(25px,1.8vw,33px)!important;line-height:1.14!important;letter-spacing:-.055em!important}
h1+p{margin:0 0 22px!important;color:#64748b!important;font-size:16px!important;line-height:1.35!important}
p.text-red-500{margin:0 0 16px!important;color:#ef4444!important;font-size:12px!important;font-weight:900!important}

#contactForm{max-width:740px!important;gap:14px!important;padding-bottom:0!important}
#contactForm .flex{gap:16px!important}
.form-label{color:#0f172a!important;font-size:12px!important;font-weight:900!important;margin-bottom:5px!important}
.form-input,.country-select{height:42px!important;border:1.4px solid #cbd5e1!important;border-radius:6px!important;background:#fff!important;color:#0f172a!important;font-size:14px!important;padding:0 13px!important;box-shadow:none!important}
.form-input:focus,.country-select:focus{border-color:#2563eb!important;box-shadow:0 0 0 3px rgba(37,99,235,.1)!important}
.country-select{min-width:104px!important;border-right:0!important;border-radius:6px 0 0 6px!important;background:#f8fafc!important}
#inp_phone{border-radius:0 6px 6px 0!important}

/* RIGHT PREVIEW HALF-SIZE */
.builder-right-preview-panel{position:relative!important;width:100%!important;min-width:0!important;height:100vh!important;background:#f7f9fc!important;border-left:1px solid #e5e7eb!important;overflow:hidden!important;padding:0 20px 30px!important;display:flex!important;flex-direction:column!important;align-items:center!important;justify-content:flex-start!important;gap:10px!important}
.builder-right-preview-panel::before,.builder-right-preview-panel::after,.builder-right-preview-panel .preview-pane-container.real-template-mode::before,.builder-right-preview-panel>.w-full.max-w-sm.flex::before,#selectedTemplateBadge{display:none!important;content:none!important}
.builder-right-preview-panel .preview-pane-container.real-template-mode{order:1!important;width:min(100%,340px)!important;height:420px!important;min-height:420px!important;max-height:420px!important;margin-top:88px!important;padding:16px!important;border-radius:18px!important;border:1px solid #dbe3ef!important;background:linear-gradient(135deg,#eef2f7 0%,#fff 100%)!important;box-shadow:0 18px 44px rgba(15,23,42,.07)!important;overflow:hidden!important;display:flex!important;align-items:flex-start!important;justify-content:center!important;pointer-events:none!important}
.builder-right-preview-panel .modern-live-preview{width:258px!important;height:360px!important;max-width:100%!important;max-height:100%!important;transform:none!important;transform-origin:top center!important;border-radius:7px!important;box-shadow:0 18px 40px rgba(15,23,42,.12)!important;pointer-events:none!important}
.builder-right-preview-panel>.w-full.max-w-sm.flex{position:relative!important;z-index:9999!important;order:2!important;width:min(100%,318px)!important;max-width:318px!important;margin-top:7px!important;padding:0!important;gap:10px!important;display:flex!important;justify-content:center!important;align-items:center!important;pointer-events:auto!important}

#btnPreview,#btnNext{position:relative!important;z-index:10000!important;height:40px!important;border-radius:999px!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;text-align:center!important;white-space:nowrap!important;text-transform:uppercase!important;letter-spacing:.05em!important;font-size:10px!important;font-weight:950!important;padding:0 16px!important;line-height:1!important;pointer-events:auto!important;cursor:pointer!important}
#btnPreview{min-width:104px!important;border:1.8px solid #0f172a!important;background:#fff!important;color:#0f172a!important}
#btnNext{min-width:142px!important;background:#ec4899!important;color:#fff!important;box-shadow:0 12px 24px rgba(236,72,153,.16)!important}
#btnPreview *,#btnNext *{pointer-events:none!important}

#previewModal,#previewModal *{pointer-events:auto!important}

@media(max-height:760px){
 body>nav{padding-top:18px!important}
 body>nav>div:first-child{margin-bottom:16px!important}
 body>nav>div:nth-child(2){gap:8px!important}
 body>nav>div:nth-child(2)::after{top:196px!important}
 body>nav>div:last-child{top:315px!important}
 body>.absolute.bottom-0{bottom:12px!important}
 body>.absolute.bottom-0 a{font-size:10.5px!important}
 body>.absolute.bottom-0>div:first-child{gap:5px!important}
 body>.absolute.bottom-0>div:last-child{margin-top:10px!important;font-size:9px!important}
 .builder-right-preview-panel .preview-pane-container.real-template-mode{margin-top:64px!important;height:380px!important;min-height:380px!important;max-height:380px!important}
 .builder-right-preview-panel .modern-live-preview{width:240px!important;height:335px!important}
}
@media(max-width:1024px){
 body{min-width:0!important;overflow:auto!important}
 body>nav{position:relative!important;width:100%!important;height:auto!important;min-height:82px!important;padding:22px 24px!important}
 body>nav>div:nth-child(2),body>nav>div:last-child,body>.absolute.bottom-0{display:none!important}
 body>.flex.flex-grow{margin-left:0!important;width:100%!important;height:auto!important;display:block!important}
 body>.flex.flex-grow>div:first-child{width:100%!important;height:auto!important;padding:32px 22px 100px!important}
 .builder-right-preview-panel{display:none!important}
 #contactForm .flex{flex-direction:column!important}
 #contactForm .w-1\/2,#contactForm .w-2\/3,#contactForm .w-1\/3{width:100%!important}
}
</style>


<script id="ghost-button-fallback-js">
(function () {
    function getValue(id) {
        return (document.getElementById(id)?.value || "").trim();
    }

    function getToken() {
        return localStorage.getItem("resume_token") || localStorage.getItem("token") || "";
    }

    function getResumeId() {
        return localStorage.getItem("current_resume_id") || localStorage.getItem("resume_id") || "";
    }

    const requiredContactFields = [
        { id: "inp_fname", label: "First Name" },
        { id: "inp_lname", label: "Last Name" },
        { id: "inp_email", label: "Email" }
    ];

    function ensureContactRequiredAlert() {
        let alertBox = document.getElementById("contactRequiredAlert");
        if (!alertBox) {
            alertBox = document.createElement("div");
            alertBox.id = "contactRequiredAlert";
            alertBox.textContent = "Please fill all required fields before moving to Education.";
            document.body.appendChild(alertBox);
        }
        return alertBox;
    }

    function showContactRequiredPopupOnly() {
        const alertBox = ensureContactRequiredAlert();
        alertBox.textContent = "Please fill all required fields before moving to Education.";
        alertBox.classList.add("show");
        clearTimeout(window.showContactRequiredPopupTimer);
        window.showContactRequiredPopupTimer = setTimeout(function () {
            alertBox.classList.remove("show");
        }, 3600);
    }

    function getErrorEl(fieldId) {
        const field = document.getElementById(fieldId);
        let errorEl = document.getElementById(fieldId + "_error");
        if (!errorEl && field) {
            errorEl = document.createElement("small");
            errorEl.id = fieldId + "_error";
            errorEl.className = "contact-field-error-text";
            field.insertAdjacentElement("afterend", errorEl);
        }
        return errorEl;
    }

    function clearContactFieldError(fieldId) {
        const field = document.getElementById(fieldId);
        const errorEl = getErrorEl(fieldId);
        if (field) {
            field.classList.remove("contact-field-error", "border-red-500", "border-red-600");
            field.style.removeProperty("border-color");
            field.style.removeProperty("box-shadow");
        }
        if (errorEl) errorEl.textContent = "";
    }

    function setContactFieldError(fieldId, label) {
        const field = document.getElementById(fieldId);
        const errorEl = getErrorEl(fieldId);
        if (field) {
            field.classList.add("contact-field-error");
            /* Inline important is added because this page has many later !important CSS overrides. */
            field.style.setProperty("border-color", "#ef4444", "important");
            field.style.setProperty("box-shadow", "0 0 0 1px rgba(239, 68, 68, .18)", "important");
        }
        if (errorEl) errorEl.textContent = label + " is required.";
    }

    function validateContactRequiredFields(showPopup) {
        let firstInvalid = null;

        requiredContactFields.forEach(function (item) {
            const field = document.getElementById(item.id);
            if (!field) return;

            if (!field.value.trim()) {
                setContactFieldError(item.id, item.label);
                if (!firstInvalid) firstInvalid = field;
            } else {
                clearContactFieldError(item.id);
            }
        });

        if (firstInvalid) {
            if (showPopup) showContactRequiredPopupOnly();
            firstInvalid.focus({ preventScroll: false });
            return false;
        }
        return true;
    }

    window.showContactRequiredPopup = function () {
        validateContactRequiredFields(false);
        showContactRequiredPopupOnly();
    };

    function attachContactFieldLiveClear() {
        requiredContactFields.forEach(function (item) {
            const field = document.getElementById(item.id);
            if (!field || field.dataset.ghostRequiredClearAttached === "1") return;
            field.dataset.ghostRequiredClearAttached = "1";
            field.addEventListener("input", function () {
                if (field.value.trim()) clearContactFieldError(item.id);
            });
        });
    }

    attachContactFieldLiveClear();
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", attachContactFieldLiveClear);
    }

    function syncPreviewModalText() {
        const first = getValue("inp_fname");
        const last = getValue("inp_lname");
        const full = (first + " " + last).trim() || "YOUR NAME";
        document.querySelectorAll(".prev_name_big").forEach(el => el.textContent = full.toUpperCase());
        document.querySelectorAll(".prev_email_big").forEach(el => el.textContent = getValue("inp_email") || "Email");
        document.querySelectorAll(".prev_city_big").forEach(el => el.textContent = getValue("inp_city") || "City");
        document.querySelectorAll(".prev_country_big").forEach(el => el.textContent = getValue("inp_country") || "Country");
        const code = document.getElementById("inp_country_code")?.value || "";
        const phone = getValue("inp_phone");
        document.querySelectorAll(".prev_phone_big").forEach(el => el.textContent = phone ? (code + " " + phone).trim() : "Phone");
    }

    async function handlePreview() {
        const modal = document.getElementById("previewModal");
        if (!modal) {
            alert("Preview modal not found.");
            return;
        }
        document.body.style.overflow = "hidden";
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        syncPreviewModalText();

        if (typeof window.loadResumeTemplateForModal === "function") {
            try { await window.loadResumeTemplateForModal(); } catch (e) { console.warn(e); }
        }
    }

    async function handleNext(btn) {
        if (!validateContactRequiredFields(true)) {
            return;
        }

        const firstName = getValue("inp_fname");
        const email = getValue("inp_email");
        const token = getToken();
        const resumeId = getResumeId();

        if (!token || !resumeId) {
            alert("Login/session missing. Please login again.");
            return;
        }

        const oldText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = "Saving...";

        const phoneCode = document.getElementById("inp_country_code")?.value || "";

        try {
            const res = await fetch("https://resume-backend-54se.onrender.com/api/resumes/update-contact", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + token
                },
                body: JSON.stringify({
                    resume_id: resumeId,
                    first_name: firstName,
                    last_name: getValue("inp_lname"),
                    city: getValue("inp_city"),
                    postal_code: getValue("inp_postal"),
                    country: getValue("inp_country"),
                    phone: (phoneCode + " " + getValue("inp_phone")).trim(),
                    email: email
                })
            });

            const data = await res.json();

            if (data.success) {
                window.location.href = "/builder/work-history";
            } else {
                alert(data.message || "Contact details could not be saved.");
                btn.disabled = false;
                btn.innerHTML = oldText;
            }
        } catch (e) {
            console.error(e);
            alert("Server error.");
            btn.disabled = false;
            btn.innerHTML = oldText;
        }
    }

    document.addEventListener("click", function (e) {
        const previewBtn = e.target.closest("#btnPreview");
        const nextBtn = e.target.closest("#btnNext");

        if (previewBtn) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            handlePreview();
            return;
        }

        if (nextBtn) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            handleNext(nextBtn);
        }
    }, true);
})();
</script>


<style id="ghost-video-sidebar-exact-size-only">
/* GHOST FINAL — ONLY blue sidebar steps/progress/footer sizing like video.
   Form, preview, Next/Preview buttons and JS logic are untouched. */

/* keep blue panel same size, stop text escaping from it */
body > nav {
    position: fixed !important;
    left: 0 !important;
    top: 0 !important;
    bottom: 0 !important;
    width: 360px !important;
    max-width: 360px !important;
    height: 100vh !important;
    min-height: 100vh !important;
    background: #073f70 !important;
    overflow: hidden !important;
    padding: 0 !important;
}

/* logo size like video */
body > nav > div:first-child {
    position: absolute !important;
    left: 47px !important;
    top: 35px !important;
    width: 265px !important;
    height: 32px !important;
    margin: 0 !important;
    padding: 0 !important;
    display: flex !important;
    align-items: center !important;
}

body > nav .text-xl {
    color: #ffffff !important;
    font-size: 21px !important;
    line-height: 1 !important;
    font-weight: 900 !important;
    letter-spacing: -0.03em !important;
    white-space: nowrap !important;
    overflow: hidden !important;
}

body > nav .fa-layer-group {
    color: #ec4899 !important;
    font-size: 27px !important;
    margin-right: 12px !important;
}

/* steps block: exact video-like size/spacing */
body > nav > div:nth-child(2) {
    position: absolute !important;
    left: 47px !important;
    top: 110px !important;
    width: 260px !important;
    height: 366px !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    font-size: 0 !important;
    color: #ffffff !important;
    z-index: 10 !important;
}

/* dotted line centered between circle buttons */
body > nav > div:nth-child(2)::before {
    content: "" !important;
    position: absolute !important;
    left: 17px !important;
    top: 36px !important;
    width: 3px !important;
    height: 294px !important;
    border-radius: 999px !important;
    background: repeating-linear-gradient(
        to bottom,
        rgba(255,255,255,.28) 0px,
        rgba(255,255,255,.28) 7px,
        transparent 7px,
        transparent 15px
    ) !important;
    z-index: 1 !important;
}

/* every step row fixed so labels remain exactly in front of circles */
body > nav > div:nth-child(2) > div {
    position: absolute !important;
    left: 0 !important;
    width: 260px !important;
    height: 36px !important;
    min-height: 36px !important;
    margin: 0 !important;
    padding: 0 0 0 50px !important;
    border: 0 !important;
    display: flex !important;
    align-items: center !important;
    color: #ffffff !important;
    opacity: 1 !important;
    font-size: 0 !important;
    line-height: 1 !important;
    text-transform: none !important;
    letter-spacing: 0 !important;
    overflow: visible !important;
    z-index: 3 !important;
}

body > nav > div:nth-child(2) > div:nth-child(1) { top: 0 !important; }
body > nav > div:nth-child(2) > div:nth-child(2) { top: 66px !important; }
body > nav > div:nth-child(2) > div:nth-child(3) { top: 132px !important; }
body > nav > div:nth-child(2) > div:nth-child(4) { top: 198px !important; }
body > nav > div:nth-child(2) > div:nth-child(5) { top: 264px !important; }

/* circle buttons: smaller like video */
body > nav > div:nth-child(2) > div::before {
    position: absolute !important;
    left: 0 !important;
    top: 0 !important;
    transform: none !important;
    width: 36px !important;
    height: 36px !important;
    border-radius: 999px !important;
    background: #0f172a !important;
    color: #ffffff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 18px !important;
    line-height: 1 !important;
    font-weight: 900 !important;
    border: 3px solid rgba(226,232,240,.50) !important;
    box-shadow: 0 0 0 3px rgba(15,23,42,.18) !important;
    z-index: 4 !important;
}

body > nav > div:nth-child(2) > div:nth-child(1)::before {
    content: "1" !important;
    background: #f8fafc !important;
    color: #111827 !important;
}
body > nav > div:nth-child(2) > div:nth-child(2)::before { content: "2" !important; }
body > nav > div:nth-child(2) > div:nth-child(3)::before { content: "3" !important; }
body > nav > div:nth-child(2) > div:nth-child(4)::before { content: "4" !important; }
body > nav > div:nth-child(2) > div:nth-child(5)::before { content: "5" !important; }

/* labels: exactly centered with their circle row */
body > nav > div:nth-child(2) > div:nth-child(1)::after,
body > nav > div:nth-child(2) > div:nth-child(2)::after,
body > nav > div:nth-child(2) > div:nth-child(3)::after,
body > nav > div:nth-child(2) > div:nth-child(4)::after,
body > nav > div:nth-child(2) > div:nth-child(5)::after {
    position: static !important;
    color: #ffffff !important;
    font-size: 20px !important;
    line-height: 1 !important;
    font-weight: 500 !important;
    letter-spacing: .01em !important;
    white-space: nowrap !important;
    text-transform: none !important;
    display: inline-block !important;
}

body > nav > div:nth-child(2) > div:nth-child(1)::after {
    content: "Heading" !important;
    font-weight: 850 !important;
}
body > nav > div:nth-child(2) > div:nth-child(2)::after { content: "Work history" !important; }
body > nav > div:nth-child(2) > div:nth-child(3)::after { content: "Education" !important; }
body > nav > div:nth-child(2) > div:nth-child(4)::after { content: "Skills" !important; }
body > nav > div:nth-child(2) > div:nth-child(5)::after { content: "Summary" !important; }

/* sixth circle and text: same row alignment */
body > nav > div:nth-child(2)::after {
    content: "6" !important;
    position: absolute !important;
    left: 0 !important;
    top: 330px !important;
    width: 36px !important;
    height: 36px !important;
    border-radius: 999px !important;
    background: #0f172a !important;
    color: #ffffff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 18px !important;
    line-height: 1 !important;
    font-weight: 900 !important;
    border: 3px solid rgba(226,232,240,.50) !important;
    box-shadow: 0 0 0 3px rgba(15,23,42,.18) !important;
    z-index: 4 !important;
}

body > nav::after {
    content: "Finalize" !important;
    position: absolute !important;
    left: 97px !important;
    top: 449px !important;
    color: #ffffff !important;
    font-size: 20px !important;
    line-height: 1 !important;
    font-weight: 500 !important;
    letter-spacing: .01em !important;
    white-space: nowrap !important;
    z-index: 12 !important;
}

/* Resume completeness: fit inside blue panel, no overflow */
body > nav > div:nth-child(3),
body > nav > div:last-child {
    position: absolute !important;
    left: 47px !important;
    top: 530px !important;
    right: auto !important;
    bottom: auto !important;
    width: 265px !important;
    height: auto !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    color: #ffffff !important;
    z-index: 9 !important;
    overflow: visible !important;
}

body > nav > div:nth-child(3) .relative,
body > nav > div:nth-child(3) svg,
body > nav > div:nth-child(3) #progressCircle,
body > nav > div:nth-child(3) #progressText,
body > nav > div:last-child .relative,
body > nav > div:last-child svg,
body > nav > div:last-child #progressCircle,
body > nav > div:last-child #progressText {
    display: none !important;
}

body > nav > div:nth-child(3) .text-xs,
body > nav > div:last-child .text-xs {
    display: block !important;
    width: 245px !important;
    max-width: 245px !important;
    color: #ffffff !important;
    font-size: 20px !important;
    line-height: 1.05 !important;
    font-weight: 950 !important;
    letter-spacing: -0.035em !important;
    text-transform: none !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    margin: 0 0 10px 0 !important;
}

body > nav > div:nth-child(3)::after,
body > nav > div:last-child::after {
    content: "" !important;
    display: block !important;
    width: 208px !important;
    height: 9px !important;
    border-radius: 999px !important;
    background: linear-gradient(90deg, #34d399 0%, #34d399 22%, #ffffff 22%, #ffffff 100%) !important;
    margin-top: 10px !important;
}

body > nav > div:nth-child(3)::before,
body > nav > div:last-child::before {
    content: "20%" !important;
    position: absolute !important;
    left: 216px !important;
    top: 36px !important;
    color: #ffffff !important;
    font-size: 16px !important;
    line-height: 1 !important;
    font-weight: 900 !important;
}

/* footer links/copyright inside the same panel */
body > .absolute.bottom-0 {
    position: fixed !important;
    left: 47px !important;
    top: 588px !important;
    bottom: auto !important;
    width: 252px !important;
    height: auto !important;
    padding: 0 !important;
    margin: 0 !important;
    background: transparent !important;
    border: 0 !important;
    display: block !important;
    z-index: 1001 !important;
    color: #ffffff !important;
    font-size: 0 !important;
    overflow: visible !important;
}

body > .absolute.bottom-0 > div:first-child {
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 10px !important;
    margin: 0 !important;
    padding: 0 !important;
}

body > .absolute.bottom-0 a {
    color: #34d399 !important;
    font-size: 16px !important;
    line-height: 1.15 !important;
    font-weight: 850 !important;
    text-decoration: none !important;
    white-space: nowrap !important;
}

body > .absolute.bottom-0 span {
    display: none !important;
}

body > .absolute.bottom-0 > div:last-child {
    display: block !important;
    margin-top: 26px !important;
    max-width: 242px !important;
    color: #ffffff !important;
    font-size: 13px !important;
    line-height: 1.35 !important;
    font-weight: 600 !important;
}

/* small height screens: compact only vertically, still no overlap */
@media (max-height: 760px) {
    body > nav > div:first-child { top: 28px !important; }
    body > nav .text-xl { font-size: 19px !important; }
    body > nav .fa-layer-group { font-size: 25px !important; }

    body > nav > div:nth-child(2) {
        top: 92px !important;
    }

    body > nav > div:nth-child(2)::before {
        left: 16px !important;
        top: 32px !important;
        height: 260px !important;
    }

    body > nav > div:nth-child(2) > div {
        height: 32px !important;
        min-height: 32px !important;
        padding-left: 46px !important;
    }

    body > nav > div:nth-child(2) > div:nth-child(1) { top: 0 !important; }
    body > nav > div:nth-child(2) > div:nth-child(2) { top: 56px !important; }
    body > nav > div:nth-child(2) > div:nth-child(3) { top: 112px !important; }
    body > nav > div:nth-child(2) > div:nth-child(4) { top: 168px !important; }
    body > nav > div:nth-child(2) > div:nth-child(5) { top: 224px !important; }

    body > nav > div:nth-child(2) > div::before,
    body > nav > div:nth-child(2)::after {
        width: 32px !important;
        height: 32px !important;
        font-size: 16px !important;
    }

    body > nav > div:nth-child(2)::after {
        top: 280px !important;
    }

    body > nav > div:nth-child(2) > div:nth-child(1)::after,
    body > nav > div:nth-child(2) > div:nth-child(2)::after,
    body > nav > div:nth-child(2) > div:nth-child(3)::after,
    body > nav > div:nth-child(2) > div:nth-child(4)::after,
    body > nav > div:nth-child(2) > div:nth-child(5)::after,
    body > nav::after {
        font-size: 18px !important;
    }

    body > nav::after {
        left: 93px !important;
        top: 372px !important;
    }

    body > nav > div:nth-child(3),
    body > nav > div:last-child {
        top: 430px !important;
    }

    body > nav > div:nth-child(3) .text-xs,
    body > nav > div:last-child .text-xs {
        font-size: 17px !important;
        width: 220px !important;
    }

    body > nav > div:nth-child(3)::after,
    body > nav > div:last-child::after {
        width: 190px !important;
        height: 8px !important;
    }

    body > nav > div:nth-child(3)::before,
    body > nav > div:last-child::before {
        left: 198px !important;
        top: 32px !important;
        font-size: 14px !important;
    }

    body > .absolute.bottom-0 {
        top: 500px !important;
    }

    body > .absolute.bottom-0 a {
        font-size: 14px !important;
    }

    body > .absolute.bottom-0 > div:first-child {
        gap: 8px !important;
    }

    body > .absolute.bottom-0 > div:last-child {
        margin-top: 18px !important;
        font-size: 11px !important;
        max-width: 230px !important;
    }
}
</style>


<script id="ghost-video-sidebar-clean-text-only">
/* Hides old original nav text nodes only; all app logic remains unchanged. */
(function () {
    function cleanStepText() {
        document.querySelectorAll("body > nav > div:nth-child(2) > div").forEach(function (step) {
            Array.from(step.childNodes).forEach(function (node) {
                if (node.nodeType === Node.TEXT_NODE) node.textContent = "";
            });
            step.querySelectorAll("span, p, small, a").forEach(function (el) {
                el.style.display = "none";
            });
        });
    }

    function cleanLogoSpacing() {
        const logo = document.querySelector("body > nav .text-xl");
        if (!logo) return;
        logo.childNodes.forEach(function (node) {
            if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() === "ResumeBuilder") {
                node.textContent = " Resume Builder";
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        cleanStepText();
        cleanLogoSpacing();
    });
    setTimeout(function () {
        cleanStepText();
        cleanLogoSpacing();
    }, 300);
})();
</script>


<!-- GHOST EXACT LEFT BLUE BAR LIKE REFERENCE - UI ONLY -->
<style id="ghost-exact-left-blue-bar-reference">
/* Only left blue sidebar + footer/progress positioning. Form/preview/right side logic untouched. */

:root {
    --ghost-ref-blue: #073f70;
    --ghost-ref-purple: #a855f7;
    --ghost-ref-green: #34d399;
    --ghost-ref-circle: #0f172a;
}

/* sidebar exact narrow blue panel */
body > nav {
    position: fixed !important;
    left: 0 !important;
    top: 0 !important;
    bottom: 0 !important;
    width: 360px !important;
    max-width: 360px !important;
    height: 100vh !important;
    min-height: 100vh !important;
    background: var(--ghost-ref-blue) !important;
    border: 0 !important;
    border-right: 0 !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin: 0 !important;
    overflow: hidden !important;
    z-index: 90 !important;
    display: block !important;
}

/* logo like 1st screenshot */
body > nav > div:first-child {
    position: absolute !important;
    left: 52px !important;
    top: 37px !important;
    width: 255px !important;
    height: 42px !important;
    margin: 0 !important;
    padding: 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 0 !important;
}

body > nav .text-xl {
    color: var(--ghost-ref-purple) !important;
    font-size: 24px !important;
    line-height: 1 !important;
    font-weight: 800 !important;
    letter-spacing: -0.02em !important;
    white-space: nowrap !important;
    overflow: visible !important;
}

body > nav .fa-layer-group {
    color: #ec4899 !important;
    font-size: 31px !important;
    margin-right: 14px !important;
    filter: none !important;
}

/* step container */
body > nav > div:nth-child(2) {
    position: absolute !important;
    left: 49px !important;
    top: 114px !important;
    width: 270px !important;
    height: 390px !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    color: #fff !important;
    font-size: 0 !important;
    text-transform: none !important;
    letter-spacing: 0 !important;
    z-index: 10 !important;
}

/* dotted center line */
body > nav > div:nth-child(2)::before {
    content: "" !important;
    position: absolute !important;
    left: 18px !important;
    top: 41px !important;
    width: 4px !important;
    height: 323px !important;
    border-radius: 999px !important;
    background: repeating-linear-gradient(
        to bottom,
        rgba(255, 255, 255, .23) 0px,
        rgba(255, 255, 255, .23) 8px,
        transparent 8px,
        transparent 18px
    ) !important;
    z-index: 1 !important;
}

/* step rows */
body > nav > div:nth-child(2) > div {
    position: absolute !important;
    left: 0 !important;
    width: 270px !important;
    height: 42px !important;
    min-height: 42px !important;
    padding: 0 0 0 53px !important;
    margin: 0 !important;
    border: 0 !important;
    display: flex !important;
    align-items: center !important;
    color: #fff !important;
    opacity: 1 !important;
    font-size: 0 !important;
    line-height: 1 !important;
    overflow: visible !important;
    z-index: 3 !important;
    cursor: default !important;
}

body > nav > div:nth-child(2) > div:nth-child(1) { top: 0 !important; }
body > nav > div:nth-child(2) > div:nth-child(2) { top: 70px !important; }
body > nav > div:nth-child(2) > div:nth-child(3) { top: 140px !important; }
body > nav > div:nth-child(2) > div:nth-child(4) { top: 210px !important; }
body > nav > div:nth-child(2) > div:nth-child(5) { top: 280px !important; }

/* circle numbers */
body > nav > div:nth-child(2) > div::before,
body > nav > div:nth-child(2)::after {
    width: 42px !important;
    height: 42px !important;
    border-radius: 999px !important;
    background: var(--ghost-ref-circle) !important;
    color: #ffffff !important;
    border: 3px solid rgba(226, 232, 240, .48) !important;
    box-shadow: 0 0 0 4px rgba(15, 23, 42, .20) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 20px !important;
    line-height: 1 !important;
    font-weight: 900 !important;
    z-index: 4 !important;
}

body > nav > div:nth-child(2) > div::before {
    position: absolute !important;
    left: 0 !important;
    top: 0 !important;
    transform: none !important;
}

body > nav > div:nth-child(2) > div:nth-child(1)::before {
    content: "1" !important;
    background: #f8fafc !important;
    color: #111827 !important;
}
body > nav > div:nth-child(2) > div:nth-child(2)::before { content: "2" !important; }
body > nav > div:nth-child(2) > div:nth-child(3)::before { content: "3" !important; }
body > nav > div:nth-child(2) > div:nth-child(4)::before { content: "4" !important; }
body > nav > div:nth-child(2) > div:nth-child(5)::before { content: "5" !important; }

/* labels from pseudo elements so original nav text cannot disturb layout */
body > nav > div:nth-child(2) > div:nth-child(1)::after,
body > nav > div:nth-child(2) > div:nth-child(2)::after,
body > nav > div:nth-child(2) > div:nth-child(3)::after,
body > nav > div:nth-child(2) > div:nth-child(4)::after,
body > nav > div:nth-child(2) > div:nth-child(5)::after {
    position: static !important;
    display: inline-block !important;
    color: #ffffff !important;
    font-size: 22px !important;
    line-height: 1 !important;
    font-weight: 400 !important;
    letter-spacing: 0 !important;
    white-space: nowrap !important;
    text-transform: none !important;
}

body > nav > div:nth-child(2) > div:nth-child(1)::after { content: "Heading" !important; font-weight: 850 !important; }
body > nav > div:nth-child(2) > div:nth-child(2)::after { content: "Work history" !important; }
body > nav > div:nth-child(2) > div:nth-child(3)::after { content: "Education" !important; }
body > nav > div:nth-child(2) > div:nth-child(4)::after { content: "Skills" !important; }
body > nav > div:nth-child(2) > div:nth-child(5)::after { content: "Summary" !important; }

/* step 6 */
body > nav > div:nth-child(2)::after {
    content: "6" !important;
    position: absolute !important;
    left: 0 !important;
    top: 350px !important;
}

body > nav::after {
    content: "Finalize" !important;
    position: absolute !important;
    left: 102px !important;
    top: 474px !important;
    color: #ffffff !important;
    font-size: 22px !important;
    line-height: 1 !important;
    font-weight: 400 !important;
    letter-spacing: 0 !important;
    white-space: nowrap !important;
    z-index: 12 !important;
}

/* progress area */
body > nav > div:nth-child(3),
body > nav > div:last-child {
    position: absolute !important;
    left: 49px !important;
    top: 560px !important;
    width: 265px !important;
    right: auto !important;
    bottom: auto !important;
    height: auto !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    color: #ffffff !important;
    z-index: 9 !important;
    overflow: visible !important;
}

body > nav > div:nth-child(3) .relative,
body > nav > div:last-child .relative {
    display: none !important;
}

body > nav > div:nth-child(3) .text-xs,
body > nav > div:last-child .text-xs {
    display: block !important;
    color: #ffffff !important;
    font-size: 22px !important;
    line-height: 1.05 !important;
    font-weight: 900 !important;
    letter-spacing: -0.03em !important;
    text-transform: none !important;
    white-space: nowrap !important;
    margin: 0 0 13px 0 !important;
}

body > nav > div:nth-child(3) .text-xs::after,
body > nav > div:last-child .text-xs::after {
    content: ":" !important;
}

body > nav > div:nth-child(3)::after,
body > nav > div:last-child::after {
    content: "" !important;
    display: block !important;
    width: 220px !important;
    height: 11px !important;
    border-radius: 999px !important;
    background: linear-gradient(90deg, var(--ghost-ref-green) 0%, var(--ghost-ref-green) 22%, #ffffff 22%, #ffffff 100%) !important;
}

body > nav > div:nth-child(3)::before,
body > nav > div:last-child::before {
    content: "20%" !important;
    position: absolute !important;
    left: 228px !important;
    top: 34px !important;
    color: #ffffff !important;
    font-size: 18px !important;
    line-height: 1 !important;
    font-weight: 900 !important;
}

/* footer links moved inside blue bar */
body > .absolute.bottom-0 {
    position: fixed !important;
    left: 49px !important;
    top: 619px !important;
    bottom: auto !important;
    right: auto !important;
    width: 260px !important;
    height: auto !important;
    padding: 0 !important;
    margin: 0 !important;
    background: transparent !important;
    border: 0 !important;
    display: block !important;
    color: #ffffff !important;
    font-size: 0 !important;
    z-index: 1001 !important;
    overflow: visible !important;
}

body > .absolute.bottom-0 > div:first-child {
    display: flex !important;
    flex-direction: column !important;
    gap: 14px !important;
    align-items: flex-start !important;
    margin: 0 !important;
    padding: 0 !important;
}

body > .absolute.bottom-0 a {
    color: var(--ghost-ref-green) !important;
    font-size: 18px !important;
    line-height: 1.05 !important;
    font-weight: 850 !important;
    letter-spacing: 0 !important;
    text-decoration: none !important;
    white-space: nowrap !important;
    text-transform: none !important;
}

body > .absolute.bottom-0 span {
    display: none !important;
}

body > .absolute.bottom-0 > div:last-child {
    display: block !important;
    margin-top: 34px !important;
    max-width: 245px !important;
    color: #ffffff !important;
    font-size: 16px !important;
    line-height: 1.35 !important;
    font-weight: 500 !important;
}

/* reserve exact panel width for the page */
body > .flex.flex-grow {
    margin-left: 360px !important;
    width: calc(100vw - 360px) !important;
}

/* hide original text children in step labels */
body > nav > div:nth-child(2) > div {
    color: transparent !important;
}
body > nav > div:nth-child(2) > div::after {
    color: #ffffff !important;
}

/* compact fallback for short screens */
@media (max-height: 820px) {
    body > nav > div:first-child { top: 34px !important; }
    body > nav > div:nth-child(2) { top: 106px !important; }
    body > nav > div:nth-child(2) > div:nth-child(1) { top: 0 !important; }
    body > nav > div:nth-child(2) > div:nth-child(2) { top: 64px !important; }
    body > nav > div:nth-child(2) > div:nth-child(3) { top: 128px !important; }
    body > nav > div:nth-child(2) > div:nth-child(4) { top: 192px !important; }
    body > nav > div:nth-child(2) > div:nth-child(5) { top: 256px !important; }
    body > nav > div:nth-child(2)::before { height: 292px !important; }
    body > nav > div:nth-child(2)::after { top: 320px !important; }
    body > nav::after { top: 432px !important; }
    body > nav > div:nth-child(3),
    body > nav > div:last-child { top: 518px !important; }
    body > .absolute.bottom-0 { top: 578px !important; }
}


/* GHOST FINAL FIX: MAKE BROWSER 100% LOOK LIKE YOUR 75% VIEW - UI ONLY */
html {
    width: 100% !important;
    height: 100% !important;
    overflow: hidden !important;
    background: #ffffff !important;
    zoom: 0.75 !important;
}

body {
    zoom: 1 !important;
    width: 133.3333333333vw !important;
    height: 133.3333333333vh !important;
    min-width: 1680px !important;
    min-height: 995px !important;
    overflow: hidden !important;
    background: #ffffff !important;
}

body > nav {
    height: 133.3333333333vh !important;
    min-height: 133.3333333333vh !important;
}

body > .flex.flex-grow {
    height: 133.3333333333vh !important;
}

body > .flex.flex-grow > div:first-child {
    height: 133.3333333333vh !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
}

.builder-right-preview-panel {
    height: 133.3333333333vh !important;
}

.builder-right-preview-panel .preview-pane-container.real-template-mode {
    margin-top: 82px !important;
}

@media (max-width: 1024px) {
    html {
        zoom: 1 !important;
        overflow: auto !important;
    }

    body {
        zoom: 1 !important;
        width: 100% !important;
        height: auto !important;
        min-width: 0 !important;
        min-height: 0 !important;
        overflow: auto !important;
    }

    body > nav,
    body > .flex.flex-grow,
    body > .flex.flex-grow > div:first-child,
    .builder-right-preview-panel {
        height: auto !important;
        min-height: auto !important;
    }
}



        /* GHOST WHITE AREA FIT FIX - BLUE SIDEBAR UNCHANGED */
        /* This block only controls the content area after the blue sidebar. */
        html {
            width: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }

        body {
            width: 100vw !important;
            max-width: 100vw !important;
            min-width: 0 !important;
            height: 100vh !important;
            min-height: 100vh !important;
            overflow: hidden !important;
            background: #ffffff !important;
        }

        body > .flex.flex-grow {
            position: fixed !important;
            top: 0 !important;
            left: 360px !important;
            margin-left: 0 !important;
            width: calc(100vw - 360px) !important;
            max-width: calc(100vw - 360px) !important;
            height: 100vh !important;
            min-height: 100vh !important;
            overflow: hidden !important;
            display: flex !important;
            background: #ffffff !important;
            z-index: 10 !important;
        }

        body > .flex.flex-grow > div:first-child {
            width: 58% !important;
            max-width: 58% !important;
            height: 100vh !important;
            min-height: 100vh !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            padding: 74px 42px 110px 42px !important;
            background: #ffffff !important;
        }

        body > .flex.flex-grow > div:first-child .max-w-2xl {
            width: 100% !important;
            max-width: 820px !important;
            margin-left: 0 !important;
            margin-right: auto !important;
        }

        .builder-right-preview-panel {
            flex: 1 1 auto !important;
            width: 42% !important;
            max-width: none !important;
            height: 100vh !important;
            min-height: 100vh !important;
            overflow: hidden !important;
            padding: 48px 28px 86px !important;
            background: #f1f5f9 !important;
            border-left: 1px solid #e5e7eb !important;
        }

        .builder-right-preview-panel .preview-pane-container.real-template-mode {
            width: min(100%, 560px) !important;
            height: min(500px, calc(100vh - 205px)) !important;
            min-height: 405px !important;
            max-height: 500px !important;
            margin-top: 0 !important;
            padding: 14px !important;
        }

        .builder-right-preview-panel .modern-live-preview {
            width: 340px !important;
            height: 478px !important;
            max-width: 94% !important;
            max-height: 100% !important;
            transform: none !important;
        }

        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            max-width: 355px !important;
            margin-top: 16px !important;
            gap: 14px !important;
        }

        #btnPreview,
        #btnNext {
            height: 48px !important;
            font-size: 12px !important;
            padding: 0 22px !important;
        }

        #btnPreview { min-width: 122px !important; }
        #btnNext { min-width: 168px !important; }

        a[href="/upload-or-scratch"] {
            position: static !important;
            left: auto !important;
            top: auto !important;
            font-size: 15px !important;
            margin-bottom: 18px !important;
        }

        h1 {
            margin-top: 0 !important;
            font-size: clamp(28px, 2.1vw, 38px) !important;
            max-width: 780px !important;
        }

        h1 + p {
            font-size: 18px !important;
            margin-bottom: 26px !important;
        }

        #contactForm {
            max-width: 800px !important;
            gap: 22px !important;
        }

        .form-label {
            font-size: 14px !important;
            margin-bottom: 8px !important;
        }

        .form-input,
        .country-select {
            height: 54px !important;
            font-size: 16px !important;
        }

        @media (max-width: 1200px) {
            body > .flex.flex-grow {
                left: 318px !important;
                width: calc(100vw - 318px) !important;
                max-width: calc(100vw - 318px) !important;
            }
        }
</style>

<script id="ghost-exact-left-blue-bar-text-cleaner">
(function () {
    function cleanGhostSidebarText() {
        document.querySelectorAll("body > nav > div:nth-child(2) > div").forEach(function (step) {
            Array.from(step.childNodes).forEach(function (node) {
                if (node.nodeType === Node.TEXT_NODE) node.textContent = "";
            });
            step.querySelectorAll("span, p, small, a").forEach(function (el) {
                el.style.display = "none";
            });
        });

        const logo = document.querySelector("body > nav .text-xl");
        if (logo) {
            Array.from(logo.childNodes).forEach(function (node) {
                if (node.nodeType === Node.TEXT_NODE && node.textContent.replace(/\s+/g, "").includes("ResumeBuilder")) {
                    node.textContent = " Resume Builder";
                }
            });
        }
    }

    document.addEventListener("DOMContentLoaded", cleanGhostSidebarText);
    setTimeout(cleanGhostSidebarText, 250);
    setTimeout(cleanGhostSidebarText, 800);
})();
</script>



<!-- GHOST WHITE AREA RIGHT EXPAND FIX - BLUE SIDEBAR UNCHANGED -->
<style id="ghost-white-area-right-expand-only">
    /* Do not edit the blue sidebar. This only stretches the white content area to the far right. */
    html {
        width: 100% !important;
        height: 100% !important;
        overflow: hidden !important;
        background: #ffffff !important;
    }

    body {
        /* keep the current 75%-style page scale, but restore enough canvas width so no blank right area appears */
        width: 133.3333333333vw !important;
        max-width: none !important;
        min-width: 1680px !important;
        height: 133.3333333333vh !important;
        min-height: 995px !important;
        overflow: hidden !important;
        background: #ffffff !important;
    }

    body > .flex.flex-grow {
        position: fixed !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 360px !important;
        right: 0 !important;
        margin-left: 0 !important;
        width: calc(133.3333333333vw - 360px) !important;
        max-width: none !important;
        height: 133.3333333333vh !important;
        min-height: 995px !important;
        display: flex !important;
        overflow: hidden !important;
        background: #ffffff !important;
        z-index: 10 !important;
    }

    body > .flex.flex-grow > div:first-child {
        width: 56% !important;
        max-width: 56% !important;
        height: 133.3333333333vh !important;
        min-height: 995px !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        background: #ffffff !important;
    }

    .builder-right-preview-panel {
        flex: 1 1 auto !important;
        width: 44% !important;
        max-width: none !important;
        height: 133.3333333333vh !important;
        min-height: 995px !important;
        overflow: hidden !important;
        background: #f1f5f9 !important;
    }

    @media (max-width: 1200px) {
        body > .flex.flex-grow {
            left: 318px !important;
            width: calc(133.3333333333vw - 318px) !important;
        }
    }

    @media (max-width: 1024px) {
        body {
            width: 100% !important;
            height: auto !important;
            min-width: 0 !important;
            min-height: 0 !important;
            overflow: auto !important;
        }

        body > .flex.flex-grow {
            position: relative !important;
            left: 0 !important;
            right: auto !important;
            width: 100% !important;
            height: auto !important;
            min-height: 0 !important;
            display: block !important;
        }

        body > .flex.flex-grow > div:first-child {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            min-height: 0 !important;
        }
    }
</style>


<!-- GHOST FINAL RIGHT PREVIEW WHITE BACKGROUND FIX - BLUE SIDEBAR UNCHANGED -->
<style id="ghost-right-preview-white-lower-final">
    /* Blue sidebar untouched. Only white/content and right preview area are adjusted. */
    body > .flex.flex-grow {
        background: #ffffff !important;
    }

    /* Center/form side ko thora zyada width, right side ko thora kam width */
    body > .flex.flex-grow > div:first-child {
        width: 60% !important;
        max-width: 60% !important;
        background: #ffffff !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    .builder-right-preview-panel {
        width: 40% !important;
        max-width: 40% !important;
        flex: 0 0 40% !important;
        background: #ffffff !important;
        border-left: 1px solid #e5e7eb !important;
        padding: 96px 30px 90px 26px !important;
        overflow: hidden !important;
        align-items: center !important;
        justify-content: flex-start !important;
    }

    /* Extra popup/card background remove: live editing only on template */
    .builder-right-preview-panel::before {
        display: none !important;
        content: none !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode {
        margin-top: 34px !important;
        width: min(100%, 560px) !important;
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
        padding: 0 !important;
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: visible !important;
    }

    .builder-right-preview-panel .modern-live-preview {
        width: 420px !important;
        height: 590px !important;
        max-width: 92% !important;
        transform: none !important;
        box-shadow: 0 24px 60px rgba(15, 23, 42, .14) !important;
        border-radius: 8px !important;
        background: #ffffff !important;
    }

    /* Buttons ko template ke neeche shift, compact width */
    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        width: 100% !important;
        max-width: 390px !important;
        margin-top: 42px !important;
        padding: 0 !important;
        gap: 18px !important;
        justify-content: center !important;
        align-items: center !important;
        position: relative !important;
        z-index: 4 !important;
    }

    #btnPreview,
    #btnNext {
        height: 50px !important;
        padding: 0 24px !important;
        font-size: 12px !important;
        border-radius: 999px !important;
        white-space: nowrap !important;
    }

    #btnPreview {
        min-width: 126px !important;
        max-width: 126px !important;
    }

    #btnNext {
        min-width: 172px !important;
        max-width: 172px !important;
    }

    @media (max-width: 1280px) {
        body > .flex.flex-grow > div:first-child {
            width: 61% !important;
            max-width: 61% !important;
        }

        .builder-right-preview-panel {
            width: 39% !important;
            max-width: 39% !important;
            flex-basis: 39% !important;
        }

        .builder-right-preview-panel .modern-live-preview {
            width: 390px !important;
            height: 548px !important;
        }
    }
</style>



<!-- GHOST FINAL FIX: REMOVE RIGHT CENTER LINE + TEMPLATE SHADOW - BLUE SIDEBAR UNCHANGED -->
<style id="ghost-remove-right-line-template-shadow-final">
    /* Blue sidebar/nav untouched. Only right white area and preview shadow/line fixed. */
    body > .flex.flex-grow {
        background: #ffffff !important;
    }

    body > .flex.flex-grow > div:first-child {
        background: #ffffff !important;
        border-right: 0 !important;
        box-shadow: none !important;
    }

    .builder-right-preview-panel {
        background: #ffffff !important;
        border-left: 0 !important;
        border-right: 0 !important;
        box-shadow: none !important;
    }

    .builder-right-preview-panel::before,
    .builder-right-preview-panel::after {
        display: none !important;
        content: none !important;
        background: transparent !important;
        box-shadow: none !important;
        border: 0 !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode {
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        outline: 0 !important;
    }

    .builder-right-preview-panel .modern-live-preview {
        box-shadow: none !important;
        filter: none !important;
        background: #ffffff !important;
    }

    .preview-pane-container,
    .preview-paper-wrap,
    .template-full-view-card,
    .exact-template-preview {
        box-shadow: none !important;
    }
</style>


<!-- GHOST CENTER FORM BIGGER FIX - BLUE SIDEBAR UNCHANGED -->
<style id="ghost-center-form-bigger-final">
    /* Blue sidebar ko touch nahi kiya. Sirf white center/form area aur right width balance. */
    body > .flex.flex-grow {
        background: #ffffff !important;
    }

    /* Center/form side ki usable width zyada */
    body > .flex.flex-grow > div:first-child {
        width: 64% !important;
        max-width: 64% !important;
        flex: 0 0 64% !important;
        padding: 88px 54px 120px 48px !important;
        background: #ffffff !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    body > .flex.flex-grow > div:first-child .max-w-2xl {
        max-width: 940px !important;
        width: 100% !important;
        margin-left: 0 !important;
        margin-right: auto !important;
    }

    /* Right side thori compact, background white same */
    .builder-right-preview-panel {
        width: 36% !important;
        max-width: 36% !important;
        flex: 0 0 36% !important;
        background: #ffffff !important;
        border-left: 0 !important;
        box-shadow: none !important;
        padding-left: 18px !important;
        padding-right: 24px !important;
    }

    /* Top text bigger */
    a[href="/upload-or-scratch"] {
        font-size: 18px !important;
        font-weight: 900 !important;
        margin-bottom: 26px !important;
    }

    h1 {
        font-size: 38px !important;
        line-height: 1.12 !important;
        max-width: 920px !important;
        margin-top: 18px !important;
        margin-bottom: 12px !important;
        letter-spacing: -0.055em !important;
    }

    h1 + p {
        font-size: 22px !important;
        line-height: 1.45 !important;
        margin-bottom: 34px !important;
    }

    p.text-red-500 {
        font-size: 16px !important;
        margin-bottom: 24px !important;
    }

    /* Form aur fields bigger */
    #contactForm {
        max-width: 930px !important;
        width: 100% !important;
        gap: 32px !important;
    }

    #contactForm .flex {
        gap: 26px !important;
    }

    .form-label {
        font-size: 18px !important;
        line-height: 1.15 !important;
        font-weight: 900 !important;
        margin-bottom: 12px !important;
        color: #020617 !important;
    }

    .form-input,
    .country-select {
        height: 68px !important;
        min-height: 68px !important;
        font-size: 22px !important;
        font-weight: 500 !important;
        padding: 0 22px !important;
        border-radius: 10px !important;
        border: 1.8px solid #cbd5e1 !important;
        background: #f8fbff !important;
    }

    .form-input::placeholder {
        font-size: 21px !important;
        color: #94a3b8 !important;
    }

    .country-select {
        min-width: 150px !important;
        font-size: 21px !important;
        font-weight: 950 !important;
        border-radius: 10px 0 0 10px !important;
        background: #f8fafc !important;
    }

    #inp_phone {
        border-radius: 0 10px 10px 0 !important;
    }

    /* Rows ke beech thori height breathing space */
    #contactForm > .flex {
        margin-bottom: 10px !important;
    }

    @media (max-width: 1280px) {
        body > .flex.flex-grow > div:first-child {
            width: 63% !important;
            max-width: 63% !important;
            flex-basis: 63% !important;
            padding-left: 42px !important;
            padding-right: 34px !important;
        }

        .builder-right-preview-panel {
            width: 37% !important;
            max-width: 37% !important;
            flex-basis: 37% !important;
        }

        h1 {
            font-size: 34px !important;
        }

        .form-input,
        .country-select {
            height: 64px !important;
            min-height: 64px !important;
            font-size: 20px !important;
        }
    }
</style>



<!-- GHOST FINAL CONTACT FORM ROW FIX - UI ONLY, OLD LOGIC UNCHANGED -->
<style>
    /* Center form labels: smaller and less bold so labels stay on one line */
    #contactForm .form-label {
        font-size: 14px !important;
        font-weight: 650 !important;
        line-height: 1.12 !important;
        margin-bottom: 8px !important;
        white-space: nowrap !important;
        letter-spacing: 0 !important;
    }

    /* Keep inputs large, but make the row layout clean */
    #contactForm .form-input,
    #contactForm .country-select {
        height: 62px !important;
        font-size: 20px !important;
        padding-left: 20px !important;
        padding-right: 20px !important;
    }

    /* Row 2 custom layout: City full width, Postal Code + Country together below */
    #contactForm > .flex:nth-of-type(2) {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 26px 24px !important;
        width: 100% !important;
    }

    /* Make the inner City/Postal wrapper dissolve so fields can be laid out correctly */
    #contactForm > .flex:nth-of-type(2) > div:first-child {
        display: contents !important;
    }

    /* City gets full row space */
    #contactForm > .flex:nth-of-type(2) > div:first-child > div:first-child {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }

    /* Postal Code stays left on second line */
    #contactForm > .flex:nth-of-type(2) > div:first-child > div:nth-child(2) {
        width: calc(32% - 12px) !important;
        flex: 0 0 calc(32% - 12px) !important;
        max-width: calc(32% - 12px) !important;
    }

    /* Country stays with Postal Code on same line */
    #contactForm > .flex:nth-of-type(2) > div:nth-child(2) {
        width: calc(68% - 12px) !important;
        flex: 0 0 calc(68% - 12px) !important;
        max-width: calc(68% - 12px) !important;
    }

    /* First and third rows keep clean two-column layout */
    #contactForm > .flex:nth-of-type(1),
    #contactForm > .flex:nth-of-type(3) {
        gap: 24px !important;
    }

    #contactForm > .flex:nth-of-type(1) > div,
    #contactForm > .flex:nth-of-type(3) > div {
        width: calc(50% - 12px) !important;
        flex: 0 0 calc(50% - 12px) !important;
        max-width: calc(50% - 12px) !important;
    }

    /* Phone select/input stays balanced */
    #inp_country_code {
        min-width: 145px !important;
        max-width: 145px !important;
        flex: 0 0 145px !important;
    }

    #inp_phone {
        flex: 1 1 auto !important;
        min-width: 0 !important;
    }
</style>


<!-- GHOST SCROLL FIX: white page scroll only, blue sidebar fixed -->
<style>
    /* Blue sidebar stays constant/fixed. Do not change its layout. */
    html,
    body {
        overflow: hidden !important;
    }

    body > nav {
        position: fixed !important;
        overflow: hidden !important;
    }

    /* Only the white builder page should move/scroll. */
    body > .flex.flex-grow {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        scrollbar-gutter: stable !important;
    }

    body > .flex.flex-grow::-webkit-scrollbar {
        width: 8px !important;
    }

    body > .flex.flex-grow::-webkit-scrollbar-track {
        background: #f8fafc !important;
    }

    body > .flex.flex-grow::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important;
        border-radius: 999px !important;
    }

    body > .flex.flex-grow::-webkit-scrollbar-thumb:hover {
        background: #94a3b8 !important;
    }

    /* Let the form section scroll with the white page instead of creating another inner scroll. */
    body > .flex.flex-grow > div:first-child {
        overflow-y: visible !important;
        overflow-x: hidden !important;
    }

    .builder-right-preview-panel {
        overflow: visible !important;
    }

    @media (max-width: 1024px) {
        html,
        body {
            overflow: auto !important;
        }

        body > .flex.flex-grow {
            overflow: visible !important;
        }
    }
</style>


<!-- GHOST FINAL SCROLL FIX: only center white form scrolls, blue sidebar unchanged -->
<style>
    /* Keep global page locked so blue sidebar never moves */
    html,
    body {
        overflow: hidden !important;
    }

    body > nav {
        position: fixed !important;
        overflow: hidden !important;
    }

    /* Main white area stays in place; scrolling happens only inside form column */
    body > .flex.flex-grow {
        overflow: hidden !important;
        height: 133.3333333333vh !important;
        max-height: 133.3333333333vh !important;
    }

    /* This is the actual scrollable white page/form area */
    body > .flex.flex-grow > div:first-child {
        height: 133.3333333333vh !important;
        max-height: 133.3333333333vh !important;
        overflow-y: scroll !important;
        overflow-x: hidden !important;
        padding-bottom: 340px !important;
        scrollbar-gutter: stable !important;
    }

    body > .flex.flex-grow > div:first-child::-webkit-scrollbar {
        width: 8px !important;
    }

    body > .flex.flex-grow > div:first-child::-webkit-scrollbar-track {
        background: #ffffff !important;
    }

    body > .flex.flex-grow > div:first-child::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important;
        border-radius: 999px !important;
    }

    body > .flex.flex-grow > div:first-child::-webkit-scrollbar-thumb:hover {
        background: #94a3b8 !important;
    }

    /* Right preview stays visible, no page-scroll dependency */
    .builder-right-preview-panel {
        height: 133.3333333333vh !important;
        max-height: 133.3333333333vh !important;
        overflow: hidden !important;
    }

    @media (max-width: 1024px) {
        html,
        body {
            overflow: auto !important;
        }

        body > .flex.flex-grow,
        body > .flex.flex-grow > div:first-child,
        .builder-right-preview-panel {
            height: auto !important;
            max-height: none !important;
            overflow: visible !important;
        }
    }


        /* GHOST FINAL SMALL FIX: BLUE SIDEBAR FOOTER TEXT ONLY */
        body > nav > div:last-child {
            left: 48px !important;
            right: 48px !important;
            width: auto !important;
            text-align: left !important;
        }

        body > nav > div:last-child .text-xs {
            font-size: 20px !important;
            line-height: 1.05 !important;
            font-weight: 950 !important;
            letter-spacing: -0.035em !important;
            white-space: nowrap !important;
            overflow: visible !important;
            max-width: 100% !important;
        }

        body > nav > div:last-child::after {
            width: 205px !important;
            height: 10px !important;
            margin-top: 10px !important;
        }

        body > nav > div:last-child::before {
            left: 214px !important;
            top: 35px !important;
            font-size: 17px !important;
            line-height: 1 !important;
            white-space: nowrap !important;
        }

        body > .absolute.bottom-0 > div:first-child {
            align-items: center !important;
            gap: 10px !important;
            width: 100% !important;
        }

        body > .absolute.bottom-0 a {
            font-size: 17px !important;
            line-height: 1.12 !important;
            font-weight: 850 !important;
            text-align: center !important;
            letter-spacing: .03em !important;
            white-space: nowrap !important;
            width: 100% !important;
        }

        body > .absolute.bottom-0 > div:last-child {
            margin-top: 28px !important;
            font-size: 15px !important;
            line-height: 1.25 !important;
            max-width: 245px !important;
        }


        /* GHOST FINAL TINY FIX: align blue sidebar footer links with Resume line only */
        body > .absolute.bottom-0 {
            left: 48px !important;
            width: 260px !important;
            text-align: left !important;
        }

        body > .absolute.bottom-0 > div:first-child {
            align-items: flex-start !important;
            text-align: left !important;
            gap: 9px !important;
            width: 100% !important;
        }

        body > .absolute.bottom-0 a {
            display: block !important;
            width: auto !important;
            text-align: left !important;
            font-size: 16px !important;
            line-height: 1.08 !important;
            font-weight: 850 !important;
            letter-spacing: .025em !important;
            white-space: nowrap !important;
        }

        body > .absolute.bottom-0 > div:last-child {
            text-align: left !important;
            margin-top: 28px !important;
            max-width: 245px !important;
        }
</style>



<!-- GHOST FINAL FIX: level all sidebar footer links equally with Resume Completeness line -->
<style>
    body > .absolute.bottom-0 {
        left: 48px !important;
        width: 260px !important;
        text-align: left !important;
    }

    body > .absolute.bottom-0 > div:first-child {
        display: block !important;
        width: 260px !important;
        margin: 0 !important;
        padding: 0 !important;
        text-align: left !important;
        align-items: flex-start !important;
        justify-content: flex-start !important;
    }

    body > .absolute.bottom-0 a {
        display: block !important;
        width: 260px !important;
        margin: 0 0 9px 0 !important;
        padding: 0 !important;
        text-align: left !important;
        transform: none !important;
        font-size: 16px !important;
        line-height: 1.08 !important;
        font-weight: 850 !important;
        letter-spacing: .025em !important;
        white-space: nowrap !important;
    }

    body > .absolute.bottom-0 span {
        display: none !important;
    }

    body > .absolute.bottom-0 > div:last-child {
        text-align: left !important;
        margin-top: 24px !important;
        padding: 0 !important;
        max-width: 245px !important;
    }
</style>



<!-- GHOST PHONE FIELD FIX: remove visible country dropdown, keep simple phone input only -->
<style>
    /* Blue sidebar and old logic unchanged. Only phone field UI is simplified. */
    #inp_country_code {
        display: none !important;
        width: 0 !important;
        min-width: 0 !important;
        max-width: 0 !important;
        flex: 0 0 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        border: 0 !important;
    }

    #inp_phone {
        width: 100% !important;
        flex: 1 1 100% !important;
        max-width: 100% !important;
        border-radius: 8px !important;
    }


        /* GHOST FINAL FORM ORDER FIX - ADD ONLY, BLUE SIDEBAR UNTOUCHED */
        #contactForm.contact-final-layout {
            max-width: 900px !important;
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 28px !important;
        }

        #contactForm.contact-final-layout .contact-row,
        #contactForm.contact-final-layout .contact-two-col-row {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
            gap: 28px !important;
            align-items: start !important;
            width: 100% !important;
        }

        #contactForm.contact-final-layout .contact-col,
        #contactForm.contact-final-layout .contact-full-row {
            width: 100% !important;
            min-width: 0 !important;
        }

        #contactForm.contact-final-layout .contact-full-row {
            display: block !important;
        }

        #contactForm.contact-final-layout .form-label {
            font-size: 14px !important;
            line-height: 1.1 !important;
            font-weight: 700 !important;
            margin-bottom: 10px !important;
            color: #0f172a !important;
            white-space: nowrap !important;
        }

        #contactForm.contact-final-layout .form-input {
            height: 62px !important;
            width: 100% !important;
            font-size: 19px !important;
            padding: 0 22px !important;
            border-radius: 8px !important;
            box-sizing: border-box !important;
        }

        #contactForm.contact-final-layout #inp_email {
            width: 100% !important;
            display: block !important;
        }

        @media (max-width: 1024px) {
            #contactForm.contact-final-layout .contact-row,
            #contactForm.contact-final-layout .contact-two-col-row {
                grid-template-columns: 1fr !important;
            }
        }
</style>

<!-- GHOST FINAL CITY + POSTAL SAME ROW FIX - ADD ONLY, BLUE SIDEBAR UNCHANGED -->
<style>
    /* Force clean two-column rows after all older form overrides */
    #contactForm.contact-final-layout > .contact-row.contact-two-col-row {
        display: grid !important;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
        column-gap: 28px !important;
        row-gap: 0 !important;
        width: 100% !important;
        align-items: start !important;
        flex-wrap: nowrap !important;
    }

    #contactForm.contact-final-layout > .contact-row.contact-two-col-row > .contact-col {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        flex: none !important;
    }

    /* City half left, Postal Code half right exactly under First/Last row */
    #contactForm.contact-final-layout > .contact-row.contact-two-col-row:nth-of-type(2) {
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
    }

    #contactForm.contact-final-layout > .contact-row.contact-two-col-row:nth-of-type(2) > .contact-col:first-child,
    #contactForm.contact-final-layout > .contact-row.contact-two-col-row:nth-of-type(2) > .contact-col:nth-child(2) {
        width: 100% !important;
        max-width: 100% !important;
        flex: none !important;
    }

    /* Labels stay compact and do not wrap */
    #contactForm.contact-final-layout .form-label {
        font-size: 14px !important;
        font-weight: 650 !important;
        line-height: 1.1 !important;
        white-space: nowrap !important;
    }

    @media (max-width: 1024px) {
        #contactForm.contact-final-layout > .contact-row.contact-two-col-row {
            grid-template-columns: 1fr !important;
        }
    }


        /* GHOST FINAL: ONLY FIELD LABELS +4PT BIGGER */
        .contact-final-layout .form-label,
        #contactForm .form-label {
            font-size: 19px !important;
            line-height: 1.2 !important;
            font-weight: 800 !important;
            margin-bottom: 10px !important;
        }

</style>


<style id="ghost-contact-required-red-no-browser-alert-final">
    /* Logo: text white, icon pink */
    body > nav .text-xl {
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
        background: none !important;
        -webkit-background-clip: initial !important;
        background-clip: initial !important;
        text-shadow: none !important;
    }

    body > nav .text-xl i.fa-layer-group,
    body > nav .fa-layer-group {
        color: #ec4899 !important;
        -webkit-text-fill-color: #ec4899 !important;
        filter: drop-shadow(0 10px 22px rgba(236,72,153,.22)) !important;
    }

    /* Required fields like Work History: red box + message below */
    #contactForm .form-input.contact-field-error {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 2px rgba(220,38,38,.12) !important;
        background: #ffffff !important;
    }

    #contactForm .contact-field-error-text {
        min-height: 18px !important;
        margin-top: 7px !important;
        color: #dc2626 !important;
        font-size: 14px !important;
        line-height: 1.2 !important;
        font-weight: 900 !important;
        display: block !important;
        letter-spacing: .01em !important;
    }

    #contactRequiredAlert {
        position: fixed !important;
        top: 28px !important;
        left: calc(360px + 50%) !important;
        transform: translateX(-50%) translateY(-130%) !important;
        width: min(520px, calc(100vw - 420px)) !important;
        padding: 18px 24px !important;
        border-radius: 10px !important;
        background: #fee2e2 !important;
        border: 1px solid #fecaca !important;
        color: #991b1b !important;
        font-size: 17px !important;
        font-weight: 950 !important;
        line-height: 1.35 !important;
        box-shadow: 0 18px 45px rgba(15,23,42,.18) !important;
        opacity: 0 !important;
        pointer-events: none !important;
        z-index: 9999999 !important;
        transition: all .24s ease !important;
        text-align: left !important;
    }

    #contactRequiredAlert.show {
        opacity: 1 !important;
        transform: translateX(-50%) translateY(0) !important;
    }

    @media (max-width: 1024px) {
        #contactRequiredAlert {
            left: 50% !important;
            width: min(520px, calc(100vw - 32px)) !important;
        }
    }
</style>


<script id="ghost-contact-required-red-no-browser-alert-final">
/* Validation is handled inside ghost-button-fallback-js so the existing popup and red borders work before navigation. */
</script>


<style id="ghost-contact-buttons-size-like-workhistory-final">
    /* GHOST FINAL: only Contact page Preview + Next buttons size increased like Work History */
    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        max-width: 560px !important;
        gap: 22px !important;
        justify-content: center !important;
        align-items: center !important;
    }

    #btnPreview,
    #btnNext {
        height: 70px !important;
        min-height: 70px !important;
        border-radius: 999px !important;
        font-size: 22px !important;
        font-weight: 950 !important;
        letter-spacing: .02em !important;
        padding: 0 34px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        line-height: 1 !important;
    }

    #btnPreview {
        min-width: 230px !important;
        width: 230px !important;
        border: 3px solid #15168f !important;
        color: #15168f !important;
        background: #ffffff !important;
    }

    #btnNext {
        min-width: 260px !important;
        width: 260px !important;
        background: #db1b83 !important;
        color: #ffffff !important;
        box-shadow: 0 16px 32px rgba(236, 72, 153, .22) !important;
    }
</style>


<style id="ghost-contact-buttons-full-visible-left-final">
    /* GHOST FINAL: only move Contact Preview/Next buttons left so full buttons show */
    .builder-right-preview-panel {
        overflow: visible !important;
    }

    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        width: 560px !important;
        max-width: 560px !important;
        gap: 22px !important;
        justify-content: center !important;
        align-items: center !important;
        transform: translateX(-82px) !important;
        overflow: visible !important;
        z-index: 999 !important;
    }

    #btnPreview,
    #btnNext {
        height: 70px !important;
        min-height: 70px !important;
        border-radius: 999px !important;
        font-size: 22px !important;
        font-weight: 950 !important;
        letter-spacing: .02em !important;
        padding: 0 30px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        line-height: 1 !important;
        flex-shrink: 0 !important;
    }

    #btnPreview {
        width: 230px !important;
        min-width: 230px !important;
    }

    #btnNext {
        width: 260px !important;
        min-width: 260px !important;
    }
</style>


<style id="ghost-contact-template-section-move-down-final">
    /* GHOST FINAL: only move right template/preview section down with the white page */
    .builder-right-preview-panel {
        transform: translateY(58px) !important;
        overflow: visible !important;
    }

    /* Keep buttons full visible after right section moves */
    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        width: 560px !important;
        max-width: 560px !important;
        gap: 22px !important;
        justify-content: center !important;
        align-items: center !important;
        transform: translateX(-82px) !important;
        overflow: visible !important;
        z-index: 999 !important;
    }
</style>



<!-- GHOST ONLY BUTTON LOCATION/SIZE PATCH - OLD LOGIC UNCHANGED -->
<style id="ghost-only-buttons-location-size-patch">
    /* GHOST FINAL: only buttons position/size adjusted. Old HTML + JS logic unchanged. */

    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        position: relative !important;
        left: auto !important;
        right: auto !important;
        top: auto !important;
        bottom: auto !important;

        width: 440px !important;
        max-width: 440px !important;
        margin-top: 16px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        padding: 0 !important;

        transform: translateX(-38px) !important;
        gap: 16px !important;

        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        overflow: visible !important;
        z-index: 999 !important;
    }

    #btnPreview,
    #btnNext {
        height: 52px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        font-size: 12px !important;
        font-weight: 950 !important;
        letter-spacing: .075em !important;
        line-height: 1 !important;
    }

    #btnPreview {
        min-width: 138px !important;
        padding: 0 28px !important;
        border: 2px solid #172554 !important;
        background: #ffffff !important;
        color: #172554 !important;
    }

    #btnNext {
        min-width: 198px !important;
        padding: 0 30px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
        box-shadow: 0 16px 32px rgba(236,72,153,.22) !important;
    }

    @media (max-width: 1280px) {
        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            width: 410px !important;
            max-width: 410px !important;
            transform: translateX(-28px) !important;
            gap: 14px !important;
        }

        #btnPreview { min-width: 130px !important; padding: 0 24px !important; }
        #btnNext { min-width: 185px !important; padding: 0 26px !important; }
    }

    @media (max-width: 1024px) {
        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            width: 100% !important;
            max-width: 430px !important;
            transform: none !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    }
</style>



<!-- GHOST FINAL CLEAN BUTTON SPACE PATCH - OLD LOGIC UNCHANGED -->
<style id="ghost-final-clean-button-space-patch">
    /* Only visual CSS: buttons size/location + clean white space below. JS/logic untouched. */

    /* Let the right side have breathing room at the bottom instead of touching footer */
    .builder-right-preview-panel {
        padding-bottom: 190px !important;
        overflow: visible !important;
    }

    /* Keep the existing button area, move it slightly right, and add bottom white gap */
    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        position: relative !important;
        width: 500px !important;
        max-width: 500px !important;
        margin-top: 22px !important;
        margin-bottom: 120px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        padding: 0 !important;
        gap: 18px !important;
        transform: translateX(18px) translateY(-8px) !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        overflow: visible !important;
        z-index: 999 !important;
    }

    /* Text readable again, buttons not too small */
    #btnPreview,
    #btnNext {
        height: 60px !important;
        min-height: 60px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        font-size: 17px !important;
        font-weight: 950 !important;
        letter-spacing: .055em !important;
        line-height: 1 !important;
        text-transform: uppercase !important;
    }

    #btnPreview {
        width: 150px !important;
        min-width: 150px !important;
        padding: 0 22px !important;
        border: 2px solid #172554 !important;
        background: #ffffff !important;
        color: #172554 !important;
    }

    #btnNext {
        width: 230px !important;
        min-width: 230px !important;
        padding: 0 24px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
        box-shadow: 0 16px 32px rgba(236,72,153,.22) !important;
    }

    /* Small screen adjustment */
    @media (max-width: 1280px) {
        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            width: 470px !important;
            max-width: 470px !important;
            transform: translateX(8px) translateY(-8px) !important;
            gap: 16px !important;
            margin-bottom: 120px !important;
        }
        #btnPreview { width: 145px !important; min-width: 145px !important; }
        #btnNext { width: 220px !important; min-width: 220px !important; }
    }
</style>

</body>
</html>