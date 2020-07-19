<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pekerjaan</title>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <style>
        body {
            color: #000;
            background: #fff;
        }

        .container {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .text-center{
            text-align: center;
        }

        .text-right{
            text-align: right;
        }

        .font-weight-normal{
            font-weight: normal;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                {{-- <img src="{{ asset('images/logo.png') }}" alt="" width="64"> --}}
                <h2 class="font-weight-normal">PROJECT MANAGEMENT</h2>
                <h4>Laporan Pekerjaan</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table cellspacing="5" cellpadding="5">
                    <tr>
                        <th class="text-right">No. Id</th>
                        <td>:</td>
                        <td>{{ $job->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Nama Pekerjaan</th>
                        <td>:</td>
                        <td>{{ $job->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Tanggal Dibuat</th>
                        <td>:</td>
                        <td>{{ $job->created_at }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Terakhir Diubah</th>
                        <td>:</td>
                        <td>{{ $job->updated_at }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Dibuat Oleh</th>
                        <td>:</td>
                        <td>{{ $job->user->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Progress Pekerjaan</th>
                        <td>:</td>
                        <td>{{ $job->progress }}%</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6"></div>
        </div>
        <hr style="margin: 20px 0">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Departement</th>
                            <th scope="col">PIC</th>
                            <th scope="col">Jumlah Pekerjaan</th>
                            <th scope="col">Detail Pekerjaan</th>
                            <th scope="col">Tanggal Dibuat</th>
                            <th scope="col">Tim</th>
                            <th scope="col">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalTasks = 0;
                        @endphp
                        @forelse ($job->departements as $key => $departement)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $departement->name }}</td>
                            <td>{{ $departement->user->name }}</td>
                            <td>{{ $departement->tasks->count() }}</td>
                            <td>
                                @foreach ($departement->tasks as $task)
                                    @php $totalTasks += 1 @endphp
                                    - {{ $task->name }} ({{ $task->status }}) <br>
                                @endforeach
                            </td>
                            <td>{{ $departement->created_at }}</td>
                            <td>
                                @php $format = ''; @endphp
                                @foreach ($departement->users as $team)
                                    @php $format .= $team->name.', ' @endphp
                                @endforeach
                                {{ substr($format , 0, -2) }}
                            </td>
                            <td>{{ $departement->progress }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <th colspan="6" scope="row" class="text-center">DATA TIDAK DITEMUKAN</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <table cellspacing="5" cellpadding="5">
                    <tr>
                        <th>Total Departement</th>
                        <td>:</td>
                        <td>{{ $job->departements->count() }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Pekerjaan</th>
                        <td>:</td>
                        <td>{{ $totalTasks }}</td>
                    </tr>
                    <tr>
                        <th>Timeline</th>
                        <td>:</td>
                        <td>{{ $job->start }} - {{ $job->end }} ({{ $rangeDayTimeline }} Hari)</td>
                    </tr>
                    @if ($rangeFinishDay)
                        <tr>
                            <th>Pekerjaan Selesai</th>
                            <td>:</td>
                            <td>{{ $job->deleted_at }} ({{ $rangeFinishDay }} Hari)</td>
                        </tr>
                        @if (($rangeFinishDay - $rangeDayTimeline) > 0 )
                            <tr>
                                <th>Diluar Timeline</th>
                                <td>:</td>
                                <td style="color:#ff0000">Terlambat {{ $rangeFinishDay - $rangeDayTimeline }} Hari</td>
                            </tr>
                        @endif
                    @endif
                </table>
            </div>
        </div>
    </div>
</body>

</html>