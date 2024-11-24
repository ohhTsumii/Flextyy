<template>
    <AppLayout title="input">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 ">
                    <section-title>
                        <template #title>
                            Add Inspection
                        </template>

                        <template #description>
                            Fill in the form to create inspections; you will be able to fill in the result of the inspections later.
                        </template>
                    </section-title>
                    <form class="flex flex-col pt-4 text-xl" @submit.prevent="submitForm">
                        <h1 class="text-xl font-medium text-gray-900">Inspection:</h1>
                        <div class="pt-2 pb-2">
                            <input-label>Week Number</input-label>
                            <TextInput v-model="formData.weekNumber" type="number"></TextInput>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>Recycle Plant</input-label>
                            <TextInput v-model="formData.recyclePlant"></TextInput>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>Inspector</input-label>
                            <TextInput v-model="formData.inspector"></TextInput>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>Country</input-label>
                            <TextInput v-model="formData.country"></TextInput>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>Glass Factory</input-label>
                            <TextInput v-model="formData.glassFactory"></TextInput>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>Test Type</input-label>
                            <select v-model="formData.testType">
                                <option>Lot</option>
                                <option>Truck</option>
                            </select>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>Cullet Type</input-label>
                            <select v-model="formData.culletType">
                                <option>Green</option>
                            </select>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>Quantity</input-label>
                            <TextInput type="number" v-model="formData.quantity"></TextInput>
                        </div>
                        <div class="pt-2 pb-2">
                            <primary-button type="submit" class="pt-2 pb-2 w-fit bg-green-600">Submit</primary-button>
                        </div>
                        <Toast ref="toast" />
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import SectionTitle from "@/Components/SectionTitle.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from 'vue';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

// Reactive state for form data
const formData = ref({
    weekNumber: '',
    recyclePlant: '',
    inspector: '',
    country: '',
    glassFactory: '',
    testType: '',
    culletType: '',
    quantity: '',
});
const responseMessage = ref('');

// Use toast
const toast = useToast();

const submitForm = async () => {
    console.log('Form submitted:', formData.value);
    try {
        // Send a POST request to the Laravel backend
        const response = await axios.post('/initialinspection', formData.value, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Include CSRF token
            },
        });
        Object.assign(formData.value,{
            weekNumber: '',
            recyclePlant: '',
            inspector: '',
            country: '',
            glassFactory: '',
            testType: '',
            culletType: '',
            quantity: '',
        });
        // Resets formData to initial values
        // Show success toast message
        toast.add({
            severity: 'success',
            summary: 'Success',
            detail: "Inspection added succesfully",
            life: 3000, // The toast will disappear after 3 seconds
        });

        // Handle the response
        responseMessage.value = response.data.message;

    } catch (error) {
        // Handle any errors
        let errorMessage = 'Error: Something went wrong';
        if (error.response && error.response.data && error.response.data.message) {
            errorMessage = 'Error: ' + error.response.data.message;
        }

        // Show error toast message
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: errorMessage,
            life: 3000, // The toast will disappear after 3 seconds
        });

        responseMessage.value = errorMessage;
    }
};

</script>

<style>
/* Optional: Add any custom styles here */
</style>
