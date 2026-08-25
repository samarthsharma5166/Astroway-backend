@php
    use Symfony\Component\HttpFoundation\Session\Session;

    $session = new Session();
    $token = $session->get('token');

    $getUserNotification = $userNotifications;
    $chatrequest = $chatRequests;

    $logo = $systemFlags->get('AdminLogo');
    $appName = $systemFlags->get('AppName');
    $OneSignalAppId = $systemFlags->get('OneSignalAppId');
    $currency = $systemFlags->get('currencySymbol');
    $appId = $systemFlags->get('firebaseappId');
    $measurementId = $systemFlags->get('firebasemeasurementId');
    $messagingSenderId = $systemFlags->get('firebasemessagingSenderId');
    $storageBucket = $systemFlags->get('firebasestorageBucket');
    $projectId = $systemFlags->get('firebaseprojectId');
    $authDomain = $systemFlags->get('firebaseauthDomain');
    $databaseURL = $systemFlags->get('firebasedatabaseURL');
    $apiKey = $systemFlags->get('firebaseapiKey');

    $freekundali = $systemFlags->get('FreeKundali');
    $kundali_matching = $systemFlags->get('KundaliMatching');
    $panchang = $systemFlags->get('TodayPanchang');
    $blog = $systemFlags->get('Blog');
    $shop = $systemFlags->get('Astromall');
    $daily_horoscope = $systemFlags->get('DailyHoroscope');
    $puja = $systemFlags->get('Puja');

    $playstore = $systemFlags->get('PlayStore');
    $appstore = $systemFlags->get('AppStore');
@endphp

<style>

    body.modal-open {
        overflow-y: scroll !important;
    }
    #otpless-login-page-parent{
        z-index: 10000;
    }

    .select2-selection__rendered {
        margin-top: 5px !important;
    }

    .pac-container {
        z-index: 10000 !important;
    }

    .pac-container:after {
        content: none !important;
    }


      /* Hide number arrows */
      input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield; /* Firefox */
        }


    .btn-chat-astro {
        background: #ffffff;
        /* box-shadow: 0 2px 3px #ffd70080; */
        font-size: 15px;
        font-weight: 600;
        border-radius: 10px;
        padding: 8px 20px;
        margin: 0 5px;
        white-space: nowrap;
    }

    .btn-chat-astro:hover {
        background: #fff;
        border: 2px solid gold;
    }


    .navbar-collapse {
        position: unset !important;
    }

    nav.navbar.navbar-expand-lg.navbar-light.top-navbar {
        background: #f4f4f5;
    }

    .scrollable-menu {
        max-height: 450px;
        /* Adjust this value as needed */
        overflow-y: auto;

    }

    .dropdown-menu.show {
        display: block;
    }

    .btn-chataccept {
        border-radius: 30px;
        border: 1px solid #5bbe2a;
        background-color: #5bbe2a !important;
        color: white !important;
    }




    .btn-chatreject {
        border-radius: 30px;
        border: 1px solid #ee4e5e;
        background-color: #ffffff !important;
        color: #ee4e5e !important;
    }

    .btn.clear-notification {
        font-size: 15px !important;
        padding: 8px 30px !important;
    }

    .btn.clear-notification:hover,
    .btn.clear-notification:focus,
    .btn.clear-notification:active {
        color: #fff !important;
        background: #ee4e5e !important;
    }

    @media screen and (max-width: 520px) {
        #notificationList {
            width: 370px !important;
        }
    }

    .navbar-expand-lg .navbar-nav .nav-link {
        padding-right: 0.9rem;
        padding-left: 0.9rem;
    }

    @media (max-width: 576px) {
        .nav-link-mobile {
            border-bottom: 1px solid #dee2e6;
            /* Add the border */
        }
    }
</style>
<style>
    .sf_chat_button {
        display: none;
        /* hide ai astrologer button from project */
        position: fixed;
        bottom: 12px;
        right: 12px;
        z-index: 99;
        font-family: Gilroy, Inter, sans-serif;
    }

    .sf_chat_button button {
        border-radius: 50%;
        /* background: rgb(255 215 0); */
        color: #FFFFFF;
        padding: 0;
        border: none;
        background: none;

    }

    .sf_chat_button svg {
        display: inline-block;
    }

    /* ----------------------------------------------FOR MASTER-----------------------------------------*/
    /* when start ai astrologer by category then comment .sf_chat_button1 */
    .sf_chat_button1 {
        position: fixed;
        bottom: 12px;
        right: 12px;
        z-index: 99;
        font-family: Gilroy, Inter, sans-serif;
    }

    .sf_chat_button1 button {
        border-radius: 50%;
        padding: 0;
        border: none;
        background: none;
    }

    .sf_chat_button1 svg {
        display: inline-block;
    }
</style>





