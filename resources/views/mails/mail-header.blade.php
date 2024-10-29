<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME',APP_NAME)}}</title>
    <link href="{{asset('themes/css/custom/mail-style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div id="wrapper-inner">
            <table class="main-table">
                <tr>
                    <td class="one-column">
                        <div class="section">
                            <table width="100%">
                                <tr>
                                    <td class="header" style=" background-color: #323334;color:#fff !important;border-bottom: 3px solid #99885b;width:100% !important">
                                        <p style="text-align: center;padding: 1%;font-weight: 900;font-size: 11px;text-transform: uppercase;color:#fff !important;">
                                            <a href="#" style="color:#fff !important;">{{env('APP_NAME',APP_NAME)}}, Momas Electricity Meters Manufacturing Company Limited (MEMMCOL)</a>
                                        </p>
                                    </td>
                                </tr>
                                {{-- <tr width="100%">
                                    <td width="100%">
                                        <table style="background-color: #f1f1f1;" width="100%">
                                            <tr>
                                                <td class="two-column">
                                                    <img src="{{asset('files/internal_images/logo.jpg')}}" alt="{{env('APP_NAME',APP_NAME)}}">
                                                </td>
                                                <td>
                                                    <h4 style="padding-left: 10px;">
                                                        <span class="ed-color">The next generation of metering technology</span>,<br>
                                                    </h4>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr> --}}