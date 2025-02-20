<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Verify Email</title>
      <style type="text/css">
         body{
         margin:0;
         padding:0;
         }
         @media (max-width:600px){
         table.main_outter {
         width: 100% !important;
         padding: 0 15px !important;
         } 
         body, table{
         width:100%!important;
         }   
         }
      </style>
   </head>
   <body style="width:600px;margin:auto;" width="600px">
      <?php $header = getThemeOptions('header'); ?>
      <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="600px" id="bodyTable" style="background: #ececec;padding: 20px 0px 40px;" >
         <tr>
            <td>
               <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="width:600px;margin:auto; padding:0 15px;">
                  <tr>
                     <td style="text-align:center;padding: 0 0 20px;">
                        <img style="width: 200px;" src="<?php echo publicPath().'/'.$header['headerlogo'] ?>">
                     </td>
                  </tr>
                  <tr>
                     <td align="center" valign="top" id="templatePreheader" style="padding:28px 15px;background: #fff;">
                        <h2 style="color: #152c3b;">Welcome To <?php echo appName() ?></h2>
                        <p style="color: #152c3b;font-size:22px;">Hello <?php echo $feedback->name ?>,</p>
                        <p style="color: #152c3b;font-size:18px;">Thank for your enquery</p>
                        <p style="color: #152c3b;"><b>Message:</b> <small><?php echo $feedback->message ?></small></p>
                        <p style="color: #152c3b;"><b>Reply:</b> <small><?php echo $content ?></small></p>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <h5 style="margin-bottom:0;">Need Support ?</h5>
                        <p style="margin-top:8px;">Feel free to email us if you have any questions, comments or suggestions. We'll be happy to resolve your issues.</p>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>