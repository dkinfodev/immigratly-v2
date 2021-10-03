@extends('emails.mail-master')

@section('content')
<table class="container_400" align="center" width="400" border="0" cellspacing="0" cellpadding="10" style="margin: 0 auto;">
	<tr>
		<td mc:edit="text003" class="text_color_282828" style="color: #282828; font-size: 15px; line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
			<div class="editable-text" style="line-height: 2;">
				<div class="text_container">
					Hello {{$first_name." ".$last_name}},<br>
					<p>We are happy to have you with us, your professional panel is created. Below is details of your panel.</p>
					<div>
						<table border="0" cellspadding="3" align="left">
							<tr>
								<th align="left">Panel Url:</th>
								<td>{{$portal_url}}</td>
							</tr>
							<tr>
								<th align="left">Email:</th>
								<td> {{$email}}</td>
							</tr>
							<tr>
								<th align="left">Password:</th>
								<td class="text-danger">You enter while signup</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</td>
	</tr>
	<tr><td height="50"></td></tr>
</table>
@endsection