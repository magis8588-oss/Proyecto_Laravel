<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    doctor: Object
});

const formatTime = (time) => {
    const [hours, minutes] = time.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour > 12 ? hour - 12 : hour === 0 ? 12 : hour;
    return `${displayHour}:${minutes} ${ampm}`;
};

const getDayName = (dayNumber) => {
    const days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    return days[dayNumber];
};

const formatDateTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>
    <AppLayout :title="`Dr. ${doctor.name}`">
        <!-- Botón Volver -->
        <div class="mb-6">
            <a 
                href="/admin/doctors"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a la lista
            </a>
        </div>

        <!-- Header con gradiente -->
        <div class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white py-6 px-5 rounded-2xl shadow-xl mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-20 w-20 bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center text-3xl font-bold">
                        {{ doctor.name?.charAt(0).toUpperCase() }}
                    </div>
                    <div class="ml-6">
                        <h1 class="text-4xl font-bold mb-1">Dr. {{ doctor.name }}</h1>
                        <p class="text-blue-100 text-lg">{{ doctor.specialty }}</p>
                        <p class="text-blue-200 text-sm">Lic. {{ doctor.license_number }}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <span 
                        v-if="doctor.is_active"
                        class="px-6 py-2 bg-green-500 text-white text-sm font-bold rounded-full text-center shadow-lg"
                    >
                        ✓ Activo
                    </span>
                    <span 
                        v-else
                        class="px-6 py-2 bg-red-500 text-white text-sm font-bold rounded-full text-center shadow-lg"
                    >
                        ✗ Inactivo
                    </span>
                    <Link
                        :href="`/admin/doctors/${doctor.slug}/edit`"
                        class="px-6 py-2 bg-white text-blue-600 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold text-center"
                    >
                        Editar
                    </Link>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna izquierda: Información del médico -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Información de Contacto -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Información de Contacto</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <a :href="`mailto:${doctor.email}`" class="text-blue-600 hover:underline font-medium">
                                    {{ doctor.email }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Teléfono</p>
                                <a :href="`tel:${doctor.phone}`" class="text-blue-600 hover:underline font-medium">
                                    {{ doctor.phone }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biografía -->
                <div v-if="doctor.bio" class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Biografía</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ doctor.bio }}</p>
                </div>
            </div>

            <!-- Columna derecha: Horarios y Citas -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Horarios de Disponibilidad -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Horarios de Disponibilidad</h2>
                        <Link
                            :href="`/admin/doctors/${doctor.slug}/availabilities`"
                            class="px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-medium text-sm"
                        >
                            Gestionar Horarios
                        </Link>
                    </div>

                    <div v-if="doctor.availabilities && doctor.availabilities.length > 0" class="space-y-3">
                        <div 
                            v-for="availability in doctor.availabilities" 
                            :key="availability.id"
                            class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200"
                        >
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-800">{{ getDayName(availability.day_of_week) }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ formatTime(availability.start_time) }} - {{ formatTime(availability.end_time) }}
                                    </p>
                                </div>
                            </div>
                            <span 
                                v-if="availability.is_active"
                                class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full border border-green-300"
                            >
                                Activo
                            </span>
                            <span 
                                v-else
                                class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-bold rounded-full border border-gray-300"
                            >
                                Inactivo
                            </span>
                        </div>
                    </div>
                    <div v-else class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500">No hay horarios configurados</p>
                        <Link
                            :href="`/admin/doctors/${doctor.slug}/availabilities`"
                            class="inline-block mt-3 text-blue-600 hover:underline font-medium"
                        >
                            Agregar horarios
                        </Link>
                    </div>
                </div>

                <!-- Citas Recientes -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Citas Recientes</h2>
                        <Link
                            href="/admin/appointments"
                            class="text-blue-600 hover:underline font-medium text-sm"
                        >
                            Ver todas
                        </Link>
                    </div>

                    <div v-if="doctor.appointments && doctor.appointments.length > 0" class="space-y-3">
                        <div 
                            v-for="appointment in doctor.appointments.slice(0, 5)" 
                            :key="appointment.id"
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors"
                        >
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    {{ appointment.patient_name?.charAt(0).toUpperCase() }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ appointment.patient_name }}</p>
                                    <p class="text-sm text-gray-600">{{ formatDateTime(appointment.start_time) }}</p>
                                </div>
                            </div>
                            <span 
                                :class="{
                                    'bg-yellow-100 text-yellow-800 border-yellow-300': appointment.status === 'pending',
                                    'bg-green-100 text-green-800 border-green-300': appointment.status === 'confirmed',
                                    'bg-blue-100 text-blue-800 border-blue-300': appointment.status === 'completed',
                                    'bg-red-100 text-red-800 border-red-300': appointment.status === 'rejected',
                                }"
                                class="px-3 py-1 text-xs font-bold rounded-full border"
                            >
                                {{ appointment.status === 'pending' ? 'Pendiente' : 
                                   appointment.status === 'confirmed' ? 'Confirmada' :
                                   appointment.status === 'completed' ? 'Completada' : 'Rechazada' }}
                            </span>
                        </div>
                    </div>
                    <div v-else class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500">No hay citas registradas</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
