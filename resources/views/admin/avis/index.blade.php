
@extends('layouts.admin')

@section('content')

<h2>Gestion des avis</h2>

<table class="table table-bordered">

    <thead>
        <tr>
            <th>Client</th>
            <th>Voiture</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        @foreach($avis as $a)

        <tr>

            <td>
                {{ $a->user->name }}
            </td>

            <td>
                {{ $a->reservation->voiture->marque }}
                {{ $a->reservation->voiture->model }}
            </td>

            <td>
                {{ $a->note }}/5 ⭐
            </td>

            <td width="40%">

    <strong>Commentaire :</strong><br>

    {{ $a->commentaire }}

    <hr>

    @if($a->reponse_admin)

        <div class="alert alert-success mt-2">

            <strong>Réponse de l'agence :</strong><br>

            {{ $a->reponse_admin }}

        </div>

    @else

        <form action="{{ route('admin.avis.repondre',$a->id) }}" method="POST">

            @csrf
            @method('PUT')

            <textarea
                name="reponse_admin"
                class="form-control"
                rows="3"
                placeholder="Écrire une réponse au client..."
                required></textarea>

            <button class="btn btn-primary btn-sm mt-2">

                Répondre

            </button>

        </form>

    @endif

</td>

            <td>
                {{ $a->created_at->format('d/m/Y') }}
            </td>

            <td>

                <form
                    action="{{ route('admin.avis.destroy',$a->id) }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        class="btn btn-danger"
                        onclick="return confirm('Supprimer cet avis ?')">

                        Supprimer

                    </button>

                </form>

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

@endsection