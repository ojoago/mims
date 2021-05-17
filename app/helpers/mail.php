<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
function smtpmailer($to,$subject,$body){
  $BODY='<!DOCTYPE html PUBLIC "-//W#C//DTD XHTML 1.0 Transitional//EN" "http://www.w3org/TR/xhtml1/DTD/xhtml1-transional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>'.SITENAME.'</title>
      <style type="text/css">
        body{
          margin:0;
          padding:0;
          background-color: #f6f9fc;
        }
        table{
          border-spacing:0;
        }
        td{
          padding:0;
        }
        img{
          border:0;
        }
        .wrapper{
          width: 100%;
          table-layout: fixed;
          background-color: #f6f9fc;
          padding-bottom: 40px;
        }
        .webkit{
          max-width: 600px;
          background-color: #ffffff;
        }
        .outer{
          margin: 0 auto;
          width: 100%;
          max-width: 600px;
          border-spacing: 0;
          font-family: sans-serif;
          color: #4a4a4a;
        }
        a{
          text-decoration: none;
          color: #232840;
          font-size: 14px;
          background-color: #fff;
          padding: 3px;
          margin:1px;
        }
        @media screen and (max-width:600px){
          img{
            width: 200px !important;
            max-width: 200px !important;
          }
          #service{
            font-size: 13px !important;
          }
        }
        @media screen and (max-width:400px){

        }

      </style>
    </head>
    <body>
    <center class="wrapper">
      <div class="webkit">
        <table class="outer" align="center">

          <tr>
            <td>
              <table width="100%" style="border-spacing:0;">
                <tr>
                  <td style="background-color:#ffffff;padding:10px;text-align:center;">
                    <a href="www.trippleseventh.com"><img src="'.URLROOT.'/t7images/t7logo.png" alt="Triple Seventh Logo"> </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td>
              <table width="100%" style="border-spacing:0; min-height:100px;">
                <tr>
                  <td style="background-color:#ffffff;padding:10px;text-align:center;">
                    '.$body.'
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td>
              <table width="100%" style="border-spacing:0;">
                <tr>
                  <td style="background-color:#c74c3c;padding:12px;text-align:center;">
                    <p style="font-size:18px;color:#ffffff;margin-bottom:13px;" id="service">
                      UTILITIES | ENGINEERING | TECHNOLOGIES | SYSTEMS
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table width="100%" style="border-spacing:0;">
                <tr>
                  <td style="background-color:#232840;padding:4px;text-align:center;">
                    <p style="font-size:14px;color:#ffffff;margin-bottom:5px;">Support: 08034511985, 08098867824</p>
                    <p style="font-size:13px;color:#ffffff;margin-bottom:5px;"><a href="mailto:tripleseventh@yahoo.com"  style="margin:1px;">tripleseventh@yahoo.com</a>, <a  style="margin:1px;" href="mailto:info@trippleseventh.com">info@trippleseventh.com</a></p>
                    <p style="font-size:13px;color:#ffffff;margin-bottom:5px;">
                      No. 74, jengre Road, off Murtala Mohammed Way, Jos, Plateau State, Nigeria

                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table width="100%" style="border-spacing:0;">
                <tr>
                  <td style="background-color:#000000;padding:5px;text-align:center;">
                    <p style="font-size:15px;color:#ffffff;margin-bottom:7px;">
                      DEVELOPED BY: <a href="mailto:dhasmom01@gmail.com">ELEVATE TECHIE </a>
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

        </table>
      </div>
    </center>';

        $from="info@trippleseventh.com";
        $from_name='MIMS | Triple Seventh';
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        // $mail->IsSMTP();
        $mail->SMTPAuth = true;

        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = EMAIL;
        $mail->Password = PWD;

   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);

        $mail->IsHTML(true);
        $mail->From=EMAIL;
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        //$mail->AddReplyTo($from_name);
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $BODY;
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            $error ="Please try Later, Error Occured while Processing...";
            return $error;
        }
        else
        {
            $error = "Thanks You !! Your email is sent.";
            return $error;
        }
    }

    $to   = 'dhasmom01@gmail.com';
    $from = 'info@trippleseventh.com';
    $name = 'Triple Seventh';
    $subj = 'PHPMailer 6.1 testing from Comsprime HasMom the developer';
    $msg = 'This is mail... testing mailing using PHP.';

    // $error=smtpmailer($to,$subj, $msg);
