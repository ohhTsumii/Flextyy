<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import SectionTitle from "@/Components/SectionTitle.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import Select from "primevue/select";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DataTable from "primevue/datatable";
import axios from "axios";

const formData = ref({
    company: '',
    country: '',
    city: '',
});

const country = ref(["UK","GR","NL","CZ","FR","USA","SP","IT","FI","PO"]);

const data = async () => {
    try {
        const response = await axios.get('/gettesttype'); // Make the GET request

        data.value = response.data
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

</script>

<template>
    <AppLayout title="Testtype">

        <div class="py-6">
            <div class="max-w-full my-2 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <section-title class="pb-4">
                        <template #title>
                            Testtype
                        </template>

                        <!-- Filling the "description" slot -->
                        <template #description>
                            Add , edit or delete Testtype
                        </template>

                        <!-- Filling the "aside" slot -->
                        <!--                        <template #aside>-->
                        <!--                            <button class="bg-blue-500 text-white px-4 py-2 rounded">-->
                        <!--                                Click Me-->
                        <!--                            </button>-->
                        <!--                        </template>-->
                    </section-title>

                    <form class="flex flex-col pt-4 text-xl" @submit.prevent="submitForm">
                        <h1 class="text-xl font-medium text-gray-900">Add test type</h1>
                        <div class="pt-2 pb-2">
                            <input-label>Company</input-label>
                            <TextInput v-model="formData.company"></TextInput>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>City</input-label>
                            <TextInput v-model="formData.city"></TextInput>
                        </div>
                        <div class="pt-2 pb-2">
                            <input-label>Country</input-label>
                            <Select v-model="formData.country" :options="country" placeholder="Select a Country" class="w-full md:w-56" />
                        </div>
                        <div class="pt-2 pb-2">
                            <primary-button type="submit" class="pt-2 pb-2 w-fit bg-green-600">Add</primary-button>
                        </div>
                    </form>
                    <div>
                        <DataTable :value="data" tableStyle="min-width: 50rem">

                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
