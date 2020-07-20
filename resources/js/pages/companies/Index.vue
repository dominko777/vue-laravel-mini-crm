<template>
    <div class="container">
        <h3>Компании</h3>
        <router-link to="create-company" class="waves-effect waves-light btn"><i class="material-icons">add</i></router-link>
        <table>
            <thead>
            <tr>
                <th>Название</th>
                <th>Email</th>
                <th>Лого</th>
                <th>Сайт</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="company in companies.data" :key="company.id">
                <td>{{ company.name }}</td>
                <td>{{ company.email }}</td>
                <td><span v-if="company.logo"><img width="100" height="100" :src="'storage/images/companies/' + company.logo" ></span></td>
                <td>{{ company.website }}</td>
                <td class="row">
                    <div class="col m6"><router-link  :to="'update-company/' + company.id" class="waves-effect waves-light btn"><i class="material-icons">create</i></router-link></div>
                    <div class="col m6"><button @click="showDeleteModal(company)" class="waves-effect waves-light btn"><i class="material-icons">delete</i></button></div>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination  :limit="5" :data="companies" @pagination-change-page="getCompanies"></Pagination>
        <div id="modal1" class="modal">
            <div class="modal-content">
                <p>Вы точно хотите удалить компанию {{ selectedCompany ? selectedCompany.name : '' }}?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Отмена</a>
                <a @click="deleteCompany" href="#!" class="modal-close waves-effect waves-green btn-flat">Удалить</a>
            </div>
        </div>
    </div>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'

    export default {
        components: { Pagination },
        data() {
            return {
                companies: [],
                axiosInstance: axios.create({
                    baseUrl: BASE_URL
                }),
                selectedCompany: null
            }
        },
        mounted() {
            this.getCompanies();
        },
        methods: {
            showDeleteModal(company) {
                this.selectedCompany = company
                $('.modal').modal();
                $('.modal').modal('open');
            },
            getCompanies(page = 1) {
                this.axiosInstance.get('companies/index?page=' + page).then(response => {
                    this.companies = response.data;
                })
            },
            deleteCompany() {
                if (this.selectedCompany) {
                    this.axiosInstance.post('companies/delete/' + this.selectedCompany.id).then(response => {
                        this.getCompanies()
                    })
                }
            },
        }
    }
</script>

<style scoped>

</style>