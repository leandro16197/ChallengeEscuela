<x-guest-layout>
    <div class="py-4 px-2">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 rounded-3xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Crear <span class="text-indigo-600">Cuenta</span></h2>
            <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mt-2">Únete a la comunidad SchoolApp</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div class="max-w-[85%] mx-auto">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-5">Nombre Completo</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="block w-full px-7 py-3.5 rounded-full bg-gray-50 border-none focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300 text-gray-600 shadow-inner text-sm"
                    placeholder="Tu nombre">
                <x-input-error :messages="$errors->get('name')" class="mt-1 ml-5" />
            </div>

            <div class="max-w-[85%] mx-auto">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-5">Email Institucional</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="block w-full px-7 py-3.5 rounded-full bg-gray-50 border-none focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300 text-gray-600 shadow-inner text-sm"
                    placeholder="correo@escuela.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1 ml-5" />
            </div>

            <div class="max-w-[85%] mx-auto">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-5">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="block w-full px-7 py-3.5 rounded-full bg-gray-50 border-none focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300 text-gray-600 shadow-inner text-sm"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-1 ml-5" />
            </div>

            <div class="max-w-[85%] mx-auto">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-5">Confirmar Contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="block w-full px-7 py-3.5 rounded-full bg-gray-50 border-none focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300 text-gray-600 shadow-inner text-sm"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 ml-5" />
            </div>

            <div class="max-w-[85%] mx-auto pt-4">
                <button type="submit" 
                    style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;"
                    class="w-full py-4 rounded-full font-black text-white text-xs uppercase tracking-widest shadow-xl shadow-indigo-200 hover:shadow-indigo-300 transform transition-all duration-300 hover:-translate-y-1 active:scale-95 flex justify-center items-center">
                    <span>Crear Cuenta</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>
        </form>

        <div class="mt-10 text-center">
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline decoration-2 underline-offset-4 ml-1">
                    Inicia Sesión
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>