var app = new Vue({
        el: "#app",
        data() {
            return {
                form: null,
                visible: false,
                collapsed: false,
                current: {
                    page: "/member/account/home",
                },
                logout:{
                    ModalText: '确实要退出登录？',
                    visible: false,
                    confirmLoading: false,
                },
                filters: ""
            }
        },
        //初始化
        mounted() {
            this.form = this.$form.createForm(this),
                this.get(),
                this.openNotification();
        },
        //方法
        methods: {
            switch_page(page) {
                this.current.page = page;
            },
            showModal () {
                this.visible = true;
            },
            handleCancel  () {
                this.visible = false;
            },
            handleCreate  () {
                this.form.validateFields((err, values) => {
                    if (!err) {
                        axios.post("/member/manage/add",values).then(function (response) {
                            if (response.status){
                                app.$message.loading('保存中..', 1)
                                    .then(() => app.$message.success(response.data.message, 2.5));
                            }else{
                                app.$message.loading('保存中..', 1)
                                    .then(() => app.$message.info(response.data.message, 2.5))
                            }
                        }).catch(
                            app.$message.loading('保存中..', 1)
                                .then(() => app.$message.info(response.data.message, 2.5))
                        )
                        app.form.resetFields();
                        app.visible = false;
                    }
                });
            },
            get() {
                axios.post("/member/account/gettype").then(function (response) {
                    if (response.status){
                        app.filters = response.data;
                    }
                }).catch()
            },
            openNotification () {
                this.$notification.open({
                    message: '词盘：欢迎回来',
                    description: '上次登陆：2019-8-8 23:55:05',
                    onClick: () => {
                        console.log('Notification Clicked!');
                    },
                });
            },
            logoutShowModal() {
                this.logout.visible = true
            },
            logoutOk(e) {
                axios.post("/member/account/logout").then(function (response) {
                    if (response.status){
                        app.$message.loading('退出登录中..', 1)
                            .then(() => app.$message.success('退出登录成功..', 2.5));
                        app.logout.confirmLoading = true;
                    }
                })
                setTimeout(() => {
                    this.logout.visible = false;
                    this.logout.confirmLoading = false;
                    window.location.href = "/";
                }, 3000);
            },
            logoutCancel(e) {
                console.log('Clicked cancel button');
                this.logout.visible = false
            },
        },
    })