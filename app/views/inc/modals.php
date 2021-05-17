<!-- Modal -->
<!-- batch upload medal  -->
<div class="modal fade" id="importForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">IMPORT FORM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" enctype="multipart/form-data" action="<?=URLROOT ?>/spreadsheets/readFile" id="batchUploadForm">
      <div class="modal-body">
			<div class="custom-file">
				<input type="file" name="excelFile" class="form-control" placeholder="Choose file..." id="validatedCustomFile" >

  			</div>
      </div>
      <div class="modal-footer">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" name ="header" id="defaultCheck1">
        </div>
					<button type="submit" class="btn btn-primary" name="uploadBash" id="uploadBatch">UPLOAD</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
			</form>
    </div>
  </div>
</div>
<!-- update password medal  -->
<div class="modal fade" id="updatepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Update Password </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" id="updatePwdForm" >
      <div class="modal-body">
        <div class="form-group input-group">
        <i class=" fas fa-lock bg-primary text-light p-2 input-group-append"></i>
          <input type = "password" name = "pwd" placeholder="Old password" class = "form-control input-sm" id='pwd' required>
        </div>
        <div class="form-group input-group">
        <i class=" fas fa-lock-open bg-primary text-light p-2 input-group-append"></i>
          <input type = "password" name = "npwd" placeholder="new password" class = "form-control input-sm" id='npwd' required>
          <i class="fas fa-eye bg-primary text-light p-2 input-group-append pointer togglePwd" id="togglePwd"></i>
        </div>
        <div class="form-group input-group">
        <i class="fa fa-keyboard bg-primary text-light p-2 input-group-append"></i>
          <input type = "password" name = "cpwd" placeholder="comfirm password" class = "form-control input-sm" id='cpwd' required>
        </div>
      </div>
      </form>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" name="updatePwd" id="updatePwd"><i class="fa fa-edit"></i> Update</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>

    </div>
  </div>
</div>
 <!-- password modal stop here  -->

<!-- update account medal  -->
<div class="modal fade" id="myaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Update Account </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="loadMyAccountDetails">

      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" name="updatePwd" id="updateMyAccount"><i class="fa fa-edit"></i> Update</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
<!-- update account medal  -->
<div class="modal fade" id="updateUserByIdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Update Account </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="updateBasiceMsg"></div>
      <div class="modal-body" id="loadMyAccountInfo">

      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" name="updatePwd" id="updateMyBasicInfBtn"><i class="fa fa-edit"></i> Update</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
 <!-- password modal stop here  -->

<!-- install edat Modal -->
<div class="modal fade bd-example-modal-lg" id = "installEdatModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
		<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">INSTALL EDAT</h5>
				<!-- <p class="small"><br/>NAME: <i id="metaName"></i> | ACCOUNT NUMBER: <i id="NUM"></i></p> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <div class="modal-body">
        <form method = "post" enctype ="multipart/form-data" action="<?php echo URLROOT;?>/Edats/upload">
			<div class = "row">
			<div class="col-md-4">
				<div class = "form-group">
					DATE OF INSTALLATION
					<input type ="hidden" name = "eid" id='eid' class="install_eid">
					<input type ="date" name = "doi" class = "form-control" placeholder= "" required>
				</div>
			</div>
			<div class = "col-md-4">
				<div class = "form-group">
					EDAT STATUS
					<select type="text" name="status" class = "form-control" required>
						<option disabled selected> METER STATUS</option>
						<option > NOT INSTALL</option>
						<option > INSTALLED</option>
					</select>
				</div>
			</div>
			<div class = "col-md-4">
				<div class = "form-group">
					EDAT PHOTO:
					<input type="file" name="edatfoto" class = "form-control"  placeholder="EDAT PHOTO"  required>
				</div>
			</div>

			<div class="col-md-12">
				<div class = "form-group">
					REMARKS:
					<textarea type="text" name="remark" class = "form-control"  placeholder="remark "  ></textarea>
				</div>
			</div>

			<div class = "col-md-6">
				<div class = "form-group">
					X:
					<input type="text"  class = "form-control" name="lat" placeholder="LATITUDE" >
				</div>
			</div>
			<div class = "col-md-6">
				<div class = "form-group">
					Y:
					<input type="text" name = "long" class = "form-control"  placeholder="LONGITUDE" >
				</div>
			</div>
			</div>
      </div>
      <div class="modal-footer">
		<input type="submit" class="btn btn-success" name="uploadEdat" value ="SUBMIT" id = "installEdatFormBtn">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
		</form>
    </div>
  </div>
