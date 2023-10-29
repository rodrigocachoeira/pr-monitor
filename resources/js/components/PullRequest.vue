<template>
    <li v-if="pullRequest != null" >
        <div class="col-span-2" >
            <img class="w-12 pt-2 rounded-full" :src="pullRequest.author.avatar" alt="">
        </div>
        <div class="col-span-6 flex items-center h-full" >
            <div class="flex-grow" >
                <strong class="text-white cursor-pointer" >
                    <a href="">{{ pullRequest.task }}</a>
                </strong>
                <div class="break-after-all" ></div>
                <span class="text-gray-400 text-sm w-80" >
                    {{ taskDescription(pullRequest.task, pullRequest.title) }}
                </span>
            </div>
            <div class="flex-grow text-right" >
                <span class="text-gray-400" >
                    {{ pullRequest.publishedAt }}
                </span>
            </div>
        </div>
        <div class="col-span-8 flex" >            
            <div class="flex-grow pt-2">
                <span :class="repositoryTag(pullRequest.repository)" class="mr-2 text-xs text-white rounded-md p-1" >
                    {{ pullRequest.repository }}
                </span>
            </div>
            <div class="flex-grow">
                <MinusIcon v-if="pullRequest.showDetails" @click="showDetails" class="h-6 w-6 text-white float-right cursor-pointer" />
                <ChevronDoubleDownIcon v-else @click="showDetails" class="h-6 w-6 text-white float-right cursor-pointer" />
            </div>
        </div>
        <div 
            v-show="pullRequest.showDetails"
            class="flex pt-5 transition-opacity duration-500"
        >
            <div class="flex-grow">
                <h1 class="text-gray-300 text-left text-sm mb-2" >Necessary Approve</h1>
                <ul class="text-right">
                    <NecessaryApprove team="Back End" :status="false" />
                    <NecessaryApprove team="Front End" :status="true" />
                    <NecessaryApprove team="Infrastructure" :status="true" />
                </ul>
            </div>
            <div class="flex-grow">
                <h1 class="text-gray-300 text-left text-sm mb-2" >All Approves</h1>
                <ul class="text-right">
                    <Approve
                        :author="author"
                        :key="author.author"
                        v-for="author in pullRequest.approves"
                    />
                </ul>
            </div>
        </div>
    </li>
</template>

<script>

import { ChevronDoubleDownIcon, MinusIcon } from '@heroicons/vue/24/solid'
import Approve from "./Approve.vue";
import NecessaryApprove from "./NecessaryApprove.vue";

export default {
    name: 'pull-request',
    
    components: {
        NecessaryApprove,
        Approve,
        ChevronDoubleDownIcon,
        MinusIcon
    },
    
    props: {
        pullRequest: {
            type: Object,
            default: null
        }
    },
    
    mounted () {
    },
    
    data () {
        return {
            tags: [
                {
                    repository: 'fm-site-br',
                    color: 'bg-green-600'
                },
                {
                    repository: 'service-facial-auth-api',
                    color: 'bg-blue-600'
                }
            ]
        }
    },

    methods: {

        showDetails() {
            this.pullRequest.showDetails = ! this.pullRequest.showDetails;
        },

        repositoryTag(repositoryName) {
            const repository = this.tags.filter(tag => {
                return tag.repository === repositoryName;
            });


            return repository.pop().color;
        },
        
        taskDescription(task, title) {
            const description = title.replace(task + ' -', '');
            const maxSize = 40;
            
            if (description.length <= maxSize) {
                return description;
            }
            
            return description.substring(0, maxSize) + '...';
        }

    }
    
};
</script>