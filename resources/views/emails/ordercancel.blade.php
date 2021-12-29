<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Booking cancellation notifications on {{ config('legacy.site_name') }}</title>
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
				<td colspan="2" style="padding: 20px;" align="center" >
					<h3 style="margin-bottom:15px; color: #707070; font-family:  Calibri , Arial; font-size:20px">Hi {{ $orderData['name'] }}</h3>
					<span style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">The Order Id {{ $orderData['orderid'] }} has been cancelled.<br/>Please find below cancel booking details</span>
				</td>
			</tr>
			<tr>
				<td style="padding: 20px;" colspan="2" align="center" >
					<table style="width:100%;" cellspacing="0" cellpadding="0">
						<tr style="background: rgba(255,255,255,.7); border-top:1px dashed #5680ab">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Order ID</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['orderid']}}</td>
						</tr>
						<tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Payment Mode:</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['paywith']}}</td>
						</tr>
						<tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Customer Name:</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['name'] }}</td>
						</tr>
						<tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Customer Email:</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['email'] }}</td>
						</tr>
						<tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Customer Phone:</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['phone'] }}</td>
						</tr>
						<tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Price :</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">${{ $orderData['total']}}</td>
						</tr>
						<tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Booking Date:</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['booking_date']}}</td>
						</tr>
                        <tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Booking Time:</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['booking_time'] }}</td>
						</tr>
						<tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Cancellation Date:</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['updated_at']}}</td>
						</tr>
						<tr style="background: rgba(255,255,255,.7)">
							<td  style="padding: 8px 20px;"><strong style="color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">Transaction Id:</strong></td>
							<td  style="padding: 8px 20px;color: #707070;font-size: 18px; font-family:  Calibri , Arial; ">{{ $orderData['payid']}}</td>
						</tr>
					</table>
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
