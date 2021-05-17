<?php
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  if(isset($_POST['export'])){
    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1','S/N');
    $active_sheet->setCellValue('B1','Item Name');
    $active_sheet->setCellValue('C1','Item Description');
    $active_sheet->setCellValue('D1','Unique ID');
    $active_sheet->setCellValue('E1','Quantity');
    $active_sheet->setCellValue('F1','Units');
    $active_sheet->setCellValue('G1','Store');
    $k=2; $n=0;
    foreach($data['item'] as $cell){
      $active_sheet->setCellValue('A'.$k,++$n);
      $active_sheet->setCellValue('B'.$k,$cell->name);
      $active_sheet->setCellValue('C'.$k,$cell->dsc);
      $active_sheet->setCellValue('D'.$k,$cell->batch);
      $active_sheet->setCellValue('E'.$k,$cell->qnt);
      $active_sheet->setCellValue('F'.$k,$cell->unit);
      $active_sheet->setCellValue('G'.$k,$cell->store);
      $k++;
    }

    $path= 'inventory-'.rand(9,999).'.xlsx';
    $writer = new Xlsx($file);
    $writer->save($path);
    if(extension_loaded('zip')){
      $zip = new ZipArchive();
      $zipName = "inventory-".rand(1,1000).".zip";
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
<style media="screen">
  #formContent{
    max-height: 310px;
    overflow-y: auto;
    overflow-x: hidden;
  }
</style>
<div class="card">
  <div class="card-header">
    <form method="post" style="margin:0;" class="mx-auto mt-0">
      <i class="fas fa-table mr-1"></i>Inventories
      <a href="<?php echo URLROOT ?>/stores"  type="button" data-toggle="tooltip" data-placement="top" title="Refresh"><button class="btn btn-danger btn-sm ml-4"><i class="fa  fa-spinner fa-spin"></i></button> </a>
      <!-- <button style="float:right;" class="btn btn-info btn-sm ml-4" type="button" id="filterByStore" data-toggle="tooltip" data-placement="top" title="filter by date" ><i class="fa  fa-filter"></i></button> -->
      <button style="float:right;" class="btn btn-success btn-sm ml-4" type="submit" name="export" data-toggle="tooltip" data-placement="top" title="Export" ><i class="fa  fa-arrow-circle-down"></i></button>
      <button type="button" class="btn btn-sm btn-info" id="createItemBtn" data-toggle="tooltip" data-placement="top" title="Create new item "><i class="fa  fa-pencil-alt "></i></button>
      <!-- <button style="float:right;" class="btn btn-primary btn-xs ml-4" type="button" data-toggle="tooltip" id="transfer" data-placement="top" title="Transfer" ><i class="fa fa-forward"></i></button> -->
      <button style="float:right;" class="btn btn-primary btn-xs" type="button" data-toggle="tooltip" id="createStore" data-placement="top" title="Create Store" ><i class="fa fa-plus"></i></button>
    </form>
  </div>
  <div class="card card-body p-1">
    <div class="row">
      <div class="col-md-4">
        <fieldset class="border p-1">
            <legend class="w-auto small"><i class="fa fa-home mr-1"></i>Stores </legend>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover small">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>address</th>
                    <th>Items</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $n=0; foreach($data['store'] as $row): ?>
                    <tr>
                      <td><?php echo ++$n ?></td>
                      <td><a href="<?php echo URLROOT.'/stores/index/'.$row->id ?>"><?php echo $row->name ?></a></td>
                      <td><?php echo $row->location ?></td>
                      <td> <?php echo $row->count ?></td>
                      <td> <i class="fa fa-edit pointer editStore" id = "<?php echo $row->id ?>"></i> </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
        </fieldset>
      </div>
      <div class="col-md-8">
        <fieldset class="border p-1">
            <legend class="w-auto small"><i class="fa fa-home mr-1"></i> <b class="text-primary mr-1"><?php echo $data['storeName'] ?></b> </legend>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover small" id="" width="100%">
                <thead>
                  <tr class="small">
                    <th width="5%">#</th>
                    <th width="30%">Item Name</th>
                    <th width="40%">Item Description</th>
                    <th width="10%">Unique Id</th>
                    <th width="5%">Quantity</th>
                    <th width="5%">Unit </th>
                    <th width="5%">Store </th>
                  </tr>
                </thead>
                <tbody>
              <?php $n=0; foreach($data['item'] as $row) :?>
                 <tr class="small" >
                 <td><?php echo ++$n?></td>
                 <td ><?php echo $row->name ?></td>
                 <td ><?php echo $row->dsc ?></td>
                 <td ><?php echo $row->batch ?></td>
                 <td ><?php echo $row->qnt?></td>
                 <td ><?php echo $row->unit?></td>
                 <td ><?php echo $row->store?></td>
               <?php endforeach; ?>
                </tbody>
              </table>
              </div>
        </fieldset>
      </div>
    </div>
  </div>
  <div class="card card-footer">

  </div>
</div>

<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script>
  $(document).ready(function(){
    $('#createStore').click(function(){
      $('#createStoreModal').modal('show');
    });
    $('#createStoreBtn').click(function(){
      var form = $('#createStoreFrom');
      $.ajax({
         url:"<?php echo URLROOT ?>/stores/create",
         type:'POST',
         data:{createStore:true,form:form.serialize()},
         dataType:"JSON",
         success:function(data){
           if(data.msg=='Store Created'){
             $('#createStoreFrom')[0].reset();
             swal(data.msg);
             location.reload();
           }else if(data.msg=='Store Updated'){
             $('#createStoreFrom')[0].reset();
             $('#createStoreModal').modal('show');
             swal(data.msg);
           }else {
             $('#createStoreMsg').html(data.error);
           }
         }
       })
    });
    $('#transfer').click(function(){
      $('#transferModal').modal('show');
    });
    $('#createItemBtn').click(function(){
      $('#createItemModal').modal('show');
    });
    $('#allStore').change(function(){
      var id=$(this).val();
      $.ajax({
        url:"<?php echo URLROOT?>/helpers/dropdown.php",
        type:"POST",
        dataType:"json",
        data:{loaditems:true,id:id},
        success:function(data){
          $('#items').html(data.items);
          $('#formContent').html('');
        }
      });
    });
    $('#storeTo').change(function(){
      var id=$(this).val();
      $('#storeId').val(id);
    });
    // $(document).on('change','#displayedItems',function(){
    //   var id = $(this).val();
    //   $.ajax({
    //       url:"<php echo URLROOT?>/Inventories/loadItem",
    //       type:"POST",
    //       dataType:'json',
    //       data:{loadItemDetails:true,id:id},
    //       success:function(data){
    //         $('#formContent').append(data.item);
    //       }
    //   });
    // });
    $(document).on('click','.remove',function(){
      var id=$(this).attr('id');
      $('#row'+id).remove();
    });
    $('#transferBtn').click(function(){
      var form=$('#transferFrom');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT?>/inventories/transfer",
        type:"POST",
        data:{transferItems:true,form:form.serialize()},
        dataType:"JSON",
        success:function(data){
            $('.loader').hide();
            if(data.error==''){
              location.href="<?php echo URLROOT;?>/inventories/printWaybill/"+data.id;
            }else{
              $('#alertMsg').text(data.error);
              $('#alertMsg').show(100);
            }
        }
      });
    });

    // view particular store items
    $('#filterByStore').change(function(){
      var id= $(this).val();
      location.href="<?php echo URLROOT;?>/inventories/index/"+id;
    });
    $('.editStore').click(function(){
      var id=$(this).attr('id');
      $.ajax({
         url:"<?php echo URLROOT ?>/stores/create",
         type:'POST',
         data:{editStore:true,id:id},
         success:function(data){
           $('#store').val(data.name)
           $('#sid').val(data.id)
           $('#adr').val(data.location)
           $('#manager').val(data.manager_id).trigger('change');
           $('#createStoreModal').modal('show');
         }
       })
    });
    // create item foot print
    $('#itemCreateBtn').click(function(){
      var form=$('#createItemForm');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT?>/stores/create",
        type:"POST",
        data:{createNewItem:true,form:form.serialize()},
        // dataType:"JSON",
        success:function(data){
            $('.loader').hide();
            if(data.error==''){
              location.reload();
            }else{
              // alert(data)
              $('#alertMsg').text(data.error);
              $('#alertMsg').show(100);
            }
        }
      });
    });
  });
