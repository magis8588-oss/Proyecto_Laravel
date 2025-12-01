<template>
    <AppLayout title="Dashboard Administrativo">
        <!-- Modern Header -->
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                            Dashboard Administrativo
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">Gestión de citas médicas</p>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Filter Section -->
                <div class="mb-6">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                <label for="doctor_filter" class="text-sm font-bold text-gray-700">
                                    Filtrar por Médico:
                                </label>
                            </div>
                            <select
                                id="doctor_filter"
                                v-model="selectedDoctor"
                                @change="applyFilter"
                                class="flex-1 sm:flex-none px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            >
                                <option value="all">Todos los Médicos</option>
                                <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
                                    {{ doctor.name }} - {{ doctor.specialty }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Pending -->
                    <div class="group bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl shadow-md hover:shadow-xl transition-all duration-200 hover:scale-105 p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-xs font-semibold uppercase tracking-wide mb-1">Pendientes</p>
                                <p class="text-2xl sm:text-3xl font-bold">{{ stats.pending }}</p>
                            </div>
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Cancelled -->
                    <div class="group bg-gradient-to-br from-red-500 to-pink-500 rounded-xl shadow-md hover:shadow-xl transition-all duration-200 hover:scale-105 p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-xs font-semibold uppercase tracking-wide mb-1">Canceladas</p>
                                <p class="text-2xl sm:text-3xl font-bold">{{ stats.cancelled }}</p>
                            </div>
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div class="group bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl shadow-md hover:shadow-xl transition-all duration-200 hover:scale-105 p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide mb-1">Completadas</p>
                                <p class="text-2xl sm:text-3xl font-bold">{{ stats.completed }}</p>
                            </div>
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Appointments -->
                    <div class="group bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-200 hover:scale-105 p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-semibold uppercase tracking-wide mb-2">Hoy</p>
                                <p class="text-4xl font-bold">{{ stats.total_today }}</p>
                            </div>
                            <div class="p-4 bg-white/20 backdrop-blur-sm rounded-xl">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <Link :href="route('admin.appointments.index')" class="group">
                        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4 hover:shadow-lg transition-all duration-200 hover:scale-105">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">Gestionar Citas</h3>
                                    <p class="text-gray-500 text-xs">Ver todas las citas</p>
                                </div>
                            </div>
                        </div>
                    </Link>

                    <Link :href="route('calendar.admin')" class="group">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl transition-all duration-200 hover:scale-105">
                            <div class="flex items-center gap-4">
                                <div class="p-4 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors duration-200">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-200">Calendario</h3>
                                    <p class="text-gray-500 text-sm">Vista semanal</p>
                                </div>
                            </div>
                        </div>
                    </Link>

                    <Link :href="route('admin.doctors.index')" class="group">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl transition-all duration-200 hover:scale-105">
                            <div class="flex items-center gap-4">
                                <div class="p-4 bg-purple-100 rounded-xl group-hover:bg-purple-200 transition-colors duration-200">
                                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">Médicos</h3>
                                    <p class="text-gray-500 text-sm">Administrar doctores</p>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Pending Appointments -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="p-2.5 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-bold text-white">Citas Pendientes</h3>
                                    <p class="text-yellow-100 text-xs">Requieren aprobación</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4">
                            <div v-if="pendingAppointments.length > 0" class="space-y-3">
                                <div
                                    v-for="appointment in pendingAppointments"
                                    :key="appointment.id"
                                    class="group bg-gradient-to-r from-gray-50 to-yellow-50/30 rounded-xl p-4 border border-gray-200 hover:shadow-md transition-all duration-200">
                                >
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900">{{ appointment.patient_name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ appointment.doctor.name }}</p>
                                        </div>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-lg">
                                            PENDIENTE
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-medium">{{ formatDateTime(appointment.start_time) }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            <span>{{ appointment.patient_email }}</span>
                                        </div>
                                    </div>
                                    
                                    <Link
                                        :href="route('admin.appointments.show', appointment.id)"
                                        class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl transition-all duration-200 hover:scale-105"
                                    >
                                        Revisar Cita
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>

                            <div v-else class="text-center py-12">
                                <div class="inline-flex p-6 bg-gray-100 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-xl text-gray-500 font-medium">No hay citas pendientes</p>
                                <p class="text-gray-400 mt-2">Todas las citas han sido procesadas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Confirmed Appointments -->
                    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">Próximas Confirmadas</h3>
                                    <p class="text-green-100 text-sm">Siguiente semana</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div v-if="upcomingAppointments.length > 0" class="space-y-4">
                                <div
                                    v-for="appointment in upcomingAppointments"
                                    :key="appointment.id"
                                    class="group bg-gradient-to-r from-gray-50 to-green-50/30 rounded-2xl p-5 border border-gray-200 hover:shadow-lg transition-all duration-200"
                                >
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900">{{ appointment.patient_name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ appointment.doctor.name }}</p>
                                        </div>
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-lg">
                                            CONFIRMADA
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-medium">{{ formatDateTime(appointment.start_time) }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                            </svg>
                                            <span>{{ appointment.patient_phone }}</span>
                                        </div>
                                    </div>
                                    
                                    <Link
                                        :href="route('admin.appointments.show', appointment.id)"
                                        class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl transition-all duration-200 hover:scale-105"
                                    >
                                        Ver Detalles
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>

                            <div v-else class="text-center py-12">
                                <div class="inline-flex p-6 bg-gray-100 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-xl text-gray-500 font-medium">No hay citas próximas</p>
                                <p class="text-gray-400 mt-2">No hay citas confirmadas para la próxima semana</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    pendingAppointments: Array,
    upcomingAppointments: Array,
    doctors: Array,
    stats: Object,
    filters: Object,
    message: String,
});

const selectedDoctor = ref(props.filters.doctor_id || 'all');

const applyFilter = () => {
    router.get(route('home.admin'), {
        doctor_id: selectedDoctor.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const formatDateTime = (dateTimeString) => {
    const date = new Date(dateTimeString);
    const days = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    
    return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} - ${hours}:${minutes}`;
};
</script>
