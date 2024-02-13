import axios from 'axios'
// import app from "../main";

const url = "https://e-leaflet.gsrs.my.id/admin/api/"; //WEB APACHE
const BASE_URL = "https://e-leaflet.gsrs.my.id/admin/"; //WEB APACHE

const http = axios.create({
  baseURL: url,
  headers: {
    Accept: 'application/json',
  },
  withCredentials: false
})

// http.interceptors.request.use((config) => {
//   app.$Progress.start(); // for every request start the progress
//   return config;
// });

// http.interceptors.response.use((response) => {
//   app.$Progress.finish(); // finish when a response is received
//   return response;
// });

export { http, url, BASE_URL }