</script>

<div class="modal fade" id="createItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Create Item Instance </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="createItemForm" method="post">
              <div class="form-group">
                  <!-- <label for="name">Item Name: <sup class="text-danger red">*</sup></label> -->
                  <input type="text" placeholder="item name" name= "brand" autocomplete="off" class="form-control form-control-sm " >
              </div>
              <div class="form-group">
                  <!-- <label for="name"> ID: <sup class="text-danger red">*</sup></label> -->
                  <input type="text" placeholder="Unique ID"name= "batch" autocomplete="off" class="form-control form-control-sm">
              </div>
              <div class="form-group">
                  <!-- <label for="name">Unit <sup class="text-danger red">*</sup></label> -->
                  <select type="text" placeholder="Unit" name= "unit" class="form-control form-control-sm">
                    <option disabled selected>Item UNIT</option>
                    <option>pcs</option>
                    <option>meters</option>
                    <option>cartoon</option>
                    <option>parket</option>
                  </select>
              </div>
          <div class="form-group">
              <!-- <label for="name">Product Description: <sup class="text-danger red">*</sup></label> -->
              <textarea type="text" placeholder="item description" autocomplete="off" placeholder="Item Description" name= "dsc" class="form-control"></textarea>
          </div>
            <!-- <div class="form-group">
              <select type="text" name="store" placeholder="Management" class = "form-control form-control-sm select2" style="width:100%">
                <option disabled selected> Select store</option>
                <php echo store(); ?>
              </select>
            </div> -->
        </form>
      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" id="itemCreateBtn"><i class="fa fa-plus"></i> Create</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="createStoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Create Store </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="createStoreMsg"></div>
      <div class="modal-body">
        <form class="form-group" method="post" id="createStoreFrom">
          <div class="form-group input-group">
          <i class=" fas fa-home bg-primary text-light p-2 input-group-append"></i>
            <input type = "hidden" name = "sid" id="sid">
            <input type = "text" name = "store" id="store" placeholder="store Name" class = "form-control input-sm"  required>
          </div>
          <div class="form-group input-group">
          <i class=" fas fa-location-arrow bg-primary text-light p-2 input-group-append pt-4"></i>
            <textarea type = "text" name = "address" id="adr" placeholder="store loaction" class = "form-control input-sm"  required></textarea>
          </div>
          <div class="form-group">
          <select type="text" name="manager" id="manager" placeholder="Management" class = "form-control form-control-sm select2" style="width:100%;">
            <option disabled selected> Select store Manager</option>
            <?php echo asign(); ?>
          </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" id="createStoreBtn"><i class="fa fa-plus"></i> Submit</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<!-- transfer to and fro store -->
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Transfer Items </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-dismissible alert-danger p-1 text-center" role ="alert" id="alertMsg" style="display:none;texr-align:center !important;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>
          <form class="form-group" method="post" id="transferFrom" width="100%">
            <div class="row">
              <div class="col-md-4 col-lg-4">
                <div class="card card-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name">Request By <sup class="text-danger red">*</sup></label>
                          <input type="text" name= "rqs" placeholder="Request By" autocomplete="off" class="form-control form-control-sm " >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name">Approved By <sup class="text-danger red">*</sup></label>
                          <input type="text" name= "apv" placeholder="Approved By" autocomplete="off" class="form-control form-control-sm " >
                          <!-- <select  type="text" name= "apv" placeholder="Approved By" autocomplete="off" class="form-control form-control-sm select2" style="width:100%;" >
                            <php echo asign(); ?>
                          </select> -->
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name">Receiver <sup class="text-danger red">*</sup></label>
                          <input type="text" name= "rcb" placeholder="Received By" autocomplete="off" class="form-control form-control-sm " >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">Unit <sup class="text-danger red">*</sup></label>
                          <input type="text" name= "unit" placeholder="unit" autocomplete="off" class="form-control form-control-sm " >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">Department <sup class="text-danger red">*</sup></label>
                          <input type="text" name= "dept" placeholder="Department" autocomplete="off" class="form-control form-control-sm " >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">Date<sup class="text-danger red">*</sup></label>
                          <input type="date" name= "date" placeholder="Received By" autocomplete="off" class="form-control form-control-sm " >
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                          <textarea type="text" name= "remark" placeholder="remark" class="form-control form-control-sm " ></textarea>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <label for="name">Store <sup class="text-danger red">*</sup></label>
                      <select type="text" style="width:100%;" id="allStore" name="from" placeholder="Management" class = "form-control form-control-sm select2" >
                        <option disabled selected> Select store</option>
                        <?php echo store(); ?>
                      </select>
                    </div>
                    <hr>
                </div>
                </div>
              </div>
              <div class="col-md-8 col-lg-8">
                <div class="card card-body">
                  <div class="row">
                    <div class="col-md-6" id="items"> </div>
                    <div class="col-md-6">
                      <select type="text" style="width:100%;" name="to" placeholder="Management" class = "form-control form-control-sm select2" >
                        <option disabled selected> Select store to</option>
                        <?php echo store(); ?>
                      </select>
                      <hr>
                    </div>
                  <div class="col-md-12">
                    <input type="hidden" name = "storeid" id="storeId">
                    <p id="formContent" ></p>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" id="transferBtn"><i class="fa fa-plus"></i> Submit</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
