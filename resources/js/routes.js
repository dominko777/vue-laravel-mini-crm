import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import CompaniesIndex from './pages/companies/Index'
import CompaniesCreate from './pages/companies/Create'
import CompaniesUpdate from './pages/companies/Update'
import EmployeesIndex from './pages/employees/Index'
import EmployeesCreate from './pages/employees/Create'
import EmployeesUpdate from './pages/employees/Update'

export default [
    {
        path: '/register',
        component: Register,
        name: 'register'
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/companies',
        component: CompaniesIndex,
        name: 'companies',
        meta: {
            auth: true
        }
    },
    {
        path: '/create-company',
        component: CompaniesCreate,
        name: 'create-company',
        meta: {
            auth: true
        }
    },
    {
        path: '/update-company/:id',
        component: CompaniesUpdate,
        name: 'update-company',
        meta: {
            auth: true
        }
    },
    {
        path: '/employees',
        component: EmployeesIndex,
        name: 'employees',
        meta: {
            auth: true
        }
    },
    {
        path: '/create-employee',
        component: EmployeesCreate,
        name: 'create-employee',
        meta: {
            auth: true
        }
    },
    {
        path: '/update-employee/:id',
        component: EmployeesUpdate,
        name: 'update-employee',
        meta: {
            auth: true
        }
    },
    {
        path: '/',
        component: Home,
        name: 'home'
    },
]