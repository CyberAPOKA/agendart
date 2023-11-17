<script setup>
import { ref, watch, onMounted, onUnmounted, computed } from "vue";
import { Head, Link, router } from '@inertiajs/vue3';
import UploadFileSvg from '@/Svgs/UploadFile.vue';
import Bars from '@/Svgs/Bars.vue';
import XMark from '@/Svgs/XMark.vue';
import Modal from '@/Components/Modal.vue';
import Filters from '@/Components/Filters.vue';
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";
import "../../css/filters.css";
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { useForm } from 'laravel-precognition-vue-inertia';
import moment from "moment";

const toast = useToast();

onMounted(() => {
    initFlowbite();
    selectedAspectRatio.value = null;
});

const props = defineProps({
    posts: Object
});

const posts = ref(props.posts);

const loadMorePosts = async () => {
    const nextPage = posts.value.current_page + 1;
    if (nextPage <= posts.value.last_page) {
        try {
            const response = await axios.get(route('posts', { page: nextPage }));
            // console.log(response);
            posts.value = {
                ...posts.value,
                data: [...posts.value.data, ...response.data.data],
                current_page: response.data.current_page
            };
        } catch (error) {
            console.error(error);
        }
    }
};

window.addEventListener('scroll', () => {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        loadMorePosts();
    }
});

onUnmounted(() => {
    window.removeEventListener('scroll', loadMorePosts);
});


function dateStringToTimeAgo(dateString) {
    const now = new Date();
    const date = new Date(dateString);
    const diff = now - date;

    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const weeks = Math.floor(days / 7);
    const months = Math.floor(days / 30);
    const years = Math.floor(days / 365);

    if (seconds < 60) {
        return "agora mesmo";
    } else if (minutes < 60) {
        return `${minutes} min atrás`;
    } else if (hours < 24) {
        return `${hours} h atrás`;
    } else if (days < 7) {
        return `${days} d atrás`;
    } else if (weeks < 4) {
        return `${weeks} sem atrás`;
    } else if (months < 12) {
        return `${months} meses atrás`;
    } else {
        return `${years} anos atrás`;
    }
}

