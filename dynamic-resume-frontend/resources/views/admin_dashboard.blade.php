<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dynamic Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const token = localStorage.getItem("adminToken");

            if (!token) {
                alert("Admin access required. Please login first.");
                window.location.href = "/";
                return;
            }

            const adminEmail = localStorage.getItem("adminEmail") || "Admin";

            const emailNode = document.getElementById("adminEmailText");
            const profileEmailNode = document.getElementById("profileEmailText");

            if (emailNode) {
                emailNode.textContent = adminEmail;
            }

            if (profileEmailNode) {
                profileEmailNode.textContent = adminEmail;
            }
        });

        function adminLogout() {
            localStorage.removeItem("adminToken");
            localStorage.removeItem("adminEmail");
            window.location.href = "/";
        }

        function showProgress(buttonName) {
            alert("This button " + buttonName + " is in progress");
        }

        function toggleAdminProfileMenu() {
            const menu = document.getElementById("adminProfileMenu");
            if (menu) {
                menu.classList.toggle("hidden");
            }
        }

        function openTemplateUploadBox() {
            const box = document.getElementById("templateUploadBox");
            if (box) {
                box.classList.remove("hidden");
                box.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        }

        function previewSelectedTemplate(event) {
    const file = event.target.files[0];
    const fileNameNode = document.getElementById("selectedTemplateFileName");
    const previewNode = document.getElementById("templatePreviewImage");
    const placeholder = document.getElementById("templatePreviewPlaceholder");

    if (!file) {
        return;
    }

    if (fileNameNode) {
        fileNameNode.textContent = file.name;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        if (previewNode) {
            previewNode.src = e.target.result;
            previewNode.classList.remove("hidden");
        }

        if (placeholder) {
            placeholder.classList.add("hidden");
        }
    };

    reader.readAsDataURL(file);
}

        async function submitTemplateDemo() {
    const name = document.getElementById("templateName").value.trim();
    const category = document.getElementById("templateCategory").value.trim();
    const file = document.getElementById("templateImage").files[0];

    if (!name || !category || !file) {
        alert("Please enter template name, category and select template image.");
        return;
    }

    const layoutKey = document.getElementById("templateLayoutKey")?.value || "modern_sidebar";
    const defaultColor = document.getElementById("templateDefaultColor")?.value || "#2563eb";

    const formData = new FormData();
    formData.append("name", name);
    formData.append("category", category);
    formData.append("layout_key", layoutKey);
    formData.append("default_color", defaultColor);
    formData.append("has_photo", document.getElementById("templateHasPhoto").value);
    formData.append("column_count", document.getElementById("templateColumnCount").value);
    formData.append("templateImage", file);

    try {
        const response = await fetch("http://localhost:5000/api/templates/upload", {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            alert("Template uploaded successfully. Now it will show on user side.");

            document.getElementById("templateName").value = "";
            document.getElementById("templateCategory").value = "";
            document.getElementById("templateImage").value = "";
            document.getElementById("selectedTemplateFileName").textContent = "No file selected";

            const previewNode = document.getElementById("templatePreviewImage");
            const placeholder = document.getElementById("templatePreviewPlaceholder");

            if (previewNode) {
                previewNode.src = "";
                previewNode.classList.add("hidden");
            }

            if (placeholder) {
                placeholder.classList.remove("hidden");
            }
        } else {
            alert(data.message || "Template upload failed.");
        }
    } catch (error) {
        console.error("Template upload error:", error);
        alert("Backend connection failed. Make sure Node server is running.");
    }
}

        window.addEventListener("click", function (event) {
            const profileBox = document.getElementById("adminProfileBox");
            const profileMenu = document.getElementById("adminProfileMenu");

            if (profileBox && profileMenu && !profileBox.contains(event.target)) {
                profileMenu.classList.add("hidden");
            }
        });
    </script>
<style>

        /* GHOST FINAL ADMIN POLISH: template upload stays thumbnail + editable layout metadata */
        #templateUploadBox {
            scroll-margin-top: 110px;
        }
        #templateUploadBox input,
        #templateUploadBox select {
            transition: all .2s ease;
        }
        #templateUploadBox input:focus,
        #templateUploadBox select:focus {
            box-shadow: 0 0 0 4px rgba(124, 58, 237, .12);
        }
        #templatePreviewImage {
            max-width: 82% !important;
            max-height: 330px !important;
            object-fit: contain !important;
            background: #f8fafc;
        }
