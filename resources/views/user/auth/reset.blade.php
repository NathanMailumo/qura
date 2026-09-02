<x-layout>
    <x-slot:title>Reset Password — Qura</x-slot:title>

    <div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md bg-white p-8 sm:p-12 rounded-[2.5rem] border border-stone-200 shadow-xs space-y-8">
            
            <div>
                <a href="{{ route('login') }}" class="inline-flex items-center text-xs uppercase tracking-widest font-semibold text-ink-400 hover:text-ink-900 transition-colors mb-6">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Login
                </a>
                <h1 class="font-editorial text-3xl sm:text-4xl text-ink-900 tracking-tight">Reset Password</h1>
                <p class="text-xs text-ink-500 mt-1">Enter your registered email address and we will send you a verification code.</p>
            </div>

            <form action="{{ route('password.request') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="block text-[10px] uppercase tracking-widest font-semibold text-ink-500">
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        placeholder="name@example.com" required autofocus
                        class="w-full px-5 py-3 bg-[#FAF8F5] border border-stone-200 rounded-full text-xs font-medium text-ink-900 placeholder:text-ink-400 focus:outline-none focus:border-ink-900 transition-colors">
                    @error('email')
                        <span class="text-xs text-rose-600 block pl-3">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3.5 px-6 rounded-full bg-ink-900 hover:bg-black text-white text-xs uppercase tracking-widest font-semibold transition-all shadow-xs cursor-pointer active:scale-98">
                        Send Verification Code
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-layout>