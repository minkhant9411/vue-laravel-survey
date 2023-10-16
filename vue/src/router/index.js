import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from "../components/DefaultLayout.vue";
import SurveyPublicView from "../components/SurveyPublicView.vue";
import AuthLayout from "../components/AuthLayout.vue";
import Dashboard from "../views/Dashboard.vue";
import SurveyView from "../views/SurveyView.vue";
import Surveys from "../views/Surveys.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import store from "../store";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      redirect: "/dashboard",
      component: DefaultLayout,
      meta: { requiresAuth: true },
      children: [
        { path: "/dashboard", name: "Dashboard", component: Dashboard },
        { path: "/surveys", name: "Surveys", component: Surveys },
        { path: "/survey/create", name: "SurveyCreate", component: SurveyView },
        { path: "/survey/:id", name: "SurveyView", component: SurveyView },
      ],
    },
    {
      path: "/view/survey/:slug",
      name: "SurveyPublicView",
      component: SurveyPublicView,
    },
    {
      path: "/auth",
      name: "Auth",
      component: AuthLayout,
      meta: { isGuest: true },
      redirect: "/login",
      children: [
        {
          path: "/login",
          name: "Login",
          component: Login,
        },
        {
          path: "/register",
          name: "Register",
          component: Register,
        },
      ],
    },
  ],
});
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: "Login" });
  } else if (store.state.user.token && to.meta.isGuest) {
    next({ name: "Dashboard" });
  } else {
    next();
  }
});
export default router;
