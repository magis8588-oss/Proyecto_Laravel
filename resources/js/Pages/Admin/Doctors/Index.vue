<script setup>
import { router, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    doctors: Array,
    message: String
});

const deleteDoctor = (doctor) => {
    if (confirm(`¿Estás seguro de que deseas eliminar al Dr. ${doctor.name}?`)) {
        router.delete(`/admin/doctors/${doctor.slug}`);
    }
};

const toggleActive = (doctor) => {
    router.put(`/admin/doctors/${doctor.slug}`, {
        ...doctor,
        is_active: !doctor.is_active
    }, {
        preserveScroll: true
    });
};
</script>

<template>
    <AppLayout title="Gestión de Médicos">
        <!-- Header con gradiente -->
        <div class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white py-6 px-5 rounded-2xl shadow-xl mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold mb-2">Gestión de Doctores</h1>
                    <p class="text-blue-100 text-lg">Administra el personal médico de la clínica</p>
                </div>
                <Link
                    href="/admin/doctors/create"
                    class="px-6 py-3 bg-white text-blue-600 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200 font-bold flex items-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Médico
                </Link>
            </div>
        </div>

        <!-- Mensaje de éxito -->
        <div v-if="message" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
            {{ message }}
        </div>

        <!-- Grid de médicos -->
        <div v-if="doctors.length === 0" class="bg-white rounded-2xl shadow-lg p-8 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <p class="text-gray-600 text-lg font-medium">No hay médicos registrados</p>
            <p class="text-gray-500 text-sm mt-2">Comienza agregando un nuevo médico</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div 
                v-for="doctor in doctors" 
                :key="doctor.id"
                class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1"
            >
                <!-- Header del card -->
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-6 text-white relative">
                    <div class="absolute top-4 right-4">
                        <span 
                            v-if="doctor.is_active"
                            class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full"
                        >
                            Activo
                        </span>
                        <span 
                            v-else
                            class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full"
                        >
                            Inactivo
                        </span>
                    </div>
                    <div class="flex items-center">
                        <div class="h-16 w-16 bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center text-2xl font-bold">
                            {{ doctor.name?.charAt(0).toUpperCase() }}
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold">Dr. {{ doctor.name }}</h3>
                            <p class="text-blue-100 text-sm">Lic. {{ doctor.license_number }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contenido del card -->
                <div class="p-6">
                    <div class="space-y-3 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Especialidad</p>
                                <p class="text-gray-900 font-medium">{{ doctor.specialty }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-gray-900 font-medium break-all">{{ doctor.email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Teléfono</p>
                                <p class="text-gray-900 font-medium">{{ doctor.phone }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex gap-2">
                        <Link
                            :href="`/admin/doctors/${doctor.slug}`"
                            class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-medium text-center text-sm"
                        >
                            Ver Detalles
                        </Link>
                        <Link
                            :href="`/admin/doctors/${doctor.slug}/edit`"
                            class="flex-1 px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-medium text-center text-sm"
                        >
                            Editar
                        </Link>
                        <button
                            @click="deleteDoctor(doctor)"
                            class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-medium text-sm"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
