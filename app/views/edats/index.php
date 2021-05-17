<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<div class="row">
    <div class="card card-body  mt-3">
      <?php if(isset($data)): ?>
            <div class="card-header"><i class="fas fa-table mr-1"></i>Edats Details</div>
            <div class="table-responsive">
              <?php  flash('register_success'); ?>
              <table class="table table-bordered table-striped table-hover small" id="" width="100%">
                <thead>
                  <tr class="small">
                    <th width="3%">s/n</th>
                    <th width="10%">Edat Number</th>
                    <th width="4%">RF</th>
                    <th width="10%">Status</th>
                    <th width="20%">Address</th>
                    <th width="20%">DT Name</th>
                    <th width="4%">pole</th>
                    <th width="4%">X</th>
                    <th width="4%">Y</th>
                    <th width="3%">Action</th>
                    <th width="5%">Count</th>
                    <th width="5%">remark</th>
                    <th width="5%">installer</th>
                    <th width="5%">Photo</th>
                    <th width="5%">date</th>
                  </tr>
                </thead>
                <tbody>
              <?php $n=0; foreach($data as $row) :?>
                <?php  $e=countMeters($row->eid);?>
                 <tr class="small">
                 <td><?php echo ++$n?></td>
                 <td class="edatnumber<?php echo $row->eid ?>" contenteditable><?php echo $row->edatnumber ?></td>
                 <td class="channel<?php echo $row->eid ?>" contenteditable><?php echo $row->channel?></td>
                 <td class="status<?php //echo $id?>"><?php echo strtolower($row->edatstatus)?></td>
                 <td class="address<?php echo $row->eid ?>" contenteditable><?php echo strtolower($row->e_address)?></td>
                 <td class="dtname<?php echo $row->eid ?>" contenteditable><?php echo strtolower($row->dt_name)?></td>
                 <td class="pole<?php echo $row->eid ?>" contenteditable><?php echo $row->pole ?></td>
                 <td class="e_x<?php echo $row->eid ?>" contenteditable><?php echo $row->e_x?></td>
                 <td class="e_y<?php echo $row->eid ?>" contenteditable><?php echo $row->e_y?></td>
                 <td>
                   <i class="fa fa-edit editEdat text-warning pointer" data-toggle="tooltip" data-placement="top" title="EDIT" id="<?php echo $row->eid ?>" ></i>
                   <?php if(strtolower($row->edatstatus)=='not install'): ?>
                      <i class="fa fa-cog reScheduleEdat text-danger pointer" data-toggle="tooltip" data-placement="top" title="Schedule" id="<?php echo $row->eid ?>" ></i>
                      <i class="fa fa-forward installedat text-success pointer" data-toggle="tooltip" data-placement="top" title="Install" id="<?=$row->eid ?>" ></i>
                     <?php else: ?>
                       <i class="fa fa-cogs SchedulefaultyEdat text-danger pointer" data-toggle="tooltip" data-placement="top" title="asign faulty edat" id="<?php echo $row->eid ?>" ></i>
                       <i class="fa fa-rocket fixfaultyEdat text-success pointer" data-toggle="tooltip" data-placement="top" title="fix faulty edat" id="<?=$row->eid ?>" ></i>
                       <i class="fa fa-map-pin mapedatMeter text-success pointer" data-toggle="tooltip" data-placement="top" title="Map edat-meter" id="<?=$row->eid ?>" ></i>
                   <?php endif; ?>

                 </td>
                 <td class="meterDetailsOnEdats pointer" id="<?php echo $row->eid ?>"><?php echo $e->count?> <i class="fa fa-eye pointer text-success" data-toggle="tooltip" data-placement="top" title="VIEW" ></i></td>
                 <td><?php echo $row->remark?></td>
                 <td><?php echo $row->uid?></td>
                 <td><img class = "img img-responsive small img-small" src="<?php echo URLROOT?>/images/<?php echo $row->edatfoto ?>"  alt="image"></td>
                 <td><?php echo date('y-m-d',strtotime($row->date)) ?></td>
                 </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
              </div>

        </div>
        <?php else: ?>
          nothing o
      <?php endif; ?>

