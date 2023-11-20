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
									<div class="card-body pb-0">
										<!--begin::Heading-->
										<!--begin::Row-->
										<div class="row g-5 g-xl-8">
											<div class="col-lg-12 mb-10">
                                                <!--begin::Notice-->

                                                        <!--begin::Content-->
                                                        <div class="mb-6 mb-md-0 fw-bold">
                                                            <h4 class="text-gray-900 fw-bolder text-center mb-8">Hai {{ auth()->user()->nama }}, Selamat datang di sistem perizinan Primakara ❤️</h4>
                                                            <div class="fs-6 text-gray-700" style="text-align: justify">Kami senang melihat <b>{{ auth()->user()->nama }}</b>  di sini. Dengan sistem ini, Kamu akan dapat dengan mudah mengakses form dari SDM. <br><br>

                                                                Jika Kamu memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi SDM. <br><br>

                                                                Terima kasih telah menjadi bagian dari keluarga Primakara. Semoga sistem ini membantu <b>{{ auth()->user()->nama }}</b> dalam pengajuan form secara online yang lebih mudah dan baik.

                                                                Salam Hangat,
                                                                [SDM Primakara]</div>
                                                        </div>
                                                        <!--end::Content-->
														@if ($isIAmLeader)
                                                        	<div class="text-center mt-8">
                                                            	<!--begin::Action-->
                                                                <a href="{{ url('rekapanAtasan') }}" class="btn btn-primary px-6 align-self-center text-nowrap">Lihat Request Rekan Kerja</a>
																<!--end::Action-->
															</div>
														@endif

                                                <!--end::Notice-->
                                            </div>
										</div>
										<!--end::Row-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
@endsection
