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
                <div
                    class="row-cell cell-wyd-lista-5 my-auto p-4 w-30 table-cell align-middle line-height-normal text-center">
                    <div class="flex flex-row justify-center h-full">
                        <a href="#"
                           onclick="openModalEdit({{ $event->id }}); event.preventDefault();"
                           class="bg-white border-white btn btn-primary edit-button mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                 viewBox="0 0 512 512">
                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/>
                            </svg>
                        </a>
                        <a href="#"
                           onclick="openModalDelete({{ $event->id }}); event.preventDefault();"
                           class="btn border-white bg-white btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                 viewBox="0 0 448 512">
                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@empty
    <p class="text-center">{{ __('events.no_events_search_name') }}</p>
@endforelse
