<?php
/* --------------------------------------------------------------------------------------- #PATH */
//$_cfg_domain = "192.168.111.25/telesongkhla";
$_cfg_domain = "202.129.59.96";
$_cfg_root = "http://".$_cfg_domain."/web/v6/";

$_cfg_ws_ip = "ws://".$_cfg_domain.":8200";

$_cfg_path = array
(
	"class"			=> $_cfg_path_root."package/class/",
	"css"				=> $_cfg_path_root."package/css/",
	"script"			=> $_cfg_path_root."package/script/",
	"page"			=> $_cfg_path_root."package/template/",
	"sys"				=> $_cfg_path_root."package/module/",
	"data"			=> $_cfg_path_root."data/",
	"img"				=> $_cfg_path_root."data/img/",
	"temp"			=> $_cfg_path_root."data/temp/",
	"download"		=> $_cfg_path_root."data/download/"
);

$_cfg_today = date('Y-m-d H:')."00";
$_cfg_day = date('Y-m-d');
$_cfg_time = date('H').":00";
$_d = explode('-', str_replace(' ', '-', $_cfg_today));
//$_t = explode(':', $_d[3]);
$_now = $_cfg_path['temp'].$_d[0]."/".(int)$_d[1]."/".(int)$_d[2]."/";
$_fixed = $_cfg_path['temp'];
//$_cfg_path_today = ( is_dir($_now) && count(scandir($_now)) > 2 ) ? $_now : $_fixed;
//$_cfg_path_root = "";
$dir1 = $_cfg_path['temp'];
$dir2 = $dir1.scan_auto($dir1)."/";
$dir3 = $dir2.scan_auto($dir2)."/";
$dir4 = $dir3.scan_auto($dir3)."/";
$_cfg_path_today = $dir4;
$_cfg_path_root = "";

function scan_auto($dir)
{
	if (is_dir($dir))
	{
  		if ($dh=opendir($dir))
		{
			$r = array();
    		while (($file = readdir($dh)) !== false)
			{
				if (is_numeric($file))
				{
     	 			array_push($r, $file);
				}
    		}
    		closedir($dh);
			return max($r);	
  		}
	}

	return false;
}


/* ------------------------------------------------------------------------------------ #CONNECT */
$_cfg_conn = array
(
	'host'		=> '192.168.191.232',
	'user'		=> 'sa',
	'pass'		=> 'ata+ee&c',
	'db'		=> 'DWR_SongKhla',
	'sql'		=> 'odbc'
);
$_cfg_tb = array
(
	'stn'				=> "[".$_cfg_conn['db']."].[dbo].[Stnname]",
	'daily'				=> "[".$_cfg_conn['db']."].[dbo].[val]",
	'dailytime'		=> "[".$_cfg_conn['db']."].[dbo].[valtime]",
	'backup'			=> "[".$_cfg_conn['db']."].[dbo].[DATA_Backup]",
	'q'					=> "[".$_cfg_conn['db']."].[dbo].[WL2Q]",
	'user'				=> "[".$_cfg_conn['db']."].[dbo].[TBuser]",
	'door'				=> "[".$_cfg_conn['db']."].[dbo].[control]",
	'door_details'	=> "[".$_cfg_conn['db']."].[dbo].[control_log]"
);
$_cfg_cctv = array
(
	'ip'			=> $_cfg_domain,
	'user'		=> 'ftp_cctv',
	'pass'		=> 'dwrwoc',
	'path'		=> '/cctv'
);
$_cfg_map = "7.2 100.3 9";
$_cfg_spot = "http://192.168.103.13/SpotlightService/Switch/";


global $_cfg_conn;

