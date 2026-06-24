<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Template - Resume Builder</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        .workspace-viewport {
            height: calc(100vh - 120px);
            overflow: hidden;
        }

        .template-card-box {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1.5px solid #e2e8f0;
        }

        .template-card-box:hover {
            border-color: #3b82f6;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
        }

        .card-selected {
            border-color: #3b82f6 !important;
            box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.2);
        }

        .filter-checkbox {
            accent-color: #ec4899;
        }

        .color-dot-opt {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.15s ease;
        }

        .color-dot-opt:hover {
            transform: scale(1.2);
        }

        .modal-overlay {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
        }

        .animation-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-white font-sans text-gray-900 h-screen overflow-hidden flex flex-col justify-between">
    <nav class="bg-white border-b py-4 px-8 flex justify-between items-center shadow-sm sticky top-0 z-50">
        <div class="flex items-center space-x-6">
            <div class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500 flex items-center cursor-pointer">
                <i class="fa-solid fa-layer-group mr-2"></i> ResumeBuilder
            </div>
        </div>

        <div class="font-bold text-gray-500 text-sm">Step 3 of 4</div>
    </nav>

    <div class="flex flex-grow workspace-viewport overflow-hidden relative">
        <aside class="w-1/5 max-w-[255px] bg-white border-r border-slate-200 p-6 hidden md:flex flex-col justify-between select-none">
            <div class="space-y-6">
                <div class="flex justify-between items-center pb-2 border-b">
                    <h3 class="font-black text-sm text-slate-800 uppercase tracking-wide">Filters</h3>
                    <button id="btnClearFilters" class="text-blue-600 text-xs font-bold hover:underline">
                        Clear filters
                    </button>
                </div>

                <div>
                    <h4 class="font-bold text-xs mb-2.5 text-gray-500 uppercase tracking-wider">
                        Headshot
                    </h4>

                    <label class="flex items-center space-x-2.5 mb-2 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" id="filter_with_photo" class="w-4 h-4 rounded border-slate-300 focus:ring-0 filter-checkbox">
                        <span>With photo</span>
                    </label>

                    <label class="flex items-center space-x-2.5 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" id="filter_without_photo" checked class="w-4 h-4 rounded border-slate-300 focus:ring-0 filter-checkbox">
                        <span>Without photo</span>
                    </label>
                </div>

                <div>
                    <h4 class="font-bold text-xs mb-2.5 text-gray-500 uppercase tracking-wider">
                        Columns
                    </h4>

                    <label class="flex items-center space-x-2.5 mb-2 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" id="filter_1_column" class="w-4 h-4 rounded border-slate-300 focus:ring-0 filter-checkbox">
                        <span>1 column</span>
                    </label>

                    <label class="flex items-center space-x-2.5 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" id="filter_2_columns" checked class="w-4 h-4 rounded border-slate-300 focus:ring-0 filter-checkbox">
                        <span>2 columns</span>
                    </label>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <h4 class="font-black text-xs text-blue-700 uppercase tracking-wider mb-2">
                        Filter Rule
                    </h4>
                    <p class="text-xs text-slate-600 leading-relaxed font-semibold">
                        Only templates uploaded by admin with matching photo and column settings will appear here.
                    </p>
                </div>
            </div>
        </aside>

        <main class="flex-1 bg-slate-50/50 overflow-y-auto p-6 lg:px-12 pb-32">
            <div class="text-center mb-8">
                <a href="javascript:void(0);" id="customBackLink" class="text-blue-600 font-bold flex items-center justify-center mb-6 hover:underline w-fit mx-auto text-xs tracking-wide uppercase transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Go Back
                </a>

                <h1 class="text-4xl font-extrabold mb-2 text-gray-900">
                    Best templates for students
                </h1>

                <p class="text-gray-600">
                    Choose a template based on your photo and column preference.
                </p>
            </div>

            <div id="activeFilterLabel" class="max-w-5xl mx-auto mb-5 bg-white border border-slate-200 rounded-xl px-5 py-3 flex items-center justify-between shadow-sm">
                <div class="text-sm font-black text-slate-800">
                    Showing:
                    <span id="filterSummary" class="text-blue-600">Without photo • 2 columns</span>
                </div>

                <div id="templateCount" class="text-xs font-black text-slate-500 uppercase tracking-wider">
                    0 Templates
                </div>
            </div>

            <div id="templatesGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto"></div>

            <div id="noTemplatesMessage" class="hidden max-w-xl mx-auto mt-14 bg-white border border-dashed border-slate-300 rounded-2xl p-10 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-2xl">
                    <i class="fa-solid fa-filter-circle-xmark"></i>
                </div>

                <h3 class="text-xl font-black text-slate-800 mb-2">
                    No matching templates found
                </h3>

                <p class="text-sm text-slate-500 font-semibold leading-relaxed">
                    Admin has not uploaded templates for this filter combination yet. Try changing filters or upload new templates from admin panel.
                </p>
            </div>
        </main>
    </div>

    <div class="sticky bottom-0 right-0 left-0 bg-[#f8fafc] border-t border-gray-200 py-3.5 px-8 flex flex-col sm:flex-row justify-between items-center z-50 text-[11px] font-bold text-gray-600 select-none gap-3 shadow-inner">
        <div class="flex space-x-6 text-gray-500">
            <a href="/legal#terms" target="_blank" class="hover:text-blue-600 transition">TERMS & CONDITIONS</a>
            <span class="text-gray-300">|</span>
            <a href="/legal#privacy" target="_blank" class="hover:text-blue-600 transition">PRIVACY POLICY</a>
            <span class="text-gray-300">|</span>
            <a href="/legal#accessibility" target="_blank" class="hover:text-blue-600 transition">ACCESSIBILITY</a>
            <span class="text-gray-300">|</span>
            <a href="/legal#contact" target="_blank" class="hover:text-blue-600 transition">CONTACT US</a>
        </div>

        <div class="flex items-center gap-3.5">
            <button id="chooseLaterBtn" class="px-8 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded shadow-sm hover:bg-gray-50 transition text-xs">
                Choose later
            </button>

            <button id="submitGridFallback" class="px-8 py-2.5 bg-pink-600 hover:bg-pink-700 text-white font-bold rounded shadow transition text-xs opacity-40 cursor-not-allowed" disabled>
                Use this template
            </button>
        </div>
    </div>

    <div id="successModal" class="fixed inset-0 modal-overlay hidden flex items-center justify-center z-[100]">
        <div class="bg-white p-8 rounded-xl shadow-2xl max-w-md w-full text-center transform scale-95 transition-transform duration-300 relative animation-fade-in">
            <div class="w-16 h-16 bg-pink-100 text-pink-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-5">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>

            <h2 class="text-xl font-bold mb-3 tracking-tight text-gray-900">
                We'll optimize your resume to pass through filters with flying colors.
            </h2>

            <p class="text-slate-500 text-xs font-semibold leading-relaxed mb-6">
                This selected template matches your filter preference and will be used in your resume builder flow.
            </p>

            <div class="flex gap-3 justify-center">
                <button onclick="document.getElementById('successModal').classList.add('hidden')" class="px-5 py-2 font-bold text-slate-500 hover:bg-slate-100 rounded text-xs uppercase tracking-wide">
                    Skip for now
                </button>

                <button id="finalNextBtn" class="px-6 py-2.5 bg-pink-500 text-white font-black rounded-full shadow-lg hover:bg-pink-600 text-xs uppercase tracking-wider">
                    Choose Template
                </button>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('resume_token');
        if (!token) {
            window.location.href = '/login';
        }

        const modal = document.getElementById('successModal');
        const finalNextBtn = document.getElementById('finalNextBtn');
        const submitGridFallback = document.getElementById('submitGridFallback');
        const btnClearFilters = document.getElementById('btnClearFilters');
        const templatesGrid = document.getElementById('templatesGrid');
        const noTemplatesMessage = document.getElementById('noTemplatesMessage');
        const filterSummary = document.getElementById('filterSummary');
        const templateCount = document.getElementById('templateCount');

        const filterWithPhoto = document.getElementById('filter_with_photo');
        const filterWithoutPhoto = document.getElementById('filter_without_photo');
        const filterOneColumn = document.getElementById('filter_1_column');
        const filterTwoColumns = document.getElementById('filter_2_columns');

        let chosenTemplate = null;
        let allTemplates = [];

        function getSelectedFilterState() {
            const photoValues = [];
            const columnValues = [];

            if (filterWithPhoto.checked) photoValues.push(1);
            if (filterWithoutPhoto.checked) photoValues.push(0);

            if (filterOneColumn.checked) columnValues.push(1);
            if (filterTwoColumns.checked) columnValues.push(2);

            return {
                photoValues,
                columnValues
            };
        }

        function updateFilterSummary(count) {
            const { photoValues, columnValues } = getSelectedFilterState();

            let photoText = 'No photo type selected';
            let columnText = 'No column type selected';

            if (photoValues.length === 2) {
                photoText = 'With & Without photo';
            } else if (photoValues.includes(1)) {
                photoText = 'With photo';
            } else if (photoValues.includes(0)) {
                photoText = 'Without photo';
            }

            if (columnValues.length === 2) {
                columnText = '1 & 2 columns';
            } else if (columnValues.includes(1)) {
                columnText = '1 column';
            } else if (columnValues.includes(2)) {
                columnText = '2 columns';
            }

            filterSummary.innerText = `${photoText} • ${columnText}`;
            templateCount.innerText = `${count} Template${count === 1 ? '' : 's'}`;
        }

        function getFilteredTemplates() {
            const { photoValues, columnValues } = getSelectedFilterState();

            if (photoValues.length === 0 || columnValues.length === 0) {
                return [];
            }

            return allTemplates.filter(template => {
                const hasPhoto = Number(template.has_photo || 0);
                const columnCount = Number(template.column_count || 2);

                return photoValues.includes(hasPhoto) && columnValues.includes(columnCount);
            });
        }

        function renderTemplates() {
            const filteredTemplates = getFilteredTemplates();

            templatesGrid.innerHTML = '';
            updateFilterSummary(filteredTemplates.length);

            chosenTemplate = null;
            submitGridFallback.disabled = true;
            submitGridFallback.classList.add('opacity-40', 'cursor-not-allowed');

            if (filteredTemplates.length === 0) {
                noTemplatesMessage.classList.remove('hidden');
                return;
            }

            noTemplatesMessage.classList.add('hidden');

            filteredTemplates.forEach((template) => {
                const imageUrl = template.thumbnail_url && template.thumbnail_url.startsWith('http')
                    ? template.thumbnail_url
                    : 'http://localhost:5000' + template.thumbnail_url;

                const templateId = template.template_key || template.id;
                const hasPhoto = Number(template.has_photo || 0);
                const columnCount = Number(template.column_count || 2);

                const card = document.createElement('div');
                card.className = 'bg-white p-2 rounded-xl template-card-box group relative cursor-pointer template-card';
                card.setAttribute('data-template', templateId);
                card.setAttribute('data-template-name', template.name || 'Template');
                card.setAttribute('data-has-photo', hasPhoto);
                card.setAttribute('data-column-count', columnCount);
                card.setAttribute('data-layout-key', template.layout_key || 'modern_sidebar');
                card.setAttribute('data-default-color', template.default_color || '#2563eb');
                card.setAttribute('data-category', template.category || 'Professional');
                card.setAttribute('data-thumbnail-url', imageUrl);

                card.innerHTML = `
                    <div class="h-72 bg-[#f8fafc] overflow-hidden border border-slate-100 rounded-lg flex items-center justify-center relative select-none">
                        <img src="${imageUrl}" alt="${template.name}" class="w-full h-full object-cover rounded-lg">
                    </div>

                    <div class="flex items-center justify-center gap-2 mt-3">
                        <span class="font-black text-blue-600 tracking-widest text-[10px] uppercase bg-blue-50/70 py-1 rounded px-3">
                            ${template.category || 'Professional'}
                        </span>

                        <span class="font-black text-slate-600 tracking-widest text-[10px] uppercase bg-slate-100 py-1 rounded px-3">
                            ${hasPhoto === 1 ? 'With photo' : 'Without photo'}
                        </span>

                        <span class="font-black text-slate-600 tracking-widest text-[10px] uppercase bg-slate-100 py-1 rounded px-3">
                            ${columnCount} Col
                        </span>
                    </div>

                    <h3 class="text-center mt-3 font-black text-gray-800 text-sm">
                        ${template.name || 'Template'}
                    </h3>

                    <div class="flex justify-center gap-1.5 mt-3 pb-1">
                        <span class="color-dot-opt bg-emerald-600 border border-slate-300"></span>
                        <span class="color-dot-opt bg-blue-800"></span>
                        <span class="color-dot-opt bg-rose-500"></span>
                        <span class="color-dot-opt bg-amber-500"></span>
                    </div>

                    <div class="absolute inset-0 bg-white/95 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200 p-4 text-center rounded-xl z-10">
                        <p class="font-bold text-gray-800 text-sm mb-4 px-2 leading-relaxed">
                            This template matches your selected filter.
                        </p>

                        <button class="px-5 py-2 bg-pink-500 text-white font-black text-xs uppercase tracking-wider rounded shadow select-template-btn hover:bg-pink-600 transition">
                            Use this template
                        </button>
                    </div>
                `;

                templatesGrid.appendChild(card);
            });

            bindTemplateSelectionEvents();
        }

        async function loadDynamicTemplates() {
            try {
                const response = await fetch('http://localhost:5000/api/templates/all');
                const data = await response.json();

                if (!data.success || !Array.isArray(data.templates)) {
                    allTemplates = [];
                    renderTemplates();
                    return;
                }

                allTemplates = data.templates.map(template => ({
                    ...template,
                    has_photo: Number(template.has_photo || 0),
                    column_count: Number(template.column_count || 2)
                }));

                renderTemplates();
            } catch (error) {
                console.error('Dynamic template load failed:', error);
                allTemplates = [];
                renderTemplates();
            }
        }

        function bindTemplateSelectionEvents() {
            document.querySelectorAll('.select-template-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const card = e.target.closest('.template-card');
                    chosenTemplate = card.getAttribute('data-template');

                    localStorage.setItem('selected_template', chosenTemplate);
                    localStorage.setItem('selected_template_name', card.getAttribute('data-template-name'));
                    localStorage.setItem('selected_template_has_photo', card.getAttribute('data-has-photo'));
                    localStorage.setItem('selected_template_column_count', card.getAttribute('data-column-count'));
                    localStorage.setItem('selected_template_layout_key', card.getAttribute('data-layout-key') || 'modern_sidebar');
                    localStorage.setItem('selected_template_default_color', card.getAttribute('data-default-color') || '#2563eb');
                    localStorage.setItem('selected_template_category', card.getAttribute('data-category') || 'Professional');
                    localStorage.setItem('selected_template_thumbnail_url', card.getAttribute('data-thumbnail-url') || '');
                    localStorage.setItem('resume_accent_color', card.getAttribute('data-default-color') || '#2563eb');

                    document.querySelectorAll('.template-card').forEach(c => c.classList.remove('card-selected'));
                    card.classList.add('card-selected');

                    submitGridFallback.disabled = false;
                    submitGridFallback.classList.remove('opacity-40', 'cursor-not-allowed');

                    modal.classList.remove('hidden');
                    modal.querySelector('div').classList.replace('scale-95', 'scale-100');
                });
            });
        }

        function applyFilterListeners() {
            [filterWithPhoto, filterWithoutPhoto, filterOneColumn, filterTwoColumns].forEach(filter => {
                filter.addEventListener('change', () => {
                    renderTemplates();
                });
            });
        }

        document.getElementById('customBackLink').addEventListener('click', () => {
            const savedExp = localStorage.getItem('selected_experience_level');

            if (savedExp === 'No Experience' || savedExp === 'Less Than 3 Years') {
                window.location.href = '/student-status';
            } else {
                window.location.href = '/experience-level';
            }
        });

        btnClearFilters.addEventListener('click', () => {
            filterWithPhoto.checked = true;
            filterWithoutPhoto.checked = true;
            filterOneColumn.checked = true;
            filterTwoColumns.checked = true;
            renderTemplates();
        });

        submitGridFallback.addEventListener('click', () => {
            if (!chosenTemplate) {
                alert('Please select a template first.');
                return;
            }

            modal.classList.remove('hidden');
            modal.querySelector('div').classList.replace('scale-95', 'scale-100');
        });

        document.getElementById('chooseLaterBtn').addEventListener('click', () => {
            const firstTemplate = allTemplates[0];

            if (firstTemplate) {
                chosenTemplate = firstTemplate.template_key || firstTemplate.id;
                localStorage.setItem('selected_template', chosenTemplate);
                localStorage.setItem('selected_template_name', firstTemplate.name || 'Template');
                localStorage.setItem('selected_template_layout_key', firstTemplate.layout_key || 'modern_sidebar');
                localStorage.setItem('selected_template_default_color', firstTemplate.default_color || '#2563eb');
                localStorage.setItem('selected_template_category', firstTemplate.category || 'Professional');
                localStorage.setItem('selected_template_thumbnail_url', firstTemplate.thumbnail_url && firstTemplate.thumbnail_url.startsWith('http') ? firstTemplate.thumbnail_url : 'http://localhost:5000' + (firstTemplate.thumbnail_url || ''));
                localStorage.setItem('resume_accent_color', firstTemplate.default_color || '#2563eb');
            }

            window.location.href = '/upload-or-scratch';
        });

        finalNextBtn.addEventListener('click', async () => {
            if (!chosenTemplate) {
                alert('Please select a template first.');
                return;
            }

            finalNextBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...';
            finalNextBtn.disabled = true;

            try {
                const response = await fetch('http://localhost:5000/api/resumes/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify({
                        template_id: chosenTemplate
                    })
                });

                const data = await response.json();

                if (data.success) {
                    localStorage.setItem('current_resume_id', data.resume_id);

                    if (data.template_id) {
                        localStorage.setItem('selected_template', data.template_id);
                    }

                    window.location.href = '/upload-or-scratch';
                } else {
                    alert('Error: ' + data.message);
                    finalNextBtn.innerHTML = 'Choose Template';
                    finalNextBtn.disabled = false;
                }
            } catch (error) {
                alert('Server connection failed.');
                finalNextBtn.innerHTML = 'Choose Template';
                finalNextBtn.disabled = false;
            }
        });

        applyFilterListeners();
        loadDynamicTemplates();
    </script>
</body>
</html>