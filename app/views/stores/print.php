<?php include_once(APPROOT . '/views/admin.inc/header.php');?>
<?php
  $tab='&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;&nbsp;&#9;';
  // print_r($data);
 ?>
 <style>
     #sentBy{
       width: 200px;
     }
    #waybill{
       width: 800px;
       font-family:Arial,'Courier New', Monaco, monospace !important;
       font-size: 14px;
       margin-left: auto;
       margin-right: auto;
       padding: 10px;
       border-radius:3px;
	     box-shadow: 0 0 15px 1px rgba(0,0,0,0.4);
     }
     #logBox{
       width: 100% !important;
       margin-bottom: 10px;
       display: inline-block;
     }
    #logBox>img{
      width: 300px;
      height: auto;
      float: right !important;
      margin-bottom:  15px !important;
    }

    .box{
      border: 1px solid black;
      margin: 3px;
      text-transform: uppercase;
      height: 105px;
    }
    #receiverside{
      text-transform: uppercase;
      width: 470px !important;
      padding: 3px;
    }
    #gsm{
      float: left !important;
    }
    .underline{
      border-bottom:2px dotted #000;
      margin-bottom: 15px !important;
    }
    .column{
      margin: 5px;
      text-transform: uppercase;
    }
    #waybillside{
      width: 290px;
      padding-right: 0 !important;
    }
    .leftpadding{
      padding-left: 4px;
    }
    #waydate{
      width: 100%;
      display: inline-block;
    }
    .left{
      float: left !important;
    }
    .right{
      float: right !important;
    }
    #waybillfooter{
      background-color:  #000;
      color: #fff;
      padding: 5px;
      margin-top: 3px;
    }
    #developer{
      display: none;
    }
    @media print{
      select,button,title,footer,header,head,#sentBy,.select2{
        display: none !important;
      }
      #waybill{
         width: 100% !important;
         font-family:Arial,'Courier New', Monaco, monospace !important;
         font-size: 14px;
         margin-left: auto;
         margin-right: auto;
         padding: 10px;
         border-radius:3px;
  	     box-shadow: 0 0 15px 1px rgba(0,0,0,0.4);
       }
       #logBox{
         width: 100% !important;
         margin-bottom: 10px;
         display: inline-block;
       }

      .box{
        border: 1px solid black;
        margin: 3px;
        text-transform: uppercase;
        height: 105px;
      }
      #receiverside{
        text-transform: uppercase;
        width: 67% !important;
        padding: 5px;
      }
      #gsm{
        float: left !important;
      }
      .underline{
        border-bottom:2px dotted #000;
        margin-bottom: 15px !important;
      }
      .column{
        margin: 5px;
        text-transform: uppercase;
      }
      #waybillside{
        width: 30% !important;
        padding-right: 0 !important;
      }
      .leftpadding{
        padding-left: 4px;
      }
      #waydate{
        width: 100%;
        display: inline-block;
      }
      .left{
        float: left !important;
      }
      .right{
        float: right !important;
      }
      #waybillfooter{
        background-color:  #000 !important;
        color: #fff !important;
        padding: 5px;
        margin-top: 3px;
        text-align: center !important;
      }
      #waybillfooter span{
        background-color:  #000 !important;
        color: #fff !important;
      }
      #developer{
        display: none;
      }
      thead>.hRow{
        margin-top: 3px !important;
        background-color: black !important;
        color: #fff !important;
        font-size: 14px !important;
      }
      /* .hRow{
          border: 1px solid #fff !important;
          background-color: #0000 !important;
          color: #fff !important;
        }
        .hRow > th{
          border: 1px solid #fff !important;
          background: #000 !important;
          color: #fff !important;
        } */
      .tRow{
          border: 1px solid #000 !important;
        }
        .tRow > td{
          border: 1px solid #000 !important;
          font-size: 14px !important;
        }
      /* #waybillfooter{
        background: black !important;
        color: white !important;
        padding: 5px !important;
        margin-top: 3px !important;

      } */
      /* th{
        background: black !important;
      }
      #waybillfooter{
        width: 100% !important;
        background: black !important;
        color: #fff  !important;
        padding: 5px !important;
        margin-top: 3px !important;
      }
      tr>td{
        border: 1px solid black !important;
      }
      .text-dark{
        background: black !important;
      }
      #developer{
        display: none !important;
      } */
    }
 </style>
 <section id="waybill">
   <div id="logBox">
     <img src="<?php echo URLROOT ?>/t7images/t7logo.png" alt="logo"  class="img img-responsive" >
   </div>
   <span id="receiverside" class="pull-left left box">
     <span id="issueto" class="underline left">Request by: <?php echo$data['data']->requestby; ?></span>
     <span id="issueto" class="underline right">aproved by: <?php echo$data['data']->aprovedby; ?></span><br>
     <br>
     <span id="gsm" class="left  column">GSM: <span class="underline"><?php echo $tab.$tab; ?></span></span>
     <span id="jobno"class="right column">JOB NO. <span class="underline"><?php echo $tab.$tab; ?></span></span>
     <span id="deliver" class="left column">delivered by: <span class="underline"><?php echo $tab.$tab; ?></span></span>
     <span id="lpo" class="right column">lpo: <span class="underline"><?php echo $tab.$tab; ?></span></span>
   </span>
   <span id="waybillside" class="pull-right right box">
     <h4 class="bg-dark text-white text-center">WAYBILL</h4>
     <span id="waydate" class="leftpadding">sent by: <span class="underline" id="sentru"><?php echo$data['data']->sentby; ?> </span>&nbsp;</span>
     <span id="waydate" class="leftpadding">Date: <span class="underline"><?php echo$data['data']->date; ?>&nbsp; </span></span>
     <span id="" class="leftpadding" >WAYBILL NO: <span class="underline"><?php echo$data['data']->wbi; ?>&nbsp; </span></span>
   </span>
   <table class="table table-bordered small table-striped table-hover ">
     <thead class="bg-dark text-white">
       <tr class="hRow">
         <th width="5%">S/N</th>
         <th width="35%">Quantity</th>
         <th width="60%">Description</th>
       </tr>
     </thead>
     <tbody>
       <?php $id=$n=0; foreach ($data['info'] as $row): ?>
         <tr class="tRow">
           <!-- <php if ($id==$row->id): ?>
                  <php continue; ?>
           <php endif; ?> -->
           <td><?php echo ++$n;//$id=$row->id ?></td>
           <td><?php echo $row->quantity .' '.$row->unit ?></td>
           <td><?php echo $row->name .', '.$row->dsc.', '.$row->batch ?></td>
         </tr>
       <?php endforeach; ?>
     </tbody>
     <tfoot>

     </tfoot>
   </table>
   <span id="rname" class="underline column">Receiver's name: <?php echo$data['data']->receivedby; ?> </span>
   <span id="rsign" class="underline column">Receiver's signature: <?php echo $tab; ?></span>
  <span id="rdate" class="underline column">Date: <?php echo $tab.$tab; ?></span><br>
   <div id="waybillfooter">
     <span class=""><i class="fa fa-location-arrow"></i>JOS  KADUNA  ABUJA  BAUCHI  GOMBE |</span>
     <span class=""><i class="fa fa-phone"></i> +234 (0)8066446677 <i class="fa fa-envelope"></i> info@tripplesventh.com, triplesventh@yahoo.com</span>
      <div class="text-center" id="developer">
        <small >powered by: ELEVATE TECHIE: <strong>dhasmom01@gmail.com</strong></small>
      </div>
   </div>

 </section>
 <div class="row p-3">
   <div class="col">

   </div>
   <div class="col">
     <select class="select2" id="sentBy">
       <option disabled selected>Sent By</option>
       <option >HAND</option>
       <option >TRUCK</option>
       <option >TRAIN</option>
       <option >AIR</option>
       <option >CAR</option>
       <option >BUS</option>
       <option >TANKER</option>
       <option >SEA</option>
       <option >OTHERS</option>
     </select>
   </div>
   <div class="col">
     <?php if (!empty(@$data['data']->sentby)): ?>
       <button  onClick="javascript:$('#carTable').printThis({importCSS: true, importStyle: true,displayTitle:false});" class="btn btn-success" id="printReceipt" title="Print Receipt" data-toggle="tooltip" data-placement="right"><i class="fa fa-print  fa-lg"></i></button>
     <?php endif; ?>
   </div>
 </div>

<?php include_once(APPROOT . '/views/inc/footer.php'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#sentBy').change(function(){
      var sentBy=$(this).val();
      $('.loader').show();
      $.ajax({
        url:"<?php echo URLROOT;?>/function_helpers.php",
        type:"POST",
        data:{updateWaybillSentMethod:true,sentBy:sentBy,id:'<?php echo @$data['data']->waybill ?>'},
        // dataType:"JSON",
        success:function(data){
            $('.loader').hide();
            location.reload();
      }
      // $('#sentru').text(sentBy);
      // $('#printReceipt').show(500);
    });
  });
  });
</script>
