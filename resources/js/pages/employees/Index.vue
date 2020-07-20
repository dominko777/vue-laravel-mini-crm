<template>
    <div class="container">
        <h3>Работники</h3>
        <router-link to="create-employee" class="waves-effect waves-light btn"><i class="material-icons">add</i></router-link>
        <table>
            <thead>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Компания</th>
                <th>Email</th>
                <th>Телефон</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="employee in employees.data" :key="employee.id">
                <td>{{ employee.first_name }}</td>
                <td>{{ employee.last_name }}</td>
                <td>{{ employee.company }}</td>
                <td>{{ employee.email }}</td>
                <td>{{ employee.phone }}</td>
                <td class="row">
                    <div class="col m6"><router-link  :to="'update-employee/' + employee.id" class="waves-effect waves-light btn"><i class="material-icons">create</i></router-link></div>
                    <div class="col m6"><button @click="showDeleteModal(employee)" class="waves-effect waves-light btn"><i class="material-icons">delete</i></button></div>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination  :limit="5" :data="employees" @pagination-change-page="getEmployees"></Pagination>
        <div id="modal1" class="modal">
            <div class="modal-content">
                <p>Вы точно хотите удалить сотрудника {{ selectedEmployee ? selectedEmployee.first_name + ' ' + selectedEmployee.last_name : '' }}?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Отмена</a>
                <a @click="deleteEmployee" href="#!" class="modal-close waves-effect waves-green btn-flat">Удалить</a>
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
                employees: [],
                axiosInstance: axios.create({
                    baseUrl: BASE_URL
                }),
                selectedEmployee: null
            }
        },
        mounted() {
            this.getEmployees();
        },
        methods: {
            showDeleteModal(employee) {
                this.selectedEmployee = employee
                $('.modal').modal();
                $('.modal').modal('open');
            },
            getEmployees(page = 1) {
                this.axiosInstance.get('employees/index?page=' + page).then(response => {
                    response.data.data.forEach(employee => {
                        employee.company = employee.company.name
                    })
                    this.employees = response.data;
                })
            },
            deleteEmployee() {
                if (this.selectedEmployee) {
                    this.axiosInstance.post('employees/delete/' + this.selectedEmployee.id).then(response => {
                        this.getEmployees()
                    })
                }
            },
        }
    }
</script>

<style scoped>

</style>