<template>
    <action-section>
        <template #title>
            Upload Audio file
        </template>

        <template #description>
            Upload any file with an audio format to convert it into <span class="font-medium text-gray-800">.mp3</span> format.
        </template>

        <template #content>
            <form @submit.prevent="convert">
                <div class="lg:grid lg:grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <input type="file" class="hidden" ref="audiofile" @change="updateFileName">

                        <div>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    <app-button type="button" mode="secondary" @click.prevent="selectNewFile">
                                        Upload file
                                    </app-button>
                                </div>

                                <div v-if="fileName" class="ml-4">
                                    <span class="rounded-xl px-3 py-1 bg-gray-100">
                                        <span class="text-sm font-medium text-gray-800">{{ fileName }}</span>
                                    </span>
                                </div>
                            </div>

                            <div class="mt-1">
                                <app-input-error :message="form.errors.audio" class="mt-2"></app-input-error>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 lg:mt-0 md:col-span-8">
                        <app-input type="text" v-model="form.name" :error="form.errors.name" label="Converted file name" placeholder="Sample audio file"></app-input>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <action-message :on="form.recentlySuccessful" class="mr-4">
                        File uploaded. <span class="ml-1">&check;</span>
                    </action-message>

                    <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                        Convert <span class="ml-1">&rarr;</span>
                    </app-button>
                </div>
            </form>
        </template>
    </action-section>
</template>

<script>
import ActionSection from '@/Views/Components/Sections/ActionSection';
import AppInput from '@/Views/Components/Inputs/Input';
import AppInputError from '@/Views/Components/Inputs/InputError';
import AppButton from '@/Views/Components/Buttons/Button';
import ActionMessage from '@/Views/Components/Alerts/ActionMessage';

export default {
    components: {
        ActionSection,
        AppInput,
        AppInputError,
        AppButton,
        ActionMessage
    },

    data() {
        return {
            form: this.$inertia.form({
                name: null,
                audio: null
            }),

            fileName: null,
        }
    },

    methods: {
        convert() {
            if (this.$refs.audiofile) {
                this.form.audio = this.$refs.audiofile.files[0];
            }

            this.form.post(this.route('conversions.store'), {
                errorBag: 'convertFile',
                preserveScroll: true,
                onSuccess: () => (this.clearFileFileInput()),
            }, {
                resetOnSuccess: true
            });
        },

        selectNewFile() {
            this.$refs.audiofile.click();
        },

        updateFileName() {
            const audiofile = this.$refs.audiofile.files[0];

            if (! audiofile) return;

            const reader = new FileReader();

            reader.onload = () => this.fileName = audiofile.name;

            reader.readAsDataURL(audiofile);
        },

        clearFileFileInput() {
            if (this.$refs.audiofile?.value) {
                this.$refs.audiofile.value = null;
            }
        },
    }
}
</script>
