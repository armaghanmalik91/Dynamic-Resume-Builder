<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Dynamic Resume Builder | The Best Online Resume Creator</title> 
    <script src="https://cdn.tailwindcss.com"></script> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> 
    <style> 
        html { scroll-behavior: smooth; } 
        ::-webkit-scrollbar { width: 12px; } 
        ::-webkit-scrollbar-track { background: #f8fafc; } 
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 6px; border: 3px solid #f8fafc; } 
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; } 
        details > summary { list-style: none; cursor: pointer; } 
        details > summary::-webkit-details-marker { display: none; } 
        .hero-bg { background-image: radial-gradient(circle at top right, #fdf4ff, #fff); } 
        .logo-rotate { transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); } 
/* Replace old style with this */
.modal-blur-bg { backdrop-filter: blur(16px); transition: all 0.4s ease-in-out; }
.scale-animation { transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); }

/* Gradient Admin Login Background */
.admin-bg-gradient {
    background: linear-gradient(135deg, #1e1b4b 0%, #831843 100%); /* Black/Purple to Pink shade */
}

/* Hide browser default black password eye (Edge/IE/Chrome native reveal) */
input[type="password"]::-ms-reveal,
input[type="password"]::-ms-clear {
    display: none;
}
input[type="password"]::-webkit-credentials-auto-fill-button,
input[type="password"]::-webkit-textfield-decoration-container {
    visibility: hidden;
    display: none !important;
    pointer-events: none;
}

        .logo-grow-spin { animation: growSpin 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }

        /* Front hero video section - one video left / text right */
        .front-hero {
            width: 100%;
            max-width: 1500px;
            min-height: calc(100vh - 146px);
            padding-top: 44px !important;
            padding-bottom: 44px !important;
            display: grid !important;
            grid-template-columns: minmax(470px, 0.95fr) minmax(520px, 1.05fr);
            align-items: center;
            column-gap: clamp(34px, 4vw, 70px);
        }

        .hero-copy {
            width: 100%;
            min-width: 0;
            text-align: left;
        }

        .hero-video-wrap {
            width: 100%;
            min-width: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-video-shell {
            position: relative;
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
        }

        .hero-video-glow {
            position: absolute;
            inset: -20px;
            background:
                radial-gradient(circle at 18% 22%, rgba(168, 85, 247, 0.22), transparent 34%),
                radial-gradient(circle at 82% 72%, rgba(236, 72, 153, 0.22), transparent 36%);
            filter: blur(24px);
            opacity: 0.85;
            z-index: 0;
            pointer-events: none;
        }

        .hero-video-card {
            position: relative;
            z-index: 1;
            width: 100%;
            border-radius: 26px;
            background: #ffffff;
            border: 8px solid #ffffff;
            box-shadow: 0 28px 72px rgba(15, 23, 42, 0.15);
            overflow: hidden;
            transform: rotate(-1deg);
            transition: 0.45s ease;
        }

        .hero-video-card:hover {
            transform: rotate(0deg) translateY(-4px);
            box-shadow: 0 34px 88px rgba(15, 23, 42, 0.19);
        }

        .hero-video {
            width: 100%;
            height: clamp(390px, 38vw, 535px);
            object-fit: contain;
            background: #ffffff;
            display: block;
        }

        .hero-title-fixed {
            font-size: clamp(46px, 4.5vw, 82px);
        }

        .hero-copy-text {
            font-size: clamp(18px, 1.35vw, 22px);
        }

        @media (max-width: 1100px) {
            .front-hero {
                min-height: auto;
                padding-top: 58px !important;
                padding-bottom: 58px !important;
                grid-template-columns: 1fr;
                row-gap: 42px;
            }

            .hero-copy {
                text-align: center;
            }

            .hero-video {
                height: 430px;
            }

            .hero-video-card {
                transform: rotate(0deg);
            }
        }

        @media (max-width: 640px) {
            .front-hero {
                padding-top: 42px !important;
                padding-bottom: 42px !important;
            }

            .hero-video {
                height: 285px;
            }

            .hero-video-card {
                border-width: 6px;
                border-radius: 22px;
            }
        }


        @media (max-width: 1100px) {
            .hero-copy .max-w-2xl {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-copy .justify-start {
                justify-content: center !important;
            }
        }



        /* Final navbar single-button + open-links fix */
        .site-navbar {
            min-height: 72px;
            overflow: visible;
        }

        .site-navbar-inner {
            width: 100%;
            max-width: 1880px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
        }

        .site-logo-wrap {
            flex: 0 0 auto;
            min-width: 250px;
        }

        .site-logo-text {
            font-size: 28px;
            line-height: 1;
            white-space: nowrap;
        }

        .site-nav-menu {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: clamp(24px, 2.2vw, 44px);
            min-width: 0;
            flex: 1 1 auto;
        }

        .main-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 0;
            color: #111827;
            font-weight: 800;
            font-size: clamp(12px, 0.86vw, 15px);
            line-height: 1.05;
            white-space: nowrap;
            letter-spacing: -0.01em;
            transition: 0.2s ease;
        }

        .main-nav-link:hover {
            color: #7c3aed;
        }

        .main-nav-link i {
            font-size: 9px;
            color: #6b7280;
            transition: 0.2s ease;
        }

        .main-nav-link:hover i {
            color: #7c3aed;
            transform: translateY(1px);
        }

        .nav-cta {
            padding: 12px 27px;
            font-size: 16px;
            white-space: nowrap;
            line-height: 1;
            min-width: 185px;
            text-align: center;
        }

        .front-hero {
            width: 100%;
            max-width: 1580px;
            min-height: calc(100vh - 116px);
            padding-top: 36px !important;
            padding-bottom: 28px !important;
            display: grid !important;
            grid-template-columns: minmax(560px, 0.98fr) minmax(590px, 1.02fr);
            align-items: center;
            column-gap: 62px;
        }

        .hero-video-wrap {
            transform: translateX(-18px);
            width: 100%;
            min-width: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-video-shell {
            position: relative;
            width: 100%;
            max-width: 675px;
            margin: 0 auto;
        }

        .hero-video-card {
            position: relative;
            z-index: 1;
            width: 100%;
            border-radius: 26px;
            background: #ffffff;
            border: 8px solid #ffffff;
            box-shadow: 0 28px 72px rgba(15, 23, 42, 0.15);
            overflow: hidden;
            transform: rotate(-1deg);
            transition: 0.45s ease;
        }

        .hero-video-card:hover {
            transform: rotate(0deg) translateY(-4px);
            box-shadow: 0 34px 88px rgba(15, 23, 42, 0.19);
        }

        .hero-video {
            width: 100%;
            height: 525px;
            object-fit: contain;
            background: #ffffff;
            display: block;
        }

        .hero-copy {
            padding-left: 46px;
            transform: translateY(-10px);
            width: 100%;
            min-width: 0;
            text-align: left;
        }

        .hero-title-fixed {
            font-size: 64px;
            line-height: 1.06;
        }

        .hero-copy-text {
            font-size: 18px;
            max-width: 720px;
        }

        .hero-actions a {
            font-size: 17px;
            padding-top: 17px;
            padding-bottom: 17px;
        }

        .hero-stats .stat-number {
            font-size: 42px;
        }

        .trusted-marquee-section {
            width: 100%;
            overflow: hidden;
            border-top: 1px solid #eef2f7;
            border-bottom: 1px solid #eef2f7;
            background: #ffffff;
            padding: 14px 0;
        }

        .trusted-marquee-track {
            display: flex;
            align-items: center;
            width: max-content;
            gap: 62px;
            animation: trustedMarquee 24s linear infinite;
        }

        .trusted-marquee-section:hover .trusted-marquee-track {
            animation-play-state: paused;
        }

        .trusted-logo-item {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            color: #64748b;
            font-size: 20px;
            font-weight: 900;
            opacity: 0.78;
            white-space: nowrap;
            transition: 0.2s ease;
        }

        .trusted-logo-item:hover {
            opacity: 1;
            color: #111827;
            transform: translateY(-1px);
        }

        @keyframes trustedMarquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        @media (max-width: 1500px) {
            .site-navbar {
                padding-left: 22px !important;
                padding-right: 22px !important;
            }

            .site-logo-wrap {
                min-width: 220px;
            }

            .site-logo-text {
                font-size: 25px;
            }

            .site-nav-menu {
                gap: clamp(18px, 1.6vw, 30px);
            }

            .main-nav-link {
                font-size: 12px;
                gap: 5px;
            }

            .nav-cta {
                padding: 10px 21px;
                font-size: 14px;
                min-width: 160px;
            }

            .front-hero {
                max-width: 1420px;
                grid-template-columns: minmax(500px, 0.98fr) minmax(520px, 1.02fr);
                column-gap: 46px;
            }

            .hero-video-shell {
                max-width: 610px;
            }

            .hero-video {
                height: 470px;
            }

            .hero-title-fixed {
                font-size: 56px;
            }

            .hero-copy-text {
                max-width: 650px;
                font-size: 17px;
            }
        }

        @media (max-width: 1220px) {
            .site-logo-wrap {
                min-width: 180px;
            }

            .site-logo-text {
                font-size: 21px;
            }

            .site-nav-menu {
                gap: 10px;
            }

            .main-nav-link {
                font-size: 10.5px;
                gap: 4px;
            }

            .nav-cta {
                padding: 9px 14px;
                font-size: 12px;
                min-width: 132px;
            }
        }

        @media (max-width: 1060px) {
            .site-nav-menu {
                display: none !important;
            }

            .front-hero {
                min-height: auto;
                padding-top: 58px !important;
                padding-bottom: 58px !important;
                grid-template-columns: 1fr;
                row-gap: 42px;
            }

            .hero-copy {
                padding-left: 0;
                transform: translateY(0);
                text-align: center;
            }

            .hero-video-wrap {
                transform: translateX(0);
            }

            .hero-copy-text {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-video {
                height: 430px;
            }

            .hero-video-card {
                transform: rotate(0deg);
            }

            .trusted-marquee-track {
                gap: 46px;
            }
        }

        @media (max-width: 640px) {
            .front-hero {
                padding-top: 42px !important;
                padding-bottom: 42px !important;
            }

            .hero-video {
                height: 285px;
            }

            .hero-video-card {
                border-width: 6px;
                border-radius: 22px;
            }
        }


        /* Resume Examples mega dropdown - fixed working version */
        .mega-nav-item {
            position: relative;
        }

        .main-nav-link {
            background: transparent;
            border: 0;
            outline: none;
            cursor: pointer;
            font-family: inherit;
        }

        .nav-mega-panel {
            position: fixed;
            left: 14px;
            right: 14px;
            top: var(--mega-top, 126px);
            z-index: 9999;
            background: #ffffff;
            border: 1px solid #eef2f7;
            border-radius: 0 0 28px 28px;
            box-shadow: 0 28px 70px rgba(15, 23, 42, 0.14);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            pointer-events: none;
            overflow: hidden;
            transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s ease;
        }

        .nav-mega-panel.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        .mega-inner {
            width: min(100%, 1720px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            min-height: 590px;
            border-radius: 0 0 28px 28px;
            overflow: hidden;
        }

        .mega-left {
            padding: 50px 54px 46px 56px;
            background: #ffffff;
        }

        .mega-title {
            font-size: 26px;
            line-height: 1.15;
            font-weight: 900;
            color: #111827;
            margin: 0 0 14px;
            letter-spacing: -0.02em;
        }

        .mega-text {
            max-width: 900px;
            font-size: 17px;
            line-height: 1.55;
            color: #5f6b6b;
            font-weight: 500;
            margin-bottom: 38px;
        }

        .mega-list-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(210px, 1fr));
            gap: 24px 70px;
            margin-bottom: 54px;
            max-width: 760px;
        }

        .mega-list-grid a {
            color: #566161;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            text-underline-offset: 6px;
            text-decoration-thickness: 2px;
            transition: 0.18s ease;
            white-space: nowrap;
        }

        .mega-list-grid a:hover {
            color: #ec4899;
            text-decoration: underline;
            text-decoration: underline;
            transform: translateX(3px);
        }

        .mega-view-all {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #ec4899;
            font-size: 18px;
            font-weight: 900;
            text-decoration: none;
            text-underline-offset: 6px;
            text-decoration-thickness: 2px;
            letter-spacing: 0.02em;
        }

        .mega-view-all:hover {
            color: #db2777;
            text-decoration: underline;
        }

        .mega-right {
            padding: 50px 56px 44px;
            text-align: center;
            background:
                radial-gradient(circle at 76% 70%, rgba(236, 72, 153, 0.25), transparent 42%),
                linear-gradient(135deg, #ffffff 0%, #fff7fb 45%, #f4d1f3 100%);
            border-left: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .mega-right-title {
            font-size: 26px;
            line-height: 1.15;
            font-weight: 900;
            color: #111827;
            margin-bottom: 14px;
        }

        .mega-right-text {
            max-width: 560px;
            color: #5f6b6b;
            font-size: 17px;
            line-height: 1.55;
            font-weight: 500;
            margin-bottom: 30px;
        }

        .mega-preview-img {
            width: min(430px, 82%);
            height: 330px;
            object-fit: contain;
            display: block;
            margin: 0 auto 38px;
            filter: drop-shadow(0 18px 26px rgba(15, 23, 42, 0.12));
        }

        .mega-build-btn {
            width: min(330px, 90%);
            min-height: 58px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #ffffff;
            color: #222222;
            font-size: 20px;
            font-weight: 650;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.08);
            transition: 0.18s ease;
        }

        .mega-build-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.13);
        }
@media (max-width: 1180px) {
            .nav-mega-panel {
                display: none !important;
            }
        }

@keyframes growSpin { 0% { transform: scale(1) rotate(0deg); opacity: 0.5; } 100% { transform: scale(1.15) rotate(360deg); opacity: 1; } } 
    
        /* Resume Examples mega dropdown compact sizing */
        .nav-mega-panel {
            left: 18px !important;
            right: 18px !important;
            border-radius: 0 0 24px 24px !important;
            overflow: hidden !important;
        }

        .mega-inner {
            min-height: 455px !important;
            max-height: calc(100vh - 150px);
            overflow: hidden;
            grid-template-columns: 1.05fr 0.95fr !important;
            border-radius: 0 0 24px 24px !important;
        }

        .mega-left {
            padding: 36px 46px 34px 52px !important;
        }

        .mega-right {
            padding: 36px 46px 34px !important;
        }

        .mega-title,
        .mega-right-title {
            font-size: 22px !important;
            line-height: 1.15 !important;
            font-weight: 850 !important;
            margin-bottom: 12px !important;
        }

        .mega-text,
        .mega-right-text {
            font-size: 14.5px !important;
            line-height: 1.5 !important;
            font-weight: 450 !important;
            margin-bottom: 28px !important;
        }

        .mega-list-grid {
            gap: 17px 58px !important;
            margin-bottom: 35px !important;
            max-width: 720px !important;
        }

        .mega-list-grid a {
            font-size: 14px !important;
            font-weight: 450 !important;
            line-height: 1.2 !important;
            color: #4b5563 !important;
            text-decoration: none;
            text-underline-offset: 5px;
            text-decoration-thickness: 2px;
        }

        .mega-list-grid a:hover {
            color: #ec4899 !important;
            text-decoration: underline !important;
            transform: translateX(2px);
        }

        .mega-view-all {
            font-size: 15px !important;
            font-weight: 900 !important;
            color: #ec4899 !important;
        }

        .mega-view-all:hover {
            color: #db2777 !important;
            text-decoration: underline !important;
        }

        .mega-preview-img {
            width: min(335px, 76%) !important;
            height: 230px !important;
            margin-bottom: 26px !important;
        }

        .mega-build-btn {
            width: min(275px, 86%) !important;
            min-height: 48px !important;
            font-size: 16px !important;
            border-radius: 12px !important;
        }

        @media (max-width: 1400px) {
            .mega-inner {
                min-height: 425px !important;
            }

            .mega-left {
                padding: 32px 38px 30px 44px !important;
            }

            .mega-right {
                padding: 32px 38px 30px !important;
            }

            .mega-title,
            .mega-right-title {
                font-size: 20px !important;
            }

            .mega-text,
            .mega-right-text {
                font-size: 13.5px !important;
            }

            .mega-list-grid a {
                font-size: 13.5px !important;
            }

            .mega-preview-img {
                width: min(305px, 74%) !important;
                height: 205px !important;
            }
        }


        /* Navbar active tab without arrows */
        .main-nav-link {
            position: relative;
            color: #111827;
        }

        .main-nav-link:hover {
            color: #ec4899 !important;
        }

        .main-nav-link:hover::after,
        .main-nav-link.active-tab::after,
        .main-nav-link.active-mega::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 2px;
            height: 2px;
            border-radius: 999px;
            background: #ec4899;
        }

        .main-nav-link.active-tab,
        .main-nav-link.active-mega {
            color: #ec4899 !important;
        }

        #resumeExamplesTrigger.active-mega::after {
            background: #ec4899 !important;
        }


        /* Final hero alignment + button sizing + trusted line placement */
        .front-hero {
            max-width: 1660px !important;
            grid-template-columns: minmax(560px, 0.92fr) minmax(650px, 1.08fr) !important;
            column-gap: 50px !important;
            align-items: center !important;
            padding-top: 34px !important;
            padding-bottom: 18px !important;
        }

        .hero-video-wrap {
            transform: translateX(-62px) translateY(-6px) !important;
            justify-content: flex-start !important;
        }

        .hero-video-shell {
            max-width: 690px !important;
            margin-left: 0 !important;
        }

        .hero-video-card {
            box-shadow: none !important;
            border: 0 !important;
            background: transparent !important;
            border-radius: 0 !important;
            transform: none !important;
        }

        .hero-video-card:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        .hero-video-glow {
            display: none !important;
        }

        .hero-copy {
            padding-left: 18px !important;
            transform: translateY(-8px) !important;
        }

        .hero-title-fixed {
            font-size: clamp(48px, 4.2vw, 72px) !important;
            line-height: 1.12 !important;
            margin-bottom: 46px !important;
            max-width: 760px !important;
        }

        .hero-copy-text {
            font-size: clamp(18px, 1.28vw, 24px) !important;
            line-height: 1.45 !important;
            max-width: 820px !important;
            margin-bottom: 34px !important;
        }

        .hero-actions {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 24px !important;
            max-width: 900px !important;
            margin-bottom: 38px !important;
        }

        .hero-primary-btn,
        .hero-secondary-btn {
            min-height: 64px !important;
            height: 64px !important;
            width: 100% !important;
            min-width: 0 !important;
            border-radius: 14px !important;
            white-space: nowrap !important;
            flex: 1 1 0 !important;
            font-size: clamp(17px, 1.25vw, 23px) !important;
            letter-spacing: 0.06em !important;
            padding: 0 28px !important;
        }

        .hero-secondary-btn i {
            margin-right: 12px !important;
        }

        .hero-stats {
            margin-top: 0 !important;
            margin-bottom: 36px !important;
            padding-top: 0 !important;
            border-top: 0 !important;
        }

        .hero-trusted-inline {
            margin-top: 18px;
            max-width: 820px;
            overflow: hidden;
        }

        .hero-trusted-title {
            font-size: 24px;
            line-height: 1.1;
            font-weight: 900;
            color: #111827;
            margin-bottom: 12px;
        }

        .hero-trusted-window {
            width: 100%;
            overflow: hidden;
            padding: 4px 0 0;
        }

        .hero-trusted-track {
            display: flex;
            align-items: center;
            gap: 42px;
            width: max-content;
            animation: trustedMarquee 22s linear infinite;
        }

        .hero-trusted-window:hover .hero-trusted-track {
            animation-play-state: paused;
        }

        .hero-trusted-item {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            font-size: 24px;
            font-weight: 900;
            color: #111827;
            opacity: 0.92;
        }

        .trusted-marquee-section {
            display: none !important;
        }

        .mega-build-btn:hover {
            background: #fb7b52 !important;
            border-color: #fb7b52 !important;
            color: #ffffff !important;
            transform: translateY(-3px) scale(1.02) !important;
            box-shadow: 0 18px 38px rgba(251, 123, 82, 0.28) !important;
        }

        @media (max-width: 1100px) {
            .front-hero {
                grid-template-columns: 1fr !important;
                padding-top: 46px !important;
            }

            .hero-video-wrap {
                transform: none !important;
                justify-content: center !important;
            }

            .hero-video-shell {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .hero-copy {
                padding-left: 0 !important;
                text-align: center !important;
            }

            .hero-title-fixed,
            .hero-copy-text,
            .hero-trusted-inline {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .hero-actions {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .hero-stats {
                justify-content: center !important;
            }
        }

        @media (max-width: 720px) {
            .hero-actions {
                flex-direction: column !important;
            }

            .hero-primary-btn,
            .hero-secondary-btn {
                width: 100% !important;
                flex: none !important;
                font-size: 16px !important;
            }
        }


        /* Final right-side spacing + visible button borders */
        .hero-title-fixed {
            margin-bottom: 24px !important;
        }

        .hero-copy-text {
            margin-bottom: 30px !important;
        }

        .hero-actions {
            gap: 22px !important;
        }

        .hero-primary-btn,
        .hero-secondary-btn {
            border-radius: 14px !important;
            border-width: 2px !important;
            border-style: solid !important;
            min-height: 64px !important;
            height: 64px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .hero-primary-btn {
            border-color: #fb7b52 !important;
            background: linear-gradient(90deg, #fb7b22 0%, #ef3f75 100%) !important;
            color: #ffffff !important;
        }

        .hero-primary-btn:hover {
            border-color: #f97316 !important;
            background: linear-gradient(90deg, #f97316 0%, #ec4899 100%) !important;
            color: #ffffff !important;
        }

        .hero-secondary-btn {
            border-color: #ff8b6f !important;
            background: #ffffff !important;
            color: #ef5f4f !important;
        }

        .hero-secondary-btn:hover {
            border-color: #fb7b52 !important;
            background: #fff7f3 !important;
            color: #f97316 !important;
        }

        @media (max-width: 1100px) {
            .hero-title-fixed {
                margin-bottom: 20px !important;
            }
        }


        /* Final requested hero fixes: gap/buttons/video/native overlay/navbar button */
        .site-navbar {
            overflow: visible !important;
        }

        .nav-cta {
            min-width: 210px !important;
            max-width: 230px !important;
            height: 54px !important;
            padding: 0 22px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            line-height: 1 !important;
            font-size: 17px !important;
        }

        .front-hero {
            max-width: 1680px !important;
            grid-template-columns: minmax(600px, 0.95fr) minmax(670px, 1.05fr) !important;
            column-gap: 18px !important;
            padding-top: 26px !important;
            padding-bottom: 12px !important;
        }

        .hero-video-wrap {
            transform: translateX(-72px) translateY(-2px) !important;
            justify-content: flex-start !important;
        }

        .hero-video-shell {
            max-width: 710px !important;
            margin-left: 0 !important;
        }

        .hero-video-card {
            box-shadow: none !important;
            border: 0 !important;
            background: transparent !important;
            border-radius: 0 !important;
            transform: none !important;
            overflow: visible !important;
        }

        .hero-video-card:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        .hero-video-glow {
            display: none !important;
        }

        .hero-video {
            pointer-events: none !important;
            user-select: none !important;
        }

        .hero-copy {
            padding-left: 0 !important;
            transform: translateY(-6px) !important;
            overflow: visible !important;
        }

        .hero-copy .inline-block.bg-purple-100 {
            display: none !important;
        }

        .hero-title-fixed {
            margin-bottom: 22px !important;
            max-width: 840px !important;
        }

        .hero-copy-text {
            max-width: 940px !important;
            margin-bottom: 30px !important;
        }

        .hero-actions {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
            gap: 28px !important;
            max-width: 960px !important;
            width: 100% !important;
            margin-bottom: 38px !important;
            overflow: visible !important;
        }

        .hero-primary-btn,
        .hero-secondary-btn {
            min-height: 76px !important;
            height: 76px !important;
            width: 100% !important;
            max-width: none !important;
            border-radius: 16px !important;
            border-width: 2px !important;
            border-style: solid !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            line-height: 1 !important;
            font-size: clamp(17px, 1.12vw, 22px) !important;
            font-weight: 850 !important;
            letter-spacing: 0.08em !important;
            padding: 0 22px !important;
            box-sizing: border-box !important;
        }

        .hero-primary-btn {
            border-color: #fb7b52 !important;
            background: linear-gradient(90deg, #fb7b22 0%, #ef3f75 100%) !important;
            color: #ffffff !important;
        }

        .hero-secondary-btn {
            border-color: #ff7a60 !important;
            background: #ffffff !important;
            color: #ef5f4f !important;
        }

        .hero-secondary-btn i {
            margin-right: 12px !important;
            color: #ef5f4f !important;
        }

        .hero-stats {
            padding-top: 0 !important;
            border-top: 0 !important;
            margin-bottom: 32px !important;
        }

        .hero-trusted-inline {
            max-width: 940px !important;
            margin-top: 0 !important;
        }

        .trusted-marquee-section {
            display: none !important;
        }

        @media (max-width: 1280px) {
            .front-hero {
                grid-template-columns: minmax(520px, 0.95fr) minmax(570px, 1.05fr) !important;
                column-gap: 14px !important;
            }

            .hero-video-wrap {
                transform: translateX(-42px) translateY(0) !important;
            }

            .hero-actions {
                gap: 20px !important;
            }

            .hero-primary-btn,
            .hero-secondary-btn {
                min-height: 66px !important;
                height: 66px !important;
                font-size: 16px !important;
                letter-spacing: 0.06em !important;
            }
        }

        @media (max-width: 1100px) {
            .front-hero {
                grid-template-columns: 1fr !important;
            }

            .hero-video-wrap {
                transform: none !important;
                justify-content: center !important;
            }

            .hero-copy {
                text-align: center !important;
            }

            .hero-actions {
                margin-left: auto !important;
                margin-right: auto !important;
            }
        }

        @media (max-width: 720px) {
            .hero-actions {
                grid-template-columns: 1fr !important;
            }
        }


        /* Final text + lower animated brand line */
        .hero-copy-text {
            font-size: clamp(15px, 1.02vw, 18px) !important;
            line-height: 1.55 !important;
            max-width: 700px !important;
            margin-bottom: 26px !important;
            color: #4b5563 !important;
        }

        .hero-stats {
            margin-bottom: 20px !important;
        }

        .hero-brand-flow {
            position: relative;
            width: min(760px, 100%);
            height: 58px;
            overflow: hidden;
            margin-top: 4px;
            isolation: isolate;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 12%, #000 78%, transparent 100%);
            mask-image: linear-gradient(90deg, transparent 0%, #000 12%, #000 78%, transparent 100%);
        }

        .hero-brand-flow::before {
            content: "Subscribers have been hired by: *";
            display: block;
            font-size: 18px;
            line-height: 1;
            font-weight: 850;
            color: #111827;
            margin-bottom: 12px;
        }

        .hero-brand-mask {
            position: absolute;
            left: -18%;
            top: 22px;
            width: 28%;
            height: 34px;
            z-index: 3;
            background: linear-gradient(90deg, #ffffff 0%, rgba(255,255,255,0.82) 55%, rgba(255,255,255,0) 100%);
            pointer-events: none;
        }

        .hero-brand-track {
            display: flex;
            align-items: center;
            gap: 38px;
            width: max-content;
            animation: heroBrandMove 18s linear infinite;
            will-change: transform;
        }

        .hero-brand-flow:hover .hero-brand-track {
            animation-play-state: paused;
        }

        .hero-brand-track span {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            color: #111827;
            font-size: clamp(19px, 1.55vw, 28px);
            line-height: 1;
            font-weight: 900;
            opacity: 0.96;
            letter-spacing: -0.04em;
        }

        @keyframes heroBrandMove {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        @media (max-width: 1100px) {
            .hero-brand-flow {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-copy-text {
                max-width: 620px !important;
            }
        }


        /* Final brand line clean-no-blur + tighter gap */
        .hero-stats {
            margin-bottom: 8px !important;
        }

        .hero-brand-flow {
            position: relative !important;
            width: min(760px, 100%) !important;
            height: 52px !important;
            overflow: hidden !important;
            margin-top: -2px !important;
            isolation: isolate !important;
            -webkit-mask-image: none !important;
            mask-image: none !important;
        }

        .hero-brand-flow::before {
            content: "Subscribers have been hired by: *";
            display: block;
            font-size: 18px;
            line-height: 1;
            font-weight: 850;
            color: #111827;
            margin-bottom: 8px !important;
        }

        .hero-brand-mask {
            display: none !important;
        }

        .hero-brand-track {
            display: flex !important;
            align-items: center !important;
            gap: 38px !important;
            width: max-content !important;
            animation: heroBrandMove 18s linear infinite !important;
            will-change: transform;
        }

        .hero-brand-track span {
            display: inline-flex !important;
            align-items: center !important;
            white-space: nowrap !important;
            color: #111827 !important;
            font-size: clamp(18px, 1.45vw, 26px) !important;
            line-height: 1 !important;
            font-weight: 900 !important;
            opacity: 1 !important;
            letter-spacing: -0.04em !important;
        }

        @keyframes heroBrandMove {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        .trusted-marquee-section {
            display: none !important;
        }


        /* Final brand line font + two paragraph block */
        .hero-brand-flow {
            width: min(820px, 100%) !important;
            height: auto !important;
            min-height: 78px !important;
            overflow: hidden !important;
            margin-top: -4px !important;
            margin-bottom: 18px !important;
            -webkit-mask-image: none !important;
            mask-image: none !important;
        }

        .hero-brand-flow::before {
            content: "Subscribers have been hired by: *";
            display: block;
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 21px !important;
            line-height: 1.1 !important;
            font-weight: 800 !important;
            color: #111827 !important;
            margin-bottom: 11px !important;
            letter-spacing: 0 !important;
        }

        .hero-brand-mask {
            display: none !important;
        }

        .hero-brand-track {
            display: flex !important;
            align-items: center !important;
            gap: 34px !important;
            width: max-content !important;
            animation: heroBrandMove 18s linear infinite !important;
            will-change: transform !important;
        }

        .hero-brand-track span {
            display: inline-flex !important;
            align-items: center !important;
            white-space: nowrap !important;
            color: #111827 !important;
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: clamp(18px, 1.35vw, 24px) !important;
            line-height: 1 !important;
            font-weight: 800 !important;
            opacity: 1 !important;
            letter-spacing: -0.03em !important;
        }

        .hero-brand-track span:nth-child(3n),
        .hero-brand-track span:nth-child(5n) {
            font-family: Georgia, 'Times New Roman', serif !important;
            font-weight: 700 !important;
            letter-spacing: -0.06em !important;
        }

        .hero-brand-track span i {
            font-size: 25px !important;
        }

        .hero-info-paragraphs {
            width: min(1280px, calc(100vw - 48px));
            margin-top: 18px;
            color: #111827;
            font-family: Arial, Helvetica, sans-serif;
            font-size: clamp(17px, 1.15vw, 21px);
            line-height: 1.55;
            font-weight: 400;
        }

        .hero-info-paragraphs p {
            margin: 0 0 34px;
        }

        .hero-info-paragraphs a {
            color: #111827;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        @media (max-width: 1100px) {
            .hero-info-paragraphs {
                margin-left: auto;
                margin-right: auto;
                text-align: left;
            }
        }


        /* Final paragraphs under video + clean brand typography */
        .front-hero {
            align-items: start !important;
            padding-bottom: 8px !important;
        }

        .hero-video-wrap {
            transform: translateX(-72px) translateY(-8px) !important;
            align-self: start !important;
        }

        .hero-copy {
            transform: translateY(-8px) !important;
            align-self: start !important;
        }

        .hero-brand-flow {
            width: min(820px, 100%) !important;
            margin-top: -4px !important;
            margin-bottom: 0 !important;
        }

        .hero-brand-track span {
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: clamp(18px, 1.35vw, 24px) !important;
            font-weight: 850 !important;
            letter-spacing: -0.02em !important;
            opacity: 1 !important;
        }

        .hero-brand-track span:nth-child(3n),
        .hero-brand-track span:nth-child(5n) {
            font-family: Arial, Helvetica, sans-serif !important;
            font-weight: 850 !important;
            letter-spacing: -0.02em !important;
        }

        .hero-info-paragraphs-full {
            grid-column: 1 / -1;
            width: min(1540px, calc(100vw - 54px));
            margin: -4px auto 0;
            padding-left: 0;
            color: #111827;
            font-family: Arial, Helvetica, sans-serif;
            font-size: clamp(17px, 1.12vw, 21px);
            line-height: 1.55;
            font-weight: 400;
            text-align: left;
        }

        .hero-info-paragraphs-full p {
            margin: 0 0 28px;
        }

        .hero-info-paragraphs-full a {
            color: #111827;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        @media (min-width: 1200px) {
            .hero-info-paragraphs-full {
                width: min(1560px, calc(100vw - 48px));
                margin-top: -2px;
            }
        }

        @media (max-width: 1100px) {
            .hero-video-wrap {
                transform: none !important;
            }

            .hero-info-paragraphs-full {
                width: min(92vw, 720px);
                margin-top: 18px;
            }
        }



        /* GHOST FINAL RESUME TEMPLATES POPUP ONLY - background matched with template image + normal image size */
        #resumeTemplatesMegaPanel .mega-right {
            background:
                radial-gradient(circle at 80% 78%, rgba(244, 154, 145, 0.34), transparent 46%),
                linear-gradient(135deg, #ffffff 0%, #fff5ef 34%, #f6d4c4 66%, #f4b8b1 100%) !important;
            border-left: 1px solid rgba(244, 184, 177, 0.35) !important;
        }

        #resumeTemplatesMegaPanel .mega-preview-img {
            width: min(335px, 76%) !important;
            height: 230px !important;
            object-fit: contain !important;
            margin: 0 auto 26px !important;
            filter: drop-shadow(0 18px 26px rgba(15, 23, 42, 0.12)) !important;
            background: transparent !important;
        }

        #resumeTemplatesMegaPanel .mega-right-text {
            margin-bottom: 20px !important;
        }

        #resumeTemplatesMegaPanel .mega-build-btn {
            margin-top: 0 !important;
        }

        @media (max-width: 1400px) {
            #resumeTemplatesMegaPanel .mega-preview-img {
                width: min(305px, 74%) !important;
                height: 205px !important;
                margin-bottom: 26px !important;
            }
        }
        /* --- ADD THIS TO YOUR <style> TAG --- */

/* Responsive Mobile Menu Fix */
@media (max-width: 1060px) {
    /* Hide desktop menu items completely */
    .site-nav-menu {
        display: none !important;
    }
    
    /* Ensure navbar container handles mobile elements properly */
    .site-navbar-inner {
        justify-content: space-between;
    }

    /* Style the hamburger button */
    .mobile-menu-btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        background: transparent;
        border: none;
        color: #111827;
        font-size: 24px;
        cursor: pointer;
        transition: color 0.2s;
    }

    .mobile-menu-btn:hover {
        color: #ec4899;
    }

    /* Keep CTA visible on larger mobile screens if needed, or hide on very small */
    @media (max-width: 640px) {
        .nav-cta {
            display: none !important;
        }
    }
}

/* Hide mobile button on desktop */
@media (min-width: 1061px) {
    .mobile-menu-btn {
        display: none !important;
    }
}

/* Mobile Menu Overlay Styles */
.mobile-menu-overlay {
    position: fixed;
    top: 0;
    right: -100%;
    width: 80%;
    max-width: 400px;
    height: 100vh;
    background: #ffffff;
    z-index: 10000;
    box-shadow: -10px 0 30px rgba(0,0,0,0.1);
    transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}

.mobile-menu-overlay.open {
    right: 0;
}

.mobile-menu-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, visibility 0.3s;
    backdrop-filter: blur(4px);
}

.mobile-menu-backdrop.open {
    opacity: 1;
    visibility: visible;
}

.mobile-menu-header {
    padding: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f1f5f9;
}

.mobile-menu-close {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #f1f5f9;
    border: none;
    color: #475569;
    font-size: 18px;
    cursor: pointer;
}

.mobile-menu-content {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.mobile-nav-link {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    text-decoration: none;
    padding: 12px 0;
    border-bottom: 1px solid #f8fafc;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mobile-nav-link i {
    font-size: 14px;
    color: #94a3b8;
}

.mobile-nav-cta {
    margin-top: 24px;
    background: linear-gradient(90deg, #fb7b22 0%, #ef3f75 100%);
    color: white;
    text-align: center;
    padding: 16px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 18px;
    text-decoration: none;
}
/* ==========================================================================
   FINAL MOBILE RESPONSIVE FIXES (ADMIN & USER PORTAL FIXED)
   ========================================================================== */
@media (max-width: 768px) {
    
    /* 1. ADMIN SECURE PORTAL: Layout barkarar, Scrollbar mukammal khatam */
    #adminCardFrame, 
    .admin-card-container,
    [id*="adminModal"] {
        max-height: 95vh !important;
        overflow-y: auto !important;
        width: 92% !important;
        max-width: 380px !important;
        margin: auto !important;
        padding: 16px 20px !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: flex-start !important;
        /* Browser default scrollbars ko hide karne ke liye */
        -ms-overflow-style: none !important;  /* IE/Edge */
        scrollbar-width: none !important;  /* Firefox */
    }

    /* Admin ki scrollbar line ko Chrome/Safari se remove karne ke liye */
    #adminCardFrame::-webkit-scrollbar, 
    .admin-card-container::-webkit-scrollbar,
    [id*="adminModal"]::-webkit-scrollbar {
        display: none !important;
    }

    /* Admin picture aur text adjustments */
    #adminCardFrame img, 
    .admin-modal-img-container img {
        max-height: 110px !important;
        object-fit: contain !important;
        margin: 0 auto 8px auto !important;
    }

    #adminCardFrame h2, #adminCardFrame h3, .admin-form-container h2 {
        font-size: 20px !important;
        margin-bottom: 4px !important;
        text-align: center !important;
    }

    #adminCardFrame p, .admin-form-container p {
        font-size: 13px !important;
        margin-bottom: 12px !important;
        text-align: center !important;
    }

    #adminCardFrame .space-y-4 > *, #adminCardFrame .space-y-6 > * {
        margin-top: 10px !important;
        margin-bottom: 10px !important;
    }

    #adminCardFrame input {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
        font-size: 14px !important;
    }
}
/* ==========================================================================
   COMPLETE FORCEFUL MOBILE RESPONSIVE RESET (MODALS & DROPDOWNS)
   ========================================================================== */
@media (max-width: 768px) {
    
    /* 1. ADMIN DASHBOARD DROPDOWN OVERFLOW FIX */
    /* Dropdown ko mobile screen ke andar bound rakhne ke liye rule */
    div[class*="absolute"][class*="right-"], 
    div[class*="absolute"][class*="left-"],
    .admin-dashboard-dropdown,
    [id*="dropdown-menu"],
    [class*="dropdown-content"] {
        right: 12px !important;
        left: auto !important;
        transform: none !important;
        width: calc(100vw - 32px) !important;
        max-width: 250px !important;
        z-index: 99999 !important;
    }

    /* 2. USER LOGIN / REGISTER POPUP COMPLETE CLEANUP */
    /* White panel card ko fully responsive dynamic rounded modal banana */
    div[id*="modal"] > div, 
    div[id*="Modal"] > div,
    [class*="modal-content"],
    .login-card-frame {
        display: flex !important;
        flex-direction: column !important;
        width: 94% !important;
        max-width: 375px !important;
        max-height: 88vh !important;
        margin: auto !important;
        padding: 20px 16px !important;
        border-radius: 20px !important;
        overflow-y: auto !important;
        box-sizing: border-box !important;
        background: #ffffff !important;
        
        /* Scrollbar track ko completely invisible karne ke liye */
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }

    /* Webkit track line hide karne ke liye */
    div[id*="modal"] > div::-webkit-scrollbar,
    div[id*="Modal"] > div::-webkit-scrollbar,
    .login-card-frame::-webkit-scrollbar {
        display: none !important;
    }

    /* DESKTOP 2-COLUMN GRID SYSTEM RESET */
    /* Tailwind ke `grid-cols-2` ya split panels ko vertical line me lane ke liye */
    div[id*="modal"] .grid, 
    div[id*="Modal"] .grid,
    div[id*="modal"] [class*="grid-cols-"],
    div[id*="Modal"] [class*="grid-cols-"] {
        grid-template-columns: 1fr !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 0 !important;
        width: 100% !important;
    }

    /* EXTRA TEXT BLOCKS REMOVE (HIDE) FOR MOBILE */
    /* Features list box, bullets, paragraphs aur side text details ko hide karna */
    div[id*="modal"] p:not(.uppercase):not([class*="text-center"]),
    div[id*="Modal"] p:not(.uppercase):not([class*="text-center"]),
    div[id*="modal"] h3,
    div[id*="Modal"] h3,
    div[id*="modal"] .flex.items-start,
    div[id*="Modal"] .flex.items-start,
    div[id*="modal"] div[class*="border-2"],
    div[id*="Modal"] div[class*="border-2"],
    div[id*="modal"] span:not([class*="text-"]),
    div[id*="Modal"] span:not([class*="text-"]) {
        display: none !important;
    }

    /* MAIN TITLE HEADINGS ALIGNMENT */
    div[id*="modal"] h2, 
    div[id*="Modal"] h2 {
        font-size: 22px !important;
        text-align: center !important;
        font-weight: 800 !important;
        margin: 4px 0 12px 0 !important;
        width: 100% !important;
        display: block !important;
        line-height: 1.2 !important;
        color: #111827 !important;
    }

    /* VECTOR ILLUSTRATION IMAGE CONTROL */
    /* Image ko top par center rakhna aur size limit karna taake fields visible hon */
    div[id*="modal"] img, 
    div[id*="Modal"] img {
        max-height: 100px !important;
        width: auto !important;
        object-fit: contain !important;
        margin: 0 auto 12px auto !important;
        display: block !important;
    }

    /* FORM & INPUT FIELD RESPONSIVENESS */
    div[id*="modal"] form,
    div[id*="Modal"] form {
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        display: block !important;
    }

    div[id*="modal"] input,
    div[id*="Modal"] input {
        width: 100% !important;
        padding: 10px 14px !important;
        font-size: 14px !important;
        border-radius: 8px !important;
        margin-bottom: 6px !important;
        box-sizing: border-box !important;
    }

    /* SUBMIT CTA BUTTON FULL WIDTH & CURVE */
    div[id*="modal"] button[type="submit"],
    div[id*="Modal"] button[type="submit"] {
        width: 100% !important;
        padding: 11px !important;
        font-size: 15px !important;
        border-radius: 9999px !important;
        margin-top: 8px !important;
    }
}
/* ==========================================================================
   PERMANENT MOBILE ACCESS & MODAL OVERRIDE LAYER (PIXEL 7 & RESPONSIVE)
   ========================================================================== */
@media screen and (max-width: 1024px) {

    /* Forcefully hiding the 3 points feature lists & vector image on mobile */
    div[id*="modal"] .flex.items-start,
    div[id*="Modal"] .flex.items-start,
    div[id*="modal"] ul li,
    div[id*="Modal"] ul li,
    .secure-guided-live-points,
    ul.space-y-4,
    div.space-y-4,
    div[id*="modal"] img,
    div[id*="Modal"] img,
    .login-card-frame img,
    .mega-left {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    /* Keep the whole popup frame bounded inside the mobile screen view */
    div[id*="modal"] > div, 
    div[id*="Modal"] > div,
    [class*="modal-content"],
    .login-card-frame {
        max-height: 85vh !important;
        width: 92% !important;
        max-width: 412px !important; /* Fixed viewport reference for Pixel 7 */
        padding: 16px 14px !important;
        overflow-y: auto !important;
        display: flex !important;
        flex-direction: column !important;
        box-sizing: border-box !important;
    }

    /* Scaling down big heading tags so they don't break rows */
    div[id*="modal"] h1, div[id*="Modal"] h1,
    div[id*="modal"] h2, div[id*="Modal"] h2,
    .text-2xl, .text-3xl, .text-4xl, .hero-title-fixed {
        font-size: 19px !important;
        line-height: 1.25 !important;
        margin-top: 2px !important;
        margin-bottom: 6px !important;
        text-align: center !important;
        white-space: normal !important;
    }

    div[id*="modal"] p, div[id*="Modal"] p,
    .text-base, .text-sm {
        font-size: 12.5px !important;
        line-height: 1.35 !important;
        margin-bottom: 10px !important;
        text-align: center !important;
    }

    /* Inputs box sizing structure layout */
    div[id*="modal"] form, div[id*="Modal"] form {
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
        width: 100% !important;
    }

    div[id*="modal"] input, div[id*="Modal"] input,
    input[type="email"], input[type="password"] {
        width: 100% !important;
        max-width: 100% !important;
        height: 42px !important;
        min-height: 42px !important;
        padding: 6px 12px !important;
        font-size: 14px !important;
        box-sizing: border-box !important;
    }

    div[id*="modal"] label, div[id*="Modal"] label {
        font-size: 12px !important;
        display: block !important;
        text-align: left !important;
    }

    /* Fixing Buttons from going out of bounds */
    button[type="submit"],
    div[id*="modal"] button,
    .hero-primary-btn {
        width: 100% !important;
        max-width: 100% !important;
        min-height: 44px !important;
        height: 44px !important;
        font-size: 14px !important;
        box-sizing: border-box !important;
    }

    /* Split grids fallback to vertical block stacking */
    div.grid.grid-cols-2 {
        grid-template-columns: 1fr !important;
        gap: 8px !important;
        width: 100% !important;
    }
}

</style> 
</head> 
<body id="topViewAnchor" class="bg-white text-gray-800 font-sans antialiased min-h-screen flex flex-col justify-between overflow-y-auto custom-scrollbar"> 

<div class="bg-gray-900 text-white text-sm text-center py-2 px-4 flex justify-center items-center gap-4"> 
    <span class="bg-pink-500 text-white text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">Updated</span> 
    <p>Our new Professional Resume Reviewer is now live! <a href="/register" class="underline font-bold hover:text-pink-400">Try it for free today.</a></p> 
</div> 

<nav class="site-navbar w-full bg-white/95 backdrop-blur-md border-b py-4 sticky top-0 z-50 shadow-sm transition-all px-5 xl:px-8 2xl:px-12">
    <div class="site-navbar-inner relative">

        <div class="site-logo-wrap flex items-center relative select-none shrink-0">
            <div id="triggerAdminToggle" onclick="handleLogoIconClick(event)" class="cursor-pointer p-1.5 text-2xl text-purple-600 hover:text-pink-500 transition-colors duration-200 mr-2">
                <i id="logoIconNode" class="fa-solid fa-layer-group logo-rotate"></i>
            </div>
            <div onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="site-logo-text font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500 tracking-tight flex items-center cursor-pointer">
                Resume Builder
            </div>
        </div>

        <div class="site-nav-menu hidden xl:flex">
            <div class="group relative cursor-pointer">
                <span class="main-nav-link">Resume Builder App</span>
                <div class="absolute top-10 left-1/2 -translate-x-1/2 bg-white border border-gray-100 shadow-xl rounded-xl p-4 hidden group-hover:block w-60 text-sm font-bold z-50">
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">Start Building</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">Builder Features</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">How It Works</a>
                </div>
            </div>

            <div id="resumeExamplesNavItem" class="mega-nav-item cursor-pointer">
                <button type="button" id="resumeExamplesTrigger" class="main-nav-link">
                    Resume Examples
                </button>
            </div>

            <div id="resumeTemplatesNavItem" class="mega-nav-item cursor-pointer">
                <button type="button" id="resumeTemplatesTrigger" class="main-nav-link">
                    Resume Templates
                </button>
            </div>

            <div class="group relative cursor-pointer">
                <span class="main-nav-link">Cover Letter Builder</span>
                <div class="absolute top-10 left-1/2 -translate-x-1/2 bg-white border border-gray-100 shadow-xl rounded-xl p-4 hidden group-hover:block w-60 text-sm font-bold z-50">
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">Create Cover Letter</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">Cover Letter Examples</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">Cover Letter Tips</a>
                </div>
            </div>

            <div class="group relative cursor-pointer">
                <span class="main-nav-link">Career Center</span>
                <div class="absolute top-10 left-1/2 -translate-x-1/2 bg-white border border-gray-100 shadow-xl rounded-xl p-4 hidden group-hover:block w-60 text-sm font-bold z-50">
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">Career FAQs</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">Resume Tips</a>
                    <a href="#" class="block py-2 text-gray-600 hover:text-purple-600 transition">Pricing Guide</a>
                </div>
            </div>

            <div class="group relative cursor-pointer">
                <span class="main-nav-link">My Account</span>
                <div class="absolute top-10 left-1/2 -translate-x-1/2 bg-white border border-gray-100 shadow-xl rounded-xl p-4 hidden group-hover:block w-52 text-sm font-bold z-50">
                    <a href="/login" class="block py-2 text-gray-600 hover:text-purple-600 transition">Log in</a>
                    <a href="/register" class="block py-2 text-gray-600 hover:text-purple-600 transition">Create Account</a>
                    <button type="button" onclick="handleLogoIconClick(event)" class="block w-full text-left py-2 text-gray-600 hover:text-purple-600 transition font-bold">Admin Portal</button>
                </div>
            </div>
        </div>

        <div class="flex items-center shrink-0">
            <a href="/register" class="nav-cta border border-orange-300 text-orange-500 rounded-xl font-black shadow-sm hover:shadow-lg hover:-translate-y-0.5 hover:bg-orange-50 transition transform tracking-wide">
                Build My Resume
            </a>
        </div>

    </div>
</nav> 

<div id="resumeExamplesMegaPanel" class="nav-mega-panel">
    <div class="mega-inner">
        <div class="mega-left">
            <h3 class="mega-title">Top Resume Examples</h3>
            <p class="mega-text">
                Choose from tailored resume examples for every profession and experience level.
                Click on any category to explore resumes designed to showcase your skills and land your dream job.
            </p>

            <div class="mega-list-grid">
                <a href="#">Teacher Resumes</a>
                <a href="#">Sales Resumes</a>
                <a href="#">Customer Service Resumes</a>
                <a href="#">Data Analyst Resumes</a>
                <a href="#">Nursing Resumes</a>
                <a href="#">Project Manager Resumes</a>
                <a href="#">Software Engineer Resumes</a>
                <a href="#">Marketing Resumes</a>
                <a href="#">Server Resumes</a>
                <a href="#">Accountant Resumes</a>
            </div>

            <a href="#" class="mega-view-all">View all 503 Resume Examples <span>→</span></a>
        </div>

        <div class="mega-right">
            <h3 class="mega-right-title">Download resume templates</h3>
            <p class="mega-right-text">
                Get a head start on your next resume. Check out our resume templates and build
                a professional resume that reflects your career goals.
            </p>

            <img src="/images/resume-examples-menu.png" alt="Resume templates preview" class="mega-preview-img">

            <a href="/register" class="mega-build-btn">Build My Resume</a>
        </div>
    </div>
</div>

<div id="resumeTemplatesMegaPanel" class="nav-mega-panel">
    <div class="mega-inner">
        <div class="mega-left">
            <h3 class="mega-title">Top Resume Templates</h3>
            <p class="mega-text">
                Browse our top-rated resume templates tailored for every profession and career stage.
                Find the perfect design to match your style and career aspirations.
            </p>

            <div class="mega-list-grid">
                <a href="#">Functional Resume Templates</a>
                <a href="#">Basic and Simple Resume Templates</a>
                <a href="#">Combination Resume Templates</a>
                <a href="#">Modern Resume Templates</a>
                <a href="#">General Resume Templates</a>
                <a href="#">Reverse-Chronological Resume Templates</a>
                <a href="#">Hybrid Resume Templates</a>
                <a href="#">Professional Resume Templates</a>
                <a href="#">Skills-Based Resume Templates</a>
                <a href="#">Google Docs Resume Templates</a>
                <a href="#">Traditional Resume Templates</a>
                <a href="#">Word Resume Templates</a>
            </div>

            <a href="#" class="mega-view-all">View all resume templates <span>→</span></a>
        </div>

        <div class="mega-right">
            <h3 class="mega-right-title">Download resume templates</h3>
            <p class="mega-right-text">
                Get a head start on your next resume. Check out our resume templates and build
                a professional resume that reflects your career goals.
            </p>

            <img src="/images/ResumeTemplate (2).png" alt="Resume templates preview" class="mega-preview-img">

            <a href="/register" class="mega-build-btn">Build My Resume</a>
        </div>
    </div>
</div>

<header class="front-hero container mx-auto px-6 border-b border-gray-100">
    <div class="hero-video-wrap relative w-full">
        <div class="hero-video-shell">
            <div class="hero-video-glow"></div>
            <div class="hero-video-card">
                <video class="hero-video" autoplay muted loop playsinline preload="auto" disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback" oncontextmenu="return false;" tabindex="-1">
                    <source src="/videos/front-page-animation.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    <div class="hero-copy z-10">
        <h1 class="hero-title-fixed font-extrabold text-gray-900 leading-tight mb-6 tracking-tight">
            The Best Online <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500">Resume Builder</span>
        </h1>
        <p class="hero-copy-text text-gray-600 mb-8 leading-relaxed max-w-2xl">
            Create a professional resume fast with live preview, clean templates, and easy guided steps.
        </p>
        <div class="hero-actions mb-8">
            <a href="/register" class="hero-primary-btn">
                Create My Resume Now
            </a>
            <a href="#how-it-works" class="hero-secondary-btn">
                <i class="fa-solid fa-cloud-arrow-up"></i> Import Resume
            </a>
        </div>
        <div class="hero-stats flex justify-start space-x-12 pt-6 border-t border-gray-200">
            <div class="text-left">
                <div class="stat-number font-black text-gray-900"><i class="fa-solid fa-arrow-trend-up text-green-500"></i> 38%</div>
                <div class="text-base text-gray-500 mt-1 font-medium">More interviews</div>
            </div>
            <div class="text-left">
                <div class="stat-number font-black text-gray-900"><i class="fa-solid fa-briefcase text-purple-500"></i> 23%</div>
                <div class="text-base text-gray-500 mt-1 font-medium">More likely to get hired</div>
            </div>
        </div>
        <div class="hero-brand-flow">
            <div class="hero-brand-mask"></div>
            <div class="hero-brand-track">
                <span>facebook</span>
                <span>Goldman Sachs</span>
                <span><i class="fa-brands fa-apple"></i></span>
                <span>TESLA</span>
                <span>Google</span>
                <span>amazon</span>
                <span>Deloitte.</span>
                <span>J.P.Morgan</span>
                <span>facebook</span>
                <span>Goldman Sachs</span>
                <span><i class="fa-brands fa-apple"></i></span>
                <span>TESLA</span>
                <span>Google</span>
                <span>amazon</span>
                <span>Deloitte.</span>
                <span>J.P.Morgan</span>
            </div>
</div>
</div>
<br>
<div class="hero-info-paragraphs-full">
    <p>
        Our online resume builder makes it simple to create a professional resume from your phone,
        laptop, or tablet using 30+ customizable resume templates anytime, anywhere.
    </p>
    <p>
        Create a resume using our <a href="#">Resume builder</a> feature, plus take advantage of
        expert suggestions, a built-in resume editor, and customizable modern and professional resume
        templates. <a href="#">Free users</a> have access to our easy-to-use resume creator and TXT file downloads.
    </p>
</div>

</header> 

<section class="trusted-marquee-section">
    <div class="trusted-marquee-track">
        
                <span class="trusted-logo-item"><i class="fa-brands fa-amazon"></i> Amazon</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-microsoft"></i> Microsoft</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-google"></i> Google</span>
                <span class="trusted-logo-item">Deloitte.</span>
                <span class="trusted-logo-item">J.P.Morgan</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-meta"></i> Meta</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-apple"></i> Apple</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-linkedin"></i> LinkedIn</span>

        
                <span class="trusted-logo-item"><i class="fa-brands fa-amazon"></i> Amazon</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-microsoft"></i> Microsoft</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-google"></i> Google</span>
                <span class="trusted-logo-item">Deloitte.</span>
                <span class="trusted-logo-item">J.P.Morgan</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-meta"></i> Meta</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-apple"></i> Apple</span>
                <span class="trusted-logo-item"><i class="fa-brands fa-linkedin"></i> LinkedIn</span>

    </div>
</section> 

<section id="features" class="py-24 bg-white"> 
    <div class="container mx-auto px-6"> 
        <div class="text-center max-w-3xl mx-auto mb-20"> 
            <h2 class="text-purple-600 font-bold tracking-wide uppercase text-sm mb-3">Why Choose Us</h2> 
            <h3 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Everything you need to build a winning resume</h3> 
            <p class="text-xl text-gray-600">We've combined modern UI design with a robust backend to give you an unparalleled resume building experience.</p> 
        </div> 
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10"> 
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 group"> 
                <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 text-3xl mb-6 group-hover:scale-110 transition transform"> <i class="fa-solid fa-file-signature"></i> </div> 
                <h4 class="text-2xl font-bold mb-4 text-gray-900">Ready-to-Use Phrases</h4> 
                <p class="text-gray-600 leading-relaxed">Stuck on what to write? Choose from our verified collection of industry-specific bullet points to make your experience shine manually.</p> 
            </div> 
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 group"> 
                <div class="w-16 h-16 bg-pink-100 rounded-xl flex items-center justify-center text-pink-600 text-3xl mb-6 group-hover:scale-110 transition transform"> <i class="fa-solid fa-desktop"></i> </div> 
                <h4 class="text-2xl font-bold mb-4 text-gray-900">Live Split-Screen Preview</h4> 
                <p class="text-gray-600 leading-relaxed">Watch your document assemble in real-time as you type. No more switching between edit and preview modes.</p> 
            </div> 
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 group"> 
                <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center text-orange-500 text-3xl mb-6 group-hover:scale-110 transition transform"> <i class="fa-solid fa-check-double"></i> </div> 
                <h4 class="text-2xl font-bold mb-4 text-gray-900">Recruiter-Approved Formats</h4> 
                <p class="text-gray-600 leading-relaxed">Our designs are structurally engineered to pass standard HR parameters, ensuring your resume gets reviewed immediately.</p> 
            </div> 
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 group"> 
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-3xl mb-6 group-hover:scale-110 transition transform"> <i class="fa-solid fa-file-pdf"></i> </div> 
                <h4 class="text-2xl font-bold mb-4 text-gray-900">Pixel-Perfect PDF Export</h4> 
                <p class="text-gray-600 leading-relaxed">Download a high-resolution, print-ready PDF instantly without any watermarks or formatting glitches.</p> 
            </div> 
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 group"> 
                <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center text-green-600 text-3xl mb-6 group-hover:scale-110 transition transform"> <i class="fa-solid fa-shield-halved"></i> </div> 
                <h4 class="text-2xl font-bold mb-4 text-gray-900">Bank-Level Security</h4> 
                <p class="text-gray-600 leading-relaxed">Your personal data is encrypted and securely stored in our robust MySQL database using the latest hashing algorithms.</p> 
            </div> 
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 group"> 
                <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center text-red-600 text-3xl mb-6 group-hover:scale-110 transition transform"> <i class="fa-solid fa-mobile-screen"></i> </div> 
                <h4 class="text-2xl font-bold mb-4 text-gray-900">100% Mobile Responsive</h4> 
                <p class="text-gray-600 leading-relaxed">Build, edit, and download your resume entirely from your smartphone while commuting or relaxing at home.</p> 
            </div> 
        </div> 
    </div> 
</section> 

<section class="bg-gray-900 text-white py-20"> 
    <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center gap-16"> 
        <div class="lg:w-1/2"> 
            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Code and Data" class="rounded-2xl shadow-2xl opacity-80 hover:opacity-100 transition"> 
        </div> 
        <div class="lg:w-1/2"> 
            <h2 class="text-4xl font-extrabold mb-6">Pass Corporate Reviews Easily</h2> 
            <p class="text-xl text-gray-400 mb-8 leading-relaxed"> Did you know that most resumes are rejected by unoptimized formatting layouts before a manager ever opens them? </p> 
            <ul class="space-y-6"> 
                <li class="flex items-start"> 
                    <div class="bg-purple-600 p-2 rounded-full mr-4 mt-1"><i class="fa-solid fa-check text-white text-sm"></i></div> 
                    <div> 
                        <h4 class="text-xl font-bold mb-1">Standardized Formatting</h4> 
                        <p class="text-gray-400">Our templates avoid complex unreadable components that confuse screening tools.</p> 
                    </div> 
                </li> 
                <li class="flex items-start"> 
                    <div class="bg-pink-500 p-2 rounded-full mr-4 mt-1"><i class="fa-solid fa-check text-white text-sm"></i></div> 
                    <div> 
                        <h4 class="text-xl font-bold mb-1">Structured Placement</h4> 
                        <p class="text-gray-400">Dedicated skills and summary sections ensure reviewers catch your core competencies instantly.</p> 
                    </div> 
                </li> 
                <li class="flex items-start"> 
                    <div class="bg-orange-400 p-2 rounded-full mr-4 mt-1"><i class="fa-solid fa-check text-white text-sm"></i></div> 
                    <div> 
                        <h4 class="text-xl font-bold mb-1">Readable Layout Layers</h4> 
                        <p class="text-gray-400">Exported PDFs contain clear readable data structures, maintaining total visual clarity.</p> 
                    </div> 
                </li> 
            </ul> 
        </div> 
    </div> 
</section> 

<section id="how-it-works" class="py-24 bg-gray-50"> 
    <div class="container mx-auto px-6"> 
        <div class="text-center mb-16"> 
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Just three easy steps</h2> 
            <p class="text-xl text-gray-600">A streamlined process designed to get you from blank page to job-ready in 10 minutes.</p> 
        </div> 
        <div class="flex flex-col lg:flex-row gap-12 items-center"> 
            <div class="lg:w-1/2 space-y-12"> 
                <div class="flex items-start group"> 
                    <div class="w-14 h-14 bg-white border-2 border-purple-200 text-purple-600 rounded-full flex items-center justify-center text-2xl font-black mr-6 group-hover:bg-purple-600 group-hover:text-white group-hover:border-purple-600 shadow-md transition-all duration-300">1</div> 
                    <div> 
                        <h3 class="text-2xl font-bold mb-3 text-gray-900">Select a template</h3> 
                        <p class="text-gray-600 text-lg leading-relaxed">Choose from our library of professional, recruiter-approved designs. You can change colors and fonts later.</p> 
                    </div> 
                </div> 
                <div class="flex items-start group"> 
                    <div class="w-14 h-14 bg-white border-2 border-pink-200 text-pink-500 rounded-full flex items-center justify-center text-2xl font-black mr-6 group-hover:bg-pink-500 group-hover:text-white group-hover:border-pink-500 shadow-md transition-all duration-300">2</div> 
                    <div> 
                        <h3 class="text-2xl font-bold mb-3 text-gray-900">Build your resume</h3> 
                        <p class="text-gray-600 text-lg leading-relaxed">Use our guided stepper form to input your education, experience, and skills. Watch the live preview update instantly.</p> 
                    </div> 
                </div> 
                <div class="flex items-start group"> 
                    <div class="w-14 h-14 bg-white border-2 border-orange-200 text-orange-500 rounded-full flex items-center justify-center text-2xl font-black mr-6 group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 shadow-md transition-all duration-300">3</div> 
                    <div> 
                        <h3 class="text-2xl font-bold mb-3 text-gray-900">Customize and Download</h3> 
                        <p class="text-gray-600 text-lg leading-relaxed">Fine-tune the details, run a quick spell check, and download your final product as a pristine PDF.</p> 
                    </div> 
                </div> 
                <a href="/register" class="inline-block mt-4 px-10 py-4 bg-gray-900 text-white rounded-md font-bold text-lg hover:bg-gray-800 transition">Start Building -></a> 
            </div> 
            <div class="lg:w-1/2 w-full flex justify-center"> 
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Working on Laptop" class="rounded-2xl shadow-2xl border-8 border-white transform rotate-2 hover:rotate-0 transition duration-500"> 
            </div> 
        </div> 
    </div> 
</section> 

<section id="examples" class="py-24 bg-white"> 
    <div class="container mx-auto px-6 text-center"> 
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Get inspired by expertly crafted templates</h2> 
        <p class="text-xl text-gray-600 mb-16 max-w-3xl mx-auto">Whether you are a fresh graduate or a seasoned executive, we have a layout that perfectly frames your career journey.</p> 
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"> 
            <div class="bg-gray-100 p-3 rounded-lg hover:-translate-y-2 transition duration-300 cursor-pointer shadow-sm hover:shadow-xl group"> 
                <div class="bg-white h-80 rounded border shadow-sm p-4 overflow-hidden relative"> 
                    <div class="w-full h-6 bg-blue-900 rounded mb-4"></div> 
                    <div class="w-12 h-12 bg-gray-300 rounded-full mx-auto mb-4 border-2 border-white -mt-8"></div> 
                    <div class="w-3/4 h-2 bg-gray-200 mx-auto mb-6"></div> 
                    <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                    <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                    <div class="w-5/6 h-1 bg-gray-200 mb-6"></div> 
                    <div class="w-1/2 h-2 bg-blue-900 mb-4"></div> 
                    <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300"> <span class="bg-white text-gray-900 px-4 py-2 rounded font-bold shadow-lg">View Professional</span> </div> 
                </div> 
                <p class="mt-4 font-bold text-gray-800">The Professional</p> 
            </div> 
            <div class="bg-gray-100 p-3 rounded-lg hover:-translate-y-2 transition duration-300 cursor-pointer shadow-sm hover:shadow-xl group"> 
                <div class="bg-white h-80 rounded border shadow-sm p-4 overflow-hidden relative flex"> 
                    <div class="w-1/3 bg-gray-800 h-full p-2"> 
                        <div class="w-full h-8 bg-gray-600 rounded-full mb-4"></div> 
                        <div class="w-full h-1 bg-gray-600 mb-2"></div> 
                    </div> 
                    <div class="w-2/3 p-2"> 
                        <div class="w-full h-4 bg-gray-300 mb-4"></div> 
                        <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                        <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                    </div> 
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300"> <span class="bg-white text-gray-900 px-4 py-2 rounded font-bold shadow-lg">View Modern</span> </div> 
                </div> 
                <p class="mt-4 font-bold text-gray-800">The Modern Split</p> 
            </div> 
            <div class="bg-gray-100 p-3 rounded-lg hover:-translate-y-2 transition duration-300 cursor-pointer shadow-sm hover:shadow-xl group"> 
                <div class="bg-white h-80 rounded border shadow-sm p-4 overflow-hidden relative"> 
                    <div class="w-full h-10 bg-emerald-600 mb-4"></div> 
                    <div class="w-1/2 h-2 bg-emerald-600 mb-4"></div> 
                    <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                    <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                    <div class="w-3/4 h-1 bg-gray-200 mb-6"></div> 
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300"> <span class="bg-white text-gray-900 px-4 py-2 rounded font-bold shadow-lg">View Minimalist</span> </div> 
                </div> 
                <p class="mt-4 font-bold text-gray-800">The Minimalist</p> 
            </div> 
            <div class="bg-gray-100 p-3 rounded-lg hover:-translate-y-2 transition duration-300 cursor-pointer shadow-sm hover:shadow-xl group"> 
                <div class="bg-white h-80 rounded border shadow-sm p-4 overflow-hidden relative text-center"> 
                    <div class="w-20 h-20 border-4 border-rose-500 rounded-full mx-auto mt-4 mb-4"></div> 
                    <div class="w-1/2 h-3 bg-rose-500 mx-auto mb-4"></div> 
                    <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                    <div class="w-full h-1 bg-gray-200 mb-2"></div> 
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300"> <span class="bg-white text-gray-900 px-4 py-2 rounded font-bold shadow-lg">View Creative</span> </div> 
                </div> 
                <p class="mt-4 font-bold text-gray-800">The Creative</p> 
            </div> 
        </div> 
        <button class="mt-12 px-10 py-4 border-2 border-purple-600 text-purple-600 font-bold text-lg rounded-md hover:bg-purple-50 transition">See All 30+ Resume Templates</button> 
    </div> 
</section> 

<section class="py-24 bg-purple-50"> 
    <div class="container mx-auto px-6"> 
        <h2 class="text-4xl md:text-5xl font-extrabold text-center text-gray-900 mb-16">What users say about Resume Builder</h2> 
        <div class="flex justify-center items-center mb-12 bg-white w-fit mx-auto px-8 py-4 rounded-full shadow-md"> <span class="text-xl font-bold mr-4">Excellent</span> <span class="text-green-500 text-2xl tracking-wildest"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-star fa-solid"></i></span> <span class="text-gray-500 ml-4 border-l pl-4 font-medium">14,289 reviews on <i class="fa-solid fa-star text-green-500"></i> Trustpilot</span> </div> 
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"> 
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition"> 
                <div class="flex text-green-500 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div> 
                <h4 class="text-lg font-bold mb-2">Roy went above and beyond</h4> 
                <p class="text-gray-600 mb-6 italic leading-relaxed">"The customer service was great, but the tool itself is magic. I built my resume in 15 minutes and it looks like a graphic designer made it."</p> 
                <div class="text-sm"><span class="font-bold">Barbara A.</span> • 20 hours ago</div> 
            </div> 
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition transition"> 
                <div class="flex text-green-500 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div> 
                <h4 class="text-lg font-bold mb-2">Got me the interview!</h4> 
                <p class="text-gray-600 mb-6 italic leading-relaxed">"Creating my own resume was frustrating in Word. With this builder, the formatting never broke. Landed an interview within a week."</p> 
                <div class="text-sm"><span class="font-bold">MaryAnn C.</span> • 5 days ago</div> 
            </div> 
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition"> 
                <div class="flex text-green-500 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div> 
                <h4 class="text-lg font-bold mb-2">This experience was just fantastic</h4> 
                <p class="text-gray-600 mb-6 italic leading-relaxed">"The built-in phrase suggestions for bullet points were a lifesaver. I didn't know how to format my work history properly until I used this."</p> 
                <div class="text-sm"><span class="font-bold">Grant W.</span> • 6 days ago</div> 
            </div> 
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition"> 
                <div class="flex text-green-500 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div> 
                <h4 class="text-lg font-bold mb-2">Perfect for tech jobs</h4> 
                <p class="text-gray-600 mb-6 italic leading-relaxed">"The optimized templates are the real deal. Uploaded my exported PDF to Workday and it parsed my data 100% perfectly."</p> 
                <div class="text-sm"><span class="font-bold">Ahmed M.</span> • 1 week ago</div> </div> 
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition"> 
                <div class="flex text-green-500 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div> 
                <h4 class="text-lg font-bold mb-2">Mobile friendly</h4> 
                <p class="text-gray-600 mb-6 italic leading-relaxed">"I updated my resume on the train from my phone. The UI is incredibly responsive. Saved the PDF directly to my files app."</p> 
                <div class="text-sm"><span class="font-bold">Jessica L.</span> • 2 weeks ago</div> 
            </div> 
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition"> 
                <div class="flex text-green-500 mb-4"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div> 
                <h4 class="text-lg font-bold mb-2">Free version is generous</h4> 
                <p class="text-gray-600 mb-6 italic leading-relaxed">"Even the free tier provides incredible value. The TXT export helped me paste my details quickly into online forms."</p> 
                <div class="text-sm"><span class="font-bold">David K.</span> • 1 month ago</div> 
            </div> 
        </div> 
    </div> 
</section> 

<section id="pricing" class="py-24 bg-white"> 
    <div class="container mx-auto px-6"> 
        <div class="text-center mb-16"> 
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Simple, transparent pricing</h2> 
            <p class="text-xl text-gray-600">Start for free, upgrade when you need more power.</p> 
        </div> 
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 max-w-5xl mx-auto"> 
            <div class="w-full md:w-1/2 bg-white border border-gray-200 rounded-2xl p-10 shadow-sm"> 
                <h3 class="text-2xl font-bold mb-2">Basic</h3> 
                <div class="text-4xl font-black mb-6">$0<span class="text-lg text-gray-400 font-normal">/forever</span></div> 
                <p class="text-gray-600 mb-8 border-b pb-8">Perfect for students and quick edits.</p> 
                <ul class="space-y-4 mb-8"> 
                    <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> 1 Resume</li> 
                    <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> 3 Standard Templates</li> 
                    <li class="flex items-center"><i class="fa-solid fa-check text-green-500 mr-3"></i> TXT Download</li> 
                </ul> 
                <a href="/register" class="block w-full py-4 text-center border-2 border-gray-900 text-gray-900 font-bold rounded-lg hover:bg-gray-900 hover:text-white transition">Sign Up Free</a> </div> 
            <div class="w-full md:w-1/2 bg-gray-900 border border-gray-900 rounded-2xl p-10 shadow-2xl relative transform md:-translate-y-4 text-white"> 
                <div class="absolute top-0 right-0 bg-pink-500 text-white font-bold text-xs px-3 py-1 rounded-bl-lg rounded-tr-lg uppercase tracking-wide">Most Popular</div> 
                <h3 class="text-2xl font-bold mb-2 text-white">Professional</h3> 
                <div class="text-4xl font-black mb-6">$2.95<span class="text-lg text-gray-400 font-normal">/14 days</span></div> 
                <p class="text-gray-400 mb-8 border-b border-gray-700 pb-8">Full access to land your dream job.</p> 
                <ul class="space-y-4 mb-8 text-gray-300"> 
                    <li class="flex items-center"><i class="fa-solid fa-check text-pink-500 mr-3"></i> Unlimited Resumes & Cover Letters</li> 
                    <li class="flex items-center"><i class="fa-solid fa-check text-pink-500 mr-3"></i> All 30+ Premium Templates</li> 
                    <li class="flex items-center"><i class="fa-solid fa-check text-pink-500 mr-3"></i> Unlimited PDF Downloads</li> 
                    <li class="flex items-center"><i class="fa-solid fa-check text-pink-500 mr-3"></i> Pre-written Phrases Repository</li> 
                </ul> 
                <a href="/register" class="block w-full py-4 text-center bg-gradient-to-r from-orange-400 to-pink-500 text-white font-bold rounded-lg shadow-lg hover:opacity-90 transition">Upgrade to Pro</a> 
            </div> 
        </div> 
    </div> 
</section> 

<section id="faq" class="py-24 bg-gray-50 border-t border-gray-200"> 
    <div class="container mx-auto px-6 max-w-7xl"> 
        <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-16">Frequently Asked Questions</h2> 
        
        <div class="flex flex-col lg:flex-row gap-12 items-start">
            <div class="w-full lg:w-1/2 bg-white rounded-2xl shadow-sm border border-gray-200 divide-y divide-gray-200"> 
                <details class="group p-5" open> 
                    <summary class="flex justify-between items-center font-bold cursor-pointer text-base text-gray-800 hover:text-purple-600 transition"> 
                        How do I use the Resume Builder app? 
                        <span class="transition-transform duration-300 group-open:rotate-45 text-xl text-purple-600">+</span> 
                    </summary> 
                    <p class="text-gray-600 mt-3 text-sm leading-relaxed pr-6">Select and customize a template, then build your profile with manual guided steps. Our platform provides text phrasing suggestions and a robust editor layout workspace.</p> 
                </details> 
                <details class="group p-5"> 
                    <summary class="flex justify-between items-center font-bold cursor-pointer text-base text-gray-800 hover:text-purple-600 transition"> 
                        Do I need to download an app on mobile? 
                        <span class="transition-transform duration-300 group-open:rotate-45 text-xl text-purple-600">+</span> 
                    </summary> 
                    <p class="text-gray-600 mt-3 text-sm leading-relaxed pr-6">No download required. Our platform is a responsive web application built with Laravel and Node.js. It works seamlessly within modern mobile browsers.</p> 
                </details> 
                <details class="group p-5"> 
                    <summary class="flex justify-between items-center font-bold cursor-pointer text-base text-gray-800 hover:text-purple-600 transition"> 
                        What makes our tool the best resume builder? 
                        <span class="transition-transform duration-300 group-open:rotate-45 text-xl text-purple-600">+</span> 
                    </summary> 
                    <p class="text-gray-600 mt-3 text-sm leading-relaxed pr-6">We combine speed, layout optimization, and privacy. Our split-screen dashboard lets you view real-time changes without constantly clicking a 'preview' button.</p> 
                </details> 
                <details class="group p-5"> 
                    <summary class="flex justify-between items-center font-bold cursor-pointer text-base text-gray-800 hover:text-purple-600 transition"> 
                        Is my information secure in the database? 
                        <span class="transition-transform duration-300 group-open:rotate-45 text-xl text-purple-600">+</span> 
                    </summary> 
                    <p class="text-gray-600 mt-3 text-sm leading-relaxed pr-6">Absolutely. We are fully compliant with data encryption standards. Personal descriptors are securely hashed inside our MySQL structures.</p> 
                </details> 
            </div>

            <div class="w-full lg:w-1/2 flex justify-center">
                <div class="bg-gray-900 p-3 rounded-2xl shadow-2xl border-4 border-gray-800 w-full max-w-lg overflow-hidden group">
                    <div class="relative bg-gray-800 rounded-lg aspect-video flex items-center justify-center overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&URL" alt="App Walkthrough Demo" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center cursor-pointer group-hover:bg-black/30 transition">
                            <div class="w-16 h-16 rounded-full bg-white/90 shadow-xl flex items-center justify-center text-purple-600 text-xl hover:bg-white hover:scale-110 transition duration-300">
                                <i class="fa-solid fa-play ml-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="pt-3 px-2 flex justify-between items-center text-xs text-gray-400 font-bold tracking-tight">
                        <span><i class="fa-solid fa-display mr-1.5 text-pink-500"></i> App Demo Walkthrough</span>
                        <span class="text-gray-500">2:40 Min</span>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</section> 

<footer class="bg-gray-900 text-gray-300 pt-20 pb-10"> 
    <div class="container mx-auto px-6"> 
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-16"> 
            <div class="lg:col-span-2"> 
                <div class="text-3xl font-black text-white mb-6 flex items-center"> <i class="fa-solid fa-layer-group text-purple-500 mr-3"></i> ResumeBuilder </div> 
                <p class="text-gray-400 text-sm leading-relaxed mb-8 pr-10"> Our online resume builder makes it simple to create a professional resume from your phone, laptop, or tablet. We empower job seekers with modern, dynamic, and professional tools. </p> 
                <div class="flex space-x-5 text-gray-400 text-2xl"> <a href="#" class="hover:text-white transition"><i class="fa-brands fa-linkedin"></i></a> <a href="#" class="hover:text-white transition"><i class="fa-brands fa-x-twitter"></i></a> <i class="fa-brands fa-instagram hover:text-white transition"></i> <i class="fa-brands fa-tiktok hover:text-white transition"></i> <i class="fa-brands fa-facebook hover:text-white transition"></i> </div> 
            </div> 
            <div> 
                <h4 class="text-white font-bold mb-6 tracking-wide uppercase text-sm">Build Your Resume</h4> 
                <ul class="space-y-3 text-sm text-gray-400"> 
                    <li><a href="#" class="hover:text-pink-400 transition">Manual Resume Builder</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Basic Resume Examples</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">How To Write a Resume</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Resume Builder App</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Cover Letter Builder</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Resume Templates</a></li> 
                </ul> 
            </div> 
            <div> 
                <h4 class="text-white font-bold mb-6 tracking-wide uppercase text-sm">Career Resources</h4> 
                <ul class="space-y-3 text-sm text-gray-400"> 
                    <li><a href="#" class="hover:text-pink-400 transition">How To Make a Resume</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Professional Summary</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Best Resume Formats</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Best Fonts for Resume</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">How To List References</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Job Interview Tips</a></li> 
                </ul> 
            </div> 
            <div> 
                <h4 class="text-white font-bold mb-6 tracking-wide uppercase text-sm">About Us</h4> 
                <ul class="space-y-3 text-sm text-gray-400"> 
                    <li><a href="#" class="hover:text-pink-400 transition">Our Story</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Contact Us</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Privacy Policy</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Terms of Service</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Accessibility</a></li> 
                    <li><a href="#" class="hover:text-pink-400 transition">Do Not Sell My Info</a></li> 
                </ul> 
            </div> 
        </div> 
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500"> 
            <p>© 2026 Dynamic Resume Builder LLC. Developed for educational purposes.</p> 
            <div class="mt-4 md:mt-0"> Made with <i class="fa-solid fa-heart text-red-500 mx-1"></i> using Laravel & Node.js </div> 
        </div> 
    </div> 
</footer> 

<div id="hiddenAdminOverlay" class="fixed inset-0 bg-slate-900/35 z-[100] modal-blur-bg hidden items-center justify-center p-4 md:p-12"> 
    <div id="adminCardFrame" class="w-full max-w-5xl bg-white rounded-3xl border border-pink-200 shadow-2xl flex flex-col md:flex-row overflow-hidden relative scale-animation transform scale-90 opacity-0 min-h-[500px]"> 
        
        <button onclick="closeAdminPortalOverlay()" class="absolute right-6 top-6 w-10 h-10 rounded-full bg-white text-slate-500 border border-slate-200 shadow-md hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition flex items-center justify-center text-base z-50"> <i class="fa-solid fa-xmark"></i> </button> 
        
        <div class="w-full md:w-1/2 p-10 flex flex-col items-center justify-center bg-gradient-to-br from-pink-50 via-white to-purple-50 border-r border-pink-100"> 
            <div class="mb-5 text-center">
                <div class="mx-auto w-14 h-14 rounded-2xl bg-gradient-to-r from-pink-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-pink-200">
                    <i class="fa-solid fa-user-shield text-xl"></i>
                </div>
                <h3 class="mt-4 text-2xl font-black text-slate-900">Admin Secure Portal</h3>
                <p class="text-sm text-slate-500 mt-1">System management access for ResumeBuilder</p>
            </div>
            <img src="images/login-illustration.jpg" alt="Login Illustration" class="w-full max-h-[330px] object-cover rounded-2xl shadow-lg border border-white"> 
        </div> 

        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center bg-white relative"> 
            
            <div id="adminAuthView" class="w-full max-w-sm mx-auto"> 
                <div class="mb-7">
                    <p class="text-xs font-black text-pink-500 uppercase tracking-[0.22em] mb-2">Administrator</p>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Admin Login</h2>
                    <p class="text-sm text-slate-500 mt-2">Enter admin credentials to open the control panel.</p>
                </div>

                <form id="adminLoginForm" onsubmit="handleAdminLogin(event)" class="space-y-5" autocomplete="off"> 
                    <div> 
                        <label class="block text-xs font-bold text-slate-600 mb-2">Admin Gmail</label>
                        <div class="relative"> 
                            <input type="email" id="adminEmail" autocomplete="off" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-4 pr-12 text-sm font-semibold text-slate-800 placeholder-slate-400 outline-none focus:bg-white focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition"  placeholder="Enter admin Gmail" required> 
                            <i class="fa-solid fa-user absolute right-4 top-4 text-pink-400 text-sm"></i> 
                        </div> 
                    </div> 
                    <div> 
                        <label class="block text-xs font-bold text-slate-600 mb-2">Password</label>
                        <div class="relative"> 
                            <input type="password" id="adminPassword" autocomplete="new-password" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-4 pr-12 text-sm font-semibold text-slate-800 placeholder-slate-400 outline-none focus:bg-white focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition" placeholder="Enter your Password" required> 
                            <i class="fa-solid fa-eye absolute right-4 top-4 text-pink-400 text-sm cursor-pointer hover:text-pink-600 transition" onclick="togglePasswordInput('adminPassword')"></i> 
                        </div> 
                        <div class="text-right mt-2.5"> <button type="button" onclick="switchAdminView('forgot')" class="text-xs text-pink-500 font-bold hover:underline">Forgot Password?</button> </div> 
                    </div> 
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-full font-bold text-sm tracking-wide shadow-lg shadow-pink-200 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all mt-4">Login</button> 
                </form> 
            </div> 

            <div id="adminForgotView" class="w-full max-w-sm mx-auto hidden"> 
                <p class="text-xs font-black text-pink-500 uppercase tracking-[0.22em] mb-2">Recovery</p>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-3">Forgot Password</h2> 
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">Enter your registered admin email. A 6-digit reset code will be sent to that email.</p> 
                <form id="forgotForm" onsubmit="handleForgotRequest(event)" class="space-y-5" autocomplete="off"> 
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">Admin Email</label>
                        <div class="relative">
                            <input type="email" id="forgotEmail" autocomplete="off" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-4 pr-12 text-sm font-semibold text-slate-800 placeholder-slate-400 outline-none focus:bg-white focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition" placeholder="adminresumebuilder@gmail.com" required>
                            <i class="fa-solid fa-envelope absolute right-4 top-4 text-pink-400 text-sm"></i>
                        </div>
                    </div> 
                    <div class="flex items-center justify-between gap-4 pt-2">
                        <button type="button" onclick="switchAdminView('login')" class="w-1/2 py-3 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl uppercase hover:bg-slate-200 transition">Back</button>
                        <button type="submit" class="w-1/2 py-3 bg-pink-500 text-white font-bold text-xs rounded-xl uppercase hover:bg-pink-600 shadow-md shadow-pink-100 transition">Send Code</button>
                    </div> 
                </form> 
            </div> 

            <div id="adminVerifyView" class="w-full max-w-sm mx-auto hidden"> 
                <p class="text-xs font-black text-blue-500 uppercase tracking-[0.22em] mb-2">Verification</p>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-3">Verify Reset Code</h2>
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">Check your email and enter the 6-digit code.</p>
                <form id="verifyForm" onsubmit="handleVerifyToken(event)" class="space-y-5" autocomplete="off"> 
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">Verification Code</label>
                        <input type="text" id="verifyOtp" maxlength="6" autocomplete="off" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 text-center text-xl font-black text-slate-800 outline-none focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition" placeholder="000000" required>
                    </div> 
                    <div class="flex items-center justify-between gap-4 pt-2">
                        <button type="button" onclick="switchAdminView('forgot')" class="w-1/2 py-3 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl uppercase hover:bg-slate-200 transition">Back</button>
                        <button type="submit" class="w-1/2 py-3 bg-blue-500 text-white font-bold text-xs uppercase rounded-xl hover:bg-blue-600 shadow-md shadow-blue-100 transition">Verify</button>
                    </div>
                </form> 
            </div> 

            <div id="adminResetView" class="w-full max-w-sm mx-auto hidden">
                <p class="text-xs font-black text-emerald-500 uppercase tracking-[0.22em] mb-2">New Credentials</p>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-3">Create New Password</h2>
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">Enter your new admin password and confirm it.</p>

                <form id="resetForm" onsubmit="handlePasswordUpdate(event)" class="space-y-5" autocomplete="off">

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">New Password</label>
                        <div class="relative">
                            <input type="password" id="newPassword" autocomplete="new-password" oninput="checkResetPasswordMatch()" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-4 pr-12 text-sm text-slate-800 placeholder-slate-400 outline-none focus:bg-white focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition" placeholder="Enter new password" required>
                            <button type="button" onmousedown="holdPasswordVisible('newPassword')" onmouseup="hidePasswordAgain('newPassword')" onmouseleave="hidePasswordAgain('newPassword')" ontouchstart="holdPasswordVisible('newPassword')" ontouchend="hidePasswordAgain('newPassword')" class="absolute right-4 top-3.5 text-pink-400 text-sm cursor-pointer hover:text-pink-600 transition">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">Confirm Password</label>
                        <div class="relative">
                            <input type="password" id="confirmNewPassword" autocomplete="new-password" oninput="checkResetPasswordMatch()" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-4 pr-12 text-sm text-slate-800 placeholder-slate-400 outline-none focus:bg-white focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition" placeholder="Confirm new password" required>
                            <button type="button" onmousedown="holdPasswordVisible('confirmNewPassword')" onmouseup="hidePasswordAgain('confirmNewPassword')" onmouseleave="hidePasswordAgain('confirmNewPassword')" ontouchstart="holdPasswordVisible('confirmNewPassword')" ontouchend="hidePasswordAgain('confirmNewPassword')" class="absolute right-4 top-3.5 text-pink-400 text-sm cursor-pointer hover:text-pink-600 transition">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        <p id="resetPasswordMatchMessage" class="text-xs font-bold mt-2 hidden"></p>
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-emerald-500 text-white rounded-xl font-bold text-sm uppercase hover:bg-emerald-600 shadow-md shadow-emerald-100 transition">Update Password</button>
                </form>
            </div> 
        </div> 
    </div> 
</div>
<script> 
// Custom Logic Handlers
function switchAdminView(view) { 
    ['adminAuthView', 'adminForgotView', 'adminVerifyView', 'adminResetView'].forEach(vId => { document.getElementById(vId).classList.add('hidden'); }); 
    if(view === 'login') document.getElementById('adminAuthView').classList.remove('hidden'); 
    else if(view === 'forgot') document.getElementById('adminForgotView').classList.remove('hidden'); 
    else if(view === 'verify') document.getElementById('adminVerifyView').classList.remove('hidden'); 
    else if(view === 'reset') document.getElementById('adminResetView').classList.remove('hidden'); 
} 

function togglePasswordInput(id) { 
    const input = document.getElementById(id); 
    input.type = input.type === 'password' ? 'text' : 'password'; 
} 

function holdPasswordVisible(id) {
    const input = document.getElementById(id);
    if (input) {
        input.type = "text";
    }
}

function hidePasswordAgain(id) {
    const input = document.getElementById(id);
    if (input) {
        input.type = "password";
    }
}

function checkResetPasswordMatch() {
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmNewPassword").value;
    const message = document.getElementById("resetPasswordMatchMessage");

    if (!message) return;

    if (!newPassword && !confirmPassword) {
        message.classList.add("hidden");
        message.textContent = "";
        return;
    }

    message.classList.remove("hidden");

    if (newPassword === confirmPassword && newPassword.length > 0) {
        message.textContent = "Passwords matched";
        message.className = "text-xs font-bold mt-2 text-emerald-400";
    } else {
        message.textContent = "Password must be same";
        message.className = "text-xs font-bold mt-2 text-red-400";
    }
}

function handleLogoIconClick(event) { 
    event.stopPropagation(); 
    const overlay = document.getElementById('hiddenAdminOverlay'); 
    const card = document.getElementById('adminCardFrame'); 
    
    // Explicit clean form fields initialization on window pop up
    document.getElementById('adminLoginForm').reset(); 
    document.getElementById('forgotForm').reset(); 
    document.getElementById('verifyForm').reset(); 
    document.getElementById('resetForm').reset(); 
    
    switchAdminView('login'); 
    overlay.classList.remove('hidden'); 
    overlay.classList.add('flex'); 
    setTimeout(() => { 
        card.classList.remove('scale-90', 'opacity-0'); 
        card.classList.add('scale-100', 'opacity-100'); 
    }, 150); 
} 

function closeAdminPortalOverlay() { 
    const overlay = document.getElementById('hiddenAdminOverlay'); 
    const card = document.getElementById('adminCardFrame'); 
    card.classList.remove('scale-100', 'opacity-100'); 
    card.classList.add('scale-90', 'opacity-0'); 
    setTimeout(() => { 
        overlay.classList.remove('flex'); 
        overlay.classList.add('hidden'); 
    }, 400); 
} 

// Custom Node Integration Functions
async function handleAdminLogin(e) {
    e.preventDefault();

    const email = document.getElementById("adminEmail").value.trim();
    const password = document.getElementById("adminPassword").value.trim();

    console.log("Frontend Admin Email:", email);
    console.log("Frontend Admin Password:", password);

    if (!email || !password) {
        alert("Email and password are required.");
        return;
    }

    try {
        const res = await fetch("http://localhost:5000/api/admin/auth/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        const data = await res.json();

        if (data.success) {
            alert("Admin logged in successfully!");
            localStorage.setItem("adminToken", data.token);
            localStorage.setItem("adminEmail", email);

            // Admin ko normal user dashboard par nahi, apne admin page par bhejo
            window.location.href = "/admin-dashboard";
        } else {
            alert(data.message || "Invalid admin email or password.");
        }
    } catch (error) {
        console.error("Admin login error:", error);
        alert("Server error. Please check backend.");
    }
}

// REPLACE THIS FUNCTION
async function handleForgotRequest(e) { 
    e.preventDefault(); 
    const email = document.getElementById('forgotEmail').value; 
    console.log("Sending recovery code to:", email); // Debugging
    
    try { 
        const res = await fetch('http://localhost:5000/api/admin/auth/forgot-key', { 
            method: 'POST', 
            headers: { 'Content-Type': 'application/json' }, 
            body: JSON.stringify({ email }) 
        }); 
        
        const data = await res.json(); 
        console.log("Response:", data); // Check this in Browser Console
        
        if(data.success) {
            switchAdminView('verify'); 
        } else { 
            alert("Error: " + data.message); 
        } 
    } catch(err) { 
        console.error("Fetch Error:", err);
        alert("Server se connection nahi ho raha. Check karein Node.js backend chal raha hai?"); 
    } 
} 

async function handleVerifyToken(e) {
    e.preventDefault();

    const email = document.getElementById('forgotEmail').value.trim();
    const otp = document.getElementById('verifyOtp').value.trim();

    try {
        const res = await fetch('http://localhost:5000/api/admin/auth/verify-key', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, otp })
        });

        const data = await res.json();

        if (data.success) {
            switchAdminView('reset');
        } else {
            alert(data.message || "Invalid reset code.");
        }
    } catch(err) {
        console.error(err);
        alert("Server se connection nahi ho raha.");
    }
}

async function handlePasswordUpdate(e) {
    e.preventDefault();

    const email = document.getElementById('forgotEmail').value.trim();
    const otp = document.getElementById('verifyOtp').value.trim();
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmNewPassword').value;

    if (newPass !== confirmPass) { alert("Security validation failed: Key values do not match."); return; }

    try {
        const res = await fetch('http://localhost:5000/api/admin/auth/reset-key', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email,
                otp,
                newPassword: newPass,
                confirmPassword: confirmPass
            })
        });

        const data = await res.json();

        if (data.success) {
            alert("Security credentials modified successfully! Please login again.");
            document.getElementById('adminLoginForm').reset();
            document.getElementById('resetForm').reset();
            switchAdminView('login');
        } else {
            alert(data.message || "Password reset failed.");
        }
    } catch(err) {
        console.error(err);
        alert("Server se connection nahi ho raha.");
    }
} 

