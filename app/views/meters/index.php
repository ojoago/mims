<?php
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  if(isset($_POST['download'])){
    $file = new Spreadsheet();
      $active_sheet = $file->getActiveSheet();
      $active_sheet->setCellValue('A1','S/N');
      $active_sheet->setCellValue('B1','Meter Number');
      $active_sheet->setCellValue('C1','Seal Number');
      $active_sheet->setCellValue('D1','Preload Unit');
      $active_sheet->setCellValue('E1','State');
      $active_sheet->setCellValue('F1','Trading Zone');
      $active_sheet->setCellValue('G1','Date');
      $active_sheet->setCellValue('H1','DT Name');
      $active_sheet->setCellValue('I1','DT CODE');
      $active_sheet->setCellValue('J1','DT Type');
      $active_sheet->setCellValue('K1','Upriser');
      $active_sheet->setCellValue('L1','Pole');
      $active_sheet->setCellValue('M1','Tariff');
      $active_sheet->setCellValue('N1','Advised Tariff');
      $active_sheet->setCellValue('O1','Customer Name');
      $active_sheet->setCellValue('P1','Phone Number');
      $active_sheet->setCellValue('Q1','Email');
      $active_sheet->setCellValue('R1','Premises Type');
      $active_sheet->setCellValue('S1','Customer Phase');
      $active_sheet->setCellValue('T1','Address');
      $active_sheet->setCellValue('U1','Remark');
      $active_sheet->setCellValue('V1','33 kv feeder');
      $active_sheet->setCellValue('W1','11 kv feeder');
      $active_sheet->setCellValue('X1','Meter Type');
      $active_sheet->setCellValue('Y1','Account Number');
      $active_sheet->setCellValue('Z1','Status');
      $active_sheet->setCellValue('AA1','X');
      $active_sheet->setCellValue('AB1','Y');
      $active_sheet->setCellValue('AC1','Name of Installer');
      $active_sheet->setCellValue('AD1','Name of Supervisor');
      $active_sheet->setCellValue('AE1','CIN');
      $active_sheet->setCellValue('AF1','RF Channel');
      $k=2;$n=0;
      foreach($data['row'] as $cell){
        $active_sheet->setCellValue('A'.$k,++$n);
        $active_sheet->setCellValue('B'.$k,$cell->meter_no);
        $active_sheet->setCellValue('C'.$k,$cell->seal_number);
        $active_sheet->setCellValue('D'.$k,$cell->preload);
        $active_sheet->setCellValue('E'.$k,replaceQuote($cell->state));
        $active_sheet->setCellValue('F'.$k,replaceQuote($cell->zone));
        $active_sheet->setCellValue('G'.$k,prettyDate($cell->date));
        $active_sheet->setCellValue('H'.$k,replaceQuote($cell->dt_name));
        $active_sheet->setCellValue('I'.$k,$cell->dt_code);
        $active_sheet->setCellValue('J'.$k,$cell->dt_type);
        $active_sheet->setCellValue('K'.$k,$cell->upriser);
        $active_sheet->setCellValue('L'.$k,replaceQuote($cell->pole));
        $active_sheet->setCellValue('M'.$k,replaceQuote($cell->presenet_tariff));
        $active_sheet->setCellValue('N'.$k,replaceQuote($cell->advised_tariff));
        $active_sheet->setCellValue('O'.$k,replaceQuote($cell->fullname));
        $active_sheet->setCellValue('P'.$k,replaceQuote($cell->phone_number));
        $active_sheet->setCellValue('Q'.$k,replaceQuote($cell->customer_email));
        $active_sheet->setCellValue('R'.$k,replaceQuote($cell->use_of_premises));
        $active_sheet->setCellValue('S'.$k,replaceQuote($cell->customer_phase));
        $active_sheet->setCellValue('T'.$k,replaceQuote($cell->customer_address));
        $active_sheet->setCellValue('U'.$k,replaceQuote($cell->customer_remark));
        $active_sheet->setCellValue('V'.$k,replaceQuote(@$cell->feeder_33));
        $active_sheet->setCellValue('W'.$k,replaceQuote($cell->feeder_11));
        $active_sheet->setCellValue('X'.$k,replaceQuote($cell->meter_type));
        $active_sheet->setCellValue('Y'.$k,replaceQuote($cell->account_number));
        $active_sheet->setCellValue('Z'.$k,replaceQuote($cell->status));
        $active_sheet->setCellValue('AA'.$k,replaceQuote($cell->latitude));
        $active_sheet->setCellValue('AB'.$k,$cell->longitude);
        $active_sheet->setCellValue('AC'.$k,replaceQuote($cell->uid));
        $active_sheet->setCellValue('AD'.$k,supervisorName($cell->installer_supervisor));
        $active_sheet->setCellValue('AE'.$k,replaceQuote($cell->din));
        $active_sheet->setCellValue('AF'.$k,$cell->rf);
        $k++;
      }
      $date=str_replace(' ','',$data['date']);
      $date=str_replace("'",'',$data['date']);
      // reportLog(UID().' Export '.$data['date']);
      $path= $date.'_'.rand(1,1000).'.xlsx';
      $writer = new Xlsx($file);
      $writer->save($path);
      if(extension_loaded('zip')){
        $zip = new ZipArchive();
        $zipName = $date.".zip";
        if($zip->open($zipName,ZIPARCHIVE::CREATE)===true){
          $zip->addFile($path);
          $zip->close();
          if(file_exists($zipName)){
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="'.$zipName.'"');
            readFile($zipName);
            unlink($zipName);
            unlink($path);
          }
        }else {
          $error="File not ready for exporting!";
        }
      }else{$error="Archive not found!";}
     exit;
  }
