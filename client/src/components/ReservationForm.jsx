import React, { useState, useEffect } from "react";
function ReservationForm({ voiture, onClose }) {
  const [start, setStart] = useState("");
  const [end, setEnd] = useState("");
  const [assurances, setAssurances] = useState([]);
  const [assuranceId, setAssuranceId] = useState("");
  const [total, setTotal] = useState(0);

  // 🔥 charger assurances depuis Laravel
  useEffect(() => {
    fetch("http://127.0.0.1:8000/api/assurances")
      .then(res => res.json())
      .then(data => setAssurances(data))
      .catch(err => console.error(err));
  }, []);

  // 🔥 calcul total automatique
  useEffect(() => {
    if (!start || !end) return;

    const d1 = new Date(start);
    const d2 = new Date(end);

    let jours = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
    if (jours <= 0) jours = 1;

    let prixVoiture = jours * Number.parseFloat(voiture.prix_par_jour);

let assurance = assurances.find(
    a => a.id === Number(assuranceId)
);
let prixAssurance = assurance
    ? Number.parseFloat(assurance.prix_base)
    : 0;
    setTotal(prixVoiture + prixAssurance);
  }, [start, end, assuranceId, assurances, voiture]);

 const handleSubmit = () => {

  console.log("🔥 CLICK CONFIRMER");

  if (!start || !end) {
    alert("Choisis les dates !");
    return;
  }

  const token = localStorage.getItem("token");

console.log(token);

  fetch("http://127.0.0.1:8000/api/reservations", {
    method: "Post",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
         "Authorization":`Bearer ${token}`

    },
    body: JSON.stringify({
      user_id: 1,
      voiture_id: voiture.id,
      assurance_id: assuranceId || null,
      start_time: start,
      end_time: end,
      total_price: total,
    }),
  })
    .then(res => res.json())
    .then(data => {
      console.log("✅ RESPONSE:", data);
      alert("Réservation créée !");
      onClose(); // ferme le modal
    })
    .catch(err => {
      console.error("❌ ERREUR:", err);
      alert("Erreur serveur");
    });
};

  return (
   
   <div
    onClick={(e) => {
    if (e.target === e.currentTarget) {
      onClose();
    }
    }}
    style={{
      position: "fixed",
      top: 0,
      left: 0,
      width: "100%",
      height: "100vh",
      backgroundColor: "rgba(0,0,0,0.6)",
      display: "flex",
      justifyContent: "center",
      alignItems: "center",
      zIndex: 999,
    }}
  >

    {/* STOP PROPAGATION */}
    <div
      className="card shadow p-3"
      style={{
        width: "380px",
        maxHeight: "90vh",
        overflowY: "auto",
        borderRadius: "12px"
      }}
    >

      <h5 className="mb-2">
        {voiture.marque} {voiture.model}
      </h5>

      {/* IMAGE */}
      <img
        src={`http://localhost:8000/storage/${voiture.image}`}
        alt=""
        style={{
          width: "100%",
          height: "160px",
          objectFit: "cover",
          borderRadius: "8px"
        }}
      />

      <p className="mt-2 fw-bold">
        💰 {voiture.prix_par_jour} DH / jour
      </p>

      {/* DATES */}
      <div className="mb-2">
        <label htmlFor="dateDebut">
    Date début
</label>
        <input
    id="dateDebut"
    type="date"
    className="form-control"
    onChange={(e) => setStart(e.target.value)}
/>
      </div>

      <div className="mb-2">
       <label htmlFor="dateFin">
    Date fin
</label>

<input
    id="dateFin"
    type="date"
    className="form-control"
    onChange={(e) => setEnd(e.target.value)}
/>
      </div>

      {/* ASSURANCE */}
      <div className="mb-2">
       <label htmlFor="assurance">
    Assurance
</label>

<select
    id="assurance"
    className="form-control"
    value={assuranceId}
    onChange={(e) => setAssuranceId(e.target.value)}
>
          <option value="">Aucune</option>

          {assurances.map((a) => (
            <option key={a.id} value={a.id}>
              {a.type} (+{a.prix_base} DH)
            </option>
          ))}
        </select>
      </div>

      {/* TOTAL */}
      <h6 className="mt-2">
        Total : {total} DH
      </h6>

      {/* BUTTONS */}
  <button
  className="btn btn-success w-100 mt-2"
  onClick={handleSubmit}
>
  Confirmer
</button>

      <button
        className="btn btn-outline-secondary w-100 mt-2"
       
  onClick={() => {
    
    window.location.reload();
  }}
>
        Fermer
      </button>

    </div>
  </div>
  );
}

export default ReservationForm;