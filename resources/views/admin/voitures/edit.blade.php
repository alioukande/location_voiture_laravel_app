<h1>Modifier la voiture</h1>

<form action="{{ route('voitures.update', $voiture->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    
```
<label>Marque</label><br>
<input type="text" name="marque" value="{{ ( $voiture->marque) }}"><br><br>

<label>Model</label><br>
<input type="text" name="model" value="{{ ( $voiture->model) }}"><br><br>

<label>Annee</label><br>
<input type="number" name="annee" value="{{ ( $voiture->annee) }}"><br><br>

<label>Prix_par_jour</label><br>
<input type="number" name="prix_par_jour" value="{{ ( $voiture->prix_par_jour) }}"><br><br>

<label>Image</label><br>
<input type="file" name="image"><br><br>

<label>Statut</label>
<select name="statut" class="form-control">
<option value="disponible" {{ $voiture->statut == 'disponible' ? 'selected' : '' }}>
Disponible
</option>
<option value="reservee" {{ $voiture->statut == 'reservee' ? 'selected' : '' }}>
Reservee
</option>
<!-- <option value="en cours" {{ $voiture->statut == 'en cours' ? 'selected' : '' }}>
En cours
</option> -->
<option value="louee" {{ $voiture->statut == 'louee' ? 'selected' : '' }}>
Louee
</option>
<option value="maintenance" {{ $voiture->statut == 'maintenance' ? 'selected' : '' }}>
maintenance
</option>
</select>


<br><br>


<h3 class="mt-4">Assurances</h3>

<div class="row">
@foreach($assurances as $assurance)

```
<div class="col-md-4 mb-3">
    <div class="card p-3 shadow-sm">

        <div class="form-check">

            <input 
                class="form-check-input"
                type="checkbox"
                name="assurances[]"
                value="{{ $assurance->id }}"
                id="assurance{{ $assurance->id }}"
                {{ $voiture->assurances->contains('id',$assurance->id) ? 'checked' : '' }}
            >

            <label class="form-check-label" for="assurance{{ $assurance->id }}">
                <strong>{{ $assurance->type }}</strong><br>
                Prix : {{ $assurance->prix_base }} DH
            </label>

        </div>

    </div>
</div>
```

@endforeach

</div>

<br>

<button type="submit">💾 Mettre à jour</button>
```

</form>


