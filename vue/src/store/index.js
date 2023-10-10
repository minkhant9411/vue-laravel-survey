import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
  state: {
    user: {
      data: {},
      token: sessionStorage.getItem("TOKEN"),
    },
    currentSurvey: {
      loading: false,
      data: {},
    },
    surveys: {
      loading: false,
      links: [],
      data: [],
    },
    questionTypes: ["text", "select", "radio", "checkbox", "textarea"],
    notifaction: {
      show: false,
      type: null,
      message: null,
    },
  },
  getters: {},
  actions: {
    getSurveys({ commit }) {
      commit("setSurveysLoading", true);
      return axiosClient.get("/survey").then((res) => {
        commit("setSurveysLoading", false);
        commit("setSurveys", res.data);
      });
    },
    deleteSurvey({}, id) {
      return axiosClient.delete(`/survey/${id}`);
    },
    getSurvey({ commit }, id) {
      commit("setCurrentSurveyLoading", true);
      return axiosClient
        .get(`/survey/${id}`)
        .then((res) => {
          commit("setCurrentSurvey", res.data);
          commit("setCurrentSurveyLoading", false);
          return res.data;
        })
        .catch((err) => {
          commit("setCurrentSurveyLoading", true);
          throw err;
        });
    },
    saveSurvey({ commit }, survey) {
      delete survey.image_url;
      let response;
      console.log(survey.id);
      if (survey.id) {
        console.log("id");
        response = axiosClient
          .put(`/survey/${survey.id}`, survey)
          .then((res) => {
            commit("setCurrentSurvey", res.data);
            return res.data;
          });
      } else {
        console.log("no id");
        response = axiosClient.post("/survey", survey).then((res) => {
          commit("setCurrentSurvey", res.data);
          return res.data;
        });
      }
      return response;
    },
    register({ commit }, user) {
      return axiosClient.post("/register", user).then(({ data }) => {
        commit("setUser", data);
        return data;
      });
    },
    login({ commit }, user) {
      return axiosClient.post("/login", user).then(({ data }) => {
        commit("setUser", data);
        return data;
      });
    },
    logout({ commit }) {
      return axiosClient.post("/logout").then((res) => {
        commit("logout");
        return res;
      });
    },
  },
  mutations: {
    setSurveysLoading(state, loading) {
      state.surveys.loading = loading;
    },
    setCurrentSurveyLoading(state, loading) {
      state.currentSurvey.loading = loading;
    },
    setCurrentSurvey(state, survey) {
      state.currentSurvey.data = survey.data;
    },
    setSurveys(state, survey) {
      state.surveys.links = survey.links;
      state.surveys.data = survey.data;
    },
    logout: (state) => {
      state.user.data = {};
      state.user.token = null;
      sessionStorage.removeItem("TOKEN");
    },
    setUser: (state, userData) => {
      state.user.token = userData.token;
      state.user.data = userData.user;
      sessionStorage.setItem("TOKEN", userData.token);
      // sessionStorage.setItem("User", userData.data);
    },
    notify: (state, { message, type }) => {
      state.notifaction.show = true;
      state.notifaction.type = type;
      state.notifaction.message = message;
      setTimeout(() => {
        state.notifaction.show = false;
      }, 3000);
    },
  },
  modules: {},
});

export default store;
