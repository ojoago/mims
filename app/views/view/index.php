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
        <div class="card-header"><i class="fas fa-table mr-1"></i>COMBINED INFORMATION</div>
        <div class="table-responsive">
        <table class="table table-bordered table-stripe table-hover" id="" width="100%">
          <thead>
            <tr class="small">
              <th width="3%">S/N</th>
              <th width="15%">ACC No.</th>
              <th width="5%">NAMES</th>
              <th width="5%">GSM</th>
              <th width="5%">address</th>
              <th width="5%">land mark</th>
              <th width="5%">state</th>
              <th width="5%">region</th>
              <th width="20%">33kv</th>
              <th width="10%">feeder</th>
              <th width="5%">dt name</th>
              <th width="5%">dt code</th>
              <th width="5%">upriser</th>
              <th width="5%">customertype</th>
              <th width="5%">metertype</th>
              <th width="5%">surveystatus</th>
              <th width="5%">payment date</th>
              <th width="5%">asign to</th>
              <th width="5%">status</th>
              <th width="5%">days count</th>
              <th width="15%">METER NO.</th>
              <th width="5%">SEAL NO.</th>
              <th width="5%">PRELOAD</th>
              <th width="5%">TARIF</th>
              <th width="5%">ADVISE TARIF</th>
              <th width="5%">X</th>
              <th width="5%">Y</th>
              <th width="20%">REMARKS</th>
              <th width="10%">status</th>
              <th width="5%">INSTALLER</th>
              <th width="5%">PHOTO</th>
              <th width="5%">date</th>
              <th width="10%">EDAT NUMBER</th>
              <th width="4%">RF</th>
              <th width="10%">STATUS</th>
              <th width="20%">ADDRESS</th>
              <th width="20%">DT NAME</th>
              <th width="4%">X</th>
              <th width="4%">Y</th>
              <th width="5%">INSTALLER</th>
              <th width="5%">PHOTO</th>
              <th width="5%">date</th>
              <th width="5%">ACTION</th>
            </tr>
          </thead>
          <tbody>
            <?php $n=0;foreach($data['info'] as $row) : ?>
              <tr>
                <td><?= ++$n?></td>
                <td class="numb" ><?php echo $row->accountnum ?></td>
                <td class="name" ><?php echo ucwords(strtolower($row->accountname)) ?></td>
                <td class="gsm" ><?php echo $row->gsm ?></td>
                <td class="address" ><?php echo strtolower($row->address) ?></td>
                <td class="clm" ><?php echo strtolower($row->clm) ?></td>
                <td class="state" ><?php echo $row->state ?></td>
                <td class="tzone" ><?php echo $row->tzone ?></td>
                <td class="feeder33" ><?php echo $row->feeder33 ?></td>
                <td class="feeder" ><?php echo $row->feeder ?></td>
                <td class="dtname" ><?php echo $row->dtname ?></td>
                <td class="dtcode" ><?php echo $row->dtcode ?></td>
                <td class="upriser" ><?php echo $row->upriser ?></td>
                <td class="cust" ><?php echo $row->customertype ?></td>
                <td class="metertype" ><?php echo $row->metertype ?></td>
                <td class="status" ><?php echo $row->surveystatus ?></td>
                <td class="date" ><?php echo $row->pdate ?></td>
                <td class="asign" ><?php echo $row->uid ?></td>
                <td class="c_status" ><?php echo $row->c_status ?></td>
                <td class="count" ><?php echo $row->dayscount ?></td>
                <td class="meter" ><?php echo $row->meternum ?></td>
                  <td class="seal" ><?php echo $row->seal ?></td>
                  <td class="preload" ><?php echo $row->preload ?></td>
                  <td class="tarif" ><?php echo $row->tarif ?></td>
                  <td class="tarif" ><?php echo $row->advicetarif ?></td>
                  <td class="m_x" ><?php echo $row->m_x ?></td>
                  <td class="m_y" ><?php echo $row->m_y ?></td>
                  <td class="remark"><?php echo $row->remark ?></td>
                  <td class="status" ><?php echo $row->status ?></td>
                  <td class="installer" ><?php echo $row->uid ?></td>
                  <td class="photo" ><img src="<?=APPROOT ?>/images/<?=$row->meterfoto?>" class="img img-responsive img-small" alt="image"></td>
                  <td class="date" ><?php echo $row->doi ?></td>
                  <td class="edatnumber" ><?php echo $row->edatnumber ?></td>
                  <td class="channel" ><?php echo $row->channel ?></td>
                  <td class="status" ><?php echo $row->edatstatus ?></td>
                  <td class="address" ><?php echo $row->e_address ?></td>
                  <td class="dtname" ><?php echo $row->dt_name ?></td>
                  <td class="e_x" ><?php echo $row->e_x ?></td>
                  <td class="e_y" ><?php echo round($row->e_y,6) ?></td>
                  <td class="uid" ><?php echo $row->uid ?></td>
                  <td><img class = "img img-responsive small img-small" src="<?=APPROOT ?>/images/<?=$row->edatfoto?>"  alt="image"></td>
                  <td><?php echo $row->date ?></td>
                  <td>
                  <i class="fa fa-trash deleteCustomer text-danger pointer" data-toggle="tooltip" data-placement="top" title="DELETE" id="'.$row->cid.'" ></i>
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