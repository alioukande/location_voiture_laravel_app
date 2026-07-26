<!DOCTYPE html>
<html>
<head>

<title>Admin Location Voiture</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
display:flex;
}

.sidebar{
width:220px;
height:100vh;
background:#343a40;
color:white;
padding-top:20px;
}

.sidebar a{
color:white;
display:block;
padding:12px;
text-decoration:none;
}

.sidebar a:hover{
background:#495057;
}

.content{
flex:1;
padding:20px;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h4 class="text-center">ADMIN</h4>

    <a href="/admin/dashboard">Dashboard</a>

    <a href="/admin/voitures">Voitures</a>

    <a href="/admin/assurances">Assurances</a>

    <a href="/admin/reservations">Réservations</a>

    <a href="/admin/avis">Avis</a>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button
            type="submit"
            style="
                background:none;
                border:none;
                color:#dc3545;
                display:block;
                width:100%;
                text-align:left;
                padding:12px;
                cursor:pointer;
            "
        >
            🚪 Déconnexion
        </button>
    </form>

</div>   <!-- ← Cette balise manquait -->

<!-- CONTENU -->

<div class="content">

    <nav class="navbar navbar-light bg-light mb-4">

        <span class="navbar-text">
            Bienvenue {{ Auth::user()->name }}
        </span>

    </nav>

    @yield('content')

</div>

</body>
</html>
