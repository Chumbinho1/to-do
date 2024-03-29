import { createRouter } from "vue-router";

const routes = [
    {
        path: "/",
        redirect: () => {},
    },
    {
        path: "/login",
        name: "login",
        component: () => import("../views/Login.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
