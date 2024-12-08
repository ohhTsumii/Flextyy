<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import SectionTitle from "@/Components/SectionTitle.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {defineProps, onMounted, ref} from "vue";
import Select from "primevue/select";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DataTable from "primevue/datatable";
import axios from "axios";
import ConfirmPopup from "primevue/confirmpopup";
import Toast from "primevue/toast";
import Column from "primevue/column";
import {useToast} from "primevue/usetoast";
import Dialog from "primevue/dialog";
import 'primeicons/primeicons.css';

const props = defineProps({
    auth: Object, // Specify that auth prop is an object
});

const toast = useToast();
let visible = ref(false);

let formData = ref({
    company: '',
    country: '',
    city: '',
});

let formDataEdit = ref({
    id: '',
    company: '',
    country: '',
    city: '',
});

const country = ref(["UK","GR","NL","CZ","FR","USA","SP","IT","FI","PO"]);
const RecyclePlants = ref(null); // Reactive variable for dashboard data
const fetchRecyclePlants = async () => {
    try {
        const response = await axios.get('/recycle-plants');
        RecyclePlants.value = response.data
        console.log(RecyclePlants.value);
    } catch (error) {
        console.error('Error fetching data:', error);
        RecyclePlants.value = []; // Handle errors by resetting the array
    }
};

onMounted(() => {
    fetchRecyclePlants();
});

const editRecord = (data) => {
    formDataEdit = ref({
        id: data.id,
        company: data.company,
        country: data.country,
        city: data.country,
    });
}
const deleteRecord = (data) => {
    confirm.require({
        target: data.currentTarget,
        message: 'Are you sure you want to delete record?',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete',
            severity: 'danger'
        },
        accept: async () => {
            console.log(data);
            toast.add({severity: 'info', summary: 'Confirmed', detail: 'You have deleted the record', life: 3000});
            formData = ref({
                id: data,

            });
            const response = await axios.post('/deleteinspection', formData.value, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Include CSRF token
                },
            });
            await data();
        },
        // reject: () => {
        //     toast.add({ severity: 'error', summary: 'Confirmed', detail: 'You have rejected', life: 3000 });
        // }
    });
};

const submitForm = async () => {
    const responseMessage = ref('');
    console.log('Form submitted:', formDataEdit.value);
    try {
        // Send a POST request to the Laravel backend
        const response = await axios.post('/editinspection', formDataEdit.value, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Include CSRF token
            },
        });
        // Show success toast message
        toast.add({
            severity: 'success',
            summary: 'Success',
            detail: "Inspection Edited succesfully",
            life: 3000, // The toast will disappear after 3 seconds
        });
        await fetchRecyclePlants();
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
            detail: error,
            life: 3000, // The toast will disappear after 3 seconds
        });

        let responseMessage;
        responseMessage.value = errorMessage;
    }
};

</script>

<template>
    <AppLayout title="Recycleplant">

        <div class="py-6">
            <div class="max-w-7xl my-2 mx-auto sm:px-6 lg:px-8">
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
                        <template v-if="RecyclePlants">
                        <DataTable :value="RecyclePlants" tableStyle="min-width: 50rem">
                            <Column header="Actions">
                                <template #body="slotProps">
                                    <Toast />
                                    <ConfirmPopup></ConfirmPopup>
                                    <Button @click="editRecord(slotProps.data); visible = true" ><i class="pi pi-pencil scale-50" style="font-size: 2rem" ></i></Button>
                                    <Button @click="deleteRecord(slotProps.data.id)"><i class="pi pi-trash scale-50" style="font-size: 2rem" ></i></Button>
                                </template>
                            </Column>
                            <Column field="company" header="Company"></Column>
                            <Column field="city" header="City"></Column>
                            <Column field="country" header="Country"></Column>
                        </DataTable>
                        </template>
                            <template v-else>
                                <p>Loading Recycling Plants...</p>
                            </template>
                        <Dialog v-model:visible="visible" modal header="Edit" :style="{ width: '25rem' }">
                            <template #header>
                                <div class="inline-flex items-center justify-center gap-2">
                                    <span class="font-bold whitespace-nowrap">Edit Inspection</span>
                                </div>
                            </template>
                            <form class="flex flex-col pt-4 text-xl" @submit.prevent="submitForm">
                                <h1 class="text-xl font-medium text-gray-900">Form</h1>
                                <div class="pt-2 pb-2">
                                    <input-label>Week Number</input-label>
                                    <TextInput v-model="formDataEdit.company"></TextInput>
                                </div>
                                <div class="pt-2 pb-2">
                                    <input-label>Recycle Plant</input-label>
                                    <TextInput v-model="formDataEdit.city"></TextInput>
                                </div>
                                <div class="pt-2 pb-2">
                                    <input-label>Inspector</input-label>
                                    <TextInput v-model="formDataEdit.country"></TextInput>
                                </div>
                                <div class="pt-2 pb-2">
                                    <primary-button type="submit" class="pt-2 pb-2 w-fit bg-green-600">Save edit
                                    </primary-button>
                                </div>
                            </form>
                            <!--                        <template #footer>-->
                            <!--                            <Button label="Cancel" text severity="secondary" @click="visible = false" autofocus />-->
                            <!--                            <Button label="Save" outlined severity="secondary" @click="visible = false" autofocus />-->
                            <!--                        </template>-->
                        </Dialog>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

