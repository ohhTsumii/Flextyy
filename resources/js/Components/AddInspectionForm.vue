<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>
<template>
    <form class="flex flex-col pt-4 text-xl"  @submit.prevent="submitForm">
        <h1 class="text-xl font-medium text-gray-900">
            Form
        </h1>
        <div class="pt-2 pb-2">
            <input-label>Week number</input-label>
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
            <TextInput v-model="formData.quantity"></TextInput>
        </div>
        <div class="pt-2 pb-2">
            <primary-button type="submit" class="pt-2 pb-2 w-fit bg-green-600">Submit</primary-button>
        </div>
    </form>
</template>
