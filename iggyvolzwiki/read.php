<?php
if(isset($webentry))
	{
	if(isset($mysql_db))
		{
		function display($pagename)
			{
			$classnum=rand();
			global $isread, $isedit, $code; // I had to make code global in order to be able to call syntax and html properly (they will not pick up $code unless it is global).  This means you can only use display() once per page (you could still embed by using the manual mysql code).  I'm working on a solution, which will probably involve arrays.
			if(page_exists($pagename))
				{
				$code=htmlspecialchars(pull('Script',$pagename));
				function syntax($orig, $html)
					{
					global $code;
					$code=str_replace($orig, $html, $code);
					}
				function allowhtml($html)
					{
					global $code;
					$code=str_replace(htmlspecialchars($html), $html, $code);
					}
				include 'syntax.php'; // Initialize the syntax
				$isread=TRUE; // Tell extensions we are reading
				$isedit=FALSE; // Tell extensions we are not editing
				include 'beforecode/index.php'; // Include extensions that want to go before code
				echo $code; // CODE
				include 'aftercode/index.php'; // Include extensions that want to go after the code
				}
			else
				{
				echo '<form method="get" action="" id="edit"><input type="hidden" name="action" value="edit" /></form>Error, page does not exist.  Please click <a onclick="document.getElementById("edit").submit();">here</a> to create.';
				}
			}
		}
	else
		{
		echo 'Uh, oh!  It looks like your wiki is not set up!  Please click <a href="/iggyvolzwiki/config/index.php">here</a> to set up your wiki!';
		}
	}
else
	{
	echo 'Sorry, you must enter the wiki through the website. If you are on the website and still getting this error, tell the webmaster to include index.php instead of read.php.';
	}
?>