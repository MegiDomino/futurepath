import React from 'react'
import ReactDOM from 'react-dom/client'
import { createBrowserRouter, RouterProvider } from 'react-router-dom'
import 'bootstrap/dist/css/bootstrap.min.css'
import Questionnaire from './pages/Questionnaire.jsx'
import Results from './pages/Results.jsx'

const router = createBrowserRouter([
  { path: "/", element: <Questionnaire/> },
  { path: "/results/:profileId", element: <Results/> }
])

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode><RouterProvider router={router} /></React.StrictMode>
)
