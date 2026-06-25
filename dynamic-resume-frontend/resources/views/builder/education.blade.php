<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Details - Resume Builder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* FIXED ZOOM PREVIEW WRAPPER ARCHITECTURE */
        .preview-pane-container {
            width: 100%;
            height: 290px; /* UPDATED: Lowered wrapper container space to clean up desktop layout view */
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
            transform: scale(0.32); /* UPDATED: Scaled down perfectly to match the image micro corner viewport layout */
            transform-origin: top center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        .form-label {
            display: block;
            font-size: 11px; /* UPDATED: Smaller crisp text footprint */
            font-weight: 700;
            color: #475569;
            margin-bottom: 3px;
        }
        .input-field {
            width: 100%;
            padding: 7px 11px; /* UPDATED: Compact form sizing match */
            border: 1.5px solid #cbd5e1;
            border-radius: 6px;
            outline: none;
            font-size: 13px;
            color: #1e293b;
            transition: all 0.2s ease;
            background: #fff;
        }
        .input-field:focus {
            border-color: #f472b6;
            box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.12);
        }
        /* Rich Text Editor Interface styling */
        .editor-container {
            border: 1.5px solid #cbd5e1;
            border-radius: 6px;
            overflow: hidden;
            background: white;
        }
        /* Dynamic Smart Invisible Scrollbar for Toolbar when heavily zoomed */
        .toolbar-scrollbox {
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(203, 213, 225, 0.5) transparent;
            transition: scrollbar-color 0.3s ease;
        }
        .toolbar-scrollbox::-webkit-scrollbar {
            height: 3px;
        }
        .toolbar-scrollbox::-webkit-scrollbar-track {
            background: transparent;
        }
        .toolbar-scrollbox::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 10px;
        }
        .toolbar-scrollbox:hover::-webkit-scrollbar-thumb, 
        .toolbar-scrollbox:active::-webkit-scrollbar-thumb {
            background: rgba(203, 213, 225, 0.8);
        }
        /* Ultra compact buttons to fix single line execution under max zoom */
        .toolbar-btn {
            padding: 3px 6px;
            color: #475569;
            font-size: 11px;
            transition: all 0.15s ease;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .toolbar-btn:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .toolbar-btn.active-tool {
            background-color: #eff6ff;
            color: #2563eb;
            border: 1px solid rgba(37, 99, 235, 0.15);
        }
        .editor-area {
            min-height: 140px; /* UPDATED: Highly condensed vertical layout */
            padding: 12px;
            outline: none;
            font-size: 13px;
            line-height: 1.5;
            color: #334155;
        }
        /* Premium Dropdown Accordion Section */
        .coursework-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.01);
            background: white;
            transition: all 0.3s ease;
        }
        .main-toggle-header {
            cursor: pointer;
            padding: 10px 16px; /* UPDATED: Compact list bars layout */
            font-weight: 700;
            font-size: 13px;
            color: #1e3a8a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.2s;
        }
        .main-toggle-header:hover {
            background: #f8fafc;
        }
        /* Arrow Rotation Physics */
        .arrow-icon {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #64748b;
            font-size: 11px;
        }
        .rotated {
            transform: rotate(180deg);
        }
        .accordion-item {
            border-bottom: 1px solid #e2e8f0;
        }
        .accordion-item:last-child {
            border-bottom: none;
        }
        .accordion-header {
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 14px;
            font-weight: 700;
            font-size: 13px;
            color: #334155;
            background: #fff;
            transition: background 0.2s;
        }
        .accordion-header:hover {
            background: #f8fafc;
        }
        /* Spacing between buttons compressed */
        .example-btn {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 8px;
            border: 1.5px solid #cbd5e1;
            border-radius: 5px;
            transition: all 0.2s ease;
            background: white;
            text-align: left;
        }
        .example-btn:hover {
            border-color: #2563eb;
            background-color: #eff6ff;
        }
        .plus-icon {
            color: #2563eb;
            background: #dbeafe;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            flex-shrink: 0;
            font-weight: 900;
        }
        /* Pro Tip Container */
        .protip-box {
            background: #eff6ff;
            border-radius: 6px;
            padding: 10px 14px;
            border-left: 4px solid #3b82f6;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
        /* Modal Layout Layer */
        .modal-overlay {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
        }
        .btn-navy {
            background: #000033;
            color: white;
            transition: background 0.2s;
        }
        .btn-navy:hover {
            background: #000022;
        }
        /* Animation for Modal Popup */
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


        /* ===== GHOST CLEAN CORE CV EDUCATION FIX: single stable editable preview ===== */
        .ghost-corecv-stage {
            width: min(100%, 640px) !important;
            height: min(610px, calc(100vh - 190px)) !important;
            min-height: 470px !important;
            max-height: 610px !important;
            padding: 18px !important;
            background: linear-gradient(135deg, #eef2f7 0%, #f8fafc 46%, #ffffff 100%) !important;
            border: 1px solid #dbe3ef !important;
            border-radius: 18px !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
        }
        .ghost-corecv-stage .modern-live-preview,
        .ghost-corecv-stage .exact-template-preview,
        .ghost-corecv-stage .a4-page,
        .ghost-corecv-stage .preview-paper-compact {
            display: none !important;
        }
        .core-cv-live {
            --cv-accent: #16a34a;
            width: 405px;
            height: 570px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 22px 55px rgba(15, 23, 42, .18);
            padding: 34px 40px;
            color: #111827;
            font-family: "Times New Roman", Georgia, serif;
            overflow: hidden;
            transform: translateZ(0);
        }
        .core-cv-live.modal-size {
            width: 520px;
            height: 735px;
            padding: 44px 54px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, .22);
        }
        .core-cv-top-line {
            font-size: 6.7px;
            line-height: 1.35;
            color: #4b5563;
            text-align: center;
            margin-bottom: 8px;
        }
        .core-cv-header-line {
            height: 1.6px;
            background: var(--cv-accent);
            margin: 0 auto 10px;
            width: 88%;
        }
        .core-cv-name {
            text-align: center;
            font-size: 17px;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #111827;
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
        .core-cv-section {
            margin-top: 9px;
        }
        .core-cv-title {
            font-size: 7.4px;
            font-weight: 900;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: .045em;
            border-bottom: 1.35px solid var(--cv-accent);
            padding-bottom: 3px;
            margin-bottom: 5px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .core-cv-text,
        .core-cv-li,
        .core-cv-list,
        .core-cv-editor-html {
            font-size: 6.65px;
            line-height: 1.43;
            color: #374151;
        }
        .core-cv-bold { font-weight: 900; color: #111827; }
        .core-cv-muted { color: #4b5563; font-style: italic; }
        .core-cv-list,
        .core-cv-editor-html ul,
        .core-cv-editor-html ol {
            margin: 0;
            padding-left: 11px;
        }
        .core-cv-list li,
        .core-cv-editor-html li {
            margin-bottom: 1.5px;
        }
        .core-cv-editor-html {
            max-height: 62px;
            overflow: hidden;
            word-break: normal;
            overflow-wrap: break-word;
        }
        .core-cv-editor-html p,
        .core-cv-editor-html div {
            margin: 0 0 3px;
        }
        .core-cv-editor-html b,
        .core-cv-editor-html strong { font-weight: 900; }
        .core-cv-editor-html i,
        .core-cv-editor-html em { font-style: italic; }
        .core-cv-editor-html u { text-decoration: underline; }
        .core-cv-editor-html a { color: #2563eb; text-decoration: underline; font-weight: 700; }
        .core-cv-grid-3 {
            display:grid;
            grid-template-columns:repeat(3, 1fr);
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
        .core-cv-live.modal-size .core-cv-top-line { font-size: 8.4px; }
        .core-cv-live.modal-size .core-cv-name { font-size: 22px; }
        .core-cv-live.modal-size .core-cv-contact { font-size: 8.5px; }
        .core-cv-live.modal-size .core-cv-title { font-size: 9.2px; }
        .core-cv-live.modal-size .core-cv-text,
        .core-cv-live.modal-size .core-cv-li,
        .core-cv-live.modal-size .core-cv-list,
        .core-cv-live.modal-size .core-cv-editor-html { font-size: 8.2px; }
        .core-cv-live.modal-size .core-cv-editor-html { max-height: 92px; }
        .editor-area ul,
        .editor-area ol {
            margin: 0;
            padding-left: 22px;
        }
        .editor-area li { margin: 4px 0; }
        .editor-area p,
        .editor-area div { margin: 0 0 6px; }
        .toolbar-btn.active-tool {
            background: #eff6ff !important;
            color: #2563eb !important;
            border: 1px solid rgba(37, 99, 235, .25) !important;
        }
        @media (max-width: 1280px) {
            .core-cv-live { width: 365px; height: 525px; padding: 30px 36px; }
            .core-cv-name { font-size: 15px; }
            .core-cv-title { font-size: 6.9px; }
            .core-cv-text, .core-cv-li, .core-cv-list, .core-cv-editor-html, .core-cv-contact, .core-cv-top-line { font-size: 6.1px; }
        }



        /* ===== GHOST FINAL RIGHT PREVIEW SCROLL FIX ===== */
        /* Purpose:
           - Keep the CV readable like the older code
           - Stop the latest preview from becoming too wide
           - Add an internal scrollbar inside the preview box
           - Keep the buttons fixed below the preview box
        */
        .builder-right-preview-panel {
            overflow: hidden !important;
            padding-top: 14px !important;
            padding-bottom: 78px !important;
        }

        .builder-right-preview-panel .ghost-corecv-stage {
            width: min(100%, 585px) !important;
            height: min(560px, calc(100vh - 205px)) !important;
            min-height: 430px !important;
            max-height: 560px !important;
            padding: 16px 14px !important;
            display: flex !important;
            align-items: flex-start !important;
            justify-content: center !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-gutter: stable !important;
            background: linear-gradient(135deg, #eef2f7 0%, #f8fafc 50%, #ffffff 100%) !important;
            border: 1px solid #dbe3ef !important;
            border-radius: 18px !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08) !important;
        }

        .builder-right-preview-panel .ghost-corecv-stage::-webkit-scrollbar {
            width: 8px;
        }

        .builder-right-preview-panel .ghost-corecv-stage::-webkit-scrollbar-track {
            background: #e5e7eb;
            border-radius: 999px;
        }

        .builder-right-preview-panel .ghost-corecv-stage::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 999px;
        }

        .builder-right-preview-panel .ghost-corecv-stage::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        .builder-right-preview-panel .ghost-corecv-stage .core-cv-live {
            width: 405px !important;
            height: auto !important;
            min-height: 570px !important;
            max-width: 94% !important;
            flex: 0 0 auto !important;
            margin: 0 auto 16px !important;
            transform: none !important;
            border-radius: 8px !important;
            box-shadow: 0 20px 50px rgba(15, 23, 42, .16) !important;
        }

        .builder-right-preview-panel .ghost-corecv-stage .core-cv-editor-html {
            max-height: none !important;
            overflow: visible !important;
        }

        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            flex-shrink: 0 !important;
            margin-top: 14px !important;
        }

        /* Modal preview should also scroll instead of cutting the page */
        .preview-paper-wrap {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            align-items: flex-start !important;
            justify-content: center !important;
            padding: 14px !important;
        }

        .preview-paper-wrap .core-cv-live.modal-size {
            width: 520px !important;
            height: auto !important;
            min-height: 735px !important;
            flex: 0 0 auto !important;
            margin-bottom: 18px !important;
        }

        @media (max-width: 1366px) {
            .builder-right-preview-panel .ghost-corecv-stage {
                width: min(100%, 560px) !important;
                height: min(535px, calc(100vh - 200px)) !important;
                min-height: 420px !important;
            }

            .builder-right-preview-panel .ghost-corecv-stage .core-cv-live {
                width: 385px !important;
                min-height: 545px !important;
                padding: 30px 36px !important;
            }
        }


        /* ===== GHOST FINAL FIX: REAL INNER SCROLLBAR FOR CORE CV PREVIEW ===== */
        .builder-right-preview-panel .ghost-corecv-stage {
            overflow: hidden !important;
            align-items: stretch !important;
            justify-content: center !important;
            padding: 14px !important;
        }

        .core-cv-scrollbox {
            width: 100% !important;
            height: 100% !important;
            overflow-y: scroll !important;
            overflow-x: hidden !important;
            display: flex !important;
            align-items: flex-start !important;
            justify-content: center !important;
            padding: 14px 10px 22px !important;
            scrollbar-gutter: stable both-edges !important;
        }

        .core-cv-scrollbox::-webkit-scrollbar {
            width: 10px !important;
        }

        .core-cv-scrollbox::-webkit-scrollbar-track {
            background: #e5e7eb !important;
            border-radius: 999px !important;
        }

        .core-cv-scrollbox::-webkit-scrollbar-thumb {
            background: #94a3b8 !important;
            border-radius: 999px !important;
            border: 2px solid #e5e7eb !important;
        }

        .core-cv-scrollbox::-webkit-scrollbar-thumb:hover {
            background: #64748b !important;
        }

        .core-cv-scrollbox .core-cv-live {
            width: 405px !important;
            height: auto !important;
            min-height: 570px !important;
            max-width: 92% !important;
            flex: 0 0 auto !important;
            margin: 0 auto !important;
            transform: none !important;
        }

        @media (max-width: 1366px) {
            .core-cv-scrollbox .core-cv-live {
                width: 392px !important;
                min-height: 560px !important;
                padding: 32px 38px !important;
            }
        }
</style>

<!-- GHOST EDUCATION PAGE UI MATCH CONTACT PAGE - UI ONLY, OLD LOGIC UNCHANGED -->
<style id="ghost-education-contact-style-final">
    /* ===== Page scale: same 75% style view at browser 100% ===== */
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

    /* ===== LEFT BLUE SIDEBAR: same contact page style ===== */
    body > nav {
        position: fixed !important;
        left: 0 !important;
        top: 0 !important;
        bottom: 0 !important;
        width: 360px !important;
        height: 133.3333333333vh !important;
        min-height: 133.3333333333vh !important;
        z-index: 80 !important;
        background: #073f70 !important;
        border: 0 !important;
        border-right: 1px solid rgba(255,255,255,.08) !important;
        box-shadow: none !important;
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
        color: #a855f7 !important;
        font-size: 27px !important;
        font-weight: 950 !important;
        letter-spacing: -0.04em !important;
        white-space: nowrap !important;
    }

    body > nav .fa-layer-group {
        font-size: 34px !important;
        color: #ec4899 !important;
        margin-right: 14px !important;
        filter: none !important;
    }

    /* Hide original horizontal step text, rebuild vertical labels */
    body > nav > div:nth-child(2) {
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 31px !important;
        width: 100% !important;
        margin: 0 !important;
        text-transform: none !important;
        letter-spacing: 0 !important;
        font-weight: 500 !important;
        font-size: 0 !important;
        position: relative !important;
    }

    body > nav > div:nth-child(2)::before {
        content: "";
        position: absolute !important;
        left: 21px !important;
        top: 43px !important;
        bottom: 44px !important;
        width: 3px !important;
        border-radius: 999px !important;
        background: repeating-linear-gradient(
            to bottom,
            rgba(255,255,255,.22) 0px,
            rgba(255,255,255,.22) 9px,
            transparent 9px,
            transparent 17px
        ) !important;
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
        color: transparent !important;
        opacity: 1 !important;
        cursor: default !important;
        font-size: 0 !important;
        line-height: 1 !important;
    }

    body > nav > div:nth-child(2) > div::before {
        position: absolute !important;
        left: 0 !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        width: 42px !important;
        height: 42px !important;
        border-radius: 999px !important;
        background: #0f172a !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 22px !important;
        font-weight: 900 !important;
        border: 3px solid rgba(226,232,240,.48) !important;
        box-shadow: 0 0 0 4px rgba(15,23,42,.16) !important;
        z-index: 2 !important;
    }

    body > nav > div:nth-child(2) > div::after {
        position: absolute !important;
        left: 54px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        color: #ffffff !important;
        font-size: 23px !important;
        line-height: 1 !important;
        font-weight: 500 !important;
        letter-spacing: .01em !important;
        white-space: nowrap !important;
    }

    body > nav > div:nth-child(2) > div:nth-child(1)::before { content: "1" !important; }
    body > nav > div:nth-child(2) > div:nth-child(1)::after { content: "Heading" !important; }

    body > nav > div:nth-child(2) > div:nth-child(2)::before { content: "2" !important; }
    body > nav > div:nth-child(2) > div:nth-child(2)::after { content: "Work history" !important; }

    body > nav > div:nth-child(2) > div:nth-child(3)::before {
        content: "3" !important;
        background: #f8fafc !important;
        color: #111827 !important;
    }
    body > nav > div:nth-child(2) > div:nth-child(3)::after {
        content: "Education" !important;
        font-weight: 850 !important;
    }

    body > nav > div:nth-child(2) > div:nth-child(4)::before { content: "4" !important; }
    body > nav > div:nth-child(2) > div:nth-child(4)::after { content: "Skills" !important; }

    body > nav > div:nth-child(2) > div:nth-child(5)::before { content: "5" !important; }
    body > nav > div:nth-child(2) > div:nth-child(5)::after { content: "Summary" !important; }

    body > nav > div:nth-child(2) > div:nth-child(5) {
        margin-bottom: 50px !important;
    }

    body > nav > div:nth-child(2)::after {
        content: "6" !important;
        position: absolute !important;
        left: 0 !important;
        top: 351px !important;
        width: 42px !important;
        height: 42px !important;
        border-radius: 999px !important;
        background: #0f172a !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 22px !important;
        font-weight: 900 !important;
        border: 3px solid rgba(226,232,240,.48) !important;
        box-shadow: 0 0 0 4px rgba(15,23,42,.16) !important;
        z-index: 2 !important;
    }

    body > nav::after {
        content: "Finalize" !important;
        position: absolute !important;
        left: 102px !important;
        top: 476px !important;
        color: #ffffff !important;
        font-size: 23px !important;
        font-weight: 500 !important;
        letter-spacing: .01em !important;
    }

    /* Progress area */
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
        font-size: 22px !important;
        font-weight: 950 !important;
        letter-spacing: -0.04em !important;
        color: #ffffff !important;
        margin-bottom: 10px !important;
        white-space: nowrap !important;
    }

    body > nav > div:last-child::after {
        content: "";
        display: block !important;
        height: 11px !important;
        width: 220px !important;
        border-radius: 999px !important;
        background: linear-gradient(90deg, #34d399 0%, #34d399 45%, #ffffff 45%, #ffffff 100%) !important;
        margin-top: 13px !important;
    }

    body > nav > div:last-child::before {
        content: "45%" !important;
        position: absolute !important;
        left: 228px !important;
        top: 39px !important;
        font-size: 18px !important;
        font-weight: 900 !important;
        color: #ffffff !important;
    }

    /* Footer links inside sidebar */
    body > .absolute.bottom-0 {
        position: fixed !important;
        left: 48px !important;
        bottom: 42px !important;
        width: 270px !important;
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
        align-items: flex-start !important;
        text-align: left !important;
    }

    body > .absolute.bottom-0 a {
        color: #34d399 !important;
        font-size: 17px !important;
        font-weight: 850 !important;
        line-height: 1.15 !important;
        letter-spacing: .08em !important;
        text-align: left !important;
        white-space: nowrap !important;
    }

    body > .absolute.bottom-0 span {
        display: none !important;
    }

    body > .absolute.bottom-0 > div:last-child {
        margin-top: 28px !important;
        color: #ffffff !important;
        font-size: 15px !important;
        line-height: 1.35 !important;
        font-weight: 600 !important;
        max-width: 240px !important;
    }

    /* ===== MAIN WHITE PAGE: same contact layout ===== */
    body > .flex.flex-grow {
        margin-left: 360px !important;
        width: calc(133.3333333333vw - 360px) !important;
        height: 133.3333333333vh !important;
        max-height: 133.3333333333vh !important;
        background: #ffffff !important;
        overflow: hidden !important;
        display: flex !important;
        position: relative !important;
    }

    body > .flex.flex-grow > div:first-child {
        width: 60% !important;
        max-width: 60% !important;
        flex: 0 0 60% !important;
        height: 133.3333333333vh !important;
        max-height: 133.3333333333vh !important;
        padding: 92px 54px 360px 48px !important;
        background: #ffffff !important;
        overflow-y: scroll !important;
        overflow-x: hidden !important;
        scrollbar-gutter: stable !important;
    }

    body > .flex.flex-grow > div:first-child::-webkit-scrollbar { width: 8px !important; }
    body > .flex.flex-grow > div:first-child::-webkit-scrollbar-track { background: #ffffff !important; }
    body > .flex.flex-grow > div:first-child::-webkit-scrollbar-thumb { background: #cbd5e1 !important; border-radius: 999px !important; }
    body > .flex.flex-grow > div:first-child::-webkit-scrollbar-thumb:hover { background: #94a3b8 !important; }

    body > .flex.flex-grow > div:first-child .max-w-2xl {
        max-width: 920px !important;
        margin-left: 0 !important;
        margin-right: auto !important;
    }

    a[href="/builder/contact"],
    a[href="/builder/work-history"] {
        position: static !important;
        color: #2563eb !important;
        font-size: 18px !important;
        font-weight: 900 !important;
        margin-bottom: 28px !important;
        letter-spacing: .04em !important;
        display: inline-flex !important;
        align-items: center !important;
        width: fit-content !important;
    }

    h1 {
        font-size: clamp(38px, 3vw, 52px) !important;
        line-height: 1.10 !important;
        letter-spacing: -0.055em !important;
        color: #0f172a !important;
        margin-top: 12px !important;
        margin-bottom: 12px !important;
        max-width: 920px !important;
    }

    h1 + p {
        font-size: 24px !important;
        line-height: 1.45 !important;
        color: #64748b !important;
        margin-bottom: 36px !important;
        letter-spacing: .01em !important;
    }

    p.text-red-500 {
        font-size: 17px !important;
        margin-bottom: 28px !important;
        color: #ef4444 !important;
        font-weight: 800 !important;
    }

    /* ===== Center form: same contact sizes ===== */
    #contactForm {
        max-width: 920px !important;
        width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 30px !important;
        margin: 0 !important;
    }

    #contactForm > .flex {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 36px !important;
        width: 100% !important;
        align-items: start !important;
    }

    #contactForm > .flex > div,
    #contactForm .w-1\/2 {
        width: 100% !important;
        max-width: 100% !important;
    }

    .form-label {
        font-size: 19px !important;
        line-height: 1.2 !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        margin-bottom: 10px !important;
        white-space: nowrap !important;
    }

    .input-field,
    .form-input,
    select.input-field {
        width: 100% !important;
        height: 68px !important;
        min-height: 68px !important;
        padding: 0 26px !important;
        border: 1.8px solid #cbd5e1 !important;
        border-radius: 8px !important;
        outline: none !important;
        font-size: 24px !important;
        color: #0f172a !important;
        background: #f8fbff !important;
        transition: all 0.2s ease !important;
        box-shadow: none !important;
    }

    .input-field::placeholder {
        color: #94a3b8 !important;
        font-size: 24px !important;
        font-weight: 500 !important;
    }

    .input-field:focus,
    select.input-field:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37,99,235,.12) !important;
    }

    #inp_month,
    #inp_year {
        height: 68px !important;
        min-height: 68px !important;
        font-size: 23px !important;
        padding: 0 22px !important;
        flex: 1 1 0 !important;
    }

    #contactForm .flex.gap-2 {
        gap: 22px !important;
        width: 100% !important;
    }

    #contactForm > .flex:nth-child(3) {
        grid-template-columns: 1fr !important;
        max-width: calc((100% - 36px) / 2) !important;
    }

    /* ===== Coursework / dropdown section same width/clean size ===== */
    .coursework-card {
        max-width: 920px !important;
        width: 100% !important;
        margin-top: 34px !important;
        border: 1.8px solid #cbd5e1 !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        box-shadow: none !important;
        overflow: hidden !important;
    }

    .main-toggle-header {
        min-height: 66px !important;
        padding: 18px 22px !important;
        font-size: 18px !important;
        color: #0f172a !important;
        display: flex !important;
        align-items: center !important;
        gap: 20px !important;
    }

    .main-toggle-header span:first-child {
        font-size: 18px !important;
        line-height: 1.25 !important;
        font-weight: 850 !important;
        color: #0f172a !important;
    }

    .main-toggle-header span:last-child {
        font-size: 14px !important;
        line-height: 1.25 !important;
        white-space: nowrap !important;
    }

    #coursework-main-section {
        padding: 22px !important;
    }

    .protip-box {
        padding: 18px 20px !important;
        border-radius: 10px !important;
        margin-bottom: 18px !important;
    }

    .protip-box p {
        font-size: 15px !important;
        line-height: 1.55 !important;
    }

    .accordion-header {
        min-height: 50px !important;
        padding: 14px 18px !important;
        font-size: 16px !important;
    }

    .example-btn {
        min-height: 38px !important;
        padding: 8px 12px !important;
        font-size: 13px !important;
    }

    .editor-container {
        border-radius: 10px !important;
        border: 1.8px solid #cbd5e1 !important;
    }

    .editor-area {
        min-height: 170px !important;
        padding: 18px !important;
        font-size: 16px !important;
        line-height: 1.6 !important;
    }

    .toolbar-btn {
        font-size: 14px !important;
        min-width: 30px !important;
        min-height: 30px !important;
        padding: 6px 8px !important;
    }

    /* ===== Right preview: white background, lower template/buttons, same contact button sizes ===== */
    .builder-right-preview-panel {
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

    .builder-right-preview-panel::before {
        display: none !important;
        content: none !important;
    }

    #selectedTemplateBadge {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
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

    .core-cv-live {
        width: 430px !important;
        height: 602px !important;
        max-width: 96% !important;
        max-height: 100% !important;
        box-shadow: none !important;
        border-radius: 6px !important;
        padding: 34px 40px !important;
        background: #ffffff !important;
    }

    .builder-right-preview-panel > .w-full.max-w-sm.flex {
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

    #btnPreview,
    #btnNextFooter,
    #btnNext {
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

    #btnPreview {
        min-width: 138px !important;
        border: 2px solid #0f172a !important;
        color: #0f172a !important;
        background: #ffffff !important;
        box-shadow: none !important;
    }

    #btnNextFooter,
    #btnNext {
        min-width: 188px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }

    #btnPreview:hover,
    #btnNextFooter:hover,
    #btnNext:hover {
        transform: translateY(-1px) !important;
    }

    /* Responsive safety */
    @media (max-width: 1024px) {
        html,
        body {
            zoom: 1 !important;
            width: 100% !important;
            height: auto !important;
            min-width: 0 !important;
            min-height: 0 !important;
            overflow: auto !important;
        }

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
            overflow: visible !important;
        }

        body > .flex.flex-grow > div:first-child {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            overflow: visible !important;
            padding: 34px 24px 110px !important;
        }

        #contactForm > .flex,
        #contactForm > .flex:nth-child(3) {
            grid-template-columns: 1fr !important;
            max-width: 100% !important;
        }

        .builder-right-preview-panel {
            display: none !important;
        }
    }


/* GHOST FINAL EDUCATION SCROLLBAR + LABEL FIX - UI ONLY, OLD LOGIC UNCHANGED */
html {
    overflow: hidden !important;
    scrollbar-width: none !important;
}
html::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}
body {
    overflow: hidden !important;
    scrollbar-width: none !important;
}
body::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}

/* Main white wrapper should not show outside/end scrollbar */
body > .flex.flex-grow {
    overflow: hidden !important;
    scrollbar-width: none !important;
}
body > .flex.flex-grow::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}

/* Only center white form area scrolls, scrollbar invisible */
body > .flex.flex-grow > div:first-child {
    overflow-y: auto !important;
    overflow-x: hidden !important;
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
    scrollbar-gutter: auto !important;
}
body > .flex.flex-grow > div:first-child::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}
body > .flex.flex-grow > div:first-child::-webkit-scrollbar-track,
body > .flex.flex-grow > div:first-child::-webkit-scrollbar-thumb {
    display: none !important;
    background: transparent !important;
}

/* Any internal scroll areas should stay usable but invisible */
.template-preview-scroll,
.toolbar-scrollbox,
.preview-modal-body,
.template-side-panel,
.template-panel-scroll-area {
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
}
.template-preview-scroll::-webkit-scrollbar,
.toolbar-scrollbox::-webkit-scrollbar,
.preview-modal-body::-webkit-scrollbar,
.template-side-panel::-webkit-scrollbar,
.template-panel-scroll-area::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}

/* Right resume/template panel stays static while center form scrolls */
.builder-right-preview-panel {
    position: sticky !important;
    top: 0 !important;
    align-self: flex-start !important;
    overflow: hidden !important;
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
}
.builder-right-preview-panel::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
    height: 0 !important;
}

/* Text-field labels: remove heavy bold, keep clean/simple */
.form-label,
#contactForm label,
#contactForm .form-label,
label.form-label {
    font-weight: 500 !important;
    letter-spacing: 0 !important;
    color: #0f172a !important;
}

/* Coursework heading label should also look simple, not extra bold */
.main-toggle-header,
.main-toggle-header span:first-child,
.accordion-header {
    font-weight: 500 !important;
}

/* Keep Month/Year dropdown size matching the contact-style inputs */
#inp_month,
#inp_year,
select.input-field {
    height: 68px !important;
    min-height: 68px !important;
}

</style>



<!-- GHOST CONTACT-LIKE PINK HOVER EFFECT ON SIDEBAR FOOTER LINKS ONLY -->
<style id="ghost-education-footer-pink-hover-effect-only">
    body > .absolute.bottom-0 a {
        transition: color .18s ease, text-shadow .18s ease, transform .18s ease !important;
        cursor: pointer !important;
    }

    body > .absolute.bottom-0 a:hover,
    body > .absolute.bottom-0 a:focus {
        color: #ec4899 !important;
        text-shadow: 0 8px 18px rgba(236, 72, 153, .22) !important;
        transform: translateX(1px) !important;
    }
</style>


