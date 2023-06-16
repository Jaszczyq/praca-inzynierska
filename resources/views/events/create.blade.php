@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dodaj wydarzenie</h1>

        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Tytuł</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Opis</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="place">Miejsce</label>
                <input type="text" class="form-control" id="place" name="place" required>
            </div>

            <div class="form-group">
                <label for="date">Data</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label for="time">Godzina</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>

            <div class="form-group">
                <label for="image">Obraz</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>

            <button type="submit" class="btn btn-primary">Dodaj</button>
        </form>
    </div>
@endsection
