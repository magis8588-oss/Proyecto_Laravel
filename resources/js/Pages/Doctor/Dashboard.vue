<template>
    <AppLayout title="Dashboard Doctor">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">Mi Panel - Dr/a {{ doctor?.name || 'Doctor' }}</h2>
                    <p class="text-sm text-gray-600 mt-1">Gestiona tus citas y agenda</p>
                </div>
                <div class="text-sm text-gray-500">
                    {{ new Date().toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div v-if="$page.props.flash?.success" class="mb-6">
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-r-lg shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ $page.props.flash.success }}</span>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-yellow-600 uppercase tracking-wide">Pendientes</span>
                        </div>
                        <div class="text-3xl font-bold text-yellow-700">{{ stats.pending }}</div>
                        <p class="text-xs text-yellow-600 mt-1">Por confirmar</p>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-green-600 uppercase tracking-wide">Confirmadas</span>
                        </div>
                        <div class="text-3xl font-bold text-green-700">{{ stats.confirmed }}</div>
                        <p class="text-xs text-green-600 mt-1">Próximas</p>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Completadas</span>
                        </div>
                        <div class="text-3xl font-bold text-blue-700">{{ stats.completed }}</div>
                        <p class="text-xs text-blue-600 mt-1">Finalizadas</p>
                    </div>

                    <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-red-600 uppercase tracking-wide">Rechazadas</span>
                        </div>
                        <div class="text-3xl font-bold text-red-700">{{ stats.rejected }}</div>
                        <p class="text-xs text-red-600 mt-1">Canceladas</p>
                    </div>
                </div>

                
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-7 h-7 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Próximas Citas</h3>
                                    <p class="text-blue-100 text-sm">Citas pendientes y confirmadas</p>
                                </div>
                            </div>
                            <Link :href="route('doctor.appointments')" class="px-4 py-2 bg-white text-blue-600 rounded-lg font-semibold text-sm hover:bg-blue-50 transition-colors">
                                Ver todas
                            </Link>
                        </div>
                    </div>

                    <div v-if="upcomingAppointments.length === 0" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg">No tienes citas próximas</p>
                        <p class="text-gray-400 text-sm mt-1">Las nuevas citas aparecerán aquí</p>
                    </div>

                    <div v-else class="divide-y divide-gray-100">
                        <div v-for="appointment in upcomingAppointments" :key="appointment.id" 
                             class="px-6 py-5 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span :class="{
                                            'bg-yellow-100 text-yellow-700': appointment.status === 'pending',
                                            'bg-green-100 text-green-700': appointment.status === 'confirmed'
                                        }" class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide">
                                            {{ appointment.status === 'pending' ? 'Pendiente' : 'Confirmada' }}
                                        </span>
                                        <span class="text-sm font-semibold text-gray-700">{{ formatDate(appointment.start) }}</span>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-800 mb-1">{{ appointment.patient_name }}</h4>
                                    <div class="flex items-center text-sm text-gray-600 space-x-4">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ appointment.patient_email }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ appointment.patient_phone }}
                                        </div>
                                    </div>
                                    <p v-if="appointment.reason" class="text-sm text-gray-600 mt-2 italic">{{ appointment.reason }}</p>
                                </div>

                                <div v-if="appointment.status === 'pending'" class="flex space-x-3 ml-6">
                                    <button @click="acceptAppointment(appointment)" 
                                            class="px-5 py-2.5 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-all shadow-sm hover:shadow-md flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Aceptar
                                    </button>
                                    <button @click="rejectAppointment(appointment)" 
                                            class="px-5 py-2.5 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-all shadow-sm hover:shadow-md flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Rechazar
                                    </button>
                                </div>
                                <div v-else class="ml-6">
                                    <button @click="completeAppointment(appointment)" 
                                            class="px-5 py-2.5 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-all shadow-sm hover:shadow-md flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Completar
                                    </button>
                                </div>
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
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmDialog from '@/Components/ConfirmDialog.vue';

defineProps({
    stats: Object,
    upcomingAppointments: Array,
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

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString('es-ES', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
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
