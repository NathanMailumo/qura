<x-layout>
    <x-slot:title>Qura - Hospital Queue Portal</x-slot:title>

    <!-- FULL PAGE CONTAINER WITH GRADIENT BACKGROUND -->
    <div class="min-h-screen bg-gradient-to-br from-indigo-100 via-purple-50 to-slate-100 flex flex-col">

        <!-- 1. FULL WIDTH NAVBAR -->
        <nav
            class="w-full bg-white/60 backdrop-blur-md border-b border-indigo-100/60 px-6 sm:px-12 py-4 flex items-center justify-between sticky top-0 z-50">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-500/20">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-2xl font-black text-slate-900 tracking-tight">Qura</span>
            </div>

            <div class="flex items-center space-x-3">
                <button onclick="openEmergencyModal()"
                    class="flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/80 text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4 text-red-600 animate-pulse" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Emergency Care
                </button>
                <a href="{{ route('login') }}"
                    class="text-xs font-bold text-slate-700 bg-white/80 hover:bg-white border border-slate-200/60 px-4 py-2.5 rounded-xl transition shadow-sm">
                    Sign In
                </a>
            </div>
        </nav>

        <!-- MAIN CONTENT WRAPPER -->
        <main class="flex-1 max-w-7xl mx-auto w-full px-6 sm:px-12 py-10 flex flex-col justify-start">

            <!-- 2. HERO & SEARCH SECTION -->
            <div class="max-w-2xl mx-auto w-full text-center space-y-4 mb-10">
                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">
                    Find Your Department
                </h1>
                <p class="text-sm sm:text-base text-slate-600 font-medium">
                    Search and join hospital queues instantly from anywhere.
                </p>

                <!-- Search Bar -->
                <div class="relative mt-6">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="departmentSearch" oninput="filterDepartments()"
                        placeholder="Search for a department (e.g. Cardiology, Pediatrics)..."
                        class="w-full pl-11 pr-4 py-4 bg-white/80 backdrop-blur-md border border-indigo-100 rounded-2xl shadow-lg shadow-indigo-900/5 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="departmentGrid">
                @forelse($departments as $department)
                    <div class="department-card bg-white/70 backdrop-blur-md border border-white/80 rounded-2xl p-6 shadow-md hover:shadow-xl hover:bg-white/90 hover:border-indigo-200 transition-all duration-200 space-y-5 flex flex-col justify-between"
                        data-name="{{ strtolower($department->name) }}">

                        <div class="space-y-4">
                            <div class="flex justify-between items-start">
                                <!-- Dynamic Icon Badge -->
                                <div
                                    class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 shadow-inner">
                                    @if ($department->icon_type === 'heart')
                                        <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    @elseif($department->icon_type === 'users')
                                        <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Dynamic Wait Status Badge -->
                                <span
                                    class="text-xs font-bold px-3 py-1 rounded-full border 
                        {{ $department->wait_status === 'Low Wait' ? 'bg-emerald-50 text-emerald-700 border-emerald-200/60' : '' }}
                        {{ $department->wait_status === 'Moderate' ? 'bg-amber-50 text-amber-700 border-amber-200/60' : '' }}
                        {{ $department->wait_status === 'High Wait' ? 'bg-red-50 text-red-700 border-red-200/60' : '' }}">
                                    {{ $department->wait_status }}
                                </span>
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-900 text-lg">{{ $department->name }}</h3>
                                <p class="text-xs text-slate-500 font-medium">{{ $department->location }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-2 border-t border-slate-200/50 pt-4 text-xs">
                                <div>
                                    <span
                                        class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Ahead</span>
                                    <span class="font-bold text-slate-800 text-base">{{ $department->patients_ahead }}
                                        Patients</span>
                                </div>
                                <div>
                                    <span
                                        class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Est.
                                        Wait</span>
                                    <span
                                        class="font-bold text-slate-800 text-base">~{{ $department->avg_wait_time_mins }}
                                        mins</span>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="">
                            @csrf
                            <input type="hidden" name="department_id" value="{{ $department->id }}">
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl text-xs transition shadow-md shadow-indigo-600/20 active:scale-[0.98]">
                                Join Queue
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-slate-500 font-medium">No active departments found for this hospital.</p>
                    </div>
                @endforelse
            </div>

            <!-- Empty Search State -->
            <div id="noResults" class="hidden text-center py-16 space-y-2">
                <p class="text-lg font-bold text-slate-800">No matching departments found</p>
                <p class="text-xs text-slate-500">Try searching with a different term.</p>
            </div>
    </div>
    </main>
    </div>

    <!-- LIVE SEARCH FILTER SCRIPT -->
    <script>
        function filterDepartments() {
            const query = document.getElementById('departmentSearch').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.department-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name').toLowerCase();
                if (query === '' || name.includes(query)) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            const noResults = document.getElementById('noResults');
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }
    </script>
</x-layout>
