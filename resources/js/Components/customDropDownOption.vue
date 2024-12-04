<template>
    <div class="custom-dropdown">
        <div class="dropdown-toggle" @click="toggleDropdown">
            <span>{{ selectedOption ? selectedOption.company : 'Select a Plant' }}</span>
            <i class="arrow" :class="{ 'open': isDropdownOpen }"></i>
        </div>
        <div v-if="isDropdownOpen" class="dropdown-menu">
            <div v-for="plant in plants" :key="plant.id" @click="selectOption(plant)">
                {{ plant.company }} - {{ plant.city }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        // v-model automatically binds to this prop 'value'
        value: {
            type: Object,
            default: null,
        },
        plants: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            isDropdownOpen: false,
            // Set selectedOption based on the 'value' prop
            selectedOption: this.value
        };
    },
    watch: {
        // Watch for changes to the 'value' prop and update selectedOption
        value(newVal) {
            this.selectedOption = newVal;
        }
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        selectOption(plant) {
            this.selectedOption = plant;
            // Emit the selected option to update the v-model in the parent component
            this.$emit('input', plant); // This will update the parent 'formData.glassFactory'
            this.isDropdownOpen = false;
        }
    }
};
</script>

<style scoped>
.custom-dropdown {
    position: relative;
    width: 250px;
    font-family: Arial, sans-serif;
}

.dropdown-toggle {
    padding: 10px;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.arrow {
    transition: transform 0.3s;
}

.arrow.open {
    transform: rotate(180deg);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    max-height: 250px; /* Limit the dropdown height */
    overflow-y: auto; /* Enable scrolling if needed */
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.dropdown-menu div {
    padding: 10px;
    cursor: pointer;
}

.custom-dropdown span,
.custom-dropdown div {
    font-size: 1rem;
}

.dropdown-menu div:hover {
    background-color: #f1f1f1;
}
</style>
