<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  .table{
    font-size:10px;
    font-family: 'Open Sans', sans-serif;
  }
  tr >td{
    padding:1px !important;
  }
  li div a{
    font-size:10px !important;
  }
</style>
<div class="row">
    <div class="col-md-12 col-lg-12 mx-auto">
        <div class="card card-body  mt-3">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Company Management</div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" width="100%">
              <thead>
                <tr class="small">
                  <th width="3%">S/N</th>
                  <th width="17%">Company Name</th>
                  <th width="15%">Manager</th>
                  <th width="10%">GSM</th>
                  <th width="5%">Staff</th>
                  <th width="12%">Pay Per Meter</th>
                  <th width="8%">Pay Per Edat</th>
                  <th width="25%">Address</th>
                  <th ><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
              <?php $n=0;foreach($data['company'] as $row): ?>
                <tr>
                  <td class="text-center"><?php echo ++$n;?></td>
                  <td ><?php echo strtoupper($row->names)?></td>
                  <td ><?php echo strtolower($row->mail)?></td>
                  <td ><?php echo $row->gsm?></td>
                  <td class="text-center"><span class="badge badge-dark"> <?php echo countStaff($row->cmid) ?></span></td>
                  <td><?php echo $row->meter ?></td>
                  <td><?php echo $row->edat ?></td>
                  <td ><?php echo ucwords($row->address)?></td>
                  <td class="text-center"><a href="<?php echo URLROOT.'/users/edit/'.$row->cmid ?>" data-toggle="tooltip" data-placement="left" title="Edit Company's Info"><i class="fa fa-edit"></i><a></td>
                </tr>
              <?php endforeach;?>
            </tbody>
            </table>
          </div>
        </div>
    </div>
 </div>


<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){

  });
</script>
