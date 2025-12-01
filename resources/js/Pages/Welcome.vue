<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Sistema de Agendamiento de Citas Médicas" />
    <div class="bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50 dark:bg-gradient-to-br dark:from-gray-900 dark:via-blue-900 dark:to-cyan-900 min-h-screen">
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-blue-600 selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <div class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-blue-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <div>
                                <h1 class="text-2xl font-bold text-blue-900 dark:text-white">MediCitas</h1>
                                <p class="text-xs text-blue-600 dark:text-cyan-300">Sistema Médico</p>
                            </div>
                        </div>
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-lg px-4 py-2 bg-blue-600 text-white font-semibold transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-lg px-4 py-2 text-blue-900 dark:text-white font-semibold transition hover:bg-blue-100 dark:hover:bg-blue-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="ml-3 rounded-lg px-4 py-2 bg-cyan-600 text-white font-semibold transition hover:bg-cyan-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <!-- Hero Section -->
                    <div class="text-center mb-12">
                        <h1 class="text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-cyan-500 to-teal-500 mb-4">
                            Sistema de Agendamiento
                        </h1>
                        <h2 class="text-4xl md:text-5xl font-bold text-blue-900 dark:text-white mb-6">
                            de Citas Médicas
                        </h2>
                        <p class="text-xl text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
                            Plataforma integral para la gestión, aprobación y denegación de citas médicas. 
                            Administra consultorios y agenda citas de manera profesional.
                        </p>
                    </div>

                    <!-- Features Grid -->
                    <div class="grid gap-6 lg:grid-cols-3 lg:gap-8 mb-8">
                        <!-- Consultorios Card -->
                        <div class="flex flex-col items-center text-center rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 transition duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <div class="flex size-20 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                Consultorios Médicos
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                Gestiona consultorios y centros de salud con información de capacidad, ubicación y disponibilidad.
                            </p>
                        </div>

                        <!-- Citas Card -->
                        <div class="flex flex-col items-center text-center rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 transition duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <div class="flex size-20 items-center justify-center rounded-full bg-gradient-to-br from-cyan-500 to-teal-500 mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                Agendamiento de Citas
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                Programa citas presenciales o virtuales. Aprueba o deniega solicitudes de manera eficiente.
                            </p>
                        </div>

                        <!-- Seguridad Card -->
                        <div class="flex flex-col items-center text-center rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 transition duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <div class="flex size-20 items-center justify-center rounded-full bg-gradient-to-br from-teal-500 to-emerald-500 mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                Seguridad Total
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                Protección de datos médicos con autenticación robusta y cumplimiento de estándares de salud.
                            </p>
                        </div>
                    </div>

                    <!-- Additional Features -->
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div class="rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-600 dark:from-blue-800 dark:to-cyan-800 p-8 shadow-xl text-white">
                            <div class="flex items-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-3xl font-bold">Características Principales</h3>
                            </div>
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">✓</span>
                                    <span class="text-lg">CRUD completo de consultorios y citas médicas</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">✓</span>
                                    <span class="text-lg">Sistema de aprobación y denegación de citas</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">✓</span>
                                    <span class="text-lg">Soporte para consultas presenciales y telemedicina</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">✓</span>
                                    <span class="text-lg">API REST con autenticación Sanctum</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">✓</span>
                                    <span class="text-lg">Filtrado avanzado de citas por consultorio</span>
                                </li>
                            </ul>
                        </div>

                        <div class="rounded-2xl bg-gradient-to-br from-teal-600 to-emerald-600 dark:from-teal-800 dark:to-emerald-800 p-8 shadow-xl text-white">
                            <div class="flex items-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h3 class="text-3xl font-bold">Tecnología Moderna</h3>
                            </div>
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">→</span>
                                    <span class="text-lg">Laravel 12 con Jetstream y Fortify</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">→</span>
                                    <span class="text-lg">Vue.js 3 con Inertia.js para SPA</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">→</span>
                                    <span class="text-lg">Tailwind CSS para diseño moderno</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">→</span>
                                    <span class="text-lg">PostgreSQL para almacenamiento robusto</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-3 text-2xl">→</span>
                                    <span class="text-lg">Autenticación de dos factores disponible</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-gray-600 dark:text-gray-400">
                    <div class="mb-4">
                        <p class="text-lg font-semibold text-blue-900 dark:text-cyan-400">MediCitas - Sistema de Agendamiento de Citas Médicas</p>
                    </div>
                    <p>Plataforma segura y profesional para la gestión médica</p>
                    <p class="mt-2">Laravel v{{ laravelVersion }} | PHP v{{ phpVersion }}</p>
                </footer>
            </div>
        </div>
    </div>
</template>
