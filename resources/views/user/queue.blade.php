<x-layout>
    <x-slot:title>Digital Queue Pass — Qura Healthcare</x-slot:title>

    <div class="max-w-4xl mx-auto px-4 sm:px-8 py-10 sm:py-16 space-y-10">

        <!-- TOP BAR: RETURN & SYNC -->
        <div class="flex items-center justify-between">
            <a href="{{ route('index') }}" 
                class="inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold text-ink-500 hover:text-ink-900 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Back to Departments</span>
            </a>

            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 text-xs text-ink-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Live Sync Active</span>
                </span>
            </div>
        </div>

        @if($activeTicket)
            <!-- ================= ACTIVE DIGITAL PASS ================= -->
            <div class="bg-white rounded-[2.5rem] border border-stone-200/90 p-8 sm:p-14 shadow-xs space-y-10">
                
                <!-- PASS TOP HEADER -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-stone-200 pb-6">
                    <div>
                        <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold block">
                            Outpatient Department • Queue Confirmation
                        </span>
                        <h1 class="font-editorial text-2xl sm:text-3xl text-ink-900 mt-1">
                            {{ $hospital->hospital_name ?? 'General Health Medical Center' }}
                        </h1>
                    </div>

                    <div class="text-left sm:text-right">
                        <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold block">Date Issued</span>
                        <span class="text-xs text-ink-700 font-medium">{{ $activeTicket->created_at->format('M d, Y • h:i A') }}</span>
                    </div>
                </div>

                <!-- MAIN SCULPTURAL TICKET & FLOATING QR BLOCK -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10">
                    
                    <!-- Left: Huge Ticket Number & Specialty -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <span class="font-editorial text-6xl sm:text-8xl text-ink-900 font-normal tracking-tight">
                                #{{ $activeTicket->ticket_number }}
                            </span>

                            <div class="space-y-1">
                                <div class="inline-block border border-stone-800 rounded-full px-3.5 py-0.5 font-editorial italic text-xs text-stone-800">
                                    Patient Ticket
                                </div>
                                <span class="text-[11px] text-emerald-700 font-semibold block">
                                    ● Currently Active
                                </span>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <h2 class="font-editorial text-3xl sm:text-4xl text-ink-900">
                                {{ $activeTicket->department }}
                            </h2>
                            <p class="text-sm text-ink-500 font-medium">
                                Location: <span class="text-ink-800 font-semibold">{{ $department->location ?? 'Outpatient Wing • Room 102' }}</span>
                            </p>
                            <p class="text-xs text-ink-400">
                                Patient Name: <span class="text-ink-700 font-medium">{{ Auth::user()->name ?: 'Nathan' }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Right: Floating Check-in QR Code Card -->
                    <div class="bg-[#FAF8F5] border border-stone-200 rounded-3xl p-6 text-center shrink-0 w-full sm:w-56 shadow-xs space-y-3">
                        <div class="w-28 h-28 mx-auto bg-white p-2.5 rounded-2xl border border-stone-200 flex items-center justify-center">
                            <svg class="w-full h-full text-ink-900" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14-2h4v2h-4v-2zm-4 0h2v4h-2v-4zm2 4h2v4h-2v-4zm2 2h4v2h-4v-2zm0-4h4v2h-4v-2zM5 5h2v2H5V5zm12 0h2v2h-2V5zM5 17h2v2H5v-2z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-mono uppercase font-bold text-ink-400 block tracking-wider">
                                REF: QURA-{{ str_pad($activeTicket->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="text-[10px] text-ink-500 font-medium block mt-0.5">
                                Scan at clinic entrance
                            </span>
                        </div>
                    </div>

                </div>

                <!-- LIVE METRICS (AIRY EDITORIAL STRIP) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-stone-200 border-y border-stone-200 py-6">
                    <div class="text-center py-2 sm:py-0 px-4">
                        <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold block">Queue Standing</span>
                        <span class="font-editorial text-3xl text-ink-900 block mt-1">
                            @if($peopleAhead === 0)
                                1st
                            @elseif($peopleAhead === 1)
                                2nd
                            @elseif($peopleAhead === 2)
                                3rd
                            @else
                                {{ $peopleAhead + 1 }}th
                            @endif
                        </span>
                        <span class="text-xs text-ink-500 font-medium mt-0.5 block">
                            @if($peopleAhead === 0)
                                You are next in line
                            @else
                                Position in line
                            @endif
                        </span>
                    </div>

                    <div class="text-center py-2 sm:py-0 px-4">
                        <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold block">Patients Ahead</span>
                        <span class="font-editorial text-3xl text-ink-900 block mt-1">{{ $peopleAhead }}</span>
                        <span class="text-xs text-ink-500 font-medium mt-0.5 block">Waiting before you</span>
                    </div>

                    <div class="text-center py-2 sm:py-0 px-4">
                        <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold block">Estimated Wait</span>
                        <span class="font-editorial text-3xl text-ink-900 block mt-1">~{{ $userWaitTime }}m</span>
                        <span class="text-xs text-ink-500 font-medium mt-0.5 block">Live calculation</span>
                    </div>
                </div>

                <!-- PATIENT JOURNEY TIMELINE -->
                <div class="space-y-4">
                    <span class="text-[10px] uppercase tracking-widest text-ink-400 font-semibold block">
                        Triage Progression
                    </span>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                        <div class="border-l-2 border-stone-900 pl-3 space-y-0.5">
                            <span class="text-[10px] uppercase tracking-wider text-ink-400 block font-semibold">Step 1</span>
                            <span class="font-semibold text-ink-900 block">Check-in Complete</span>
                            <span class="text-ink-400 block">Ticket generated</span>
                        </div>

                        <div class="border-l-2 border-stone-900 pl-3 space-y-0.5">
                            <span class="text-[10px] uppercase tracking-wider text-emerald-600 block font-semibold">Step 2 • Active</span>
                            <span class="font-semibold text-ink-900 block">In Queue Line</span>
                            <span class="text-ink-400 block">Waiting in hall</span>
                        </div>

                        <div class="border-l-2 border-stone-200 pl-3 space-y-0.5 opacity-50">
                            <span class="text-[10px] uppercase tracking-wider text-ink-400 block font-semibold">Step 3</span>
                            <span class="font-medium text-ink-700 block">Triage & Vitals</span>
                            <span class="text-ink-400 block">Nurse preparation</span>
                        </div>

                        <div class="border-l-2 border-stone-200 pl-3 space-y-0.5 opacity-50">
                            <span class="text-[10px] uppercase tracking-wider text-ink-400 block font-semibold">Step 4</span>
                            <span class="font-medium text-ink-700 block">Consultation</span>
                            <span class="text-ink-400 block">Room call</span>
                        </div>
                    </div>
                </div>

                <!-- PATIENT ADVISORY NOTE -->
                <div class="p-6 rounded-3xl bg-[#FAF8F5] border border-stone-200/80 text-xs text-ink-600 space-y-2">
                    <span class="font-semibold text-ink-900 block uppercase tracking-wider text-[11px]">
                        Notice for Your Visit:
                    </span>
                    <p class="leading-relaxed">
                        Please remain seated within hearing distance of the department intercom and display screens in <strong class="text-ink-900">{{ $department->location ?? 'your wing' }}</strong>. Have your photo ID and appointment reference ready.
                    </p>
                </div>

                <!-- ACTIONS -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-stone-100 print:hidden">
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="button" onclick="location.reload()" 
                            class="w-full sm:w-auto px-6 py-3 rounded-full text-xs font-semibold uppercase tracking-wider bg-ink-900 hover:bg-black text-white transition-all shadow-xs cursor-pointer active:scale-95">
                            Refresh Status
                        </button>

                        <button type="button" onclick="window.print()" 
                            class="w-full sm:w-auto px-6 py-3 rounded-full text-xs font-semibold uppercase tracking-wider bg-white hover:bg-stone-100 text-ink-800 border border-stone-200 transition-colors cursor-pointer">
                            Print Pass
                        </button>
                    </div>

                    <form method="POST" action="{{ route('queue.leave') }}" onsubmit="return confirm('Forfeit your place in line?');">
                        @csrf
                        <button type="submit" 
                            class="text-xs uppercase tracking-wider font-semibold text-stone-400 hover:text-rose-600 transition-colors cursor-pointer py-2">
                            Cancel & Leave Queue
                        </button>
                    </form>
                </div>

            </div>
        @else
            <!-- ================= NO ACTIVE PASS VIEW ================= -->
            <div class="bg-white rounded-[2.5rem] border border-stone-200 p-10 sm:p-16 text-center space-y-6 shadow-xs max-w-2xl mx-auto">
                <span class="font-editorial italic text-3xl text-ink-400 block">Qura Pass</span>
                
                <h2 class="font-editorial text-3xl sm:text-4xl text-ink-900">
                    No active clinic ticket
                </h2>

                <p class="text-ink-500 text-sm leading-relaxed max-w-md mx-auto">
                    You do not currently have a spot reserved in line. Browse our clinical specialties and join a queue when you're ready.
                </p>

                <div class="pt-4">
                    <a href="{{ route('index') }}" 
                        class="inline-flex items-center justify-center px-8 py-3.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-ink-900 hover:bg-black text-white transition-all shadow-xs active:scale-95">
                        Browse Departments
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-layout>