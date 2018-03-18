<?php  // handlers fields  any custom forms from ajax  ?>

<?php require_once 'phpmailer.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>htm formr</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<meta charset="utf-8">
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
</head>
<body>
<!-- 
	<form id="as21-contact-form1" method="post" action="">
		<fieldset>    
			<input type="text" name="fname" placeholder="First Name">
			<input type="text" name="lname" placeholder="Last Name">
			<input type="email" name="email" type="email" placeholder="E-mail">
			<textarea name="message" placeholder="Message"></textarea>
			<input type="submit" name="submit" id="submit" value="Send" />
		</fieldset>

	</form>
	<div class="clearfix"></div>
 -->

 <h3>Contact form</h3>

	<form id="as21-contact-form" method="post" action="">
		<div class="col-sm-12">
			<div class="form-group">
				<input type="text" name="fname" class="form-control" placeholder="First Name">
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<input type="text" name="lname" class="form-control" placeholder="Last Name">
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<textarea name="message" class="form-control" name="message" placeholder="Message"></textarea>
			</div>
		</div>

		<div class="col-sm-12">
			<div class="form-group">
			<!-- work html5 >=ie10 -->
				<input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input name="userfile[]" multiple="multiple"  type="file">
			</div>
		</div>
		
		<div class="col-sm-12">
			<div class="form-group">
				<input type="submit" class="as21-submit btn btn-primary" data-form="as21-contact-form" value="Send">
			</div>
		</div>

	</form>



 <h3>Free get a quote</h3>


	<form id="as21-form-get-quote" method="post" action="">

		<div class="col-lg-12 col-md-4  col-sm-4">
			<div class="form-group">
				<input type="text" name="name" class="form-control" placeholder="Name">
			</div>
		</div>
		<div class="col-lg-12 col-md-4  col-sm-4">
			<div class="form-group">
				<input type="text" name="phone" class="form-control" placeholder="Phone">
			</div>
		</div>
		<div class="col-lg-12 col-md-4  col-sm-4">
			<div class="form-group">
				<input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="form-group">
				<textarea name="message" class="form-control" name="message" placeholder="Message"></textarea>
			</div>
		</div>
<!-- 
		<div class="col-sm-12">
			<div class="form-group">
				<input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input name="userfile" type="file">
			</div>
		</div>
	-->		
	<div class="col-sm-12">
		<div class="form-group">
			<input type="submit" class="as21-submit btn btn-primary" data-form="as21-form-get-quote" value="Send">
		</div>
	</div>

</form>


	<script type="text/javascript">

		$( document ).ready(function() {
			
			// var path_theme = 'http://web-dev-pro.ru/s/custom-form';
			$('.as21-submit').click(function(e){

				e.preventDefault();
				var el = $(this);
				var form = el.closest("form");
				var name_form = el.data('form');
				// var form_data = .serialize() + "&name_form="+name_form;
				var form_data = form.serialize();
				var data = form_data + "&form_name="+name_form+'&as21-ajax=1';

				console.log(el);
				console.log(form);
				console.log(form.html());
				console.log(form_data);
				console.log(name_form);
				console.log(data);
				// return false;

				$("p.field-error").remove();

				$.ajax({
					type: 'post',
					// url: path_theme+'/mail.php',
					// url: path_theme+'/phpmailer.php',
					url: 'index.php',
					data: data,
					success: function(data){
						console.log('run ajax');
						console.log(data);
						var data = JSON.parse(data);
						console.log(data);
						if(data.res == 'success') {
							// alert("Ваше сообщение успешно отправлено!");
							alert("Your message was successfully sent!");
						}

						if(data.errors){
							var show_errors_user = '';
							for (var key in data.errors) {

								show_errors_user += key+' '+data.errors[key]+' ';
								field_inpt = $("#"+name_form+" input[name="+key+"]");				
								field_inpt.parent().append('<p class="field-error">'+field_inpt.attr("placeholder")+' '+data.errors[key]+'<p>');

								field_ta = $("#"+name_form+" textarea[name="+key+"]");				
								field_ta.parent().append('<p class="field-error">'+field_ta.attr("placeholder")+' '+data.errors[key]+'<p>');
							}
						}
						console.log(show_errors_user);
						console.log(name_form);
						// console.log($("#"+name_form+" input[name=fname]").html());
						console.log($("#as21-contact-form input[name=fname]").html());
						console.log($("#as21-contact-form input[name='fname']").parent().html() );
						console.log($("#as21-contact-form input[name='fname']").attr("placeholder") );
					},
					error:function(){
						console.log("error");
					}
				});

			});

		});

	</script>
	
</body>
</html>