@extends('layouts.app')

@php
    function translateMonths($dateString) {
        $months = [
                    'January' => 'stycznia',
                     'February' => 'lutego',
                     'March' => 'marca',
                     'April' => 'kwietnia',
                     'May' => 'maja',
                     'June' => 'czerwca',
                     'July' => 'lipca',
                     'August' => 'sierpnia',
                     'September' => 'września',
                     'October' => 'października',
                     'November' => 'listopada',
                     'December' => 'grudnia',
        ];

        return str_replace(
            array_keys($months),
            array_values($months),
            $dateString
        );
    }

    $rows = 15;
    $columns = 20;
    $left_side = 5;
    $right_side = 5;

@endphp

@section('content')
    <style>
        .row {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .seat {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            margin: 5px;
            position: relative;
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
    <div class="container">
        <div class="card bg-white" style="border: none;">
            <div class="card-body" style="border: 1px solid #e2e8f0; border-radius: 5px">
                <h2 id="eventTitle"></h2>
                <p id="eventDateTime"></p>
                <p id="eventLocation"></p>
                @for($row = 1; $row <= $rows; $row++)
                    <div class="row">
                        @for($column = $columns; $column > 0; $column--)
                            @if($column == $left_side)
                                <button class="seat available" id="seat_{{ $row }}_{{ $column }}"
                                        style="margin-right: 20px;">
                                    @elseif($column == $columns - $right_side + 1)
                                        <button class="seat available" id="seat_{{ $row }}_{{ $column }}"
                                                style="margin-left: 20px;">
                                            @else
                                                <button class="seat available" id="seat_{{ $row }}_{{ $column }}">
                                                    @endif
                                                    <div class="seat_container">
                                                    <span id="seat_nr_{{ $row }}_{{ $column }}"
                                                          style="display: none; color: white !important;">{{$column}}</span>
                                                        <img src="{{url('/images/events/couch-solid.png')}}" alt="Seat">
                                                    </div>
                                                </button>
                                @endfor
                                @endfor
                    </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary" id="reserve-btn" disabled>Rezerwuj</button>
                <button class="btn btn-success" id="buy-btn" disabled>Kup bulet</button>
            </div>
        </div>

        <script>
            function isAnySeatSelected() {
                return document.querySelectorAll('.seat.selected').length > 0;
            }

            function switchButtons() {
                if (isAnySeatSelected()) {
                    console.log('Any seat selected');
                    document.getElementById('reserve-btn').disabled = false;
                    document.getElementById('buy-btn').disabled = false;
                }
                else {
                    document.getElementById('reserve-btn').disabled = true;
                    document.getElementById('buy-btn').disabled = true;
                }
            }

            document.querySelectorAll('.seat').forEach(seat => {
                seat.addEventListener('click', (e) => {
                    var target = e.target;
                    var clickedButton;
                    if (target.tagName === 'BUTTON') {
                        clickedButton = target;
                    } else {
                        clickedButton = target.closest('button');
                    }
                    if (!clickedButton.classList.contains('disabled')) {
                        if (clickedButton.classList.contains('selected')) {
                            clickedButton.classList.remove('selected');
                            clickedButton.querySelector('span').style.display = 'none';
                        } else {
                            clickedButton.classList.add('selected');
                            clickedButton.querySelector('span').style.display = 'inline';
                        }
                    }
                    switchButtons();
                });
            });

            function getSeatsAsString() {
                var seats = '';
                document.querySelectorAll('.seat.selected').forEach(seat => {
                    seats += seat.id.replace('seat_', '') + ',';
                });
                seats = seats.slice(0, -1);
                return seats;
            }

            document.getElementById("buy-btn").addEventListener("click", function() {
                window.location.href = "/purchase-summary/{{$event->id}}/"+getSeatsAsString();
            });

            document.getElementById("reserve-btn-btn").addEventListener("click", function() {
                window.location.href = "/reservation-summary/{{$event->id}}/"+getSeatsAsString();
            });

            document.getElementById('eventTitle').innerText = event.title;
            document.getElementById('eventDateTime').innerText = event.date + ' at ' + event.time;
            document.getElementById('eventLocation').innerText = event.city + ', ' + event.place;

            // code to display the modal
        </script>

        <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>

@endsection
