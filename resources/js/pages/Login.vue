<template>
    <div class="container">
        <h4>Вход</h4>
        <div class="row">
            <form class="col s12 register-form" @submit.prevent="onSubmit">
                <div class="row">
                    <div class="input-field col s12">
                        <input v-model.lazy="email" id="email" type="email" class="validate">
                        <label for="email">Email</label>
                        <div v-if="formTouched">
                            <span v-if="!$v.email.required" class="helper-text error" data-success="right">Поле обязательно для заполнения</span>
                            <span v-if="!$v.email.email" class="helper-text error" data-success="right">Введите правильный email</span>
                            <span v-if="serverError" class="helper-text error" data-success="right">{{ serverError }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input v-model.lazy="password" id="password" type="password" class="validate">
                        <label for="password">Password</label>
                        <div v-if="formTouched">
                            <span v-if="!$v.password.required" class="helper-text error" data-success="right">Поле обязательно для заполнения</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" class="waves-effect waves-light btn">Войти</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { required, minLength, email } from 'vuelidate/lib/validators'

    export default {
        props: ['app'],
        data() {
            return {
                email: '',
                password: '',
                errors: [],
                formTouched: false,
                serverError: ''
            }
        },
        methods: {
            onSubmit() {
                this.formTouched = true
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    const data = {
                        email: this.email,
                        password: this.password,
                    }
                    this.app.axiosInstance.post('auth/login', data).then(response => {
                        this.app.user = response.data
                        this.$router.push('/')
                    }).catch(error => {
                        if (error.response.data.error) {
                            this.serverError = error.response.data.error
                        }
                    })
                }
                this.$v.$reset()
            }
        },
        validations: {
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(6)
            }
        }
    }
</script>

<style scoped>
    span.error {
        color: red;
    }
    .register-form {
        margin-top: 10px;
    }
</style>