</style></head>

<body class="bg-[#f4f7fb] text-slate-900 min-h-screen">

    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-slate-200 shadow-xl p-4 hidden lg:flex flex-col z-50">

        <div class="flex items-center gap-3 mb-7">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-600 via-violet-600 to-fuchsia-600 flex items-center justify-center shadow-lg shadow-violet-200">
                <i class="fa-solid fa-layer-group text-white text-lg"></i>
            </div>

            <div>
                <h1 class="text-lg font-black leading-tight text-slate-950">Admin Panel</h1>
                <p class="text-[11px] text-slate-500 font-semibold">Dynamic Resume Builder</p>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-50 to-fuchsia-50 border border-indigo-100 rounded-2xl p-3 mb-5">
            <p class="text-[11px] text-indigo-700 font-black uppercase tracking-wider">Control Mode</p>
            <p class="text-xs text-slate-600 mt-1">Admin workspace is active and protected.</p>
        </div>

        <nav class="space-y-2 flex-1">

            <button onclick="showProgress('Dashboard')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-slate-950 text-white font-bold text-sm text-left shadow-md">
                <i class="fa-solid fa-chart-line w-4 text-fuchsia-300"></i>
                Dashboard
            </button>

            <button onclick="showProgress('Users')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-indigo-50 text-slate-700 font-bold text-sm transition text-left">
                <i class="fa-solid fa-users w-4 text-indigo-600"></i>
                Users
            </button>

            <button onclick="showProgress('Resumes')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-blue-50 text-slate-700 font-bold text-sm transition text-left">
                <i class="fa-solid fa-file-lines w-4 text-blue-600"></i>
                Resumes
            </button>

            <button onclick="showProgress('Jobs')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-emerald-50 text-slate-700 font-bold text-sm transition text-left">
                <i class="fa-solid fa-briefcase w-4 text-emerald-600"></i>
                Jobs
            </button>

            <button onclick="openTemplateUploadBox()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-violet-50 text-slate-700 font-bold text-sm transition text-left">
                <i class="fa-solid fa-palette w-4 text-violet-600"></i>
                Templates
            </button>

            <button onclick="showProgress('Complaints')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-amber-50 text-slate-700 font-bold text-sm transition text-left">
                <i class="fa-solid fa-flag w-4 text-amber-600"></i>
                Complaints
            </button>

            <button onclick="showProgress('Settings')" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-100 text-slate-700 font-bold text-sm transition text-left">
                <i class="fa-solid fa-gear w-4 text-slate-600"></i>
                Settings
            </button>

        </nav>

        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3 mb-3">
            <p class="text-[11px] text-slate-500 mb-1 font-bold">Admin Security</p>
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-700">Protected Mode</span>
                <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black">ON</span>
            </div>
        </div>

        <button onclick="adminLogout()" class="w-full px-3 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-black text-sm transition shadow-md">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>
            Logout
        </button>
    </aside>

    <main class="lg:ml-64 min-h-screen p-4 lg:p-6">

        <header class="sticky top-0 z-40 bg-[#f4f7fb]/90 backdrop-blur-xl border-b border-slate-200 -mx-4 lg:-mx-6 px-4 lg:px-6 py-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                <div>
                    <p class="text-xs text-violet-700 font-black uppercase tracking-[0.22em]">Admin Workspace</p>
                    <h2 class="text-2xl lg:text-3xl font-black mt-1 text-slate-950">Welcome Admin</h2>
                    <p class="text-slate-500 mt-1 text-sm font-medium">Manage users, resumes, templates, jobs and system health.</p>
                </div>

                <div id="adminProfileBox" class="relative">
                    <button onclick="toggleAdminProfileMenu()" class="flex items-center gap-3 bg-white border border-slate-200 rounded-2xl px-4 py-3 hover:border-violet-300 transition shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-600 to-fuchsia-600 flex items-center justify-center text-white">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>

                        <div class="text-left hidden sm:block">
                            <p class="text-[11px] text-slate-500 font-bold">Logged in as admin</p>
                            <p id="adminEmailText" class="font-black text-violet-700 text-sm">Admin</p>
                        </div>

                        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                    </button>

                    <div id="adminProfileMenu" class="hidden absolute right-0 mt-3 w-72 bg-white border border-slate-200 rounded-2xl shadow-2xl overflow-hidden">

                        <div class="p-4 border-b border-slate-100 bg-gradient-to-r from-violet-50 to-fuchsia-50">
                            <p class="text-xs text-slate-500 font-bold">Admin Profile</p>
                            <p id="profileEmailText" class="text-sm font-black text-slate-950 break-all">Admin</p>
                        </div>

                        <button onclick="showProgress('Update Profile')" class="w-full px-4 py-3 text-left text-sm font-bold hover:bg-slate-50 transition text-slate-700">
                            <i class="fa-solid fa-user-pen mr-2 text-violet-600"></i>
                            Update Profile
                        </button>

                        <button onclick="showProgress('Settings')" class="w-full px-4 py-3 text-left text-sm font-bold hover:bg-slate-50 transition text-slate-700">
                            <i class="fa-solid fa-sliders mr-2 text-blue-600"></i>
                            Settings
                        </button>

                        <button onclick="showProgress('Complaints')" class="w-full px-4 py-3 text-left text-sm font-bold hover:bg-slate-50 transition text-slate-700">
                            <i class="fa-solid fa-flag mr-2 text-amber-500"></i>
                            Complaints
                        </button>

                        <button onclick="adminLogout()" class="w-full px-4 py-3 text-left text-sm font-black text-red-600 hover:bg-red-50 transition">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>
                            Logout
                        </button>
                    </div>
                </div>

            </div>
        </header>

        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

            <button onclick="showProgress('Users')" class="text-left bg-white border border-slate-200 rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-xl transition">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-950">Users</h3>
                <p class="text-slate-500 text-xs mt-1 font-medium">Manage registered users.</p>
            </button>

            <button onclick="showProgress('Resumes')" class="text-left bg-white border border-slate-200 rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-xl transition">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-950">Resumes</h3>
                <p class="text-slate-500 text-xs mt-1 font-medium">View and control resumes.</p>
            </button>

            <button onclick="showProgress('Jobs')" class="text-left bg-white border border-slate-200 rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-xl transition">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-950">Jobs</h3>
                <p class="text-slate-500 text-xs mt-1 font-medium">Manage job listings.</p>
            </button>

            <button onclick="openTemplateUploadBox()" class="text-left bg-white border border-slate-200 rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-xl transition">
                <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-950">Templates</h3>
                <p class="text-slate-500 text-xs mt-1 font-medium">Upload and control templates.</p>
            </button>

        </section>

        <section class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">

            <div class="xl:col-span-2 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-black text-slate-950">Admin Controls</h3>
                        <p class="text-xs text-slate-500 font-medium">Main modules will be connected one by one.</p>
                    </div>
                    <button onclick="showProgress('All Controls')" class="text-xs font-black text-violet-700 hover:underline">View all</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-3 border border-slate-200">
                        <div>
                            <h4 class="font-black text-sm text-slate-950">User Management</h4>
                            <p class="text-xs text-slate-500">View, block, or manage users.</p>
                        </div>
                        <button onclick="showProgress('User Management')" class="px-3 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs">Open</button>
                    </div>

                    <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-3 border border-slate-200">
                        <div>
                            <h4 class="font-black text-sm text-slate-950">Template Management</h4>
                            <p class="text-xs text-slate-500">Add or update templates.</p>
                        </div>
                        <button onclick="openTemplateUploadBox()" class="px-3 py-2 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-black text-xs">Open</button>
                    </div>

                    <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-3 border border-slate-200">
                        <div>
                            <h4 class="font-black text-sm text-slate-950">Job Management</h4>
                            <p class="text-xs text-slate-500">Control jobs and applications.</p>
                        </div>
                        <button onclick="showProgress('Job Management')" class="px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs">Open</button>
                    </div>

                    <div class="flex justify-between items-center bg-slate-50 rounded-2xl p-3 border border-slate-200">
                        <div>
                            <h4 class="font-black text-sm text-slate-950">Complaints</h4>
                            <p class="text-xs text-slate-500">Review user complaints.</p>
                        </div>
                        <button onclick="showProgress('Complaints')" class="px-3 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs">Open</button>
                    </div>

                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <h3 class="text-lg font-black mb-4 text-slate-950">System Status</h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 text-sm font-bold">Frontend</span>
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-black">Active</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 text-sm font-bold">Node Backend</span>
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-black">Connected</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 text-sm font-bold">MySQL Database</span>
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-black">Ready</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 text-sm font-bold">Admin Auth</span>
                        <span class="px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-black">Secured</span>
                    </div>
                </div>
            </div>

        </section>

        <section id="templateUploadBox" class="hidden bg-white border border-violet-200 rounded-3xl p-5 shadow-lg mb-6">
            <div class="flex flex-col xl:flex-row gap-6">

                <div class="xl:w-1/2">
                    <p class="text-xs text-violet-700 font-black uppercase tracking-[0.2em]">Template Upload</p>
                    <h3 class="text-2xl font-black text-slate-950 mt-1">Upload First Resume Template</h3>
                    <p class="text-sm text-slate-500 mt-2 font-medium">
                        Start with one template. Later we will connect this with database and user side template pages.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
                        <div>
                            <label class="block text-xs font-black text-slate-600 mb-2">Template Name</label>
                            <input id="templateName" type="text" placeholder="Modern Professional" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold outline-none focus:border-violet-400">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-600 mb-2">Template Category</label>
                            <select id="templateCategory" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold outline-none focus:border-violet-400">
                                <option value="">Select Category</option>
                                <option value="Professional">Professional</option>
                                <option value="Modern">Modern</option>
                                <option value="Creative">Creative</option>
                                <option value="Minimal">Minimal</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-xs font-black text-slate-600 mb-2">Editable Layout Type</label>
                            <select id="templateLayoutKey" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold outline-none focus:border-violet-400">
                                <option value="modern_sidebar">Modern Sidebar - Editable</option>
                            </select>
                            <p class="text-[11px] text-slate-500 font-semibold mt-1">Image is only thumbnail. This layout is used for live editing.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-600 mb-2">Default Accent Color</label>
                            <input id="templateDefaultColor" type="color" value="#2563eb" class="w-full h-[46px] rounded-xl border border-slate-200 bg-slate-50 px-2 py-2 outline-none focus:border-violet-400">
                            <p class="text-[11px] text-slate-500 font-semibold mt-1">User can change this color in preview later.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Photo Type</label>
                            <select id="templateHasPhoto" name="has_photo" class="w-full border rounded-lg px-4 py-3">
                                <option value="0">Without Photo</option>
                                <option value="1">With Photo</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Column Type</label>
                            <select id="templateColumnCount" name="column_count" class="w-full border rounded-lg px-4 py-3">
                                <option value="1">1 Column</option>
                                <option value="2">2 Columns</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-black text-slate-600 mb-2">Template Image / Preview</label>
                        <input id="templateImage" type="file" accept="image/*" onchange="previewSelectedTemplate(event)" class="w-full rounded-xl border border-dashed border-violet-300 bg-violet-50 px-4 py-3 text-sm font-bold text-slate-700">
                        <p id="selectedTemplateFileName" class="text-xs text-slate-500 font-bold mt-2">No file selected</p>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <button onclick="submitTemplateDemo()" class="px-5 py-3 rounded-xl bg-violet-600 hover:bg-violet-700 text-white text-sm font-black shadow-md">
                            <i class="fa-solid fa-upload mr-2"></i>
                            Upload Template
                        </button>

                        <button onclick="showProgress('Connect Template with User Side')" class="px-5 py-3 rounded-xl bg-slate-950 hover:bg-slate-800 text-white text-sm font-black shadow-md">
                            <i class="fa-solid fa-link mr-2"></i>
                            Connect User Side
                        </button>
                    </div>
                </div>

                <div class="xl:w-1/2 bg-gradient-to-br from-slate-50 to-violet-50 rounded-3xl border border-slate-200 p-5 flex items-center justify-center min-h-[280px]">
                    <div class="text-center w-full">
                        <img id="templatePreviewImage" src="" alt="Template Preview" class="hidden mx-auto max-h-72 rounded-2xl shadow-xl border border-white object-contain">
                        <div id="templatePreviewPlaceholder">
                            <div class="w-16 h-16 rounded-2xl bg-violet-100 text-violet-600 mx-auto flex items-center justify-center mb-4">
                                <i class="fa-solid fa-image text-2xl"></i>
                            </div>
                            <h4 class="font-black text-slate-950">Template Preview</h4>
                            <p class="text-sm text-slate-500 mt-1">Selected template image will appear here.</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-4 pb-6">

            <div class="bg-gradient-to-br from-violet-600 to-indigo-700 text-white rounded-2xl p-5 shadow-lg">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h3 class="font-black">Quick Actions</h3>
                </div>

                <p class="text-sm text-violet-100 mb-4">Fast admin shortcuts for important system operations.</p>

                <div class="flex flex-wrap gap-2">
                    <button onclick="openTemplateUploadBox()" class="px-3 py-2 rounded-xl bg-white/20 text-xs font-black hover:bg-white/30 transition">Create Template</button>
                    <button onclick="showProgress('Review Users')" class="px-3 py-2 rounded-xl bg-white/20 text-xs font-black hover:bg-white/30 transition">Review Users</button>
                    <button onclick="showProgress('View Complaints')" class="px-3 py-2 rounded-xl bg-white/20 text-xs font-black hover:bg-white/30 transition">View Complaints</button>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="font-black text-slate-950">Security Center</h3>
                </div>

                <p class="text-sm text-slate-500 mb-4">Admin authentication is enabled and protected through token verification.</p>

                <button onclick="showProgress('Security Center')" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition">
                    Open Security
                </button>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h3 class="font-black text-slate-950">Smart Insights</h3>
                </div>

                <p class="text-sm text-slate-500 mb-4">Future analytics section for resume usage, jobs, templates and user activity.</p>

                <button onclick="showProgress('Smart Insights')" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition">
                    View Insights
                </button>
            </div>

        </section>

    </main>



