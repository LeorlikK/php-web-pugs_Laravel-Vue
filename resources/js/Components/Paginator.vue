<template>
    <div class="paginator">
        <button
            @click.prevent="changePage(1)"
            :key="1" class="page first-page"
            :disabled="current_page === 1"
        >First</button>
        <button
            v-if="paginator"
            v-for="link in paginator" :key="link"
            class="page"
            :class="current_page === link ? 'current-page' : ''"
            @click.prevent="changePage(link)"
        >
            {{link}}
        </button>
        <button
            @click.prevent="changePage(last_page)"
            :key="last_page" class="page last-page"
            :disabled="current_page === last_page"
        >Last</button>
    </div>
</template>

<script>
export default {
    name: "Paginator",
    emits: ['changePage'],
    props: {
        current_page: {
            type: Number,
        },
        last_page: {
            type: Number,
        },
        total: {
            type: Number,
        },
    },
    data() {
        return {
        }
    },
    methods: {
        changePage(page) {
            this.$emit('changePage', page)
        }
    },
    computed: {
        paginator() {
            const before = []
            const after = []
            for (let i = this.current_page; i > this.current_page - 5; i--) {
                before.push(i)
                if (i === 1) break
            }
            for (let i = this.current_page + 1; i < this.current_page + 5; i++) {
                if (i > this.last_page) break
                after.push(i)
            }

            return before.reverse().concat(after)
        }
    }
}
</script>

<style scoped>
</style>
