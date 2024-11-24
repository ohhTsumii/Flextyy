<template>
    <AppLayout title="input">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 ">
                    <section-title>
                        <template #title>
                            Fill in results.
                        </template>

                        <template #description>
                            Complete your results here for easy organization and reliable data reporting.
                        </template>
                    </section-title>
                    <form class="flex flex-col pt-4 text-xl" @submit.prevent="submitForm">
                        <div>
                            <h1 class="text-2xl font-medium text-gray-900 py-4">General Data</h1>
                            <input-label>Country : {{ country }}</input-label>
                            <input-label>Supplier : {{ supplier }}</input-label>
                            <input-label>Type of cullet : {{ cullettype }}</input-label>
                            <input-label>OI Plant : {{ oi_Plant }}</input-label>
                            <input-label>Additional remark cullet : {{ cullettype }}</input-label>
                        </div>
                        <div class="py-4">
                            <h1 class="text-2xl font-medium text-gray-900">Delivery incoming control data</h1>

                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Date of test</input-label>
                                <TextInput v-model="formData.dateTest" type="date"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Type of test</input-label>
                                <TextInput v-model="formData.typeTest" type="text"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Production plant supplier</input-label>
                                <TextInput v-model="formData.plantSupplier" type="text"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">TRUCK / Lot size (tons)</input-label>
                                <TextInput v-model="formData.lotSize" type="text"></TextInput>
                            </div>
                            <Divider/>
                            <h1 class="text-xl font-medium text-gray-900 py-2 mt-6">Sample Size(kg):</h1>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Contamination</input-label>
                                <TextInput v-model="formData.contamination" type="text"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Humidity %</input-label>
                                <TextInput v-model="formData.humidity" type="text"></TextInput>
                            </div>
                            <Divider/>
