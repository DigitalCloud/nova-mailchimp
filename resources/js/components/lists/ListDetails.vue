<template>
    <loading-view :loading="initialLoading">
        <loading-card :loading="false" class="mb-6 py-3 px-6">
            <div>
                <div class="flex items-center mb-3">
                    <h4 class="text-90 font-normal text-2xl  w-full flex ">List Details</h4>
                </div>
                <div class="ml-3 w-full items-center">
                    <detail-text-field :field="{name: 'ID', value: list.id}"></detail-text-field>
                    <detail-text-field :field="{name: 'Name', value: list.name}"></detail-text-field>
                    <detail-date
                        :field="{name: 'Creation Date', format:'YYYY/MM/DD h:mm a', value: list.date_created}"></detail-date>
                    <detail-text-field
                        :field="{name: 'Members Count', value: list.stats.member_count}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Unsubscribe Count', value: list.stats.unsubscribe_count}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Cleaned Count', value: list.stats.cleaned_count}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Campaign Count', value: list.stats.campaign_count}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Open Rate', value: list.stats.open_rate?list.stats.open_rate.toFixed(2):''}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Click Rate', value: list.stats.click_rate?list.stats.click_rate.toFixed(2):''}"></detail-text-field>
                </div>
            </div>
        </loading-card>
        <loading-card :loading="loadingTable" class="mb-6 py-3 px-6">
            <div>
                <div class="flex items-center mb-3">
                    <h4 class="text-90 font-normal text-2xl  w-full flex ">List Members</h4>
                </div>
                <div class="ml-3 w-full flex items-center">
                    <table
                        v-if="members.length > 0"
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
                         Email
                      </span>
                            </th>
                            <th class="text-left">
                      <span class="inline-flex items-center">
                         Name
                      </span>
                            </th>
                            <th class="text-left">
                      <span class="inline-flex items-center">
                         Status
                      </span>
                            </th>
                            <th class="text-left">
                      <span class="inline-flex items-center">
                        Last Change
                      </span>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-for="member in members">
                        <tr>
                            <td>{{ member.id }}</td>
                            <td>{{ member.email_address }}</td>
                            <td>{{ (member.merge_fields.FNAME+member.merge_fields.LNAME)? member.merge_fields.FNAME
                                +''+member.merge_fields.LNAME : '---'}}
                            </td>
                            <td>
                                {{member.status}}
                            </td>
                            <td>
                                <index-date
                                    :field="{format:'YYYY/MM/DD h:mm a', value: member.last_changed}"></index-date>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <pagination
                    :items="members"
                    :hasMore="next_page"
                    :hasPrevious="last_page"
                    @previous="previousPage"
                    @next="nextPage"
                ></pagination>
            </div>
        </loading-card>
    </loading-view>
</template>
<script>
    export default {
        props: ['listId'],
        components: {
            'pagination': require('../common/paging')
        },
        data() {
            return {
                initialLoading: true,
                loadingTable: true,
                members: {},
                list: {
                    stats: {},
                },
                next_page: 0,
                last_page: 0
            }
        },
        methods: {
            getList(params) {
                Nova.request().get('/nova-vendor/nova-mailchimp/lists/' + this.listId, {params})
                    .then((response) => {
                        this.list = response.data.data.list;
                        this.members = response.data.data.members;
                        this.initialLoading = false;
                        this.loadingTable = false;
                        this.next_page = response.data.paging.next_page;
                        this.last_page = response.data.paging.last_page;
                    })
            },
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
        }
    }
</script>
