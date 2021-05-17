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
          <a href="<?php echo URLROOT.@$data['baseUrl'] ?>">Home</a>
        <div class="card-header"><i class="fas fa-table mr-1"></i>
        <?php echo @$data['companyName'] ?> : <?php echo  @$data['msg']; ?>
          <?php if (@$data['cust'][0]->status=='not install'): ?>
            <input style="float:right !important;" type="button" id="toggleCheck" value="batch asign" class="btn btn-xs btn-success pull-right ml-auto">
            <input style="float:right !important; display:none;" type="button" id="batchAsignModel" value="batch" class="btn btn-xs btn-success pull-right ml-auto" data-toggle="modal" data-target="#asignedToInstaller" aria-expanded="false" aria-controls="pagesCollapseAuth">
          <?php endif; ?>
        </div>
        <div class="table-responsive">
          <?php flash('register_success'); ?>
          <table class="table table-bordered table-stripe table-hover" width="100%">
            <thead>
              <tr class="small">
                <th width="2%">S/N</th>
                <th width="5%">Number</th>
                <th width="15%">Names</th>
                <th width="5%">gsm</th>
                <th width="20%">address</th>
                <th width="15%">meter type</th>
                <th width="10%">Status</th>
                <th width="10%">Date</th>
                <th width="9%">Asign to</th>
                <th width="3%">Counts</th>
                <th width="3%"><i class="fa fa-cog"></i></th>
              </tr>
            </thead>
            <tbody>
          <?php $n=0; foreach($data['cust'] as $row) :?>
            <tr>
              <td><?php echo ++$n; ?></td>
              <td><?php echo $row->accountnumber ?></td>
              <td><?php echo $row->accountname ?></td>
              <td><?php echo $row->gsm ?></td>
              <td><?php echo $row->address ?></td>
              <td><?php echo $row->metertype ?></td>
              <td class="text-white <?php echo $row->status=='not install' ? 'bg-warning' : 'bg-success'  ?>"><?php echo $row->status ?></td>
              <td><?php echo date('Y-m-d',strtotime($row->created_on)) ?></td>
              <td><?php echo $row->uid ?></td>
              <td><?php echo $row->dayscount ?></td>
              <td>
                <?php if(strtoupper($row->status)=='INSTALLED'): ?>
                  <?php echo $row->comment; ?>
                <?php elseif(strtolower(($row->status)=='not install')): ?>
                    <i class="fa fa-unlink asignCustomer text-primary pointer" data-toggle="tooltip" data-placement="top" title="Asign" id="<?=$row->id ?>" ></i>
                    <i class="fa fa-forward installCustomer text-success pointer" data-toggle="tooltip" data-placement="top" title="Install" id="<?=$row->id ?>" ></i>
                      <div class="form-check">
                        <input class="form-check-input batchAsign" type="checkbox" value="<?=$row->id ?>" name ="batchAsign" id="id<?=$row->id ?>" style="display:none">
                  </form>
                <?php endif; ?>
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
    $('.installCustomer').click(function(){
      var id = $(this).attr('id');
      window.location="<?php echo URLROOT;?>/meters/install/"+id;
    });
    $('.asignCustomer').click(function(){
      var id =$(this).attr('id');
      $('#custId').val(id);
      dependency(<?php echo @$data['id'] ?>);
      $('#asignedToInstaller').modal('show');
    });
    $('#toggleCheck').click(function(){
      $(this).hide(500);
      $('#asignBtn').hide();
      $('#batchAsignBtn').show();
      $('.batchAsign').toggle(300);
      $('#batchAsignModel').toggle(300);
    });
    $('.company').change(function(){
  		var id =$(this).val();
      dependency(id);
  	});
    function dependency(id){
      $.ajax({
  			url:"<?=URLROOT ?>/helpers/dropdown.php",
  			type:'POST',
  			dataType:'JSON',
  			data:{fetchInstaller:true,id:id},
  			success:function(data){
  				$('#asignedto').html(data.installer);
  			}
  		})
    }
    // asign to individual
    $('#asignBtn').click(function(){
      var form = $('#asignForm');
      var cmp=$('#asignedto').val();
      if(cmp!==null){
        $.ajax({
          url:"<?=URLROOT ?>/schedules/asignCustomer/",
          type:'POST',
          // dataType:'JSON',
          data:{asignedto:true,form:form.serialize()},
          success:function(data){
            if(data.includes('success')){
                $('#asignedToInstaller').modal('hide');
                $('#asignForm')[0].reset();
                swal({
                   title: "",
                   text: data,
                   icon: "success",
                 });
              }else{
                swal(data);
              }

          }
        });
      }else{  $('.required').text('select Installer');}
    });
    $('#batchAsignBtn').click(function(){
      var cmp=$('#company').val();
      var i =$('#asignedto').val();
      var batch = [];
       $.each($("input[name='batchAsign']:checked"), function(){
           batch.push($(this).val());
       });
       if(batch.length >0){
         if(cmp !==null){
          $.ajax({
            url:"<?=URLROOT ?>/schedules/batchAsignCustomer",
            type:'POST',
            // dataType:'JSON',
            data:{asignedto:true,batch:batch,company:cmp,installer:i},
            success:function(data){
              if(data.includes('success')){
                  $('#asignedToInstaller').modal('hide');
                  $('#asignForm')[0].reset();
                  swal({
                     title: "",
                     text: data,
                     icon: "success",
                   });
                }else{
                  swal(data);
                }
            }
          });
      }else{alert('select Company!')}
      }else{alert('select at least one customer')}
    });
})
</script>
<!-- Asign customer to team and company for installation model  -->
<div class="modal fade" id="asignedToInstaller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h6 class="modal-title" id="exampleModalLabel">Asign Customer to installer</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" id="asignForm">
      <div class="modal-body">
        <div class = "form-group">
          <p id="required" class="text-danger required"></p>
            <input type="hidden" name = "customer_id" id ="custId">
            <input type="hidden" name = "company" value="<?php echo @$data['id']; ?>">
        </div>
        <div class = "form-group">
          ASIGN TO:
            <select style="width:100%;" type="text" name="asignedto" id="asignedto" placeholder="Address" class = "form-control asignedto select2" >
            <option disabled selected> Select Installer</option>
          </select>
        </div>
      </div>
      </form>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" name="asignBtn" id="asignBtn"><i class="fa fa-edit"></i> Go</button>
          <button  class="btn btn-primary pull-left btn-sm" name="batchAsignBtn" style="display:none;" id="batchAsignBtn"><i class="fa fa-edit"></i> Asign</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>

    </div>
  </div>
</div>