<!-- GHOST UPDATE: Education Description + Ready Examples screen polish -->
<style id="ghost-education-description-ready-examples-final">
    /* Keep old logic, only improve education description option layout */
    .coursework-card {
        margin-top: 38px !important;
        border: 1.8px solid #cbd5e1 !important;
        border-radius: 14px !important;
        overflow: hidden !important;
        background: #ffffff !important;
    }

    .main-toggle-header {
        min-height: 76px !important;
        padding: 20px 24px !important;
        background: #ffffff !important;
        align-items: center !important;
    }

    .main-toggle-header span:first-child {
        font-size: 20px !important;
        line-height: 1.2 !important;
        font-weight: 900 !important;
        color: #071022 !important;
        letter-spacing: -0.01em !important;
    }

    .main-toggle-header span:last-child {
        font-size: 16px !important;
        font-weight: 850 !important;
        color: #2563eb !important;
        text-decoration: underline !important;
    }

    #coursework-main-section {
        padding: 26px !important;
        background: #ffffff !important;
    }

    #coursework-main-section .grid {
        grid-template-columns: minmax(320px, 0.82fr) minmax(480px, 1.18fr) !important;
        gap: 28px !important;
        align-items: start !important;
    }

    #coursework-main-section .lg\:col-span-6 {
        grid-column: auto !important;
    }

    #coursework-main-section p.uppercase,
    #coursework-main-section .text-\[10px\].uppercase {
        font-size: 13px !important;
        letter-spacing: .12em !important;
        color: #64748b !important;
        font-weight: 950 !important;
        margin-bottom: 10px !important;
    }

    .ghost-edu-desc-heading {
        margin: 0 0 12px !important;
    }

    .ghost-edu-desc-title {
        font-size: 30px !important;
        line-height: 1.1 !important;
        font-weight: 950 !important;
        color: #071022 !important;
        letter-spacing: -0.02em !important;
        margin: 0 0 8px !important;
    }

    .ghost-edu-desc-subtitle {
        font-size: 18px !important;
        line-height: 1.35 !important;
        font-weight: 500 !important;
        color: #475569 !important;
        margin: 0 0 18px !important;
    }

    #coursework-main-section .border.border-slate-200.rounded-lg {
        border-radius: 14px !important;
        border: 1.8px solid #cbd5e1 !important;
        overflow: hidden !important;
        max-height: 620px !important;
        overflow-y: auto !important;
        scrollbar-gutter: stable !important;
        background: #ffffff !important;
    }

    #coursework-main-section .accordion-header {
        min-height: 58px !important;
        padding: 16px 18px !important;
        font-size: 17px !important;
        line-height: 1.2 !important;
        font-weight: 900 !important;
        color: #071022 !important;
        background: #ffffff !important;
    }

    #coursework-main-section .accordion-header:hover {
        background: #f8fafc !important;
    }

    #coursework-main-section .example-btn {
        min-height: 42px !important;
        padding: 9px 12px !important;
        border-radius: 999px !important;
        border: 1.5px solid #cbd5e1 !important;
        background: #ffffff !important;
        gap: 8px !important;
    }

    #coursework-main-section .example-btn:hover {
        border-color: #ec4899 !important;
        background: #fdf2f8 !important;
        transform: translateY(-1px) !important;
    }

    #coursework-main-section .example-btn span {
        font-size: 13px !important;
        font-weight: 850 !important;
        color: #334155 !important;
    }

    #coursework-main-section .plus-icon {
        width: 20px !important;
        height: 20px !important;
        font-size: 10px !important;
        background: #dbeafe !important;
        color: #2563eb !important;
    }

    #coursework-main-section .editor-container {
        border-radius: 14px !important;
        border: 1.8px solid #94a3b8 !important;
        background: #ffffff !important;
        overflow: hidden !important;
        min-height: 560px !important;
    }

    #coursework-main-section .toolbar-scrollbox {
        min-height: 86px !important;
        padding: 16px 28px !important;
        background: #ffffff !important;
        border-bottom: 1.5px solid #cbd5e1 !important;
        justify-content: flex-start !important;
        gap: 20px !important;
    }

    #coursework-main-section .toolbar-scrollbox > div:first-child,
    #coursework-main-section .toolbar-scrollbox > div:last-child {
        gap: 24px !important;
    }

    #coursework-main-section .toolbar-btn {
        min-width: 42px !important;
        min-height: 42px !important;
        padding: 8px !important;
        font-size: 26px !important;
        color: #071022 !important;
        border-radius: 8px !important;
        background: transparent !important;
    }

    #coursework-main-section .toolbar-btn:hover,
    #coursework-main-section .toolbar-btn.active-tool {
        background: #eaf2ff !important;
        color: #071022 !important;
        border-color: transparent !important;
    }

    .ghost-edu-smart-pill {
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        margin: 24px 28px 4px !important;
        padding: 11px 20px !important;
        border-radius: 999px !important;
        border: 1.6px solid #ec4899 !important;
        background: #fdf2f8 !important;
        color: #071022 !important;
        font-size: 15px !important;
        line-height: 1 !important;
        font-weight: 950 !important;
        letter-spacing: .02em !important;
        width: fit-content !important;
        cursor: default !important;
    }

    #editor.editor-area {
        min-height: 410px !important;
        padding: 24px 28px 36px !important;
        font-size: 22px !important;
        line-height: 1.55 !important;
        color: #071022 !important;
        background: #ffffff !important;
    }

    #editor.editor-area ul,
    #editor.editor-area ol {
        padding-left: 28px !important;
        margin: 0 !important;
    }

    #editor.editor-area li {
        margin: 8px 0 !important;
    }

    #editor.editor-area:empty::before {
        content: "Add education highlights, coursework, projects, awards, scholarships, or achievements here...";
        color: #94a3b8;
        font-weight: 400;
    }

    .protip-box {
        border-radius: 12px !important;
        border-left: 5px solid #2563eb !important;
        background: #eff6ff !important;
        padding: 18px 20px !important;
    }

    .protip-box p {
        font-size: 15px !important;
        line-height: 1.55 !important;
    }

    @media (max-width: 1280px) {
        #coursework-main-section .grid {
            grid-template-columns: 1fr !important;
        }
        #coursework-main-section .editor-container {
            min-height: 520px !important;
        }
        #editor.editor-area {
            min-height: 360px !important;
        }
    }
</style>



<!-- GHOST EDUCATION SUMMARY PAGE PATCH - UI + SAME OLD SAVE DATA LOGIC -->
<style id="ghost-education-summary-page-patch">
    body.education-summary-mode > .flex.flex-grow {
        overflow: hidden !important;
        display: block !important;
    }

    body.education-summary-mode > .flex.flex-grow > div:first-child {
        width: 100% !important;
        max-width: 100% !important;
        flex: none !important;
        height: 133.3333333333vh !important;
        padding: 92px 64px 260px 64px !important;
        background: #ffffff !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    body.education-summary-mode > .flex.flex-grow > div:first-child .max-w-2xl {
        max-width: none !important;
        width: 100% !important;
    }

    body.education-summary-mode .builder-right-preview-panel,
    body.education-summary-mode #contactForm,
    body.education-summary-mode .coursework-card,
    body.education-summary-mode .education-form-title,
    body.education-summary-mode .education-form-subtitle,
    body.education-summary-mode .education-required-line {
        display: none !important;
    }

    body.education-form-mode #educationSummaryPage {
        display: none !important;
    }

    #educationSummaryPage {
        width: 100% !important;
        max-width: 1480px !important;
        margin: 0 auto !important;
        display: block;
        color: #081022;
    }

    .edu-summary-topbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 54px;
    }

    .edu-summary-title {
        font-size: 54px;
        line-height: 1.06;
        font-weight: 950;
        letter-spacing: .14em;
        color: #071022;
        margin: 0 0 16px;
        text-transform: lowercase;
    }

    .edu-summary-subtitle {
        max-width: 960px;
        font-size: 26px;
        line-height: 1.35;
        font-weight: 400;
        color: #071022;
        letter-spacing: .02em;
    }

    .edu-summary-tips {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #0b77df;
        font-size: 23px;
        font-weight: 900;
        text-decoration: underline;
        white-space: nowrap;
        margin-top: 98px;
    }

    .edu-summary-card {
        width: 100%;
        border: 1.7px solid #cbd5e1;
        border-radius: 12px;
        min-height: 148px;
        display: grid;
        grid-template-columns: 70px minmax(0, 1fr) 190px;
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 28px;
    }

    .edu-summary-number {
        min-height: 86px;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 22px;
        background: #f3f6fb;
        border-right: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        border-bottom-right-radius: 12px;
        font-size: 28px;
        font-weight: 900;
        color: #071022;
    }

    .edu-summary-content {
        padding: 30px 28px 24px;
        min-width: 0;
    }

    .edu-summary-school {
        font-size: 28px;
        line-height: 1.12;
        font-weight: 950;
        letter-spacing: .04em;
        color: #071022;
        margin-bottom: 20px;
        word-break: break-word;
    }

    .edu-summary-location,
    .edu-summary-degree,
    .edu-summary-date {
        font-size: 21px;
        line-height: 1.25;
        font-weight: 500;
        color: #071022;
        margin-bottom: 14px;
    }

    .edu-summary-description {
        margin-top: 14px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
        max-width: 980px;
        font-size: 18px;
        line-height: 1.45;
        color: #334155;
    }

    .edu-summary-description:empty {
        display: none;
    }

    .edu-summary-missing {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 4px;
        padding: 9px 16px;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        font-size: 20px;
        line-height: 1;
        color: #071022;
        font-weight: 500;
        white-space: nowrap;
    }

    .edu-summary-missing-dot {
        width: 14px;
        height: 14px;
        border-radius: 999px;
        background: #ff7b7b;
        flex: 0 0 auto;
    }

    .edu-summary-add-coursework {
        margin-left: 16px;
        font-size: 19px;
        font-weight: 900;
        color: #0b77df;
        text-decoration: underline;
        cursor: pointer;
        white-space: nowrap;
    }

    .edu-summary-actions {
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        gap: 30px;
        padding: 38px 36px 0 0;
        color: #0876de;
    }

    .edu-summary-icon-btn {
        border: 0;
        background: transparent;
        color: #0876de;
        font-size: 28px;
        line-height: 1;
        cursor: pointer;
        padding: 0;
        transition: transform .16s ease, color .16s ease;
    }

    .edu-summary-icon-btn:hover {
        color: #075cad;
        transform: translateY(-1px);
    }

    .edu-summary-add-box {
        width: 100%;
        min-height: 88px;
        border: 3px dashed #1685eb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0b77df;
        font-size: 28px;
        font-weight: 950;
        text-decoration: underline;
        cursor: pointer;
        margin: 14px 0 66px;
        background: #ffffff;
    }

    .edu-summary-add-box i {
        margin-right: 24px;
        font-size: 30px;
        text-decoration: none;
    }

    .edu-summary-footer-buttons {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 28px;
        padding-right: 0;
        margin-bottom: 90px;
    }

    .edu-summary-preview-btn,
    .edu-summary-next-btn {
        height: 70px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        white-space: nowrap;
        font-size: 26px;
        font-weight: 950;
        letter-spacing: .02em;
        padding: 0 58px;
        cursor: pointer;
        transition: transform .18s ease, background .18s ease, color .18s ease;
    }

    .edu-summary-preview-btn {
        min-width: 240px;
        border: 3px solid #0b0b7a;
        color: #0b0b7a;
        background: #ffffff;
    }

    .edu-summary-next-btn {
        min-width: 270px;
        border: 3px solid #d81380;
        background: #d81380;
        color: #ffffff;
    }

    .edu-summary-preview-btn:hover,
    .edu-summary-next-btn:hover {
        transform: translateY(-1px);
    }

    body.education-summary-mode .ghost-summary-clean-bottom-space {
        height: 160px;
        background: #ffffff;
    }

    @media (max-width: 1024px) {
        body.education-summary-mode > .flex.flex-grow > div:first-child {
            padding: 34px 24px 120px !important;
        }
        .edu-summary-topbar { display: block; }
        .edu-summary-title { font-size: 36px; }
        .edu-summary-subtitle { font-size: 18px; }
        .edu-summary-tips { margin-top: 24px; font-size: 18px; }
        .edu-summary-card { grid-template-columns: 56px 1fr; }
        .edu-summary-actions { grid-column: 1 / -1; justify-content: flex-end; padding: 0 20px 20px; }
        .edu-summary-footer-buttons { justify-content: center; flex-wrap: wrap; }
    }
</style>



<!-- GHOST FINAL EDUCATION SUMMARY MATCH WORK HISTORY - UI ONLY -->
<style id="ghost-edu-summary-workhistory-match-final">
    body.education-summary-mode > .flex.flex-grow > div:first-child {
        padding: 86px 64px 260px 64px !important;
    }

    body.education-summary-mode > .flex.flex-grow > div:first-child .max-w-2xl {
        max-width: 1500px !important;
        width: 100% !important;
        margin: 0 auto !important;
    }

    #educationSummaryPage {
        max-width: 1500px !important;
        width: 100% !important;
        margin: 0 auto !important;
    }

    .edu-summary-topbar {
        display: flex !important;
        align-items: flex-start !important;
        justify-content: space-between !important;
        gap: 28px !important;
        margin-bottom: 34px !important;
    }

    .edu-summary-title {
        font-size: 52px !important;
        line-height: 1.06 !important;
        font-weight: 950 !important;
        letter-spacing: -0.035em !important;
        color: #071022 !important;
        margin: 0 0 18px !important;
        text-transform: none !important;
    }

    .edu-summary-subtitle {
        max-width: 1040px !important;
        font-size: 25px !important;
        line-height: 1.35 !important;
        font-weight: 400 !important;
        color: #071022 !important;
        letter-spacing: .01em !important;
    }

    .edu-summary-tips {
        margin-top: 72px !important;
        color: #0b77df !important;
        font-size: 24px !important;
        font-weight: 900 !important;
        text-decoration: underline !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
        white-space: nowrap !important;
    }

    .edu-summary-card {
        width: 100% !important;
        min-height: 198px !important;
        border: 1.7px solid #cbd5e1 !important;
        border-radius: 6px !important;
        background: #ffffff !important;
        display: grid !important;
        grid-template-columns: 70px minmax(0, 1fr) 210px !important;
        column-gap: 20px !important;
        padding: 26px 28px 26px 30px !important;
        overflow: visible !important;
        margin: 0 0 28px !important;
    }

    .edu-summary-number {
        width: 38px !important;
        height: 38px !important;
        min-height: 38px !important;
        padding: 0 !important;
        margin: 0 auto !important;
        border: 1px solid #dbe3ef !important;
        border-radius: 5px !important;
        background: #f8fafc !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 23px !important;
        font-weight: 800 !important;
        color: #071022 !important;
    }

    .edu-summary-content {
        padding: 0 !important;
        min-width: 0 !important;
    }

    .edu-summary-school {
        font-size: 29px !important;
        line-height: 1.15 !important;
        font-weight: 950 !important;
        letter-spacing: .035em !important;
        color: #071022 !important;
        margin: 0 0 12px !important;
        word-break: break-word !important;
    }

    .edu-summary-location,
    .edu-summary-degree,
    .edu-summary-date {
        font-size: 17px !important;
        line-height: 1.35 !important;
        font-weight: 650 !important;
        color: #334155 !important;
        margin: 0 0 12px !important;
    }

    .edu-summary-description {
        max-width: 1030px !important;
        margin: 18px 0 12px !important;
        padding-top: 17px !important;
        border-top: 1px solid #dbe3ef !important;
        font-size: 16px !important;
        line-height: 1.45 !important;
        color: #334155 !important;
    }

    .edu-summary-missing-row {
        margin-top: 14px !important;
        display: flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 12px !important;
        font-size: 16px !important;
        line-height: 1.35 !important;
    }

    .edu-summary-missing-label {
        color: #c1123c !important;
        font-size: 16px !important;
        font-weight: 950 !important;
    }

    .edu-summary-missing-link {
        color: #0b77df !important;
        font-size: 16px !important;
        font-weight: 900 !important;
        text-decoration: underline !important;
        background: transparent !important;
        border: 0 !important;
        padding: 0 !important;
        cursor: pointer !important;
    }

    .edu-summary-use-row {
        margin-top: 14px !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        color: #0b77df !important;
        font-size: 16px !important;
        font-weight: 900 !important;
        text-decoration: underline !important;
    }

    .edu-summary-use-row input {
        width: 17px !important;
        height: 17px !important;
        accent-color: #0b77df !important;
        cursor: pointer !important;
    }

    .edu-summary-actions {
        display: flex !important;
        justify-content: flex-end !important;
        align-items: flex-start !important;
        gap: 28px !important;
        padding: 0 0 0 0 !important;
        color: #0876de !important;
    }

    .edu-summary-icon-btn {
        border: 0 !important;
        background: transparent !important;
        color: #0876de !important;
        font-size: 26px !important;
        line-height: 1 !important;
        cursor: pointer !important;
        padding: 2px !important;
    }

    .edu-summary-move-btn {
        cursor: grab !important;
    }

    .edu-summary-add-box {
        width: 100% !important;
        min-height: 70px !important;
        border: 2px dashed #1685eb !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: #0b77df !important;
        font-size: 22px !important;
        font-weight: 950 !important;
        text-decoration: none !important;
        cursor: pointer !important;
        margin: 0 0 50px !important;
        background: #ffffff !important;
    }

    .edu-summary-add-box span {
        text-decoration: underline !important;
    }

    .edu-summary-add-box i {
        margin-right: 16px !important;
        font-size: 23px !important;
        text-decoration: none !important;
    }

    .edu-summary-footer-buttons {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 30px !important;
        padding-right: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 110px !important;
    }

    .edu-summary-preview-btn,
    .edu-summary-next-btn {
        height: 68px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        font-size: 26px !important;
        font-weight: 950 !important;
        letter-spacing: .02em !important;
        padding: 0 58px !important;
        cursor: pointer !important;
    }

    .edu-summary-preview-btn {
        min-width: 260px !important;
        border: 3px solid #0b0b7a !important;
        color: #0b0b7a !important;
        background: #ffffff !important;
    }

    .edu-summary-next-btn {
        min-width: 285px !important;
        border: 3px solid #d81380 !important;
        background: #d81380 !important;
        color: #ffffff !important;
    }

    @media (max-width: 1024px) {
        .edu-summary-card { grid-template-columns: 56px 1fr !important; }
        .edu-summary-actions { grid-column: 1 / -1 !important; padding-top: 18px !important; }
    }
</style>



