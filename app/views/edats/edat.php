<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body  mt-3">
          <h5 class="text-center">SCHEDULE EDAT</h5>
		        <?php flash('register_success'); ?>
        <form method = "post" action="<?php echo URLROOT;?>/edats/edat" id="edatForm">
			<div class = "row">
			<div class="col-md-12">
				<div class = "form-group">
					<!-- DATE OF INSTALLATION -->
					<input type ="date" name = "date" class = "form-control form-control-sm <?php echo (!empty($data['date_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['date'];?>"  >
					<span class="invalid-feedback"><?php echo $data['date_err']; ?></span>
				</div>
			</div>
			<div class="col-md-12">
				<div class = "form-group">
					<!-- EDAT NUMBER -->
					<input type = "text" name="edatnum" class = "form-control form-control-sm <?php echo (!empty($data['edatnum_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['edatnum'];?>"  placeholder= "edat number" maxlength="10" >
					<span class="invalid-feedback"><?php echo $data['edatnum_err']; ?></span>
				</div>
			</div>
			<div class="col-md-12">
				<div class = "form-group">
					<!-- RF CHANNEL -->
					<input type = "number" name="rf" class = "form-control form-control-sm <?php echo (!empty($data['rf_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['rf'];?>" placeholder= "chanel number" >
					<span class="invalid-feedback"><?php echo $data['rf_err']; ?></span>
				</div>
			</div>

			<div class="col-md-12">
				<div class = "form-group">
					<!-- EDAT STATUS -->
					<select type="text" name="edatstatus" id="edatS" placeholder="Address" class="form-control form-control-sm <?php echo (!empty($data['edatstatus_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['edatstatus'];?>" >
						<option disabled selected> SELECT STATUS</option>
						<option <?php if($data['edatstatus']=='NOT INSTALL'){echo 'selected';} ?> >NOT INSTALL</option>
						<option <?php if($data['edatstatus']=='INSTALLED'){echo 'selected';} ?> >INSTALLED</option>
					</select>
					<span class="invalid-feedback"><?php echo $data['edatstatus_err']; ?></span>
				</div>
			</div>
			<div class="col-md-12">
				<div class = "form-group">
				<!-- POLE: -->
					<input type="text" name="pole" class = "form-control form-control-sm <?php echo (!empty($data['pole_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['pole'];?>" placeholder="POLE NUMBER" >
					<span class="invalid-feedback"><?php echo $data['pole_err']; ?></span>
				</div>
			</div>
			<div class="col-md-12">
				<div class = "form-group">
					<input type="text" name="address" class = "form-control form-control-sm <?php echo (!empty($data['address_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['address'];?>" placeholder="address" >
					<span class="invalid-feedback"><?php echo $data['address_err']; ?></span>
				</div>
			</div>
			<div class="col-md-12">
				<div class = "form-group">
				<!-- PROJECT: -->
				<select type="text" id="project" name="state" placeholder="project" class = "form-control form-control-sm select2 <?php echo (!empty($data['state_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['state'];?>" >
					<option disabled selected> Select state</option>
					<?php echo state(); ?>
				</select>
					<span class="invalid-feedback"><?php echo $data['state_err']; ?></span>
				</div>
			</div>
			<div class="col-md-12">
				<div class = "form-group">
				<!-- PROJECT: -->
				<select type="text"  name="dtname"  class = "form-control form-control-sm select2 <?php echo (!empty($data['dtname_err'])) ? 'is-invalid' : '' ; ?>" >
					<option disabled selected> Select DT</option>
					<?php echo dtNames($data['dtname']); ?>
				</select>
					<span class="invalid-feedback"><?php echo $data['dtname_err']; ?></span>
				</div>
			</div>
			<div class="col-md-6">
				<div class = "form-group">
					Company:
					<select type="text" id="cmp" name="company" class = "form-control form-control-sm select2 <?php echo (!empty($data['company_err'])) ? 'is-invalid' : '' ; ?>" >
						<option disabled selected> Select</option>
						<?php echo company(); ?>
					</select>
					<span class="invalid-feedback"><?php echo $data['company_err']; ?></span>
				</div>
            </div>
            <div class="col-md-6">
			<div class = "form-group">
				ASIGN:
				<select type="text" name="asignedto" id="asignedto" placeholder="Address" class = "form-control form-control-sm select2 <?php echo (!empty($data['asignedto_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['asignedto'];?>" >
					<option disabled selected> Select Company First</option>

				</select>
				<span class="invalid-feedback"><?php echo $data['asignedto_err']; ?></span>
			</div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="submit" value="Submit" class="btn btn-success btn-block">
                </div>
            </div>
      </div>
		</form>
      </div>
    </div>
 </div>

<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
	$(document).ready(function(){
		$('#cmp').change(function(){
  		var id =$(this).val();
      alert(id)
  		$.ajax({
  			url:"<?php echo URLROOT ?>/helpers/dropdown.php",
  			type:'POST',
  			dataType:'JSON',
  			data:{fetchInstaller:true,id:id},
  			success:function(data){
  				$('#asignedto').html(data.installer);
  			}
  		})
  	});
  });
</script>