</div>
<!-- install edat modal stop here -->
<!-- main edat modal -->
<div class="modal fade bd-example-modal-lg" id = "maintainEdatFormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">EDAT MAINTENANCE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <div class="modal-body">
       <form method = "post" enctype ="multipart/form-data" id="maintainEdatForm">
			<div class="row">
      <input type = "hidden" name="eid" class = "form-control" id="edat_Id">
			<div class="col-md-4">
				<label>Source of/ Fault</label>
				<select type="text" name="fault" id="efault" class = "form-control" required>
					<option disabled selected> SELECT CAUSE</option>
					<option > Faulty breaker</option>
					<option > Bad coupling</option>
					<option > Temper mode</option>
					<option > Natural cause</option>
				</select>
			</div>
			<div class="col-md-4">
				<label>MAINTENANCE STATUS:</label>
				<select type="text" name="status" id="estatus" class = "form-control" required>
					<option disabled selected> SELECT STATUS</option>
					<option > Replacement</option>
					<option > Resolved</option>
					<option > unresolved</option>
				</select>
			</div>
      <div class="col-md-4">
				<div class = "form-group">
					<label>SEAL Number:</label>
					<input type="number" name="seal" placeholder="new seal" class = "form-control"  required>
				</div>
			</div>
      <div class="col-md-12">
			<div class = "form-group">
				<label>Solution/recommendation</label>
				<textarea type = "text" name="solution" class = "form-control" placeholder= "solution" maxlength="50" required></textarea>
			</div>
			</div>
			<div class="col-md-4" style="display:none;" id="newedat">
				<div class = "form-group">
					<label>New Edat Number:</label>
					<input type="number" name="edatnum"  class = "form-control"  placeholder="new edat number">
				</div>
			</div>
			<div class="col-md-4">
				<div class = "form-group">
					<label>DATE:</label>
					<input type="date" name="date" class = "form-control"  required>
				</div>
			</div>
			<div class="col-md-4">
				<div class = "form-group">
					<label>EDAT PHOTO:</label>
					<input type="file" name="edatfoto" class = "form-control"  required>
				</div>
			</div>
			</div>
      </div>
      <div class="modal-footer">
       	<input type="submit" class="btn btn-success pull-left" value="SUBMIT" name="maintainEdatFormBtn" id  "maintainEdatFormBtn">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id = "maintainMeterFormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">METER MAINTENANCE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="maintainMeterFormMsg"></div>
	  <div class="modal-body">
       <form method = "post" enctype ="multipart/form-data" id="maintainMeterForm">
			<div class="row">
			<div class="col-md-4">
				<div class = "form-group">
					<label>NEW SEAL NUMBER:</label>
					<input type = "text" name="newseal" class = "form-control form-control-sm" maxlength="6" placeholder= "NEW SEAL" autocomplete="off" required>
          <span class="invalid-feedback" id="seal_err"></span>
					<input type = "hidden" name="fixMeterId" id ="mmid" required>
				</div>
			</div>
			<div class="col-md-4">
				<label>Source of/ Fault</label>
				<select type="text" name="fault" id="mfault" class = "form-control form-control-sm" required>
					<option disabled selected> SELECT CAUSE</option>
					<option > Faulty breaker</option>
					<option > Bad coupling</option>
					<option > Temper mode</option>
					<option > Natural cause</option>
					<option > Captured on Wrong meter Number</option>
				</select>
        <span class="invalid-feedback" id="fault_err"></span>
			</div>
			<div class="col-md-4">
				<label>MAINTENANCE STATUS:</label>
				<select type="text" name="status"  id="mstatus" class = "form-control form-control-sm" required>
					<option disabled selected> SELECT STATUS</option>
					<option > Resolved</option>
					<option > unresolved</option>
          <option > Replacement</option>
				</select>
        <span class="invalid-feedback" id="status_err"></span>
			</div>
			<div class="col-md-12">
			<div class = "form-group">
				<label>Solution/recommendation</label>
				<textarea type = "text" name="solution" class = "form-control form-control-sm" placeholder= "solution" maxlength="50" required  autocomplete="off" ></textarea>
        <span class="invalid-feedback" id="solution_err"></span>
    	</div>
			</div>
			<div class="col-md-2">
				<div class = "form-group">
					<label>DATE:</label>
					<input type="date" name="date" class = "form-control form-control-sm"  required>
          <span class="invalid-feedback" id="date_err"></span>
				</div>
			</div>
			<div class="col-md-4  hide hidden" style="display:none;" id="meterNumber">
				<div class = "form-group">
					<label>New Meter Number:</label>
					<input type="number" name="newmeter" placeholder="New Meter Number" class = "form-control form-control-sm  hide hidden hide"  autocomplete="off" >
          <span class="invalid-feedback" id="meter_err"></span>
				</div>
			</div>
			<div class="col-md-3">
				<div class = "form-group">
					<label>PHOTO:</label>
					<input type="file" name="meterfoto" class = "form-control form-control-sm"  required>
          <span class="invalid-feedback" id="foto_err"></span>
				</div>
			</div>
			<div class="col-md-3">
				<div class = "form-group">
					<label>Installer</label>
          <select type="date" name="installer" class="form-control form-control-sm select2" style="width:100%">
            <option disabled selected>Select Installer</option>
            <?php loadInstaller() ?>
          </select>
				</div>
			</div>
			</div>
      </div>
      <div class="modal-footer">
       <input type="submit" class="btn btn-success" name="jobcompletion" value="SUBMIT" >
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- pair meter to edat modal -->
<div class="modal fade bd-example-modal-lg" id = "mapEdatMeter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
		<div class="modal-header bg-light">
        <h5 class="modal-title"> Map Meter to an Edat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <div class="modal-body">
			   <form id="mapEdatMeterForm" method="post">
           <div class="allMetersDetail" id="edatsdetails">	</div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="mapEdatToMeter">Map</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
