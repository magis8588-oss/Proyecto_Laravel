<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-50">
        <!-- Modern Header -->
        <header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 border-b border-blue-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4 h-14 sm:h-16">
                    <Link :href="route('home')" class="group flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors">
                        <div class="p-2 bg-gray-100 group-hover:bg-blue-50 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </div>
                        <span class="hidden sm:inline font-medium">Volver</span>
                    </Link>
                    <div class="flex-1">
                        <h1 class="text-lg md:text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                            Perfil del Especialista
                        </h1>
                        <p class="text-sm text-gray-500 hidden sm:block">Información detallada y disponibilidad</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <!-- Modern Doctor Profile Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 border border-gray-100">
                <div class="lg:flex">
                    <!-- Photo Section with Modern Design -->
                    <div class="lg:w-2/5 relative bg-gradient-to-br from-blue-500 via-blue-600 to-cyan-600 p-8 lg:p-10">
                        <div class="absolute inset-0 opacity-10 bg-white/5"></div>
                        <div class="relative text-center">
                            <div class="inline-block relative mb-4">
                                <div class="absolute inset-0 bg-white/20 rounded-full blur-2xl"></div>
                                <div class="relative bg-white/10 backdrop-blur-sm p-6 rounded-full border-4 border-white/30">
                                    <svg class="w-20 h-20 sm:w-24 sm:h-24 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="inline-flex items-center gap-2 bg-green-500 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-lg">
                                <span class="w-2.5 h-2.5 bg-white rounded-full animate-pulse"></span>
                                Disponible para Consultas
                            </div>
                        </div>
                    </div>

                    <!-- Info Section with Modern Layout -->
                    <div class="lg:w-3/5 p-6 lg:p-8">
                        <div class="mb-4">
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ doctor.name }}</h2>
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 text-blue-700 rounded-lg text-sm font-semibold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                                {{ doctor.specialty }}
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-gray-600 leading-relaxed text-sm">{{ doctor.bio }}</p>
                        </div>

                        <!-- Contact Cards -->
                        <div class="grid grid-cols-1 gap-3">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Email</p>
                                    <a :href="`mailto:${doctor.email}`" class="text-gray-900 hover:text-blue-600 text-sm font-medium truncate block">
                                        {{ doctor.email }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Teléfono</p>
                                    <a :href="`tel:${doctor.phone}`" class="text-gray-900 hover:text-green-600 font-medium">
                                        {{ doctor.phone }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                                <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Licencia Médica</p>
                                    <p class="text-gray-900 font-medium">{{ doctor.license_number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Availability Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Horarios Disponibles</h3>
                        <p class="text-gray-500 text-sm">Selecciona la fecha y hora de tu preferencia</p>
                    </div>
                </div>

                <div v-if="availability && availability.length > 0" class="space-y-6">
                    <!-- Group by date with modern cards -->
                    <div v-for="(dateGroup, date) in groupedAvailability" :key="date" class="bg-gradient-to-r from-gray-50 to-blue-50/30 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-1 h-10 bg-gradient-to-b from-blue-600 to-cyan-600 rounded-full"></div>
                            <h4 class="text-xl font-bold text-gray-800">
                                {{ formatDateFull(date) }}
                            </h4>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                            <button
                                v-for="slot in dateGroup"
                                :key="`${slot.date}-${slot.time}`"
                                @click="selectSlot(slot)"
                                :class="[
                                    'group relative px-3 py-3 rounded-lg border-2 transition-all duration-200 font-semibold text-sm',
                                    selectedSlot && selectedSlot.date === slot.date && selectedSlot.time === slot.time
                                        ? 'border-blue-600 bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg scale-105'
                                        : 'border-gray-200 bg-white hover:border-blue-400 hover:bg-blue-50 text-gray-700 hover:scale-105 hover:shadow-md'
                                ]"
                            >
                                <svg class="w-4 h-4 mx-auto mb-1" :class="selectedSlot && selectedSlot.date === slot.date && selectedSlot.time === slot.time ? 'text-white' : 'text-blue-600'" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                {{ slot.time }}
                            </button>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-16">
                    <div class="inline-flex p-6 bg-gray-100 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-700 mb-2">No hay horarios disponibles</h4>
                    <p class="text-gray-500">Por favor, vuelve a consultar más tarde</p>
                </div>

                <!-- Modern Selected Slot Confirmation -->
                <div v-if="selectedSlot" class="mt-6 relative overflow-hidden bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl shadow-2xl">
                    <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                    <div class="relative p-6">
                        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="flex-shrink-0 p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="text-white flex-1">
                                    <h4 class="text-2xl font-bold mb-3">¡Horario Seleccionado!</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-semibold text-lg">{{ formatDateFull(selectedSlot.date) }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-semibold text-lg">{{ selectedSlot.time }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 mt-3">
                                            <svg class="w-5 h-5 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-blue-100">Duración estimada: 30 minutos</span>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    @click="selectedSlot = null"
                                    class="flex-shrink-0 p-2 hover:bg-white/20 rounded-lg transition-colors duration-200"
                                >
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <Link
                                :href="route('appointments.booking-form', { doctor: doctor.slug, start: selectedSlot.dateTime })"
                                class="group flex-shrink-0 px-8 py-4 bg-white text-blue-600 font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all duration-200 hover:scale-105 flex items-center gap-2"
                            >
                                Continuar con la Reserva
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    doctor: {
        type: Object,
        required: true
    },
    availability: {
        type: Array,
        default: () => []
    }
});

const selectedSlot = ref(null);

// Group availability by date
const groupedAvailability = computed(() => {
    const grouped = {};
    
    props.availability.forEach(slot => {
        if (!grouped[slot.date]) {
            grouped[slot.date] = [];
        }
        grouped[slot.date].push(slot);
    });
    
    return grouped;
});

const selectSlot = (slot) => {
    selectedSlot.value = slot;
};

const formatDateFull = (dateString) => {
    const date = new Date(dateString);
    const days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    
    return `${days[date.getDay()]}, ${date.getDate()} de ${months[date.getMonth()]} de ${date.getFullYear()}`;
};
</script>
