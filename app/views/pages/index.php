<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/t7images/title.png">
    <title><?php echo SITENAME;?></title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light header_area">
  <a class="navbar-brand" href="<?php echo URLROOT; ?>"><img src="<?php echo URLROOT; ?>/t7images/t7logo.png" width="200" id="logo" alt="Triple Seventh Logo"> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
        <?php if(isset($_SESSION['mimsUserId'])) : ?>
            <li class="nav-item">
                <span class="nav-link text-primary" > <?php echo strtoupper(userSession());?></span>
            </li>
            <li class="nav-item">
                <a class="nav-link bg-danger" href="<?php echo URLROOT;?>/guests/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
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

<div class="container">
    
    <div id="about">

        <h2>About US</h2><br>
        <h6>TRIPLE SEVENTH NIGERIA LIMITED (TSNL) is a leading pioneer multi-functional company in the field of Utility Management Consultancy, Engineering (Electrical, Water, Civil & Building) and Procurement.
        TSNL was established by professional Engineers with diverse engineering field practices in Nigeria for the past twenty-five years (25years).</h6><br>
        <p>
        TSNL recognizes the need for innovation in services and aims to achieve client satisfaction by employing modern and appropriate techniques tailored to suit the client’s financial resources and the particular environment. A major goal of our services is the achievement of efficiency and sustainability in utilization.

    (TSNL) business-oriented solutions support efficient, effective operation, helping to maximize value in providing a number of services to help identify improvements to optimize Utilities existing systems which can increase revenue earnings by reducing their Aggregate Technical Commercial and Collection (ATC & C) losses, Avoid Regulatory Compliance Issues, quantify and reduce Non-Revenue Water (NRW) and Unaccounted For Water (UFW).
        </p>

    </div>
</div>
<a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();
      // Store hash
      var hash = this.hash;
      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
  $('#meternum').keyup(function(){
	  $('#submitCmpBtn').attr('disabled','disabled');
	  var num = $(this).val();
	  if((num.length)==12){
		$.ajax({
			method:"POST",
			url:"admin/core.php",
			data:{verifyMeterNumber:true,num:num},
			success:function(data){
				if(data){
					$('#submitCmpBtn').removeAttr('disabled')
				}else{alert('PLEASE CONTACT DisCo!')}
		}
	  })
	  }else{}
  });
  $('#submitCmpBtn').click(function(){
	  var form=$('#complainForm');
	$.ajax({
		url:"admin/core.php",
		method:"POST",
		data:{postCustomerComplain:true,form:form.serialize()},
		 success:function(data){
		  alert(data);
		}
    })
   });

})
</script>

<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
