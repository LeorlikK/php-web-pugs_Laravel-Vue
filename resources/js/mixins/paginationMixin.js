import router from "@/router";

export default {
    data() {
        return {
            pagination: {
                current_page: router.currentRoute.value.query.page ?? 1,
                last_page: null,
                total: null,
            },
        }
    },
    methods: {
        changePage(page) {
            this.getItems(page)
        },
        assigningCurrentPage(page) {
            this.pagination.current_page = page
        },
        assigningValuesPaginator(data) {
            this.pagination.current_page = data.meta.current_page
            this.pagination.last_page = data.meta.last_page
            this.pagination.total = data.meta.total
        }
    }
}
