<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <nav class="bg-white border-b py-4 px-6 flex justify-between items-center shadow-sm">
        <a href="/dashboard" class="text-xl font-black text-purple-600 flex items-center">
            <i class="fa-solid fa-layer-group mr-2"></i> ResumeBuilder
        </a>
        <div class="flex items-center space-x-4">
            <span class="text-sm font-bold text-gray-600">My Account</span>
            <button onclick="logoutUser()" class="text-sm font-bold text-red-500 hover:underline">Sign Out</button>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10 max-w-6xl flex flex-col md:flex-row gap-10">
        
        <div class="w-full md:w-1/4">
            <h1 class="text-3xl font-extrabold mb-8">My Account</h1>
            <ul class="space-y-2 font-bold text-gray-600 text-sm">
                <li><button onclick="switchTab('general')" id="tab-general" class="w-full text-left px-4 py-3 bg-blue-50 text-blue-900 rounded-lg transition">General Account Settings</button></li>
                <li><button onclick="switchTab('subscription')" id="tab-subscription" class="w-full text-left px-4 py-3 hover:bg-gray-100 rounded-lg transition">Subscription</button></li>
                <li><button onclick="switchTab('communication')" id="tab-communication" class="w-full text-left px-4 py-3 hover:bg-gray-100 rounded-lg transition">Communication Preferences</button></li>
            </ul>
        </div>

        <div class="w-full md:w-3/4">
            
            <div id="panel-general" class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-2xl font-bold mb-6">General Account Settings</h2>
                
                <div class="space-y-6">
                    <div class="flex justify-between items-center border-b pb-4">
                        <div class="w-1/3 font-bold text-gray-700">Account ID:</div>
                        <div class="w-2/3 text-gray-600">767692148</div>
                    </div>
                    <div class="flex justify-between items-center border-b pb-4">
                        <div class="w-1/3 font-bold text-gray-700">Email ID:</div>
                        <div class="w-2/3 text-gray-600 flex justify-between">
                            <span>user@example.com</span>
                            <button class="text-blue-600 font-bold hover:underline"><i class="fa-solid fa-pencil"></i> Edit</button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center border-b pb-4">
                        <div class="w-1/3 font-bold text-gray-700">Password:</div>
                        <div class="w-2/3 text-gray-600 flex justify-between">
                            <span>********</span>
                            <button class="text-blue-600 font-bold hover:underline"><i class="fa-solid fa-pencil"></i> Edit</button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pb-2">
                        <div class="w-1/3 font-bold text-gray-700">Contact Info:</div>
                        <div class="w-2/3 text-gray-600 flex justify-between">
                            <span>Not Provided</span>
                            <button class="text-blue-600 font-bold hover:underline"><i class="fa-solid fa-pencil"></i> Edit</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="panel-subscription" class="hidden bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-2xl font-bold mb-6">Subscription</h2>
                <div class="space-y-6 mb-8">
                    <div class="flex justify-between items-center border-b pb-4">
                        <span class="font-bold text-gray-700">Account ID:</span>
                        <span class="text-gray-600">767692148</span>
                    </div>
                    <div class="flex justify-between items-center border-b pb-4">
                        <span class="font-bold text-gray-700">Subscription Status:</span>
                        <span class="text-gray-600">Basic</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-700">Registration Date:</span>
                        <span class="text-gray-600">May 11, 2026</span>
                    </div>
                </div>
                <button class="px-6 py-3 bg-pink-500 text-white font-bold rounded shadow hover:bg-pink-600">Upgrade to Full Access</button>
            </div>

            <div id="panel-communication" class="hidden bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-2xl font-bold mb-2">Communication Preferences</h2>
                <p class="text-gray-600 mb-6 font-bold">Select which emails you would like to receive:</p>
                
                <div class="space-y-4 mb-8">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" checked class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="text-gray-700">Insider Tips & Tricks</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" checked class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="text-gray-700">New Features & Announcements</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                        <span class="text-gray-700">Job Recommendations</span>
                    </label>
                    <div class="border-t pt-4 mt-4">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-red-500 rounded">
                            <span class="text-gray-700 font-bold">Unsubscribe from all Resume Builder emails</span>
                        </label>
                    </div>
                </div>
                <button class="px-6 py-2 bg-pink-500 text-white font-bold rounded shadow hover:bg-pink-600">Save Changes</button>
            </div>

        </div>
    </div>

    <script>
        if (!localStorage.getItem('resume_token')) window.location.href = '/login';

        function logoutUser() {
            localStorage.removeItem('resume_token');
            window.location.href = '/login';
        }

        // Tab Switching Logic
        function switchTab(tabName) {
            // Hide all panels
            document.getElementById('panel-general').classList.add('hidden');
            document.getElementById('panel-subscription').classList.add('hidden');
            document.getElementById('panel-communication').classList.add('hidden');
            
            // Reset all tab styles
            const tabs = ['general', 'subscription', 'communication'];
            tabs.forEach(t => {
                document.getElementById('tab-'+t).className = "w-full text-left px-4 py-3 hover:bg-gray-100 rounded-lg transition";
            });

            // Show selected panel
            document.getElementById('panel-' + tabName).classList.remove('hidden');
            
            // Highlight active tab
            document.getElementById('tab-' + tabName).className = "w-full text-left px-4 py-3 bg-blue-50 text-blue-900 rounded-lg transition";
        }
    </script>
</body>
</html>