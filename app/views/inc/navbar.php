<nav class="navbar navbar-expand-lg navbar-light bg-light header_area mb-3">
  <a class="navbar-brand" href="<?php echo URLROOT; ?>"><img src="<?php echo URLROOT; ?>/t7images/t7logo.png" width="200" id="logo" alt="Triple Seventh Logo"> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo URLROOT;?>/pages">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URLROOT;?>/pages/about">About</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <?php if(isset($_SESSION['mimsUserId'])) : ?>
            <li class="nav-item">
                <span class="nav-link" >Weclome <?php echo strtoupper(base64_decode($_SESSION['mimsUid']));?></span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT;?>/guests/logout"><i class="fas fa-sign-out"></i> Logout</a>
            </li>
        <?php else : ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT;?>/guests/register">Register <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT;?>/guests/login">Login</a>
        </li>
        <?php endif; ?>
    </ul>
  </div>
</nav>
<div class="container-fluid">
