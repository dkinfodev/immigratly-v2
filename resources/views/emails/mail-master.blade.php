<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
	<style>

	/* ----------- */
	/* -- Reset -- */
	/* ----------- */
	body {
		margin: 0;
		padding: 0;
		mso-padding-alt: 0;
		mso-margin-top-alt: 0;
		width: 100% !important;
		height: 100% !important;
		mso-margin-bottom-alt: 0;
		/*background-color: #f0f0f0;*/
	}

	body, table, td, p, a, li, blockquote {
		-ms-text-size-adjust: 100%;
		-webkit-text-size-adjust: 100%;
	}

	table { border-spacing: 0; }
	table, td {
		mso-table-lspace: 0pt !important;
		mso-table-rspace: 0pt !important;
	}

	img, a img {
		border: 0;
		outline: none;
		text-decoration: none;  
	}
	img { -ms-interpolation-mode: bicubic; }

	p, h1, h2, h3, h4, h5, h6 {
		margin: 0;
		padding: 0;
	}

	.ReadMsgBody { width: 100%; }
	.ExternalClass { width: 100%; }
	.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
		line-height: 100%;
	}

	#outlook a { padding: 0; }

	img{
		max-width: 100%;
		height: auto;
	}

	/* ---------------- */
	/* -- Responsive -- */
	/* ---------------- */
	@media only screen and (max-width: 620px) {

		#foxeslab-email .table1 { width: 91% !important; }
		#foxeslab-email .table1-2 { width: 98% !important; }
		#foxeslab-email .table1-3 { width: 98% !important; }
		#foxeslab-email .table1-4 { width: 98% !important; }

		#foxeslab-email .tablet_no_float {
			clear: both;
			width: 100% !important;
			margin: 0 auto !important;
			text-align: center !important;
		}
		 #foxeslab-email .tablet_wise_float {
			clear: both;
			float: none !important;
			width: auto !important;
			margin: 0 auto !important;
			text-align: center !important;
		 }

		#foxeslab-email .tablet_hide { display: none !important; }

		#foxeslab-email .image1 { width: 100% !important; }
		#foxeslab-email .image1-290 {
			width: 100% !important;
			max-width: 290px !important;
		}

		.center_content{
			text-align: center !important;
		}
		.center_button{
			width: 50% !important;
			margin-left: 25% !important;
			max-width: 300px !important;
		}
	}


	@media only screen and (max-width: 479px) {
		#foxeslab-email .table1 { width: 98% !important; }
		#foxeslab-email .no_float {
			clear: both;
			width: 100% !important;
			margin: 0 auto !important;
			text-align: center !important;
		}
		 #foxeslab-email .wise_float {
			clear: both;
			float: none !important;
			width: auto !important;
			margin: 0 auto !important;
			text-align: center !important;
		 }

		#foxeslab-email .mobile_hide { display: none !important; }

	}

	@media (max-width: 480px){
		.container_400{
			width: 95%;
		}
	}
	</style>
</head>
<body style="padding: 30px;margin: 0;" id="foxeslab-email">
	<!-- Section-1 -->
<table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td>
			<!-- container -->
			<table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#303f9f" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
				<!-- padding-top -->
				<tr><td height="25"></td></tr>
				<tr>
					<td>
						<!-- Inner container -->
						<table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
						

							<!-- horizontal gap -->
							<tr><td height="60"></td></tr>

							<!-- <tr>
								<td align="center">
									<div class="editable-img">
										<img editable="true" mc:edit="image003" src="{{ url('assets/mail/circle-icon-person.png') }}"  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
									</div>
								</td>
							</tr>
 -->
							<!-- horizontal gap -->
							<tr><td height="40"></td></tr>

							<tr>
								<td mc:edit="text001" align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
									<div class="editable-text">
										<span class="text_container">
											<multiline>
												{{ companyName() }}
											</multiline>
										</span>
									</div>
								</td>
							</tr>
							<!-- horizontal gap -->
							<tr><td height="30"></td></tr>
						</table><!-- END inner container -->
					</td>
				</tr>
				<!-- padding-bottom -->
				<tr><td height="104"></td></tr>
			</table><!-- END container -->
		</td>
	</tr>

	<tr>
		<td>
			<!-- container -->
			<table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
				<!-- padding-top -->
				<tr><td height="60"></td></tr>

				<tr>
					<td>
						@yield('content')
					</td>
				</tr>

				<!-- padding-bottom -->
				<tr><td height="60"></td></tr>
			</table><!-- END container -->
		</td>
	</tr>
</table>
</body>

</html>