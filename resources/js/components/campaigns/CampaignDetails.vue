<template>
    <loading-view :loading="initialLoading">
        <loading-card :loading="false" class="mb-6 py-3 px-6">
            <div>
                <div class="flex items-center mb-3">
                    <h4 class="text-90 font-normal text-2xl  w-full flex ">Campaign Details</h4>
                </div>
                <div class="ml-3 w-full items-center">
                    <detail-text-field :field="{name: 'ID', value: campaign.id}"></detail-text-field>
                    <detail-text-field :field="{name: 'Title', value: campaign.settings.title}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Recipient List', value: campaign.recipients.list_name}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Recipient Count', value: campaign.recipients.recipient_count}"></detail-text-field>
                    <detail-date
                        :field="{name: 'Creation Date', format:'YYYY/MM/DD h:mm a', value: campaign.create_time}"></detail-date>
                    <detail-date
                        :field="{name: 'Send Time', format:'YYYY/MM/DD h:mm a', value: campaign.send_time}"></detail-date>
                </div>
            </div>
        </loading-card>

        <loading-card :loading="false" class="mb-6 py-3 px-6">
            <div>
                <div class="flex items-center mb-3">
                    <h4 class="text-90 font-normal text-2xl  w-full flex ">Campaign Summery</h4>
                </div>
                <div class="ml-3 w-full items-center">
                    <detail-text-field
                        :field="{name: 'Opens', value: campaign.report_summary.opens}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Unique Opens', value: campaign.report_summary.unique_opens}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Open Rate', value: campaign.report_summary.open_rate?campaign.report_summary.open_rate.toFixed(2):''}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Clicks', value: campaign.report_summary.clicks}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Click Rate', value: campaign.report_summary.click_rate?campaign.report_summary.click_rate.toFixed(2):''}"></detail-text-field>
                    <detail-text-field
                        :field="{name: 'Subscriber Clicks', value: campaign.report_summary.subscriber_clicks}"></detail-text-field>
                </div>
            </div>
        </loading-card>
    </loading-view>
</template>
<script>
    export default {
        props: ['campaignId'],
        data() {
            return {
                initialLoading: true,
                campaign: {
                    settings: {},
                    recipients: {},
                    report_summary: {}
                }
            }
        },
        computed: {},
        methods: {
            getList() {
                Nova.request().get('/nova-vendor/nova-mailchimp/campaigns/' + this.campaignId)
                    .then((response) => {
                        this.campaign = response.data.data;
                        this.initialLoading = false
                    })
            }
        },
        created() {
            this.getList()
        }
    }
</script>
