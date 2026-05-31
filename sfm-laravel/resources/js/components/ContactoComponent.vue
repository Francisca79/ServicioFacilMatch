<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    profesionales: { type: Array, default: () => [] },
});

const form = ref({
    profesional_id: '',
    nombre: '',
    correo: '',
    mensaje: '',
});

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('profesional');
    if (id) form.value.profesional_id = id;
});

const enviando = ref(false);
const mensaje = ref('');
const error = ref('');

const enviar = async () => {
    enviando.value = true;
    error.value = '';
    mensaje.value = '';

    try {
        await axios.post('/api/contactos', form.value);
        mensaje.value = 'Mensaje enviado correctamente. El profesional te contactará pronto.';
        form.value = { profesional_id: '', nombre: '', correo: '', mensaje: '' };
    } catch (e) {
        const errors = e.response?.data?.errors;
        error.value = errors ? Object.values(errors).flat().join(' ') : 'Error al enviar el mensaje.';
    } finally {
        enviando.value = false;
    }
};
</script>

<template>
    <main class="bg-gray-50 min-h-screen py-12 px-6">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Contacto</h1>
            <p class="text-gray-600 mb-8">Envía un mensaje directo al profesional que te interese.</p>

            <div class="bg-white rounded-2xl shadow-md p-10">
                <form @submit.prevent="enviar" class="space-y-5">
                    <div>
                        <label class="block font-medium mb-1">Profesional</label>
                        <select v-model="form.profesional_id" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none">
                            <option value="">Seleccione un profesional</option>
                            <option v-for="p in profesionales" :key="p.id" :value="p.id">
                                {{ p.nombre }} — {{ p.nombre_categoria || p.categoria?.nombre_categoria }}
                            </option>
                        </select>
                    </div>

                    <input v-model="form.nombre" type="text" placeholder="Tu nombre" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none" />

                    <input v-model="form.correo" type="email" placeholder="Tu correo electrónico" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none" />

                    <textarea v-model="form.mensaje" rows="5" placeholder="Escribe tu mensaje..." required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none"></textarea>

                    <p v-if="mensaje" class="text-green-600">{{ mensaje }}</p>
                    <p v-if="error" class="text-red-600">{{ error }}</p>

                    <button type="submit" :disabled="enviando"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white py-4 rounded-xl font-bold disabled:opacity-50">
                        {{ enviando ? 'Enviando...' : 'Enviar mensaje' }}
                    </button>
                </form>

                <div class="mt-10 pt-8 border-t text-gray-600 text-sm space-y-1">
                    <p>📧 contacto@sfm.com</p>
                    <p>📞 7777-7777</p>
                    <p>📍 San Miguel, El Salvador</p>
                </div>
            </div>
        </div>
    </main>
</template>
