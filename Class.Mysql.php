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








/**
  *Mysql::rowCount() function return row count
 *@param table string
 *@param con string sql condtion
 *@return int  row count
 */ 

public function rowCount($table,$condtions=''){
$this->table=$table;
$this->condtions=$condtions;
$sql="select count(*) as total from ".$this->perfix.$this->table."  $this->condtions ";
//echo $sql."<br/>";
$rowcount=@mysql_query($sql,$this->link) or $this->Err($sql)."";
$row=mysql_fetch_array($rowcount);
return $row['total'];
}
 

 /**
  *Mysql::__rowCount() alies function return row count depend on sql querys
 *@param sql string sql statment
 *@return int  row count
 */ 

public function __rowCount($sql){
$this->sql=$sql;
$rowcount=@mysql_query($this->sql,$this->link) or $this->Err($this->sql);
$row=mysql_fetch_array($rowcount);
return $row['total'];
 
} 
 
 
 /**
  *Mysql::insertid() Get Last ID insert
  *@return integer
  */
 
public function insertid(){
if (@mysql_affected_rows()>0)
{
$id = @mysql_insert_id($this->link);
}
return $id;
}

 
  /**
   *Mysql::Query() Fetch rows From Db
   *@param sql string sql statment;
   *@return array
   */
public function Query($sql){
$this->sql=$sql;
$rs=mysql_query($this->sql,$this->link) or $this->Err($this->sql);
while($row=mysql_fetch_array($rs)){
$rows[]=$row;
}


if(is_array($rows)){
return $rows;
} 
else{
return false;
}
 
}
 
 
 
  /**
   *Mysql::Queryper() Fetch rows From Db
   *@param sql string sql statment
   *@return array
   */
public function Queryper($sql){
if($_GET['page']==''){
$page=1;
} else {
$page=$_GET['page'];
}

if($_GET['start']==''){
$current=1;
} else {
$current=$_GET['start'];
}

$this->sql=$sql;
$rs=mysql_query($this->sql."  LIMIT $current , $page",$this->link) or $this->Err($this->sql);
$row=mysql_fetch_array($rs);
if(is_array($row)){
return $row;
} 
else{
return false;
}
 
} 
 

 
 
  /**
   *Mysql::SetQuery() Execute Query From Db
   *@param sql string sql statment;
   *@return boolean
 */ 
 
public function SetQuery($sql){
$rs=mysql_query($sql,$this->link) or $this->Err($sql."********");
if($rs==true){
return true;
}
else {
return false;
}
 
} 
 
 
 
				/**
				*Mysql::Fetch() Execute Query From Db
				*@param sql string sql statment;
				*@Example 
				
				$filed=array("cm_articles.ID","cm_articles.title","cm_cat.name","cm_cat.ID as cat");
				$table=array('cm_articles','aa');
				$arrjon=array("left join emp on emp.id=dept.cat","left join emp on emp.id=dept.cat");
				
				$da=$Db->Fetch($filed,$table,$arrjon,"where `ID`='6' ",false,"ID desc",2,50);
				
				
				$Filed=array("cm_articles.ID","cm_articles.title","cm_cat.name","cm_cat.ID as cat","count(cm_articles_comment.ID)");
				
				$From=array("cm_articles");
				
				$Join=array("left join cm_cat on cm_articles.cat=cm_cat.ID","left join cm_articles_comment on cm_articles.ID=cm_articles_comment.ref_id");
				$Condetion=false;
				$Group="cm_articles.ID";
				$Order="ID asc";
				//$Start=false;
				//$Limit=false;
				
				if(empty($_GET['start'])){
				$Start=0;
				
				} else {
				$Start=$_GET['start'];
				}
				$Limit='8';
				
				
				$da=$Db->Fetch($Filed,$From,$Join,$Condetion,$Group,$Order,$Start,$Limit);
				echo "<br/>";
				$len=$Db->FetchCount($Filed,$From,$Join,$Condetion,$Group);
				*@return boolean
				*/ 
 
public function Fetch($field="*",$from=array(),$join=array(),$con=false,$group=false,$order=false,$start=false,$limit=false){
if(is_array($field)){
$fields=implode(",",$field);
}
if(is_array($from)){
$froms=implode(",",$from);
}
if(is_array($join)){
$joins=implode("  ",$join);
}
else {
$joins='';
}
if($con){
$cons=$con;
}
if($group){
$groups="group by ".$group;
}
if($order){
$orders=" order by  ".$order;
}

if($start || $limit){
$limiter="limit ".$start.",".$limit;
}

$sql="select $fields  from $froms  $joins   $cons  $groups  $orders  $limiter";
echo $sql;
$rs=mysql_query($sql,$this->link) or $this->Err($sql);
while($row=mysql_fetch_array($rs)){
$rows[]=$row;
}

if(is_array($rows)){
return $rows;
} 
else{
return false;
}



}


///////////////////////////////////////////////////////



public function FetchCount($field="*",$from=array(),$join=array(),$con=false,$group=false){
if(is_array($field)){
$fields=implode(",",$field);
}
if(is_array($from)){
$froms=implode(",",$from);
}
if(is_array($join)){
$joins=implode("  ",$join);
}
else {
$joins='';
}
if($con){
$cons=$con;
}
if($group){
$groups="group by ".$group;
}

 $sql="select $fields  from $froms  $joins   $cons  $groups  ";
//echo $sql;
$rs=mysql_query($sql,$this->link) or $this->Err($sql);
return  mysql_num_rows($rs);



}



 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
  /**
   * Mysql::Insert() -   INSERT  query
   *
   * @param string $table - the table you will INSERT 
   * @param array $fields_values - array from the feilds and values
   * @return object
   */
 
 
