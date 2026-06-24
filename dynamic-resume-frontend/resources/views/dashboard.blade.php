<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Resume Builder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{
            --rb-navy:#07004f;
            --rb-text:#0f172a;
            --rb-muted:#64748b;
            --rb-pink:#c1007a;
            --rb-purple:#7c3aed;
            --rb-border:#d9dde7;
            --rb-soft:#f6f7fb;
        }
        *{box-sizing:border-box}
        body{background:#fff;color:var(--rb-text);font-family:Arial,Helvetica,sans-serif;min-height:100vh}
        .rb-navbar{height:92px;background:#fff;border-bottom:1px solid #eef0f5;display:flex;align-items:center;justify-content:space-between;padding:0 78px;position:sticky;top:0;z-index:50;box-shadow:0 1px 0 rgba(15,23,42,.04)}
        .rb-brand{display:flex;align-items:center;gap:12px;font-size:25px;font-weight:950;letter-spacing:-.045em;white-space:nowrap;text-decoration:none}
        .rb-brand span{background:linear-gradient(90deg,#7c3aed 0%,#ec4899 100%);-webkit-background-clip:text;background-clip:text;color:transparent}
        .rb-brand i{font-size:30px;background:linear-gradient(180deg,#7c3aed 0%,#ec4899 100%);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;filter:none}
        .rb-nav-left{display:flex;align-items:center;gap:48px}
        .rb-nav-links{display:flex;align-items:center;gap:37px;font-size:15px;font-weight:950;text-transform:uppercase;letter-spacing:.02em;color:#0f172a}
        .rb-nav-item{position:relative;display:flex;align-items:center;gap:7px;color:#0f172a;text-decoration:none;padding:36px 0;cursor:pointer;border-bottom:0!important;transition:color .18s ease}
        .rb-nav-item:hover{color:#111827}
        .rb-nav-item::after{content:none!important}
        .rb-nav-dropdown{position:relative}
        .rb-nav-item .fa-angle-down{transition:transform .18s ease}
        .rb-nav-dropdown:hover .rb-nav-item .fa-angle-down,
        .rb-nav-dropdown.open .rb-nav-item .fa-angle-down{transform:rotate(180deg)}
        .rb-mega{position:fixed;top:92px;left:0;right:0;background:#fff;border-top:1px solid #f3f4f6;border-bottom:1px solid #d9dde7;box-shadow:0 8px 18px rgba(15,23,42,.04);display:none;z-index:70;padding:42px 118px 38px;text-transform:none;letter-spacing:0}
        .rb-nav-dropdown:hover .rb-mega,.rb-nav-dropdown.open .rb-mega{display:grid}
        .rb-mega-inner{display:grid;grid-template-columns:420px minmax(0,1fr) minmax(0,1fr);column-gap:82px;align-items:center;width:100%;max-width:1680px;margin:0 auto}
        .rb-mega-art{height:300px;display:flex;align-items:center;justify-content:center}
        .rb-mega-art img{max-width:100%;max-height:300px;object-fit:contain}
        .rb-mega-col{display:flex;flex-direction:column;gap:46px}
        .rb-mega-link{display:grid;grid-template-columns:minmax(0,1fr) 26px;gap:22px;align-items:start;color:#0f172a;text-decoration:none}
        .rb-mega-link h4{font-size:28px;line-height:1.05;font-weight:950;margin:0 0 12px;letter-spacing:.01em;color:#0f172a;text-transform:none}
        .rb-mega-link p{font-size:23px;line-height:1.42;font-weight:500;color:#8993a5;margin:0;text-transform:none;letter-spacing:.01em}
        .rb-mega-link i{font-size:28px;color:#0f172a;margin-top:2px}
        .rb-mega-link:hover h4,.rb-mega-link:hover i{color:#c1007a}
        .rb-mega-link:hover p{color:#64748b}
        .rb-right{display:flex;align-items:center;gap:30px}
        .rb-bell{font-size:21px;color:#111827;cursor:pointer}
        #profileBtn{display:flex;align-items:center;gap:12px;text-transform:uppercase;font-size:17px;font-weight:950;color:#0f172a;background:transparent;border:0;cursor:pointer;outline:0}
        #profileBtn .fa-user{font-size:19px;color:#0f172a}
        #profileBtn:hover{color:#c1007a}
        #dropdownMenu{position:absolute;right:0;top:48px;width:220px;background:#fff;border:1px solid #e5e7eb;box-shadow:0 18px 45px rgba(15,23,42,.16);border-radius:2px;padding:8px 0;z-index:100;text-transform:none}
        #dropdownMenu a,#dropdownMenu button{font-size:14px;font-weight:800}
        .page-wrap{max-width:1500px;margin:0 auto;padding:42px 72px 0}
        .dash-grid{display:grid;grid-template-columns:420px minmax(0,1fr);gap:34px;align-items:start}
        .resume-card{border:1px solid #aeb4c1;background:#fff;min-height:710px;padding:26px 26px 34px}
        .resume-label{font-size:15px;font-weight:950;text-transform:uppercase;letter-spacing:.03em;margin-bottom:12px}
        .resume-select{height:58px;border:1px solid #9ca3af;display:flex;align-items:center;justify-content:space-between;padding:0 18px;font-size:22px;letter-spacing:.04em;color:#111827;background:#fff;overflow:hidden}
        .primary-row{display:flex;align-items:center;gap:13px;margin:18px 0 30px;font-size:19px;color:#111827}
        .primary-row i{color:#f2c94c;font-size:21px}.primary-row b{font-weight:950}
        .resume-preview{height:430px;background:#fff;border-top:12px solid #79a521;overflow:hidden;box-shadow:0 0 0 1px rgba(148,163,184,.25) inset;position:relative}
        .resume-paper{transform:scale(.62);transform-origin:top center;width:520px;height:700px;background:#fff;margin:24px auto 0;font-family:Georgia,serif;text-align:center;color:#3f6212}
        .resume-paper h3{font-size:24px;letter-spacing:.10em;margin:20px 0 8px}.resume-paper p{font-size:11px;color:#475569}.paper-line{height:2px;background:#79a521;margin:18px 40px}.paper-section{height:8px;background:#d1d5db;margin:12px 54px;border-radius:99px}.paper-section.short{width:55%;margin-left:auto;margin-right:auto}
        .check-card{background:#f7f8fb;box-shadow:0 12px 35px rgba(15,23,42,.08);border:1px solid #eef0f5}
        .check-head{height:76px;background:#0a0061;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 30px}
        .check-head h2{font-size:29px;font-weight:950;letter-spacing:.01em}.check-head a{color:#fff;font-size:24px;font-weight:950;text-decoration:underline;text-underline-offset:4px;display:flex;align-items:center;gap:14px}
        .check-body{padding:26px 30px 32px}.check-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}.check-top h3{font-size:27px;font-weight:950;letter-spacing:.02em}.check-top span{font-size:21px}.check-top b{color:#247d5b;font-weight:950}
        .task-row{display:grid;grid-template-columns:250px minmax(0,1fr) 140px;gap:34px;align-items:center;padding:25px 0;border-top:1px solid #d7dbe5}.task-row:first-of-type{border-top:0}.task-img{height:135px;display:flex;align-items:center;justify-content:center}.resume-stack{width:190px;height:120px;position:relative}.sheet{position:absolute;width:110px;height:140px;background:#fff;border:1px solid #cbd5e1;box-shadow:0 8px 16px rgba(15,23,42,.11)}.sheet:nth-child(1){left:5px;top:10px}.sheet:nth-child(2){left:45px;top:0;background:#e6f4f7;border-top:32px solid #4aa7bb}.sheet:nth-child(3){right:0;top:13px}.strength-box{width:190px;border:1px solid #cbd5e1;border-radius:5px;background:#fff;padding:16px 18px}.strength-box h5{font-size:14px;font-weight:950;margin-bottom:8px;display:flex;justify-content:space-between}.strength-box p{font-size:13px;margin:7px 0;color:#1f2937}.strength-box i{color:#b91c1c;font-size:12px;margin-right:7px}.cover-icon{width:190px;height:120px;border:1px solid #cbd5e1;border-radius:5px;background:#fff;display:flex;align-items:center;justify-content:center;color:#7c3aed;font-size:48px}.task-content h4{font-size:23px;font-weight:950;margin-bottom:14px}.task-content p{font-size:22px;line-height:1.35;color:#1f2937;margin-bottom:16px}.pink-btn{display:inline-flex;align-items:center;justify-content:center;min-width:220px;height:45px;border-radius:999px;background:#c1007a;color:#fff;font-size:17px;font-weight:950;text-decoration:none;border:0;box-shadow:0 10px 20px rgba(193,0,122,.14);cursor:pointer}.pink-btn:hover{background:#a90069}.outline-btn{display:inline-flex;align-items:center;justify-content:center;min-width:165px;height:45px;border-radius:999px;background:#fff;color:#0a0a49;border:1.5px solid #0a0a49;font-size:18px;font-weight:950;text-decoration:none;cursor:pointer}.incomplete{display:flex;align-items:center;gap:9px;color:#111827;font-size:20px;white-space:nowrap}.dot{width:12px;height:12px;background:#d6d9df;border-radius:999px;display:inline-block}.recent-wrap{margin-top:42px}.recent-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}.recent-head h3{font-size:27px;font-weight:950}.recent-table{width:100%;border-collapse:collapse;background:#fff}.recent-table th{text-align:left;font-size:14px;color:#64748b;font-weight:950;text-transform:uppercase;padding:14px 10px;border-bottom:1px solid #d7dbe5}.recent-table td{padding:18px 10px;border-bottom:1px solid #d7dbe5;font-size:18px}.recent-table a{color:#05024f;font-weight:950;text-decoration:underline}.score-pill{display:inline-flex;min-width:52px;height:34px;border-radius:999px;background:#f8fafc;align-items:center;justify-content:center;color:#0e6b9a;font-weight:950}.see-all{display:flex;justify-content:flex-end;margin-top:24px}.see-all a{font-size:23px;font-weight:950;color:#05024f;text-decoration:none}.webinars{margin-top:70px}.webinar-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}.webinar-top h3{font-size:42px;font-weight:950;letter-spacing:.04em}.webinar-select{height:58px;border:1px solid #9ca3af;background:#fff;min-width:300px;padding:0 18px;display:flex;align-items:center;justify-content:space-between;font-size:22px;color:#1f2937}.webinar-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}.webinar-card{border:1px solid #cbd5e1;background:#fff;overflow:hidden}.webinar-img{height:190px;position:relative;background:#dbeafe;display:flex;align-items:center;justify-content:center}.webinar-img img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}.webinar-img i{position:relative;color:#fff;font-size:64px;text-shadow:0 4px 14px rgba(0,0,0,.22)}.webinar-card h4{font-size:17px;line-height:1.3;font-weight:950;padding:16px 18px 8px;min-height:72px}.webinar-card a{display:block;padding:0 18px 18px;color:#0e6b9a;font-weight:950}.rb-footer{margin-top:80px;border-top:1px solid #e5e7eb;padding:28px 72px 34px;display:flex;justify-content:space-between;gap:20px;color:#64748b;font-size:14px;font-weight:800}.rb-footer-links{display:flex;gap:24px;flex-wrap:wrap}.rb-footer a{color:#374151;text-decoration:none}.rb-footer a:hover{color:#c1007a}

        /* GHOST FINAL DASHBOARD BOTTOM ALIGNMENT: full left start + slightly smaller like screenshot */
        .dashboard-full-section{width:100%;margin-top:44px;}
        .dashboard-full-section .recent-wrap{margin-top:0;}
        .dashboard-full-section .recent-head h3{font-size:22px;letter-spacing:.01em;}
        .dashboard-full-section .recent-table th{font-size:12px;padding:12px 9px;}
        .dashboard-full-section .recent-table td{font-size:15px;padding:15px 9px;}
        .dashboard-full-section .score-pill{min-width:46px;height:30px;font-size:14px;}
        .dashboard-full-section .see-all{margin-top:22px;}
        .dashboard-full-section .see-all a{font-size:20px;}
        .dashboard-full-section .webinars{margin-top:58px;}
        .dashboard-full-section .webinar-top{margin-bottom:18px;}
        .dashboard-full-section .webinar-top h3{font-size:32px;letter-spacing:.055em;}
        .dashboard-full-section .webinar-select{height:48px;min-width:270px;font-size:18px;}
        .dashboard-full-section .webinar-grid{gap:18px;}
        .dashboard-full-section .webinar-img{height:155px;}
        .dashboard-full-section .webinar-img i{font-size:52px;}
        .dashboard-full-section .webinar-card h4{font-size:15px;min-height:62px;padding:14px 16px 6px;}
        .dashboard-full-section .webinar-card a{font-size:14px;padding:0 16px 16px;}

        /* GHOST FINAL COMPACT FIX: Equal dropdown size + smaller page data */
        .rb-mega{
            top:82px !important;
            min-height:305px !important;
            max-height:305px !important;
            padding:24px 110px 24px !important;
            overflow:hidden !important;
        }
        .rb-mega-inner{
            grid-template-columns:360px minmax(0,1fr) minmax(0,1fr) !important;
            column-gap:72px !important;
            max-width:1580px !important;
            min-height:255px !important;
            align-items:center !important;
        }
        .rb-mega-art{height:245px !important;}
        .rb-mega-art img{max-height:245px !important;max-width:360px !important;}
        .rb-mega-col{gap:34px !important;}
        .rb-mega-link{grid-template-columns:minmax(0,1fr) 20px !important;gap:16px !important;}
        .rb-mega-link h4{font-size:22px !important;line-height:1.08 !important;margin-bottom:8px !important;}
        .rb-mega-link p{font-size:17px !important;line-height:1.35 !important;}
        .rb-mega-link i{font-size:22px !important;margin-top:1px !important;}

        .page-wrap{padding-top:32px !important;padding-bottom:34px !important;}
        .resume-card{padding:22px !important;}
        .resume-card h3{font-size:22px !important;}
        .resume-card p{font-size:15px !important;}
        .resume-empty{height:220px !important;}
        .create-btn{height:44px !important;font-size:15px !important;}
        .checklist-head{padding:15px 22px !important;}
        .checklist-head h2{font-size:21px !important;}
        .checklist-body{padding:22px !important;}
        .check-top h3{font-size:24px !important;}
        .check-top span{font-size:14px !important;}
        .task-row{grid-template-columns:210px minmax(0,1fr) 120px !important;gap:26px !important;padding:20px 0 !important;}
        .task-img{height:115px !important;}
        .resume-stack{width:165px !important;height:105px !important;}
        .sheet{width:95px !important;height:118px !important;}
        .sheet:nth-child(2){border-top-width:26px !important;}
        .strength-box{width:165px !important;padding:13px 15px !important;}
        .strength-box h5{font-size:12px !important;}
        .strength-box p{font-size:11px !important;margin:6px 0 !important;}
        .cover-icon{width:165px !important;height:104px !important;font-size:40px !important;}
        .task-content h4{font-size:20px !important;margin-bottom:10px !important;}
        .task-content p{font-size:18px !important;line-height:1.32 !important;margin-bottom:13px !important;}
        .pink-btn{min-width:190px !important;height:40px !important;font-size:15px !important;}
        .outline-btn{min-width:145px !important;height:40px !important;font-size:15px !important;}
        .incomplete{font-size:16px !important;gap:7px !important;}

        .goal-card{padding:24px !important;}
        .goal-card h3{font-size:24px !important;}
        .goal-card p{font-size:16px !important;}

        .dashboard-full-section{margin-top:34px !important;}
        .dashboard-full-section .recent-head h3{font-size:19px !important;}
        .dashboard-full-section .recent-table th{font-size:10px !important;padding:10px 8px !important;}
        .dashboard-full-section .recent-table td{font-size:13px !important;padding:12px 8px !important;}
        .dashboard-full-section .score-pill{min-width:40px !important;height:26px !important;font-size:12px !important;}
        .dashboard-full-section .see-all a{font-size:16px !important;}
        .dashboard-full-section .webinars{margin-top:45px !important;}
        .dashboard-full-section .webinar-top h3{font-size:28px !important;}
        .dashboard-full-section .webinar-select{height:42px !important;min-width:240px !important;font-size:15px !important;}
        .dashboard-full-section .webinar-grid{gap:15px !important;}
        .dashboard-full-section .webinar-img{height:130px !important;}
        .dashboard-full-section .webinar-img i{font-size:44px !important;}
        .dashboard-full-section .webinar-card h4{font-size:13px !important;min-height:54px !important;padding:12px 14px 5px !important;}
        .dashboard-full-section .webinar-card a{font-size:12px !important;padding:0 14px 14px !important;}
        .rb-footer{margin-top:58px !important;padding-top:22px !important;padding-bottom:26px !important;font-size:12px !important;}



        /* GHOST CAREER GOALS SECTION - added as requested, UI only */
        .career-goals-section{
            width:100%;
            margin-top:38px;
        }
        .career-goals-section > h2{
            font-size:22px;
            line-height:1.05;
            font-weight:950;
            color:#0f172a;
            margin:0 0 3px;
            letter-spacing:.01em;
        }
        .career-goals-section > p{
            font-size:10px;
            line-height:1.2;
            color:#64748b;
            font-weight:700;
            margin:0 0 16px;
        }
        .career-goals-card{
            min-height:122px;
            border:1px solid #b9bfcc;
            border-radius:8px;
            background:#f8fafc;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:24px 42px 22px;
            overflow:hidden;
        }
        .career-goals-copy h3{
            font-size:22px;
            line-height:1.15;
            font-weight:950;
            color:#0f172a;
            margin:0 0 7px;
        }
        .career-goals-copy p{
            font-size:10px;
            line-height:1.35;
            color:#475569;
            font-weight:700;
            margin:0 0 14px;
        }
        .career-goals-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:92px;
            height:28px;
            border-radius:999px;
            background:#c1007a;
            color:#ffffff;
            text-decoration:none;
            font-size:10px;
            font-weight:950;
            box-shadow:0 8px 18px rgba(193,0,122,.13);
        }
        .career-goals-btn:hover{background:#a90069;}
        .career-goals-art{
            width:210px;
            height:105px;
            display:flex;
            align-items:center;
            justify-content:flex-end;
            flex-shrink:0;
        }
        .career-goals-art img{
            max-width:100%;
            max-height:115px;
            object-fit:contain;
            display:block;
        }
        @media(max-width:1100px){
            .career-goals-card{padding:22px;align-items:flex-start;gap:14px;}
            .career-goals-art{width:150px;height:95px;}
        }

        @media(max-width:1100px){.rb-navbar{padding:0 24px}.rb-nav-links{display:none}.page-wrap{padding:26px 20px}.dash-grid{grid-template-columns:1fr}.resume-card{min-height:auto}.task-row{grid-template-columns:1fr}.task-img{justify-content:flex-start}.webinar-grid{grid-template-columns:1fr}.rb-footer{padding:24px;display:block}.rb-footer-links{margin-bottom:12px}}
    

        /* GHOST FINAL NAV BLUE HOVER/CLICK EFFECT - UI ONLY */
        .rb-nav-item:hover,
        .rb-nav-item.nav-active,
        .rb-nav-dropdown.open > .rb-nav-item,
        .rb-nav-dropdown:hover > .rb-nav-item {
            color: #2563eb !important;
        }
        .rb-nav-item:hover .fa-angle-down,
        .rb-nav-item.nav-active .fa-angle-down,
        .rb-nav-dropdown.open > .rb-nav-item .fa-angle-down,
        .rb-nav-dropdown:hover > .rb-nav-item .fa-angle-down {
            color: #2563eb !important;
        }



        /* GHOST FINAL: slightly bigger Career Goals + lower dashboard area only */
        .career-goals-section{
            margin-top:46px !important;
        }
        .career-goals-section > h2{
            font-size:27px !important;
            line-height:1.08 !important;
            margin-bottom:5px !important;
        }
        .career-goals-section > p{
            font-size:12px !important;
            margin-bottom:18px !important;
        }
        .career-goals-card{
            min-height:150px !important;
            padding:30px 54px 28px !important;
            border-radius:9px !important;
        }
        .career-goals-copy h3{
            font-size:26px !important;
            margin-bottom:9px !important;
        }
        .career-goals-copy p{
            font-size:13px !important;
            line-height:1.38 !important;
            margin-bottom:16px !important;
        }
        .career-goals-btn{
            min-width:110px !important;
            height:34px !important;
            font-size:12px !important;
        }
        .career-goals-art{
            width:260px !important;
            height:128px !important;
        }
        .career-goals-art img{
            max-height:138px !important;
        }
        .dashboard-full-section{
            margin-top:42px !important;
        }
        .dashboard-full-section .recent-head h3{
            font-size:23px !important;
        }
        .dashboard-full-section .recent-table th{
            font-size:11px !important;
            padding:12px 9px !important;
        }
        .dashboard-full-section .recent-table td{
            font-size:14.5px !important;
            padding:14px 9px !important;
        }
        .dashboard-full-section .score-pill{
            min-width:44px !important;
            height:28px !important;
            font-size:13px !important;
        }
        .dashboard-full-section .see-all a{
            font-size:18px !important;
        }
        .dashboard-full-section .webinars{
            margin-top:54px !important;
        }
        .dashboard-full-section .webinar-top h3{
            font-size:32px !important;
        }
        .dashboard-full-section .webinar-select{
            height:48px !important;
            min-width:260px !important;
            font-size:17px !important;
        }
        .dashboard-full-section .webinar-grid{
            gap:18px !important;
        }
        .dashboard-full-section .webinar-img{
            height:152px !important;
        }
        .dashboard-full-section .webinar-img i{
            font-size:50px !important;
        }
        .dashboard-full-section .webinar-card h4{
            font-size:15px !important;
            min-height:62px !important;
            padding:14px 16px 6px !important;
        }
        .dashboard-full-section .webinar-card a{
            font-size:13px !important;
            padding:0 16px 16px !important;
        }
        .rb-footer{
            margin-top:68px !important;
            font-size:13px !important;
        }


        /* GHOST NOTIFICATIONS PAGE - bell click UI only */
        .notifications-page{
            max-width:1120px;
            margin:0 auto;
            padding:72px 24px 86px;
            color:#0f172a;
        }
        .notifications-page.hidden{display:none!important;}
        .notifications-title{
            font-size:40px;
            line-height:1.1;
            font-weight:950;
            letter-spacing:.09em;
            margin:0 0 34px;
        }
        .notification-tabs{
            display:flex;
            align-items:center;
            gap:42px;
            margin-bottom:26px;
            padding-left:16px;
        }
        .notification-tab{
            border:0;
            background:transparent;
            color:#0f172a;
            font-size:18px;
            font-weight:500;
            padding:14px 18px;
            border-radius:10px;
            cursor:pointer;
            transition:background .18s ease,color .18s ease,box-shadow .18s ease;
        }
        .notification-tab:hover,
        .notification-tab.active{
            background:#f2f7ff;
            color:#2563eb;
            box-shadow:0 0 0 2px rgba(37,99,235,.12);
            font-weight:850;
        }
        .notification-box{
            min-height:420px;
            border:1px solid #d9dde7;
            background:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            padding:48px 24px;
        }
        .notification-empty-icon{
            width:34px;
            height:34px;
            margin:0 auto 22px;
            border:2px solid #fca5a5;
            border-radius:4px;
            color:#ef4444;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:16px;
        }
        .notification-panel{display:none;}
        .notification-panel.active{display:block;}
        .notification-panel h3{
            font-size:25px;
            line-height:1.2;
            font-weight:950;
            margin:0 0 14px;
            letter-spacing:.02em;
        }
        .notification-panel p{
            font-size:20px;
            line-height:1.45;
            color:#0f172a;
            margin:0 0 30px;
        }
        .notification-action{
            min-width:230px;
            min-height:58px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:999px;
            background:#c1007a;
            color:#fff;
            font-size:19px;
            font-weight:950;
            text-decoration:none;
            padding:0 34px;
            border:0;
            cursor:pointer;
            transition:transform .18s ease,background .18s ease,box-shadow .18s ease;
        }
        .notification-action:hover{
            background:#a80069;
            transform:translateY(-1px);
            box-shadow:0 12px 28px rgba(193,0,122,.18);
        }
        .rb-bell.active{color:#2563eb;}
        @media(max-width:768px){
            .notifications-page{padding:48px 16px 70px;}
            .notifications-title{font-size:30px;}
            .notification-tabs{gap:10px;flex-wrap:wrap;padding-left:0;}
            .notification-tab{font-size:15px;padding:11px 14px;}
            .notification-box{min-height:340px;}
        }



        /* GHOST FINAL COMPACT PAGE ONLY - Navbar size untouched */
        .page-wrap{
            max-width:1360px !important;
            padding:28px 56px 0 !important;
        }
        .dash-grid{
            grid-template-columns:340px minmax(0,1fr) !important;
            gap:26px !important;
        }
        .resume-card{
            min-height:560px !important;
            padding:20px 20px 24px !important;
        }
        .resume-label{font-size:12px !important;margin-bottom:9px !important;}
        .resume-select{height:46px !important;font-size:17px !important;padding:0 14px !important;}
        .primary-row{font-size:14px !important;margin:13px 0 20px !important;gap:9px !important;}
        .primary-row i{font-size:16px !important;}
        .resume-preview{height:330px !important;}
        .resume-paper{transform:scale(.48) !important;margin-top:18px !important;}
        .resume-actions a{font-size:11px !important;}
        .resume-link-row{font-size:12px !important;}

        .check-head{height:58px !important;padding:0 22px !important;}
        .check-head h2{font-size:22px !important;}
        .check-head a{font-size:17px !important;gap:9px !important;}
        .check-body{padding:18px 22px 22px !important;}
        .check-top{margin-bottom:14px !important;}
        .check-top h3{font-size:21px !important;}
        .check-top span{font-size:15px !important;}
        .task-row{
            grid-template-columns:170px minmax(0,1fr) 105px !important;
            gap:22px !important;
            padding:16px 0 !important;
        }
        .task-img{height:96px !important;}
        .resume-stack{width:145px !important;height:92px !important;}
        .sheet{width:82px !important;height:105px !important;}
        .strength-box{width:145px !important;padding:10px 12px !important;}
        .strength-box h5{font-size:11px !important;margin-bottom:5px !important;}
        .strength-box p{font-size:10px !important;margin:4px 0 !important;}
        .cover-icon{width:145px !important;height:92px !important;font-size:36px !important;}
        .task-content h4{font-size:17px !important;margin-bottom:7px !important;}
        .task-content p{font-size:14px !important;line-height:1.28 !important;margin-bottom:10px !important;}
        .pink-btn{min-width:158px !important;height:34px !important;font-size:12px !important;}
        .outline-btn{min-width:125px !important;height:34px !important;font-size:12px !important;}
        .incomplete{font-size:12px !important;gap:6px !important;}
        .dot{width:8px !important;height:8px !important;}

        .career-goals-section{margin-top:30px !important;}
        .career-goals-section > h2{font-size:22px !important;margin-bottom:3px !important;}
        .career-goals-section > p{font-size:10px !important;margin-bottom:12px !important;}
        .career-goals-card{min-height:118px !important;padding:22px 38px 20px !important;}
        .career-goals-copy h3{font-size:21px !important;margin-bottom:6px !important;}
        .career-goals-copy p{font-size:10.5px !important;margin-bottom:11px !important;line-height:1.25 !important;}
        .career-goals-btn{min-width:92px !important;height:28px !important;font-size:10px !important;}
        .career-goals-art{width:205px !important;height:100px !important;}
        .career-goals-art img{max-height:108px !important;}

        .dashboard-full-section{margin-top:28px !important;}
        .dashboard-full-section .recent-head{margin-bottom:8px !important;}
        .dashboard-full-section .recent-head h3{font-size:20px !important;}
        .dashboard-full-section .recent-table th{font-size:9px !important;padding:8px 7px !important;}
        .dashboard-full-section .recent-table td{font-size:11.5px !important;padding:10px 7px !important;}
        .dashboard-full-section .score-pill{min-width:34px !important;height:22px !important;font-size:10px !important;}
        .dashboard-full-section .see-all{margin-top:14px !important;}
        .dashboard-full-section .see-all a{font-size:14px !important;}
        .dashboard-full-section .webinars{margin-top:34px !important;}
        .dashboard-full-section .webinar-top{margin-bottom:12px !important;}
        .dashboard-full-section .webinar-top h3{font-size:26px !important;letter-spacing:.04em !important;}
        .dashboard-full-section .webinar-select{height:38px !important;min-width:210px !important;font-size:13px !important;padding:0 12px !important;}
        .dashboard-full-section .webinar-grid{gap:13px !important;}
        .dashboard-full-section .webinar-img{height:112px !important;}
        .dashboard-full-section .webinar-img i{font-size:38px !important;}
        .dashboard-full-section .webinar-card h4{font-size:11.5px !important;min-height:46px !important;padding:10px 12px 4px !important;line-height:1.18 !important;}
        .dashboard-full-section .webinar-card a{font-size:10.5px !important;padding:0 12px 12px !important;}
        .rb-footer{margin-top:44px !important;padding:18px 56px 22px !important;font-size:11px !important;}

        /* Notification page compact only, navbar unchanged */
        .notifications-page{
            max-width:860px !important;
            padding:42px 18px 56px !important;
        }
        .notifications-title{
            font-size:30px !important;
            margin-bottom:22px !important;
            letter-spacing:.06em !important;
        }
        .notification-tabs{
            gap:22px !important;
            margin-bottom:16px !important;
            padding-left:8px !important;
        }
        .notification-tab{
            font-size:14px !important;
            padding:9px 12px !important;
            border-radius:8px !important;
        }
        .notification-box{
            min-height:290px !important;
            padding:30px 18px !important;
        }
        .notification-empty-icon{
            width:28px !important;
            height:28px !important;
            margin-bottom:14px !important;
            font-size:13px !important;
        }
        .notification-panel h3{
            font-size:18px !important;
            margin-bottom:8px !important;
        }
        .notification-panel p{
            font-size:14px !important;
            line-height:1.32 !important;
            margin-bottom:18px !important;
        }
        .notification-action{
            min-width:170px !important;
            min-height:42px !important;
            font-size:14px !important;
            padding:0 24px !important;
        }



        /* GHOST UPDATE: Career Goals + lower content slightly bigger, footer untouched */
        .career-goals-section{margin-top:36px !important;}
        .career-goals-section > h2{font-size:26px !important;margin-bottom:5px !important;}
        .career-goals-section > p{font-size:12px !important;margin-bottom:15px !important;}
        .career-goals-card{min-height:145px !important;padding:28px 46px 26px !important;}
        .career-goals-copy h3{font-size:25px !important;margin-bottom:8px !important;}
        .career-goals-copy p{font-size:12.5px !important;margin-bottom:14px !important;line-height:1.35 !important;}
        .career-goals-btn{min-width:112px !important;height:34px !important;font-size:11.5px !important;}
        .career-goals-art{width:245px !important;height:122px !important;}
        .career-goals-art img{max-height:130px !important;}

        .dashboard-full-section{margin-top:34px !important;}
        .dashboard-full-section .recent-head{margin-bottom:11px !important;}
        .dashboard-full-section .recent-head h3{font-size:24px !important;}
        .dashboard-full-section .recent-table th{font-size:11px !important;padding:10px 8px !important;}
        .dashboard-full-section .recent-table td{font-size:13.5px !important;padding:13px 8px !important;}
        .dashboard-full-section .score-pill{min-width:40px !important;height:26px !important;font-size:11.5px !important;}
        .dashboard-full-section .see-all{margin-top:17px !important;}
        .dashboard-full-section .see-all a{font-size:16px !important;}
        .dashboard-full-section .webinars{margin-top:43px !important;}
        .dashboard-full-section .webinar-top{margin-bottom:15px !important;}
        .dashboard-full-section .webinar-top h3{font-size:31px !important;letter-spacing:.045em !important;}
        .dashboard-full-section .webinar-select{height:43px !important;min-width:235px !important;font-size:15px !important;padding:0 14px !important;}
        .dashboard-full-section .webinar-grid{gap:16px !important;}
        .dashboard-full-section .webinar-img{height:132px !important;}
        .dashboard-full-section .webinar-img i{font-size:45px !important;}
        .dashboard-full-section .webinar-card h4{font-size:13px !important;min-height:54px !important;padding:12px 14px 5px !important;line-height:1.24 !important;}
        .dashboard-full-section .webinar-card a{font-size:12px !important;padding:0 14px 14px !important;}

</style>
</head>
<body class="font-sans antialiased">
    <nav class="rb-navbar">
        <div class="rb-nav-left">
            <a href="/dashboard" class="rb-brand"><i class="fa-solid fa-layer-group"></i><span>Resume Builder</span></a>
            <div id="navLinks" class="rb-nav-links">
                <a href="/jobs" id="nav-jobs" class="nav-item rb-nav-item">Jobs</a>
                <div class="rb-nav-dropdown">
                    <a href="#" id="nav-documents" class="nav-item rb-nav-item">Documents <i class="fa-solid fa-angle-down text-xs"></i></a>
                    <div class="rb-mega">
                        <div class="rb-mega-inner">
                            <div class="rb-mega-art"><img src="/images/Document.png.png" alt="Documents"></div>
                            <div class="rb-mega-col">
                                <a href="#" class="rb-mega-link">
                                    <span><h4>Resumes</h4><p>Create, edit, and access all your resumes in one convenient place.</p></span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <a href="#" class="rb-mega-link">
                                    <span><h4>Cover Letters</h4><p>Easily craft cover letters that align with the job description and your resume.</p></span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </div>
                            <div class="rb-mega-col">
                                <a href="#" class="rb-mega-link">
                                    <span><h4>Resume Check</h4><p>Check your resume for grammar, structure, and clarity with ease.</p></span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                                <a href="#" class="rb-mega-link">
                                    <span><h4>Feedback Tool</h4><p>Get feedback from people you trust to improve your resume.</p></span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rb-nav-dropdown">
                    <a href="#" id="nav-resources" class="nav-item rb-nav-item">Resources <i class="fa-solid fa-angle-down text-xs"></i></a>
                    <div class="rb-mega">
                        <div class="rb-mega-inner">
                            <div class="rb-mega-art"><img src="/images/Resources.png.png" alt="Resources"></div>
                            <div class="rb-mega-col">
                                <a href="#" class="rb-mega-link">
                                    <span><h4>Interview Prep</h4><p>Discover career tips and expert articles to help you tackle challenges throughout your professional journey.</p></span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </div>
                            <div class="rb-mega-col">
                                <a href="#" class="rb-mega-link">
                                    <span><h4>Webinars</h4><p>Check out expert webinars for tools, insights, and strategies to succeed in a competitive job market.</p></span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rb-nav-dropdown">
                    <a href="#" id="nav-boldpro" class="nav-item rb-nav-item">Bold.Pro <i class="fa-solid fa-angle-down text-xs"></i></a>
                    <div class="rb-mega">
                        <div class="rb-mega-inner">
                            <div class="rb-mega-art"><img src="/images/BOLDPRO.png.png" alt="Bold Pro"></div>
                            <div class="rb-mega-col">
                                <a href="#" class="rb-mega-link">
                                    <span><h4>Professional Profile</h4><p>Turn your resume into a Professional Profile with one click and get found by recruiters online.</p></span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </div>
                            <div class="rb-mega-col">
                                <a href="#" class="rb-mega-link">
                                    <span><h4>Profile Analytics</h4><p>Check who's interested in your Profile in the Analytics Panel.</p></span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rb-right">
            <button id="notificationBell" type="button" class="rb-bell" aria-label="Open notifications"><i class="fa-solid fa-bell"></i></button>
            <div class="relative">
                <button id="profileBtn" type="button">
                    <i class="fa-solid fa-user"></i>
                    <span id="userDisplayName">Loading...</span>
                    <i class="fa-solid fa-angle-down text-xs"></i>
                </button>
                <div id="dropdownMenu" class="hidden">
                    <a href="/settings" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-purple-600"><i class="fa-solid fa-gear mr-2"></i> Settings</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-purple-600"><i class="fa-solid fa-headset mr-2"></i> Contact Us</a>
                    <div class="border-t border-gray-100 my-2"></div>
                    <button onclick="logoutUser()" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Sign Out</button>
                </div>
            </div>
        </div>
    </nav>

    <main class="page-wrap">
        <div class="dash-grid">
            <aside class="resume-card">
                <div class="resume-label">Resume</div>
                <div class="resume-select"><span id="resumeNameShort">ARMAGHAN_SHAHZAD_Re...</span><i class="fa-solid fa-caret-down text-gray-500"></i></div>
                <div class="primary-row"><i class="fa-solid fa-star"></i><span>This is your <b>primary</b> resume</span></div>
                <div class="resume-preview">
                    <div class="resume-paper">
                        <h3>ARMAGHAN SHAHZAD</h3>
                        <p>Talagang Pakistan</p>
                        <p>+92305-56221 &nbsp;&nbsp;&nbsp;&nbsp; 23-se-073@student.hitecuni.edu.pk</p>
                        <div class="paper-line"></div>
                        <div class="paper-section"></div><div class="paper-section short"></div><div class="paper-section"></div><div class="paper-section short"></div>
                    </div>
                </div>
                <a href="/builder-intro" class="mt-6 w-full h-12 border-2 border-blue-700 text-blue-700 font-black rounded hover:bg-blue-50 transition flex items-center justify-center text-[15px]"><i class="fa-solid fa-plus mr-2"></i> Create New Resume</a>
            </aside>

            <section class="min-w-0">
                <div class="check-card">
                    <div class="check-head">
                        <h2>Your Checklist</h2>
                        <a href="#">View all features <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="check-body">
                        <div class="check-top">
                            <h3>Get ready to apply</h3>
                            <span>Completed&nbsp; <b>0 of 4</b></span>
                        </div>
                        <div class="task-row">
                            <div class="task-img"><div class="resume-stack"><div class="sheet"></div><div class="sheet"></div><div class="sheet"></div></div></div>
                            <div class="task-content"><h4>Get your resume</h4><p>Congratulations, your resume is ready!</p><a href="/builder-intro" class="pink-btn">Download resume</a></div>
                            <div class="incomplete"><span class="dot"></span> Incomplete</div>
                        </div>
                        <div class="task-row">
                            <div class="task-img"><div class="strength-box"><h5><span>Resume Strength</span><span>15</span></h5><p><i class="fa-solid fa-circle-exclamation"></i>Contact Information</p><p><i class="fa-solid fa-circle-exclamation"></i>Professional Summary</p><p><i class="fa-solid fa-circle-exclamation"></i>Skills</p><p><i class="fa-solid fa-circle-exclamation"></i>Work History</p><p><i class="fa-solid fa-circle-exclamation"></i>Education</p></div></div>
                            <div class="task-content"><h4>Check out your resume score</h4><p>We found 5 errors in your resume. Use our Resume Check tool to fix them.</p><button type="button" class="outline-btn">Fix resume</button></div>
                            <div class="incomplete"><span class="dot"></span> Incomplete</div>
                        </div>
                        <div class="task-row">
                            <div class="task-img"><div class="cover-icon"><i class="fa-regular fa-envelope-open"></i></div></div>
                            <div class="task-content"><h4>Create a cover letter</h4><p>Personalize your application and communicate directly with hiring managers.</p><button type="button" class="outline-btn">Create letter</button></div>
                            <div class="incomplete"><span class="dot"></span> Incomplete</div>
                        </div>
                    </div>
                </div>

            </section>
        </div>

        <section class="career-goals-section">
            <h2>Career Goals</h2>
            <p>Use this section to map out your journey.</p>
            <div class="career-goals-card">
                <div class="career-goals-copy">
                    <h3>Let’s set your career goals</h3>
                    <p>We’ll help you figure out your path and guide you through the process.</p>
                    <a href="#" class="career-goals-btn">Get started</a>
                </div>
                <div class="career-goals-art">
                    <img src="/images/CareerGoals.png.png" alt="Career Goals">
                </div>
            </div>
        </section>

        <div class="dashboard-full-section">
            <div class="recent-wrap">
                    <div class="recent-head"><h3>Recent Resumes</h3></div>
                    <table class="recent-table">
                        <thead><tr><th>Resume</th><th>Created</th><th>Modified</th><th>Feedback</th><th>Score</th><th>Check</th><th>Edit</th></tr></thead>
                        <tbody>
                            <tr><td><b>ARMAGHAN...</b></td><td>06/06/2026</td><td>06/06/2026</td><td><a href="#"><i class="fa-regular fa-message mr-1"></i> Share for Feedback</a></td><td><span class="score-pill">15</span></td><td><a href="#"><i class="fa-regular fa-circle-check mr-1"></i> Check</a></td><td><a href="#"><i class="fa-solid fa-pen mr-1"></i> Edit</a></td></tr>
                            <tr><td><b>ARMAGHAN...</b></td><td>06/06/2026</td><td>31/05/2026</td><td><a href="#"><i class="fa-regular fa-message mr-1"></i> Share for Feedback</a></td><td><span class="score-pill">32</span></td><td><a href="#"><i class="fa-regular fa-circle-check mr-1"></i> Check</a></td><td><a href="#"><i class="fa-solid fa-pen mr-1"></i> Edit</a></td></tr>
                            <tr><td><b>ARMAGHAN...</b></td><td>02/06/2026</td><td>02/06/2026</td><td><a href="#"><i class="fa-regular fa-message mr-1"></i> Share for Feedback</a></td><td><span class="score-pill">15</span></td><td><a href="#"><i class="fa-regular fa-circle-check mr-1"></i> Check</a></td><td><a href="#"><i class="fa-solid fa-pen mr-1"></i> Edit</a></td></tr>
                        </tbody>
                    </table>
                    <div class="see-all"><a href="#">See all resumes <i class="fa-solid fa-arrow-right"></i></a></div>
                </div>

                <div class="webinars">
                    <div class="webinar-top"><h3>Recommended Webinars</h3><div class="webinar-select">Recommended For you <i class="fa-solid fa-caret-down text-slate-500"></i></div></div>
                    <div class="webinar-grid">
                        <div class="webinar-card"><div class="webinar-img"><img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=600&q=80" alt="Webinar"><i class="fa-regular fa-circle-play"></i></div><h4>How to Determine if a Company has the Culture You Want</h4><a href="#"><i class="fa-solid fa-tv mr-1"></i> Watch Video</a></div>
                        <div class="webinar-card"><div class="webinar-img"><img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=600&q=80" alt="Webinar"><i class="fa-regular fa-circle-play"></i></div><h4>Create a Winning Personal Brand to Land Your Next Job</h4><a href="#"><i class="fa-solid fa-tv mr-1"></i> Watch Video</a></div>
                        <div class="webinar-card"><div class="webinar-img"><img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=80" alt="Webinar"><i class="fa-regular fa-circle-play"></i></div><h4>How to Get the Salary You Deserve</h4><a href="#"><i class="fa-solid fa-tv mr-1"></i> Watch Video</a></div>
                    </div>
                </div>
        </div>
    </main>

    <section id="notificationsPage" class="notifications-page hidden">
        <h1 class="notifications-title">Notifications</h1>
        <div class="notification-tabs" role="tablist" aria-label="Notification tabs">
            <button type="button" class="notification-tab active" data-notification-tab="all">All</button>
            <button type="button" class="notification-tab" data-notification-tab="documents">Documents</button>
            <button type="button" class="notification-tab" data-notification-tab="jobs">Jobs</button>
            <button type="button" class="notification-tab" data-notification-tab="profile">Profile</button>
        </div>

        <div class="notification-box">
            <div class="notification-panel active" data-notification-panel="all">
                <div class="notification-empty-icon"><i class="fa-regular fa-id-card"></i></div>
                <h3>You're all caught up!</h3>
                <p>When we have relevant updates for you,<br>you'll find them here.</p>
                <button type="button" id="backToDashboardBtn" class="notification-action">Back to Dashboard</button>
            </div>

            <div class="notification-panel" data-notification-panel="documents">
                <div class="notification-empty-icon"><i class="fa-regular fa-file-lines"></i></div>
                <h3>You're all caught up!</h3>
                <p>No document notifications right now.</p>
            </div>

            <div class="notification-panel" data-notification-panel="jobs">
                <div class="notification-empty-icon"><i class="fa-solid fa-briefcase"></i></div>
                <h3>You're all caught up!</h3>
                <p>No job notifications right now. You can open the Jobs page from here.</p>
                <a href="/jobs" class="notification-action">Go to Jobs</a>
            </div>

            <div class="notification-panel" data-notification-panel="profile">
                <div class="notification-empty-icon"><i class="fa-regular fa-user"></i></div>
                <h3>You're all caught up!</h3>
                <p>No profile notifications right now.</p>
            </div>
        </div>
    </section>


    <footer class="rb-footer">
        <div class="rb-footer-links">
            <a href="/legal#terms" target="_blank">Terms & Conditions</a>
            <a href="/legal#privacy" target="_blank">Privacy Policy</a>
            <a href="/legal#accessibility" target="_blank">Accessibility</a>
            <a href="/legal#contact" target="_blank">Contact Us</a>
        </div>
        <div>&copy; 2026, Bold Limited. All rights reserved.</div>
    </footer>

    <script>
        const token = localStorage.getItem('resume_token');
        if (!token) window.location.href = '/login'; 

        async function fetchUserProfile() {
            try {
                const response = await fetch('http://localhost:5000/api/auth/profile', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token 
                    }
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById('userDisplayName').innerText = data.user.name;
                } else {
                    localStorage.removeItem('resume_token');
                    window.location.href = '/login';
                }
            } catch (error) {
                console.error("Failed to load user profile:", error);
                document.getElementById('userDisplayName').innerText = "Guest";
            }
        }

        fetchUserProfile();


        const dashboardPage = document.querySelector('.page-wrap');
        const notificationsPage = document.getElementById('notificationsPage');
        const notificationBell = document.getElementById('notificationBell');
        const backToDashboardBtn = document.getElementById('backToDashboardBtn');

        function showDashboardPage() {
            dashboardPage.classList.remove('hidden');
            notificationsPage.classList.add('hidden');
            notificationBell.classList.remove('active');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showNotificationsPage(defaultTab = 'all') {
            dashboardPage.classList.add('hidden');
            notificationsPage.classList.remove('hidden');
            notificationBell.classList.add('active');
            activateNotificationTab(defaultTab);
            dropdownMenu.classList.add('hidden');
            document.querySelectorAll('.rb-nav-dropdown').forEach(drop => {
                drop.classList.remove('open');
                const nav = drop.querySelector('.rb-nav-item');
                if (nav) nav.classList.remove('nav-active');
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function activateNotificationTab(tabName) {
            document.querySelectorAll('[data-notification-tab]').forEach(tab => {
                tab.classList.toggle('active', tab.dataset.notificationTab === tabName);
            });
            document.querySelectorAll('[data-notification-panel]').forEach(panel => {
                panel.classList.toggle('active', panel.dataset.notificationPanel === tabName);
            });
        }

        notificationBell.addEventListener('click', (e) => {
            e.stopPropagation();
            showNotificationsPage('all');
        });

        document.querySelectorAll('[data-notification-tab]').forEach(tab => {
            tab.addEventListener('click', () => activateNotificationTab(tab.dataset.notificationTab));
        });

        backToDashboardBtn.addEventListener('click', showDashboardPage);

        const profileBtn = document.getElementById('profileBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        document.querySelectorAll('.rb-nav-dropdown > .rb-nav-item').forEach(item => {
            item.addEventListener('click', function(e){
                e.preventDefault();
                e.stopPropagation();

                const clickedDropdown = this.parentElement;
                const wasOpen = clickedDropdown.classList.contains('open');

                document.querySelectorAll('.rb-nav-dropdown').forEach(drop => {
                    drop.classList.remove('open');
                    const nav = drop.querySelector('.rb-nav-item');
                    if (nav) nav.classList.remove('nav-active');
                });

                if (!wasOpen) {
                    clickedDropdown.classList.add('open');
                    this.classList.add('nav-active');
                }
            });
        });

        document.querySelectorAll('.rb-nav-item').forEach(item => {
            item.addEventListener('mouseenter', function(){
                this.classList.add('nav-hovering');
            });
            item.addEventListener('mouseleave', function(){
                this.classList.remove('nav-hovering');
            });
        });

        document.querySelectorAll('.rb-mega').forEach(menu => {
            menu.addEventListener('click', function(e){
                e.stopPropagation();
            });
        });

        window.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
            document.querySelectorAll('.rb-nav-dropdown').forEach(drop => {
                drop.classList.remove('open');
                const nav = drop.querySelector('.rb-nav-item');
                if (nav) nav.classList.remove('nav-active');
            });
        });

        function logoutUser() {
            localStorage.removeItem('resume_token');
            window.location.href = '/login';
        }
    </script>
</body>
</html>
