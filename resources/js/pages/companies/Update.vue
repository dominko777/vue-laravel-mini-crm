<template>
    <div class="container">
        <h4>Редактирование компании</h4>
        <div class="row">
            <form class="col s12" @submit.prevent="onSubmit">
                <div class="row">
                    <div class="input-field col s12">
                        <input v-model.lazy="name" id="email" type="text" class="validate">
                        <label for="email">Название</label>
                        <span v-if="nameError" class="helper-text error" data-success="right">{{ nameError }}</span>
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
                    <span v-if="logo"><img width="100" height="100" :src="'/storage/images/companies/' + logo" ></span>
                    <div class="file-field col s12">
                        <div class="btn">
                            <span>Выберите лого</span>
                            <input id="logo-input" type="file" ref="logo"">
                        </div>
                        <span v-if="logoError" class="helper-text error" data-success="right">{{ logoError }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input v-model.lazy="website" id="email" type="text" class="validate">
                        <label for="email">Сайт</label>
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
                name: '',
                nameError: '',
                email: '',
                emailError: '',
                logo: [],
                website: '',
                formTouched: false,
                logo: '',
                logoError: '',
                axiosInstance: axios.create({
                    baseUrl: BASE_URL
                })
            }
        },
        mounted() {
           this.getCompany();
        },
        methods: {
            getCompany() {
                this.axiosInstance.defaults.baseURL = BASE_URL
                this.axiosInstance.get('companies/show/' + this.$route.params.id).then(response => {
                    this.name = response.data.name
                    this.email = response.data.email
                    this.logo = response.data.logo
                    this.website = response.data.website
                })
            },
            onSubmit() {
                this.nameError = '';
                this.emailError = '';
                this.logoError = '';
                const formData = new FormData();
                if (this.$refs.logo.files[0]) {
                    formData.append('logo', this.$refs.logo.files[0]);
                }
                formData.append('id', this.$route.params.id);
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('website', this.website);
                this.axiosInstance.defaults.baseURL = BASE_URL
                this.axiosInstance.post('companies/update', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.$router.push('/companies')
                }).catch(error => {
                    if (error.response.data.errors) {
                        const errors = error.response.data.errors;
                        for (let key in errors) {
                            if (key === 'name') {
                                this.nameError = errors[key][0]
                            } else if (key === 'email'){
                                this.emailError = errors[key][0]
                            } else if (key === 'logo'){
                                this.logoError = errors[key][0]
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