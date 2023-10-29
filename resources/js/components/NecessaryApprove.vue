<template>
    <li class="flex items-center w-60 pb-1">
        <div v-if="status" class="h-6 w-6 text-green-500 mr-2">
            <CheckCircleIcon class="h-6 w-6" />
        </div>
        <div v-else class="h-6 w-6 text-gray-500 mr-2">
            <CheckCircleIcon class="h-6 w-6" />
        </div>
        <span class="text-white text-sm">
            {{ team }}
        </span>
    </li>
</template>

<script>

import {CheckCircleIcon} from "@heroicons/vue/24/solid/index.js";

export default {

    name: 'necessary-approve',
    components: {CheckCircleIcon},

    props: {
        team: {
            type: String,
            default: ""
        },
        status: {
            type: Boolean,
            default: false
        }
    }

}

</script>