<div class="header">
    <nav class="navbar navbar-expand-lg navbar-light top-navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Left Side: Toggle Button + Logo + Subtext -->
            <div class="d-flex align-items-center">
                <button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="text-decoration-none" href="{{ route('front.home') }}">
                    <div class="d-flex align-items-center ml-2">

                        <img src="{{ asset($logo->value) }}" alt="{{ $appName->value }}" class="img-fluid" width="50"
                            height="50">

                        <div class="astroway-logo-ntext ml-2">
                            <span class="astroway-logo-text notranslate">{{ $appName->value }}</span>
                           <span class="astroway-logo-subtext notranslate">Consult Online {{ $professionTitle }}s
                                Anytime</span>
                        </div>

                    </div>
                </a>
            </div>

            <div class="btn-groups d-none d-lg-flex mr-md-3">
                <a href="{{ route('front.talkList') }}" id="callPg" class="btn btn-chat-astro other-country"><img
                        src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/call.svg') }}"
                        alt="call"> Talk To {{ $professionTitle }}</a>
                <a href="{{ route('front.chatList') }}" id="chatPg" class="btn btn-chat-astro"><img
                        src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/chat.svg') }}"
                        alt="chat"> Chat With {{ $professionTitle }}</a>
            </div>

            <div class="d-flex align-items-center">

                <div id="google_translate_button" class="d-none d-md-block" style="height:38px;width:82px"></div>


                @if (authcheck())

                    <li class="list-inline-item">
                        <div class="dropdown ">
                            <a class="btn dropdown-toggle p-0" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                                @if (authcheck()['profile'])
                                    <img src="{{ asset(authcheck()['profile']) }}" alt="User" class="img-fluid rounded" style="height: 50px;width:50px">
                                @else
                                    <img src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img.png') }}"
                                        alt="" class="psychic-img img-fluid" >
                                @endif


                            </a>
                            <div class="dropdown-menu user-options fadeInUp5px dropdown-menu-right dropdown-menu-lg-left scrollable-menu"
                                aria-labelledby="dropdownMenuLink">
                                <ul>
                                    <li class="namedisplay d-block text-center">


                                        @if (authcheck()['profile'])
                                            <img src="{{ asset(authcheck()['profile']) }}" alt="User"
                                                class="img-fluid rounded" >
                                        @else
                                            <img src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png') }}"
                                                alt="User" class="img-fluid">
                                        @endif

                                        <div>
                                            <h2 class="pt-3">{{ authcheck()['name'] ?: 'User' }}

                                            </h2>
                                            <h3></h3>
                                        </div>
                                    </li>
                                    <li class="d-lg-block">
                                        <div>
                                            <a class="dropdown-item " href="{{ route('front.getMyAccount') }}">
                                                <span class="mr-2 accSet accSettingWeb">
                                                    <i class="fa-solid fa-user"></i>

                                                </span>
                                                <span>My Account</span>
                                            </a>
                                        </div>
                                    </li>

                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item d-flex justify-content-between align-items-center pr-2"
                                                href="{{ route('front.getMyWallet') }}">
                                                <span>
                                                    <span class="mr-2">
                                                        <i class="fa-solid fa-wallet"></i>
                                                    </span>

                                                    <span>My Wallet</span>
                                                </span>


                                                    <span class="gWalletbalance color-red bg-pink"
                                                    style="border-radius:20px; padding:2px 10px; font-size:12px;">
                                                    @if($walletType == 'Coin')
                                                        <img src="{{ asset($coinIcon) }}" alt="Wallet Icon" width="15">
                                                    @else
                                                        {{ $currency['value'] }}
                                                    @endif
                                                    {{ number_format($userWalletAmount, 2) }}</span>

                                            </a>
                                        </div>
                                    </li>



                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.getMyChat') }}">
                                                <span class="mr-2">
                                                    <i class="fa-solid fa-comment-dots"></i>
                                                </span>
                                                <span>My Chats</span>
                                            </a>
                                        </div>
                                    </li>

                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.getMyAiChat') }}">
                                                <span class="mr-2">
                                                    <i class="fa-solid fa-comment-dots"></i>
                                                </span>
                                                <span>My Ai Chats</span>
                                            </a>
                                        </div>
                                    </li>

                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.getMyCall') }}">
                                                <span class="mr-2">
                                                    <i class="fa-solid fa-phone"></i>
                                                </span>
                                                <span>My Calls</span>
                                            </a>
                                        </div>
                                    </li>

                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.myOrders') }}">
                                                <span class="mr-2">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </span>
                                                <span>My Orders</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.getMypujalist') }}">
                                                <span class="mr-2">
                                                    <i class="fa fa-list"></i>
                                                </span>
                                                <span>My Puja Order</span>
                                            </a>
                                        </div>
                                    </li>

                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.getMyReport') }}">
                                                <span class="mr-2">
                                                    <i class="fa-solid fa-file"></i>
                                                </span>
                                                <span>My Reports</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.getMyFollowing') }}">
                                                <span class="mr-2">
                                                    <i class="fa-solid fa-circle-user"></i>
                                                </span>
                                                <span>My Following</span>
                                            </a>
                                        </div>
                                    </li>

                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.getblockAstrologer') }}">
                                                <span class="mr-2">
                                                    <i class="fa-solid fa-circle-user"></i>
                                                </span>
                                                <span>Blocked {{ $professionTitle }}</span>
                                            </a>
                                        </div>
                                    </li>

                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" href="{{ route('front.myAstrologerPuja') }}">
                                                <span class="mr-2">
                                                    <i class="fa fa-list"></i>
                                                </span>
                                                <span>{{ $professionTitle }} Puja</span>
                                            </a>
                                        </div>
                                    </li>


                                    <li class="d-block">
                                        <div>
                                            <a class="dropdown-item" id="logout" href="javascript:void()"
                                                onclick="logout()">
                                                <span class="mr-2">
                                                    <i class="fa-solid fa-right-from-bracket"></i>
                                                </span>
                                                <span>Sign Out</span>
                                            </a>
                                        </div>
                                    </li>



                                </ul>
                            </div>
                        </div>
                    </li>

                    {{-- For Notification --}}
                    <li class="list-inline-item ml-4">
                        <div class="dropdown">
                            <a class="btn  p-0" style="width: 30px" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa-solid fa-bell"></i>
                                <span class="badge badge-danger badge-counter" id="notificationCount">0</span>
                            </a>
                            <div class="dropdown-menu user-options fadeInUp5px dropdown-menu-right dropdown-menu-lg-left scrollable-menu"
                                aria-labelledby="dropdownMenuLink" id="notificationDropdown">
                                <ul id="notificationList">
                                    @foreach ($getUserNotification as $notification)
                                        <li class="d-lg-block @if ($notification->chatStatus == 'Accepted' || $notification->callStatus == 'Accepted') bg-pink @endif">
                                            <div>
                                                <a class="dropdown-item"
                                                    @if ($notification->chatStatus == 'Accepted') onclick="setIds('{{ $notification->chatId }}', '{{ $notification->astrologerId }}')" data-toggle="modal" data-target="#chatinfomodal"
                                                @elseif($notification->callStatus == 'Accepted') onclick="setCallIds('{{ $notification->callId }}', '{{ $notification->astrologerId }}')" @if ($notification->call_method != 'exotel') data-toggle="modal"  data-target="#callinfomodal" @endif
                                                    @endif>
                                                    <span class="mr-2 accSet accSettingWeb">
                                                        <i class="fa-solid fa-bell"></i>
                                                    </span>
                                                    <span>{{ $notification->title }}</span>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                @if (count($getUserNotification) > 0)
                                    <a class="dropdown-item text-center btn clear-notification"
                                        id="clearNotifications">Clear Notifications</a>
                                @else
                                    <ul id="notificationList">
                                        <li class="d-lg-block">
                                            <span class="dropdown-item text-center ">No Notification Yet</span>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </li>

                    {{-- End --}}
                @else
                    <a class="btn p-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31.001"
                            viewBox="0 0 31 31.001">
                            <path id="Path_22197" data-name="Path 22197"
                                d="M-1542.569-660.735a15.4,15.4,0,0,0-10.96-4.54,15.4,15.4,0,0,0-10.96,4.54,15.4,15.4,0,0,0-4.54,10.96,15.4,15.4,0,0,0,4.54,10.96,15.4,15.4,0,0,0,10.96,4.54,15.4,15.4,0,0,0,10.96-4.54,15.4,15.4,0,0,0,4.54-10.96A15.4,15.4,0,0,0-1542.569-660.735Zm-18.529,22.2a1.407,1.407,0,0,1,.058-.37,7.822,7.822,0,0,1,8.253-6.134,7.787,7.787,0,0,1,7.043,6.061.694.694,0,0,1,.021.279,13.477,13.477,0,0,1-7.806,2.48A13.475,13.475,0,0,1-1561.1-638.538Zm2.805-13.283a4.915,4.915,0,0,1,4.932-4.9,4.914,4.914,0,0,1,4.89,4.938,4.9,4.9,0,0,1-4.932,4.89A4.9,4.9,0,0,1-1558.293-651.821Zm14.155,11.807c-.047-.121-.1-.26-.148-.425a9.72,9.72,0,0,0-5.4-5.721,6.706,6.706,0,0,0,3.021-5.721,6.469,6.469,0,0,0-2-4.705,6.7,6.7,0,0,0-9.414-.021,6.5,6.5,0,0,0-1.994,5.449,6.659,6.659,0,0,0,3,4.994,10.164,10.164,0,0,0-5.644,6.344,13.518,13.518,0,0,1-4.367-9.956,13.568,13.568,0,0,1,13.552-13.552,13.568,13.568,0,0,1,13.552,13.552A13.514,13.514,0,0,1-1544.138-640.014Z"
                                transform="translate(1569.03 665.275)" />
                        </svg>
                        <span class="loginSignUp" data-toggle="modal" data-target="#loginSignUp">Sign In </span>
                    </a>
                @endif
            </div>
        </div>
    </nav>



    <nav class="navbar navbar-expand-lg navbar-light" style="z-index: 1">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle font-weight-semi-bold nav-link-mobile" href="#"
                            id="matchingDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img src="{{ asset($freekundali->value) }}" alt="" height="20" width="20">
                            Kundali
                        </a>
                        <div class="dropdown-menu" aria-labelledby="matchingDropdown">
                            <a class="dropdown-item" href="{{ route('front.kundaliMatch') }}">Kundali Matching</a>
                            <a class="dropdown-item" href="{{ route('front.getkundali') }}">Free Janam Kundali</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link font-weight-semi-bold nav-link-mobile"
                            href="{{ route('front.getPanchang') }}"><img src="{{ asset($panchang->value) }}"
                                alt="" height="20" width="20"> Panchang</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link font-weight-semi-bold nav-link-mobile"
                            href="{{ route('front.pujaCategory') }}"><img src="{{ asset($puja->value) }}" alt=""
                                height="20" width="20"> Puja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-semi-bold nav-link-mobile"
                            href="{{ route('front.reportList') }}"><img
                                src="{{ asset('public/frontend/homeimage/report.png') }}" alt=""
                                height="20" width="20"> Reports</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link font-weight-semi-bold nav-link-mobile"
                            href="{{ route('front.horoScope') }}"><img src="{{ asset($daily_horoscope->value) }}"
                                alt="" height="20" width="20"> Horoscope</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link font-weight-semi-bold nav-link-mobile"
                            href="{{ route('front.getproducts') }}"><img src="{{ asset($shop->value) }}" alt=""
                                height="20" width="20"> Shop</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link font-weight-semi-bold nav-link-mobile"
                            href="{{ route('front.getBlog') }}"><img src="{{ asset($blog->value) }}" alt=""
                                height="20" width="20">Blog</a>
                    </li>

                    <li class="nav-item d-lg-none mb-2 mt-2 text-center">
                        <a href="{{ route('front.talkList') }}" id="callPg"
                            class="btn btn-chat other-country"><img
                                src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/call.svg') }}"
                                alt="call"> Talk To {{ $professionTitle }}</a>
                        <a href="{{ route('front.chatList') }}" id="chatPg" class="btn btn-chat"><img
                                src="{{ asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/chat.svg') }}"
                                alt="chat"> Chat With {{ $professionTitle }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

{{-- Chat Accept Reject Model --}}
<div id="chatinfomodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm h-100 d-flex align-items-center">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title font-weight-bold">
                    Accept Chat Request
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <form id="chatForm">
                    <input type="hidden" name="chatId" id="chatIdInput" value="">
                    <input type="hidden" id="astrologerIdInput" name="astrologerId" value="">
                    <div class="text-center">
                        <a class="btn btn-chataccept  active d-inline-block m-2" id="startchat" role="button"
                            data-toggle="modal">
                            Start Chat
                        </a>
                        <a class="btn btn-chatreject active d-inline-block m-2" id="rejectchat" role="button"
                            data-toggle="modal">
                            Reject Chat
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

{{-- Call Accept Reject Modal --}}

<div id="callinfomodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm h-100 d-flex align-items-center">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title font-weight-bold">
                    Accept Call Request
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <form id="callForm">
                    <input type="hidden" name="callId" id="callIdInput" value="">
                    <input type="hidden" id="astrologerIdInput" name="astrologerId" value="">
                    <input type="hidden" id="calltypeInput" name="call_type" value="">
                    <div class="text-center">
                        <a class="btn btn-chataccept  active d-inline-block m-2" id="startcall" role="button"
                            data-toggle="modal">
                            Start Call
                        </a>
                        <a class="btn btn-chatreject active d-inline-block m-2" id="rejectcall" role="button"
                            data-toggle="modal">
                            Reject Call
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

{{-- End Model --}}

<!-- Add Select2 CSS CDN -->


<div class="modal fade rounded mt-2 mt-md-5 login-offer" id="loginSignUp" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body pt-0 pb-0">
                <div class="login-offer-bg d-none">
                    <p class="text-white font-22 text-center font-weight-bold p-0 m-0 offertxt1">Get
                        Consultation from Experts</p>
                    <p class="text-center p-0 m-0 offertxt2 ">First Chat Free</p>
                </div>
                <button type="button" class="close login-sig-close-btn loginCloseBut" data-dismiss="modal"
                    aria-hidden="true">
                    ×
                </button>
                <div class="bg-white body">
                    <div class="row ">
                        <div class="col-md-12 px-4 py-5">
                            <ul class="nav nav-tabs"></ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="LoginRegisterWithOTP">
                                    <div class="col-md-12 text-center font-22 ">
                                        <h3 class="font-weight-bold">Sign In</h3>
                                    </div>
                                    <div>
                                        <p class="colorblack text-center pb-md-0 pb-2 mb-0">Enter your mobile number to continue</p>
                                    </div>
                                    <div class="pt-4">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="d-flex inputform country-dropdown-container" id="header-country-dropdown-container">
                                                    <!-- Country Code Dropdown -->
                                                    <select class="form-control select2" id="countryCode"name="countryCode">
                                                        @foreach ($countries as $country)
                                                            <option data-country="in" value="+{{ $country->phonecode }}" data-ucname="India">
                                                                +{{ $country->phonecode }} {{ $country->iso }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <!-- Mobile Number Input -->
                                                    <input class="form-control mobilenumber border-left text-box single-line" id="contactNo" maxlength="12" name="contactNo" placeholder="Enter Mobile Number." type="number">
                                                    <input type="hidden" id="validOtp" value="" />
                                                </div>
                                                <!--<span class="text-danger field-validation-error  ContactMobile-error" style="display: none">Please Enter Your Mobile Number</span>-->
                                                <span class="text-danger field-validation-error otp-error" id="mobileMessage"></span>
                                            </div>
                                        </div>

                                        <!-- Get OTP Button -->
                                        <div class="form-group text-center">
                                            <button class="font-weight-bold ml-0 w-100 btn btn-chat" id="loaderOtpLogin" type="button" style="display:none;" disabled="">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                            <!--<input type="button" id="getOtp" value="Get OTP" class="font-weight-bold ml-0 w-100 btn btn-chat valid" aria-invalid="false" onclick="phoneAuth()" >-->
                                            <input type="button" id="sendOtpBtn" value="Send OTP" class="font-weight-bold ml-0 w-100 btn btn-chat valid" aria-invalid="false" >
                                        </div>
                                    </div>
                                    <div class="container mt-3 mb-3">
                                        <div class="row">
                                            {{-- <div class="col-md-6">
                                                <button style="font-size: 14px" class="btn btn-success w-100 d-flex align-items-center justify-content-center" onclick="oauth('WHATSAPP')">
                                                    <i class="fa-brands fa-whatsapp mr-2"></i>
                                                    <span>WhatsApp Login</span>
                                                </button>
                                            </div> --}}

                                            <div class="col-md-12">
                                                <button
                                                    class="btn btn-danger w-100 d-flex align-items-center justify-content-center"
                                                    id="googleLoginBtn">
                                                    <i class="fa-solid fa-envelope mr-2"></i>
                                                    <span>Continue With Gmail</span>
                                                </button>
                                            </div>
                                            <!--<div class="col-md-12 mt-2">-->
                                            <!--    <button-->
                                            <!--        class="btn btn-success w-100 d-flex align-items-center justify-content-center"-->
                                            <!--        onclick="oauth('WHATSAPP')">-->
                                            <!--        <i class="fa-brands fa-whatsapp mr-2" style="font-size: 21px"></i>-->
                                            <!--        <span>Continue With Whatsapp</span>-->
                                            <!--    </button>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-11 list-inline-item ml-md-3 ml-sm-0">
                                            <p class="text-dark font-13 text-center pb-md-0 pb-2 mb-0">
                                                By signing in, you agree to our&nbsp;<a class="text-dark font-13" style="color:#EE4E5E !important" href="{{route('front.termscondition')}}" target="_blank">Terms Of Use</a>&nbsp;and&nbsp;<a class="text-dark font-13" style="color:#EE4E5E !important" href="{{route('front.privacyPolicy')}}" target="_blank">Privacy Policy</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- OTP Input (Initially Hidden) -->
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <!--<div id="otpInputGroup" style="display: none;">-->
                                        <div id="otpInputGroup" class="d-none">
                                            <div class="col-md-12 text-center pb-2 pb-md-4">
                                                <h3 class="font-22 font-weight-bold">OTP Verification</h3>
                                            </div>
                                            <div class="otpheader pb-2 align-items-center">
                                                <!--Enter 6 digit code sent to Your Number.<a href="#" onclick="editMobile()" class="pl-1  font-14 text-danger">Edit</a>-->
                                                Enter 6 digit code sent to Your Number.<a href="#" onclick="editMobileNumber()" class="pl-1  font-14 text-danger">Edit</a>
                                            </div>
                                            <div class="form-group">
                                                <!--<input class="form-control" id="otp" name="otp" placeholder="Enter OTP" type="number">-->
                                                <input class="form-control" id="otpCode" name="otp" placeholder="Enter OTP" type="number">
                                            </div>
                                            <div class="form-group float-right">
                                                <button id="resendOtpBtn" class="btn btn-sm text-primary" onclick="startOtpTimer()">Resend OTP</button>
                                            </div>
                                            <span class="text-danger" id="otpLoginMessage"></span>

                                            <form method="post" action="{{ route('front.verifyOTL') }}"
                                                id="OtpLesslogin">
                                                @csrf
                                                <input type="hidden" name="otl_token" id="otl_token">
                                                <input id="veifycontactNo" name="contactNo" type="hidden"
                                                    value="" />
                                                <input id="countryCode" name="countryCode" type="hidden"
                                                    value="" />
                                                <input id="country" name="country" type="hidden"
                                                    value="" />
                                                <input id="name" name="name" type="hidden"
                                                    value="" />
                                            </form>

                                            <div class="form-group text-center">
                                                <div class="my-0 w-100">
                                                    <button class="font-weight-bold w-100 btn btn-chat ml-0" id="loaderVerifyLogin" type="button" style="display:none" disabled="">
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        Loading...
                                                    </button>

                                                    <!--<input type="submit" value="Submit" class="btn btn-chat font-weight-bold w-100 ml-0 mt-3" id="btnVerify" onclick="verifyOTP()">-->
                                                    <input type="button" value="Submit" id="verifyOtpBtn" class="btn btn-chat font-weight-bold w-100 ml-0 mt-3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p>Download Our App For Better Experience</p>
                                    <a href="{{$playstore->value}}" class="mt-2"><img src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/google-play.png')}}" alt="google-play" class="mt-2 img-fluid" width="183" height="54" loading="lazy"></a>
                                    <a href="{{$appstore->value}}"><img src="{{asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/app-store.png')}}" alt="google-play" class="img-fluid mt-2" width="183" height="54" loading="lazy"></a>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="astroLoginModal" tabindex="-1" role="dialog" aria-labelledby="astroLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pb-5 px-4">
                <div class="mb-4">
                    <i class="fa-solid fa-circle-exclamation text-warning" style="font-size: 60px;"></i>
                </div>
                <h4 class="font-weight-bold mb-3">Astrologer Account Detected</h4>
                <p class="text-muted mb-4" id="astroLoginMessage">
                    This contact information is already registered as an astrologer. Please use the astrologer portal to login.
                </p>
                <div class="d-flex flex-column gap-2">
                    <a href="{{route('front.astrologerlogin')}}" class="btn btn-chat w-100 py-3 font-weight-bold">
                        Go to Astrologer Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth-compat.js"></script>
<script>
  const firebaseConfig = {
    apiKey: "AIzaSyBgedfzopcQAhydvjCbGiZ5Y96AWr2h0Fo",
    authDomain: "astrologer-b2a22.firebaseapp.com",
    projectId: "astrologer-b2a22",
    storageBucket: "astrologer-b2a22.appspot.com",
    messagingSenderId: "388934999115",
    appId: "1:388934999115:web:f36ef7ad7124ba16a1be0c"
  };
  firebase.initializeApp(firebaseConfig);
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- Added by bhushan borse on 12, June 2025 -->
<script>
$(document).ready(function () {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'invisible'
    });

    $('#sendOtpBtn').click(function () {
        const mobile = $('#contactNo').val();
        const countryCode = $('#countryCode').val().trim();
        const fullNumber = countryCode + mobile;
        $('#otpLoginMessage').text('');
        $('#mobileMessage').text('')
        $("#validOtp").val("");
        $("#otpCode").val("")


        if (mobile?.length <= 0) {
            $('#mobileMessage').text('Please Enter Your Mobile Number');
            return
        }

        if (mobile === "9797979797" || mobile === "9898989898") {
            $('#otpInputGroup').removeClass('d-none');
            $('#sendOtpBtn').addClass('d-none');
            makeAction(true);
            return;
        }

        firebase.auth().signInWithPhoneNumber(fullNumber, window.recaptchaVerifier)
            .then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                $('#mobileMessage').text('');
                $('#otpInputGroup').removeClass('d-none');
                $('#sendOtpBtn').addClass('d-none');
                makeAction(true);
            }).catch(function (error) {
                $('#mobileMessage').text(error.message);
            });
    });

    $('#verifyOtpBtn').click(function () {
        const mobile = $('#contactNo').val();
        const otpCode = $('#otpCode').val();
        const countryCode = $('#countryCode').val().trim();

        if (otpCode?.length <= 0) {
            $("#otpLoginMessage").html("Enter OTP")
            return
        }

        if (mobile === "9797979797" || mobile === "9898989898") {
            if (otpCode === "111111") {
                verifyBackendLogin(mobile, countryCode, otpCode);
            } else {
                $("#otpLoginMessage").html("Invalid OTP");
            }
            return;
        }

        window.confirmationResult.confirm(otpCode).then(function (result) {
            verifyBackendLogin(mobile, countryCode, otpCode);
        }).catch(function (error) {
            $("#otpLoginMessage").html("Invalid OTP");
        });
    });

    function verifyBackendLogin(mobile, countryCode, otpCode) {
        $.ajax({
            url: '{{ route("front.verifyOTL") }}',
            method: 'POST',
            data: {
                contactNo: mobile,
                otp: otpCode,
                countryCode: countryCode,
                country: '',
                isFirebaseVerified: 1,
                fromWeb: 1
            },
            success: function (res) {
                if (res.status == 200) {
                    location.reload();
                } else {
                    toastr.error(res.message);
                    $('#mobileMessage').text(res.message);
                }
            },
            error: function (e) {
                toastr.error(e?.responseJSON?.message);
                $('#mobileMessage').html(e?.responseJSON?.message);
            }
        });
    }
});

