@extends('layouts.main', ['title' => $title ])
 
@section('content')

<!-- Timeline Block -->
<div id="myTimeline">
    <ul class="timeline-events">
        @foreach ($busAgenda as $key => $bus)
            @foreach ($bus->agenda as $agenda)
                <li data-timeline-node="{ start:'{{ $agenda->start_date }}', end:'{{ $agenda->finish_date }}', row:{{ $key + 1 }}, content:'{{ $agenda->uuid }}' }">{{ $agenda->customername }}</li>
            @endforeach
        @endforeach
    </ul>
</div>
 
@endsection

@push('extra-scripts')
    <link rel="stylesheet" href="{{asset('assets/jquery-timeline/dist/jquery.timeline.min.css')}}">
    <script src="{{asset('assets/jquery-timeline/dist/jquery.timeline.min.js')}}"></script>

    <script type="text/javascript">
        $(function () {
            const busRow = {!!json_encode($busRow)!!};
            $("#myTimeline").Timeline({
                scale: "day",
                colorScheme: {
                    event: {
                        text:       '#24140e',
                        border:     '#7E837F',
                        background: '#00BFB3'
                    }
                },
                headline: {
                    display: true,
                    title:   "Agenda Bus",
                    range:   true,
                    local:   "id-ID",
                    format:  {
                        timeZone: "UTC", hour12: false,
                    }
                },
                ruler: {
                    truncateLowers: false,
                    top: {
                        lines: [ 'year', 'month', 'day' ],
                        format: {
                            year:  'numeric',
                            month: 'long',
                            day:   'numeric',
                        }
                    },
                    bottom: {
                        lines: [ 'day' ],
                        format: {
                            day:  'numeric',
                        }
                    }
                },
                sidebar: {
                    sticky:  true,
                    list:    busRow
                },
            })

            $("#myTimeline").Timeline('openEvent', function(event) {
                const uuid = event.content;
                const url = '{!! url('/sale/book/show/detail'); !!}'
                window.location.href = url + '/' + uuid;
                return false;
            });
        });
    </script>
@endpush