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
        <?php if ($data['edats']): ?>
          <input type="text" name="" class="form-control form-control-sm" value="" id="searchEdat" placeholder="Enter Edat Number or RF">
          <div class="table-responsive" id="searchedEdatTable">
            <table class="table table-bordered table-striped table-hover small" width="100%">
              <thead>
                <tr class="small">
                  <th width="4%">S/N</th>
                  <th width="10%">Edat</th>
                  <th width="3%">RF</th>
                  <th width="35%">Edat Address</th>
                  <th width="45%">DT Name</th>
                  <th width="3%">#</th>
                </tr>
              </thead>
              <tbody>
            <?php $n=0; foreach($data['edats'] as $row) :?>
              <tr class="getDatials pointer" id="<?php echo $row->eid; ?>">
                <td><?php echo ++$n; ?></td>
                <td> <?php echo $row->edatnumber; ?></td>
                <td><?php echo $row->channel; ?></td>
                <td><?php echo $row->e_address; ?></td>
                <td><?php echo $row->dt_name; ?></td>
                <td><?php echo $row->count; ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            </div>
          <?php else: ?>
            <h4>No Edat Installed Yet</h4>
        <?php endif; ?>
      </div>
    </div>
	<div class="col-md-6">
    <div class="card card-body  mt-3 content">
    <?php if ($data['meters']): ?>
      <input type="text" name="" class="form-control form-control-sm" value="" id="searchMeter" placeholder="Enter Meter Number or Dt Name">
      <div class="table-responsive" id="searchedMeterTable">
        <table class="table table-bordered table-striped table-hover small" width="100%">
          <thead>
            <tr class="small">
              <th width="3%">S/N</th>
              <th width="12%">Meter</th>
              <th width="60%">DT</th>
              <th width="10%">X</th>
              <th width="10%">Y</th>
              <th width="5%"><i class="fa fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
        <?php $n=0; foreach($data['meters'] as $row) :?>
          <tr >
            <td><?php echo ++$n; ?></td>
            <td><?php echo $row->meternum; ?> <small class="text-info"><?php echo $row->rf ?></small> <?php echo $row->edatnumber ? '<small>'.$row->edatnumber.'</small>' : ''; ?> </td>
            <td><?php echo $row->dt; ?></td>
            <td><?php echo $row->m_x; ?></td>
            <td><?php echo $row->m_y; ?></td>
            <td>
              <div class="btn-group">
                <input type="checkbox" name="pair[]" value="<?php echo $row->mid ?>" <?php echo $row->edatnumber ? 'checked' : ''; ?>>
                <i class="fa fa-map-pin text-info ml-1 pointer pair" title="map to an Edat" data-toggle="tooltip" data-placement="left" id="<?php echo $row->mid ?>"></i>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      <?php else: ?>
        <h4>No Meter Installed Yet</h4>
    <?php endif; ?>
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
