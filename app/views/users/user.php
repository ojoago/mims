<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style >
  tr > td{
    padding: 1px !important;
  }
</style>
<div class = "card">
  <div class="card card-header">Users Management   </div>
<div class = "card card-body  mt-2 mb-2">
  <!-- <ol class="breadcrumb mb-4 mt-1">
    <li class="breadcrumb-item active">  </li>

    </ol> -->
    <?php if (isset($data['users'])): ?>
  <div class="row">
        <div class="table-responsive table shadow">
          <table class="table table-hover table-striped table-bordered small">
            <thead>
              <tr>
              <th width="2%">S/N</th>
              <th width="22%">Names</th>
              <th width="5%">Username</th>
              <th width="5%">gsm</th>
              <th width="15%">email</th>
              <th width="15%">company</th>
              <th width="15%">address</th>
              <th width="10%">Group</th>
              <th width="7%">Status</th>
              <th width="4%"><i class="fa fa-cog"></i></th>
            </tr>
            </thead>
            <tbody>
              <?php $n=0; foreach($data['users'] as $row): ?>
                <tr>
                  <td class="text-center"><?php echo++$n; ?></td>
                  <td><?php echo$row->firstname .' '.$row->lastname.' '.$row->othername; ?></td>
                  <td><?php echo decodeHtmlEntity($row->uid); ?></td>
                  <td><?php echo$row->gsm; ?></td>
                  <td><?php echo decodeHtmlEntity($row->mail); ?></td>
                  <td><?php echo decodeHtmlEntity($row->names); ?></td>
                  <td><?php echo decodeHtmlEntity($row->address); ?></td>
                  <td><?php echo decodeHtmlEntity($row->level); ?> <small><?php echo decodeHtmlEntity($row->team); ?></small> </td>
                  <td class="text-center"><?php echo decodeHtmlEntity($row->userstatus); ?></td>
                  <td class="text-center">
                    <ul class="navbar-nav ml-auto ml-md-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i></a>
                            <div class="dropdown-menu dropdown-menu-left actionDropdown" aria-labelledby="userDropdown">
                            <?php if(@$role['rights']==1): ?>
                                <a class="dropdown-item updateaccess pointer" id="<?php echo $row->userId ?>" ><i class = "fa fa-lock"></i> access</a>
                              <?php endif; ?>
                              <?php if(@$role['projects']==1): ?>
                              <a class="dropdown-item assignUserToProjectById pointer" id="<?php echo $row->userId ?>" ><i class = "fa fa-angle-double-right"></i> Asign to Project</a>
                            <?php endif; ?>
                              <a class="dropdown-item updateLevel pointer" id="<?php echo $row->userId ?>" ><i class = "fa fa-cog"></i> level</a>
                                <?php if (strtolower($row->level)=='installer'): ?>
                                  <a class="dropdown-item updateTeam pointer" id="<?php echo $row->userId ?>" ><i class = "fa fa-cog"></i> team</a>
                                <?php endif; ?>
                                <a class="dropdown-item updateStatus pointer" id="<?php echo $row->userId ?>" ><i class = "fa fa-magnet"></i> status</a>
                                <?php if(@$role['updateUser']==1): ?>
                                <a class="dropdown-item updateUserById pointer bg-warning" id="<?php echo $row->userId ?>" ><i class = "fa fa-edit"></i> Update</a>
                              <?php endif; ?>
                                <?php if(@$role['deleteUser']==1): ?>
                                <a class="dropdown-item deleteUserById pointer bg-danger" id="<?php echo $row->userId ?>" ><i class = "fa fa-trash"></i> delete</a>
                              <?php endif; ?>
                            </div>
                        </li>
                    </ul>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
  </div>

