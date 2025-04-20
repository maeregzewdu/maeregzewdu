<template>
    <div class="form-group">
        <label v-if="label" class="block text-xs sm:text-sm text-gray-400 mb-2">{{ label }}</label>
        <div class="relative">
            <div v-if="icon" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i :class="icon + ' text-gray-500'"></i>
            </div>
            <input 
                v-if="type !== 'textarea'"
                :type="type"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                :placeholder="placeholder"
                :required="required"
                :disabled="disabled"
                :class="[
                    'w-full py-2.5 rounded-xl bg-[#0F172A] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/30 transition-colors',
                    icon ? 'pl-10 pr-3' : 'px-3',
                    disabled ? 'opacity-50 cursor-not-allowed' : ''
                ]"
            >
            <textarea 
                v-else
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                :placeholder="placeholder"
                :required="required"
                :disabled="disabled"
                :rows="rows"
                :class="[
                    'w-full px-3 py-2.5 rounded-xl bg-[#0F172A] border border-white/10 text-white focus:outline-none focus:border-[#F5D061]/30 transition-colors',
                    disabled ? 'opacity-50 cursor-not-allowed' : ''
                ]"
            ></textarea>
        </div>
        <p v-if="error" class="mt-1 text-xs text-red-500">{{ error }}</p>
        <p v-if="hint" class="mt-1 text-xs text-gray-500">{{ hint }}</p>
    </div>
</template>

<script>
export default {
    name: 'FormInput',
    props: {
        modelValue: {
            type: [String, Number],
            default: ''
        },
        label: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'text'
        },
        placeholder: {
            type: String,
            default: ''
        },
        icon: {
            type: String,
            default: ''
        },
        required: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        error: {
            type: String,
            default: ''
        },
        hint: {
            type: String,
            default: ''
        },
        rows: {
            type: Number,
            default: 3
        }
    },
    emits: ['update:modelValue']
}
</script> 