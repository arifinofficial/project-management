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
        .page_break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                {{-- <img src="{{ asset('images/logo.png') }}" alt="" width="64"> --}}
                <h2 class="font-weight-normal">PROJECT MANAGEMENT</h2>
                <h4>Laporan Karyawan</h4>
                <h4>Pada Bulan {{ $monthYear[1] }}-{{ $monthYear[0] }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table cellspacing="5" cellpadding="5">
                    <tr>
                        <th class="text-right">Id Karyawan</th>
                        <td>:</td>
                        <td>{{ $person->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Nama Karyawan</th>
                        <td>:</td>
                        <td>{{ $person->name }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6"></div>
        </div>
        <hr style="margin: 20px 0">
        <div class="row">
            <div class="col-12">
                <p>PIC</p>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Pekerjaan</th>
                            <th scope="col">Departement</th>
                            <th scope="col">PIC</th>
                            <th scope="col">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalTasks = 0;
                        @endphp
                        @forelse ($personPic as $key => $pic)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $pic->job->name }}</td>
                            <td>{{ $pic->name }}</td>
                            <td>{{ $pic->user->name }}</td>
                            <td>{{ $pic->progress }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <th colspan="5" scope="row" class="text-center">DATA TIDAK DITEMUKAN</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="page_break"></div>
                <p>Laporan Pekerjaan</p>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Pekerjaan</th>
                            <th scope="col">Departement</th>
                            <th scope="col">PIC</th>
                            <th scope="col">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalTasks = 0;
                        @endphp
                        @forelse ($personReport as $key => $pic)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $pic->job->name }}</td>
                            <td>{{ $pic->name }}</td>
                            <td>{{ $pic->user->name }}</td>
                            <td>{{ $pic->progress }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <th colspan="5" scope="row" class="text-center">DATA TIDAK DITEMUKAN</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>