window.addEventListener('click', (e) => { 
    const card = document.getElementById('adminCardFrame'); 
    if (document.getElementById('hiddenAdminOverlay').classList.contains('flex') && !card.contains(e.target) && !document.getElementById('triggerAdminToggle').contains(e.target)) { closeAdminPortalOverlay(); } 
}); 
</script> 

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.site-navbar');
    const megaItems = [
        { trigger: document.getElementById('resumeExamplesTrigger'), panel: document.getElementById('resumeExamplesMegaPanel') },
        { trigger: document.getElementById('resumeTemplatesTrigger'), panel: document.getElementById('resumeTemplatesMegaPanel') }
    ].filter(item => item.trigger && item.panel);

    let lockedItem = null;
    let closeTimer = null;

    function updateMegaTop() {
        if (!navbar) return;
        const rect = navbar.getBoundingClientRect();
        document.documentElement.style.setProperty('--mega-top', rect.bottom + 'px');
    }

    function closeAll(force = false) {
        if (lockedItem && !force) return;
        lockedItem = null;
        megaItems.forEach(function (item) {
            item.panel.classList.remove('show');
            item.trigger.classList.remove('active-mega');
        });
    }

    function openMega(item, lock = false) {
        clearTimeout(closeTimer);
        updateMegaTop();

        megaItems.forEach(function (otherItem) {
            if (otherItem !== item) {
                otherItem.panel.classList.remove('show');
                otherItem.trigger.classList.remove('active-mega');
            }
        });

        if (lock) lockedItem = item;
        item.panel.classList.add('show');
        item.trigger.classList.add('active-mega');
    }

    megaItems.forEach(function (item) {
        item.trigger.addEventListener('mouseenter', function () {
            openMega(item, false);
        });

        item.trigger.addEventListener('mouseleave', function () {
            closeTimer = setTimeout(function () {
                closeAll(false);
            }, 160);
        });

        item.trigger.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (lockedItem === item && item.panel.classList.contains('show')) {
                closeAll(true);
            } else {
                openMega(item, true);
            }
        });

        item.panel.addEventListener('mouseenter', function () {
            clearTimeout(closeTimer);
            openMega(item, false);
        });

        item.panel.addEventListener('mouseleave', function () {
            closeTimer = setTimeout(function () {
                closeAll(false);
            }, 160);
        });
    });

    document.addEventListener('click', function (event) {
        const clickedInsideMega = megaItems.some(function (item) {
            return item.panel.contains(event.target) || item.trigger.contains(event.target);
        });

        if (!clickedInsideMega) {
            closeAll(true);
        }
    });

    window.addEventListener('resize', updateMegaTop);
    window.addEventListener('scroll', updateMegaTop, { passive: true });
    updateMegaTop();
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const navTabs = document.querySelectorAll('.site-nav-menu .main-nav-link');

    function clearActiveTabs() {
        navTabs.forEach(function (tab) {
            tab.classList.remove('active-tab');
        });
    }

    navTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            clearActiveTabs();

            if (tab.id !== 'resumeExamplesTrigger' && tab.id !== 'resumeTemplatesTrigger') {
                tab.classList.add('active-tab');

                ['resumeExamples', 'resumeTemplates'].forEach(function (name) {
                    const panel = document.getElementById(name + 'MegaPanel');
                    const trigger = document.getElementById(name + 'Trigger');

                    if (panel && trigger) {
                        panel.classList.remove('show');
                        trigger.classList.remove('active-mega');
                    }
                });
            }
        });
    });
});
</script>
<!-- --- ADD THIS AT THE VERY BOTTOM OF YOUR HTML (JUST BEFORE </body>) --- -->

