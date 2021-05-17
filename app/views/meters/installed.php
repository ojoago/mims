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
<?php
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  if(isset($_POST['download'])){
    $file = new Spreadsheet();
      $active_sheet = $file->getActiveSheet();
      $active_sheet->setCellValue('A1','Account Number');
      $active_sheet->setCellValue('B1','Account Names');
      $active_sheet->setCellValue('C1','Phone Number');
      $active_sheet->setCellValue('D1','Address');
      $active_sheet->setCellValue('E1','Recommended Meter');
      $active_sheet->setCellValue('F1','Meter Number');
      $active_sheet->setCellValue('G1','Seal Number');
      $active_sheet->setCellValue('H1','Preload Unit');
      $active_sheet->setCellValue('I1','Tariff');
      $active_sheet->setCellValue('J1','Advice Tariff');
      $active_sheet->setCellValue('K1','X');
      $active_sheet->setCellValue('L1','Y');
      $active_sheet->setCellValue('M1','Remark');
      $active_sheet->setCellValue('N1','Status');
      $active_sheet->setCellValue('O1','Installer');
      $active_sheet->setCellValue('P1','Date');
      $active_sheet->setCellValue('Q1','Edat Number');
      $active_sheet->setCellValue('R1','RF CHannel');
      $active_sheet->setCellValue('S1','Edat Status');
      $active_sheet->setCellValue('T1','Edat Address');
      $active_sheet->setCellValue('U1','DT Names');
      $active_sheet->setCellValue('V1','Pole');
      $active_sheet->setCellValue('W1','X');
      $active_sheet->setCellValue('X1','Y');
      $active_sheet->setCellValue('Y1','Remark');
      $active_sheet->setCellValue('Z1','Installer');
      $k=2;
      foreach($data as $cell){
        $active_sheet->setCellValue('A'.$k,$cell->accountnumber);
        $active_sheet->setCellValue('B'.$k,$cell->cust_names);
        $active_sheet->setCellValue('C'.$k,$cell->gsm);
        $active_sheet->setCellValue('D'.$k,$cell->address);
        $active_sheet->setCellValue('E'.$k,$cell->meter_recomended);
        $active_sheet->setCellValue('F'.$k,$cell->meternum);
        $active_sheet->setCellValue('G'.$k,$cell->seal);
        $active_sheet->setCellValue('H'.$k,$cell->preload);
        $active_sheet->setCellValue('I'.$k,$cell->tarif);
        $active_sheet->setCellValue('J'.$k,$cell->advicetarif);
        $active_sheet->setCellValue('K'.$k,$cell->m_x);
        $active_sheet->setCellValue('L'.$k,$cell->m_y);
        $active_sheet->setCellValue('M'.$k,$cell->comment);
        $active_sheet->setCellValue('N'.$k,$cell->status);
        $active_sheet->setCellValue('O'.$k,$cell->uid);
        $active_sheet->setCellValue('P'.$k,$cell->doi);
        $active_sheet->setCellValue('Q'.$k,$cell->edatnumber);
        $active_sheet->setCellValue('R'.$k,$cell->channel);
        $active_sheet->setCellValue('S'.$k,$cell->edatstatus);
        $active_sheet->setCellValue('T'.$k,$cell->e_address);
        $active_sheet->setCellValue('U'.$k,$cell->dt_name);
        $active_sheet->setCellValue('V'.$k,$cell->pole);
        $active_sheet->setCellValue('W'.$k,$cell->e_x);
        $active_sheet->setCellValue('X'.$k,$cell->e_y);
        $active_sheet->setCellValue('Y'.$k,$cell->uid);
        $active_sheet->setCellValue('Y'.$k,$cell->remark);
      echo  $k++;
      }
      $path= 'Installed_'.rand(1,100).'.xlsx';
      $writer = new Xlsx($file);
      $writer->save($path);
      if(extension_loaded('zip')){
        $zip = new ZipArchive();
        $zipName = "InstalledCustomer_".rand(10,100).".zip";
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
<?php if(!empty($data)): ?>
<div class="row">
    <div class="col-md-12 col-lg-12 mx-auto">
        <div class="card card-body  mt-3">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <i class="fas fa-table mr-1"></i> Metered Custmers
              <div class="btn-group">
                <nav class="navbar">
                  <button type="button" class="btn bg-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filter </button>
                  <div class="dropdown-menu">
                      <a class="dropdown-item pointer" id="bydate">Number</a>
                      <a class="dropdown-item pointer" id="dateRange">Date Range</a>
                      <a class="dropdown-item pointer" id="byaccount">Account</a>
                      <a class="dropdown-item pointer" id="bycompany">Company</a>
                      <a class="dropdown-item pointer" id="bycompanyRange">Company Range</a>
                  </div>
                </nav>
              </div>
            </div>
            <div class="col-md-9">
              <div class="row">
              <div class="col-md-10">
                <form method="post" action="<?php echo URLROOT;?>/installedmeters/GetRange" class="pull-left" id="bydateRange" style="display:none;">
                    <div class="input-group mx-2">
                       <input class="form-control" type="date" name="from" placeholder="mm/dd/YYYY" aria-label="Search" aria-describedby="basic-addon2" />
                       <div class="input-group-append">
                           <button class="btn-primary text-white" type="button">From</button>
                       </div>
                       <input class="form-control" type="date" name="to" placeholder="mm/dd/YYYY" aria-label="Search" aria-describedby="basic-addon2" />
                      <div class="input-group-append">
                           <button class="btn-primary text-white" name="GetRange" type="button">To</button>
                      </div>
                      <!-- <div class="input-group-append"> -->
                           <input class="btn btn-success btn-sm" type="submit" value="Go">
                      <!-- </div> -->
                  </div>
              </form>
                <form method="post" action="<?php echo URLROOT;?>/installedmeters/justcompany" class="pull-left" id="justcompany" style="display:none;">
                    <div class="input-group mx-2">
                      <!-- <div class = "form-group"> -->
                       Company:
                       <select type="text" name="company" placeholder="Address" class = "form-control form-control-sm " >
                         <option disabled selected> Select</option>
                         <?php echo company(); ?>
                       </select>

                     <!-- </div> -->
                      <!-- <div class="input-group-append"> -->
                           <input class="btn btn-success btn-sm" type="submit" value="Go">
                      <!-- </div> -->
                  </div>
              </form>
                <form method="post" action="<?php echo URLROOT;?>/installedmeters/companyrange" class="pull-left" id="companyRange" style="display:none;width:100%;margin-left:0 !important;">
                    <div class="input-group mx-2">
                       <select type="text" name="company" class = "form-control form-control-sm" required>
                         <option disabled selected> Select Company</option>
                         <?php echo company(); ?>
                       </select>
                     <input class="form-control form-control-sm" required type="date" name="from" placeholder="mm/dd/YYYY" aria-label="Search" aria-describedby="basic-addon2" />
                     <div class="input-group-append">
                         <button class="btn-primary text-white" type="button">From</button>
                     </div>
                     <input class="form-control form-control-sm" required type="date" name="to" placeholder="mm/dd/YYYY" aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                         <button class="btn-primary text-white" name="GetRange" type="button">To</button>
                    </div>
                           <input class="btn btn-success btn-sm" type="submit" value="Go">
                  </div>
              </form>
              <form method="post" action="<?php echo URLROOT;?>/installedmeters/column" class="form-group" id="date" style="display:none;">
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
              </form>
              <form method="post" action="" id="bynum" style="display:none;" class="form-group">
                <div class="input-group">
                   <input class="form-control" id="searchval" type="text" placeholder="Account Number..." aria-label="Search" aria-describedby="basic-addon2" />
                   <div class="input-group-append">
                       <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                   </div>
               </div>
               <p id="result"></p>
              </form>
              </div>
            <div class="col-md-2">
              <form  class="mx-0 px-0" style="margin:0 !important;padding: 0!important;" method="post">
                <input style="float:right !important;" type="submit" name="download" value="Export" class="btn btn-xs btn-success pull-right ml-auto">
              </form>
            </div>
          </div>
          </div>
          </div>
        </div>
        <div class="table-responsive">
                      <table class="table table-bordered table-stripe table-hover" id="" width="100%">
                        <thead>
                          <tr class="small">
                            <th width="3%">S/N</th>
                            <th width="10%">Number</th>
                            <th width="5%">Names</th>
                            <th width="5%">GSM</th>
                            <th width="15%">Address</th>
                            <th width="10%">Meter No</th>
                            <th width="5%">RF</th>
                            <th width="5%">Seal</th>
                            <th width="3%">Preload</th>
                            <th width="5%">Tarif</th>
                            <th width="5%">X</th>
                            <th width="5%">Y</th>
                            <th width="20%">Remark</th>
                            <th width="7%">Status</th>
                            <th width="5%">Installer</th>
                            <th width="5%">Photo</th>
                            <th width="5%">Date</th>
                            <th width="10%">Edat Number</th>
                            <!-- <th width="10%">Status</th> -->
                            <th width="3%"><i class="fa fa-cog"></i></th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php $n=0; foreach ($data as $row): ?>
                          <tr class="small xs" id ="<?php echo $row->cid ?>">
                              <td><?=++$n ?></td>
                              <td class="numb" ><?php echo$row->accountnumber ?></td>
                              <td class="name" ><?php echo $row->accountname ?></td>
                              <td class="gsm" ><?php echo $row->gsm ?></td>
                              <td class="address" ><?php echo $row->address ?></td>
                              <!-- <td class="count" ><?php //echo $row->dayscount ?></td> -->
                               <td class="meter" ><?php echo $row->meternum ?></td>
                               <td class="meter" ><?php echo $row->rf ?></td>
                               <td class="seal" ><?php echo $row->seal ?></td>
                               <td class="preload" ><?php echo $row->preload ?></td>
                               <td class="tarif" ><?php echo $row->tarif ?></td>
                               <!-- <td class="tarif" ><?php //echo $row->advicetarif ?></td> -->
                               <td class="m_x" ><?php echo $row->m_x ?></td>
                               <td class="m_y" ><?php echo $row->m_y ?></td>
                               <td class="remark"><?php echo $row->comment ?></td>
                               <td class="status" ><?php echo $row->status ?></td>
                               <td class="installer" ><?php echo $row->uid ?></td>
                               <td class="photo" ><img src="<?php echo URLROOT ?>/images/<?php echo $row->meterfoto ?>" class="img img-responsive img-small" alt="image"></td>
                               <td class="date" ><?php echo $row->doi ?></td>
                               <td class="edatnumber" ><?php echo $row->edatnumber ?></td>
                               <td>
                                 <div class="btn-group small">
                                   <i class="fa fa-cog fixefaultyMeter text-primary pointer fa-2x mr-1" data-toggle="tooltip" data-placement="top" title="fix Meter" id="<?php echo $row->mid ?>" ></i>
                                   <i class="fa fa-cogs asignFaultyMeter text-warning pointer fa-2x" data-toggle="tooltip" data-placement="top" title="Asign Meter" id="<?php echo $row->mid ?>" ></i>
                                   <i class="fa fa-map-pin text-info ml-1 pointer pair fa-2x" title="map to an Edat" data-toggle="tooltip" data-placement="left" id="<?php echo $row->mid ?>"></i>
                                 </div>
                                </td>
                                <!-- <td><img class = "img img-responsive small img-small" src="images/<php echo $row->edatfoto ?>"  alt="image"></td> -->
                        </tr>
                      <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
      </div>
    </div>
 <!-- </div> -->

<?php else : ?>
  empty result set
<?php endif; ?>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){
    //toggle Filter forms
    //reloadPage(01234567678898);
    $('#dateRange').click(function(){
      $('#date').hide(500);
      $('#bynum').hide(500);
      $('#justcompany').hide(500);
      $('#companyRange').hide(500);
      $('#bydateRange').show(700);
    });
    $('#bydate').click(function(){
      $('#bynum').hide(500);
        $('#bydateRange').hide(500);
        $('#justcompany').hide(500);
        $('#companyRange').hide(500);
        $('#date').show(700);
    });
    $('#byaccount').click(function(){
      $('#bynum').show(700);
      $('#justcompany').hide(500);
      $('#companyRange').hide(500);
      $('#bydateRange').hide(500);
      $('#date').hide(500);
    });
    $('#bycompany').click(function(){
      $('#justcompany').show(600);
      $('#bynum').hide(500);
      $('#companyRange').hide(500);
      $('#bydateRange').hide(500);
      $('#date').hide(500);
    });
    $('#bycompanyRange').click(function(){
      $('#companyRange').show(700);
      $('#justcompany').hide(500);
      $('#bynum').hide(500);
      $('#bydateRange').hide(500);
      $('#date').hide(500);
    });
    // dynamic search
    $('#searchval').keyup(function(){
      var val = $(this).val();
      if(val !==''){
        $('.loader').show();
        $.ajax({
          url:"<?=URLROOT ?>/Installedmeters/findBynumber",
          type:'POST',
          // dataType:'JSON',
          data:{findnumber:true,num:val},
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
                alert(data);
                swal({
                   title: "",
                   text: data,
                   icon: "success",
                 });
              }else{
                alert(data)
                swal(data);
              }
          }
        });
      }else{  $('.required').text('select company');}
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
            <?php echo company(); ?>
          </select>
        </div>
        <div class = "form-group">
          ASIGN:
            <select style="width:100%;" type="text" name="installer" id="asignedto" placeholder="Address" class = "form-control asignedto select2" >
            <option disabled selected> Select Company First</option>
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
