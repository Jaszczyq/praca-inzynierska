@extends('layouts.app')

@php
    use App\Models\TicketType;
    use Illuminate\Support\Facades\DB;

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

    function translateDays($dayString) {
    $days = [
        'Monday' => 'Poniedziałek',
        'Tuesday' => 'Wtorek',
        'Wednesday' => 'Środa',
        'Thursday' => 'Czwartek',
        'Friday' => 'Piątek',
        'Saturday' => 'Sobota',
        'Sunday' => 'Niedziela',
    ];

    return str_replace(
        array_keys($days),
        array_values($days),
        $dayString
    );


}



@endphp

@section('content')
    <div class="container">
        <div class="card"
             style="background-color: #F0F0F0; border: none; padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="card-body bg-white" style="align-self: flex-start;border: 1px solid #e2e8f0; border-radius: 5px; padding: 20px;">
                <div>
                    <ul style="list-style-type: none; padding: 0;">
                        @php $id = 0; @endphp
                        @foreach ($selectedSeats as $seat)
                            @php $seat_part = explode('_', $seat); @endphp
                            <li style="margin-bottom: 10px;">
                                <span>Rząd: {{ $seat_part[0] }}</span>
                                <span style="margin-left: 10px;">Miejsce: {{ $seat_part[1] }}</span>
                                <span style="margin-left: 10px;">Typ biletu:
        <select id="select_ticket_{{$id}}" onchange="calculateTotalPrice()">
            @php
                $types = TicketType::all();
                $event_ticket_prices = DB::table('event_ticket_types')->where('event_id', $event->id)->get(['id', 'price']);
                $event_ticket_prices = array_combine($event_ticket_prices->pluck('id')->toArray(), $event_ticket_prices->pluck('price')->toArray());

                foreach ($types as $type) {
                    echo '<option value="' . $type->id . '" data-price="' . ($event_ticket_prices[$type->id] ?? 0) . '">' . $type->name . '</option>';
                }
            @endphp
        </select>
    </span>
                                <span id="ticket_price_{{$id}}"
                                      style="margin-left: 10px; font-weight: bold; text-transform: uppercase">0 zł</span>
                            </li>
                            @php $id++; @endphp
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card-body bg-white" style="border: 1px solid #e2e8f0; border-radius: 5px; padding: 20px;">
                <p style="font-weight: bold; text-transform: uppercase; display: flex; align-items: center;">
    <span style="display: inline-block; margin-right: 10px;">
        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
            <path
                d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
        </svg>
    </span>
                    {{ $event->city }} · {{ $event->place }}
                </p>
                <hr class="my-3">
                <p style="font-weight: bold; text-transform: uppercase; display: flex; align-items: center;">
    <span style="display: inline-block; margin-right: 10px;">
        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path
                d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H336zM64 400v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H208zm112 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H336c-8.8 0-16 7.2-16 16z"/>
        </svg>
    </span>
                    @if ($event->date->isToday())
                        Dzisiaj,
                    @else
                        {{ translateDays($event->date->format('l')) }},
                    @endif
                    {{ translateMonths($event->date->format('j F Y')) }}
                    , {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                </p>
                <hr class="my-3">
                <h2 style="font-weight: bold; margin-bottom: 20px;">{{ $event->title }}</h2>
                <div id="ticket_summary" style="background-color: #F4F4F7; border-radius: 10px; padding: 20px;">
                </div>
                <div style="margin-top: 20px;">
                    <h2 style="font-weight: bold; text-transform: uppercase">Razem to zapłaty: <span
                            id="totalPrice"></span> zł</h2>
                </div>
            </div>
        </div>
    </div>
    <script>
        function calculateTotalPrice() {
            let total = 0;
            let selectedTickets = document.querySelectorAll('select[id^="select_ticket_"]');
            let ticketSummary = {};
            let ticketPriceSummary = {};

            for (let i = 0; i < selectedTickets.length; i++) {
                let selectedOption = selectedTickets[i].options[selectedTickets[i].selectedIndex];
                let price = parseFloat(selectedOption.dataset.price);
                let ticketType = selectedOption.innerText;

                document.getElementById(`ticket_price_${i}`).innerText = `Cena: ${price} zł`;
                total += price;

                ticketSummary[ticketType] = (ticketSummary[ticketType] || 0) + 1;
                ticketPriceSummary[ticketType] = (ticketPriceSummary[ticketType] || 0) + price;
            }

            // Aktualizacja podsumowania
            let summaryContainer = document.getElementById('ticket_summary');
            summaryContainer.innerHTML = '';

            for (let [type, count] of Object.entries(ticketSummary)) {
                let ticketLine = document.createElement('p');

                let price = document.createElement('span');
                price.innerText = `${ticketPriceSummary[type]} zł`.toUpperCase();
                price.style.fontWeight = 'bold';

                ticketLine.append(document.createTextNode(`${type} x${count}, `));
                ticketLine.append(price);

                summaryContainer.appendChild(ticketLine);
            }

            document.getElementById('totalPrice').innerText = total;
        }

        window.onload = calculateTotalPrice;
    </script>
@endsection
