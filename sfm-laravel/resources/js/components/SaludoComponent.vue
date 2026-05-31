<script setup>
import { ref } from 'vue';

const nombre = ref('');
</script>

<template>
    <div class="p-6 bg-blue-50 rounded-xl border border-blue-200">
        <h2 class="text-xl font-bold mb-4">Saludo dinámico (Vue 3)</h2>
        <input
            v-model="nombre"
            type="text"
            placeholder="Escribe tu nombre"
            class="border rounded-lg px-4 py-2 w-full max-w-md"
        />
        <p v-if="nombre" class="mt-4 text-lg">
            Hola, <strong>{{ nombre }}</strong>. Bienvenido a Servicio Fácil Match.
        </p>
    </div>
</template>
