<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  .table{
    /* font-size:10px; */
    font-family: 'Open Sans', sans-serif;
  }
</style>
<div class="row">
    <div class="col-md-12 col-lg-12 mx-auto">
      <div class="card">
        <div class="card-header">
        <input type="text" class="form-control form-control-sm" placeholder="Enter Account Number" id="searchByNumber" autofocus>
        </div>
        <div class="card card-body">
          <?php flash('register_success'); ?>
          <div class="table-responsive" id="listTable">
            <table class="table table-bordered table-stripe table-hover" width="100%">
              <thead>
                <tr class="small">
                  <th width="2%">S/N</th>
                  <th width="5%">Number</th>
                  <th width="15%">Names</th>
                  <th width="5%">GSM</th>
                  <th width="20%">Address</th>
                  <th width="7%">Feeder</th>
                  <th width="3%">TARIFF</th>
                  <th width="5%">Area</th>
                  <th width="10%">DT Name</th>
                  <th width="20%">CIN</th>
                  <th width="10%">DT CODE</th>
                </tr>
              </thead>
              <tbody>
            <?php $n=0; foreach($data as $row) :?>
              <tr>
                <td><?php echo ++$n; ?></td>
                <td> <a href="<?php echo URLROOT.'/meters/load/'.$row->id ?>"><?php echo $row->account_number ?></a>  <small><?php echo $row->status ?></small></td>
                <td><?php echo $row->fullname ?></td>
                <td><?php echo $row->gsm ?></td>
                <td><?php echo $row->address ?></td>
                <td><?php echo $row->feeder ?></td>
                <td><?php echo $row->tariff_code ?></td>
                <td><?php echo $row->area ?></td>
                <td><?php echo $row->dt_name ?></td>
                <td><?php echo $row->cin ?></td>
                <td><?php echo $row->transformer_number ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            </div>
      </div>
      </div>
    </div>
 </div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
  $(document).ready(function(){
    // dynamic search
    $('#searchByNumber').keyup(function(){
      var val = $(this).val();
      if(val !==''){
        $.ajax({
          url:"<?php echo URLROOT ?>/helpers/loadmodal.php",
          type:'POST',
          // dataType:'JSON',
          data:{findCustomerByNumber:true,num:val},
          success:function(data){
            $('#listTable').html(data);
          }
         })
      }else{
        $('#result').html('');
      }
    });
});
</script>
