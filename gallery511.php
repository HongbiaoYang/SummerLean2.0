<?php

include('includes/application_top.php');

?>

	<TABLE width="500" cellspacing="0" cellpadding="0" border="0" align="center" height="100%">
		
        
        
        
        <?php 
        
         $query = "select firstname, lastname, picture from tbl_students where 1 and gender = 'F'";
											    $result = tep_db_query($query);
											    
                        	if (tep_db_num_rows($result) > 0) {
                        		while ($row = tep_db_fetch_array($result)) {
                       		      echo '<tr><td>'.$row[firstname].' '.$row[lastname].'<br>'.$image.
                                '<br><img src="uploads/'.$row[picture].'" width=400px />
                                </td></tr>';
            }
        }
                        		    
    /*                        		    
        $dirname = "uploads/";
            $images = glob($dirname."*");
            foreach($images as $image) {
            echo '<tr><td>'.$image.
                '<br><img src="'.$image.'" width=400px />
                </td></tr>';
            }
      */
        
        ?>


			</TABLE>

	</body>

</html>
