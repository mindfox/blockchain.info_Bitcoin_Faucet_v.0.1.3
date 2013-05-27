<div class="header">
   <table class="header-table">
      <tr>
         <td align="left">
            <?php echo '<a href="'.$WEBSITE_URL.'" class="toolbar">'.$WEBSITE_NAME.'</a>'; ?>
         </td>
         <td align="right">
            <table style="font-size: 12px; color: #FFFFFF;">
               <tr>
                  <?php
                  if($SESSION_ADMIN==$ADMIN_USERNAME) {
                     echo '<td style="padding-right: 20px;"><b><a href="admin.php" class="toolbar">Admin Panel</a><b></td>
                           <td style="padding-right: 20px;"><b><a href="admin.php?logout=true" class="toolbar">Logout</a><b></td>';
                  }
                  ?>
                  <td><b>Request Pending:</b></td>
                  <td><?php echo $FAUCET_PEND.' of '.$FAUCET_PAID; ?></td>
                  <td style="padding-left: 20px;"><b>Faucet Balance:</b></td>
                  <td><?php echo $FAUCET_BALANCE; ?></td>
                  <td style="padding-left: 20px;"><b>Server Connection:</b></td>
                  <td><?php echo $SERER_CONNECTION; ?></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</div>
<div class="footer">
   <table class="footer-table">
      <tr>
         <td align="left" style="width: 200px;">
            zellus faucet script
         </td>
         <td align="center">
            Donate to faucet: <?php echo $BLOCKCHAIN_FROM; ?>
         </td>
         <td align="right" style="width: 200px;">

         </td>
      </tr>
   </table>
</div>