public function Insert($table,$fields_values=array()){
//$Db_Expr=array('NOW()','CURDATE()','ADDDATE','','','');
$this->table=$table;
$check = true;
$val = '';
$names = '';
foreach ($fields_values as $fields=>$values) {
if ($check) {
$check = false;
} else {
$names .= ',';
$val .= ',';
}
$names .= $fields;
if($values=='NOW()'){
$val .=$values;
} 
else {
$val .= $this->Quote($values);

}
}

$sql = "INSERT INTO  ". $this->perfix.$this->table ." ($names) VALUES ($val);";
$rs=mysql_query($sql,$this->link) or $this->Err($sql);
if($rs==true){
return true;
}
else {
return false;
}
 
} 
 
 

   /**
   * Mysql::Insert() -  Alies  INSERT  query
   *
   * @param string $table - the table you will INSERT 
   * @param array $fields_values - array from the feilds and values
   *@Example 
  $arr2=array(
"name"=>$Db->Filter($Db->Quote("nader")),
"dat"=>"NOW()",
"dat_reg"=>"adddate(NOW(),INTERVAL 1 YEAR)"
);

   
   * @return object
   */
 
 
 
 public function __Insert($table,$fields_values=array()){

$this->table=$table;
$check = true;
$val = '';
$names = '';
foreach ($fields_values as $fields=>$values) {
if ($check) {
$check = false;
} else {
$names .= ',';
$val .= ',';
}
$names .= $fields;

$val .= $values;

}

$sql = "INSERT INTO  ". $this->perfix.$this->table ." ($names) VALUES ($val);";
$rs=mysql_query($sql,$this->link) or $this->Err($sql);
if($rs==true){
return true;
}
else {
return false;
}
 
} 
 
  
 
 
   /**
   * Mysql::update() -   update  query
   *
   * @param string $table - the table you will UPDATE in it
   * @param array $fields_values - array from the feilds and values
   * @param string $where - if you choose AUTO_UPDATE you will need to specify where condition
   * @return object
   */
 
public function Update($table,$fields_values,$where=false){
$this->table=$table;
$set = '';
$first=true;
foreach ($fields_values as $fields=>$values) {
if ($first) {
	$first = false;
} else {
	$set .= ',';
}
$set .= "$fields = ".$this->Quote($values);
}
$sql = "UPDATE ".$this->perfix.$this->table ." SET $set";
if ($where) {
$sql .= "$where";
}
 
$rs=mysql_query($sql,$this->link) or $this->Err($sql);
if($rs==true){
return true;
}
else {
return false;
}


} 
 
 
 
   /**
   * Mysql::update() -   Alies method  Update
   *
   * @param string $table - the table you will UPDATE in it
   * @param array $fields_values - array from the feilds and values
   * @param string $where - if you choose AUTO_UPDATE you will need to specify where condition
   *@Example 
   $arr=array(
//"name"=>$Db->Quote("ahmed"), //or "name"=>$Db->Filter($Db->Quote("ahmed")),
"name"=>$Db->Filter($Db->Quote("tamer")),
"dat"=>"NOW()",
"dat_reg"=>"NOW()",
"counter"=>"(counter+1)"
);


$Db->__Update("test",$arr," where `ID`='1' ");
   * @return object
   */
 
 
 
public function __Update($table,$fields_values,$where=false){
$this->table=$table;
$set = '';
$first=true;
foreach ($fields_values as $fields=>$values) {
if ($first) {
	$first = false;
} else {
	$set .= ',';
}
$set .= "$fields = ".$values;
}
$sql = "UPDATE ".$this->perfix.$this->table ." SET $set";
if ($where) {
$sql .= "$where";
}
 
$rs=mysql_query($sql,$this->link) or $this->Err($sql);
if($rs==true){
return true;
}
else {
return false;
}


} 
 
 
 
 
 
   /**
    *Mysql::Delete() Delete Row function From Db
    *@param table string   table Db
    *@param where string  where Condtion
    *@return boolean
    */ 
public function Delete($table,$where=''){
$this->table=$table;
$this->where=$where;
$sql="delete from ".$this->perfix.$this->table .'  '. $this->where;
$rs=mysql_query($sql,$this->link) or $this->Err($sql);
if($rs==true){
return true;
}
else {
return false;
}

} 
  
  
   /**
    *Mysql::FetchAll() FetchAll Rows From table
    *@param table string  Database table ;
    *@param where string Condtion statment;
    *@return Array
    */ 
 
public function FetchAll($table,$where=''){
$this->table=$table;
$this->where=$where;

 $this->sql="select * from ".$this->perfix.$this->table . $this->where;
 //echo $this->sql."<br/>";
$rs=mysql_query($this->sql,$this->link) or $this->Err($this->sql);


while($row=mysql_fetch_array($rs)){
$rows[]=$row;
}
if(is_array($rows)){
return $rows;
} 
else{
return false;
}
 
} 
  
  
     /**
    *Mysql::__FetchAll() alies FetchAll Rows From table
    *@param table string  Database table ;
    *@param where string Condtion statment;
	*@Example
	 if(empty($_GET['start'])){
     $Start=0;

    } else {
     $Start=$_GET['start'];
     }
     $Limit='8';
    *@return Array
    */ 
  
 public function __FetchAll($table,$where='',$start=false,$limit=false){
$this->table=$table;
$this->where=$where;

if($start || $limit){
$limiter="limit ".$start.",".$limit;
}
 $this->sql="select * from ".$this->perfix.$this->table . $this->where ."  ". $limiter;
$rs=mysql_query($this->sql,$this->link) or $this->Err($this->sql);
while($row=mysql_fetch_array($rs)){
$rows[]=$row;
}
if(is_array($rows)){
return $rows;
} 
else{
return false;
}
 
} 
    
  
  
  
   /**
    * Mysql::FetchRow() Fetch one Row From table
    *@param table string  Database table ;
    *@param where string Condtion statment;
    *@return Array
    */   
  
 public function FetchRow($table,$where=''){
$this->table=$table;
$this->where=$where;
$this->sql="select * from ".$this->perfix.$this->table . $this->where.' limit 1';
$rs=mysql_query($this->sql,$this->link) or $this->Err($this->sql);
$row=mysql_fetch_array($rs);
if(is_array($row)){
return $row;
} 
else{
return false;
}
 

} 
  



       /**
      *Mysql::pageNum() - function to genrate paging 
      *@param perpage  string  number limit in page 10
	  *@param link  string    Additional link
	  *@Example $Db->pageNum("num page","?action=news",$countRow);
	  *@param rowcount  int   count record
      *@return string
      */

 

