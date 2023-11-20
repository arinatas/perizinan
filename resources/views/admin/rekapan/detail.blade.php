@extends('layouts.main')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        @include('partials.toolbar')
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Detail User</h5>
                                    </div>
                                    <div class="table-responsive my-10 mx-8">
                                        <table class="table table-striped gy-5 gs-5">
                                            <tr>
                                                <th style="width: 100px;">Nama</th>
                                                <td style="text-align: left;">: {{ $akun->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>: {{ $akun->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jabatan</th>
                                                <td>: {{ $akun->jabatan }}</td>
                                            </tr>
                                            <tr>
                                                <th>Devisi</th>
                                                <td>: {{ $akun->devisi->nama_devisi }}</td>
                                            </tr>
                                            <tr>
                                                <th>Atasan</th>
                                                <td>: @if ($akun->devisi->atasanUser)
                                                        {{ $akun->devisi->atasanUser->nama }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Periode</th>
                                                <td>: {{ $startDate }} - {{ $endDate }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Detail Pengajuan Izin</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(count($izinDetails) > 0)
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Jumlah Izin</th>
                                                        <th>No Hp</th>
                                                        <th>Keperluan</th>
                                                        <th>Approve Atasan</th>
                                                        <th>Approve SDM</th>
                                                        <th>Bukti Pendukung</th>
                                                        <!-- Add other izin details as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($izinDetails as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->tanggal }}</td>
                                                            <td>{{ $izin->jumlah_izin }} Hari</td>
                                                            <td>{{ $izin->no_hp }}</td>
                                                            <td>{{ $izin->keperluan }}</td>
                                                            <td>
                                                                @if($izin->approve_atasan == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_atasan == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_atasan == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($izin->approve_sdm == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_sdm == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_sdm == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($izin->bukti_pendukung)
                                                                    <a href="javascript:void(0);" onclick="showBuktiPendukung('{{ asset('uploads/' . $izin->bukti_pendukung) }}')">
                                                                        @if (pathinfo($izin->bukti_pendukung, PATHINFO_EXTENSION) === 'pdf')
                                                                            <i class="fas fa-file-pdf text-danger fa-2x"></i> View
                                                                        @else
                                                                            <i class="fas fa-image text-primary fa-2x"></i> View
                                                                        @endif
                                                                    </a>
                                                                @else
                                                                    No Bukti
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Tidak ada Pengajuan Izin untuk periode ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Detail Pengajuan Sakit</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(count($sakitDetails) > 0)
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Jumlah Izin</th>
                                                        <th>No Hp</th>
                                                        <th>Keterangan</th>
                                                        <th>Approve Atasan</th>
                                                        <th>Approve SDM</th>
                                                        <th>Bukti Pendukung</th>
                                                        <!-- Add other izin details as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sakitDetails as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->tanggal }}</td>
                                                            <td>{{ $izin->jumlah_izin }} Hari</td>
                                                            <td>{{ $izin->no_hp }}</td>
                                                            <td>{{ $izin->keterangan }}</td>
                                                            <td>
                                                                @if($izin->approve_atasan == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_atasan == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_atasan == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($izin->approve_sdm == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_sdm == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_sdm == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($izin->bukti_pendukung)
                                                                    <a href="javascript:void(0);" onclick="showBuktiPendukung('{{ asset('uploads/' . $izin->bukti_pendukung) }}')">
                                                                        @if (pathinfo($izin->bukti_pendukung, PATHINFO_EXTENSION) === 'pdf')
                                                                            <i class="fas fa-file-pdf text-danger fa-2x"></i> View
                                                                        @else
                                                                            <i class="fas fa-image text-primary fa-2x"></i> View
                                                                        @endif
                                                                    </a>
                                                                @else
                                                                    No Bukti
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Tidak ada Pengajuan Izin Sakit untuk periode ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Detail Pengajuan Izin 1/2 Hari</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(count($sethariDetails) > 0)
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Waktu Izin</th>
                                                        <th>No Hp</th>
                                                        <th>Keperluan</th>
                                                        <th>Approve Atasan</th>
                                                        <th>Approve SDM</th>
                                                        <!-- Add other izin details as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sethariDetails as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->tanggal }}</td>
                                                            <td>{{ $izin->waktu }}</td>
                                                            <td>{{ $izin->no_hp }}</td>
                                                            <td>{{ $izin->keperluan }}</td>
                                                            <td>
                                                                @if($izin->approve_atasan == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_atasan == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_atasan == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($izin->approve_sdm == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_sdm == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_sdm == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Tidak ada Pengajuan Izin 1/2 Hari untuk periode ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Detail Pengajuan Izin Meninggalkan Tugas</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(count($meninggalkantugasDetails) > 0)
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Waktu Izin</th>
                                                        <th>No Hp</th>
                                                        <th>Keperluan</th>
                                                        <th>Approve Atasan</th>
                                                        <th>Approve SDM</th>
                                                        <!-- Add other izin details as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($meninggalkantugasDetails as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->tanggal }}</td>
                                                            <td>{{ $izin->waktu }}</td>
                                                            <td>{{ $izin->no_hp }}</td>
                                                            <td>{{ $izin->keperluan }}</td>
                                                            <td>
                                                                @if($izin->approve_atasan == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_atasan == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_atasan == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($izin->approve_sdm == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_sdm == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_sdm == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Tidak ada Pengajuan Izin Meninggalkan Tugas untuk periode ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Detail Pengajuan Tugas Keluar Kantor</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(count($tgsklrkantorDetails) > 0)
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Selesai</th>
                                                        <th>No HP</th>
                                                        <th>Keperluan</th>
                                                        <th>Approve Atasan</th>
                                                        <th>Approve SDM</th>
                                                        <th>Bukti Pendukung</th>
                                                        <!-- Add other izin details as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tgsklrkantorDetails as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->tanggal }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->jam_mulai)->format('H:i') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->jam_selesai)->format('H:i') }}</td>
                                                            <td>{{ $izin->no_hp }}</td>
                                                            <td>{{ $izin->keperluan }}</td>
                                                            <td>
                                                                @if($izin->approve_atasan == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_atasan == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_atasan == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($izin->approve_sdm == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_sdm == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_sdm == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($izin->bukti_pendukung)
                                                                    <a href="javascript:void(0);" onclick="showBuktiPendukung('{{ asset('uploads/' . $izin->bukti_pendukung) }}')">
                                                                        @if (pathinfo($izin->bukti_pendukung, PATHINFO_EXTENSION) === 'pdf')
                                                                            <i class="fas fa-file-pdf text-danger fa-2x"></i> View
                                                                        @else
                                                                            <i class="fas fa-image text-primary fa-2x"></i> View
                                                                        @endif
                                                                    </a>
                                                                @else
                                                                    No Bukti
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Tidak ada Pengajuan Izin Tugas Keluar Kantor untuk periode ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Detail Pengajuan Cuti</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(count($cutiDetails) > 0)
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Jumlah Cuti</th>
                                                        <th>Alamat</th>
                                                        <th>No HP</th>
                                                        <th>Keperluan</th>
                                                        <th>Jenis Cuti</th>
                                                        <th>Approve Atasan</th>
                                                        <th>Approve SDM</th>
                                                        <th>Bukti Pendukung</th>
                                                        <!-- Add other izin details as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cutiDetails as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->tanggal_mulai }}</td>
                                                            <td>{{ $izin->tanggal_selesai }}</td>
                                                            <td>{{ $izin->jumlah_cuti }} Hari</td>
                                                            <td>{{ $izin->alamat }}</td>
                                                            <td>{{ $izin->no_hp }}</td>
                                                            <td>{{ $izin->keperluan }}</td>
                                                            <td>{{ $izin->jenisCuti->nama_cuti }}</td>
                                                            <td>
                                                                @if($izin->approve_atasan == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_atasan == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_atasan == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($izin->approve_sdm == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_sdm == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_sdm == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($izin->bukti_pendukung)
                                                                    <a href="javascript:void(0);" onclick="showBuktiPendukung('{{ asset('uploads/' . $izin->bukti_pendukung) }}')">
                                                                        @if (pathinfo($izin->bukti_pendukung, PATHINFO_EXTENSION) === 'pdf')
                                                                            <i class="fas fa-file-pdf text-danger fa-2x"></i> View
                                                                        @else
                                                                            <i class="fas fa-image text-primary fa-2x"></i> View
                                                                        @endif
                                                                    </a>
                                                                @else
                                                                    No Bukti
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Tidak ada Pengajuan Izin Cuti untuk periode ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Detail Pengajuan Lembur</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(count($lemburDetails) > 0)
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Selesai</th>
                                                        <th>Durasi Lembur</th>
                                                        <th>Keterangan</th>
                                                        <th>Approve Atasan</th>
                                                        <th>Approve SDM</th>
                                                        <th>Bukti Pendukung</th>
                                                        <!-- Add other izin details as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($lemburDetails as $index => $izin)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $izin->tanggal }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->jam_mulai)->format('H:i') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->jam_selesai)->format('H:i') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->durasi_lembur)->format('H:i') }}</td>
                                                            <td>{{ $izin->keterangan_pekerjaan }}</td>
                                                            <td>
                                                                @if($izin->approve_atasan == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_atasan == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_atasan == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($izin->approve_sdm == 0)
                                                                    <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                                @elseif($izin->approve_sdm == 1)
                                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                                @elseif($izin->approve_sdm == 2)
                                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                                @else
                                                                    <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($izin->bukti_pendukung)
                                                                    <a href="javascript:void(0);" onclick="showBuktiPendukung('{{ asset('uploads/' . $izin->bukti_pendukung) }}')">
                                                                        @if (pathinfo($izin->bukti_pendukung, PATHINFO_EXTENSION) === 'pdf')
                                                                            <i class="fas fa-file-pdf text-danger fa-2x"></i> View
                                                                        @else
                                                                            <i class="fas fa-image text-primary fa-2x"></i> View
                                                                        @endif
                                                                    </a>
                                                                @else
                                                                    No Bukti
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Tidak ada Pengajuan Lembur untuk periode ini.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Bukti Pendukung -->
    <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktiModalLabel">Bukti Pendukung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="buktiContent">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showBuktiPendukung(fileSrc) {
            // Periksa ekstensi file
            var fileExtension = fileSrc.split('.').pop().toLowerCase();
            
            if (fileExtension === 'pdf') {
                // Buka PDF di tab baru
                window.open(fileSrc, '_blank');
            } else {
                // Set sumber gambar dan buka modal
                document.getElementById('buktiContent').innerHTML = '<img class="img-fluid" src="' + fileSrc + '" alt="Bukti Pendukung" style="width: 100%; height: auto;">';
                $('#buktiModal').modal('show');
            }
        }
    </script>

@endsection
