@php
    function translateMonths($dateString) {
        $months = [
            'January' => 'Styczeń',
            'February' => 'Luty',
            'March' => 'Marzec',
            'April' => 'Kwiecień',
            'May' => 'Maj',
            'June' => 'Czerwiec',
            'July' => 'Lipiec',
            'August' => 'Sierpień',
            'September' => 'Wrzesień',
            'October' => 'Październik',
            'November' => 'Listopad',
            'December' => 'Grudzień',
        ];

        return str_replace(
            array_keys($months),
            array_values($months),
            $dateString
        );
    }
@endphp

@forelse ($events as $event)
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="border: 1px solid #e2e8f0; border-radius: 5px; margin: 10px 0">
        <div class="wyd-szukaj-table">
            <div class="table-row d-flex align-items-start border-2 rounded-lg overflow-hidden w-full text-center line-height-0">

                <div class="row-cell cell-wyd-lista-1 me-3 text-center p-2 my-auto">

                    <div class="text-center p-4 w-36 flex flex-col justify-center h-full">
                        <div class="no-warp linia-1">
                            <b>{{ translateMonths($event->date->format('j F Y')) }}</b>
                        </div>
                        <div class="no-warp linia-2">
                            godz. {{ substr($event->time, 0, strlen($event->time) - 3) }}
                        </div>
                        <div>
                        <span class="no-warp linia-3">
                            <b>{{ $event->ticketType }}</b>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="row-cell cell-wyd-lista-2 me-3 align-middle p-0 line-height-0 text-xs">
                    <a href="{{ route('event.details', ['id' => $event->id]) }}"
                       title="{{ $event->title }}">
                        <img src="{{ $event->image }}" alt="{{ $event->title }}"
                             class="mx-auto my-auto" width="163px" height="110px"/>
                    </a>
                </div>
                <div
                    class="row-cell cell-wyd-lista-3 me-3 my-auto p-4 text-left relative overflow-hidden table-cell align-middle line-height-normal" style="width: 30%">
                    <div class="flex flex-col justify-center h-full">
                        <div><b>{{ $event->title }}</b></div>
                        <div>{{ $event->description }}</div>
                    </div>
                </div>
                <div
                    class="row-cell cell-wyd-lista-4 me-3 my-auto p-4 w-56 table-cell align-middle line-height-normal text-center" style="width: 25%">
                    <div class="flex flex-col justify-center h-full">
                        <div><b>{{ $event->place }}</b></div>
                    </div>
                </div>
                <div
                    class="row-cell cell-wyd-lista-5 my-auto p-4 w-30 table-cell align-middle line-height-normal text-center">
                    <div class="flex flex-col justify-center h-full">
                        <a href="" class="btn btn-success">Kup bilet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@empty
    <p class="text-center">Brak wydarzeń na ten dzień.</p>
@endforelse
