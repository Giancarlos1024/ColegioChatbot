<template>
  <section 
    id="inicio"
    class="mt-[60px] flex h-screen items-center 
           bg-gradient-to-r from-blue-50 to-cyan-50
           dark:from-gray-900 dark:to-gray-800 transition-colors duration-500"
  >
    <div class="mx-auto grid max-w-[1400px] items-center gap-10 px-8 md:grid-cols-2">
      
      <!-- Texto principal -->
      <div>
        <h1 class="text-4xl md:text-6xl font-bold text-blue-700 dark:text-cyan-400 mb-4 transition-colors duration-500">
          INIF N° 48 <br />
          <span class="text-blue-900 dark:text-cyan-200">
            Sistema de Gestión e Inscripción de Talleres
          </span>
        </h1>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-6 transition-colors duration-500">
          Plataforma moderna para la gestión eficiente de talleres educativos. 
          Facilita las inscripciones, administración y seguimiento de todos los talleres 
          de nuestra institución educativa con tecnología avanzada.
        </p>

        <!-- Botones principales -->
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
          <a href="/login" 
             class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg shadow-lg transition-all duration-200 hover:scale-105 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Iniciar Sesión
          </a>
          <a href="/register" 
             class="flex items-center justify-center bg-cyan-600 hover:bg-cyan-700 text-white px-8 py-4 rounded-lg shadow-lg transition-all duration-200 hover:scale-105 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Registrarse
          </a>
        </div>

        <!-- Botones secundarios -->
        <div class="flex space-x-4">
          <a href="#servicios" 
             class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-6 py-3 rounded-lg transition font-medium">
            Ver Funcionalidades
          </a>
          <a href="#contacto"
             class="border-2 border-gray-400 text-gray-600 hover:bg-gray-600 hover:text-white px-6 py-3 rounded-lg transition font-medium">
            Contáctanos
          </a>
        </div>
      </div>

      <!-- Carrusel de imágenes -->
      <div class="hidden md:flex flex-col items-center relative w-full overflow-hidden rounded-xl shadow-xl">
        <div
          class="flex transition-transform duration-700 ease-in-out"
          :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
        >
          <img
            v-for="(img, index) in images"
            :key="index"
            :src="img"
            alt="Sistema biométrico"
            class="w-full h-[480px] object-cover flex-shrink-0"
          />
        </div>

        <!-- Botones de navegación -->
        <button 
          @click="prev" 
          class="absolute left-2 top-1/2 -translate-y-1/2 
                 bg-white/70 dark:bg-gray-700/70 
                 p-3 rounded-full shadow 
                 hover:bg-white dark:hover:bg-gray-600 
                 transition-colors"
        >
          &#8592;
        </button>
        <button 
          @click="next" 
          class="absolute right-2 top-1/2 -translate-y-1/2 
                 bg-white/70 dark:bg-gray-700/70 
                 p-3 rounded-full shadow 
                 hover:bg-white dark:hover:bg-gray-600 
                 transition-colors"
        >
          &#8594;
        </button>
      </div>

    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from "vue";

const images = [

  "/imagenes/taller2.jpg",
  "/imagenes/taller3.jpg",
  "/imagenes/taller4.jpg",
  "/imagenes/taller5.jpg",
  "/imagenes/taller6.jpg",
  "/imagenes/taller7.jpg",
  "/imagenes/taller 8.jpg",
];

const currentIndex = ref(0);

const prev = (): void => {
  currentIndex.value = (currentIndex.value - 1 + images.length) % images.length;
};

const next = (): void => {
  currentIndex.value = (currentIndex.value + 1) % images.length;
};

// Cambio automático cada 5 segundos
let intervalId: number;
onMounted(() => {
  intervalId = window.setInterval(next, 5000);
});
onUnmounted(() => {
  clearInterval(intervalId);
});
</script>
