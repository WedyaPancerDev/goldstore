@extends('layouts.public')

@section('title')
	Toko Emas - Login
@endsection

@section('content')
	<section class="crancy-wc crancy-wc__full crancy-bg-cover">
		<div class="crancy-wc__form">
			<!-- Welcome Banner -->
			<div class="crancy-wc__form--middle">
				<div class="crancy-wc__form-inner">
					<div class="crancy-wc__logo">
						<svg style="height: 45px; width: 45px" width="24" height="16" viewBox="0 0 24 16" fill="none"
							xmlns="http://www.w3.org/2000/svg">
							<path
								d="M7.99994 7.0002H15.9999C16.1477 6.99923 16.2933 6.96554 16.4264 6.90157C16.5596 6.83759 16.6769 6.74492 16.7699 6.6302C16.8677 6.51773 16.9391 6.38484 16.9789 6.24123C17.0187 6.09763 17.0259 5.94695 16.9999 5.8002L15.9999 0.800204C15.9532 0.570928 15.8275 0.365306 15.6448 0.219131C15.4621 0.0729566 15.2339 -0.00451449 14.9999 0.000203439H8.99994C8.766 -0.00451449 8.53781 0.0729566 8.35509 0.219131C8.17237 0.365306 8.0467 0.570928 7.99994 0.800204L6.99994 5.8002C6.97132 5.94547 6.97531 6.09528 7.01163 6.23881C7.04794 6.38235 7.11568 6.51603 7.20994 6.6302C7.30512 6.74755 7.42565 6.84181 7.56247 6.90589C7.6993 6.96997 7.84887 7.00222 7.99994 7.0002ZM9.81994 2.0002H14.1799L14.7799 5.0002H9.21994L9.81994 2.0002ZM21.9999 9.8002C21.9532 9.57093 21.8275 9.36531 21.6448 9.21913C21.4621 9.07296 21.2339 8.99549 20.9999 9.0002H14.9999C14.766 8.99549 14.5378 9.07296 14.3551 9.21913C14.1724 9.36531 14.0467 9.57093 13.9999 9.8002L12.9999 14.8002C12.9713 14.9455 12.9753 15.0953 13.0116 15.2388C13.0479 15.3824 13.1157 15.516 13.2099 15.6302C13.3051 15.7475 13.4256 15.8418 13.5625 15.9059C13.6993 15.97 13.8489 16.0022 13.9999 16.0002H21.9999C22.1477 15.9992 22.2933 15.9655 22.4264 15.9016C22.5596 15.8376 22.6769 15.7449 22.7699 15.6302C22.8677 15.5177 22.9391 15.3848 22.9789 15.2412C23.0187 15.0976 23.0259 14.9469 22.9999 14.8002L21.9999 9.8002ZM15.2199 14.0002L15.8199 11.0002H20.1799L20.7799 14.0002H15.2199ZM8.99994 9.0002H2.99994C2.766 8.99549 2.53781 9.07296 2.35509 9.21913C2.17237 9.36531 2.0467 9.57093 1.99994 9.8002L0.999945 14.8002C0.971321 14.9455 0.975311 15.0953 1.01163 15.2388C1.04794 15.3824 1.11568 15.516 1.20994 15.6302C1.30512 15.7475 1.42565 15.8418 1.56247 15.9059C1.6993 15.97 1.84887 16.0022 1.99994 16.0002H9.99994C10.1477 15.9992 10.2933 15.9655 10.4264 15.9016C10.5596 15.8376 10.6769 15.7449 10.7699 15.6302C10.8677 15.5177 10.9391 15.3848 10.9789 15.2412C11.0187 15.0976 11.0259 14.9469 10.9999 14.8002L9.99994 9.8002C9.95319 9.57093 9.82752 9.36531 9.6448 9.21913C9.46208 9.07296 9.23389 8.99549 8.99994 9.0002ZM3.21994 14.0002L3.81994 11.0002H8.17994L8.77994 14.0002H3.21994Z"
								fill="#fbbf24" />
						</svg>
					</div>
					<div class="crancy-wc__form-inside">
						<div class="crancy-wc__form-middle">
							<div class="crancy-wc__form-top">
								<div class="text-center mt-5">
									<h5 class="fs-3">Selamat Datang</h5>
									<p class="text-muted">Masuk untuk mengakses ke aplikasi.</p>
								</div>
								<!-- Sign in Form -->
								<form class="crancy-wc__form-main" action="{{ route('login') }}" method="post">
									@csrf
									<!-- Form Group -->
									<div class="form-group">
										<div class="form-group__input">
											<input class="crancy-wc__form-input fw-medium" type="text" name="username" placeholder="Username" />
										</div>

										@if ($errors->has('username'))
											<div class="pt-2">
												<span class="form-text fw-semibold text-danger">
													{{ $errors->first('username') }}
												</span>
											</div>
										@endif
									</div>

									<!-- Form Group -->
									<div class="form-group">
										<div class="form-group__input">
											<input class="crancy-wc__form-input fw-medium" placeholder="Kata Sandi" id="password-field" type="password"
												name="password" maxlength="20" />
											<span class="crancy-wc__toggle"><i class="fas fa-eye" id="toggle-icon"></i></span>
										</div>

										@if ($errors->has('password'))
											<div class="pt-2">
												<span class="form-text fw-semibold text-danger">
													{{ $errors->first('password') }}
												</span>
											</div>
										@endif
									</div>

									<!-- Form Group -->
									<div class="form-group mg-top-30">
										<div class="crancy-wc__button">
											<button class="ntfmax-wc__btn" type="submit">
												Masuk ke Aplikasi
											</button>
										</div>
									</div>
								</form>
								<!-- End Sign in Form -->
							</div>

							<!-- Footer Top -->
							<div class="crancy-wc__footer--top">
								<p class="crancy-wc__footer--copyright">
									@ <span id="year-now"></span> <b>PT. Bali Aura Indah</b> All Right Reserved.
								</p>
							</div>
							<!-- End Footer Top -->
						</div>
					</div>
				</div>
				<div class="crancy-wc__banner crancy-bg-cover">
					<div class="crancy-wc__banner--img">
						<img src="{{ asset('assets/img/welcome-vector.png') }}" width="600" loading="lazy" alt="#" />
					</div>

					<div class="crancy-wc__slider">
						<!-- Sinlge Slider -->
						<div class="single-slider">
							<div class="crancy-wc__slider--single">
								<div class="crancy-wc__slider--content">
									<h4 class="crancy-wc__slider--title pt-2">
										Manajemen Barang dan Keuangan
										dengan Mudah dan Efisien
									</h4>
									<p class="crancy-wc__slider--text">
										Dirancang untuk memudahkan pengelolaan barang produksi dan keuangan perusahaan Anda
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Welcome Banner -->
		</div>
	</section>
@endsection

@section('scripts')
	<script>
		document.getElementById('year-now').innerText = new Date().getFullYear();
	</script>
@endsection
