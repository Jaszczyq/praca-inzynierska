@extends('layouts.app')

@php
    $halls = App\Models\Hall::all();
@endphp

@section('content')
    <style>
        .row {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 40px;
            position: relative;
            border-bottom: solid 1px #e1e1e1;
        }

        .seat {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            padding: 0px;
        }

        .seat .seat_container {
            width: 40px;
            height: 40px;
            max-width: 40px;
            max-height: 40px;
            display: grid;
            place-items: center;
        }

        .seat .seat_container > * {
            grid-column-start: 1;
            grid-row-start: 1;
        }

        .seat .seat_container span {
            display: inline;
            color: white !important;
            font-size: 16pt;
            font-weight: bold;
            text-shadow: 0px 0px 3px black;
            z-index: 2;
        }

        .seat.available img {
            filter: invert(33%) sepia(84%) saturate(5858%) hue-rotate(199deg) brightness(90%) contrast(100%);
        }

        .seat.selected img {
            filter: invert(54%) sepia(37%) saturate(7144%) hue-rotate(340deg) brightness(101%) contrast(101%);
        }

        .seat.disabled img {
            filter: invert(73%) sepia(7%) saturate(3%) hue-rotate(322deg) brightness(96%) contrast(81%);
        }
    </style>
    <link rel="stylesheet" type="text/css" href="resources/css/seats.css">


    @component('booking.seats_creator_sections_modal')
    @endcomponent

    <div id="errorPopup" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 m-auto w-fit hidden" role="alert">
        <span class="font-medium">{{ __('creator.error') }}</span> {{ __('creator.save_error') }}
    </div>
    <div id="successPopup" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 m-auto w-fit hidden" role="alert">
        <span class="font-medium">{{ __('creator.success') }}</span> {{ __('creator.save_success') }}
    </div>
    <div class="flex justify-center items-center mt-8">
        <form id="cinemaHallForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" autocomplete="off">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="hallNameInput">
                    {{ __('creator.hall_name') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="hallNameInput" name="hallName" required>
            </div>
            <div class="mb-4">
                <span class="text-gray-700 text-sm font-bold mb-2">{{ __('creator.options') }}</span>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="option" value="load" checked>
                        <span class="ml-2">{{ __('creator.load_from_db') }}</span>
                    </label>
                </div>
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="option" value="generate">
                        <span class="ml-2">{{ __('creator.generate_new') }}</span>
                    </label>
                </div>
            </div>
            <div class="mb-4" id="hallListContainer">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="hallList">
                    Wybierz Salę:
                </label>
                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-4" id="hallList" name="hallList">
                    @if (count($halls) > 0)
                        @foreach ($halls as $hall)
                            <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                        @endforeach
                    @elseif (count($halls) == 0)
                        <option value="">{{ __('creator.no_halls_in_db') }}</option>
                    @endif
                </select>
                <div class="flex items-center justify-between">
                    <button id="loadHallButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline m-auto">
                        {{ __('creator.load_hall') }}
                    </button>
                </div>
            </div>
            <div class="mb-4 hidden" id="hallGenerateContainer">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="rowsInput">
                        {{ __('creator.rows') }}
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" id="rowsInput" name="rows" min="1" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="columnsInput">
                        {{ __('creator.columns') }}
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" id="columnsInput" name="columns" min="1" required>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <button id="generateHallButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline m-auto">
                        {{ __('creator.generate_hall') }}
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between mb-4">
                <button id="openSectionEditButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline m-auto">
                    {{ __('creator.open_section_editor') }}
                </button>
            </div>
            <div class="flex items-center justify-between mt-4">
                <button id="saveButton" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline m-auto">
                    {{ __('creator.save') }}
                </button>
            </div>
        </form>
    </div>
    <div class="hallContainer" style="position: relative;">
        <div id="cinemaHall"></div>
        <!--canvas id="hallCanvas" style="position: absolute; z-index: -1; top: 0; left: 0; width: 100%; height: 100%;"></canvas-->
    </div>

    <div id="dropdownDelay" class="hidden z-10 divide-y rounded-lg shadow w-44 bg-gray-700 divide-gray-600">
        <ul class="py-2 text-sm text-gray-200" aria-labelledby="dropdownDelayButton">
            <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="assingToSection()">Przypisz do sekcji</a>
            </li>
            <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Usuń</a>
            </li>
        </ul>
    </div>

    <script>
        document.querySelectorAll('input[name="option"]').forEach(input => {
            input.addEventListener('change', function() {
                const hallListContainer = document.getElementById('hallListContainer');
                const hallGenerateContainer = document.getElementById('hallGenerateContainer');
                if (this.value === 'load') {
                    hallListContainer.classList.remove('hidden');
                    hallGenerateContainer.classList.add('hidden');
                } else {
                    hallListContainer.classList.add('hidden');
                    hallGenerateContainer.classList.remove('hidden');
                }
            });
        });

        var loadedHallId = null;

        function getHall(hallId) {
            const hallList = document.getElementById('hallList');

            const formData = new FormData();
            formData.append('hallId', hallId);

            var url = "{{ route('booking.get_hall', ':id') }}";

            url = url.replace(":id", hallId);

            return fetch(url, {
                method: 'GET'
            }).then(response => {
                return response.json();
            }).catch(error => {
                console.log(error);
                return null;
            });
        }

        function loadHall(hallId) {
            getHall(hallId).then(hall => {
                var hall_data = hall.hall;

                var name = hall_data.name;
                var json_template = JSON.parse(hall_data.json_template);

                document.getElementById('hallNameInput').value = name;

                clearHall();

                if(json_template.hallData) {
                    var sections = json_template.sections;

                    const sectionList = document.getElementById('sectionList');

                    for (let i = 0; i < sections.length; i++) {
                        const s = sections[i];
                        const sectionRow = document.createElement('div');
                        sectionRow.className = 'flex items-center mb-2 bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer';
                        sectionRow.style.backgroundColor = s.color;
                        sectionRow.id = s.id;
                        sectionRow.onclick = (e) => {
                            if (e.target.tagName === 'INPUT') return;
                            if (selectedSection && selectedSection !== sectionRow) {
                                selectedSection.classList.remove('bg-gray-300');
                            }
                            selectedSection = sectionRow;
                            sectionRow.classList.add('bg-gray-300');
                            addSectionToSeats(selectedSeats, sectionRow);
                        };

                        const nameInput = document.createElement('input');
                        nameInput.className = 'shadow appearance-none border rounded py-2 px-3 text-gray-700 mr-2';
                        nameInput.placeholder = 'Nazwa sekcji';
                        nameInput.value = s.name;

                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Usuń';
                        deleteButton.className = 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded';
                        deleteButton.onclick = () => sectionList.removeChild(sectionRow);

                        sectionRow.appendChild(nameInput);
                        sectionRow.appendChild(deleteButton);

                        sectionList.appendChild(sectionRow);
                    }

                    json_template = json_template.hallData;
                }

                var rows = json_template.length;

                for (let i = 0; i < rows; i++) {
                    var row = insertRow();

                    var seats = json_template[i].seats;

                    for (let j = 0; j < seats.length; j++) {
                        var seat = createButton(seats[j].left);

                        seat.dataset.section = seats[j].section ? seats[j].section : null;

                        row.appendChild(seat);
                    }
                }

                loadedHallId = hallId;

                generateGrid();
            });
        }

        let selectionBox = null;
        let isSelecting = false;
        let isDragging = false;
        var initX, initY, firstX, firstY;
        var selectedSeats = [];

        function moveSeatBetweenRows(event, seat) {
            const row = seat.parentElement;

            // get mouse y position and calculate nearest row
            const y = event.clientY;
            const rowHeight = row.offsetHeight;
            const rowY = row.getBoundingClientRect().y;

            const newRowIndex = Math.floor((y - rowY) / rowHeight);

            console.log(newRowIndex);
        }

        function moveSeat(event, seat) {
            if (!isDragging) return;

            let deltaX = event.pageX - firstX;
            let deltaY = event.pageY - firstY;

            if (!checkForCollision(initX + deltaX, seat)) {
                seat.style.left = initX + deltaX + 'px';
                //seat.style.top = initY + deltaY + 'px';
            }
        }

        function checkForCollision(posX, seat) {
            const row = seat.parentElement;

            // get all other seats
            const seats = row.querySelectorAll('.seat');
            var collisions = [];

            seatX = posX;
            seatXRight = seatX + 40;

            for (let i = 0; i < seats.length; i++) {
                const otherSeat = seats[i];

                if (otherSeat === seat) continue;

                const otherSeatLeft = parseInt(otherSeat.style.left, 10);
                const otherSeatRight = otherSeatLeft + 40;

                if ((posX >= otherSeatLeft && posX <= otherSeatRight) ||
                    (seatXRight >= otherSeatLeft && seatXRight <= otherSeatRight)) {
                    collisions.push({left: otherSeatLeft, right: otherSeatRight});
                }
            }

            //console.log(collisions);

            if (collisions.length > 0) {
                const bestPosition = findBestPosition(posX, collisions);
                seat.style.left = bestPosition + 'px';
                return true;
            }

            return false;
        }

        function assignToSection(event) {
            event.preventDefault();
            openSectionModal();
        }

        function generateJson() {
            // get all seats with left position and row number, sort by left position desc
            const rows = document.querySelectorAll('.row');

            let json = [];

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];

                var rowJson = [];

                const seats = row.querySelectorAll('.seat');

                for (let j = 0; j < seats.length; j++) {
                    const seat = seats[j];

                    rowJson.push({
                        left: parseInt(seat.style.left),
                        section: seat.dataset.section !== undefined ? seat.dataset.section : null
                    });
                }

                rowJson.sort((a, b) => {
                    return b.left - a.left;
                })

                json.push({
                    row: i + 1,
                    seats: rowJson
                })
            }

            var fullData = {
                hallData: json,
                sections: []
            }

            const sections = document.querySelectorAll('[id^="section_"]');

            for (let i = 0; i < sections.length; i++) {
                const section = sections[i];

                fullData.sections.push({
                    id: section.id,
                    name: section.querySelector('input').value,
                    color: section.style.backgroundColor
                });
            }

            return fullData;
        }

        function findBestPosition(posX, collisions) {
            const sortedCollisions = collisions.sort((a, b) => a.left - b.left);
            const halfOfPageWidth = Math.floor(window.innerWidth / 2);
            const seatWidth = 40;

            let bestPosition;

            if (posX < halfOfPageWidth) {
                // Szukaj najlepszej pozycji z lewej strony
                return sortedCollisions[sortedCollisions.length - 1].left - seatWidth;
            } else {
                // Szukaj najlepszej pozycji z prawej strony
                return sortedCollisions[0].right;
            }

            return bestPosition !== undefined ? bestPosition : posX;
        }

        function removeSeats() {
            for (const seat of selectedSeats) {
                seat.remove('selected');
            }
        }

        function insertSeat(row) {
            // get biggest left
            const seats = row.querySelectorAll('.seat');

            let biggestLeft = 0;

            for (const seat of seats) {
                const seatLeft = parseInt(seat.style.left, 10);

                if (seatLeft > biggestLeft) {
                    biggestLeft = seatLeft;
                }
            }

            biggestLeft += 40;

            if(biggestLeft < Math.floor(window.innerWidth / 2) && row.children.length == 0) {
                biggestLeft = Math.floor(window.innerWidth / 2);
            }

            var seat = createButton(biggestLeft);

            row.appendChild(seat);
        }

        function insertRow() {
            const rowDiv = document.createElement('div');
            rowDiv.classList.add('row');

            rowDiv.addEventListener('contextmenu', function(e) {
                e.preventDefault();

                // check if target is a seat or is  img
                if (e.target.classList.contains('seat') || e.target.tagName === 'IMG') return;

                insertSeat(rowDiv);
            });

            document.getElementById('cinemaHall').appendChild(rowDiv);

            return rowDiv;
        }

        function clearHall() {
            const rows = document.querySelectorAll('.row');

            for (const row of rows) {
                row.remove();
            }
        }

        function createButton(left) {
            const seatButton = document.createElement('button');
            seatButton.classList.add('seat', 'available');
            seatButton.style.position = 'absolute';
            seatButton.style.left = left + 'px';

            seatButton.addEventListener('click', function(event) {
                if (seatButton.classList.contains('selected')) {
                    seatButton.classList.remove('selected');
                }
                else {
                    seatButton.classList.add('selected');
                }
            });

            seatButton.addEventListener('mousedown', function(event) {
                event.preventDefault()
                isDragging = true;
                initX = seatButton.offsetLeft;
                initY = seatButton.offsetTop;
                firstX = event.pageX;
                firstY = event.pageY;

                seatButton.classList.add('dragging');
            });

            seatButton.addEventListener('contextmenu', function(event) {
                event.preventDefault();
                document.getElementById('dropdownDelay').classList.remove('hidden');

                document.getElementById('dropdownDelay').style.left = event.pageX + 'px';
                document.getElementById('dropdownDelay').style.top = event.pageY + 'px';
                document.getElementById('dropdownDelay').style.position = 'absolute';
            })

            const seatContainer = document.createElement('div');
            seatContainer.classList.add('seat_container');

            const seatImage = document.createElement('img');
            seatImage.src = '/images/events/couch-solid.png';
            seatImage.alt = 'Seat';

            seatContainer.appendChild(seatImage);
            seatButton.appendChild(seatContainer);

            return seatButton;
        }

        function openSectionModal() {
            document.getElementById('sectionDialog').style.display = 'block';
            generateGrid();
        }

        document.getElementById('loadHallButton').addEventListener('click', function(e) {
            e.preventDefault();

            var selectedHall = document.getElementById('hallList').value;

            loadHall(selectedHall);
        })

        document.getElementById('openSectionEditButton').addEventListener('click', function(e) {
            e.preventDefault();

            openSectionModal();
        })

        document.getElementById('generateHallButton').addEventListener('click', function(e) {
            e.preventDefault();

            clearHall();

            const rows = parseInt(document.getElementById('rowsInput').value);
            const columns = parseInt(document.getElementById('columnsInput').value);
            const cinemaHall = document.getElementById('cinemaHall');
            cinemaHall.innerHTML = ''; // Czyść salę przed generowaniem nowej

            for (let row = 1; row <= rows; row++) {
                const rowDiv = document.createElement('div');
                rowDiv.classList.add('row');

                rowDiv.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    insertSeat(rowDiv);
                })

                var halfOfColumns = columns / 2;
                var halfOfPageWidth = Math.floor(window.innerWidth / 2);

                for (let column = 1; column <= columns; column++) {
                    var left = ((-halfOfColumns+column-1) * 40 + halfOfPageWidth);
                    //console.log("(("+-halfOfColumns+"+"+column+"-"+1+") * 40 + "+halfOfPageWidth+")");
                    const seatButton = createButton(left);
                    rowDiv.appendChild(seatButton);
                }

                cinemaHall.appendChild(rowDiv);
            }
        });

        document.getElementById('cinemaHallForm').addEventListener('submit', function(e) {
            e.preventDefault();
        });

        document.getElementById('saveButton').addEventListener('click', function(e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('_token', '{{ csrf_token() }}');
            if (loadedHallId) {
                formData.append('id', loadedHallId);
            }
            formData.append('name', document.getElementById('hallNameInput').value);
            formData.append('json_template', JSON.stringify(generateJson()));

            var url = "{{ route('booking.save_hall') }}";

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    document.getElementById('successPopup').classList.remove('hidden');
                    document.getElementById('errorPopup').classList.add('hidden');
                }
                else {
                    document.getElementById('errorPopup').classList.remove('hidden');
                    document.getElementById('successPopup').classList.add('hidden');
                }

                setTimeout(function() {
                    document.getElementById('successPopup').classList.add('hidden');
                    document.getElementById('errorPopup').classList.add('hidden');
                }, 3000);
            });
        });

        window.addEventListener('mousedown', function(e) {
            // if target is inside #cinemaHallForm or one of its children ignore event
            if (e.target.closest('#cinemaHallForm') || e.target.closest('#cinemaHall') || e.target.closest('#sectionDialog') || e.target.closest('#errorPopup')) {
                return;
            }
            isSelecting = true;
            selectionBox = document.createElement('div');
            selectionBox.style.position = 'absolute';
            selectionBox.style.border = '1px dashed #000';
            document.body.appendChild(selectionBox);
            selectionBox.startX = e.pageX;
            selectionBox.startY = e.pageY;

            // check if is clicked on seat
            var seats = document.querySelectorAll('.seat');

            for (let i = 0; i < seats.length; i++) {
                if (seats[i].contains(e.target)) {
                    return;
                }
            }

            selectedSeats = [];

            seats = document.querySelectorAll('.seat.selected');

            for (let i = 0; i < seats.length; i++) {
                seats[i].classList.remove('selected');
            }

            document.getElementById('dropdownDelay').classList.add('hidden');
        });

        window.addEventListener('mousemove', function(event) {
            if (isDragging) {
                moveSeat(event, document.querySelector('.seat.dragging'));
            }
            else if (isSelecting) {
                const minX = Math.min(selectionBox.startX, event.pageX);
                const maxX = Math.max(selectionBox.startX, event.pageX);
                const minY = Math.min(selectionBox.startY, event.pageY);
                const maxY = Math.max(selectionBox.startY, event.pageY);

                selectionBox.style.left = minX + 'px';
                selectionBox.style.top = minY + 'px';
                selectionBox.style.width = maxX - minX + 'px';
                selectionBox.style.height = maxY - minY + 'px';

                selectedSeats = [];

                var seats = document.querySelectorAll('.seat.selected');

                for (let i = 0; i < seats.length; i++) {
                    seats[i].classList.remove('selected');
                }

                seats = document.querySelectorAll('.seat');

                for (const seat of seats) {
                    const boundingRect = seat.getBoundingClientRect();
                    const seatLeft = boundingRect.left + window.scrollX;
                    const seatTop = boundingRect.top + window.scrollY;
                    const seatRight = seatLeft + boundingRect.width;
                    const seatBottom = seatTop + boundingRect.height;

                    if (seatRight > minX && seatLeft < maxX && seatBottom > minY && seatTop < maxY) {
                        seat.classList.add('selected');
                        selectedSeats.push(seat);
                    }
                }
            }
        });

        window.addEventListener('mouseup', function(event) {
            isDragging = false;
            if (isSelecting) {
                isSelecting = false;
                document.body.removeChild(selectionBox);

                const minX = Math.min(selectionBox.startX, event.pageX);
                const maxX = Math.max(selectionBox.startX, event.pageX);
                const minY = Math.min(selectionBox.startY, event.pageY);
                const maxY = Math.max(selectionBox.startY, event.pageY);
            }
            const draggedSeat = document.querySelector('.seat.dragging');
            if (draggedSeat) {
                draggedSeat.classList.remove('dragging');
            }
        });

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Delete') {
                removeSeats();
            }
            else if (e.key === 'Enter') {
                insertRow();
            }
        });
    </script>

    <!--
    <script src="node_modules/flowbite/dist/flowbite.min.js"></script> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/hexToRGB.js') }}"></script>

@endsection
