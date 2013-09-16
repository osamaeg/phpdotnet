<?php
define("__MYSQLERROR_ERROR__","Error");
define("__MYSQLERROR_NUMBER__","Error No");
define("__EmailAdmin__","osama_eg@live.com");


/*
@desc class Mysql to manage database  
@Author Osama salaam
@Package Mysql
@Version 0.1
@CopyRight 2010
*/
class Mysql {
//@var  address string Redirect Url
protected $address;

//@var  Error Boolean Check Error true
protected $Error=true;

//@var link Resource mysql
protected $link;

//@var Host,UserDb,PassDb,Dbname String  Paramters Connection.
private $Host,$UserDb,$PassDb,$Dbname;

//@var filetowrite,filemod,filetoread,filecontent  dirs String  Paramters hander File.
private $filetowrite,$filemod,$filetoread,$filecontent,$dirs;

//@var pattern String  Genrate key.
protected  $pattern="0123456789abcdefghijklmonpqrstyvwxyz!@%&()*/-";

//@var	string the table perfix
protected $perfix='cm_';

//@var	sql string the sql statment
private $sql;


//@var	table string Db Table
protected $table;

//@var	where string Sql Condtion.
protected $where;

//@var	SessionVar  Destroy variable Session.
protected $SessionVar;


//@var	Uploader  uploader file array
protected $Uploader;

//@var	numrows  count record
protected $numrows='0';

//@var	limit   record
public $limit=5;

//@var	start  record  
public $start='0';

public $condtions;







/**
* Mysql::__construct() -Function To Connect DB and select db 
*
*@param Host  Type:String  Host name
*@param UserDb  Type:String  database username
*@param PassDb  Type:String  database password
*@param Dbname  Type:String  database name
*@return boolean
*/


public function __construct($Host,$UserDb,$PassDb,$Dbname){
$this->Connect($Host,$UserDb,$PassDb,$Dbname);
}



public function Connect($Host,$UserDb,$PassDb,$Dbname){

$this->Host=$Host;
$this->UserDb=$UserDb;
$this->PassDb=$PassDb;
$this->Dbname=$Dbname;
$this->link=mysql_connect($this->Host,$this->UserDb,$this->PassDb);
if(!$this->link){
exit($this->Err());
}
if(!mysql_select_db($this->Dbname,$this->link) ){
exit($this->Err());
}
else {
return $this->link;

}

}




   /**
 *Mysql::print_error() function Error Show
 *@param sql String Error Mysql
 *@return String
*/



public  function print_error($err = "") {

$_error  = __MYSQLERROR_ERROR__." : ".mysql_error()."\n";
$_error .= __MYSQLERROR_NUMBER__.": ".mysql_errno()."\n";
$_error .= "Date: ".date("l dS of F Y h:i:s A")."\n";
if($err != '') {
$_error .= "$err";
}
$_error .= "\n---------------Query---------------";
$output = "<html dir=rtl><head><meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>Arab Portal Database Error</title>
<style>P,BODY{ font-family:Windows UI,arial; font-size:12px; }</style>
</head>
<body>
<br><br><blockquote><b>لم يكن قادر على اجراء الاستعلام من قاعدة البينات.</b><br>
يرجى المحاولة بتحديث الصفحة باضغط على هذا الرابط <a href=\"javascript:window.location=window.location;\">اضغط هنا</a>
اذا لم يجري الاستعلام الرجاء ابلاغ ادارة الموقع  <a href='mailto:".__EmailAdmin__."?subject=خطأ في قاعدة البينات'>مراسلة الموقع </a>
<br><br><b>الاستعلام الذي تسبب في الخطأ</b><br>
<form name='mysql'><textarea dir=\"ltr\" rows=\"15\" cols=\"70\">".$_error."\n$err</textarea></form></blockquote><br>
<p><b><a href=\"$_SERVER[HTTP_HOST]/\" target=\"_blank\">Powerd By Osama salama</a></b></p></body></html>";
print $output;
exit;
}





   /**
 *Mysql::Err() function Error Show
 *@param sql String Error Mysql
 *@return String
*/




public function Err($sql='') {
		$err = "<font color='red'>
				Mysql Error Occurred<br />
				Error Details:<br />
				File Name: ".__FILE__."<br />
				Line Number: ". __LINE__."<br />
				Err Number: ".mysql_errno()."<br />
				Err Desc: ".mysql_error()."<br /></font>";
		if($sql != '') {
			$err .= "Query Says: <textarea cols='60' rows='8'>$sql</textarea>";
		}
		if ($this->Error) {
			die($err);
		}
	}
 
 
 
 /**
  *Mysql::__destruct() function To Close Database 
  *@return boolean True
  */

 public function __destruct(){
 
 return @mysql_close($this->link);
 
 }
 


























}



?>
