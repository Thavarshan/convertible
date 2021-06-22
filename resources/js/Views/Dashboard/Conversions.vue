<template>
    <action-section>
        <template #title>
            Previous Conversions
        </template>

        <template #description>
            List of all audio file with relative conversion status.
        </template>

        <template #content>
            <div>
                <div v-if="conversions.length > 0" class="space-y-4">
                    <card v-for="(conversion, index) in conversions" :key="index" :has-action="false">
                        <template #content>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div>
                                        <svg v-if="conversion.status === 'pending'" class="animate-spin -ml-1 mr-3 h-6 w-6 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>

                                        <svg v-else-if="conversion.status === 'succeeded'" xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                        </svg>

                                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-3 h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>

                                    <div>
                                        <div class="text-sm font-medium text-gray-800">{{ conversion.name }}</div>
                                        <div class="text-xs text-gray-500">{{ conversion.audio_file_name }}</div>
                                    </div>
                                </div>

                                <div>
                                    <span class="capitalize px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="`text-${statusColor(conversion.status)}-800 bg-${statusColor(conversion.status)}-100`">
                                        {{ conversion.status }}
                                    </span>
                                </div>
                            </div>
                        </template>
                    </card>
                </div>

                <div v-else>
                    <span class="text-gray-500 text-sm">No previous or pending conversions</span>
                </div>
            </div>
        </template>
    </action-section>
</template>

<script>
import ActionSection from '@/Views/Components/Sections/ActionSection';
import Card from '@/Views/Components/Cards/Card';

export default {
    components: {
        ActionSection,
        Card,
    },

    props: {
        conversions: {
            type: Object,
            required: false,
            default: {}
        }
    },

    methods: {
        statusColor(status) {
            if (status === 'succeeded') {
                return 'green';
            } else if (status === 'failed') {
                return 'red';
            } else {
                return 'yellow';
            }
        }
    }
}
</script>
