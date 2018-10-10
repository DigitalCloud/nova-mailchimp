Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'mailchimp-lists',
            path: '/mailchimp/lists',
            component: require('./components/lists/Lists'),
        },
        {
            name: 'mailchimp-campaigns',
            path: '/mailchimp/campaigns',
            component: require('./components/campaigns/Campaigns'),
        },
        {
            name: 'mailchimp-list-details',
            path: '/mailchimp/list/:listId',
            component: require('./components/lists/ListDetails'),
            props: true,
        },
        {
            name: 'mailchimp-campaign-details',
            path: '/mailchimp/campaign/:campaignId',
            component: require('./components/campaigns/CampaignDetails'),
            props: true,
        },
        {
            name: 'mailchimp-reports',
            path: '/mailchimp/reports',
            component: require('./components/lists/Lists'),
        },
    ])
});
