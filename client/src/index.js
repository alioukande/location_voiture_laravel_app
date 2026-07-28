import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";

import App from "./App";
 import Reservations from "./components/Reservations";
// import Login from "./components/Login";
// import Register from "./components/Register";

const root = ReactDOM.createRoot(document.getElementById("root"));

root.render(
  <BrowserRouter>
    <Routes>

      <Route path="/" element={<App />} />
      <Route path="/reservations" element={<Reservations />} />
     

    </Routes>
  </BrowserRouter>
);