<script>
// Add Mobile Menu Elements to DOM dynamically
document.addEventListener('DOMContentLoaded', function() {
    // 1. Add Mobile Toggle Button to Navbar
    const navbarInner = document.querySelector('.site-navbar-inner');
    if (navbarInner) {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'mobile-menu-btn';
        toggleBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
        
        // Insert right after logo or before CTA
        const logoWrap = document.querySelector('.site-logo-wrap');
        logoWrap.parentNode.insertBefore(toggleBtn, logoWrap.nextSibling);

        // 2. Create Mobile Menu Overlay & Backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'mobile-menu-backdrop';
        
        const overlay = document.createElement('div');
        overlay.className = 'mobile-menu-overlay';
        
        // Extract existing links to populate mobile menu
        const desktopLinks = Array.from(document.querySelectorAll('.main-nav-link'));
        let linksHTML = '';
        
        desktopLinks.forEach(link => {
            // Clean up text content
            const text = link.textContent.trim();
            const href = link.getAttribute('href') || '#';
            linksHTML += `<a href="${href}" class="mobile-nav-link">${text} <i class="fa-solid fa-chevron-right"></i></a>`;
        });

        overlay.innerHTML = `
            <div class="mobile-menu-header">
                <span class="site-logo-text font-black text-gray-900">Menu</span>
                <button class="mobile-menu-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="mobile-menu-content">
                ${linksHTML}
                <a href="/register" class="mobile-nav-cta">Build My Resume</a>
            </div>
        `;

        document.body.appendChild(backdrop);
        document.body.appendChild(overlay);

        // 3. Add Event Listeners
        const closeBtn = overlay.querySelector('.mobile-menu-close');
        
        function openMobileMenu() {
            backdrop.classList.add('open');
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeMobileMenu() {
            backdrop.classList.remove('open');
            overlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        toggleBtn.addEventListener('click', openMobileMenu);
        closeBtn.addEventListener('click', closeMobileMenu);
        backdrop.addEventListener('click', closeMobileMenu);
    }
});
</script>
</body> 
</html>