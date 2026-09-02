<x-layout>
    <x-slot:title>Departments & Live Queue — {{ $hospital->hospital_name ?? 'Qura Medical' }}</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-10 sm:py-16 space-y-12">

        <!-- EDITORIAL HERO (NO GENERIC BANNER) -->
        <section class="text-center max-w-3xl mx-auto space-y-6 pt-4 sm:pt-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-stone-100 text-ink-600 text-[11px] font-semibold uppercase tracking-widest">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                <span>Live Clinic Queue • Updated Real-Time</span>
            </div>

            <h1 class="font-editorial text-4xl sm:text-6xl text-ink-900 tracking-tight leading-[1.15]">
                Care that moves at your pace, not the <span class="italic font-normal">waiting room’s</span>
            </h1>

            <p class="text-ink-500 text-sm sm:text-base leading-relaxed max-w-xl mx-auto font-normal">
                Check current queue lengths and estimated wait times across all outpatient departments. Join the line digitally from anywhere.
            </p>

            <div class="pt-2 text-xs text-ink-400 font-medium tracking-wide">
                {{ $hospital->hospital_name ?? 'General Health Medical Center' }} &nbsp;•&nbsp; {{ $hospital->hospital_address ?? 'Central Outpatient Pavilion' }}
            </div>

            <!-- KEY CLINIC METRICS (AIRY EDITORIAL STRIP) -->
            <div class="pt-6 max-w-lg mx-auto">
                <div class="grid grid-cols-3 divide-x divide-stone-200 py-3 border-y border-stone-200/80">
                    <div class="text-center px-2">
                        <span class="font-editorial text-2xl sm:text-3xl text-ink-900 block">{{ $departments->count() }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold">Specialties</span>
                    </div>

                    @php
                        $totalWaiting = $departmentCounts ? $departmentCounts->sum() : 0;
                    @endphp
                    <div class="text-center px-2">
                        <span class="font-editorial text-2xl sm:text-3xl text-ink-900 block">{{ $totalWaiting }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold">In Line</span>
                    </div>

                    <div class="text-center px-2">
                        <span class="font-editorial text-2xl sm:text-3xl text-ink-900 block">~12m</span>
                        <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold">Avg. Wait</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ACTIVE TICKET NOTICE (MINIMALIST REFINED CARD) -->
        @if($activeTicket)
            @php
                $ahead = $people_ahead ?? $peopleAhead ?? 0;
                $wait = $user_waitTime ?? $userWaitTime ?? 0;
            @endphp
            <section class="bg-white rounded-3xl border border-stone-200 p-6 sm:p-8 shadow-xs">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-stone-900 text-white flex flex-col items-center justify-center shrink-0">
                            <span class="text-[9px] uppercase tracking-widest text-stone-400 font-bold">Pass</span>
                            <span class="font-editorial text-2xl font-normal">#{{ $activeTicket->ticket_number }}</span>
                        </div>

                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] uppercase tracking-wider text-emerald-700 font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-100">
                                    Active Ticket
                                </span>
                                <span class="text-xs text-ink-400 font-medium">• {{ $ahead }} ahead of you</span>
                            </div>
                            <h2 class="font-editorial text-2xl text-ink-900">{{ $activeTicket->department }}</h2>
                            <p class="text-xs text-ink-500">Estimated wait: ~{{ $wait }} minutes</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 self-end md:self-auto">
                        <a href="{{ route('queue.show') }}" 
                            class="inline-flex items-center justify-center px-6 py-3 rounded-full text-xs font-semibold uppercase tracking-wider bg-ink-900 hover:bg-black text-white transition-all shadow-xs active:scale-95">
                            View Live Pass
                        </a>

                        <form method="POST" action="{{ route('queue.leave') }}" onsubmit="return confirm('Leave this queue?');">
                            @csrf
                            <button type="submit" 
                                class="px-5 py-3 rounded-full text-xs font-semibold uppercase tracking-wider text-stone-500 hover:text-stone-800 bg-stone-100 hover:bg-stone-200 transition-colors cursor-pointer">
                                Leave
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        @endif

        <!-- SEARCH & WING CATEGORY FILTERS -->
        <section class="space-y-6 pt-2">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-stone-200 pb-6">
                <!-- Search Input -->
                <div class="relative w-full md:w-96">
                    <input type="text" 
                        id="departmentSearch" 
                        oninput="filterDepartments()"
                        placeholder="Search departments or wings..."
                        class="w-full pl-11 pr-10 py-3 rounded-full bg-white border border-stone-200 text-xs font-medium text-ink-800 placeholder:text-ink-400 focus:outline-none focus:border-ink-900 transition-all">
                    <svg class="w-4 h-4 text-ink-400 absolute left-4 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <button type="button" id="clearSearchBtn" onclick="clearSearch()" class="hidden absolute right-3.5 top-3 text-stone-400 hover:text-stone-700">
                        &times;
                    </button>
                </div>

                <!-- Minimalist Wing Filter Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs" id="filterTabs">
                    <button type="button" onclick="setWingFilter('all', this)" class="filter-tab active px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider bg-ink-900 text-white transition-all cursor-pointer">
                        All (<span id="visibleCount">{{ $departments->count() }}</span>)
                    </button>
                    <button type="button" onclick="setWingFilter('wing a', this)" class="filter-tab px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider bg-white hover:bg-stone-100 text-ink-600 border border-stone-200 transition-all cursor-pointer">
                        Wing A
                    </button>
                    <button type="button" onclick="setWingFilter('wing b', this)" class="filter-tab px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider bg-white hover:bg-stone-100 text-ink-600 border border-stone-200 transition-all cursor-pointer">
                        Wing B
                    </button>
                    <button type="button" onclick="setWingFilter('wing c', this)" class="filter-tab px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider bg-white hover:bg-stone-100 text-ink-600 border border-stone-200 transition-all cursor-pointer">
                        Wing C
                    </button>
                    <button type="button" onclick="setWingFilter('wing d', this)" class="filter-tab px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider bg-white hover:bg-stone-100 text-ink-600 border border-stone-200 transition-all cursor-pointer">
                        Wing D & Others
                    </button>
                </div>
            </div>

            <!-- DEPARTMENTS GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="departmentGrid">
                @forelse($departments as $department)
                    @php
                        $count = $departmentCounts[$department->name] ?? 0;
                        $deptWait = $count * 8;
                        $nameLower = strtolower($department->name);
                        $locationLower = strtolower($department->location ?? '');
                    @endphp

                    <div class="department-card group bg-white border border-stone-200/90 hover:border-stone-400 rounded-3xl p-7 transition-all duration-300 flex flex-col justify-between space-y-6 shadow-xs"
                        data-name="{{ $nameLower }}"
                        data-location="{{ $locationLower }}">

                        <!-- Card Header -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold">
                                    {{ $department->location ?? 'Outpatient' }}
                                </span>

                                <span class="text-[11px] font-medium px-2.5 py-1 rounded-full bg-stone-100 text-ink-700">
                                    @if($count === 0)
                                        No wait
                                    @else
                                        ~{{ $deptWait }}m wait
                                    @endif
                                </span>
                            </div>

                            <h3 class="font-editorial text-2xl text-ink-900 group-hover:opacity-80 transition-opacity leading-snug">
                                {{ $department->name }}
                            </h3>

                            <p class="text-xs text-ink-500 font-medium">
                                <span class="font-bold text-ink-900">{{ $count }}</span> {{ Str::plural('patient', $count) }} in line
                            </p>
                        </div>

                        <!-- Card Action -->
                        <div class="pt-2 border-t border-stone-100">
                            @auth
                                @if($activeTicket)
                                    <a href="{{ route('queue.show') }}" 
                                        class="w-full py-3 px-5 rounded-full text-xs font-semibold uppercase tracking-wider text-center block bg-stone-100 hover:bg-stone-200 text-ink-700 transition-colors">
                                        View Ticket (#{{ $activeTicket->ticket_number }})
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('queue.join') }}">
                                        @csrf
                                        <input type="hidden" name="department" value="{{ $department->name }}">
                                        <button type="submit" 
                                            class="w-full py-3 px-5 rounded-full text-xs font-semibold uppercase tracking-wider text-center bg-ink-900 hover:bg-black text-white transition-all shadow-xs cursor-pointer active:scale-98">
                                            Enter Queue
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                    class="w-full py-3 px-5 rounded-full text-xs font-semibold uppercase tracking-wider text-center block bg-stone-100 hover:bg-stone-200 text-ink-800 transition-colors">
                                    Sign In to Enter
                                </a>
                            @endauth
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-stone-200 p-8">
                        <p class="font-editorial text-xl text-ink-900">No departments found</p>
                        <p class="text-xs text-ink-400 mt-1">Please check back shortly.</p>
                    </div>
                @endforelse
            </div>

            <!-- ZERO RESULTS FALLBACK -->
            <div id="noResults" class="hidden text-center py-16 bg-white rounded-3xl border border-stone-200 p-8">
                <p class="font-editorial text-2xl text-ink-900">No matching departments</p>
                <p class="text-xs text-ink-400 mt-1">We couldn't find any department matching your query.</p>
                <button type="button" onclick="clearSearch()" class="mt-4 px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-wider bg-stone-100 hover:bg-stone-200 text-ink-800 transition-colors cursor-pointer">
                    Clear Filters
                </button>
            </div>
        </section>

    </div>

    <!-- CLIENT JAVASCRIPT FOR SEARCH & FILTERING -->
    <script>
        let currentWingFilter = 'all';

        function setWingFilter(wing, buttonElement) {
            currentWingFilter = wing.toLowerCase();

            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active', 'bg-ink-900', 'text-white');
                tab.classList.add('bg-white', 'text-ink-600', 'border', 'border-stone-200');
            });

            buttonElement.classList.add('active', 'bg-ink-900', 'text-white');
            buttonElement.classList.remove('bg-white', 'text-ink-600', 'border', 'border-stone-200');

            filterDepartments();
        }

        function filterDepartments() {
            const query = document.getElementById('departmentSearch').value.toLowerCase().trim();
            const clearBtn = document.getElementById('clearSearchBtn');
            const cards = document.querySelectorAll('.department-card');
            let visibleCount = 0;

            if (clearBtn) {
                clearBtn.classList.toggle('hidden', query === '');
            }

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const location = card.getAttribute('data-location') || '';

                const matchesQuery = query === '' || name.includes(query) || location.includes(query);
                const matchesWing = (currentWingFilter === 'all') 
                    || (currentWingFilter === 'wing d' ? (!location.includes('wing a') && !location.includes('wing b') && !location.includes('wing c')) : location.includes(currentWingFilter));

                if (matchesQuery && matchesWing) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            const countEl = document.getElementById('visibleCount');
            if (countEl) countEl.textContent = visibleCount;

            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.classList.toggle('hidden', visibleCount > 0);
            }
        }

        function clearSearch() {
            const input = document.getElementById('departmentSearch');
            if (input) input.value = '';
            const firstTab = document.querySelector('.filter-tab');
            if (firstTab) setWingFilter('all', firstTab);
        }
    </script>
</x-layout>