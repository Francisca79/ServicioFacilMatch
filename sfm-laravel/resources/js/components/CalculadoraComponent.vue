<script setup>
import { ref } from 'vue';
import axios from 'axios';

const num1 = ref('');
const num2 = ref('');
const operacion = ref('sumar');
const resultado = ref(null);

const calcular = async () => {
    const response = await axios.post('/calcular', {
        num1: num1.value,
        num2: num2.value,
        operacion: operacion.value,
    });

    resultado.value = response.data.res;
};
</script>

<template>
    <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm max-w-md">
        <h2 class="text-xl font-bold mb-4">Calculadora SFM (Vue + Axios)</h2>

        <div class="space-y-3">
            <input
                v-model="num1"
                type="number"
                placeholder="Número 1"
                class="border rounded-lg px-4 py-2 w-full"
            />
            <input
                v-model="num2"
                type="number"
                placeholder="Número 2"
                class="border rounded-lg px-4 py-2 w-full"
            />
            <select v-model="operacion" class="border rounded-lg px-4 py-2 w-full">
                <option value="sumar">Sumar</option>
                <option value="restar">Restar</option>
                <option value="multiplicar">Multiplicar</option>
                <option value="dividir">Dividir</option>
            </select>
            <button
                @click="calcular"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700"
            >
                Calcular
            </button>
        </div>

        <p v-if="resultado !== null" class="mt-4 text-2xl font-bold text-blue-700">
            Resultado: {{ resultado }}
        </p>
    </div>
</template>