const disabledButton = computed(() => {
    return form.errors && Object.keys(form.errors).length > 0;
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

const selectedAspectRatio = ref('');

watch(selectedAspectRatio, (newValue) => {
    if (cropper.value) {
        cropper.value.replace(cropper.value.src, false);
        if (newValue) {
            cropper.value.setAspectRatio(newValue);
        } else {
            cropper.value.setAspectRatio(NaN);
        }
    }
});

const onFileSelected = (key, event) => {
    const file = event.target.files[0];

    if (!file) {
        return;
    }

    const maxFileSize = 5 * 1024 * 1024;
    if (file.size > maxFileSize) {
        toast.error("O arquivo deve ser menor que 5MB.", {
            position: "top-right",
            duration: 10000,
        });
        return;
    }

    const img = new Image();
    img.onload = () => {
        if (img.width < 350 || img.height < 350) {
            toast.error("As dimensões da imagem devem ser no mínimo 350x350px.", {
                position: "top-right",
                duration: 10000,
            });
        } else {
            const reader = new FileReader();
            reader.onload = (e) => {
                imageUrl.value = e.target.result;
            };
            reader.readAsDataURL(file);
            form[key] = [file];
            form[key + "_name"] = file.name;
        }
    };

    img.onerror = () => {
        toast.error("A imagem deve ser do tipo PNG, JPG ou JPEG.", {
            position: "top-right",
            duration: 10000,
        });
    };

    img.src = URL.createObjectURL(file);
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
    const croppedCanvas = cropper.value.getCroppedCanvas();

    if (croppedCanvas.width < 350 || croppedCanvas.height < 350) {
        toast.error("As dimensões da imagem recortada devem ser no mínimo 350x350px.", {
            position: "top-right",
            duration: 10000,
        });
        return;
    }

    image.value = croppedCanvas.toDataURL();
    const dataURL = croppedCanvas.toDataURL();
    const filename = form.photo_name;
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

const imageWidth = ref(0);
const imageHeight = ref(0);

const onImageLoad = (event) => {
    imageWidth.value = event.target.naturalWidth;
    imageHeight.value = event.target.naturalHeight;
};

const imageFilter = ref('filter-original');

const handleFilterChange = (newFilter) => {
    imageFilter.value = newFilter;
};

const cancel = () => {
    closeCreatePostModal();
    form.photo = "";
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

watch(imageFilter, (newValue) => {
    form.filter = newValue;
});

const form = useForm('post', route('welcome'), {
    photo: "",
    image: "",
    comment: "",
    filter: ""
});

const createPost = () => form.submit({
    headers: {
        "Content-Type": "multipart/form-data",
    },
    preserveScroll: true,
    onSuccess: (page) => {
        // console.log(page);
        const success = page.props.success;
        posts.value = page.props.posts;
        // console.log(success);
        // console.log(posts)
        if (success) {
            toast.success(success, {
                position: "top-right",
                duration: 5000,
            });
        }

        closeCreatePostModal();
        step.value = 1;

        form.photo = "";
        form.image = null;
        form.comment = "";
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

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

        <div class="hidden lg:block fixed sm:top-0 sm:end-0 p-6 text-end z-10">
            <button @click="openCreatePostModal"
                class="flex items-center justify-evenly gap-4 bg-blue-500 p-4 text-white rounded-xl" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span class="font-bold text-2xl">Publicar</span>
            </button>
        </div>

        <div class="hidden lg:block fixed sm:bottom-0 sm:end-0 p-6 text-end z-10">
            <button @click="scrollToTop"
                class="flex items-center justify-evenly gap-4 bg-blue-500 p-4 text-white rounded-xl" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

            </button>
        </div>

        <div class="hidden lg:block fixed sm:bottom-0 sm:start-0 p-6 text-end z-10">
            <Link :href="route('logout')" method="post" as="button"
                class="p-4 bg-red-500 flex flex-col items-center justify-center rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white"
                class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
            </svg>
            <span class="font-bold text-lg text-white">Sair</span>
            </Link>
        </div>

        <div
            class="fixed lg:hidden z-50 w-full h-16 max-w-lg -translate-x-1/2 bg-white border border-gray-200 bottom-0 left-1/2 dark:bg-gray-700 dark:border-gray-600">

            <div class="flex items-center justify-around h-full w-full">

                <Link :href="route('logout')" method="post" as="button"
                    class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                </svg>
                </Link>

                <button type="button" @click="openCreatePostModal"
                    class="inline-flex items-center justify-center w-10 h-10 font-medium bg-blue-600 rounded-full hover:bg-blue-700 group focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6 lg:p-8 flex items-center justify-center flex-col gap-8">
            <div v-for="post in posts.data" :key="post.id"
                class="flex justify-center flex-col mx-auto max-w-md border-b-2 border-gray-300 pb-4">
                <div class="flex flex-col lg:flex-row justify-between">
                    <div class="flex gap-1">
                        <h1 class="font-bold text-gray-900 text-left">{{ post.user.name }}</h1>
                        <h2>{{ dateStringToTimeAgo(post.created_at) }}</h2>
                    </div>
                    <h3>{{ moment(post.created_at).format("DD/MM/YYYY [às] HH:mm") }}</h3>
                </div>
                <img v-if="post.image_path" v-lazy="'../storage/' + post.image_path" :class="post.image_filter"
                    class="max-h-[30rem] lg:w-[30rem] mx-auto bg-cover w-full" />
                <h2 class="text-left max-w-md pt-2">{{ post.comment }}</h2>
            </div>

        </div>
    </div>

    <Modal :show="showCreatePostModal" @close="closeCreatePostModal" class="min-h-screen"
        :maxWidth="(form.photo.length != 0 && image && step === 2) ? '5xl' : (image && step === 1) ? '6xl' : (form.photo.length !== 0 && !image ? '4xl' : '3xl')">
        <form @submit.prevent="createPost">
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
                <div class="flex flex-col justify-center items-center gap-y-12 my-20" v-if="form.photo.length === 0">
                    <UploadFileSvg />
                    <label for="dropzone-file-photo">
                        <div
                            class="flex justify-evenly items-center gap-2 bg-blue-500 px-6 py-3 text-white font-bold text-xs rounded-lg uppercase shadow-all hover:cursor-pointer">

                            <span>Selecionar do computador</span>
                        </div>
                        <input id="dropzone-file-photo" class="hidden" type="file" @change="onFileSelected('photo', $event)"
                            accept=".png, .jpeg, .jpg" />
                    </label>

                </div>

                <div v-else>
                    <div v-if="form.photo.length != 0 && !image"
                        class="relative flex flex-col lg:flex-row lg: items-center justify-between">
                        <div class="max-w-2xl flex items-center justify-center w-full">
                            <vue-cropper ref="cropper" v-if="imageUrl" :src="imageUrl" alt="Imagem" preview=".preview"
                                :aspect-ratio="selectedAspectRatio" :viewMode="1" :zoomOnWheel="zoomOnWheel"
                                :key="componentKey" class="min-w-[10rem] min-h-[10rem]" />
                            <button @click="togglePopover" type="button" class="hidden lg:block absolute bottom-2 left-2">
                                <div v-if="isPopoverOpen" class="p-2 bg-gray-900 rounded-full">
                                    <XMark />
                                </div>
                                <div v-else class="p-2 bg-gray-900 rounded-full">
                                    <Bars />
                                </div>
                            </button>

                            <button @click="togglePopover" type="button"
                                class="hidden lg:block lg:absolute bottom-2 left-2">
                                <div v-if="isPopoverOpen" class="p-2 bg-gray-900 rounded-full">
                                    <XMark />
                                </div>
                                <div v-else class="p-2 bg-gray-900 rounded-full">
                                    <Bars />
                                </div>
                            </button>

                            <div class="absolute bottom-16 lg:left-2 flex flex-col justify-content-between rounded-lg"
                                v-show="isPopoverOpen" ref="popover" style="background-color: rgba(48, 49, 53, 0.7)">
                                <h1 class="font-bold text-white border-b border-gray-900 pt-2 px-2 pb-2 text-center">
                                    Proporção
                                </h1>

                                <input type="radio" id="aspect-null" value="" class="hidden peer"
                                    v-model.number="selectedAspectRatio">
                                <label for="aspect-null" class="border-b border-gray-900 py-4 px-2 hover:cursor-pointer">
                                    <div class="flex items-center gap-8 w-full">
                                        <div class="font-black" :class="{
                                            'text-white text-xl': selectedAspectRatio === '',
                                            'text-gray-300 text-lg': selectedAspectRatio !== ''
                                        }">Original</div>
                                        <div class="border-2 border-gray-900 p-3 rounded-md"
                                            :class="{ 'bg-white': selectedAspectRatio === '' || selectedAspectRatio === null }">
                                        </div>
                                    </div>
                                </label>

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

                        <div class="flex lg:pt-6 gap-4 p-4">
                            <div class="grid grid-cols-2 lg:flex lg:flex-col gap-4">
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

                                <button @click="togglePopover" type="button"
                                    class="lg:hidden flex items-center justify-center">
                                    <div v-if="isPopoverOpen" class="p-2 bg-gray-900 rounded-full">
                                        <XMark />
                                    </div>
                                    <div v-else class="p-2 bg-gray-900 rounded-full">
                                        <Bars />
                                    </div>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div v-if="image && step === 1" class="flex flex-col lg:flex-row justify-between w-full">
                        <div class="rounded-2xl shadow-all lg:max-w-3xl flex flex-col items-center justify-center w-full">
                            <img :src="image" :class="imageFilter" alt="Imagem recortada" @load="onImageLoad" />
                            <div v-if="imageWidth && imageHeight" class="text-md font-medium mt-2 text-center">
                                Dimensões: <span class="text-lg font-bold text-black">{{ imageWidth }}</span> x <span
                                    class="text-lg font-bold text-black">{{
                                        imageHeight }}</span> pixels
                            </div>
                        </div>
                        <div>
                            <h1 class="text-center mt-2 font-bold text-xl">Filtros</h1>
                            <div
                                class="grid grid-cols-4 lg:grid-cols-3 gap-4 p-4 max-h-[30rem] lg:max-h-[40rem] overflow-y-auto">

                                <Filters :image="image" @filter-changed="handleFilterChange" />

                            </div>
                        </div>

                    </div>

                </div>

                <div v-if="form.photo.length != 0 && image && step === 2" class="flex flex-col lg:flex-row ">
                    <div class="rounded-2xl shadow-all lg:max-w-2xl" :class="{
                        'flex flex-col items-center justify-center w-full': imageWidth < 700
                    }">
                        <img :src="image" :class="imageFilter" alt="Imagem recortada" />
                    </div>

                    <div class="w-full lg:max-w-sm p-2">
                        <div class="relative">
                            <label for="comment"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Escreva
                                uma mensagem</label>
                            <textarea id="comment" rows="10" v-model="form.comment" @change="form.validate('comment')"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="O que você está pensando?"
                                :class="{ 'border-red-500 focus:ring-red-500 focus:border-red-500': form.comment.length > 200 }"></textarea>
                            <span class="absolute bottom-0 right-6">{{ form.comment.length }}/200</span>
                        </div>
                        <div v-if="form.invalid('comment')" class="text-red-500 font-medium">
                            {{ form.errors.comment }}
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
                    <button type="button" class="bg-red-500 px-4 py-2 text-white rounded-lg">Voltar</button>
                </div>
                <button v-if="form.photo.length != 0 && !image && step === 1" type="button" @click="cropImage"
                    class="bg-blue-500 rounded-md text-white py-2 px-4">
                    <span>Avançar</span>
                </button>
                <button type="button" v-if="image && step === 1" @click="step++"
                    class="bg-blue-500 rounded-md text-white py-2 px-4">Avançar</button>
                <button type="button" v-if="image && step === 2" @click="step--"
                    class="bg-red-500 px-4 py-2 text-white rounded-lg">Voltar</button>
                <button type="submit" v-if="image && step === 2" class="bg-green-500 rounded-md text-white py-2 px-4"
                    :disabled="disabledButton || !image || form.comment.length === 0 || form.comment.length > 200" :class="{
                        'opacity-50 cursor-not-allowed': disabledButton || !image || form.comment.length === 0 || form.comment.length > 200
                    }">
                    Salvar
                </button>
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
