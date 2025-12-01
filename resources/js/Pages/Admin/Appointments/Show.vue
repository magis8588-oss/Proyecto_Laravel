<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    appointment: Object
});

const showAcceptModal = ref(false);
const showRejectModal = ref(false);

const acceptForm = useForm({
    notes: ''
});

const rejectForm = useForm({
    notes: ''
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

const acceptAppointment = () => {
    acceptForm.post(`/admin/appointments/${props.appointment.slug}/accept`, {
        preserveScroll: true,
        onSuccess: () => {
            showAcceptModal.value = false;
            acceptForm.reset();
        },
        onError: () => {
            console.error('Error al confirmar cita');
        }
    });
};

const rejectAppointment = () => {
    if (!rejectForm.notes) {
        alert('Debes proporcionar un motivo de rechazo');
        return;
    }
    
    rejectForm.post(`/admin/appointments/${props.appointment.slug}/reject`, {
        preserveScroll: true,
        onSuccess: () => {
            showRejectModal.value = false;
            rejectForm.reset();
        },
        onError: () => {
            console.error('Error al rechazar cita');
        }
    });
};
</script>

<template>
    <AppLayout title="Detalles de la Cita">
        <!-- Botón Volver -->
        <div class="mb-6">
            <a 
                href="/admin/appointments"
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
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold mb-2">Detalles de la Cita</h1>
                    <p class="text-blue-100 text-lg">{{ appointment.patient_name }}</p>
                </div>
                <span 
                    :class="statusColors[appointment.status]"
                    class="px-6 py-3 text-lg font-semibold rounded-full border-2 shadow-lg"
                >
                    {{ statusLabels[appointment.status] }}
                </span>
            </div>
        </div>

        <!-- Grid de información -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
            <!-- Información del Paciente -->
            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                        {{ appointment.patient_name?.charAt(0).toUpperCase() }}
                    </div>
                    <h2 class="ml-4 text-xl font-bold text-gray-800">Información del Paciente</h2>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nombre Completo</label>
                        <p class="text-gray-900 font-medium mt-1">{{ appointment.patient_name }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Correo Electrónico</label>
                        <p class="text-gray-900 font-medium mt-1">{{ appointment.patient_email }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Teléfono</label>
                        <p class="text-gray-900 font-medium mt-1">{{ appointment.patient_phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Información del Médico -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                        {{ appointment.doctor?.name?.charAt(0).toUpperCase() }}
                    </div>
                    <h2 class="ml-4 text-xl font-bold text-gray-800">Información del Médico</h2>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nombre</label>
                        <p class="text-gray-900 font-medium mt-1">Dr. {{ appointment.doctor?.name || 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Especialidad</label>
                        <p class="text-gray-900 font-medium mt-1">{{ appointment.doctor?.specialty || 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Correo</label>
                        <p class="text-gray-900 font-medium mt-1">{{ appointment.doctor?.email || 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Información de la Cita -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="ml-4 text-xl font-bold text-gray-800">Detalles de la Cita</h2>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Fecha y Hora</label>
                        <p class="text-gray-900 font-medium mt-1">{{ formatDateTime(appointment.start_time) }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Estado</label>
                        <p class="mt-1">
                            <span 
                                :class="statusColors[appointment.status]"
                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full border"
                            >
                                {{ statusLabels[appointment.status] }}
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Fecha de Solicitud</label>
                        <p class="text-gray-900 font-medium mt-1">{{ formatDateTime(appointment.created_at) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Motivo de la Cita -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Motivo de la Consulta</h2>
            <p class="text-gray-700 leading-relaxed">{{ appointment.reason }}</p>
        </div>

        <!-- Notas Administrativas (si existen) -->
        <div v-if="appointment.admin_notes" class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-blue-900 mb-4">Notas Administrativas</h2>
            <p class="text-blue-800">{{ appointment.admin_notes }}</p>
        </div>

        <!-- Botones de acción (solo si está pendiente) -->
        <div v-if="appointment.status === 'pending'" class="flex gap-4 mb-6">
            <button 
                @click="showAcceptModal = true"
                class="flex-1 px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200 font-bold text-lg flex items-center justify-center"
            >
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Aceptar Cita
            </button>
            
            <button 
                @click="showRejectModal = true"
                class="flex-1 px-6 py-4 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200 font-bold text-lg flex items-center justify-center"
            >
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Rechazar Cita
            </button>
        </div>

        <!-- Modal Aceptar Cita -->
        <Teleport to="body">
            <div 
                v-if="showAcceptModal" 
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="showAcceptModal = false"
            >
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="ml-4 text-2xl font-bold text-gray-800">Confirmar Cita</h3>
                    </div>
                    
                    <p class="text-gray-600 mb-4">
                        ¿Estás seguro de que deseas aceptar esta cita? Se enviará un correo de confirmación al paciente.
                    </p>
                    
                    <form @submit.prevent="acceptAppointment">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Notas adicionales (opcional)
                            </label>
                            <textarea 
                                v-model="acceptForm.notes"
                                rows="3"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Instrucciones para el paciente..."
                            ></textarea>
                        </div>
                        
                        <div class="flex gap-3">
                            <button 
                                type="submit"
                                :disabled="acceptForm.processing"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold disabled:opacity-50"
                            >
                                {{ acceptForm.processing ? 'Procesando...' : 'Confirmar' }}
                            </button>
                            <button 
                                type="button"
                                @click="showAcceptModal = false"
                                class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg shadow-md hover:bg-gray-300 transition-all duration-200 font-bold"
                            >
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>

        <!-- Modal Rechazar Cita -->
        <Teleport to="body">
            <div 
                v-if="showRejectModal" 
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="showRejectModal = false"
            >
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <h3 class="ml-4 text-2xl font-bold text-gray-800">Rechazar Cita</h3>
                    </div>
                    
                    <p class="text-gray-600 mb-4">
                        Proporciona un motivo para el rechazo. Se enviará un correo al paciente con esta información.
                    </p>
                    
                    <form @submit.prevent="rejectAppointment">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Motivo del rechazo <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                v-model="rejectForm.notes"
                                rows="4"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                placeholder="Explica el motivo del rechazo..."
                            ></textarea>
                            <p v-if="rejectForm.errors.notes" class="text-red-500 text-sm mt-1">
                                {{ rejectForm.errors.notes }}
                            </p>
                        </div>
                        
                        <div class="flex gap-3">
                            <button 
                                type="submit"
                                :disabled="rejectForm.processing"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold disabled:opacity-50"
                            >
                                {{ rejectForm.processing ? 'Procesando...' : 'Rechazar' }}
                            </button>
                            <button 
                                type="button"
                                @click="showRejectModal = false"
                                class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg shadow-md hover:bg-gray-300 transition-all duration-200 font-bold"
                            >
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </AppLayout>
</template>
