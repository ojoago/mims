<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12 mx-auto">
          <div class="card card-body  mt-1">
            <div class="card-header"><i class="fas fa-table mr-1"></i>SR-IN</div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover small" width="100%">
                  <thead>
                    <tr class="small">
                      <!-- <th width="5%">s/n</th> -->
                      <th width="30%">Item Name</th>
                      <th width="40%">Item Description</th>
                      <th width="10%">ID</th>
                      <!-- <th width="5%">old value</th> -->
                      <th width="5%">stock</th>
                      <th width="5%">Qnt </th>
                      <th width="10%">Condition</th>
                      <th width="5%">Units </th>
                      <th width="5%">request by </th>
                      <th width="5%">approved by </th>
                      <th width="5%">received by </th>
                      <th width="5%">dept </th>
                      <th width="5%">unit </th>
                      <th width="5%">store </th>
                      <th width="5%">remark </th>
                      <th width="5%">date </th>
                      <th width="5%">Waybill </th>
                    </tr>
                  </thead>
                  <tbody>
                <?php $n=0; foreach($data['inventory'] as $row) :?>
                   <tr class="small">
                   <!-- <td><php echo ++$n?></td> -->
                   <td ><?php echo $row->name ?></td>
                   <td ><?php echo $row->dsc ?></td>
                   <td ><?php echo $row->batch ?></td>
                   <!-- <td >< echo row->old></td> -->
                   <td ><?php echo $row->quantity?></td>
                   <td ><?php echo ($row->quantity+$row->old)?></td>
                   <td ><?php echo $row->status ?></td>
                   <td ><?php echo $row->units?></td>
                   <td ><?php echo $row->requestby?></td>
                   <td ><?php echo $row->aprovedby?></td>
                   <td ><?php echo $row->receivedby?></td>
                   <td ><?php echo $row->dept?></td>
                   <td ><?php echo $row->unit?></td>
                   <td ><?php echo $row->store?></td>
                   <td ><?php echo $row->remark?></td>
                   <td ><?php echo $row->date?></td>
                   <td ><a href="<?php echo URLROOT?>/Inventories/printWaybill/<?php echo $row->waybill; ?>"><?php echo $row->waybill?></a></td>
                  <?php endforeach; ?>
                  </tbody>
                </table>
                </div>
          </div>
          </div>
      </div>

<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
