<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<style media="screen">
  #monthly{
    max-height:110px !important;
    padding: 2px;
    overflow-y: scroll;
    color: #000000;
  }
</style>
<div class = "card card-body  mt-3">
  <ol class="breadcrumb mb-4 mt-1">
    <li class="breadcrumb-item active"> Dashboard </li>
    </ol>
  <div class="row">
        <div class="col-xl-2 col-md-2">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body"><i class="fa fa-sitemap"></i> Companies</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['company']>0){ ?> href="<?php echo URLROOT;?>/users/manage" <?php } ?> >View Details</a>
							<div class="small text-white "><?php echo $data['company'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <div class="col-xl-4 col-md-4">
            <div class="card  mb-4" id="monthly">
  						<?php if($data['monthSummary']): ?>
                <?php foreach($data['monthSummary'] as $row): ?>
                  <span class="small"><small><?php echo date('F, y',strtotime($row->month)) ?></small> | <?php echo $row->names ? ucwords($row->names) : 'none'; ?> |  <?php echo $row->count ?> | <?php echo $row->metertype ?> |  <?php echo $row->status ?>  </span><hr>
                <?php endforeach; ?>
              <?php endif; ?>
  					</div>

				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card text-white mb-4">
						<div class="card-body bg-info"></i><i class="fa fa-exclamation-triangle" ></i> null</div>
						<div class="card-footer bg-success d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" >View Details</a>
							<div class="small text-white">null</div>
						</div>
					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-dark text-white mb-4">
						<div class="card-body"><i class="fa fa-exclamation-circle"></i> Not Installed</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['paidcustomer']>0){  ?> href="<?php echo URLROOT;?>/admins/paid" <?php } ?>  >View Details</a>
							<div class="small text-white "><?php echo $data['paidcustomer'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"><i class="fa fa-check-square"></i> Installed</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['installedmeters']>0){  ?> href="<?php echo URLROOT;?>/admins/installedmeters" <?php } ?> >View Details</a>
							<div class="small text-white "><?php echo $data['installedmeters'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
        <div class="col-xl-3 col-md-3">
					<div class="card bg-info text-white mb-4">
						<div class="card-body"><i class="fa fa-exclamation-triangle"></i> Meters without Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['metersWithoutEdat']>0){ ?> href="<?php echo URLROOT;?>/admins/noedat" <?php } ?> >View Details</a>
							<div class="small text-white "><?php echo $data['metersWithoutEdat'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-3">
					<div class="card bg-primary text-white mb-4">
						<div class="card-body"><i class="fa fa-box-open"></i> Total Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['edatAsigned']>0){ ?> href="<?php echo URLROOT;?>/admins/alledats" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['edatAsigned'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"><i class="fa fa-wifi"></i> Installed Edats</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['instlledEdats']>0){ ?> href="<?php echo URLROOT;?>/admins/installededats" <?php } ?> >View Details</a>
							<div class="small text-white " ><?php echo $data['instlledEdats'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>

        <!-- last row -->
				<div class="col-xl-3 col-md-3">
					<div class="card bg-warning text-white mb-4">
						<div class="card-body"></i><i class="fa fa-exclamation-triangle" ></i> faulty Meter</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['faultyMeters']>0){ ?> href="<?php echo URLROOT;?>/admins/asignedfaultymeters" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['faultyMeters'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-warning text-white mb-4">
						<div class="card-body"></i><i class="fa fa-exclamation-triangle" ></i>  faulty Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['asignedFaultyEdats']>0){ ?> href="<?php echo URLROOT;?>/admins/asignedfaultyedats" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['asignedFaultyEdats'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"></i><i class="fa fa-check-square" ></i> fixed faulty Meter</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" <?php if($data['fixedfaultyMeter']>0){ ?> href="<?php echo URLROOT;?>/admins/fixedfaultymeter" <?php } ?> >View Details</a>
							<div class="small text-white"><?php echo $data['fixedfaultyMeter'];?>&nbsp;&nbsp; <i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-3">
					<div class="card bg-success text-white mb-4">
						<div class="card-body"></i><i class="fa fa-check-square" ></i> fixed faulty Edat</div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link"  <?php if($data['fixedFaultyEdat']>0){ ?> href="<?php echo URLROOT;?>/admins/fixedfaultyedat" <?php } ?>>View Details</a>
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
