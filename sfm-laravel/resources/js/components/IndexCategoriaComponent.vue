<script setup>
const props = defineProps({
    categorias: { type: Array, required: true },
});

const obtenerIcono = (nombre) => {
    const iconos = {
        Electricista: '⚡', Plomería: '🔧', Plomero: '🔧', Programación: '💻',
        'Diseñador Gráfico': '🎨', Pintura: '🎨', Jardinería: '🌿', Limpieza: '🧼',
        Construcción: '🏗️', Marketing: '📢', Fotografía: '📷', Reparaciones: '🔩',
        Diseño: '✏️', Carpintería: '🪵',
    };
    return iconos[nombre] || '🛠️';
};
</script>

<template>
    <main class="bg-gray-50 min-h-screen py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 text-center">Categorías de Servicios</h1>
            <p class="text-gray-600 text-center mb-12">Explora profesionales por categoría</p>

            <div class="space-y-8">
                <div v-for="categoria in categorias" :key="categoria.id"
                    class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl">
                            {{ obtenerIcono(categoria.nombre_categoria) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ categoria.nombre_categoria }}</h2>
                            <p class="text-gray-600">{{ categoria.descripcion }}</p>
                        </div>
                        <a :href="`/profesionales?categoria=${encodeURIComponent(categoria.nombre_categoria)}`"
                            class="ml-auto bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">
                            Ver todos
                        </a>
                    </div>

                    <div v-if="categoria.profesionales?.length" class="grid md:grid-cols-3 gap-4">
                        <div v-for="p in categoria.profesionales" :key="p.id"
                            class="border border-gray-100 rounded-lg p-4 bg-gray-50">
                            <h3 class="font-bold">{{ p.nombre }}</h3>
                            <p class="text-sm text-gray-600">{{ p.especialidad }}</p>
                            <p class="text-blue-600 font-bold mt-2">${{ p.precio_estimado }}</p>
                        </div>
                    </div>
                    <p v-else class="text-gray-500 text-sm">No hay profesionales en esta categoría aún.</p>
                </div>
            </div>
        </div>
    </main>
</template>
