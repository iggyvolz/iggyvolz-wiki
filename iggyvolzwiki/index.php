<?php
$webentry=TRUE;
include 'localsettings.php';
$con = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
if (!$con)
	  {
	  die('Could not connect to mySQL database: ' . mysql_error());
	  }
mysql_select_db($mysql_db, $con);
if(!function_exists('page_exists'))
{
function page_exists($pagename)
{
$sql="SELECT * FROM ".$GLOBALS['mysql_prefix']."pages WHERE Pagename='$pagename'";
$result_set = mysql_query($sql) or die(mysql_error());
$num_rows = mysql_num_rows($result_set);
if($num_rows==0)
{
return FALSE;
}
else
{
return TRUE;
}
}
}
if(!function_exists('pull'))
{
function pull($myrow, $pagename)
{
$sql="SELECT * FROM ".$GLOBALS['mysql_prefix']."pages WHERE Pagename='$pagename'";
$result = mysql_unbuffered_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($result))
  {
  return $row[$myrow];
  }
}
}
if(!function_exists('haspermission'))
{
function haspermission($pagename)
{
if(pull('Permission',$pagename)<$GLOBALS['permission'])
{
return TRUE;
}
else
{
return FALSE;
}
}
}
include 'read.php';
include 'edit.php';