<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    items: { type: Array, default: () => [] },
});

const active = ref(0);
const current = computed(() => props.items[active.value] || props.items[0]);
const next = () => { active.value = (active.value + 1) % props.items.length; };
const previous = () => { active.value = (active.value - 1 + props.items.length) % props.items.length; };
</script>

<template>
    <div class="vue-gallery" v-if="items.length">
        <div class="vue-gallery-image"><img :src="current.image" :alt="current.alt"></div>
        <div class="vue-gallery-controls"><button type="button" @click="previous">←</button><span>{{ String(active + 1).padStart(2, '0') }} / {{ String(items.length).padStart(2, '0') }}</span><button type="button" @click="next">→</button></div>
    </div>
</template>
