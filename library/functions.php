<?php
function checkUser()
{
	if ((!isset($_SESSION['asset_user_id'])) || ($_SESSION['asset_user_id'] == '')) {
		header('Location: ' . WEB_ROOT . 'login.php');
		exit;
	}
	
	if (isset($_GET['logout'])) {
		if (isset($_GET['info']) && $_GET['info'] != '')
		{
			$name = "Congradulations! Please use <u>".$_GET['info']."</u> to log in!";
		}
			doLogout($name);
	}
	
	if (isset($_GET['success'])) {
		
		$msg = $_GET['success'];
		$msg = urlencode("Congradulations! Registration succeed!! <br>
		Use <u>".$msg."</u> to login and view your projects.");
			
		doLogoutWithAlert($msg);
	}
	
	if (isset($_GET['changed'])) {
		
		$msg = $_GET['changed'];		
		
		if ($msg == 'true')
		{
			$msg = urlencode("Congradulations! Password Changed!! <br>
			Use your new password to login and view your projects.");
		}
		else 
		{
			$msg = urlencode("Password change failed! <br>
			Please log in and try again, or contact utlean@utk.edu!");
		}
			
			doLogoutWithAlert($msg);
		}
}

function doLogin()
{
	// if we found an error save the error message in this variable
	$errorMessage = '';
	
	$userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];
	
	// first, make sure the username & password are not empty
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	} else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} else {
		// check the database and see if the username and password combo do match
		$sql = "SELECT StuIndex, Email, Password, LastName, Rank
		        FROM tbl_students
				WHERE Email = '$userName' AND Password = '$password'";
		$result = dbQuery($sql);
	
		//$tsql = 
	
	
		if (dbNumRows($result) == 1) {
			$row = dbFetchAssoc($result);
			$_SESSION['asset_user_id'] = $row['StuIndex'];
			$_SESSION['asset_user_name'] = $row['Email'];
			$_SESSION['asset_user_type'] = $row['Rank'];

			// now that the user is verified we move on to the next page
            // if the user had been in the admin pages before we move to
			// the last page visited
			if (isset($_SESSION['login_return_url'])) {
				header('Location: ' . $_SESSION['login_return_url']);
				exit;
			} else {
				header('Location: index.php');
				exit;
			}
		}
		 else {
			$errorMessage = 'Wrong username or password';
		}		
			
	}
	
	return $errorMessage;
}

/*
	Logout a user
*/
function doLogout($name = 10)
{
	if (isset($_SESSION['asset_user_id'])) {
		unset($_SESSION['asset_user_id']);

		$_SESSION['asset_user_id'] = '';
		
		if ($_SESSION['asset_user_type'] == 0)
		{
			$_SESSION['login_return_url'] = 'index.php';
		}
		else 
		{
			$_SESSION['login_return_url'] = 'index.php';
		}
			
	header('Location: login.php');
	exit;
	}
}

function doLogoutWithAlert($msg)
{
	if (isset($_SESSION['asset_user_id'])) {
		unset($_SESSION['asset_user_id']);

		$_SESSION['asset_user_id'] = '';
		
		$_SESSION['login_return_url'] = 'index.php';

	}
		
	header('Location: login.php?info='.$msg);
	exit;
}


/*
	Generate combo box options containing the categories we have.
	if $catId is set then that category is selected
*/
function buildCategoryOptions($catId = 0)
{
	$sql = "SELECT cat_id, cat_parent_id, cat_name
			FROM tbl_category
			ORDER BY cat_id";
	$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
	
	$categories = array();
	while($row = dbFetchArray($result)) {
		list($id, $parentId, $name) = $row;
		
		if ($parentId == 0) {
			// we create a new array for each top level categories
			$categories[$id] = array('name' => $name, 'children' => array());
		} else {
			// the child categories are put int the parent category's array
			$categories[$parentId]['children'][] = array('id' => $id, 'name' => $name);	
		}
	}	
	
	// build combo box options
	$list = '';
	foreach ($categories as $key => $value) {
		$name     = $value['name'];
		$children = $value['children'];
		
		$list .= "<optgroup label=\"$name\">"; 
		
		foreach ($children as $child) {
			$list .= "<option value=\"{$child['id']}\"";
			if ($child['id'] == $catId) {
				$list.= " selected";
			}
			
			$list .= ">{$child['name']}</option>\r\n";
		}
		
		$list .= "</optgroup>";
	}
	
	return $list;
}

