<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card card-body  mt-3">
          <?php if(isset($data['custId'])): ?>
            <h5 class="text-center">Install Meter</h5>
            <?php flash('register_success'); ?>
        <form method = "post" enctype ="multipart/form-data" action="<?php echo URLROOT;?>/schedules/meter">
    			<div class = "row">
    			<div class="col-md-4">
    				<div class = "form-group">
    					DATE OF INSTALLATION
    					<input type ="date" name = "doi" class = "form-control form-control-sm <?php echo(!empty($data['doi_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['doi']?>"  placeholder= "" >
              <span class="invalid-feedback"><?php echo $data['doi_err']; ?></span>
    					<input type ="hidden" name = "custid" class = "form-control" value="<?php echo $data['custId']; ?>">
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
    					EDAT NUMBER
    					<input type = "text" name="edatNum" class = "form-control  form-control-sm <?php echo(!empty($data['edat_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['edatNum']?>" placeholder= "edat number" maxlength="10" >
              <span class="invalid-feedback"><?php echo $data['edat_err']; ?></span>
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
    				<input type="file" name="meterfoto" placeholder="Choose file..." class="form-control form-control-sm  <?php echo(!empty($data['meterfoto_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['meterfoto']?>" id="validatedCustomFile">
    			   <span class="invalid-feedback"><?php echo $data['img_err']; ?></span>
      			</div>
    			</div>

    			<div class="col-md-12">
    				<div class = "form-group">
    					REMARKS:
    					<textarea type="text" name="remark" class = "form-control  form-control-sm  <?php echo(!empty($data['remark_err'])) ? 'is-invalid' : ''; ?>" placeholder="remark "  ><?php echo  $data['remark']?></textarea>
              <span class="invalid-feedback"><?php echo $data['remark_err']; ?></span>
    				</div>
    			</div>

    			<div class = "col-md-6">
    				<div class = "form-group">
    					X:
    					<input type="text" name="latitude" class = "form-control  form-control-sm  <?php echo(!empty($data['lotitude_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo  $data['latitude']?>""  placeholder="LATITUDE">
              <span class="invalid-feedback"><?php echo $data['latitude_err']; ?></span>
    				</div>
    			</div>
    			<div class = "col-md-6">
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
          <?php redirect('views/paidcustomer') ?>
        <?php endif; ?>
    </div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
