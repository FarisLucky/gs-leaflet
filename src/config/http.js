import axios from 'axios'
// import app from "../main";

const url = "http://localhost:8000/api/"; //WEB APACHE

const http = axios.create({
  baseURL: url,
  headers: {
    Accept: 'application/json',
  },
})

// http.interceptors.request.use((config) => {
//   app.$Progress.start(); // for every request start the progress
//   return config;
// });

// http.interceptors.response.use((response) => {
//   app.$Progress.finish(); // finish when a response is received
//   return response;
// });

export { http, url }
