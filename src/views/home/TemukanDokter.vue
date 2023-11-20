<template>
    <div class="card">
        <div class="card-body my-3 mx-4">
            <form action="">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="search_dokter_label">
                            <strong>Temukan Dokter yang Tepat</strong>
                            <p>
                                Cari dan temukan dokter yang tepat untuk kebutuhan medis anda, dan buat janji dengan langkah
                                mudah
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group mb-2">
                            <Multiselect v-model="selectedCountries" id="ajax" label="name" track-by="code"
                                placeholder="Type to search" open-direction="bottom" :options="countries" :multiple="true"
                                :searchable="true" :loading="isLoading" :internal-search="false" :clear-on-select="false"
                                :close-on-select="false" :options-limit="300" :limit="3" :limit-text="limitText"
                                :max-height="600" :show-no-results="false" :hide-selected="true" @search-change="asyncFind">
                                <template slot="tag" slot-scope="{ option, remove }"><span class="custom__tag"><span>{{
                                    option.name }}</span><span class="custom__remove"
                                            @click="remove(option)">❌</span></span></template>
                                <template slot="clear" slot-scope="props">
                                    <div class="multiselect__clear" v-if="selectedCountries.length"
                                        @mousedown.prevent.stop="clearAll(props.search)"></div>
                                </template><span slot="noResult">Oops! No elements found. Consider changing the search
                                    query.</span>
                            </Multiselect>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-2">
                            <button type="submit" class="btn w-100 btn-search-dokter">
                                Search
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>

export default {
    name: 'TemukanDokter',
    data() {
        return {
            selectedCountries: [],
            countries: [],
            isLoading: false,
            selected: '',
            options: [
                { name: 'Vue.js', language: 'JavaScript' },
                { name: 'Rails', language: 'Ruby' },
                { name: 'Sinatra', language: 'Ruby' },
                { name: 'Laravel', language: 'PHP' },
                { name: 'Phoenix', language: 'Elixir' }
            ]
        }
    },
    methods: {
        limitText(count) {
            return `and ${count} other countries`
        },
        asyncFind(query) {
            this.isLoading = true
            ajaxFindCountry(query).then(response => {
                this.countries = response
                this.isLoading = false
            })
        },
        clearAll() {
            this.selectedCountries = []
        }
    }
}
</script>