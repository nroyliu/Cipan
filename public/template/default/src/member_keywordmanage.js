const columns = [{
    title: '关键词',
    dataIndex: 'name',
    width: '25%',
    scopedSlots: { customRender: 'name' },
}, {
    title: '分类',
    dataIndex: 'type',
    width: '15%',
    scopedSlots: { customRender: 'type' },
}, {
    title: '描述',
    dataIndex: 'description',
    width: '40%',
    scopedSlots: { customRender: 'description' },
}, {
    title: '操作',
    dataIndex: 'operation',
    scopedSlots: { customRender: 'operation' },
}]
const data = []

var app = new Vue({
    el: "#app",
    data() {
        this.cacheData = data.map(item => ({ ...item }))
        return {
            data,
            columns,
            filters:""
        }
    },
    //初始化
    mounted() {
        this.get()
    },
    //方法
    methods: {
        handleChange (value, key, column) {
            const newData = [...this.data]
            const target = newData.filter(item => key === item.id)[0]
            if (target) {
                target[column] = value
                this.data = newData
            }
        },
        selectChange (event, key, column){
            console.log(typeof event)
            const newData = [...this.data]
            const target = newData.filter(item => key === item.id)[0]
            if (target) {
                target[column] = event
                this.data = newData
            }
        },
        edit (key) {
            console.log("edit:"+key);
            const newData = [...this.data]
            const target = newData.filter(item => key === item.id)[0]
            if (target) {
                target.editable = true
                this.data = newData
            }
        },
        save (key) {
            const newData = [...this.data]
            console.log(newData);
            const target = newData.filter(item => key === item.id)[0]
            console.log(target)
            axios.post("/member/manage/update",{...target}).then(function (response) {
                if (response.status){
                    if (response.data.status){
                        app.$message.loading('保存中..', 0.5)
                            .then(() => app.$message.success(response.data.message, 1.5))
                    }else{
                        app.$message.loading('保存中..', 0.5)
                            .then(() => app.$message.info(response.data.message, 1.5))
                    }
                }
            }).catch()
            if (target) {
                delete target.editable
                this.data = newData
                this.cacheData = newData.map(item => ({ ...item }))
            }
        },
        cancel (key) {
            const newData = [...this.data]
            const target = newData.filter(item => key === item.id)[0]
            if (target) {
                Object.assign(target, this.cacheData.filter(item => key === item.id)[0])
                delete target.editable
                this.data = newData
            }
        },
        get() {
            axios.post("/member/manage/get").then(function (response) {
                if (response.status){
                    app.data = response.data.results;
                    app.filters = response.data.filters;
                }
            }).catch()
        }
    },
})