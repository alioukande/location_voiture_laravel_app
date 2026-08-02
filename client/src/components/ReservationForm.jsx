import { useState, useEffect } from "react";
import { Modal, Button, Form } from "react-bootstrap";
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
    method: "POST",
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
   .then(async (res) => {
  const data = await res.json();

  if (!res.ok) {
    throw new Error(data.message || "Erreur lors de la réservation");
  }

  return data;
})
.then((data) => {
  console.log("✅ RESPONSE:", data);
  alert("Réservation créée avec succès !");
  onClose();
})
.catch((err) => {
  console.error(err);
  alert(err.message);
});
};

  return (
   
    <Modal
    show={true}
    onHide={onClose}
    centered
    backdrop="static"
  >
    <Modal.Header closeButton>
      <Modal.Title>
        {voiture.marque} {voiture.model}
      </Modal.Title>
    </Modal.Header>

    <Modal.Body>

      <img
        src={`http://localhost:8000/storage/${voiture.image}`}
        alt={voiture.marque}
        className="img-fluid rounded mb-3"
      />

      <p className="fw-bold">
        💰 {voiture.prix_par_jour} DH / jour
      </p>

      <Form.Group className="mb-3">
        <Form.Label>Date début</Form.Label>
        <Form.Control
          type="date"
          onChange={(e) => setStart(e.target.value)}
        />
      </Form.Group>

      <Form.Group className="mb-3">
        <Form.Label>Date fin</Form.Label>
        <Form.Control
          type="date"
          onChange={(e) => setEnd(e.target.value)}
        />
      </Form.Group>

      <Form.Group className="mb-3">
        <Form.Label>Assurance</Form.Label>

        <Form.Select
          value={assuranceId}
          onChange={(e) => setAssuranceId(e.target.value)}
        >
          <option value="">Aucune</option>

          {assurances.map((a) => (
            <option key={a.id} value={a.id}>
              {a.type} (+{a.prix_base} DH)
            </option>
          ))}
        </Form.Select>

      </Form.Group>

      <h5 className="text-success">
        Total : {total.toFixed(2)} DH
      </h5>

    </Modal.Body>

    <Modal.Footer>

      <Button
        variant="secondary"
        onClick={onClose}
      >
        Fermer
      </Button>

      <Button
        variant="success"
        onClick={handleSubmit}
      >
        Confirmer
      </Button>

    </Modal.Footer>

  </Modal>
);
}

export default ReservationForm;