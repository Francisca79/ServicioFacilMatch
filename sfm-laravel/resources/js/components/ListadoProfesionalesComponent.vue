<script setup>
const props = defineProps({
    listado: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="mt-6">
        <h2 class="text-xl font-bold mb-4">Profesionales desde BD (Vue + props)</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Nombre</th>
                    <th class="border border-gray-300 px-4 py-2">Especialidad</th>
                    <th class="border border-gray-300 px-4 py-2">Precio</th>
                    <th class="border border-gray-300 px-4 py-2">Categoría</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="profesional in listado" :key="profesional.id">
                    <td class="border border-gray-300 px-4 py-2">{{ profesional.id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ profesional.nombre }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ profesional.especialidad }}</td>
                    <td class="border border-gray-300 px-4 py-2">${{ profesional.precio_estimado }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ profesional.categoria?.nombre_categoria ?? '—' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
