<nav class="navbar navbar-light bg-dark">
	<h2 class="text-white">Skillstest</h2>
 	<button type="button" class="btn text-right"><a href="<?php echo base_url(); ?>contact/logout">Logout</a></button>
</nav>
<br/>
<button class="btn btn-primary btn-lg" id="btnAdd">Add Contact</button>
<br/><br/>
<div class="alert d-none">
	
</div>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Company</th>
			<th>Mobile No.</th>
			<th>Email</th>
			<th>ACTION</th>
		</tr>
	</thead>
	<tbody id="showdata">
		
	</tbody>
</table>

<div id="myModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       	<form method="POST" id="myForm">
       		<div class="form-group">
			    <label>Name<b class="text-danger">*</b></label>
			    <input type="text" name="con_name" class="form-control" placeholder="ex. John Doe">
			    <div class="invalid-feedback">Name is required.</div>
			</div>
			<div class="form-group">
			    <label>Company<b class="text-danger">*</b></label>
			   	<textarea class="form-control" name="con_comp"></textarea>
			   	<div class="invalid-feedback">Company is required.</div>
			</div>
			<div class="form-group">
			    <label>Mobile No.<b class="text-danger">*</b></label>
			    <input type="text" name="con_mobile" class="form-control" placeholder="ex. 09xxx">
			    <div class="invalid-feedback">Mobile Number is required.</div>
			</div>
       		<div class="form-group">
			    <label>Email address<b class="text-danger">*</b></label>
			    <input type="email" name="con_email" class="form-control" placeholder="ex. jonhdoe@gmail.com">
			    <div class="invalid-feedback">Email is required.</div>
			</div>
       	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnProceed">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
	$(function(){
		showAllContact();

		$('#btnAdd').click(function(){
			$('#myModal').modal('show');
			$('#myModal').find('.modal-header').text("Add Contact");
			$('#myForm').attr('action', '<?php echo base_url(); ?>contact/add');
		});

		//add contact
		$('#btnProceed').click(function(){
			var url = $('#myForm').attr('action');
			var data = $('#myForm').serialize();

			//validation
			var con_name = $('#myForm').find('input[name=con_name]').val();
			var con_comp = $('#myForm').find('textarea[name=con_comp]').val();
			var con_mobile = $('#myForm').find('input[name=con_mobile]').val();
			var con_email = $('#myForm').find('input[name=con_email]').val();
		
			if(con_name=='' || con_comp=='' || con_mobile=='' || con_email==''){
				if(con_name==''){
					$('#myForm').find('input[name=con_name]').addClass('is-invalid');
				}
				if(con_comp==''){
					$('#myForm').find('textarea[name=con_addr]').addClass('is-invalid');
				}
				if(con_mobile==''){
					$('#myForm').find('input[name=con_mobile]').addClass('is-invalid');
				}
				if(con_email==''){
					$('#myForm').find('input[name=con_email]').addClass('is-invalid');
				}
			}
			else{
				$('#myForm').find('input[name=con_name]').removeClass('is-invalid');
				$('#myForm').find('textarea[name=con_comp]').removeClass('is-invalid');
				$('#myForm').find('input[name=con_mobile]').removeClass('is-invalid');
				$('#myForm').find('input[name=con_email]').removeClass('is-invalid');

				$.ajax({
					type: 'ajax',
					url: url,
					async: false,
					data: data,
					type:'POST',
					dataType:'json',
					success: function(response){
						$('#myModal').modal('hide');
						$('#myForm')[0].reset();
						showAllContact();
						if(response.type=='200'){
							$('.alert').html(response.msg).addClass('alert-success').removeClass('d-none').fadeIn().delay(4000).fadeOut('slow');
						}
						else if(response.type=='500'){
							$('.alert').html(response.msg).addClass('alert-danger').removeClass('d-none').fadeIn().delay(4000).fadeOut('slow');
						}
					},
					error: function(){
					
					}
				});
			}
		});

		//edit contact
		$('#showdata').on('click', '.item-edit', function(){
			var id = $(this).attr('data');
			$('#myModal').modal('show');
			$('#myModal').find('.modal-header').text("Edit Contact");
			$('#myForm').attr('action', '<?php echo base_url(); ?>contact/edit');
			
			$.ajax({
				type: 'ajax',
				method: 'GET',
				url: '<?php echo base_url(); ?>contact/viewcontact',
				async: false,
				dataType: 'json',
				data: {id: id},
				success: function(data){
					$('#myForm').find('input[name=con_name]').val(data.contact_name);
					$('#myForm').find('textarea[name=con_comp]').val(data.contact_company);
					$('#myForm').find('input[name=con_mobile]').val(data.contact_number);
					$('#myForm').find('input[name=con_email]').val(data.contact_email);

					$('<input>').attr({
					    type: 'hidden',
					    value: id,
					    name: 'con_id'
					}).appendTo('#myForm');
				},
				error: function(){

				}
			});
		});

		//delete contact
		$('#showdata').on('click', '.item-delete', function(){
			var id = $(this).attr('data');
			if (confirm('Are you sure you want to delete this contact?')) {
				  $.ajax({
					type: 'ajax',
					async: false,
					method: 'GET',
					dataType: 'json',
					data: {id: id},
					url: '<?php echo base_url(); ?>contact/delete',
					success: function(response){
						if(response.type=='200'){
							$('.alert').html(response.msg).addClass('alert-success').removeClass('d-none').fadeIn().delay(4000).fadeOut('slow');
						}
						else if(response.type=='500'){
							$('.alert').html(response.msg).addClass('alert-danger').removeClass('d-none').fadeIn().delay(4000).fadeOut('slow');
						}
						$('.alert').html(response.msg).fadeIn().delay(4000).fadeOut('slow');
						showAllContact();
					},
					error: function(){

					}
				}); 
			} 

				
		});

		function showAllContact(limit){
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url('contact/showAllContact'); ?>',
				async: false,
				method: 'GET',
				dataType:'json',
				success: function(data){
					var html = '';	
					if(data.length==0 || data==false){
						html += "<tr><td colspan='5' class='text-center'>No record/s found.</td></tr>";
					}
					else{
						data.forEach(function(d){
							html += 
								"<tr>"+
									"<td>"+d.contact_name+"</td>"+
									"<td>"+d.contact_company+"</td>"+
									"<td>"+d.contact_number+"</td>"+
									"<td>"+d.contact_email+"</td>"+
									"<td class='text-center'>"+
										"<button class='mr-2 btn btn-lg btn-success item-edit' data='"+d.contact_id+"'>EDIT</button>"+
										"<button class='mr-2 btn btn-lg btn-danger item-delete' data='"+d.contact_id+"'>DELETE</button>"+
									"</td>"+
								"<tr>";
						});
					}

					$('#showdata').html(html);
		
				},
				error: function(){
					alert("Could not get data from database");
				}
			});
		}

	
	});
</script>