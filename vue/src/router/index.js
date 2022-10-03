import {createRouter, createWebHistory} from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Game from '../views/Game.vue';

const routes = [

{
    path: '/',
    name: 'Login',
    component: Login
},

{
    path: '/register',
    name: 'Register',
    component: Register
},


{
    path: '/game',
    name: 'Game',
    component: Game
}

];

const router = createRouter({

    history: createWebHistory(),
    routes
})


export default router;