<template>
    <loading-view :loading="initialLoading">
        <loading-card :loading="false" class="flex flex-wrap py-8 mb-8 text-center">
            <div class="w-1/2">
                <div>
                    <p class="text-2xl text-sm uppercase mb-2 text-80">
                        Total Campaigns
                    </p>
                </div>
            </div>
            <div class="w-1/2">
                <div>
                    <p class="text-2xl">
                        {{total_items}}
                    </p>
                </div>
            </div>
        </loading-card>
        <loading-card :loading="loadingTable" class="card relative">
            <table
                v-if="items.length > 0"
                class="table w-full"
                cellpadding="0"
                cellspacing="0"
                data-testid="resource-table"
            >
                <thead>
                <tr>
                    <th class="text-left">
                      <span class="inline-flex items-center">
                         ID
                      </span>
                    </th>
                    <th class="text-left">
                      <span class="inline-flex items-center">
                         Title
                      </span>
                    </th>
                    <th class="text-left">
                      <span class="inline-flex items-center">
                         emails_sent
                      </span>
                    </th>
                    <th class="text-left">
                      <span class="inline-flex items-center">
                         Creation Date
                      </span>
                    </th>
                    <th class="text-left">
                      <span class="inline-flex items-center">
                         Send Time
                      </span>
                    </th>
                    <th>&nbsp;<!-- View --></th>
                </tr>
                </thead>
                <tbody v-for="campaign in items">
                <tr>
                    <td>{{ campaign.id }}</td>
                    <td>{{ campaign.settings.title }}</td>
                    <td>{{ campaign.emails_sent }}</td>
                    <td>
                        <index-date
                            :field="{format:'YYYY/MM/DD h:mm a', value: campaign.create_time}"></index-date>
                    </td>
                    <td>
                        <index-date
                            :field="{format:'YYYY/MM/DD h:mm a', value: campaign.send_time}"></index-date>
                    </td>
                    <td>
                        <span>
                            <router-link
                                class="cursor-pointer text-70 hover:text-primary mr-3"
                                :to="{ name: 'mailchimp-campaign-details', params: {
                                        campaignId: campaign.id
                                    }}"
                                :title="__('View')"
                            >
                                <icon type="view" width="22" height="18" view-box="0 0 22 16"/>
                            </router-link>
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination
                :items="this.items"
                :hasMore="next_page"
                :hasPrevious="last_page"
                @previous="previousPage"
                @next="nextPage"
            ></pagination>
        </loading-card>
    </loading-view>
</template>

<script>
    export default {
        components: {
            'pagination': require('../common/paging')
        },
        data() {
            return {
                items: {},
                total_items: 0,
                initialLoading: true,
                loadingTable: true,
                next_page: 0,
                last_page: 0
            }
        },
        methods: {
            getList(params) {
                Nova.request().get('/nova-vendor/nova-mailchimp/campaigns', {params})
                    .then((response) => {
                        this.items = response.data.data.campaigns;
                        this.total_items = response.data.data.total_items;
                        this.initialLoading = false;
                        this.loadingTable = false;
                        this.next_page = response.data.paging.next_page;
                        this.last_page = response.data.paging.last_page;
                    })
            }
            ,
            nextPage() {
                if (this.next_page) {
                    this.loadingTable = true;
                    this.getList({'page': this.next_page});
                }
            },
            previousPage() {
                if (this.last_page) {
                    this.loadingTable = true;
                    this.getList({'page': this.last_page});
                }
            }
        },
        created() {
            this.getList()
        },
    }
</script>
