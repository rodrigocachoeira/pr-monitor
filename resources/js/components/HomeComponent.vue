<template>
    <main class="w-full max-w-2xl mx-auto pl-10 pr-10 pt-4" >
        
        <h1 class="text-white text-center text-xl mb-2" >Pending PRs</h1>
        
        <section class="w-full text-right" >
            <button disabled v-if="loading" class="bg-purple-900 hover:bg-purple-700 text-white text-sm py-1 px-3 rounded opacity-50 cursor-not-allowed">
                Syncing ...
            </button>

            <button v-else @click="getPullRequests()" class="bg-purple-900 text-sm hover:bg-purple-700 text-white py-1 px-3 rounded">
                Sync
            </button>
        </section>

        <div v-if="loading" class="min-h-screen flex items-center justify-center">
            <div class="w-16 h-16 border-t-4 border-blue-500 border-right-transparent border-bottom-transparent border-left-transparent border-solid rounded-full animate-spin"></div>
        </div>
        
        <ul class="pull-requests" v-else v-if="pullRequests.length > 0" >
            <PullRequest
                v-for="pullRequest in pullRequests" 
                :key="pullRequest.title" 
                :pull-request="pullRequest"
                class="grid grid-cols-8 mt-5"
            >
            </PullRequest>
        </ul>

    </main>
</template>
<script>
    import PullRequest from "./PullRequest.vue";

    export default {
        name: 'home-component',
        
        components: { PullRequest },
        
        async mounted () {
            await this.getPullRequests();
        },
        
        data () {
            return {
                loading: false,
                pullRequests: []
            }
        },
        
        methods: {
            
            async getPullRequests() {
                this.loading = true;
                
                try {
                    let res = await axios.get('/api/pull-requests');

                    if (res.status !== 200) {
                        return;
                    }

                    this.pullRequests = res.data.pullRequests.map((p) => {
                        p.showDetails = false;
                        
                        return p;
                    });
                } catch (e) {
                    console.error(e);
                } finally {
                    this.loading = false;
                }
            }
            
        }
        
    }
    
</script>