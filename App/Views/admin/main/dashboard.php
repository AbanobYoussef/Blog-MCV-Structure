<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login V7</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<form action="<?php echo url('/admin/submit');?>" method=post enctype="multipart/form-data">
			<label>Email</label>
			<input type="text" name="email">
			<br>
			<label>password</label>
			<input type="password" name="password">
			<br>
			<label>Confirm password</label>
			<input type="password" name="confirm_password">
			<br>
			<label>Full Name</label>
			<input type="text" name="full_name">
			<br>
			<input type="file" name="image">
			<br>
			<button>Send</button>
		</form>
		<script src="<?php echo assets('admin/vendor/jquery/jquery-3.2.1.min.js');?>"></script>
        <script>	
        	$(function(){
	        		$('form').on('submit',function(e){
	        		e.preventDefault();
	        		var form = $(this);
	        		var sentData= new FormData(form[0]);
	        		$.ajax({

	        			url:form.attr('action'),
	        			type:'POST',
	        			dataType:'json',
	        			data:sentData,
	        			success:function(r){
	        				$('body').append(r);
	        			},
	        			cache:false,
	        			processData:false,
	        			contentType:false,

	        		});
        		});
        	});
        </script>
	</body>
</html>