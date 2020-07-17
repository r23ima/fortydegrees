<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
        	<div class="jumbotron">
	        	<h1 class="text-center">Registration</h1>
				<form id="myForm">
					<div class="form-group">
					    <label for="name">Name<b class="text-danger">*</b></label>
					    <input type="text" class="form-control" placeholder="Name" name="name">
					    <div class="invalid-feedback">Name is required</div>
					</div>

					<div class="form-group">
					    <label for="exampleInputEmail1">Email address<b class="text-danger">*</b></label>
					    <input type="email" class="form-control" placeholder="Enter email" name="email">
					     <div class="invalid-feedback">Email is required</div>
					</div>
					<div class="form-group">
					    <label for="exampleInputPassword1">Password<b class="text-danger">*</b></label>
					    <input type="password" class="form-control" placeholder="Password" name="password" >
					     <div class="invalid-feedback">Password is required</div>
					</div>
					<div class="form-group">
					    <label for="exampleInputPassword">Confirm Password<b class="text-danger">*</b></label>
					    <input type="password" class="form-control" placeholder="Confirm Password" name="confirmpass">
					     <div class="invalid-feedback">Confirm password is required</div>
					</div>
					<div class="form-row">
						<div class="col text-right">
							<button class="btn btn-lg btn-success" type="button" id="btnProceed">Submit</button>
						</div>
						<div class="col text-left">
							<button class="btn btn-lg btn-danger" type="reset">Cancel</button>
						</div>
					</div>
					<hr>
						<div class="text-center"> Already have an account? Login <a href="<?php echo base_url(); ?>contact/index">here</a></div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$(function(){
		$('#btnProceed').click(function(){
			var url = '<?php echo base_url(); ?>contact/registerUser'
			var data = $('#myForm').serialize();

			var name = $('#myForm').find('input[name=name]').val();
			var email = $('#myForm').find('input[name=email]').val();
			var pass = $('#myForm').find('input[name=password]').val();
			var cpass = $('#myForm').find('input[name=confirmpass]').val();

			if(name=="" || email=="" || pass=="" || cpass==""){
				if(name==""){
					$('#myForm').find('input[name=name]').addClass('is-invalid')
				}
				if(email==""){
					$('#myForm').find('input[name=email]').addClass('is-invalid')
				}
				if(pass==""){
					$('#myForm').find('input[name=password]').addClass('is-invalid')
				}
				if(cpass==""){
					$('#myForm').find('input[name=confirmpass]').addClass('is-invalid')
				}
			}
			else{
				if(pass==cpass){
					$.ajax({
						type: 'ajax',
						url: url,
						async: false,
						data: data,
						type:'POST',
						dataType:'json',
						success: function(response){
							if(response['type']=='200')
								window.location.href="<?php echo base_url(); ?>contact/dashboard";
							else 
								alert(response['msg']);
							
						},
						error: function(){
						
						}
					});
				}
				else{
					alert("Password and confirm password did not matched.");
				}
			}
		});
	});
</script>