<x-layout>
    <x-slot:title>Set New Password — Qura</x-slot:title>

    <div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md bg-white p-8 sm:p-12 rounded-[2.5rem] border border-stone-200 shadow-xs space-y-8">
            
            <div class="text-center space-y-2">
                <span class="text-[10px] uppercase tracking-widest font-semibold text-ink-400">Security</span>
                <h1 class="font-editorial text-3xl sm:text-4xl text-ink-900 tracking-tight">Set New Password</h1>
                <p class="text-xs text-ink-500 font-normal">Choose a secure password for your Qura account.</p>
            </div>

            <form action="{{ route('password.reset.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">

                <div class="space-y-1.5">
                    <label class="block text-[10px] uppercase tracking-widest font-semibold text-ink-500">
                        New Password
                    </label>
                    <input type="password" name="password" required 
                        placeholder="••••••••"
                        class="w-full px-5 py-3 bg-[#FAF8F5] border border-stone-200 rounded-full text-xs font-medium text-ink-900 placeholder:text-ink-400 focus:outline-none focus:border-ink-900 transition-colors">
                    @error('password')
                        <span class="text-xs text-rose-600 block pl-3">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] uppercase tracking-widest font-semibold text-ink-500">
                        Confirm New Password
                    </label>
                    <input type="password" name="password_confirmation" required 
                        placeholder="••••••••"
                        class="w-full px-5 py-3 bg-[#FAF8F5] border border-stone-200 rounded-full text-xs font-medium text-ink-900 placeholder:text-ink-400 focus:outline-none focus:border-ink-900 transition-colors">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3.5 px-6 rounded-full bg-ink-900 hover:bg-black text-white text-xs uppercase tracking-widest font-semibold transition-all shadow-xs cursor-pointer active:scale-98">
                        Update Password
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-layout>