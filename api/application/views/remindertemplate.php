<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if (gte mso 9)|(IE)]>
	<xml>
		<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="UTF-8">
	<title>Notification Email </title>

	<!-- Google Fonts Link -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">

		/*------ Client-Specific Style ------ */
		@-ms-viewport{width:device-width;}
		table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
		img{-ms-interpolation-mode:bicubic; border: 0;}
		p, a, li, td, blockquote{mso-line-height-rule:exactly;}
		p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
		#outlook a{padding:0;}
		.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
		.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%;}

		/*------ Reset Style ------ */
		*{-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}
		table{border-spacing: 0 !important;}
		h1, h2, h3, h4, h5, h6, p{display:block; Margin:0; padding:0;}
		img, a img{border:0; height:auto; outline:none; text-decoration:none;}
		#bodyTable, #bodyCell{ margin:0; padding:0; width:100%;}
		body {height:100%; margin:0; padding:0; width:100%;}

		.appleLinks a {color: #c2c2c2 !important; text-decoration: none;}
        span.preheader { display: none !important; }

		/*------ Google Font Style ------ */
		[style*="Open Sans"] {font-family:'Open Sans', Helvetica, Arial, sans-serif !important;}				
		/*------ General Style ------ */
		.wrapperWebview, .wrapperBody, .wrapperFooter{width:100%; max-width:600px; Margin:0 auto;}

		/*------ Column Layout Style ------ */
		.tableCard {text-align:center; font-size:0;}
		
		/*------ Images Style ------ */
		.imgHero img{ width:600px; height:auto; }
		
	</style>

	<style type="text/css">
		/*------ Media Width 480 ------ */
		@media screen and (max-width:640px) {
			table[class="wrapperWebview"]{width:100% !important; }
			table[class="wrapperEmailBody"]{width:100% !important; }
			table[class="wrapperFooter"]{width:100% !important; }
			td[class="imgHero"] img{ width:100% !important;}
			.hideOnMobile {display:none !important; width:0; overflow:hidden;}
		}
	</style>

</head>

<body style="background-color:#ffffff;">
<center>
	<table border="0" cellpadding="0" cellspacing="0" width="800" style="background-color:#F9F9F9;">
		<tr>
			<td style="padding:15px;">
               <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family: Arial, Helvetica, sans-serif; font-size:14px;">
			<tr>
				<td align="center" valign="top">
					<!-- Content Table Open // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
                         <!-- <tr>
							<td align="center" valign="middle" style="padding-top:40px;padding-bottom:40px" class="emailLogo">
								<a href="#" target="_blank" style="text-decoration:none;">
									<img src="<?php echo base_url(); ?>assets/img/logo.png" alt="" width="150"/>
								</a>
							</td>
						</tr> -->
						<tr>
							<td>
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="padding:10px 0px;">
										<p>Dear <?php echo $username; ?>,</p>
									</td>
								</tr>
								<tr>
									<td style="padding:10px 0px;">
									    <?php 
										 foreach($result as $date_data){
										    $vf = $date_data['VerificationDate'];
										 }
										   $date = DateTime::createFromFormat('d/m/Y',$vf);
										   $formattedDate = $date->format('jS F Y');
										?>
										<p style="padding:10px 0px;">It&rsquo;s time to verify your asset.</p>
									</td>
								</tr>
							</table>	
							</td>
						</tr>

                <tr>
                    <td>
                        <table width="100%" border="1">
                <tr>
                <th style="padding:5px 5px; text-align:center;">S.No</th>
                <th style="padding:5px 5px; text-align:center;">Title</th> 
                <th style="padding:5px 5px; text-align:center;">Unique Ref No</th>
                <th style="padding:5px 5px; text-align:center;">Category</th> 
                <th style="padding:5px 5px; text-align:center;">SubCategory</th>  
                <th style="padding:5px 5px; text-align:center;">Verification Date</th>
                <th style="padding:5px 5px; text-align:center;">User</th>
                <th style="padding:5px 5px; text-align:center;">Auditor</th>
                <th style="padding:5px 5px; text-align:center;">Supervisor</th>
				<th style="padding:5px 5px; text-align:center;">Action</th>
				
            </tr>   

			 <?php 
			    $i = 1;
			    foreach($result as $res_data){
					$url = base_url()."Assetmanagement/ViewAssetDetails?ref_no=".$res_data['UniqueRefNumber']."&type=1";
			 ?>
            <tr>
                <td style="padding:5px 5px; text-align:center;"><?php echo $i; ?></td>
                <td style="padding:5px 5px; text-align:center;"><?php echo $res_data['AssetTitle']; ?></td> 
                <td style="padding:5px 5px; text-align:center;"><?php echo $res_data['UniqueRefNumber']; ?></td>
                <td style="padding:5px 5px; text-align:center;"><?php echo $res_data['AsseCatName']; ?></td> 
                <td style="padding:5px 5px; text-align:center;"><?php echo $res_data['AssetSubcatName']; ?></td>  
                <td style="padding:5px 5px; text-align:center;"><?php echo $res_data['VerificationDate']; ?></td>
                <td style="padding:5px 5px; text-align:center;"><?php echo $res_data['User']; ?></td>
                <td style="padding:5px 5px; text-align:center;"><?php echo $res_data['Auditor']; ?></td>
                <td style="padding:5px 5px; text-align:center;"><?php echo $res_data['Supervisor']; ?></td>
				<td style="padding:5px 5px; text-align:center;"><a href="<?php echo $url; ?>"><button type="button" class="btn btn-warning">Verify</button></a></td>
			</tr>
			<?php 
			     $i++;
				}
			?>
            </table>
                    </td>
                </tr> 
				<tr>
					<td style="padding:20px 0px;"><p>If you already verified your asset, kindly ignore the mail.</p></td>
				<tr>
					<td style="padding:20px 0px;"><h4 style="padding:0px 0px 15px 0px;"><b>Regards,</4></h4><p><b>Asset Management System Admin</b></p></td>
					</table>
					<!-- Content Table Close // -->
				</td>
			</tr>
		</table>
		<td>
			<tr>
			</table>

		

		

	</center>
 
</body>
</html>