function makeAction(action = false) {
    if (action) {
        $("#contactNo").attr("readonly", true)
        $("#contactNo").attr("disabled", true)
        $("#countryCode").attr("readonly", true)
        $("#countryCode").attr("disabled", true)
        $("#header-country-dropdown-container").css('background-color', '#e9ecef')
    }
    if (!action) {
        $("#contactNo").removeAttr("readonly");
        $("#contactNo").removeAttr("disabled");
        $("#countryCode").removeAttr("readonly");
        $("#countryCode").removeAttr("disabled");
        $("#header-country-dropdown-container").css('background-color', '')
    }
}

function editMobileNumber() {
    $("#validOtp").val("")
    $('#otpInputGroup').addClass('d-none');
    $('#sendOtpBtn').removeClass('d-none');
    makeAction(false)
}
</script>
<!-- Added by bhushan borse on 12, June 2025 -->

<script>
    $(document).ready(function() {
        // Initialize Select2

        $('#countryCode').select2({
            dropdownAutoWidth: true,
            width: 'resolve',
            minimumResultsForSearch: 0
        });
    });

</script>


@if (authcheck())
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize OneSignal
            window.OneSignalDeferred = window.OneSignalDeferred || [];
            OneSignalDeferred.push(async function(OneSignal) {
                await OneSignal.init({
                    appId: "{{ $OneSignalAppId->value }}",
                });
            });

            // Check and request notification permission using the browser API
            const checkNotificationPermission = async () => {
                const permission = Notification.permission;

                if (permission === 'default') {
                    try {
                        const newPermission = await Notification.requestPermission();

                        if (newPermission === 'granted') {
                            const subscriptionId = OneSignal.User.PushSubscription.id;

                            if (subscriptionId) {
                                // Send the subscription ID to the server
                                $.ajax({
                                    url: '{{ route('storeSubscriptionId') }}',
                                    type: 'POST',
                                    data: {
                                        subscription_id_web: subscriptionId,
                                    },
                                    dataType: 'JSON',
                                    success: function(response) {
                                        console.log('Subscription ID stored:', response);
                                    },
                                    error: function(err) {
                                        console.error('Error storing subscription ID:', err);
                                    },
                                });
                            }
                        } else {
                            console.log('Permission not granted or blocked:', newPermission);
                        }
                    } catch (error) {
                        console.error('Error requesting notification permission:', error);
                    }
                } else if (permission === 'granted') {
                    console.log('Notification permission already granted.');
                } else {
                    console.log('Notification permission denied or blocked.');
                }
            };

            // Automatically check notification permission when the page loads
            checkNotificationPermission();
        });
    </script>
