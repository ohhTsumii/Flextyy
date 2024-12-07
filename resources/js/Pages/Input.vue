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
                            <TextInput v-model="formData.date" type="date"></TextInput>
                        </div>
                        <div class="pt-2 pb-2 ">
                            <input-label>Recycle Plant</input-label>
<!--                            <TextInput v-model="formData.recyclePlant"></TextInput>-->
<!--                            <select class="w-20" v-model="formData.recyclePlant">-->
<!--                                <option v-for="plant in RecyclePlants" :key="plant.id" :value="plant.id">-->
<!--                                    {{ plant.company }} - {{ plant.city }}-->
<!--                                </option>-->
<!--                            </select>-->
                            <Select v-model="formData.recyclePlant" :options="RecyclePlants" optionLabel="fullLabel" optionValue="id" placeholder="Select a City" class="w-full md:w-56" />
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
                            <Select v-model="formData.glassFactory" :options="GlassFactories" optionLabel="fullLabel" optionValue="id" placeholder="Select a City" class="w-full md:w-56" />
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
                        <Toast />
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
import {onMounted, ref} from 'vue';
import axios from 'axios';
import {useToast} from 'primevue/usetoast';
import Toast from 'primevue/toast';
import Select from 'primevue/select';

const RecyclePlants = ref([]);
const GlassFactories = ref([]);
// Reactive variables
const inputDate = ref(''); // Input field binding
const weekNumber = ref(null); // Week number to show after calculation
const getGlassFactories = async () => {
    try {
        const response = await axios.get('/glass-factories'); // Make the GET request
        console.log(response.data);
        GlassFactories.value = response.data.map(Glassfactory => ({
            ...Glassfactory,
            fullLabel: `${Glassfactory.company} - ${Glassfactory.country}` // Combine company and country
        }));
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};
const getRecyclePlants = async () => {
    try {
        const response = await axios.get('/recycle-plants'); // Make the GET request
        console.log(response.data);

        // Assuming response.data is an array of objects
        // Add a new property 'fullLabel' that combines 'company' and 'country'
        // Assign the enhanced data with fullLabel to RecyclePlants
        RecyclePlants.value = response.data.map(plant => ({
            ...plant,
            fullLabel: `${plant.company} - ${plant.country}` // Combine company and country
        }));
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};


onMounted(() => {
    getGlassFactories();
    getRecyclePlants();
});
console.log(GlassFactories)
// Reactive state for form data
const formData = ref({
    date: '',
    recyclePlant: '',
    inspector: '',
    country: '',
    glassFactory: '',
    testType: '',
    culletType: '',
    quantity: '',
    weekNumber: '',
});
const responseMessage = ref('');

// Use toast
const toast = useToast();

// Parse the entered date string and compute the week number
// Function to calculate the week number
function getWeekNumber(date) {
    const targetDate = new Date(date);
    const startOfYear = new Date(targetDate.getFullYear(), 0, 1);

    const daysDifference = Math.floor((targetDate - startOfYear) / (24 * 60 * 60 * 1000));
    const weekNum = Math.ceil((daysDifference + 3) / 7);

    return weekNum;
}
const submitForm = async () => {
    // console.log('Form submitted:', formData.value);
    // console.log(getWeekNumber(formData.value.date))
    formData.value.weekNumber = getWeekNumber(formData.value.date);
    try {
        // Send a POST request to the Laravel backend
        const response = await axios.post('/initialinspection', formData.value, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Include CSRF token
            },
        });
        Object.assign(formData.value,{
            date: '',
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

<style scoped>
select {
    width: 250px; /* Set a specific width */
    overflow-y: auto; /* Allow scrolling if there are too many options */
}
</style>