function connDB( $sql = null )
{
	global $_cfg_conn;

	$mode = ( empty($sql) ) ? $_cfg_conn['sql'] : $sql;

	if ( $mode == "odbc" )
	{
		$hosting = "Driver={SQL Server}; Server=$_cfg_conn[host]; Database=$_cfg_conn[db]";
		$conn = odbc_connect($hosting, $_cfg_conn['user'], $_cfg_conn['pass']);
	}
	else if ( $mode == "ms" )
	{
		$conn = mssql_connect($_cfg_conn['host'], $_cfg_conn['user'], $_cfg_conn['pass']);
	}
	else
	{
		$conn = false;
	}

	return $conn;
}


/* ------------------------------------------------------------------------------------ #CONTENT */
$_cfg_name = "ทะเลสาบสงขลา";

$_cfg_key = "โครงการโทรมาตร, โทรมาตร, ลุ่มน้ำ".$_cfg_name.", ".$_cfg_name.", สถานการณ์น้ำ";

$_cfg_desc = "โครงการตรวจวัดสภาพน้ำทางไกลอัตโนมัติลุ่มน้ำ".$_cfg_name;

$_cfg_title = "ลุ่มน้ำ".$_cfg_name." | ระบบโทรมาตร";

$_cfg_footer = "อาคารกรมทรัพยากรน้ำ (ชั้น 11) เลขที่ 180/3 ถนนพระรามที่ 6 ซอย 34 สามเสนใน พญาไท กรุงเทพฯ 10400";
//$_cfg_footer .= "<BR><font color=red>* ระบบอยู่ในช่วงทดสอบและปรับแต่ง ข้อมูลยังไม่สามารถนำไปใช้ในการอ้างอิงได้</font>";

$_cfg_report_head = "ข้อมูลการตรวจวัดจากระบบโทรมาตร";

$_cfg_txt_load = "Loading...";
$_cfg_txt_error = "<BR>---- ไม่พบข้อมูล ----";

$_cfg_form_success = "<BR>บันทึกข้อมูลเรียบร้อยค่ะ, กำลังเปลี่ยนหน้า...";
$_cfg_form_error = "<BR>ไม่สามารถบันทึกข้อมูลได้, กำลังเปลี่ยนหน้า...";