<!-- GHOST FINAL PATCH: Education Summary size like Work History + white logo text only -->
<style id="ghost-edu-summary-size-like-workhistory-white-logo-text">
    /* Resume Builder text white only - icon/logo color untouched */
    body > nav .text-xl,
    body > nav .text-xl span,
    body > nav .text-xl div {
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
    }
    body > nav .text-xl i,
    body > nav .fa-layer-group {
        color: #ec4899 !important;
        -webkit-text-fill-color: #ec4899 !important;
    }

    /* White page/content area thora compact - Work History summary jaisa */
    body.education-summary-mode > .flex.flex-grow > div:first-child {
        padding: 82px 54px 240px 54px !important;
    }

    body.education-summary-mode > .flex.flex-grow > div:first-child .max-w-2xl,
    #educationSummaryPage {
        max-width: 1340px !important;
        width: 100% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .edu-summary-topbar {
        margin-bottom: 28px !important;
        gap: 24px !important;
    }

    .edu-summary-title {
        font-size: 44px !important;
        line-height: 1.08 !important;
        letter-spacing: -0.04em !important;
        margin-bottom: 14px !important;
    }

    .edu-summary-subtitle {
        max-width: 980px !important;
        font-size: 22px !important;
        line-height: 1.35 !important;
    }

    .edu-summary-tips {
        margin-top: 62px !important;
        font-size: 22px !important;
        gap: 8px !important;
    }

    .edu-summary-card {
        min-height: 178px !important;
        grid-template-columns: 62px minmax(0, 1fr) 190px !important;
        column-gap: 18px !important;
        padding: 23px 25px 23px 24px !important;
        margin-bottom: 22px !important;
        border-radius: 6px !important;
    }

    .edu-summary-number {
        width: 34px !important;
        height: 34px !important;
        min-height: 34px !important;
        font-size: 20px !important;
    }

    .edu-summary-school {
        font-size: 25px !important;
        line-height: 1.15 !important;
        letter-spacing: .035em !important;
        margin-bottom: 10px !important;
    }

    .edu-summary-location,
    .edu-summary-degree,
    .edu-summary-date {
        font-size: 15px !important;
        line-height: 1.32 !important;
        margin-bottom: 10px !important;
        font-weight: 650 !important;
    }

    .edu-summary-description {
        margin-top: 14px !important;
        padding-top: 14px !important;
        font-size: 14px !important;
        line-height: 1.42 !important;
    }

    .edu-summary-missing-row,
    .edu-summary-use-row {
        margin-top: 12px !important;
        gap: 10px !important;
        font-size: 15px !important;
    }

    .edu-summary-missing-label,
    .edu-summary-missing-link,
    .edu-summary-use-row {
        font-size: 15px !important;
    }

    .edu-summary-use-row input {
        width: 15px !important;
        height: 15px !important;
    }

    .edu-summary-actions {
        gap: 24px !important;
    }

    .edu-summary-icon-btn {
        font-size: 24px !important;
    }

    .edu-summary-add-box {
        min-height: 62px !important;
        font-size: 21px !important;
        margin-bottom: 42px !important;
    }

    .edu-summary-footer-buttons {
        gap: 28px !important;
        margin-bottom: 105px !important;
        padding-right: 0 !important;
    }

    .edu-summary-preview-btn,
    .edu-summary-next-btn {
        height: 60px !important;
        font-size: 23px !important;
        padding: 0 52px !important;
        letter-spacing: .02em !important;
    }

    .edu-summary-preview-btn {
        min-width: 242px !important;
        border-width: 3px !important;
    }

    .edu-summary-next-btn {
        min-width: 265px !important;
        border-width: 3px !important;
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
            <div onclick="window.location.href='/builder/contact'" class="hover:text-white cursor-pointer transition">Contact</div>
            <div class="text-pink-500 border-b-2 border-pink-500 pb-2 -mb-2.5 transition cursor-pointer">Education</div>
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
                <div class="absolute font-bold text-xs" id="progressText">45%</div>
            </div>
            <div class="text-xs font-semibold">Resume Completeness</div>
        </div>
    </nav>

    <div class="flex flex-grow overflow-hidden relative">
        <div class="w-full lg:w-[62%] bg-gray-50 overflow-y-auto p-8 lg:px-16 pb-40">
            <div class="max-w-2xl mx-auto">
                <a href="/builder/work-history" class="text-blue-700 font-bold flex items-center mb-4 hover:underline w-fit text-xs tracking-wide">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i> Go Back
                </a>
                <h1 class="text-[25px] font-black mb-0.5 leading-tight tracking-tight text-gray-900 education-form-title">Share your education journey</h1>
                <p class="text-gray-500 mb-5 text-[14px] education-form-subtitle">Include your institution and special achievements.</p>
                <p class="text-[11px] font-bold text-red-500 mb-3 education-required-line">* indicates a required field</p>
                
                <form id="contactForm" class="space-y-3.5">
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="form-label">Institution *</label>
                            <input type="text" id="inp_school" class="input-field" placeholder="e.g. HITEC University">
                        </div>
                        <div class="w-1/2">
                            <label class="form-label">School Location</label>
                            <input type="text" id="inp_location" class="input-field" placeholder="e.g. Taxila, Pakistan">
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="form-label">Degree</label>
                            <select id="inp_degree" class="input-field">
                                <option value="">Select</option>
                                <option value="High School diploma">High School diploma</option>
                                <option value="GED">GED</option>
                                <option value="Associate of Arts">Associate of Arts</option>
                                <option value="Associate of Science">Associate of Science</option>
                                <option value="Associate of Applied Science">Associate of Applied Science</option>
                                <option value="Bachelor of Arts">Bachelor of Arts</option>
                                <option value="Bachelor of Science">Bachelor of Science</option>
                                <option value="BBA">BBA</option>
                                <option value="Master of Arts">Master of Arts</option>
                                <option value="Master of Science">Master of Science</option>
                                <option value="MBA">MBA</option>
                                <option value="J.D.">J.D.</option>
                                <option value="M.D.">M.D.</option>
                                <option value="Ph.D.">Ph.D.</option>
                                <option value="Enter a certificate">Enter a certificate</option>
                            </select>
                        </div>
                        <div class="w-1/2">
                            <label class="form-label">Field of Study</label>
                            <input type="text" id="inp_field" class="input-field" placeholder="e.g. Software Engineering">
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="form-label">Graduation Date (or expected Date)</label>
                            <div class="flex gap-2">
                                <select id="inp_month" class="input-field w-1/2 bg-white font-medium">
                                    <option value="">Month</option>
                                    <option value="Jan">Jan</option><option value="Feb">Feb</option><option value="Mar">Mar</option><option value="Apr">Apr</option><option value="May">May</option><option value="Jun">Jun</option><option value="Jul">Jul</option><option value="Aug">Aug</option><option value="Sep">Sep</option><option value="Oct">Oct</option><option value="Nov">Nov</option><option value="Dec">Dec</option>
                                </select>
                                <select id="inp_year" class="input-field w-1/2 bg-white font-medium">
                                    <option value="">Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="coursework-card border shadow-sm mt-5">
                    <div class="main-toggle-header" onclick="toggleMainCoursework()">
                        <span class="tracking-tight font-extrabold flex items-center text-slate-800 text-xs">
                            <i class="fa-solid fa-chevron-down mr-2.5 arrow-icon" id="main-arrow"></i> Add any additional coursework you're proud to showcase
                        </span>
                        <span class="text-[11px] text-blue-600 underline font-semibold hover:text-blue-800">Look here for sample resume references</span>
                    </div>
                    <div id="coursework-main-section" class="p-3.5 pt-1.5 border-t border-slate-100 space-y-2 hidden bg-white">
                        <div class="protip-box">
                            <i class="fa-solid fa-lightbulb text-slate-800 text-sm mt-0.5 flex-shrink-0"></i>
                            <p class="text-[11px] font-semibold text-slate-700 leading-relaxed">
                                <strong class="text-slate-900 font-bold mr-1">Pro Tip</strong> Not enough work experience? This section can help you stand out. You can have a coursework-focused resume instead. Include international schooling, educational achievements or specializations that are most relevant to the job you want.
                            </p>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">
                            <div class="lg:col-span-6 space-y-2">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ready to use examples</p>
                                <div class="border border-slate-200 rounded-lg overflow-hidden shadow-sm bg-white">
                                    <div class="accordion-item">
                                        <div class="accordion-header" onclick="toggleCategory('cat-1', this)">Educational Achievements <i class="fa-solid fa-chevron-down arrow-icon"></i></div>
                                        <div id="cat-1" class="p-3 bg-slate-50/50 hidden border-t border-slate-100">
                                            <p class="text-[11px] text-slate-500 mb-1 font-semibold leading-snug">Would you like to include any honors or achievements?</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                <div class="example-btn" onclick="addBullet('Successfully cleared international grade equivalence track to GPA matrix')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">International Grade to GPA Equivalent</span></div>
                                                <div class="example-btn" onclick="addBullet('Scored in the top percentiles of national achievement tests')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Achievement Tests</span></div>
                                                <div class="example-btn" onclick="addBullet('Maintained a minimum average of 85% throughout the core degree tracks')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Minimum Average</span></div>
                                                <div class="example-btn" onclick="addBullet('Member of the Dean\'s Honor List for outstanding academic scores')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Dean's List</span></div>
                                                <div class="example-btn" onclick="addBullet('Achieved a Cumulative GPA of 3.8/4.0')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">GPA</span></div>
                                                <div class="example-btn" onclick="addBullet('Graduated with First Class Honors')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Honors</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header" onclick="toggleCategory('cat-2', this)">Awards, Grants and Scholarships <i class="fa-solid fa-chevron-down arrow-icon"></i></div>
                                        <div id="cat-2" class="p-3 bg-slate-50/50 hidden border-t border-slate-100">
                                            <p class="text-[11px] text-slate-500 mb-1 font-semibold leading-snug">Include a scholarship or award if you have received any.</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                <div class="example-btn" onclick="addBullet('Recipient of National Merit Scholarship')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Awards</span></div>
                                                <div class="example-btn" onclick="addBullet('Awarded University Merit Scholarship for Academic Excellence')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Scholarship</span></div>
                                                <div class="example-btn" onclick="addBullet('Won top positions in competitive athletic/engineering challenges')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Athletic or Competitive Scholarship</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header" onclick="toggleCategory('cat-3', this)">Completed Coursework <i class="fa-solid fa-chevron-down arrow-icon"></i></div>
                                        <div id="cat-3" class="p-3 bg-slate-50/50 hidden border-t border-slate-100">
                                            <p class="text-[11px] text-slate-500 mb-1 font-semibold leading-snug">Have you completed any courses that are relevant to the job you're applying for?</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                <div class="example-btn" onclick="addBullet('Relevant coursework in Advanced Data Structures and Algorithms')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Relevant Coursework</span></div>
                                                <div class="example-btn" onclick="addBullet('Completed certified professional development program tracks')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Professional Development</span></div>
                                                <div class="example-btn" onclick="addBullet('Completed extensive university level coursework requirements')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">University Coursework</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header" onclick="toggleCategory('cat-4', this)">Activities and Memberships <i class="fa-solid fa-chevron-down arrow-icon"></i></div>
                                        <div id="cat-4" class="p-3 bg-slate-50/50 hidden border-t border-slate-100">
                                            <p class="text-[11px] text-slate-500 mb-1 font-semibold leading-snug">Have you been active with any group, team or organization?</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                <div class="example-btn" onclick="addBullet('Active member of student-led club or community society')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Club or Society</span></div>
                                                <div class="example-btn" onclick="addBullet('Served as official representative for department program execution')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Club or Program Representative</span></div>
                                                <div class="example-btn" onclick="addBullet('Participated extensively in co-curricular (CCA) or extracurricular activities')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Co-curricular (CCA) or Extracurricular Activity</span></div>
                                                <div class="example-btn" onclick="addBullet('Maintained active student association membership status')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Student Association Membership</span></div>
                                                <div class="example-btn" onclick="addBullet('Elected as captain or leader for strategic development operations')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Captain or Leader</span></div>
                                                <div class="example-btn" onclick="addBullet('Represented institution in competitive sports participation events')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Sports Participation</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header" onclick="toggleCategory('cat-5', this)">International Schooling <i class="fa-solid fa-chevron-down arrow-icon"></i></div>
                                        <div id="cat-5" class="p-3 bg-slate-50/50 hidden border-t border-slate-100">
                                            <p class="text-[11px] text-slate-500 mb-1 font-semibold leading-snug">Do you have experience studying abroad?</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                <div class="example-btn" onclick="addBullet('Completed international student exchange semester and study abroad track')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Study Abroad</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <div class="accordion-header" onclick="toggleCategory('cat-6', this)">Apprenticeship and Internship <i class="fa-solid fa-chevron-down arrow-icon"></i></div>
                                        <div id="cat-6" class="p-3 bg-slate-50/50 hidden border-t border-slate-100">
                                            <p class="text-[11px] text-slate-500 mb-1 font-semibold leading-snug">Hands-on learning through apprenticeships or internships demonstrate commitment to the job!</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                <div class="example-btn" onclick="addBullet('Completed technical field apprenticeship training program')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Apprenticeship</span></div>
                                                <div class="example-btn" onclick="addBullet('Gained practical development experience through professional industry internship')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Internship</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-none">
                                        <div class="accordion-header" onclick="toggleCategory('cat-7', this)">Thesis, dissertation and other projects <i class="fa-solid fa-chevron-down arrow-icon"></i></div>
                                        <div id="cat-7" class="p-3 bg-slate-50/50 hidden border-t border-slate-100">
                                            <p class="text-[11px] text-slate-500 mb-1 font-semibold leading-snug">Let's include your noteworthy projects here.</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                <div class="example-btn" onclick="addBullet('Successfully completed research thesis requirement')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Thesis</span></div>
                                                <div class="example-btn" onclick="addBullet('Conducted systematic academic research projects')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Research Projects</span></div>
                                                <div class="example-btn" onclick="addBullet('Authored academic dissertation for co-curricular evaluation')"><div class="plus-icon"><i class="fa-solid fa-plus"></i></div><span class="text-xs font-bold text-slate-600">Dissertation</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="lg:col-span-6 mt-2">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Education Description</p>
                                <div class="editor-container shadow-sm">
                                    <div class="bg-slate-50 p-1.5 border-b flex items-center justify-between border-slate-200 toolbar-scrollbox select-none">
                                        <div class="flex items-center gap-1 flex-nowrap whitespace-nowrap">
                                            <button onclick="formatStyle('bold', this)" class="toolbar-btn" id="tool-bold"><i class="fa-solid fa-bold"></i></button>
                                            <button onclick="formatStyle('italic', this)" class="toolbar-btn" id="tool-italic"><i class="fa-solid fa-italic"></i></button>
                                            <button onclick="formatStyle('underline', this)" class="toolbar-btn" id="tool-underline"><i class="fa-solid fa-underline"></i></button>
                                            <button onclick="formatStyle('insertUnorderedList', this)" class="toolbar-btn" id="tool-list"><i class="fa-solid fa-list-ul"></i></button>
                                            <button onclick="toggleSpellCheck(this)" class="toolbar-btn active-tool" id="tool-spell"><i class="fa-solid fa-spell-check"></i></button>
                                        </div>
                                        <div class="h-4 w-[1px] bg-slate-300 mx-1 flex-shrink-0"></div>
                                        <div class="flex items-center gap-1 flex-nowrap whitespace-nowrap">
                                            <button onclick="clearFormatting()" class="toolbar-btn" title="Clear Formatting"><i class="fa-solid fa-text-slash"></i></button>
                                            <button onclick="showLinkPopup()" class="toolbar-btn"><i class="fa-solid fa-link"></i></button>
                                            <button onclick="format('undo')" class="toolbar-btn"><i class="fa-solid fa-rotate-left"></i></button>
                                            <button onclick="format('redo')" class="toolbar-btn"><i class="fa-solid fa-rotate-right"></i></button>
                                        </div>
                                    </div>
                                    <div id="editor" contenteditable="true" spellcheck="true" class="editor-area bg-white text-slate-800" oninput="updatePreview()"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
<div class="preview-pane-container real-template-mode ghost-corecv-stage" id="educationPreviewHost">
    <!-- Core CV One Column live editable preview is rendered here by JS. No PNG editing, no old blue sidebar. -->
</div>
            <div class="w-full max-w-sm flex justify-center gap-3 px-6 mt-5 z-30">
                <button id="btnPreview" class="px-6 py-2 bg-white border-2 border-slate-800 text-slate-800 font-extrabold rounded-full hover:bg-slate-50 transition text-[11px] uppercase tracking-wide min-w-[110px]">
                    Preview
                </button>
                <button id="btnNextFooter" class="px-8 py-2 bg-pink-500 text-white font-extrabold rounded-full shadow hover:bg-pink-600 transition text-[11px] uppercase tracking-wide min-w-[130px]">
                    Save & Next
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
        <div class="text-gray-500">
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
                                    <div class="exact-live-chip exact-live-contact prev_email_big">Education Preview</div>
                                    <div class="exact-live-chip exact-live-section theme-text">Education</div>
                                    <div class="exact-live-chip exact-live-info">
                                        <span id="modal_prev_school">HITEC University</span> • <span id="modal_prev_date">2020 - 2024</span><br>
                                        <span id="modal_prev_degree">Bachelor of Science</span>, <span id="modal_prev_field">Software Engineering</span>
                                        <div id="modal_prev_details" class="mt-2 text-[11px] leading-snug whitespace-normal"></div>
                                    </div>
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


    <div id="linkModal" class="fixed inset-0 modal-overlay hidden items-center justify-center z-[100]">
        <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl border animation-fade-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 tracking-tight">Add link</h3>
                <i class="fa-solid fa-xmark text-gray-400 cursor-pointer hover:text-red-500 text-xl" onclick="hideLinkPopup()"></i>
            </div>
            <div class="space-y-4">
                <div><label class="form-label">Link Text</label><input type="text" id="link_text" class="input-field" placeholder="WebCo"></div>
                <div><label class="form-label">Link (URL)</label><input type="text" id="link_url" class="input-field" placeholder="www.website.com"></div>
                <div class="flex gap-4 pt-4">
                    <button onclick="hideLinkPopup()" class="w-1/2 py-3 text-blue-700 font-bold hover:bg-slate-50 transition rounded-lg text-sm">Cancel</button>
                    <button onclick="applyLink()" class="w-1/2 py-3 btn-navy rounded-lg font-bold shadow-md text-sm">Add Link</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('resume_token');
        const resumeId = localStorage.getItem('current_resume_id');
        if (!token || !resumeId) window.location.href = '/login';

        // Custom Accordion Controllers
        function toggleMainCoursework() {
            document.getElementById('coursework-main-section').classList.toggle('hidden');
            document.getElementById('main-arrow').classList.toggle('rotated');
        }

        // Accordion Category Handler Engine
        function toggleCategory(catId, headerElement) {
            document.getElementById(catId).classList.toggle('hidden');
            const icon = headerElement.querySelector('.arrow-icon') || headerElement.querySelector('i');
            if(icon) icon.classList.toggle('rotated');
        }

        // --- ENHANCED RICH EDITOR LOGIC ENGINE ---
        function format(cmd) {
            document.execCommand(cmd, false, null);
            updatePreview();
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

        async function loadSelectedTemplateForEducation() {
            if (!token || !resumeId) return;

            try {
                const res = await fetch(`https://resume-backend-54se.onrender.com/api/resumes/get/${resumeId}`, {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });

                const data = await res.json();

                if (data.success && data.resume) {
                    applySelectedTemplateBadge(data.resume);
                    if (data.resume.template_key || data.resume.template_id) {
                        localStorage.setItem("selected_template", data.resume.template_key || data.resume.template_id);
                    }
                }
            } catch (error) {
                console.error("Selected template load failed:", error);
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

                    if (typeof applySelectedTemplateBadge === "function") {
                        applySelectedTemplateBadge(data.resume);
                    }

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

        loadSelectedTemplateForEducation();
        function formatStyle(cmd, btnElement) {
            const editor = document.getElementById('editor');
            editor.focus();
            if (cmd === 'insertUnorderedList') {
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    const range = selection.getSelection().getRangeAt(0);
                    const container = range.commonAncestorContainer;
                    const blockNode = container.nodeType === 1 ? container : container.parentElement;
                    const isInsideList = blockNode.closest('ul, li') || document.queryCommandState('insertUnorderedList');
                    if (isInsideList) {
                        document.execCommand('insertUnorderedList', false, null);
                    } else {
                        const selectedText = selection.toString().trim();
                        if (selectedText !== "") {
                            document.execCommand('insertUnorderedList', false, null);
                        } else {
                            const currentHTML = editor.innerHTML.trim();
                            if (currentHTML !== "" && !currentHTML.startsWith('<ul>') && !currentHTML.startsWith('<li>')) {
                                const items = currentHTML.split(/<br>|<div>|<\/div>/i).filter(el => el.trim() !== "");
                                let listHTML = '<ul>';
                                items.forEach(item => {
                                    listHTML += `<li>${item.trim()}</li>`;
                                });
                                listHTML += '</ul>';
                                editor.innerHTML = listHTML;
                            } else {
                                document.execCommand('insertUnorderedList', false, null);
                            }
                        }
                    }
                }
            } else {
                document.execCommand(cmd, false, null);
            }
            const isListActive = document.queryCommandState('insertUnorderedList') || editor.innerHTML.includes('<li>');
            const listBtn = document.getElementById('tool-list');
            if (isListActive) {
                listBtn.classList.add('active-tool');
            } else {
                listBtn.classList.remove('active-tool');
            }
            if (cmd !== 'insertUnorderedList') {
                btnElement.classList.toggle('active-tool', document.queryCommandState(cmd));
            }
            updatePreview();
        }

        document.getElementById('tool-list').classList.remove('active-tool');

        // Clear All Formatting Styles
        function clearFormatting() {
            document.execCommand('removeFormat', false, null);
            ['tool-bold', 'tool-italic', 'tool-underline', 'tool-list'].forEach(id => {
                document.getElementById(id).classList.remove('active-tool');
            });
            updatePreview();
        }

        // Toggle Spellcheck Engine
        function toggleSpellCheck(btnElement) {
            const editor = document.getElementById('editor');
            const isSpellCheckOn = editor.getAttribute('spellcheck') === 'true';
            editor.setAttribute('spellcheck', !isSpellCheckOn);
            btnElement.classList.toggle('active-tool');
        }

        // Modal triggers
        function showLinkPopup() {
            document.getElementById('linkModal').classList.remove('hidden');
            document.getElementById('linkModal').classList.add('flex');
        }

        function hideLinkPopup() {
            document.getElementById('linkModal').classList.remove('flex');
            document.getElementById('linkModal').classList.add('hidden');
        }

        function applyLink() {
            const text = document.getElementById('link_text').value;
            const url = document.getElementById('link_url').value;
            document.getElementById('editor').focus();
            document.execCommand('insertHTML', false, `<a href="https://${url}" class="text-blue-600 underline font-semibold" target="_blank">${text}</a>`);
            hideLinkPopup();
            updatePreview();
        }

        function addBullet(text) {
            const editor = document.getElementById('editor');
            editor.focus();
            if (!editor.innerHTML.includes('<li>')) {
                editor.innerHTML = `<ul><li>${text}</li></ul>`;
            } else {
                const ul = editor.querySelector('ul');
                if (ul) {
                    ul.innerHTML += `<li>${text}</li>`;
                } else {
                    document.execCommand('insertHTML', false, `<li>${text}</li>`);
                }
            }
            document.getElementById('tool-list').classList.add('active-tool');
            updatePreview();
        }

        // Live Realtime Dynamic Renderer
        function updatePreview() {
            document.getElementById('prev_school').innerText = document.getElementById('inp_school').value || "HITEC University";
            document.getElementById('prev_degree').innerText = document.getElementById('inp_degree').value || "Bachelor of Science";
            document.getElementById('prev_field').innerText = document.getElementById('inp_field').value || "Software Engineering";
            const month = document.getElementById('inp_month').value;
            const year = document.getElementById('inp_year').value;
            document.getElementById('prev_date').innerText = (month || year) ? `${month} ${year}` : "2020 - 2024";
            document.getElementById('prev_details').innerHTML = document.getElementById('editor').innerHTML;
        }

        // Setup Options Years Range
        const yrSelect = document.getElementById('inp_year');
        for(let i = new Date().getFullYear() + 5; i >= 1960; i--) {
            yrSelect.innerHTML += `<option value="${i}">${i}</option>`;
        }

        function setSelectOrAddOption(selectId, value) {
            const select = document.getElementById(selectId);
            if (!select) return;
            const cleanValue = (value || '').trim();
            if (!cleanValue) {
                select.value = '';
                return;
            }
            const exists = Array.from(select.options).some(opt => opt.value === cleanValue);
            if (!exists) {
                const option = new Option(cleanValue, cleanValue);
                select.add(option);
            }
            select.value = cleanValue;
        }

        // Data Population Pipeline
        async function loadData() {
            try {
                const resH = await fetch(`https://resume-backend-54se.onrender.com/api/resumes/get/${resumeId}`, { headers: { 'Authorization': 'Bearer ' + token } });
                const dH = await resH.json();
                if(dH.success) {
                    document.getElementById('prev_name').innerText = dH.resume.first_name + " " + (dH.resume.last_name || '');
                    document.getElementById('prev_contact').innerText = `${dH.resume.city || ''}, ${dH.resume.country || ''} | ${dH.resume.phone || ''} | ${dH.resume.email || ''}`;
                }
                const resE = await fetch(`https://resume-backend-54se.onrender.com/api/resumes/education/${resumeId}`, { headers: { 'Authorization': 'Bearer ' + token } });
                const dE = await resE.json();
                if(dE.success && dE.education) {
                    const e = dE.education;
                    document.getElementById('inp_school').value = e.school_name || '';
                    setSelectOrAddOption('inp_degree', e.degree || '');
                    document.getElementById('inp_field').value = e.field_of_study || '';
                    document.getElementById('inp_month').value = e.graduation_month || '';
                    document.getElementById('inp_year').value = e.graduation_year || '';
                    document.getElementById('editor').innerHTML = e.education_description || '';
                    if(e.school_location) document.getElementById('inp_location').value = e.school_location;
                    updatePreview();
                }
            } catch(e) {
                console.log(e);
            }
        }
        loadData();

        // Node Persistence Endpoint Pipeline Handler
        async function saveAndNextPipeline() {
            const btn = document.getElementById('btnNextFooter');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> SAVING...';
            btn.disabled = true;
            const payload = {
                resume_id: resumeId,
                school_name: document.getElementById('inp_school').value,
                school_location: document.getElementById('inp_location').value,
                degree: document.getElementById('inp_degree').value,
                field_of_study: document.getElementById('inp_field').value,
                graduation_month: document.getElementById('inp_month').value,
                graduation_year: document.getElementById('inp_year').value,
                education_description: document.getElementById('editor').innerHTML
            };
            try {
                const res = await fetch('https://resume-backend-54se.onrender.com/api/resumes/education', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token },
                    body: JSON.stringify(payload)
                });
                if((await res.json()).success) {
                    window.location.href = "/builder/experience";
                }
            } catch(e) {
                alert("Error saving.");
            } finally {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }
        }

        // Event Listeners for Save Action Endpoints
        document.getElementById('btnNextFooter').addEventListener('click', saveAndNextPipeline);


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

        function getTemplateKeyValue(template) { return template?.template_key || String(template?.id || ''); }
        function getTemplateImageUrl(thumbnail) { if (!thumbnail) return ''; return thumbnail.startsWith('http') ? thumbnail : 'https://resume-backend-54se.onrender.com' + thumbnail; }
        function setImageOrFallback(img, fallback, thumbnail) {
            if (!img) return;
            const imageUrl = getTemplateImageUrl(thumbnail);
            if (!imageUrl) { img.classList.add('hidden'); if (fallback) fallback.classList.remove('hidden'); return; }
            img.classList.remove('hidden'); if (fallback) fallback.classList.add('hidden');
            img.onerror = function () { this.classList.add('hidden'); if (fallback) fallback.classList.remove('hidden'); };
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

        function getActiveTemplateKey() { return localStorage.getItem('selected_template') || ''; }
        function applySelectedTemplateBadge(resume) {
            const badge = document.getElementById('selectedTemplateBadge');
            const thumb = document.getElementById('selectedTemplateThumb');
            const name = document.getElementById('selectedTemplateName');
            const category = document.getElementById('selectedTemplateCategory');
            if (!badge || !thumb || !name || !category || !resume) return;
            const thumbnail = resume.template_thumbnail_url || resume.thumbnail_url;
            name.textContent = resume.template_name || resume.name || 'Selected Template';
            category.textContent = resume.template_category || resume.category || 'Professional';
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
        async function loadSelectedTemplateForEducation() {
            if (!token || !resumeId) return;
            try {
                const res = await fetch(`https://resume-backend-54se.onrender.com/api/resumes/get/${resumeId}`, { headers: { 'Authorization': 'Bearer ' + token } });
                const data = await res.json();
                if (data.success && data.resume) {
                    applySelectedTemplateBadge(data.resume);
                    if (data.resume.template_key || data.resume.template_id) localStorage.setItem('selected_template', data.resume.template_key || data.resume.template_id);
                    updateModalCurrentTemplateInfo(data.resume);
                }
            } catch (error) { console.error('Selected template load failed:', error); }
        }
        function updateModalCurrentTemplateInfo(templateOrResume = null) {
            const name = templateOrResume?.template_name || templateOrResume?.name || document.getElementById('selectedTemplateName')?.textContent || 'Selected Template';
            const category = templateOrResume?.template_category || templateOrResume?.category || document.getElementById('selectedTemplateCategory')?.textContent || 'Professional';
            const thumbnail = templateOrResume?.template_thumbnail_url || templateOrResume?.thumbnail_url || document.getElementById('selectedTemplateThumb')?.src || '';
            ['modalCurrentTemplateName','modalLargeTemplateName'].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = name; });
            ['modalCurrentTemplateCategory','modalLargeTemplateCategory'].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = category; });
            const textNode = document.getElementById('modalSelectedTemplateText'); if (textNode) textNode.textContent = 'Current: ' + name + ' • ' + category;
            setImageOrFallback(document.getElementById('modalCurrentTemplateImg'), null, thumbnail);
            setImageOrFallback(document.getElementById('modalCurrentTemplateLargeImg'), document.getElementById('modalCurrentTemplateLargeFallback'), thumbnail);
            setImageOrFallback(document.getElementById('modalFullTemplateImg'), document.getElementById('modalFullTemplateFallback'), thumbnail);
            setExactLiveTemplateBackground(thumbnail);
        }
        function sortTemplatesForPreview(templates) {
            const sortMode = templateSortSelect?.value || 'selected';
            const active = getActiveTemplateKey();
            const pending = getTemplateKeyValue(pendingPreviewTemplate);
            return [...templates].sort((a,b)=>{
                const ak=getTemplateKeyValue(a), bk=getTemplateKeyValue(b);
                if (pending && ak===pending && bk!==pending) return -1;
                if (pending && bk===pending && ak!==pending) return 1;
                if (active && ak===active && bk!==active) return -1;
                if (active && bk===active && ak!==active) return 1;
                if (sortMode==='name') return String(a.name||'').localeCompare(String(b.name||''));
                if (sortMode==='category') return String(a.category||'').localeCompare(String(b.category||''));
                return 0;
            });
        }
        function renderPreviewTemplates() {
            if (!dynamicTemplatesGrid) return;
            const templates = sortTemplatesForPreview(previewTemplatesCache);
            const active = getActiveTemplateKey();
            const pending = getTemplateKeyValue(pendingPreviewTemplate);
            dynamicTemplatesGrid.innerHTML='';
            if(!templates.length){ dynamicTemplatesGrid.innerHTML='<div class="text-center text-sm text-gray-400 py-10 w-full col-span-2">No templates found.</div>'; return; }
            templates.forEach(tpl=>{
                const key=getTemplateKeyValue(tpl), isActive=active && key===active, isPending=pending && key===pending;
                const card=document.createElement('div');
                card.dataset.previewTemplate=key;
                card.className='preview-template-card '+(isPending?'pending-template-card':isActive?'selected-template-card':'');
                card.innerHTML=`
                    ${isPending ? '<span class="template-status-pill pending">Selected now</span>' : isActive ? '<span class="template-status-pill">Already selected</span>' : ''}
                    <div class="template-thumb-frame">
                        <img src="${getTemplateImageUrl(tpl.thumbnail_url)}" alt="${tpl.name || 'Template'}" onerror="this.classList.add('hidden'); this.parentElement.querySelector('.template-image-fallback').classList.remove('hidden');">
                        <div class="template-image-fallback hidden"><i class="fa-solid fa-image text-lg mb-1"></i>Preview not found</div>
                    </div>
                    <p class="text-center text-xs font-black mt-2 text-gray-800 truncate">${tpl.name || 'Template'}</p>
                    <p class="text-center text-[10px] font-black text-pink-500 uppercase tracking-wider">${tpl.category || 'Professional'}</p>`;
                card.addEventListener('click',()=>{ pendingPreviewTemplate=tpl; updateModalCurrentTemplateInfo(tpl); renderPreviewTemplates(); });
                dynamicTemplatesGrid.appendChild(card);
            });
        }
        async function confirmTemplateChangeFromPreview() {
            if(!pendingPreviewTemplate || !getTemplateKeyValue(pendingPreviewTemplate)){ alert('Please select a template first.'); return; }
            const oldHtml=changeTemplateBtn.innerHTML; changeTemplateBtn.innerHTML='<i class="fa-solid fa-spinner fa-spin mr-2"></i>Updating...'; changeTemplateBtn.disabled=true;
            try{
                const res=await fetch('https://resume-backend-54se.onrender.com/api/resumes/update-template',{method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+token},body:JSON.stringify({resume_id:resumeId,template_id:getTemplateKeyValue(pendingPreviewTemplate)})});
                const data=await res.json();
                if(data.success && data.resume){ localStorage.setItem('selected_template',getTemplateKeyValue(pendingPreviewTemplate)); applySelectedTemplateBadge(data.resume); updateModalCurrentTemplateInfo(data.resume); pendingPreviewTemplate=null; renderPreviewTemplates(); }
                else alert(data.message || 'Template update failed.');
            }catch(error){ console.error('Template update error:',error); alert('Server error while updating template.'); }
            finally{ changeTemplateBtn.innerHTML=oldHtml; changeTemplateBtn.disabled=false; }
        }
        function syncBigPreviewEducation() {
            document.querySelector('.prev_name_big').innerText = document.getElementById('prev_name')?.innerText || 'YOUR NAME';
            document.querySelector('.prev_email_big').innerText = document.getElementById('inp_school')?.value || 'Education Preview';
            document.getElementById('modal_prev_school').innerText = document.getElementById('inp_school').value || 'HITEC University';
            document.getElementById('modal_prev_date').innerText = ((document.getElementById('inp_month').value || '') + ' ' + (document.getElementById('inp_year').value || '')).trim() || '2020 - 2024';
            document.getElementById('modal_prev_degree').innerText = document.getElementById('inp_degree').value || 'Bachelor of Science';
            document.getElementById('modal_prev_field').innerText = document.getElementById('inp_field').value || 'Software Engineering';
            document.getElementById('modal_prev_details').innerHTML = document.getElementById('editor').innerHTML || '';
        }
        openPreviewBtn.addEventListener('click', async()=>{
            document.body.style.overflow='hidden';
            previewModal.classList.remove('hidden'); previewModal.classList.add('flex');
            pendingPreviewTemplate=null; syncBigPreviewEducation(); await loadSelectedTemplateForEducation();
            try{ const res=await fetch('https://resume-backend-54se.onrender.com/api/templates/all'); const data=await res.json(); previewTemplatesCache=data.success?(data.templates||[]):[]; renderPreviewTemplates(); }
            catch(error){ dynamicTemplatesGrid.innerHTML='<p class="text-red-500 text-xs">Failed to load templates.</p>'; }
        });
        function closeModal(){ previewModal.classList.add('hidden'); previewModal.classList.remove('flex'); document.body.style.overflow=''; }
        closePreviewBtn.addEventListener('click',closeModal);
        closePreviewTop.addEventListener('click',closeModal);
        changeTemplateBtn.addEventListener('click',confirmTemplateChangeFromPreview);
        if(templateSortSelect) templateSortSelect.addEventListener('change',renderPreviewTemplates);
        document.querySelectorAll('.color-btn').forEach(btn=>{ btn.addEventListener('click',()=>{ const selectedColor=btn.dataset.color || window.getComputedStyle(btn).backgroundColor; document.querySelectorAll('.color-btn').forEach(b=>b.classList.remove('active-color')); btn.classList.add('active-color'); document.querySelectorAll('.theme-text').forEach(el=>el.style.color=selectedColor); document.querySelectorAll('.theme-border').forEach(el=>el.style.borderColor=selectedColor); }); });

        ['inp_school', 'inp_month', 'inp_year', 'inp_degree', 'inp_field', 'inp_location'].forEach(id => {
            document.getElementById(id).addEventListener('input', updatePreview);
        });
        loadSelectedTemplateForEducation();
    

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



        /* ===== GHOST CLEAN FINAL CORE CV EDUCATION LOGIC ===== */
        (function () {
            let isRenderingCoreCv = false;
            let coreObserver = null;
            const DEFAULT_ACCENT = '#16a34a';

            function qs(id) { return document.getElementById(id); }
            function clean(value) { return String(value || '').replace(/\s+/g, ' ').trim(); }

            function setEditorButtonsType() {
                document.querySelectorAll('.toolbar-btn, .example-btn, #btnPreview, #btnNextFooter, #closePreviewBtn, #closePreviewTop, #changeTemplateBtn, #tool-bold, #tool-italic, #tool-underline, #tool-list, #tool-spell').forEach(btn => {
                    if (btn.tagName === 'BUTTON') btn.setAttribute('type', 'button');
                });
            }

            function getSelectValue(id) {
                const el = qs(id);
                if (!el) return '';
                if (el.tagName === 'SELECT') {
                    const opt = el.options[el.selectedIndex];
                    const text = clean(opt ? opt.textContent : '');
                    const value = clean(el.value);
                    if (['month', 'year', 'select'].includes(text.toLowerCase()) || !value) return '';
                    return text || value;
                }
                return clean(el.value || el.innerText || el.textContent);
            }

            function getContactSnapshot() {
                let snap = {};
                try { snap = JSON.parse(localStorage.getItem('resume_contact_snapshot') || '{}'); } catch (e) { snap = {}; }

                const first = clean(snap.firstName || localStorage.getItem('resume_preview_first_name'));
                const last = clean(snap.lastName || localStorage.getItem('resume_preview_last_name'));

                return {
                    fullName: clean(snap.fullName) || clean(localStorage.getItem('resume_preview_name')) || clean([first, last].filter(Boolean).join(' ')) || 'Your Name',
                    city: clean(snap.city || localStorage.getItem('resume_preview_city')) || 'City',
                    country: clean(snap.country || localStorage.getItem('resume_preview_country')) || 'Country',
                    postal: clean(snap.postal || localStorage.getItem('resume_preview_postal')),
                    phone: clean(snap.phoneFull || snap.phone || localStorage.getItem('resume_preview_phone')) || 'Phone',
                    email: clean(snap.email || localStorage.getItem('resume_preview_email')) || 'your.email@example.com'
                };
            }

            function editor() { return qs('editor') || qs('coursework-editor') || document.querySelector('[contenteditable="true"]') || document.querySelector('.editor-area'); }

            function sanitizeEditorHtml(html) {
                const raw = String(html || '').trim();
                if (!raw) return '';

                const wrapper = document.createElement('div');
                wrapper.innerHTML = raw;
                const allowed = new Set(['B','STRONG','I','EM','U','A','UL','OL','LI','BR','DIV','P','SPAN']);

                function walk(node) {
                    Array.from(node.childNodes).forEach(child => {
                        if (child.nodeType === Node.ELEMENT_NODE) {
                            if (!allowed.has(child.tagName)) {
                                const frag = document.createDocumentFragment();
                                while (child.firstChild) frag.appendChild(child.firstChild);
                                child.replaceWith(frag);
                                walk(node);
                                return;
                            }

                            Array.from(child.attributes).forEach(attr => {
                                const name = attr.name.toLowerCase();
                                if (child.tagName === 'A' && name === 'href') {
                                    const href = child.getAttribute('href') || '';
                                    if (!/^https?:\/\//i.test(href)) child.setAttribute('href', 'https://' + href.replace(/^\/+/, ''));
                                    child.setAttribute('target', '_blank');
                                    child.setAttribute('rel', 'noopener noreferrer');
                                } else if (name !== 'href') {
                                    child.removeAttribute(attr.name);
                                }
                            });
                            walk(child);
                        }
                    });
                }
                walk(wrapper);
                return wrapper.innerHTML.trim();
            }

            function editorHtml() {
                const ed = editor();
                if (!ed) return '';
                return sanitizeEditorHtml(ed.innerHTML || ed.value || '');
            }

            function editorFallbackHtml() {
                return '<ul><li>Add coursework, awards, scholarships, internships or projects from the left side.</li><li>Extra education details will automatically align inside this template.</li></ul>';
            }

            function educationData() {
                const c = getContactSnapshot();
                const month = getSelectValue('inp_month');
                const year = getSelectValue('inp_year');
                return {
                    ...c,
                    school: getSelectValue('inp_school') || 'School / College Name',
                    location: getSelectValue('inp_location') || 'Study Location',
                    degree: getSelectValue('inp_degree') || 'Qualification',
                    field: getSelectValue('inp_field') || 'Subject',
                    date: [month, year].filter(Boolean).join(' ') || 'Study dates',
                    highlightsHtml: editorHtml() || editorFallbackHtml()
                };
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
                return clean(localStorage.getItem('resume_accent_color')) || clean(localStorage.getItem('selected_template_default_color')) || DEFAULT_ACCENT;
            }

            function coreCvMarkup(data, modalMode = false) {
                return `
                    <div class="core-cv-live ${modalMode ? 'modal-size' : ''}" style="--cv-accent:${esc(selectedAccent())}">
                        <div class="core-cv-top-line">Use this area to express your career aspirations and goals, and quickly connect with an employer.</div>
                        <div class="core-cv-header-line"></div>
                        <div class="core-cv-name">${esc(data.fullName)}</div>
                        <div class="core-cv-contact">${esc([data.city, data.country, data.postal].filter(Boolean).join(', '))}<br>${esc(data.phone)} &nbsp; | &nbsp; ${esc(data.email)}</div>

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
                            <div class="core-cv-grid-3 core-cv-text">
                                <ul class="core-cv-list"><li>Learning</li><li>Research</li><li>Teamwork</li></ul>
                                <ul class="core-cv-list"><li>Communication</li><li>Planning</li><li>Problem Solving</li></ul>
                                <ul class="core-cv-list"><li>Documentation</li><li>Presentation</li><li>Analysis</li></ul>
                            </div>
                        </section>

                        <section class="core-cv-section">
                            <div class="core-cv-title">Career History</div>
                            <div class="core-cv-history-row core-cv-text">
                                <div><span class="core-cv-bold">Your Most Recent Job Title</span><br>Duties</div>
                                <div>Employer name</div>
                                <div class="core-cv-muted">Employment dates</div>
                            </div>
                            <div class="core-cv-text">In concise sentences describe the daily tasks you undertook.</div>
                        </section>

                        <section class="core-cv-section">
                            <div class="core-cv-title">Academic Qualifications</div>
                            <div class="core-cv-edu-row core-cv-text">
                                <div><span class="core-cv-bold">${esc(data.school)}</span><br>${esc(data.degree)} / ${esc(data.field)}</div>
                                <div>${esc(data.location)}</div>
                                <div class="core-cv-muted">${esc(data.date)}</div>
                            </div>
                        </section>

                        <section class="core-cv-section">
                            <div class="core-cv-title">Education Highlights</div>
                            <div class="core-cv-editor-html">${data.highlightsHtml}</div>
                        </section>
                    </div>
                `;
            }

            function previewHost() { return qs('educationPreviewHost') || document.querySelector('.preview-pane-container'); }

            function renderCoreCvEducationPreview() {
                const host = previewHost();
                if (!host) return;

                const oldScrollBox = host.querySelector('.core-cv-scrollbox');
                const savedScrollTop = oldScrollBox
                    ? oldScrollBox.scrollTop
                    : Number(localStorage.getItem('core_cv_education_scroll_top') || 0);

                isRenderingCoreCv = true;
                host.classList.add('real-template-mode', 'ghost-corecv-stage');

                let scrollBox = host.querySelector('.core-cv-scrollbox');

                if (!scrollBox) {
                    host.innerHTML = '<div class="core-cv-scrollbox"></div>';
                    scrollBox = host.querySelector('.core-cv-scrollbox');
                }

                if (scrollBox) {
                    scrollBox.innerHTML = coreCvMarkup(educationData(), false);

                    requestAnimationFrame(function () {
                        scrollBox.scrollTop = savedScrollTop;
                    });

                    if (scrollBox.dataset.scrollLockBound !== '1') {
                        scrollBox.dataset.scrollLockBound = '1';
                        scrollBox.addEventListener('scroll', function () {
                            localStorage.setItem('core_cv_education_scroll_top', String(this.scrollTop));
                        }, { passive: true });
                    }
                }

                localStorage.setItem('resume_preview_education_school', getSelectValue('inp_school'));
                localStorage.setItem('resume_preview_education_location', getSelectValue('inp_location'));
                localStorage.setItem('resume_preview_education_degree', getSelectValue('inp_degree'));
                localStorage.setItem('resume_preview_education_field', getSelectValue('inp_field'));
                localStorage.setItem('resume_preview_education_date', [getSelectValue('inp_month'), getSelectValue('inp_year')].filter(Boolean).join(' '));
                localStorage.setItem('resume_preview_education_extra_html', editorHtml());
                setTimeout(() => { isRenderingCoreCv = false; }, 0);
            }

            function renderCoreCvModalPreview() {
                const paper = document.querySelector('.preview-paper-wrap');
                if (!paper) return;
                paper.innerHTML = coreCvMarkup(educationData(), true);
                paper.style.alignItems = 'center';
                paper.style.justifyContent = 'center';
            }

            function updateToolbarStates() {
                const map = { bold: 'tool-bold', italic: 'tool-italic', underline: 'tool-underline', insertUnorderedList: 'tool-list' };
                Object.entries(map).forEach(([cmd, id]) => {
                    const btn = qs(id);
                    if (!btn) return;
                    let active = false;
                    try { active = document.queryCommandState(cmd); } catch (e) { active = false; }
                    if (cmd === 'insertUnorderedList') active = active || !!(editor() && editor().querySelector('li'));
                    btn.classList.toggle('active-tool', active);
                });
            }

            window.formatStyle = function (cmd, btnElement) {
                const ed = editor();
                if (!ed) return;
                ed.focus();
                try { document.execCommand(cmd, false, null); } catch (e) { console.warn('format failed', cmd, e); }
                updateToolbarStates();
                renderCoreCvEducationPreview();
            };

            window.format = function (cmd) {
                const ed = editor();
                if (!ed) return;
                ed.focus();
                try { document.execCommand(cmd, false, null); } catch (e) { console.warn('format failed', cmd, e); }
                updateToolbarStates();
                renderCoreCvEducationPreview();
            };

            window.clearFormatting = function () {
                const ed = editor();
                if (!ed) return;
                ed.focus();
                try { document.execCommand('removeFormat', false, null); } catch (e) {}
                updateToolbarStates();
                renderCoreCvEducationPreview();
            };

            window.addBullet = function (text) {
                const ed = editor();
                if (!ed) return;
                ed.focus();
                if (!ed.innerHTML.trim()) ed.innerHTML = '<ul></ul>';
                let ul = ed.querySelector('ul');
                if (!ul) {
                    ed.innerHTML = '<ul>' + ed.innerHTML.replace(/<div>/gi, '<li>').replace(/<\/div>/gi, '</li>').replace(/<br\s*\/?>/gi, '') + '</ul>';
                    ul = ed.querySelector('ul');
                }
                const li = document.createElement('li');
                li.textContent = text;
                ul.appendChild(li);
                updateToolbarStates();
                renderCoreCvEducationPreview();
            };

            window.applyLink = function () {
                const text = clean(qs('link_text')?.value);
                let url = clean(qs('link_url')?.value);
                if (!url) return;
                if (!/^https?:\/\//i.test(url)) url = 'https://' + url;
                const ed = editor();
                if (!ed) return;
                ed.focus();
                const label = text || url;
                try { document.execCommand('insertHTML', false, `<a href="${esc(url)}" target="_blank" rel="noopener noreferrer">${esc(label)}</a>`); } catch (e) {}
                if (typeof hideLinkPopup === 'function') hideLinkPopup();
                renderCoreCvEducationPreview();
            };

            window.updatePreview = renderCoreCvEducationPreview;
            window.updateModernEducationPreview = renderCoreCvEducationPreview;
            window.updateEducationPreviewFinal = renderCoreCvEducationPreview;
            window.forceEducationVideoStylePreview = renderCoreCvEducationPreview;
            window.renderCoreCvEducationPreview = renderCoreCvEducationPreview;

            function bindEvents() {
                setEditorButtonsType();
                ['inp_school','inp_location','inp_degree','inp_field','inp_month','inp_year'].forEach(id => {
                    const el = qs(id);
                    if (!el || el.dataset.ghostCoreBound === '1') return;
                    el.dataset.ghostCoreBound = '1';
                    el.addEventListener('input', renderCoreCvEducationPreview);
                    el.addEventListener('change', renderCoreCvEducationPreview);
                });

                const ed = editor();
                if (ed && ed.dataset.ghostCoreBound !== '1') {
                    ed.dataset.ghostCoreBound = '1';
                    ed.addEventListener('input', () => { updateToolbarStates(); renderCoreCvEducationPreview(); });
                    ed.addEventListener('keyup', () => { updateToolbarStates(); renderCoreCvEducationPreview(); });
                    ed.addEventListener('mouseup', updateToolbarStates);
                    ed.addEventListener('paste', () => setTimeout(renderCoreCvEducationPreview, 80));
                    ed.addEventListener('keydown', e => {
                        if (e.key === 'Tab') {
                            e.preventDefault();
                            document.execCommand('insertText', false, '    ');
                            renderCoreCvEducationPreview();
                        }
                    });
                }

                document.querySelectorAll('.accordion-header, .example-btn, .main-toggle-header').forEach(el => {
                    if (el.dataset.ghostCoreClickBound === '1') return;
                    el.dataset.ghostCoreClickBound = '1';
                    el.addEventListener('click', () => setTimeout(renderCoreCvEducationPreview, 90));
                });

                const previewBtn = qs('btnPreview');
                if (previewBtn && previewBtn.dataset.ghostCorePreviewBound !== '1') {
                    previewBtn.dataset.ghostCorePreviewBound = '1';
                    previewBtn.addEventListener('click', () => setTimeout(renderCoreCvModalPreview, 140));
                }
            }

            function protectPreview() {
                const host = previewHost();
                if (!host || coreObserver) return;
                coreObserver = new MutationObserver(function () {
                    if (isRenderingCoreCv) return;
                    if (!host.querySelector('.core-cv-live')) requestAnimationFrame(renderCoreCvEducationPreview);
                });
                coreObserver.observe(host, { childList: true });
            }

            function boot() {
                localStorage.setItem('selected_template_layout_key', 'core_cv_one_column');
                localStorage.setItem('selected_template_default_color', selectedAccent());
                bindEvents();
                renderCoreCvEducationPreview();
                protectPreview();
            }

            document.addEventListener('DOMContentLoaded', function () {
                boot();
                setTimeout(boot, 120);
                setTimeout(boot, 500);
            });
            setTimeout(boot, 60);
        })();
    </script>


<!-- GHOST FINAL EDUCATION RIGHT PREVIEW MATCH CONTACT - UI ONLY, OLD LOGIC UNCHANGED -->
<style id="ghost-education-right-preview-contact-size-final">
    /* End page/body scrollbar hatao, sirf center form area invisible-scroll ke sath move kare */
    html,
    body,
    body > .flex.flex-grow,
    .builder-right-preview-panel,
    .builder-right-preview-panel .ghost-corecv-stage,
    .core-cv-scrollbox {
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    html::-webkit-scrollbar,
    body::-webkit-scrollbar,
    body > .flex.flex-grow::-webkit-scrollbar,
    .builder-right-preview-panel::-webkit-scrollbar,
    .builder-right-preview-panel .ghost-corecv-stage::-webkit-scrollbar,
    .core-cv-scrollbox::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    /* Right side same contact page feel: static template, no internal scrollbar */
    .builder-right-preview-panel {
        width: 40% !important;
        max-width: 40% !important;
        flex: 0 0 40% !important;
        height: 133.3333333333vh !important;
        background: #ffffff !important;
        border-left: 0 !important;
        padding: 150px 30px 82px 26px !important;
        overflow: hidden !important;
        align-items: center !important;
        justify-content: flex-start !important;
        position: sticky !important;
        top: 0 !important;
        align-self: flex-start !important;
    }

    .builder-right-preview-panel::before {
        display: none !important;
        content: none !important;
        box-shadow: none !important;
        background: transparent !important;
        border: 0 !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
        width: min(100%, 560px) !important;
        height: 545px !important;
        min-height: 545px !important;
        max-height: 545px !important;
        padding: 0 !important;
        margin-top: 35px !important;
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
        overflow: hidden !important;
        padding: 0 !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
        scrollbar-gutter: auto !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
    .core-cv-scrollbox .core-cv-live,
    .core-cv-live {
        width: 390px !important;
        height: 545px !important;
        min-height: 545px !important;
        max-height: 545px !important;
        max-width: 96% !important;
        padding: 30px 36px !important;
        margin: 0 auto !important;
        transform: none !important;
        border-radius: 6px !important;
        box-shadow: none !important;
        background: #ffffff !important;
        overflow: hidden !important;
        flex: 0 0 auto !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-editor-html,
    .core-cv-live .core-cv-editor-html {
        max-height: 78px !important;
        overflow: hidden !important;
    }

    /* Buttons contact page jaisi height/width me visible rakho */
    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        position: relative !important;
        z-index: 4 !important;
        max-width: 390px !important;
        width: 100% !important;
        gap: 18px !important;
        padding: 0 !important;
        margin-top: 70px !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-shrink: 0 !important;
    }

    #btnPreview,
    #btnNextFooter,
    #btnNext {
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
        box-shadow: none !important;
    }

    #btnPreview {
        min-width: 138px !important;
        border: 2px solid #0f172a !important;
        color: #0f172a !important;
        background: #ffffff !important;
    }

    #btnNextFooter,
    #btnNext {
        min-width: 188px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
    }
</style>


<!-- GHOST FINAL EDUCATION PREVIEW POSITION + SHADOW FIX - UI ONLY, OLD LOGIC UNCHANGED -->
<style id="ghost-education-preview-shadow-corner-contact-location">
    /* Right preview contact-page location: no visible scrollbars, template static */
    .builder-right-preview-panel,
    .builder-right-preview-panel .ghost-corecv-stage,
    .core-cv-scrollbox {
        overflow: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    .builder-right-preview-panel::-webkit-scrollbar,
    .builder-right-preview-panel .ghost-corecv-stage::-webkit-scrollbar,
    .core-cv-scrollbox::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    /* Template ka top Share your education journey wali row se start ho */
    .builder-right-preview-panel {
        background: #ffffff !important;
        border-left: 0 !important;
        justify-content: flex-start !important;
        align-items: center !important;
        padding-top: 132px !important;
        padding-bottom: 72px !important;
        padding-left: 26px !important;
        padding-right: 30px !important;
    }

    .builder-right-preview-panel::before,
    .builder-right-preview-panel::after {
        display: none !important;
        content: none !important;
        background: transparent !important;
        box-shadow: none !important;
        border: 0 !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
        width: min(100%, 560px) !important;
        height: 520px !important;
        min-height: 520px !important;
        max-height: 520px !important;
        padding: 0 !important;
        margin-top: 0 !important;
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
        overflow: hidden !important;
        padding: 0 !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
        background: transparent !important;
    }

    /* Template ko visible corners + soft shadow do */
    .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
    .core-cv-scrollbox .core-cv-live,
    .core-cv-live {
        width: 390px !important;
        height: 520px !important;
        min-height: 520px !important;
        max-height: 520px !important;
        max-width: 96% !important;
        padding: 30px 36px !important;
        margin: 0 auto !important;
        transform: none !important;
        border-radius: 10px !important;
        box-shadow: 0 24px 58px rgba(15, 23, 42, .16) !important;
        background: #ffffff !important;
        overflow: hidden !important;
        flex: 0 0 auto !important;
    }

    /* Buttons contact page wali location/size par */
    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        position: relative !important;
        z-index: 4 !important;
        max-width: 390px !important;
        width: 100% !important;
        gap: 18px !important;
        padding: 0 !important;
        margin-top: 48px !important;
        transform: none !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-shrink: 0 !important;
    }

    #btnPreview,
    #btnNextFooter,
    #btnNext {
        height: 54px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        text-transform: uppercase !important;
        font-size: 13px !important;
        font-weight: 950 !important;
        letter-spacing: .08em !important;
        padding: 0 26px !important;
        box-shadow: none !important;
    }

    #btnPreview {
        min-width: 138px !important;
        border: 2px solid #0f172a !important;
        color: #0f172a !important;
        background: #ffffff !important;
    }

    #btnNextFooter,
    #btnNext {
        min-width: 188px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
    }