public function pageNum($perpage,$link,$rowcount)
{
 
$GetPage=$this->Filter($_GET['page']);
$GetStart=$this->Filter($_GET['start']);
 
$this->numrows=$rowcount;

if ($this->numrows > $perpage )  {

$pagenum = "<br><table class='pagingnav' border='0' dir='rtl' cellpadding='3'><tr><td><div class='mylink'><b>الصفحات</div></td>";

 if($GetPage > 1) {
	$prestart = ($GetPage*$perpage)-(2*$perpage);
	$prepage =  $GetPage - 1;
	$pagenum .= "<td class=mylink><b><a title='الأولى' href=".$this->self."?action=$link&start=0&page=1>
	الصفحة الأولى</a></td>\n";
	$pagenum .= "<td class=mylink><a title='الصفحة السابقة' href=".$this->self."?action=$link&start=$prestart&page=$prepage>الصفحة السابقة</a></td>\n";
}


$pages=ceil($this->numrows/$perpage);
if($GetPage == 0) {
	$GetPage = 1;
}
if($GetPage > 0){
	$GetPage = $GetPage - 2;
}
$maxpage =  $GetPage + 4 ;             for ($i = $GetPage ; $i <= $maxpage && $i <= $pages ; $i++){
	if($i > 0){
		$nextpag = $perpage*($i-1);
		if ($nextpag == $GetStart) {
			$pagenum .= "<td class=mylink><div class='pagingnav'><center><b>$i</b>&nbsp;\n</div></td>";
		}else{
			$pagenum .= "<td class=mylink><a href=$this->self?action=$link&start=$nextpag&page=$i>$i</a></td>";
	   }
	}
 }

 if (! ( ($GetStart/$perpage) == ($pages - 1) ) && ($pages != 1) )
 {
	 $nextpag = ($pages*$perpage)-$perpage;
	 $nextstart = ($GetPage+2)*$perpage;
	 $nextpage= $GetPage + 3;
	 $pagenum .= "<td><font class=mylink><a title='الصفحة التالية' href=".$this->self."?action=$link&start=$nextstart&page=$nextpage> الصفحة التالية</a></font></td>";
	 $pagenum .= "<td><font class=mylink><a title='الأخيرة' href=".$this->self."?action=$link&start=$nextstart&page=$nextpage> الأخيرة</a></font></td>";
 } 
$pagenum .= "</tr></table>";
}  


return $pagenum;
}







  /**
   *Mysql::Pager()  generate paging show per page
   *@param sql string  sql  table 
   *@param page string  link page
   *@param start string   start record from;
   *@param limit string   limit record select
   *@param addlink string Addtional param url
   *@return String
   */ 
public function  Pager($sql,$start,$limit,$page,$addlink){ 

@$num=$this->__rowCount($sql);
for($i=0;$i<ceil($num/$limit);$i++){
$b=$i+1;
$start=$limit*$i;
$data.="[&nbsp;<a style='text-decoration:none' href=$page&start=$start&limit=$limit&$addlink><font size=1>&nbsp;<b>$b</b>&nbsp;</a>&nbsp;</font>]";
}
return $data;
 
}




  /**
   *Mysql::__Pager() limit  rows From Db
   *@param limit int  limit select db
   *@param link string add link to button
   *@param pages int  row count
   *@return string
   */

public function __Pager($i,$limit,$link,$pages){
$s=$i;

$no3=@floor($pages/$limit);
$no2=++$no3;
$html="<centeR><table width=100% dir=rtl class='menu_tr'><TR><TD><centeR>";
if($pages>$limit)
{
if($i==1)
{
$html.= " <font class=pageper> باقى الصفحات  ";
}

$no22=$no2;

if($no2>15)
{


$waw=$no2-15;
if($i<$waw)
{
$gogo=$i+14;
}
else
{
$gogo=$no2;
}

}
else
{
$gogo=$no2;
}


if($i >1)
{
$newi=$i-1;
$html.="<font class=pageper>
<a href=?i=$newi&$link>
السابق</a>";
}

	
for ($i=$i ;$i<$gogo ; $i++)
{

if($i==$s)
{
$html.= "  <font class=pageper>|<B> $i</b>";
}
else
{
$html.= "  <font class=pageper>| <a class=main href=?i=$i&$link>$i</a>";
}
			
}

if($no22>15 and $s<$waw)
{
$html.= "   <font class=pageper>  | <a href=?i=$i&$link>التالى";
}
else
{
$html.= "   <font class=pageper>  | ";
}
 $html.= " <BR>";
}
$html.="</TD></TR></table >";

return $html;
 } 
 
 
 


  /**
   *Mysql::ConvertEncode() Convert String Between utf-8 or ISO-8859-1 or windows-1256
   *@param in_encoding string Encoding Type ;
   *@param out_encoding string  Encoding Type want to convert to ;
   *@param str string;
   *@return string Converting
   */ 
 