<!--                            <div class="pt-2 pb-2 flex flex-row items-center">-->
<!--                                <input-label class="w-[30%]">Control done by:</input-label>-->
<!--                                <TextInput v-model="formData.recyclePlant" type="text"></TextInput>-->
<!--                            </div>-->
                        </div>

                        <div>
                            <h1 class="text-2xl font-medium text-gray-900 py-4">Result vs Specification Data</h1>
                            <h1 class="text-xl font-medium text-gray-900 py-2 mt-6">1. Inorganic contamination</h1>

                            <div
                                class="flex flex-row justify-between w-full">
                                <p>CSP</p>
                                <p>Ceramics</p>
                                <p>Stones</p>
                                <p>Porcelain</p>
                            </div>
                            <div
                                class="pt-2 pb-2 flex flex-row justify-between items-center w-full">
                                <input-label class="w-[15%]">input (#)</input-label>
                                <TextInput v-model="formData.ceramics_pc" type="number"></TextInput>
                                <TextInput v-model="formData.stones_pc" type="number"></TextInput>
                                <TextInput v-model="formData.porcelain_pc" type="number"></TextInput>
                            </div>
                            <div
                                class="pt-2 pb-2 flex flex-row justify-between w-full items-center">
                                <input-label class="w-[15%]">input (gr.)</input-label>
                                <TextInput v-model="formData.ceramic_gr" type="number"></TextInput>
                                <TextInput v-model="formData.stones_gr" type="number"></TextInput>
                                <TextInput v-model="formData.porcelain_gr" type="number"></TextInput>
                            </div>
                            <div
                                class="pt-2 pb-2 flex flex-row justify-between w-full items-center">
                                <input-label class="w-[15%]">Opal Glass (gr.)</input-label>
                                <TextInput class="" v-model="formData.opalGlass"></TextInput>
                                <div class="w-[49%]"></div> <!-- Minimal spacer -->
                            </div>
                        </div>
                        <Divider/>
                        <div>
                            <h1 class="text-xl font-medium text-gray-900 mt-6 py-2">2. Metal contamination</h1>

                            <div class="pt-2 pb-2 flex flex-row flex-row items-center">
                                <input-label class="w-[30%]">Magnetic (ppm / gr/ton)</input-label>
                                <TextInput class="ml-1" v-model="formData.magnetic"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row flex-row items-center">
                                <input-label class="w-[30%]">Non-magnetic (ppm / gr/ton)</input-label>
                                <TextInput class="ml-1" v-model="formData.nonMagnetic"></TextInput>
                            </div>
                        </div>
                        <Divider/>
                        <div>
                            <h1 class="text-xl font-medium text-gray-900 mt-6 py-2">3. Moisture and organic
                                contamination</h1>

                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Organic Matter (gr)</input-label>
                                <TextInput class="ml-1" v-model="formData.organicMatter"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Plastics seperate</input-label>
                                <TextInput class="ml-1" v-model="formData.plasticSeperate"></TextInput>
                            </div>
                        </div>
                        <Divider/>
                        <div>
                            <h1 class="text-xl font-medium text-gray-900 mt-6 py-2">4. General quality requirements</h1>

                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Pyro-Ceramic Glass (gr)</input-label>
                                <TextInput class="ml-1" v-model="formData.pyroGlass_gr"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center ">
                                <input-label class="w-[30%]">Pyro-Ceramic Glass (pieces)</input-label>
                                <TextInput class="ml-1" v-model="formData.pyroGlass_pc"></TextInput>
                            </div>
                        </div>
                        <Divider/>
                        <div>
                            <h1 class="text-xl font-medium text-gray-900 mt-6 py-2">5. Granulometry / Sizing</h1>

                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Input in grams ( > 70mm)</input-label>
                                <TextInput class="ml-1" v-model="formData.largerThan70mm"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Input in grams ( > 10mm)</input-label>
                                <TextInput class="ml-1" v-model="formData.largerThan10mm"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Input in grams ( > 5mm -< 10mm)</input-label>
                                <TextInput class="ml-1" v-model="formData.between5mmAnd10mm"></TextInput>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row items-center">
                                <input-label class="w-[30%]">Input in grams ( < 5mm)</input-label>
                                <TextInput class="ml-1" v-model="formData.smallerThan5mm"></TextInput>
                            </div>
                        </div>
                        <Divider/>
                        <div>
                            <h1 class="text-xl font-medium text-gray-900 py-2 mt-6">6. Color specification</h1>

                            <div class="flex flex-row justify-between w-full">
                                <p class="w-[15%]"></p>
                                <p class="w-[15%]">(half) flint</p>
                                <p class="w-[15%]">Green</p>
                                <p class="w-[15%]">Amber</p>
                                <p class="w-[15%]">dead leaf</p>
                                <p class="w-[15%]">Blue</p>
                            </div>
                            <div class="pt-2 pb-2 flex flex-row justify-between items-center w-full">
                                <input-label class="w-[15%]">Input Color Gram</input-label>
                                <TextInput class="w-[15%]" v-model="formData.flint" type="number"></TextInput>
                                <TextInput class="w-[15%]" v-model="formData.green" type="number"></TextInput>
                                <TextInput class="w-[15%]" v-model="formData.amber" type="number"></TextInput>
                                <TextInput class="w-[15%]" v-model="formData.deadLeaf" type="number"></TextInput>
                                <TextInput class="w-[15%]" v-model="formData.blue" type="number"></TextInput>
                            </div>
                        </div>
                        <div class="pt-2 pb-2">
                            <primary-button type="submit" class="pt-2 pb-2 w-fit bg-green-600">Submit
                            </primary-button>
                        </div>
                        <Toast ref="toast"/>
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
import {ref} from 'vue';
import axios from 'axios';
import {useToast} from 'primevue/usetoast';
import Toast from 'primevue/toast';
import Divider from 'primevue/divider';

//hardcoded for now
const country = ref("UK")
const supplier = ref("Sibelco")
const cullettype = ref("green")
const oi_Plant = ref("Alloa")


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
// const responseMessage = ref('');

// Use toast
// const toast = useToast();

// const submitForm = async () => {
//     console.log('Form submitted:', formData.value);
//     try {
//         // Send a POST request to the Laravel backend
//         const response = await axios.post('/initialinspection', formData.value, {
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Include CSRF token
//             },
//         });
//         Object.assign(formData.value,{
//             weekNumber: '',
//             recyclePlant: '',
//             inspector: '',
//             country: '',
//             glassFactory: '',
//             testType: '',
//             culletType: '',
//             quantity: '',
//         });
//         // Resets formData to initial values
//         // Show success toast message
//         toast.add({
//             severity: 'success',
//             summary: 'Success',
//             detail: "Inspection added succesfully",
//             life: 3000, // The toast will disappear after 3 seconds
//         });
//
//         // Handle the response
//         responseMessage.value = response.data.message;
//
//     } catch (error) {
//         // Handle any errors
//         let errorMessage = 'Error: Something went wrong';
//         if (error.response && error.response.data && error.response.data.message) {
//             errorMessage = 'Error: ' + error.response.data.message;
//         }
//
//         // Show error toast message
//         toast.add({
//             severity: 'error',
//             summary: 'Error',
//             detail: errorMessage,
//             life: 3000, // The toast will disappear after 3 seconds
//         });
//
//         responseMessage.value = errorMessage;
//     }
// };

</script>

<style>
/* Optional: Add any custom styles here */
</style>
