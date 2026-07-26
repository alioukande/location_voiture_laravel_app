@extends('layouts.admin')

@section('content')

<h2>Liste des assurances</h2>

<a href="{{ route('admin.assurances.create') }}" class="btn btn-primary mb-3">
➕ Ajouter une assurance
</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Type</th>
            <th>Description</th>
            <th>Prix de base (DH)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assurances as $assurance)
        <tr>
            <td>{{ $assurance->type }}</td>
            <td>{{ $assurance->description }}</td>
            <td>{{ $assurance->prix_base }} DH</td>
            <td>
                <a href="{{ route('admin.assurances.edit', $assurance->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                <form action="{{ route('admin.assurances.destroy', $assurance->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection