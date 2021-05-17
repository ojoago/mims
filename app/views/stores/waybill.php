<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  #itemaAdded{
    height: 460px;
    overflow-y: auto;
    overflow-x: hidden !important;
  }
  #itemBody{
    max-height: 480px;
    overflow-y: auto;
    overflow-x: hidden !important;
  }
</style>
<div class="card card-body mb-1">
  <h6 class="text-center text-upperr">WAYBILL</h6>
  <form action="<?php echo URLROOT;?>/Inventories/waybills" method="post" id="wayBillForm">
    <div class="row">
      <div class="col-md-7 col-lg-7">
          <div class="card card-body">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                    <label for="name">Category <sup class="text-danger red">*</sup></label>
                    <select type="text" name= "cat" id="category" class="form-control form-control-sm " >
                      <option disabled selected>select option</option>
                      <option >SR-IN</option>
                      <option >SR-CN</option>
                    </select>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group" id="baseStore">
                  <label for="name">Store: <sup class="text-danger red">*</sup></label>
                  <select type="text"  id="fromStore" name="from" class = "form-control form-control-sm select2 " >
                    <option disabled selected> Select store</option>
                    <?php echo store(); ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="" id="itemBody"> </div>
          </div>
      </div>

      <div class="col-md-6 col-lg-5" id="itemaAdded">
        <fieldset class="border p-1">
            <legend class="w-auto small"> <input type="button" id="continueBtn" value="Continue" class="btn btn-warning btn-xs"></legend>
            <div class="row">
              <div class="col-md-12">
                    <p id="formContent" >
                      <i class="fa fa-truck fa-3x"></i>
                    </p>
              </div>
            </div>
        </fieldset>

      </div>
    </div>
  </form>
</div>
<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#category').change(function(){
      if($(this).val().toUpperCase()=='SR-IN'){
        $('#baseStore').hide();
        // load general items
        $.ajax({
          url:"<?php echo URLROOT?>/functions/loadmodal.php",
          type:"POST",
          data:{loadAllStoreItemsSrIN:true},
          success:function(data){
            loadItemAdded()
            $('#itemBody').html(data);
          }
        });
      }else{
        $('#itemBody').html('');
        $('#baseStore').show();
      }
    });
    $('#fromStore').change(function(){
      var id=$(this).val();
      if($('#category').val().toUpperCase()=='SR-CN'){
        $.ajax({
          url:"<?php echo URLROOT?>/functions/loadmodal.php",
          type:"POST",
          data:{loadAllStoreItemOnSrCN:true,id:id},
          success:function(data){
            loadItemAdded()
            $('#itemBody').html(data);
          }
        });
      }else{

      }
    });
    $(document).on('click','.addToTransfer',function(){
      var id=$(this).attr('id');
      var cat=$('#category').val();
      $.ajax({
        url:"<?php echo URLROOT?>/stores/loadItem",
        type:"POST",
        data:{loadSRINItemDetails:true,id:id,cat:cat},
        success:function(data){
          loadItemAdded()
        }
      });
    });
    $(document).on('click','.removeItem',function(){
      var id=$(this).attr('id')
      $.ajax({
        url:"<?php echo URLROOT?>/stores/loadItem",
        type:"POST",
        data:{removeItem:true,id:id},
        success:function(data){
          loadItemAdded()
        }
      });
    });
    $(document).on('change','.itemQnt',function(){
      var id =$(this).attr('id');
      var qnt =$(this).val();
      $.ajax({
        url:"<?php echo URLROOT?>/stores/loadItem",
        type:"POST",
        data:{updateQnt:true,id:id,qnt:qnt},
        success:function(data){
          loadItemAdded()
        }
      });
    });
    $(document).on('change','.itemComment',function(){
      var id =$(this).attr('id');
      var txt =$(this).val();
      $.ajax({
        url:"<?php echo URLROOT?>/stores/loadItem",
        type:"POST",
        data:{addComment:true,id:id,txt:txt},
        success:function(data){
          loadItemAdded()
        }
      });
    });
    loadItemAdded();
    function loadItemAdded(){
      $.ajax({
        url:"<?php echo URLROOT?>/stores/loadItem",
        type:"POST",
        data:{loadItemAdded:true},
        success:function(data){
          $('#formContent').html(data);
        }
      });
    }
    $('#submitWayBillBtn').click(function(){
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT?>/stores/loadItem",
        type:"POST",
        data:{processData:true},
        success:function(data){
          $('#formContent').html(data);
          $('.loader').hide();
        }
      });
    });
    $('#continueBtn').click(function(){
      $('#wayBillModal').modal('show');
    });
    $('#genWayBillFormBtn').click(function(){
      var cat=$('#category').val();
      var from =$('#fromStore').val();//Source
      var form = $('#genWayBillForm');//form submit
      $.ajax({
         url:"<?php echo URLROOT ?>/stores/loadItem",
         type:'POST',
         data:{processWayBill:true,type:cat,from:from,form:form.serialize()},
         dataType:"JSON",
         success:function(data){
           console.log(data);
           if(data.error==''){
             location.href="<?php echo URLROOT ?>/stores/waybill/"+data.id;
           }else{
             $('#waybillMsg').html(data.error);
           }
         }
       })
    });
  });
</script>
<!-- /// -->
<div class="modal fade" id="wayBillModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">WAYBILL INFORMATION</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" id="genWayBillForm">
        <div id="waybillMsg"></div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label for="name">Request By <sup class="text-danger red">*</sup></label>
                <input type="text" name= "rqs" autocomplete="off" class="form-control form-control-sm " placeholder="Request By" >
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label for="name">Approved By <sup class="text-danger red">*</sup></label>
                <input type="text" name= "apv" autocomplete="off" class="form-control form-control-sm " placeholder="Approved By">
            </div>
          </div>

          <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label for="name">Receiver <sup class="text-danger red">*</sup></label>
                <input type="text" name= "rcb" autocomplete="off" class="form-control form-control-sm " placeholder="Receiver's name" >
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label for="name">Department <sup class="text-danger red">*</sup></label>
                <input type="text" name= "dept" autocomplete="off" class="form-control form-control-sm " placeholder="Department">
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label for="name">Unit <sup class="text-danger red">*</sup></label>
                <input type="text" name= "unit" autocomplete="off" class="form-control form-control-sm " placeholder="Unit">
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label for="name">Date: <sup class="text-danger red">*</sup></label>
                <input type="date" placeholder="date" name= "date" class="form-control form-control-sm " >
            </div>
          </div>
          <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="form-group">
                <label for="name">Remark: </label>
                <textarea type="text" autocomplete="off" placeholder="Remark"  name= "remark" class="form-control form-control-sm "></textarea>
            </div>
          </div>

          <div class="col-md-12">
              <label for="name">Store: <sup class="text-danger red">*</sup></label>
            <select type="text"  id="toStore" name="to" class = "form-control form-control-sm select2 " style="width:100%" >
              <option disabled selected> Select store to</option>
              <?php echo store(); ?>
            </select>
          </div>
        </div>
      </div>
    </form>
      <div class="modal-footer">
					<button type="button" class="btn btn-success" id="genWayBillFormBtn">Submit</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
