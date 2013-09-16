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
 





 /**
  *Mysql::__destruct() function To Close Database 
  *@return boolean True
  */

 public function __destruct(){
 
 return @mysql_close($this->link);
 
 }
 
 
  /**
  *Mysql::GenerateKey()  function to genrate key
  *@return string random string 
  */
public function GenerateKey(){
$seed=(double) microtime() * 1000000;
srand($seed);
return rand();
} 
 
 
   /**
  *Mysql::makePassword()  function makePassword
  *@return string random string 
  */
public  function makePassword()
{
$salt = "R1aQ2qW3wE4eT5rY6tU7yI8uP9iLKoJHpGFDSAZXCVBNM";
srand((double)microtime()*1000000);
$i = 0;
while ($i <= 6)
{
$num = rand() % 30;
$tmp = substr($salt, $num, 1);
$pass = $pass . $tmp;
$i++;
}
return $pass;
}
 
 
  /**
  *Mysql::randomkey() function To get randomkey
  *@param  len  int  key length   
  *@return string
  */   
 
public  function randomkey($len){
 for($i=0;$i<$len;$i++){
$key.=$this->pattern{rand(0,44)};
 }
 return $key;
 }
 
 
 
 
 /**
  *Mysql::Redirect() function To Redirect
  *@param address string  Redirect Url
  *@return Boolean True 
  */
public function Redirect($address){
$this->address=$address;

if(!headers_sent()){
header("location:$this->address");
return true;
}  
else {
echo "<script type=\"text/javascript\">window.location.href=$this->address</script>";
echo "<meta http-equiv=\"refresh\" content=\"0;url=$this->address\">";
return true;
}
}


/**
 *Mysql::WriteFile()  function To Write new file
 *@param filetowrite string
 *@param filemod  string  Read,write, append 'w,w+,a,a+,r,r+,rb 
 *@return boolean
 */ 
 
public function WriteFile($filetowrite,$filecontent,$filemod='w+'){

$this->filetowrite=$filetowrite;
$this->filemod=$filemod;
$this->filecontent=$filecontent;
if(function_exists('fopen')){

if (!$fp = fopen($this->filetowrite,$this->filemod)) {
throw new Exception($this->Err);
exit;
    }
 if (fwrite($fp, $this->filecontent) === FALSE) {
throw new Exception($this->Err);
        exit;
    }
 fclose($fp);
  return true;
}  

else {
$fp=new SplFileObject($this->filetowrite,$this->filemod);
$fp->fwrite($this->filecontent);
$fp->fclose($fp);
 return true;
}


} 
 
 
 
 /**
  *Mysql::ReadFile() function To Open  file
  *@param filetowrite string
  *@param filemod string  Read,write, append 'w,w+,a,a+,r,r+,rb
  *@return string
*/ 
 
 public function ReadFile__($filetoread,$filemod='r'){

$this->filetoread=$filetoread;
$this->filemod=$filemod;
$out='';
if(file_exists($this->filetoread)){

if(function_exists('fopen')){

$fp=fopen($this->filetoread,$this->filemod);

while(!feof($fp)){
$out.=fread($fp,1024);
}
fclose($fp);
return $out;
} 

else {
$fp=new SplFileObject($this->filetoread);
foreach($fp as $line){
$out.=$line;
}

return $out;
}
}
else {
 return false;

 }

} 
 
 
 /**
  *Mysql::FormatSize() function To Format size  file
  *@param size Int File size
  *@return string
  */  
 
public function FormatSize($fileSize)
{
$count = 0;
$format = array("Bytes","KB","MB","GB","TB","PB","EB","ZB","YB");
while($fileSize>1024 && $count<9)
{
$fileSize=$fileSize/1024;
$count++;
}
$return = number_format($fileSize,2,'.',',')." <font color=red>".$format[$count]."</font>";
return $return;
}
 

 /**
  *Mysql::__FormatSize() alies function To Format size  file
  *@param size Int File size
  *@return string
  */  


