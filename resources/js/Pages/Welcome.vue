<script setup>
import { ref, watch, onMounted, onUnmounted } from "vue";
import { Head, Link, useForm } from '@inertiajs/vue3';
import UploadFileSvg from '@/Svgs/UploadFile.vue';
import Bars from '@/Svgs/Bars.vue';
import XMark from '@/Svgs/XMark.vue';
import Modal from '@/Components/Modal.vue';
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";
import "../../css/filters.css";

onMounted(() => {
    initFlowbite();
    selectedAspectRatio.value = '1';
});

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    posts: Array
});

let step = ref(1);

const zoomOnWheel = ref(false);

const componentKey = ref(0);

const toggleZoomOnWheel = () => {
    zoomOnWheel.value = !zoomOnWheel.value;
    componentKey.value++;
}

const isPopoverOpen = ref(false);
const popover = ref(null);

const togglePopover = () => {
    isPopoverOpen.value = !isPopoverOpen.value;
};

const closePopover = (event) => {
    if (popover.value && !popover.value.contains(event.target)) {
        isPopoverOpen.value = false;
    }
};

onMounted(() => {
    window.addEventListener('mousedown', closePopover);
});

onUnmounted(() => {
    window.removeEventListener('mousedown', closePopover);
});

const showCreatePostModal = ref(false);
const openCreatePostModal = () => {
    showCreatePostModal.value = true;
};
const closeCreatePostModal = () => {
    showCreatePostModal.value = false;
};

const imageUrl = ref(null);
const image = ref(null);
const cropper = ref(null);

const selectedAspectRatio = ref(1);

watch(selectedAspectRatio, (newValue) => {
    if (newValue && cropper.value) {
        cropper.value.replace(cropper.value.src, false);
        cropper.value.setAspectRatio(newValue);
    }
});

const onFileSelected = (key, event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageUrl.value = e.target.result;
        };
        reader.readAsDataURL(file);
        form[key] = [file];
        form[key + "_name"] = file.name;
    }
};

const dataURLtoFile = (dataURL, filename) => {
    const arr = dataURL.split(",");
    const mime = arr[0].match(/:(.*?);/)[1];
    const bstr = atob(arr[1]);
    let n = bstr.length;
    const u8arr = new Uint8Array(n);
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, { type: mime });
};

const cropImage = () => {
    image.value = cropper.value.getCroppedCanvas().toDataURL();
    const dataURL = cropper.value.getCroppedCanvas().toDataURL();
    const filename = form.sponsor_name;
    const file = dataURLtoFile(dataURL, filename);
    form.image = file;
};

const flipImageX = () => {
    if (cropper.value) {
        const currentScaleX = cropper.value.getData().scaleX;
        cropper.value.scaleX(currentScaleX * -1);
    }
};

const flipImageY = () => {
    if (cropper.value) {
        const currentScaleY = cropper.value.getData().scaleY;
        cropper.value.scaleY(currentScaleY * -1);
    }
};

const imageFilter = ref('filter-original');

const applyFilter = (filterName) => {
    imageFilter.value = filterName;
};

const cancel = () => {
    closeCreatePostModal();
    form.sponsor = "";
    form.image = null;
    imageUrl.value = null;
    image.value = null;
    if (cropper.value) {
        cropper.value.destroy();
        cropper.value = null;
    }
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.value = "";
    }
};

const backToCrop = () => {
    image.value = null;
    form.image = null;
}

const form = useForm({
    sponsor: "",
    image: "",
    file_type: "",
    link: "",
});

const submit = () => {
    form.post(route("post.create"), {
        headers: {
            "Content-Type": "multipart/form-data",
        },
        preserveScroll: true,
        onSuccess: () => {
            closeCreatePostModal();
            toast.success("Arquivo salvo com Sucesso!", {
                position: "top-right",
                duration: 5000,
            });
            form.sponsor = "";
            form.image = null;
            form.file_type = "";
            form.link = "";
            imageUrl.value = null;
            image.value = null;
            if (cropper.value) {
                cropper.value.destroy();
                cropper.value = null;
            }
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput) {
                fileInput.value = "";
            }
        },
    });
};

