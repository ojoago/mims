<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  .table{
    font-size:10px;
    font-family: 'Open Sans', sans-serif;
    max-height:400px;
  }
  .state,.region,.bigfeeder,.feeder{
    overflow-y:auto !important;
  }
  /* .card-body{
      height:430px;
      overflow-y:auto;
  } */
  #addProjectBtn{
    float: right !important;
  }
</style>
<div class="row">
    <div class="card card-body  mt-1">
       <div class="row">
         <div class="col-md-6 col-lg-6 col-xl-6 region">
           <div class="card-header"><i class="fas fa-table mr-1"></i>Projects
             <button class="btn btn-primary btn-sm" id = "addProjectBtn" type="button" data-toggle="tooltip" data-placement="left" title="Add New level" ><i class="fa fa-plus"></i></button>
             <table class="table table-bordered table-stripe table-hover" width="100%">
               <thead>
                 <tr>
                   <th width="5%">S/N</th>
                   <th >Project</th>
                   <th >Description</th>
                   <th >Company</th>
                   <th width="5%"><i class="fa fa-cog"></i></th>
                 </tr>
               </thead>
               <tbody>
             <?php $n=0; foreach($data['projects'] as $row) : ?>
                 <tr><td><?=++$n?></td>
                   <td class="pname" id="pname<?php echo $row->id ?>"><?php echo $row->pname ?></td>
                   <td id="pdsc<?php echo $row->id ?>"><?php echo $row->pdsc ?></td>
                   <td><?php echo $row->names ?></td>
                 <td>
                 <i class="fa fa-edit editPname text-warning pointer" data-toggle="tooltip" data-placement="top" title="EDIT" id="<?php echo $row->id ?>" ></i>
                 </td>
                 </tr>
             <?php endforeach;?>
             </tbody>
             </table>
         </div>
        </div>
        <div class="col-md-3 col-lg-3 col-xl-3 state">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Team</div>
        <div class="input-group">
            <input class="form-control form-control-sm" id="newTeam" type="text" placeholder="New Team" aria-label="Search" aria-describedby="basic-addon2" />
            <div class="input-group-append">
                <button class="btn btn-primary btn-sm" id = "addTeamBtn" type="button" data-toggle="tooltip" data-placement="top" title="Add New Team" ><i class="fa fa-plus"></i></button>
            </div>
        </div>
            <table class="table table-bordered table-stripe table-hover" width="100%">
              <thead>
                <tr >
                  <th width="5%" >S/N</th>
                  <th >Team</th>
                  <th width="5%"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
            <?php $n=0;foreach($data['team'] as $row) : ?>
            <tr>
                <td><?=++$n?></td>
                <td contenteditable  class="team" id="team<?php echo $row->id ?>"><?php echo $row->team?></td>
                <td>
                <i class="fa fa-edit editTeam text-warning pointer" data-toggle="tooltip" data-placement="top" title="EDIT" id="<?php echo $row->id ?>" ></i>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
            </table>
        </div>
        <div class="col-md-3 col-lg-3 col-xl-3 region">
          <div class="card-header"><i class="fas fa-table mr-1"></i>LEVEL
          <div class="input-group">
              <input class="form-control form-control-sm" id="newLevel" type="text" placeholder="New Level">
              <div class="input-group-append">
                  <button class="btn btn-primary btn-sm" id = "addLevelBtn" type="button" data-toggle="tooltip" data-placement="top" title="Add New level" ><i class="fa fa-plus"></i></button>
              </div>
          </div>
        <table class="table table-bordered table-stripe table-hover" width="100%">
              <thead>
                <tr>
                  <th width="5%">S/N</th>
                  <th >LEVEL</th>
                  <th width="5%"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
            <?php $n=0; foreach($data['role'] as $row) : ?>
                <tr><td><?=++$n?></td>
                  <td contenteditable class="role" id="role<?php echo $row->id ?>"><?php echo $row->role ?></td>
                <td>
                <i class="fa fa-edit editRole text-warning pointer" data-toggle="tooltip" data-placement="top" title="EDIT" id="<?php echo $row->id ?>" ></i>
                </td>
                </tr>
            <?php endforeach;?>
            </tbody>
            </table>
        </div>
       </div>
    </div>
  </div>
</div>

