<script setup>
import { ref, defineEmits } from "vue";

const emits = defineEmits(['filter-changed']);
const imageFilter = ref('filter-original');

const applyFilter = (filterName) => {
    imageFilter.value = filterName;
    emits('filter-changed', filterName);
};
defineProps({
    image: Object
})
</script>
<template>
    <button @click="applyFilter('filter-original')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-original" />
        <span class="text-sm text-gray-900 font-medium text-center">Original</span>
    </button>
    <button @click="applyFilter('filter-1977')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-1977" />
        <span class="text-sm text-gray-900 font-medium text-center">1977</span>
    </button>
    <button @click="applyFilter('filter-aden')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-aden" />
        <span class="text-sm text-gray-900 font-medium text-center">Aden</span>
    </button>
    <button @click="applyFilter('filter-amaro')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-amaro" />
        <span class="text-sm text-gray-900 font-medium text-center">Amaro</span>
    </button>
    <button @click="applyFilter('filter-ashby')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-ashby" />
        <span class="text-sm text-gray-900 font-medium text-center">Ashby</span>
    </button>
    <button @click="applyFilter('filter-brannan')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-brannan" />
        <span class="text-sm text-gray-900 font-medium text-center">Brannan</span>
    </button>
    <button @click="applyFilter('filter-brooklyn')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-brooklyn" />
        <span class="text-sm text-gray-900 font-medium text-center">Brooklyn</span>
    </button>
    <button @click="applyFilter('filter-charmes')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-charmes" />
        <span class="text-sm text-gray-900 font-medium text-center">Charmes</span>
    </button>
    <button @click="applyFilter('filter-clarendon')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-clarendon" />
        <span class="text-sm text-gray-900 font-medium text-center">Clarendon</span>
    </button>
    <button @click="applyFilter('filter-crema')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-crema" />
        <span class="text-sm text-gray-900 font-medium text-center">Crema</span>
    </button>
    <button @click="applyFilter('filter-dogpatch')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-dogpatch" />
        <span class="text-sm text-gray-900 font-medium text-center">Dogpatch</span>
    </button>
    <button @click="applyFilter('filter-earlybird')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-earlybird" />
        <span class="text-sm text-gray-900 font-medium text-center">Earlybird</span>
    </button>
    <button @click="applyFilter('filter-gingham')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-gingham" />
        <span class="text-sm text-gray-900 font-medium text-center">Gingham</span>
    </button>
    <button @click="applyFilter('filter-ginza')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-ginza" />
        <span class="text-sm text-gray-900 font-medium text-center">Ginza</span>
    </button>
    <button @click="applyFilter('filter-hefe')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-hefe" />
        <span class="text-sm text-gray-900 font-medium text-center">Hefe</span>
    </button>
    <button @click="applyFilter('filter-helena')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-helena" />
        <span class="text-sm text-gray-900 font-medium text-center">Helena</span>
    </button>
    <button @click="applyFilter('filter-hudson')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-hudson" />
        <span class="text-sm text-gray-900 font-medium text-center">Hudson</span>
    </button>
    <button @click="applyFilter('filter-inkwell')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-inkwell" />
        <span class="text-sm text-gray-900 font-medium text-center">Inkwell</span>
    </button>
    <button @click="applyFilter('filter-kelvin')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-kelvin" />
        <span class="text-sm text-gray-900 font-medium text-center">Kelvin</span>
    </button>
    <button @click="applyFilter('filter-juno')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-juno" />
        <span class="text-sm text-gray-900 font-medium text-center">Kuno</span>
    </button>
    <button @click="applyFilter('filter-lark')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-lark" />
        <span class="text-sm text-gray-900 font-medium text-center">Lark</span>
    </button>
    <button @click="applyFilter('filter-lofi')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-lofi" />
        <span class="text-sm text-gray-900 font-medium text-center">Lo-Fi</span>
    </button>
    <button @click="applyFilter('filter-ludwig')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-ludwig" />
        <span class="text-sm text-gray-900 font-medium text-center">Ludwig</span>
    </button>
    <button @click="applyFilter('filter-maven')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-maven" />
        <span class="text-sm text-gray-900 font-medium text-center">Maven</span>
    </button>
    <button @click="applyFilter('filter-mayfair')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-mayfair" />
        <span class="text-sm text-gray-900 font-medium text-center">Mayfair</span>
    </button>
    <button @click="applyFilter('filter-moon')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-moon" />
        <span class="text-sm text-gray-900 font-medium text-center">Moon</span>
    </button>
    <button @click="applyFilter('filter-nashville')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-nashville" />
        <span class="text-sm text-gray-900 font-medium text-center">Nashville</span>
    </button>
    <button @click="applyFilter('filter-perpetua')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-perpetua" />
        <span class="text-sm text-gray-900 font-medium text-center">Perpetua</span>
    </button>
    <button @click="applyFilter('filter-poprocket')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-poprocket" />
        <span class="text-sm text-gray-900 font-medium text-center">Poprocket</span>
    </button>
    <button @click="applyFilter('filter-reyes')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-reyes" />
        <span class="text-sm text-gray-900 font-medium text-center">Reyes</span>
    </button>
    <button @click="applyFilter('filter-rise')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-rise" />
        <span class="text-sm text-gray-900 font-medium text-center">Rise</span>
    </button>
    <button @click="applyFilter('filter-sierra')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-sierra" />
        <span class="text-sm text-gray-900 font-medium text-center">Sierra</span>
    </button>
    <button @click="applyFilter('filter-skyline')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-skyline" />
        <span class="text-sm text-gray-900 font-medium text-center">Skyline</span>
    </button>
    <button @click="applyFilter('filter-slumber')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-slumber" />
        <span class="text-sm text-gray-900 font-medium text-center">Slumber</span>
    </button>
    <button @click="applyFilter('filter-stinson')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-stinson" />
        <span class="text-sm text-gray-900 font-medium text-center">Stinson</span>
    </button>
    <button @click="applyFilter('filter-sutro')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-sutro" />
        <span class="text-sm text-gray-900 font-medium text-center">Sutro</span>
    </button>
    <button @click="applyFilter('filter-toaster')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-toaster" />
        <span class="text-sm text-gray-900 font-medium text-center">Toaster</span>
    </button>
    <button @click="applyFilter('filter-valencia')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-valencia" />
        <span class="text-sm text-gray-900 font-medium text-center">Valencia</span>
    </button>
    <button @click="applyFilter('filter-vesper')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-vesper" />
        <span class="text-sm text-gray-900 font-medium text-center">Vesper</span>
    </button>
    <button @click="applyFilter('filter-walden')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-walden" />
        <span class="text-sm text-gray-900 font-medium text-center">Walden</span>
    </button>
    <button @click="applyFilter('filter-willow')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-willow" />
        <span class="text-sm text-gray-900 font-medium text-center">Willow</span>
    </button>
    <button @click="applyFilter('filter-xpro-ii')" type="button">
        <img :src="image" alt="I" class="max-w-24 max-h-24 filter-xpro-ii" />
        <span class="text-sm text-gray-900 font-medium text-center">X-Pro II</span>
    </button>
    <button @click="applyFilter('filter-sepia')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-sepia" />
        <span class="text-sm text-gray-900 font-medium text-center">Sepia</span>
    </button>
    <button @click="applyFilter('filter-grayscale')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-grayscale" />
        <span class="text-sm text-gray-900 font-medium text-center">Grayscale</span>
    </button>
    <button @click="applyFilter('filter-high-contrast')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-high-contrast" />
        <span class="text-sm text-gray-900 font-medium text-center whitespace-nowrap">High Contrast</span>
    </button>
    <button @click="applyFilter('filter-saturated')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-saturated" />
        <span class="text-sm text-gray-900 font-medium text-center">Saturated</span>
    </button>
    <button @click="applyFilter('filter-vintage')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-vintage" />
        <span class="text-sm text-gray-900 font-medium text-center">Vintage</span>
    </button>
    <button @click="applyFilter('filter-blur')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-blur" />
        <span class="text-sm text-gray-900 font-medium text-center">Blur</span>
    </button>
    <button @click="applyFilter('filter-invert')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-invert" />
        <span class="text-sm text-gray-900 font-medium text-center">Invert</span>
    </button>
    <button @click="applyFilter('filter-opacity')" type="button">
        <img :src="image" alt="Imagem recortada" class="max-w-24 max-h-24 filter-opacity" />
        <span class="text-sm text-gray-900 font-medium text-center">Opacity</span>
    </button>
</template>