</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10">
            <Link v-if="$page.props.auth.Post" :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            Dashboard</Link>

            <template v-else>
                <Link :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Register</Link>
            </template>
        </div>

        <div class="p-6 lg:p-8">

            <button @click="openCreatePostModal" class="button-theme" type="button">
                Publicar
            </button>



            <div v-for="post in posts">
                <img v-if="post.image_path" :src="'../storage/' + post.image_path" />
            </div>
        </div>
    </div>

    <Modal :show="showCreatePostModal" @close="closeCreatePostModal"
        :maxWidth="(image && step === 1) ? '5xl' : (form.sponsor.length !== 0 && !image ? '4xl' : '3xl')">
        <form @submit.prevent="submit">
            <div class="flex items-center justify-between py-1 px-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Criar nova postagem
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    @click="closeCreatePostModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div>
                <div class="flex flex-col justify-center items-center gap-y-6" v-if="form.sponsor.length === 0">
                    <UploadFileSvg />
                    <label for="dropzone-file-sponsor">
                        <div
                            class="flex justify-evenly items-center gap-2 bg-indigo-600 px-6 py-3 text-white font-bold text-xs rounded-lg uppercase shadow-all hover:cursor-pointer">

                            <span>Selecionar do computador</span>
                        </div>
                        <input id="dropzone-file-sponsor" class="hidden" type="file"
                            @change="onFileSelected('sponsor', $event)" accept=".png, .jpeg, .jpg" />
                    </label>

                </div>

                <div v-else>
                    <div v-if="form.sponsor.length != 0 && !image" class="flex flex-col lg:flex-row">
                        <div class="relative max-w-2xl">
                            <vue-cropper ref="cropper" v-if="imageUrl" :src="imageUrl" alt="Imagem" preview=".preview"
                                :aspect-ratio="selectedAspectRatio" :viewMode="1" :zoomOnWheel="zoomOnWheel"
                                :key="componentKey" />
                            <button @click="togglePopover" type="button" class="absolute bottom-2 left-2">
                                <div v-if="isPopoverOpen" class="p-2 bg-gray-900 rounded-full">
                                    <XMark />
                                </div>
                                <div v-else class="p-2 bg-gray-900 rounded-full">
                                    <Bars />
                                </div>

                            </button>
                            <div class="absolute bottom-16 left-2 flex flex-col justify-content-between rounded-lg"
                                v-show="isPopoverOpen" ref="popover" style="background-color: rgba(60, 66, 77, 0.3)">
                                <h1 class="font-bold text-white border-b border-gray-900 pt-2 px-2 pb-2 text-center">
                                    Proporção
                                </h1>
                                <input type="radio" id="aspect-1" value="1" class="hidden peer"
                                    v-model.number="selectedAspectRatio">
                                <label for="aspect-1" class="border-b border-gray-900 py-4 px-2 hover:cursor-pointer">
                                    <div class="flex items-center gap-8 w-full">
                                        <div class="font-black" :class="{
                                            'text-white text-xl': selectedAspectRatio === '1',
                                            'text-gray-300 text-lg': selectedAspectRatio !== '1'
                                        }">1:1</div>
                                        <div class="border-2 border-gray-900 p-3 rounded-md"
                                            :class="{ 'bg-white': selectedAspectRatio === '1' }"></div>
                                    </div>
                                </label>
                                <input type="radio" id="aspect-1-3" value="1.3" class="hidden peer"
                                    v-model.number="selectedAspectRatio">
                                <label for="aspect-1-3" class="border-b border-gray-900 py-4 px-2 hover:cursor-pointer">
                                    <div class="flex items-center gap-8  w-full">
                                        <div class="font-black" :class="{
                                            'text-white text-xl': selectedAspectRatio === '1.3',
                                            'text-gray-300 text-lg': selectedAspectRatio !== '1.3'
                                        }">4:3</div>
                                        <div class="border-2 border-gray-900 px-4 py-3 rounded-md"
                                            :class="{ 'bg-white': selectedAspectRatio === '1.3' }"></div>
                                    </div>
                                </label>
                                <input type="radio" id="aspect-1-7" value="1.7" class="hidden peer"
                                    v-model.number="selectedAspectRatio">
                                <label for="aspect-1-7" class="py-4 px-2 hover:cursor-pointer">
                                    <div class="flex items-center gap-8  w-full">
                                        <div class="font-black" :class="{
                                            'text-white text-xl': selectedAspectRatio === '1.7',
                                            'text-gray-300 text-lg': selectedAspectRatio !== '1.7'
                                        }">16:9</div>
                                        <div class="border-2 border-gray-900 px-4 py-2 rounded-md"
                                            :class="{ 'bg-white': selectedAspectRatio === '1.7' }"></div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex pt-6 gap-4 p-4">
                            <div class="flex flex-col gap-4">
                                <button @click="flipImageX" type="button"
                                    class="bg-blue-500 p-4 text-white rounded-xl">Inverter Horizontalmente</button>
                                <button @click="flipImageY" type="button"
                                    class="bg-blue-500 p-4 text-white rounded-xl">Inverter Verticalmente</button>
                                <button @click="toggleZoomOnWheel" type="button"
                                    class="bg-blue-500 p-4 text-white rounded-xl">
                                    <h2>Habilitar Zoom</h2>
                                    <span v-if="zoomOnWheel === true" class="font-bold">(Habilitado)</span>
                                    <span v-else class="font-bold">(Desabilitado)</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-if="image && step === 1" class="flex items-center w-full">
                        <div class="rounded-2xl shadow-all">
                            <img :src="image" :class="imageFilter" alt="Imagem recortada" />
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 px-4">
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
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex items-center justify-between p-4 md:p-5 border-t">
                <div v-if="!image && step === 1">
                    <button type="button" @click="cancel"
                        class="bg-red-500 px-4 py-2 text-white rounded-lg">Cancelar</button>
                </div>
                <div v-if="image && step === 1" @click="backToCrop">
                    <button type="button">Voltar</button>
                </div>
                <button v-if="form.sponsor.length != 0 && !image && step === 1" type="button" @click="cropImage"
                    class="bg-blue-500 rounded-md text-white py-2 px-4">
                    <span>Avançar</span>
                </button>
                <button type="button" v-if="image && step === 1" @click="step++">Avançar</button>
                <button type="button" v-if="image && step === 2" @click="step--">Voltar</button>
                <button type="submit" v-if="image && step === 2">Salvar</button>
            </div>
        </form>
    </Modal>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
