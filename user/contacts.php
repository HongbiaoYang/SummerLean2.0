<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';



?> 
<div class="prepend-1 span-17">
<p>&nbsp;</p>
<h2 class="catHead">Contact Us</h2>
<p><img src="images/users.png" class="left"/>
	<p class="errorMessage"><?php echo $errorMessage; ?></p>

 <table  border="0" align="center" cellpadding="2" cellspacing="1" class="text">
   <tr> 
   <td colspan="5">&nbsp;</td>
  </tr>
  
  <tr> 
  </tr>
 </table>
 
 <p>&nbsp;</p>
</form>
</div>
