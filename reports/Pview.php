<?
ini_set('max_execution_time',60); // 60 seconds for max execution time
$view = $_REQUEST['view'];
$site_id = $_REQUEST['site_id'];
$type = $_REQUEST['type'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$dtmm1=date('Y-m',strtotime($date1));
$dtmm2=date('Y-m',strtotime($date2));
$dtyy=date('Y',strtotime($date1));
$sta = explode("-", $site_id);
$ssite=$sta[0];	

$status_rf=c_rf($ssite);
$status_wl=c_wl($ssite);

$tdt = explode("-",$date1);
if($tdt[1]=='02' AND $tdt[2]>28)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}
if($tdt[1]=='04' AND $tdt[2]>30)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}
if($tdt[1]=='06' AND $tdt[2]>30)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}
if($tdt[1]=='09' AND $tdt[2]>30)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}
if($tdt[1]=='11' AND $tdt[2]>30)
{
	$info = cal_days_in_month( CAL_GREGORIAN , $tdt[1] , $tdt[0] ) ;
	$date2=$tdt[0]."-".$tdt[1]."-".$info;
}


?>
<div id="content">
<a href="./?view=table&site_id=<?=$site_id?>&type=<?=$type?>&date1=<?=$date1?>&date2=<?=$date2?>&search=search" class="btn">ตารางข้อมูล</a>
<? if($ssite=="Tpat.1")
	{}
else{
?>
<!-- <a href="./?view=RF&site_id=<?=$site_id?>&type=<?=$type?>&date1=<?=$date1?>&date2=<?=$date2?>&search=search" class="btn" >กราฟน้ำฝน</a>
 --><?
}?>
<!-- /////////////////////WL////////////////////////// -->
<? if($ssite=="STN11")
	{}
else{
?>
<!-- <a href="./?view=WL&site_id=<?=$site_id?>&type=<?=$type?>&date1=<?=$date1?>&date2=<?=$date2?>&search=search" class="btn">กราฟระดับน้ำ</a>
 --><?
}?>


<a href="exportexcel.php?view=export&site_id=<?=$site_id?>&type=<?=$type?>&date1=<?=$date1?>&date2=<?=$date2?>&search=search" class="btn">Excel Download</a>
</div>
<?   
	$namedt1=setdatetime(date($date1),"DD/MM/YYYY");
	$namedt2=setdatetime(date($date2),"DD/MM/YYYY");

	function dmonth($ddlM)
	{
				if($ddlM=="01" or $ddlM=="1")	{	    $mm="มกราคม";}
				elseif($ddlM=="02" or $ddlM=="2")	{	$mm="กุมภาพันธ์ ";}
				elseif($ddlM=="03" or $ddlM=="3")	{	$mm="มีนาคม ";}
				elseif($ddlM=="04" or $ddlM=="4")	{	$mm="เมษายน ";}
				elseif($ddlM=="05" or $ddlM=="5")	{	$mm="พฤษภาคม ";}
				elseif($ddlM=="06" or $ddlM=="6")	{	$mm="มิถุนายน ";}
				elseif($ddlM=="07" or $ddlM=="7")	{	$mm="กรกฎาคม ";}
				elseif($ddlM=="08" or $ddlM=="8")	{	$mm="สิงหาคม ";}
				elseif($ddlM=="09" or $ddlM=="9")	{	$mm="กันยายน ";}
				elseif($ddlM=="10")	{	$mm="ตุลาคม ";}
				elseif($ddlM=="11")	{	$mm="พฤศจิกายน ";}
				else{	$mm=" ธันวาคม";}
		return $mm;
	}

	function dyear($ddly)
	{
				if($ddly=="2012"){$yy="2555";}
				elseif($ddly=="2013"){$yy="2556 ";}
				elseif($ddly=="2014"){$yy="2557 ";}
				elseif($ddly=="2015"){$yy="2558 ";}
				elseif($ddly=="2016"){$yy="2559 ";}
				elseif($ddly=="2017"){$yy="2560 ";}
				else{$ddly=" 2561";}		
				return $yy;
	}
 
	if($type=="DS")
	{
		$ddate="select top 1 datepart(DD,DB.dtm) dday,datepart(MM,DB.dtm) dmm,datepart(YY,DB.dtm) dyy ,convert(varchar(10),DB.dtm,120) dt ,
		datepart(DD,DB1.dtm) dday1,datepart(MM,DB1.dtm) dmm1,datepart(YY,DB1.dtm) dyy1 ,convert(varchar(10),DB1.dtm,120) dt1
		from [DWR_SongKhla].[dbo].[Daily] DB,[DWR_SongKhla].[dbo].[Daily] DB1 where DB.dtm='$date1' and DB1.dtm='$date2' and DB.stn='$ssite'";
	}
	else if($type=="MS")
	{ 
		$ddate="select top 1 datepart(DD,DB.dtm) dday,datepart(MM,DB.dtm) dmm,datepart(YY,DB.dtm) dyy ,convert(varchar(10),DB.dtm,120) dt ,
		datepart(DD,DB1.dtm) dday1,datepart(MM,DB1.dtm) dmm1,datepart(YY,DB1.dtm) dyy1 ,convert(varchar(10),DB1.dtm,120) dt1
		from [DWR_SongKhla].[dbo].[Daily] DB,[DWR_SongKhla].[dbo].[Daily] DB1 where CONVERT(varchar(7),DB.dtm,120)='$dtmm1' and CONVERT(varchar(7),DB1.dtm,120)='$dtmm2'
		 and DB.stn='$ssite' order by DB.dtm";
	}
	else
	{
		$ddate="select top 1 datepart(DD,dtm) dday,datepart(MM,dtm) dmm,datepart(YY,dtm) dyy ,convert(varchar(10),dtm,120) dt
		from [DWR_SongKhla].[dbo].[Daily] DB where CONVERT(varchar(4),DB.dtm,120)='$dtyy' and stn='$ssite' order by dtm";
	}

	$dda = odbc_exec($connection,$ddate);
    $ndd=odbc_fetch_array($dda);
	$sday=$ndd['dday'];
	$smm=$ndd['dmm'];
	$syy=$ndd['dyy'];
	$dt=$ndd['dt'];
	$sday1=$ndd['dday1'];
	$smm1=$ndd['dmm1'];
	$syy1=$ndd['dyy1'];
	$dt1=$ndd['dt1'];
	
	$compare_T=DateDiff($date1,$date2);
	
	$dta = (int)$sday." ".dmonth($smm)." ".dyear($syy);
	$dta1 = (int)$sday1." ".dmonth($smm1)." ".dyear($syy1);
	$ndtm = dmonth($smm)." ".dyear($syy);
	$ndtm1 = dmonth($smm1)." ".dyear($syy1);
	$ndty = dyear($syy);
	$ndty1 = dyear($syy1);

	if($compare_T < 1)
	{
		if($type=="DS")
		{
			$namedateshow="วันที่  $dta";
		}
		elseif($type=="MS")
		{
			$namedateshow="เดือน  $ndtm";
		}
		elseif($type=="YS")
		{
			$namedateshow="ปี  $ndty";
		}
		else{}

	}
	else
	{
		if($type=="DS")
		{
			$namedateshow="ระหว่างวันที่  $dta ถึง $dta1";
		}
		elseif($type=="MS")
		{
			$namedateshow="ระหว่างเดือน  $ndtm ถึง $ndtm1";
		}
		else{}
	}
	
	$ss="SELECT stn,st_name FROM [DWR_SongKhla].[dbo].[stnname] where stn='$ssite'";
    $ress = odbc_exec($connection,$ss);
    $namesta=odbc_fetch_array($ress);
    $stationss=$namesta['stn'];
	$sname=$namesta['stn'];
	$namethai=$namesta['st_name'];
	$Dname=iconv('TIS-620', 'UTF-8', $namethai);

