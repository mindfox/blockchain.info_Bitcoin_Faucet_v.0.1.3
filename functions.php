<?php

// Sotoshisize bitcoin amounts and then trim them clean.
   function satoshisize($satoshitize) {
      return rtrim(rtrim(sprintf("%.8f", $satoshitize), "0"), ".");
   }

$SESSION_ADMIN = $_SESSION['SESSION_ADMIN'];

$dbconn = mysql_connect($DB_LOCATION,$DB_USERNAME,$DB_PASSWORD);
if(!$dbconn) { die($DB_ERROR); }
$dbc = mysql_select_db($DB_NAME);
if(!$dbc) { die($DB_ERROR); }

$Query = mysql_query("SELECT paid FROM requests WHERE paid='0'");
$FAUCET_PEND = mysql_num_rows($Query);
$Query = mysql_query("SELECT paid FROM requests");
$FAUCET_PAID = mysql_num_rows($Query);
$Query = mysql_query("SELECT * FROM settings WHERE id='1'");
while($Row = mysql_fetch_assoc($Query)) {
   $ADMIN_USERNAME = $Row['username'];
   $ADMIN_PASSWORD = $Row['password'];
   $WEBSITE_NAME = $Row['faucet_title'];
   $WEBSITE_URL = $Row['faucet_url'];
   $TX_DISPLAY_LIMIT = $Row['tx_display_limit'];
   $FAUCET_AMOUNT = $Row['faucet_amount'];
   $FAUCET_REQUEST_EVERY = $Row['pay_every'];
   $BLOCKCHAIN_GUID = $Row['blockchain_guid'];
   $BLOCKCHAIN_FIRST = $Row['blockchain_first'];
   $BLOCKCHAIN_SECOND = $Row['blockchain_second'];
   $BLOCKCHAIN_FROM = $Row['blockchain_keyaddress'];
   $yocaptcha_status = $Row['yocaptcha_status'];
   $yocaptcha_public = $Row['yocaptcha_public'];
   $yocaptcha_private = $Row['yocaptcha_private'];
}
$TXID_DISPLAY_LIST ='<table style="width: 500px;">
                        <tr>
                           <td align="left mstyle="padding: 5px;"><b>Last '.$TX_DISPLAY_LIMIT.' Transactions:</b></td>
                        </tr>';
$Query = mysql_query("SELECT txid FROM transactions");
if(mysql_num_rows($Query)!=0) {
   $Query = mysql_query("SELECT date, txid FROM transactions ORDER BY id DESC LIMIT $TX_DISPLAY_LIMIT");
   while($Row = mysql_fetch_assoc($Query)) {
      $TXID_DISPLAY_LIST_DATE = $Row['date'];
      $TXID_DISPLAY_LIST_TXID = $Row['txid'];
      $TXID_DISPLAY_LIST .= '<tr>
                                <td align="left" style="padding: 5px; padding-left: 25px;">'.$TXID_DISPLAY_LIST_TXID.'</td>
                             </tr>';
   }
} else {
      $TXID_DISPLAY_LIST .= '<tr>
                                <td align="left" style="padding: 5px; padding-left: 25px;">Empty...</td>
                             </tr>';
}
$TXID_DISPLAY_LIST .= '</table>';
$FAUCET_WALLET_LABEL = "FaucetAddress"; // NO SPACES
if($BLOCKCHAIN_GUID) {
   if($BLOCKCHAIN_FIRST) {
      if($BLOCKCHAIN_SECOND) {
         if(!$BLOCKCHAIN_FROM) {
            $blockchain_api = "https://blockchain.info/merchant/$BLOCKCHAIN_GUID/new_address?password=$BLOCKCHAIN_FIRST&second_password=$BLOCKCHAIN_SECOND&label=$FAUCET_WALLET_LABEL";
            $blockchain_response = file_get_contents($blockchain_api);
            $blockchain_object = json_decode($blockchain_response);
            $BLOCKCHAIN_FROM = $blockchain_object->address;
            if(!$BLOCKCHAIN_FROM) {
               $FAUCET_BALANCE = "?";
               $SERER_CONNECTION = "Down";
            } else {
               $sql = mysql_query("UPDATE settings SET blockchain_keyaddress='$BLOCKCHAIN_FROM' WHERE id='1'");
               $blockchain_api = "https://blockchain.info/merchant/$BLOCKCHAIN_GUID/address_balance?password=$BLOCKCHAIN_FIRST&address=$BLOCKCHAIN_FROM&confirmations=0";
               $blockchain_response = file_get_contents($blockchain_api);
               $blockchain_object = json_decode($blockchain_response);
               $FAUCET_BALANCE = $blockchain_object->balance;
               $FAUCET_BALANCE = $FAUCET_BALANCE / "100000000";
               $FAUCET_BALANCE = satoshisize($FAUCET_BALANCE);
               $SERER_CONNECTION = "Active";
            }
         } else {
            $blockchain_api = "https://blockchain.info/merchant/$BLOCKCHAIN_GUID/address_balance?password=$BLOCKCHAIN_FIRST&address=$BLOCKCHAIN_FROM&confirmations=0";
            $blockchain_response = file_get_contents($blockchain_api);
            $blockchain_object = json_decode($blockchain_response);
            $FAUCET_BALANCE = $blockchain_object->balance;
            $FAUCET_BALANCE = $FAUCET_BALANCE / "100000000";
            $FAUCET_BALANCE = satoshisize($FAUCET_BALANCE);
            $SERER_CONNECTION = "Active";
         }

      } else {
         $FAUCET_BALANCE = "?";
         $SERER_CONNECTION = "Down";
      }
   } else {
      $FAUCET_BALANCE = "?";
      $SERER_CONNECTION = "Down";
   }
} else {
   $FAUCET_BALANCE = "?";
   $SERER_CONNECTION = "Down";
}
?>