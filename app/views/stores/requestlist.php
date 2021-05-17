<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  #wayBillForm{
    height: 460px;
    overflow-y: auto;
  overflow-x: hidden !important;
  }
</style>
<div class="card card-body mb-1">
  <form action="<?php echo URLROOT;?>/Inventories/waybills" method="post" id="wayBillForm">
    <div class="row">
      <div class="col-md-7">
        <div class="card card-body">
          <h6 class="text-center text-upperr">ITEM REQUEST</h6>
            <div class="table table-responsive">
              <table class="table table-striped table-bordered table-hover small">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Request ID</th>
                    <th>Requested By</th>
                    <th>Receiver</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                    <?php $i=0; foreach($data['list'] as $row): ?>
                      <tr>
                        <td><?php echo ++$i; ?></td>
                        <?php if($row->status!='TREATED'): ?>
                          <td>
                            <a href="<?php echo URLROOT .'/stores/requestlist/'.$row->rid;?>"><?php echo trimSTR($row->rid,6); ?></a>
                            <i class ="fa  fa-check-square text-info pointer aprovedRequest" id="<?php echo $row->rid ?>" title="<?php echo $row->rid; ?>" data-toggle="tooltip" data-placement="right"></i>
                          </td>
                        <?php else: ?>
                          <td><a href="<?php echo URLROOT .'/stores/requestlist/'.$row->rid;?>"><?php echo $row->rid; ?></a> </td>
                        <?php endif; ?>
                        <td><?php echo decodeHtmlEntity(getUsername($row->request_by)); ?></td>
                        <td><?php echo decodeHtmlEntity($row->uid); ?></td>
                        <td><?php echo $row->store; ?></td>
                        <td><?php echo $row->status; ?></td>
                        <td><?php echo $row->date; ?></td>
                      </tr>
                    <?php endforeach; ?>
                </tbody>
              </table>
            </div>
        </div>
      </div>

      <div class="col-md-5">
        <fieldset class="border p-1">
            <legend class="w-auto small"> Details</legend>
            <p id="alertMsg"></p>
            <div class="row">
              <div class="col-md-12">
                <div class="table table-responsive">
                  <table class="table table-striped table-bordered table-hover small">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Item Name</th>
                        <th>Destination</th>
                        <th>QNT</th>
                      </tr>
                    </thead>
                    <?php if(isset($data['deatils'])): ?>
                      <tbody>
                          <?php $i=0; foreach($data['deatils'] as $row): ?>
                            <tr>
                              <td><?php echo ++$i; ?></td>
                              <td><?php echo $row->name; ?></td>
                              <td><?php echo $row->dsc; ?></td>
                              <td><?php echo $row->qnt; ?></td>
                            </tr>
                          <?php endforeach; ?>
                      </tbody>
                    <?php endif; ?>
                  </table>
                </div>
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
    $('.aprovedRequest').click(function(){
      var id=$(this).attr('id');
      $('.loader').show()
      $.ajax({
         url:"<?php echo URLROOT ?>/stores/processRequest",
         type:'POST',
         data:{approveRequest:true,id:id},
         dataType:"JSON",
         success:function(data){
           $('.loader').hide()
           if(data.error==''){
             location.href="<?php echo URLROOT ?>/stores/waybill/"+data.id;
           }else{
             $('#alertMsg').html(data.error);
           }
         }
       })
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
