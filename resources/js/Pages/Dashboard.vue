<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from "@/Components/SectionTitle.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {defineProps, onMounted, ref} from 'vue';
import Badge from 'primevue/badge';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import 'primeicons/primeicons.css';
import Toast from 'primevue/toast';
import ConfirmPopup from "primevue/confirmpopup";
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import axios from "axios";
import Dialog from 'primevue/dialog';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

// Define props to access user data
const props = defineProps({
    auth: Object, // Specify that auth prop is an object
});

let formData = ref({
    id: '',

});

let formDataEdit = ref({
    weeknumber: '',
    recycleplant: '',
    inspector: '',
    country: '',
    glassfactory: '',
    testtype: '',
    cullettype: '',
    quantity: '',
    id: '',
});

// Destructure the user from auth prop
const {user} = props.auth;
let visible = ref(false);
const dashboardData = ref(null); // Reactive variable for dashboard data

const count = ref(0)
// Function to fetch the dashboard data
const fetchDashboardData = async () => {
    try {
        const response = await axios.get('/api/dashboard'); // Make the GET request
        // console.log(response.data);
        dashboardData.value = response.data; // Assign the response data
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};

// Run the function when the component is mounted
onMounted(() => {
    fetchDashboardData();
});

const confirm = useConfirm();
const toast = useToast();


const editRecord = (data) => {
    formDataEdit = ref({
        weekNumber: data.weeknumber,
        recyclePlant: data.recycleplant,
        inspector: data.inspector,
        country: data.country,
        glassFactory: data.glassfactory,
        testType: data.testtype,
        culletType: data.cullettype,
        quantity: data.quantity,
        id: data.id,
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
            await fetchDashboardData();
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
        await fetchDashboardData();
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

const fillRecord = (data) => {
    const query = new URLSearchParams(data).toString();
    window.location.href = `/inputresult?id=${query}`;
};


const resultSeverity = (data) => {
    if (data == "higher") return 'warn';
    // console.log(data);
    else return 'success';

}

const statusSeverity = (data) => {
    if (data == "open") return 'warn';
    // console.log(data);
    else return 'success';

}

</script>

<template>
    <AppLayout title="Dashboard">

        <div class="py-6">
            <div class="max-w-full my-2 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <section-title class="pb-4">
                        <template #title>
                            Welcome {{ user.name }}
                        </template>

                        <!-- Filling the "description" slot -->
                        <template #description>
                            Get ready for your upcoming inspections! Below, you’ll find the schedule. Each inspection is
                            an opportunity for you to showcase your skills and commitment to excellence.
                        </template>

                        <!-- Filling the "aside" slot -->
                        <!--                        <template #aside>-->
                        <!--                            <button class="bg-blue-500 text-white px-4 py-2 rounded">-->
                        <!--                                Click Me-->
                        <!--                            </button>-->
                        <!--                        </template>-->
                    </section-title>
                    <template v-if="dashboardData">
                        <DataTable :value="dashboardData['openInspections']" tableStyle="min-width: 50rem">
                            <Column header="Actions">
                                <template #body="slotProps">
                                    <Toast/>
                                    <ConfirmPopup></ConfirmPopup>
                                    <Button @click="editRecord(slotProps.data);visible = true"><i
                                        class="pi pi-pencil scale-50" style="font-size: 2rem"></i></Button>
                                    <!--                                <Button><i class="pi pi-trash" style="font-size: 2rem" ></i></Button>-->
                                    <Button @click="deleteRecord(slotProps.data.id)"><i class="pi pi-trash scale-50"
                                                                                        style="font-size: 2rem"></i>
                                    </Button>
                                </template>
                            </Column>
                            <Column field="date" header="Date"></Column>
                            <Column field="weeknumber" header="Week Number"></Column>
                            <Column field="status" header="status">
                                <template #body="slotProps">
                                    <Badge :value="slotProps.data.status"
                                           :severity="statusSeverity(slotProps.data.status)"/>
                                </template>
                            </Column>
                            <Column field="inspector" header="Inspector"></Column>
                            <Column field="recycle_plant_company" header="Recycle Plant"></Column>
                            <Column field="glass_factory_company" header="Glass Factory"></Column>
                            <Column field="country" header="Country"></Column>
                            <Column field="testtype" header="Test type"></Column>
                            <Column field="cullettype" header="Cullet type"></Column>
                            <Column field="quantity" header="Quantity"></Column>
                            <!--                        <Column field="result" header="Result" >-->
                            <!--                            <template #body="slotProps">-->
                            <!--                                <Badge :value="slotProps.data.status" :severity="resultSeverity(slotProps.data)" />-->
                            <!--                            </template>-->
                            <!--                        </Column>-->
                            <Column header="Results">
                                <template #body="slotProps">
                                    <secondary-button severity="success" @click="fillRecord(slotProps.data.id)">Fill
                                    </secondary-button>
                                </template>
                            </Column>
                        </DataTable>
                    </template>
                    <template v-else>
                        <p>Loading inspections...</p>
                    </template>
                    <Dialog v-model:visible="visible" modal header="Edit Profile" :style="{ width: '25rem' }">
                        <template #header>
                            <div class="inline-flex items-center justify-center gap-2">
                                <!--                                <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" shape="circle" />-->
                                <span class="font-bold whitespace-nowrap">Edit Inspection</span>
                            </div>
                        </template>
                        <form class="flex flex-col pt-4 text-xl" @submit.prevent="submitForm">
                            <h1 class="text-xl font-medium text-gray-900">Form</h1>
                            <div class="pt-2 pb-2">
                                <input-label>Week Number</input-label>
                                <TextInput v-model="formDataEdit.weekNumber" type="number"></TextInput>
                            </div>
                            <div class="pt-2 pb-2">
                                <input-label>Recycle Plant</input-label>
                                <TextInput v-model="formDataEdit.recyclePlant"></TextInput>
                            </div>
                            <div class="pt-2 pb-2">
                                <input-label>Inspector</input-label>
                                <TextInput v-model="formDataEdit.inspector"></TextInput>
                            </div>
                            <div class="pt-2 pb-2">
                                <input-label>Country</input-label>
                                <TextInput v-model="formDataEdit.country"></TextInput>
                            </div>
                            <div class="pt-2 pb-2">
                                <input-label>Glass Factory</input-label>
                                <TextInput v-model="formDataEdit.glassFactory"></TextInput>
                            </div>
                            <div class="pt-2 pb-2">
                                <input-label>Test Type</input-label>
                                <select v-model="formDataEdit.testType">
                                    <option>Lot</option>
                                    <option>Truck</option>
                                </select>
                            </div>
                            <div class="pt-2 pb-2">
                                <input-label>Cullet Type</input-label>
                                <select v-model="formDataEdit.culletType">
                                    <option>Green</option>
                                </select>
                            </div>
                            <div class="pt-2 pb-2">
                                <input-label>Quantity</input-label>
                                <TextInput type="number" v-model="formDataEdit.quantity"></TextInput>
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-10 p-6">
                    <section-title class="pb-4">
                        <template #title>
                            History
                        </template>

                        <!-- Filling the "description" slot -->
                        <template #description>
                            All filled closed inspections will show below
                        </template>

                        <!-- Filling the "aside" slot -->
                        <!--                        <template #aside>-->
                        <!--                            <button class="bg-blue-500 text-white px-4 py-2 rounded">-->
                        <!--                                Click Me-->
                        <!--                            </button>-->
                        <!--                        </template>-->
                    </section-title>
                    <template v-if="dashboardData">
                        <DataTable :value="dashboardData['closedInspections']" tableStyle="min-width: 50rem">
                            <!--                            <Column header="Actions" >-->
                            <!--                                <template #body="slotProps">-->
                            <!--                                    <Toast />-->
                            <!--                                    <ConfirmPopup></ConfirmPopup>-->
                            <!--                                    <Button @click="editRecord(slotProps.data);visible = true" ><i class="pi pi-pencil scale-50" style="font-size: 2rem" ></i></Button>-->
                            <!--                                    &lt;!&ndash;                                <Button><i class="pi pi-trash" style="font-size: 2rem" ></i></Button>&ndash;&gt;-->
                            <!--                                    <Button @click="deleteRecord(slotProps.data.id)"><i class="pi pi-trash scale-50" style="font-size: 2rem" ></i></Button>-->
                            <!--                                </template>-->
                            <!--                            </Column>-->
                            <Column field="date" header="Date"></Column>
                            <Column field="weeknumber" header="Week Number"></Column>
                            <Column field="status" header="status">
                                <template #body="slotProps">
                                    <Badge :value="slotProps.data.status"
                                           :severity="statusSeverity(slotProps.data.status)"/>
                                </template>
                            </Column>
                            <Column field="inspector" header="Inspector"></Column>
                            <Column field="recycle_plant_company" header="Recycle Plant"></Column>
                            <Column field="glass_factory_company" header="Glass Factory"></Column>
                            <Column field="country" header="Country"></Column>
                            <Column field="testtype" header="Test type"></Column>
                            <Column field="cullettype" header="Cullet type"></Column>
                            <Column field="quantity" header="Quantity"></Column>
                            <!--                        <Column field="result" header="Result" >-->
                            <!--                            <template #body="slotProps">-->
                            <!--                                <Badge :value="slotProps.data.status" :severity="resultSeverity(slotProps.data)" />-->
                            <!--                            </template>-->
                            <!--                        </Column>-->
                            <Column header="Results">
                                <template #body="slotProps">
                                    <secondary-button severity="success">View</secondary-button>
                                </template>
                            </Column>
                        </DataTable>
                    </template>
                    <template v-else>
                        <p>Loading inspections...</p>
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.green {
    background-color: green;
    color: white;
    padding: 0.5rem;
    border-radius: 4px;
}
</style>
