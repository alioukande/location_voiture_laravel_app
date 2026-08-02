import React from "react";
import "../css/voiture.css";

function VoitureList({ voitures, onReserve }) {

  return (

    
    
    <div className="container">
      <div className="row">

        {voitures.map((v) => (
          <div className="col-12 col-sm-6 col-md-4 mb-4" key={v.id}>

            <div className="card h-100 border-0 shadow voiture-card">

              {/* IMAGE */}
              <img
                src={`http://127.0.0.1:8000/storage/${v.image}`}
                className="card-img-top voiture-img"
                alt={v.marque}
              />

              <div className="card-body d-flex flex-column">

                <h5 className="card-title">
                  {v.marque} {v.model}
                </h5>

                <p className="prix">
                  💰 {v.prix_par_jour} DH / jour
                </p>

                <p className="mb-2">
                  <span className={v.disponible ? "badge bg-success" : "badge bg-danger"}>
                    {v.disponible ? "Disponible" : "Non disponible"}
                  </span>
                </p>

                <button
                  className="btn btn-primary btn-reserver w-100 mt-auto"
                  onClick={() => onReserve(v)}
                >
                  Réserver
                </button>

              </div>

            </div>

          </div>
        ))}

      </div>
    </div>



  );

  




}

export default VoitureList;