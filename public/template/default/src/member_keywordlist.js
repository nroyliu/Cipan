const columns = [{
    title: '关键词',
    dataIndex: 'name',
    sorter: true,
    width: '20%',
    scopedSlots: { customRender: 'name' },
}, {
    title: '类别',
    dataIndex: 'Typetext',
    filters: [],
    width: '20%',
}, {
    title: '描述',
    dataIndex: 'description',
}];
var app = new Vue({
    el: "#app",
    data() {
        return {
            data: [],
            pagination: {},
            loading: false,
            columns,
        }
    },
    //初始化
    mounted() {
        this.fetch();
    },
    //方法
    methods: {
        handleTableChange (pagination, filters, sorter) {
            console.log(pagination);
            const pager = { ...this.pagination };
            pager.current = pagination.current;
            this.pagination = pager;
            this.fetch({
                results: pagination.pageSize, //每页数量
                page: pagination.current, //当前页面
                sortField: sorter.field, //排序字段
                sortOrder: sorter.order, //排序编号
                ...filters,
            });
        },
        fetch (params = {}) {
            console.log('params:', params);
            this.loading = true
            axios.post('/member/keyword/get', {
                results: 10,
                ...params,
            })
                .then(function (response) {
                    console.log(response.data.status);
                    if (response.data) {
                        const pagination = { ...app.pagination };
                        // Read total count from server
                        pagination.total = response.data.total;
                        app.loading = false;
                        app.data = response.data.results;
                        app.pagination = pagination;
                        columns[1].filters = response.data.filters;
                    } else {
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
})