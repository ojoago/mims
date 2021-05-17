<?php include_once(APPROOT . '/views/admin.inc/header.php');?>

<style>
  #myActivity{
    height: 110px;
    overflow-y: auto;
    padding-left: 15px;
  }
  #monthly{
    height:110px !important;
    padding: 2px;
    overflow-y: scroll;
    color: #000000;
  }
</style>
<div class = "card card-body  mt-3">
  <ol class="breadcrumb mb-4 mt-1">
      <h4><?php echo strtoupper(UID()) ?> <small><small> <?php echo$data['companyName'] ?></small></small></h4> &nbsp;<li class="breadcrumb-item active"> Dashboard </li>
    </ol>
  <div class="row">
        <div class="col-xl-6 col-md-6">
          <div class="card  mb-4" id="monthly">
						<?php if($data['monthly']): ?>
              <?php foreach($data['monthly'] as $row): ?>
                <span><small><?php echo date('F, Y',strtotime($row->month)) ?></small> | <?php echo $row->metertype ?> | Installed: <?php echo $row->count ?>  </span><hr>
              <?php endforeach; ?>
            <?php endif; ?>
					</div>
				</div>
        <div class="col-xl-6 col-md-6">
					<div class="card mb-4" id="myActivity">
						<div class="card-body" id="activity"><i class="fa fa-tasks"></i> ACTIVITY</div>

					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body"><i class="fa fa-tasks"></i> Asigned CUSTOMER</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['metersAsigned']>0){ ?> href="<?php echo URLROOT;?>/installers/meters" <?php } ?> >View Details</a>
							<div class="small text-white "><?php echo $data['metersAsigned'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"><i class="fa fa-lightbulb"></i> Installed Meters</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['installedmeters']>0){ ?> href="<?php echo URLROOT;?>/installers/installedmeters" <?php } ?> >View Details</a>
							<div class="small text-white " ><?php echo $data['installedmeters'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-info text-white mb-4">
						<div class="card-body"><i class="fa fa-tasks"></i> Asigned Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['edatAsigned']>0){ ?> href="<?php echo URLROOT;?>/installers/edats" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['edatAsigned'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"></i><i class="fa fa-check-square" ></i> Installed Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['instlledEdats']>0){ ?> href="<?php echo URLROOT;?>/installers/installededats" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['instlledEdats'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <!-- last row -->
				<div class="col-xl-3 col-md-3">
					<div class="card bg-dark text-white mb-4">
						<div class="card-body"></i><i class="fa fa-exclamation-triangle" ></i> faulty Meter</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['asignedFaultyMeters']>0){ ?> href="<?php echo URLROOT;?>/installers/asignedFaultyMeters" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['asignedFaultyMeters'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-dark text-white mb-4">
						<div class="card-body"></i><i class="fa fa-exclamation-triangle" ></i>  faulty Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['asignedFaultyEdats']>0){ ?> href="<?php echo URLROOT;?>/installers/asignedFaultyEdats" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['asignedFaultyEdats'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"></i><i class="fa fa-thumbs-up" ></i> fixed faulty Meter</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['fixedfaultyMeter']>0){ ?> href="<?php echo URLROOT;?>/installers/fixedfaultyMeter" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['fixedfaultyMeter'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"></i><i class="fa fa-thumbs-up" ></i> fixed faulty Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link"  <?php if($data['fixedFaultyEdat']>0){ ?> href="<?php echo URLROOT;?>/installers/fixedFaultyEdat" <?php } ?>>View Details</a>
							<div class="small text-white"><?php echo $data['fixedFaultyEdat'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
  </div>
</div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script type="text/javascript">
function myActivity(){
  $.ajax({
    url:"<?=URLROOT ?>/helpers/dropdown.php",
    type:'POST',
    dataType:'JSON',
    data:{myActivities:true},
    success:function(data){
      $('#activity').html(data.activity);
    }
   })
}
    $(document).ready(function(){
      myActivity();
    });
</script>
