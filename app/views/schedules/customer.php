<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card card-body  mt-1">
			<?php flash('register_success'); ?>
                <h2  class="text-center">Schedule Customer</h2>
                <form  action="<?php echo URLROOT;?>/schedules/customer" method="post">
						<div class = "modal-body">
							<div class="row">
								<div class = "col-md-6">
									<div class = "form-group">
										Account Name
										<input type = "text" name = "accountname" id="accountname" placeholder="Account NAMES" value="<?php echo $data['accountname'];?>" class = "form-control <?php echo (!empty($data['accountname_err'])) ? 'is-invalid' : '' ; ?>"  required>
										<input type = "hidden" name = "pid" class = "pid" id="pid" >
										<span class="invalid-feedback"><?php echo $data['accountname_err']; ?></span>
									</div>
								</div>
							<div class="col-md-3">
								<div class="form-group">
									Account Number:
									<input type = "text" name = "accountnum" id="accountnum" placeholder="Account NUMBER" value="<?php echo $data['accountnum'];?>"  class = "form-control <?php echo (!empty($data['accountnum_err'])) ? 'is-invalid' : '' ; ?>" required>
									<span class="invalid-feedback"><?php echo $data['accountnum_err']; ?></span>
								</div>
							</div>
							<div class = "col-md-3">
								<div class = "form-group">
									Phone
									<input type = "number" name = "gsm" id="gsm" placeholder="GSM NUMBER" maxlength="11" value="<?php echo $data['gsm'];?>" class = "form-control <?php echo (!empty($data['gsm_err'])) ? 'is-invalid' : '' ; ?>"" required>
									<span class="invalid-feedback"><?php echo $data['gsm_err']; ?></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class = "form-group">
									Address
									<textarea type="text" name="address" id="address" placeholder="Address" class = "form-control <?php echo (!empty($data['address_err'])) ? 'is-invalid' : '' ; ?>" required><?php echo $data['address'];?> </textarea>
									<span class="invalid-feedback"><?php echo $data['address_err']; ?></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class = "form-group">
									closest Land Mark
									<textarea type="text" name="clm" id="clm" placeholder="closest Land Mark" class = "form-control <?php echo (!empty($data['clm_err'])) ? 'is-invalid' : '' ; ?>" required> <?php echo $data['clm'];?></textarea>
									<span class="invalid-feedback"><?php echo $data['clm_err']; ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class = "form-group">
									SURVEY STATUS
									<select type="text" name="surveystatus" id="survey" value="<?php echo $data['surveystatus'];?>" class = "form-control select2 <?php echo (!empty($data['survey_err'])) ? 'is-invalid' : '' ; ?>""  required>
										<option disabled selected>Survey Status</option>
										<option > conducted</option>
										<option > not conducted</option>
									</select>
									<span class="invalid-feedback"><?php echo $data['surveystatus_err']; ?></span>
								</div>
							</div>
                            <div class = "col-md-4">
								<div class = "form-group">
									CUSTOMER TYPE
									<select type="text" name="ctype" id="ctype" value="<?php echo $data['ctype'];?>" class = "form-control select2 <?php echo (!empty($data['ctype_err'])) ? 'is-invalid' : '' ; ?>"  required>
										<option disabled selected> SELECT TYPE</option>
										<option > PREPAID</option>
										<option > POST PAID</option>
									</select>
									<span class="invalid-feedback"><?php echo $data['ctype_err']; ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class = "form-group">
									STATE
									<select type="text" name="state" id = "state" value="<?php echo $data['state'];?>" placeholder="state" class = "form-control select2 <?php echo (!empty($data['state_err'])) ? 'is-invalid' : '' ; ?>"   required>
										<option disabled selected> Select State</option>
										<?php echo state(); ?>
									</select>
									<span class="invalid-feedback"><?php echo $data['state_err']; ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class = "form-group">

									REGION
									<select type="text" name="region" placeholder="region" id="tzone" value="<?php echo $data['region'];?>" class = "form-control select2 region <?php echo (!empty($data['region_err'])) ? 'is-invalid' : '' ; ?>"  required>
										<option disabled selected> Select State First</option>
										<p class = "region"></p>
									</select>
									<span class="invalid-feedback"><?php echo $data['region_err']; ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class = "form-group">
									33KV FEEDER
									<select type="text" name="kv33" id = "kv33" placeholder="Address" value="<?php echo $data['k33'];?>" class = "form-control select2 <?php echo (!empty($data['k33_err'])) ? 'is-invalid' : '' ; ?>"  required>
										<option disabled selected> Select Region first</option>

									</select>
									<span class="invalid-feedback"><?php echo $data['k33_err']; ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class = "form-group">
									11KV FEEDER
									<select type="text" name="feeder" placeholder="Feeder" id="feeder" value="<?php echo $data['feeder'];?>" class = "form-control select2 <?php echo (!empty($data['feeder_err'])) ? 'is-invalid' : '' ; ?>"  required>
										<option disabled selected> Select 33KV First</option>
										<!-- <p class = "feeder"></p> -->
									</select>
									<span class="invalid-feedback"><?php echo $data['feeder_err']; ?></span>
								</div>
							</div>

							<div class="col-md-3">
								<div class = "form-group">
									DT	NAME
									<input type = "text" name = "dtname" id="dtname" placeholder="DT NAME" value="<?php echo $data['dtname'];?>" class = "form-control <?php echo (!empty($data['dtname_err'])) ? 'is-invalid' : '' ; ?>"  required>
									<span class="invalid-feedback"><?php echo $data['dtname_err']; ?></span>
								</div>
							</div>

							<div class="col-md-3">
								<div class = "form-group">
									DT
									<input type = "number" name = "dtcode" id="dtcode" placeholder="DT CODE" value="<?php echo $data['dtcode'];?>" class = "form-control <?php echo (!empty($data['dtcode_err'])) ? 'is-invalid' : '' ; ?>"  required>
									<span class="invalid-feedback"><?php echo $data['dtcode_err']; ?></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class = "form-group">
									UPRISER
									<input type = "number" name = "upriser" id="upriser" placeholder="UPRISER NUMBER" value="<?php echo $data['upriser'];?>" class = "form-control <?php echo (!empty($data['upriser_err'])) ? 'is-invalid' : '' ; ?>" required>
									<span class="invalid-feedback"><?php echo $data['upriser_err']; ?></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class = "form-group">
									POLE NUMBER
									<input type = "number" name = "pole" id="pole" placeholder="POLE NUMBER" value="<?php echo $data['pole'];?>" class = "form-control <?php echo (!empty($data['pole_err'])) ? 'is-invalid' : '' ; ?>" required>
                                    <span class="invalid-feedback"><?php echo $data['pole_err']; ?></span>
                                </div>
							</div>

							<div class = "col-md-3">
								<div class = "form-group">
									METER TYPE
									<select type="text" name="metertype" id="meterType" placeholder="Address" class = "form-control <?php echo (!empty($data['metertype_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['metertype'];?>" required>
										<option disabled selected> SELECT TYPE</option>
										<option > Single Phase</option>
										<option > Three Phase</option>
									</select>
									<span class="invalid-feedback"><?php echo $data['metertype_err']; ?></span>
								</div>
							</div>
							<div class ="col-md-3">
								<div class = "form-group">
									DATE
									<input type ="date" name = "date" id="date" class = "form-control <?php echo (!empty($data['date_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['date'];?>" required>
									<span class="invalid-feedback"><?php echo $data['date_err']; ?></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class = "form-group">
									Company:
                                    <select type="text" id="company"name="company" placeholder="Address" class = "form-control select2 <?php echo (!empty($data['company_err'])) ? 'is-invalid' : '' ; ?>"  value="<?php echo $data['company'];?>"  required>
										<option disabled selected> Select</option>
										<?php echo company(); ?>
									</select>
									<span class="invalid-feedback"><?php echo $data['company_err']; ?></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class = "form-group">
									ASIGN:
                                    <select type="text" name="asignedto" id="asignedto" placeholder="Address" class = "form-control select2 <?php echo (!empty($data['asignedto_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['asignedto'];?>" >
										<option disabled selected> Select Company First</option>

									</select>
									<span class="invalid-feedback"><?php echo $data['asignedto_err']; ?></span>
								</div>
							</div>
						</div>
					</div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-success btn-block">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

    </script>
