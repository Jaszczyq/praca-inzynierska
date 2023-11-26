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

    /*
     * <div class="row">
        <button class="seat disabled">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 160C64 89.3 121.3 32 192 32H448c70.7 0 128 57.3 128 128v33.6c-36.5 7.4-64 39.7-64 78.4v48H128V272c0-38.7-27.5-71-64-78.4V160zM544 272c0-20.9 13.4-38.7 32-45.3c5-1.8 10.4-2.7 16-2.7c26.5 0 48 21.5 48 48V448c0 17.7-14.3 32-32 32H576c-17.7 0-32-14.3-32-32H96c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V272c0-26.5 21.5-48 48-48c5.6 0 11 1 16 2.7c18.6 6.6 32 24.4 32 45.3v48 32h32H512h32V320 272z"/></svg>
        </button>
        <!-- ... -->
    </div>
    <div class="row">
        <button class="seat disabled">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 160C64 89.3 121.3 32 192 32H448c70.7 0 128 57.3 128 128v33.6c-36.5 7.4-64 39.7-64 78.4v48H128V272c0-38.7-27.5-71-64-78.4V160zM544 272c0-20.9 13.4-38.7 32-45.3c5-1.8 10.4-2.7 16-2.7c26.5 0 48 21.5 48 48V448c0 17.7-14.3 32-32 32H576c-17.7 0-32-14.3-32-32H96c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V272c0-26.5 21.5-48 48-48c5.6 0 11 1 16 2.7c18.6 6.6 32 24.4 32 45.3v48 32h32H512h32V320 272z"/></svg>
        </button>
        <!-- ... -->
    </div>
    <!-- ... -->

    <button class="seat" id="seat_{{ $row }}_{{ $column }}">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 160C64 89.3 121.3 32 192 32H448c70.7 0 128 57.3 128 128v33.6c-36.5 7.4-64 39.7-64 78.4v48H128V272c0-38.7-27.5-71-64-78.4V160zM544 272c0-20.9 13.4-38.7 32-45.3c5-1.8 10.4-2.7 16-2.7c26.5 0 48 21.5 48 48V448c0 17.7-14.3 32-32 32H576c-17.7 0-32-14.3-32-32H96c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V272c0-26.5 21.5-48 48-48c5.6 0 11 1 16 2.7c18.6 6.6 32 24.4 32 45.3v48 32h32H512h32V320 272z"/></svg>
            </button>
     */
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
    @for($row = 1; $row <= $rows; $row++)
        <div class="row">
        @for($column = $columns; $column > 0; $column--)
            @if($column == $left_side)
                <button class="seat available" id="seat_{{ $row }}_{{ $column }}" style="margin-right: 20px;">
            @elseif($column == $columns - $right_side + 1)
                <button class="seat available" id="seat_{{ $row }}_{{ $column }}" style="margin-left: 20px;">
            @else
                <button class="seat available" id="seat_{{ $row }}_{{ $column }}">
            @endif
                <div class="seat_container">
                    <span id="seat_nr_{{ $row }}_{{ $column }}" style="display: none; color: white !important;">{{$column}}</span>
                    <img src="{{url('/images/events/couch-solid.png')}}" alt="Seat">
                </div>
            </button>
        @endfor
    @endfor

    <script>
        document.querySelectorAll('.seat').forEach(seat => {
            seat.addEventListener('click', (e) => {
                var target = e.target;
                var clickedButton;
                if (target.tagName === 'BUTTON') {
                    clickedButton = target;
                }
                else {
                    clickedButton = target.closest('button');
                }
                if (!clickedButton.classList.contains('disabled')) {
                    if(clickedButton.classList.contains('selected')) {
                        clickedButton.classList.remove('selected');
                        clickedButton.querySelector('span').style.display = 'none';
                    }
                    else {
                        clickedButton.classList.add('selected');
                        clickedButton.querySelector('span').style.display = 'inline';
                    }
                }
            });
        });
    </script>

    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection
