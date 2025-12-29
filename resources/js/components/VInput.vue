<template>
    <div>
        <label
            v-if="label"
            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
        >
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>

        <input
            :type="type === 'money' ? 'text' : type"
            v-model="localValue"
            :placeholder="placeholder ?? label"
            @blur="handleUp"
            @input="change"
            class="mt-1 py-2 px-3 block w-full rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
            :class="{
                'bg-gray-200 dark:bg-gray-600': disabled,
                'border-red-600 dark:border-red-500': error.length,
            }"
            :disabled="disabled"
        />
        <div v-if="helper"
            class="bg-blue-100 mt-1 rounded text-justify flex items-center p-2"
        >
            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
            <small class="text-sm text-blue-900">
                {{ helper }}
            </small>
        </div>
        <v-error :error="error" />
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import VError from "@test/components/VError.vue";

const props = defineProps({
    modelValue: [String, Number],
    label: String,
    type: { type: String, default: "text" },
    placeholder: { type: String, default: null },
    required: { type: Boolean, default: false },
    error: { type: [Array, String], default: [] },
    digits: { type: Number, default: 2 },
    disabled: { type: Boolean, default: false },
    helper: { Type: String, default: null },
});

const emit = defineEmits(["update:modelValue", "input"]);

const localValue = ref("");

watch(
    () => props.modelValue,
    (val) => {
        if (props.type === "money") {
            const num = Number(val);
            localValue.value = !isNaN(num)
                ? (num / Math.pow(10, props.digits)).toFixed(props.digits)
                : "";
        } else {
            localValue.value = val ?? "";
        }
    },
    { immediate: true }
);

const handleUp = () => {
    if (props.type === "money") {
        const num = Number(localValue.value);
        if (!isNaN(num)) {
            // guarda en centavos
            emit(
                "update:modelValue",
                Math.round(num * Math.pow(10, props.digits))
            );
            // re-formatea la vista (ej. 300.9 → 300.90)
            localValue.value = num.toFixed(props.digits);
        } else {
            emit("update:modelValue", null);
            localValue.value = "";
        }
    } else {
        emit("update:modelValue", localValue.value);
    }
};

const change = () => {
    if (props.type != "money") {
        emit("update:modelValue", localValue.value);
        emit("input", localValue.value);
    }
};
</script>
