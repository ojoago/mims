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
        <div class="card-header"><i class="fas fa-table mr-1"></i>Edat Details</div>
        <div class="table-responsive">
          <table class="table table-bordered table-stripe table-hover" id="" width="100%">
            <thead>
            <tr class="small">
              <th width="3%">S/N</th>
              <th width="10%">EDAT NUMBER</th>
              <th width="4%">RF</th>
              <th width="10%">STATUS</th>
              <th width="20%">ADDRESS</th>
              <th width="20%">DT NAME</th>
              <th width="4%">X</th>
              <th width="4%">Y</th>
              <th width="5%">ACTION</th>
              <th width="5%">METERS</th>
              <th width="5%">INSTALLER</th>
              <th width="5%">PHOTO</th>
              <th width="5%">date</th>
            </tr>
            </thead>
            <tbody>
              <?php $n=0; foreach($data['edat'] as $row) : ?>
              <?php  $e=countMeters($row->eid);?>
               <tr>
               <td><?php echo ++$n?></td>
               <td class="edatnumber<?php echo $id?>" contenteditable><?php echo $row->edatnumber ?></td>
               <td class="channel<?php echo $id?>" contenteditable><?php echo $row->channel?></td>
               <td class="status<?php echo $id?>"><?php echo $row->edatstatus?></td>
               <td class="address<?php echo $id?>" contenteditable><?php echo $row->e_address?></td>
               <td class="dtname<?php echo $id?>" contenteditable><?php echo $row->dt_name?></td>
               <td class="e_x<?php echo $id?>" contenteditable><?php echo $row->e_x?></td>
               <td class="e_y<?php echo $id?>" contenteditable><?php echo $row->e_y?></td>
               <td>
               <i class="fa fa-edit editEdat text-warning pointer" data-toggle="tooltip" data-placement="top" title="EDIT" id="'.$id.'" ></i>
                <i class="fa fa-cog reSchedleEdat text-danger pointer" data-toggle="tooltip" data-placement="top" title="Schedule" id="'.$id.'" ></i>
               </td>
               <td class="meterDetailsOnEdats pointer" id="'.$id.'"><?php echo $e->count?> <i class="fa fa-eye pointer text-success" data-toggle="tooltip" data-placement="top" title="VIEW" ></i></td>
               <td><?php echo $row->uid?></td>
               <td><img class = "img img-responsive small img-small" src="<?=APPROOT ?>/images/<?=$row->edatfoto?>"  alt="image"></td>
               <td><?php echo $row->date?></td>
               </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
 </div>


<?php include_once(APPROOT . '/views/inc/footer.php');?>