public function ConvertEncode($in_encoding,$out_encoding,$str){
$result=@iconv($in_encoding,$out_encoding,$str);
return $result;
}  
 
 
 
  /**
   *Mysql::Upload() Function upload file 
   *@param file   $_FILES array ;
   *@param target string  path upload ;
   *@param mime array;
   *@param mark string;
   *@return string 
   */ 
 
public function Upload($file,$tmp,$target,$mime,$mark=''){
$fileextention=$this->File_extension($file);
if(in_array(strtoupper($fileextention),$mime)){
$filename=$this->GenerateKey().time().$mark.'.'.$fileextention;
move_uploaded_file($tmp,$target.$filename) or die('Error Upload File');
return $filename;
}
else {
return false;
}
}  
  
 
 
   /**
   *Mysql::Timeshow() Function view date format
   *@return string 
   */ 
 
public function Timeshow(){
return date("l ,d F Y H:i");
}  
 

  /**
   *Mysql::ShowIP() Get IP Adress
   *@return string IP
   */ 

public function ShowIP(){
if(getenv('HTTP_X_FORWARDED_FOR')){
$ip=getenv('HTTP_X_FORWARDED_FOR');
}
elseif (getenv('HTTP_CLIENT_IP')){
$ip=getenv('HTTP_CLIENT_IP');
}
elseif(getenv('REMOTE_ADDR')) {
$ip=getenv('REMOTE_ADDR');
} 
 else {
$ip=$_SERVER['REMOTE_ADDR']; 
 }
 return $ip;
}   
 
 

 
 
  /**
   *Mysql::Sendmail() Send Mail by Mail Function...
   *@param address string  Mail Address 
   *@param subject string  Subject message
   *@param message content Message
   *@param from mail send from it
   *@see mail  Function
   *@return boolean true
   */ 
 
public function Sendmail($address,$subject,$message,$from){
 
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8'. "\r\n";
$headers .= 'From: '.$from .' Reply-To: '.$from.'\r\n X-Mailer: PHP/'. phpversion();
if(@mail($address,$subject,$message,$headers)){
return true;
}else{
return false;
} 
 
}   
  
public function __Sendmail($to,$subject,$message,$attach=false,$From=false,$FromName=false){

try {
$row=$this->FetchRow('setting','');

$mail = new phpmailer();
$mail->Subject  =$subject;
if($From){
$mail->From     = $From;
} else {
$mail->From     = $row['frommail'];
}

if($FromName){
$mail->FromName = $FromName;
} else {
$mail->FromName = $row["fromname"];
}


$mail->CharSet='utf-8';
$mail->ContentType = "text/html";
$mail->IsHTML(true);
$mail->Priority ="1";
$mail->Port=$row['smtpport'];

if($attach){
$mail->AddAttachment($attach);
}
switch($row["mailserver"])
{
case "smtp" :
$mail->Host=$row["smtphost"];
$mail->SMTPDebug=false;
$mail->SMTPAuth=true;
$mail->Username=$row["smtpuser"];
$mail->Password=$row["smtppass"];
$mail->Mailer="smtp";
 break;
case "sendmail"  :
$mail->Sendmail=$row["path_sendmail"];
$mail->Mailer="sendmail";
break;
case "php":
default :
$mail->Mailer="mail";
break;
}
$mail->Body=$message;
$mail->AddAddress($to);

if(@!$mail->Send()) {
@$mail->ClearAddresses();
return false;
} else {
return true;
}


} catch (phpmailerException $e) {
 // echo $e->errorMessage(); 
} catch (Exception $e) {
//  echo $e->getMessage(); 
}



}




  /**
   *Mysql::SetCookie()  Function save cookie in client user...
   *@param name string cookie name 
   *@param valie string  cookie value 
   *@param Expire time time in houre
   *@see SetCookie  Function
   *@return boolean true
   */ 


public function SetCookie($name,$val,$expire='1'){
$calexpire=3600*$expire;
$check=@setcookie($name, $val, time()+$calexpire);
return $check;
}   
 
 
 
 
   /**
    *Mysql::GetCookie() Get Cookie value  Function  restore cookie in client user...
    *@param name string cookie name 
    *@see SetCookie  Function
    *@return string 
    */ 
 
public function GetCookie($name){
 return @$_COOKIE["$name"];
} 
 
 
   /**
    *Mysql::delCookie() delete Cookie   Function  delete cookie in client user...
    *@param name string cookie name 
    *@see SetCookie  Function
    *@return boolean true
    */  
public function delCookie($name){
 @setcookie($name,'', time()-3600);
}  
 
 
 
 
 
  /**
   *Mysql::Download() Download File.......
   *@param file string Filename &path file;
   *@return string 
   */ 
 
public function download( $file )
{
@header( "Pragma: public");
@header( "Expires: 0");
@header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
@header( "Accept-Ranges: none");
@header( "Content-Type: application/force-download");
@header( "Content-Type: application/octet-stream");
@header( 'Content-Disposition: attachment; filename="'. basename($file) .'"');
@header( "Content-Length: ". filesize($file));
@header( "Content-Transfer-Encoding: binary");
@header( "Content-Description: File Transfert");
@readfile( $file );
exit;
 
    } 
 
 
   /**
   *Mysql::__Download() Download File  by depend on speed limit. ......
   *@param file string Filename &path file;
   *@param download_rate Int speed download by KB
   *@return string 
   */ 
 
 
 