<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script>
    $(document).ready(function(){
      $('#addTeamBtn').click(function(){
         var txt = $('#newTeam').val();
         $.ajax({
           url:"<?php echo URLROOT ?>/dependency/addTeam",
           type:"POST",
           data:{newTeam:true,team:txt},
           success:function(data){
             swal(data);
             if(data.includes('success')){
               $('#newTeam').val('');
               location.reload();
             }
           }
         });
      });
      $('.editTeam').click(function(){
        var id=$(this).attr('id');
        var txt=$('#team'+id).text();
        $.ajax({
          url:"<?php echo URLROOT ?>/dependency/addTeam",
          type:"POST",
          data:{updateTeam:true,team:txt,id:id},
          success:function(data){
            swal(data)
          }
        });
      });
      $('#addLevelBtn').click(function(){
         var txt = $('#newLevel').val();
         $.ajax({
           url:"<?php echo URLROOT ?>/dependency/addRole",
           type:"POST",
           data:{newRole:true,role:txt},
           success:function(data){
             swal(data);
             if(data.includes('success')){
               $('#newTeam').val('');
               location.reload();
             }
           }
         });
      });
      $('.editRole').click(function(){
        var id=$(this).attr('id');
        var txt=$('#role'+id).text();
        $.ajax({
          url:"<?php echo URLROOT ?>/dependency/addRole",
          type:"POST",
          data:{updateRole:true,role:txt,id:id},
          success:function(data){
            swal(data)
          }
        });
      });
      $('#addProjectBtn').click(function(){
        $('#manageProjectForm')[0].reset();
        $('#manageProjectModal').modal('show')
        $('#manageProjectFormMsg').html('');
      });
      $('.editPname').click(function(){
        $('#manageProjectForm')[0].reset();
        var id=$(this).attr('id');
        $('#projectId').val(id);
        $('#projectName').val($('#pname'+id).text());
        $('#projectDsc').val($('#pdsc'+id).text());
        $('#manageProjectModal').modal('show');
        $('#manageProjectFormMsg').html('');
      });
      $('#manageProjectBtn').click(function(){
        var form =$('#manageProjectForm');
        $.ajax({
           url:"<?php echo URLROOT?>/Dependency/manageProject",
           method:'POST',
           data:{addProject:true,form:form.serialize()},
           success:function(data){
             if(data.includes('success')){
                $('#manageProjectForm')[0].reset();
                $('#manageProjectModal').modal('hide');
                swal(data);
                location.reload()
                $('#manageProjectFormMsg').html('');
              }else{
                $('#manageProjectFormMsg').html(data);
              }
           }
        });
      });
    });
</script>
<div class="modal fade" id="manageProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content panel panel-default">
      <div class="modal-header panel-heading">
        <h5 class="modal-title" id="exampleModalLabel">Manage Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="manageProjectFormMsg"></div>
			<form method = "post" id="manageProjectForm">
        <div class="modal-body" id="projectList">
          <div class="form-group">
            <input type="hidden" name="id" id="projectId">
            <input type="text" name="project" id="projectName" class="form-control form-control-sm" placeholder="Project Name">
          </div>
          <div class="form-group">
            <textarea type="text" name="dsc" id="projectDsc" class="form-control form-control-sm" placeholder="Description"></textarea>
          </div>
          <div class="form-group">
            <select class="select2 form-control form-control-sm" name="state" id="state" style="width:100%;">
              <option disabled selected>SELECT STATE</option>
              <option>BAUCHI</option>
              <option>GOMBE</option>
              <option>PLATEAU</option>
              <option>BENUE</option>
            </select>
          </div>
          <div class="form-group">
            <select class="select2 form-control form-control-sm" name="zone" id="zone" style="width:100%;">
              <option disabled selected>SELECT ZONE</option>
              <option>BAUCHI</option>
              <option>GOMBE</option>
              <option>AZARE</option>
              <option>ZARIA ROAD</option>
              <option>MEKERI</option>
            </select>
          </div>
          <div class="form-group">
            <select class="select2 form-control form-control-sm" name="cid" id="cid" style="width:100%;">
              <option disabled selected>Select Company</option>
              <?php company() ?>
            </select>
          </div>
        </div>
	     </form>
      <div class="modal-footer">
					<button  class="btn btn-primary pull-left btn-sm" id="manageProjectBtn"><i class="fa fa-edit"></i>Submit</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>