<!-- GHOST ADMIN DASHBOARD PATCH - ADD ONLY -->
<style>
    /* ===== ADMIN TEMPLATE UPLOAD PROFESSIONAL OVERRIDE - ADD ONLY ===== */
    #templateUploadBox {
        border-radius: 28px !important;
        border: 1px solid #ddd6fe !important;
        background:
            radial-gradient(circle at top left, rgba(124, 58, 237, 0.12), transparent 35%),
            radial-gradient(circle at bottom right, rgba(236, 72, 153, 0.10), transparent 35%),
            #ffffff !important;
        box-shadow: 0 28px 70px rgba(15, 23, 42, 0.12) !important;
        overflow: hidden !important;
    }

    #templateUploadBox input,
    #templateUploadBox select {
        height: 46px !important;
        border-radius: 13px !important;
        border: 1.5px solid #cbd5e1 !important;
        font-weight: 800 !important;
        color: #0f172a !important;
    }

    #templateUploadBox input:focus,
    #templateUploadBox select:focus {
        outline: none !important;
        border-color: #8b5cf6 !important;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, .15) !important;
    }

    #templatePreviewImage {
        object-fit: contain !important;
        background: #f8fafc !important;
    }

    .admin-template-live-card {
        margin-top: 18px;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        padding: 18px;
        background: #ffffff;
        box-shadow: 0 18px 40px rgba(15,23,42,.08);
    }

    .admin-mini-resume {
        width: 220px;
        height: 310px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        display: grid;
        grid-template-columns: 34% 66%;
        box-shadow: 0 20px 50px rgba(15,23,42,.18);
        margin: 0 auto;
        --resume-accent: #2563eb;
    }

    .admin-mini-side {
        background: #1f2937;
        padding: 16px 8px;
        color: white;
    }

    .admin-mini-main {
        padding: 18px 12px;
    }

    .admin-mini-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: white;
        border: 3px solid var(--resume-accent);
        margin: 0 auto 14px;
    }

    .admin-mini-line {
        height: 5px;
        border-radius: 999px;
        background: rgba(255,255,255,.35);
        margin-bottom: 8px;
    }

    .admin-mini-title {
        width: 82%;
        height: 12px;
        border-radius: 999px;
        background: #111827;
        margin-bottom: 8px;
    }

    .admin-mini-accent {
        width: 55%;
        height: 7px;
        border-radius: 999px;
        background: var(--resume-accent);
        margin-bottom: 16px;
    }

    .admin-mini-text {
        height: 5px;
        border-radius: 999px;
        background: #cbd5e1;
        margin-bottom: 7px;
    }

    .admin-connect-btn {
        width: 100%;
        margin-top: 14px;
        padding: 12px 18px;
        border-radius: 999px;
        background: #0f172a;
        color: white;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: .08em;
        transition: .2s ease;
    }

    .admin-connect-btn:hover {
        background: #ec4899;
        transform: translateY(-1px);
    }
