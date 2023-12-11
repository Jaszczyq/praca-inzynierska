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
            <div class="card-body bg-white"
                 style="align-self: flex-start;border: 1px solid #e2e8f0; border-radius: 5px; padding: 20px;">
                <form id="payment-form">
                    <input type="text" id="name" placeholder="Imię">
                    <input type="text" id="surname" placeholder="Nazwisko">
                    <input type="text" id="account-number" placeholder="Numer konta">
                    <input type="text" id="amount" placeholder="Kwota">
                    <button type="submit">Zapłać</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('payment-form').addEventListener('submit', function(event) {
            event.preventDefault();

            var name = document.getElementById('name').value;
            var surname = document.getElementById('surname').value;
            var accountNumber = document.getElementById('account-number').value;
            var amount = document.getElementById('amount').value;

            // Tutaj możesz zrobić coś z danymi, np. wysłać je na serwer
            console.log(name, surname, accountNumber, amount);
        });
    </script>
@endsection
