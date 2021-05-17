<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card card-body  mt-1">
                <h1 class="display-3"><?php// echo$data['title']; ?></h1>
                <p class="lead"> <?php echo @$data['msg']; ?></p>
                <div class="table-responsive">
                <table class="table table-bordered table-stripe table-hover small" id="" width="100%">
                <thead>
                    <tr class="">
                        <th width="5%">S/N</th>
                        <th width="10%">account number</th>
                        <th width="10%">account name</th>
                        <th width="15%">gsm</th>
                        <th width="15%">address</th>
                        <th width="20%">clm</th>
                        <th width="15%">surveystatus</th>
                        <th width="15%">ctype</th>
                        <th width="5%">region</th>
                        <th width="5%">kv33</th>
                        <th width="5%">feeder</th>
                        <th width="5%">state</th>
                        <th width="5%">dtname</th>
                        <th width="5%">dtcode</th>
                        <th width="5%">upriser</th>
                        <th width="5%">pole</th>
                        <th width="5%">metertype</th>
                        <th width="5%">date</th>
                        <th width="5%">company</th>
                        <th width="5%">asignedto</th>
                    </tr>
                </thead>
                <tbody>
                <?php $n=0;foreach($data as $row): ?>
                    <tr>
                        <td> <?=++$n?></td>

                        <td class="account_number" contenteditable> <?=@$row[0]?></td>
                        <td class="account_number" contenteditable> <?=@$row[1]?></td>
                        <td class="account_name" contenteditable> <?=@$row[2]?></td>
                        <td class="address" contenteditable> <?=@$row[3]?></td>
                        <td class="gsm" contenteditable> <?=@$row[4]?></td>
                        <td class="clm" contenteditable> <?=@$row[5]?></td>
                        <td class="region" contenteditable> <?=@$row[6]?></td>
                        <td class="feeder" contenteditable> <?=@$row[7]?></td>
                        <td class="dt" contenteditable> <?=@$row[8]?></td>
                        <td class="upriser" contenteditable> <?=@$row[9]?></td>
                        <td class="pole" contenteditable> <?=@$row[10]?></td>
                        <td class="survey" contenteditable> <?=@$row[11]?></td>
                        <td class="metertype" contenteditable> <?=@$row[12]?></td>
                        <td class="status" contenteditable> <?=@$row[13]?></td>
                        <td class="" contenteditable> <?=@$row[14]?></td>
                        <td class="" contenteditable> <?=@$row[15]?></td>
                        <td class="" contenteditable> <?=@$row[16]?></td>
                        <td class="" contenteditable> <?=@$row[17]?></td>
                        <td> <?=@$row[18]?></td>
                        <td> <?=@$row[19]?></td>
                    </tr>
                <?php endforeach;?>
                <tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script>

    </script>
