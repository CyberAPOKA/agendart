<template>
    <div>
        <button @click="applyFilter('filter-1977')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-1977" />
        </button>

        <button @click="applyFilter('filter-aden')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-aden" />
        </button>

        <button @click="applyFilter('filter-amaro')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-amaro" />
        </button>

        <button @click="applyFilter('filter-ashby')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-ashby" />
        </button>

        <button @click="applyFilter('filter-brannan')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-brannan" />
        </button>

        <button @click="applyFilter('filter-brooklyn')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-brooklyn" />
        </button>

        <button @click="applyFilter('filter-charmes')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-charmes" />
        </button>

        <button @click="applyFilter('filter-clarendon')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-clarendon" />
        </button>
        <button @click="applyFilter('filter-crema')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-crema" />
        </button>
        <button @click="applyFilter('filter-dogpatch')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-dogpatch" />
        </button>
        <button @click="applyFilter('filter-earlybird')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-earlybird" />
        </button>
        <button @click="applyFilter('filter-gingham')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-gingham" />
        </button>
        <button @click="applyFilter('filter-ginza')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-ginza" />
        </button>
        <button @click="applyFilter('filter-hefe')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-hefe" />
        </button>
        <button @click="applyFilter('filter-helena')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-helena" />
        </button>
        <button @click="applyFilter('filter-hudson')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-hudson" />
        </button>
        <button @click="applyFilter('filter-inkwell')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-inkwell" />
        </button>
        <button @click="applyFilter('filter-kelvin')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-kelvin" />
        </button>
        <button @click="applyFilter('filter-juno')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-juno" />
        </button>
        <button @click="applyFilter('filter-lark')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-lark" />
        </button>
        <button @click="applyFilter('filter-lofi')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-lofi" />
        </button>
        <button @click="applyFilter('filter-ludwig')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-ludwig" />
        </button>
        <button @click="applyFilter('filter-maven')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-maven" />
        </button>
        <button @click="applyFilter('filter-mayfair')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-mayfair" />
        </button>
        <button @click="applyFilter('filter-moon')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-moon" />
        </button>
        <button @click="applyFilter('filter-nashville')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-nashville" />
        </button>
        <button @click="applyFilter('filter-perpetua')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-perpetua" />
        </button>
        <button @click="applyFilter('filter-poprocket')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-poprocket" />
        </button>
        <button @click="applyFilter('filter-reyes')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-reyes" />
        </button>
        <button @click="applyFilter('filter-rise')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-rise" />
        </button>
        <button @click="applyFilter('filter-sierra')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-sierra" />
        </button>
        <button @click="applyFilter('filter-skyline')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-skyline" />
        </button>
        <button @click="applyFilter('filter-slumber')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-slumber" />
        </button>
        <button @click="applyFilter('filter-stinson')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-stinson" />
        </button>
        <button @click="applyFilter('filter-sutro')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-sutro" />
        </button>
        <button @click="applyFilter('filter-toaster')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-toaster" />
        </button>
        <button @click="applyFilter('filter-valencia')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-valencia" />
        </button>
        <button @click="applyFilter('filter-vesper')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-vesper" />
        </button>
        <button @click="applyFilter('filter-walden')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-walden" />
        </button>
        <button @click="applyFilter('filter-willow')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-willow" />
        </button>
        <button @click="applyFilter('filter-xpro-ii')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 filter-xpro-ii" />
        </button>
        <button @click="applyFilter('filter-original')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20" />
        </button>
        <button @click="applyFilter('sepia')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 sepia" />
        </button>
        <button @click="applyFilter('grayscale')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 grayscale" />
        </button>
        <button @click="applyFilter('high-contrast')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 high-contrast" />
        </button>
        <button @click="applyFilter('saturated')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 saturated" />
        </button>
        <button @click="applyFilter('vintage')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 vintage" />
        </button>
        <button @click="applyFilter('blur')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 blur" />
        </button>
        <button @click="applyFilter('invert')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 invert" />
        </button>
        <button @click="applyFilter('opacity')" type="button">
            <img :src="image" alt="Imagem recortada" class="max-w-20 max-h-20 opacity" />
        </button>

        <button @click="applyFilter('filter-xpro-ii')" type="button">
            <img :src="image" alt="I" class="max-w-20 max-h-20 filter-xpro-ii" />
        </button>

    </div>
</template>