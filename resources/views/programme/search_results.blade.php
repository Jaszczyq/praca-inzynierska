<div id="search-results">
    @foreach ($events as $event)
        <div class="event">
            <h3>{{ $event->name }}</h3>
            <!-- Dodaj inne informacje o wydarzeniach -->
        </div>
    @endforeach
</div>
