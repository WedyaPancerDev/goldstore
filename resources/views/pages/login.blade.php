@extends('layouts.public')

@section('title')
CV. Tropikal Bali - Login
@endsection

@section('content')
<section class="crancy-wc crancy-wc__full crancy-bg-cover">
    <div class="crancy-wc__form">
        <!-- Welcome Banner -->
        <div class="crancy-wc__form--middle">
            <div class="crancy-wc__form-inner">
                <div class="crancy-wc__logo">
                    <a href="">
                        <img src="{{ asset('assets/img/favicon.svg') }}" height="45" width="45" alt="#">
                    </a>
                </div>
                <div class="crancy-wc__form-inside">
                    <div class="crancy-wc__form-middle">
                        <div class="crancy-wc__form-top">
                            <div class="text-center mt-5">
                                <h5 class="fs-3">Selamat Datang</h5>
                                <p class="text-muted">Masuk untuk mengakses ke aplikasi.</p>
                            </div>
                            <!-- Sign in Form -->
                            <form class="crancy-wc__form-main" action="index.html" method="post">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <div class="form-group__input">
                                        <input class="crancy-wc__form-input fw-medium" type="username" name="username"
                                            placeholder="Username" />
                                    </div>
                                </div>
                                <!-- Form Group -->
                                <div class="form-group">
                                    <div class="form-group__input">
                                        <input class="crancy-wc__form-input fw-medium" placeholder="Kata Sandi"
                                            id="password-field" type="password" name="password" maxlength="8" />
                                        <span class="crancy-wc__toggle"><i class="fas fa-eye"
                                                id="toggle-icon"></i></span>
                                    </div>
                                </div>

                                <!-- Form Group -->
                                <div class="form-group">
                                    <div class="crancy-wc__check-inline">
                                        <div class="crancy-wc__checkbox">
                                            <input class="crancy-wc__form-check" id="checkbox" name="checkbox"
                                                type="checkbox" />
                                            <label for="checkbox">Ingat saya</label>
                                        </div>
                                        <div class="crancy-wc__forgot"></div>
                                    </div>
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
                                @ <span id="year-now"></span> <b>CV. Tropikal Bali</b> All Right Reserved.
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