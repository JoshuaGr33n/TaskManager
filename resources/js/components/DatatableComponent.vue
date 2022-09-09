<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage"
            :pagination="pagination"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>
<script>
export default {
    data() {
        return {
            columns: [{
                label: 'id',
                field: 'id'
            },
            {
                label: 'title',
                field: 'name'
            },
            {
                label: 'category',
                field: 'email',
                show: true,
                sort:{
                 sortable: true,
                 sortColumn: 'title',
                 sortDir: 'asc',
                },
            },
            {
                label: 'description',
                field: 'status'
            }
            ],
            rows: [],
            page: 1,
            filter: '',
            perPage: 5,
            pagination: {
                limit: 1,
                align: "right",
                size: "small"
            }
        }
    },
    methods: {
        showBlogs: function () {
            axios.get('users').then(function (res) {
                this.rows = res.data;
            }.bind(this));
        }
    },
    created: function () {
        this.showBlogs()
    }
}
</script>