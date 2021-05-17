<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<style media="screen">
  #monthly{
    height:110px !important;
    padding: 2px;
    overflow-y: scroll;
    color: #000000;
  }
</style>
<div class = "card card-body  mt-3">
  <ol class="breadcrumb mb-4 mt-1">
      <?php echo $data['companyName'] ?> &nbsp;<li class="breadcrumb-item active"> Dashboard </li>
    </ol>
  <div class="row">
        <div class="col-xl-2 col-md-2">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body"><i class="fa fa-users"></i> Staff</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['staff']>0){ ?> href="<?php echo URLROOT;?>/Installations/staff" <?php } ?> >View Details</a>
							<div class="small text-white "><?php echo $data['staff'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <div class="col-xl-4 col-md-4">
					<div class="card  mb-4" id="monthly">
						<?php if($data['monthly']): ?>
              <?php foreach($data['monthly'] as $row): ?>
                <span><small><?php echo date('F, Y',strtotime($row->month)) ?></small> | <?php echo $row->metertype ?> | Installed: <?php echo $row->count ?>  </span><hr>
              <?php endforeach; ?>
            <?php endif; ?>
					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-info text-white mb-4">
						<div class="card-body"><i class="fa fa-truck"></i> Meter in Store</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['metersAsigned']>0){} ?> >View Details</a>
							<div class="small text-white "><?php echo $data['metersAsigned'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-info text-white mb-4">
						<div class="card-body"><i class="fa fa-store"></i> Edat in Store</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['metersAsigned']>0){} ?> >View Details</a>
							<div class="small text-white "><?php echo $data['metersAsigned'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body"><i class="fa fa-tasks"></i> Asigned CUSTOMER</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['metersAsigned']>0){ ?> href="<?php echo URLROOT;?>/Installations/meters" <?php } ?> >View Details</a>
							<div class="small text-white mr-1"><?php echo $data['metersAsigned'];?> <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"><i class="fa fa-check-square"></i> Installed Meters</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['installedmeters']>0){ ?> href="<?php echo URLROOT;?>/Installations/installedmeters" <?php } ?> >View Details</a>
							<div class="small text-white " ><?php echo $data['installedmeters'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body"><i class="fa fa-tasks"></i> Asigned Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['edatAsigned']>0){ ?> href="<?php echo URLROOT;?>/Installations/edats" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['edatAsigned'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"></i><i class="fa fa-check-square" ></i> Installed Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['instlledEdats']>0){ ?> href="<?php echo URLROOT;?>/Installations/installededats" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['instlledEdats'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <!-- last row -->
				<div class="col-xl-3 col-md-3">
					<div class="card bg-warning text-white mb-4">
						<div class="card-body"></i><i class="fa fa-exclamation-triangle" ></i> faulty Meter</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['asignedFaultyMeters']>0){ ?> href="<?php echo URLROOT;?>/Installations/asignedFaultyMeters" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['asignedFaultyMeters'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-warning text-white mb-4">
						<div class="card-body"></i><i class="fa fa-exclamation-triangle" ></i>  faulty Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['asignedFaultyEdats']>0){ ?> href="<?php echo URLROOT;?>/Installations/asignedFaultyEdats" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['asignedFaultyEdats'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"></i><i class="fa fa-thumbs-up" ></i> fixed faulty Meter</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['fixedfaultyMeter']>0){ ?> href="<?php echo URLROOT;?>/Installations/fixedfaultyMeter" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['fixedfaultyMeter'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"></i><i class="fa fa-thumbs-up" ></i> fixed faulty Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link"  <?php if($data['fixedFaultyEdat']>0){ ?> href="<?php echo URLROOT;?>/Installations/fixedFaultyEdat" <?php } ?>>View Details</a>
							<div class="small text-white"><?php echo $data['fixedFaultyEdat'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
  </div>
</div>
<?php include_once(APPROOT . '/views/inc/footer.php');?>
<script type="text/javascript">
  $(document).ready(function(){

  });
</script>
