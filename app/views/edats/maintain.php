<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<div class="row">
    <div class="co-xl-4 col-md-4 col-lg-4">
      <div class="card card-body  mt-3">

      </div>
    </div>
    <div class="col-xl-8 col-xl-8 col-md-8">
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
                  <i class="fa fa-cog reScheduleEdat text-danger pointer" data-toggle="tooltip" data-placement="top" title="Schedule" id="<?php echo $row->eid ?>" ></i>
                  <i class="fa fa-forward installedat text-success pointer" data-toggle="tooltip" data-placement="top" title="Install" id="<?=$row->eid ?>" ></i>
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
      </div>
        <?php else: ?>
          nothing o
      <?php endif; ?>

</div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script>
	$(document).ready(function(){

	});
</script>
