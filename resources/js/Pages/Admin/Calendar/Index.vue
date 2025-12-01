<template>
    <AppLayout title="Calendario Semanal">
        <!-- Modern Header -->
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                            Calendario Semanal
                        </h2>
                        <p class="text-gray-600 text-xs mt-1">Vista de citas y disponibilidad</p>
                    </div>
                </div>
                
                <Link
                    :href="route('home.admin')"
                    class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl transition-all duration-200 hover:scale-105 shadow-lg"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Dashboard
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Doctor Selector -->
                <div class="mb-6">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                <label for="doctor_selector" class="text-sm font-bold text-gray-700">
                                    Seleccionar Médico:
                                </label>
                            </div>
                            <select
                                id="doctor_selector"
                                v-model="selectedDoctorSlug"
                                @change="changeDoctor"
                                class="flex-1 sm:flex-none px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                            >
                                <option value="">Selecciona un médico</option>
                                <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.slug">
                                    {{ doctor.name }} - {{ doctor.specialty }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Calendar View -->
                <div v-if="selectedDoctor" class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    
                    <!-- Doctor Info Header -->
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-6">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl sm:text-3xl font-bold text-white">{{ selectedDoctor.name }}</h3>
                                <p class="text-green-100 text-sm sm:text-base mt-1">{{ selectedDoctor.specialty }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Availability Info -->
                    <div v-if="selectedDoctor.availabilities && selectedDoctor.availabilities.length > 0" class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <h4 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            Horario de Atención
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <div
                                v-for="avail in selectedDoctor.availabilities"
                                :key="avail.day_of_week"
                                class="bg-white rounded-xl px-4 py-3 border border-green-200 shadow-sm"
                            >
                                <p class="font-bold text-gray-900">{{ avail.day_name }}</p>
                                <p class="text-sm text-green-600 font-medium">{{ avail.start_time }} - {{ avail.end_time }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Appointments List -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                                Citas Programadas (Próximos 30 días)
                            </h4>
                            <span class="px-4 py-2 bg-green-100 text-green-700 font-bold rounded-lg">
                                {{ appointments.length }} citas
                            </span>
                        </div>

                        <div v-if="appointments.length > 0" class="space-y-3">
                            <div
                                v-for="appointment in groupedAppointments"
                                :key="appointment.date"
                                class="bg-gradient-to-r from-gray-50 to-green-50/30 rounded-xl p-4 border border-gray-200">
                            >
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-1 h-10 bg-gradient-to-b from-green-600 to-emerald-600 rounded-full"></div>
                                    <h5 class="text-lg font-bold text-gray-900">{{ appointment.date }}</h5>
                                </div>

                                <div class="space-y-3">
                                    <div
                                        v-for="appt in appointment.appointments"
                                        :key="appt.id"
                                        class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md transition-all duration-200"
                                    >
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <span class="text-lg font-bold text-gray-900">{{ formatTime(appt.start) }}</span>
                                                    <span
                                                        :class="[
                                                            'px-3 py-1 text-xs font-bold rounded-lg',
                                                            appt.status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                                            appt.status === 'confirmed' ? 'bg-green-100 text-green-700' :
                                                            appt.status === 'completed' ? 'bg-blue-100 text-blue-700' :
                                                            'bg-gray-100 text-gray-700'
                                                        ]"
                                                    >
                                                        {{ appt.status_label }}
                                                    </span>
                                                </div>
                                                <p class="font-semibold text-gray-900">{{ appt.patient_name }}</p>
                                                <div class="mt-2 space-y-1">
                                                    <p class="text-sm text-gray-600 flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                        </svg>
                                                        {{ appt.patient_email }}
                                                    </p>
                                                    <p class="text-sm text-gray-600 flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                        </svg>
                                                        {{ appt.patient_phone }}
                                                    </p>
                                                </div>
                                                <p v-if="appt.reason" class="text-sm text-gray-600 mt-2 italic">
                                                    "{{ appt.reason }}"
                                                </p>
                                            </div>
                                            <Link
                                                :href="route('admin.appointments.show', appt.id)"
                                                class="flex-shrink-0 p-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl transition-all duration-200 hover:scale-110"
                                            >
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-16">
                            <div class="inline-flex p-8 bg-gray-100 rounded-full mb-4">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-2xl text-gray-500 font-bold">No hay citas programadas</p>
                            <p class="text-gray-400 mt-2">Este médico no tiene citas en los próximos 30 días</p>
                        </div>
                    </div>
                </div>

                <!-- No Doctor Selected -->
                <div v-else class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-16">
                    <div class="text-center">
                        <div class="inline-flex p-8 bg-gradient-to-r from-green-100 to-emerald-100 rounded-full mb-6">
                            <svg class="w-20 h-20 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-3">Selecciona un Médico</h3>
                        <p class="text-gray-500 text-lg">Elige un médico del menú superior para ver su calendario de citas</p>
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
    doctors: Array,
    selectedDoctor: Object,
    appointments: Array,
});

const selectedDoctorSlug = ref(props.selectedDoctor?.slug || '');

const changeDoctor = () => {
    if (selectedDoctorSlug.value) {
        router.get(route('calendar.admin'), {
            doctor: selectedDoctorSlug.value,
        });
    }
};

// Group appointments by date
const groupedAppointments = computed(() => {
    const groups = {};
    
    props.appointments.forEach(appointment => {
        const date = new Date(appointment.start);
        const dateKey = date.toLocaleDateString('es-ES', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        if (!groups[dateKey]) {
            groups[dateKey] = {
                date: dateKey,
                appointments: []
            };
        }
        
        groups[dateKey].appointments.push(appointment);
    });
    
    return Object.values(groups).sort((a, b) => {
        return new Date(a.appointments[0].start) - new Date(b.appointments[0].start);
    });
});

const formatTime = (isoString) => {
    const date = new Date(isoString);
    return date.toLocaleTimeString('es-ES', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
};
</script>
