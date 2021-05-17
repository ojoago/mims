<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  #wayBillForm{
    height: 460px;
    overflow-y: auto;
  overflow-x: hidden !important;
  }
</style>
<div class="card card-body mb-1">
  <h6 class="text-center text-upperr">WAYBILL</h6>
  <form action="<?php echo URLROOT;?>/Inventories/waybills" method="post" id="wayBillForm">
    <div class="row">
      <div class="col-md-6 col-lg-6">
          <div class="card card-body">
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
                    <textarea type="text" autocomplete="off" placeholder="Remark"  name= "remark" class="form-control form-control-sm "> </textarea>
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="form-group">
                    <label for="name">Category <sup class="text-danger red">*</sup></label>
                    <select type="text" name= "cat" class="form-control form-control-sm " >
                      <option disabled selected>select option</option>
                      <option <?php if($data['cat']=='SR-IN'){echo 'selected';} ?>  >SR-IN</option>
                      <option <?php if($data['cat']=='SR-CN'){echo 'selected';} ?>  >SR-CN</option>
                    </select>
                </div>
              </div>

              <div class="col-md-6 col-lg-6 col-xl-6">
                  <label for="name">Store: <sup class="text-danger red">*</sup></label>
                <select type="text"  id="storeTo" name="to" placeholder="Management" class = "form-control form-control-sm select2 " >
                  <option disabled selected> Select store to</option>
                  <?php echo store(); ?>
                </select>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-6 col-lg-6">
          <div class="card card-body">
            <div class="row">
              <div class="col-md-9">
                <div class = "form-group">
                  <div  id="items"></div>
                </div>
              </div>
              <div class="col-md-3">
                  <input type="button" id="wayBillBtn" value="Submit" class="btn btn-success btn-sm">
              </div>
              <div class="col-md-12">
                    <p id="formContent" ></p>
              </div>
            </div>
          </div>
      </div>

    </div>
  </form>
</div>
<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#model').change(function(){
      var id = $(this).val();
      $.ajax({
        url:"<?php echo URLROOT?>/inventories/getDsc",
        type:"POST",
        // dataType:"JSON",
        data:{id:id},
        success:function(data){
          // alert(data);
            $('#dsc').val(data.dsc+' -> '+data.name + ' quantity remaining ' +data.qnt);
        }
      });
    });
  });
</script>
