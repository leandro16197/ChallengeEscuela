<x-guest-layout>
    <div class="py-4 px-2">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-50 rounded-3xl mb-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">School<span class="text-indigo-600">App</span></h2>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.2em] mt-2">Portal de Acceso</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-8">
            @csrf

            <div class="max-w-[90%] mx-auto">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-5">Email Institucional</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                    class="block w-full px-8 py-4 rounded-full bg-gray-50 border-none focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300 text-gray-600 shadow-inner"
                    placeholder="ejemplo@escuela.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-5" />
            </div>

            <div class="max-w-[90%] mx-auto">
                <div class="flex justify-between items-center mb-2 ml-5">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Contraseña</label>
                </div>
                <input type="password" name="password" required 
                    class="block w-full px-8 py-4 rounded-full bg-gray-50 border-none focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300 text-gray-600 shadow-inner"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-5" />
            </div>

            <div class="max-w-[85%] mx-auto flex items-center justify-between px-2">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded-md border-gray-200 text-indigo-600 focus:ring-indigo-500 transition-all">
                    <label for="remember_me" class="ml-2 text-[11px] text-gray-500 font-bold uppercase tracking-tighter">Recordarme</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="text-[11px] font-black text-indigo-600 hover:text-indigo-800 transition uppercase tracking-tighter" href="{{ route('password.request') }}">¿Olvidaste tu clave?</a>
                @endif
            </div>

            <div class="max-w-[90%] mx-auto pt-2">
                <button type="submit" 
                    style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;"
                    class="w-full py-4 rounded-full font-black text-white text-sm uppercase tracking-widest shadow-xl shadow-indigo-200 hover:shadow-indigo-300 transform transition-all duration-300 hover:-translate-y-1 active:scale-95 flex justify-center items-center">
                    <span>Entrar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>

        <div class="mt-12 text-center">
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">
                ¿Nuevo aquí? 
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline decoration-2 underline-offset-4 ml-1">
                    Crea una cuenta
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>