</style>

<script>
(function () {
    function ensureAdminTemplatePreviewCard() {
        const box = document.getElementById("templateUploadBox");
        if (!box) return;

        if (document.getElementById("adminEditableTemplatePreviewCard")) return;

        const previewCard = document.createElement("div");
        previewCard.id = "adminEditableTemplatePreviewCard";
        previewCard.className = "admin-template-live-card";
        previewCard.innerHTML = `
            <div class="flex flex-col lg:flex-row items-center gap-6">
                <div class="flex-1">
                    <p class="text-[11px] font-black uppercase tracking-[0.24em] text-violet-600">
                        Editable Layout Preview
                    </p>
                    <h3 class="text-2xl font-black text-slate-950 mt-1">
                        Modern Sidebar Template
                    </h3>
                    <p class="text-sm text-slate-500 font-semibold mt-2 leading-relaxed">
                        Uploaded image is only a thumbnail for user selection. Actual builder preview will use this editable HTML/CSS layout.
                    </p>

                    <button type="button" onclick="window.location.href='/templates'" class="admin-connect-btn">
                        Connect / Check User Side
                    </button>
                </div>

                <div class="admin-mini-resume" id="adminMiniResumePreview">
                    <div class="admin-mini-side">
                        <div class="admin-mini-avatar"></div>
                        <div class="admin-mini-line" style="width:90%"></div>
                        <div class="admin-mini-line" style="width:70%"></div>
                        <div class="admin-mini-line" style="width:80%"></div>
                    </div>
                    <div class="admin-mini-main">
                        <div class="admin-mini-title"></div>
                        <div class="admin-mini-accent"></div>
                        <div class="admin-mini-text" style="width:100%"></div>
                        <div class="admin-mini-text" style="width:88%"></div>
                        <div class="admin-mini-text" style="width:94%"></div>
                        <br>
                        <div class="admin-mini-title" style="width:60%; height:8px;"></div>
                        <div class="admin-mini-text" style="width:85%"></div>
                        <div class="admin-mini-text" style="width:70%"></div>
                    </div>
                </div>
            </div>
        `;

        box.appendChild(previewCard);

        const colorInput = document.getElementById("templateDefaultColor");
        if (colorInput) {
            const applyColor = () => {
                const mini = document.getElementById("adminMiniResumePreview");
                if (mini) mini.style.setProperty("--resume-accent", colorInput.value || "#2563eb");
            };

            colorInput.addEventListener("input", applyColor);
            colorInput.addEventListener("change", applyColor);
            applyColor();
        }
    }

    const oldOpen = window.openTemplateUploadBox;

    window.openTemplateUploadBox = function () {
        if (typeof oldOpen === "function") {
            oldOpen();
        }

        setTimeout(ensureAdminTemplatePreviewCard, 120);
    };

    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(ensureAdminTemplatePreviewCard, 500);
    });
})();
</script>

</body>
</html>