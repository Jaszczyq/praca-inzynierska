@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div id="controls-carousel" class="relative w-full" data-carousel="slide">
                            <!-- Carousel wrapper -->
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                @foreach($events as $event)
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img
                                            onclick="openModalDetails({{ $event->id }}); event.preventDefault();"
                                            style="aspect-ratio: 16/9; width: 100%; object-fit: cover; border-radius: 10px;"
                                            src="{{ $event->image }}" alt="{{ $event->title }}"
                                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        />
                                        <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-50 text-white p-4 flex justify-center">
                                            <h2 class="text-lg md:text-2xl font-bold">{{ $event->title }}</h2>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button"
                                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                    data-carousel-prev>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M5 1 1 5l4 4"/>
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button"
                                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                    data-carousel-next>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #controls-carousel {
            z-index: 1;
        }
    </style>

    @component('events.modal_details', ['categories' => $categories])
    @endcomponent
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var buyUrlTemplate = "{{ route('seats', ':id') }}";

        var currentBuyUrl = buyUrlTemplate.replace(':id', -1);

        var modalDetails = document.getElementById("modal_details");

        const options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};

        document.getElementById("buyButton").addEventListener("click", function () {
            window.location.href = currentBuyUrl;
        });

        function openModalDetails(id) {
            modalDetails.style.display = "block";

            fetch('/events/' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("event_title").textContent = data.title;
                    document.getElementById("event_description").textContent = data.description;
                    document.getElementById("event_city").textContent = data.city;
                    document.getElementById("event_place").textContent = data.place;
                    document.getElementById("event_date").textContent = new Date(data.date).toLocaleDateString('pl-PL', options);
                    document.getElementById("event_time").textContent = data.time;
                    document.getElementById("event_categories").textContent = data.category;
                    currentBuyUrl = buyUrlTemplate.replace(':id', id);
                });
        }

        function closeModalDetails() {
            modalDetails.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === modalDetails) {
                modalDetails.style.display = "none";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

@endsection
