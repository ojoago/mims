<?php
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  if(isset($_POST['export'])){
    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1','S/N');
    $active_sheet->setCellValue('B1','Item Name');
    $active_sheet->setCellValue('C1','Item Description');
    $active_sheet->setCellValue('D1','ID');
    $active_sheet->setCellValue('E1','stock');
    $active_sheet->setCellValue('F1','Quantity');
    $active_sheet->setCellValue('G1','Units');
    $active_sheet->setCellValue('H1','Request By');
    $active_sheet->setCellValue('I1','Approved by');
    $active_sheet->setCellValue('J1','Received by');
    $active_sheet->setCellValue('K1','Department');
    $active_sheet->setCellValue('L1','Unit');
    $active_sheet->setCellValue('M1','Store ');
    $active_sheet->setCellValue('N1','Remark');
    $active_sheet->setCellValue('O1','Date');
    $active_sheet->setCellValue('P1','Waybill');
    $k=2; $n=0;
    foreach($data['sr_in'] as $cell){
      $active_sheet->setCellValue('A'.$k,++$n);
      $active_sheet->setCellValue('B'.$k,$cell->name);
      $active_sheet->setCellValue('C'.$k,$cell->dsc);
      $active_sheet->setCellValue('D'.$k,$cell->batch);
      $active_sheet->setCellValue('E'.$k,$cell->old);
      $active_sheet->setCellValue('F'.$k,$cell->quantity);
      $active_sheet->setCellValue('G'.$k,$cell->unit);
      $active_sheet->setCellValue('H'.$k,$cell->requestby);
      $active_sheet->setCellValue('I'.$k,$cell->aprovedby);
      $active_sheet->setCellValue('j'.$k,$cell->receivedby);
      $active_sheet->setCellValue('K'.$k,$cell->dept);
      $active_sheet->setCellValue('L'.$k,$cell->units);
      $active_sheet->setCellValue('M'.$k,$cell->store);
      $active_sheet->setCellValue('N'.$k,$cell->remark);
      $active_sheet->setCellValue('O'.$k,$cell->date);
      $active_sheet->setCellValue('P'.$k,$cell->wbi);
      $k++;
    }
    $path= 'sr-in_'.rand(9,999).'.xlsx';
    $writer = new Xlsx($file);
    $writer->save($path);
    if(extension_loaded('zip')){
      $zip = new ZipArchive();
      $zipName = "sr-in_".rand(1,1000).".zip";
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
<div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12 mx-auto">
          <div class="card card-body  mt-1">
            <div class="card-header">
                <form method="post" style="margin:0;" class="mx-auto mt-0">
                  <i class="fas fa-table mr-1"></i>SR-IN
                  <a href="<?php echo URLROOT ?>/stores/sr_in">
                    <button style="float:right;" class="btn btn-danger btn-sm ml-4" type="button" data-toggle="tooltip" data-placement="top" title="Refresh" ><i class="fa  fa-spinner fa-spin"></i></button>
                  </a>
                  <button style="float:right;" class="btn btn-info btn-sm ml-4" type="button" id="filterByStore" data-toggle="tooltip" data-placement="top" title="filter by date" ><i class="fa  fa-filter"></i></button>
                  <button style="float:right;" class="btn btn-success btn-sm ml-4" type="submit" name="export" data-toggle="tooltip" data-placement="top" title="Export" ><i class="fa  fa-arrow-circle-down"></i></button>
                </form>
            </div>
            <form method="post" id="bydateRange" class="Filter" style="display:none" class="mx-auto mt-0">
                <div class="input-group mx-2">
                   <input class="datepicker" autocomplete="off" type="text" id="from" name="from"  placeholder="YYYY/mm/dd" style="width:160px !important;" required>
                   <div class="input-group-append">
                       <button class="bg-light btnBox btn-sm" type="button" style="padding:1px; height:30px;">From</button>
                   </div>
                   <input class="datepicker" autocomplete="off" type="text" id="to" name="to" placeholder="YYYY/mm/dd"  style="width:160px !important;" required>
                  <div class="input-group-append">
                       <button class="bg-light btnBox btn-sm" type="button" style="padding:1px; height:30px;">To</button>
                  </div>
                  <!-- <select class="form-control" type="text" name="category" id="category" style="width:250px;" >
                    <option disabled selected>Select Category</option>
                    <php echo prodCat() ?>
                  </select> -->
                    <input class="btn btn-success btn-sm btnBox" id="submitBtn" type="button" value="Go">
              </div>
          </form>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover small" width="100%">
                  <thead>
                    <tr class="small">
                      <!-- <th width="5%">s/n</th> -->
                      <th width="30%">Item Name</th>
                      <th width="40%">Item Description</th>
                      <th width="10%">ID</th>
                      <!-- <th width="5%">old value</th> -->
                      <th width="5%">stock</th>
                      <th width="5%">Qnt </th>
                      <th width="5%">Units </th>
                      <th width="5%">request by </th>
                      <th width="5%">approved by </th>
                      <th width="5%">received by </th>
                      <th width="5%">dept </th>
                      <th width="5%">unit </th>
                      <th width="5%">store </th>
                      <th width="5%">remark </th>
                      <th width="5%">date </th>
                      <th width="5%">Waybill </th>
                    </tr>
                  </thead>
                  <tbody>
                <?php $n=0; foreach($data['sr_in'] as $row) :?>
                   <tr class="small">
                   <td ><?php echo $row->name ?></td>
                   <td ><?php echo $row->dsc ?></td>
                   <td ><?php echo $row->batch ?></td>
                   <td ><?php echo ($row->old)?></td>
                   <td ><?php echo $row->quantity?></td>
                   <td ><?php echo $row->unit?></td>
                   <td ><?php echo $row->requestby?></td>
                   <td ><?php echo $row->aprovedby?></td>
                   <td ><?php echo $row->receivedby?></td>
                   <td ><?php echo $row->dept?></td>
                   <td ><?php echo $row->units?></td>
                   <td ><?php echo $row->store?></td>
                   <td ><?php echo $row->remark?></td>
                   <td ><?php echo $row->date?></td>
                   <td ><a href="<?php echo URLROOT?>/stores/waybill/<?php echo $row->wbi; ?>"><?php echo $row->wbi?></a></td>
                  <?php endforeach; ?>
                  </tbody>
                </table>
                </div>
          </div>
          </div>
      </div>

<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#filterByStore').click(function(){
      $('#bydateRange').toggle(500)
    });
  });
</script>