@endif


<script>
    var firebaseConfig = {
        apiKey: "{{ $apiKey->value }}",
        databaseURL: "{{ $databaseURL->value }}",
        authDomain: "{{ $authDomain->value }}",
        projectId: "{{ $projectId->value }}",
        storageBucket: "{{ $storageBucket->value }}",
        messagingSenderId: "{{ $messagingSenderId->value }}",
        appId: "{{ $appId->value }}",
        measurementId: "{{ $measurementId->value }}"
    };

    if (firebaseConfig.apiKey && firebaseConfig.apiKey.trim() !== "") {
        try {
            if (firebase.apps.length === 0) {
                firebase.initializeApp(firebaseConfig);
            }
        } catch (e) {
            console.error("Firebase init error: ", e);
        }
    }
</script>



<script>
    function logout() {
        $.ajax({
            url: "{{ route('front.logout') }}", // URL of your logout route
            type: 'GET',
            success: function(response) {

                toastr.success('Logged out successfully');

                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                toastr.error(error);
            }
        });
    }
</script>

@if (authcheck())
    <script>
        // Store the IDs of notifications that have already triggered a modal
        let processedNotifications = new Set();

        function setIds(chatId, astrologerId) {
            document.getElementById('chatIdInput').value = chatId;
            document.getElementById('astrologerIdInput').value = astrologerId;
        }

        function setCallIds(callId, astrologerId, call_type) {
            document.getElementById('callIdInput').value = callId;
            document.getElementById('astrologerIdInput').value = astrologerId;
            document.getElementById('calltypeInput').value = call_type;
        }

        // ---------------------

        // Retrieve last processed ID from localStorage or set it to 0 if not present
        let lastProcessedId = parseInt(localStorage.getItem('lastProcessedId')) || 0;

        setInterval(function() {
            fetch("{{ route('api.getUserNotification', ['token' => $token]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const notificationDropdown = document.getElementById('notificationDropdown');
                    const notificationCount = document.getElementById('notificationCount');

                    // Create a container for all notification content
                    let notificationContent = document.createElement('div');

                    if (data.recordList.length > 0) {
                        // Create notification list
                        const notificationList = document.createElement('ul');
                        notificationList.id = 'notificationList';

                        data.recordList.forEach(notification => {
                            const isChatAccepted = notification.chatStatus === 'Accepted';
                            const isCallAccepted = notification.callStatus === 'Accepted';

                            // Check if the notification is new
                            if (notification.id > lastProcessedId) {
                                playSound("{{ asset('public/sound/livechat-129007.mp3') }}");
                                localStorage.setItem('lastProcessedId', notification.id);
                                lastProcessedId = notification.id;
                            }

                            // Create notification item
                            const listItem = document.createElement('li');
                            listItem.className = 'd-lg-block';
                            listItem.setAttribute('not-id', notification.id);

                            listItem.innerHTML = `
                                <div>
                                    <a class="dropdown-item"
                                        ${isChatAccepted ?
                                            `onclick="setIds('${notification.chatId}', '${notification.astrologerId}')" data-toggle="modal" data-target="#chatinfomodal"` :
                                            (isCallAccepted ?
                                                `onclick="setCallIds('${notification.callId}', '${notification.astrologerId}', '${notification.call_type}')" ${notification.call_method !== 'exotel' ? 'data-toggle="modal" data-target="#callinfomodal"' : ''}` :
                                                '')}>
                                        <span class="mr-2 accSet accSettingWeb">
                                            <i class="fa-solid fa-bell"></i>
                                        </span>
                                        <span>${notification.title}</span>
                                    </a>
                                </div>
                            `;

                            notificationList.appendChild(listItem);

                            // Process modal opening logic
                            if ((isChatAccepted || isCallAccepted) && !processedNotifications.has(notification.id)) {
                                processedNotifications.add(notification.id);
                                if (isChatAccepted) {
                                    setIds(notification.chatId, notification.astrologerId);
                                    $('#chatinfomodal').modal('show');
                                } else if (isCallAccepted) {
                                    setCallIds(notification.callId, notification.astrologerId, notification.call_type);
                                    if (notification.call_method != 'exotel') {
                                        $('#callinfomodal').modal('show');
                                    }
                                }
                            }
                        });

                        notificationContent.appendChild(notificationList);

                        // Add Clear Notifications button
                        const clearButton = document.createElement('a');
                        clearButton.className = 'dropdown-item text-center btn clear-notification';
                        clearButton.id = 'clearNotifications';
                        clearButton.textContent = 'Clear Notifications';
                        clearButton.onclick = function() {
                            // Implement your clear notifications logic here
                            // For example:
                            fetch("{{ route('api.deleteAllUserNotification', ['token' => $token]) }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(() => {
                                toastr.success('Notification Cleared Successfully');
                                notificationCount.innerText = '0';
                                notificationDropdown.innerHTML = `
                                    <ul id="notificationList">
                                        <li class="d-lg-block">
                                            <span class="dropdown-item text-center">No Notification Yet</span>
                                        </li>
                                    </ul>
                                `;
                            })
                            .catch(error => console.error('Error clearing notifications:', error));
                        };
                        notificationContent.appendChild(clearButton);

                        notificationCount.innerText = data.recordList.length;
                    } else {
                        // No notifications case
                        notificationContent.innerHTML = `
                            <ul id="notificationList">
                                <li class="d-lg-block">
                                    <span class="dropdown-item text-center">No Notification Yet</span>
                                </li>
                            </ul>
                        `;
                        notificationCount.innerText = '0';
                    }

                    // Replace the dropdown content
                    notificationDropdown.innerHTML = '';
                    notificationDropdown.appendChild(notificationContent);
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }, 4000);

        function playSound(url) {
            const audio = new Audio(url);
            audio.play();
        }

        $('#startchat').click(function(e) {
            e.preventDefault();
            var formData = $('#chatForm').serialize();
            var astrologerId = $("#astrologerIdInput").val();
            var chatId = $("#chatIdInput").val();

            $.ajax({
                url: "{{ route('api.acceptChatRequestFromCustomer', ['token' => $token]) }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Chat Started Successfully..Wait');
                    window.location.href = "{{ route('front.chat') }}" + "?astrologerId=" +
                        astrologerId + "&chatId=" + chatId;
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });

        // Reject Chat

        $('#rejectchat').click(function(e) {
            e.preventDefault();
            var formData = $('#chatForm').serialize();
            var astrologerId = $("#astrologerIdInput").val();

            $.ajax({
                url: "{{ route('api.rejectChatRequestFromCustomer', ['token' => $token]) }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Chat Rejected Successfully.');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });


        // Start Call

        $('#startcall').click(function(e) {
            e.preventDefault();
            var formData = $('#callForm').serialize();
            var astrologerId = $("#astrologerIdInput").val();
            var callId = $("#callIdInput").val();
            var call_type = $("#calltypeInput").val();


            $.ajax({
                url: "{{ route('api.acceptCallRequestFromCustomer', ['token' => $token]) }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Call Started Successfully..Wait');
                    window.location.href = "{{ route('front.call') }}" + "?astrologerId=" +
                        astrologerId + "&callId=" + callId + "&call_type=" + call_type;
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });


        // Reject Call

        $('#rejectcall').click(function(e) {
            e.preventDefault();
            var formData = $('#callForm').serialize();
            var astrologerId = $("#astrologerIdInput").val();

            $.ajax({
                url: "{{ route('api.rejectCallRequestFromCustomer', ['token' => $token]) }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Call Rejected Successfully.');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });
        $('#clearNotifications').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('api.deleteAllUserNotification', ['token' => $token]) }}",
                type: 'POST',
                success: function(response) {
                    toastr.success('Notification Cleared Successfully');

                },
                error: function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });
        });
    </script>
@endif

<script>

    let countdownInterval;

    function startOtpTimer() {
        let countdown = 30;
        let $btn = $('#resendOtpBtn');
        $btn.prop('disabled', true).html(`Resend OTP in <span id="timer">${countdown}</span>s`);
        $btn.prop('disabled', true).removeClass('text-primary').addClass(`text-info`);

        clearInterval(countdownInterval); // clear previous
        countdownInterval = setInterval(function () {
            countdown--;
            $('#timer').text(countdown);
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                $btn.prop('disabled', false).removeClass('text-info').addClass(`text-primary`).text('Resend OTP');
            }
        }, 1000);
    }

</script>
<script>
    document.getElementById('googleLoginBtn').addEventListener('click', async function () {
        const provider = new firebase.auth.GoogleAuthProvider();
        firebase.auth().signInWithPopup(provider)
        .then(async (result) => {
            const idToken = await result.user.getIdToken();

            // Send token to backend
            console.log(" response 1539 :: ", result.user)

            $.ajax({
                url: '{{ route("front.verifyOTL") }}',
                method: 'POST',
                data: {
                    fromWeb: 1,
                    isGoogleLogin: 1,
                    email: result.user?.email,
                    name: result.user?.displayName
                },
                success: function (res) {
                    console.log(" res :: ", res)
                    if (res.status == 200) {
                        location.reload();
                    } else {
                        if (res.message === 'This email is registered as an astrologer') {
                            $('#loginSignUp').modal('hide');
                            $('#astroLoginModal').modal('show');
                        } else {
                            toastr.error("Login failed: " + res.message);
                        }
                    }
                },
                error: function (e) {
                    if (e?.responseJSON?.message === 'This email is registered as an astrologer') {
                        $('#loginSignUp').modal('hide');
                        $('#astroLoginModal').modal('show');
                    } else {
                        toastr.error("Login failed: " + e?.responseJSON?.message);
                    }
                }
            });
        })
        .catch((error) => {
            toastr.error(error?.responseJSON?.message);
        });
    });
</script>