public function __Download($file,$download_rate=30){

header('Cache-control: private');
header('Content-Type: application/octet-stream');
header('Content-Length: '.filesize($file));
header('Content-Disposition: filename="'. basename($file) .'"');
flush();
$file = fopen($file, "r");
while(!feof($file))
{
echo fread($file, round($download_rate * 1024));
flush();
sleep(1);
}
fclose($file);



}

 
 
 
 
 
 
 
   /**
    *Mysql::File_extension() get File Exetention.......
    *@param filename string Filename &path file;
    *@return string 
    */
 
public function File_extension($filename){

$exe=end(explode(".","$filename")); 

return  $exe;
 
}  


   /**
    *Mysql::__File_extension()  alies function get File Exetention.......
    *@param filename string Filename &path file;
    *@return string 
    */

function __File_extension($filename)
{
$path_info = @pathinfo($filename);
return $path_info['extension'];
}

 
 
    /**
    *Mysql::Validate()    function validate input data.......
    *@param input string data input want by users
	*@param type string Validate type (Empty|Email|IP|Int|String|Upload)
    *@return Boolean  
    */
 
 
public function Validate($input,$type){
 
switch($type){
case "Empty":
$s=strlen($input);
if ($s >0) {
return true;
} else 
{ return false;
}
 break;
case "Email":
$Valid=preg_match('/^(.+)@([^@]+)$/',$input);
return $Valid;
break;
case "IP":
$Valid=preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $input);
return $Valid;
break;
case "Int":
$Valid=ctype_digit($input);
return $Valid;
break;
case "String":
$Valid=ctype_alpha($input); 
return $Valid;
break;
case "Url":
$Valid=preg_match("/^(http://)?([^/] )/i",$input);
return $Valid;
case "Upload":
$Valid=preg_match("/^(.+)\\.(.+)/i",$input);
return $Valid;


break;
} 
} 



   /**
   * Mysql::Filter() -   filter input data   
   * @param input string data input 
   * @FileSource class.filter.php
   * @return string
   */

public function Filter($input){
$filter=new InputFilter();
$filterval=$filter->process($input);
return  $filterval;
}  
 
 
 

   /**
   * Mysql::roleAccess() -   Authenticate user   
   * @param account Array ,associated array account users array('User1'=>'pass1')
   * @return boolean
   */

public function roleAccess($account=array()){
$login_successful = false;
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
{
$usr = $_SERVER['PHP_AUTH_USER'];
$pwd = $_SERVER['PHP_AUTH_PW'];
 foreach($account as $key=>$value){
 if($usr == $key && $pwd == $value){
 $login_successful = true;
 break;
 }
  }
}
 if (!$login_successful)
{
    header('WWW-Authenticate: Basic realm="Secret page"');
    header('HTTP/1.0 401 Unauthorized');
    print "Login failed!\n";
}
}
 
 
 
   /**
   * Mysql::Apacheinfo() -   Show Apacheinfo
   * @param att  (M,V,U) string  type info from apache
   * @param uri    string  filename form lookup
   * @return string
   */ 
  public function Apacheinfo($att,$uri=''){
 
switch($att){
case "M":
$appserv= apache_get_modules() ;
return $appserv;
break;
case "V":
$appserv=  apache_get_version ();
return $appserv;
break;
case "U":
 $appserv= apache_lookup_uri($uri);
 return $appserv;
break;
} 
  
}  
 
 
    /**
     * Mysql::ServerInfo() -  get info about server
     * @return string
     */ 
 public function ServerInfo(){
 return phpinfo();
}  



    /**
     * Mysql::ReadRss() -   Read rss file
     * @param url   string  path file xml
     * @return array
     */ 
 
public function ReadRss($url){

$filerss=$this->remoteFile($url);
$xml= simplexml_load_string($filerss);
$rss=$xml->xpath('//item');
 if(is_array($rss)){
 return $rss;
 }
 return false;
}  


 
    /**
     * Mysql::Read_column() -   select specified column ID,name,sal 
	 *  
	 *
     * @param column   column ID 
	 * @param table   string table name
     * @return resource
     */ 
public function Read_column($column,$table){

$sql="select $column from $this->perfix $table";
$rs=mysql_query($sql,$this->link) or die($this->Err($sql));
 return $rs;
}



    /**

	
	
     * Mysql::WriteRss() -   create rss file depend on read_colum method 
	 @Example  $arrdesc=array('title'=>'title','link'=>'http://www.masrawy.com/News','description'=>'Masrawy  News','generator'=>'generator','url'=>'http://www.masrawy.com/News','image_url'=>'image_url','image_link'=>'image_link');
     * @param filename   column ID
	 * @param arrdesc   array  rss descrption
	 * @param column   string  column name ,Id,title,date,text
     * @param table   string     table name
	 * @param linksnews   string  link news
     * @return string
     */ 