<?php endif; ?>
</div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script type="text/javascript">
  $(document).ready(function(){
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
                swal(data);
                $('.loader').hide();
            }
      });
    });
    $('.updateTeam').click(function(){
      var id= $(this).attr('id');
      $('#user_id').val(id);
      $('#updateTeam').modal('show');
    });
    $('.assignUserToProjectById').click(function(){
      var id= $(this).attr('id');
      $.ajax({
         url:"<?php echo URLROOT?>/helpers/loadModel.php",
         method:'POST',
         data:{loadProjectRadio:true,id:id},
         success:function(data){
          $('#projectList').html(data);
          $('#assignProjectModal').modal('show');
         }
      });
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
                swal(data);
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
        url:"<?php echo URLROOT ?>/installations/updatelevel",
        type:'POST',
        // dataType:'JSON',
        data:{updateLevel:true,form:form.serialize()},
        success:function(data){
              $('#updateLevel').modal('hide');
              $('#updateLevelForm')[0].reset();
              $('.loader').hide();
              swal(data)
            }
      });
    });
    // update level stop here
    // update access right start here
    $('.updateaccess').click(function(){
      var id=$(this).attr('id');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/users/access",
        type:'POST',
        // dataType:'JSON',
        data:{loadAccess:true,id:id},
        success:function(data){
          $('#accessBody').html(data);
          $('#updateaccessModal').modal('show');
          $('.loader').hide();
        }
      })

    });
    // update access right stop here
    $('#updateAccessBtn').click(function(){
      var form =$('#access_right');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/users/updateAccess",
        type:'POST',
        // dataType:'JSON',
        data:{updateAccessRight:true,form:form.serialize()},
        success:function(data){
         swal(data);
          $('.loader').hide();
        }
      })
    });
    // update access right stop here
    $('.deleteUserById').click(function(){
      var id=$(this).attr('id');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/users/deleteUser",
        type:'POST',
        data:{deleteUserById:true,id:id},
        success:function(data){
         swal(data);
         //location.reload();
          $('.loader').hide();
        }
      })
    });
    $('.updateUserById').click(function(){
      var id=$(this).attr('id');
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT ?>/Guests/loadMyAccount",
        type:'POST',
        data:{loadUserBasicInfoById:true,id:id},
        success:function(data){
          $('.loader').hide();
          $('#loadMyAccountInfo').html(data);
          $('#updateUserByIdModal').modal('show');
        }
      })
    });
    $('#updateMyBasicInfBtn').click(function(){
      var form =$('#updateBasicInfo');
      $.ajax({
         url:"<?php echo URLROOT?>/Guests/updateMyAccount",
         method:'POST',
         data:{updateBasicInfo:true,form:form.serialize()},
         success:function(data){
           if(data.includes('success')){
              $('#updateBasicInfo')[0].reset();
              $('#updateMyBasicInfBtn').modal('hide');
              swal(data);
            }else{
              $('#updateBasiceMsg').html(data);
            }
         }
      });
    });

    $('#assignProjectBtn').click(function(){
      var form =$('#assignProjectForm');
      $.ajax({
         url:"<?php echo URLROOT?>/Dependency/manageProject",
         method:'POST',
         data:{assignProject:true,form:form.serialize()},
         success:function(data){
           if(data.includes('success')){
              $('#assignProjectForm')[0].reset();
              $('#assignProjectModal').modal('hide');
              swal(data);
            }else{
              $('#assignProjectMsg').html(data);
            }
         }
      });
    });
  });
</script>
<!-- update level modal  -->

<div class="modal fade" id="updateaccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading bg-light">
        <h5 class="modal-title" id="exampleModalLabel">Update Access right </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="" id="accessBody">

        </div>
      </div>
      <div class="modal-footer bg-light">
					<div class="btn-group">
            <button  class="btn btn-primary pull-left btnBox btn-sm" id="updateAccessBtn"><i class="fa fa-edit"></i> Update</button>
            <button type="button" class="btn btn-danger btnBox btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          </div>
      </div>

    </div>
  </div>
</div>
<!-- update access modal stop here  -->
<!-- Asign Project modal start -->
<div class="modal fade" id="assignProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Asign Project </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="assignProjectMsg"></div>
			<form method = "post" id="assignProjectForm">
        <h5 class="ml-3">Projects</h5>
        <div class="modal-body" id="projectList">

        </div>
	     </form>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" id="assignProjectBtn"><i class="fa fa-edit"></i> Update</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Asign Project  modal End here -->
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
        <select type="text" name="group" id="edatS" placeholder="Address" class="form-control form-control-sm " >
          <option disabled selected> SELECT Group</option>
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
          <option disabled selected> SELECT TEAM</option>
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
          <!-- <option  ></option>
          <option  >Team D</option>
          <option  >Team E</option> -->
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
