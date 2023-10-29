<template>
    <li class="flex items-center pb-1">
        <div class="h-6 w-6 text-green-500 mr-2">
            <CheckCircleIcon class="h-6 w-6" />
        </div>
        <span class="text-white text-sm">
            {{ author.author }}
        </span>
    </li>
</template>

<script>

    import { CheckCircleIcon } from "@heroicons/vue/24/solid/index.js";

    export default {
        
        name: 'approve',
        components: {CheckCircleIcon},
        
        props: {
            author: {
                type: Object,
                default: {}
            }
        }
        
    }

</script>