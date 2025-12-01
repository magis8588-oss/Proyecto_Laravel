<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-50">
        <!-- Modern Header with Glass Effect -->
        <header class="sticky top-0 z-50 backdrop-blur-lg bg-white/90 border-b border-blue-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14 sm:h-16">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl blur opacity-20"></div>
                            <div class="relative bg-gradient-to-r from-blue-600 to-cyan-600 p-2 sm:p-2.5 rounded-xl">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                                Clínica Oftalmológica
                            </h1>
                            <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">Tu visión, nuestra prioridad</p>
                        </div>
                    </div>
                    <div v-if="canLogin" class="flex gap-2">
                        <Link v-if="!$page.props.auth.user" :href="route('login')" 
                            class="px-3 sm:px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">
                            <span class="hidden sm:inline">Iniciar Sesión</span>
                            <span class="sm:hidden">Login</span>
                        </Link>
                        <Link v-else :href="route('dashboard')" 
                            class="px-3 sm:px-4 py-2 text-sm bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:shadow-lg hover:scale-105 transform transition-all duration-200 font-medium">
                            <span class="hidden sm:inline">Panel Administrativo</span>
                            <span class="sm:hidden">Panel</span>
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section with Modern Design -->
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-cyan-600/5"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                <div class="text-center mb-8">
                    <div class="inline-block mb-3">
                        <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs sm:text-sm font-semibold">
                            🏥 Sistema de Citas en Línea
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                        Agenda tu Cita con<br/>
                        <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                            Nuestros Especialistas
                        </span>
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        Contamos con oftalmólogos certificados especializados en todas las áreas de la salud visual.
                        Reserva tu consulta de forma rápida y sencilla.
                    </p>
                </div>

                <!-- Modern Search/Filter Bar -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4">
                        <div class="flex flex-col lg:flex-row gap-3">
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input 
                                    v-model="searchQuery"
                                    type="text" 
                                    placeholder="Buscar por nombre o especialidad..."
                                    class="w-full pl-10 pr-3 py-3 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                >
                            </div>
                            <div class="lg:w-64 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                </div>
                                <select 
                                    v-model="specialtyFilter"
                                    class="w-full pl-10 pr-3 py-3 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white transition-all appearance-none cursor-pointer"
                                >
                                    <option value="">Todas las especialidades</option>
                                    <option v-for="specialty in specialties" :key="specialty" :value="specialty">
                                        {{ specialty }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Doctors Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            <!-- Modern Doctors Grid -->
            <div v-if="filteredDoctors.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <div 
                    v-for="doctor in filteredDoctors" 
                    :key="doctor.id"
                    class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200 hover:-translate-y-1"
                >
                    <!-- Modern Doctor Photo with Overlay -->
                    <div class="relative h-32 sm:h-40 bg-gradient-to-br from-blue-500 via-blue-600 to-cyan-600 overflow-hidden">
                        <div class="absolute inset-0 bg-black/10"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-white transform group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-16 h-16 sm:w-20 sm:h-20" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1">
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                Disponible
                            </span>
                        </div>
                    </div>

                    <!-- Doctor Info with Modern Spacing -->
                    <div class="p-4 sm:p-5">
                        <div class="mb-3">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ doctor.name }}
                            </h3>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs sm:text-sm font-semibold">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                                {{ doctor.specialty }}
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm mb-3 line-clamp-2 leading-relaxed">
                            {{ doctor.bio }}
                        </p>

                        <!-- Contact Info with Icons -->
                        <div class="space-y-2 mb-3 pb-3 border-b border-gray-100">
                            <div class="flex items-center gap-2 text-gray-600 text-xs sm:text-sm">
                                <div class="flex-shrink-0 w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <span class="truncate">{{ doctor.email }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600 text-xs sm:text-sm">
                                <div class="flex-shrink-0 w-7 h-7 bg-green-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <span>{{ doctor.phone }}</span>
                            </div>
                        </div>

                        <!-- Availability Preview with Modern Design -->
                        <div v-if="doctor.upcoming_availability && doctor.upcoming_availability.length > 0" class="mb-3">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Próximos Horarios:</p>
                            <div class="flex flex-wrap gap-1.5">
                                <span 
                                    v-for="(slot, index) in doctor.upcoming_availability.slice(0, 2)" 
                                    :key="index"
                                    class="inline-flex items-center gap-1 text-xs bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 px-2 py-1 rounded-md border border-green-200 font-medium"
                                >
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ formatDate(slot.date) }} • {{ slot.time }}
                                </span>
                            </div>
                        </div>

                        <!-- Modern CTA Button -->
                        <Link 
                            :href="route('doctors.show', doctor.slug)"
                            class="block w-full text-center bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold py-2.5 rounded-lg transition-all duration-200 shadow-md hover:shadow-xl transform hover:scale-105 text-sm"
                        >
                            <span class="flex items-center justify-center gap-2">
                                Ver Perfil y Agendar
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- No Results -->
            <div v-else class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No se encontraron médicos</h3>
                <p class="text-gray-500">Intenta ajustar los filtros de búsqueda</p>
            </div>
        </section>

        <!-- Modern Stats Section -->
        <section class="relative mt-6 sm:mt-8 mb-6 sm:mb-8 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-600"></div>
            <div class="absolute inset-0 opacity-10 bg-white/5"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center transform hover:scale-105 transition-transform duration-300">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg mb-2">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl font-bold text-white mb-1">{{ doctors.length }}+</div>
                        <div class="text-blue-100 font-medium text-xs sm:text-sm">Especialistas Certificados</div>
                    </div>
                    <div class="text-center transform hover:scale-105 transition-transform duration-300">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg mb-2">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl font-bold text-white mb-1">8</div>
                        <div class="text-blue-100 font-medium text-xs sm:text-sm">Especialidades Médicas</div>
                    </div>
                    <div class="text-center transform hover:scale-105 transition-transform duration-300">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg mb-2">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl font-bold text-white mb-1">24h</div>
                        <div class="text-blue-100 font-medium text-xs sm:text-sm">Confirmación de Citas</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modern Footer -->
        <footer class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-6 sm:py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-2">
                        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-lg">Clínica Oftalmológica</div>
                            <div class="text-gray-400 text-sm">Tu visión, nuestra prioridad</div>
                        </div>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-gray-400 text-sm">© 2025 Clínica Oftalmológica</p>
                        <p class="text-gray-500 text-xs mt-1">Sistema de Gestión de Citas Médicas</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    doctors: {
        type: Array,
        required: true
    },
    canLogin: {
        type: Boolean,
        default: false
    }
});

const searchQuery = ref('');
const specialtyFilter = ref('');

// Extract unique specialties
const specialties = computed(() => {
    return [...new Set(props.doctors.map(d => d.specialty))];
});

// Filtered doctors based on search and specialty
const filteredDoctors = computed(() => {
    let filtered = props.doctors.filter(doctor => doctor.is_active);

    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(doctor => 
            doctor.name.toLowerCase().includes(query) ||
            doctor.specialty.toLowerCase().includes(query)
        );
    }

    if (specialtyFilter.value) {
        filtered = filtered.filter(doctor => doctor.specialty === specialtyFilter.value);
    }

    return filtered;
});

// Format date helper
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const days = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    
    return `${days[date.getDay()]} ${date.getDate()} ${months[date.getMonth()]}`;
};
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