public  function __FormatSize($fileSize)
{

$byteUnits = array(" GB"," MB"," KB"," bytes");

if($fileSize >= 1073741824)
{
$fileSize = round($fileSize / 1073741824 * 100) / 100 . $byteUnits[0];
}
elseif($fileSize >= 1048576)
{
$fileSize = round($fileSize / 1048576 * 100) / 100 . $byteUnits[1];
}
elseif($fileSize >= 1024)
{
$fileSize = round($fileSize / 1024 * 100) / 100 . $byteUnits[2];
}
else
{
$fileSize = $fileSize . $byteUnits[3];
}
return $fileSize;
}
 
 
  /**
  *Mysql::dir_size()  function to get folder size
  *@param path string File path
  *@return int
  */  
 
 
public function dir_size($path)
{
    $size = 0;

    $dir = opendir($path);
    if (!$dir){return 0;}

    while (($file = readdir($dir)) !== false) {

        if ($file[0] == '.'){ continue; }

        if (is_dir($path.$file)){
            // recursive:
            $size += dir_size($path.$file.DIRECTORY_SEPARATOR);
        }
        else {
            $size += filesize($path.$file);
        }
    }

    closedir($dir);
    return $size;
} 
 
 
 /**
 *Mysql::ReadDir() function To read all file in dir
 *@param   dirs  string directory String
 *@return array
*/  

public function ReadDir($dirs) {

$this->dirs=$dirs;

 if ($handle = opendir("$dirs")) {
   while (false !== ($item = readdir($handle))) {
     if ($item != "." && $item != "..") {
       if (is_dir("$dirs/$item")) {
 
         $this->ReadDir("$dirs/$item");
		 
       } else {
          $arrdir[]="$dirs/$item";
 //view file
       }
     }
   }
   closedir($handle);
 
 
 }
 return $arrdir;
}



 
 /**
  *Mysql::DeleteDir() function To delete all file in dir
  *@param   dirs  string directory String
  *@return boolean
  */  

public function DeleteDir($dirs) {
$this->dirs=$dirs;
 if ($handle = opendir("$dirs")) {
   while (false !== ($item = readdir($handle))) {
     if ($item != "." && $item != "..") {
       if (is_dir("$dirs/$item")) {
         $this->DeleteDir("$dirs/$item");
       } else {
         @unlink("$dirs/$item");
        }
     }
   }
   closedir($handle);
   @rmdir($dirs);
 
 }
}
 

 /**
  *Mysql::removeFolder() function To delete  directory
  *@param   dirs  string directory String
  *@return boolean
  */  


public function removeFolder($dir)
{
if(!is_dir($dir))
return false;

for($s = DIRECTORY_SEPARATOR, $stack = array($dir), $emptyDirs = array($dir); $dir = array_pop($stack);){
if(!($handle = @dir($dir)))
continue;
while(false !== $item = $handle->read())
$item != '.' && $item != '..' && (is_dir($path = $handle->path . $s . $item) ?
array_push($stack, $path) && array_push($emptyDirs, $path) : unlink($path));
$handle->close();
}
for($i = count($emptyDirs); $i--; rmdir($emptyDirs[$i]));

}




 /**
  *Mysql::get_days_for_month() function to get number of days in month
  *@param   m  int  month
  *@return Int
  */  

 public function get_days_for_month($m)
{
    $m = intval($m);
    if ($m == 4 || $m == 6 || $m == 9 || $m == 11) {
        return 30;
    }
    elseif ($m == 02) { return 28; }
    return 31;
}
 
 
 
  /**
  *Mysql::__day_month() function to get number of days in month
  *@param   month  int  month  like 02
  *@param   year  int  Year  like 1980
  *@see Calendar Functions
  *@return Int
  */
 
 
 public function __day_month($month,$year)
{
$days=cal_days_in_month(0,$month,$year);
    return $days;
} 






















}



?>
