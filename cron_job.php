<?php
require"config.php";
require"functions.php";

if($FAUCET_REQUEST_EVERY=="daily") { $user_cookie_date = date("m/d/Y"); }
if($FAUCET_REQUEST_EVERY=="hourly"){ $user_cookie_date = date("m/d/Y-G"); }
if($FAUCET_REQUEST_EVERY=="ampm"){ $user_cookie_date = date("m/d/Y-A"); }
$fee = "50000";
$amount = $FAUCET_AMOUNT * "100000000";
$prerecipients .= '{';
$repcount = 0;
$Query = mysql_query("SELECT * FROM requests WHERE paid='0'");
while($Row = mysql_fetch_assoc($Query)) {
   $pay_address = $Row['address'];
   $repcount++;
   if($repcount==1) {
      $prerecipients .= '"'.$pay_address.'": '.$amount;
   } else {
      $prerecipients .= ',"'.$pay_address.'": '.$amount;
   }
}
$prerecipients .= '}';
$blockchain_api = "https://blockchain.info/merchant/$BLOCKCHAIN_GUID/address_balance?password=$BLOCKCHAIN_FIRST&address=$BLOCKCHAIN_FROM&confirmations=0";
$blockchain_response = file_get_contents($blockchain_api);
$blockchain_object = json_decode($blockchain_response);
$FAUCET_BALANCE = $blockchain_object->balance;
$FAUCET_BALANCE = $FAUCET_BALANCE / "100000000";
$FAUCET_BALANCE = satoshisize($FAUCET_BALANCE);
if($FAUCET_BALANCE>"0.0015") {
   $recipients = urlencode($prerecipients);
   $json_url = "http://blockchain.info/merchant/$BLOCKCHAIN_GUID/sendmany?password=$BLOCKCHAIN_FIRST&second_password=$BLOCKCHAIN_SECOND&recipients=$recipients&from=$BLOCKCHAIN_FROM&shared=false&fee=$fee";
   $json_data = file_get_contents($json_url);
   $json_feed = json_decode($json_data);
   $BTC_tx_hash = $json_feed->tx_hash;
   if(!$BTC_tx_hash) {
      $sql = mysql_query("UPDATE requests SET paid='1' WHERE paid='3'");
      $sql = mysql_query("INSERT INTO transactions (id,date,txid)
                      VALUES ('','$user_cookie_date','Error Transaction Cancelled')");
   } else {
      $sql = mysql_query("UPDATE requests SET paid='1' WHERE paid='0'");
      $sql = mysql_query("INSERT INTO transactions (id,date,txid)
                      VALUES ('','$user_cookie_date','$BTC_tx_hash')");
   }
} else  {
   $sql = mysql_query("UPDATE requests SET paid='1' WHERE paid='4'");  // to low of balance
}
?>