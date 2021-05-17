<?php
	$access=mimsAccessRight(base64_decode($_SESSION['mimsUserId']));
	$str='$role='.'array('.$access.');';
	eval($str);
?>
<div id="layoutSidenav">
	<div id="layoutSidenav_nav">
		<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
			<div class="sb-sidenav-menu">
				<div class="nav">
					<!-- <div class="sb-sidenav-menu-heading" id ="core">Core</div> -->
					<?php if(@$role['landing']==1) : ?>
								<a class="nav-link" href="<?php echo URLROOT;?>/dashboards"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt mr-1"></i></div>Dashboard</a>
					<?php endif; ?>
					<?php if(@$role['home']==1): ?>
						<a class="nav-link" href="<?php echo URLROOT;?>/admins"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt mr-1"></i></div>Home</a>
					<?php endif; ?>
					<?php if(@$role['meter']==1): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#meters" aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fa fa-lightbulb"></i></div>
							Meters
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="meters" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav small">
								<?php if(@$role['bash']==1): ?>
									<a class="nav-link collapsed pointer" data-toggle="modal" data-target="#importForm" aria-expanded="false" aria-controls="pagesCollapseAuth"><i class="fa fa-cloud mr-1"></i> Batch Upload</a>
								<?php endif; ?>
								<a class="nav-link collapsed" href="<?php echo URLROOT;?>/meters/schedule"><i class="fa fa-upload mr-1"></i>Upload Meter</a>
								<?php if(@$role['paid']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/meters/index" ><i class="fa fa-check-square mr-1"></i>Installed Meters</a>
								<?php endif; ?>
								<?php if(@$role['record']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/meters/record" ><i class="fa fa-check-square mr-1"></i>Daily Installations</a>
								<?php endif; ?>
								<?php if(@$role['record']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/meters/couple" ><i class="fa fa-check-square mr-1"></i>Daily Coupling</a>
								<?php endif; ?>
								<a class="nav-link collapsed" href="<?php echo URLROOT;?>/meters/list"><i class="fa fa-upload mr-1"></i>List</a>
							</nav>
						</div>
					<?php endif; ?>
					<?php if(@$role['manage_edat']==1): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#edats" aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fa fa-box-open"></i></div>
							Edats
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="edats" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav small">
								<?php if(@$role['schedule']==1): ?>
									<a class="nav-link collapsed"  href="<?php echo URLROOT;?>/edats/edat"><i class="fa fa-compass mr-1 mr-1"></i> Schedule Edat</a>
								<?php endif; ?>
								<?php if(@$role['view']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/edats/index" ><i class="fa fa-eye mr-1 mr-1"></i> View Edats</a>
								<?php endif; ?>
							</nav>
						</div>
					<?php endif; ?>
					<?php if(@$role['maintaninace']==1): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#mantainance" aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
							Maintainance
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="mantainance" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav small">
								<?php if(@$role['m_meter']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/maintainance/meter"> <i class="fa fa-lightbulb mr-1"></i> Meter</a>
								<?php endif; ?>
								<?php if(@$role['m_edat']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/maintainance/edat"><i class="fa fa-box-open mr-1"></i>Edat</a>
								<?php endif; ?>
								<?php if(@$role['m_edat']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/maintainance/pair"><i class="fa fa-box-open mr-1"></i>Pair Edat</a>
								<?php endif; ?>
								<?php if(@$role['m_edat']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/maintainance/box"><i class="fa fa-box mr-1"></i>Meter Box</a>
								<?php endif; ?>
							</nav>
						</div>
					<?php endif; ?>
					<?php if(@$role['company']==1): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#company" aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
							Company
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="company" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav small">
								<?php if(@$role['cmp']==1): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/installations"><i class="fa fa-home mr-1"> </i> Home</a>
								<?php endif; ?>
							</nav>
						</div>
					<?php endif; ?>
					<?php if(@$role['installer']==1): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Installer" aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
							Installer
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="Installer" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav small">
								<a class="nav-link collapsed" href="<?php echo URLROOT;?>/installers"><i class="fa fa-home mr-1"> </i> Home</a>
							</nav>
						</div>
					<?php endif; ?>
					<?php if(@$role['users']==1): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user" aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
							Users
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="user" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav">
								<?php if(@$role['user']==1): ?>
									<a class="nav-link collapsed small" href="<?php echo URLROOT;?>/users/user">Users Management</a>
								<?php endif; ?>
								<?php if(@$role['create']==1): ?>
									<a class="nav-link collapsed samll" href="<?php echo URLROOT;?>/users/create">Create Company</a>
								<?php endif; ?>
								<?php if(@$role['cmp_mng']==1): ?>
									<a class="nav-link collapsed small" href="<?php echo URLROOT;?>/users/manage">Company Management</a>
								<?php endif; ?>
							</nav>
						</div>
					<?php endif; ?>
					<?php if(@$role['inventory']==10): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inventary" aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fa fa-home"></i></div>
							Inventory
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="inventary" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav small">
								<?php if(@$role['bin']==10): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/inventories/index"><i class="fa fa-inbox mr-1"></i> Inventory</a>
								<?php endif; ?>
								<?php if(@$role['waybill']==10): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/inventories/waybills"><i class="fa fa-ticket mr-1"></i> Way Bill</a>
								<?php endif; ?>
								<?php if(@$role['lend']==10): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/inventories/lend"><i class="fa fa-thumbs-up mr-1"></i> Lend</a>
								<?php endif; ?>
								<?php if(@$role['sr_in']==10): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/inventories/sr_in"><i class="fa fa-inbox mr-1"></i> SR_IN</a>
								<?php endif; ?>
								<?php if(@$role['sr_cn']==10): ?>
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/inventories/sr_cn"><i class="fa fa-inbox mr-1"></i> SR_CN</a>
								<?php endif; ?>
							</nav>
						</div>
					<?php endif; ?>
					<?php if(@$role['inventory']==1): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stores" aria-expanded="false" aria-controls="collapsePages">
							<div class="sb-nav-link-icon"><i class="fa fa-home"></i></div>
							Store
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="stores" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
							<nav class="sb-sidenav-menu-nested nav small">
								 <?php if(@$role['bin']==1): ?> 
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/stores/index"><i class="fa fa-inbox mr-1"></i> Inventory</a>
								 <?php endif; ?> 
								 <?php if(@$role['myrequest']==1): ?> 
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/stores/myrequest"><i class="fa fa-inbox mr-1"></i>My Request</a>
								 <?php endif; ?> 
								 <?php if(@$role['requestlist']==1): ?> 
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/stores/requestlist"><i class="fa fa-inbox mr-1"></i>Request LIST</a>
								 <?php endif; ?> 
								 <?php if(@$role['waybill']==1): ?> 
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/stores/waybills"><i class="fa fa-ticket mr-1"></i> Way Bill</a>
								 <?php endif; ?> 
								 <?php if(@$role['lend']==1): ?> 
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/stores/lend"><i class="fa fa-thumbs-up mr-1"></i> Lend</a>
								 <?php endif; ?> 
								 <?php if(@$role['lend']==1): ?> 
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/stores/lendlist"><i class="fa fa-thumbs-up mr-1"></i> List</a>
								 <?php endif; ?> 
								 <?php if(@$role['sr_in']==1): ?> 
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/stores/sr_in"><i class="fa fa-inbox mr-1"></i> SR_IN</a>
								 <?php endif; ?> 
								 <?php if(@$role['sr_cn']==1): ?> 
									<a class="nav-link collapsed" href="<?php echo URLROOT;?>/stores/sr_cn"><i class="fa fa-inbox mr-1"></i> SR_CN</a>
								 <?php endif; ?> 
							</nav>
						</div>
					<?php endif; ?>
					<?php if(@$role['settings']==1): ?>
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settings" aria-expanded="false" aria-controls="collapsePages">
						<div class="sb-nav-link-icon"><i class="fas fa-cogs  mr-1"></i></div>
						Setting
						<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
					</a>
					<div class="collapse" id="settings" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
						<nav class="sb-sidenav-menu-nested nav">
							<a class="nav-link collapsed" href="<?php echo URLROOT;?>/dependency/index"> Dependency</a>
						</nav>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="sb-sidenav-footer">
Elevate Techie...
			</div>
		</nav>
	</div>
	<div id="layoutSidenav_content">
