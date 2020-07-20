<template>
    <div>
        <Navbar :app="this"></Navbar>

        <spinner v-if="loading" class="spinner"></spinner>
        <div v-else-if="initiated">
            <router-view  :key="$route.fullPath" :app="this"></router-view>
        </div>
s    </div>
</template>

<script>
    import Navbar from './components/Navbar'
    export default {
        name: 'app',
        components: {
            Navbar
        },
        data() {
            return {
                user: null,
                loading: true,
                initiated: false,
                axiosInstance: axios.create({
                    baseUrl: BASE_URL
                })
            }
        },
        mounted() {
            this.init()
        },
        methods: {
            init() {
                this.axiosInstance.get('auth/init').then(response => {
                    this.user = response.data.user;
                    this.loading = false;
                    this.initiated = true;
                    if (!this.user) {
                        this.$router.push('/login')
                    } else {
                        localStorage.setItem('user', JSON.stringify(this.user))
                        this.$router.push('/companies')
                    }
                })
            }
        }
    }
</script>

<style scoped>
    .spinner {
        margin-top: 10px;
    }
</style>