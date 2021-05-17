<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
 <style>
   form{
     margin-top:0px !important;
   }
   #first{
     left: 0;
     right: 0;
     bottom: 0;
   }
   #second{
     display: none;
     transition: 4s ease;
     top:0;
     left: 0;
     right: 0;
   }
   #listTable{
     /* width:93% !important; */
   	 position: absolute;
   	 z-index:99 !important;
     background: #fff;
     color: #333 !important;
     margin-top: 35px;
   }
   small{
       text-transform:uppercase;
   }
   select{
       text-transform:uppercase;
   }
   /* #listTable>table{
     color: #ffffff !important;
   }
   #listTable > table:hover{
     color: #fff !important;
   } */
 </style>
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card card-body  mt-1">
          <div class="row mb-1">
            <div class="col-md-9">
              <div class="input-group">
                <a href="<?php echo URLROOT ?>/meters/schedule" data-toggle="tooltip" data-placement="top" title="Refresh" class="mr-1"> <button type="button" class="btn btn-danger btn-sm"> <i class="fa fa-spinner fa-spin"></i> </button> </a>
                <input type="text" class="form-control form-control-sm" placeholder="Enter Account Number" id="searchByNumber">
                <div id="listTable"></div>
              </div>
            </div>
            <div class="col-md-3">
                <?php flash('register_success'); ?>
            </div>
          </div>
        <form method = "post" enctype ="multipart/form-data" action="<?php echo URLROOT;?>/meters/schedule" id="scheduleForm">
          <fieldset id="first" >
            <!-- <h5 class="text-center">CUSTOMER INFORMATION</h5> -->
            <div class="row">
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>METER NUMBER</small>
                  <div class="input-group">
                    <input type = "text" name = "meter_num" maxlength="11" autofocus autocomplete="off" id="meter_num" placeholder="Enter Meter Number" class = "form-control form-control-sm <?php echo(!empty($data['meter_num_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['meter_num']); ?>" >
                    <span class="invalid-feedback "><?php echo $data['meter_num_err']; ?></span>
                    <?php if(@$role['dup_entry']==1): ?>
                        <input type="checkbox" name="dup" class="ml-1" >
                    <?php endif;?>
                  </div>
                </div>
              </div>
              <div class = "col-md-2">
                <div class = "form-group">
                  <small>PRELODE UNIT</small>
                  <input type = "number" name = "preload" autocomplete="off" id="preload" maxlength="2" placeholder="Enter preload Unit" class = "form-control form-control-sm <?php echo(!empty($data['preload_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo empty($data['preload']) ? '25' : $data['preload']; ?>" >
                  <span class="invalid-feedback"><?php echo $data['preload_err']; ?></span>
                </div>
              </div>
              <div class="col-md-2">
                <div class = "form-group">
                  <small>STATE</small>
                  <input type="text" name="state" id = "formState" readonly class = "form-control form-control-sm <?php echo(!empty($data['state_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo loadStateRegion()->state ?>">
                  <span class="invalid-feedback"><?php echo $data['state_err']; ?></span>
                </div>
              </div>
              <div class="col-md-2">
                <div class = "form-group">
                  <small>TRADING ZONE</small>
                  <input type="text" name="zone" id = "zone" readonly class = "form-control form-control-sm <?php echo(!empty($data['zone_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo loadStateRegion()->region ?>">
                  <span class="invalid-feedback"><?php echo $data['zone_err']; ?></span>
                </div>
              </div>
              <div class="col-md-3">
                <div class = "form-group">
                  <small>INSTALLATION DATE</small>
                  <input type ="date" name = "doi" autocomplete="off" id="date" class = "form-control form-control-sm <?php echo(!empty($data['doi_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo @$_SESSION['doi']; ?>" >
                  <span class="invalid-feedback"><?php echo $data['doi_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-4">
                <div class = "form-group">
                  <small>DT NAME</small>
                  <input type = "text" name = "dt_name" autocomplete="off" id="dt_name" placeholder="Dt Name" class = "form-control form-control-sm <?php echo(!empty($data['dt_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['dt_name']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['dt_name_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-2">
                <div class = "form-group">
                  <small>DT NUMBER</small>
                  <input type = "text" name = "dt_code" autocomplete="off" id="dt_code" placeholder="Dt Number" class = "form-control form-control-sm <?php echo(!empty($data['dt_code_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['dt_code']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['dt_code_err']; ?></span>
                </div>
              </div>
              <div class="col-md-2">
                <div class = "form-group">
                  <small>DT TYPE</small>
                  <select type="text" name="dt_type" id = "dt_type" class = "form-control form-control-sm <?php echo(!empty($data['dt_type_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected> SELECT TYPE</option>
                    <option <?php if(strtolower($data['dt_type'])=='public'){echo 'selected';} ?> >public</option>
                    <option <?php if(strtolower($data['dt_type'])=='private'){echo 'selected';} ?> >private</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $data['dt_type_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-2">
                <div class = "form-group">
                  <small>UPRISER NUMBER</small>
                  <input type = "text" name = "upriser" autocomplete="off" id="upriser"  maxlength="1" placeholder="Upriser Number" class = "form-control form-control-sm <?php echo(!empty($data['upriser_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['upriser']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['upriser_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-2">
                <div class = "form-group">
                  <small>POLE NUMBER</small>
                  <input type = "text" name = "pole" autocomplete="off" id="pole" placeholder="Pole Number" maxlength="3"  class = "form-control form-control-sm <?php echo(!empty($data['pole_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['pole']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['pole_err']; ?></span>
                </div>
              </div>
              <div class="col-md-2">
        				<div class = "form-group">
        				<small>PRESENT TARIFF</small>
        					<select type="text" name ="tariff" id="tariff" class="form-control  form-control-sm <?php echo(!empty($data['tariff_err'])) ? 'is-invalid' : ''; ?>" >
        						<option disabled selected>SELECT TARIF</option>
        						<option <?php if($data['tariff']=='R1') {echo 'selected';} ?>>R1</option>
        						<option <?php if($data['tariff']=='R2'){echo 'selected';} ?>>R2</option>
        						<option <?php if($data['tariff']=='R3'){echo 'selected';} ?>>R3</option>
        						<option <?php if($data['tariff']=='C1'){echo 'selected';} ?>>C1</option>
        						<option <?php if($data['tariff']=='C2'){echo 'selected';} ?>>C2</option>
        						<option <?php if($data['tariff']=='D1'){echo 'selected';} ?>>D1</option>
        						<option <?php if($data['tariff']=='D2'){echo 'selected';} ?>>D2</option>
        						<option <?php if($data['tariff']=='A1'){echo 'selected';} ?>>A1</option>
        						<option <?php if($data['tariff']=='A2'){echo 'selected';} ?>>A2</option>
        					</select>
                  <span class="invalid-feedback"><?php echo $data['tariff_err']; ?></span>
        				</div>
        			</div>
              <div class="col-md-2">
        				<div class = "form-group">
        					<small>ADVISED TARIFF</small>
        					<select type="text" name ="advtariff" id="advtariff" class="form-control  form-control-sm <?php echo(!empty($data['advtariff_err'])) ? 'is-invalid' : ''; ?>" >
        						<option disabled selected>SELECT ADVISED TARIF</option>
        						<option <?php if($data['advtariff']=='R1'){echo 'selected';} ?>>R1</option>
        						<option <?php if($data['advtariff']=='R2'){echo 'selected';} ?>>R2</option>
        						<option <?php if($data['advtariff']=='R3'){echo 'selected';} ?>>R3</option>
        						<option <?php if($data['advtariff']=='C1'){echo 'selected';} ?>>C1</option>
        						<option <?php if($data['advtariff']=='C2'){echo 'selected';} ?>>C2</option>
        						<option <?php if($data['advtariff']=='D1'){echo 'selected';} ?>>D1</option>
        						<option <?php if($data['advtariff']=='D2'){echo 'selected';} ?>>D2</option>
        						<option <?php if($data['advtariff']=='A1'){echo 'selected';} ?>>A1</option>
        						<option <?php if($data['advtariff']=='A2'){echo 'selected';} ?>>A2</option>
        					</select>
                  <span class="invalid-feedback"><?php echo $data['advtariff_err']; ?></span>
        				</div>
        			</div>
              <div class = "col-md-5">
                <div class = "form-group">
                  <small>CUSTOMER FULL NAME</small>
                  <input type = "text" name = "fullname" autocomplete="off" id="title" placeholder="Full name" class = "form-control form-control-sm <?php echo(!empty($data['fullname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['fullname']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['fullname_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>PHONE NUMBER</small>
                  <input type = "text" name = "gsm" autocomplete="off" id="gsm" placeholder="Enter Phone Number" maxlength="11"  class = "form-control form-control-sm <?php echo(!empty($data['gsm_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['gsm']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['gsm_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>CUSTOMER EMAIL</small>
                  <input type = "email" name = "mail" autocomplete="off" id="mail" placeholder="Enter Customer E-mail address" class = "form-control form-control-sm <?php echo(!empty($data['mail_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['mail']); ?>">
                  <span class="invalid-feedback"><?php echo $data['mail_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>USE OF PREMISES</small>
                  <select type="text" name="premises" id = "premises" class = "form-control form-control-sm <?php echo(!empty($data['premises_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected> SELECT TYPE</option>
                    <option <?php if(strtoupper($data['premises'])=='RESIDENTIAL'){echo 'selected';} ?> >RESIDENTIAL</option>
                    <option <?php if(strtoupper($data['premises'])=='COMMERCIAL'){echo 'selected';} ?> >COMMERCIAL</option>
                    <option <?php if(strtoupper($data['premises'])=='SPECIAL'){echo 'selected';} ?> >SPECIAL</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $data['premises_err']; ?></span>
                </div>
              </div>
              <div class="col-md-2">
                <div class = "form-group">
                  <small>CUSTOMER PHASE</small>
                  <select type="text" name="phase" id = "phase" placeholder="state" class = "form-control form-control-sm <?php echo(!empty($data['phase_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected> SELECT PHASE</option>
                    <option <?php if($data['phase']=='RED'){echo 'selected';} ?> > RED</option>
                    <option <?php if($data['phase']=='YELLOW'){echo 'selected';} ?> > YELLOW</option>
                    <option <?php if($data['phase']=='BLUE'){echo 'selected';} ?> > BLUE</option>
                    <option <?php if($data['phase']=='ALL'){echo 'selected';} ?> > THREE PHASE</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $data['phase_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-4">
                <div class = "form-group">
                  <small>CIN</small>
                  <input type="text" name="din" id = "din" value="<?php echo trim($data['din']) ?>" placeholder="DT index Number" class = "form-control form-control-sm <?php echo(!empty($data['din_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['din']) ?>">
                  <span class="invalid-feedback"><?php echo $data['din_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-6">
                <div class = "form-group">
                   <small>CUSTOMER ADDRESS <small>(WITH LANDMARKS)</small> </small>
                  <textarea type = "text" name = "address" autocomplete="off" id="address" placeholder="Enter Customer's Address" class = "form-control form-control-sm <?php echo(!empty($data['address_err'])) ? 'is-invalid' : ''; ?>" ><?php echo decodeHtmlEntity($data['address']); ?></textarea>
                  <span class="invalid-feedback"><?php echo $data['address_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-6">
                <div class = "form-group">
                  <small>CUSTOMER Remark</small>
                  <textarea type = "text" name = "remark" autocomplete="off" id="remark" placeholder="Enter remark" class = "form-control form-control-sm <?php echo(!empty($data['remark_err'])) ? 'is-invalid' : ''; ?>" ><?php echo empty($data['remark']) ? 'GOOD' : decodeHtmlEntity($data['remark']); ?></textarea>
                  <span class="invalid-feedback"><?php echo $data['remark_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>SEAL NUMBER</small>
                  <input type="text" name="seal" id = "seal"  autocomplete="off"  value="<?php echo $data['seal'] ?>" placeholder="Seal Number"  maxlength="6" class = "form-control form-control-sm <?php echo(!empty($data['seal_err'])) ? 'is-invalid' : ''; ?>">
                  <span class="invalid-feedback"><?php echo $data['seal_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>33KV FEEDER</small>
                  <select type="text" name="feeder_33kv" id = "feeder_33" class = "form-control form-control-sm select2 <?php echo(!empty($data['feeder_33kv_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected> SELECT Feeder</option>
                    <?php feeder33kv($data['feeder_33kv']) ?>
                  </select>
                  <span class="invalid-feedback"><?php echo $data['feeder_33kv_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>11KV FEEDER</small>
                  <select type="text" name="feeder_11kv" id = "feeder_11" class = "form-control form-control-sm select2 <?php echo(!empty($data['feeder_11kv_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected id="feederOption"> SELECT Feeder</option>
                  </select>
                  <input type="hidden" id="selectedFeeder" value="<?php echo $data['feeder_11kv'] ?>">
                  <span class="invalid-feedback"><?php echo $data['feeder_11kv_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>METER TYPE</small>
                  <select type="text" name="meter_type" id = "type" class = "form-control form-control-sm <?php echo(!empty($data['meter_type_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected> SELECT TYPE</option>
                    <option <?php if($data['meter_type']=='SINGLE PHASE'){ echo 'selected';} ?>> SINGLE PHASE</option>
                    <option <?php if($data['meter_type']=='THREE PHASE'){ echo 'selected';} ?>> THREE PHASE</option>
                    <option <?php if($data['meter_type']=='WHOLE PHASE'){ echo 'selected';} ?>> WHOLE PHASE</option>
                    <option <?php if($data['meter_type']=='MD/CT'){ echo 'selected';} ?>> MD/CT</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $data['meter_type_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>METER BRAND</small>
                  <select type="text" name="meter_brand" id = "brand" class = "select2 form-control form-control-sm <?php echo(!empty($data['meter_brand_err'])) ? 'is-invalid' : ''; ?>" style="width:100%"  >
                    <option disabled selected> SELECT BRAND</option>
                    <?php company(loadStateRegion()->cmid) ?>
                  </select>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>METER TECHNOLOGY</small>
                  <select type="text" name="meter_tech" id = "tech" class = "form-control form-control-sm <?php echo(!empty($data['meter_tech_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected> SELECT TECH</option>
                    <option selected > PLC</option>
                    <option > RF</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $data['meter_tech_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>CUSTOMER ESTIMATED CUMULATIVE</small>
                  <input type = "text" name = "estimated" autocomplete="off" id="estimated" placeholder="CUSTOMER ESTIMATED CUMULATIVE" class = "form-control form-control-sm <?php echo(!empty($data['estimated_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['estimated']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['estimated_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>ACCOUNT NUMBER</small>
                  <input type = "text" name = "account_no" autocomplete="off" id="account_no" placeholder="Enter Customer Account Number" class = "form-control form-control-sm <?php echo(!empty($data['account_no_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['account_no']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['account_no_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>BUSINESS UNIT</small>
                  <input type = "text" name = "b_unit" autocomplete="off" id="b_unit" placeholder="Business Unit" value="GOMBE" class = "form-control form-control-sm <?php echo(!empty($data['b_unit_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo decodeHtmlEntity($data['b_unit']); ?>" >
                  <span class="invalid-feedback"><?php echo $data['b_unit_err']; ?></span>
                </div>
              </div>
              <!-- <div class = "col-md-3">
                <div class = "form-group">
                  BUSINESS UNIT
                  <input type = "text" name = "account_no" autocomplete="off" id="account_no" placeholder="BUSINESS UNIT" valu="GOMBE" class = "form-control form-control-sm" value="<php echo $data['account_no']; ?>" >
                  <span class="invalid-feedback"><php echo $data['account_no_err']; ?></span>
                </div>
              </div> -->
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>GPS LATITUDE (X)</small>
                  <input type = "text" name = "x" autocomplete="off" id="x" placeholder="eg 0.1234567890" class = "form-control form-control-sm <?php echo(!empty($data['x_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['x']; ?>" >
                  <span class="invalid-feedback"><?php echo $data['x_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>GPS LONGITUDE (Y)</small>
                  <input type = "text" name = "y" autocomplete="off" id="y" placeholder=" eg 0.0123456789" class = "form-control form-control-sm <?php echo(!empty($data['y_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['y']; ?>" >
                  <span class="invalid-feedback"><?php echo $data['y_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>INSTALLER</small>
                  <select type="text" name="installer" id = "installer" class = "form-control form-control-sm select2 <?php echo(!empty($data['installer_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected> SELECT Installer</option>
                    <?php loadInstaller($data['installer']) ?>
                  </select>
                  <span class="invalid-feedback"><?php echo $data['installer_err']; ?></span>
                </div>
              </div>
              <div class = "col-md-3">
                <div class = "form-group">
                  <small>SUPERVISOR</small>
                  <select type="text" name="super" id = "super" class = "form-control form-control-sm select2 <?php echo(!empty($data['super_err'])) ? 'is-invalid' : ''; ?>"   >
                    <option disabled selected> SELECT Supervisor</option>
                    <?php loadSup($data['super']) ?>
                  </select>
                  <span class="invalid-feedback"><?php echo $data['super_err']; ?></span>
                </div>
              </div>

              <div class = "col-md-3" id="rfchannel">
                <div class = "form-group">
                  <small>RF CHANNEL</small>
                  <input type="number" name="rf" id = "rf" placeholder="RF Channel" maxlength="2" value="<?php echo decodeHtmlEntity($data['rf']) ?>" class = "form-control form-control-sm <?php echo(!empty($data['rf_err'])) ? 'is-invalid' : ''; ?>">
                  <span class="invalid-feedback"><?php echo $data['rf_err']; ?></span>
                </div>
              </div>
              <?php if(isset($data['update'])): ?>
              <div class = "col-md-5">
                <div class = "form-group">
                  <small>Reason</small>
                  <input type="text" name="updated_for" autofocus="off" placeholder="State why you're updating the record" value="<?php echo decodeHtmlEntity(@$data['updated_for']) ?>" class = "form-control form-control-sm <?php echo(!empty(@$data['updated_for_err'])) ? 'is-invalid' : ''; ?>">
                  <span class="invalid-feedback"><?php echo @$data['updated_for_err']; ?></span>
                </div>
              </div>
              <?php endif; ?>
              <div class = "col-md-3" id="rfchannel">
                <div class = "form-group">
                  <p><label for="">Multiple ? </label> <input type="checkbox" name="multiple" ></p>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col">
                <?php if(isset($data['update'])): ?>
                  <?php if(@$role['editmeter']==1): ?>
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                    <button type="submit" id="submitBtn" data-toggle="tooltip" title="Update" data-placement='top' class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Update </button>
                  <?php endif; ?>
                <?php else: ?>
                  <button type="submit" id="submitBtn" data-toggle="tooltip" title="Submit" data-placement='top' class="btn btn-success btn-sm"> <i class="fa fa-plus-square"></i> Submit </button>
                <?php endif; ?>
              </div>
            </div>
          </fieldset>
        </form>
          </div>
          </div>

    </div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){
    $('#tech').change(function(){
      if($(this).val()=='RF'){
        $('#rfchannel').show(500);
      }else{
        $('#rfchannel').hide(500);
      }
    });
    if($('#type').val()=='RF'){
        $('#rfchannel').show(500);
    }else{$('#rfchannel').hide(500);}
    $('#next').change(function(){
      if($(this).is(":checked")){
        $('fieldset').hide(500);
        $('#second').show()
        $(this).prop('checked',false);
      }
    })
    $('#previous').change(function(){
      if($(this).is(":checked")){
        $('fieldset').hide(500);
        $('#first').show(700);
        $(this).prop('checked',false);
      }
    })
    $('#scheduleCustomer').click(function(){
      var form = $('#scheduleForm');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/meters/scheduleCustomer",
        type:'POST',
        data:{scheduleCustomer:true,form:form.serialize()},
        success:function(data){
            // $('#updateTeam').modal('hide');
            // $('#updateTeamForm')[0].reset();
            $('.loader').hide();
            // alert(data)
            alert(data);
            // updateMsg(data);
          }
      });
    });
    if($('#feeder_33').val()!=null){
      fetchFeeder($('#feeder_33').val())
    }
    function fetchFeeder(id){
      var val =$('#selectedFeeder').val();
      $.ajax({
        url:"<?php echo URLROOT ?>/functions/dropdown.php",
        type:"POST",
        data:{load11Feeder:true,id:id,val:val},
        success:function(data){
          $('#feeder_11').html(data);
        }
      });
    }

    $('#feeder_33').change(function(){
      var id=$(this).val();
      fetchFeeder(id);
    });
    $('#searchByNumber').keyup(function(){
      var val = $(this).val();
      if(val !==''){
        $.ajax({
          url:"<?php echo URLROOT ?>/helpers/loadmodal.php",
          type:'POST',
          // dataType:'JSON',
          data:{findCustomerByNumber:true,num:val},
          success:function(data){
            $('#listTable').html(data);
          }
         })
      }else{
        $('#listTable').html('');
      }
    });
    // $('#meter_num').change(function(){
    //   var num=$(this).val()
    //   $.ajax({
    //     url:"<php echo URLROOT ?>/meters/confirmMeterNumber",
    //     type:"POST",
    //     data:{confirmMeterNumber:true,num:num},
    //     success:function(data){
    //       $('#submitBtn').show();
    //       if(data!=''){
    //         swal({
    //            title: "Error",
    //            text: data,
    //            icon: "warning",
    //          });
    //          $('#submitBtn').hide();
    //       }else{
    //         $('#submitBtn').show();
    //       }
    //     }
    //   });
    // });
    // var selected= $('#selectedFeeder').val();
    // alert(selected)
    // if(selected!=null && !=''){
    //   $('#feeder_11').val(selected).trigger('change');
    // }
  });
</script>
