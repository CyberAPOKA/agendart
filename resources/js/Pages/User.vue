<script setup>

const props = defineProps({
    user: Object
});

const posts = ref(props.user.posts);
</script>

<template>
    <div>
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
</template>