</style>


<!-- GHOST FINAL: EDUCATION BLUE LEFT SIDEBAR MATCHED WITH CONTACT PAGE - ONLY BLUE AREA UPDATED -->
<style id="ghost-education-blue-sidebar-from-contact-only">
:root {
    --ghost-ref-blue: #073f70;
    --ghost-ref-purple: #a855f7;
    --ghost-ref-green: #34d399;
    --ghost-ref-circle: #0f172a;
}

/* BLUE LEFT SIDEBAR ONLY */
body > nav {
    position: fixed !important;
    left: 0 !important;
    top: 0 !important;
    bottom: 0 !important;
    width: 360px !important;
    max-width: 360px !important;
    height: 133.3333333333vh !important;
    min-height: 133.3333333333vh !important;
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

/* Logo */
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

/* Step container */
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

/* Dotted center line */
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

/* Step rows */
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
    color: transparent !important;
    opacity: 1 !important;
    font-size: 0 !important;
    line-height: 1 !important;
    overflow: visible !important;
    z-index: 3 !important;
    cursor: default !important;
    background: transparent !important;
}

body > nav > div:nth-child(2) > div:nth-child(1) { top: 0 !important; }
body > nav > div:nth-child(2) > div:nth-child(2) { top: 70px !important; }
body > nav > div:nth-child(2) > div:nth-child(3) { top: 140px !important; }
body > nav > div:nth-child(2) > div:nth-child(4) { top: 210px !important; }
body > nav > div:nth-child(2) > div:nth-child(5) { top: 280px !important; }

/* Circle numbers */
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
    background: var(--ghost-ref-circle) !important;
    color: #ffffff !important;
}
body > nav > div:nth-child(2) > div:nth-child(2)::before { content: "2" !important; }
body > nav > div:nth-child(2) > div:nth-child(3)::before {
    content: "3" !important;
    background: #f8fafc !important;
    color: #111827 !important;
}
body > nav > div:nth-child(2) > div:nth-child(4)::before { content: "4" !important; }
body > nav > div:nth-child(2) > div:nth-child(5)::before { content: "5" !important; }

/* Labels */
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
    transform: none !important;
}

body > nav > div:nth-child(2) > div:nth-child(1)::after { content: "Heading" !important; }
body > nav > div:nth-child(2) > div:nth-child(2)::after { content: "Work history" !important; }
body > nav > div:nth-child(2) > div:nth-child(3)::after { content: "Education" !important; font-weight: 850 !important; }
body > nav > div:nth-child(2) > div:nth-child(4)::after { content: "Skills" !important; }
body > nav > div:nth-child(2) > div:nth-child(5)::after { content: "Summary" !important; }

/* Step 6 */
body > nav > div:nth-child(2)::after {
    content: "6" !important;
    position: absolute !important;
    left: 0 !important;
    top: 350px !important;
}

/* Finalize text */
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

/* Resume completeness inside blue bar */
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
    background: linear-gradient(90deg, var(--ghost-ref-green) 0%, var(--ghost-ref-green) 45%, #ffffff 45%, #ffffff 100%) !important;
}

body > nav > div:nth-child(3)::before,
body > nav > div:last-child::before {
    content: "45%" !important;
    position: absolute !important;
    left: 228px !important;
    top: 34px !important;
    color: #ffffff !important;
    font-size: 18px !important;
    line-height: 1 !important;
    font-weight: 900 !important;
}

/* Footer links inside blue bar */
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


/* GHOST FOOTER LINK LEFT ALIGN FIX - all links start from same x-position */
body > .absolute.bottom-0 > div:first-child > * {
    margin-left: 0 !important;
    margin-right: 0 !important;
}
body > .absolute.bottom-0 > div:first-child a {
    display: block !important;
    width: max-content !important;
    text-align: left !important;
    margin-left: 0 !important;
    padding-left: 0 !important;
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


/* GHOST EXACT CONTACT PAGE SIZE MATCH - Education sidebar only */
body > nav > div:nth-child(3) .text-xs,
body > nav > div:last-child .text-xs {
    font-size: 22px !important;
}

body > nav > div:nth-child(3)::before,
body > nav > div:last-child::before {
    font-size: 18px !important;
}

body > .absolute.bottom-0 a {
    font-size: 17px !important;
}
</style>



<!-- GHOST FINAL EDUCATION CENTER AREA MATCH CONTACT PAGE - SIZE ONLY, OLD LOGIC UNCHANGED -->
<style id="ghost-education-center-contact-exact-size-final">
    /* Center/right split same as contact page: form side wider, preview side compact */
    body > .flex.flex-grow > div:first-child {
        width: 64% !important;
        max-width: 64% !important;
        flex: 0 0 64% !important;
        padding: 88px 54px 340px 48px !important;
    }

    .builder-right-preview-panel {
        width: 36% !important;
        max-width: 36% !important;
        flex: 0 0 36% !important;
        padding: 122px 24px 74px 18px !important;
        background: #ffffff !important;
        border-left: 0 !important;
        overflow: hidden !important;
        justify-content: flex-start !important;
        align-items: center !important;
    }

    /* Education labels/fields reduced to contact page size */
    #contactForm {
        max-width: 930px !important;
        width: 100% !important;
        gap: 24px !important;
    }

    #contactForm > .flex {
        gap: 24px !important;
        align-items: start !important;
    }

    #contactForm .form-label,
    .form-label {
        font-size: 14px !important;
        line-height: 1.12 !important;
        font-weight: 650 !important;
        margin-bottom: 8px !important;
        letter-spacing: 0 !important;
        color: #0f172a !important;
        white-space: nowrap !important;
    }

    #contactForm .input-field,
    #contactForm select.input-field,
    .input-field,
    select.input-field {
        height: 62px !important;
        min-height: 62px !important;
        padding: 0 20px !important;
        font-size: 20px !important;
        font-weight: 500 !important;
        border-radius: 8px !important;
        border: 1.6px solid #cbd5e1 !important;
        background: #f8fbff !important;
        color: #0f172a !important;
        box-shadow: none !important;
    }

    #contactForm .input-field::placeholder,
    .input-field::placeholder {
        font-size: 20px !important;
        color: #94a3b8 !important;
        font-weight: 500 !important;
    }

    #inp_month,
    #inp_year,
    #contactForm #inp_month,
    #contactForm #inp_year {
        height: 62px !important;
        min-height: 62px !important;
        font-size: 20px !important;
        padding: 0 20px !important;
    }

    #contactForm .flex.gap-2 {
        gap: 18px !important;
    }

    /* Resume live preview reduced like contact page */
    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
        width: min(100%, 430px) !important;
        height: 470px !important;
        min-height: 470px !important;
        max-height: 470px !important;
        padding: 0 !important;
        margin-top: 0 !important;
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
        overflow: hidden !important;
        padding: 0 !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
        background: transparent !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
    .core-cv-scrollbox .core-cv-live,
    .core-cv-live {
        width: 335px !important;
        height: 470px !important;
        min-height: 470px !important;
        max-height: 470px !important;
        max-width: 96% !important;
        padding: 25px 30px !important;
        margin: 0 auto !important;
        transform: none !important;
        border-radius: 9px !important;
        box-shadow: 0 20px 48px rgba(15, 23, 42, .14) !important;
        background: #ffffff !important;
        overflow: hidden !important;
        flex: 0 0 auto !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-editor-html,
    .core-cv-live .core-cv-editor-html {
        max-height: 68px !important;
        overflow: hidden !important;
    }

    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        max-width: 350px !important;
        width: 100% !important;
        gap: 14px !important;
        margin-top: 34px !important;
        padding: 0 !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    #btnPreview,
    #btnNextFooter,
    #btnNext {
        height: 52px !important;
        font-size: 13px !important;
        padding: 0 24px !important;
        border-radius: 999px !important;
        white-space: nowrap !important;
    }

    #btnPreview { min-width: 132px !important; }
    #btnNextFooter,
    #btnNext { min-width: 178px !important; }

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

        .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
        .core-cv-scrollbox .core-cv-live,
        .core-cv-live {
            width: 318px !important;
            height: 448px !important;
            min-height: 448px !important;
            max-height: 448px !important;
        }

        .builder-right-preview-panel .preview-pane-container.real-template-mode,
        .builder-right-preview-panel .ghost-corecv-stage {
            height: 448px !important;
            min-height: 448px !important;
            max-height: 448px !important;
        }
    }
</style>



<!-- GHOST FINAL: EDUCATION RIGHT PREVIEW + BUTTONS LOWER LIKE CONTACT PAGE - ONLY THIS AREA -->
<style id="ghost-education-right-preview-lower-like-contact-final">
    /* Only move/resize the right-side resume template and buttons. Form/sidebar/logic untouched. */
    .builder-right-preview-panel {
        padding: 0 20px 30px !important;
        background: #ffffff !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 0 !important;
    }

    .builder-right-preview-panel::before,
    .builder-right-preview-panel::after {
        display: none !important;
        content: none !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
        order: 1 !important;
        width: min(100%, 405px) !important;
        height: 600px !important;
        min-height: 600px !important;
        max-height: 600px !important;
        margin-top: 115px !important;
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

    .core-cv-scrollbox {
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
        background: transparent !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
    .core-cv-scrollbox .core-cv-live,
    .core-cv-live {
        width: 394px !important;
        height: 598px !important;
        min-height: 598px !important;
        max-height: 598px !important;
        max-width: 100% !important;
        padding: 31px 36px !important;
        margin: 0 auto !important;
        transform: none !important;
        border-radius: 7px !important;
        box-shadow: 0 18px 40px rgba(15,23,42,.10) !important;
        background: #ffffff !important;
        overflow: hidden !important;
        flex: 0 0 auto !important;
    }

    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        order: 2 !important;
        position: relative !important;
        z-index: 9999 !important;
        width: min(100%, 360px) !important;
        max-width: 360px !important;
        margin-top: 58px !important;
        padding: 0 !important;
        gap: 16px !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    #btnPreview,
    #btnNextFooter,
    #btnNext {
        height: 54px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        text-transform: uppercase !important;
        letter-spacing: .06em !important;
        font-size: 13px !important;
        font-weight: 950 !important;
        line-height: 1 !important;
        padding: 0 24px !important;
    }

    #btnPreview {
        min-width: 142px !important;
        border: 2px solid #0f172a !important;
        background: #ffffff !important;
        color: #0f172a !important;
    }

    #btnNextFooter,
    #btnNext {
        min-width: 190px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }

    @media (max-height: 760px) {
        .builder-right-preview-panel .preview-pane-container.real-template-mode,
        .builder-right-preview-panel .ghost-corecv-stage {
            margin-top: 88px !important;
            height: 560px !important;
            min-height: 560px !important;
            max-height: 560px !important;
        }

        .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
        .core-cv-scrollbox .core-cv-live,
        .core-cv-live {
            width: 370px !important;
            height: 558px !important;
            min-height: 558px !important;
            max-height: 558px !important;
        }

        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            margin-top: 34px !important;
        }
    }
</style>



<!-- GHOST FINAL: RIGHT PREVIEW TOP CONTACT-LIKE + EDUCATION LOGIC UNCHANGED -->
<style id="ghost-education-contact-top-preview-final-fix">
    /* Sirf right-side resume template + buttons. Education form/sidebar/JS/backend logic untouched. */
    .builder-right-preview-panel {
        background: #ffffff !important;
        border-left: 0 !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: flex-start !important;
        padding: 0 20px 30px !important;
        gap: 0 !important;
    }

    .builder-right-preview-panel::before,
    .builder-right-preview-panel::after {
        display: none !important;
        content: none !important;
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
        order: 1 !important;
        width: min(100%, 405px) !important;
        height: 598px !important;
        min-height: 598px !important;
        max-height: 598px !important;
        margin-top: 112px !important;
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

    .core-cv-scrollbox {
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
        background: transparent !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    .core-cv-scrollbox::-webkit-scrollbar,
    .builder-right-preview-panel::-webkit-scrollbar,
    .builder-right-preview-panel .ghost-corecv-stage::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
    .core-cv-scrollbox .core-cv-live,
    .core-cv-live {
        width: 394px !important;
        height: 598px !important;
        min-height: 598px !important;
        max-height: 598px !important;
        max-width: 100% !important;
        padding: 52px 36px 31px !important;
        margin: 0 auto !important;
        transform: none !important;
        border-radius: 7px !important;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .10) !important;
        background: #ffffff !important;
        overflow: hidden !important;
        flex: 0 0 auto !important;
    }

    /* Contact page jaisa top: resume direct name/contact se start ho, extra top sentence/line na aye */
    .builder-right-preview-panel .core-cv-top-line,
    .builder-right-preview-panel .core-cv-header-line {
        display: none !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    .builder-right-preview-panel .core-cv-name {
        margin-top: 0 !important;
        margin-bottom: 6px !important;
    }

    .builder-right-preview-panel .core-cv-contact {
        margin-bottom: 12px !important;
        padding-bottom: 9px !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-editor-html,
    .core-cv-live .core-cv-editor-html {
        max-height: 74px !important;
        overflow: hidden !important;
    }

    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        order: 2 !important;
        position: relative !important;
        z-index: 9999 !important;
        width: min(100%, 360px) !important;
        max-width: 360px !important;
        margin-top: 60px !important;
        padding: 0 !important;
        gap: 16px !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-shrink: 0 !important;
    }

    #btnPreview,
    #btnNextFooter,
    #btnNext {
        height: 54px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        text-transform: uppercase !important;
        letter-spacing: .06em !important;
        font-size: 13px !important;
        font-weight: 950 !important;
        line-height: 1 !important;
        padding: 0 24px !important;
        box-shadow: none !important;
    }

    #btnPreview {
        min-width: 142px !important;
        border: 2px solid #0f172a !important;
        background: #ffffff !important;
        color: #0f172a !important;
    }

    #btnNextFooter,
    #btnNext {
        min-width: 190px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
    }

    @media (max-height: 760px) {
        .builder-right-preview-panel .preview-pane-container.real-template-mode,
        .builder-right-preview-panel .ghost-corecv-stage {
            margin-top: 88px !important;
            height: 558px !important;
            min-height: 558px !important;
            max-height: 558px !important;
        }

        .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
        .core-cv-scrollbox .core-cv-live,
        .core-cv-live {
            width: 370px !important;
            height: 558px !important;
            min-height: 558px !important;
            max-height: 558px !important;
            padding-top: 46px !important;
        }

        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            margin-top: 34px !important;
        }
    }
</style>


<!-- GHOST UPDATE: EDUCATION completed steps tick + bright white completed connector line -->
<style id="ghost-education-completed-tick-line-final">
    /* Keep original dotted line, but paint completed path bright white from Heading -> Work history -> Education */
    body > nav > div:nth-child(2)::before {
        background:
            linear-gradient(
                to bottom,
                #ffffff 0px,
                #ffffff 146px,
                transparent 146px,
                transparent 100%
            ),
            repeating-linear-gradient(
                to bottom,
                rgba(255,255,255,.22) 0px,
                rgba(255,255,255,.22) 9px,
                transparent 9px,
                transparent 17px
            ) !important;
        box-shadow: 0 0 8px rgba(255,255,255,.28) !important;
    }

    /* Previous completed pages become tick circles */
    body > nav > div:nth-child(2) > div:nth-child(1)::before,
    body > nav > div:nth-child(2) > div:nth-child(2)::before {
        content: "✓" !important;
        background: #ffffff !important;
        color: #111827 !important;
        font-size: 23px !important;
        font-weight: 950 !important;
        border-color: rgba(226,232,240,.78) !important;
        z-index: 4 !important;
    }

    /* Current page Education stays active white circle with number 3 */
    body > nav > div:nth-child(2) > div:nth-child(3)::before {
        content: "3" !important;
        background: #ffffff !important;
        color: #111827 !important;
        font-size: 22px !important;
        font-weight: 950 !important;
        z-index: 4 !important;
    }

    body > nav > div:nth-child(2) > div:nth-child(3)::after {
        color: #ffffff !important;
        font-weight: 950 !important;
    }
</style>



<!-- GHOST FINAL FIX: Education required field red border + popup logic only -->
<style id="ghost-education-required-red-border-final">
    /* Same Work History style red border for required empty fields */
    .ghost-required-red-border,
    input.ghost-required-red-border,
    select.ghost-required-red-border,
    textarea.ghost-required-red-border,
    .input-field.ghost-required-red-border,
    .form-input.ghost-required-red-border {
        border: 2px solid #ef1f2d !important;
        box-shadow: none !important;
        outline: none !important;
        background: #ffffff !important;
    }

    .ghost-required-red-border:focus,
    input.ghost-required-red-border:focus,
    select.ghost-required-red-border:focus,
    textarea.ghost-required-red-border:focus,
    .input-field.ghost-required-red-border:focus,
    .form-input.ghost-required-red-border:focus {
        border: 2px solid #ef1f2d !important;
        box-shadow: 0 0 0 3px rgba(239, 31, 45, 0.10) !important;
    }

    .ghost-field-error-text {
        display: block !important;
        margin-top: 8px !important;
        color: #dc2626 !important;
        font-size: 15px !important;
        line-height: 1.2 !important;
        font-weight: 850 !important;
        letter-spacing: .01em !important;
    }

    #ghostEducationRequiredPopup {
        position: fixed !important;
        top: 24px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        z-index: 9999999 !important;
        width: min(550px, calc(100vw - 48px)) !important;
        background: #fee2e2 !important;
        border: 1px solid #fecaca !important;
        color: #991b1b !important;
        border-radius: 10px !important;
        padding: 20px 26px !important;
        font-size: 19px !important;
        line-height: 1.25 !important;
        font-weight: 950 !important;
        letter-spacing: .02em !important;
        box-shadow: 0 20px 55px rgba(15, 23, 42, .14) !important;
        display: none !important;
        pointer-events: none !important;
    }

    #ghostEducationRequiredPopup.ghost-show-required-popup {
        display: block !important;
        animation: ghostRequiredPopupFade .18s ease-out !important;
    }

    @keyframes ghostRequiredPopupFade {
        from { opacity: 0; transform: translateX(-50%) translateY(-6px); }
        to { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
</style>

<script id="ghost-education-required-popup-red-border-script">
(function () {
    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    ready(function () {
        var nextBtn = document.getElementById('btnNextFooter') || document.getElementById('btnNext');
        var requiredFields = [
            {
                id: 'inp_school',
                message: 'Institution is required.'
            }
        ];

        function getOrCreatePopup() {
            var popup = document.getElementById('ghostEducationRequiredPopup');
            if (!popup) {
                popup = document.createElement('div');
                popup.id = 'ghostEducationRequiredPopup';
                popup.innerHTML = 'Please fill all required fields before moving to<br>Experience.';
                document.body.appendChild(popup);
            }
            return popup;
        }

        function showRequiredPopup() {
            var popup = getOrCreatePopup();
            popup.classList.add('ghost-show-required-popup');
            clearTimeout(window.__ghostEducationRequiredPopupTimer);
            window.__ghostEducationRequiredPopupTimer = setTimeout(function () {
                popup.classList.remove('ghost-show-required-popup');
            }, 3200);
        }

        function ensureErrorText(input) {
            if (!input) return null;
            var errorId = input.id + '_ghost_error';
            var existing = document.getElementById(errorId);
            if (existing) return existing;
            var small = document.createElement('small');
            small.id = errorId;
            small.className = 'ghost-field-error-text';
            input.insertAdjacentElement('afterend', small);
            return small;
        }

        function setFieldError(field, show) {
            var input = document.getElementById(field.id);
            if (!input) return;
            var errorText = ensureErrorText(input);
            if (show) {
                input.classList.add('ghost-required-red-border');
                if (errorText) errorText.textContent = field.message;
            } else {
                input.classList.remove('ghost-required-red-border');
                if (errorText) errorText.textContent = '';
            }
        }

        function validateEducationRequiredFields() {
            var firstInvalid = null;
            requiredFields.forEach(function (field) {
                var input = document.getElementById(field.id);
                var isEmpty = !input || !String(input.value || '').trim();
                setFieldError(field, isEmpty);
                if (isEmpty && !firstInvalid) firstInvalid = input;
            });
            if (firstInvalid) {
                showRequiredPopup();
                try { firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' }); } catch (e) {}
                setTimeout(function () { try { firstInvalid.focus(); } catch (e) {} }, 180);
                return false;
            }
            return true;
        }

        requiredFields.forEach(function (field) {
            var input = document.getElementById(field.id);
            if (!input) return;
            ['input', 'change', 'blur'].forEach(function (eventName) {
                input.addEventListener(eventName, function () {
                    if (String(input.value || '').trim()) {
                        setFieldError(field, false);
                    }
                });
            });
        });

        if (nextBtn) {
            nextBtn.addEventListener('click', function (e) {
                if (!validateEducationRequiredFields()) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
            }, true);
        }
    });
})();
</script>


<!-- GHOST FINAL PATCH: Education template location same as Contact + required red border/popup position -->
<style id="ghost-education-contact-location-required-final-patch">
    /* Right template area: Contact page jaisi location/size. Old form/backend logic untouched. */
    .builder-right-preview-panel {
        width: 38% !important;
        max-width: 38% !important;
        flex: 0 0 38% !important;
        background: radial-gradient(circle at 50% 36%, rgba(255,255,255,.96), rgba(248,250,252,.88) 42%, rgba(226,232,240,.78) 100%) !important;
        border-left: 1px solid #e5e7eb !important;
        padding: 28px 38px 86px !important;
        justify-content: center !important;
        align-items: center !important;
        overflow: hidden !important;
        position: relative !important;
        gap: 18px !important;
    }

    .builder-right-preview-panel::before {
        content: "" !important;
        position: absolute !important;
        inset: 26px 30px 120px !important;
        border-radius: 22px !important;
        background: rgba(255,255,255,.46) !important;
        border: 1px solid rgba(226,232,240,.9) !important;
        box-shadow: 0 18px 50px rgba(15,23,42,.06) !important;
        pointer-events: none !important;
        display: block !important;
    }

    .builder-right-preview-panel::after {
        display: none !important;
        content: none !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
        position: relative !important;
        z-index: 2 !important;
        order: 1 !important;
        width: min(100%, 660px) !important;
        height: min(640px, calc(100vh - 226px)) !important;
        min-height: 475px !important;
        max-height: 640px !important;
        margin-top: 0 !important;
        padding: 20px !important;
        background: transparent !important;
        border: 0 !important;
        border-radius: 20px !important;
        box-shadow: none !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
    }

    .core-cv-scrollbox {
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: flex-start !important;
        justify-content: center !important;
        background: transparent !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    .core-cv-scrollbox::-webkit-scrollbar,
    .builder-right-preview-panel::-webkit-scrollbar,
    .builder-right-preview-panel .ghost-corecv-stage::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
    .core-cv-scrollbox .core-cv-live,
    .core-cv-live {
        width: 430px !important;
        height: 602px !important;
        min-height: 602px !important;
        max-height: 602px !important;
        max-width: 96% !important;
        padding: 52px 36px 31px !important;
        margin: 0 auto !important;
        transform: none !important;
        border-radius: 8px !important;
        box-shadow: 0 28px 68px rgba(15,23,42,.17) !important;
        background: #ffffff !important;
        overflow: hidden !important;
        flex: 0 0 auto !important;
    }

    .builder-right-preview-panel .core-cv-top-line,
    .builder-right-preview-panel .core-cv-header-line {
        display: none !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    .builder-right-preview-panel .core-cv-name {
        margin-top: 0 !important;
        margin-bottom: 6px !important;
    }

    .builder-right-preview-panel .core-cv-contact {
        margin-bottom: 12px !important;
        padding-bottom: 9px !important;
    }

    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        order: 2 !important;
        position: relative !important;
        z-index: 4 !important;
        max-width: 440px !important;
        width: 100% !important;
        gap: 16px !important;
        padding: 0 !important;
        margin-top: 18px !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-shrink: 0 !important;
    }

    #btnPreview,
    #btnNextFooter,
    #btnNext {
        height: 54px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        white-space: nowrap !important;
        text-transform: uppercase !important;
        letter-spacing: .08em !important;
        font-size: 13px !important;
        font-weight: 950 !important;
        line-height: 1 !important;
        padding: 0 28px !important;
        box-shadow: none !important;
    }

    #btnPreview {
        min-width: 140px !important;
        border: 2px solid #0f172a !important;
        background: #ffffff !important;
        color: #0f172a !important;
    }

    #btnNextFooter,
    #btnNext {
        min-width: 190px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
        box-shadow: 0 16px 32px rgba(236,72,153,.22) !important;
    }

    /* Required field: red border exactly like Contact/Work History, forced over old !important CSS. */
    body #contactForm #inp_school.ghost-required-red-border,
    body #contactForm #inp_school.education-field-error,
    body #contactForm input.input-field.ghost-required-red-border,
    body #contactForm input.input-field.education-field-error {
        border: 2px solid #ef4444 !important;
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 1px rgba(239, 68, 68, .18) !important;
        background: #ffffff !important;
        outline: none !important;
    }

    body #contactForm #inp_school.ghost-required-red-border:focus,
    body #contactForm #inp_school.education-field-error:focus {
        border: 2px solid #ef4444 !important;
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, .12) !important;
        outline: none !important;
    }

    #contactForm .ghost-field-error-text,
    #contactForm .education-field-error-text {
        display: block !important;
        min-height: 18px !important;
        margin-top: 8px !important;
        color: #dc2626 !important;
        font-size: 14px !important;
        line-height: 1.2 !important;
        font-weight: 900 !important;
        letter-spacing: .01em !important;
    }

    /* Popup location: Contact page wali top location, main content area ke center mein. */
    #ghostEducationRequiredPopup {
        position: fixed !important;
        top: 28px !important;
        left: calc(360px + ((100vw - 360px) / 2)) !important;
        transform: translateX(-50%) translateY(-130%) !important;
        z-index: 9999999 !important;
        width: min(584px, calc(100vw - 420px)) !important;
        max-width: 584px !important;
        background: #fee2e2 !important;
        border: 1px solid #fecaca !important;
        color: #991b1b !important;
        border-radius: 10px !important;
        padding: 18px 24px !important;
        font-size: 17px !important;
        line-height: 1.35 !important;
        font-weight: 950 !important;
        letter-spacing: .02em !important;
        box-shadow: 0 18px 45px rgba(15,23,42,.18) !important;
        display: block !important;
        opacity: 0 !important;
        pointer-events: none !important;
        text-align: left !important;
        transition: all .24s ease !important;
        animation: none !important;
    }

    #ghostEducationRequiredPopup.ghost-show-required-popup {
        display: block !important;
        opacity: 1 !important;
        transform: translateX(-50%) translateY(0) !important;
        animation: none !important;
    }

    @media (max-width: 1280px) {
        .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
        .core-cv-scrollbox .core-cv-live,
        .core-cv-live {
            width: 385px !important;
            height: 548px !important;
            min-height: 548px !important;
            max-height: 548px !important;
        }
    }

    @media (max-width: 1024px) {
        #ghostEducationRequiredPopup {
            left: 50% !important;
            width: min(520px, calc(100vw - 32px)) !important;
        }
    }
