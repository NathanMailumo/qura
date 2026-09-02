<x-layout>
    <x-slot:title>Verify OTP — Qura</x-slot:title>

    <div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md bg-white p-8 sm:p-12 rounded-[2.5rem] border border-stone-200 shadow-xs space-y-8">
            
            <div>
                <a href="{{ route('password.request') }}" class="inline-flex items-center text-xs uppercase tracking-widest font-semibold text-ink-400 hover:text-ink-900 transition-colors mb-6">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Change Email
                </a>
                <h1 class="font-editorial text-3xl sm:text-4xl text-ink-900 tracking-tight">Verification Code</h1>
                <p class="text-xs text-ink-500 mt-1">
                    We sent a 6-digit verification code to 
                    <span class="font-semibold text-ink-900">{{ session('reset_email', 'your email') }}</span>.
                </p>
            </div>

            <form action="{{ route('password.otp.verify') }}" method="POST" id="otp-form" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                <input type="hidden" name="otp" id="combined-otp">

                <!-- 6-Digit Box Inputs -->
                <div>
                    <div class="flex items-center justify-between gap-2" id="otp-inputs">
                        @for ($i = 0; $i < 6; $i++)
                            <input 
                                type="text" 
                                maxlength="1" 
                                inputmode="numeric" 
                                pattern="[0-9]*" 
                                class="otp-digit w-12 h-14 text-center text-xl font-editorial font-bold bg-[#FAF8F5] border border-stone-200 rounded-2xl focus:bg-white focus:outline-none focus:border-ink-900 text-ink-900 transition-colors"
                                required
                            >
                        @endfor
                    </div>
                    @error('otp')
                        <span class="text-xs text-rose-600 mt-2 block text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3.5 px-6 rounded-full bg-ink-900 hover:bg-black text-white text-xs uppercase tracking-widest font-semibold transition-all shadow-xs cursor-pointer active:scale-98">
                        Verify Code
                    </button>
                </div>
            </form>

            <div class="text-center text-xs text-ink-500">
                Didn't receive the code? 
                <form action="{{ route('password.request') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('reset_email') }}">
                    <button type="submit" class="font-semibold text-ink-900 hover:underline bg-transparent border-0 p-0 cursor-pointer ml-1">
                        Resend OTP
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- JavaScript for auto-tabbing, pasting, & submitting -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.otp-digit');
            const combinedInput = document.getElementById('combined-otp');
            const form = document.getElementById('otp-form');

            inputs.forEach((input, index) => {
                if (index === 0) input.focus();

                input.addEventListener('input', (e) => {
                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasteData = e.clipboardData.getData('text').trim();
                    if (/^\d{6}$/.test(pasteData)) {
                        pasteData.split('').forEach((char, i) => {
                            if (inputs[i]) inputs[i].value = char;
                        });
                        inputs[inputs.length - 1].focus();
                    }
                });
            });

            form.addEventListener('submit', () => {
                let fullCode = '';
                inputs.forEach(input => fullCode += input.value);
                combinedInput.value = fullCode;
            });
        });
    </script>
</x-layout>