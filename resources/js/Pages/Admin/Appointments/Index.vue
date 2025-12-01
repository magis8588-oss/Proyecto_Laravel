<script setup>
import { ref, computed } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    appointments: Object,
    doctors: Array,
    filters: Object
});

const statusColors = {
    pending: 'bg-yellow-100 text-yellow-800 border-yellow-300',
    confirmed: 'bg-green-100 text-green-800 border-green-300',
    completed: 'bg-blue-100 text-blue-800 border-blue-300',
    rejected: 'bg-red-100 text-red-800 border-red-300',
    cancelled: 'bg-gray-100 text-gray-800 border-gray-300'
};

const statusLabels = {
    pending: 'Pendiente',
    confirmed: 'Confirmada',
    completed: 'Completada',
    rejected: 'Rechazada',
    cancelled: 'Cancelada'
};

const selectedStatus = ref(props.filters.status || '');
const selectedDoctor = ref(props.filters.doctor || '');
const startDate = ref(props.filters.start_date || '');
const endDate = ref(props.filters.end_date || '');

const applyFilters = () => {
    router.get('/admin/appointments', {
        status: selectedStatus.value,
        doctor: selectedDoctor.value,
        start_date: startDate.value,
        end_date: endDate.value
    }, {
        preserveState: true,
        preserveScroll: true
    });
};

const clearFilters = () => {
    selectedStatus.value = '';
    selectedDoctor.value = '';
    startDate.value = '';
    endDate.value = '';
    router.get('/admin/appointments');
};

const formatDateTime = (dateString) => {
    const date = new Date(dateString);
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleDateString('es-ES', options);
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
    };
    return date.toLocaleDateString('es-ES', options);
};

const formatTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleTimeString('es-ES', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
};
</script>

<template>
    <AppLayout title="Gestión de Citas">
        <!-- Header con gradiente -->
        <div class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white py-6 px-5 rounded-2xl shadow-xl mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold mb-2">Gestión de Citas</h1>
            <p class="text-blue-100 text-lg">Administra todas las citas médicas del sistema</p>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-lg p-4 mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Filtros</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Filtro por Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Estado
                    </label>
                    <select 
                        v-model="selectedStatus"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Todos</option>
                        <option value="pending">Pendiente</option>
                        <option value="confirmed">Confirmada</option>
                        <option value="completed">Completada</option>
                        <option value="rejected">Rechazada</option>
                        <option value="cancelled">Cancelada</option>
                    </select>
                </div>

                <!-- Filtro por Médico -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Médico
                    </label>
                    <select 
                        v-model="selectedDoctor"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Todos</option>
                        <option 
                            v-for="doctor in doctors" 
                            :key="doctor.id" 
                            :value="doctor.id"
                        >
                            Dr. {{ doctor.user?.name || 'N/A' }}
                        </option>
                    </select>
                </div>

                <!-- Filtro por Fecha Inicio -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Desde
                    </label>
                    <input 
                        type="date" 
                        v-model="startDate"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>

                <!-- Filtro por Fecha Fin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hasta
                    </label>
                    <input 
                        type="date" 
                        v-model="endDate"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
            </div>

            <!-- Botones de filtro -->
            <div class="flex gap-3 mt-4">
                <button 
                    @click="applyFilters"
                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-medium"
                >
                    Aplicar Filtros
                </button>
                <button 
                    @click="clearFilters"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-md hover:bg-gray-300 transition-all duration-200 font-medium"
                >
                    Limpiar Filtros
                </button>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 mb-4">
            <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl shadow-md p-3 text-white">
                <div class="text-2xl sm:text-3xl font-bold">{{ appointments.data.filter(a => a.status === 'pending').length }}</div>
                <div class="text-yellow-100 text-xs mt-1">Pendientes</div>
            </div>
            <div class="bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl shadow-md p-3 text-white">
                <div class="text-2xl sm:text-3xl font-bold">{{ appointments.data.filter(a => a.status === 'confirmed').length }}</div>
                <div class="text-green-100 text-xs mt-1">Confirmadas</div>
            </div>
            <div class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl shadow-md p-3 text-white">
                <div class="text-2xl sm:text-3xl font-bold">{{ appointments.data.filter(a => a.status === 'completed').length }}</div>
                <div class="text-blue-100 text-xs mt-1">Completadas</div>
            </div>
            <div class="bg-gradient-to-br from-red-400 to-pink-500 rounded-xl shadow-md p-3 text-white">
                <div class="text-2xl sm:text-3xl font-bold">{{ appointments.data.filter(a => a.status === 'rejected').length }}</div>
                <div class="text-red-100 text-xs mt-1">Rechazadas</div>
            </div>
            <div class="bg-gradient-to-br from-purple-400 to-indigo-500 rounded-2xl shadow-lg p-4 text-white">
                <div class="text-3xl font-bold">{{ appointments.total }}</div>
                <div class="text-purple-100 text-sm mt-1">Total</div>
            </div>
        </div>

        <!-- Lista de citas -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Si no hay citas -->
            <div v-if="appointments.data.length === 0" class="p-8 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-600 text-lg font-medium">No se encontraron citas</p>
                <p class="text-gray-500 text-sm mt-2">Intenta ajustar los filtros</p>
            </div>

            <!-- Tabla de citas -->
            <div v-else class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Paciente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Médico
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Fecha y Hora
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Motivo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr 
                            v-for="appointment in appointments.data" 
                            :key="appointment.id"
                            class="hover:bg-blue-50 transition-colors duration-150"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ appointment.patient_name?.charAt(0).toUpperCase() }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ appointment.patient_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ appointment.patient_email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    Dr. {{ appointment.doctor?.name || 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ appointment.doctor?.specialty || 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ formatDate(appointment.start_time) }}
                                </div>
                                <div class="text-sm font-medium text-blue-600">
                                    {{ formatTime(appointment.start_time) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                    {{ appointment.reason }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span 
                                    :class="statusColors[appointment.status]"
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border"
                                >
                                    {{ statusLabels[appointment.status] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link 
                                    :href="`/admin/appointments/${appointment.slug}`"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-medium"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver Detalles
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div v-if="appointments.links && appointments.links.length > 3" class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando 
                        <span class="font-medium">{{ appointments.from }}</span>
                        a
                        <span class="font-medium">{{ appointments.to }}</span>
                        de
                        <span class="font-medium">{{ appointments.total }}</span>
                        resultados
                    </div>
                    <div class="flex gap-2">
                        <Link
                            v-for="(link, index) in appointments.links"
                            :key="index"
                            :href="link.url"
                            v-html="link.label"
                            :class="{
                                'bg-blue-600 text-white': link.active,
                                'bg-white text-gray-700 hover:bg-gray-100': !link.active,
                                'cursor-not-allowed opacity-50': !link.url
                            }"
                            class="px-3 py-2 rounded-lg border border-gray-300 text-sm font-medium transition-colors duration-200"
                            :disabled="!link.url"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
