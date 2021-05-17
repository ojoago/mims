<?php
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  if(isset($_POST['download'])){
    $file = new Spreadsheet();
      $active_sheet = $file->getActiveSheet();
      $active_sheet->setCellValue('A1','S/N');
      $active_sheet->setCellValue('B1','DATE');
      $active_sheet->setCellValue('C1','NAME OF COUPLER');
      $active_sheet->setCellValue('D1','NUMBERS OF METERS ISSUED OUT');
      $active_sheet->setCellValue('E1','NO OF 1Q METERS ISSUED OUT');
      $active_sheet->setCellValue('F1','NO OF 3Q METERS ISSUED OUT ');
      $active_sheet->setCellValue('G1','NO OF 1Q METERS SUCCESSFULLY COUPLED OUT');
      $active_sheet->setCellValue('H1','NO OF 3Q METERS SUCCESSFULLY COUPLED OUT');
      $active_sheet->setCellValue('I1','REMARKS');
      $k=2;$sp=$spc=$tp=$n=$tpc=0;
      foreach($data as $cell){
        $sp+=$cell->single_phase;$spc+=$cell->single_phase_coupled;$tp+=$cell->three_phase;$tpc=$cell->three_phase_coupled;
        $active_sheet->setCellValue('A'.$k,++$n);
        $active_sheet->setCellValue('B'.$k,prettyDate($cell->date));
        $active_sheet->setCellValue('C'.$k,replaceQuote($cell->uid));
        $active_sheet->setCellValue('D'.$k,$cell->single_phase+$cell->three_phase);
        $active_sheet->setCellValue('E'.$k,$cell->single_phase);
        $active_sheet->setCellValue('F'.$k,$cell->three_phase);
        $active_sheet->setCellValue('G'.$k,$cell->single_phase_coupled);
        $active_sheet->setCellValue('H'.$k,$cell->three_phase_coupled);
        $active_sheet->setCellValue('I'.$k,replaceQuote($cell->remarks));
        $k++;
      }
      $active_sheet->setCellValue('A'.$k,'TOTAL');
      $active_sheet->setCellValue('B'.$k,'');
      $active_sheet->setCellValue('C'.$k,'');
      $active_sheet->setCellValue('D'.$k,$sp+$tp);
      $active_sheet->setCellValue('E'.$k,$sp);
      $active_sheet->setCellValue('F'.$k,$tp);
      $active_sheet->setCellValue('G'.$k,$spc);
      $active_sheet->setCellValue('H'.$k,$tpc);
      $active_sheet->setCellValue('I'.$k,'');
        $path= 'T7 NMMP DAILY COUPLING RECORD_'.rand(1,700).'.xlsx';
      $writer = new Xlsx($file);
      $writer->save($path);
      if(extension_loaded('zip')){
        $zip = new ZipArchive();
        $zipName = "T7 NMMP DAILY COUPLING RECORD.zip";
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
  label{
    text-transform: uppercase;
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
            Couple
            <a href="<?php echo URLROOT ?>/meters/couple"><button type="button" class="btn btn-danger btn-sm ml-1" data-toggle="tooltip" title="Refresh"  ><i class="fa fa-spinner fa-spin"></i></button></a>
            <button class="btn btn-primary btn-sm ml-1 mr-1"  id = "addDailyRecord" type="button" data-toggle="tooltip" data-placement="top" title="Add New Record" style="float:right !important;"><i class="fa fa-plus"></i></button>
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
                    <?php loadCoupler() ?>
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
                  <th>Single Phase Issued Out</th>
                  <th>Single Phase Coupled</th>
                  <th>Three Phase Issued Out </th>
                  <th>Three Phase Coupled</th>
                  <th>Remarks</th>
                  <th>Coupler</th>
                  <th width="8%">Date</th>
                  <th align="center"> <i class="fa fa-cog"></i> </th>
                </tr>
              </thead>
              <tbody>
                <?php  $sp=$spc=$tp=$n=$tpc=0; ?>
            <?php foreach($data as $row) :?>
              <?php $sp+=$row->single_phase;$spc+=$row->single_phase_coupled;$tp+=$row->three_phase;$tpc+=$row->three_phase_coupled ?>
              <tr class="small">
                <td><?php echo ++$n; ?></td>
                <td><?php echo $row->single_phase ?></td>
                <td><?php echo $row->single_phase_coupled ?></td>
                <td><?php echo $row->three_phase ?></td>
                <td><?php echo $row->three_phase_coupled ?></td>
                <td><?php echo decodeHtmlEntity($row->remarks) ?></td>
                <td><?php echo decodeHtmlEntity($row->uid) ?></td>
                <td><?php echo prettyDate($row->date) ?></td>
                <td align="center">
                  <!-- <i class="fa fa-edit text-warning pointer editDailyRecord" id="<php echo $row->id ?>"></i> -->
                  <i class="fa fa-trash text-danger pointer deleteDailyRecord" id="<?php echo $row->id ?>"></i>
                </td>
              </tr>
              <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td >Total</td>
                  <td><?php echo number_format($sp) ?></td>
                  <td><?php echo number_format($spc) ?></td>
                  <td><?php echo number_format($tp) ?></td>
                  <td><?php echo number_format($tpc) ?></td>
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
          url:"<?php echo URLROOT ?>/Meters/manageCoupling",
          type:'POST',
          dataType:'JSON',
          data:{addDailyCoupling:true,form:form.serialize()},
          success:function(data){
            $('.loader').hide();
            $('#addDailyCouplingMsg').html(data.msg);
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
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/Meters/manageRecord",
        type:'POST',
        dataType:'JSON',
        data:{loadDailyRecordById:true,id:id},
        success:function(data){
          $('#schedule').val(data.meters);
          $('#recordId').val(data.id);
          $('#installed').val(data.installed);
          $('#replaced').val(data.replaced);
          $('#recordDate').val(data.date);
          $('#team_id').val(data.team_id).trigger('change');
          $('#supervisorId').val(data.sup).trigger('change');
          $('#addDailyRecordModal').modal('show');
          $('.loader').hide();
        }
      });
    });
    $('.deleteDailyRecord').click(function(){
      var id=$(this).attr('id');
      if(confirm('Delete Record?')){
        $.ajax({
          url:"<?php echo URLROOT ?>/Meters/manageCoupling",
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
        location.href="<?php echo URLROOT;?>/meters/couple/"+from+'/'+to;
      }else {
        location.href="<?php echo URLROOT;?>/meters/couple/"+from+'/'+to+'/'+id;
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
      <div id="addDailyCouplingMsg"></div>
      <div class="modal-body">
        <form class="form-group" id="addDailyRecordForm">
          <div class="row">
              <div class="col-md-6">
                 <div class="form-group">
                    <label>Single Phase issued out</label>
                    <input type="number" name="spio" id="spio" class="form-control form-control-sm" placeholder="Single Phase issued out">
                    <input type="hidden" name="id" id="recordId">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Single Phase coupled</label>
                  <input type="number" name="spc" id="spc" class="form-control form-control-sm" placeholder="No. Of Single Phase coupled">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                 <label>Three Phase issued out</label>
                <input type="number" name="tpio" id="tpio" class="form-control form-control-sm" placeholder="No. of Three Phase issued out">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Three Phase coupled</label>
                  <input type="number" name="tpc" id="tfc" class="form-control form-control-sm" placeholder="No. of Three Phase Coupled">
                </div>
              </div>
              <div class="col-md-5">
                  <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" id="recordDate" class="form-control form-control-sm">
              </div>
              </div>
              <div class="col-md-7">
                  <div class="form-group">
                    <label>Coupler</label>
                    <select type="date" name="sup" id="installerId" class="form-control form-control-sm select2" style="width:100%">
                      <option disabled selected>Select Coupler</option>
                      <?php loadCoupler() ?>
                    </select>
                  </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>remarks</label>
                  <textarea type="text" name="remark" id="remark" class="form-control form-control-sm" placeholder="Remarks"></textarea>
                </div>
              </div>
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
