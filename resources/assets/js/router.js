module.exports = {
    routes: [
        { path: '/', component: require('./components/BusinessLocationsList.vue') },
        { path: '/add', component: require('./components/AddLocation.vue') },
        { path: '/edit/:id', component: require('./components/EditLocation.vue') },


    ]
};