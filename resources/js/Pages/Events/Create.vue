<script setup>
import { onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    venues: Array,
    selectedVenue: [String, Number]
});

const form = useForm({
    event_name: '',
    event_date: '',
    event_is_virtual: false,
    event_speaker_name: '',
    fk_venue_event: props.selectedVenue || '',
});

const submit = () => {
    form.post(route('events.store'));
};

onMounted(() => {
    // Configurar fecha y hora actual como valor predeterminado
    if (!form.event_date) {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        form.event_date = now.toISOString().slice(0, 16);
    }
});
</script>

<template>
    <Head title="Create Event"/>

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-purple-500 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Crear Nuevo Evento</h2>
                </div>
                <Link :href="route('events.index')"
                      class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                    ← Volver
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                        <h3 class="text-2xl font-bold text-white">Información del Evento</h3>
                        <p class="text-purple-100 mt-1">Complete todos los campos para crear un nuevo evento</p>
                    </div>
                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="mb-4">
                                <InputLabel for="event_name" value="Event Name" class="dark:text-gray-300"/>
                                <TextInput
                                    id="event_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.event_name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.event_name"/>
                            </div>

                            <div class="mb-4">
                                <InputLabel for="event_date" value="Event Date" class="dark:text-gray-300"/>
                                <input
                                    id="event_date"
                                    type="datetime-local"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    v-model="form.event_date"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.event_date"/>
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center">
                                    <input
                                        id="event_is_virtual"
                                        type="checkbox"
                                        class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                        v-model="form.event_is_virtual"
                                    />
                                    <InputLabel for="event_is_virtual" value="Is Virtual Event?" class="ml-2 dark:text-gray-300"/>
                                </div>
                                <InputError class="mt-2" :message="form.errors.event_is_virtual"/>
                            </div>

                            <div class="mb-4">
                                <InputLabel for="event_speaker_name" value="Speaker Name" class="dark:text-gray-300"/>
                                <TextInput
                                    id="event_speaker_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.event_speaker_name"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.event_speaker_name"/>
                            </div>

                            <div class="mb-4">
                                <InputLabel for="fk_venue_event" value="Venue" class="dark:text-gray-300"/>
                                <select
                                    id="fk_venue_event"
                                    v-model="form.fk_venue_event"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                >
                                    <option value="">Select a Venue</option>
                                    <option v-for="venue in venues" :key="venue.id" :value="venue.id">
                                        {{ venue.venue_name }} (Capacity: {{ venue.venue_max_capacity }})
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.fk_venue_event"/>
                            </div>

                            <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <button type="submit" 
                                    class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Crear Evento
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