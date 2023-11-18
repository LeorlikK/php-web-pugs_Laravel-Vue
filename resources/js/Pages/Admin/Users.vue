<template>
    <div class="container-admin">
        <AdminMenu></AdminMenu>
        <div class="content content-admin-users">
            <div class="users">
                <div class="sorted">
                    <p>Сортировать по:</p>
                    <select @change="changeSorted" v-model="sorted" autocomplete="off">
                        <option value="id">id</option>
                        <option value="email">email</option>
                        <option value="login">login</option>
                        <option value="created_at">created at</option>
                        <option value="updated_at">updated at</option>
                    </select>
                    <div
                        @click.prevent="changeSortedType('asc')"
                        :class="sorted_type === 'asc' ? 'sorted-color-l' : 'sorted-color-b'"
                        class="sorted-type-one"></div>
                    <div
                        @click.prevent="changeSortedType('desc')"
                        :class="sorted_type === 'asc' ? 'sorted-color-b' : 'sorted-color-l'"
                        class="sorted-type-two"></div>
                </div>
                <div class="find">
                    <input v-model="search" @keyup.enter="changeSearch" placeholder="Поиск по email">
                    <a @click.prevent="changeSearch" class="btn btn-update btn-white-c">Поиск</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th scope="row">ID</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Role</th>
                            <th>Avatar</th>
                            <th>Created_At</th>
                            <th>Updated_At</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="post in posts" :class="post.banned ? 'banned-line' : ''">
                            <th>{{ post.id }}</th>
                            <td>{{ post.email }}</td>
                            <td>{{ post.login }}</td>
                            <td>{{ post.role }}</td>
                            <td>{{ post.avatar }}</td>
                            <td>{{ post.created_at }}</td>
                            <td>{{ post.updated_at }}</td>
                            <td class="users-btn-update"><router-link :to="{name: 'admin_user_edit', params: {user: post.id}}">Update</router-link></td>
                            <td :class="post.banned ? 'users-btn-banned' : 'users-btn-update'">
                                <a @click.prevent="confirmBanned(post)">{{ post.banned ? 'Banned' : 'Active'}}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Paginator
                v-if="pagination.last_page > 1"
                :current_page="pagination.current_page"
                :last_page="pagination.last_page"
                :total="pagination.total"
                @changePage="changePage"
            ></Paginator>
            <Confirm
                :text="textBannedUser"
                :question="question"
                @answer="bannedUser"
            ></Confirm>
        </div>
    </div>
</template>

<script>
import AdminMenu from "@/Components/Menu/AdminMenu.vue";
import router from "@/router";
import myAxios from "@/myAxios";
import Confirm from "@/Components/Сonfirmation/Confirm.vue";
import {API_ROUTES} from "@/routs";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import errorsLogMixin from "@/mixins/logMixin";
export default {
    name: "Users",
    components: {AdminMenu, Confirm},
    mixins: [inputErrorsMixin, errorsLogMixin],
    data() {
        return {
            posts: [],
            pagination: {
                current_page: router.currentRoute.value.query.page,
                last_page: null,
                total: null,
            },
            sorted: router.currentRoute.value.query.sorted ?? 'id',
            sorted_type: router.currentRoute.value.query.sorted_type ?? 'asc',
            search: router.currentRoute.value.query.search,

            textBannedUser: '',
            question: false,
            userBanned: null
        }
    },
    methods: {
        getUsers(page) {
            this.pagination.current_page = page
            const query = {
                page: this.pagination.current_page,
                sorted: this.sorted,
                sorted_type: this.sorted_type,
                search: this.search
            }
            router.replace({ query: query })
            myAxios.get(`${API_ROUTES.protected.admin_users}`, { params: query })
                .then(data => {
                    this.dataLog(data)
                    data = data.data
                    this.posts.splice(0)
                    this.posts.push(...data.data)
                    this.pagination.current_page = data.meta.current_page
                    this.pagination.last_page = data.meta.last_page
                    this.pagination.total = data.meta.total
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        },
        bannedUser(confirm) {
            this.question = false
            if (confirm){
                myAxios.post(`${API_ROUTES.protected.admin_user_banned}/${this.userBanned.id}`)
                    .then(data => {
                        this.dataLog(data)
                        this.userBanned.banned = !this.userBanned.banned
                    })
                    .catch(errors => {
                        this.errorsLog(errors)
                    })
            } else {
                this.userBanned = null
            }
        },
        changePage(page) {
            this.getUsers(page)
        },
        changeSorted() {
            this.getUsers(1)
        },
        changeSortedType(type) {
            this.sorted_type = type
            this.getUsers(1)
        },
        changeSearch() {
            this.getUsers(1)
        },
        confirmBanned(user){
            this.textBannedUser = user.banned ? 'Разблокировать пользователя?' : 'Заблокировать пользователя?'
            this.question = true
            this.userBanned = user
        },
    },
    mounted() {
        this.getUsers(this.pagination.current_page)
    }
}
</script>

<style scoped>

</style>
