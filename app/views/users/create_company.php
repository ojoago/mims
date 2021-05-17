<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  .table{
    font-size:10px;
    font-family: 'Open Sans', sans-serif;
  }
</style>
    <div class="card">
      <div class="card-header"><i class="fas fa-table mr-1"></i>Create Company</div>
        <div class="card card-body  mt-3">
        <?php flash('register_success'); ?>
        <form action="<?php echo URLROOT;?>/users/create" method="post">
          <div class="row">
            <div class="col-md-6">
            <div class="form-group">
              <label for="name">Company Name: <sup class="text-danger red">*</sup></label>
              <input type="text" name= "name" placeholder ="Enter Company's Name" class="form-control form-control-sm <?php echo(!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo$data['name'];?>">
              <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
            </div>

            <div class="form-group">
                <label for="name">Manager: <sup class="text-danger red">*</sup></label>
                <select  name="mail" style="width:100%" class="form-control form-control-sm <?php echo(!empty($data['mail_err'])) ? 'is-invalid' : ''; ?> select2">
                  <option disabled selected>Select Company Manager</option>
                  <?php echo asign(@$data['edit']) ?>
                </select>
                <span class="invalid-feedback"><?php echo $data['mail_err']; ?></span>
            </div>
          </div>
            <div class="col-md-6">

          <div class="form-group">
              <!-- <label for="name">Address: <sup class="text-danger red">*</sup></label> -->
              <textarea type="text" name= "address" placeholder ="Enter Company's Address" class="form-control form-control <?php echo(!empty($data['address_err'])) ? 'is-invalid' : ''; ?>" ><?php echo$data['address'];?></textarea>
              <span class="invalid-feedback"><?php echo $data['address_err']; ?></span>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Payment Per Meter: <sup class="text-danger red">*</sup></label>
                <input type="text" name= "mpay" placeholder ="Enter Company Phone Number" class="form-control form-control-sm <?php echo(!empty($data['mpay_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo$data['mpay'];?>" >
                <span class="invalid-feedback"><?php echo $data['mpay_err']; ?></span>
            </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Payment per Edat: <sup class="text-danger red">*</sup></label>
                <input type="text" name= "epay" placeholder ="Enter Company Phone Number" class="form-control form-control-sm <?php echo(!empty($data['epay_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo$data['epay'];?>" >
                <span class="invalid-feedback"><?php echo $data['epay_err']; ?></span>
            </div>
            </div>
          </div>
            </div>
          </div>
          <div class="row">
              <div class="col">
                  <?php if(isset($data['edit'])): ?>
                    <input type="hidden" value="<?php echo $data['edit'] ?>" name="id">
                    <input type="submit" value="Edit" class="btn btn-warning btn-block">
                  <?php else: ?>
                    <input type="submit" value="Register" class="btn btn-success btn-block">
                  <?php endif; ?>
              </div>
          </div>
      </form>
        </div>
    </div>



<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){

  });
</script>
