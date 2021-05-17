<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<style>
  .table{
    font-size:10px;
    font-family: 'Open Sans', sans-serif;
  }
</style>
<div class="row">
    <div class="col-md-12 col-lg-12 mx-auto">
        <div class="card card-body  mt-3">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Customers Details</div>
        <div class="table-responsive">
          <table class="table table-bordered table-stripe table-hover" id="" width="100%">
            <thead>
              <tr class="small">
                <th width="2%">S/N</th>
                <th width="5%">Acc Number</th>
                <th width="15%">Names</th>
                <th width="5%">gsm</th>
                <th width="15%">email</th>
                <th width="25%">address</th>
                <th width="7%">meter type</th>
                <th width="12%">Date</th>
                <th width="5%">Status</th>
                <th width="15%">Payment Date</th>
              </tr>
            </thead>
            <tbody>
          <?php $n=0; foreach($data['cust'] as $row) :?>
            <tr>
              <td><?php echo ++$n; ?></td>
              <td><?php echo $row->accountnumber ?></td>
              <td><?php echo $row->cust_names ?></td>
              <td><?php echo $row->gsm ?></td>
              <td><?php echo $row->email ?></td>
              <td><?php echo $row->address ?></td>
              <td><?php echo $row->meter_recomended ?></td>
              <td><?php echo $row->created_on ?></td>
              <td><?php echo 'Paid' ?></td>
              <td><?php echo $row->payment_date ?></td>
              <td>
                <i class="fa fa-edit editCustomer text-warning pointer" data-toggle="tooltip" data-placement="top" title="EDIT" id="'.$row->cid.'" ></i>
                <i class="fa fa-trash deleteCustomer text-danger pointer" data-toggle="tooltip" data-placement="top" title="DELETE" id="'.$row->cid.'" ></i>
              </td>
            </tr>
            <?php endforeach; ?>
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
