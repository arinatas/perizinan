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
                        <!--begin::Heading-->
                        <div class="card-px pt-10 d-flex justify-content-between">
                            <!--begin::Title-->
                            <div class="d-inline mt-2">
                                <h2 class="fs-2x fw-bolder mb-0">{{ $title }}</h2>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!-- Filter Form -->
                        <div class="card-px mt-10">
                            <form action="{{ route('rekapan') }}" method="GET">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Tanggal Mulai:</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Tanggal Selesai:</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Filter Form -->

                        <!--begin::Table-->
                        @if ($startDate && $endDate && $akuns)
                            <div class="table-responsive my-10 mx-8">
                                <table class="table table-striped gy-7 gs-7">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                            <th class="min-w-50px">No</th>
                                            <!-- Add other table headers as needed -->
                                            <th class="min-w-100px">Nama</th>
                                            <th class="min-w-100px">Izin</th>
                                            <th class="min-w-100px">Sakit</th>
                                            <th class="min-w-100px">1/2 Hari</th>
                                            <th class="min-w-100px">Meninggalkan Tugas</th>
                                            <th class="min-w-100px">Tugas Keluar</th>
                                            <th class="min-w-100px">Cuti</th>
                                            <th class="min-w-100px">Lembur</th>
                                            <th class="min-w-50px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1; // Inisialisasi no
                                        @endphp
                                        @foreach ($akuns as $item)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <!-- Add other table cells as needed -->
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $izinCounts[$item->id] ?? 0 }}</td>
                                                <td>{{ $izinSakitCounts[$item->id] ?? 0 }}</td>
                                                <td>{{ $izinSetengahHariCounts[$item->id] ?? 0 }}</td>
                                                <td>{{ $izinMeninggalkanTugasCounts[$item->id] ?? 0 }}</td>
                                                <td>{{ $izinTgsKlrKantorCounts[$item->id] ?? 0 }}</td>
                                                <td>{{ $izinCutiCounts[$item->id] ?? 0 }}</td>
                                                <td>{{ $izinLemburCounts[$item->id] ?? 0 }}</td>
                                                <td>
                                                    <a href="{{ route('rekapan.detail', ['id' => $item->id, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-primary btn-action" data-toggle="tooltip" title="Detail">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $no++; // Tambahkan no setiap kali iterasi
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <!--end::Table-->
                        
                        <!--begin::Notice-->
                        @if (!$startDate || !$endDate)
                            <div class="alert alert-warning mt-4">
                                Silahkan filter terlebih dahulu berdasarkan tanggal.
                            </div>
                        @endif
                        <!--end::Notice-->
                        
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Menghentikan tindakan penghapusan asli
            if (confirm("Apakah Anda yakin ingin menghapus?")) {
                // Jika pengguna menekan OK dalam konfirmasi, lanjutkan dengan penghapusan
                event.target.form.submit();
            }
        }
    </script>
@endsection
