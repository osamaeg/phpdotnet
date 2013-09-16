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

	
	
	
	}



?>
