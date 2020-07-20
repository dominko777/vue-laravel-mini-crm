<template>
    <div class="container">
        <ul id="dropdown1" class="dropdown-content">
            <li v-if="!app.user"><router-link to="/login">Войти</router-link></li>
            <li v-if="!app.user"><router-link to="/register">Регистрация</router-link></li>
            <li v-if="app.user"><a href="#" @click.prevent="logout">Выйти</a></li>
        </ul>
        <nav>
            <div class="nav-wrapper">
                <router-link class="brand-logo" to="/">CRM</router-link>
                <ul class="right hide-on-med-and-down">
                    <li><router-link to="/companies">Компании</router-link></li>
                    <li><router-link to="/employees">Работники</router-link></li>
                    <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">{{ app.user ? app.user.email : 'Аккаунт' }}<i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    $(document).ready(function () {
        $(".dropdown-trigger").dropdown();
    });

    export default {
        name: 'navbar',
        props: [ 'app' ],
        methods: {
            logout(evt) {
                this.app.axiosInstance.post('auth/logout').then(response => {
                    localStorage.removeItem('user');
                    this.$router.go('/login');
                });
            }
        }
    }
</script>

<style scoped>
.brand-logo {
    padding-left: 10px;
}
</style>