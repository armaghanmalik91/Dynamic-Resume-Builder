<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Resume Builder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <nav class="bg-white border-b py-3 px-6 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center space-x-10">
            <div class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500 cursor-pointer">
                <i class="fa-solid fa-layer-group mr-2"></i> ResumeBuilder
            </div>
            <div id="navLinks" class="hidden lg:flex space-x-6 text-sm font-bold text-gray-700 uppercase tracking-wide items-center">
                <a href="/jobs" id="nav-jobs" class="nav-item hover:text-pink-600 transition pb-3 -mb-3">Jobs</a>
                <a href="#" id="nav-documents" class="nav-item hover:text-pink-600 transition pb-3 -mb-3">Documents <i class="fa-solid fa-angle-down text-xs ml-1"></i></a>
                <a href="#" id="nav-resources" class="nav-item hover:text-pink-600 transition pb-3 -mb-3">Resources <i class="fa-solid fa-angle-down text-xs ml-1"></i></a>
                <a href="#" id="nav-boldpro" class="nav-item text-purple-600 hover:text-pink-600 transition pb-3 -mb-3">Bold.Pro <i class="fa-solid fa-angle-down text-xs ml-1"></i></a>
            </div>
        </div>
        <div class="flex items-center space-x-6">
            <i class="fa-regular fa-bell text-gray-500 text-xl cursor-pointer hover:text-purple-600 transition"></i>
            <div class="relative">
                <button id="profileBtn" class="flex items-center space-x-2 text-sm font-bold text-gray-700 focus:outline-none hover:text-pink-600 transition">
                    <i class="fa-solid fa-user-circle text-2xl text-gray-400"></i>
                    <span id="userDisplayName">Loading...</span>
                    <i class="fa-solid fa-angle-down text-xs"></i>
                </button>
                <div id="dropdownMenu" class="hidden absolute right-0 mt-3 w-48 bg-white border border-gray-100 rounded-md shadow-xl py-2 text-sm font-semibold">
                    <a href="/settings" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-purple-600"><i class="fa-solid fa-gear mr-2"></i> Settings</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-purple-600"><i class="fa-solid fa-headset mr-2"></i> Contact Us</a>
                    <div class="border-t border-gray-100 my-2"></div>
                    <button onclick="logoutUser()" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Sign Out</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10 max-w-7xl flex flex-col lg:flex-row gap-8">
        <div class="w-full lg:w-1/4">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mb-6">
                <div class="h-64 bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center text-gray-400 mb-4 overflow-hidden relative group cursor-pointer hover:border-pink-400 transition">
                    <div class="text-center">
                        <i class="fa-regular fa-file-lines text-4xl mb-2"></i>
                        <p class="text-sm font-bold">No resumes yet</p>
                    </div>
                </div>
                <a href="/builder-intro" class="w-full py-3 bg-white border-2 border-blue-600 text-blue-600 font-bold rounded hover:bg-blue-50 transition flex items-center justify-center">
                    <i class="fa-solid fa-plus mr-2"></i> Create New Resume
                </a>
            </div>
        </div>

        <div class="w-full lg:w-3/4 space-y-8">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="bg-[#000033] text-white px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold">Your Checklist</h2>
                    <a href="#" class="text-sm font-bold hover:underline">View all features <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Get ready to apply</h3>
                        <span class="text-sm font-bold text-gray-500">Completed <span class="text-green-600">0 of 4</span></span>
                    </div>
                    <div class="flex gap-6 border-b border-gray-100 pb-6 mb-6">
                        <div class="w-32 h-40 bg-gray-100 border rounded flex-shrink-0 relative overflow-hidden">
                            <div class="absolute top-0 w-full h-8 bg-blue-900"></div>
                            <div class="mt-10 mx-2 h-2 bg-gray-300 rounded"></div>
                            <div class="mt-2 mx-2 h-2 bg-gray-300 rounded w-2/3"></div>
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-xl font-bold mb-2">Create a resume</h4>
                            <p class="text-gray-600 mb-4">Create a professional resume to stand out from other applicants.</p>
                            <a href="/builder-intro" class="px-6 py-2 bg-pink-600 text-white font-bold rounded-full hover:bg-pink-700 shadow-md transition inline-block">Start resume</a>
                        </div>
                        <div class="text-gray-400 text-sm font-bold flex items-center gap-2"><i class="fa-regular fa-circle"></i> Incomplete</div>
                    </div>

                    <div class="flex gap-6 border-b border-gray-100 pb-6 mb-6">
                        <div class="w-32 h-24 bg-blue-50 border border-blue-100 rounded flex items-center justify-center text-blue-500 text-4xl flex-shrink-0">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-xl font-bold mb-2">Check out your resume score</h4>
                            <p class="text-gray-600 mb-4">We'll give you a score so you can make necessary improvements.</p>
                            <button class="px-6 py-2 bg-white border border-gray-300 font-bold rounded-full hover:bg-gray-50 transition">See resume score</button>
                        </div>
                        <div class="text-gray-400 text-sm font-bold flex items-center gap-2"><i class="fa-regular fa-circle"></i> Incomplete</div>
                    </div>

                    <div class="flex gap-6">
                        <div class="w-32 h-24 bg-purple-50 border border-purple-100 rounded flex items-center justify-center text-purple-500 text-4xl flex-shrink-0">
                            <i class="fa-regular fa-envelope-open"></i>
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-xl font-bold mb-2">Create a cover letter</h4>
                            <p class="text-gray-600 mb-4">Personalize your application and communicate directly with hiring managers.</p>
                            <button class="px-6 py-2 bg-white border border-gray-300 font-bold rounded-full hover:bg-gray-50 transition">Create a cover letter</button>
                        </div>
                        <div class="text-gray-400 text-sm font-bold flex items-center gap-2"><i class="fa-regular fa-circle"></i> Incomplete</div>
                    </div>
                </div>
            </div>

            <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-8 flex justify-between items-center shadow-sm">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Let's set your career goals</h3>
                    <p class="text-gray-600 mb-4">We'll help you figure out your path and guide you through the process.</p>
                    <button class="px-6 py-2 bg-pink-600 text-white font-bold rounded-full hover:bg-pink-700 shadow-md">Get started</button>
                </div>
                <div class="hidden md:block text-6xl text-indigo-300">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-end mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">Recommended Webinars</h3>
                    <select class="text-sm border-gray-300 rounded px-2 py-1 text-gray-600 bg-white">
                        <option>Recommended For You</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="h-32 bg-gray-200 relative flex items-center justify-center">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Webinar">
                            <i class="fa-regular fa-circle-play text-4xl text-white relative z-10 drop-shadow-md"></i>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold mb-2 text-sm h-10 overflow-hidden">How to Determine if a Company has the Culture You Want</h4>
                            <a href="#" class="text-blue-600 text-sm font-bold"><i class="fa-solid fa-tv mr-1"></i> Watch Video</a>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="h-32 bg-gray-200 relative flex items-center justify-center">
                            <img src="https://images.unsplash.com/photo-1552581234-26160f608093?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Webinar">
                            <i class="fa-regular fa-circle-play text-4xl text-white relative z-10 drop-shadow-md"></i>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold mb-2 text-sm h-10 overflow-hidden">Create a Winning Personal Brand to Land Your Next Job</h4>
                            <a href="#" class="text-blue-600 text-sm font-bold"><i class="fa-solid fa-tv mr-1"></i> Watch Video</a>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="h-32 bg-gray-200 relative flex items-center justify-center">
                            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Webinar">
                            <i class="fa-regular fa-circle-play text-4xl text-white relative z-10 drop-shadow-md"></i>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold mb-2 text-sm h-10 overflow-hidden">How to Get the Salary You Deserve</h4>
                            <a href="#" class="text-blue-600 text-sm font-bold"><i class="fa-solid fa-tv mr-1"></i> Watch Video</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        // Dropdown Toggle Logic
        const profileBtn = document.getElementById('profileBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        profileBtn.addEventListener('click', () => dropdownMenu.classList.toggle('hidden'));
        window.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Logout Logic
        function logoutUser() {
            localStorage.removeItem('resume_token');
            window.location.href = '/login';
        }

        // --- UPDATED: Navbar Mouse Move (Hover) & Click (Blue Highlight) Logic ---
        const navItems = document.querySelectorAll('.nav-item');

        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if(this.getAttribute('href') === '#') {
                    e.preventDefault();
                }

                // Pehle baki sab targets se active/blue classes aur borders saaf karein
                navItems.forEach(nav => {
                    nav.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                    
                    // Reset custom base state colors
                    if (nav.id === 'nav-boldpro') {
                        nav.classList.add('text-purple-600');
                        nav.classList.remove('text-gray-700');
                    } else {
                        nav.classList.add('text-gray-700');
                        nav.classList.remove('text-purple-600');
                    }
                });

                // Ab click kiye gaye element ko solid Blue border aur Blue text apply karein
                this.classList.remove('text-gray-700', 'text-purple-600');
                this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
            });
        });
    </script>
</body>
</html>