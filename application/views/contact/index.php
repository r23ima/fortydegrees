<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
            <div class="jumbotron">
            	<h1 class="text-center">Login</h1>
                <form id="myForm">
				  <div class="form-group">
				    <label for="exampleInputEmail1">Email address</label>
				    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
				   	<div class="invalid-feedback">Email is required.</div>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Password</label>
				    <input type="password" class="form-control" id="pass" name="password" placeholder="Password">
				    <div class="invalid-feedback">Password is required.</div>
				  </div>
				  	<div class="text-center">
					  <button type="button" class="btn btn-primary" id="btnProceed">Submit</button>
					  <button type="reset" class="btn btn-danger">Reset</button>
					  <hr>
					  Don't have an account? Sign up <a href="<?php echo base_url(); ?>contact/registration">here</a>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>

<script>
	$(function(){
		$('#btnProceed').click(function(){
			var url = '<?php echo base_url(); ?>contact/validateUser'
			var data = $('#myForm').serialize();

			var user = $('#myForm').find('input[name=email]').val();
			var pass = $('#myForm').find('textarea[name=password]').val();

			if(user=="" || pass==""){
				if(user==""){
					$('#myForm').find('input[name=name]').addClass('is-invalid')
				}
				if(pass==""){
					$('#myForm').find('input[name=password]').addClass('is-invalid')
				}
			}
			else{
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
							alert("Invalid Credentials");
					},
					error: function(){
					
					}
				});
			}
		});
	});
</script>