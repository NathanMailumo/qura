<x-layout>
    <x-slot:title>Login</x-slot:title>

    <!-- Full-Screen Split View -->
    <div class="min-h-screen w-full flex flex-col lg:flex-row bg-[#F8FAFC]">

        <!-- Left Column: Full-Height Image Banner -->
        <div
            class="lg:w-1/2 relative min-h-[300px] lg:min-h-screen bg-slate-900 flex flex-col justify-between p-8 lg:p-12 text-white overflow-hidden">
            <!-- Fullscreen Cover Image -->
            <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1200&auto=format&fit=crop"
                alt="Clinic background" class="absolute inset-0 w-full h-full object-cover opacity-50 mix-blend-overlay">

            <!-- Branding Header -->
            <div class="relative z-10 flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <span class="font-bold text-lg text-white">Q</span>
                </div>
                <span class="font-bold text-2xl tracking-wide text-white">Qura</span>
            </div>

            <!-- Bottom Floating Overlay Card -->
            <div class="relative z-10 bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 max-w-lg mb-4">
                <p class="text-xs uppercase tracking-widest text-blue-300 font-semibold mb-2">Smart Queueing</p>
                <h2 class="text-2xl font-semibold leading-tight">Streamline your clinic visit experience seamlessly.
                </h2>
            </div>
        </div>

        <!-- Right Column: Clean Form Container -->
        <div class="lg:w-1/2 flex items-center justify-center p-6 lg:p-16">
            <!-- Constrained Form Card -->
            <div class="w-full max-w-md bg-white p-8 lg:p-10 rounded-3xl shadow-sm border border-slate-100">

                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Welcome Back</h1>
                    <p class="text-slate-500 text-xs mt-1">Log in to manage your queue tickets.</p>
                </div>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        @error('email')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror

                        <label for="email"
                            class="block text-[11px] font-semibold text-slate-600 mb-1 uppercase tracking-wider">Email
                            Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="name@example.com" required
                            class="w-full px-4 py-2.5 bg-[#F8FAFC] border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-800 transition">

                        {{-- @error('email')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror --}}

                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password"
                                class="block text-[11px] font-semibold text-slate-600 uppercase tracking-wider">Password</label>
                            <a href="{{ route('password.reset') }}"
                                class="text-[11px] font-semibold text-blue-600 hover:underline">
                                Forgot password?
                            </a>
                        </div>
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                            class="w-full px-4 py-2.5 bg-[#F8FAFC] border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-800 transition">
                        @error('password')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    {{-- <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 text-blue-600 bg-[#F8FAFC] border-slate-200 rounded focus:ring-blue-500 transition">
                            <span class="text-xs font-medium text-slate-600">Remember me</span>
                        </label>
                    </div> --}}

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full shadow-md shadow-blue-500/20 active:scale-[0.99] transition duration-150 text-sm mt-2">
                        Login
                    </button>
                </form>

                <p class="text-center text-xs text-slate-500 mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Register
                        here</a>
                </p>
            </div>
        </div>

    </div>
</x-layout>
