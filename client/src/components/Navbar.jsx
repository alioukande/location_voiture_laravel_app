
import { Link } from "react-router-dom";

export default function Navbar({ logout }) {
  return (
    <nav className="navbar navbar-expand-lg navbar-dark bg-primary shadow">
      <div className="container">

        <Link className="navbar-brand fw-bold" to="/">
          🚗 Car Rental
        </Link>

        <button
          className="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span className="navbar-toggler-icon"></span>
        </button>

        <div className="collapse navbar-collapse" id="navbarNav">

          <ul className="navbar-nav me-auto">

            <li className="nav-item">
              <Link className="nav-link" to="/">
                Accueil
              </Link>
            </li>

            <li className="nav-item">
              <Link className="nav-link" to="/reservations">
                Mes réservations
              </Link>
            </li>

          </ul>

          <button
            className="btn btn-outline-light"
            onClick={logout}
          >
            🚪 Déconnexion
          </button>

        </div>

      </div>
    </nav>
  );
}