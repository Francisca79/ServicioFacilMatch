<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    profesionales: { type: Array, default: () => [] },
    usuarioAutenticado: { type: Boolean, default: false },
    nombreUsuario: { type: String, default: '' },
});

const emit = defineEmits(['resena-agregada']);

const form = ref({
    profesional_id: '',
    calificacion: 5,
    comentario: '',
    nombre: props.nombreUsuario || '',
});

const enviando = ref(false);
const mensaje = ref('');
const error = ref('');

const enviar = async () => {
    enviando.value = true;
    error.value = '';
    mensaje.value = '';

    try {
        await axios.post('/api/resenas', form.value);
        mensaje.value = 'Reseña publicada correctamente.';
        form.value.comentario = '';
        form.value.calificacion = 5;
        emit('resena-agregada');
    } catch (e) {
        error.value = e.response?.data?.message || 'Error al publicar la reseña.';
    } finally {
        enviando.value = false;
    }
};
</script>

<template>
    <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
        <h2 class="text-xl font-bold mb-6">Publicar reseña</h2>

        <form @submit.prevent="enviar" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Tu nombre</label>
                <input v-model="form.nombre" type="text" required
                    :readonly="usuarioAutenticado"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Profesional</label>
                <select v-model="form.profesional_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none">
                    <option value="">Seleccione un profesional</option>
                    <option v-for="p in profesionales" :key="p.id" :value="p.id">
                        {{ p.nombre }} — {{ p.nombre_categoria || p.categoria?.nombre_categoria }}
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Calificación</label>
                <select v-model="form.calificacion"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none">
                    <option v-for="n in 5" :key="n" :value="n">{{ n }} estrella(s)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Comentario</label>
                <textarea v-model="form.comentario" rows="4" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none"
                    placeholder="Describe tu experiencia con el profesional..."></textarea>
            </div>

            <p v-if="mensaje" class="text-green-600 text-sm">{{ mensaje }}</p>
            <p v-if="error" class="text-red-600 text-sm">{{ error }}</p>

            <button type="submit" :disabled="enviando"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold disabled:opacity-50">
                {{ enviando ? 'Publicando...' : 'Publicar reseña' }}
            </button>
        </form>
    </div>
</template>
