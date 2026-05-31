<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    listado: { type: Array, required: true },
    categoriaInicial: { type: String, default: 'Todas las categorías' },
    esAdmin: { type: Boolean, default: false },
});

const categorias = [
    'Todas las categorías', 'Electricista', 'Plomería', 'Programación',
    'Diseñador Gráfico', 'Pintura', 'Jardinería', 'Limpieza',
    'Construcción', 'Marketing', 'Fotografía',
];

const ordenes = [
    'Mejor valorados', 'Más reseñas',
    'Precio: Menor a Mayor', 'Precio: Mayor a Menor',
];

const categoria = ref(categorias.includes(props.categoriaInicial) ? props.categoriaInicial : 'Todas las categorías');
const orden = ref('Mejor valorados');
const busqueda = ref('');
const profesionales = ref([...props.listado]);
const perfilAbierto = ref(null);

const obtenerIcono = (cat) => {
    const iconos = {
        Electricista: '⚡', Plomería: '🔧', Carpintería: '🪵', Pintura: '🎨',
        Jardinería: '🌿', Limpieza: '🧼', Construcción: '🏗️', Programación: '💻',
        Marketing: '📢', Fotografía: '📷', 'Diseñador Gráfico': '🎨',
    };
    return iconos[cat] || '🛠️';
};

const estrellas = (calificacion) => {
    const n = Math.round(calificacion || 5);
    return '⭐'.repeat(Math.min(5, Math.max(1, n || 5)));
};

const profesionalesFiltrados = computed(() => {
    let lista = [...profesionales.value];

    if (categoria.value !== 'Todas las categorías') {
        lista = lista.filter((p) => p.nombre_categoria === categoria.value);
    }

    if (busqueda.value.trim()) {
        const q = busqueda.value.toLowerCase();
        lista = lista.filter((p) =>
            p.nombre?.toLowerCase().includes(q) ||
            p.especialidad?.toLowerCase().includes(q) ||
            p.nombre_categoria?.toLowerCase().includes(q)
        );
    }

    if (orden.value === 'Precio: Menor a Mayor') {
        lista.sort((a, b) => a.precio_estimado - b.precio_estimado);
    } else if (orden.value === 'Precio: Mayor a Menor') {
        lista.sort((a, b) => b.precio_estimado - a.precio_estimado);
    } else if (orden.value === 'Mejor valorados') {
        lista.sort((a, b) => (b.calificacion || 0) - (a.calificacion || 0));
    }

    return lista;
});

const eliminarProfesional = async (id) => {
    if (!window.confirm('¿Seguro que deseas eliminar este perfil?')) return;

    try {
        await axios.delete(`/profesionales/${id}`);
        profesionales.value = profesionales.value.filter((p) => p.id !== id);
        alert('Perfil eliminado correctamente');
    } catch {
        alert('Error al eliminar perfil');
    }
};
</script>

<template>
    <main class="bg-gray-50 min-h-screen">
        <section class="bg-white border-b border-gray-200 px-6 py-12">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Encuentra tu Profesional Ideal</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="bg-gray-100 rounded-lg px-4 py-3 flex items-center gap-3">
                        <span class="text-gray-400 text-xl">🔍</span>
                        <input v-model="busqueda" type="text"
                            placeholder="Buscar por nombre, servicio o categoría..."
                            class="bg-transparent outline-none w-full text-gray-700" />
                    </div>

                    <select v-model="categoria" class="bg-gray-100 rounded-lg px-4 py-3 outline-none cursor-pointer">
                        <option v-for="item in categorias" :key="item" :value="item">{{ item }}</option>
                    </select>

                    <select v-model="orden" class="bg-gray-100 rounded-lg px-4 py-3 outline-none cursor-pointer">
                        <option v-for="item in ordenes" :key="item" :value="item">{{ item }}</option>
                    </select>
                </div>

                <p class="mt-6 text-gray-600">
                    Mostrando {{ profesionalesFiltrados.length }} de {{ profesionales.length }} profesionales
                </p>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-12">
            <div v-if="profesionalesFiltrados.length === 0"
                class="bg-white border border-gray-200 rounded-xl p-16 text-center shadow-sm">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">No hay profesionales registrados</h2>
                <p class="text-gray-600 mb-8">Por el momento no hay profesionales en esta categoría.</p>
                <div class="inline-block bg-blue-50 text-blue-700 px-5 py-3 rounded-lg font-semibold">
                    Categoría seleccionada: {{ categoria }}
                </div>
            </div>

            <div v-else class="grid md:grid-cols-3 gap-8">
                <div v-for="p in profesionalesFiltrados" :key="p.id"
                    class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
                    <div class="flex items-center gap-4">
                        <img :src="p.foto || 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png'"
                            :alt="p.nombre" class="w-20 h-20 rounded-full object-cover" />
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ p.nombre }}</h3>
                            <p class="text-gray-600">{{ obtenerIcono(p.nombre_categoria) }} {{ p.nombre_categoria }}</p>
                            <p class="text-yellow-500 mt-1">{{ estrellas(p.calificacion) }}</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3 text-gray-700">
                        <p v-if="p.ciudad">📍 {{ p.ciudad }}</p>
                        <p v-if="p.telefono">📞 {{ p.telefono }}</p>
                        <p v-if="p.experiencia">💼 {{ p.experiencia }}</p>
                        <p>{{ obtenerIcono(p.nombre_categoria) }} {{ p.especialidad }}</p>
                    </div>

                    <p class="mt-6 text-gray-600">{{ p.descripcion_servicio || p.descripcion }}</p>

                    <div class="mt-6 border-t pt-4 flex justify-between">
                        <div>
                            <p class="text-blue-600 font-bold text-2xl">${{ p.precio_estimado }}</p>
                            <p class="text-sm text-gray-500">por servicio</p>
                        </div>
                        <div class="text-right text-sm text-gray-500">
                            <p v-if="p.modalidad">{{ p.modalidad }}</p>
                            <p v-if="p.disponibilidad">{{ p.disponibilidad }}</p>
                        </div>
                    </div>

                    <a :href="`/contacto?profesional=${p.id}`"
                        class="mt-4 block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-900 py-2 rounded-xl font-semibold">
                        Contactar
                    </a>

                    <button @click="perfilAbierto = perfilAbierto === p.id ? null : p.id"
                        class="mt-3 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl font-semibold">
                        Ver perfil
                    </button>

                    <div v-if="perfilAbierto === p.id"
                        class="mt-5 bg-blue-50 border border-blue-100 rounded-xl p-5 text-gray-700">
                        <h4 class="font-bold text-gray-900 mb-3">Información completa</h4>
                        <p><strong>Nombre:</strong> {{ p.nombre }}</p>
                        <p><strong>Categoría:</strong> {{ p.nombre_categoria }}</p>
                        <p><strong>Especialidad:</strong> {{ p.especialidad }}</p>
                        <p><strong>Experiencia:</strong> {{ p.experiencia }}</p>
                        <p><strong>Descripción:</strong> {{ p.descripcion_servicio || p.descripcion }}</p>
                        <p><strong>Valoración:</strong> {{ estrellas(p.calificacion) }}</p>
                    </div>

                    <button v-if="esAdmin" @click="eliminarProfesional(p.id)"
                        class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-xl font-semibold">
                        Eliminar perfil
                    </button>
                </div>
            </div>
        </section>
    </main>
</template>
