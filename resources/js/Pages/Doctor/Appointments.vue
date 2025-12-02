<template>
    <AppLayout title="Mis Citas">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mis Citas
                </h2>
                <Link :href="route('doctor.dashboard')" class="text-indigo-600 hover:text-indigo-800">
                    ← Volver al panel
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select 
                                v-model="localFilters.status"
                                @change="applyFilters"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="all">Todos los estados</option>
                                <option value="pending">Pendiente</option>
                                <option value="confirmed">Confirmada</option>
                                <option value="completed">Completada</option>
                                <option value="rejected">Rechazada</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                            <input 
                                type="date"
                                v-model="localFilters.date"
                                @change="applyFilters"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paciente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha y Hora
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contacto
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="appointments.data.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    No se encontraron citas
                                </td>
                            </tr>
                            <tr v-for="appointment in appointments.data" :key="appointment.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ appointment.patient_name }}</div>
                                    <div v-if="appointment.reason" class="text-sm text-gray-500 italic">{{ appointment.reason }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ formatDate(appointment.start) }}</div>
                                    <div class="text-sm text-gray-500">{{ formatTime(appointment.start) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="statusClass(appointment.status)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ statusText(appointment.status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ appointment.patient_email }}</div>
                                    <div class="text-sm text-gray-500">{{ appointment.patient_phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button 
                                            v-if="appointment.status === 'pending'"
                                            @click="acceptAppointment(appointment)"
                                            class="text-green-600 hover:text-green-900"
                                        >
                                            Aceptar
                                        </button>
                                        <button 
                                            v-if="appointment.status === 'pending'"
                                            @click="rejectAppointment(appointment)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Rechazar
                                        </button>
                                        <button 
                                            v-if="appointment.status === 'confirmed'"
                                            @click="completeAppointment(appointment)"
                                            class="text-blue-600 hover:text-blue-900"
                                        >
                                            Completar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    
                    <div v-if="appointments.data.length > 0" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <Link 
                                v-if="appointments.prev_page_url" 
                                :href="appointments.prev_page_url"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Anterior
                            </Link>
                            <Link 
                                v-if="appointments.next_page_url" 
                                :href="appointments.next_page_url"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Siguiente
                            </Link>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Mostrando 
                                    <span class="font-medium">{{ appointments.from }}</span>
                                    a 
                                    <span class="font-medium">{{ appointments.to }}</span>
                                    de 
                                    <span class="font-medium">{{ appointments.total }}</span>
                                    resultados
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <Link 
                                        v-for="link in appointments.links" 
                                        :key="link.label"
                                        :href="link.url"
                                        :class="[
                                            link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                            'relative inline-flex items-center px-4 py-2 border text-sm font-medium'
                                        ]"
                                        v-html="link.label"
                                    />
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ConfirmDialog
            :show="showConfirmDialog"
            :title="dialogConfig.title"
            :message="dialogConfig.message"
            :type="dialogConfig.type"
            :confirmText="dialogConfig.confirmText"
            @confirm="dialogConfig.onConfirm"
            @cancel="showConfirmDialog = false"
        />
    </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmDialog from '@/Components/ConfirmDialog.vue';

const props = defineProps({
    appointments: Object,
    filters: Object,
    doctor: Object,
});

const showConfirmDialog = ref(false);
const dialogConfig = ref({
    title: '',
    message: '',
    type: 'info',
    confirmText: 'Aceptar',
    onConfirm: () => {}
});

const localFilters = reactive({
    status: props.filters.status || 'all',
    date: props.filters.date || '',
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('es-ES', { 
        weekday: 'short', 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
};

const formatTime = (dateString) => {
    return new Date(dateString).toLocaleTimeString('es-ES', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
};

const statusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        confirmed: 'bg-green-100 text-green-800',
        completed: 'bg-blue-100 text-blue-800',
        rejected: 'bg-red-100 text-red-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const statusText = (status) => {
    const texts = {
        pending: 'Pendiente',
        confirmed: 'Confirmada',
        completed: 'Completada',
        rejected: 'Rechazada',
    };
    return texts[status] || status;
};

const applyFilters = () => {
    router.get(route('doctor.appointments'), localFilters, {
        preserveState: true,
        preserveScroll: true,
    });
};

const acceptAppointment = (appointment) => {
    dialogConfig.value = {
        title: '¿Confirmar cita?',
        message: `¿Deseas confirmar la cita con ${appointment.patient_name}?`,
        type: 'success',
        confirmText: 'Confirmar',
        onConfirm: () => {
            router.post(route('doctor.appointments.accept', appointment.slug));
            showConfirmDialog.value = false;
        }
    };
    showConfirmDialog.value = true;
};

const rejectAppointment = (appointment) => {
    dialogConfig.value = {
        title: '¿Rechazar cita?',
        message: `¿Estás seguro de rechazar la cita con ${appointment.patient_name}?`,
        type: 'danger',
        confirmText: 'Rechazar',
        onConfirm: () => {
            router.post(route('doctor.appointments.reject', appointment.slug));
            showConfirmDialog.value = false;
        }
    };
    showConfirmDialog.value = true;
};

const completeAppointment = (appointment) => {
    dialogConfig.value = {
        title: '¿Completar cita?',
        message: `¿Marcar como completada la cita con ${appointment.patient_name}?`,
        type: 'info',
        confirmText: 'Completar',
        onConfirm: () => {
            router.post(route('doctor.appointments.complete', appointment.slug));
            showConfirmDialog.value = false;
        }
    };
    showConfirmDialog.value = true;
};
</script>