?>
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
  	position: absolute;
  	z-index:99 !important;
  }
  #result li{
    background:#333333 !important;
  	color:#fff !important;
  	height:30px;
    padding: 3px !important;
  }

  #result li a:hover{
    text-decoration:none !important;
  }
  form{
    margin-top:0px !important;
  }
</style>

<div class="row">
    <div class="col-md-12 col-lg-12 mx-auto">
        <div class="card card-body  mt-3">
        <div class="card-header">
          <div class="row">
            <div class="col-md-7">
              <i class="fas fa-table mr-1"></i> Metered Customers
              <a href="<?php echo URLROOT ?>/meters"><button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Refresh"  ><i class="fa fa-spinner fa-spin"></i></button></a>
              <div class="btn-group">
                <nav class="navbar">
                  <button type="button" class="btn bg-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filter </button>
                  <div class="dropdown-menu">
                      <a href="<?php echo URLROOT ?>/meters/index/all" class="dropdown-item pointer" >All</a>
                      <a class="dropdown-item pointer" id="dateRange">Date Range</a>
                      <a class="dropdown-item pointer" id="byaccount">Single Account</a>
                      <a class="dropdown-item pointer" id="bydate">Random Search</a>
                      <a class="dropdown-item pointer" id="bySup">Supervisor</a>
                  </div>
                </nav>
              </div>
              <?php echo $data['date'] ?>: <span class="badge badge-dark p-2"><?php echo $data['count']; ?></span>
            </div>
            <div class="col-md-5">
              <div class="row">
              <div class="col-md-10 ml-0">
                <form method="post" class="pull-left filterForm" id="bydateRange" style="display:none;">
                    <div class="input-group mx-2">
                       <input class="form-control" type="date" name="from" id="from" placeholder="mm/dd/YYYY" aria-label="Search" aria-describedby="basic-addon2" />
                       <div class="input-group-append">
                           <button class="btn-primary text-white" type="button">From</button>
                       </div>
                       <input class="form-control" type="date" name="to" id="to" placeholder="mm/dd/YYYY" aria-label="Search" aria-describedby="basic-addon2" />
                      <div class="input-group-append">
                           <button class="btn-primary text-white" name="GetRange" type="button">To</button>
                      </div>
                      <!-- <div class="input-group-append"> -->
                           <input class="btn btn-success btn-sm" type="button" id="byDateRangeBtn" value="Go">
                      <!-- </div> -->
                  </div>
              </form>
                <form method="post" class="pull-left filterForm" id="bySupRange" style="display:none;" >
                    <div class="input-group mx-2">
                       <input class="form-control" type="date" name="from" id="froms" placeholder="mm/dd/YYYY" aria-label="Search" aria-describedby="basic-addon2" />
                       <!-- <div class="input-group-append">
                           <button class="btn-primary text-white" type="button">From</button>
                       </div> -->
                       <input class="form-control" type="date" name="to" id="tos" placeholder="mm/dd/YYYY" aria-label="Search" aria-describedby="basic-addon2" />
                      <!-- <div class="input-group-append">
                           <button class="btn-primary text-white" name="GetRange" type="button">To</button>
                      </div> -->
                      <select type="text" name="super" id = "super"class = "form-control" >
                        <option disabled selected> SELECT Supervisor</option>
                        <?php loadSup() ?>
                      </select>
                      <!-- <div class="input-group-append"> -->
                           <input class="btn btn-success btn-sm" type="button" id="bySupRangeBtn" value="Go">
                      <!-- </div> -->
                  </div>
              </form>
              <form  class="form-group filterForm" id="date" style="display:none;">
                <input type="text" id="searchval" autocomplete="off" placeholder="Enter account, meter number or name" class="form-control">
              </form>
              <!-- <form method="post" action="<php echo URLROOT;?>/installedmeters/column" class="form-group" id="date" style="display:none;">
                <div class="input-group">
                   <input class="form-control" type="text" name="day" placeholder="Enter number" aria-label="Search" aria-describedby="basic-addon2" required>
                   <div class="input-group-append">
                     <select type="text" name="criteria"  class = "form-control" required>
                       <option disabled selected>select criteria</option>
                       <option value="accountnumber">Account Number</option>
                       <option value="meternum">Meter Number</option>
                       <option value="edatnumber">Edat Number</option>
                   </select>
                   </div>
                   <input class="btn btn-success btn-sm" name="column" type="submit" value="Go">
               </div>
              </form> -->
              <form method="post" action="" id="bynum" style="display:none;" class="form-group filterForm">
                <div class="input-group">
                   <input class="form-control" id="searchSingle" autocomplete="off" type="text" placeholder="Account Number... or meter Number..." aria-label="Search" aria-describedby="basic-addon2" />
               </div>
               <p id="result"></p>
              </form>
              </div>
            <div class="col-md-2">
              <?php if(!empty($data['row'])): ?>
              <form  class="mx-0 px-0" style="margin:0 !important;padding: 0!important;" method="post">
                <input style="float:right !important;" type="submit" name="download" value="Export" class="btn btn-xs btn-success pull-right ml-auto">
              </form>
            <?php endif; ?>
            </div>
          </div>
          </div>
          </div>
        </div>
        <div class="table-responsive">
                      <table class="table table-bordered table-stripe table-hover" width="100%"  id="listTable">
                        <thead>
                          <tr class="">
                            <th>S/N</th>
                            <th>Meter Number</th>
                            <th>Seal </th>
                            <th>Preload</th>
                            <th>State</th>
                            <th>Zone</th>
                            <th>Date</th>
                            <th>DT Name</th>
                            <th>DT CODE</th>
                            <th>DT Type</th>
                            <th>Upriser</th>
                            <th>pole </th>
                            <th>tariff</th>
                            <th>advised tariff</th>
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                            <th>email</th>
                            <th>premises Type</th>
                            <th>customer phase</th>
                            <th>address</th>
                            <th>remark</th>
                            <th>33 kv feeder</th>
                            <th>11 kv feeder</th>
                            <th>meter type</th>
                            <th>estimated CUMULATIVE</th>
                            <th>account number</th>
                            <th>Status</th>
                            <th>X</th>
                            <th>Y</th>
                            <th>installer</th>
                            <th>Supervisor</th>
                            <th>din</th>
                            <th>rf</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(!empty($data)): ?>
                        <?php $n=0; foreach ($data['row'] as $row): ?>
                          <tr class="">
                              <td><?=++$n ?></td>
                              <td ><?php echo decodeHtmlEntity($row->meter_no) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->seal_number) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->preload) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->state) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->zone) ?></td>
                              <td ><?php echo prettyDate($row->date) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->dt_name) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->dt_code) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->dt_type) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->upriser) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->pole) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->presenet_tariff) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->advised_tariff) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->fullname)  ?></td>
                              <td ><?php echo decodeHtmlEntity($row->phone_number) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->customer_email) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->use_of_premises) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->customer_phase) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->customer_address) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->customer_remark) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->feeder_11) ?></td>
                              <td ><?php echo decodeHtmlEntity(@$row->feeder_33) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->meter_type) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->estimated) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->account_number) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->status) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->latitude) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->longitude) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->uid) ?></td>
                              <td ><?php echo decodeHtmlEntity(supervisorName($row->installer_supervisor)) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->din) ?></td>
                              <td ><?php echo decodeHtmlEntity($row->rf) ?></td>
                              <td >
                                <div class="btn-group">
                                  <?php if(@$role['fixMeter']==1): ?>
                                    <i class="fa fa-cog fixefaultyMeter text-primary pointer mr-1" data-toggle="tooltip" data-placement="top" title="fix Meter" id="<?php echo $row->id ?>" ></i>
                                  <?php endif; ?>
                                  <?php if(@$role['asignMeter']==1): ?>
                                    <i class="fa fa-cogs asignFaultyMeter text-warning pointer mr-1" data-toggle="tooltip" data-placement="top" title="Asign Meter" id="<?php echo $row->id ?>" ></i>
                                  <?php endif; ?>
                                  <?php if(@$role['editmeter']==1): ?>
                                    <a href="<?php echo URLROOT.'/meters/edit/'.$row->id?>" data-toggle="tooltip" data-placement="top" title="Edit Info"> <i class="fa fa-edit text-warning"></i> </a>
                                  <?php endif; ?>
                                  <?php if(@$role['deleteMeter']==1): ?>
                                    <a class="pointer deleteMeter" id="<?php echo $row->id  ?>" data-toggle="tooltip" data-placement="top" title="Delete Customer"> <i class="fa fa-trash text-danger"></i> </a>
                                  <?php endif; ?>
                              </div>
                              </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
      </div>
    </div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){
    //toggle Filter forms
    //reloadPage(01234567678898);
    $('#dateRange').click(function(){
      $('.filterForm').hide(300);
      $('#bydateRange').show(700);
      $('.loader').hide();
    });
    $('#bydate').click(function(){
      $('#bynum').hide(500);
      $('.filterForm').hide(300);
        $('#date').show(700);
        $('.loader').hide();
    });
    $('#byaccount').click(function(){
      $('.filterForm').hide(300);
      $('#bynum').show(700);
      $('.loader').hide();
    });
    $('#bycompany').click(function(){
      $('.filterForm').hide(300);
      $('#justcompany').show(600);
      $('.loader').hide();
    });
    $('#bycompanyRange').click(function(){
      $('.filterForm').hide(300);
      $('#companyRange').show(700);
      $('.loader').hide();
    });
    $('#bySup').click(function(){
      $('.filterForm').hide(300);
      $('#bySupRange').show(700);
      $('.loader').hide();
    });
    // dynamic search
    $('#searchval').keyup(function(){
      var val = $(this).val();
      if(val !==''){
        $.ajax({
          url:"<?php echo URLROOT ?>/helpers/loadmodal.php",
          type:'POST',
          // dataType:'JSON',
          data:{installedCustomerByNumberOrName:true,num:val},
          success:function(data){
            $('#listTable').html(data);
            $('[data-toggle="tooltip"]').tooltip();
          }
         })
      }else{
        $('#result').html('');
      }
    });

    $('#searchSingle').keyup(function(){
      var val = $(this).val();
      if(val !==''){
        //$('.loader').show();
        $.ajax({
          url:"<?php echo URLROOT ?>/helpers/loadmodal.php",
          type:'POST',
          // dataType:'JSON',
          data:{searchSingleInstalledCustomerByVal:true,num:val},
          success:function(data){
            $('#result').html(data);
          }
         })
      }else{
        $('.loader').hide();
        $('#result').html('');
      }
    });
        // faulty meters goes here
        $('.asignFaultyMeter').click(function(){
          var id = $(this).attr('id');
          $('#custId').val(id);
          $('#asignedFaultyMetersModal').modal('show');
        });

    $('.company').change(function(){
  		var id =$(this).val();
  		$.ajax({
  			url:"<?=URLROOT ?>/helpers/dropdown.php",
  			type:'POST',
  			dataType:'JSON',
  			data:{fetchInstaller:true,id:id},
  			success:function(data){
  				$('#asignedto').html(data.installer);
  			}
  		})
  	});
    // asign to individual
    $('#asignBtn').click(function(){
      var form = $('#asignForm');
      var cmp=$('.company').val();
      if(cmp!==null){
        $.ajax({
          url:"<?=URLROOT ?>/faults/asignMeter",
          type:'POST',
          // dataType:'JSON',
          data:{asignMeter:true,form:form.serialize()},
          success:function(data){
            if(data.includes('success')){
                $('#asignedFaultyMetersModal').modal('hide');
                $('#asignForm')[0].reset();
                swal({
                   title: "",
                   text: data,
                   icon: "success",
                 });
              }else{
                swal({
                   title: "",
                   text: data,
                   icon: "warning",
                 });
              }
          }
        });
      }else{  $('.required').text('select company');}
    });
    $('.deleteMeter').click(function(){
      $('#deletecustomerId').val($(this).attr('id'));
      $('#deleteCustomerModal').modal('show');
    });
    $('#deleteCustomerBtn').click(function(){
      var form =$('#deleteCustomerForm');
      $.ajax({
         url:"<?php echo URLROOT?>/Meters/manageMeters",
         method:'POST',
         data:{deleteCustomer:true,form:form.serialize()},
         success:function(data){
           if(data.includes('success')){
              location.reload();
            }else{
              $('#deleteMsg').html(data);
            }
         }
      });
    });
    $('#byDateRangeBtn').click(function(){
      var from=$('#from').val().replace('/','_');
      var to=$('#to').val().replace('/','_');
      from=from.replace('/','_');
      to=to.replace('/','_');
      location.href="<?php echo URLROOT;?>/meters/index/"+from+'/'+to;
    });
    $('#bySupRangeBtn').click(function(){
      var from=$('#froms').val().replace('/','_');
      var to=$('#tos').val().replace('/','_');
      from=from.replace('/','_');
      to=to.replace('/','_');
      var sup =$('#super').val();
      if(sup !=null && from !=''){
        location.href="<?php echo URLROOT;?>/meters/supervisor/"+from+'/'+sup+'/'+to;
      }
    });
})
</script>
<!-- Asign customer to team and company for installation model  -->
<div class="modal fade" id="asignedFaultyMetersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h6 class="modal-title" id="exampleModalLabel">Asign Faulty Meter to installer</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" id="asignForm">
      <div class="modal-body">
        <div class = "form-group">
          <p id="required" class="text-danger required"></p>
            <input type="hidden" name = "meterID" id ="custId">
            <select style="width:100%;" type="text" id="company" name="company" placeholder="Address" class = "form-control select2 company"   required>
            <option disabled selected> Select   Company</option>
            <?php echo company(1); ?>
          </select>
        </div>
        <div class = "form-group">
          ASIGN:
            <select style="width:100%;" type="text" name="installer" id="asignedto" placeholder="Address" class = "form-control asignedto select2" >
            <option disabled selected> Select Company First</option>
            <?php loadInstaller() ?>
          </select>
        </div>
      </div>
      </form>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" name="asignBtn" id="asignBtn"><i class="fa fa-rocket"></i> Go</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Asign customer to team and company for installation model  -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h6 class="modal-title" id="exampleModalLabel">Delete Customer</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" id="deleteCustomerForm">
      <div class="modal-body">
        <div class = "form-group">
          <p id="deleteMsg" class="text-danger required"></p>
            <input type="hidden" name = "id" id ="deletecustomerId">
            <textarea name="reason"  class="form-control form-control-sm" placeholder="State why you are deleting and Who ask you to!"></textarea>
        </div>

      </div>
      </form>
      <div class="modal-footer">
					<button  class="btn btn-danger pull-left btn-sm" id="deleteCustomerBtn"><i class="fa fa-rocket"></i> Delete</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>

    </div>
  </div>
</div>
