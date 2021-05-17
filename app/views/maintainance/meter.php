<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<div class="row">
    <div class="col-md-4 mx-auto">
        <div class="card card-body  mt-3">
        <?php if ($data): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover small" width="100%">
              <thead>
                <tr class="small">
                  <th width="2%">s/n</th>
                  <th width="2%">meter</th>
                  <th width="2%">status</th>
                  <th width="2%">Installer</th>
                </tr>
              </thead>
              <tbody>
            <?php $n=0; foreach($data as $row) :?>
              <tr class="getDatials pointer" id="<?php echo $row->did; ?>">
                <td><?php echo ++$n; ?></td>
                <td><?php echo $row->meter_no; ?></td>
                <td><?php echo $row->status; ?></td>
                <td><?php echo $row->uid; ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            </div>
          <?php else: ?>
            Empty
        <?php endif; ?>
      </div>
    </div>
	<div class="col-md-8">
    <div class="card card-body  mt-3">
      <div class="" id ="details">

      </div>
    </div>
  </div>
 </div>


<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script type="text/javascript">
  $(document).ready(function(){
    $('.getDatials').click(function(){
      var id = $(this).attr('id');
      $.ajax({
        url:"<?php echo URLROOT?>/helpers/loadmodal.php",
        type:"POST",
        dataType:"JSON",
        data:{fualtyMeterDetails:true,id:id},
        success:function(data){
          // alert(data);
            $('#details').html(data.table);
        }
      });
    });
  });
</script>