</div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
	$(document).ready(function(){
    // edit edat
    $('.editEdat').click(function(){
      var id = $(this).attr('id');
      var edat = $('.edatnumber'+id).text();
      var rf = $('.channel'+id).text();
      var pole = $('.pole'+id).text();
      var address = $('.address'+id).text();
      var dt = $('.dtname'+id).text();
      var x = $('.e_x'+id).text();
      var y = $('.e_y'+id).text();
      $.ajax({
        url:"<?php echo URLROOT?>/edats/update",
        type:"POST",
        data:{updateEdat:true,id:id,edat:edat,rf:rf,address:address,dt:dt,x:x,y:y,pole:pole},
        success:function(data){
          alert(data);
        }
      });
    });
    // edit edat stop here
    // load meters on each edat
    $('.meterDetailsOnEdats').click(function(){
      var id =$(this).attr('id');
      $.ajax({
        url:"<?php echo URLROOT?>/helpers/loadmodal.php",
        type:"POST",
        dataType:"JSON",
        data:{loadMeterDetailsOnEdat:true,id:id},
        success:function(data){
          if(data.msg !==''){
            alert(data.msg);
          }else{
            $('#metersOnEdatDetailsModal').modal('show');
            $('.allMetersDetail').html(data.table);
            $('#edat').text(data.edat);
          }
        }
      });
    });
    // asign edat modal
    $('.reScheduleEdat').click(function(){
      var id =$(this).attr('id');
      $('#edatId').val(id);
      $('#asignFautyEdatBtn').hide();
      $('#asignEdatBtn').show();
      $('#asignedToInstaller').modal('show')
    });
    // asign edat form action
    $('#asignEdatBtn').click(function(){
      var form = $('#asignForm');
      var cmp=$('.company').val();
      if(cmp!==null){
        $.ajax({
          url:"<?php echo URLROOT ?>/edats/asignEdat",
          type:'POST',
          // dataType:'JSON',
          data:{asignedto:true,form:form.serialize()},
          success:function(data){
            if(data.includes('success')){
                $('#asignedToInstaller').modal('hide');
                $('#asignForm')[0].reset();
                // swal({
                //    title: "",
                //    text: data,
                //    icon: "success",
                //  });
                alert(data)
              }else{
              //  swal(data);
                alert(data)
              }
          }
        });
      }else{  $('.required').text('select company');}
    });
    // asign stop here
    $('.company').change(function(){
  		var id =$(this).val();
  		$.ajax({
  			url:"<?=URLROOT ?>/helpers/dropdown.php",
  			type:'POST',
  			dataType:'JSON',
  			data:{fetchInstaller:true,id:id},
  			success:function(data){
  				$('#asignedto').html(data.installer);
  			}
  		})
  	});
    //
    //install edat direct
    $('.installedat').click(function(){
      var id=$(this).attr('id');
      $('.install_eid').val(id);
      $('#installEdatModal').modal('show',50000)
    });
    // asign faulty edat
    $('.SchedulefaultyEdat').click(function(){
      var id =$(this).attr('id');
      $('#edatId').val(id);
      $('#asignEdatBtn').hide();
      $('#asignFautyEdatBtn').show();
      $('#asignedToInstaller').modal('show')
    });
    // schedule faulty edat
    $('#asignFautyEdatBtn').click(function(){
      var form = $('#asignForm');
      var cmp=$('.company').val();

      if(cmp!==null){
        $.ajax({
          url:"<?php echo URLROOT ?>/faults/asignEdat",
          type:'POST',
          // dataType:'JSON',
          data:{asignedto:true,form:form.serialize()},
          success:function(data){
            if(data.includes('success')){
                $('#asignedToInstaller').modal('hide');
                $('#asignForm')[0].reset();
                // swal({
                //    title: "",
                //    text: data,
                //    icon: "success",
                //  });
                alert(data)
              }else{
              //  swal(data);
                alert(data)
              }
          }
        });
      }else{  $('.required').text('select company');}
    });
    // schedule fualty meter
	});
</script>
<!-- meters on edat model -->
<div class="modal fade bd-example-modal-lg" id = "metersOnEdatDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
		<div class="modal-header">
        <h5 class="modal-title" id="edat"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <div class="modal-body">
			<div class="allMetersDetail">	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- meters on edat model stop here -->
<!-- asign edat to an installer -->
<div class="modal fade" id="asignedToInstaller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h6 class="modal-title" id="exampleModalLabel">Asign Edat to Installer</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" id="asignForm">
      <div class="modal-body">
        <div class = "form-group">
          <p id="required" class="text-danger required"></p>
            <input type="hidden" name = "edat_id" id ="edatId">
            <select style="width:100%;" type="text" id="company" name="company" placeholder="company" class = "form-control select2 company"   required>
            <option disabled selected> Select   Company</option>
            <?php echo company(); ?>
          </select>
        </div>
        <div class = "form-group">
          ASIGN:
            <select style="width:100%;" type="text" name="asignedto" id="asignedto" placeholder="installer" class = "form-control asignedto select2" >
            <option disabled selected> Select Company First</option>
          </select>
        </div>
      </div>
      </form>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" name="asignBtn" id="asignEdatBtn"><i class="fa fa-cog"></i> Go</button>
					<button  class="btn btn-primary pull-left btn-sm" name="asignBtn" id="asignFautyEdatBtn" style="display:none;"><i class="fa fa-cogs"></i> Go</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>

    </div>
  </div>
</div>
