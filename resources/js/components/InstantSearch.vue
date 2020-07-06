<template>
    <ais-instant-search index-name="threads" :search-client="searchClient" :routing="routing">
        <ais-configure :hitsPerPage="8" :attributesToSnippet="['body:40']" :attributesToHighlight="['title']"/>
        <div class="left-panel">
            <h2 class="font-header font-semibold text-xl text-gray-700 mb-2 tracking-widest">Channels</h2>
            <ais-refinement-list attribute="channel.name" :limit="100"
                     :class-names="{
                    'ais-RefinementList': 'bg-white bg-opacity-25',
                    // ...
                  }"
            />
            <ais-clear-refinements class="mt-2"/>
        </div>
        <div class="right-panel">
            <ais-search-box
                placeholder="Search here..."
                :autofocus="true"
                :show-loading-indicator="true"
                class="mb-2"
            />
            <ais-hits>
                <ul slot-scope="{ items }">
                    <li v-for="item in items" :key="item.objectID">
                        <div class="rounded-lg p-2 pb-0 border border-gray-300 bg-white mb-2 transition duration-500 ease-in-out transform hover:scale-105">
                            <a :href="item.link">
                                <div class="hit-title">
                                    <ais-highlight attribute="title" :hit="item"></ais-highlight>
                                </div>
                                <div class="hit-body">
                                    <ais-snippet attribute="body" :hit="item"></ais-snippet>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
            </ais-hits>
            <ais-pagination :class-names="{
                'ais-Pagination-item': 'bg-white',
                // ...
              }"
            />
        </div>
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';
    import 'instantsearch.css/themes/algolia-min.css';
    import { history } from 'instantsearch.js/es/lib/routers';
    import { simple } from 'instantsearch.js/es/lib/stateMappings';

    export default {
        data() {
            return {
                searchClient: algoliasearch(
                    process.env.MIX_ALGOLIA_APP_ID,
                    process.env.MIX_ALGOLIA_PUBLIC_KEY
                ),
                routing: {
                    router: history(),
                    stateMapping: simple(),
                },
            };
        }
    };
</script>

<style>
    .ais-Hits-list {
        margin-top: 0;
        margin-bottom: 1em;
    }

    .ais-InstantSearch {
        display: grid;
        grid-template-columns: 1fr 4fr;
        grid-gap: 1em;
    }

    .ais-Hits-item {
        @apply rounded-lg bg-white;
    }
    .hit-title {
        margin-bottom: 0.5em;
    }
    .hit-body {
        color: #888;
        margin-bottom: 0.5em;
    }
</style>