</style>

<script id="ghost-education-required-red-border-document-capture-final">
(function () {
    function ready(fn) {
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", fn);
        } else {
            fn();
        }
    }

    function getPopup() {
        var popup = document.getElementById("ghostEducationRequiredPopup");
        if (!popup) {
            popup = document.createElement("div");
            popup.id = "ghostEducationRequiredPopup";
            document.body.appendChild(popup);
        }
        popup.innerHTML = "Please fill all required fields before moving to<br>Experience.";
        return popup;
    }

    function showPopup() {
        var popup = getPopup();
        popup.classList.add("ghost-show-required-popup");
        clearTimeout(window.__ghostEducationRequiredPopupTimerFinal);
        window.__ghostEducationRequiredPopupTimerFinal = setTimeout(function () {
            popup.classList.remove("ghost-show-required-popup");
        }, 3600);
    }

    function getErrorEl(input) {
        if (!input) return null;
        var id = input.id + "_ghost_error";
        var errorEl = document.getElementById(id);
        if (!errorEl) {
            errorEl = document.createElement("small");
            errorEl.id = id;
            errorEl.className = "ghost-field-error-text education-field-error-text";
            input.insertAdjacentElement("afterend", errorEl);
        }
        return errorEl;
    }

    function setSchoolError(show) {
        var input = document.getElementById("inp_school");
        if (!input) return false;

        var errorEl = getErrorEl(input);

        if (show) {
            input.classList.add("ghost-required-red-border", "education-field-error");
            input.style.setProperty("border", "2px solid #ef4444", "important");
            input.style.setProperty("border-color", "#ef4444", "important");
            input.style.setProperty("box-shadow", "0 0 0 1px rgba(239, 68, 68, .18)", "important");
            input.style.setProperty("background", "#ffffff", "important");
            if (errorEl) errorEl.textContent = "Institution is required.";
            return true;
        }

        input.classList.remove("ghost-required-red-border", "education-field-error");
        input.style.removeProperty("border");
        input.style.removeProperty("border-color");
        input.style.removeProperty("box-shadow");
        input.style.removeProperty("background");
        if (errorEl) errorEl.textContent = "";
        return false;
    }

    function validateEducationRequired(showRequiredPopup) {
        var input = document.getElementById("inp_school");
        var empty = !input || !String(input.value || "").trim();

        setSchoolError(empty);

        if (empty) {
            if (showRequiredPopup) showPopup();
            try { input && input.focus({ preventScroll: true }); } catch (e) {}
            return false;
        }

        return true;
    }

    window.validateEducationRequiredGhostFinal = validateEducationRequired;

    ready(function () {
        var input = document.getElementById("inp_school");
        if (input && input.dataset.ghostEducationFinalClear !== "1") {
            input.dataset.ghostEducationFinalClear = "1";
            ["input", "change", "blur"].forEach(function (eventName) {
                input.addEventListener(eventName, function () {
                    if (String(input.value || "").trim()) {
                        setSchoolError(false);
                    }
                });
            });
        }

        /* Capture on document runs before old button handlers, so old navigation cannot hide the red border. */
        document.addEventListener("click", function (e) {
            var target = e.target;
            var nextBtn = target && target.closest ? target.closest("#btnNextFooter, #btnNext") : null;
            if (!nextBtn) return;

            if (!validateEducationRequired(true)) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            }
        }, true);
    });
})();
</script>


<!-- GHOST FINAL SMALL PATCH: white live preview background + lower/smaller template + popup slightly right -->
<style id="ghost-education-white-preview-lower-popup-right-final">
    /* Right side background: pure white, no grey/radial card */
    .builder-right-preview-panel {
        background: #ffffff !important;
        border-left: 0 !important;
        padding: 82px 34px 96px 30px !important;
        justify-content: flex-start !important;
        align-items: center !important;
        gap: 0 !important;
        overflow: hidden !important;
    }

    .builder-right-preview-panel::before,
    .builder-right-preview-panel::after {
        display: none !important;
        content: none !important;
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
    }

    /* Live preview box: white, smaller, and a little lower like Contact page */
    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
        width: min(100%, 560px) !important;
        height: 560px !important;
        min-height: 560px !important;
        max-height: 560px !important;
        margin-top: 48px !important;
        padding: 0 !important;
        background: #ffffff !important;
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        overflow: hidden !important;
        align-items: flex-start !important;
        justify-content: center !important;
    }

    .core-cv-scrollbox {
        background: #ffffff !important;
        padding: 0 !important;
        overflow: hidden !important;
        align-items: flex-start !important;
        justify-content: center !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
    .core-cv-scrollbox .core-cv-live,
    .builder-right-preview-panel .core-cv-live {
        width: 390px !important;
        height: 545px !important;
        min-height: 545px !important;
        max-height: 545px !important;
        max-width: 94% !important;
        margin: 0 auto !important;
        padding: 46px 34px 28px !important;
        background: #ffffff !important;
        border-radius: 6px !important;
        box-shadow: none !important;
        overflow: hidden !important;
        transform: none !important;
        flex: 0 0 auto !important;
    }

    /* Buttons stay under preview, slightly lower but same style */
    .builder-right-preview-panel > .w-full.max-w-sm.flex {
        margin-top: 34px !important;
        max-width: 420px !important;
        gap: 16px !important;
    }

    /* Red popup: thora right side shift, same old red border logic untouched */
    #ghostEducationRequiredPopup {
        left: calc(360px + ((100vw - 360px) / 2) + 90px) !important;
        top: 28px !important;
    }

    @media (max-width: 1280px) {
        .builder-right-preview-panel .preview-pane-container.real-template-mode,
        .builder-right-preview-panel .ghost-corecv-stage {
            height: 530px !important;
            min-height: 530px !important;
            max-height: 530px !important;
            margin-top: 42px !important;
        }

        .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
        .core-cv-scrollbox .core-cv-live,
        .builder-right-preview-panel .core-cv-live {
            width: 365px !important;
            height: 510px !important;
            min-height: 510px !important;
            max-height: 510px !important;
            padding: 42px 32px 26px !important;
        }
    }

    @media (max-width: 1024px) {
        #ghostEducationRequiredPopup {
            left: 50% !important;
        }
    }
</style>



<!-- GHOST FINAL TINY PATCH: show live preview corners + move popup more right -->
<style id="ghost-education-preview-corners-popup-more-right-final">
    /* Keep right side pure white, only make template page edges/corners visible */
    .builder-right-preview-panel,
    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage,
    .core-cv-scrollbox {
        background: #ffffff !important;
    }

    .builder-right-preview-panel .preview-pane-container.real-template-mode,
    .builder-right-preview-panel .ghost-corecv-stage {
        overflow: visible !important;
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }

    .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
    .core-cv-scrollbox .core-cv-live,
    .builder-right-preview-panel .core-cv-live {
        width: 382px !important;
        height: 530px !important;
        min-height: 530px !important;
        max-height: 530px !important;
        max-width: 92% !important;
        margin: 6px auto 0 !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 8px !important;
        box-shadow: 0 16px 34px rgba(15, 23, 42, .10) !important;
        background: #ffffff !important;
        overflow: hidden !important;
    }

    /* Popup thora aur right side */
    #ghostEducationRequiredPopup {
        left: calc(360px + ((100vw - 360px) / 2) + 170px) !important;
        top: 28px !important;
    }

    @media (max-width: 1280px) {
        .builder-right-preview-panel .ghost-corecv-stage .core-cv-live,
        .core-cv-scrollbox .core-cv-live,
        .builder-right-preview-panel .core-cv-live {
            width: 358px !important;
            height: 498px !important;
            min-height: 498px !important;
            max-height: 498px !important;
            margin-top: 6px !important;
        }

        #ghostEducationRequiredPopup {
            left: calc(360px + ((100vw - 360px) / 2) + 145px) !important;
        }
    }

    @media (max-width: 1024px) {
        #ghostEducationRequiredPopup {
            left: 50% !important;
        }
    }
</style>



<!-- GHOST FINAL PATCH: popup exact center with live preview template -->
<style id="ghost-popup-exact-template-center-final">
    /* Fallback: put popup on the right preview side, not on the left form side */
    #ghostEducationRequiredPopup {
        top: 28px !important;
        left: calc(81.5vw + 90px) !important;
        transform: translateX(-50%) translateY(-130%) !important;
    }

    #ghostEducationRequiredPopup.ghost-show-required-popup {
        transform: translateX(-50%) translateY(0) !important;
    }

    @media (max-width: 1024px) {
        #ghostEducationRequiredPopup {
            left: 50% !important;
        }
    }
</style>

<script id="ghost-popup-exact-template-center-script-final">
(function () {
    function findLivePreviewTarget() {
        return document.querySelector('.builder-right-preview-panel .core-cv-live') ||
               document.querySelector('.builder-right-preview-panel .modern-live-preview') ||
               document.querySelector('.builder-right-preview-panel .ghost-corecv-stage') ||
               document.querySelector('.builder-right-preview-panel .preview-pane-container');
    }

    function centerPopupOnTemplate() {
        var popup = document.getElementById('ghostEducationRequiredPopup');
        var target = findLivePreviewTarget();
        if (!popup || !target) return;

        var rect = target.getBoundingClientRect();
        if (!rect || !rect.width) return;

        /* GHOST FINAL OFFSET: user asked same amount more right than current position */
        var centerX = rect.left + (rect.width / 2) + 90;
        popup.style.setProperty('left', centerX + 'px', 'important');
        popup.style.setProperty('top', '28px', 'important');
        popup.style.setProperty('right', 'auto', 'important');
    }

    function runCentering() {
        centerPopupOnTemplate();
        setTimeout(centerPopupOnTemplate, 30);
        setTimeout(centerPopupOnTemplate, 120);
    }

    document.addEventListener('click', function (e) {
        var target = e.target;
        var nextBtn = target && target.closest ? target.closest('#btnNextFooter, #btnNext') : null;
        if (nextBtn) runCentering();
    }, true);

    window.addEventListener('resize', runCentering);
    window.addEventListener('load', runCentering);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runCentering);
    } else {
        runCentering();
    }
})();
</script>


<!-- GHOST FINAL EDUCATION BUTTON CLEAN SPACE PATCH - OLD LOGIC UNCHANGED -->
<style id="ghost-final-education-clean-button-space-patch">
    /* Only visual CSS: button size/location + clean white space below. JS/logic untouched. */

    /* Right side ko bottom se clean white breathing space do */
    .builder-right-preview-panel {
        padding-bottom: 190px !important;
        overflow: visible !important;
        background: #ffffff !important;
    }

    /* Existing button area same rakha, sirf thora right + bottom clean gap */
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

    /* Button ke neeche white clean space force karo */
    .builder-right-preview-panel > .w-full.max-w-sm.flex::after {
        content: "" !important;
        position: absolute !important;
        left: -40px !important;
        right: -40px !important;
        top: 100% !important;
        height: 130px !important;
        background: #ffffff !important;
        z-index: -1 !important;
        pointer-events: none !important;
    }

    /* Text readable, buttons not small */
    #btnPreview,
    #btnNextFooter,
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
        box-shadow: none !important;
    }

    #btnNextFooter,
    #btnNext {
        width: 230px !important;
        min-width: 230px !important;
        padding: 0 24px !important;
        background: #ec4899 !important;
        color: #ffffff !important;
        box-shadow: 0 16px 32px rgba(236,72,153,.22) !important;
    }

    @media (max-width: 1280px) {
        .builder-right-preview-panel > .w-full.max-w-sm.flex {
            width: 470px !important;
            max-width: 470px !important;
            transform: translateX(8px) translateY(-8px) !important;
            gap: 16px !important;
            margin-bottom: 120px !important;
        }

        #btnPreview {
            width: 145px !important;
            min-width: 145px !important;
        }

        #btnNextFooter,
        #btnNext {
            width: 220px !important;
            min-width: 220px !important;
        }
    }
</style>


<!-- GHOST UPDATE: Education Description + Ready Examples behavior -->
<script id="ghost-education-description-ready-examples-logic">
(function () {
    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    function getVal(id, fallback) {
        const el = document.getElementById(id);
        const v = el ? String(el.value || '').trim() : '';
        return v || fallback;
    }

    function updateEducationDescriptionHeading() {
        const title = document.getElementById('ghostEduDescDynamicTitle');
        const sub = document.getElementById('ghostEduDescDynamicSub');
        if (!title || !sub) return;

        const school = getVal('inp_school', 'Your school');
        const field = getVal('inp_field', getVal('inp_degree', 'Education'));
        const location = getVal('inp_location', '');
        title.textContent = location ? (school + ' | ' + location) : school;
        sub.textContent = 'Add education description, achievements, coursework, projects and awards.';
    }

    function installEducationDescriptionUI() {
        const section = document.getElementById('coursework-main-section');
        const editor = document.getElementById('editor');
        if (!section || !editor) return;

        const headerText = document.querySelector('.main-toggle-header span:first-child');
        if (headerText) {
            headerText.innerHTML = '<i class="fa-solid fa-chevron-down mr-2.5 arrow-icon" id="main-arrow"></i> Add education description';
        }

        const headerLink = document.querySelector('.main-toggle-header span:last-child');
        if (headerLink) {
            headerLink.textContent = 'Ready to use examples';
        }

        const readyTitle = Array.from(section.querySelectorAll('p')).find(p => /Ready to use examples/i.test(p.textContent || ''));
        if (readyTitle) readyTitle.textContent = 'Ready to use examples';

        const editorCol = editor.closest('.lg\\:col-span-6') || editor.closest('.mt-2') || editor.parentElement;
        if (editorCol && !document.getElementById('ghostEduDescDynamicTitle')) {
            const heading = document.createElement('div');
            heading.className = 'ghost-edu-desc-heading';
            heading.innerHTML = '<h2 class="ghost-edu-desc-title" id="ghostEduDescDynamicTitle">Your school</h2><p class="ghost-edu-desc-subtitle" id="ghostEduDescDynamicSub">Add education description, achievements, coursework, projects and awards.</p>';
            editorCol.insertBefore(heading, editorCol.firstChild);
        }

        const oldLabel = editorCol ? Array.from(editorCol.querySelectorAll('p')).find(p => /Education Description/i.test(p.textContent || '')) : null;
        if (oldLabel) oldLabel.textContent = 'Education Description';

        const editorContainer = editor.closest('.editor-container');
        if (editorContainer && !document.getElementById('ghostEduSmartPill')) {
            const pill = document.createElement('div');
            pill.id = 'ghostEduSmartPill';
            pill.className = 'ghost-edu-smart-pill';
            pill.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i> Smart suggestions (will be applied soon)';
            editorContainer.insertBefore(pill, editor);
        }

        ['inp_school', 'inp_location', 'inp_degree', 'inp_field'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el && !el.dataset.ghostEduHeadingBound) {
                el.dataset.ghostEduHeadingBound = 'true';
                el.addEventListener('input', updateEducationDescriptionHeading);
                el.addEventListener('change', updateEducationDescriptionHeading);
            }
        });

        updateEducationDescriptionHeading();
    }

    ready(installEducationDescriptionUI);

    /* Safer example insertion: every Ready-to-use example goes inside Education Description editor */
    const oldAddBullet = window.addBullet;
    window.addBullet = function (text) {
        const editor = document.getElementById('editor');
        if (!editor) {
            if (typeof oldAddBullet === 'function') return oldAddBullet(text);
            return;
        }

        editor.focus();

        let ul = editor.querySelector('ul');
        if (!ul) {
            editor.innerHTML = '<ul></ul>';
            ul = editor.querySelector('ul');
        }

        const li = document.createElement('li');
        li.textContent = text;
        ul.appendChild(li);

        const toolList = document.getElementById('tool-list');
        if (toolList) toolList.classList.add('active-tool');

        if (typeof window.updatePreview === 'function') {
            window.updatePreview();
        }
    };
})();
</script>



<!-- GHOST CLEAN FIX: duplicate WorkHistory missing-note patches removed.
     Old final sidebar logic below is kept; this only stops the big duplicate note and initial shake. -->

<!-- GHOST FINAL v3: Fetch selected Work History into Education live preview + strict missing-note cleanup -->
<style id="ghost-education-selected-work-preview-v3">
    .core-cv-selected-work-html ul,
    .core-cv-selected-work-html ol {
        margin: 2px 0 0 !important;
        padding-left: 11px !important;
    }
    .core-cv-selected-work-html li {
        margin-bottom: 1.5px !important;
    }
    .core-cv-selected-work-html a {
        color: #2563eb !important;
        text-decoration: underline !important;
        font-weight: 800 !important;
    }
</style>


<!-- GHOST REMOVED: old single-work preview script was overwriting checked-work transfer logic -->




