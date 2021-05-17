<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<div class="row">
  <div class="col-md-8">
    <fieldset class="border p-1">
      <legend class="w-auto"><i class="fa  fa-info-circle mr-1"></i></legend>
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
          <thead>
            <tr>
              <th width="10%">Name</th>
              <th width="5%">Item</th>
              <th width="15%">collection  <i class="fa fa-calendar"></i> </th>
              <th width="15%">returning  <i class="fa fa-calendar"></i></th>
              <th width="35%">Remarks</th>
              <th width="20%">LID</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data['lid'] as $row): ?>
              <tr>
                <td><?php echo $row->uid ?></td>
                <td><?php echo $row->count ?></td>
                <td><?php echo $row->collection_date ?></td>
                <td><?php echo $row->r_date ?></td>
                <td><?php echo $row->remark ?></td>
                <td> <a href="<?php echo URLROOT .'/stores/lendlist/'. $row->lid ?>">
                  <?php echo $row->lid ?></a> <button type="button" class="btn btn-success btn-xs"> <i class="fa  fa-check-square"></i> </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </fieldset>
  </div>
  <div class="col-md-4">
    <fieldset class="border p-1">
        <legend class="w-auto small">details</legend>
        <?php if (isset($data['details'])): ?>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>Qnt </th>
                  <th>Item </th>
                  <th>Store</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data['details'] as $row): ?>
                  <tr>
                    <td>
                      <?php echo $row->qnt ?>
                      <input type="text" name="" class="form-control form-control-sm gqnt" id="<?php echo $row->pid ?>">
                    </td>
                    <td><?php echo $row->name ?></td>
                    <td><?php echo $row->store ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
    </fieldset>
  </div>
</div>
<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('.gqnt').change(function(){
      var id=$(this).attr('id');
      var qnt=$(this).val();
      alert(id)
    });
  });
</script>
