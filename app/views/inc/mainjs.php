<script type="text/javascript">
// $( function() {
//   $(".datepicker").datepicker({
//     dateFormat: 'yy/mm/dd'
//   });
// });
$(document).on('click',function(){
  $('[data-toggle="tooltip"]').tooltip('hide')
})
$(document).ready(function(){
  var Time= new Date();
  setInterval(function(){
   $.ajax({
     method:"POST",
     // dataType:"JSON",
     url:"<?php echo URLROOT?>/helpers/cronjobs.php",
     data:{computeDays:true},
     success:function(data){
       //alert(data);
     }
   });
   var time = Time.getHours();
    var min = Time.getMinutes();
  }, 1000);

  // fix fualty meters goes here
  $('.fixefaultyMeter').click(function(){
    var id = $(this).attr('id');
    $('#mmid').val(id);
    $('#maintainMeterFormModal').modal('show');
  });
  $('#mstatus').change(function(){
    var mn = $(this).val();
    if(mn=='Replacement'){
      $('#meterNumber').show(500);
    }else{
      $('#meterNumber').hide(500);
    }
    // alert(mn)
  });

  // submit fix meter form
  $('#maintainMeterForm').on('submit', function(event){
    event.preventDefault();
    $('.loader').show();
    $.ajax({
     url:"<?php echo URLROOT?>/Faults/fixMeter",
     method:"POST",
     data:new FormData(this),
     // dataType:'json',
     contentType:false,
     cache:false,
     processData:false,
     success:function(data){
       if(data.includes('success')){
          $('#maintainMeterForm')[0].reset();
 					$('#maintainMeterFormModal').modal('hide');
 					swal(data);
 				}else{
          swal({
             title: "Error",
             text: data,
             icon: "warning",
           });
           if(data.includes('updated but issue not solved')){
             $('#maintainMeterForm')[0].reset();
           }
 				}
        $('.loader').hide();
     }
    })
   });
   // fix faulty edat modal
   $('.fixfaultyEdat').click(function(){
     var id=$(this).attr('id');
     $('#edat_Id').val(id);
     $('#maintainEdatFormModal').modal('show');
   });
   $('#estatus').change(function(){
     var mn = $(this).val();
     if(mn=='Replacement'){
       $('#newedat').show(500);
     }else{
       $('#newedat').hide(500);
     }
   });

   // submit fix edat form
   $('#maintainEdatForm').on('submit', function(event){
     $('.loader').show();
     event.preventDefault();
     $.ajax({
      url:"<?php echo URLROOT?>/Faults/fixEdat",
      method:"POST",
      data:new FormData(this),
      // dataType:'json',
      contentType:false,
      cache:false,
      processData:false,
      success:function(data){
        if(data.includes('success')){
           $('#maintainEdatForm')[0].reset();
  					$('#maintainEdatFormModal').modal('hide');
  					swal(data);
  				}else{
  					swal(data);
  				}
          $('.loader').hide();
      }
     })
    });

   // fix faulty edat stop here
   $('.myaccountsetting').click(function(){
     $('.loader').show();
     var id = $(this).attr('id');
     $.ajax({
       url:"<?php echo URLROOT?>/Guests/loadMyAccount",
       method:"POST",
       data:{loadMyDetails:true,id:id},
       success:function(data){
         $('#loadMyAccountDetails').html(data);
         $('.loader').hide();
         $('#myaccount').modal('show');
       }
     });
   });
   // submit fix edat form
   $('#updateMyAccount').click(function(){
     $('.loader').show();
     var form=$('#updateMyInfo');
     $.ajax({
        url:"<?php echo URLROOT?>/Guests/updateMyAccount",
        method:'POST',
        data:{updatingMyAccount:true,form:form.serialize()},
        success:function(data){
          if(data.includes('success')){
             $('#updateMyInfo')[0].reset();
    					$('#myaccount').modal('hide');
    					swal(data);
    				}else{
    					swal(data);
    				}
            $('.loader').hide();
        }
     });
   });

   // show hide password
   var state=false;
   $('.togglePwd').click(function(){
     if(state===false){
       $('#pwd').attr('type','text');
       $('#cpwd').attr('type','text');
       $('#npwd').attr('type','text');
       state=true;
     }else{
       $('#pwd').attr('type','password');
       $('#cpwd').attr('type','password');
       $('#npwd').attr('type','password');
       state=false;
     }
   });
   $('#updatePwd').click(function(){
     var form =$('#updatePwdForm');
     $('.loader').show();
     $.ajax({
        url:"<?php echo URLROOT?>/Guests/updatePwd",
        method:'POST',
        data:{updatingPwd:true,form:form.serialize()},
        success:function(data){
          if(data.includes('success')){
             $('#updatePwdForm')[0].reset();
             $('#updatepassword').modal('hide');
             swal(data);
           }else{
             swal(data);
           }
           $('.loader').hide();
        }
     });
   });
   // inventory goes down here
   // waybill goes down here
   $('#storeTo').change(function(){
     var id=$(this).val();
     $.ajax({
       url:"<?php echo URLROOT?>/helpers/dropdown.php",
       type:"POST",
       dataType:"json",
       data:{loaditems:true,id:id},
       success:function(data){
         $('#items').html(data.items);
         $('#itemIdLabel').show(500);
         $('#formContent').html('');
       }
     });
   });
   $(document).on('change','#displayedItems',function(){
     var id = $(this).val();
     $.ajax({
         url:"<?php echo URLROOT?>/Inventories/loadItem",
         type:"POST",
         dataType:'json',
         data:{loadItemDetails:true,id:id},
         success:function(data){
           $('#formContent').prepend(data.item);
         }
     });
   });
   $(document).on('click','.remove',function(){
     var id=$(this).attr('id');
     $('#row'+id).remove();
   });

   $('#wayBillBtn').click(function(){
     var form=$('#wayBillForm');
     $('.loader').show();
     $.ajax({
       url:"<?php echo URLROOT?>/Inventories/inOutWayBill",
       type:"POST",
       dataType:'JSON',
       data:{wayBillItems:true,form:form.serialize()},
       success:function(data){
         $('.loader').hide();
          if(data.msg=='success'){
            location.href="<?php echo URLROOT;?>/Inventories/printWaybill/"+(data.waybill);
          }else{swal(data.msg);}
       }
     });
   });
   // waybill stop here
   // map edat and meters
   $(document).on('click','.pair',function(){
     var id=$(this).attr('id');
     $.ajax({
       url:"<?php echo URLROOT ?>/helpers/dropdown.php",
       type:"POST",
       data:{loadEdat:true,id:id},
       success:function(data){
         $('#edatsdetails').html(data);
         $('#mapEdatMeter').modal('show');
       }
     });
   });
   $('#mapEdatToMeter').click(function(){
     $('.loader').show();
     var form=$('#mapEdatMeterForm');
     var id=$('#edatId').val();
     if(id !==null){
       $.ajax({
         url:"<?php echo URLROOT ?>/maintainance/mapEdatMeter",
         type:"POST",
         data:{mapEdatToMeter:true,form:form.serialize()},
         success:function(data){
           $('.loader').hide();
           if(data.includes('success')){
               $('#mapEdatMeter').modal('hide');
               $('#'+form)[0].reset();
                swal({
                   title: "",
                   text: data,
                   icon: "success",
                 });
               location.reload();
             }else{
               swal(data);
             }
         }
       });
     }else{
       swal({
           title: "Error",
           text: 'Select an Edat',
           icon: "danger",
         });
         $('.loader').hide();
     }
   });
});
</script>