<!-- GHOST FINAL FIX: Education Go Back must return to Work History, not Contact -->
<script id="ghost-education-goback-workhistory-final">
(function () {
    function fixEducationBack() {
        document.querySelectorAll('a').forEach(function (a) {
            if (String(a.textContent || '').trim().toLowerCase().includes('go back')) {
                a.setAttribute('href', '/builder/work-history');
            }
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fixEducationBack);
    else fixEducationBack();
    window.addEventListener('load', fixEducationBack);
})();
</script>



<!-- GHOST FINAL MICRO PATCH: Education back to Work History + missing Work History sidebar + selected works in preview -->
<style id="ghost-education-missing-workhistory-selected-works-final">
    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(2)::before {
        content: "2" !important;
        background: #0f172a !important;
        color: #ffffff !important;
        font-size: 22px !important;
        font-weight: 950 !important;
        border-color: rgba(226,232,240,.48) !important;
        box-shadow: 0 0 0 4px rgba(15,23,42,.20) !important;
    }
    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(2)::after {
        content: "Work history" !important;
        font-weight: 500 !important;
        color: #ffffff !important;
        transform: translateY(-9px) !important;
    }
    .ghost-work-missing-sidebar-note {
        position: absolute !important;
        left: 54px !important;
        top: 24px !important;
        color: #ffffff !important;
        font-size: 15px !important;
        line-height: 1.1 !important;
        font-weight: 650 !important;
        letter-spacing: 0 !important;
        white-space: nowrap !important;
        z-index: 10 !important;
        pointer-events: none !important;
    }
    body.ghost-workhistory-missing-info > nav > div:nth-child(2)::before {
        background: repeating-linear-gradient(
            to bottom,
            rgba(255,255,255,.22) 0px,
            rgba(255,255,255,.22) 9px,
            transparent 9px,
            transparent 17px
        ) !important;
        box-shadow: none !important;
    }
    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(1)::before {
        content: "✓" !important;
        background: #ffffff !important;
        color: #111827 !important;
    }
    body.ghost-workhistory-missing-info .core-cv-selected-work-row {
        display: grid !important;
        grid-template-columns: 1.15fr .85fr .8fr !important;
        gap: 8px !important;
        margin-bottom: 4px !important;
        align-items: start !important;
    }
    body.ghost-workhistory-missing-info .core-cv-selected-work-row,
    .core-cv-selected-work-row {
        font-size: 6.65px !important;
        line-height: 1.43 !important;
        color: #374151 !important;
    }
    .core-cv-selected-work-extra { margin-top: 2px !important; max-height: 30px !important; overflow: hidden !important; }
    .core-cv-selected-work-extra ul, .core-cv-selected-work-extra ol { margin: 0 !important; padding-left: 10px !important; }
    .core-cv-selected-work-extra a { color: #2563eb !important; text-decoration: underline !important; font-weight: 700 !important; }
</style>

<script id="ghost-education-missing-workhistory-sidebar-only-script-final">
(function () {
    function resumeId(){ return localStorage.getItem('current_resume_id') || 'no_resume'; }
    function scopedKey(base){ return base + '_' + resumeId(); }
    function workMissing(){
        return localStorage.getItem(scopedKey('resume_work_history_missing_info')) === 'true' ||
               localStorage.getItem('resume_work_history_missing_info') === 'true';
    }
    function fixBackLink(){
        document.querySelectorAll('a').forEach(function(a){
            var text = String(a.textContent || '').trim().toLowerCase();
            var href = String(a.getAttribute('href') || '');
            if (text.includes('go back') || href === '/builder/contact') {
                a.setAttribute('href', '/builder/work-history');
            }
        });
    }
    function applyMissingSidebar(){
        document.body.classList.toggle('ghost-workhistory-missing-info', workMissing());
        var step2 = document.querySelector('body > nav > div:nth-child(2) > div:nth-child(2)');
        if (!step2) return;
        var note = step2.querySelector('.ghost-work-missing-sidebar-note');
        if (workMissing()) {
            if (!note) {
                note = document.createElement('span');
                note.className = 'ghost-work-missing-sidebar-note';
                note.textContent = 'Add missing information';
                step2.appendChild(note);
            }
        } else if (note) {
            note.remove();
        }
    }
    function boot(){ fixBackLink(); applyMissingSidebar(); }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot); else boot();
    window.addEventListener('load', boot);
    setInterval(boot, 350);
})();
</script>



<!-- GHOST FINAL PATCH: Fetch only checked Work History items into Education Career History preview -->
<style id="ghost-education-selected-work-career-history-final-only">
    .core-cv-selected-work-row-final {
        display: grid !important;
        grid-template-columns: 1.15fr .85fr .8fr !important;
        gap: 8px !important;
        margin-bottom: 4px !important;
        align-items: start !important;
        font-size: 6.65px !important;
        line-height: 1.43 !important;
        color: #374151 !important;
    }
    .core-cv-selected-work-extra-final {
        margin: 1px 0 5px !important;
        max-height: 32px !important;
        overflow: hidden !important;
        font-size: 6.65px !important;
        line-height: 1.43 !important;
        color: #374151 !important;
    }
    .core-cv-selected-work-extra-final ul,
    .core-cv-selected-work-extra-final ol {
        margin: 0 !important;
        padding-left: 10px !important;
    }
    .core-cv-selected-work-extra-final li {
        margin-bottom: 1px !important;
    }
    .core-cv-selected-work-extra-final a {
        color: #2563eb !important;
        text-decoration: underline !important;
        font-weight: 700 !important;
    }
    .core-cv-career-null-final {
        font-size: 6.65px !important;
        line-height: 1.43 !important;
        color: #374151 !important;
        font-weight: 900 !important;
        letter-spacing: .02em !important;
        text-transform: uppercase !important;
        padding-top: 2px !important;
    }
    .core-cv-live.modal-size .core-cv-selected-work-row-final,
    .core-cv-live.modal-size .core-cv-selected-work-extra-final,
    .core-cv-live.modal-size .core-cv-career-null-final {
        font-size: 8.2px !important;
    }
</style>

<script id="ghost-education-fetch-checked-workhistory-final-only">
(function () {
    function rid() {
        return localStorage.getItem('current_resume_id') || 'no_resume';
    }

    function scopedKey(base) {
        return base + '_' + rid();
    }

    function readJson(key, fallback) {
        try {
            var raw = localStorage.getItem(key);
            if (!raw) return fallback;
            return JSON.parse(raw);
        } catch (e) {
            return fallback;
        }
    }

    function esc(value) {
        return String(value || '').replace(/[&<>"']/g, function (m) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[m];
        });
    }

    function plain(html) {
        var d = document.createElement('div');
        d.innerHTML = html || '';
        return (d.textContent || d.innerText || '').trim();
    }

    function hasWorkData(work) {
        return !!(work && (
            String(work.job_title || '').trim() ||
            String(work.employer || '').trim() ||
            String(work.city || '').trim() ||
            String(work.country || '').trim() ||
            String(work.start_month || '').trim() ||
            String(work.start_year || '').trim() ||
            String(work.end_month || '').trim() ||
            String(work.end_year || '').trim() ||
            work.is_remote ||
            work.currently_working ||
            plain(work.extra_info)
        ));
    }

    function normalizeSelectedWorks(value) {
        if (!value) return [];
        if (Array.isArray(value)) return value.filter(hasWorkData);
        if (typeof value === 'object') return hasWorkData(value) ? [value] : [];
        return [];
    }

    function signature(work) {
        return [
            work.id || work._id || '',
            work.job_title || '',
            work.employer || '',
            work.city || '',
            work.country || '',
            work.is_remote ? '1' : '0',
            work.start_month || '',
            work.start_year || '',
            work.end_month || '',
            work.end_year || '',
            work.currently_working ? '1' : '0',
            plain(work.extra_info || '')
        ].map(function (v) { return String(v).trim().toLowerCase(); }).join('|');
    }

    function getCheckedWorksFromStorage() {
        var selected = [];
        [
            scopedKey('resume_work_history_selected_for_education'),
            'resume_work_history_selected_for_education_' + rid(),
            'resume_work_history_selected_for_education'
        ].forEach(function (key) {
            normalizeSelectedWorks(readJson(key, [])).forEach(function (work) {
                selected.push(work);
            });
        });

        var seen = {};
        return selected.filter(function (work) {
            var sig = signature(work);
            if (seen[sig]) return false;
            seen[sig] = true;
            return true;
        });
    }

    function dateText(work) {
        var start = [work.start_month, work.start_year].filter(Boolean).join(' ');
        var end = work.currently_working ? 'Current' : [work.end_month, work.end_year].filter(Boolean).join(' ');
        return [start, end].filter(Boolean).join(' - ') || 'Employment dates';
    }

    function locationText(work) {
        var city = String(work.city || '').trim();
        var country = String(work.country || '').trim();
        var location = [city, country].filter(Boolean).join(', ');
        if (location && work.is_remote) return location + ' (Remote)';
        if (location) return location;
        if (work.is_remote) return 'Remote';
        return 'Location';
    }

    function workRowHtml(work) {
        var title = esc(work.job_title || 'Job title');
        var employer = esc(work.employer || 'Employer');
        var location = esc(locationText(work));
        var dates = esc(dateText(work));
        var extra = plain(work.extra_info)
            ? '<div class="core-cv-selected-work-extra-final core-cv-editor-html">' + work.extra_info + '</div>'
            : '';

        return '' +
            '<div class="core-cv-selected-work-row-final core-cv-text">' +
                '<div><span class="core-cv-bold">' + title + '</span><br>' + employer + '</div>' +
                '<div>' + location + '</div>' +
                '<div class="core-cv-muted">' + dates + '</div>' +
            '</div>' + extra;
    }

    function findCareerSection(cv) {
        var titles = Array.from(cv.querySelectorAll('.core-cv-title'));
        var title = titles.find(function (el) {
            return String(el.textContent || '').trim().toLowerCase() === 'career history';
        });
        return title ? title.closest('.core-cv-section') : null;
    }

    function expectedCareerHtml(works) {
        if (!works.length) {
            return '<div class="core-cv-title">Career History</div><div class="core-cv-career-null-final">NILL</div>';
        }
        return '<div class="core-cv-title">Career History</div>' + works.map(workRowHtml).join('');
    }

    function renderCareerHistory() {
        var works = getCheckedWorksFromStorage();
        var html = expectedCareerHtml(works);

        document.querySelectorAll('.core-cv-live').forEach(function (cv) {
            var section = findCareerSection(cv);
            if (!section) return;

            /* Always compare actual HTML, because old scripts can rewrite the section after this patch runs. */
            if (section.innerHTML !== html) {
                section.innerHTML = html;
            }

            section.setAttribute('data-ghost-career-source', 'checked-work-history-only');
            section.setAttribute('data-ghost-checked-work-count', String(works.length));
        });
    }

    function fixBackLink() {
        document.querySelectorAll('a').forEach(function (a) {
            var text = String(a.textContent || '').trim().toLowerCase();
            var href = String(a.getAttribute('href') || '');
            if (text.includes('go back') || href === '/builder/contact') {
                a.setAttribute('href', '/builder/work-history');
            }
        });
    }

    function boot() {
        fixBackLink();
        renderCareerHistory();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.addEventListener('load', boot);

    var observer = new MutationObserver(function () {
        window.requestAnimationFrame(boot);
    });

    function startObserver() {
        if (document.body && !document.body.dataset.ghostCheckedWorkObserver) {
            document.body.dataset.ghostCheckedWorkObserver = '1';
            observer.observe(document.body, { childList: true, subtree: true });
        }
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', startObserver);
    else startObserver();

    setInterval(boot, 120);
})();
</script>



<!-- GHOST FINAL ADD: Education intro + highest level flow before main Education form -->
<style id="ghost-education-intro-level-flow-final">
    .ghost-edu-flow-overlay {
        position: fixed !important;
        left: 0 !important;
        top: 0 !important;
        width: 133.3333333333vw !important;
        height: 133.3333333333vh !important;
        min-width: 1680px !important;
        min-height: 995px !important;
        background: #ffffff !important;
        z-index: 9999998 !important;
        display: none !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        color: #071022 !important;
        font-family: Arial, Helvetica, sans-serif !important;
    }

    .ghost-edu-flow-overlay.show {
        display: block !important;
    }

    .ghost-edu-flow-screen {
        display: none !important;
        min-height: 100% !important;
        position: relative !important;
        background: #ffffff !important;
    }

    .ghost-edu-flow-screen.active {
        display: block !important;
    }

    .ghost-edu-flow-back {
        position: absolute !important;
        top: 78px !important;
        left: 48px !important;
        color: #2563eb !important;
        font-size: 22px !important;
        line-height: 1 !important;
        font-weight: 950 !important;
        text-decoration: underline !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        cursor: pointer !important;
        border: 0 !important;
        background: transparent !important;
        padding: 0 !important;
        z-index: 10 !important;
    }

    .ghost-edu-flow-back:hover {
        color: #ec4899 !important;
    }

    .ghost-edu-intro-layout {
        width: 100% !important;
        min-height: 100% !important;
        display: grid !important;
        grid-template-columns: minmax(0, 1fr) 600px !important;
        gap: 80px !important;
        padding: 150px 58px 90px 58px !important;
        align-items: start !important;
    }

    .ghost-edu-intro-copy {
        padding-top: 8px !important;
        max-width: 820px !important;
    }

    .ghost-edu-intro-copy h1 {
        margin: 0 0 42px !important;
        color: #071022 !important;
        font-size: 52px !important;
        line-height: 1.18 !important;
        font-weight: 950 !important;
        letter-spacing: .045em !important;
    }

    .ghost-edu-intro-copy h2 {
        margin: 0 0 14px !important;
        color: #071022 !important;
        font-size: 26px !important;
        line-height: 1.18 !important;
        font-weight: 950 !important;
    }

    .ghost-edu-intro-copy p {
        margin: 0 !important;
        color: #071022 !important;
        font-size: 30px !important;
        line-height: 1.36 !important;
        font-weight: 400 !important;
        letter-spacing: .065em !important;
        max-width: 930px !important;
    }

    .ghost-edu-preview-side {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: flex-start !important;
        padding-top: 0 !important;
    }

    .ghost-edu-template-frame {
        position: relative !important;
        width: 430px !important;
        height: 610px !important;
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        overflow: hidden !important;
        box-shadow: none !important;
    }

    .ghost-edu-template-frame img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
        display: none !important;
        background: #ffffff !important;
        position: relative !important;
        z-index: 2 !important;
    }

    .ghost-edu-template-frame.has-image img {
        display: block !important;
    }

    .ghost-edu-template-frame.has-image .ghost-edu-mock-template {
        display: none !important;
    }

    .ghost-edu-education-highlight {
        position: absolute !important;
        left: 3% !important;
        right: 3% !important;
        top: 68.5% !important;
        height: 23% !important;
        border: 3px solid #34d399 !important;
        background: rgba(52, 211, 153, .14) !important;
        z-index: 5 !important;
        pointer-events: none !important;
    }

    .ghost-edu-mock-template {
        width: 100% !important;
        height: 100% !important;
        background: #ffffff !important;
        color: #475569 !important;
        font-family: Georgia, 'Times New Roman', serif !important;
        overflow: hidden !important;
    }

    .ghost-edu-mock-topbar { height: 14px !important; background: #7aa33a !important; }
    .ghost-edu-mock-inner { padding: 40px 55px !important; }
    .ghost-edu-mock-name { text-align:center !important; color:#7aa33a !important; font-size:20px !important; font-weight:950 !important; letter-spacing:.10em !important; }
    .ghost-edu-mock-role { text-align:center !important; font-size:9px !important; color:#64748b !important; margin-top:4px !important; }
    .ghost-edu-mock-contact { display:flex !important; justify-content:space-between !important; color:#7aa33a !important; font-size:8px !important; margin-top:18px !important; }
    .ghost-edu-mock-line { height:1px !important; background:#7aa33a !important; margin:10px 0 12px !important; }
    .ghost-edu-mock-title { text-align:center !important; color:#7aa33a !important; font-size:12px !important; font-weight:950 !important; margin:12px 0 8px !important; }
    .ghost-edu-mock-small { font-size:8px !important; line-height:1.45 !important; color:#475569 !important; }
    .ghost-edu-mock-skills { display:grid !important; grid-template-columns:1fr 1fr !important; gap:7px 22px !important; margin-top:8px !important; }
    .ghost-edu-mock-work { margin:16px 0 14px !important; }
    .ghost-edu-mock-row { display:flex !important; justify-content:space-between !important; gap:12px !important; margin:8px 0 !important; }
    .ghost-edu-mock-job { font-size:9px !important; font-weight:950 !important; color:#64748b !important; }
    .ghost-edu-mock-date { font-size:8px !important; color:#64748b !important; font-style:italic !important; text-align:right !important; }
    .ghost-edu-mock-education { margin:12px -44px 0 !important; padding:10px 44px 16px !important; border:3px solid #34d399 !important; background:rgba(52,211,153,.13) !important; }

    .ghost-edu-intro-actions {
        margin-top: 72px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 28px !important;
        width: 100% !important;
    }

    .ghost-edu-flow-preview-btn,
    .ghost-edu-flow-next-btn {
        height: 74px !important;
        border-radius: 999px !important;
        font-size: 27px !important;
        font-weight: 950 !important;
        cursor: pointer !important;
        transition: all .18s ease !important;
    }

    .ghost-edu-flow-preview-btn {
        width: 258px !important;
        border: 3px solid #15168f !important;
        background: #ffffff !important;
        color: #15168f !important;
    }

    .ghost-edu-flow-next-btn {
        width: 258px !important;
        border: 0 !important;
        background: #c4007a !important;
        color: #ffffff !important;
    }

    .ghost-edu-flow-preview-btn:hover,
    .ghost-edu-flow-next-btn:hover {
        transform: translateY(-1px) !important;
    }

    .ghost-edu-level-wrap {
        width: min(100%, 1500px) !important;
        margin: 0 auto !important;
        padding: 110px 58px 78px !important;
        text-align: center !important;
    }

    .ghost-edu-level-title {
        margin: 0 0 24px !important;
        color: #071022 !important;
        font-size: 52px !important;
        line-height: 1.12 !important;
        font-weight: 950 !important;
        letter-spacing: .055em !important;
    }

    .ghost-edu-level-subtitle {
        margin: 0 0 84px !important;
        color: #071022 !important;
        font-size: 31px !important;
        line-height: 1.22 !important;
        font-weight: 400 !important;
        letter-spacing: .055em !important;
    }

    .ghost-edu-level-grid {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 50px 48px !important;
        align-items: center !important;
    }

    .ghost-edu-level-option {
        height: 154px !important;
        border: 1.7px solid #94a3b8 !important;
        border-radius: 13px !important;
        background: #ffffff !important;
        color: #071022 !important;
        font-size: 30px !important;
        line-height: 1.18 !important;
        font-weight: 400 !important;
        letter-spacing: .015em !important;
        cursor: pointer !important;
        transition: all .18s ease !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 0 18px !important;
    }

    .ghost-edu-level-option:hover,
    .ghost-edu-level-option.selected {
        border-color: #15168f !important;
        box-shadow: 0 0 0 3px rgba(21, 22, 143, .10) !important;
        transform: translateY(-1px) !important;
    }

    .ghost-edu-level-option.selected {
        background: #15168f !important;
        color: #ffffff !important;
        font-weight: 900 !important;
    }

    .ghost-edu-level-option.center-last {
        grid-column: 2 / 3 !important;
    }

    .ghost-edu-prefer-link {
        margin-top: 50px !important;
        border: 0 !important;
        background: transparent !important;
        color: #0969da !important;
        font-size: 22px !important;
        line-height: 1 !important;
        font-weight: 950 !important;
        text-decoration: underline !important;
        cursor: pointer !important;
    }

    @media (max-width: 1200px) {
        .ghost-edu-intro-layout {
            grid-template-columns: 1fr !important;
            gap: 40px !important;
        }

        .ghost-edu-level-grid {
            grid-template-columns: 1fr 1fr !important;
        }

        .ghost-edu-level-option.center-last {
            grid-column: 1 / -1 !important;
            width: 50% !important;
            margin: 0 auto !important;
        }
    }

    @media (max-width: 900px) {
        .ghost-edu-flow-overlay {
            width: 100vw !important;
            height: 100vh !important;
            min-width: 0 !important;
            min-height: 0 !important;
        }

        .ghost-edu-intro-layout,
        .ghost-edu-level-wrap {
            padding: 92px 24px 60px !important;
        }

        .ghost-edu-intro-copy h1,
        .ghost-edu-level-title {
            font-size: 34px !important;
            letter-spacing: 0 !important;
        }

        .ghost-edu-intro-copy p,
        .ghost-edu-level-subtitle {
            font-size: 20px !important;
            letter-spacing: 0 !important;
        }

        .ghost-edu-level-grid {
            grid-template-columns: 1fr !important;
            gap: 18px !important;
        }

        .ghost-edu-level-option,
        .ghost-edu-level-option.center-last {
            width: 100% !important;
            grid-column: auto !important;
            height: 92px !important;
            font-size: 22px !important;
        }

        .ghost-edu-template-frame {
            width: 300px !important;
            height: 420px !important;
        }
    }
</style>

<div id="ghostEducationFlow" class="ghost-edu-flow-overlay" aria-hidden="true">
    <section class="ghost-edu-flow-screen active" id="ghostEduIntroScreen">
        <button type="button" class="ghost-edu-flow-back" id="ghostEduIntroBack">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Go Back</span>
        </button>

        <div class="ghost-edu-intro-layout">
            <div class="ghost-edu-intro-copy">
                <h1>Great, let's work on your<br>Education</h1>
                <h2>Here's what you need to know:</h2>
                <p>Employers quickly scan the education section.<br>We'll take care of the formatting so it's easy to find.</p>
            </div>

            <aside class="ghost-edu-preview-side">
                <div class="ghost-edu-template-frame" id="ghostEduTemplateFrame">
                    <img id="ghostEduTemplateImage" alt="Selected resume template education preview">
                    <div class="ghost-edu-mock-template">
                        <div class="ghost-edu-mock-topbar"></div>
                        <div class="ghost-edu-mock-inner">
                            <div class="ghost-edu-mock-name" id="ghostEduMockName">ARMAGHAN SHAHZAD</div>
                            <div class="ghost-edu-mock-role">Taxila, Pakistan</div>
                            <div class="ghost-edu-mock-contact"><span>+9230-5356621</span><span>23-se-051@student.hitec.edu.pk</span></div>
                            <div class="ghost-edu-mock-line"></div>
                            <p class="ghost-edu-mock-small">Use this section to give recruiters a quick glimpse of your professional profile.</p>
                            <div class="ghost-edu-mock-title">Skills</div>
                            <div class="ghost-edu-mock-line"></div>
                            <div class="ghost-edu-mock-skills">
                                <span class="ghost-edu-mock-small">Skill 1</span><span class="ghost-edu-mock-small">Skill 2</span>
                                <span class="ghost-edu-mock-small">Skill 3</span><span class="ghost-edu-mock-small">Skill 4</span>
                            </div>
                            <div class="ghost-edu-mock-work">
                                <div class="ghost-edu-mock-title">Work History</div>
                                <div class="ghost-edu-mock-row"><div><div class="ghost-edu-mock-job">Sales Manager</div><div class="ghost-edu-mock-small">Employer</div></div><div class="ghost-edu-mock-date">January 2025 - Current</div></div>
                                <ul class="ghost-edu-mock-small"><li>Developed market strategies and improved customer satisfaction.</li><li>Collaborated with team members on daily operations.</li></ul>
                            </div>
                            <div class="ghost-edu-mock-education">
                                <div class="ghost-edu-mock-title">Education</div>
                                <p class="ghost-edu-mock-small">Include your degree, school name and the year you graduated. If you don't have a degree, list coursework or training that's relevant to the job you're applying for.</p>
                                <div class="ghost-edu-mock-row"><div><div class="ghost-edu-mock-job">School Name or City</div><div class="ghost-edu-mock-small">Degree in field of study</div></div><div class="ghost-edu-mock-date">Study dates</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="ghost-edu-education-highlight"></div>
                </div>

                <div class="ghost-edu-intro-actions">
                    <button type="button" class="ghost-edu-flow-preview-btn" id="ghostEduIntroPreview">Preview</button>
                    <button type="button" class="ghost-edu-flow-next-btn" id="ghostEduIntroNext">Next</button>
                </div>
            </aside>
        </div>
    </section>

    <section class="ghost-edu-flow-screen" id="ghostEduLevelScreen">
        <button type="button" class="ghost-edu-flow-back" id="ghostEduLevelBack">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Go Back</span>
        </button>

        <div class="ghost-edu-level-wrap">
            <h1 class="ghost-edu-level-title">What is your highest level of education?</h1>
            <p class="ghost-edu-level-subtitle">Choose the most recent or highest degree you have completed.</p>

            <div class="ghost-edu-level-grid">
                <button type="button" class="ghost-edu-level-option" data-degree="Technical or Vocational">Technical or Vocational</button>
                <button type="button" class="ghost-edu-level-option" data-degree="Related Courses">Related Courses</button>
                <button type="button" class="ghost-edu-level-option" data-degree="Certificates or diplomas">Certificates or diplomas</button>
                <button type="button" class="ghost-edu-level-option" data-degree="Associates">Associates</button>
                <button type="button" class="ghost-edu-level-option" data-degree="Bachelors">Bachelors</button>
                <button type="button" class="ghost-edu-level-option" data-degree="Masters or Specialized">Masters or Specialized</button>
                <button type="button" class="ghost-edu-level-option center-last" data-degree="Doctoral or J.D.">Doctoral or J.D.</button>
            </div>

            <button type="button" class="ghost-edu-prefer-link" id="ghostEduPreferNoAnswer">Prefer not to answer</button>
        </div>
    </section>
</div>

<script id="ghost-education-intro-level-flow-final-script">
(function () {
    function q(id) { return document.getElementById(id); }
    function rid() { return localStorage.getItem('current_resume_id') || 'no_resume'; }
    function flowDoneKey() { return 'resume_education_intro_flow_done_' + rid(); }
    function apiBase() { return 'https://resume-backend-54se.onrender.com'; }
    function tokenValue() { return localStorage.getItem('resume_token') || ''; }

    function clean(value) {
        return String(value || '').trim();
    }

    function getTemplateUrl(thumbnail) {
        if (!thumbnail) return '';
        var cleanPath = String(thumbnail).trim().replace(/\\/g, '/');
        if (!cleanPath) return '';
        if (cleanPath.startsWith('http://') || cleanPath.startsWith('https://')) return cleanPath;
        if (cleanPath.startsWith('/uploads/')) return apiBase() + cleanPath;
        if (cleanPath.startsWith('uploads/')) return apiBase() + '/' + cleanPath;
        return apiBase() + '/uploads/templates/' + cleanPath;
    }

    function getStoredTemplateKey() {
        return localStorage.getItem('selected_template') ||
               localStorage.getItem('selectedTemplate') ||
               localStorage.getItem('resume_template') ||
               localStorage.getItem('template_id') || '';
    }

    function templateMatches(template, key) {
        if (!template || !key) return false;
        return String(template.template_key) === String(key) ||
               String(template.id) === String(key) ||
               String(template._id) === String(key);
    }

    async function fetchJson(url, options) {
        try {
            var res = await fetch(url, options || {});
            return await res.json();
        } catch (e) {
            return null;
        }
    }

    async function applyEducationFlowSelectedTemplate() {
        var frame = q('ghostEduTemplateFrame');
        var img = q('ghostEduTemplateImage');
        if (!frame || !img) return;

        var templatesData = await fetchJson(apiBase() + '/api/templates/all');
        var templates = templatesData && templatesData.success && Array.isArray(templatesData.templates) ? templatesData.templates : [];
        var resumeData = await fetchJson(apiBase() + '/api/resumes/get/' + rid(), {
            headers: { 'Authorization': 'Bearer ' + tokenValue() }
        });
        var resume = resumeData && resumeData.success ? resumeData.resume : null;
        var storedKey = getStoredTemplateKey();
        var selected = null;

        if (storedKey) selected = templates.find(function (t) { return templateMatches(t, storedKey); });
        if (!selected && resume) {
            var resumeKey = resume.template_key || resume.template_id || resume.template || '';
            selected = templates.find(function (t) { return templateMatches(t, resumeKey); });
        }
        if (!selected && resume && (resume.template_thumbnail_url || resume.thumbnail_url)) {
            selected = { thumbnail_url: resume.template_thumbnail_url || resume.thumbnail_url };
        }
        if (!selected && templates.length) selected = templates[0];

        var url = getTemplateUrl(selected && (selected.thumbnail_url || selected.template_thumbnail_url));
        if (!url) {
            frame.classList.remove('has-image');
            return;
        }

        img.onload = function () { frame.classList.add('has-image'); };
        img.onerror = function () {
            frame.classList.remove('has-image');
            img.removeAttribute('src');
        };
        img.src = url;
    }

    function showOverlay(screenName) {
        var flow = q('ghostEducationFlow');
        if (!flow) return;
        flow.classList.add('show');
        flow.setAttribute('aria-hidden', 'false');
        q('ghostEduIntroScreen') && q('ghostEduIntroScreen').classList.toggle('active', screenName === 'intro');
        q('ghostEduLevelScreen') && q('ghostEduLevelScreen').classList.toggle('active', screenName === 'level');
        try { flow.scrollTo({ top: 0, behavior: 'auto' }); } catch (e) {}
    }

    function hideOverlay() {
        var flow = q('ghostEducationFlow');
        if (!flow) return;
        flow.classList.remove('show');
        flow.setAttribute('aria-hidden', 'true');
    }

    function optionToDegree(optionText) {
        var map = {
            'Technical or Vocational': 'Technical or Vocational',
            'Related Courses': 'Relevant Coursework',
            'Certificates or diplomas': 'Certificate',
            'Associates': 'Associate of Science',
            'Bachelors': 'Bachelor of Science',
            'Masters or Specialized': 'Master of Science',
            'Doctoral or J.D.': 'Ph.D.'
        };
        return map[optionText] || optionText || '';
    }

    function ensureDegreeOption(value) {
        var degree = q('inp_degree');
        if (!degree || !value) return;
        var exists = Array.from(degree.options || []).some(function (opt) {
            return clean(opt.value).toLowerCase() === clean(value).toLowerCase() || clean(opt.textContent).toLowerCase() === clean(value).toLowerCase();
        });
        if (!exists) {
            var option = document.createElement('option');
            option.value = value;
            option.textContent = value;
            degree.appendChild(option);
        }
    }

    function finishEducationFlow(selectedDegreeLabel) {
        var degreeValue = optionToDegree(selectedDegreeLabel);
        if (degreeValue) {
            ensureDegreeOption(degreeValue);
            var degree = q('inp_degree');
            if (degree) {
                degree.value = degreeValue;
                degree.dispatchEvent(new Event('input', { bubbles: true }));
                degree.dispatchEvent(new Event('change', { bubbles: true }));
            }
            localStorage.setItem('resume_education_selected_level_' + rid(), selectedDegreeLabel);
        }
        localStorage.setItem(flowDoneKey(), 'true');
        hideOverlay();
        if (typeof updatePreview === 'function') {
            try { updatePreview(); } catch (e) {}
        }
        if (typeof renderCoreCvEducationPreview === 'function') {
            try { renderCoreCvEducationPreview(); } catch (e) {}
        }
    }

    function bindEducationFlow() {
        var flow = q('ghostEducationFlow');
        if (!flow || flow.dataset.ghostEducationFlowReady === '1') return;
        flow.dataset.ghostEducationFlowReady = '1';

        var introBack = q('ghostEduIntroBack');
        var levelBack = q('ghostEduLevelBack');
        var introNext = q('ghostEduIntroNext');
        var introPreview = q('ghostEduIntroPreview');
        var prefer = q('ghostEduPreferNoAnswer');

        if (introBack) introBack.addEventListener('click', function () { window.location.href = '/builder/work-history'; });
        if (levelBack) levelBack.addEventListener('click', function () { showOverlay('intro'); });
        if (introNext) introNext.addEventListener('click', function () { showOverlay('level'); });
        if (introPreview) introPreview.addEventListener('click', function () {
            var previewBtn = q('btnPreview');
            if (previewBtn) previewBtn.click();
        });
        if (prefer) prefer.addEventListener('click', function () { finishEducationFlow(''); });

        document.querySelectorAll('.ghost-edu-level-option').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.ghost-edu-level-option').forEach(function (b) { b.classList.remove('selected'); });
                btn.classList.add('selected');
                finishEducationFlow(btn.dataset.degree || btn.textContent);
            });
        });
    }

    function fixEducationBackToWorkHistory() {
        document.querySelectorAll('a').forEach(function (a) {
            var text = clean(a.textContent).toLowerCase();
            var href = clean(a.getAttribute('href'));
            if (text.includes('go back') || href === '/builder/contact') {
                a.setAttribute('href', '/builder/work-history');
            }
        });
    }

    function shouldShowEducationFlow() {
        /* Fresh resume should see this first. Existing completed flow goes direct to the main education form. */
        return localStorage.getItem(flowDoneKey()) !== 'true';
    }

    function bootEducationFlow() {
        bindEducationFlow();
        fixEducationBackToWorkHistory();
        applyEducationFlowSelectedTemplate();
        if (shouldShowEducationFlow()) showOverlay('intro');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootEducationFlow);
    } else {
        bootEducationFlow();
    }
    window.addEventListener('load', bootEducationFlow);
})();
</script>



<!-- GHOST FINAL OVERRIDE: Education two-step intro flow inside WHITE AREA only. Old form/sidebar/backend logic untouched. -->
<style id="ghost-education-two-step-white-area-final-override">
    /* Cover only the white Education work area, never the blue left sidebar */
    #ghostEducationFlow.ghost-edu-flow-overlay {
        position: fixed !important;
        left: 360px !important;
        top: 0 !important;
        width: calc(133.3333333333vw - 360px) !important;
        height: 133.3333333333vh !important;
        min-width: 0 !important;
        min-height: 995px !important;
        background: #ffffff !important;
        z-index: 99998 !important;
        display: none !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        color: #071022 !important;
        font-family: Arial, Helvetica, sans-serif !important;
    }

    #ghostEducationFlow.ghost-edu-flow-overlay.show {
        display: block !important;
    }

    #ghostEducationFlow .ghost-edu-flow-screen {
        display: none !important;
        min-height: 100% !important;
        position: relative !important;
        background: #ffffff !important;
    }

    #ghostEducationFlow .ghost-edu-flow-screen.active {
        display: block !important;
    }

    #ghostEducationFlow .ghost-edu-flow-back {
        position: absolute !important;
        top: 90px !important;
        left: 48px !important;
        color: #2563eb !important;
        font-size: 20px !important;
        line-height: 1 !important;
        font-weight: 950 !important;
        text-decoration: underline !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        cursor: pointer !important;
        border: 0 !important;
        background: transparent !important;
        padding: 0 !important;
        z-index: 10 !important;
    }

    #ghostEducationFlow .ghost-edu-intro-layout {
        width: 100% !important;
        min-height: 100% !important;
        display: grid !important;
        grid-template-columns: minmax(620px, 1fr) 520px !important;
        gap: 90px !important;
        padding: 150px 58px 80px 48px !important;
        align-items: start !important;
    }

    #ghostEducationFlow .ghost-edu-intro-copy {
        padding-top: 0 !important;
        max-width: 860px !important;
    }

    #ghostEducationFlow .ghost-edu-intro-copy h1 {
        margin: 0 0 40px !important;
        color: #071022 !important;
        font-size: 50px !important;
        line-height: 1.28 !important;
        font-weight: 950 !important;
        letter-spacing: .055em !important;
    }

    #ghostEducationFlow .ghost-edu-intro-copy h2 {
        margin: 0 0 18px !important;
        color: #071022 !important;
        font-size: 26px !important;
        line-height: 1.18 !important;
        font-weight: 950 !important;
        letter-spacing: .02em !important;
    }

    #ghostEducationFlow .ghost-edu-intro-copy p {
        margin: 0 !important;
        color: #071022 !important;
        font-size: 29px !important;
        line-height: 1.35 !important;
        font-weight: 400 !important;
        letter-spacing: .065em !important;
        max-width: 930px !important;
    }

    #ghostEducationFlow .ghost-edu-preview-side {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: flex-start !important;
        padding-top: 0 !important;
    }

    #ghostEducationFlow .ghost-edu-template-frame {
        width: 410px !important;
        height: 590px !important;
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        overflow: hidden !important;
        box-shadow: none !important;
        position: relative !important;
    }

    #ghostEducationFlow .ghost-edu-education-highlight {
        position: absolute !important;
        left: 3% !important;
        right: 3% !important;
        top: 68.5% !important;
        height: 23% !important;
        border: 3px solid #34d399 !important;
        background: rgba(52, 211, 153, .14) !important;
        z-index: 5 !important;
        pointer-events: none !important;
    }

    #ghostEducationFlow .ghost-edu-intro-actions {
        margin-top: 68px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 26px !important;
        width: 100% !important;
    }

    #ghostEducationFlow .ghost-edu-flow-preview-btn,
    #ghostEducationFlow .ghost-edu-flow-next-btn {
        height: 68px !important;
        border-radius: 999px !important;
        font-size: 26px !important;
        font-weight: 950 !important;
        cursor: pointer !important;
        transition: all .18s ease !important;
    }

    #ghostEducationFlow .ghost-edu-flow-preview-btn {
        width: 245px !important;
        border: 3px solid #15168f !important;
        background: #ffffff !important;
        color: #15168f !important;
    }

    #ghostEducationFlow .ghost-edu-flow-next-btn {
        width: 245px !important;
        border: 0 !important;
        background: #c4007a !important;
        color: #ffffff !important;
    }

    #ghostEducationFlow .ghost-edu-level-wrap {
        width: min(100%, 1500px) !important;
        margin: 0 auto !important;
        padding: 95px 70px 78px !important;
        text-align: center !important;
    }

    #ghostEducationFlow .ghost-edu-level-title {
        margin: 0 0 26px !important;
        color: #071022 !important;
        font-size: 50px !important;
        line-height: 1.12 !important;
        font-weight: 950 !important;
        letter-spacing: .055em !important;
    }

    #ghostEducationFlow .ghost-edu-level-subtitle {
        margin: 0 0 84px !important;
        color: #071022 !important;
        font-size: 29px !important;
        line-height: 1.22 !important;
        font-weight: 400 !important;
        letter-spacing: .055em !important;
    }

    #ghostEducationFlow .ghost-edu-level-grid {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 50px 48px !important;
        align-items: center !important;
    }

    #ghostEducationFlow .ghost-edu-level-option {
        height: 154px !important;
        border: 1.7px solid #94a3b8 !important;
        border-radius: 13px !important;
        background: #ffffff !important;
        color: #071022 !important;
        font-size: 29px !important;
        line-height: 1.18 !important;
        font-weight: 400 !important;
        letter-spacing: .015em !important;
        cursor: pointer !important;
        transition: all .18s ease !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 0 18px !important;
    }

    #ghostEducationFlow .ghost-edu-level-option:hover,
    #ghostEducationFlow .ghost-edu-level-option.selected {
        border-color: #15168f !important;
        box-shadow: 0 0 0 3px rgba(21, 22, 143, .10) !important;
        transform: translateY(-1px) !important;
    }

    #ghostEducationFlow .ghost-edu-level-option.selected {
        background: #15168f !important;
        color: #ffffff !important;
        font-weight: 900 !important;
    }

    #ghostEducationFlow .ghost-edu-level-option.center-last {
        grid-column: 2 / 3 !important;
    }

    #ghostEducationFlow .ghost-edu-prefer-link {
        margin-top: 50px !important;
        border: 0 !important;
        background: transparent !important;
        color: #0969da !important;
        font-size: 22px !important;
        line-height: 1 !important;
        font-weight: 950 !important;
        text-decoration: underline !important;
        cursor: pointer !important;
    }

    /* Preview modal must open above this intro flow when Preview is clicked */
    #previewModal {
        z-index: 10000020 !important;
    }

    @media (max-width: 1024px) {
        #ghostEducationFlow.ghost-edu-flow-overlay {
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            min-width: 0 !important;
            min-height: 0 !important;
            z-index: 99998 !important;
        }
        #ghostEducationFlow .ghost-edu-intro-layout {
            grid-template-columns: 1fr !important;
            gap: 40px !important;
            padding: 92px 24px 60px !important;
        }
        #ghostEducationFlow .ghost-edu-level-grid {
            grid-template-columns: 1fr !important;
            gap: 18px !important;
        }
        #ghostEducationFlow .ghost-edu-level-option,
        #ghostEducationFlow .ghost-edu-level-option.center-last {
            width: 100% !important;
            grid-column: auto !important;
            height: 92px !important;
            font-size: 22px !important;
        }
    }
</style>

