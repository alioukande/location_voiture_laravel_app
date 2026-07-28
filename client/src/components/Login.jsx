import { useState } from "react";
import "../css/login.css";
import { Link, useNavigate } from "react-router-dom";

export default function Login({ onLogin }) {

    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const navigate = useNavigate();
    

    const login = async (e) => {

        e.preventDefault();

        const response = await fetch("http://127.0.0.1:8000/api/login",{

            method:"POST",

            headers:{
                "Content-Type":"application/json",
                "Accept":"application/json"
            },

            body:JSON.stringify({
                email,
                password
            })

        });

        const data = await response.json();

        if(response.ok){

            localStorage.setItem("token",data.token);

            onLogin();

        }else{

            alert(data.message);

        }

    }

    return(

<div className="login-container">

<div className="card login-card p-4">

<div className="text-center">

<div className="logo">
🚗
</div>

<h2 className="title">
Car Rental
</h2>

<p className="text-muted">
Connectez-vous à votre compte
</p>

</div>

<form onSubmit={login}>

<div className="mb-3">

<input
type="email"
className="form-control"
placeholder="Adresse email"
value={email}
onChange={(e)=>setEmail(e.target.value)}
required
/>

</div>

<div className="mb-3">

<input
type="password"
className="form-control"
placeholder="Mot de passe"
value={password}
onChange={(e)=>setPassword(e.target.value)}
required
/>

</div>

<button
className="btn btn-primary w-100 btn-login">

Se connecter

</button>

<div className="text-center mt-3">

<p>

Pas encore de compte ?

<Link
to="/register"
className="text-decoration-none ms-2">

Créer un compte

</Link>

</p>

</div>

</form>

</div>

</div>

    )

}