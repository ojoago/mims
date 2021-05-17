<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<style media="screen">
  .content{
    max-height: 520px;
    overflow-y: auto;
  }
</style>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body  mt-3 content">
        <?php if($data['box']): ?>
          <!-- <input type="text" name="" class="form-control form-control-sm" value="" id="searchEdat" placeholder="Enter Edat Number or RF"> -->
          <div class="table-responsive" id="searchedEdatTable">
            <table class="table table-bordered table-striped table-hover small" width="100%">
              <thead>
                <tr class="small">
                  <th width="4%">S/N</th>
                  <th width="10%">Box</th>
                  <th width="3%">Tech</th>
                  <th width="35%">dt</th>
                  <th width="45%">Feeder</th>
                  <th width="5%">X</th>
                  <th width="5%">Y</th>
                  <th width="3%">#</th>
                </tr>
              </thead>
              <tbody>
            <?php $n=0; foreach($data['box'] as $row) :?>
              <tr >
                <td><?php echo ++$n; ?></td>
                <td><a href="<?php echo URLROOT.'/maintainance/box/'; echo !empty($row->box) ? $row->box : '' ?>"><?php echo !empty($row->box) ? $row->box : ''; ?></a> </td>
                <td><?php echo $row->tech; ?></td>
                <td><?php echo $row->dt; ?></td>
                <td><?php echo $row->feeder; ?></td>
                <td><?php echo $row->m_x; ?></td>
                <td><?php echo $row->m_y; ?></td>
                <td><?php echo $row->count; ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            </div>
          <?php else: ?>
            <h4>No Meter Box record found</h4>
        <?php endif; ?>
      </div>
    </div>
	<div class="col-md-6">
    <div class="card card-body  mt-3 content">
      <!-- <input type="text" name="" class="form-control form-control-sm" value="" id="searchMeterOnBox" placeholder="Enter Meter Number or Dt Name"> -->
      <div class="table-responsive" id="searchedMeterTable">
    <?php if(@$data['metersOnBox']): ?>
        <table class="table table-bordered table-striped table-hover small" width="100%">
          <thead>
            <tr class="small">
              <th width="3%">S/N</th>
              <th width="50%">Names</th>
              <th width="22%">Meter Number</th>
              <th width="7%">Tech</th>
              <th width="18%">Date</th>
            </tr>
          </thead>
          <tbody>
        <?php $n=0; foreach($data['metersOnBox'] as $row) :?>
          <tr >
            <td><?php echo ++$n; ?></td>
            <td><?php echo $row->accountname; ?></td>
            <td><?php echo $row->meternum; ?> <small class="text-info"><?php echo $row->rf ?></small>  </td>
            <td><?php echo strtoupper($row->tech); ?></td>
            <td><?php echo $row->doi; ?></td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
    <?php endif; ?>
  </div>
  </div>
  </div>
 </div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#searchMeter').keyup(function(){
      var txt = $(this).val();
      if(txt!=''){
        $.ajax({
          url:"<?php echo URLROOT?>/helpers/loadmodal.php",
          type:"POST",
          data:{searchMeterForPair:true,txt:txt},
          success:function(data){
            $('#searchedMeterTable').html(data);
          }
        });
      }else{}
    });
    $('#searchEdat').keyup(function(){
      var txt = $(this).val();
      if(txt!=''){
        $.ajax({
          url:"<?php echo URLROOT?>/helpers/loadmodal.php",
          type:"POST",
          data:{searchEdatForPair:true,txt:txt},
          success:function(data){
            $('#searchedEdatTable').html(data);
          }
        });
      }else{}
    });


  });
</script>
