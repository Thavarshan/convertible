<template>
    <app-layout>
        <div>
            <upload-audio-file-form></upload-audio-file-form>

            <section-border></section-border>

            <conversions :conversions="conversions.data"></conversions>

            <pagination :links="conversions.links"></pagination>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Views/Layouts/AppLayout';
import UploadAudioFileForm from '@/Views/Dashboard/UploadAudioFileForm';
import Conversions from '@/Views/Dashboard/Conversions';
import SectionBorder from '@/Views/Components/Sections/SectionBorder';
import Pagination from '@/Views/Components/Pagination/Pagination';

export default {
    components: {
        AppLayout,
        UploadAudioFileForm,
        Conversions,
        SectionBorder,
        Pagination
    },

    props: ['conversions']
};
</script>
