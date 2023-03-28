<template>
    <VueDatePicker
        :enable-time-picker="false"
        teleport-center
        month-name-format="short"
        select-text="Seleccionar"
        cancel-text="Cancelar"
        @update:model-value="onSelect"
    >
        <template #trigger>

            <slot></slot>


        </template>
    </VueDatePicker>
</template>
<script setup>
import VueDatePicker from "@vuepic/vue-datepicker";
import { ref } from "vue";

const props = defineProps({
    modelValue: String,
});
const emit = defineEmits(["update:modelValue"]);

const date = ref(null);

const onSelect = (e) => {
    const day = e.getDate().toString().padStart(2, "0");
    const month = (e.getMonth() + 1).toString().padStart(2, "0");
    const year = e.getFullYear().toString().padStart(2, "0");
    date.value = year + "-" + month + "-" + day;
    emit("update:modelValue", date.value);
};
</script>
