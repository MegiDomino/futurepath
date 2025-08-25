import axios from "axios";
const API = axios.create({ baseURL: "http://127.0.0.1:9000/api" });

export const fetchQuestions = () => API.get("/questions").then(r=>r.data);
export const upsertProfile = (email) => API.post("/profile",{ email }).then(r=>r.data);
export const submitAnswers = (payload) => API.post("/submit", payload).then(r=>r.data);
export const getRecommendation = (profile_id) => API.post("/recommend", { profile_id }).then(r=>r.data);