<script id="ghost-education-two-step-white-area-final-script">
(function () {
    function q(id) { return document.getElementById(id); }
    function clean(value) { return String(value || '').trim(); }
    function rid() { return localStorage.getItem('current_resume_id') || 'no_resume'; }
    function apiBase() { return 'https://resume-backend-54se.onrender.com'; }
    function tokenValue() { return localStorage.getItem('resume_token') || ''; }

    function showScreen(screenName) {
        var flow = q('ghostEducationFlow');
        if (!flow) return;
        flow.classList.add('show');
        flow.setAttribute('aria-hidden', 'false');
        var intro = q('ghostEduIntroScreen');
        var level = q('ghostEduLevelScreen');
        if (intro) intro.classList.toggle('active', screenName === 'intro');
        if (level) level.classList.toggle('active', screenName === 'level');
        try { flow.scrollTo({ top: 0, behavior: 'auto' }); } catch (e) {}
    }

    function hideFlow() {
        var flow = q('ghostEducationFlow');
        if (!flow) return;
        flow.classList.remove('show');
        flow.setAttribute('aria-hidden', 'true');
    }

    function optionToDegree(optionText) {
        var map = {
            'Technical or Vocational': 'Technical or Vocational',
            'Related Courses': 'Relevant Coursework',
            'Certificates or diplomas': 'Certificate',
            'Associates': 'Associate of Science',
            'Bachelors': 'Bachelor of Science',
            'Masters or Specialized': 'Master of Science',
            'Doctoral or J.D.': 'Ph.D.'
        };
        return map[clean(optionText)] || clean(optionText);
    }

    function ensureDegreeOption(value) {
        var degree = q('inp_degree');
        if (!degree || !value) return;
        var exists = Array.from(degree.options || []).some(function (opt) {
            return clean(opt.value).toLowerCase() === clean(value).toLowerCase() ||
                   clean(opt.textContent).toLowerCase() === clean(value).toLowerCase();
        });
        if (!exists) {
            var option = document.createElement('option');
            option.value = value;
            option.textContent = value;
            degree.appendChild(option);
        }
    }

    function openMainEducationForm(selectedLabel) {
        var degreeValue = optionToDegree(selectedLabel);
        if (degreeValue) {
            ensureDegreeOption(degreeValue);
            var degree = q('inp_degree');
            if (degree) {
                degree.value = degreeValue;
                degree.dispatchEvent(new Event('input', { bubbles: true }));
                degree.dispatchEvent(new Event('change', { bubbles: true }));
            }
            localStorage.setItem('resume_education_selected_level_' + rid(), clean(selectedLabel));
        }
        hideFlow();
        if (typeof updatePreview === 'function') { try { updatePreview(); } catch (e) {} }
        if (typeof renderCoreCvEducationPreview === 'function') { try { renderCoreCvEducationPreview(); } catch (e) {} }
    }

    function getTemplateUrl(thumbnail) {
        if (!thumbnail) return '';
        var path = String(thumbnail).trim().replace(/\\/g, '/');
        if (!path) return '';
        if (path.indexOf('http://') === 0 || path.indexOf('https://') === 0) return path;
        if (path.indexOf('/uploads/') === 0) return apiBase() + path;
        if (path.indexOf('uploads/') === 0) return apiBase() + '/' + path;
        return apiBase() + '/uploads/templates/' + path;
    }

    function templateKey() {
        return localStorage.getItem('selected_template') ||
               localStorage.getItem('selectedTemplate') ||
               localStorage.getItem('resume_template') ||
               localStorage.getItem('template_id') || '';
    }

    function templateMatches(t, key) {
        if (!t || !key) return false;
        return String(t.template_key) === String(key) || String(t.id) === String(key) || String(t._id) === String(key);
    }

    async function fetchJson(url, options) {
        try {
            var res = await fetch(url, options || {});
            return await res.json();
        } catch (e) {
            return null;
        }
    }

    async function applySelectedTemplateImage() {
        var frame = q('ghostEduTemplateFrame');
        var img = q('ghostEduTemplateImage');
        if (!frame || !img) return;

        var templatesData = await fetchJson(apiBase() + '/api/templates/all');
        var templates = templatesData && templatesData.success && Array.isArray(templatesData.templates) ? templatesData.templates : [];
        var resumeData = await fetchJson(apiBase() + '/api/resumes/get/' + rid(), {
            headers: { 'Authorization': 'Bearer ' + tokenValue() }
        });
        var resume = resumeData && resumeData.success ? resumeData.resume : null;
        var key = templateKey();
        var selected = null;

        if (key) selected = templates.find(function (t) { return templateMatches(t, key); });
        if (!selected && resume) {
            var resumeKey = resume.template_key || resume.template_id || resume.template || '';
            selected = templates.find(function (t) { return templateMatches(t, resumeKey); });
        }
        if (!selected && resume && (resume.template_thumbnail_url || resume.thumbnail_url)) {
            selected = { thumbnail_url: resume.template_thumbnail_url || resume.thumbnail_url };
        }
        if (!selected && templates.length) selected = templates[0];

        var url = getTemplateUrl(selected && (selected.thumbnail_url || selected.template_thumbnail_url));
        if (!url) { frame.classList.remove('has-image'); return; }

        img.onload = function () { frame.classList.add('has-image'); };
        img.onerror = function () { frame.classList.remove('has-image'); img.removeAttribute('src'); };
        img.src = url;
    }

    function fixBackLinks() {
        document.querySelectorAll('a').forEach(function (a) {
            var text = clean(a.textContent).toLowerCase();
            var href = clean(a.getAttribute('href'));
            if (text.indexOf('go back') !== -1 || href === '/builder/contact') {
                a.setAttribute('href', '/builder/work-history');
            }
        });
    }

    function bindFlow() {
        var flow = q('ghostEducationFlow');
        if (!flow || flow.dataset.ghostEducationTwoStepFixed === '1') return;
        flow.dataset.ghostEducationTwoStepFixed = '1';

        var introBack = q('ghostEduIntroBack');
        var levelBack = q('ghostEduLevelBack');
        var introNext = q('ghostEduIntroNext');
        var introPreview = q('ghostEduIntroPreview');
        var prefer = q('ghostEduPreferNoAnswer');

        if (introBack) introBack.onclick = function () { window.location.href = '/builder/work-history'; };
        if (levelBack) levelBack.onclick = function () { showScreen('intro'); };
        if (introNext) introNext.onclick = function () { showScreen('level'); };
        if (prefer) prefer.onclick = function () { openMainEducationForm(''); };
        if (introPreview) introPreview.onclick = function () {
            var previewBtn = q('btnPreview');
            if (previewBtn) previewBtn.click();
            setTimeout(function () {
                var modal = q('previewModal');
                if (modal) modal.style.setProperty('z-index', '10000020', 'important');
            }, 80);
        };

        document.querySelectorAll('.ghost-edu-level-option').forEach(function (btn) {
            btn.onclick = function () {
                document.querySelectorAll('.ghost-edu-level-option').forEach(function (b) { b.classList.remove('selected'); });
                btn.classList.add('selected');
                openMainEducationForm(btn.dataset.degree || btn.textContent);
            };
        });
    }

    function bootEducationTwoStepFlow() {
        /* Must show whenever user reaches Education page from Work History. Do not use old saved flow-done flag. */
        localStorage.removeItem('resume_education_intro_flow_done_' + rid());
        bindFlow();
        fixBackLinks();
        applySelectedTemplateImage();
        showScreen('intro');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootEducationTwoStepFlow);
    } else {
        bootEducationTwoStepFlow();
    }
    window.addEventListener('load', bootEducationTwoStepFlow);
})();
</script>

<!-- GHOST FINAL PATCH v2: smaller + scrollable intro screens, sidebar old missing-state restored -->
<style id="ghost-education-two-step-size-scroll-sidebar-final-v2">
    /* ===== Two education intro pages: only white area, smaller, scrollable ===== */
    #ghostEducationFlow.ghost-edu-flow-overlay {
        left: 360px !important;
        top: 0 !important;
        width: calc(133.3333333333vw - 360px) !important;
        height: 133.3333333333vh !important;
        max-height: 133.3333333333vh !important;
        min-width: 0 !important;
        min-height: 0 !important;
        background: #ffffff !important;
        z-index: 99998 !important;
        overflow-y: scroll !important;
        overflow-x: hidden !important;
        scrollbar-width: thin !important;
        scrollbar-color: #94a3b8 #ffffff !important;
    }

    #ghostEducationFlow.ghost-edu-flow-overlay::-webkit-scrollbar {
        width: 9px !important;
        display: block !important;
    }

    #ghostEducationFlow.ghost-edu-flow-overlay::-webkit-scrollbar-track {
        background: #ffffff !important;
    }

    #ghostEducationFlow.ghost-edu-flow-overlay::-webkit-scrollbar-thumb {
        background: #94a3b8 !important;
        border-radius: 999px !important;
        border: 2px solid #ffffff !important;
    }

    #ghostEducationFlow .ghost-edu-flow-screen {
        min-height: 1060px !important;
        padding-bottom: 70px !important;
    }

    #ghostEducationFlow .ghost-edu-flow-back {
        top: 76px !important;
        left: 48px !important;
        font-size: 18px !important;
        font-weight: 950 !important;
    }

    #ghostEducationFlow .ghost-edu-intro-layout {
        grid-template-columns: minmax(520px, 1fr) 470px !important;
        gap: 56px !important;
        padding: 135px 48px 80px 48px !important;
        align-items: start !important;
    }

    #ghostEducationFlow .ghost-edu-intro-copy {
        max-width: 740px !important;
        padding-top: 0 !important;
    }

    #ghostEducationFlow .ghost-edu-intro-copy h1 {
        font-size: 38px !important;
        line-height: 1.26 !important;
        letter-spacing: .050em !important;
        margin: 0 0 30px !important;
        font-weight: 950 !important;
    }

    #ghostEducationFlow .ghost-edu-intro-copy h2 {
        font-size: 21px !important;
        line-height: 1.2 !important;
        margin: 0 0 13px !important;
        font-weight: 950 !important;
    }

    #ghostEducationFlow .ghost-edu-intro-copy p {
        font-size: 23px !important;
        line-height: 1.34 !important;
        letter-spacing: .045em !important;
        max-width: 760px !important;
    }

    #ghostEducationFlow .ghost-edu-preview-side {
        padding-top: 0 !important;
        align-items: center !important;
    }

    #ghostEducationFlow .ghost-edu-template-frame {
        width: 350px !important;
        height: 495px !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 10px 26px rgba(15, 23, 42, .06) !important;
    }

    #ghostEducationFlow .ghost-edu-education-highlight {
        border-width: 3px !important;
        top: 68.5% !important;
        height: 22.8% !important;
    }

    #ghostEducationFlow .ghost-edu-intro-actions {
        margin-top: 50px !important;
        gap: 22px !important;
    }

    #ghostEducationFlow .ghost-edu-flow-preview-btn,
    #ghostEducationFlow .ghost-edu-flow-next-btn {
        width: 205px !important;
        height: 58px !important;
        font-size: 21px !important;
        border-radius: 999px !important;
    }

    #ghostEducationFlow .ghost-edu-flow-preview-btn {
        border-width: 2.5px !important;
    }

    #ghostEducationFlow .ghost-edu-level-wrap {
        width: min(100%, 1260px) !important;
        padding: 92px 58px 95px !important;
        text-align: center !important;
    }

    #ghostEducationFlow .ghost-edu-level-title {
        font-size: 40px !important;
        line-height: 1.12 !important;
        letter-spacing: .045em !important;
        margin: 0 0 20px !important;
    }

    #ghostEducationFlow .ghost-edu-level-subtitle {
        font-size: 23px !important;
        line-height: 1.22 !important;
        letter-spacing: .040em !important;
        margin: 0 0 62px !important;
    }

    #ghostEducationFlow .ghost-edu-level-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 34px 36px !important;
    }

    #ghostEducationFlow .ghost-edu-level-option {
        height: 116px !important;
        border-radius: 12px !important;
        font-size: 23px !important;
        line-height: 1.16 !important;
        padding: 0 16px !important;
    }

    #ghostEducationFlow .ghost-edu-prefer-link {
        margin-top: 38px !important;
        font-size: 19px !important;
    }

    /* ===== Sidebar old logic restoration: do not let missing line overlap Work history ===== */
    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(2),
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(2) {
        height: 58px !important;
        min-height: 58px !important;
        overflow: visible !important;
    }

    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(2)::before,
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(2)::before {
        content: "2" !important;
        background: #0f172a !important;
        color: #ffffff !important;
        font-size: 20px !important;
        font-weight: 950 !important;
        border-color: rgba(226,232,240,.48) !important;
    }

    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(2)::after,
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(2)::after {
        content: "Work history" !important;
        top: 18px !important;
        transform: translateY(-50%) !important;
        font-size: 21px !important;
        line-height: 1 !important;
        font-weight: 850 !important;
        color: #ffffff !important;
        white-space: nowrap !important;
    }

    .ghost-work-missing-sidebar-note,
    .ghost-work-missing-note {
        left: 54px !important;
        top: 34px !important;
        font-size: 13px !important;
        line-height: 1.05 !important;
        font-weight: 650 !important;
        color: #ffffff !important;
        letter-spacing: 0 !important;
        white-space: nowrap !important;
        z-index: 20 !important;
        pointer-events: none !important;
    }

    body.ghost-workhistory-missing-info > nav > div:nth-child(2)::before,
    body.work-history-missing-from-skip > nav > div:nth-child(2)::before {
        background: repeating-linear-gradient(
            to bottom,
            rgba(255,255,255,.22) 0px,
            rgba(255,255,255,.22) 9px,
            transparent 9px,
            transparent 17px
        ) !important;
        box-shadow: none !important;
    }

    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(1)::before,
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(1)::before {
        content: "✓" !important;
        background: #ffffff !important;
        color: #111827 !important;
    }

    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(3)::before,
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(3)::before {
        content: "3" !important;
        background: #ffffff !important;
        color: #111827 !important;
    }

    @media (max-height: 780px) {
        #ghostEducationFlow .ghost-edu-flow-screen { min-height: 1120px !important; }
        #ghostEducationFlow .ghost-edu-intro-layout { padding-top: 118px !important; }
        #ghostEducationFlow .ghost-edu-template-frame { width: 330px !important; height: 466px !important; }
        #ghostEducationFlow .ghost-edu-intro-copy h1 { font-size: 35px !important; }
        #ghostEducationFlow .ghost-edu-intro-copy p { font-size: 21px !important; }
    }

    @media (max-width: 1024px) {
        #ghostEducationFlow.ghost-edu-flow-overlay {
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
        }
        #ghostEducationFlow .ghost-edu-flow-screen { min-height: 1000px !important; }
        #ghostEducationFlow .ghost-edu-intro-layout {
            grid-template-columns: 1fr !important;
            padding: 92px 24px 70px !important;
            gap: 34px !important;
        }
        #ghostEducationFlow .ghost-edu-level-grid { grid-template-columns: 1fr !important; }
    }
</style>

<script id="ghost-education-sidebar-missing-state-cleaner-final-v2">
(function () {
    function rid() { return localStorage.getItem('current_resume_id') || 'no_resume'; }
    function isMissing() {
        return localStorage.getItem('resume_work_history_missing_info_' + rid()) === 'true' ||
               localStorage.getItem('resume_work_history_missing_information_' + rid()) === 'true' ||
               localStorage.getItem('resume_work_history_missing_info') === 'true';
    }
    function cleanSidebarMissingNote() {
        var step2 = document.querySelector('body > nav > div:nth-child(2) > div:nth-child(2)');
        if (!step2) return;
        var missing = isMissing();
        document.body.classList.toggle('ghost-workhistory-missing-info', missing);
        document.body.classList.toggle('work-history-missing-from-skip', missing);

        var notes = Array.from(step2.querySelectorAll('.ghost-work-missing-sidebar-note, .ghost-work-missing-note'));
        notes.forEach(function (n, index) {
            if (!missing || index > 0) n.remove();
        });
        if (missing && !step2.querySelector('.ghost-work-missing-sidebar-note, .ghost-work-missing-note')) {
            var note = document.createElement('span');
            note.className = 'ghost-work-missing-sidebar-note';
            note.textContent = 'Add missing information';
            step2.appendChild(note);
        }
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', cleanSidebarMissingNote);
    else cleanSidebarMissingNote();
    window.addEventListener('load', cleanSidebarMissingNote);
    setTimeout(cleanSidebarMissingNote, 300);
})();
</script>



<!-- GHOST FINAL PATCH: Education description examples + editor side-by-side compact layout -->
<style id="ghost-education-description-side-by-side-compact-final">
    /* Only this Education Description area is adjusted. Sidebar, intro flow, backend and JS logic untouched. */

    .coursework-card {
        max-width: 930px !important;
        margin-top: 32px !important;
        border-radius: 14px !important;
        overflow: hidden !important;
    }

    .coursework-card .main-toggle-header {
        min-height: 64px !important;
        padding: 16px 22px !important;
        gap: 14px !important;
    }

    .coursework-card .main-toggle-header span:first-child {
        font-size: 20px !important;
        line-height: 1.15 !important;
        font-weight: 900 !important;
    }

    .coursework-card .main-toggle-header span:last-child {
        font-size: 16px !important;
        line-height: 1.15 !important;
        font-weight: 850 !important;
    }

    #coursework-main-section {
        padding: 22px 24px 24px !important;
        background: #ffffff !important;
    }

    #coursework-main-section .protip-box {
        padding: 18px 20px !important;
        margin-bottom: 18px !important;
        max-width: 100% !important;
    }

    #coursework-main-section .protip-box p {
        font-size: 15px !important;
        line-height: 1.48 !important;
    }

    /* MAIN FIX: examples left, education description editor right, exactly face-to-face */
    #coursework-main-section > .grid,
    #coursework-main-section .grid.grid-cols-1.lg\:grid-cols-12,
    #coursework-main-section .grid.grid-cols-1 {
        display: grid !important;
        grid-template-columns: minmax(330px, 0.47fr) minmax(390px, 0.53fr) !important;
        gap: 26px !important;
        align-items: start !important;
        width: 100% !important;
    }

    #coursework-main-section .lg\:col-span-6,
    #coursework-main-section > .grid > div {
        grid-column: auto !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        margin-top: 0 !important;
    }

    /* Left ready examples box: compact width so arrows come close like desired screenshot */
    #coursework-main-section .border.border-slate-200.rounded-lg,
    #coursework-main-section .lg\:col-span-6:first-child .border {
        width: 100% !important;
        max-width: 100% !important;
        height: 455px !important;
        max-height: 455px !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        scrollbar-gutter: stable !important;
    }

    #coursework-main-section .accordion-header {
        min-height: 48px !important;
        padding: 12px 14px 12px 18px !important;
        font-size: 16px !important;
        line-height: 1.15 !important;
        font-weight: 900 !important;
        gap: 10px !important;
        justify-content: flex-start !important;
    }

    #coursework-main-section .accordion-header .arrow-icon,
    #coursework-main-section .accordion-header i {
        margin-left: auto !important;
        font-size: 13px !important;
        flex: 0 0 auto !important;
    }

    #coursework-main-section .accordion-item > div[id^="cat-"] {
        padding: 16px !important;
    }

    #coursework-main-section .accordion-item > div[id^="cat-"] p {
        font-size: 15px !important;
        line-height: 1.35 !important;
        margin-bottom: 12px !important;
    }

    #coursework-main-section .example-btn {
        min-height: 54px !important;
        padding: 10px 13px !important;
        border-radius: 10px !important;
        gap: 12px !important;
        max-width: 100% !important;
    }

    #coursework-main-section .example-btn span {
        font-size: 14px !important;
        line-height: 1.25 !important;
        font-weight: 650 !important;
    }

    #coursework-main-section .plus-icon {
        width: 34px !important;
        height: 34px !important;
        font-size: 18px !important;
        flex: 0 0 34px !important;
    }

    /* Right editor: no huge vertical size, aligned opposite examples */
    .ghost-edu-desc-heading {
        margin: 0 0 14px !important;
    }

    .ghost-edu-desc-title {
        font-size: 30px !important;
        line-height: 1.08 !important;
        margin-bottom: 6px !important;
    }

    .ghost-edu-desc-subtitle {
        font-size: 17px !important;
        line-height: 1.25 !important;
        margin-bottom: 16px !important;
    }

    #coursework-main-section .lg\:col-span-6:nth-child(2) > p,
    #coursework-main-section .mt-2 > p {
        font-size: 14px !important;
        margin-bottom: 8px !important;
        letter-spacing: .10em !important;
    }

    #coursework-main-section .editor-container {
        min-height: 455px !important;
        height: 455px !important;
        border-radius: 12px !important;
        overflow: hidden !important;
    }

    #coursework-main-section .toolbar-scrollbox {
        min-height: 62px !important;
        height: 62px !important;
        padding: 10px 18px !important;
        gap: 14px !important;
    }

    #coursework-main-section .toolbar-scrollbox > div:first-child,
    #coursework-main-section .toolbar-scrollbox > div:last-child {
        gap: 16px !important;
    }

    #coursework-main-section .toolbar-btn {
        min-width: 34px !important;
        min-height: 34px !important;
        width: 34px !important;
        height: 34px !important;
        padding: 6px !important;
        font-size: 21px !important;
        border-radius: 7px !important;
    }

    .ghost-edu-smart-pill {
        margin: 18px 22px 2px !important;
        padding: 9px 16px !important;
        font-size: 14px !important;
    }

    #editor.editor-area,
    #coursework-main-section #editor.editor-area {
        min-height: 310px !important;
        height: 310px !important;
        padding: 22px 24px !important;
        font-size: 20px !important;
        line-height: 1.5 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    #editor.editor-area:empty::before {
        font-size: 20px !important;
        line-height: 1.55 !important;
    }

    @media (max-width: 1280px) {
        #coursework-main-section > .grid,
        #coursework-main-section .grid.grid-cols-1.lg\:grid-cols-12,
        #coursework-main-section .grid.grid-cols-1 {
            grid-template-columns: minmax(300px, 0.46fr) minmax(360px, 0.54fr) !important;
            gap: 20px !important;
        }

        #coursework-main-section .border.border-slate-200.rounded-lg,
        #coursework-main-section .editor-container {
            height: 430px !important;
            min-height: 430px !important;
            max-height: 430px !important;
        }

        #editor.editor-area,
        #coursework-main-section #editor.editor-area {
            height: 290px !important;
            min-height: 290px !important;
            font-size: 18px !important;
        }
    }

    @media (max-width: 1024px) {
        #coursework-main-section > .grid,
        #coursework-main-section .grid.grid-cols-1.lg\:grid-cols-12,
        #coursework-main-section .grid.grid-cols-1 {
            grid-template-columns: 1fr !important;
        }

        #coursework-main-section .border.border-slate-200.rounded-lg,
        #coursework-main-section .editor-container {
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
        }

        #editor.editor-area,
        #coursework-main-section #editor.editor-area {
            height: 260px !important;
            min-height: 260px !important;
        }
    }
</style>



<!-- GHOST FINAL DIRECT EDIT: compact education editor toolbar + remove "Your school" heading -->
<style id="ghost-final-direct-education-editor-compact-user-file">
    /*
      Final visual-only patch.
      Old save/preview/dropdown/backend logic is untouched.
      This only fixes the Education Description area shown in screenshots.
    */

    /* Keep the two panels directly side-by-side like the reference screenshot */
    #coursework-main-section > .grid,
    #coursework-main-section .grid.grid-cols-1.lg\:grid-cols-12,
    #coursework-main-section .grid.grid-cols-1 {
        display: grid !important;
        grid-template-columns: minmax(330px, 0.49fr) minmax(410px, 0.51fr) !important;
        gap: 18px !important;
        align-items: start !important;
    }

    #coursework-main-section .lg\:col-span-6,
    #coursework-main-section .mt-2 {
        grid-column: auto !important;
        margin-top: 0 !important;
        padding-top: 0 !important;
        align-self: start !important;
    }

    /* Remove "Your school" and the subtitle under it */
    .ghost-edu-desc-heading,
    #ghostEduDescDynamicTitle,
    #ghostEduDescDynamicSub {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        min-height: 0 !important;
        max-height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    /* Education description label stays, but compact and close to the box */
    #coursework-main-section .lg\:col-span-6:nth-child(2) > p,
    #coursework-main-section .mt-2 > p,
    #coursework-main-section p.text-\[10px\].font-black,
    #coursework-main-section p.uppercase {
        font-size: 12px !important;
        line-height: 1 !important;
        margin: 0 0 8px 0 !important;
        padding: 0 !important;
        letter-spacing: .12em !important;
        font-weight: 900 !important;
        color: #64748b !important;
    }

    /* Main editor box moved upward and reduced */
    #coursework-main-section .editor-container {
        width: 100% !important;
        height: 350px !important;
        min-height: 350px !important;
        max-height: 350px !important;
        margin: 0 !important;
        padding: 0 !important;
        border-radius: 10px !important;
        border: 1.6px solid #94a3b8 !important;
        overflow: hidden !important;
        background: #ffffff !important;
    }

    /* Toolbar: very small icons so all icons remain visible in one line */
    #coursework-main-section .toolbar-scrollbox {
        height: 44px !important;
        min-height: 44px !important;
        max-height: 44px !important;
        padding: 5px 10px !important;
        gap: 5px !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        white-space: nowrap !important;
        align-items: center !important;
        justify-content: flex-start !important;
        flex-wrap: nowrap !important;
        border-bottom: 1px solid #cbd5e1 !important;
        background: #ffffff !important;
    }

    #coursework-main-section .toolbar-scrollbox > div:first-child,
    #coursework-main-section .toolbar-scrollbox > div:last-child {
        gap: 5px !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        flex-shrink: 0 !important;
    }

    #coursework-main-section .toolbar-scrollbox .h-4,
    #coursework-main-section .toolbar-scrollbox .w-\[1px\] {
        height: 20px !important;
        margin-left: 5px !important;
        margin-right: 5px !important;
        flex: 0 0 1px !important;
    }

    #coursework-main-section .toolbar-btn,
    #coursework-main-section button.toolbar-btn,
    .toolbar-btn {
        width: 25px !important;
        height: 25px !important;
        min-width: 25px !important;
        min-height: 25px !important;
        max-width: 25px !important;
        max-height: 25px !important;
        padding: 0 !important;
        margin: 0 !important;
        font-size: 14px !important;
        line-height: 1 !important;
        border-radius: 5px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex: 0 0 25px !important;
    }

    #coursework-main-section .toolbar-btn i,
    #coursework-main-section button.toolbar-btn i,
    .toolbar-btn i {
        font-size: 14px !important;
        line-height: 1 !important;
        width: auto !important;
        height: auto !important;
    }

    #coursework-main-section .toolbar-btn.active-tool,
    #coursework-main-section button.toolbar-btn.active-tool {
        background: #eaf2ff !important;
        color: #071022 !important;
        border: 0 !important;
        box-shadow: none !important;
    }

    .ghost-edu-smart-pill {
        margin: 12px 18px 2px !important;
        padding: 7px 14px !important;
        font-size: 12px !important;
        line-height: 1 !important;
        border-radius: 999px !important;
    }

    #editor.editor-area,
    #coursework-main-section #editor.editor-area {
        height: 244px !important;
        min-height: 244px !important;
        max-height: 244px !important;
        padding: 16px 18px !important;
        font-size: 16px !important;
        line-height: 1.45 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        background: #ffffff !important;
    }

    #editor.editor-area:empty::before {
        font-size: 16px !important;
        line-height: 1.45 !important;
        color: #94a3b8 !important;
        font-weight: 400 !important;
    }

    /* Left examples box: compact so both boxes face each other cleanly */
    #coursework-main-section .border.border-slate-200.rounded-lg {
        height: 350px !important;
        min-height: 350px !important;
        max-height: 350px !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        border-radius: 10px !important;
    }

    #coursework-main-section .accordion-header {
        min-height: 42px !important;
        height: 42px !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        line-height: 1.1 !important;
        font-weight: 850 !important;
    }

    #coursework-main-section .accordion-header .arrow-icon,
    #coursework-main-section .accordion-header i {
        margin-left: 8px !important;
        font-size: 11px !important;
        flex: 0 0 auto !important;
    }

    #coursework-main-section .example-btn {
        min-height: 38px !important;
        padding: 7px 10px !important;
        gap: 8px !important;
        border-radius: 8px !important;
    }

    #coursework-main-section .example-btn span {
        font-size: 12px !important;
        line-height: 1.2 !important;
        font-weight: 700 !important;
    }

    #coursework-main-section .plus-icon {
        width: 24px !important;
        height: 24px !important;
        font-size: 13px !important;
        flex: 0 0 24px !important;
    }

    @media (max-width: 1280px) {
        #coursework-main-section > .grid,
        #coursework-main-section .grid.grid-cols-1.lg\:grid-cols-12,
        #coursework-main-section .grid.grid-cols-1 {
            grid-template-columns: minmax(300px, 0.49fr) minmax(380px, 0.51fr) !important;
            gap: 16px !important;
        }

        #coursework-main-section .editor-container,
        #coursework-main-section .border.border-slate-200.rounded-lg {
            height: 330px !important;
            min-height: 330px !important;
            max-height: 330px !important;
        }

        #editor.editor-area,
        #coursework-main-section #editor.editor-area {
            height: 225px !important;
            min-height: 225px !important;
            max-height: 225px !important;
            font-size: 15px !important;
        }

        #coursework-main-section .toolbar-btn,
        #coursework-main-section button.toolbar-btn,
        .toolbar-btn {
            width: 24px !important;
            height: 24px !important;
            min-width: 24px !important;
            min-height: 24px !important;
            flex-basis: 24px !important;
            font-size: 13px !important;
        }

        #coursework-main-section .toolbar-btn i,
        #coursework-main-section button.toolbar-btn i,
        .toolbar-btn i {
            font-size: 13px !important;
        }
    }

    @media (max-width: 1024px) {
        #coursework-main-section > .grid,
        #coursework-main-section .grid.grid-cols-1.lg\:grid-cols-12,
        #coursework-main-section .grid.grid-cols-1 {
            grid-template-columns: 1fr !important;
        }

        #coursework-main-section .editor-container,
        #coursework-main-section .border.border-slate-200.rounded-lg {
            height: auto !important;
            min-height: 0 !important;
            max-height: none !important;
        }

        #editor.editor-area,
        #coursework-main-section #editor.editor-area {
            height: 220px !important;
            min-height: 220px !important;
            max-height: 220px !important;
        }
    }