/*
	If you want to be able to add products to the first level category
	replace the above function with the one below
*/
/*

function buildCategoryOptions($catId = 0)
{
	$sql = "SELECT cat_id, cat_parent_id, cat_name
			FROM tbl_category
			ORDER BY cat_id";
	$result = dbQuery($sql) or die('Cannot get Product. ' . mysql_error());
	
	$categories = array();
	while($row = dbFetchArray($result)) {
		list($id, $parentId, $name) = $row;
		
		if ($parentId == 0) {
			// we create a new array for each top level categories
			$categories[$id] = array('name' => $name, 'children' => array());
		} else {
			// the child categories are put int the parent category's array
			$categories[$parentId]['children'][] = array('id' => $id, 'name' => $name);	
		}
	}	
	
	// build combo box options
	$list = '';
	foreach ($categories as $key => $value) {
		$name     = $value['name'];
		$children = $value['children'];
		
		$list .= "<option value=\"$key\"";
		if ($key == $catId) {
			$list.= " selected";
		}
			
		$list .= ">$name</option>\r\n";

		foreach ($children as $child) {
			$list .= "<option value=\"{$child['id']}\"";
			if ($child['id'] == $catId) {
				$list.= " selected";
			}
			
			$list .= ">&nbsp;&nbsp;{$child['name']}</option>\r\n";
		}
	}
	
	return $list;
}
*/

/*
	Create a thumbnail of $srcFile and save it to $destFile.
	The thumbnail will be $width pixels.
*/
function createThumbnail($srcFile, $destFile, $width, $quality = 75)
{
	$thumbnail = '';
	
	if (file_exists($srcFile)  && isset($destFile))
	{
		$size        = getimagesize($srcFile);
		$w           = number_format($width, 0, ',', '');
		$h           = number_format(($size[1] / $size[0]) * $width, 0, ',', '');
		
		$thumbnail =  copyImage($srcFile, $destFile, $w, $h, $quality);
	}
	
	// return the thumbnail file name on sucess or blank on fail
	return basename($thumbnail);
}

/*
	Copy an image to a destination file. The destination
	image size will be $w X $h pixels
*/
function copyImage($srcFile, $destFile, $w, $h, $quality = 75)
{
    $tmpSrc     = pathinfo(strtolower($srcFile));
    $tmpDest    = pathinfo(strtolower($destFile));
    $size       = getimagesize($srcFile);

    if ($tmpDest['extension'] == "gif" || $tmpDest['extension'] == "jpg")
    {
       $destFile  = substr_replace($destFile, 'jpg', -3);
       $dest      = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } elseif ($tmpDest['extension'] == "png") {
       $dest = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } else {
      return false;
    }

    switch($size[2])
    {
       case 1:       //GIF
           $src = imagecreatefromgif($srcFile);
           break;
       case 2:       //JPEG
           $src = imagecreatefromjpeg($srcFile);
           break;
       case 3:       //PNG
           $src = imagecreatefrompng($srcFile);
           break;
       default:
           return false;
           break;
    }

    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);

    switch($size[2])
    {
       case 1:
       case 2:
           imagejpeg($dest,$destFile, $quality);
           break;
       case 3:
           imagepng($dest,$destFile);
    }
    return $destFile;

}

