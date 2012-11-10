<?php
if(isset($webentry))
	{
	function edit($pagename,$returnas = 'p',$rows = '50',$cols = '50')// Change 50 to change default, returnas will be what the pagename will return as (ex. example.com?{RETURNASVALUE}={PAGENAME}&code=... but in post form)
		{
		global $isread, $isedit, $mysql_prefix, $permission;
		function booltostr($bool, $true, $false)
			{
			if($bool)
				{
				return $true;
				}
			else
				{
				return $false;
				}
			}
		$defcode=pull('Script', $pagename);
		$usercode=$_REQUEST['code'];
		if($_REQUEST['submit']=='yes')
			{
			if(haspermission($pagename))
				{
				if(page_exists($pagename))
					{
					if(mysql_query("UPDATE ".$mysql_prefix."pages SET script='$usercode' WHERE pagename='$pagename'"))
						{
						echo 'Update successful!';
						}
					else
						{
						die("Update failed on $pagename with script $usercode and query \"UPDATE ".$mysql_prefix."pages SET script='$code' WHERE pagename='$pagename'\".  MySQL error: ".mysql_error());
						}
					}
				else
					{
					if(mysql_query("INSERT INTO ".$mysql_prefix."pages (Pagename, Script, Permission) VALUES ('$pagename', '$usercode', '1')")) // Permission 1 is unblocked anonomous users.
						{
						echo 'Page '.$pagename.' created successfully!';
						}
					else
						{
						die('Error: Page '.$pagename.' creation unsuccessful.  Error '.mysql_error().' on query '."INSERT INTO ".$mysql_prefix."pages (Pagename, Script, Permission) VALUES ('$pagename', '$usercode', '1')");
						}
					}
				}
			else
				{
				echo 'Error.  You do not have permission to edit this page.';
				}
			}
		else
			{
			$isread=FALSE; // Tell extensions we are not reading
			$isedit=TRUE; // Tell extensions we are editing
			include 'beforecode/index.php'; // Include extensions that want to go before code
			echo "<form action=\"\" method=\"post\">
			<input type=\"hidden\" name=\"submit\" value=\"yes\" />
			<input type=\"hidden\" name=\"$returnas\" value=\"$pagename\" />
			<textarea rows=\"$rows\" cols=\"$cols\" name=\"code\">$defcode</textarea><br /><br />";
			if(haspermission($pagename))
				{
				echo '<input type="submit" />';
				}
			else
				{
				echo 'You do not have permission to edit this page.  You may only view the source.';
				}
			include 'aftercode/index.php'; // Include extensions that want to go after code
			}
		}
	}
else
	{
	echo 'Sorry, you must enter the wiki through the website. If you are on the website and still getting this error, tell the webmaster to include index.php instead of read.php.';
	}


