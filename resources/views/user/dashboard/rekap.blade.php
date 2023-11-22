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
										<!--begin::Heading-->
										<!--begin::Row-->
										<div class="row g-5 g-xl-8">
											<div class="accordion" id="accordionExample">
												<div class="accordion-item">
												  <h2 class="accordion-header" id="headingOne">
													<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
													  Form Izin
													</button>
												  </h2>
												  <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
													<div class="accordion-body">
														<div class="col-lg-12">
															<!--begin::Notice-->
															<div class="card-px text-center">
																<!--begin::Title-->
																	<h1>Form Izin</h1>
																<!--end::Title-->
															</div>
															<div class="table-responsive">
																<table class="table table-row-bordered gy-5">
																	<thead>
																		<tr class="fw-bold fs-5">
																			<th>Nama</th>
																			<th>Tgl</th>
																			<th>Jml</th>
																			<th>Keperluan</th>
																			<th>Atasan</th>
																			<th>Bukti</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($formIzin as $item)
																			<tr>
																				<td>{{ $item->nama }}</td>
																				<td>{{ $item->tanggal }}</td>
																				<td>{{ $item->jumlah_izin }} Hari</td>
																				<td>{{ $item->keperluan }}</td>
																				<td>
																					@if ($item->approve_atasan == 0)
																					<span class="badge bg-warning text-dark">Waiting</span>
																					@elseif($item->approve_atasan == 1)
																					<span class="badge bg-success">Approved</span>
																					@elseif($item->approve_atasan == 2)
																					<span class="badge bg-danger">Rejected</span>
																					@endif
																				</td>
																				<td>
																					<a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModalIzin{{ $item->id }}">
																						<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Visible.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																								<rect x="0" y="0" width="24" height="24"/>
																								<path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																								<path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
																							</g>
																						</svg><!--end::Svg Icon--></span>
																					</a>
									
																					<!--begin::Modal - New Card-->
																					<div class="modal fade" id="detailModalIzin{{ $item->id }}" tabindex="-1" aria-hidden="true">
																						<!--begin::Modal dialog-->
																						<div class="modal-dialog modal-dialog-centered mw-850px">
																							<!--begin::Modal content-->
																							<div class="modal-content">
																								<!--begin::Modal header-->
																								<div class="modal-header">
																									<!--begin::Modal title-->
																									<h2>File Bukti</h2>
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
																									@if ($item->bukti_pendukung)
																										@php
																											$extension = pathinfo($item->bukti_pendukung, PATHINFO_EXTENSION);
																										@endphp
									
																										@if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
																											{{-- Display image --}}
																											<img src="{{ asset('storage/' . $item->bukti_pendukung) }}" alt="Bukti Pendukung" class="img-fluid mx-auto d-block mt-10">
									
																										@elseif (in_array(strtolower($extension), ['pdf']))
																											{{-- Display PDF --}}
																											<a href="{{ asset('storage/' . $item->bukti_pendukung) }}" target="_blank">View PDF</a>
																										@else
																											{{-- Handle other file types --}}
																											<p>File type not supported</p>
																										@endif
																									@else
																										No File Available
																									@endif
																									<!--end::content modal body-->
																								</div>
																								<!--end::Modal body-->
																							</div>
																							<!--end::Modal content-->
																						</div>
																						<!--end::Modal dialog-->
																					</div>
																					<!--end::Modal - New Card-->
																				</td>
																				@if ($item->approve_atasan == 0)
																				<td>
																					<div class="btn-group d-flex">
																						<!-- Atasan Approve/Unapprove/Reject Buttons -->
																						<form method="post" action="{{ route('formizin.approve-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-success btn-action w-100" data-toggle="tooltip" title="Approve Atasan"><i class="fas fa-check"></i></button>
																						</form>
						
																						<form method="post" action="{{ route('formizin.reject-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-danger btn-action w-100" style="margin-left: 5px" data-toggle="tooltip" title="Reject Atasan"><i class="fas fa-times"></i></button>
																						</form>
																					</div>
																				</td>
																				@endif
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
															<!--end::Notice-->
														</div>
													</div>
												  </div>
												</div>
												<div class="accordion-item">
												  <h2 class="accordion-header" id="headingTwo">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
														Form Sakit
													</button>
												  </h2>
												  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
													<div class="accordion-body">
														<div class="col-lg-12">
															<!--begin::Notice-->
															<div class="card-px text-center">
																<!--begin::Title-->
																	<h1>Form Sakit</h1>
																<!--end::Title-->
															</div>
															<div class="table-responsive">
																<table class="table table-row-bordered gy-5">
																	<thead>
																		<tr class="fw-bold fs-5">
																			<th>Nama</th>
																			<th>Tgl</th>
																			<th>Jml</th>
																			<th>Keterangan</th>
																			<th>Atasan</th>
																			<th>Bukti</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($formSakit as $item)
																			<tr>
																				<td>{{ $item->nama }}</td>
																				<td>{{ $item->tanggal }}</td>
																				<td>{{ $item->jumlah_izin }} Hari</td>
																				<td>{{ $item->keterangan }}</td>
																				<td>
																					@if ($item->approve_atasan == 0)
																					<span class="badge bg-warning text-dark">Waiting</span>
																					@elseif($item->approve_atasan == 1)
																					<span class="badge bg-success">Approved</span>
																					@elseif($item->approve_atasan == 2)
																					<span class="badge bg-danger">Rejected</span>
																					@endif
																				</td>
																				<td>
																					<a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModalSakit{{ $item->id }}">
																						<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Visible.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																								<rect x="0" y="0" width="24" height="24"/>
																								<path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																								<path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
																							</g>
																						</svg><!--end::Svg Icon--></span>
																					</a>
									
																					<!--begin::Modal - New Card-->
																					<div class="modal fade" id="detailModalSakit{{ $item->id }}" tabindex="-1" aria-hidden="true">
																						<!--begin::Modal dialog-->
																						<div class="modal-dialog modal-dialog-centered mw-850px">
																							<!--begin::Modal content-->
																							<div class="modal-content">
																								<!--begin::Modal header-->
																								<div class="modal-header">
																									<!--begin::Modal title-->
																									<h2>File Bukti</h2>
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
																									@if ($item->bukti_pendukung)
																										@php
																											$extension = pathinfo($item->bukti_pendukung, PATHINFO_EXTENSION);
																										@endphp
									
																										@if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
																											{{-- Display image --}}
																											<img src="{{ asset('storage/' . $item->bukti_pendukung) }}" alt="Bukti Pendukung" class="img-fluid mx-auto d-block mt-10">
									
																										@elseif (in_array(strtolower($extension), ['pdf']))
																											{{-- Display PDF --}}
																											<a href="{{ asset('storage/' . $item->bukti_pendukung) }}" target="_blank">View PDF</a>
																										@else
																											{{-- Handle other file types --}}
																											<p>File type not supported</p>
																										@endif
																									@else
																										No File Available
																									@endif
																									<!--end::content modal body-->
																								</div>
																								<!--end::Modal body-->
																							</div>
																							<!--end::Modal content-->
																						</div>
																						<!--end::Modal dialog-->
																					</div>
																					<!--end::Modal - New Card-->
																				</td>
																				@if ($item->approve_atasan == 0)
																				<td>
																					<div class="btn-group d-flex">
																						<!-- Atasan Approve/Unapprove/Reject Buttons -->
																						<form method="post" action="{{ route('formsakit.approve-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-success btn-action w-100" data-toggle="tooltip" title="Approve Atasan"><i class="fas fa-check"></i></button>
																						</form>
						
																						<form method="post" action="{{ route('formsakit.reject-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-danger btn-action w-100" style="margin-left: 5px" data-toggle="tooltip" title="Reject Atasan"><i class="fas fa-times"></i></button>
																						</form>
																					</div>
																				</td>
																				@endif
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
															<!--end::Notice-->
														</div>
													</div>
												  </div>
												</div>
												<div class="accordion-item">
												  <h2 class="accordion-header" id="headingThree">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
													  Form Setengah Hari
													</button>
												  </h2>
												  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
													<div class="accordion-body">
														<div class="col-lg-12">
															<!--begin::Notice-->
															<div class="card-px text-center">
																<!--begin::Title-->
																	<h1>Form Setengah Hari</h1>
																<!--end::Title-->
															</div>
															<div class="table-responsive">
																<table class="table table-row-bordered gy-5">
																	<thead>
																		<tr class="fw-bold fs-5">
																			<th>Nama</th>
																			<th>Tgl</th>
																			<th>Waktu</th>
																			<th>Keperluan</th>
																			<th>Atasan</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($formSetHari as $item)
																			<tr>
																				<td>{{ $item->nama }}</td>
																				<td>{{ $item->tanggal }}</td>
																				<td>{{ $item->waktu }}</td>
																				<td>{{ $item->keperluan }}</td>
																				<td>
																					@if ($item->approve_atasan == 0)
																					<span class="badge bg-warning text-dark">Waiting</span>
																					@elseif($item->approve_atasan == 1)
																					<span class="badge bg-success">Approved</span>
																					@elseif($item->approve_atasan == 2)
																					<span class="badge bg-danger">Rejected</span>
																					@endif
																				</td>
																				@if ($item->approve_atasan == 0)
																				<td>
																					<div class="btn-group d-flex">
																						<!-- Atasan Approve/Unapprove/Reject Buttons -->
																						<form method="post" action="{{ route('formsethari.approve-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-success btn-action w-100" data-toggle="tooltip" title="Approve Atasan"><i class="fas fa-check"></i></button>
																						</form>
						
																						<form method="post" action="{{ route('formsethari.reject-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-danger btn-action w-100" style="margin-left: 5px" data-toggle="tooltip" title="Reject Atasan"><i class="fas fa-times"></i></button>
																						</form>
																					</div>
																				</td>
																				@endif
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
															<!--end::Notice-->
														</div>
													</div>
												  </div>
												</div>
												<div class="accordion-item">
												  <h2 class="accordion-header" id="headingThree">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourth" aria-expanded="false" aria-controls="collapseFourth">
														Form Meninggalkan Tugas
													</button>
												  </h2>
												  <div id="collapseFourth" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
													<div class="accordion-body">
														<div class="col-lg-12">
															<!--begin::Notice-->
															<div class="card-px text-center">
																<!--begin::Title-->
																	<h1>Form Setengah Hari</h1>
																<!--end::Title-->
															</div>
															<div class="table-responsive">
																<table class="table table-row-bordered gy-5">
																	<thead>
																		<tr class="fw-bold fs-5">
																			<th>Nama</th>
																			<th>Tgl</th>
																			<th>Waktu</th>
																			<th>Keperluan</th>
																			<th>Atasan</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($formMeninggalkanTugas as $item)
																			<tr>
																				<td>{{ $item->nama }}</td>
																				<td>{{ $item->tanggal }}</td>
																				<td>{{ $item->waktu }}</td>
																				<td>{{ $item->keperluan }}</td>
																				<td>
																					@if ($item->approve_atasan == 0)
																					<span class="badge bg-warning text-dark">Waiting</span>
																					@elseif($item->approve_atasan == 1)
																					<span class="badge bg-success">Approved</span>
																					@elseif($item->approve_atasan == 2)
																					<span class="badge bg-danger">Rejected</span>
																					@endif
																				</td>
																				@if ($item->approve_atasan == 0)
																				<td>
																					<div class="btn-group d-flex">
																						<!-- Atasan Approve/Unapprove/Reject Buttons -->
																						<form method="post" action="{{ route('formmeninggalkantugas.approve-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-success btn-action w-100" data-toggle="tooltip" title="Approve Atasan"><i class="fas fa-check"></i></button>
																						</form>
						
																						<form method="post" action="{{ route('formmeninggalkantugas.reject-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-danger btn-action w-100" style="margin-left: 5px" data-toggle="tooltip" title="Reject Atasan"><i class="fas fa-times"></i></button>
																						</form>
																					</div>
																				</td>
																				@endif
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
															<!--end::Notice-->
														</div>
													</div>
												  </div>
												</div>
												<div class="accordion-item">
												  <h2 class="accordion-header" id="headingThree">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFifth" aria-expanded="false" aria-controls="collapseFifth">
													  Form Tugas Keluar Kantor
													</button>
												  </h2>
												  <div id="collapseFifth" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
													<div class="accordion-body">
														<div class="col-lg-12">
															<!--begin::Notice-->
															<div class="card-px text-center">
																<!--begin::Title-->
																	<h1>Form Tugas Keluar Kantor</h1>
																<!--end::Title-->
															</div>
															<div class="table-responsive">
																<table class="table table-row-bordered gy-5">
																	<thead>
																		<tr class="fw-bold fs-5">
																			<th>Nama</th>
																			<th>Tgl</th>
																			<th>Waktu</th>
																			<th>Keperluan</th>
																			<th>Atasan</th>
																			<th>Bukti</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($formFormTgsKlrKantor as $item)
																			<tr>
																				<td>{{ $item->nama }}</td>
																				<td>{{ $item->tanggal }}</td>
																				<td>{{ $item->jam_mulai }} ~ {{ $item->jam_selesai }}</td>
																				<td>{{ $item->keperluan }}</td>
																				<td>
																					@if ($item->approve_atasan == 0)
																					<span class="badge bg-warning text-dark">Waiting</span>
																					@elseif($item->approve_atasan == 1)
																					<span class="badge bg-success">Approved</span>
																					@elseif($item->approve_atasan == 2)
																					<span class="badge bg-danger">Rejected</span>
																					@endif
																				</td>
																				<td>
																					<a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModalTugasKeluar{{ $item->id }}">
																						<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Visible.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																								<rect x="0" y="0" width="24" height="24"/>
																								<path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																								<path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
																							</g>
																						</svg><!--end::Svg Icon--></span>
																					</a>
									
																					<!--begin::Modal - New Card-->
																					<div class="modal fade" id="detailModalTugasKeluar{{ $item->id }}" tabindex="-1" aria-hidden="true">
																						<!--begin::Modal dialog-->
																						<div class="modal-dialog modal-dialog-centered mw-850px">
																							<!--begin::Modal content-->
																							<div class="modal-content">
																								<!--begin::Modal header-->
																								<div class="modal-header">
																									<!--begin::Modal title-->
																									<h2>File Bukti</h2>
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
																									@if ($item->bukti_pendukung)
																										@php
																											$extension = pathinfo($item->bukti_pendukung, PATHINFO_EXTENSION);
																										@endphp
									
																										@if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
																											{{-- Display image --}}
																											<img src="{{ asset('storage/' . $item->bukti_pendukung) }}" alt="Bukti Pendukung" class="img-fluid mx-auto d-block mt-10">
									
																										@elseif (in_array(strtolower($extension), ['pdf']))
																											{{-- Display PDF --}}
																											<a href="{{ asset('storage/' . $item->bukti_pendukung) }}" target="_blank">View PDF</a>
																										@else
																											{{-- Handle other file types --}}
																											<p>File type not supported</p>
																										@endif
																									@else
																										No File Available
																									@endif
																									<!--end::content modal body-->
																								</div>
																								<!--end::Modal body-->
																							</div>
																							<!--end::Modal content-->
																						</div>
																						<!--end::Modal dialog-->
																					</div>
																					<!--end::Modal - New Card-->
																				</td>
																				@if ($item->approve_atasan == 0)
																				<td>
																					<div class="btn-group d-flex">
																						<!-- Atasan Approve/Unapprove/Reject Buttons -->
																						<form method="post" action="{{ route('formtgsklrkantor.approve-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-success btn-action w-100" data-toggle="tooltip" title="Approve Atasan"><i class="fas fa-check"></i></button>
																						</form>
						
																						<form method="post" action="{{ route('formtgsklrkantor.reject-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-danger btn-action w-100" style="margin-left: 5px" data-toggle="tooltip" title="Reject Atasan"><i class="fas fa-times"></i></button>
																						</form>
																					</div>
																				</td>
																				@endif
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
															<!--end::Notice-->
														</div>
													</div>
												  </div>
												</div>
												<div class="accordion-item">
												  <h2 class="accordion-header" id="headingThree">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
													  Form Lembur
													</button>
												  </h2>
												  <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
													<div class="accordion-body">
														<div class="col-lg-12">
															<!--begin::Notice-->
															<div class="card-px text-center">
																<!--begin::Title-->
																	<h1>Form Lembur</h1>
																<!--end::Title-->
															</div>
															<div class="table-responsive">
																<table class="table table-row-bordered gy-5">
																	<thead>
																		<tr class="fw-bold fs-5">
																			<th>Nama</th>
																			<th>Tgl</th>
																			<th>Waktu</th>
																			<th>Durasi</th>
																			<th>Keterangan</th>
																			<th>Atasan</th>
																			<th>Bukti</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($formLembur as $item)
																			<tr>
																				<td>{{ $item->nama }}</td>
																				<td>{{ $item->tanggal }}</td>
																				<td>{{ $item->jam_mulai }} ~ {{ $item->jam_selesai }}</td>
																				<td>{{ $item->durasi_lembur }}</td>
																				<td>{{ $item->keterangan_pekerjaan }}</td>
																				<td>
																					@if ($item->approve_atasan == 0)
																					<span class="badge bg-warning text-dark">Waiting</span>
																					@elseif($item->approve_atasan == 1)
																					<span class="badge bg-success">Approved</span>
																					@elseif($item->approve_atasan == 2)
																					<span class="badge bg-danger">Rejected</span>
																					@endif
																				</td>
																				<td>
																					<a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModalLembur{{ $item->id }}">
																						<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Visible.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																								<rect x="0" y="0" width="24" height="24"/>
																								<path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																								<path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
																							</g>
																						</svg><!--end::Svg Icon--></span>
																					</a>
									
																					<!--begin::Modal - New Card-->
																					<div class="modal fade" id="detailModalLembur{{ $item->id }}" tabindex="-1" aria-hidden="true">
																						<!--begin::Modal dialog-->
																						<div class="modal-dialog modal-dialog-centered mw-850px">
																							<!--begin::Modal content-->
																							<div class="modal-content">
																								<!--begin::Modal header-->
																								<div class="modal-header">
																									<!--begin::Modal title-->
																									<h2>File Bukti</h2>
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
																									@if ($item->bukti_pendukung)
																										@php
																											$extension = pathinfo($item->bukti_pendukung, PATHINFO_EXTENSION);
																										@endphp
									
																										@if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
																											{{-- Display image --}}
																											<img src="{{ asset('storage/' . $item->bukti_pendukung) }}" alt="Bukti Pendukung" class="img-fluid mx-auto d-block mt-10">
									
																										@elseif (in_array(strtolower($extension), ['pdf']))
																											{{-- Display PDF --}}
																											<a href="{{ asset('storage/' . $item->bukti_pendukung) }}" target="_blank">View PDF</a>
																										@else
																											{{-- Handle other file types --}}
																											<p>File type not supported</p>
																										@endif
																									@else
																										No File Available
																									@endif
																									<!--end::content modal body-->
																								</div>
																								<!--end::Modal body-->
																							</div>
																							<!--end::Modal content-->
																						</div>
																						<!--end::Modal dialog-->
																					</div>
																					<!--end::Modal - New Card-->
																				</td>
																				@if ($item->approve_atasan == 0)
																				<td>
																					<div class="btn-group d-flex">
																						<!-- Atasan Approve/Unapprove/Reject Buttons -->
																						<form method="post" action="{{ route('formlembur.approve-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-success btn-action w-100" data-toggle="tooltip" title="Approve Atasan"><i class="fas fa-check"></i></button>
																						</form>
						
																						<form method="post" action="{{ route('formlembur.reject-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-danger btn-action w-100" style="margin-left: 5px" data-toggle="tooltip" title="Reject Atasan"><i class="fas fa-times"></i></button>
																						</form>
																					</div>
																				</td>
																				@endif
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
															<!--end::Notice-->
														</div>
													</div>
												  </div>
												</div>
												<div class="accordion-item">
												  <h2 class="accordion-header" id="headingThree">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
													  From Cuti
													</button>
												  </h2>
												  <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
													<div class="accordion-body">
														<div class="col-lg-12">
															<!--begin::Notice-->
															<div class="card-px text-center">
																<!--begin::Title-->
																	<h1>Form Cuti</h1>
																<!--end::Title-->
															</div>
															<div class="table-responsive">
																<table class="table table-row-bordered gy-5">
																	<thead>
																		<tr class="fw-bold fs-5">
																			<th>Nama</th>
																			<th>Tanggal</th>
																			<th>Jml Cuti</th>
																			<th>Keperluan</th>
																			<th>Atasan</th>
																			<th>Bukti</th>
																			<th>Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($formCuti as $item)
																			<tr>
																				<td>{{ $item->nama }}</td>
																				<td>{{ $item->tanggal_mulai }} ~ {{ $item->tanggal_selesai }}</td>
																				<td>{{ $item->jumlah_cuti }} Hari</td>
																				<td>{{ $item->keperluan }}</td>
																				<td>
																					@if ($item->approve_atasan == 0)
																					<span class="badge bg-warning text-dark">Waiting</span>
																					@elseif($item->approve_atasan == 1)
																					<span class="badge bg-success">Approved</span>
																					@elseif($item->approve_atasan == 2)
																					<span class="badge bg-danger">Rejected</span>
																					@endif
																				</td>
																				<td>
																					<a href="#" class="" data-bs-toggle="modal" data-bs-target="#detailModalCuti{{ $item->id }}">
																						<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Visible.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																								<rect x="0" y="0" width="24" height="24"/>
																								<path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																								<path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
																							</g>
																						</svg><!--end::Svg Icon--></span>
																					</a>
									
																					<!--begin::Modal - New Card-->
																					<div class="modal fade" id="detailModalCuti{{ $item->id }}" tabindex="-1" aria-hidden="true">
																						<!--begin::Modal dialog-->
																						<div class="modal-dialog modal-dialog-centered mw-850px">
																							<!--begin::Modal content-->
																							<div class="modal-content">
																								<!--begin::Modal header-->
																								<div class="modal-header">
																									<!--begin::Modal title-->
																									<h2>File Bukti</h2>
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
																									@if ($item->bukti_pendukung)
																										@php
																											$extension = pathinfo($item->bukti_pendukung, PATHINFO_EXTENSION);
																										@endphp
									
																										@if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
																											{{-- Display image --}}
																											<img src="{{ asset('storage/' . $item->bukti_pendukung) }}" alt="Bukti Pendukung" class="img-fluid mx-auto d-block mt-10">
									
																										@elseif (in_array(strtolower($extension), ['pdf']))
																											{{-- Display PDF --}}
																											<a href="{{ asset('storage/' . $item->bukti_pendukung) }}" target="_blank">View PDF</a>
																										@else
																											{{-- Handle other file types --}}
																											<p>File type not supported</p>
																										@endif
																									@else
																										No File Available
																									@endif
																									<!--end::content modal body-->
																								</div>
																								<!--end::Modal body-->
																							</div>
																							<!--end::Modal content-->
																						</div>
																						<!--end::Modal dialog-->
																					</div>
																					<!--end::Modal - New Card-->
																				</td>
																				@if ($item->approve_atasan == 0)
																				<td>
																					<div class="btn-group d-flex">
																						<!-- Atasan Approve/Unapprove/Reject Buttons -->
																						<form method="post" action="{{ route('formcuti.approve-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-success btn-action w-100" data-toggle="tooltip" title="Approve Atasan"><i class="fas fa-check"></i></button>
																						</form>
						
																						<form method="post" action="{{ route('formcuti.reject-atasan', $item->id) }}">
																							@csrf
																							<button type="button"  onclick="showConfirmation(event)" class="btn btn-sm btn-danger btn-action w-100" style="margin-left: 5px" data-toggle="tooltip" title="Reject Atasan"><i class="fas fa-times"></i></button>
																						</form>
																					</div>
																				</td>
																				@endif
																			</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
															<!--end::Notice-->
														</div>
													</div>
												  </div>
												</div>
											  </div>
										</div>
										<!--end::Row-->
								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>

					<script>
						function showConfirmation(event) {
							var result = confirm("Apakah Anda yakin ingin melanjutkan?");
							if (result) {
								// Mendapatkan elemen tombol yang diklik
								var clickedButton = event.target;
								// Mendapatkan formulir terkait dengan tombol yang diklik
								var form = clickedButton.closest('form');

								 // Melakukan submit form jika pengguna memilih "Ya"
								if (form) {
									form.submit();
								}
							}
						}
					</script>
@endsection
