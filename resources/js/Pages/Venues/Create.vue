<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    venue_name: '',
    venue_address: '',
    venue_max_capacity: '',
});

const submit = () => {
    form.post(route('venues.store'));
};
</script>

<template>
    <Head title="Create Venue"/>

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-indigo-500 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Crear Nuevo Venue</h2>
                </div>
                <Link :href="route('venues.index')"
                      class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                    ← Volver
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-indigo-500 to-blue-500 p-6">
                        <h3 class="text-2xl font-bold text-white">Información del Venue</h3>
                        <p class="text-indigo-100 mt-1">Complete todos los campos para crear un nuevo lugar</p>
                    </div>
                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="mb-4">
                                <InputLabel for="venue_name" value="Venue Name" class="dark:text-gray-300"/>
                                <TextInput
                                    id="venue_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.venue_name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.venue_name"/>
                            </div>

                            <div class="mb-4">
                                <InputLabel for="venue_address" value="Venue Address" class="dark:text-gray-300"/>
                                <TextInput
                                    id="venue_address"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.venue_address"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.venue_address"/>
                            </div>

                            <div class="mb-4">
                                <InputLabel for="venue_max_capacity" value="Maximum Capacity"
                                            class="dark:text-gray-300"/>
                                <TextInput
                                    id="venue_max_capacity"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.venue_max_capacity"
                                    required
                                    min="1"
                                />
                                <InputError class="mt-2" :message="form.errors.venue_max_capacity"/>
                            </div>

                            <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <button type="submit" 
                                    class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-lg hover:from-indigo-700 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Crear Venue
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>