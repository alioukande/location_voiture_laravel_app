import { useEffect, useState } from "react";
import AvisModal from "./AvisModal";

function Reservations() {
  const [reservations, setReservations] = useState([]);
  const [reservationSelectionnee, setReservationSelectionnee] = useState(null);

  useEffect(() => {
    fetch("http://127.0.0.1:8000/api/reservations")
      .then((res) => res.json())
      .then((data) => setReservations(data))
      .catch((err) => console.log(err));
  }, []);

  const badgeColor = (statut) => {
    switch (statut) {
      case "confirmee":
        return "bg-success";
      case "en attente":
        return "bg-warning text-dark";
      case "annulee":
        return "bg-danger";
      case "terminee":
        return "bg-secondary";
      default:
        return "bg-primary";
    }
  };

  // Calcul du nombre de jours
  const calculJours = (debut, fin) => {
    const start = new Date(debut);
    const end = new Date(fin);

    const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

    return diff <= 0 ? 1 : diff;
  };

  return (
    <div className="container py-4">

      <h2 className="text-center fw-bold mb-4">
        📋 Mes Réservations
      </h2>

      {reservations.length === 0 ? (
        <div className="alert alert-info text-center">
          Aucune réservation trouvée.
        </div>
      ) : (
        <div className="row">

          {reservations.map((r) => {

            const jours = calculJours(r.start_time, r.end_time);
            const prixVoiture = jours * parseFloat(r.voiture.prix_par_jour);
            const prixAssurance = r.assurance
              ? parseFloat(r.assurance.prix_base)
              : 0;

            return (

              <div className="col-md-4 mb-4" key={r.id}>

                <div className="card shadow border-0 rounded-4 h-100">

                  <img
                    src={`http://127.0.0.1:8000/storage/${r.voiture.image}`}
                    className="card-img-top"
                    alt={r.voiture.marque}
                    style={{
                      height: "220px",
                      objectFit: "cover",
                    }}
                  />

                  <div className="card-body">

                    <h4 className="fw-bold text-center">
                      🚗 {r.voiture.marque} {r.voiture.model}
                    </h4>

                    <hr />

                    <p>
                      📅 <strong>Début :</strong><br />
                      {r.start_time}
                    </p>

                    <p>
                      📅 <strong>Fin :</strong><br />
                      {r.end_time}
                    </p>

                    <p>
                      🗓️ <strong>Durée :</strong> {jours} jour{jours > 1 ? "s" : ""}
                    </p>

                    <div className="bg-light rounded-3 p-3 mt-3">

                      <h6 className="fw-bold text-primary mb-3">
                        💳 Détails du paiement
                      </h6>

                      <div className="d-flex justify-content-between">
                        <span>🚗 Prix / jour</span>
                        <strong>{r.voiture.prix_par_jour} DH</strong>
                      </div>

                      <div className="d-flex justify-content-between">
                        <span>📅 Nombre de jours</span>
                        <strong>{jours}</strong>
                      </div>

                      <div className="d-flex justify-content-between">
                        <span>🚘 Sous-total voiture</span>
                        <strong>{prixVoiture.toFixed(2)} DH</strong>
                      </div>

                      <div className="d-flex justify-content-between">
                        <span>🛡️ Assurance</span>
                        <strong>{prixAssurance.toFixed(2)} DH</strong>
                      </div>

                      <div className="d-flex justify-content-between">
                        <span>📋 Type</span>
                        <strong>
                          {r.assurance ? r.assurance.type : "Aucune"}
                        </strong>
                      </div>

                      <div className="mt-2">
                        <small className="text-muted">
                          {r.assurance
                            ? r.assurance.description
                            : "Aucune assurance sélectionnée"}
                        </small>
                      </div>

                      <hr />

                      <div className="d-flex justify-content-between fs-5">
                        <strong>Total payé</strong>
                        <strong className="text-success">
                          {parseFloat(r.total_price).toFixed(2)} DH
                        </strong>
                      </div>

                    </div>
                          {reservationSelectionnee && (
        <AvisModal
          reservation={reservationSelectionnee}
          onClose={() => setReservationSelectionnee(null)}
        />
      )}
<div className="text-center mt-3">

  <span className={`badge ${badgeColor(r.statut)} px-3 py-2`}>
    {r.statut.toUpperCase()}
  </span>

  {r.statut === "terminee" && (
    <button
      className="btn btn-warning w-100 mt-3"
      onClick={() => setReservationSelectionnee(r)}
    >
      ⭐ Laisser un avis
    </button>
  )}

</div>
                    

                  </div>
                  

                </div>

              </div>

              

            );
          })}

        </div>
      )}
      
      

    </div>
    
  );
}

export default Reservations;