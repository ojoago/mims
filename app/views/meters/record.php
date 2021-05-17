<?php
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  if(isset($_POST['download'])){
    $file = new Spreadsheet();
      $active_sheet = $file->getActiveSheet();
      $active_sheet->setCellValue('A1','S/N');
      $active_sheet->setCellValue('B1','Date');
      $active_sheet->setCellValue('C1','Schedule');
      $active_sheet->setCellValue('D1','Installed');
      $active_sheet->setCellValue('E1','Replacement');
      $active_sheet->setCellValue('F1','Total');
      $active_sheet->setCellValue('G1','Team');
      $active_sheet->setCellValue('H1','Installer');
      $k=2;$n=0;
      foreach($data as $cell){
        $active_sheet->setCellValue('A'.$k,++$n);
        $active_sheet->setCellValue('B'.$k,prettyDate($cell->date));
        $active_sheet->setCellValue('C'.$k,$cell->meters);
        $active_sheet->setCellValue('D'.$k,$cell->installed);
        $active_sheet->setCellValue('E'.$k,replaceQuote($cell->replaced));
        $active_sheet->setCellValue('F'.$k,replaceQuote($cell->replaced+$cell->installed));
        $active_sheet->setCellValue('G'.$k,$cell->team);
        $active_sheet->setCellValue('H'.$k,replaceQuote($cell->uid));
        $k++;
      }
      $path= 'NMMP DAILY INSTALLATION T7-'.rand(1,700).'.xlsx';
      $writer = new Xlsx($file);
      $writer->save($path);
      if(extension_loaded('zip')){
        $zip = new ZipArchive();
        $zipName = "NMMP DAILY INSTALLATION T7 Archived.zip";
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
    /* font-size:10px; */
    font-family: 'Open Sans', sans-serif;
  }
  #filter{
    border: solid #19c5f1 3px;
    border-radius: 5px;
    margin-right: 3px;
    margin-left: 3px;
  }
