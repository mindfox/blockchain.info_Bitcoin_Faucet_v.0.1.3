<?php
require"config.php";
require"functions.php";
require"floats.php";
$SESSION_LOGOUT = addslashes(strip_tags($_GET['logout']));
if($SESSION_LOGOUT){
session_destroy();
header("Location: admin.php");
}
$SESSION_ADMIN_USER = addslashes(strip_tags($_POST['admuser']));
$SESSION_ADMIN_PASS = md5(addslashes(strip_tags($_POST['admpass'])));
if($SESSION_ADMIN_USER==$ADMIN_USERNAME) {
   if($SESSION_ADMIN_PASS==$ADMIN_PASSWORD) {
     $_SESSION['SESSION_ADMIN'] = $SESSION_ADMIN_USER;
     header("Location: admin.php");
   }
}
if($SESSION_ADMIN==$ADMIN_USERNAME) {
   $EDIT_MADE = 0;
   $POSTED_ADMIN_username = addslashes(strip_tags($_POST['username']));
   $POSTED_ADMIN_password = addslashes(strip_tags($_POST['password']));
   $POSTED_ADMIN_repeat = addslashes(strip_tags($_POST['repeat']));
   $POSTED_ADMIN_faucet_title = addslashes(strip_tags($_POST['faucet_title']));
   $POSTED_ADMIN_faucet_url = addslashes(strip_tags($_POST['faucet_url']));
   $POSTED_ADMIN_tx_display_limit = addslashes(strip_tags($_POST['tx_display_limit']));
   $POSTED_ADMIN_faucet_amount = addslashes(strip_tags($_POST['faucet_amount']));
   $POSTED_ADMIN_pay_every = addslashes(strip_tags($_POST['pay_every']));
   $POSTED_ADMIN_blockchain_guid = addslashes(strip_tags($_POST['blockchain_guid']));
   $POSTED_ADMIN_blockchain_first = addslashes(strip_tags($_POST['blockchain_first']));
   $POSTED_ADMIN_blockchain_second = addslashes(strip_tags($_POST['blockchain_second']));
   $POSTED_ADMIN_yocaptcha_status = addslashes(strip_tags($_POST['yocaptcha_status']));
   $POSTED_ADMIN_yocaptcha_public = addslashes(strip_tags($_POST['yocaptcha_public']));
   $POSTED_ADMIN_yocaptcha_private = addslashes(strip_tags($_POST['yocaptcha_private']));
   if($POSTED_ADMIN_username) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET username='$POSTED_ADMIN_username' WHERE id='1'");
   }
   if($POSTED_ADMIN_password) {
      if($POSTED_ADMIN_password==$POSTED_ADMIN_repeat){
         $EDIT_MADE = 1;
         $POSTED_ADMIN_password = md5($POSTED_ADMIN_password);
         $sql = mysql_query("UPDATE settings SET password='$POSTED_ADMIN_password' WHERE id='1'");
      }
   }
   if($POSTED_ADMIN_faucet_title) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET faucet_title='$POSTED_ADMIN_faucet_title' WHERE id='1'");
   }
   if($POSTED_ADMIN_faucet_url) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET faucet_url='$POSTED_ADMIN_faucet_url' WHERE id='1'");
   }
   if($POSTED_ADMIN_tx_display_limit) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET tx_display_limit='$POSTED_ADMIN_tx_display_limit' WHERE id='1'");
   }
   if($POSTED_ADMIN_faucet_amount) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET faucet_amount='$POSTED_ADMIN_faucet_amount' WHERE id='1'");
   }
   if($POSTED_ADMIN_pay_every) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET pay_every='$POSTED_ADMIN_pay_every' WHERE id='1'");
   }
   if($POSTED_ADMIN_blockchain_guid) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET blockchain_guid='$POSTED_ADMIN_blockchain_guid' WHERE id='1'");
   }
   if($POSTED_ADMIN_blockchain_first) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET blockchain_first='$POSTED_ADMIN_blockchain_first' WHERE id='1'");
   }
   if($POSTED_ADMIN_blockchain_second) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET blockchain_second='$POSTED_ADMIN_blockchain_second' WHERE id='1'");
   }
   if($POSTED_ADMIN_yocaptcha_status) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET yocaptcha_status='$POSTED_ADMIN_yocaptcha_status' WHERE id='1'");
   }
   if($POSTED_ADMIN_yocaptcha_public) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET yocaptcha_public='$POSTED_ADMIN_yocaptcha_public' WHERE id='1'");
   }
   if($POSTED_ADMIN_yocaptcha_private) {
      $EDIT_MADE = 1;
      $sql = mysql_query("UPDATE settings SET yocaptcha_private='$POSTED_ADMIN_yocaptcha_private' WHERE id='1'");
   }
   if($EDIT_MADE==1) {
      header("Location: admin.php");
   }
}
?>
<html>
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <title><?php echo $WEBSITE_NAME; ?> - Admin</title>
   <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body style="font-family: verdana; font-size: 12px; padding: 0px; margin-top: 60px; margin-bottom: 20px; margin-left: 0px; margin-right: 0px;">
   <?php
   if($SESSION_ADMIN!=$ADMIN_USERNAME) {
      echo '<center>
            <div align="center" style="width: 280px; background: #FFFFFF; border-radius: 16px; -moz-border-radius: 16px; padding: 15px;">
            <form action="admin.php" method="POST">
            <table style="width: 250px; font-size: 12px;">
               <tr>
                  <td colspan="2" align="left" style="font-size: 14px;"><b>Administrator Login</b></td>
               </tr><tr>
                  <td align="right"><b>Username:</b></td>
                  <td align="right"><input type="text" name="admuser" placeholder="Username" style="width: 180px;"></td>
               </tr><tr>
                  <td align="right"><b>Password:</b></td>
                  <td align="right"><input type="password" name="admpass" placeholder="Password" style="width: 180px;"></td>
               </tr><tr>
                  <td colspan="2" align="right"><input type="submit" nmae="submit" value="Login"></td>
               </tr>
            </table>
            </form>
            </div>
            </center>';
   } else {
      echo '<center>
            <table style="width: 500px;">
               <tr>
                  <td align="center" style="width: 20px;">
                  </td>
                  <td align="center" style="width: 600px;">
                     <div align="center" style="width: 600px; background: #FFFFFF; border-radius: 16px; -moz-border-radius: 16px; padding: 15px;">
                     <form action="admin.php" method="POST">
                     <table style="width: 500px;">
                        <tr>
                           <td align="left" style="padding: 5px;"><h3>Administration Panel:</h3></td>
                        </tr><tr>
                           <td align="center" style="padding: 5px; padding-left: 25px;">
                               <b>Deposit address: '.$BLOCKCHAIN_FROM.'</b>
                           </td>
                        </tr><tr>
                           <td align="center" style="padding: 5px;">
                              <table>
                                 <tr>
                                    <td align="left" colspan="2"><b>Bitcoin Faucet Settings:</b></td>
                                 </tr><tr>
                                    <td align="center" colspan="2">(Only modify fields you want to edit)</td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Admin Username:</b></td>
                                    <td align="right" style="width: 320px;"><input type="text" name="username" placeholder="'.$ADMIN_USERNAME.'" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Admin Password:</b></td>
                                    <td align="right" style="width: 320px;"><input type="password" name="password" placeholder="New Password" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Repeat Password:</b></td>
                                    <td align="right" style="width: 320px;"><input type="password" name="repeat" placeholder="Repeat New Password" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Facuet Name:</b></td>
                                    <td align="right" style="width: 320px;"><input type="text" name="faucet_title" placeholder="'.$WEBSITE_NAME.'" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Facuet URL:</b></td>
                                    <td align="right" style="width: 320px;"><input type="text" name="faucet_url" placeholder="'.$WEBSITE_URL.'" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Txid\'s to list:</b></td>
                                    <td align="right" style="width: 320px;"><input type="text" name="tx_display_limit" placeholder="'.$TX_DISPLAY_LIMIT.'" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Pay Per Request:</b></td>
                                    <td align="right" style="width: 320px;"><input type="text" name="faucet_amount" placeholder="'.$FAUCET_AMOUNT.'" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Pay Every:</b></td>
                                    <td align="right" style="width: 320px;">
                                       <select name="pay_every" class="admin-box">';
                                       if($FAUCET_REQUEST_EVERY=="hourly") {
                                          echo '<option value="hourly" selected>Hourly</option>
                                                <option value="daily">Daily</option>
                                                <option value="ampm">AM/PM</option>';
                                       }
                                       if($FAUCET_REQUEST_EVERY=="daily") {
                                          echo '<option value="hourly">Hourly</option>
                                                <option value="daily" selected>Daily</option>
                                                <option value="ampm">AM/PM</option>';
                                       }
                                       if($FAUCET_REQUEST_EVERY=="ampm") {
                                          echo '<option value="hourly">Hourly</option>
                                                <option value="daily">Daily</option>
                                                <option value="ampm" selected>AM/PM</option>';
                                       }
                                  echo '</select>
                                    </td>
                                 </tr><tr>
                                    <td align="left" colspan="2"><b>Blockchain.info Wallet Credentials:</b></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Wallet Identifier:</b></td>
                                    <td align="right" style="width: 320px;"><input type="text" name="blockchain_guid" placeholder="'.$BLOCKCHAIN_GUID.'" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>First Password:</b></td>
                                    <td align="right" style="width: 320px;"><input type="password" name="blockchain_first" placeholder="First Password" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Second Password:</b></td>
                                    <td align="right" style="width: 320px;"><input type="password" name="blockchain_second" placeholder="Second Password" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="left" colspan="2"><b>yoCaptcha Website Keys:</b>(Site Specific)</td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Enable Captchas:</b></td>
                                    <td align="right" style="width: 320px;">
                                       <select name="yocaptcha_status" class="admin-box">';
                                       if($yocaptcha_status=="active") {
                                          echo '<option value="active" selected>Enabled</option>
                                                <option value="inactive">Disabled</option>';
                                       }
                                       if($yocaptcha_status=="inactive") {
                                          echo '<option value="active">Enabled</option>
                                                <option value="inactive" selected>Disabled</option>';
                                       }
                                  echo '</select>
                                    </td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Public Key:</b></td>
                                    <td align="right" style="width: 320px;"><input type="text" name="yocaptcha_public" placeholder="'.$yocaptcha_public.'" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" style="width: 150px;"><b>Private Key:</b></td>
                                    <td align="right" style="width: 320px;"><input type="Password" name="yocaptcha_private" placeholder="Private Key" class="admin-box"></td>
                                 </tr><tr>
                                    <td align="right" colspan="2"><input type="submit" name="submit" value="Submit Changes" class="admin-button"></td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                     </form>
                     '.$TXID_DISPLAY_LIST.'
                     </div>
                  </td>
                  <td align="center" style="width: 20px;">
                  </td>
               </tr>
            </table>
            </center>';
   }
   ?>
</body>
</html>