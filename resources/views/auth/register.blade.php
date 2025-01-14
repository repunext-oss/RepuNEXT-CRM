<!DOCTYPE html>
<html lang="en">
<head>
    <title>Garuda Aerospace - Signup </title>
    <meta charset="utf-8" />
    <meta name="description" content=" " />
    <meta name="keywords" content=" " />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.svg')}}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="bg-body">
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-up -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #2d4e9d">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                    <!--begin::Content-->
                    <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                        <!--begin::Logo-->
                        <a href="{{ URL::to('/'); }}" class="py-9 mb-0">
                                <img alt="Logo" src="{{asset('backend/assets/media/logos/garuda_white_logo.png')}}" class="h-70px" />
                            </a>
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #fff;">Welcome to Garuda Aerospace</h1>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <!-- <p class="fw-bold fs-2" style="color: #986923;">Discover Amazing Metronic
                            <br />with great build tools</p> -->
                            <!--end::Description-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Illustration-->
                        <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{asset('backend/assets/media/illustrations/sketchy-1/drone-white.png')}});"></div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Aside-->
                <!--begin::Body-->
                <div class="d-flex flex-column flex-lg-row-fluid py-10">
                    <!--begin::Content-->
                    <div class="d-flex flex-center flex-column flex-column-fluid">
                        <!--begin::Wrapper-->
                        <div class="w-lg-600px p-10 p-lg-15 mx-auto">
                            <form method="POST" action="{{ route('register') }}" class="form w-100"  >   
                                @csrf
                                <!--begin::Heading-->
                                <div class="mb-10 text-center">
                                    <!--begin::Title-->
                                    <h1 class="text-dark mb-3">Create an Account</h1>
                                    <!--end::Title-->
                                    <!--begin::Link-->
                                    <div class="text-gray-400 fw-bold fs-4">Already have an account?
                                        <a href="{{route('login')}}" class="link-primary fw-bolder">Sign in here</a></div>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Action-->
                                    <!-- <button type="button" class="btn btn-light-primary fw-bolder w-100 mb-10">
                                        <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="h-20px me-3" />Sign in with Google</button> -->
                                        <!--end::Action-->
                                        <!--begin::Separator-->
                                        <!-- <div class="d-flex align-items-center mb-10">
                                            <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                                            <span class="fw-bold text-gray-400 fs-7 mx-2">OR</span>
                                            <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                                        </div> -->
                                        <!--end::Separator-->
                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">
                                            <!--begin::Col-->
                                            <div class="col-xl-12">
                                                <label class="form-label fw-bolder text-dark fs-6">Name</label>
                                                <input class="form-control form-control-lg form-control-solid" type="text" :value="old('name')" id="name" name="name" autocomplete="off" />
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <div class="fv-row mb-7">
                                            <label class="form-label fw-bolder text-dark fs-6">Username</label>
                                            <input class="form-control form-control-lg form-control-solid" type="text" id="username" placeholder="" name="username" :value="old('username')" autocomplete="off" />
                                        </div>
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <label class="form-label fw-bolder text-dark fs-6">Phone</label>
                                            <input class="form-control form-control-lg form-control-solid" type="phone" id="phone" placeholder="" name="phone" :value="old('phone')" autocomplete="off" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <label class="form-label fw-bolder text-dark fs-6">Email</label>
                                            <input class="form-control form-control-lg form-control-solid" type="email" id="email" placeholder="" name="email" :value="old('email')" autocomplete="off" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                                            <!--begin::Wrapper-->
                                            <div class="mb-1">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bolder text-dark fs-6">Password</label>
                                                <!--end::Label-->
                                                <!--begin::Input wrapper-->

                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-lg form-control-solid" id="password" type="password" placeholder="" name="password" required autocomplete="new-password" />
                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                        <i class="bi bi-eye-slash fs-2"></i>
                                                        <i class="bi bi-eye fs-2 d-none"></i>
                                                    </span>
                                                </div>
                                                <!--end::Input wrapper-->
                                                <!--begin::Meter-->
                                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                                </div>
                                                <!--end::Meter-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Hint-->
                                            <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Input group=-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
                                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" id="password_confirmation" name="password_confirmation" autocomplete="off" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <label class="form-check form-check-custom form-check-solid form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="toc" value="1" />
                                                <span class="form-check-label fw-bold text-gray-700 fs-6">I Agree
                                                    <a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
                                                </label>
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="text-center">
                                                <button type="submit"  class="btn btn-lg btn-primary">
                                                    <span class="indicator-label">Submit</span>
                                                    <span class="indicator-progress">Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Footer-->
                                    <!-- <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                                        <div class="d-flex flex-center fw-bold fs-6">
                                            <a href="https://keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">About</a>
                                            <a href="https://devs.keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
                                            <a href="https://1.envato.market/EA4JP" class="text-muted text-hover-primary px-2" target="_blank">Purchase</a>
                                        </div>
                                    </div> -->
                                    <!--end::Footer-->
                                </div> <!--end::Body-->
                            </div> <!--end::Authentication - Sign-up-->
                        </div>
                        <script src="{{asset('backend/assets/plugins/global/plugins.bundle.js')}}"></script>
                        <script src="{{asset('backend/assets/js/scripts.bundle.js')}}"></script>
                        <script src="{{asset('backend/assets/js/custom/authentication/sign-up/general.js')}}"></script>
                    </body>
                    
                    </html>