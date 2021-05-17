<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<style>
  .table{
    font-size:10px;
    font-family: 'Open Sans', sans-serif;
  }
</style>
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card card-body  mt-3">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Meter Details</div>
        <div class="table-responsive">
          <table class="table table-bordered table-stripe table-hover" id="" width="100%">
            <thead>
              <tr class="small">
                <th width="3%">S/N</th>
                <th width="15%">METER NO.</th>
                <th width="5%">SEAL NO.</th>
                <th width="5%">PRELOAD</th>
                <th width="5%">TARIF</th>
                <th width="5%">ADVICE TARIF</th>
                <th width="5%">X</th>
                <th width="5%">Y</th>
                <th width="20%">REMARKS</th>
                <th width="10%">status</th>
                <th width="5%">INSTALLER</th>
                <th width="5%">PHOTO</th>
                <th width="5%">date</th>
                <th width="5%">ACTION</th>
              </tr>
            </thead>
            <tbody>
            <?php $n=0; foreach($data['meter'] as $row) : ?>
              <tr>
              <td><?php echo ++$n?></td>
              <td class="meter'.$row->mid.'" contenteditable><?php echo $row->meternum?></td>
              <td class="seal'.$row->mid.'" contenteditable><?php echo $row->seal?></td>
              <td class="preload'.$row->mid.'" contenteditable><?php echo $row->preload?></td>
              <td class="tarif'.$row->mid.'" contenteditable><?php echo $row->tarif?></td>
              <td class="advtarif'.$row->mid.'" contenteditable> <?php echo $row->advicetarif?></td>
              <td class="mx'.$row->mid.'" contenteditable><?php echo $row->m_x?></td>
              <td class="my'.$row->mid.'" contenteditable><?php echo $row->m_y?></td>
              <td><?php echo $row->remark?></td>
              <td><?php echo $row->status?></td>
              <td><?php echo $row->noi?></td>
              <td><img class = "img img-responsive small img-small" src="<?=APPROOT ?>/images/<?=$row->meterfoto?>"  alt="image"></td>
              <td><?php echo $row->doi?></td>
              <td><i class="fa fa-edit editMeter text-warning pointer" data-toggle="tooltip" data-placement="top" title="EDIT" id="'.$row->mid.'" ></i>
                  <i class="fa fa-cog reSchedleMeter text-danger pointer" data-toggle="tooltip" data-placement="top" title="Schedule" id="'.$row->mid.'" ></i>
              </td>
              </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        </div>

      </div>   
    </div>
 </div>
 

<?php include_once(APPROOT . '/views/inc/footer.php');?>