</style>
<div class="row">
    <div class="col-md-12 col-lg-12 mx-auto">
      <div class="card">
        <div class="card-header">
          <div class="row">
            Schedule
            <a href="<?php echo URLROOT ?>/meters/record"><button type="button" class="btn btn-danger btn-sm ml-1" data-toggle="tooltip" title="Refresh"  ><i class="fa fa-spinner fa-spin"></i></button></a>
            <button class="btn btn-primary btn-sm ml-1 mr-1"  id = "addDailyRecord" type="button" data-toggle="tooltip" data-placement="left" title="Add New Record" style="float:right !important;"><i class="fa fa-plus"></i></button>
            <?php if(!empty($data)): ?>
              <form  class="mx-0 px-0" style="margin:0 !important;padding: 0!important;float:right !important;" method="post">
                <input style="float:right !important;" type="submit" name="download" value="Export" class="btn btn-sm btn-success pull-right ml-auto" data-toggle="tooltip" data-placement="left" title="Export to Excel" >
              </form>
            <?php endif; ?>
            <button type="button" class="btn bg-light p-1" id="filter"> Filter </button>
            <form method="post" class="pull-left filterForm" id="bydateRange" style="display:none;">
                <div class="input-group mx-2">
                   <input class="form-control form-control-sm" type="date" name="from" id="from" placeholder="mm/dd/YYYY">
                   <div class="input-group-append">
                       <button class="btn-primary text-white" type="button">From</button>
                   </div>
                   <input class="form-control form-control-sm" type="date" name="to" id="to" placeholder="mm/dd/YYYY">
                  <div class="input-group-append">
                       <button class="btn-primary text-white" name="GetRange" type="button">To</button>
                  </div>
                  <select type="text" name="sup" id="installerId" class="form-control form-control-sm select2" style="width:220px;">
                    <option disabled selected>Select Installer</option>
                    <?php loadInstaller() ?>
                  </select>
                  <!-- <div class="input-group-append"> -->
                       <input class="btn btn-success btn-sm" type="button" id="byDateRangeBtn" value="Go">
                  <!-- </div> -->
              </div>
          </form>

          </div>
        </div>
        <div class="card card-body mb-3">
          <?php flash('register_success'); ?>
          <div class="table-responsive" id="listTable">
            <table class="table table-bordered table-striped table-hover" width="100%">
              <thead>
                <tr class="small">
                  <th width="5%">S/N</th>
                  <th>Date</th>
                  <th>Schedule</th>
                  <th>Forms</th>
                  <th>Replaced</th>
                  <th>Total</th>
                  <th>Team</th>
                  <th>Installer</th>
                  <th>Writer</th>
                  <th align="center"> <i class="fa fa-cog"></i> </th>
                </tr>
              </thead>
              <tbody>
                <?php  $meters=$installed=$replaced= $n=0; ?>
            <?php foreach($data as $row) :?>
              <?php $meters+=$row->meters;$installed+=$row->installed;$replaced+=$row->replaced ?>
              <tr class="small">
                <td><?php echo ++$n; ?></td>
                <td><?php echo prettyDate($row->date) ?></td>
                <td contenteditable id="meter<?php echo $row->id ?>"><?php echo $row->meters ?></td>
                <td contenteditable id="installed<?php echo $row->id ?>"><?php echo $row->installed ?></td>
                <td contenteditable id="replaced<?php echo $row->id ?>"><?php echo $row->replaced ?></td>
                <td><?php echo $row->replaced+$row->installed ?></td>
                <td><?php echo $row->team ?></td>
                <td><?php echo decodeHtmlEntity($row->uid) ?></td>
                <td><?php echo supervisorName($row->writer) ?></td>
                <td align="center">
                  <i class="fa fa-edit text-warning pointer editDailyRecord" id="<?php echo $row->id ?>"></i>
                  <i class="fa fa-trash text-danger pointer deleteDailyRecord" id="<?php echo $row->id ?>"></i>
                </td>
              </tr>
              <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2">Total</td>
                  <td><?php echo number_format($meters) ?></td>
                  <td><?php echo number_format($installed) ?></td>
                  <td><?php echo number_format($replaced) ?></td>
                  <td><?php echo number_format($installed+$replaced) ?></td>
                </tr>
              </tfoot>
            </table>
            </div>
      </div>
      </div>
    </div>
 </div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){
    // dynamic search
    $('#addDailyRecordBtn').click(function(){
      var form=$('#addDailyRecordForm');
      $('.loader').show();
        $.ajax({
          url:"<?php echo URLROOT ?>/Meters/manageRecord",
          type:'POST',
          dataType:'JSON',
          data:{addDailyRecord:true,form:form.serialize()},
          success:function(data){
            $('.loader').hide();
            $('#addDailyRecordMsg').html(data.msg);
            if(data.error==''){
              $('#addDailyRecordForm')[0].reset();
            }
          }
        });
    });
    $('#addDailyRecord').click(function(){
      $('#addDailyRecordModal').modal('show');
    });
    $('.editDailyRecord').click(function(){
      var id=$(this).attr('id');
      var meter=$('#meter'+id).text()
      var forms=$('#installed'+id).text()
      var replaced=$('#replaced'+id).text()
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/Meters/manageRecord",
        type:'POST',
        // dataType:'JSON',
        data:{loadDailyRecordById:true,id:id,meter:meter,forms:forms,replaced:replaced},
        success:function(data){
          $('.loader').hide();
          swal(data)
        }
      });
    });
    $('.deleteDailyRecord').click(function(){
      var id=$(this).attr('id');
      if(confirm('Delete Record? Once deleted, you will not be able to recover!')){
          $.ajax({
          url:"<?php echo URLROOT ?>/Meters/manageRecord",
          type:'POST',
          data:{deleteDailyRecordById:true,id:id},
          success:function(data){
            swal(data,{
              icon: "success",
            })
            location.reload()
          }
        });
      }


    });
    $('#filter').click(function(){
      $('#bydateRange').toggle(500);
    });
    $('#byDateRangeBtn').click(function(){
      var from=$('#from').val().replace('/','_');
      var to=$('#to').val().replace('/','_');
      from=from.replace('/','_');
      to=to.replace('/','_');
      var id=$('#installerId').val();
      if(id==null){
        location.href="<?php echo URLROOT;?>/meters/record/"+from+'/'+to;
      }else {
        location.href="<?php echo URLROOT;?>/meters/record/"+from+'/'+to+'/'+id;
      }
    });
});
</script>
<!-- update account medal  -->
<div class="modal fade" id="addDailyRecordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Add Daily</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="addDailyRecordMsg"></div>
      <div class="modal-body">
        <form class="form-group" id="addDailyRecordForm">
          <div class="row">
              <div class="col-md-6">
                 <div class="form-group">
                    <label>No. of Meter Given out</label>
                    <input type="number" name="schedule" id="schedule" class="form-control form-control-sm" placeholder="No of Meter Given out">
                    <input type="hidden" name="id" id="recordId">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                 <label>No. of Forms Submitted</label>
                <input type="number" name="installed" id="installed" class="form-control form-control-sm" placeholder="No. of Installed">
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
            <label>Replaced</label>
            <input type="number" name="replaced" id="replaced" class="form-control form-control-sm" placeholder="No. Of Replacement">
          </div>
              </div>
              <div class="col-md-6">
                   <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" id="recordDate" class="form-control form-control-sm">
          </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                <label>Team</label>
                <select type="date" name="team" id="team_id" class="form-control form-control-sm">
                  <option disabled selected>Select Team</option>
                  <?php teams() ?>
                </select>
              </div>
              </div>
              <div class="col-md-6">
                   <div class="form-group">
                <label>Installer</label>
                <select type="text" name="sup" id="supervisorId" class="form-control form-control-sm select2" style="width:100%">
                  <option disabled selected>Select Installer</option>
                  <?php loadInstaller() ?>
                </select>
              </div>
              </div>
          </div>
          <div class="form-group">
           <label>Installer</label>
           <select type="text" name="writer" id="writer" class="form-control form-control-sm select2" style="width:100%">
             <option disabled selected>Select Writer</option>
             <?php loadWriter() ?>
           </select>
         </div>
        </form>
      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" id="addDailyRecordBtn"><i class="fa fa-book"></i> Submit</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
 <!-- password modal stop here  -->
