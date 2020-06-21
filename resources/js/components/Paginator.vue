<template>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between" v-if="hasPages">
        <div class="flex justify-between flex-1 sm:hidden">
            <span v-if="onFirstPage" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                &laquo; Previous
            </span>
            <a v-else :href="prevUrl" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                &laquo; Previous
            </a>

            <a v-if="hasMorePages" :href="nextUrl" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                Next &raquo;
            </a>
            <span v-else class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                Next &raquo;
            </span>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    Showing
                    <span class="font-medium">{{ dataSet.from }}</span>
                    to
                    <span class="font-medium">{{ dataSet.to }}</span>
                    of
                    <span class="font-medium">{{ dataSet.total }}</span>
                    results
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm">
                    <span v-if="onFirstPage" aria-disabled="true" aria-label="&laquo; Previous">
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                    <a v-else :href="prevUrl" @click.prevent="page--" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="&laquo; Previous">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                        <span aria-current="page" v-if="page == 1">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">1</span>
                        </span>
                        <a v-else :href="dataSet.first_page_url" @click.prevent="page = 1" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="first page">
                            1
                        </a>

                        <div v-if="dataSet.last_page > 2">
                            <a v-if="page == 1" href="#" @click.prevent="page = 2" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="second page">
                                {{ page + 1 }}
                            </a>

                            <a v-else-if="page == dataSet.last_page" href="#" @click.prevent="page = dataSet.last_page - 1" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="page before the last one">
                                {{ page - 1 }}
                            </a>

                            <span v-else aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">{{ page }}</span>
                            </span>
                        </div>


                        <span aria-current="page" v-if="page == dataSet.last_page">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">{{ dataSet.last_page }}</span>
                        </span>
                        <a v-else :href="dataSet.last_page_url" @click.prevent="page = dataSet.last_page" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="last page">
                            {{ dataSet.last_page }}
                        </a>

                    <a v-if="hasMorePages" :href="nextUrl" @click.prevent="page++" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next &raquo;">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <span v-else aria-disabled="true" aria-label="Next &raquo;">
                        <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                </span>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        props: ['dataSet'],
        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
                lastPage: false,
            }
        },
        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.lastPage = this.dataSet.last_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },
            page() {
                this.broadcast().updateUrl();
            }
        },
        computed: {
            hasPages() {
                return this.page != 1 || this.page < this.lastPage;
            },
            onFirstPage() {
                return this.page == 1;
            },
            hasMorePages() {
                return this.page < this.lastPage;
            }
        },
        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },
            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>

<style scoped>

</style>
