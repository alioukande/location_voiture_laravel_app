import { useEffect, useState } from "react";
import VoitureList from "./components/VoitureList";
import ReservationForm from "./components/ReservationForm";
import Login from "./components/Login";
import Navbar from "./components/Navbar";
import Footer from "./components/Footer";

function App() {
  const [voitures, setVoitures] = useState([]);
  const [selectedCar, setSelectedCar] = useState(null);
  const [search, setSearch] = useState("");


  useEffect(() => {
    fetch("http://127.0.0.1:8000/api/voitures")
      .then(res => res.json())
      .then(data => setVoitures(data));
  }, []);

  const voituresFiltrees = voitures.filter((v) =>
    (v.marque || "").toLowerCase().includes(search.toLowerCase()) ||
    (v.model || "").toLowerCase().includes(search.toLowerCase())
  );
  const [isLogged,setIsLogged]=useState(
    !!localStorage.getItem("token")
);
if(!isLogged){

    return <Login onLogin={()=>setIsLogged(true)}/>

}


const logout = () => {
  localStorage.removeItem("token");
  setIsLogged(false);
};

  return (
     <div className="container py-4">

    <Navbar logout={logout} />

    <div className="mt-4 text-center">
      <h2 className="fw-bold">🚗 Nos voitures disponibles</h2>
      <p className="text-muted">
        Trouvez le véhicule idéal pour votre prochain trajet.
      </p>
    </div>

    <input
      type="text"
      className="form-control mb-3"
      placeholder="Rechercher..."
      value={search}
      onChange={(e) => setSearch(e.target.value)}
    />

    <VoitureList
      voitures={voituresFiltrees}
      onReserve={setSelectedCar}
    />

    {selectedCar && (
      <ReservationForm
        voiture={selectedCar}
        onClose={() => setSelectedCar(null)}
      />
    )}
 <Footer />

  </div>
  );
}

export default App;