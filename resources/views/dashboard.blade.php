@extends(config('laravisitors.layout'))

@section('title', 'Dashboard LaraVisitors')

@section('content')
    <div class="container">
        <h1 class="mb-4"><i class="fa-solid fa-chart-line"></i> {{ __('laravisitors::messages.title') }}</h1>

        <!-- Filters per date -->
        <div class="row mb-4">
            <div class="col">
                <div class="card shadow-sm p-3">
                    <form method="GET" action="{{ route('laravisitors.dashboard') }}"
                        class="row gy-2 gx-3 align-items-center">

                        <div class="col-12 col-md-auto d-flex align-items-center">
                            <label for="start_date" class="col-form-label me-2 mb-0">{{ __('laravisitors::messages.from') }}</label>
                            <input type="date" id="start_date" name="start_date" class="form-control form-control-sm"
                                value="{{ $start }}" max="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-12 col-md-auto d-flex align-items-center">
                            <label for="end_date" class="col-form-label me-2 mb-0">{{ __('laravisitors::messages.to') }}</label>
                            <input type="date" id="end_date" name="end_date" class="form-control form-control-sm"
                                value="{{ $end }}" max="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-12 col-md-auto">
                            <button type="submit" class="btn btn-primary btn-sm w-100 w-md-auto">
                                <i class="fas fa-filter"></i> {{ __('laravisitors::messages.filter') }}
                            </button>
                        </div>

                        <div class="col-12 col-md-auto">
                            <a href="{{ route('laravisitors.export', ['start_date' => $start, 'end_date' => $end]) }}"
                                class="btn btn-success btn-sm w-100 w-md-auto">
                                <i class="fas fa-file-csv"></i> {{ __('laravisitors::messages.export') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Résumé -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="float-start"><i class="fa-solid fa-eye fa-2x"></i></div>
                        <h5 class="card-title">{{ __('laravisitors::messages.total_visits') }}</h5>
                        <p class="card-text fs-4">{{ $totalVisits }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="float-start"><i class="fa-solid fa-computer fa-2x"></i></div>
                        <h5 class="card-title">{{ __('laravisitors::messages.unique_visitors') }}</h5>
                        <p class="card-text fs-4">{{ $uniqueVisits }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="float-start"><i class="fa-solid fa-user-tie fa-2x"></i></div>
                        <h5 class="card-title">{{ __('laravisitors::messages.identified_visitors') }}</h5>
                        <p class="card-text fs-4">{{ $uniqueIdentifiedVisits }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="float-start"><i class="fa-solid fa-link fa-2x"></i></div>
                        <h5 class="card-title">{{ __('laravisitors::messages.online_visitors') }}</h5>
                        <p class="card-text fs-4">{{ $onlineVisitors->count() }}
                            @if ($onlineVisitors->count() > 0)
                                <button type="button" class="btn btn-link p-0 m-0 align-baseline" data-bs-toggle="modal"
                                    data-bs-target="#onlineVisitor">
                                    <i class="fa-solid fa-eye"></i> {{ __('laravisitors::messages.see') }}
                                </button>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="onlineVisitor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="onlineVisitorLabel">{{ __('laravisitors::messages.online_users_list') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($onlineVisitors as $visitor)
                            {{ data_get($visitor, config('laravisitors.user_display_attribute')) }}<br>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('laravisitors::messages.close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics by identified user -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="h4 mb-3">{{ __('laravisitors::messages.identified_user_stats') }}</h2>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('laravisitors::messages.user') }}</th>
                            <th>{{ __('laravisitors::messages.visits') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userStats as $userStat)
                            <tr>
                                <td>{{ $userStat->user_name }}</td>
                                <td>{{ $userStat->visits }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- URL visits -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="h4 mb-3">{{ __('laravisitors::messages.popular_urls') }}</h2>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('laravisitors::messages.url') }}</th>
                            <th>{{ __('laravisitors::messages.visits') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($popularPages as $page)
                            <tr>
                                <td>{{ $page->url }}</td>
                                <td>{{ $page->visits }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Evolution of visits -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="h4 mb-3">
                    {{ __('laravisitors::messages.visits_evolution', ['start' => $start, 'end' => $end]) }}
                </h2>
                <canvas id="visitsChart" height="100" data-chart="true"></canvas>
            </div>
        </div>

        <!-- Navigator & Device Statistics -->
        <div class="row
                    mb-4">
            <div class="col-md-6">
                <h2 class="h4 mb-3">{{ __('laravisitors::messages.browser_stats') }}</h2>
                <canvas id="browserChart" height="100" data-chart="true"></canvas>
            </div>
            <div class="col-md-6">
                <h2 class="h4 mb-3">{{ __('laravisitors::messages.device_stats') }}</h2>
                <canvas id="deviceChart" height="100" data-chart="true"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            let chartsInitialized = false;

            function initCharts() {
                if (chartsInitialized) return;
                if (typeof Chart === 'undefined') return;

                const visitsEl = document.getElementById('visitsChart');
                const browserEl = document.getElementById('browserChart');
                const deviceEl = document.getElementById('deviceChart');

                if (!visitsEl || !browserEl || !deviceEl) {
                    console.warn('[LaraVisitors] Canvas manquants — init annulée.');
                    return;
                }

                new Chart(visitsEl.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: @json($visitsOverTime->pluck('date')),
                        datasets: [{
                            label: 'Visites par jour',
                            data: @json($visitsOverTime->pluck('visits')),
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    }
                });

                new Chart(browserEl.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: @json($browserStats->pluck('browser')),
                        datasets: [{
                            data: @json($browserStats->pluck('visits')),
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(153, 102, 255)'
                            ]
                        }]
                    }
                });

                new Chart(deviceEl.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: @json($deviceStats->pluck('device')),
                        datasets: [{
                            data: @json($deviceStats->pluck('visits')),
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)'
                            ]
                        }]
                    }
                });

                chartsInitialized = true;
                document.dispatchEvent(new CustomEvent('laravisitors:chartsReady'));
            }

            if (typeof Chart !== 'undefined') {
                initCharts();
            }

            document.addEventListener('chartJsLoaded', initCharts);
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Chart !== 'undefined') initCharts();
            });
        })();
    </script>
@endsection
