<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Contact Us - {{ config('legacy.site_name') }}</title>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0;
            font-family:  Calibri , Arial ;
            letter-spacing: 1px;
        }
        img{
            max-width: 100%;
        }
    </style>
</head>
<body>
<table align="center" style=" border-collapse: collapse;width:600px; " border="0" cellpadding="0px" cellspacing="0px">
    <tbody>
    <tr>
        <td colspan="2" style="padding: 20px;" align="center">
            <a href="{{ config('legacy.logo_link') }}" class="navbar-logo">
                <img class="navbar-logo-desktop" alt="logo" src="{{ config('legacy.logo_link') }}/images/logo-mail.png">
            </a>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding: 20px;" align="left" >


            {!! $userData['email_text'] !!}

        </td>
    </tr>


    <tr>
        <td colspan="2">
            <table cellspacing="25" cellpadding="0" border="0" align="center" width="100%" class="mobileview" style="font-size:14px; font-family: Calibri, Arial ;">
                <tr>
                    <td height="1" bgcolor="#bbbbbb"></td>
                </tr>
                <tr>
                    <td align="center" style="font-size:18px; font-family: Calibri, Arial ; color:#706f6f;">
                        <img src="{{ config('legacy.logo_link') }}/images/logo-mail.png" class="view-mobile" alt="" style="max-width:100%">
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <a href="{{ config('legacy.logo_link') }}" style="font-size:18px; font-family:  Calibri , Arial ; color:#000;text-decoration: none;">{{ config('legacy.site_name') }}</a><br>
                        <a href="mailto:{{ config('legacy.site_email') }}" style="font-size:18px; font-family:  Calibri , Arial ; color:#000;text-decoration: none;">{{ config('legacy.site_email') }}</a>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="font-size:18px; font-family:  Calibri, Arial ; line-height:24px; color:#706f6f;">
                        {{ config('legacy.site_address') }}
                    </td>
                </tr>
                <tr>
                    <td align="center" style="font-size:14px; font-family:  Calibri , Arial ; line-height:30px;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
