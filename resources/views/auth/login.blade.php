<!DOCTYPE html>
<html lang="en">
    <!--begin::Head-->
    <head>
        <title>xyz - Login</title>
        <meta charset="utf-8" />
        <meta name="description" content=" " />
        <meta name="keywords" content=" " />
        <meta name="viewport" content="width=device-width, initial-scale=1" /> 
        <link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.svg')}}" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
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
        @if(Session::has('message'))
		 var type = "{{ Session::get('alert-type','info') }}"
		 switch(type){
		    case 'info':
		    toastr.info(" {{ Session::get('message') }} ");
		    break;
		    case 'success':
		    toastr.success(" {{ Session::get('message') }} ");
		    break;
		    case 'warning':
		    toastr.warning(" {{ Session::get('message') }} ");
		    break;
		    case 'error':
		    toastr.error(" {{ Session::get('message') }} ");
		    break; 
		 }          
		 @endif 
    </script>
    <style>
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -27px;
            position: relative;
            z-index: 2;
        }
        .fa-fw {
            text-align: center;
            width: 3.25em;
        }
    </style> 
        <div class="d-flex flex-column flex-root">
            <!--begin::Authentication - Sign-in -->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                <!--begin::Aside-->
                <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #333">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                        <!--begin::Content-->
                        <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                            <!--begin::Logo-->
                            <a href="{{ URL::to('/'); }}" class="py-9 mb-0">
                                <img alt="Logo" src="{{asset('backend/assets/media/logos/logo.png')}}" class="h-70px" />
                            </a>
                            <!--end::Logo-->
                            <!--begin::Title-->
                            <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #fff;">Welcome to XYZ</h1>
                            <!--end::Title-->
                            <!--begin::Description--><!-- 
                            <p class="fw-bold fs-2" style="color: #fff;">Discover Amazing Metronic
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
                        <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                            <!--begin::Form-->
                            <form class="form w-100" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="text-center mb-10"> 
                                    <h1 class="text-dark mb-3">Sign In to xyz</h1>
                                </div>
                                <div class="fv-row mb-10"> 
                                    <label class="form-label fs-6 fw-bolder text-dark">Username</label>
                                    <input class="form-control form-control-lg form-control-solid" id="username" type="text" name="username" :value="old('username')" required autocomplete="off" />
                                    <!--end::Input-->
                                </div>
                                <div class="fv-row mb-10"> 
                                    <div class="d-flex flex-stack mb-2">

                                        <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                        
                                    </div>
                                    <input class="form-control form-control-lg form-control-solid" id="password" type="password" name="password" autocomplete="off" />
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                   
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                                        <span class="indicator-label">Sign In</span>
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>    
                    </div> 
                </div>
            </div> 
        </div>
        <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
            input.attr("type", "text");
            } else {
            input.attr("type", "password");
            }
        });
    </script>
    <script src="{{asset('backend/assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('backend/assets/js/scripts.bundle.js')}}"></script>
    <script src="{{asset('backend/assets/js/custom/authentication/sign-up/general.js')}}"></script>
</body>                 
</html>