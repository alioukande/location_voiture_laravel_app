
import { useState } from "react";
import { Link  } from "react-router-dom";
import "../css/login.css";

export default function Register() {


    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");

    const register = async (e) => {

        e.preventDefault();

        if(password !== passwordConfirmation){

            alert("Les mots de passe ne correspondent pas");

            return;
        }

        const response = await fetch("http://192.168.11.150/api/register",{

            method:"POST",

            headers:{
                "Content-Type":"application/json",
                "Accept":"application/json"
            },

            body:JSON.stringify({

                name,
                email,
                password,
                passwordConfirmation

            })

        });

        const data = await response.json();

        if(response.ok){

            alert("Compte créé avec succès 🎉");

           

        }else{

            alert(data.message || "Erreur lors de l'inscription");

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
Créer un nouveau compte
</p>

</div>

<form onSubmit={register}>

<div className="mb-3">

<input
type="text"
className="form-control"
placeholder="Nom complet"
value={name}
onChange={(e)=>setName(e.target.value)}
required
/>

</div>

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

<div className="mb-3">

<input
type="password"
className="form-control"
placeholder="Confirmer le mot de passe"
value={passwordConfirmation}
onChange={(e)=>setPasswordConfirmation(e.target.value)}
required
/>

</div>

<button
className="btn btn-primary w-100 btn-login">

Créer un compte

</button>

<Link
  to="/"
  className="text-decoration-none ms-2">

  Se connecter

</Link>

</form>

</div>

</div>

    );

}