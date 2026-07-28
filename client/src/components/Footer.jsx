import { Link } from "react-router-dom";

export default function Footer() {
  return (
    <footer className="bg-dark text-white mt-5 pt-5 pb-3">
      <div className="container">

        <div className="row">

          {/* Logo */}
          <div className="col-md-4 mb-4">
            <h4 className="fw-bold">🚗 Car Rental</h4>
            <p className="text-light">
              Réservez votre voiture en quelques clics avec notre plateforme
              simple, rapide et sécurisée.
            </p>
          </div>

          {/* Navigation */}
          <div className="col-md-4 mb-4">
            <h5>Navigation</h5>

            <ul className="list-unstyled">

              <li className="mb-2">
                <Link to="/" className="text-white text-decoration-none">
                  🏠 Accueil
                </Link>
              </li>

              <li className="mb-2">
                <Link
                  to="/reservations"
                  className="text-white text-decoration-none"
                >
                  📋 Mes réservations
                </Link>
              </li>

            </ul>
          </div>

          {/* Contact */}
          <div className="col-md-4 mb-4">

            <h5>Contact</h5>

            <p className="mb-2">📧 contact@carrental.ma</p>

            <p className="mb-2">📞 +212 6 12 34 56 78</p>

            <p>📍 Casablanca, Maroc</p>

          </div>

        </div>

        <hr className="border-secondary" />

        <div className="text-center">

          <small>
            © 2026 Car Rental Morocco - Tous droits réservés.
          </small>

        </div>

      </div>
    </footer>
  );
}