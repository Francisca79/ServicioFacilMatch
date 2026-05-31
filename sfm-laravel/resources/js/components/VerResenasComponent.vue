<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import IngresarResenaComponent from './IngresarResenaComponent.vue';

const props = defineProps({
    profesionales: { type: Array, default: () => [] },
    usuarioAutenticado: { type: Boolean, default: false },
    nombreUsuario: { type: String, default: '' },
});

const resenas = ref([]);
const cargando = ref(true);

const cargarResenas = async () => {
    cargando.value = true;
    try {
        const { data } = await axios.get('/api/resenas');
        resenas.value = data;
    } catch (e) {
        console.error(e);
    } finally {
        cargando.value = false;
    }
};

onMounted(cargarResenas);

const estrellas = (n) => '⭐'.repeat(n);

const formatearFecha = (fecha) => new Date(fecha).toLocaleDateString('es-SV');
</script>

<template>
    <main class="bg-gray-50 min-h-screen py-12 px-6">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Reseñas de Profesionales</h1>
            <p class="text-gray-600 mb-10">Opiniones verificadas de clientes sobre los servicios contratados.</p>

            <div class="grid lg:grid-cols-2 gap-8">
                <ingresar-resena-component
                    :profesionales="profesionales"
                    :usuario-autenticado="usuarioAutenticado"
                    :nombre-usuario="nombreUsuario"
                    @resena-agregada="cargarResenas"
                />

                <div>
                    <h2 class="text-xl font-bold mb-4">Reseñas publicadas</h2>
                    <div v-if="cargando" class="text-gray-500">Cargando reseñas...</div>
                    <div v-else-if="resenas.length === 0"
                        class="bg-white border rounded-xl p-10 text-center text-gray-500">
                        Aún no hay reseñas. Sé el primero en opinar.
                    </div>
                    <div v-else class="space-y-4 max-h-[600px] overflow-y-auto">
                        <div v-for="r in resenas" :key="r.id"
                            class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ r.user?.name ?? 'Cliente' }}</h3>
                                    <p class="text-sm text-blue-600">{{ r.profesional?.nombre }}</p>
                                    <p class="text-xs text-gray-400">{{ r.profesional?.categoria?.nombre_categoria }}</p>
                                </div>
                                <span class="text-yellow-500">{{ estrellas(r.calificacion) }}</span>
                            </div>
                            <p class="mt-3 text-gray-700">{{ r.comentario }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ formatearFecha(r.created_at) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
