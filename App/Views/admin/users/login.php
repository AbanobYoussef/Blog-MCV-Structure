<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V7</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo assets('admin/images/icons/favicon.ico');?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/vendor/bootstrap/css/bootstrap.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/fonts/font-awesome-4.7.0/css/font-awesome.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="
	<?php echo assets('admin/vendor/animate/animate.css');?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/vendor/css-hamburgers/hamburgers.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/vendor/animsition/css/animsition.min.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/vendor/select2/select2.min.css');?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/vendor/daterangepicker/daterangepicker.css');?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/css/util.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo assets('admin/css/main.css');?>">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-90 p-b-30">
				<form id="login-form" class="login100-form validate-form" action="<?php echo url('admin/login/submit');?>" method='post'>
					<span class="login100-form-title p-b-40">
						Login
					</span>

					<div>
						<a href="#" class="btn-login-with bg1 m-b-10">
							<i class="fa fa-facebook-official"></i>
							Login with Facebook
						</a>

						<a href="#" class="btn-login-with bg2">
							<i class="fa fa-twitter"></i>
							Login with Twitter
						</a>
					</div>

					<div class="text-center p-t-55 p-b-30">
						<div id='login-results' style="font-weight:bold">
						</div>
						<span class="txt1">
							Login with email
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter email: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-20" data-validate = "Please enter password">
						<span class="btn-show-pass">
							<i class="fa fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<button id='but' class="login100-form-btn">
							Login
						</button>
						<input  type="checkbox" name="remeber" style="margin-top:20px;margin-left:20px;">
						<span style="margin-top:15px;">Remember Me</span>
					</div>
					
					<div class="flex-col-c p-t-224">
						<span class="txt2 p-b-10">
							Don’t have an account?
						</span>

						<a href="#" class="txt3 bo1 hov1">
							Sign up now
						</a>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="<?php echo assets('admin/vendor/jquery/jquery-3.2.1.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo assets('admin/vendor/animsition/js/animsition.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo assets('admin/vendor/bootstrap/js/popper.js');?>"></script>
	<script src="<?php echo assets('admin/vendor/bootstrap/js/bootstrap.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo assets('admin/vendor/select2/select2.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo assets('admin/vendor/daterangepicker/moment.min.js');?>"></script>
	<script src="<?php echo assets('admin/vendor/daterangepicker/daterangepicker.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo assets('admin/vendor/countdowntime/countdowntime.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo assets('admin/js/main.js');?>"></script>
	<script>
		$(function(){
			var flag=false;
			reus= $('#login-results');

			$('#login-form').on('submit',function (e){
			e.preventDefault();
			if(flag===true)
			{
				return false;
			}
			
			form=$(this);

			requestUrl=form.attr('action');

			requestMethod=form.attr('method');

			requestData=form.serialize();

			$.ajax({

				url:requestUrl,
				type:requestMethod,
				data:requestData,
				dataType:'json',
				beforeSend:function (){
					flage=true;
					$('#but').attr('disabled',true);
					reus.removeClass().addClass('alert alert-info').html('Logging....');
				},
				success : function (results){
					if(results.errors)
					{
						reus.removeClass().addClass('alert alert-danger').html(results.errors);
					
						$('#but').removeAttr('disabled');
						flag=false;
					} 
					else if (results.success)
					{
						reus.removeClass().addClass('alert alert-success').html(results.success);
						setTimeout(function(){
							if(results.redirect)
							{
								window.location.href=results.redirect;
							}
						},2000);
					}
				}
			});

		});
		});
		
	</script>

</body>
</html>