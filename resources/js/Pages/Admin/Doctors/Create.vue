<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    specialties: Object
});

const form = useForm({
    name: '',
    license_number: '',
    specialty: '',
    bio: '',
    email: '',
    phone: '',
    is_active: true
});

const submit = () => {
    form.post('/admin/doctors');
};
</script>

<template>
    <AppLayout title="Nuevo Médico">
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
        <div class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white py-8 px-6 rounded-3xl shadow-2xl mb-8">
            <h1 class="text-4xl font-bold mb-2">Registrar Nuevo Médico</h1>
            <p class="text-blue-100 text-lg">Complete la información del médico</p>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Información Personal -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Información Personal</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre Completo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                v-model="form.name"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Juan Pérez García"
                            >
                            <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
                        </div>

                        <!-- Número de Licencia -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Número de Licencia Médica <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                v-model="form.license_number"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="123456"
                            >
                            <p v-if="form.errors.license_number" class="text-red-500 text-sm mt-1">{{ form.errors.license_number }}</p>
                        </div>

                        <!-- Especialidad -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Especialidad <span class="text-red-500">*</span>
                            </label>
                            <select 
                                v-model="form.specialty"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">Seleccione una especialidad</option>
                                <option 
                                    v-for="(label, value) in specialties" 
                                    :key="value"
                                    :value="value"
                                >
                                    {{ label }}
                                </option>
                            </select>
                            <p v-if="form.errors.specialty" class="text-red-500 text-sm mt-1">{{ form.errors.specialty }}</p>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Estado
                            </label>
                            <div class="flex items-center h-11">
                                <input 
                                    type="checkbox" 
                                    v-model="form.is_active"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-5 w-5"
                                >
                                <span class="ml-3 text-gray-700">Activo (acepta nuevas citas)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Información de Contacto</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Correo Electrónico <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                v-model="form.email"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="doctor@ejemplo.com"
                            >
                            <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                v-model="form.phone"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="555-1234"
                            >
                            <p v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Biografía -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Información Adicional</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Biografía / Experiencia
                        </label>
                        <textarea 
                            v-model="form.bio"
                            rows="5"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Describe la experiencia y credenciales del médico..."
                        ></textarea>
                        <p class="text-gray-500 text-sm mt-1">Esta información será visible para los pacientes</p>
                        <p v-if="form.errors.bio" class="text-red-500 text-sm mt-1">{{ form.errors.bio }}</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex gap-4 pt-6">
                    <button 
                        type="submit"
                        :disabled="form.processing"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200 font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{ form.processing ? 'Guardando...' : 'Guardar Médico' }}
                    </button>
                    <a 
                        href="/admin/doctors"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl shadow-lg hover:bg-gray-300 transition-all duration-200 font-bold text-lg text-center"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
