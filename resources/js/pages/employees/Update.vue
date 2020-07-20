<template>
    <div class="container">
        <h4>Редактирование работника</h4>
        <div class="row">
            <form class="col s12" @submit.prevent="onSubmit">
                <div class="row">
                    <div class="input-field col s12">
                        <input v-model.lazy="first_name" id="first-name" type="text" class="validate">
                        <label for="email">Имя</label>
                        <span v-if="firstNameError" class="helper-text error" data-success="right">{{ firstNameError }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input v-model.lazy="last_name" id="last-name" type="text" class="validate">
                        <label for="email">Фамилия</label>
                        <span v-if="lastNameError" class="helper-text error" data-success="right">{{ lastNameError }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input v-model.lazy="email" id="email" type="email" class="validate">
                        <label for="email">Email</label>
                        <span v-if="emailError" class="helper-text error" data-success="right">{{ emailError }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input v-model.lazy="phone" id="phone" type="text" class="validate">
                        <label for="phone">Телефон</label>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" class="waves-effect waves-light btn">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                first_name: '',
                firstNameError: '',
                last_name: '',
                lastNameError: '',
                email: '',
                emailError: '',
                phone: '',
                axiosInstance: axios.create({
                    baseUrl: BASE_URL
                }),
            }
        },
        created() {
            this.axiosInstance.defaults.baseURL = BASE_URL
            this.axiosInstance.get('employees/show/' + this.$route.params.id).then(response => {
                this.first_name = response.data.first_name
                this.last_name = response.data.last_name
                this.email = response.data.email
                this.phone = response.data.phone
            })
        },
        methods: {
            onSubmit() {
                const data = {
                    id: this.$route.params.id,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email,
                    phone: this.phone
                }
                this.axiosInstance.post('employees/update', data).then(response => {
                    this.$router.push('/employees')
                }).catch(error => {
                    if (error.response.data.errors) {
                        const errors = error.response.data.errors;
                        for (let key in errors) {
                            if (key === 'first_name') {
                                this.firstNameError = errors[key][0]
                            } else if (key === 'last_name'){
                                this.lastNameError = errors[key][0]
                            } else if (key === 'email'){
                                this.emailError = errors[key][0]
                            }
                        }
                    }
                })
            }
        }
    }
</script>

<style scoped>
    span.error {
        color: red;
    }
</style>