</style>
<script id="ghost-final-direct-education-editor-compact-user-file-js">
(function () {
    function removeDynamicSchoolHeading() {
        var heading = document.querySelector('.ghost-edu-desc-heading');
        if (heading) heading.remove();

        var title = document.getElementById('ghostEduDescDynamicTitle');
        if (title && title.parentElement) title.parentElement.remove();

        var sub = document.getElementById('ghostEduDescDynamicSub');
        if (sub && sub.parentElement) sub.parentElement.remove();

        document.querySelectorAll('#coursework-main-section .toolbar-btn, #coursework-main-section button.toolbar-btn').forEach(function (btn) {
            if (btn.tagName === 'BUTTON') btn.setAttribute('type', 'button');
            btn.style.setProperty('width', '25px', 'important');
            btn.style.setProperty('height', '25px', 'important');
            btn.style.setProperty('min-width', '25px', 'important');
            btn.style.setProperty('min-height', '25px', 'important');
            btn.style.setProperty('font-size', '14px', 'important');
            btn.style.setProperty('padding', '0', 'important');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', removeDynamicSchoolHeading);
    } else {
        removeDynamicSchoolHeading();
    }

    window.addEventListener('load', removeDynamicSchoolHeading);
    setTimeout(removeDynamicSchoolHeading, 100);
    setTimeout(removeDynamicSchoolHeading, 500);
})();
</script>
<style id="ghost-final-arrow-align-add-missing-small">
    /* Ready examples accordion arrows end/right side par align */
    #coursework-main-section .accordion-header,
    .accordion-header {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px !important;
        width: 100% !important;
    }

    #coursework-main-section .accordion-header i,
    #coursework-main-section .accordion-header .arrow-icon,
    .accordion-header i,
    .accordion-header .arrow-icon {
        margin-left: auto !important;
        flex-shrink: 0 !important;
        position: static !important;
        right: auto !important;
        transform-origin: center !important;
    }

    /* Add missing information: bold hatao + 2pt size kam */
    .ghost-work-missing-sidebar-note,
    .ghost-work-missing-note {
        font-size: 9px !important;      /* 11px se 2pt kam */
        font-weight: 400 !important;    /* bold remove */
        line-height: 1 !important;
        top: 30px !important;
        left: 54px !important;
        white-space: nowrap !important;
    }

    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(2)::after,
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(2)::after {
        font-weight: 500 !important;
    }
</style>


<!-- GHOST EDUCATION SUMMARY LOGIC PATCH - old APIs reused, no backend route changed -->
<script id="ghost-education-summary-logic-patch">
(function () {
    function q(id) { return document.getElementById(id); }
    function clean(v) { return (v == null ? '' : String(v)).trim(); }
    function htmlToText(html) {
        var div = document.createElement('div');
        div.innerHTML = html || '';
        return clean(div.textContent || div.innerText || '');
    }
    function getResumeId() {
        return (typeof resumeId !== 'undefined' ? resumeId : localStorage.getItem('current_resume_id')) || 'no_resume';
    }
    function getToken() {
        return (typeof token !== 'undefined' ? token : localStorage.getItem('resume_token')) || '';
    }
    function listKey() { return 'resume_education_summary_list_' + getResumeId(); }
    function selectedKey() { return 'resume_education_selected_id_' + getResumeId(); }
    function snapKey() { return 'resume_education_summary_snapshot_' + getResumeId(); }
    function makeId() { return 'edu_' + Date.now() + '_' + Math.random().toString(16).slice(2); }
    function hasEducation(e) {
        if (!e) return false;
        return !!(
            clean(e.school_name) || clean(e.school_location) || clean(e.degree) ||
            clean(e.field_of_study) || clean(e.graduation_month) || clean(e.graduation_year) ||
            htmlToText(e.education_description)
        );
    }
    function normalizeEntry(e) {
        e = e || {};
        return {
            _ghost_id: e._ghost_id || makeId(),
            resume_id: e.resume_id || getResumeId(),
            school_name: clean(e.school_name),
            school_location: clean(e.school_location),
            degree: clean(e.degree),
            field_of_study: clean(e.field_of_study),
            graduation_month: clean(e.graduation_month),
            graduation_year: clean(e.graduation_year),
            education_description: e.education_description || ''
        };
    }
    function signature(e) {
        return [e.school_name, e.school_location, e.degree, e.field_of_study, e.graduation_month, e.graduation_year].map(function (x) {
            return clean(x).toLowerCase();
        }).join('|');
    }
    function getEducationList() {
        var list = [];
        try { list = JSON.parse(localStorage.getItem(listKey()) || '[]') || []; } catch (e) { list = []; }

        /* GHOST FIX: stale/local snapshot auto-migration removed.
           Summary will only show education that was saved through the education form/backend,
           not old leftover localStorage data. */
        list = list.filter(hasEducation).map(normalizeEntry);
        var seen = {};
        list = list.filter(function (item) {
            var sig = signature(item);
            if (seen[sig]) return false;
            seen[sig] = true;
            return true;
        });
        saveEducationList(list);
        return list;
    }
    function saveEducationList(list) {
        localStorage.setItem(listKey(), JSON.stringify((list || []).filter(hasEducation).map(normalizeEntry)));
    }
    function getSelectedId(list) {
        list = list || getEducationList();
        var selected = localStorage.getItem(selectedKey());
        if (selected && list.some(function (x) { return x._ghost_id === selected; })) return selected;
        return '';
    }
    function setSelectedId(id) {
        if (id) localStorage.setItem(selectedKey(), id);
    }
    function selectedEntry(list) {
        list = list || getEducationList();
        var selected = getSelectedId(list);
        return selected ? (list.find(function (x) { return x._ghost_id === selected; }) || null) : null;
    }
    function addOrUpdateEntry(entry, selectIt) {
        entry = normalizeEntry(entry);
        var list = getEducationList();
        var editId = window.__ghostEditingEducationId || entry._ghost_id;
        var idx = list.findIndex(function (x) { return x._ghost_id === editId; });
        if (idx < 0) idx = list.findIndex(function (x) { return signature(x) === signature(entry); });
        if (idx >= 0) {
            entry._ghost_id = list[idx]._ghost_id;
            list[idx] = entry;
        } else {
            list.push(entry);
        }
        saveEducationList(list);
        if (selectIt === true) {
            setSelectedId(entry._ghost_id);
            localStorage.setItem(snapKey(), JSON.stringify(entry));
        }
        window.__ghostEditingEducationId = null;
        return entry;
    }
    function getFormEducationPayload() {
        return {
            _ghost_id: window.__ghostEditingEducationId || makeId(),
            resume_id: getResumeId(),
            school_name: q('inp_school') ? q('inp_school').value : '',
            school_location: q('inp_location') ? q('inp_location').value : '',
            degree: q('inp_degree') ? q('inp_degree').value : '',
            field_of_study: q('inp_field') ? q('inp_field').value : '',
            graduation_month: q('inp_month') ? q('inp_month').value : '',
            graduation_year: q('inp_year') ? q('inp_year').value : '',
            education_description: q('editor') ? q('editor').innerHTML : ''
        };
    }
    function fillEducationForm(e) {
        if (!e) return;
        if (q('inp_school')) q('inp_school').value = e.school_name || '';
        if (q('inp_location')) q('inp_location').value = e.school_location || '';
        if (q('inp_degree')) {
            if (typeof setSelectOrAddOption === 'function') setSelectOrAddOption('inp_degree', e.degree || '');
            else q('inp_degree').value = e.degree || '';
        }
        if (q('inp_field')) q('inp_field').value = e.field_of_study || '';
        if (q('inp_month')) q('inp_month').value = e.graduation_month || '';
        if (q('inp_year')) q('inp_year').value = e.graduation_year || '';
        if (q('editor')) q('editor').innerHTML = e.education_description || '';
        try { if (typeof updatePreview === 'function') updatePreview(); } catch (err) {}
        try { if (typeof renderCoreCvEducationPreview === 'function') renderCoreCvEducationPreview(); } catch (err) {}
    }
    function clearEducationForm() {
        ['inp_school', 'inp_location', 'inp_field'].forEach(function (id) { if (q(id)) q(id).value = ''; });
        ['inp_degree', 'inp_month', 'inp_year'].forEach(function (id) { if (q(id)) q(id).value = ''; });
        if (q('editor')) q('editor').innerHTML = '';
        window.__ghostEditingEducationId = null;
        try { if (typeof updatePreview === 'function') updatePreview(); } catch (err) {}
        try { if (typeof renderCoreCvEducationPreview === 'function') renderCoreCvEducationPreview(); } catch (err) {}
    }
    function ensureSummaryDom() {
        var host = document.querySelector('body > .flex.flex-grow > div:first-child .max-w-2xl');
        if (!host) return;
        var summary = q('educationSummaryPage');
        if (!summary) {
            summary = document.createElement('div');
            summary.id = 'educationSummaryPage';
            host.appendChild(summary);
        }
        summary.innerHTML = `
            <div class="edu-summary-topbar">
                <div>
                    <h1 class="edu-summary-title">Education summary</h1>
                    <div class="edu-summary-subtitle">Review your education to ensure it’s up to date, including any current programs or training.</div>
                </div>
                <a href="javascript:void(0)" class="edu-summary-tips"><i class="fa-regular fa-lightbulb"></i> Tips</a>
            </div>
            <div id="eduSummaryList" class="edu-summary-list"></div>
            <button type="button" class="edu-summary-add-box" id="eduSummaryAddAnother"><i class="fa-solid fa-plus"></i><span>Add another education</span></button>
            <div class="edu-summary-footer-buttons">
                <button type="button" class="edu-summary-preview-btn" id="eduSummaryPreview">Preview</button>
                <button type="button" class="edu-summary-next-btn" id="eduSummaryNext">Next: Skills</button>
            </div>
            <div class="ghost-summary-clean-bottom-space"></div>
        `;
        q('eduSummaryAddAnother').addEventListener('click', function () { clearEducationForm(); showFormMode(null); });
        q('eduSummaryPreview').addEventListener('click', function () {
            var chosen = selectedEntry();
            if (chosen) fillEducationForm(chosen);
            var oldPreview = q('btnPreview');
            if (oldPreview) oldPreview.click();
        });
        q('eduSummaryNext').addEventListener('click', async function () {
            var chosen = selectedEntry();
            if (chosen) {
                fillEducationForm(chosen);
                localStorage.setItem(snapKey(), JSON.stringify(chosen));
                await saveChosenToBackend(chosen);
            } else {
                try {
                    localStorage.removeItem(selectedKey());
                    localStorage.removeItem(snapKey());
                } catch(e) {}
            }
            window.location.href = '/builder/skills';
        });
    }
    function cardHtml(e, i, selectedId) {
        var degreeLine = [clean(e.degree), clean(e.field_of_study)].filter(Boolean).join(', ');
        var dateLine = [clean(e.graduation_month), clean(e.graduation_year)].filter(Boolean).join(' ');
        var missingDate = !dateLine;
        var missingDegree = !degreeLine;
        var missingCoursework = !htmlToText(e.education_description);
        return `
            <div class="edu-summary-card" data-edu-id="${e._ghost_id}">
                <div class="edu-summary-number">${i + 1}</div>
                <div class="edu-summary-content">
                    <div class="edu-summary-school">${clean(e.school_name) || 'Institution Name'}</div>
                    ${clean(e.school_location) ? `<div class="edu-summary-location">${clean(e.school_location)}</div>` : ''}
                    ${degreeLine ? `<div class="edu-summary-degree">${degreeLine}</div>` : ''}
                    ${dateLine ? `<div class="edu-summary-date">${dateLine}</div>` : ''}
                    ${clean(e.education_description) ? `<div class="edu-summary-description">${e.education_description}</div>` : ''}
                    ${(missingDate || missingDegree || missingCoursework) ? `
                    <div class="edu-summary-missing-row">
                        <span class="edu-summary-missing-label">Missing details:</span>
                        ${missingDate ? `<button type="button" class="edu-summary-missing-link" data-action="date">Add graduation date</button>` : ''}
                        ${missingDegree ? `<button type="button" class="edu-summary-missing-link" data-action="degree">Add degree / field</button>` : ''}
                        ${missingCoursework ? `<button type="button" class="edu-summary-missing-link" data-action="coursework">Add description</button>` : ''}
                    </div>` : ''}
                    <label class="edu-summary-use-row"><input type="checkbox" class="edu-summary-use-checkbox" data-id="${e._ghost_id}" ${selectedId === e._ghost_id ? "checked" : ""}> Use This Education</label>
                </div>
                <div class="edu-summary-actions">
                    <button type="button" class="edu-summary-icon-btn" data-action="edit" title="Edit"><i class="fa-solid fa-pen"></i></button>
                    <button type="button" class="edu-summary-icon-btn" data-action="delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    <button type="button" class="edu-summary-icon-btn edu-summary-move-btn" data-action="move" title="Move"><i class="fa-solid fa-arrows-up-down-left-right"></i></button>
                </div>
            </div>
        `;
    }
    function renderSummaryList() {
        ensureSummaryDom();
        var box = q('eduSummaryList');
        if (!box) return;
        var list = getEducationList();
        if (!list.length) return showFormMode(null);
        var selectedId = getSelectedId(list);
        box.innerHTML = list.map(function (e, i) { return cardHtml(e, i, selectedId); }).join('');

        box.querySelectorAll('.edu-summary-use-checkbox').forEach(function (cb) {
            cb.addEventListener('change', function () {
                if (cb.checked) {
                    box.querySelectorAll('.edu-summary-use-checkbox').forEach(function (other) {
                        if (other !== cb) other.checked = false;
                    });
                    setSelectedId(cb.dataset.id);
                    var chosen = selectedEntry();
                    if (chosen) {
                        fillEducationForm(chosen);
                        localStorage.setItem(snapKey(), JSON.stringify(chosen));
                    }
                } else {
                    try {
                        if (localStorage.getItem(selectedKey()) === cb.dataset.id) {
                            localStorage.removeItem(selectedKey());
                            localStorage.removeItem(snapKey());
                        }
                    } catch(e) {}
                }
            });
        });
        if (typeof window.ghostEduSummaryAfterRender === 'function') {
            setTimeout(window.ghostEduSummaryAfterRender, 0);
        }
        box.querySelectorAll('.edu-summary-card').forEach(function (card) {
            var id = card.dataset.eduId;
            var entry = getEducationList().find(function (x) { return x._ghost_id === id; });
            card.querySelectorAll('button[data-action]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var action = btn.dataset.action;
                    if (!entry) return;
                    if (action === 'edit') {
                        window.__ghostEditingEducationId = id;
                        showFormMode(entry);
                    } else if (action === 'delete') {
                        var list = getEducationList().filter(function (x) { return x._ghost_id !== id; });
                        saveEducationList(list);
                        if (getSelectedId(list) === id || !list.some(function (x) { return x._ghost_id === getSelectedId(list); })) {
                            localStorage.removeItem(selectedKey());
                            localStorage.removeItem(snapKey());
                        }
                        if (list.length) renderSummaryList(); else showFormMode(null);
                    } else if (action === 'date') {
                        window.__ghostEditingEducationId = id; showFormMode(entry); setTimeout(function(){ var el=q('inp_month')||q('inp_year'); if(el){ el.scrollIntoView({behavior:'smooth', block:'center'}); try{el.focus();}catch(e){} } },120);
                    } else if (action === 'degree') {
                        window.__ghostEditingEducationId = id; showFormMode(entry); setTimeout(function(){ var el=q('inp_degree')||q('inp_field'); if(el){ el.scrollIntoView({behavior:'smooth', block:'center'}); try{el.focus();}catch(e){} } },120);
                    } else if (action === 'coursework') {
                        window.__ghostEditingEducationId = id; showFormMode(entry, true);
                    }
                });
            });
        });
    }
    function showSummaryMode(entry) {
        if (entry && hasEducation(entry)) addOrUpdateEntry(entry, false);
        var list = getEducationList();
        if (!list.length) return showFormMode(null);
        var chosen = selectedEntry(list);
        if (chosen) fillEducationForm(chosen);
        renderSummaryList();
        document.body.classList.add('education-summary-mode');
        document.body.classList.remove('education-form-mode');
    }
    function showFormMode(entry, focusCoursework) {
        if (entry) fillEducationForm(entry);
        ensureSummaryDom();
        document.body.classList.add('education-form-mode');
        document.body.classList.remove('education-summary-mode');
        if (focusCoursework) {
            setTimeout(function () {
                try { if (q('coursework-main-section') && q('coursework-main-section').classList.contains('hidden') && typeof toggleMainCoursework === 'function') toggleMainCoursework(); } catch (err) {}
                var editor = q('editor');
                if (editor) editor.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 80);
        }
    }
    async function fetchEducationForSummary() {
        var rid = getResumeId();
        var tk = getToken();
        if (!rid || !tk) return null;
        try {
            var res = await fetch('https://resume-backend-54se.onrender.com/api/resumes/education/' + rid, { headers: { 'Authorization': 'Bearer ' + tk } });
            var data = await res.json();
            if (data && data.success && data.education && hasEducation(data.education)) {
                return normalizeEntry(data.education);
            }
        } catch (err) {}
        return null;
    }
    async function saveChosenToBackend(entry) {
        if (!entry || !hasEducation(entry)) return false;
        var payload = normalizeEntry(entry);
        delete payload._ghost_id;
        try {
            await fetch('https://resume-backend-54se.onrender.com/api/resumes/education', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + getToken() },
                body: JSON.stringify(payload)
            });
            return true;
        } catch (err) { return false; }
    }
    async function saveEducationAndShowSummary(btn) {
        var payload = getFormEducationPayload();
        if (!hasEducation(payload)) {
            alert('Please add at least institution or education details first.');
            return;
        }
        var old = btn ? btn.innerHTML : '';
        if (btn) { btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> SAVING...'; btn.disabled = true; }
        try {
            var serverPayload = normalizeEntry(payload);
            delete serverPayload._ghost_id;
            var res = await fetch('https://resume-backend-54se.onrender.com/api/resumes/education', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + getToken() },
                body: JSON.stringify(serverPayload)
            });
            var data = await res.json();
            if (data && data.success) {
                var saved = addOrUpdateEntry(payload, false);
                try { localStorage.removeItem(selectedKey()); localStorage.removeItem(snapKey()); } catch(e) {}
                showSummaryMode(saved);
            } else {
                alert('Education could not be saved.');
            }
        } catch (err) {
            alert('Error saving.');
        } finally {
            if (btn) { btn.innerHTML = old; btn.disabled = false; }
        }
    }
    function bindSummaryPatch() {
        ensureSummaryDom();
        document.body.classList.add('education-form-mode');
        var btn = q('btnNextFooter');
        if (btn && !btn.dataset.ghostEducationSummaryBound) {
            btn.dataset.ghostEducationSummaryBound = '1';
            btn.addEventListener('click', function (ev) {
                ev.preventDefault();
                ev.stopImmediatePropagation();
                saveEducationAndShowSummary(btn);
            }, true);
        }
        setTimeout(async function () {
            var serverEducation = await fetchEducationForSummary();

            if (hasEducation(serverEducation)) {
                /* GHOST FIX: database/backend saved education is the only auto-loaded summary source. */
                var savedFromDb = normalizeEntry(serverEducation);
                saveEducationList([savedFromDb]);
                localStorage.setItem(snapKey(), JSON.stringify(savedFromDb));
            } else {
                /* GHOST FIX: no backend-saved education means no auto summary card.
                   Remove only stale education summary cache; old checkbox/forward logic stays unchanged. */
                localStorage.removeItem(listKey());
                localStorage.removeItem(snapKey());
                localStorage.removeItem(selectedKey());
            }

            var list = getEducationList();
            if (list.length) showSummaryMode(selectedEntry(list));
            else showFormMode(null);
        }, 450);
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bindSummaryPatch);
    else bindSummaryPatch();
})();
</script>




<!-- GHOST FINAL STABLE PATCH: sidebar flow + tips + no-shake See More (old logic unchanged) -->
<style id="ghost-final-stable-education-summary-patch">
    /* Sidebar connector: solid white line to current Education step, dim line continues below */
    body > nav > div:nth-child(2)::before,
    body.ghost-workhistory-missing-info > nav > div:nth-child(2)::before,
    body.work-history-missing-from-skip > nav > div:nth-child(2)::before {
        background:
            linear-gradient(to bottom, #ffffff 0px, #ffffff 146px, transparent 146px, transparent 100%),
            repeating-linear-gradient(to bottom, rgba(255,255,255,.22) 0px, rgba(255,255,255,.22) 9px, transparent 9px, transparent 17px) !important;
        box-shadow: none !important;
    }

    body > nav > div:nth-child(2) > div:nth-child(1)::before {
        content: "✓" !important;
        background: #ffffff !important;
        color: #111827 !important;
        font-size: 23px !important;
        font-weight: 950 !important;
        border-color: rgba(226,232,240,.78) !important;
    }

    body:not(.ghost-workhistory-completed-selected) > nav > div:nth-child(2) > div:nth-child(2)::before,
    body.ghost-workhistory-missing-info:not(.ghost-workhistory-completed-selected) > nav > div:nth-child(2) > div:nth-child(2)::before,
    body.work-history-missing-from-skip:not(.ghost-workhistory-completed-selected) > nav > div:nth-child(2) > div:nth-child(2)::before {
        content: "2" !important;
        background: #0f172a !important;
        color: #ffffff !important;
        font-size: 20px !important;
        font-weight: 950 !important;
        border-color: rgba(226,232,240,.48) !important;
    }

    body.ghost-workhistory-completed-selected > nav > div:nth-child(2) > div:nth-child(2)::before {
        content: "✓" !important;
        background: #ffffff !important;
        color: #111827 !important;
        font-size: 23px !important;
        font-weight: 950 !important;
        border-color: rgba(226,232,240,.78) !important;
    }

    body > nav > div:nth-child(2) > div:nth-child(3)::before,
    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(3)::before,
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(3)::before {
        content: "3" !important;
        background: #ffffff !important;
        color: #111827 !important;
        font-size: 22px !important;
        font-weight: 950 !important;
        border-color: rgba(226,232,240,.78) !important;
    }

    .ghost-work-missing-sidebar-note,
    .ghost-work-missing-note {
        font-size: 12px !important;
        font-weight: 400 !important;
        line-height: 1.05 !important;
        top: 34px !important;
    }

    body.education-summary-mode .edu-summary-card,
    .edu-summary-card {
        min-height: 227px !important;
        height: 227px !important;
        max-height: 227px !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
        align-items: start !important;
        contain: layout !important;
    }

    body.education-summary-mode .edu-summary-card.ghost-edu-expanded,
    .edu-summary-card.ghost-edu-expanded {
        height: auto !important;
        max-height: none !important;
        overflow: visible !important;
    }

    /* Description must not show until user clicks See More */
    .edu-summary-card .edu-summary-description {
        display: none !important;
        max-height: 0 !important;
        overflow: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .edu-summary-card.ghost-edu-expanded .edu-summary-description {
        display: block !important;
        max-height: none !important;
        overflow: visible !important;
        margin: 10px 0 8px !important;
        padding-top: 10px !important;
        border-top: 1px solid #e2e8f0 !important;
        line-height: 1.45 !important;
        color: #334155 !important;
    }

    .edu-summary-see-more-row {
        display: flex !important;
        align-items: center !important;
        margin-top: 7px !important;
        margin-bottom: 7px !important;
        position: relative !important;
        z-index: 8 !important;
        line-height: 1.25 !important;
    }

    .edu-summary-see-more-link {
        border: 0 !important;
        background: transparent !important;
        padding: 0 !important;
        color: #0b77df !important;
        font-size: 15px !important;
        line-height: 1.25 !important;
        font-weight: 850 !important;
        text-decoration: underline !important;
        cursor: pointer !important;
    }

    .edu-summary-use-row {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        position: relative !important;
        z-index: 7 !important;
    }

    .edu-summary-use-checkbox {
        cursor: pointer !important;
    }

    /* Tips popup exactly under Tips button */
    .ghost-edu-tips-popover {
        position: fixed !important;
        width: min(540px, calc(100vw - 48px)) !important;
        max-width: min(540px, calc(100vw - 48px)) !important;
        background: #ffffff !important;
        border: 1.8px solid #34d399 !important;
        border-radius: 6px !important;
        box-shadow: 0 18px 45px rgba(15,23,42,.18) !important;
        padding: 22px 26px 24px !important;
        z-index: 999999 !important;
        color: #071022 !important;
        font-family: inherit !important;
        display: none !important;
    }
    .ghost-edu-tips-popover.show { display: block !important; }
    .ghost-edu-tips-popover::before {
        content: "";
        position: absolute;
        top: -14px;
        right: 62px;
        width: 0;
        height: 0;
        border-left: 14px solid transparent;
        border-right: 14px solid transparent;
        border-bottom: 14px solid #34d399;
    }
    .ghost-edu-tips-popover::after {
        content: "";
        position: absolute;
        top: -11px;
        right: 64px;
        width: 0;
        height: 0;
        border-left: 12px solid transparent;
        border-right: 12px solid transparent;
        border-bottom: 12px solid #ffffff;
    }
    .ghost-edu-tips-popover h3 {
        font-size: 20px !important;
        font-weight: 950 !important;
        margin: 0 0 10px !important;
        color: #071022 !important;
    }
    .ghost-edu-tips-popover p,
    .ghost-edu-tips-popover li {
        font-size: 15px !important;
        line-height: 1.55 !important;
        color: #111827 !important;
    }
    .ghost-edu-tips-popover ul {
        margin: 12px 0 0 !important;
        padding-left: 22px !important;
    }
    .ghost-edu-tips-popover li { margin-bottom: 9px !important; }
</style>

<script id="ghost-final-stable-education-summary-patch-js">
(function () {
    function rid() { return localStorage.getItem('current_resume_id') || 'no_resume'; }
    function readJson(key, fallback) {
        try { var raw = localStorage.getItem(key); return raw ? JSON.parse(raw) : fallback; } catch(e) { return fallback; }
    }
    function plainHtml(html) {
        var d = document.createElement('div');
        d.innerHTML = html || '';
        return (d.textContent || d.innerText || '').replace(/\s+/g, ' ').trim();
    }
    function plainEl(el) {
        return ((el && (el.textContent || el.innerText)) || '').replace(/\s+/g, ' ').trim();
    }
    function hasWorkData(work) {
        return !!(work && (
            String(work.job_title || '').trim() || String(work.employer || '').trim() ||
            String(work.city || '').trim() || String(work.country || '').trim() ||
            String(work.start_month || '').trim() || String(work.start_year || '').trim() ||
            String(work.end_month || '').trim() || String(work.end_year || '').trim() ||
            work.is_remote || work.currently_working || plainHtml(work.extra_info)
        ));
    }
    function selectedWorks() {
        var id = rid();
        var keys = [
            'resume_work_history_selected_for_education_' + id,
            'resume_work_history_selected_for_education'
        ];
        var out = [];
        keys.forEach(function (key) {
            var value = readJson(key, []);
            if (Array.isArray(value)) out = out.concat(value.filter(hasWorkData));
            else if (hasWorkData(value)) out.push(value);
        });
        return out;
    }
    function updateSidebarProgress() {
        var hasSelectedWork = selectedWorks().length > 0;
        document.body.classList.toggle('ghost-workhistory-completed-selected', hasSelectedWork);
        if (hasSelectedWork) {
            document.body.classList.remove('ghost-workhistory-missing-info');
            document.body.classList.remove('work-history-missing-from-skip');
            document.querySelectorAll('.ghost-work-missing-sidebar-note, .ghost-work-missing-note').forEach(function(n){ n.remove(); });
        }
    }

    function ensureSeeMore(card) {
        if (!card) return;
        var desc = card.querySelector('.edu-summary-description');
        var useRow = card.querySelector('.edu-summary-use-row');
        var content = card.querySelector('.edu-summary-content') || card;
        var hasDesc = !!plainEl(desc);

        var row = card.querySelector('.edu-summary-see-more-row');
        var extraRows = Array.prototype.slice.call(card.querySelectorAll('.edu-summary-see-more-row')).slice(1);
        extraRows.forEach(function (r) { r.remove(); });

        if (!hasDesc) {
            if (row) row.remove();
            card.classList.remove('ghost-edu-expanded', 'ghost-edu-has-description');
            return;
        }

        card.classList.add('ghost-edu-has-description');

        if (!row) {
            row = document.createElement('div');
            row.className = 'edu-summary-see-more-row';
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'edu-summary-see-more-link';
            btn.textContent = card.classList.contains('ghost-edu-expanded') ? 'See Less' : 'See More';
            btn.addEventListener('click', function (ev) {
                ev.preventDefault();
                ev.stopPropagation();
                var expanded = card.classList.toggle('ghost-edu-expanded');
                btn.textContent = expanded ? 'See Less' : 'See More';
            });
            row.appendChild(btn);
        } else {
            var existingBtn = row.querySelector('.edu-summary-see-more-link');
            if (existingBtn) existingBtn.textContent = card.classList.contains('ghost-edu-expanded') ? 'See Less' : 'See More';
        }

        /* Required order: See More above checkbox */
        if (useRow && row.nextElementSibling !== useRow) {
            useRow.parentNode.insertBefore(row, useRow);
        } else if (!useRow && desc && row.previousElementSibling !== desc) {
            desc.insertAdjacentElement('afterend', row);
        } else if (!row.parentNode) {
            content.appendChild(row);
        }
    }

    function applySummaryEnhancements() {
        updateSidebarProgress();
        document.querySelectorAll('.edu-summary-card').forEach(ensureSeeMore);

        /* Keep previous user selection checked when returning to Education.
           If no selected id exists, all checkboxes stay unchecked. */
        try {
            var rid = (typeof resumeId !== 'undefined' ? resumeId : localStorage.getItem('current_resume_id')) || 'no_resume';
            var selected = localStorage.getItem('resume_education_selected_id_' + rid) || '';
            document.querySelectorAll('.edu-summary-use-checkbox').forEach(function(cb){
                cb.checked = !!selected && cb.dataset.id === selected;
            });
        } catch(e) {}
    }

    var previousHook = window.ghostEduSummaryAfterRender;
    window.ghostEduSummaryAfterRender = function () {
        if (typeof previousHook === 'function') previousHook();
        requestAnimationFrame(applySummaryEnhancements);
    };

    document.addEventListener('change', function (ev) {
        var cb = ev.target && ev.target.classList && ev.target.classList.contains('edu-summary-use-checkbox') ? ev.target : null;
        if (!cb) return;
        document.body.dataset.ghostEduUserCheckedOnce = '1';
        if (cb.checked) {
            document.querySelectorAll('.edu-summary-use-checkbox').forEach(function (other) {
                if (other !== cb) other.checked = false;
            });
            try {
                var rid = (typeof resumeId !== 'undefined' ? resumeId : localStorage.getItem('current_resume_id')) || 'no_resume';
                localStorage.setItem('resume_education_selected_id_' + rid, cb.dataset.id);
                var list = JSON.parse(localStorage.getItem('resume_education_summary_list_' + rid) || '[]') || [];
                var found = list.find(function(x){ return x && x._ghost_id === cb.dataset.id; });
                if (found) localStorage.setItem('resume_education_summary_snapshot_' + rid, JSON.stringify(found));
            } catch(e) {}
        } else {
            try {
                var rid2 = (typeof resumeId !== 'undefined' ? resumeId : localStorage.getItem('current_resume_id')) || 'no_resume';
                if (localStorage.getItem('resume_education_selected_id_' + rid2) === cb.dataset.id) {
                    localStorage.removeItem('resume_education_selected_id_' + rid2);
                    localStorage.removeItem('resume_education_summary_snapshot_' + rid2);
                }
            } catch(e) {}
        }
    }, true);

    function ensureTipsPopover() {
        var existing = document.getElementById('ghostEduTipsPopover');
        if (existing) return existing;
        var pop = document.createElement('div');
        pop.id = 'ghostEduTipsPopover';
        pop.className = 'ghost-edu-tips-popover';
        pop.innerHTML = '<h3>Expert Insights</h3>' +
            '<p>Include your education details to showcase your qualifications and confirm that you meet job requirements or industry standards.</p>' +
            '<ul>' +
            '<li>List your schools and degrees, starting with the most recent. Include high school only if you didn’t attend college.</li>' +
            '<li>If your degree is over ten years old, consider removing the date.</li>' +
            '<li>Coursework is optional. List relevant courses if you don’t have much work experience.</li>' +
            '<li>Certifications and training programs should be included in a separate section.</li>' +
            '</ul>';
        document.body.appendChild(pop);
        return pop;
    }

    function getZoom() {
        var z = parseFloat((window.getComputedStyle(document.body).zoom || '1').toString());
        return (!z || isNaN(z)) ? 1 : z;
    }

    function placeTips(pop, tips) {
        if (!pop || !tips) return;
        var zoom = getZoom();
        var rect = tips.getBoundingClientRect();
        var visualWidth = Math.min(540, window.innerWidth - 48);
        var cssWidth = visualWidth / zoom;
        var rightGap = Math.max(42, window.innerWidth - rect.right - 8) / zoom;
        var top = (rect.bottom + 16) / zoom;
        pop.style.width = cssWidth + 'px';
        pop.style.maxWidth = cssWidth + 'px';
        pop.style.left = 'auto';
        pop.style.right = rightGap + 'px';
        pop.style.top = top + 'px';
    }

    document.addEventListener('click', function (ev) {
        var tips = ev.target && ev.target.closest ? ev.target.closest('.edu-summary-tips') : null;
        var pop = ensureTipsPopover();
        if (tips) {
            ev.preventDefault();
            ev.stopPropagation();
            placeTips(pop, tips);
            pop.classList.toggle('show');
            return;
        }
        if (pop && pop.classList.contains('show') && !pop.contains(ev.target)) {
            pop.classList.remove('show');
        }
    }, true);

    window.addEventListener('resize', function () {
        var pop = document.getElementById('ghostEduTipsPopover');
        var tips = document.querySelector('.edu-summary-tips');
        if (pop && pop.classList.contains('show') && tips) placeTips(pop, tips);
    });

    function boot() {
        requestAnimationFrame(applySummaryEnhancements);
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();
    window.addEventListener('load', boot);
})();
</script>


<!-- GHOST FINAL FIX ONLY: no duplicate/big WorkHistory missing note + no shaking on skip popup flow -->
<style id="ghost-final-workhistory-missing-note-no-shake-only">
    /* Keep existing sidebar logic, only normalize the visual missing note. */
    .ghost-work-missing-note,
    .ghost-work-missing-sidebar-note {
        position: absolute !important;
        left: 54px !important;
        top: 32px !important;
        font-size: 12px !important;
        line-height: 1.05 !important;
        font-weight: 400 !important;
        letter-spacing: 0 !important;
        color: #ffffff !important;
        white-space: nowrap !important;
        z-index: 50 !important;
        pointer-events: none !important;
        text-transform: none !important;
    }

    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(2),
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(2) {
        overflow: visible !important;
        min-height: 52px !important;
    }

    body.ghost-workhistory-missing-info > nav > div:nth-child(2) > div:nth-child(2)::after,
    body.work-history-missing-from-skip > nav > div:nth-child(2) > div:nth-child(2)::after {
        content: "Work history" !important;
        top: 18px !important;
        transform: translateY(-50%) !important;
        font-size: 21px !important;
        line-height: 1 !important;
        font-weight: 500 !important;
        color: #ffffff !important;
        white-space: nowrap !important;
    }
</style>
<script id="ghost-final-workhistory-missing-note-no-shake-only-js">
(function(){
    function rid(){ return localStorage.getItem('current_resume_id') || 'no_resume'; }
    function isMissing(){
        return localStorage.getItem('resume_work_history_missing_info_' + rid()) === 'true' ||
               localStorage.getItem('resume_work_history_missing_information_' + rid()) === 'true' ||
               localStorage.getItem('resume_work_history_missing_info') === 'true';
    }
    function hasSelectedWork(){
        function read(key, fb){ try { var v = localStorage.getItem(key); return v ? JSON.parse(v) : fb; } catch(e){ return fb; } }
        function txt(html){ var d=document.createElement('div'); d.innerHTML=html||''; return (d.textContent||'').trim(); }
        function valid(w){ return !!(w && (w.job_title || w.employer || w.city || w.country || w.start_month || w.start_year || w.end_month || w.end_year || w.is_remote || w.currently_working || txt(w.extra_info))); }
        var a = read('resume_work_history_selected_for_education_' + rid(), []);
        var b = read('resume_work_history_selected_for_education', []);
        if (!Array.isArray(a)) a = valid(a) ? [a] : [];
        if (!Array.isArray(b)) b = valid(b) ? [b] : [];
        return a.concat(b).some(valid);
    }
    function normalizeMissingNote(){
        var step2 = document.querySelector('body > nav > div:nth-child(2) > div:nth-child(2)');
        if (!step2) return;
        var completed = hasSelectedWork();
        var missing = !completed && isMissing();

        document.body.classList.toggle('ghost-workhistory-completed-selected', completed);
        document.body.classList.toggle('ghost-workhistory-missing-info', missing);
        document.body.classList.toggle('work-history-missing-from-skip', missing);

        var notes = Array.prototype.slice.call(step2.querySelectorAll('.ghost-work-missing-sidebar-note, .ghost-work-missing-note'));
        notes.forEach(function(n, i){ if (!missing || i > 0) n.remove(); });
        if (missing && !step2.querySelector('.ghost-work-missing-sidebar-note, .ghost-work-missing-note')) {
            var note = document.createElement('span');
            note.className = 'ghost-work-missing-sidebar-note';
            note.textContent = 'Add missing information';
            step2.appendChild(note);
        }
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', normalizeMissingNote);
    else normalizeMissingNote();
    window.addEventListener('load', normalizeMissingNote);
    setTimeout(normalizeMissingNote, 80);
    setTimeout(normalizeMissingNote, 300);
})();
</script>

</body>
</html>
