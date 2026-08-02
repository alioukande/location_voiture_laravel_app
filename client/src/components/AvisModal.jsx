

import { useState } from "react";

function AvisModal({ reservation, onClose }) {

    const [note, setNote] = useState(0);
    const [commentaire, setCommentaire] = useState("");

    const envoyerAvis = async (e) => {

        e.preventDefault();

        const token = localStorage.getItem("token");
        if (note === 0) {
    alert("Veuillez sélectionner une note.");
    return;
}

        const response = await fetch(
            "http://127.0.0.1:8000/api/avis",
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },

                body: JSON.stringify({
                    reservation_id: reservation.id,
                    voiture_id: reservation.voiture.id,
                    note,
                    commentaire,
                }),
            }
        );

        const data = await response.json();

        if (response.ok) {

            alert("Avis envoyé avec succès.");

            onClose();

        } else {

            alert(data.message || "Erreur");

        }

    };

    return (

        <div
            className="modal d-block"
            style={{ background: "rgba(0,0,0,.5)" }}
        >

            <div className="modal-dialog">

                <div className="modal-content">

                    <div className="modal-header">

                        <h5 className="modal-title">

                            ⭐ Donner votre avis

                        </h5>

                        <button
                            className="btn-close"
                            onClick={onClose}
                        ></button>

                    </div>

                    <form onSubmit={envoyerAvis}>

                        <div className="modal-body">

                            <h5>

                                {reservation.voiture.marque}{" "}
                                {reservation.voiture.model}

                            </h5>

                            <div className="mb-3">

    <p className="form-label fw-bold mb-2">
    Votre note
</p>

    <div className="d-flex justify-content-center">

       {[1, 2, 3, 4, 5].map((etoile) => (

    <button
        key={etoile}
        type="button"
        onClick={() => setNote(etoile)}
        className="btn p-0 border-0 bg-transparent"
        style={{
            fontSize: "40px",
            cursor: "pointer",
            color: etoile <= note ? "#ffc107" : "#d3d3d3",
            margin: "0 5px"
        }}
    >
        ★
    </button>

))}

    </div>

</div>
<p htmlFor="commentaire" className="form-label fw-bold">
    Votre commentaire

</p>

                            <textarea
                                className="form-control"
                                rows="4"
                                placeholder="Votre commentaire..."
                                value={commentaire}
                                onChange={(e) =>
                                    setCommentaire(e.target.value)
                                }
                            ></textarea>

                        </div>

                        <div className="modal-footer">

                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={onClose}
                            >
                                Fermer
                            </button>

                           <button
    type="submit"
    className="btn btn-warning fw-bold"
>
    ⭐ Envoyer mon avis
</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    );
}

export default AvisModal;