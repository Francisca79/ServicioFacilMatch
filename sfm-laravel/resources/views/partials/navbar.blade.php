<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            @include('partials.logo')
            <span class="font-bold text-4xl text-gray-900">SFM</span>
        </a>

        @guest
            <div class="hidden lg:flex gap-6 text-gray-800 font-medium items-center">
                <a href="/" class="hover:text-blue-600">Inicio</a>
                <a href="/profesionales" class="hover:text-blue-600">Profesionales</a>
                <a href="/categorias" class="hover:text-blue-600">Categorías</a>
                <a href="/resenas" class="hover:text-blue-600">Reseñas</a>
            </div>
        @endguest

        <div class="flex items-center gap-3">
            @auth
                <a href="/" class="font-semibold text-gray-900 hover:text-blue-600 text-sm">Inicio</a>

                @if ($mensajesUrl ?? null)
                    <a href="{{ $mensajesUrl }}" class="relative p-2 rounded-lg hover:bg-gray-100" title="Mensajería">
                        <span class="text-xl">💬</span>
                        @if (($mensajesNoLeidos ?? 0) > 0)
                            <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-xs font-bold min-w-[1.25rem] h-5 px-1 rounded-full flex items-center justify-center">
                                {{ $mensajesNoLeidos > 99 ? '99+' : $mensajesNoLeidos }}
                            </span>
                        @endif
                    </a>
                @endif

                <div class="relative group">
                    <button class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg text-sm">
                        <img src="{{ auth()->user()->foto_url }}" class="w-8 h-8 rounded-full object-cover border" alt="">
                        <span class="hidden sm:inline font-medium">{{ auth()->user()->name }}</span>
                        <span>▾</span>
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-white border rounded-xl shadow-lg py-2 hidden group-hover:block z-50">
                        <a href="{{ auth()->user()->panelRoute() }}" class="block px-4 py-2 hover:bg-gray-50 text-sm font-semibold text-blue-600">
                            @if (auth()->user()->isAdmin()) Panel Admin
                            @elseif (auth()->user()->isProfesional()) Mi Panel Profesional
                            @else Mi Panel Cliente
                            @endif
                        </a>
                        @if (auth()->user()->isAdmin())
                            <a href="/panel/admin/perfil" class="block px-4 py-2 hover:bg-gray-50 text-sm">Mi perfil</a>
                        @elseif (auth()->user()->isCliente())
                            <a href="/panel/cliente/perfil" class="block px-4 py-2 hover:bg-gray-50 text-sm">Mi perfil</a>
                            <a href="/panel/cliente/mensajes" class="block px-4 py-2 hover:bg-gray-50 text-sm flex items-center justify-between">
                                Mensajería
                                @if (($mensajesNoLeidos ?? 0) > 0)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $mensajesNoLeidos }}</span>
                                @endif
                            </a>
                        @elseif (auth()->user()->isProfesional())
                            <a href="/panel/profesional/editar" class="block px-4 py-2 hover:bg-gray-50 text-sm">Editar perfil</a>
                            <a href="/panel/profesional/mensajes" class="block px-4 py-2 hover:bg-gray-50 text-sm flex items-center justify-between">
                                Mensajería
                                @if (($mensajesNoLeidos ?? 0) > 0)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $mensajesNoLeidos }}</span>
                                @endif
                            </a>
                        @endif
                        <hr class="my-1">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-50 text-sm text-red-600">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="font-semibold text-gray-900 hover:text-blue-600 text-sm">Iniciar Sesión</a>
                <div class="relative group">
                    <button class="bg-gray-950 text-white px-4 py-2 rounded-lg font-semibold text-sm">Registrarse ▾</button>
                    <div class="absolute right-0 mt-2 w-48 bg-white border rounded-xl shadow-lg py-2 hidden group-hover:block z-50">
                        <a href="/registro" class="block px-4 py-2 hover:bg-gray-50 text-sm">Soy Profesional</a>
                        <a href="/registro-cliente" class="block px-4 py-2 hover:bg-gray-50 text-sm">Soy Cliente</a>
                    </div>
                </div>
                <div class="lg:hidden relative group">
                    <button class="bg-gray-100 px-3 py-2 rounded-lg text-sm">☰</button>
                    <div class="absolute right-0 mt-2 w-48 bg-white border rounded-xl shadow-lg py-2 hidden group-hover:block z-50">
                        <a href="/" class="block px-4 py-2 hover:bg-gray-50 text-sm">Inicio</a>
                        <a href="/profesionales" class="block px-4 py-2 hover:bg-gray-50 text-sm">Profesionales</a>
                        <a href="/categorias" class="block px-4 py-2 hover:bg-gray-50 text-sm">Categorías</a>
                        <a href="/resenas" class="block px-4 py-2 hover:bg-gray-50 text-sm">Reseñas</a>
                    </div>
                </div>
            @endauth
        </div>
    </nav>
</header>
