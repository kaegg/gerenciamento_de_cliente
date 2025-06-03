<template>
    <button :class="['btn btn-md', className]" @click="onClick">
        <slot>Botão</slot>
    </button>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
    onClick: Function,
    class: {
        type: String,
        default: ''
    }
});

const className = props.class
</script>
