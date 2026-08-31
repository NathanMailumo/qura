<x-layout>
    <x-slot:title>Verify OTP</x-slot:title>

    <!-- Full-Screen Split View -->
    <div class="min-h-screen w-full flex flex-col lg:flex-row bg-[#F8FAFC]">
        
        <!-- Left Column: Full-Height Image Banner -->
        <div class="lg:w-1/2 relative min-h-[300px] lg:min-h-screen bg-slate-900 flex flex-col justify-between p-8 lg:p-12 text-white overflow-hidden">
            <img 
                src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1200&auto=format&fit=crop" 
                alt="Clinic background" 
                class="absolute inset-0 w-full h-full object-cover opacity-50 mix-blend-overlay"
            >
            
            <div class="relative z-10 flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <span class="font-bold text-lg text-white">Q</span>
                </div>
                <span class="font-bold text-2xl tracking-wide text-white">Qura</span>
            </div>

            <div class="relative z-10 bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 max-w-lg mb-4">
                <p class="text-xs uppercase tracking-widest text-blue-300 font-semibold mb-2">Smart Queueing</p>
                <h2 class="text-2xl font-semibold leading-tight">Streamline your clinic visit experience seamlessly.</h2>
            </div>
        </div>

        <!-- Right Column: Clean Form Container -->
        <div class="lg:w-1/2 flex items-center justify-center p-6 lg:p-16">
            <div class="w-full max-w-md bg-white p-8 lg:p-10 rounded-3xl shadow-sm border border-slate-100">
                
                <div class="mb-6">
                    <a href="{{ route('password.request') }}" class="inline-flex items-center text-xs text-slate-500 hover:text-blue-600 transition mb-4 font-medium">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Change Email
                    </a>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Enter Verification Code</h1>
                    <p class="text-slate-500 text-xs mt-1">
                        We sent a 6-digit code to 
                        <span class="font-semibold text-slate-700">{{ session('reset_email', 'your email') }}</span>.
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
                                    class="otp-digit w-12 h-14 text-center text-xl font-bold bg-[#F8FAFC] border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800 transition"
                                    required
                                >
                            @endfor
                        </div>
                        @error('otp')
                            <span class="text-xs text-red-500 mt-2 block text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full shadow-md shadow-blue-500/20 active:scale-[0.99] transition duration-150 text-sm flex items-center justify-center space-x-2"
                    >
                        <span>Verify Code</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <div class="text-center text-xs text-slate-500 mt-6">
                    Didn't receive code? 
                    <form action="{{ route('password.request') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('reset_email') }}">
                        <button type="submit" class="text-blue-600 font-semibold hover:underline bg-transparent border-0 p-0 cursor-pointer">
                            Resend OTP
                        </button>
                    </form>
                </div>

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
                // Focus first box automatically
                if (index === 0) input.focus();

                // Move forward on type
                input.addEventListener('input', (e) => {
                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                // Move backward on backspace
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // Handle complete code paste
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

            // Concatenate all 6 digits into the hidden #combined-otp input before sending
            form.addEventListener('submit', () => {
                let fullCode = '';
                inputs.forEach(input => fullCode += input.value);
                combinedInput.value = fullCode;
            });
        });
    </script>
</x-layout>