<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script>
$(document).ready(function(){
	$('#state').change(function(){
		var id =$(this).val();
		$.ajax({
			url:"<?=URLROOT ?>/helpers/dropdown.php",
			type:'POST',
			dataType:'JSON',
			data:{fetchRegion:true,id:id},
			success:function(data){
				$('.region').html(data.region);
			}
		})
	});
	$('#tzone').change(function(){
		var id =$(this).val();
		$.ajax({
			url:"<?=URLROOT ?>/helpers/dropdown.php",
			type:'POST',
			dataType:'JSON',
			data:{fetchFeederT:true,id:id},
			success:function(data){
				$('#kv33').html(data.feederT);
			}
		})
	});
	$('#kv33').change(function(){
		var id =$(this).val();
		$.ajax({
			url:"<?=URLROOT ?>/helpers/dropdown.php",
			type:'POST',
			dataType:'JSON',
			data:{fetchFeederE:true,id:id},
			success:function(data){
				$('#feeder').html(data.feeder);
			}
		})
	});
	$('#company').change(function(){
		var id =$(this).val();
		$.ajax({
			url:"<?=URLROOT ?>/helpers/dropdown.php",
			type:'POST',
			dataType:'JSON',
			data:{fetchInstaller:true,id:id},
			success:function(data){
				$('#asignedto').html(data.installer);
				console.log(data.installer);
			}
		})
	});
	$('#batchUploadForm').on('submit', function(e){
		// e.preventDefualt();

		// $.ajax({
		// 	url:"<?=URLROOT ?>/spreadsheet/readFile",
		// 	method:"POST",
		// 	data:new FromData(this),
		// 	contentType:false,
		// 	cache:false,
		// 	processData:false,
		// 	beforeSend:function(){
		// 		$('#uploadBatch').attr('disabled', 'disabled');
		// 		$('#uploadBatch').val('Processing');
		// 	},
		// 	success:function(data){
		// 		alert(data);
		// 		$('#uploadBatch')[0].reset();
		// 		$('#uploadBatch').attr('disabled', false);
		// 		$('#uploadBatch').val('UPLOAD');
		// 	}
		// });
	});
});
</script>