public function WriteRss($filename,$arrdesc,$column,$table,$linksnews){
$doc = new DOMDocument();
$root = $doc->createElement('rss');
$doc->appendChild($root);
$root->setAttribute('version', '2.0');
$channel=$doc->createElement('channel');
$channel=$root->appendChild($channel);
$title_=$doc->createElement('title',$arrdesc['title']);
$channel->appendChild($title_);
$link_=$doc->createElement('link',$arrdesc['link']);
$channel->appendChild($link_);
$description_=$doc->createElement('description');
$description_=$channel->appendChild($description_);
$dec=$doc->createCDATASection($arrdesc['description']);
$description_->appendChild($dec);
$generator_=$doc->createElement('generator',$arrdesc['generator']);
$channel->appendChild($generator_);
$url_=$doc->createElement('url',$arrdesc['url']);
$channel->appendChild($url_);
$language_=$doc->createElement('language','en-ar');
$channel->appendChild($language_);
$img_=$doc->createElement('image');
$channel->appendChild($img_);
$img_url=$doc->createElement('url',$arrdesc['image_url']);
$img_->appendChild($img_url);
$img_link=$doc->createElement('link',$arrdesc['image_link']);
$img_->appendChild($img_link);
$rs=$this->Read_column($column,$table);
while($row=mysql_fetch_array($rs)){
$linknews_=$linksnews. '&amp;' . 'id= '.$row['0'];
$item=$doc->createElement('item');
$channel->appendChild($item);
$element1=$doc->createElement('title',$row['1']);
$item->appendChild($element1);
$element2=$doc->createElement('link',$linknews_);
$item->appendChild($element2);
$element3=$doc->createElement('guid',$linknews_);
$item->appendChild($element3);
$element31=$doc->createElement('pubDate',$row['2']);
$item->appendChild($element31);

$element4=$doc->createElement('description');
$element4=$item->appendChild($element4);
$dec4=$doc->createCDATASection($row['3']);
$element4->appendChild($dec4);
}
$doc->save($filename);
} 




    /**
     * Mysql::ReadXml() -   Read xml file
     * @param filename   string  path file xml
     * @return Object
     */ 
public function ReadXml($filename){

$Chexe=strtoupper($this->File_extension($filename));
if($Chexe=="XML")
{
$Obj=simplexml_load_file($filename);
return $Obj;
} 
else {
return false;
}
 
} 
 
 
 
 
     /**
     * Mysql::ReadJson() -   Read json file
     * @param filename   string  path file xml
     * @return array
     */ 
 
public function ReadJson($filename){

if(file_exists($filename)){
$file=file_get_contents($filename); 
$json=json_decode($file);
return $json;
 } else {
 return false;
 }
} 

 
     /**
     * Mysql::ImageSize() -   resize image
     * @param ImgSrc   string  image path
	 * @param ImgTarget   string  image path target
	 * @param x   int  width file
	 * @param y   int  heigth file
     * @return string
     */ 
	 
public function ImageSize($ImgSrc,$ImgTarget,$x,$y){
 if(function_exists('imagecreatefromjpeg'))
 {
 
 try
 {
switch (strtoupper($this->File_extension($ImgSrc))){
case "JPG":
case "JPEG" :
$im=@imagecreatefromjpeg($ImgSrc);
break;
case "GIF":
$im=@imagecreatefromgif($ImgSrc);
break;
case "PNG":
$im=@imagecreatefrompng($ImgSrc);
break;
} 
$canves=@imagecreatetruecolor($x,$y);
$width=@imagesx($im);
$height=@imagesy($im);
 @imagecopyresampled($canves,$im,0,0,0,0,$x,$y,$width,$height);
@imagegif($canves,$ImgTarget);
@imagedestroy($im);
@imagedestroy($canves); 
  
} 
catch(Exception  $e){
echo "<script>alert($e->getMessage())</script>"; 
}
}
else{
dir('GD Not Support in Server.........');
}

}
 
 
      /**
       * Mysql::remoteFile() -   Read file from server
       * @param url   string  path file
       * @return string
       */ 
 
public function remoteFile($url){
if(function_exists('curl_init')){
$curl = @curl_init(); 
$timeout = 0;
@curl_setopt ($curl, CURLOPT_URL, $url); 
@curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true); 
@curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, $timeout); 
$buffer = @curl_exec($curl); 
@curl_close($curl); 
return $buffer;
}elseif(function_exists('file_get_contents')){
$buffer = @file_get_contents($url); 
return $buffer;
}elseif(function_exists('file')){
$buffer = @implode('',@file($url)); 
return $buffer;
}else{
return false;
}
}
 

 
       /**
       * Mysql::Session_Time() -   Increase session time we must call before session start
       * @param sec   int  secound time
       * @return boolean
       */ 
 
 
public function Session_Time($sec){
session_set_cookie_params($sec);
}
  
 
 
       /**
       * Mysql::Session_Id() -  show session ID
       * @return int
       */ 
 
public function Session_Id(){
return session_id();
}
 
 
 
        /**
        * Mysql::Session_clean() -  show session ID
	    *@param SessionVar string varabile name;
        * @return boolean true; 
        */ 
 
 public function Session_clean($SessionVar){
$this->SessionVar=$SessionVar;
unset($_SESSION[$this->SessionVar]); 
}
 






 
     /**
      * Mysql::Session_Detstroy() -  dsetroy all session
      * @return boolean true; 
      */ 
 
public function Session_Detstroy(){
session_unset();
session_destroy();
$_SESSION=array();
}
  
 
   /**
   * Mysql::AddSlashes() - make string save to use
   * @param string $str
   * @return string
   */
   
	public function AddSlashes($str) {
		if (!get_magic_Quotes_gpc()) {
	    	$str = addslashes(strip_tags($str));
		} else {
		    $str = strip_tags($str);
		}
		return $str;
	}
	
   /**
   * Mysql::Quote() - prepare string to inserted or updated in the database
   * @param string $string
   * @return string
   */
   
	public function Quote($string = null) {
        return ($string === null) ? 'NULL' : "'" . str_replace("'", "''", $string) . "'";
    }
    



   /**
    * Mysql::text2links() - convert all link to html link and active it
    * @param str  string
    * @return string
    */	

