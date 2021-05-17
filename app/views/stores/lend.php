<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<style media="screen">
  #formContent{
    max-height: 310px;
    overflow-y: auto;
    overflow-x: hidden;
  }
</style>
<div class="row">
<div class="col-md-8">
  <div class="card">
  <div class="card-header"><i class="fas fa-table mr-1"></i>Inventory
    <button style="float:right;" class="btn btn-primary btn-xs ml-4" type="button" data-toggle="tooltip" id="transfer" data-placement="top" title="Lend Item" ><i class="fa fa-forward"></i></button>
    <button style="float:right;" class="btn btn-primary btn-xs" type="button" data-toggle="tooltip" id="createStore" data-placement="top" title="return Lend Itmem" ><i class="fa fa-backward"></i></button>
  </div>
    <div class="card card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover" id="" width="100%">
            <thead>
              <tr>
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
          <?php $n=0; foreach($data as $row) :?>
             <tr  >
             <td><?php echo ++$n?></td>
             <td ><?php echo $row->name ?></td>
             <td ><?php echo $row->dsc ?></td>
             <td ><?php echo $row->batch ?></td>
             <td >
               <?php echo $row->qnt?>
               <input type="text" id="<?php echo $row->pid ?>" value="" class="form-control form-control-sm Lqnt">
             </td>
             <td ><?php echo $row->unit?></td>
             <td ><?php echo $row->store?></td>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header" id="lendMsg"><i class="fas fa-table mr-1"></i>
        </div>
        <div class="card-body">
          <div class="" id="viewItem">  </div>
        </div>
        <div class="card-footer"><button data-toggle="modal" data-target="#processLend" type="button" class="btn btn-primary btn-sm" id="lendOutBtn" style="display:none"> <i class="fas fa-dot-circle"></i> </button>
      </div>
    </div>
</div>
</div>
<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script>
  $(document).ready(function(){
    $('#createStore').click(function(){
      $('#createStoreModal').modal('show');
    });
    $('#transfer').click(function(){
      $('#transferModal').modal('show');
    });
    $('#storeTo').change(function(){
      var id=$(this).val();
      $('#storeId').val(id);
    });

    $(document).on('click','.remove',function(){
      var id=$(this).attr('id');
      $('#row'+id).remove();
    });

    $(document).on('change','.Lqnt',function(){
      var qnt =$(this).val();
      var id =$(this).attr('id');
      $.ajax({
         url:"<?php echo URLROOT ?>/stores/manageLend",
         type:'POST',
         data:{addItem:true,id:id,qnt:qnt},
         // dataType:"JSON",
         success:function(data){
            $('#lendMsg').html(data);
            loadAddedItem();
         }
       })
    });
    $(document).on('click','.removeItem',function(){
      var id=$(this).attr('id');
      $.ajax({
        url:"<?php echo URLROOT?>/stores/manageLend",
        type:"POST",
        data:{removeItem:true,id:id},
        success:function(data){
          $('#lendMsg').html(data);
          loadAddedItem();
        }
      });
    });
    loadAddedItem();
    function loadAddedItem(){
      $.ajax({
         url:"<?php echo URLROOT ?>/stores/manageLend",
         type:'POST',
         data:{loadItem:true},
         success:function(data){
            $('#viewItem').html(data);
            if(data!==''){
              $('#lendOutBtn').show();
            }else{
              $('#lendOutBtn').hide(600);
            }
         }
       });
    }
    $('#lendFromStoreBtn').click(function(){
      var form =$('#lendFrom');
      $.ajax({
        url:"<?php echo URLROOT?>/stores/manageLend",
        type:"POST",
        dataType:"JSON",
        data:{processLendFrom:true,from:form.serialize()},
        success:function(data){
          if(data.error==''){
            location.href="<?php echo URLROOT ?>/stores/lendlist/"+data.id;
          }else{
            $('#lendFormMsg').html(data.error);
          }
        }
      });
    });
    // view particular store items
    $('#filterByStore').change(function(){
      var id= $(this).val();
      location.href="<?php echo URLROOT;?>/inventories/index/"+id;
    });
  });
</script>
<div class="modal fade" id="processLend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Lend Out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <legend id="lendFormMsg"></legend>
        <form class="form-group" method="post" id="lendFrom">
          <label>Date of collection</label>
          <div class="form-group input-group">
          <i class=" fas fa-calendar bg-primary text-light p-2 input-group-append"></i>
            <input type = "date" name = "cdate" class = "form-control form-control-sm" >
          </div>
          <label>Date of returning</label>
          <div class="form-group input-group">
          <i class=" fas fa-calendar bg-primary text-light p-2 input-group-append"></i>
            <input type = "date" name = "rdate" class = "form-control form-control-sm" >
          </div>
          <label>Remarks</label>
          <div class="form-group input-group">
          <i class=" fas fa-keyboard bg-primary text-light p-2 input-group-append pt-4"></i>
            <textarea type = "text" name = "remark" placeholder="enter Remark" class = "form-control form-control-sm"  required></textarea>
          </div>
          <div class="form-group">
          <select type="text" name="clt" placeholder="Management" class = "form-control form-control-sm select2" style="width:100%;">
            <option disabled selected> Select Name</option>
            <?php echo asign(); ?>
          </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" id="lendFromStoreBtn"><i class="fa fa-plus"></i> Create</button>
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
                          <label for="name">Request By <sup class="text-danger red">*</sup></label>
                          <input type="text" name= "apv" placeholder="Approved By" autocomplete="off" class="form-control form-control-sm " >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name">Request By <sup class="text-danger red">*</sup></label>
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
