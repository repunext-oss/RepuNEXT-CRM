<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Garuda Aerospace - Home</title>
        <meta charset="utf-8" />
        <meta name="description" content=" " />
        <meta name="keywords" content=" " />
        <meta name="viewport" content="width=device-width, initial-scale=1" /> 
        <link rel="shortcut icon" href="{{asset('backend/assets/media/logos/favicon.svg')}}" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <link href="{{asset('backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    </head>
    <body id="kt_body" class="bg-body">
         <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
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
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" style="background-color: #2d4e9d">
                    <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                        <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                            <a href="../../demo1/dist/index.html" class="py-9 mb-0">
                                <img alt="Logo" src="{{asset('backend/assets/media/logos/garuda_white_logo.png')}}" class="h-70px" />
                            </a>
                            <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #fff;">Welcome to XYZ</h1>
                        </div>
                        <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{asset('backend/assets/media/illustrations/sketchy-1/drone-white.png')}});"></div>
                      
                    </div>
                </div>
                <div class="d-flex flex-column flex-lg-row-fluid py-10">
                    <div class="d-flex flex-center flex-column flex-column-fluid">
                        <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                           <h1><a href="{{route('login')}}">Click Here</a> to Login the page</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="{{asset('backend/assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('backend/assets/js/scripts.bundle.js')}}"></script>
    <script src="{{asset('backend/assets/js/custom/authentication/sign-up/general.js')}}"></script>
</body>                 
</html>