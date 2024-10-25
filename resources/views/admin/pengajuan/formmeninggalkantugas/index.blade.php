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
                                            <form action="{{ route('formmeninggalkantugas') }}" method="GET">
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="start_date" class="form-label">Tanggal Awal:</label>
                                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="end_date" class="form-label">Tanggal Akhir:</label>
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
                                        @if ($formmeninggalkantugass )
                                        <div class="table-responsive my-10 mx-8">
                                        <!-- Include this at the top of your view file to show flash messages -->
                                        @if(session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        <table class="table table-striped gy-7 gs-7" id="sortableTable">
                                            <thead>
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                    <th class="min-w-100px">No</th>
                                                    <th class="min-w-100px" data-type="string" onclick="sortTable(1)">Nama ▲</th>
                                                    <th class="min-w-100px" data-type="string" onclick="sortTable(2)">Jabatan ▲</th>
                                                    <th class="min-w-100px" data-type="string" onclick="sortTable(3)">Tanggal ▲</th>
                                                    <th class="min-w-50px" data-type="string" onclick="sortTable(4)">Waktu ▲</th>
                                                    <th class="min-w-100px" data-type="string" onclick="sortTable(5)">Approve Atasan ▲</th>
                                                    <th class="min-w-100px" data-type="string" onclick="sortTable(6)">Approve SDM ▲</th>
                                                    <th class="min-w-100px">Action Atasan</th>
                                                    <th class="min-w-100px">Action SDM</th>
                                                    <th class="min-w-100px">Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1; // Inisialisasi no
                                                @endphp
                                                @foreach ($formmeninggalkantugass as $item)
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->jabatan }}</td>
                                                        <td>{{ $item->tanggal }}</td>
                                                        <td>{{ $item->waktu }}</td>
                                                        <td>
                                                            @if($item->approve_atasan == 0)
                                                                <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                            @elseif($item->approve_atasan == 1)
                                                                <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                            @elseif($item->approve_atasan == 2)
                                                                <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                            @else
                                                                <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($item->approve_sdm == 0)
                                                                <i class="fas fa-hourglass-half text-warning" data-toggle="tooltip" title="Menunggu Persetujuan"></i> Waiting
                                                            @elseif($item->approve_sdm == 1)
                                                                <i class="fas fa-check-circle text-success" data-toggle="tooltip" title="Disetujui"></i> Disetujui
                                                            @elseif($item->approve_sdm == 2)
                                                                <i class="fas fa-times-circle text-danger" data-toggle="tooltip" title="Ditolak"></i> Ditolak
                                                            @else
                                                                <i class="fas fa-question-circle text-muted" data-toggle="tooltip" title="Status Tidak Dikenali"></i> Status Tidak Dikenali
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group d-flex flex-column">
                                                                <!-- Atasan Approve/Unapprove/Reject Buttons -->
                                                                <form method="post" action="{{ route('formmeninggalkantugas.approve-atasan', $item->id) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-success btn-action mb-2 w-100" data-toggle="tooltip" title="Approve Atasan"><i class="fas fa-check"></i> Approve</button>
                                                                </form>

                                                                <form method="post" action="{{ route('formmeninggalkantugas.unapprove-atasan', $item->id) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-warning btn-action mb-2 w-100" data-toggle="tooltip" title="Unapprove Atasan"><i class="fas fa-undo"></i> Unapprove</button>
                                                                </form>

                                                                <form method="post" action="{{ route('formmeninggalkantugas.reject-atasan', $item->id) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger btn-action w-100" data-toggle="tooltip" title="Reject Atasan"><i class="fas fa-times"></i> Reject</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group d-flex flex-column">
                                                                <!-- SDM Approve/Unapprove/Reject Buttons -->
                                                                <form method="post" action="{{ route('formmeninggalkantugas.approve-sdm', $item->id) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-success btn-action mb-2 w-100" data-toggle="tooltip" title="Approve SDM"><i class="fas fa-check"></i> Approve</button>
                                                                </form>

                                                                <form method="post" action="{{ route('formmeninggalkantugas.unapprove-sdm', $item->id) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-warning btn-action mb-2 w-100" data-toggle="tooltip" title="Unapprove SDM"><i class="fas fa-undo"></i> Unapprove</button>
                                                                </form>

                                                                <form method="post" action="{{ route('formmeninggalkantugas.reject-sdm', $item->id) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger btn-action w-100" data-toggle="tooltip" title="Reject SDM"><i class="fas fa-times"></i> Reject</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-info btn-action" title="Detail Pengajuan Izin" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}"><i class="fas fa-eye"></i></a>
                                                            {{-- modal here --}}
                                                            <!--begin::Modal - New Card-->
                                                            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                                                <!--begin::Modal dialog-->
                                                                <div class="modal-dialog modal-dialog-centered mw-850px">
                                                                    <!--begin::Modal content-->
                                                                    <div class="modal-content">
                                                                        <!--begin::Modal header-->
                                                                        <div class="modal-header">
                                                                            <!--begin::Modal title-->
                                                                            <h2>Detail Pengajuan Izin : {{ $item->nama }} </h2>
                                                                            <!--end::Modal title-->
                                                                            <!--begin::Close-->
                                                                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                                                <span class="svg-icon svg-icon-1">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                                                                    </svg>
                                                                                </span>
                                                                                <!--end::Svg Icon-->
                                                                            </div>
                                                                            <!--end::Close-->
                                                                        </div>
                                                                        <!--end::Modal header-->
                                                                        <!--begin::Modal body-->
                                                                        <div class="modal-body scroll-y mx-xl-8">
                                                                            <!--begin::content modal body-->
                                                                            <div class="table-responsive my-10 mx-8">
                                                                                <table class="table table-striped gy-7 gs-7">
                                                                                <tr>
                                                                                    <th>Nama</th>
                                                                                    <td>{{ $item->nama }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Jabatan</th>
                                                                                    <td>{{ $item->jabatan }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Devisi</th>
                                                                                    <td>{{ $item->devisi->nama_devisi }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Tanggal Izin</th>
                                                                                    <td>{{ $item->tanggal }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Waktu</th>
                                                                                    <td>{{ $item->waktu }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>No HP</th>
                                                                                    <td>{{ $item->no_hp }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Keperluan</th>
                                                                                    <td>{{ $item->keperluan }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Approve Atasan</th>
                                                                                    <td>
                                                                                        @if($item->approve_atasan == 1)
                                                                                            <span class="text-success"><i class="fas fa-check"></i> Disetujui</span>
                                                                                        @elseif($item->approve_atasan == 0)
                                                                                            <span class="text-warning"><i class="fas fa-clock"></i> Menunggu</span>
                                                                                        @elseif($item->approve_atasan == 2)
                                                                                            <span class="text-danger"><i class="fas fa-times"></i> Ditolak</span>
                                                                                        @else
                                                                                            <span class="text-muted">Not Reviewed</span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th>Approve SDM</th>
                                                                                    <td>
                                                                                        @if($item->approve_sdm == 1)
                                                                                            <span class="text-success"><i class="fas fa-check"></i> Disetujui</span>
                                                                                        @elseif($item->approve_sdm == 0)
                                                                                            <span class="text-warning"><i class="fas fa-clock"></i> Menunggu</span>
                                                                                        @elseif($item->approve_sdm == 2)
                                                                                            <span class="text-danger"><i class="fas fa-times"></i> Ditolak</span>
                                                                                        @else
                                                                                            <span class="text-muted">Not Reviewed</span>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Tanggal Input</th>
                                                                                    <td>{{ $item->created_at }}</td>
                                                                                </tr>
                                                                                </table>
                                                                            </div>
                                                                            <!--end::content modal body-->
                                                                        </div>
                                                                        <!--end::Modal body-->
                                                                    </div>
                                                                    <!--end::Modal content-->
                                                                </div>
                                                                <!--end::Modal dialog-->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $no++; // Tambahkan no setiap kali iterasi
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        @else
                                        <div class="my-10 mx-15">
                                            <!--begin::Notice-->
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black" />
                                                        <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                    <!--begin::Content-->
                                                    <div class="mb-3 mb-md-0 fw-bold">
                                                        <h4 class="text-gray-900 fw-bolder">Belum ada data</h4>
                                                        <div class="fs-6 text-gray-700 pe-7">Belum ada data yang diinputkan</div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Notice-->
                                        </div>
                                        @endif
                                        <!--end::Table-->
                                        <!--begin::Notice-->
                                        @if (!$startDate || !$endDate)
                                        <div class="my-10 mx-15">
                                            <!--begin::Notice-->
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                                <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none">
                                                        <path opacity="0.3"
                                                            d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z"
                                                            fill="black" />
                                                        <path
                                                            d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div
                                                    class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                    <!--begin::Content-->
                                                    <div class="mb-3 mb-md-0 fw-bold">
                                                        <h4 class="text-gray-900 fw-bolder">Silakan filter terlebih dahulu berdasarkan tanggal awal & tanggal akhir
                                                        </h4>
                                                        <div class="fs-6 text-gray-700 pe-7">Pilih tanggal awal & tanggal akhir pada formulir di atas untuk melihat
                                                            data.</div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
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
                    <script>
                        let sortOrder = {}; // Object to track sort order for each column

                        function sortTable(columnIndex) {
                            const table = document.getElementById("sortableTable");
                            const tbody = table.tBodies[0];
                            const rows = Array.from(tbody.rows);
                            const type = table.rows[0].cells[columnIndex].getAttribute('data-type');

                            // Determine the current sort order
                            const currentOrder = sortOrder[columnIndex] || 'asc';
                            const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
                            sortOrder[columnIndex] = newOrder; // Update the sort order for the clicked column

                            const sortedRows = rows.sort((a, b) => {
                                const aText = a.cells[columnIndex].textContent.trim();
                                const bText = b.cells[columnIndex].textContent.trim();

                                if (type === 'string') {
                                    return newOrder === 'asc'
                                        ? aText.localeCompare(bText)
                                        : bText.localeCompare(aText);
                                }
                                return newOrder === 'asc'
                                    ? aText - bText
                                    : bText - aText; // for numeric values
                            });

                            // Remove existing rows and append the sorted rows
                            tbody.innerHTML = "";
                            tbody.append(...sortedRows);

                            // Update header indicator
                            const header = table.rows[0].cells[columnIndex];
                            header.innerHTML = header.innerHTML.includes('▲') ? header.innerHTML.replace('▲', '▼') : header.innerHTML.replace('▼', '▲');
                        }
                    </script>
@endsection
