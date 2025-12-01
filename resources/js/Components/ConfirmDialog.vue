<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
                <!-- Backdrop -->
                <div 
                    class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
                    @click="cancel"
                ></div>
                
                <!-- Modal -->
                <div class="flex min-h-full items-center justify-center p-4">
                    <div 
                        class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all"
                        @click.stop
                    >
                        <!-- Header -->
                        <div class="px-6 pt-6 pb-4">
                            <div class="flex items-start gap-4">
                                <!-- Icon -->
                                <div 
                                    class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center"
                                    :class="iconClass"
                                >
                                    <svg 
                                        class="w-6 h-6" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path 
                                            v-if="type === 'danger'"
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                        />
                                        <path 
                                            v-else-if="type === 'success'"
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                        <path 
                                            v-else
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                        {{ title }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ message }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="px-6 pb-6 flex gap-3 justify-end">
                            <button
                                @click="cancel"
                                class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                            >
                                {{ cancelText }}
                            </button>
                            <button
                                @click="confirm"
                                class="px-4 py-2.5 text-sm font-semibold text-white rounded-lg transition-all"
                                :class="confirmButtonClass"
                            >
                                {{ confirmText }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: 'Confirmar acción'
    },
    message: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'info', // info, success, danger
        validator: (value) => ['info', 'success', 'danger'].includes(value)
    },
    confirmText: {
        type: String,
        default: 'Aceptar'
    },
    cancelText: {
        type: String,
        default: 'Cancelar'
    }
});

const emit = defineEmits(['confirm', 'cancel']);

const iconClass = computed(() => {
    const classes = {
        danger: 'bg-red-100 text-red-600',
        success: 'bg-green-100 text-green-600',
        info: 'bg-blue-100 text-blue-600'
    };
    return classes[props.type] || classes.info;
});

const confirmButtonClass = computed(() => {
    const classes = {
        danger: 'bg-red-600 hover:bg-red-700',
        success: 'bg-green-600 hover:bg-green-700',
        info: 'bg-blue-600 hover:bg-blue-700'
    };
    return classes[props.type] || classes.info;
});

const confirm = () => {
    emit('confirm');
};

const cancel = () => {
    emit('cancel');
};
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-active .relative,
.modal-leave-active .relative {
    transition: transform 0.2s ease, opacity 0.2s ease;
}

.modal-enter-from .relative,
.modal-leave-to .relative {
    transform: scale(0.95);
    opacity: 0;
}
</style>
