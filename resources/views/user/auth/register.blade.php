<x-layout>
    <x-slot:title>Register — Qura</x-slot:title>

    <div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md bg-white p-8 sm:p-12 rounded-[2.5rem] border border-stone-200 shadow-xs space-y-8">
            
            <div class="text-center space-y-2">
                <span class="text-[10px] uppercase tracking-widest font-semibold text-ink-400">Patient Registration</span>
                <h1 class="font-editorial text-3xl sm:text-4xl text-ink-900 tracking-tight">Create Account</h1>
                <p class="text-xs text-ink-500 font-normal">Join Qura to check in and manage your outpatient visits.</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Full Name -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-[10px] uppercase tracking-widest font-semibold text-ink-500">
                        Full Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="John Doe" required
                        class="w-full px-5 py-3 bg-[#FAF8F5] border border-stone-200 rounded-full text-xs font-medium text-ink-900 placeholder:text-ink-400 focus:outline-none focus:border-ink-900 transition-colors">
                    @error('name')
                        <span class="text-xs text-rose-600 block pl-3">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-[10px] uppercase tracking-widest font-semibold text-ink-500">
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        placeholder="name@example.com" required
                        class="w-full px-5 py-3 bg-[#FAF8F5] border border-stone-200 rounded-full text-xs font-medium text-ink-900 placeholder:text-ink-400 focus:outline-none focus:border-ink-900 transition-colors">
                    @error('email')
                        <span class="text-xs text-rose-600 block pl-3">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-[10px] uppercase tracking-widest font-semibold text-ink-500">
                        Password (Min 8 Characters)
                    </label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required
                        class="w-full px-5 py-3 bg-[#FAF8F5] border border-stone-200 rounded-full text-xs font-medium text-ink-900 placeholder:text-ink-400 focus:outline-none focus:border-ink-900 transition-colors">
                    @error('password')
                        <span class="text-xs text-rose-600 block pl-3">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-[10px] uppercase tracking-widest font-semibold text-ink-500">
                        Confirm Password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required
                        class="w-full px-5 py-3 bg-[#FAF8F5] border border-stone-200 rounded-full text-xs font-medium text-ink-900 placeholder:text-ink-400 focus:outline-none focus:border-ink-900 transition-colors">
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3.5 px-6 rounded-full bg-ink-900 hover:bg-black text-white text-xs uppercase tracking-widest font-semibold transition-all shadow-xs cursor-pointer active:scale-98">
                        Register Account
                    </button>
                </div>
            </form>

            <div class="pt-4 border-t border-stone-100 text-center text-xs text-ink-500">
                <span>Already registered?</span>
                <a href="{{ route('login') }}" class="font-semibold text-ink-900 hover:underline ml-1">
                    Sign in here
                </a>
            </div>

        </div>
    </div>
</x-layout>