/*
	Create the paging links
*/
function getPagingNav($sql, $pageNum, $rowsPerPage, $queryString = '')
{
	$result  = mysql_query($sql) or die('Error, query failed. ' . mysql_error());
	$row     = mysql_fetch_array($result, MYSQL_ASSOC);
	$numrows = $row['numrows'];
	
	// how many pages we have when using paging?
	$maxPage = ceil($numrows/$rowsPerPage);
	
	$self = $_SERVER['PHP_SELF'];
	
	// creating 'previous' and 'next' link
	// plus 'first page' and 'last page' link
	
	// print 'previous' link only if we're not
	// on page one
	if ($pageNum > 1)
	{
		$page = $pageNum - 1;
		$prev = " <a href=\"$self?page=$page{$queryString}\">[Prev]</a> ";
	
		$first = " <a href=\"$self?page=1{$queryString}\">[First Page]</a> ";
	}
	else
	{
		$prev  = ' [Prev] ';       // we're on page one, don't enable 'previous' link
		$first = ' [First Page] '; // nor 'first page' link
	}
	
	// print 'next' link only if we're not
	// on the last page
	if ($pageNum < $maxPage)
	{
		$page = $pageNum + 1;
		$next = " <a href=\"$self?page=$page{$queryString}\">[Next]</a> ";
	
		$last = " <a href=\"$self?page=$maxPage{$queryString}{$queryString}\">[Last Page]</a> ";
	}
	else
	{
		$next = ' [Next] ';      // we're on the last page, don't enable 'next' link
		$last = ' [Last Page] '; // nor 'last page' link
	}
	
	// return the page navigation link
	return $first . $prev . " Showing page <strong>$pageNum</strong> of <strong>$maxPage</strong> pages " . $next . $last; 
}

/*------------------------------
$total 总记录数
$perpage 每页显示记录数
$thispage 当前页
$url 地址形式
------------------------------*/
function page($total, $perpage, $thispage, $url) {
    $pagecount = ceil($total / $perpage);
    $centernum = 10; //中间分页显示链接的个数
    $page = '';
    if ($pagecount <= 1){
        $back = '';
        $next = '';
        $center = '';
    }else{
        $back = '';
        $next = '';
        $center = '';
        if ($thispage == 1){ //当前页为第一页
            for ($i=1;$i<=$centernum;$i++){
                if ($i>$pagecount){
                    break;
                }
                if ($i != $thispage){
                    $center .= '<a href="'.$url.$i.'">'.$i.'</a>';
                }else{
                    $center .= '<a class="this" style="color:purple">'.$i.'</a>';
                }
            }
            $next .= '<a href="'.$url.($thispage+1).'"> Next</a>';
            $next .= '<a href="'.$url.$pagecount.'"> Last</a>';
        }elseif ($thispage == $pagecount){ //当前页为最后一页
            $back .= '<a href="'.$url.'1">First </a>';
            $back .= '<a href="'.$url.($thispage-1).'">Previous </a>';
            for ($i=$pagecount-$centernum+1;$i<=$pagecount;$i++){
                if ($i<1){
                    $i = 1;
                }
                if ($i != $thispage){
                    $center .= '<a href="'.$url.$i.'">'.$i.'</a>';
                }else{
                    $center .= '<a class="this" style="color:purple">'.$i.'</a>';
                }
            }
        }else{ //单前页既不是第一页也不是最后一页
            $back .= '<a href="'.$url.'1">First </a>';
            $back .= '<a href="'.$url.($thispage-1).'">Previous </a>';
            $left = $thispage - floor($centernum / 2) ;
            $right = $thispage + floor($centernum / 2) ;
            if ($left < 1){
                $left = 1;
                $right = $centernum < $pagecount ? $centernum:$pagecount;
            }
            if ($right > $pagecount){
                $left = $centernum < $pagecount ? ($pagecount-$centernum+1):1;
                $right = $pagecount;
            }
            for ($i = $left; $i <= $right; $i++) {
                if ($i != $thispage){
                    $center .= '<a href="'.$url.$i.'">'.$i.'</a>';
                }else{
                    $center .= '<a class="this" style="color:purple">'.$i.'</a>';
                }
            }
            $next .= '<a href="'.$url.($thispage+1).'"> Next</a>';
            $next .= '<a href="'.$url.$pagecount.'"> Last</a>';
        }
    }
    $page .= $back.$center.$next;
    echo $page; //输出分页
}


?>
