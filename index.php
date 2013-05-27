<?php
require"config.php";
require"functions.php";
include'captcha.php';

$requesting_address = addslashes(strip_tags($_POST['address']));
$user_ip = $_SERVER['REMOTE_ADDR'];
$amt = $FAUCET_AMOUNT;
if($FAUCET_REQUEST_EVERY=="daily") { $user_cookie_date = date("m/d/Y"); }
if($FAUCET_REQUEST_EVERY=="hourly"){ $user_cookie_date = date("m/d/Y-G"); }
if($FAUCET_REQUEST_EVERY=="ampm"){ $user_cookie_date = date("m/d/Y-A"); }
$DISPLAY_COMEBACK_MESSAGE = 0;
$user_cookie_stamp = "today_is".$user_cookie_date;
if(isset($_COOKIE["$user_cookie_stamp"])) { $DISPLAY_COMEBACK_MESSAGE = 7; }

$Query = mysql_query("SELECT ip FROM requests WHERE date='$user_cookie_date' AND ip='$user_ip'");
if(mysql_num_rows($Query) != 0) { $DISPLAY_COMEBACK_MESSAGE = 7; }

$Query = mysql_query("SELECT ip FROM requests WHERE date='$user_cookie_date' AND address='$requesting_address'");
if(mysql_num_rows($Query) != 0) { $DISPLAY_COMEBACK_MESSAGE = 7; }

if($yocaptcha_status=="active") {
   $session = $_REQUEST['yocaptcha_session'];
   $answer = $_REQUEST['yocaptcha_answer'];
   $r = yocaptcha_verify_form($yocaptcha_public, $yocaptcha_private, $session, $answer);
   if($r->is_valid==1) {
      if($DISPLAY_COMEBACK_MESSAGE!=7) {
         if($requesting_address) {
            if(!mysql_query("INSERT INTO requests (id,date,ip,address,amount,paid)
                             VALUES ('','$user_cookie_date','$user_ip','$requesting_address','$amt','0')")) {
               die($DB_ERROR);
            } else {
               setcookie("$user_cookie_stamp", "1");
               header("Location: index.php");
            }
         }
      }
   }
} else {
   if($DISPLAY_COMEBACK_MESSAGE!=7) {
      if($requesting_address) {
         if(!mysql_query("INSERT INTO requests (id,date,ip,address,amount,paid)
                          VALUES ('','$user_cookie_date','$user_ip','$requesting_address','$amt','0')")) {
            die($DB_ERROR);
         } else {
            setcookie("$user_cookie_stamp", "1");
            header("Location: index.php");
         }
      }
   }
}
?>
<html>
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title><?php echo $WEBSITE_NAME; ?> - Home Page</title>
   <link rel="stylesheet" type="text/css" href="style/style.css">
   <?php
   if($DISPLAY_COMEBACK_MESSAGE!=7) {
      echo '<script src="scripts/jquery-1.9.1.js" type="text/javascript"></script>
            <script type="text/javascript">
               $(function(){
                  var count = 9;
                  countdown = setInterval(function(){
                     $(".request-countdown").html("Please wait " + count + " seconds!");
                     if (count <= 0) {
                        $(".request-countdown").delay(500).fadeOut(500);
                        $(".bitcoin-request").delay(900).fadeIn(500);
                     }
                     count--;
                  }, 1000);
               });
            </script>';
   }
   ?>
</head>
<body style="font-family: verdana; font-size: 12px; padding: 0px; margin-top: 60px; margin-bottom: 20px; margin-left: 0px; margin-right: 0px;">
   <center>
   <table style="width: 500px;">
      <tr>
         <td align="center" valign="top" style="width: 200px;">
            <iframe scrolling="no" style="border: 0; width: 160px; height: 600px;" src="http://coinurl.com/get.php?id=3986" frameborder="0"></iframe>
         </td>
         <td align="center" valign="top" style="width: 600px;">
            <div align="center" style="width: 600px; background: #FFFFFF; border-radius: 16px; -moz-border-radius: 16px; padding: 15px;">
            <table style="width: 500px;">
               <tr>
                  <td align="left" style="padding: 5px;"><b>Free Bitcoin Faucet:</b></td>
               </tr><tr>
                  <td align="left" style="padding: 5px; padding-left: 25px;">Request free bitcoins every hour as long as the faucet has the balance to cover it.</td>
               </tr>
            </table>
            <div style="height: 280px;">
            <form action="index.php" method="POST" style="padding: 0px; margin: 0px;">
            <script type="text/javascript" src="http://api.yocaptcha.com/get.php?k=<?php echo $yocaptcha_public; ?>"></script><br>
            <?php
            if($DISPLAY_COMEBACK_MESSAGE!=7) {
               echo '<div class="request-countdown" style="height: 40px; font-weight: bold;">Please wait 10 seconds!</div>
                     <div class="bitcoin-request" style="height: 40px; display: none;">
                     <table style="width: 330px;">
                        <tr>
                           <td align="center" style="padding: 5px;"><input type="text" name="address" placeholder="Your Bitcoin Address" class="request-box"></td>
                           <td align="center" style="padding: 5px;"><input type="submit" type="submit" value="Submit" class="request-button"></td>
                        </tr>
                     </table>
                     </div>';
            } else {
               echo '<div style="height: 40px; font-weight: bold;">You have made a request for this timeframe, try again later!</div>';
            }
            ?>
            </form>
            </div><br>
            <iframe scrolling="no" style="border: 0; width: 468px; height: 60px;" src="http://coinurl.com/get.php?id=3984" frameborder="0"></iframe><br>
            <?php echo $TXID_DISPLAY_LIST; ?><br>
            <iframe scrolling="no" style="border: 0; width: 468px; height: 60px;" src="http://coinurl.com/get.php?id=3985" frameborder="0"></iframe>
            </div>
         </td>
         <td align="center" valign="top" style="width: 200px;">
            <iframe scrolling="no" style="border: 0; width: 160px; height: 600px;" src="http://coinurl.com/get.php?id=6275" frameborder="0"></iframe>
         </td>
      </tr>
   </table>
   </center>
   <?php
   require"floats.php";
   ?>
</body>
</html>