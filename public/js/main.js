$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    // submit fix edat form
    $('#meterForm').on('submit', function(event){
      event.preventDefault();
      $.ajax({
       url:"core.php",
       method:"POST",
       data:new FormData(this),
       // dataType:'json',
       contentType:false,
       cache:false,
       processData:false,
       success:function(data){
        returnState(data,'meterForm');
       }
      })
     });

    // dropdown search
    $('.select2').select2();
    // back to top button
    window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("backToTop").style.display = "block";
        } else {
            document.getElementById("backToTop").style.display = "none";
        }
    }
    // When the user clicks on the button, scroll to the top of the document
    $('#backToTop').click(function(e){
		e.preventDefault();
	$('html, body').animate({scrollTop:0},'100000');
	});

});
