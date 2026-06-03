<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Job Search - Resume Builder</title> 
    <script src="https://cdn.tailwindcss.com"></script> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> 
    <style> 
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; } 
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; } 
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; } 
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; } 

        .filter-dropdown {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1), 0 4px 12px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
        }
    </style> 
</head> 
<body class="bg-white font-sans text-slate-800 antialiased min-h-screen flex flex-col justify-between overflow-y-auto custom-scrollbar"> 
    <div class="w-full flex flex-col"> 
        <nav class="bg-white border-b border-slate-200 py-4 px-12 flex justify-between items-center sticky top-0 z-50 shadow-sm"> 
            <div class="flex items-center"> 
                <div onclick="window.location.href='/dashboard'" class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500 cursor-pointer tracking-tight"> 
                    <i class="fa-solid fa-layer-group mr-2"></i> ResumeBuilder 
                </div> 
            </div> 
            <div class="flex items-center"> 
                <a href="/dashboard" class="text-blue-600 hover:text-blue-700 transition font-bold text-[15px] tracking-tight"> Go to dashboard </a> 
            </div> 
        </nav> 

        <div class="bg-white border-b border-slate-200 px-12 sticky top-[69px] z-40"> 
            <div class="max-w-7xl mx-auto flex justify-between items-center text-[15px] font-bold text-gray-900 h-14"> 
                <div class="w-1/3 flex justify-center"> 
                    <button id="tab-search" onclick="switchViewMode('search')" class="h-14 text-slate-900 border-b-[3px] border-blue-600 tracking-tight font-black focus:outline-none transition px-4"> Job search </button> 
                </div> 
                <div class="w-1/3 flex justify-center"> 
                    <button id="tab-saved" onclick="switchViewMode('saved')" class="h-14 text-slate-700 hover:text-slate-900 border-b-[3px] border-transparent tracking-tight font-medium focus:outline-none transition px-4"> Saved jobs (<span id="cnt-saved">0</span>) </button> 
                </div> 
                <div class="w-1/3 flex justify-center"> 
                    <button id="tab-applied" onclick="switchViewMode('applied')" class="h-14 text-slate-700 hover:text-slate-900 border-b-[3px] border-transparent tracking-tight font-medium focus:outline-none transition px-4"> Applied (<span id="cnt-applied">0</span>) </button> 
                </div> 
            </div> 
        </div> 

        <div id="searchBarContainer" class="bg-slate-50/50 border-b border-slate-100 py-6 px-12 flex flex-col gap-4"> 
            <div class="max-w-7xl w-full mx-auto bg-white border border-slate-200/80 rounded-xl p-5 shadow-sm flex flex-col md:flex-row gap-4 items-center"> 
                <div class="w-full md:w-[42%] relative"> 
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-slate-400 text-lg"></i> 
                    <input type="text" id="searchKeyword" class="w-full pl-12 pr-4 py-3 bg-white border border-slate-300 rounded-lg outline-none focus:border-pink-500 transition font-normal text-base placeholder-slate-400" placeholder="Job title or keyword"> 
                </div> 
                <div class="w-full md:w-[42%] relative"> 
                    <i class="fa-solid fa-location-dot absolute left-4 top-4 text-slate-400 text-lg"></i> 
                    <input type="text" id="searchLocation" class="w-full pl-12 pr-4 py-3 bg-white border border-slate-300 rounded-lg outline-none focus:border-pink-500 transition font-normal text-base placeholder-slate-400" placeholder="City, region or country"> 
                </div> 
                <button onclick="performSearch(1)" class="w-full md:w-[16%] py-3 bg-[#cc1470] text-white font-bold rounded-full shadow-md hover:bg-[#b21262] transition flex items-center justify-center gap-2 text-base tracking-wide"> 
                    <i class="fa-solid fa-magnifying-glass text-sm"></i> Search 
                </button> 
            </div> 
            <div class="max-w-7xl w-full mx-auto flex gap-4 relative"> 
                <div class="relative"> 
                    <button id="btnDistance" onclick="toggleDropdown('dropdownDistance')" class="bg-white border border-slate-300 rounded-lg px-4 py-2 font-semibold text-sm flex items-center gap-2 text-slate-700 shadow-sm transition active:scale-95"> 
                        <span id="txtDistance">25 Miles</span> <i id="iconDistance" class="fa-solid fa-chevron-down text-xs"></i> 
                    </button> 
                    <div id="dropdownDistance" class="hidden absolute left-0 mt-2 w-44 rounded-lg py-1 z-40 text-sm font-semibold filter-dropdown"> 
                        <button onclick="setDistance('5 Miles')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">5 Miles</button> 
                        <button onclick="setDistance('10 Miles')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">10 Miles</button> 
                        <button onclick="setDistance('15 Miles')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">15 Miles</button> 
                        <button onclick="setDistance('25 Miles')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">25 Miles</button> 
                        <button onclick="setDistance('50 Miles')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">50 Miles</button> 
                        <button onclick="setDistance('100 Miles')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">100 Miles</button> 
                    </div> 
                </div> 
                <div class="relative"> 
                    <button id="btnTime" onclick="toggleDropdown('dropdownTime')" class="bg-white border border-slate-300 rounded-lg px-4 py-2 font-semibold text-sm flex items-center gap-2 text-slate-700 shadow-sm transition active:scale-95"> 
                        <span id="txtTime">Any time</span> <i id="iconTime" class="fa-solid fa-chevron-down text-xs"></i> 
                    </button> 
                    <div id="dropdownTime" class="hidden absolute left-0 mt-2 w-44 rounded-lg py-1 z-40 text-sm font-semibold filter-dropdown"> 
                        <button onclick="setTimeRange('Any time')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">Any time</button> 
                        <button onclick="setTimeRange('Past day')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">Past day</button> 
                        <button onclick="setTimeRange('Past week')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">Past week</button> 
                        <button onclick="setTimeRange('Past month')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 transition">Past month</button> 
                    </div> 
                </div> 
            </div> 
        </div> 

        <div class="max-w-7xl w-full mx-auto px-12 pt-6 flex justify-between items-center select-none"> 
            <div class="text-slate-950 text-xl font-extrabold tracking-tight">
                <span id="totalResultsTxt" class="font-black">0</span> results
            </div> 
            <div class="flex items-center gap-3"> 
                <span class="text-sm font-black text-slate-900 tracking-tight">Sort by</span> 
                <div class="relative">
                    <button id="btnSort" onclick="toggleDropdown('dropdownSort')" class="bg-white border border-slate-300 rounded-md px-4 py-2 font-medium text-base text-slate-400 flex items-center gap-4 min-w-[150px] justify-between shadow-sm hover:border-slate-400 transition"> 
                        <span id="txtSort" class="text-slate-400">Relevance</span> <i id="iconSort" class="fa-solid fa-chevron-down text-xs text-slate-900"></i> 
                    </button> 
                    <div id="dropdownSort" class="hidden absolute right-0 mt-1 w-[150px] rounded-md py-1 z-50 text-sm font-semibold filter-dropdown"> 
                        <button onclick="setSortMode('Relevance')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 text-slate-800 transition">Relevance</button> 
                        <button onclick="setSortMode('Date Posted')" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 text-slate-800 transition">Date Posted</button> 
                    </div> 
                </div>
            </div> 
        </div> 

        <div class="max-w-7xl w-full mx-auto px-12 py-3 flex flex-col md:flex-row gap-6 items-start mb-20"> 
            <div class="w-full md:w-[38%] flex flex-col"> 
                <div class="flex flex-col gap-4 mb-6" id="jobListContainer"> 
                    <div class="text-center py-10 text-slate-400 font-medium"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Finding best matches...</div> 
                </div> 
                <div class="flex items-center justify-between border-t border-slate-200/80 pt-4 bg-white select-none w-full" id="paginationFooterWrapper"> 
                    <button id="btnPrevPage" class="text-slate-700 hover:text-blue-600 flex items-center gap-1 font-black text-xs uppercase tracking-wider transition disabled:text-slate-300 disabled:cursor-not-allowed"> 
                        <i class="fa-solid fa-chevron-left text-[10px]"></i> Prev 
                    </button> 
                    <div class="flex items-center gap-1 mx-2 overflow-x-auto custom-scrollbar whitespace-nowrap px-1 py-1 min-w-[120px]" id="numericPagesTrack"></div> 
                    <button id="btnNextPage" class="text-slate-700 hover:text-blue-600 flex items-center gap-1 font-black text-xs uppercase tracking-wider transition disabled:text-slate-300 disabled:cursor-not-allowed"> Next <i class="fa-solid fa-chevron-right text-[10px]"></i> </button> 
                </div> 
            </div> 
            <div class="hidden md:flex w-[62%] bg-white border border-slate-200 rounded-xl shadow-sm p-8 flex-col sticky top-40 max-h-[calc(100vh-12rem)] overflow-y-auto custom-scrollbar" id="jobDetailsContainer"> 
                <div class="text-center my-auto text-slate-400 py-24"> 
                    <i class="fa-solid fa-briefcase text-6xl mb-4 text-slate-300"></i> 
                    <p class="font-extrabold text-slate-700 text-lg">Select a job to view complete details</p> 
                    <p class="text-slate-400 text-sm mt-1">Your dynamic recommendation metrics will align here.</p> 
                </div> 
            </div> 
        </div> 
    </div> 
    <div class="w-full bg-white border-t border-slate-200 py-4 px-12 flex flex-col sm:flex-row justify-between items-center text-xs font-bold text-slate-400 tracking-wide z-40 bg-white"> 
        <div class="mb-2 sm:mb-0">© 2026, Bold Limited. All rights reserved.</div> 
        <div class="flex gap-4"> 
            <a href="/legal#terms" target="_blank" class="hover:text-slate-800 transition">TERMS & CONDITIONS</a> | <a href="/legal#privacy" target="_blank" class="hover:text-slate-800 transition">PRIVACY POLICY</a> | <a href="/legal#accessibility" target="_blank" class="hover:text-slate-800 transition">ACCESSIBILITY</a> | <a href="/legal#contact" target="_blank" class="hover:text-slate-800 transition">CONTACT US</a> 
        </div> 
    </div> 
    <script> 
        const token = localStorage.getItem('resume_token'); 
        if (!token) window.location.href = '/login'; 

        let allJobs = []; 
        let savedJobIds = []; // Global array tracker for retaining pink favorite states
        let viewMode = 'search'; 
        let selectedDistance = '25 Miles'; 
        let selectedTimeRange = 'Any time'; 
        let selectedSortMode = 'Relevance'; 
        let currentPage = 1; 
        let totalPagesCount = 1; 

        function toggleDropdown(id) { 
            const dropdown = document.getElementById(id); 
            const isHidden = dropdown.classList.contains('hidden'); 
            
            ['dropdownDistance', 'dropdownTime', 'dropdownSort'].forEach(dId => { 
                document.getElementById(dId).classList.add('hidden'); 
            }); 

            const arrowMap = { 'dropdownDistance': 'iconDistance', 'dropdownTime': 'iconTime', 'dropdownSort': 'iconSort' }; 
            document.getElementById(arrowMap.dropdownDistance).className = "fa-solid fa-chevron-down text-xs text-slate-900"; 
            document.getElementById(arrowMap.dropdownTime).className = "fa-solid fa-chevron-down text-xs text-slate-900"; 
            document.getElementById(arrowMap.dropdownSort).className = "fa-solid fa-chevron-down text-xs text-slate-900"; 

            if (isHidden) { 
                dropdown.classList.remove('hidden'); 
                document.getElementById(arrowMap[id]).className = "fa-solid fa-chevron-up text-xs text-slate-900"; 
            } 
        } 

        function setDistance(val) { 
            selectedDistance = val; 
            document.getElementById('txtDistance').innerText = val; 
            toggleDropdown('dropdownDistance'); 
            performSearch(1); 
        } 

        function setTimeRange(val) { 
            selectedTimeRange = val; 
            document.getElementById('txtTime').innerText = val; 
            toggleDropdown('dropdownTime'); 
            performSearch(1); 
        } 

        function setSortMode(val) { 
            selectedSortMode = val; 
            document.getElementById('txtSort').innerText = val; 
            toggleDropdown('dropdownSort'); 
            performSearch(1); 
        } 

        window.addEventListener('click', (e) => { 
            if (!e.target.closest('#btnDistance') && !e.target.closest('#btnTime') && !e.target.closest('#btnSort')) { 
                ['dropdownDistance', 'dropdownTime', 'dropdownSort'].forEach(dId => { 
                    const el = document.getElementById(dId); 
                    if(el) el.classList.add('hidden'); 
                }); 
                ['iconDistance', 'iconTime', 'iconSort'].forEach(iId => {
                    const icon = document.getElementById(iId);
                    if(icon) icon.className = "fa-solid fa-chevron-down text-xs text-slate-900";
                });
            } 
        }); 

        async function fetchMetrics() { 
            try { 
                const response = await fetch(`http://localhost:5000/api/jobs/metrics?mode=saved`, { 
                    method: 'GET', 
                    headers: { 'Authorization': 'Bearer ' + token } 
                }); 
                const data = await response.json(); 
                if(data.success) { 
                    // Track list of saved IDs from metric list to lock card view colors globally
                    savedJobIds = data.jobs.map(j => j.id);
                    
                    // Fetch real current view counters sync
                    const realMetricResp = await fetch(`http://localhost:5000/api/jobs/metrics?mode=${viewMode}`, {
                        method: 'GET',
                        headers: { 'Authorization': 'Bearer ' + token }
                    });
                    const mData = await realMetricResp.json();
                    
                    document.getElementById('cnt-saved').innerText = mData.savedCount; 
                    document.getElementById('cnt-applied').innerText = mData.appliedCount; 
                    
                    if(viewMode !== 'search') { 
                        allJobs = mData.jobs; 
                        renderJobCards(mData.jobs); 
                        document.getElementById('totalResultsTxt').innerText = mData.jobs.length; 
                        document.getElementById('numericPagesTrack').innerHTML = ''; 
                        document.getElementById('paginationFooterWrapper').classList.add('hidden'); 
                        if(mData.jobs.length > 0) showJobDetails(mData.jobs[0].id); 
                        else renderEmptyState(); 
                    } 
                } 
            } catch (error) { console.error("Metrics logic issue:", error); } 
        } 

        function switchViewMode(mode) { 
            viewMode = mode; 
            ['search', 'saved', 'applied'].forEach(m => { 
                const btn = document.getElementById(`tab-${m}`); 
                btn.className = (m === mode) ? "h-14 text-slate-900 border-b-[3px] border-blue-600 tracking-tight font-black focus:outline-none transition px-4" : "h-14 text-slate-700 hover:text-slate-900 border-b-[3px] border-transparent tracking-tight font-medium focus:outline-none transition px-4"; 
            }); 
            if(mode === 'search') { 
                document.getElementById('searchBarContainer').classList.remove('hidden'); 
                document.getElementById('paginationFooterWrapper').classList.remove('hidden'); 
                performSearch(1); 
            } else { 
                document.getElementById('searchBarContainer').classList.add('hidden'); 
                fetchMetrics(); 
            } 
        } 

        async function performSearch(pageNo = 1) { 
            if(viewMode !== 'search') return; 
            currentPage = pageNo; 
            const keyword = document.getElementById('searchKeyword').value; 
            const location = document.getElementById('searchLocation').value; 
            const listContainer = document.getElementById('jobListContainer'); 
            listContainer.innerHTML = '<div class="text-center py-10 text-slate-400 font-medium"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Filtering results...</div>'; 
             
            try { 
                // Fetch user metrics first to ensure savedJobIds sync is fresh for render cards
                const metricSync = await fetch(`http://localhost:5000/api/jobs/metrics?mode=saved`, { 
                    method: 'GET', 
                    headers: { 'Authorization': 'Bearer ' + token } 
                });
                const metricData = await metricSync.json();
                if(metricData.success) {
                    savedJobIds = metricData.jobs.map(j => j.id);
                }

                const url = `http://localhost:5000/api/jobs/search?keyword=${encodeURIComponent(keyword)}&location=${encodeURIComponent(location)}&distance=${encodeURIComponent(selectedDistance)}&timeRange=${encodeURIComponent(selectedTimeRange)}&sortBy=${encodeURIComponent(selectedSortMode)}&page=${currentPage}`; 
                 
                const response = await fetch(url, { 
                    method: 'GET', 
                    headers: { 'Authorization': 'Bearer ' + token } 
                }); 
                const data = await response.json(); 
                 
                if (data.success && data.jobs.length > 0) { 
                    allJobs = data.jobs; 
                    totalPagesCount = data.pagination.totalPages; 
                    document.getElementById('totalResultsTxt').innerText = data.pagination.totalJobs; 
                    renderJobCards(data.jobs); 
                    showJobDetails(data.jobs[0].id); 
                    renderPaginationFooter(data.pagination); 
                } else { 
                    document.getElementById('totalResultsTxt').innerText = "0"; 
                    renderEmptyState(); 
                    document.getElementById('numericPagesTrack').innerHTML = ''; 
                    document.getElementById('btnPrevPage').disabled = true; 
                    document.getElementById('btnNextPage').disabled = true; 
                } 
                // Refresh top layout counts alongside
                document.getElementById('cnt-saved').innerText = metricData.savedCount;
                document.getElementById('cnt-applied').innerText = metricData.appliedCount;
            } catch (error) { console.error(error); } 
        } 

        function renderEmptyState() { 
            document.getElementById('jobListContainer').innerHTML = ` 
                <div class="bg-white p-8 rounded-xl border border-slate-200 text-center text-slate-500 shadow-sm mt-2"> 
                    <i class="fa-solid fa-circle-info text-3xl mb-3 text-pink-500"></i> 
                    <p class="font-bold text-base text-slate-800">No jobs tracked here</p> 
                    <p class="text-xs text-slate-400 mt-1">Try optimizing search parameters or clear filters.</p> 
                </div>`; 
            document.getElementById('jobDetailsContainer').innerHTML = ` 
                <div class="text-center my-auto text-gray-400 py-20"> 
                    <i class="fa-solid fa-ban text-5xl mb-3 text-slate-300"></i> 
                    <p class="font-bold text-slate-700">No details viewable</p> 
                </div>`; 
        } 

        function renderJobCards(jobs) { 
            const listContainer = document.getElementById('jobListContainer'); 
            listContainer.innerHTML = ''; 
            jobs.forEach((job) => { 
                // Condition to keep favorite state pink or fallback to grey
                const isSaved = savedJobIds.includes(job.id);
                const bookmarkColorClass = isSaved ? 'text-pink-500' : 'text-slate-300';

                listContainer.innerHTML += ` 
                    <div onclick="showJobDetails(${job.id})" id="card-${job.id}" class="job-card bg-white p-5 border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-slate-300 transition duration-150 cursor-pointer flex flex-col relative group"> 
                        <div onclick="saveJob(event, ${job.id}, this)" class="absolute right-4 top-4 ${bookmarkColorClass} hover:text-pink-500 transition p-1.5 rounded-lg hover:bg-slate-50 z-10"> 
                            <i class="fa-solid fa-bookmark text-base"></i> 
                        </div> 
                        <h4 class="font-black text-slate-900 pr-8 text-[15px] group-hover:text-purple-700 transition leading-snug">${job.title}</h4> 
                        <p class="text-xs font-bold text-slate-600 mt-1.5">${job.employer}</p> 
                        <p class="text-xs text-slate-400 mt-1 flex items-center gap-1.5 font-medium"><i class="fa-solid fa-location-dot text-[10px] text-slate-400"></i> ${job.location}</p> 
                        <span class="text-[10px] text-slate-400 font-bold mt-4 uppercase tracking-wider">${job.posted_date}</span> 
                    </div>`; 
            }); 
        } 

        function showJobDetails(jobId) { 
            const job = allJobs.find(j => j.id === jobId); 
            if (!job) return; 
            document.querySelectorAll('.job-card').forEach(c => c.classList.remove('border-purple-500', 'bg-purple-50/15', 'shadow-md')); 
            const activeCard = document.getElementById(`card-${jobId}`); 
            if(activeCard) activeCard.classList.add('border-purple-500', 'bg-purple-50/15', 'shadow-md'); 
             
            const detailsContainer = document.getElementById('jobDetailsContainer'); 
            detailsContainer.innerHTML = ` 
                <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-6"> 
                    <div class="pr-4"> 
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">${job.title}</h2> 
                        <p class="text-base font-extrabold text-purple-700 mt-1.5">${job.employer}</p> 
                        <div class="flex flex-wrap gap-5 text-xs text-slate-400 mt-4 font-bold uppercase tracking-wider"> 
                            <span><i class="fa-regular fa-calendar-days mr-1.5 text-pink-500 text-sm"></i> ${job.posted_date}</span> 
                            <span><i class="fa-solid fa-location-dot mr-1.5 text-pink-500 text-sm"></i> ${job.location}</span> 
                        </div> 
                    </div> 
                    <button onclick="applyJob(${job.id}, this)" class="px-7 py-3 bg-pink-600 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md hover:bg-pink-700 transition flex items-center gap-2 flex-shrink-0"> Apply now <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> </button> 
                </div> 
                <div class="flex-1 pr-1"> 
                    <div class="border border-blue-200 bg-blue-50/40 rounded-xl p-4 flex justify-between items-center mb-6"> 
                        <div class="flex items-center gap-3"> 
                            <div class="w-10 h-10 rounded-full bg-white border flex items-center justify-center text-slate-500 shadow-sm"><i class="fa-regular fa-file-lines text-lg"></i></div> 
                            <div> 
                                <h5 class="text-sm font-extrabold text-slate-800">Personalize documents for this job</h5> 
                                <a href="#" class="text-xs text-blue-600 font-bold hover:underline">How it works</a> 
                            </div> 
                        </div> 
                        <button class="px-4 py-2 bg-white border border-slate-300 font-bold text-xs rounded-lg shadow-sm hover:bg-slate-50 transition flex items-center gap-1">Documents <i class="fa-solid fa-chevron-down text-[9px]"></i></button> 
                    </div> 
                    <h4 class="text-xs font-black uppercase text-slate-400 tracking-widest mb-4">Job Description</h4> 
                    <p class="text-slate-600 font-medium leading-relaxed whitespace-pre-line text-sm lg:text-[15px]">${job.description}</p> 
                </div>`; 
        } 

        function renderPaginationFooter(meta) { 
            const track = document.getElementById('numericPagesTrack'); 
            track.innerHTML = ''; 

            document.getElementById('btnPrevPage').disabled = meta.currentPage === 1; 
            document.getElementById('btnNextPage').disabled = meta.currentPage === meta.totalPages; 

            for(let i = 1; i <= meta.totalPages; i++) { 
                const isActive = i === meta.currentPage; 
                track.innerHTML += ` 
                    <button onclick="performSearch(${i})" class="w-8 h-8 flex items-center justify-center rounded-lg text-xs transition font-bold flex-shrink-0 ${isActive ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-100'}"> 
                        ${i} 
                    </button>`; 
            } 
        } 

        document.getElementById('btnPrevPage').onclick = function() { 
            if(currentPage > 1) performSearch(currentPage - 1); 
        }; 

        document.getElementById('btnNextPage').onclick = function() { 
            if(currentPage < totalPagesCount) performSearch(currentPage + 1); 
        }; 

        async function saveJob(e, jobId, element) { 
            e.stopPropagation(); 
            try { 
                const response = await fetch('http://localhost:5000/api/jobs/save', { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token }, 
                    body: JSON.stringify({ job_id: jobId }) 
                }); 
                const data = await response.json(); 
                if(data.success) { 
                    alert(data.message); 
                    
                    // Instantly toggle local color class based on database feedback
                    if(data.isSaved) {
                        element.className = "absolute right-4 top-4 text-pink-500 transition p-1.5 rounded-lg hover:bg-slate-50 z-10";
                    } else {
                        element.className = "absolute right-4 top-4 text-slate-300 hover:text-pink-500 transition p-1.5 rounded-lg hover:bg-slate-50 z-10";
                    }
                    
                    // If in "Saved jobs" tab, view should re-render to strip the card away
                    if(viewMode === 'saved') {
                        fetchMetrics();
                    } else {
                        // Just update top dynamic counters smoothly
                        const countSync = await fetch(`http://localhost:5000/api/jobs/metrics?mode=saved`, { method: 'GET', headers: { 'Authorization': 'Bearer ' + token } });
                        const cData = await countSync.json();
                        if(cData.success) {
                            savedJobIds = cData.jobs.map(j => j.id);
                            document.getElementById('cnt-saved').innerText = cData.savedCount;
                        }
                    }
                } 
            } catch (error) { console.error(error); } 
        } 

        async function applyJob(jobId, buttonEl) { 
            buttonEl.disabled = true; 
            buttonEl.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Submitting...'; 
            try { 
                const response = await fetch('http://localhost:5000/api/jobs/apply', { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token }, 
                    body: JSON.stringify({ job_id: jobId }) 
                }); 
                const data = await response.json(); 
                if(data.success) { 
                    alert(data.message); 
                    buttonEl.className = "px-7 py-3 bg-emerald-600 text-white font-black text-xs uppercase tracking-wider rounded-xl cursor-default flex items-center gap-2 flex-shrink-0"; 
                    buttonEl.innerHTML = 'Applied <i class="fa-solid fa-circle-check text-[11px]"></i>'; 
                    fetchMetrics(); 
                } else { 
                    alert(data.message); buttonEl.disabled = false; buttonEl.innerHTML = 'Apply now <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>'; 
                } 
            } catch (error) { console.error(error); } 
        } 

        switchViewMode('search'); 
    </script> 
</body> 
</html>