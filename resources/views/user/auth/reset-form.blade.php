<x-layout>
    <x-slot:title>Reset Password</x-slot:title>

    <div class="min-h-screen w-full flex flex-col lg:flex-row bg-[#F8FAFC]">
        <!-- Left Banner -->
        <div class="lg:w-1/2 relative min-h-[300px] lg:min-h-screen bg-slate-900 flex flex-col justify-between p-8 lg:p-12 text-white overflow-hidden">
            <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1200&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-50 mix-blend-overlay">
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

        <!-- Right Form Container -->
        <div class="lg:w-1/2 flex items-center justify-center p-6 lg:p-16">
            <div class="w-full max-w-md bg-white p-8 lg:p-10 rounded-3xl shadow-sm border border-slate-100">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Set New Password</h1>
                    <p class="text-slate-500 text-xs mt-1">Please enter your new password below.</p>
                </div>

                <form action="{{ route('password.reset.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('reset_email') }}">

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">New Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 bg-[#F8FAFC] border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-800">
                        @error('password')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-3 bg-[#F8FAFC] border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-800">
                    </div>

                    <button type="submit" class="w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full shadow-md shadow-blue-500/20 active:scale-[0.99] transition duration-150 text-sm">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>