/*--------------------------select data--------------------------------------*/
if($view=="table")
{
	$minrf=array();
	$hourrf=array();
	$wl=array();
	$wle=array();
	$wlavg=array();
	$wlmin=array();
	$wlmax=array();
	$wleavg=array();
	$wlemin=array();
	$wlemax=array();
	$timerf=array();
	$timeavg=array();
	$timemin=array();
	$timemax=array();
	$timeavge=array();
	$timemine=array();
	$timemaxe=array();

	$flow=array();
	$flowavg=array();
	$flowmin=array();
	$flowmax=array();
	$timeavgflow=array();
	$timeminflow=array();
	$timemaxflow=array();

	$velocity=array();
	$velocityavg=array();
	$velocitymin=array();
	$velocitymax=array();
	$timeavgvelocity=array();
	$timeminvelocity=array();
	$timemaxvelocity=array();

	$area=array();
	$areaavg=array();
	$areamin=array();
	$areamax=array();
	$timeavgarea=array();
	$timeminarea=array();
	$timemaxarea=array();

	if($type =="DS" or $type =="DB")
	{
		

	?>
	
				<table CLASS="datatable" align="center" border="1">
				<tr class="tr_head">
					<td rowspan="2">ลำดับ </td>
					<td rowspan="2">ชื่อสถานี </td>
					<td rowspan="2" >วันที่ - เวลา</td>
					<? if ($status_rf==1) { ?><td colspan="1" >ปริมาณน้ำฝน (มม.)</td><?}?>
					<td colspan="1">ระดับน้ำ (เมตร รทก.)</td>
					<!-- <td colspan="3">ปริมาณน้ำ</td> -->
				</tr>
				<tr class="tr_head">
				<? if ($status_rf==1) { ?><td >15 นาที</td><?}?>
				<td >15 นาที</td>
				<!-- <td >อัตราการไหล<br><span> (ลบ.ม./วินาที)</span></td>
				<td >ความเร็ว<br><span> (ม./วินาที)</span></td>
				<td >พื้นที่หน้าตัด<br><span> (ตร.ม./วินาที)</span></td> -->
				</tr>	
				<tbody>
			<?
				if($type =="DS")
				{
						$sss="select distinct CONVERT(varchar(20),dtm,120) AS adate,
						rf ,
						wl
						FROM [DWR_SongKhla].[dbo].[Daily]  WHERE dtm BETWEEN '".$date1." 00:00' AND '".$date2." 23:50' and stn='".$ssite."' 
						order by CONVERT(varchar(20),dtm,120)";
				}
				else{}

				$rs_check =odbc_exec($connection,$sss);
				$checkrow=odbc_num_rows($rs_check);					
				if($checkrow=="0" )
				{
					echo "<p align=\"center\"><font color=\"red\">ไม่พบข้อมูล</font></p>";
				}
				else
				{	$STN_ID1 = 1;
					while($r_check=odbc_fetch_array($rs_check))
					{
						$sqltm="select * from [DWR_SongKhla].[dbo].[Stnname]  WHERE stn='".$ssite."' order by d_id";
						$result = odbc_exec($connection,$sqltm);
						$row = odbc_fetch_array($result);
						$STN_ID = $row["stn"];
						
						$STN_NAME_THAI = iconv('TIS-620', 'UTF-8', $row["st_name"]); 
						
						if ( $r_check['rf'] != "" )
						{
							array_push($minrf,$r_check['rf']);
						}
						if ( $r_check['wl'] != "" )
						{
							array_push($wl,$r_check['wl']);
						}
				
				?>
							<tr >
								<td><?=$STN_ID1?></td>
								<td><?=$STN_NAME_THAI?></td>
								<td><? echo ShortThaiDate($r_check['adate'],1,$STN_ID,"no")?></td>
								<? if ($status_rf==1) { ?><td><?=checkrf($r_check['rf'],$STN_ID,0)?></td><?}?>
								<td><?=checkna($r_check['wl'],$STN_ID,1)?></td>
								
							</tr>
					<?
						$STN_ID1++;
					}	//end while	 

					if (!empty($minrf)) 
					{
						$min15=min($minrf);
						$max15=max($minrf);
						$avgrf= array_sum($minrf)/ count($minrf);
						$totalrf= array_sum($minrf);
					}
					if (!empty($wl)) 
					{
						$minwl=min($wl);
						$maxwl=max($wl);
						$totalwl= array_sum($wl);					
						$avgwl= array_sum($wl) / count($wl);
					}

				}
			?> 
		</tbody>
		<tfoot>
		<tr class="tr_list" bgcolor='#EEEED1'>
			<td colspan="3">MIN</td>
			<? if ($status_rf==1) { ?><td><?=checkrf($min15,$STN_ID,1)?></td><?}?>
			<td><?=checkna($minwl,$STN_ID,1)?></td>
			
		</tr>
		<tr class="tr_list" bgcolor='#EEEED1'>
			<td colspan="3">MAX</td>
			<? if ($status_rf==1) { ?><td><?=checkrf($max15,$STN_ID,1)?></td><?}?>
			<td><?=checkna($maxwl,$STN_ID,1)?></td>
			
		</tr>
		<tr class="tr_list" bgcolor='#EEEED1'>
			<td colspan="3">SUM</td>
			<? if ($status_rf==1) { ?><td><?=checkrf($totalrf,$STN_ID,1)?></td><?}?>
			<td>n/a</td>
			
		
		</tr>
		<tr class="tr_list" bgcolor='#EEEED1'>
			<td colspan="3">Average</td>
			<? if ($status_rf==1) { ?><td>n/a</td><?}?>
			<td><?=checkna($avgwl,$STN_ID,1)?></td>
			
		</tr>
		</tfoot>
		</table>
	<?php
		
	}
	//////////////////////////////month/////////////////////////////////
	else if($type =="MS" or $type =="MB")
	{
		?>
		<div>
		<table align="center" border="1">
				<tr class="tr_head">
					<td rowspan="2">รหัสสถานี </td>
					<td rowspan="2">ชื่อสถานี </td>
					<td rowspan="2" >วันที่ - เวลา</td>
					<td colspan="1" >ปริมาณน้ำฝน (มม.)</td>
					<td colspan="3">ระดับน้ำ เมตร (รทก.)</td>
				</tr>
				<tr class="tr_head">
				<td >น้ำฝนสะสมรายวัน</td>
				<td >เฉลี่ยรายวัน</td>
				<td >ต่ำสุดรายวัน</td>
				<td >สูงสุดรายวัน</td>
				</tr>		
			<tbody>
			<?php
			
				if($type =="MS")
				{
					$sss="select distinct CONVERT(varchar(10),dtm,120) AS adate,
					sum(rf) rf00 ,
					avg(wl) wlavg,
					max(wl) wlmax,
					min(wl) wlmin
					FROM [DWR_SongKhla].[dbo].[Daily]  WHERE CONVERT(varchar(7),dtm,120) BETWEEN '".$dtmm1."' AND '".$dtmm2."' 
					and stn='".$ssite."' 
					group BY CONVERT(varchar(10),dtm,120) 
					order by CONVERT(varchar(10),dtm,120)";
				}
				else
				{
				}
				
				$rs_check =odbc_exec($connection,$sss);
				$row = 1;
				$checkrow=odbc_num_rows($rs_check);
					
				if($checkrow=="0")
				{
					echo "<p align=\"center\"><font color=\"red\">ไม่พบข้อมูล</font></p>";
				}
				else
				{		$STN_ID1 = 1;
					while($r_check=odbc_fetch_array($rs_check))
					{
						$sqltm="select * from [DWR_SongKhla].[dbo].[Stnname]  WHERE stn='".$ssite."' order by d_id";
						$result = odbc_exec($connection,$sqltm);
						$row = odbc_fetch_array($result);
						$STN_ID = $row["stn"];
						
						$STN_NAME_THAI = iconv('TIS-620', 'UTF-8', $row["st_name"]);

						array_push($minrf,$r_check['rf00']);
						array_push($wlavg,$r_check['wlavg']);
						array_push($wlmin,$r_check['wlmin']);
						array_push($wlmax,$r_check['wlmax']);
					
						$timerf[$r_check['adate']]= $r_check['rf00'];
						$timeavg[$r_check['adate']] = $r_check['wlavg'];
						$timemin[$r_check['adate']] = $r_check['wlmin'];
						$timemax[$r_check['adate']] = $r_check['wlmax'];
	
						

				?>
						<tr class="tr_list">
							<td><?=$STN_ID1?></td>
							<td><?=$STN_NAME_THAI?></td>
							<td><? echo ShortThaiDate($r_check['adate'],2,$STN_ID,"no")?></td>
							<td><?=checkrf($r_check['rf00'],$STN_ID,0)?></td>
							<td><?=checkna($r_check['wlavg'],$STN_ID,1)?></td>
							<td><?=checkna($r_check['wlmin'],$STN_ID,1)?></td>
							<td><?=checkna($r_check['wlmax'],$STN_ID,1)?></td>
						</tr>
				<?
						$row++;
						$STN_ID1++;
						}	//end while	
						$dtminrf = array_search(min($timerf),$timerf);
						$dtmaxrf = array_search(max($timerf),$timerf);
						$dtmin_avg = array_search(min($timeavg),$timeavg);
						$dtmax_avg = array_search(max($timeavg),$timeavg);
						$dtmin_min = array_search(min($timemin),$timemin);
						$dtmax_min = array_search(max($timemin),$timemin);
						$dtmin_max = array_search(min($timemax),$timemax);
						$dtmax_max = array_search(max($timemax),$timemax);
						$min15=min($minrf);
						$max15=max($minrf);
						$wlavg_min=min($wlavg);
						$wlavg_max=max($wlavg);
						$wlmin_min=min($wlmin);
						$wlmin_max=max($wlmin);
						$wlmax_min=min($wlmax);
						$wlmax_max=max($wlmax);
						$totalrf= array_sum($minrf);
						$avg_wl= array_sum($wlavg)/ count($wlavg);
						$min_wl= array_sum($wlmin)/ count($wlmin);
						$max_wl= array_sum($wlmax) / count($wlmax);
					}
			?>
			</tbody>
			<tfoot>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">MIN</td>
				<td><?=checkrf($min15,$STN_ID,0)?></td>
				<td><?=checkna($wlavg_min,$STN_ID,1)?></td>
				<td><?=checkna($wlmin_min,$STN_ID,1)?></td>
				<td><?=checkna($wlmax_min,$STN_ID,1)?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">TIME MIN</td>
				<td><? echo ShortThaiDate($dtminrf,2,$STN_ID,"rf")?></td>
				<td><? echo ShortThaiDate($dtmin_avg,2,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmin_min,2,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmin_max,2,$STN_ID,"wl")?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">MAX</td>
				<td><?=checkrf($max15,$STN_ID,0)?></td>
				<td><?=checkna($wlavg_max,$STN_ID,1)?></td>
				<td><?=checkna($wlmin_max,$STN_ID,1)?></td>
				<td><?=checkna($wlmax_max,$STN_ID,1)?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">TIME MAX</td>
				<td><? echo ShortThaiDate($dtmaxrf,2,$STN_ID,"rf")?></td>
				<td><? echo ShortThaiDate($dtmax_avg,2,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmax_min,2,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmax_max,2,$STN_ID,"wl")?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">SUM</td>
				<td><?=checkrf($totalrf,$STN_ID,0)?></td>
				<td>n/a</td>
				<td>n/a</td>
				<td>n/a</td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">Average</td>
				<td>n/a</td>
				<td><?=checkna($avg_wl,$STN_ID,1)?></td>
				<td><?=checkna($min_wl,$STN_ID,1)?></td>
				<td><?=checkna($max_wl,$STN_ID,1)?></td>
			</tr>
		</tfoot>
		</table>
		</div>
		<?php 
	}
	///////////////////////////////year/////////////////////////////////
	else if($type =="YS" )
	{
		
		?>
		<div>
		<table align="center" border="1">
				<tr class="tr_head">
					<td rowspan="2">รหัสสถานี </td>
					<td rowspan="2">ชื่อสถานี </td>
					<td rowspan="2" >วันที่ - เวลา</td>
					<td colspan="1" >ปริมาณน้ำฝน (มม.)</td>
					<td colspan="3">ระดับน้ำ เมตร (รทก.)</td>
				</tr>
				<tr class="tr_head">
				<td >น้ำฝนสะสมรายเดือน</td>
				<td >เฉลี่ยรายเดือน</td>
				<td >ต่ำสุดรายเดือน</td>
				<td >สูงสุดรายเดือน</td>
				</tr>		
			<tbody>
			<?
		
				if($type =="YS")
				{
					$sss="select distinct CONVERT(varchar(7),dtm,120) AS adate,
					sum(rf) rf00 ,
					avg(wl) wlavg,
					max(wl) wlmax,
					min(wl) wlmin
					FROM [DWR_SongKhla].[dbo].[Daily]  WHERE CONVERT(varchar(4),dtm,120) BETWEEN '".$dtyy."' AND '".$dtyy."' 
					and stn='".$ssite."' 
					group BY CONVERT(varchar(7),dtm,120) 
					order by CONVERT(varchar(7),dtm,120)  ";
				}
				
				else
				{
				}
				
				$rs_check =odbc_exec($connection,$sss);
				$row = 1;
				$checkrow=odbc_num_rows($rs_check);
					
				if($checkrow=="0")
				{
					echo "<p align=\"center\"><font color=\"red\">ไม่พบข้อมูล</font></p>";
				}
				else
				{		$STN_ID1 = 1;
					while($r_check=odbc_fetch_array($rs_check))
					{
						$sqltm="select * from [DWR_SongKhla].[dbo].[Stnname]  WHERE stn='".$ssite."' order by d_id";
						$result = odbc_exec($connection,$sqltm);
						$row = odbc_fetch_array($result);
						$STN_ID = $row["stn"];
						
						$STN_NAME_THAI = iconv('TIS-620', 'UTF-8', $row["st_name"]);
						array_push($minrf,$r_check['rf00']);
						array_push($wlavg,$r_check['wlavg']);
						array_push($wlmin,$r_check['wlmin']);
						array_push($wlmax,$r_check['wlmax']);

						$timerf[$r_check['adate']] = $r_check['rf00'];
						$timeavg[$r_check['adate']] = $r_check['wlavg'];
						$timemin[$r_check['adate']] = $r_check['wlmin'];
						$timemax[$r_check['adate']] = $r_check['wlmax'];
				?>
						<tr class="tr_list">
							<td><?=$STN_ID1?></td>
							<td><?=$STN_NAME_THAI?></td>
							<td><? echo ShortThaiDate($r_check['adate'],3,$STN_ID,"no")?></td>
							<td><?=checkrf($r_check['rf00'],$STN_ID,0)?></td>
							<td><?=checkna($r_check['wlavg'],$STN_ID,1)?></td>
							<td><?=checkna($r_check['wlmin'],$STN_ID,1)?></td>
							<td><?=checkna($r_check['wlmax'],$STN_ID,1)?></td>
						</tr>
				<?
						$row++;
						$STN_ID1++;
						}	//end while	
						
						$dtminrf = array_search(min($timerf),$timerf);
						$dtmaxrf = array_search(max($timerf),$timerf);
						$dtmin_avg = array_search(min($timeavg),$timeavg);
						$dtmax_avg = array_search(max($timeavg),$timeavg);
						$dtmin_min = array_search(min($timemin),$timemin);
						$dtmax_min = array_search(max($timemin),$timemin);
						$dtmin_max = array_search(min($timemax),$timemax);
						$dtmax_max = array_search(max($timemax),$timemax);
						$min15=min($minrf);
						$max15=max($minrf);
						$wlavg_min=min($wlavg);
						$wlavg_max=max($wlavg);
						$wlmin_min=min($wlmin);
						$wlmin_max=max($wlmin);
						$wlmax_min=min($wlmax);
						$wlmax_max=max($wlmax);
						$totalrf= array_sum($minrf);
						$avg_wl= array_sum($wlavg)/ count($wlavg);
						$min_wl= array_sum($wlmin)/ count($wlmin);
						$max_wl= array_sum($wlmax) / count($wlmax);
					}
			?>
			</tbody>
			<tfoot>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">MIN</td>
				<td><?=checkrf($min15,$STN_ID,0)?></td>
				<td><?=checkna($wlavg_min,$STN_ID,1)?></td>
				<td><?=checkna($wlmin_min,$STN_ID,1)?></td>
				<td><?=checkna($wlmax_min,$STN_ID,1)?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">TIME MIN</td>
				<td><? echo ShortThaiDate($dtminrf,3,$STN_ID,"rf")?></td>
				<td><? echo ShortThaiDate($dtmin_avg,3,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmin_min,3,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmin_max,3,$STN_ID,"wl")?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">MAX</td>
				<td><?=checkrf($max15,$STN_ID,0)?></td>
				<td><?=checkna($wlavg_max,$STN_ID,1)?></td>
				<td><?=checkna($wlmin_max,$STN_ID,1)?></td>
				<td><?=checkna($wlmax_max,$STN_ID,1)?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">TIME MAX</td>
				<td><? echo ShortThaiDate($dtmaxrf,3,$STN_ID,"rf")?></td>
				<td><? echo ShortThaiDate($dtmax_avg,3,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmax_min,3,$STN_ID,"wl")?></td>
				<td><? echo ShortThaiDate($dtmax_max,3,$STN_ID,"wl")?></td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">SUM</td>
				<td><?=checkrf($totalrf,$STN_ID,0)?></td>
				<td>n/a</td>
				<td>n/a</td>
				<td>n/a</td>
			</tr>
			<tr class="tr_list" bgcolor='#EEEED1'>
				<td colspan="3">Average</td>
				<td>n/a</td>
				<td><?=checkna($avg_wl,$STN_ID,1)?></td>
				<td><?=checkna($min_wl,$STN_ID,1)?></td>
				<td><?=checkna($max_wl,$STN_ID,1)?></td>
			</tr>
		</tfoot>
		</table>
		</div>
		<?
		}
	
}
else if($view=="RF")
	{
		$nametype="กราฟปริมาณน้ำฝน"; 
		$yname="มม.";
		$yaname="ปริมาณน้ำฝน มม.";
		$typess="column";
		$minva=0;
		$maxva=100;
		
		$a=0;
		if($type =="DS")
		{
			$p_date=date("Y-m-d",strtotime($date1));
			$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
			$pointIn= 900 * 1000; // 15 min
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%e. %B %Y %H:%M";
			$minva = $maxva = null;
			$a=15;
			$b=900;
			$strQuery="select DISTINCT CONVERT(varchar(16),dtm,120) adate,rf as avalue 
			FROM [DWR_SongKhla].[dbo].[Daily] WHERE dtm BETWEEN '$date1 00:00' AND '$date2 23:45' and datepart(MINUTE,dtm) % 15 = 0 and stn='$ssite'
			 order by CONVERT(varchar(16),dtm,120) ";
		}
		elseif($type =="MS")
		{
			$p_date=date("Y-m",strtotime($date1));
			$p_date2=date("Y-m",strtotime($date2));
			$maxZ= 24 * 3600000;
			$pointIn= 24 * 3600 * 1000; // 1 day
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%e. %B %Y";
			$minva = $maxva = null;
			$a=60*24;
			$b=86400;
			$strQuery="select DISTINCT CONVERT(varchar(10),dtm,120) adate,sum(rf) avalue 
			FROM [DWR_SongKhla].[dbo].[Daily] WHERE CONVERT(varchar(7),dtm,120) BETWEEN '".$dtmm1."' AND '".$dtmm2."' and datepart(MINUTE,dtm) % 15 = 0 and 
			stn='$ssite'  group BY CONVERT(varchar(10),dtm,120) order by CONVERT(varchar(10),dtm,120) ";
		}
		elseif($type =="YS")
		{
			$p_date=date("Y",strtotime($date1));
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%B %Y";
			$minva = $maxva = null;
			$strQuery="select DISTINCT CONVERT(varchar(7),dtm,120) adate,sum(rf) avalue 
			FROM [DWR_SongKhla].[dbo].[Daily] WHERE CONVERT(varchar(4),dtm,120) BETWEEN '".$dtyy."' AND '".$dtyy."' and datepart(MINUTE,dtm) % 15 = 0 and 
			stn='$ssite' group BY CONVERT(varchar(7),dtm,120) order by CONVERT(varchar(7),dtm,120)";
		}
		else{}


		$result = odbc_exec($connection,$strQuery); 
	  // while ($row_rs_tu01 = odbc_fetch_array($result));	

		$stagearray=array();
		$wt_arr=array();
			
		$stadatey=date("Y",strtotime($date1));
		if($type =="YS")
		{
			$stadatem="01";
		}
		else
		{
			$stadatem=date("m",strtotime($date1));
		}
		if($type =="MS" || $type =="MB" || $type =="YS")
		{
			$stadated="01";
		}
		else
		{
			$stadated=date("d",strtotime($date1));
		}
		$stadateh=date("H",strtotime($date1));
		$stadatei=date("i",strtotime($date1));
		$sm=$stadatey."-".$stadatem;
		
		if($type =="DS" || $type =="DB")
		{
			$stadate=strtotime($date1);
			$enddate=strtotime($date2)+86400;
		}
		elseif($type =="MS" || $type =="MB")
		{
			$date_y=date("Y",strtotime($date1));
			$date_m=date("m",strtotime($date1));
			$info = cal_days_in_month( CAL_GREGORIAN , $date_m , $date_y ) ;
			$stadate=strtotime(date("Y-m",strtotime($date1))."-01");
			$enddate=strtotime(date("Y-m",strtotime($date2))."-".$info."")+86400;
		}
		elseif($type =="YS")
		{
			$stadate=strtotime(date("Y",strtotime($date1))."-01-01");
			$enddate=strtotime(date("Y",strtotime($date1))."-12-31")+86400;
		}
		else{}	

		while($stadate < $enddate)
		{

			if ($row = odbc_fetch_array($result))
			{
				
				if($type =="DS" || $type =="DB" || $type =="MS" || $type =="MB")
				{
					$sname=strtotime($row['adate']);
				}
				elseif($type =="YS")
				{
					$sname=strtotime($row['adate']."-01");
				}
				else{}
				
				while($stadate < $sname)
				{
					array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
					if ($p_format=="0" or $p_format=="1")
					{
						$stadatei+=$a;
						$stadate+=$a*60;
					}
					else
					{
						
						$info = cal_days_in_month( CAL_GREGORIAN , $stadatem , $stadatey ) ;
						$stadate += ($info * 24 * 60 * 60);
						$stadatey=date("Y",$stadate);
						$stadatem=date("m",$stadate);
						$stadated=date("d",$stadate);
						$stadateh=date("H",$stadate);
						$stadatei=date("i",$stadate);
					}
				
				}

				if($row["avalue"]==null){$val="null";}else{$val=$row["avalue"];}
				array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."), ".$val."]");

				if ($type =="DS" || $type =="DB" || $type =="MS" || $type =="MB")
				{
					$stadatei+=$a;
					$stadate+=$a*60;
				}
				else
				{
				
					$info = cal_days_in_month( CAL_GREGORIAN ,$stadatem ,$stadatey ) ;
					$stadate += ($info * 24 * 60 * 60);
					$stadatey=date("Y",$stadate);
					$stadatem=date("m",$stadate);
					$stadated=date("d",$stadate);
					$stadateh=date("H",$stadate);
					$stadatei=date("i",$stadate);
				}
			
			}
			else
			{
				array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
				if ($type =="DS" || $type =="DB" || $type =="MS" || $type =="MB")
					{
						$stadatei+=$a;
						$stadate+=$a*60;
					}
					else
					{
						$info = cal_days_in_month( CAL_GREGORIAN ,$stadatem , $stadatey ) ;
						$stadate += ($info * 24 * 60 * 60);
						$stadatey=date("Y",$stadate);
						$stadatem=date("m",$stadate);
						$stadated=date("d",$stadate);
						$stadateh=date("H",$stadate);
						$stadatei=date("i",$stadate);
					}
				
			}
		}
		$ponts_str=implode(",",$wt_arr);

			?>
			<br>
			<div id="graph" ></div>
			<script type="text/javascript">
			//alert("aa");
			$(function () {
				var chart;
				$(document).ready(function() {
					Highcharts.setOptions({
					lang: {
						months: ['ม.ค.', 'ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']		}
				});
					chart = new Highcharts.Chart({
						chart: {
							zoomType: 'x',
							renderTo: 'graph',
							type: 'column',
							spacingLeft: 25 ,
							resetZoomButton: {
								position: {
								// align: 'right', // by default
								 // verticalAlign: 'top', // by default
								x: -30,
								y: -20
								}
							}
						},
						credits: {
						enabled: false
						},
						title: {
							text: '<?php echo $nametype." ".$namedateshow;?>',
						
						style: {
							fontSize: '14px'
						}
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							type: 'datetime',
							//maxZoom: <? echo $maxZ;?>,
							minRange: '<? echo $a;?>' * 60 * 1000 * 6,
							minTickInterval: '<? echo $a;?>' * 60 * 1000,
							title: {
								text: null
							},
							labels:{
							rotation:-45,
							align:'right',
							fontSize: '8px'
								},
							dateTimeLabelFormats: {
							second: '%H:%M:%S',
							minute: '%H:%M',
							hour: '%H:%M',
							day: '%e %B %Y',
							week:'%e %B %Y',
							month:'%B %Y',
							year:'%Y'
						}
						},
						yAxis: {
							min: '<? echo $minva;?>',
							title: {
								text: '<? echo $yaname;?>'
							}
						},
						tooltip: {
							formatter: function() {
							return  Highcharts.dateFormat('<? echo $formatdd;?>',this.x) + '<br><b>' + this.y +'</b>'+'  มม.';
						}
						},
						plotOptions: {
							column: {
								pointPadding: 0.2,
								borderWidth: 0
							},
							series: {
							marker: {
								enabled:false,
								lineWidth: 0
							}
							}
							},
							scrollbar: {
							 enabled: true
							},
							series: [{
								//pointInterval:900 * 1000,
								name: 'สถานี <?php echo $Dname;?>',
								//pointStart: Date.UTC(<? echo $syy+543 ;?>, <? echo $smm-1 ;?>, <? echo $sday ;?>),
								data: [<? echo $ponts_str;?>]

						}]
					});
				});

			});
			</script>
	<?
	}
	else if($view=="WL")
	{
		$nametype="กราฟระดับน้ำ";
		$yname="เมตร.รทก.";
		$yaname="ระดับน้ำ เมตร.รทก.";
		$typess="line";
		$wlH="หน้า ปตร.";
		$wlL="ท้าย ปตร.";

		$stralarm="select stn_id,CONVERT(decimal(10,1),alarm_WL1) a_L1,CONVERT(decimal(10,1),alarm_WL2) a_L2,CONVERT(float,alarm_WL2+10) alarm FROM [PATTANI].[dbo].[TM_STN] where STN_ID='$ssite' ";	
		$realarm = odbc_exec($connection,$stralarm);
		$malarm=odbc_fetch_array($realarm);
		$A_L1=$malarm['a_L1'];
		$A_L2=$malarm['a_L2'];
		$A_alarm=$malarm['alarm'];	
			
		$a=0;
		if($type =="DS")
		{
			$p_date=date("Y-m-d",strtotime($date1));
			$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
			$pointIn= 900 * 1000; // 15 min
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%e. %B %Y %H:%M";
			$minva = $maxva = null;
			$a=15;
			$b=900;
			
				$strQuery="select DISTINCT CONVERT(varchar(16),dtm,120) adate,wl as avalue 
				FROM [DWR_SongKhla].[dbo].[Daily] WHERE dtm BETWEEN '$date1 00:00' AND '$date2 23:45' and datepart(MINUTE,dtm) % 15 = 0 and stn='$ssite'   order by CONVERT(varchar(16),dtm,120) ";
			
		}
		elseif($type =="MS")
		{
			$p_date=date("Y-m",strtotime($date1));
			$p_date2=date("Y-m",strtotime($date2));
			$maxZ= 24 * 3600000;
			$pointIn= 24 * 3600 * 1000; // 1 day
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%e. %B %Y";
			$minva = $maxva = null;
			$a=60*24;
			$b=86400;
			if($ssite=="Tpat.12")
			{
				$strQuery="select DISTINCT CONVERT(varchar(10),DT,120) adate,CONVERT(decimal(10,2), avg(case sensor_id when '200' then value end)) avalue,CONVERT(decimal(10,2), avg(case sensor_id when '201' then value end)) bvalue FROM [PATTANI].[dbo].[DATA_Backup] WHERE CONVERT(varchar(7),DT,120) BETWEEN '".$dtmm1."' AND '".$dtmm2."' and datepart(MINUTE,DT) % 15 = 0 and 
				STN_ID='$ssite'  group BY CONVERT(varchar(10),DT,120) order by CONVERT(varchar(10),DT,120) ";
			}
			else
			{
				$strQuery="select DISTINCT CONVERT(varchar(10),DT,120) adate,CONVERT(decimal(10,2), avg(case sensor_id when '200' then value end)) avalue 
				FROM [PATTANI].[dbo].[DATA_Backup] WHERE CONVERT(varchar(7),DT,120) BETWEEN '".$dtmm1."' AND '".$dtmm2."' and datepart(MINUTE,DT) % 15 = 0 and 
				STN_ID='$ssite' group BY CONVERT(varchar(10),DT,120) order by CONVERT(varchar(10),DT,120) ";
			}
		}
		elseif($type =="YS")
		{
			$p_date=date("Y",strtotime($date1));
			$p_date2=date("Y",strtotime($date2));
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%B %Y";
			$minva = $maxva = null;
			if($ssite=="Tpat.12")
			{
				$strQuery="select DISTINCT CONVERT(varchar(7),DT,120) adate,CONVERT(decimal(10,2), avg(case sensor_id when '200' then value end)) avalue,CONVERT(decimal(10,2), avg(case sensor_id when '201' then value end)) bvalue FROM [PATTANI].[dbo].[DATA_Backup] WHERE CONVERT(varchar(4),DT,120) BETWEEN '".$dtyy."' AND '".$dtyy."' and datepart(MINUTE,DT) % 15 = 0 and 
				STN_ID='$ssite' and Value <> 0 group BY CONVERT(varchar(7),DT,120) order by CONVERT(varchar(7),DT,120)";
			}
			else
			{
				$strQuery="select DISTINCT CONVERT(varchar(7),DT,120) adate,CONVERT(decimal(10,2), avg(case sensor_id when '200' then value end)) avalue 
				FROM [PATTANI].[dbo].[DATA_Backup] WHERE CONVERT(varchar(4),DT,120) BETWEEN '".$dtyy."' AND '".$dtyy."' and datepart(MINUTE,DT) % 15 = 0 and 
				STN_ID='$ssite' and Value <> 0 group BY CONVERT(varchar(7),DT,120) order by CONVERT(varchar(7),DT,120)";
			}
		}
		else{}

	   $result = odbc_exec($connection,$strQuery); 
	  // while ($row_rs_tu01 = odbc_fetch_array($result));	

		$stagearray=array();
		$wt_arr=array();
		$wt_arr2=array();
		
		$stadatey=date("Y",strtotime($date1));
		if($type=="YS")
		{
			$stadatem="01";
		}
		else
		{
			$stadatem=date("m",strtotime($date1));
		}
		if($type=="MS" || $type=="MB" || $type=="YS")
		{
			$stadated="01";
		}
		else
		{
			$stadated=date("d",strtotime($date1));
		}
		$stadateh=date("H",strtotime($date1));
		$stadatei=date("i",strtotime($date1));
		$sm=$stadatey."-".$stadatem;
		
		if($type=="DS" || $type=="DB")
		{
			$stadate=strtotime($date1);
			$enddate=strtotime($date2)+86400;
		}
		elseif($type=="MS" || $type=="MB")
		{
			$date_y=date("Y",strtotime($date1));
			$date_m=date("m",strtotime($date1));
			$info = cal_days_in_month( CAL_GREGORIAN , $date_m , $date_y ) ;
			$stadate=strtotime(date("Y-m",strtotime($date1))."-01");
			$enddate=strtotime(date("Y-m",strtotime($date2))."-".$info."")+86400;
		}
		elseif($type=="YS")
		{
			$stadate=strtotime(date("Y",strtotime($date1))."-01-01");
			$enddate=strtotime(date("Y",strtotime($date2))."-12-31")+86400;
		}
		else{}	

		while($stadate < $enddate)
		{

			if ($row = odbc_fetch_array($result))
			{
				
				if($type=="DS" || $type=="DB" || $type=="MS" || $type=="MB")
				{
					$sname=strtotime($row['adate']);
				}
				elseif($type=="YS")
				{
					$sname=strtotime($row['adate']."-01");
				}
				else{}
				
				while($stadate < $sname)
				{
					array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
					array_push($wt_arr2,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
					if ($type=="DS" || $type=="DB" || $type=="MS" || $type=="MB")
					{
						$stadatei+=$a;
						$stadate+=$a*60;
					}
					else
					{
						
						$info = cal_days_in_month( CAL_GREGORIAN , $stadatem , $stadatey ) ;
						$stadate += ($info * 24 * 60 * 60);
						$stadatey=date("Y",$stadate);
						$stadatem=date("m",$stadate);
						$stadated=date("d",$stadate);
						$stadateh=date("H",$stadate);
						$stadatei=date("i",$stadate);
					}
				
				}
				if($ssite=="Tpat.12")
				{
					if($row["avalue"]==null){$val="null";}else{$val=$row["avalue"];}
					if($row["bvalue"]==null){$val2="null";}else{$val2=$row["bvalue"];}
					array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."), ".$val."]");
					array_push($wt_arr2,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."), ".$val2."]");
				}
				else
				{
					if($row["avalue"]==null){$val="null";}else{$val=$row["avalue"];}
					array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."), ".$val."]");
				}

				if ($type=="DS" || $type=="DB" || $type=="MS" || $type=="MB")
				{
					$stadatei+=$a;
					$stadate+=$a*60;
				}
				else
				{
				
					$info = cal_days_in_month( CAL_GREGORIAN ,$stadatem ,$stadatey ) ;
					$stadate += ($info * 24 * 60 * 60);
					$stadatey=date("Y",$stadate);
					$stadatem=date("m",$stadate);
					$stadated=date("d",$stadate);
					$stadateh=date("H",$stadate);
					$stadatei=date("i",$stadate);
				}
			
			}
			else
			{
				array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
				array_push($wt_arr2,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
				if ($type=="DS" || $type=="DB" || $type=="MS" || $type=="MB")
					{
						$stadatei+=$a;
						$stadate+=$a*60;
					}
					else
					{
						$info = cal_days_in_month( CAL_GREGORIAN ,$stadatem , $stadatey ) ;
						$stadate += ($info * 24 * 60 * 60);
						$stadatey=date("Y",$stadate);
						$stadatem=date("m",$stadate);
						$stadated=date("d",$stadate);
						$stadateh=date("H",$stadate);
						$stadatei=date("i",$stadate);
					}
				
			}
		}
		if($ssite=="Tpat.12")
		{
			$ponts_str=implode(",",$wt_arr);
			$ponts_str2=implode(",",$wt_arr2);
		}
		else
		{
			$ponts_str=implode(",",$wt_arr);
		}
		?>

			<div id="graph" class="span6" style="min-width: 1350px; height: 530px; margin: 0 auto"></div>
			<?if($ssite=="Tpat.12")
			{?>
			<script type="text/javascript">

			$(function () {				 
				$(document).ready(function() {
					Highcharts.setOptions({
					lang: {	months: ['ม.ค.', 'ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']		}
					});
					var chart = new Highcharts.Chart({
						chart: {
							renderTo: 'graph',
							zoomType: 'x',
							//height: 500,
						    //marginBottom: 110,
							spacingRight: 20,
							spacingLeft: 20 ,
								resetZoomButton: {
								position: {
								//align: 'right', // by default
								//verticalAlign: 'top', // by default
								x: -30,
								y: -20
								}
							}
						},
						credits: {
						enabled: false
						},
						title: {
							text: '<? echo $nametype." ".$namedateshow;?>',
							x: -20, //center
						style: {
							fontSize: '14px'
						}
						},
						legend: {
							layout: 'vertical',
							align: 'left',
							verticalAlign: 'top',
							x: 100,
							y: 35,
							floating: true,
							borderWidth: 1,
							backgroundColor: '#FFFFFF'
						},
						subtitle: {
						style: {
							fontSize: '12px'
							},
						verticalAlign: 'bottom',
						x: 420,
						y: -460
						},		
						xAxis: {
							type: 'datetime',
							//maxZoom: <? echo $maxZ;?>,
							minRange: '<? echo $a;?>' * 60 * 1000 * 6,
							minTickInterval: '<? echo $a;?>' * 60 * 1000,
							title: {
								text: null
							},
							labels:{
							rotation:-45,
							align:'right',
							fontSize: '8px'
								},
							dateTimeLabelFormats: {
							day: '%e %B %Y',
							week:'%e %B %Y',
							month:'%B %Y',
							year:'%Y'
						}
						},
					   yAxis: [{
							//min: '<? echo $minva;?>',
				
							//minPadding: 0.5,
							maxPadding: 0.5,
							title: {text: '<? echo $yaname;?>'}}
						],
						tooltip: {
							formatter: function() {	
								return  Highcharts.dateFormat('<? echo $formatdd;?>',this.x) + '<br><b>' + this.y +'</b>'+' <? echo $yname;?>';
								}
						},
						plotOptions: {							
							series:{marker:{enabled:false}}
						},    
						scrollbar: {
							 enabled: true
						 },
						series: [{
							type: 'line',
							name: '<? echo $wlH;?>',
							data: [<? echo $ponts_str;?>],
							lineWidth: 1,
							dashStyle:'shortdot'
								},
							{
							type: 'line',
							name: '<? echo $wlL;?>',
							data: [<? echo $ponts_str2;?>],		
							lineWidth: 1,
							dashStyle:'solid'
						}]
					});
						
				});

			});
			</script>
			<?}
			else
			{?>
			<script type="text/javascript">
			$(function () {
				var chart;
				$(document).ready(function() {
					Highcharts.setOptions({
					lang: {
						months: ['ม.ค.', 'ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']		}
				});
					chart = new Highcharts.Chart({
						chart: {
							zoomType: 'x',
							renderTo: 'graph',
							type: 'line',
							spacingLeft: 25 ,
							resetZoomButton: {
								position: {
								// align: 'right', // by default
								 // verticalAlign: 'top', // by default
								x: -30,
								y: -20
								}
							}
						},
						credits: {
						enabled: false
						},
						title: {
							text: '<? echo $nametype." ".$namedateshow;?>',
						
						style: {
							fontSize: '14px'
						}
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							type: 'datetime',
							//maxZoom: <? echo $maxZ;?>,
							minRange: '<? echo $a;?>' * 60 * 1000 * 6,
							minTickInterval: '<? echo $a;?>' * 60 * 1000,
							title: {
								text: null
							},
							labels:{
							rotation:-45,
							align:'right',
							fontSize: '8px'
								},
							dateTimeLabelFormats: {
							day: '%e %B %Y',
							week:'%e %B %Y',
							month:'%B %Y',
							year:'%Y'
						}
						},
						yAxis: {
							//min: '<? echo $minva;?>',
							minPadding: 2,
							maxPadding: 2,
							title: {
								text: '<? echo $yaname;?>'
							}
						},
						tooltip: {
							formatter: function() {
							return  Highcharts.dateFormat('<? echo $formatdd;?>',this.x) + '<br><b>' + this.y +'</b>'+' <? echo $yname;?>';
						}
						},
						plotOptions: {
							series:{marker:{enabled:false}}
						},
						exporting: {
							url: 'http://telepattani.com/exporting_server/index.php'
						},
						scrollbar: {
							 enabled: true
						},
						series: [{
							//pointInterval:900 * 1000,
							name: 'สถานี <?php echo $Dname;?>',
							//pointStart: Date.UTC(<? echo $syy+543 ;?>, <? echo $smm-1 ;?>, <? echo $sday ;?>),
							data: [<? echo $ponts_str;?>],
							lineWidth: 1

						}]
					});
				});

			});
			</script>
			<?	
			}
	}
	else if($view=="FLOW")
	{
		$nametypfull="กราฟปริมาณน้ำ";

		$nametype="อัตราการไหล";
		$yname="ลบ.ม./วินาที";
		$yaname="อัตราการไหล  ลบ.ม./วินาที";

		$nametype2="ความเร็ว";
		$yname2="ม./วินาที";
		$yaname2="ความเร็ว  ม./วินาที";

		$nametype3="พื้นที่หน้าตัด";
		$yname3="ตร.ม./วินาที";
		$yaname3="พื้นที่หน้าตัด  ตร.ม./วินาที";

		/*$stralarm="select stn_id,CONVERT(decimal(10,1),Alram_L1) a_L1,CONVERT(decimal(10,1),Alram_L2) a_L2,CONVERT(float,Alram_L2+10) alarm FROM [PATTANI].[dbo].[TM_STN] where STN_ID='$ssite' ";	
		$realarm = odbc_exec($connection,$stralarm);
		$malarm=odbc_fetch_array($realarm);
		$A_L1=$malarm['a_L1'];
		$A_L2=$malarm['a_L2'];
		$A_alarm=$malarm['alarm'];	*/
			
		$a=0;
		if($type =="DS")
		{
			$p_date=date("Y-m-d",strtotime($date1));
			$maxZ= 3 * 60 * 60 * 1000;//3 * 3600000;
			$pointIn= 900 * 1000; // 15 min
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%e. %B %Y %H:%M";
			$minva = $maxva = null;
			$a=15;
			$b=900;
			
				$strQuery="select DISTINCT CONVERT(varchar(16),DT,120) adate
				,sum(case sensor_id when '300' then Value end) avalue 
				,sum(case sensor_id when '301' then Value end) bvalue
				,sum(case sensor_id when '302' then Value end) cvalue
				FROM [PATTANI].[dbo].[DATA_Backup] WHERE DT BETWEEN '$date1 00:00' AND '$date2 23:45' and datepart(MINUTE,DT) % 15 = 0 and STN_ID='$ssite'   group BY CONVERT(varchar(16),DT,120) order by CONVERT(varchar(16),DT,120) ";
			
		}
		elseif($type =="MS")
		{
			$p_date=date("Y-m",strtotime($date1));
			$p_date2=date("Y-m",strtotime($date2));
			$maxZ= 24 * 3600000;
			$pointIn= 24 * 3600 * 1000; // 1 day
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%e. %B %Y";
			$minva = $maxva = null;
			$a=60*24;
			$b=86400;
			
				$strQuery="select DISTINCT CONVERT(varchar(10),DT,120) adate
				,CONVERT(decimal(38,2),avg(case sensor_id when '300' then value end)) avalue 
				,CONVERT(decimal(38,2),avg(case sensor_id when '301' then Value end)) bvalue
				,CONVERT(decimal(38,2),avg(case sensor_id when '302' then Value end)) cvalue
				FROM [PATTANI].[dbo].[DATA_Backup] WHERE CONVERT(varchar(7),DT,120) BETWEEN '".$dtmm1."' AND '".$dtmm2."' and datepart(MINUTE,DT) % 15 = 0 and 
				STN_ID='$ssite' group BY CONVERT(varchar(10),DT,120) order by CONVERT(varchar(10),DT,120) ";
			
		}
		elseif($type =="YS")
		{
			$p_date=date("Y",strtotime($date1));
			$p_date2=date("Y",strtotime($date2));
			$mmdate=date("m",strtotime($date1))-1;
			$formatdd="%B %Y";
			$minva = $maxva = null;
			
				$strQuery="select DISTINCT CONVERT(varchar(7),DT,120) adate
				,CONVERT(decimal(38,2),avg(case sensor_id when '300' then value end)) avalue 
				,CONVERT(decimal(38,2),avg(case sensor_id when '301' then Value end)) bvalue
				,CONVERT(decimal(38,2),avg(case sensor_id when '302' then Value end)) cvalue
				FROM [PATTANI].[dbo].[DATA_Backup] WHERE CONVERT(varchar(4),DT,120) BETWEEN '".$dtyy."' AND '".$dtyy."' and datepart(MINUTE,DT) % 15 = 0 and 
				STN_ID='$ssite' group BY CONVERT(varchar(7),DT,120) order by CONVERT(varchar(7),DT,120)";
			
		}
		else{}

		$result = odbc_exec($connection,$strQuery); 
		// while ($row_rs_tu01 = odbc_fetch_array($result));	

		$stagearray=array();
		$wt_arr=array();
		$wt_arr2=array();
		$wt_arr3=array();
		
		$stadatey=date("Y",strtotime($date1));
		if($type=="YS")
		{
			$stadatem="01";
		}
		else
		{
			$stadatem=date("m",strtotime($date1));
		}
		if($type=="MS" || $type=="MB" || $type=="YS")
		{
			$stadated="01";
		}
		else
		{
			$stadated=date("d",strtotime($date1));
		}
		$stadateh=date("H",strtotime($date1));
		$stadatei=date("i",strtotime($date1));
		$sm=$stadatey."-".$stadatem;
		
		if($type=="DS" || $type=="DB")
		{
			$stadate=strtotime($date1);
			$enddate=strtotime($date2)+86400;
		}
		elseif($type=="MS" || $type=="MB")
		{
			$date_y=date("Y",strtotime($date1));
			$date_m=date("m",strtotime($date1));
			$info = cal_days_in_month( CAL_GREGORIAN , $date_m , $date_y ) ;
			$stadate=strtotime(date("Y-m",strtotime($date1))."-01");
			$enddate=strtotime(date("Y-m",strtotime($date2))."-".$info."")+86400;
		}
		elseif($type=="YS")
		{
			$stadate=strtotime(date("Y",strtotime($date1))."-01-01");
			$enddate=strtotime(date("Y",strtotime($date2))."-12-31")+86400;
		}
		else{}	

		while($stadate < $enddate)
		{

			if ($row = odbc_fetch_array($result))
			{
				
				if($type=="DS" || $type=="DB" || $type=="MS" || $type=="MB")
				{
					$sname=strtotime($row['adate']);
				}
				elseif($type=="YS")
				{
					$sname=strtotime($row['adate']."-01");
				}
				else{}
				
				while($stadate < $sname)
				{
					array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
					array_push($wt_arr2,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
					array_push($wt_arr3,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
					if ($type=="DS" || $type=="DB" || $type=="MS" || $type=="MB")
					{
						$stadatei+=$a;
						$stadate+=$a*60;
					}
					else
					{
						
						$info = cal_days_in_month( CAL_GREGORIAN , $stadatem , $stadatey ) ;
						$stadate += ($info * 24 * 60 * 60);
						$stadatey=date("Y",$stadate);
						$stadatem=date("m",$stadate);
						$stadated=date("d",$stadate);
						$stadateh=date("H",$stadate);
						$stadatei=date("i",$stadate);
					}
				
				}
				
				if($row["avalue"]==null){$val="null";}else{$val=$row["avalue"];}
				if($row["bvalue"]==null){$val2="null";}else{$val2=$row["bvalue"];}
				if($row["cvalue"]==null){$val3="null";}else{$val3=$row["cvalue"];}
				array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."), ".$val."]");
				array_push($wt_arr2,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."), ".$val2."]");
				array_push($wt_arr3,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."), ".$val3."]");
				

				if ($type=="DS" || $type=="DB" || $type=="MS" || $type=="MB")
				{
					$stadatei+=$a;
					$stadate+=$a*60;
				}
				else
				{
				
					$info = cal_days_in_month( CAL_GREGORIAN ,$stadatem ,$stadatey ) ;
					$stadate += ($info * 24 * 60 * 60);
					$stadatey=date("Y",$stadate);
					$stadatem=date("m",$stadate);
					$stadated=date("d",$stadate);
					$stadateh=date("H",$stadate);
					$stadatei=date("i",$stadate);
				}
			
			}
			else
			{
				array_push($wt_arr,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
				array_push($wt_arr2,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
				array_push($wt_arr3,"[ Date.UTC(".($stadatey+543).",".($stadatem-1).",".$stadated.",".$stadateh.",".$stadatei."),  null]");
				if ($type=="DS" || $type=="DB" || $type=="MS" || $type=="MB")
					{
						$stadatei+=$a;
						$stadate+=$a*60;
					}
					else
					{
						$info = cal_days_in_month( CAL_GREGORIAN ,$stadatem , $stadatey ) ;
						$stadate += ($info * 24 * 60 * 60);
						$stadatey=date("Y",$stadate);
						$stadatem=date("m",$stadate);
						$stadated=date("d",$stadate);
						$stadateh=date("H",$stadate);
						$stadatei=date("i",$stadate);
					}
				
			}
		}
		
		$ponts_str=implode(",",$wt_arr);
		$ponts_str2=implode(",",$wt_arr2);
		$ponts_str3=implode(",",$wt_arr3);
		
		?>

			<div id="graph" class="span6" style="min-width: 1350px; height: 530px; margin: 0 auto"></div>
			<script type="text/javascript">
			$(function () {				 
				$(document).ready(function() {
					Highcharts.setOptions({
					lang: {	months: ['ม.ค.', 'ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']		}
					});
					var chart = new Highcharts.Chart({
						chart: {
							renderTo: 'graph',
							zoomType: 'x',
							//height: 500,
						    //marginBottom: 110,
							spacingRight: 20,
							spacingLeft: 20 ,
								resetZoomButton: {
								position: {
								//align: 'right', // by default
								//verticalAlign: 'top', // by default
								x: -30,
								y: -20
								}
							}
						},
						credits: {
						enabled: false
						},
						title: {
							text: '<? echo $nametypfull." ".$namedateshow;?>',
							x: -20, //center
						style: {
							fontSize: '14px'
						}
						},
						legend: {
							layout: 'vertical',
							align: 'left',
							verticalAlign: 'top',
							x: 180,
							y: 35,
							floating: true,
							borderWidth: 1,
							backgroundColor: '#FFFFFF'
						},
						subtitle: {
						text: 'สถานี <?php echo $Dname;?>',
						x: -20, //center
						style: {
						fontSize: '12px',
						color: '#363636'
						}
						},		
						xAxis: {
							type: 'datetime',
							//maxZoom: <? echo $maxZ;?>,
							minRange: '<? echo $a;?>' * 60 * 1000 * 6,
							minTickInterval: '<? echo $a;?>' * 60 * 1000,
							title: {
								text: null
							},
							labels:{
							rotation:-45,
							align:'right',
							fontSize: '8px'
								},
							dateTimeLabelFormats: {
							day: '%e %B %Y',
							week:'%e %B %Y',
							month:'%B %Y',
							year:'%Y'
						}
					},
					   yAxis: [{
							//min: '<? echo $minva;?>',
							lineWidth: 1,
							tickWidth: 1,
							maxPadding: 0.5,
							title: 
								{
									text: '<? echo $yaname;?>', 
									style: {
										 color: "#990000"
										}
								},
								labels: {
									style: {
										color: "#990000"
											}
										}
								},
								{
									lineWidth: 1,
									tickWidth: 1,
									maxPadding: 0.5,
									title: 
										{
											text: '<? echo $yaname2;?>', 
											style: {
												 color: "#00008B"
												}
										},
										labels: {
											style: {
												color: "#00008B"
													}
												}
								},
								{
									lineWidth: 1,
									tickWidth: 1,
									maxPadding: 0.5,
									title: 
										{
											text: '<? echo $yaname3;?>', 
											style: {
												 color: "#007700"
												}
										},
										labels: {
											style: {
												color: "#007700"
													}
												},
												opposite: true
								}
										],
						tooltip: {
							formatter: function() {
						var a='<?=$nametype?>';
						var b='<?=$nametype2?>';
						var c='<?=$nametype3?>';
						//alert(d);
						if(this.point.series.name ==a)
						{
							return  Highcharts.dateFormat('<?php echo $formatdd;?>',this.x) + '<br> <?php echo $nametype;?> <b>' + this.y +'</b>'+' <?php echo $yname;?>';
						}
						else if(this.point.series.name ==b)
						{
							return  Highcharts.dateFormat('<?php echo $formatdd;?>',this.x) + '<br> <?php echo $nametype2;?> <b>' + this.y +'</b>'+' <?php echo $yname2;?>';
						}
						else 
						{
							return  Highcharts.dateFormat('<?php echo $formatdd;?>',this.x) + '<br> <?php echo $nametype3;?> <b>' + this.y +'</b>'+' <?php echo $yname3;?>';
						}
					}
					},
						plotOptions: {							
							series:{marker:{enabled:false}}
						},    
						scrollbar: {
							 enabled: true
						 },
						series: [{
							type: 'line',
							name: '<? echo $nametype;?>',
							data: [<? echo $ponts_str;?>],
							color: "#990000",
							yAxis: 0,
							lineWidth: 1,
							dashStyle:'shortdot'
								},
							{
							type: 'line',
							name: '<? echo $nametype2;?>',
							data: [<? echo $ponts_str2;?>],	
							color: "#00008B",
							yAxis: 1,
							lineWidth: 1,
							dashStyle:'solid'
								},
							{
							type: 'line',
							name: '<? echo $nametype3;?>',
							data: [<? echo $ponts_str3;?>],	
							color: "#007700",
							yAxis: 2,
							lineWidth: 1,
							dashStyle:"solid"
						}]
					});
						
				});

			});
			</script>
			<?	
	}
	else
	{}
?>
<?
/*------------------------function----------------------------------*/
function ShortThaiDate($txt,$ss,$ssite,$ty)
{
	global $ThaiSubMonth;
	$Year = substr(substr($txt, 0, 4), -4);
	$Month = substr($txt, 5, 2);
	$DayNo = substr($txt, 8, 2);
	$T = substr($txt, 11, 5);
	
	if($ty=="rf")
	{
		if($ssite=="Tpat.1" || $ssite=="Tpat.2" || $ssite=="Tpat.6" || $ssite=="Tpat.7" || $ssite=="Tpat.12")
		{
			$x="n/a";
		}
		else
		{
			if($ss==1)
			{
				$x = $Year."-".$Month."-".$DayNo." ".$T;
			}
			else if($ss==2)
			{
				$x = $Year."-".$Month."-".$DayNo;
			}
			else 
			{
				$x = $Year."-".$Month;
			}
		}
	}
	elseif($ty=="wl")
	{
		if($ssite=="Tpat.16" || $ssite=="Tpat.18" || $ssite=="Tpat.19" || $ssite=="20" || $ssite=="Tpat.22" || $ssite=="Tpat.23" || $ssite=="Tpat.24")
		{
			$x="n/a";
		}
		else
		{
			if($ss==1)
			{
				$x = $Year."-".$Month."-".$DayNo." ".$T;
			}
			else if($ss==2)
			{
				$x = $Year."-".$Month."-".$DayNo;
			}
			else 
			{
				$x = $Year."-".$Month;
			}
		}
	}
	else
	{
		if($ss==1)
			{
				$x = $Year."-".$Month."-".$DayNo." ".$T;
			}
			else if($ss==2)
			{
				$x = $Year."-".$Month."-".$DayNo;
			}
			else 
			{
				$x = $Year."-".$Month;
			}
	}
	return $x;
}

function checkrf($n,$ssite,$mm)
{
	if($ssite=="Tpat.1" || $ssite=="Tpat.2" || $ssite=="Tpat.6" || $ssite=="Tpat.7" || $ssite=="Tpat.12")
	{
		$s="n/a";
	}
	else
	{
		$s=number_format($n,2);
	}
	return $s;
}

function checkna($n,$ssite,$mm)
{
	if($ssite=="Tpat.16" || $ssite=="Tpat.18" || $ssite=="Tpat.19" || $ssite=="20" || $ssite=="Tpat.22" || $ssite=="Tpat.23" || $ssite=="Tpat.24")
	{
			if($mm=="0")
			{
				$s=number_format($n,2);
			}
			else
			{
				$s="n/a";
			}
	}
	elseif($n=="")
	{
		$s="-";
	}
	else
	{
		$s=number_format($n,2);
	}
	return $s;
}
function checkflow($n,$ssite,$mm)
{
	if($ssite=="Tpat.5" || $ssite=="Tpat.7")
	{
		if($n=="" && $n!="0")
		{
			$s="-";
		}
		else
		{
			if($mm=="1")
			{
				$s=number_format($n,2);
			}
			else
			{
				$s="n/a";
			}
		}
	}
	else
	{
		$s="n/a";
	}
	return $s;
}




function c_wl($id)
{
if($id=='STN11' )
{return 0;}else{return 1;}
}
function c_rf($id)
{
if($id=='Tpat.3'  )
{return 0;}else{return 1;}
}
	function select_q($val,$stn)
	{
		global $connection;
		$v=number_format($val, 2);
		$select="SELECT Q FROM [PATTANI].[dbo].[WL2Q] WHERE STN_ID='".$stn."' AND WL='".$v."' ";

		$r=odbc_fetch_array(odbc_exec($connection,$select));

		return $r['Q'];
	}

?>
<script type="text/javascript">
$(document).ready(function()
{
	//alert("aa");
	$('.datatable').fixedtableheader({ headerrowsize:2 });


});
</script>