<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<style >

tr>td{
  padding-top: 1px !important;
  padding-bottom: 1px !important;
}
#report{
  max-height:350px !important;
  min-width: 300px;
  padding: 1px;
  overflow-y: scroll;
  top:0 !important;
  position: absolute !important;
  display: none;
  padding: 5px;
  color: #000;
}

</style>
<div class = "card card-body  mt-2 mb-1">
  <a href="<?php echo URLROOT.'/installations' ?>" class="pull-right">Home</a>
  <ol class="breadcrumb mb-4 mt-1">
    <?php if(isset($data['companyName'])): ?>
      <?php echo $data['companyName'] ?> &nbsp;<li class="breadcrumb-item active"> Dashboard </li>
    <?php endif; ?>
    <input type="button" class="btn btn-info btn-xs pull-right mr-auto" id="show" value="Log">
    </ol>
    <?php if (isset($data['data'])): ?>
  <div class="row">
      <div class="table-responsive table">
        <table class="table table-hover table-striped table-bordered small">
          <thead>
            <tr>
            <th width="2%">S/N</th>
            <th width="20%">Names</th>
            <th width="10%">Username</th>
            <th width="10%">gsm</th>
            <th width="20%">email</th>
            <th width="20%">address</th>
            <th width="13%">Group</th>
            <th width="5%">Status</th>
            <th width="3%"><i class="fa fa-cog"></i></th>
          </tr>
          </thead>
          <tbody>
            <?php $n=0; foreach($data['data'] as $row): ?>
              <tr>
                <td><?php echo++$n; ?></td>
                <td><?php echo$row->firstname .' '.$row->lastname.' '.$row->othername; ?></td>
                <td><?php echo$row->uid; ?></td>
                <td><?php echo$row->gsm; ?></td>
                <td><?php echo$row->mail; ?></td>
                <td><?php echo$row->address; ?></td>
                <td><?php echo$row->level; ?> <small><?php echo$row->team; ?></small> </td>
                <td><?php echo$row->userstatus; ?></td>
                <td >
                  <ul class="navbar-nav ml-auto ml-md-0">
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i></a>
                          <div class="dropdown-menu dropdown-menu-left actionDropdown" aria-labelledby="userDropdown">
                            <a class="dropdown-item updateLevel pointer" id="<?php echo $row->userId ?>" ><i class = "fa fa-key"></i> level</a>
                              <?php if (strtolower($row->level)=='installer'): ?>
                                <a class="dropdown-item updateTeam pointer" id="<?php echo $row->userId ?>" ><i class = "fa fa-cog"></i> team</a>
                              <?php endif; ?>
                              <a class="dropdown-item updateStatus pointer" id="<?php echo $row->userId ?>" ><i class = "fa fa-magnet"></i> status</a>
                          </div>
                      </li>
                  </ul>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
			<div class="card mb-4" id="report">
        <input type="button" class="btn btn-danger btn-xs ml-2 pull-right" id="hide"  value="close"><br>
        <?php foreach($data['report'] as $row): ?>
            <small>
              <span><?php echo ucfirst($row->activity )?> | <small> <?php echo $row->time  ?></small></span>
            </small><br>
        <?php endforeach; ?>
			</div>
  </div>
<?php endif; ?>
</div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#show').click(function(){
      $('#report').show(800);
    });
    $('#hide').click(function(){
      $('#report').hide(800);
    });
    // update status
    $('.updateStatus').click(function(){
      var id =$(this).attr('id');
      $('#useri_d').val(id);
      $('#updateStatusModal').modal('show');
    });
    $('#updateStatusBtn').click(function(){
      var form = $('#updateStatusForm');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/Installations/updateStatus",
        type:'POST',
        data:{updateLevel:true,form:form.serialize()},
        success:function(data){
              $('#updateTeam').modal('hide');
              $('#updateTeamForm')[0].reset();
              $('#updateStatusModal').modal('hide');
                alert(data);

                $('.loader').hide();
            }
      });
    });
    $('.updateTeam').click(function(){
      var id= $(this).attr('id');
      $('#user_id').val(id);
      $('#updateTeam').modal('show');
    });
    $('#updateTeamBtn').click(function(){
      var form = $('#updateTeamForm');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/Installations/updateTeam",
        type:'POST',
        // dataType:'JSON',
        data:{updateLevel:true,form:form.serialize()},
        success:function(data){
              $('#updateTeam').modal('hide');
              $('#updateTeamForm')[0].reset();
                alert(data);
                $('.loader').hide();
            }
      });
    });
    // update team stop here
    // update level goes
    $('.updateLevel').click(function(){
      var id= $(this).attr('id');
      $('#userId').val(id);
      $('#updateLevel').modal('show');
    });
    $('#updateLevelBtn').click(function(){
      var form = $('#updateLevelForm');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/Installations/updatelevel",
        type:'POST',
        // dataType:'JSON',
        data:{updateLevel:true,form:form.serialize()},
        success:function(data){
              $('#updateLevel').modal('hide');
              $('#updateLevelForm')[0].reset();
              $('.loader').hide();
              alert(data)
            }
      });
    });
    // update level stop here
  });
</script>
<!-- update level model  -->
<div class="modal fade" id="updateLevel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Update Group </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<form method = "post" id="updateLevelForm">
      <div class="modal-body">
        <div class="form-group input-group">
        <i class=" fas fa-tasks bg-primary text-light p-2 input-group-append"></i>
        <select type="text" name="group" id="edatS" placeholder="Address" class="form-control form-control-sm">
          <option disabled selected> SELECT ROLE</option>
          <?php echo userRole() ?>
        </select>
        <input type="hidden" id="userId" name="userId">
        </div>
	</form>
      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" id="updateLevelBtn"><i class="fa fa-edit"></i> Update</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>

    </div>
  </div>
</div>
<!-- update level model  -->
<!-- update team modal  -->
<div class="modal fade" id="updateTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Users Team </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method = "post" id="updateTeamForm">
      <div class="modal-body">
        <div class="form-group input-group">
        <i class=" fas fa-tasks bg-primary text-light p-2 input-group-append"></i>
        <select type="text" name="team" placeholder="Address" class="form-control form-control-sm " >
          <option disabled selected> SELECT Team</option>
          <?php echo teams() ?>
        </select>
        <input type="hidden" id="user_id" name="userId">
        </div>
	</form>
      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" name="updatePwd" id="updateTeamBtn"><i class="fa fa-edit"></i> Update</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
<!-- update team stop here -->
<!-- update status modal  -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">User Status </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method = "post" id="updateStatusForm">
      <div class="modal-body">
        <div class="form-group input-group">
        <i class=" fas fa-tasks bg-primary text-light p-2 input-group-append"></i>
        <select type="text" name="status" placeholder="Address" class="form-control form-control-sm " >
          <option disabled selected> SELECT STATUS</option>
          <option value="active">activate</option>
          <option value="guest">deactivate</option>
        </select>
        <input type="hidden" id="useri_d" name="userId">
        </div>
	</form>
      </div>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" name="updatePwd" id="updateStatusBtn"><i class="fa fa-edit"></i> Update</button>
          <button type="button" class="btn btn-danger btn-xs btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
<!-- update status stop here -->
