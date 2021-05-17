<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

 <style>
   .table{
     font-size:10px;
     font-family: 'Open Sans', sans-serif;
   }
   .btn-group{
     /* background-color:#000 !important; */
     padding: 0 !important;
     margin: 0px !important;
   }
   .btn-group >.navbar{
     margin: 1px !important;
     padding: 1px !important;
   }
   .btn-group >.navbar >.btn{
     background-color:#fff !important;
     color: #19c5f1 !important;
     padding: 2px !important;
     border: solid #19c5f1 3px;
     border-radius: 5px;
   }
   #result{
    width:93% !important;
   	position:absolute;
   	z-index:999 !important;
    float: left !important;
   }
   #result li{
     background:#333333 !important;
   	color:#fff !important;
   	height:30px;
     padding: 3px !important;
      list-style: none;
   }
   #result li a{
      list-style: none;
   }
   #result li a:hover{
     text-decoration:none !important;
     list-style: none;
   }
   form{
     margin-top:0px !important;
   }
 </style>
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card card-body  mt-3">
          <?php if(isset($data['custId'])): ?>
            <h5 class="text-center">Install Meter</h5>
            <?php flash('register_success'); ?>
        <form method = "post" enctype ="multipart/form-data" action="<?php echo URLROOT;?>/meters/install">
    			<div class = "row">
    			<div class="col-md-2">
    				<div class = "form-group">
    					INSTALLATION DATE
    					<input type ="date" name = "doi" class = "form-control form-control-sm <?php echo(!empty($data['doi_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['doi']?>"  placeholder= "" >
              <span class="invalid-feedback"><?php echo $data['doi_err']; ?></span>
    					<input type ="hidden" name = "custid" class = "form-control" value="<?php echo $data['custId']; ?>">
    				</div>
    			</div>
    			<div class="col-md-2">
    				<div class = "form-group">
    					Type
              <select type="text" name ="type" id="type" class="form-control select2  form-control-sm <?php echo(!empty($data['type_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['tariff']?>">
    						<option disabled selected>SELECT TYPE</option>
    						<option <?php if($data['type']=='PLC') {echo 'selected';} ?>>PLC</option>
    						<option <?php if($data['type']=='RF'){echo 'selected';} ?>>RF</option>
    					</select>
              <span class="invalid-feedback"><?php echo $data['type_err']; ?></span>
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class = "form-group">
    					PRELODE CREDIT
    					<input type="text" name="preload" class = "form-control form-control-sm <?php echo(!empty($data['preload_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['preload']?>"  placeholder="50.6" >
              <span class="invalid-feedback"><?php echo $data['preload_err']; ?></span>
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class = "form-group">
    					SEAL NUMBER
    					<input type = "number" name="seal" class = "form-control form-control-sm <?php echo(!empty($data['seal_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['seal']?>" placeholder= "seal number" maxlength="6" >
              <span class="invalid-feedback"><?php echo $data['seal_err']; ?></span>
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class = "form-group">
    					METER NO.
    					<input type = "text" name="meterNumber" class = "form-control  form-control-sm <?php echo(!empty($data['mt_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['meterNumber']?>" placeholder= "meter number" maxlength="12" >
              <span class="invalid-feedback"><?php echo $data['mt_err']; ?></span>
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class = "form-group">
    					BOX NUMBER
    					<input type = "text" name="box" class = "form-control  form-control-sm <?php echo(!empty($data['box_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['box']?>" placeholder= "Box number" maxlength="10" >
              <span class="invalid-feedback"><?php echo $data['box_err']; ?></span>
    				</div>
    			</div>
    			<div class="col-md-4">
    				<div class = "form-group">
    					TARRIF
    					<select type="text" name ="tariff" id="tariff" class="form-control select2  form-control-sm <?php echo(!empty($data['tariff_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['tariff']?>">
    						<option disabled selected>SELECT TARIF</option>
    						<option <?php if($data['tariff']=='R1') {echo 'selected';} ?>>R1</option>
    						<option <?php if($data['tariff']=='R2'){echo 'selected';} ?>>R2</option>
    						<option <?php if($data['tariff']=='R3'){echo 'selected';} ?>>R3</option>
    						<option <?php if($data['tariff']=='C1'){echo 'selected';} ?>>C1</option>
    						<option <?php if($data['tariff']=='C2'){echo 'selected';} ?>>C2</option>
    						<option <?php if($data['tariff']=='D1'){echo 'selected';} ?>>D1</option>
    						<option <?php if($data['tariff']=='D2'){echo 'selected';} ?>>D2</option>
    					</select>
              <span class="invalid-feedback"><?php echo $data['tariff_err']; ?></span>
    				</div>
    			</div>
    			<div class="col-md-4" >
    				<div class = "form-group">
    					ADVISED TARIF
    					<select type="text" name ="advtariff" id="advtariff" class="form-control select2  form-control-sm <?php echo(!empty($data['advtariff_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['advtariff']?>">
    						<option disabled selected>SELECT ADVISED TARIF</option>
    						<option <?php if($data['advtariff']=='R1'){echo 'selected';} ?>>R1</option>
    						<option <?php if($data['advtariff']=='R2'){echo 'selected';} ?>>R2</option>
    						<option <?php if($data['advtariff']=='R3'){echo 'selected';} ?>>R3</option>
    						<option <?php if($data['advtariff']=='C1'){echo 'selected';} ?>>C1</option>
    						<option <?php if($data['advtariff']=='C2'){echo 'selected';} ?>>C2</option>
    						<option <?php if($data['advtariff']=='D1'){echo 'selected';} ?>>D1</option>
    						<option <?php if($data['advtariff']=='D2'){echo 'selected';} ?>>D2</option>
    					</select>
              <span class="invalid-feedback"><?php echo $data['advtariff_err']; ?></span>
    				</div>
    			</div>
    			<div class = "col-md-4">
    				<div class = "form-group">
    					METER STATUS
    					<select type="text" name="status" id="status" class = "form-control select2 form-control-sm <?php echo(!empty($data['status_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['status']?>">
    						<option disabled selected> METER STATUS</option>
    						<option <?php if($data['status']=='NOT INSTALL'){echo 'selected';} ?>>NOT INSTALL</option>
    						<option <?php if($data['status']=='INSTALLED'){echo 'selected';} ?>> INSTALLED</option>
    					</select>
              <span class="invalid-feedback"><?php echo $data['status_err']; ?></span>
    				</div>
    			</div>
    			<div class = "col-md-4">METER PHOTO:
    			<div class="custom-file">
    				<input type="file" name="meterfoto" placeholder="Choose file..." class="form-control form-control-sm " value="<?php echo  $data['meterfoto']?>" id="validatedCustomFile">
      			</div>
    			</div>

    			<div class="col-md-12">
    				<div class = "form-group">
    					REMARKS:
    					<textarea type="text" name="remark" class = "form-control  form-control-sm  <?php echo(!empty($data['remark_err'])) ? 'is-invalid' : ''; ?>" placeholder="remark "  ><?php echo  $data['remark']?></textarea>
              <span class="invalid-feedback"><?php echo $data['remark_err']; ?></span>
    				</div>
    			</div>
          <div class = "col-md-4" id="rfchannel" style="display:none;">
    				<div class = "form-group">
    					RF channel
    					<input type="text" name="rf" class = "form-control  form-control-sm  <?php echo(!empty($data['rf_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['rf']?>" placeholder="rf channel">
              <span class="invalid-feedback"><?php echo $data['rf_err']; ?></span>
    				</div>
    			</div>
    			<div class = "col-md-4">
    				<div class = "form-group">
    					X:
    					<input type="text" name="latitude" class = "form-control  form-control-sm  <?php echo(!empty($data['latitude_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['latitude']?>"  placeholder="LATITUDE">
              <span class="invalid-feedback"><?php echo $data['latitude_err']; ?></span>
    				</div>
    			</div>
    			<div class = "col-md-4">
    				<div class = "form-group">
    					Y:
    					<input type="text" name="longitude" class = "form-control  form-control-sm  <?php echo(!empty($data['longitude_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['longitude']?>" placeholder="LONGITUDE">
              <span class="invalid-feedback"><?php echo $data['longitude_err']; ?></span>
    				</div>
    			</div>

          </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" class="btn btn-success" name="jobcompletion" value ="SUBMIT" id = "meterFormBtn"/>
                    </div>
                </div>
          </div>
          </div>
    		</form>
        <?php else: ?>
          <?php redirect('meters/index') ?>
        <?php endif; ?>
    </div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){
    $('#type').change(function(){
      if($(this).val()=='RF'){
        $('#rfchannel').show(500);
      }else{
        $('#rfchannel').hide(500);
      }
    });
    if($('#type').val()=='RF'){
        $('#rfchannel').show(500);
    }else{$('#rfchannel').hide(500);}
  });
</script>
