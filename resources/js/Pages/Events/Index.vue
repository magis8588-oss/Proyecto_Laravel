<script setup>
import {computed, ref} from 'vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    events: Array,
    venues: Array,
    message: String
});

const selectedVenue = ref('');
const showDeleteModal = ref(false);
const eventToDelete = ref(null);

const filteredEvents = computed(() => {
    if (!selectedVenue.value) {
        return props.events;
    }
    return props.events.filter(event => event.fk_venue_event == selectedVenue.value);
});

const createEventLink = computed(() => {
    const baseUrl = route('events.create');
    return selectedVenue.value ? `${baseUrl}?venue_id=${selectedVenue.value}` : baseUrl;
});

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
}

const confirmDelete = (event) => {
    eventToDelete.value = event;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showDeleteModal.value = false;
};

const deleteForm = useForm({});

const deleteEvent = () => {
    deleteForm.delete(route('events.destroy', eventToDelete.value.id), {
        onSuccess: () => {
            showDeleteModal.value = false;
        },
    });
};
</script>

<template>
    <Head title="Events"/>

    <AppLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 stroke-purple-500 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Gestión de Eventos</h2>
                </div>
                <Link :href="createEventLink"
                      class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-semibold">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Crear Evento
                    </span>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Venue Filter -->
                <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-indigo-500 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        <label for="venue-filter" class="mr-4 text-lg font-semibold text-gray-700 dark:text-gray-300">Filtrar por Venue:</label>
                        <select
                            id="venue-filter"
                            v-model="selectedVenue"
                            class="flex-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 dark:focus:border-purple-600 focus:ring-purple-500 dark:focus:ring-purple-600 rounded-lg shadow-sm"
                        >
                            <option value="">Todos los Venues</option>
                            <option v-for="venue in venues" :key="venue.id" :value="venue.id">
                                {{ venue.venue_name }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Flash Message -->
                <div v-if="message"
                     class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative"
                     role="alert">
                    <span class="block sm:inline">{{ message }}</span>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div v-if="filteredEvents.length === 0"
                             class="text-center py-4 text-gray-600 dark:text-gray-400">
                            No events available.
                        </div>
                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Event Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Virtual
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Speaker
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Venue
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="event in filteredEvents" :key="event.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ event.id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ event.event_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ formatDate(event.event_date) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ event.event_is_virtual ? 'Yes' : 'No' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ event.event_speaker_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ event.venue?.venue_name || 'No venue' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <Link :href="route('events.show', event.id)"
                                                  class="text-indigo-600 hover:text-indigo-900">
                                                View
                                            </Link>
                                            <Link :href="route('events.edit', event.id)"
                                                  class="text-blue-600 hover:text-blue-900">
                                                Edit
                                            </Link>
                                            <button @click="confirmDelete(event)"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmación de eliminación -->
        <Modal :show="showDeleteModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Estás seguro de que deseas eliminar este evento?
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Esta acción no se puede deshacer.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                    <DangerButton :class="{ 'opacity-25': deleteForm.processing }" :disabled="deleteForm.processing"
                                  @click="deleteEvent">
                        Eliminar
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>