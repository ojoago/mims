<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<style>
  .table{
    font-size:10px;
    font-family: 'Open Sans', sans-serif;
  }
</style>
<div class="row">
    <div class="col-md-4 col-lg-4 mx-auto">
        <div class="card card-body  mt-3">
         <div class="card-header"><i class="fas fa-table mr-1"></i>Company Details</div>

          <div class="table-responsive">
            <table class="table table-bordered table-stripe table-hover" id="" width="100%">
              <thead>
                <tr class="small">
                  <th width="5%">S/N</th>

                  <th width="20%">Company</th>

                </tr>
              </thead>
              <?php $n=0;foreach($data['company'] as $row): ?>
              <tbody>
                <tr>
                  <td><?php echo ++$n;?></td>
                  <td><?php echo ucwords($row->names)?></td>

                </tr>
              </tbody>
              <?php endforeach;?>
            </table>
          </div>

        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-xl-8">
      <div class="card card-body">

      </div>
    </div>
 </div>


<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){

  });
</script>
