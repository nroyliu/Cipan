var app = new Vue({
    el: "#app",
    data() {
        return {
            data: []
        }
    },
    mounted() {
        this.fetch();
    },
    methods: {
        fetch () {
            axios.post('/member/account/types',)
                .then(function (response) {
                    app.data = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
})