public function text2links($str = '')
{
if($str=='' or !preg_match('/(http|www\.|@)/i', $str)) { return $str; }
$lines = explode("\n", $str);
$new_text = '';
while (list($k,$l) = each($lines))
{
$l = preg_replace("/([ \t]|^)www\./i", "\\1http://www.", $l);
$l = preg_replace("/([ \t]|^)ftp\./i", "\\1ftp://ftp.", $l);

$l = preg_replace("/(http:\/\/[^ )\r\n!]+)/i",
"<a href=\"\\1\">\\1</a>", $l);

$l = preg_replace("/(https:\/\/[^ )\r\n!]+)/i",
"<a href=\"\\1\">\\1</a>", $l);

$l = preg_replace("/(ftp:\/\/[^ )\r\n!]+)/i",
"<a href=\"\\1\">\\1</a>", $l);

$l = preg_replace(
"/([-a-z0-9_]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)+))/i",
"<a href=\"mailto:\\1\">\\1</a>", $l);
$new_text .= $l."\n";
}

return $new_text;
}
	
	///////////////
	
 
    /**
    *Mysql::fix_badwords() - Filter all bad words
    *@param str  string text want to filter
    *@param bad_words  string with bad words  fuck,shit,paragraph
    *@param replace_str  string ,*
    *@return string
    */	

public function fix_badwords($str, $bad_words, $replace_str='')
{
    if (!is_array($bad_words)){ $bad_words = explode(',', $bad_words); }
    for ($x=0; $x < count($bad_words); $x++)
    {
        $fix = isset($bad_words[$x]) ? $bad_words[$x] : '';
        $_replace_str = $replace_str;
        if (strlen($replace_str)==1)
        {
            $_replace_str = str_pad($_replace_str, strlen($fix), $replace_str);
        }
        $str = preg_replace('/'.$fix.'/i', $_replace_str, $str);
    }
    return $str;
} 
 
 /////
 
     /**
    *Mysql::str_to_hex() -Convert string to hex
    *@param string  string text  
    *@return string
    */	
 
public function str_to_hex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}




     /**
      *Mysql::hex_to_str() -Convert hex to string
      *@param hex  string text  
      *@return string
      */	
public function hex_to_str($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}



     /**
      *Mysql::Flash_message() -Show flash  message 
      *@param title  string  title message 
	  *@param msg  string content message  
	  *@param type  string  type message (Warning|Notice|Apply)   
      *@return string
      */	


public function Flash_message($title,$msg,$type='Warning'){
switch($type){
case "Warning":
$content=$this->ReadFile__("../public/external/msg/Warning.dat",'r');
break;
case "Notice":
 $content=$this->ReadFile__("../public/external/msg/Notice.dat",'r');
break;
case "Apply":
 $content=$this->ReadFile__("../public/external/msg/Apply.dat",'r');
break;
}
$content1=str_replace("{_TITLE}",$title,$content);
$flash__=str_replace("{_MSG}",$msg,$content1);
return $flash__;
}

 
 
 
public function Front_message($title,$msg,$type='Warning'){
switch($type){
case "Warning":
$content=$this->ReadFile__("public/external/msg/Warning2.dat",'r');
break;
case "Notice":
 $content=$this->ReadFile__("public/external/msg/Notice2.dat",'r');
break;
case "Apply":
 $content=$this->ReadFile__("public/external/msg/Apply2.dat",'r');
break;
}
$content1=str_replace("{_TITLE}",$title,$content);
$flash__=str_replace("{_MSG}",$msg,$content1);
return $flash__;
}
 
 
 
 
 
 
 
      /**
      *Mysql::Date_Arabic() -Show date  arabic 
      *@param GetDateFormat  string date now  ,example  Date_Arabic(date("Y-m-d"),"d / m / y")."هـ";
	  *@param DFormat  string    date Schema
      *@return string
      */	
 
 
 
public function Date_Arabic($GetDateFormat,$DFormat)
{
//start function
$Days=@date("D");   //print day name+Saturday-->Friday
//start hijri function date
$TDays=round(strtotime($GetDateFormat)/(3600*24));
$HYear=round($TDays/354.3667);
$Remain=$TDays-($HYear*354.3667);
$HMonths=round($Remain/29.5305);
$HDays=$Remain-($HMonths*29.5305);
$HYear=$HYear+1389;
$HMonths=$HMonths+10;
$HDays=$HDays+23;
//hijri function days between [29:30]
if ($HDays>29.5305 and round($HDays)!=30)
{
$HMonths=$HMonths+1;
$HDays=Round($HDays-29.5305);
}
else
{
$HDays=Round($HDays);
}
//hijri function months
if ($HMonths>12)
{
$HMonths=$HMonths-12;
$HYear=$HYear+1;
}
//hijri month names [print month name]
if ($HMonths=="1")  $hmname="محرم";
if ($HMonths=="2")  $hmname="صفر";
if ($HMonths=="3")  $hmname="ربيع الأول";
if ($HMonths=="4")  $hmname="ربيع الثاني";
if ($HMonths=="5")  $hmname="جمادى الأولى";
if ($HMonths=="6")  $hmname="جمادى الثانية";
if ($HMonths=="7")  $hmname="رجب";
if ($HMonths=="8")  $hmname="شعبان";
if ($HMonths=="9")  $hmname="رمضان";
if ($HMonths=="10") $hmname="شوال";
if ($HMonths=="11") $hmname="ذو القعدة";
if ($HMonths=="12") $hmname="ذو الحجة";
//day function [print day name]
if ($Days=="Sat")   $dd="السبت";
if ($Days=="Sun")   $dd="الأحد";
if ($Days=="Mon")   $dd="الاثنين";
if ($Days=="Tue")   $dd="الثلاثاء";
if ($Days=="Wed")   $dd="الأربعاء";
if ($Days=="Thu")   $dd="الخميس";
if ($Days=="Fri")   $dd="الجمعة";

$les = strlen($DFormat);
for($i=0; $i<=$les; $i++)
{
$df[$i]= substr ($DFormat,$i,1);
if($df[$i]=="A" || $df[$i]=="a")
{
$ddf=@date("a",$GetDateFormat);
if(substr($ddf,0,1)=="a")
{
$Result.="صباحاً";
}
else
{
$Result>="مساءً";
}
}
elseif($df[$i]=="D")  {$Result.="$dd";}
elseif($df[$i]=="d")  {$Result.="$HDays";}
elseif($df[$i]=="m")  {$Result.="$HMonths";}
elseif($df[$i]=="M")  {$Result.="$hmname";}
elseif($df[$i]=="y")  {$Result.="$HYear";}
elseif($df[$i]=="Y")  {$Result.="$HYear"."هجري";}
elseif($df[$i]=="g")  {$Result.=@date("g",$GetDateFormat);}
elseif($df[$i]=="G")  {$Result.=@date("G",$GetDateFormat);}
elseif($df[$i]=="i")  {$Result.=@date("i",$GetDateFormat);}
elseif($df[$i]=="H")  {$Result.=@date("H",$GetDateFormat);}
elseif($df[$i]=="h")  {$Result.=@date("i",$GetDateFormat);}
elseif($df[$i]=="s")  {$Result.=@date("s",$GetDateFormat);}
else
{
$Result.=$df[$i];
}
}
return $Result;

}

 
 
 
 

