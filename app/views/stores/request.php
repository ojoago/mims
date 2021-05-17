<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  #wayBillForm{
    height: 460px;
    overflow-y: auto;
  overflow-x: hidden !important;
  }
  .itemComment{
    display: none;
  }
</style>
<div class="card card-body mb-1">
  <h6 class="text-center text-upperr">ITEM REQUEST</h6>
  <form action="<?php echo URLROOT;?>/Inventories/waybills" method="post" id="wayBillForm">
    <div class="row">
      <div class="col-md-7 col-lg-7">
          <div class="card card-body">
                <div class="form-group" id="baseStore">
                  <select type="text"  id="fromStore" name="from" class = "form-control form-control-sm select2 " >
                    <option disabled selected> Select store from</option>
                    <?php echo store(); ?>
                  </select>
                </div>
                <p id="alertMsg"></p>
            <div class="" id="itemBody"> </div>
          </div>
      </div>

      <div class="col-md-6 col-lg-5">
        <fieldset class="border p-1">
            <legend class="w-auto small"> <input type="button" id="continueBtn" value="Continue" class="btn btn-warning btn-sm"></legend>
            <div class="row">
              <div class="col-md-12">
                    <p id="formContent" >
                      <i class="fa fa-truck fa-4x"></i>
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
    $('#fromStore').change(function(){
      var id=$(this).val();
        $.ajax({
          url:"<?php echo URLROOT?>/functions/loadmodal.php",
          type:"POST",
          data:{loadAllStoreItemOnSrCN:true,id:id},
          success:function(data){
            loadItemAdded()
            $('#itemBody').html(data);
          }
        });
    });
    $(document).on('click','.addToTransfer',function(){
      var id=$(this).attr('id')
      $.ajax({
        url:"<?php echo URLROOT?>/stores/loadItem",
        type:"POST",
        data:{loadSRINItemDetails:true,id:id},
        success:function(data){
          $('#alertMsg').html(data)
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
          $('#alertMsg').html(data)
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
      var from =$('#fromStore').val();//Source
      var form = $('#genWayBillForm');//form submit
      if(from != null){
        $.ajax({
           url:"<?php echo URLROOT ?>/stores/processRequest",
           type:'POST',
           data:{userItemRequest:true,store:from,form:form.serialize()},
           dataType:"JSON",
           success:function(data){
             if(data.error==''){
               location.href="<?php echo URLROOT ?>/stores/myrequest/"+data.id;
             }else{
               $('#alertMsg').html(data.error);
             }
           }
         })
      }else{
        alert('select source store');
      }
    });
  });
</script>
<!-- /// -->
<div class="modal fade" id="wayBillModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ITEM REQUEST</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" id="genWayBillForm">
        <div id="waybillMsg"></div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="form-group">
                <label for="name">Remark: </label>
                <textarea type="text" autocomplete="off" placeholder="Remark"  name= "remark" class="form-control form-control-sm "></textarea>
            </div>
          </div>
          <div class="col-md-12">
              <label for="name">Receiver: <sup class="text-danger red">*</sup></label>
            <select type="text"  id="toStore" name="to" class = "form-control form-control-sm select2 " style="width:100%" >
              <option disabled selected>Select Receiver</option>
              <?php echo asign(); ?>
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
