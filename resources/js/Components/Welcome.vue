<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-gradient-to-r from-blue-600 via-cyan-500 to-teal-500 dark:from-blue-900 dark:via-cyan-900 dark:to-teal-900 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white drop-shadow-lg mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <div>
                    <h1 class="text-4xl font-bold text-white drop-shadow-md">
                        Sistema de Agendamiento de Citas Médicas
                    </h1>
                    <p class="mt-2 text-cyan-100 text-lg">Gestión eficiente de consultas y pacientes</p>
                </div>
            </div>

            <p class="mt-6 text-white text-lg leading-relaxed drop-shadow-sm">
                Plataforma integral para la gestión, agendamiento, aprobación y denegación de citas médicas. 
                Administra tus consultorios médicos y agenda citas de manera profesional y organizada.
            </p>
        </div>

        <div class="bg-gradient-to-br from-gray-50 to-blue-50 dark:bg-gray-800 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
            <Link :href="route('venues.index')" class="group">
                <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="size-12 stroke-blue-500 group-hover:stroke-blue-600 transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                        <h2 class="ms-4 text-2xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            Consultorios Médicos
                        </h2>
                    </div>
                    <p class="mt-4 text-gray-600 dark:text-gray-300 leading-relaxed">
                        Administra los consultorios médicos y centros de salud. Configura capacidad, ubicación y disponibilidad de cada consultorio.
                    </p>
                    <div class="mt-6 inline-flex items-center font-semibold text-blue-600 dark:text-blue-400 group-hover:text-blue-700">
                        Ver Consultorios
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-2 size-5 fill-blue-500 group-hover:translate-x-1 transition-transform">
                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </Link>

            <Link :href="route('events.index')" class="group">
                <div class="p-6 bg-white dark:bg-gray-700 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-cyan-500">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="size-12 stroke-cyan-500 group-hover:stroke-cyan-600 transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <h2 class="ms-4 text-2xl font-bold text-gray-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                            Citas Médicas
                        </h2>
                    </div>
                    <p class="mt-4 text-gray-600 dark:text-gray-300 leading-relaxed">
                        Gestiona el agendamiento de citas médicas. Aprueba o deniega solicitudes, programa consultas presenciales o virtuales (telemedicina).
                    </p>
                    <div class="mt-6 inline-flex items-center font-semibold text-cyan-600 dark:text-cyan-400 group-hover:text-cyan-700">
                        Ver Citas Médicas
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-2 size-5 fill-cyan-500 group-hover:translate-x-1 transition-transform">
                            <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </Link>

            <div class="p-6 bg-gradient-to-br from-emerald-500 to-teal-600 dark:from-emerald-900 dark:to-teal-900 rounded-xl shadow-lg text-white">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="size-10 stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="ms-4 text-2xl font-bold">
                        Funcionalidades
                    </h2>
                </div>
                <ul class="space-y-3 text-white">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Gestión completa de consultorios médicos</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Agendamiento de citas presenciales y telemedicina</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Sistema de aprobación y denegación de citas</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>API REST para integración con otros sistemas</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Filtrado de citas por consultorio médico</span>
                    </li>
                </ul>
            </div>

            <div class="p-6 bg-gradient-to-br from-blue-600 to-indigo-700 dark:from-blue-900 dark:to-indigo-900 rounded-xl shadow-lg text-white">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="size-10 stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    <h2 class="ms-4 text-2xl font-bold">
                        Seguridad y Privacidad
                    </h2>
                </div>
                <p class="leading-relaxed text-blue-50">
                    Plataforma segura con autenticación robusta mediante Laravel Jetstream, Fortify y Sanctum. 
                    Protección de datos médicos sensibles con verificación de email, autenticación de dos factores 
                    y recuperación segura de contraseñas.
                </p>
                <div class="mt-4 pt-4 border-t border-blue-400">
                    <p class="text-sm text-blue-100">
                        ✓ Cumple con estándares de seguridad para datos de salud
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