public function MainCat($table,$type){
$rows=$this->FetchAll($table," where `cat`='0' and `type`='$type' ");
 
$html="<select   class='text_field' style='width:200px' size='10' name='cat' >";
$html.="<option value='0'>قسم رئيسي</option>";
foreach($rows as $row){
$html.="<option value='$row[ID]'>$row[name]</option>";
$html.=$this->SubCat($table,$type,$row['ID']);

}
 
$html.="</select>";
return $html;
}



//***********************************
public function SubCat($table,$type,$ID){
$rows2=$this->FetchAll($table," where `cat`='$ID' and `type`='$type' ");
if(is_array($rows2)){
//$html="";
foreach($rows2 as $row2){
$html.="<option value='$row2[ID]' dir='rtl'>";
for($i=0;$i<$row2['level'];$i++){
$html.="--- &nbsp;";
}
$html.="$row2[name]</option>";
}
$html.=$this->SubCat($table,$type,$row2['ID']);

}
return $html;


}
 
 
 
 
 public function MainCatEdit($table,$type,$catselect=0){


$rows=$this->FetchAll($table," where `cat`='0' and `type`='$type' ");
 
$html="<select   class='text_field' style=\"width:200px\"  name=\"cat\" >";
foreach($rows as $row){
$lens=$this->rowCount($table," where `cat`='$row[ID]' and `type` ='$type' ");
if($lens!=0){
$html.="<optgroup title=\"لا يمكن الاضافة بهذا القسم\" label=\"$row[name]\" class=\"blocks_red\"></optgroup>";
} 
else {
if($row["ID"]==$catselect){
$html.="<option selected='selected' value=\"$row[ID]\">$row[name]</option>";
} else {
$html.="<option  value=\"$row[ID]\">$row[name]</option>";
}
}
 $html.=$this->SubCatEdit($table,$type,$row['ID'],$catselect);
}

$html.="</select>";
return $html;
}
//***********************************
public function SubCatEdit($table,$type,$ID,$catselect){
$rows2=$this->FetchAll($table," where `cat`='$ID' and `type`='$type' ");


foreach($rows2 as $row2){
$lens=$this->rowCount($table," where `cat`='$row2[ID]' and `type`='$type' ");
 if($lens!=0){
for($i=0;$i < $row2['level'];$i++){
$bar.="--- &nbsp;";
}
$html.="<optgroup title='لا يمكن الاضافة بهذا القسم' label='$row2[name] $bar' class='blocks_red' ></optgroup>";
} 
else {
if($row2["ID"]==$catselect){
$html.="<option  selected='selected'  value='$row2[ID]' dir='rtl'>";
} else {
$html.="<option value='$row2[ID]' dir='rtl'>";

}



for($i=0;$i < $row2['level'];$i++){
$html.="--- &nbsp;";
}
$html.="$row2[name]</option>";



}
$html.=$this->SubCatEdit($table,$type,$row2['ID'],$catselect);

}

return $html;


}
 
 
 
 //////////////////////////
 
 public function Db_Expr($expression){
 
 return (string) $expression;
 
 }
 
 
       /**
      *Mysql::showFile() -Show file by type
      *@param target string  target dir
	  *@param typefile  string    {*.jpeg,*.jpeg,*.png,*.gif}
      *@return array
      */	
 
public function showFile($target,$typefile){
  foreach(glob("../public/files/$target/$typefile",GLOB_BRACE) as $filename){
 $files[]=basename($filename);
 }
  return  $files;
 }
 
 
 public function __showFile($target,$typefile){
 
 foreach(glob("../../public/files/$target/$typefile",GLOB_BRACE) as $filename){
 $files[]=basename($filename);
 }
  return  $files;
 }
 
 
 
 /////Custome Method
 
 
    public function check_email ($email)
    {
        if (mb_ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $email))
        return true;
        else
        return false;
    }
	
	
	////////////////
	
	 public  function check_name($name)
    {
	if (is_numeric($name[0]) || preg_match('/[^-_.ءاأإآئؤبتثجحخدذرزسشصضطظعغفقكلمنهويةA-Za-z0-9]+/si', $name))
        return true;
        else
        return false;
    }
	
 
 
 
    public function check_num($num)
    {
        if (is_numeric ($num))
        return true;
        else
        return false;

    }
    
////////////////////////////////	
	
  public   function check_str($str)
    {
        if (mb_eregi ('[a-z_]',$str))
        return true;
        else
        return false;

    }
 
 
 
 



public function me(){
	echo "im test......";
	
	}









}



?>