/* ------------------------------------------------------------------- #MENU */
$_cfg_menu_path_1 = "./?page=";
$_cfg_menu_path_2 = "&view=";
$_cfg_menu_main = array
(
	'map' => array
	(
		'name'		=> "หน้าหลัก",
		'title'			=> "หน้าหลัก",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-home",
		'link'			=> $_cfg_menu_path_1."map",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'station' => array
	(
		'name'		=> "สถานีโทรมาตร",
		'title'			=> "สถานีโทรมาตร",
		'expand'		=> false,
		'function'		=> "null",
		'glyphicon'  => "glyphicon glyphicon-map-marker",
		'link'			=> $_cfg_menu_path_1."station&id=STN01",
		'jump'			=> array('class'=>"null", 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'about' => array
	(
		'name'		=> "ข้อมูลโครงการ",
		'title'			=> "ข้อมูลโครงการ",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-info-sign",
		//'link'			=> "javascript:expand('about')",
		'link'			=> $_cfg_menu_path_1."about&view=project",
		'jump'			=> array('class'=>"null", 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'report' => array
	(
		'name'		=> "รายงานสรุป",
		'title'			=> "รายงานสรุป",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-file",
		'link'			=> $_cfg_menu_path_1."report".$_cfg_menu_path_2."now",
		'jump'			=> array('class'=>"new", 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'cctv' => array
	(
		'name'		=> 'กล้อง CCTV',
		'title'			=> 'ภาพจากกล้อง CCTV',
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-facetime-video",
		'link'			=> $_cfg_menu_path_1."cctv",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'service' => array
	(
		'name'		=> 'Web Service',
		'title'			=> 'Web Service',
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-link",
		'link'			=> $_cfg_menu_path_1."service",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>true)
	),
	'admin' => array
	(
		'name'		=> "สำหรับเจ้าหน้าที่",
		'title'			=> "สำหรับเจ้าหน้าที่",
		'expand'		=> true,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-list-alt",
		'link'			=> $_cfg_menu_path_1."admin",
		'jump'			=> array('class'=>"expand", 'target'=>null),
		'display'		=> array('default'=>false, 'admin'=>true)
	),
	'logout' => array
	(
		'name'		=> "ออกจากระบบ",
		'title'			=> "ออกจากระบบ",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-list-alt",
		'link'			=> $_cfg_menu_path_1."login&sign=out",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>false, 'admin'=>true)
	),
	'login' => array
	(
		'name'		=> "เข้าสู่ระบบ",
		'title'			=> "เข้าสู่ระบบ",
		'expand'		=> false,
		'function'		=> null,
		'glyphicon'  =>"glyphicon glyphicon-user",
		'link'			=> $_cfg_menu_path_1."login",
		'jump'			=> array('class'=>null, 'target'=>null),
		'display'		=> array('default'=>true, 'admin'=>false)
	)
);

$_cfg_menu_sub = array
(
	'about' => array
	(
		'project' => array
		(
			'name'	=> 'ความเป็นมาของโครงการ',
			'title'		=> 'ความเป็นมาของโครงการ',
			'link'		=> $_cfg_menu_path_1."about".$_cfg_menu_path_2."project",
			'jump'		=> array('class'=>null, 'target'=>null)
		),
		'station' => array
		(
			'name'	=> 'รายละเอียดสถานีโทรมาตร',
			'title'		=> 'รายละเอียดสถานีโทรมาตร',
			'link'		=> $_cfg_menu_path_1."about".$_cfg_menu_path_2."station",
			'jump'		=> array('class'=>null, 'target'=>null)
		)
	),
	'report' => array
	(
		'now' => array
		(
			'name'	=> 'รายงานสรุปข้อมูลปัจจุบัน',
			'title'		=> 'รายงานสรุปข้อมูลปัจจุบัน',
			'link'		=> $_cfg_menu_path_1."report".$_cfg_menu_path_2."now",
			'jump'		=> array('class'=>null, 'target'=>null)
		),

	),
	'panel' => array
	(
		'station' => array
		(
			'name'	=> 'แก้ไขข้อมูลสถานี',
			'title'		=> 'ข้อมูลสถานีโทรมาตร',
			'link'		=> $_cfg_menu_path_1."panel".$_cfg_menu_path_2."station",
			'jump'		=> array('class'=>null, 'target'=>null)
		),
		'alarm' => array
		(
			'name'	=> 'แก้ไขค่าระดับเตือนภัย',
			'title'		=> 'ตั้งค่าระดับเตือนภัยลุ่มน้ำ',
			'link'		=> $_cfg_menu_path_1."panel".$_cfg_menu_path_2."alarm",
			'jump'		=> array('class'=>null, 'target'=>null)
		),
		'door' => array
		(
			'name'	=> 'ข้อมูลระยะยกบาน',
			'title'		=> 'การเก็บบันทึกข้อมูลระยะยกบาน (ปตร./ ทรบ.)',
			'link'		=> $_cfg_menu_path_1."panel".$_cfg_menu_path_2."door",
			'jump'		=> array('class'=>null, 'target'=>null)
		),
		'spot' => array
		(
			'name'	=> 'ตั้งค่าอุปกรณ์',
			'title'		=> 'การตั้งค่าอุปกรณ์',
			'link'		=> $_cfg_menu_path_1."panel".$_cfg_menu_path_2."spot",
			'jump'		=> array('class'=>null, 'target'=>null)
		)
	)
);


/* ---------------------------------------------------------------- DATATYPE */
$_cfg_data_type = array
(
	'rf' => array("ฝนวันนี้", "มม."),
	'wl' => array("ระดับน้ำ", "ม.รทก.","ระดับน้ำย้อนหลัง"),
	'fl' => array("อัตราการไหล", "ลบ.ม./วินาที"),
	'ca' => array("ความจุลำน้ำ", "%"),
	'rf24'=>array("ฝน24ชม.", "มม.")
	);


/* ------------------------------------------------------------------ #LABEL */
$_cfg_label = array
(
	"stn"				=> "สถานี",
	"date"			=> "วันที่",
	"time"			=> "ช่วงเวลา",
	"type"			=> "ประเภท",
	"data"			=> "ข้อมูล",
	"format"			=> "รูปแบบ",
	"download"		=> "ดาวโหลด"
);


/* ----------------------------------------------------------------- #BUTTON */
$_cfg_btn = array
(
	"login"		=> "Sing In",
	"search"		=> "ค้นหา",
	"graph"		=> "แสดงกราฟ",
	"table"		=> "แสดงตาราง",
	"excel"		=> "Excel",
	"pdf"			=> "PDF"
);


/* ----------------------------------------------------------------- #SELECT */
$_cfg_select = array
(
	"time" => array
	(
		array(600, "เช้ามืด, 0:00-5:59 น.", ""),
		array(1900, "กลางวัน, 6:00-18:59 น.", "SELECTED"),
		array(2400, "กลางคืน, 19:00-23:59 น.", "")
	),
	"report" => array
	(
		array("f_15", "ราย 15 นาที", ""),
		array("f_hr", "รายชั่วโมง", ""),
		array("f_mean", "รายวัน-เฉลี่ย", ""),
		array("f_min", "รายวัน-ต่ำสุด", ""),
		array("f_max", "รายวัน-สูงสุด", "")
	)
);


/* ---------------------------------------------------------------- #STATION */
$_cfg_station = array
(
	'MS' => array
	(
		'name'		=> 'สถานีหลัก กรมทรัพยากรน้ำ (ชั้น 11)',
		'address'		=> 'ศูนย์ควบคุมระบบโทรมาตร ชั้น 11 ',
		'utm'			=> '663,840E 1,524,614N',
		'tool'			=> 'เครื่องแม่ข่าย 4 ชุด (SCADA Server, Flood Forecast Sever, Database Sever, Internet/Web Sever) เครื่องเวิร์คสเตชั่น 3 ชุด (SCADA View, FLOOD FORECAST View, Internet Sever) และอุปกรณ์บริวาร',
		'adsl'			=> 'ควบคุมการทำงานของสถานีโทรมาตรสนามและรับข้อมูลตรวจวัดจากสถานีโทรมาตรสนามผ่าน GPRS สำหรับเชื่อมโยงกับสถานีหลักย่อยใช้ ADSL Modem'
	)
	//,
//	'SMS1' => array
//	(
//		'name'		=> 'สถานีหลักย่อย ศูนย์อุทกวิทยาและบริหารน้ำภาคใต้ จ.พัทลุง',
//		'address'		=> 'ศูนย์อุทกวิทยาและบริหารน้ำภาคใต้ โครงการชลประทานพัทลุง ถนนราเมศวร์ ต.คูหาสวรรค์ อ.เมือง จ.พัทลุง',
//		'utm'			=> '617,330E 841,076N',
//		'tool'			=> "เครื่องเวิร์คสเตชั่น 1 ชุด (SCADA View)",
//		'adsl'			=> "เชื่อมโยงกับสถานีหลัก ใช้ ADSL Modem"
//	),
//	'SMS2' => array
//	(
//		'name'		=> 'สถานีหลักย่อย สำนักชลประทานที่ 17',
//		'address'		=> 'ศูนย์ประมวลวิเคราะห์สถานการณ์น้ำ โครงการชลประทานนราธิวาส เลขที่ 3/1 หมู่ที่ 3 ตำบลกะลุวอเหนือ อำเภอเมือง จังหวัดนราธิวาส ',
//		'utm'			=> "6°24'36.2\"N 101°50'05.4\"E",
//		'tool'			=> "เครื่องเวิร์คสเตชั่น 1 ชุด (SCADA View) และอุปกรณ์บริวาร",
//		'adsl'			=> "เชื่อมโยงกับสถานีหลัก ใช้ ADSL Modem"
//	),
//	'SMS3' => array
//	(
//		'name'		=> "สถานีหลักย่อย เขื่อนปัตตานี",
//		'address'		=> "ศูนย์อุทกวิทยาและบริหารน้ำภาคใต้ โครงการชลประทานปัตตานี 198 หมู่ 4 ต.บางเขา อ.หนองจิก จ.ปัตตานี",
//		'utm'			=> "6.677256 101.286747",
//		'tool'			=> "เครื่องเวิร์คสเตชั่น 1 ชุด (SCADA View)",
//		'adsl'			=> "เชื่อมโยงกับสถานีหลัก ใช้ ADSL Modem"
//	),
//	'SMS4' => array
//	(
//		'name'		=> "สถานีหลักย่อย ยะลา",
//		'address'		=> "ศูนย์อุทกวิทยาและบริหารน้ำภาคใต้ โครงการชลประทานยะลา เลขที่ 38 ถนนสิโรรส ต.สะเตง อ.เมือง จ.ยะลา",
//		'utm'			=> "6.536885, 101.261502",
//		'tool'			=> "เครื่องเวิร์คสเตชั่น 1 ชุด (SCADA View)",
//		'adsl'			=> "เชื่อมโยงกับสถานีหลัก ใช้ ADSL Modem"
//	),

);


/* ------------------------------------------------------------------ #ABOUT */
$_cfg_about = array
(
	array
	(
		'title'			=>	'ที่มาของโครงการ',
		'content'		=>	array
								(
									"ระบบตรวจวัดสภาพน้ำทางไกลอัตโนมัติ เป็นเครื่องมือที่ใช้เพื่อการบริหารจัดการทรัพยากรน้ำที่มีประสิทธิภาพ โดยระบบฯ จะตรวจวัดข้อมูลด้านอุตุ-อุทกวิทยา คือ ข้อมูลปริมาณน้ำฝน ระดับน้ำ และคุณภาพน้ำที่ใช้ในการติดตามสถานการณ์น้ำแบบอัตโนมัติตามช่วงเวลาที่กำหนด (Time Mode System) และ/หรือ ตามสถานะที่กำหนด (Event Mode System) พร้อมทั้งจัดเก็บข้อมูลลงในระบบฐานข้อมูลที่จัดเตรียมไว้ (Real Time Data Collection) ทันที เพื่อให้สามารถนำข้อมูลมาวิเคราะห์และคาดการณ์สถานการณ์น้ำได้อย่างทันท่วงที",
									
									"สำหรับลุ่มน้ำทะเลสาบสงขลา กรมทรัพยากรน้ำ ได้ดำเนินการติดตั้งระบบตรวจวัดสภาพน้ำทางไกลอัตโนมัติ (ระบบโทรมาตร) จำนวน 11 สถานีสนาม ตั้งแต่ปีงบประมาณ พ.ศ. 2553 ซึ่งระบบฯ ผ่านการใช้งานอย่างต่อเนื่องมาหลายปี ทำให้อุปกรณ์ทางอิเล็กทรอนิกส์ที่มีอายุการใช้งานจำกัด เริ่มหมดอายุใช้งาน ดังนั้น เพื่อให้ระบบตรวจวัดสภาพน้ำทางไกลอัตโนมัติของแม่น้ำทะเลสาบสงขลา ทั้ง 11 สถานีสนาม ตลอดจนสถานีหลัก สามารถตรวจวัด รับส่ง และวิเคราะห์ประมวลผลข้อมูลปริมาณน้ำฝน ระดับน้ำ คุณภาพน้ำ เพื่อคาดการณ์พยากรณ์สถานการณ์น้ำได้อย่างถูกต้องและรวดเร็ว กรมทรัพยากรน้ำ จึงมีความประสงค์ว่าจ้างดำเนินงานซ่อมปรับปรุงระบบตรวจวัดสภาพน้ำทางไกลอัตโนมัติ ในพื้นที่ลุ่มน้ำทะเลสาบสงขลา",
									"โดยการซ่อมปรับปรุงระบบตรวจวัดสภาพน้ำทางไกลอัตโนมัติ ในพื้นที่ลุ่มน้ำทะเลสาบสงขลา จะดำเนินงานใน 2 องค์ประกอบหลักของระบบ ดังนี้"

								),
		'list'			=>	array
								(
									'1) สถานีหลัก เป็นส่วนที่ติดตั้ง Hardware และ Software ของระบบควบคุมทางไกล (Scada) ระบบฐานข้อมูล ระบบ Website และส่วนประกอบอื่นๆ',

									'2) สถานีสนาม จำนวน 11 สถานี เป็นส่วนที่ติดตั้งเครื่องมือตรวจวัด อุปกรณ์ส่งข้อมูล และอุปกรณ์ที่เกี่ยวข้อง'
																	),
		'file'			=>	null,
		'img'			=>	'pic_about_1.jpg'
	),
	array
	(
		'title'			=>	'วัตถุประสงค์',
		'content'		=>	array
								(
									'กรมทรัพยากรน้ำ มีแผนดำเนินงานซ่อมปรับปรุงระบบตรวจวัดสภาพน้ำทางไกลอัตโนมัติ ในพื้นที่ลุ่มน้ำทะเลสาบสงขลา เพื่อให้ระบบโทรมาตรทะเลสาบสงขลา มีความพร้อมใช้งานได้อย่างมีประสิทธิภาพตลอดเวลา โดยมีวัตถุประสงค์หลักในการดำเนินโครงการ ดังนี้'
								),
		'list'			=>	array
								(
									'2.1 เพื่อซ่อมแซมหรือเปลี่ยนทดแทนอุปกรณ์ที่ชำรุดในสถานีสนาม ตลอดจนปรับแต่งพร้อมสอบเทียบอุปกรณ์ให้สามารถตรวจวัดข้อมูลได้ถูกต้อง สมบูรณ์ และได้มาตรฐานของการใช้งาน',

									'2.2 เพื่อซ่อมปรับปรุงระบบรับส่งข้อมูล ระบบฐานข้อมูล และระบบ website ให้ทันสมัยและสามารถใช้งานได้อย่างมีประสิทธิภาพ',
									'2.3 เพื่อซ่อมแซมหรือเปลี่ยนทดแทนอุปกรณ์ที่ชำรุดของระบบ hardware และ software ในเครื่อง server ของระบบตรวจวัดสภาพน้ำทางไกลอัตโนมัติ ลุ่มน้ำทะเลสาบสงขลา',
								
									'2.4 เพื่อเพิ่มทักษะและประสิทธิภาพในการดำเนินงานของเจ้าหน้าที่ในการใช้งานและดูแลบำรุงรักษาระบบโทรมาตรฯ'
								),
		'file'			=>	null,
		'img'			=>	'pic_about_2.jpg'
	),
	//array
	//(
	//	'title'			=>	'องค์ประกอบหลักของระบบ',
//	'content'		=>	array
//								(
//									'ใน ปี 2555 กรมชลประทานได้ดำเนินการเชื่อมโยงข้อมูล ระบบโทรมาตรของโครงการโทรมาตรลุ่มน้ำ'.$_cfg_name.' ให้จัดเก็บและแสดงผลแบบเวลาจริง พร้อมทั้งจัดหาโปรแกรม และพัฒนาระบบพยากรณ์และระบบ Website ขึ้นใหม่ โดยปฏิบัติการ ณ ศูนย์โทรมาตร กรมชลประทาน สามเสน กรุงเทพฯ ระบบโทรมาตรลุ่มน้ำ'.$_cfg_name.' มี 3 ส่วนหลัก ได้แก่ สถานีศูนย์ควบคุมหลัก สถานีหลักย่อย และสถานีสนาม'
//								),
//		'list'			=>	array
//								(
//									'สถานีศูนย์ควบคุมหลัก (Master Station) ซึ่งเป็นที่ตั้งของห้องควบคุมระบบโทรมาตร (Control Room) ตั้งอยู่ที่กรมชลประทาน สามเสน',
//
//									'สถานีหลักย่อย (Sub-Master Station) ทำหน้าที่ติดตามและเฝ้าระวัง จำนวน 4 แห่ง ได้แก่
//									<br>- '.$_cfg_station['SMS1']['name'].'
//									<br>- '.$_cfg_station['SMS2']['name'].'
//									<br>- '.$_cfg_station['SMS3']['name'].'
//									<br>- '.$_cfg_station['SMS4']['name'].'',
//
//									'สถานีสนาม (Remote Station) จำนวน 26 สถานี ประกอบด้วย
//									<br>- สถานีวัดปริมาณน้ำฝนอย่างเดียว 7 สถานี
//									<br>- สถานีวัดระดับน้ำอย่างเดียว 5 สถานี
//									<br>- สถานีวัดปริมาณน้ำฝนและวัดระดับน้ำ 14 สถานี'
//								),
//		'file'			=>	null,
//		'img'			=>	'pic_about_3.jpg'
//	),
	array
	(
		'title'			=>	'รายชื่อสถานีโทรมาตร',
		'content'		=>	null,
		'list'			=>	null,
		'file'			=>	'table.php',
		'img'			=>	null
		//'img'			=>	'pic_map.jpg'
	)
);


/* ------------------------------------------------------------------ #LOGIN */
$_cfg_sign_form = array
(
	"id"		=> "ID",
	"pass"	=> "Password",
	"verify"	=> "Verify"
);
$_cfg_sign_ms = array
(
	"yes" => array
	(
		"ms" => "Logging in, Please wait.",
		"style" => "process fs_big fc_pri"
	),
	"no" => array
	(
		"ms" => "Username or Password incorrect, Please try again.",
		"style" => "process fs_big fc_danger"
	),
	"verify" => array
	(
		"ms" => "Verify incorrect.",
		"style" => "process fs_big fc_danger"
	)
);


/* ---------------------------------------------------------------------------------------- #XML */
$_cfg_xml = array
(
	array("https://www.tmd.go.th/xml/weather_report.php?StationNumber=48568", 1),
	array("https://www.tmd.go.th/xml/weather_report.php?StationNumber=48560", 0),
	array("https://www.tmd.go.th/xml/region_daily_forecast.php?RegionID=5", 1),
	//array("http://www.tmd.go.th/xml/region_daily_forecast.php?RegionID=6", 0),
	array("https://www.tmd.go.th/xml/warning.php", 1)
);


/* --------------------------------------------------------------------------------------- #LINK */
$_cfg_link = array
(
	array
	(
		'name' => 'กรมทรัพยากรน้ำ',
		'link' => 'http://www.dwr.go.th'
	),
//	array
//	(
//		'name' => 'HAM',
//		'link' => 'http://wx.hamweather.com/?country=th&state=&place=trang&from=wxdir'
//	),
//	array
//	(
//		'name' => 'WATER',
//		'link' => 'http://water.rid.go.th'
//	),
	array
	(
		'name' => 'ศูนย์เมขลา',
		'link' => 'http://mekhala.dwr.go.th/main/'
	),
//	array
//	(
//		'name' => 'RI17',
//		'link' => 'http://irrigation.rid.go.th/rid17'
//	),
//	array
//	(
//		'name' => 'patani',
//		'link' => 'http://ridceo.rid.go.th/patani'
//	)
);


/* -------------------------------------------------------------------------------------- #BLOCK */
$_cfg_flow = array
(
	'Tpat.1',
	'Tpat.2',
	'Tpat.3',
	'Tpat.6',
	'Tpat.11',
	'Tpat.12',
	'Tpat.14'
);
$_cfg_block_cctv = array
(
	'Tpat.9'
	//'Tpat.12'
);
?>