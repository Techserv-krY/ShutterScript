<?
//	print for debuging
//	print_r($_IPS);
// Definition Buttons WebFront
define("ENO_UP", 0);
define("ENO_STOP", 1);
define("ENO_DOWN", 2);
define("ENO_25", 3);
define("ENO_50", 4);
define("ENO_75", 5);
define("ENO_L0", 6);
define("ENO_L25", 7);
define("ENO_L50", 8);
define("ENO_L75", 9);
define("ENO_L100", 10);
// Aktiv Button Glow WebFront
if($_IPS["SENDER"] == "WebFront"){
	SetValue($_IPS["VARIABLE"], $_IPS["VALUE"]);
	}
$jalousien=array(
//EDIT ---------!!!!!! array(OBJEKTID,FAHRZEIT NACH OBEN,FAHRZEIT NACH UNTEN,LAMELLEN AUF,LAMELLEN ZU,"NAME JALOUSIE"), !!!!!!
	array(46612 /*[Eltako FSB61]*/,56,55,3.3,3.3,"Jalousie 2"),
	);
// print for debuging
//	print_r($jalousien);
		for ( $x = 0; $x < count ( $jalousien ); $x++ )
{
// Array Definition
	$ENO_ID      = $jalousien[$x][0];
	$ENO_UP_T    = $jalousien[$x][1];
	$ENO_DOWN_T  = $jalousien[$x][2];
	$ENO_LUP_T   = $jalousien[$x][3];
	$ENO_LDOWN_T = $jalousien[$x][4];
	$ENO_NAME    = $jalousien[$x][5];
	
//EDIT ---------!!!!!! Boolean !!!!!!
	$ShutterOC       = 37212 /*[Eltako FSB61\ShutterOC]*/;
	$ShutterStop     = 46916 /*[Eltako FSB61\ShutterStop]*/;
	$Shutter25       = 17347 /*[Eltako FSB61\Shutter25]*/;
	$Shutter50       = 15897 /*[Eltako FSB61\Shutter50]*/;
	$Shutter75       = 56662 /*[Eltako FSB61\Shutter75]*/;
	$ShutterMovement = 15301 /*[Eltako FSB61\ShutterMovement]*/;
	$isRunning       = 55615 /*[Eltako FSB61\isRunning]*/;
	
// if Shutter Down - Time Calculator  for Position 25%, 50% and 75%
	$UP25 = $ENO_UP_T - $ENO_UP_T * 75 / 100;
	$UP50 = $ENO_UP_T - $ENO_UP_T * 50 / 100;
	$UP75 = $ENO_UP_T - $ENO_UP_T * 25 / 100;
// if Shutter Up - Time Calculator  for Position 25%, 50% and 75%
	$DOWN25 = $ENO_DOWN_T - $ENO_DOWN_T * 75 / 100;
	$DOWN50 = $ENO_DOWN_T - $ENO_DOWN_T * 50 / 100;
	$DOWN75 = $ENO_DOWN_T - $ENO_DOWN_T * 25 / 100;
// if Shutter Down - Time Calculator  for Slats Position 25%, 50% and 75%
	$LUP25 = $ENO_LUP_T - $ENO_LUP_T * 75 / 100;
	$LUP50 = $ENO_LUP_T - $ENO_LUP_T * 50 / 100;
	$LUP75 = $ENO_LUP_T - $ENO_LUP_T * 25 / 100;
// if Shutter Up - Time Calculator  for Slats Position 25%, 50% and 75%
	$LDOWN25 = $ENO_LUP_T - $ENO_LUP_T * 75 / 100;
	$LDOWN25 = $ENO_LUP_T - $ENO_LUP_T * 50 / 100;
	$LDOWN25 = $ENO_LUP_T - $ENO_LUP_T * 25 / 100;
	
// TimerScript			
	$timerscriptid = 32702 /*[Eltako FSB61\Time Elapsed\time elapsed]*/;
    $starttimeid = 37742 /*[Eltako FSB61\Start Time]*/;
			
switch ($_IPS['SENDER']) {
	case "WebFront": {
		switch($_IPS['VALUE']) {
// ShutterMove.OC
				case ENO_STOP:{
					ENO_ShutterStop($ENO_ID);
					SetValueBoolean($ShutterStop ,true);
					SetValueBoolean($Shutter25 ,false);
					SetValueBoolean($Shutter50 ,false);
					SetValueBoolean($Shutter75 ,false);
					break;
				}
				case ENO_UP:{
					ENO_ShutterMoveUp($ENO_ID);
					SetValueBoolean($ShutterOC ,true);
					SetValueBoolean($ShutterStop ,false);
					SetValueBoolean($Shutter25 ,false);
					SetValueBoolean($Shutter50 ,false);
					SetValueBoolean($Shutter75 ,false);
					SetValueBoolean($isRunning ,true);
					break;
				}
				case ENO_DOWN: {
					ENO_ShutterMoveDown($ENO_ID);
					SetValueBoolean($ShutterOC ,false);
					SetValueBoolean($ShutterStop ,false);
					SetValueBoolean($Shutter25 ,false);
					SetValueBoolean($Shutter50 ,false);
					SetValueBoolean($Shutter75 ,false);
					SetValueBoolean($isRunning ,true);
					break;
				}
// ShutterMove
				case ENO_25: {
//	if(GetValueBoolean($ShutterOC)) == true { // True = FULLOPEN
					if(GetValueBoolean($Shutter25)) {
						ENO_ShutterStop($ENO_ID);
						}
					elseif(GetValueBoolean($Shutter50)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN25);
						//	fals = letze befehlt war nach oben / true = letzter befehl nach unten
						SetValueBoolean($ShutterMovement ,true);
						}
					elseif(GetValueBoolean($Shutter75)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN50);
						SetValueBoolean($ShutterMovement ,true);
						}
					elseif(GetValueBoolean($ShutterOC)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN75);
						SetValueBoolean($ShutterMovement ,true);
						}
						else {
						ENO_ShutterMoveUpEx($ENO_ID, $UP25);
						SetValueBoolean($ShutterMovement ,false);
						}
					SetValueBoolean($Shutter25 ,true);
					SetValueBoolean($Shutter50 ,false);
					SetValueBoolean($Shutter75 ,false);
					SetValueBoolean($isRunning ,true);
					break;
				}
				
				case ENO_50: {
					if(GetValueBoolean($Shutter25)) {
						ENO_ShutterMoveUpEx($ENO_ID, $UP25);
						SetValueBoolean($ShutterMovement ,false);
						}
					elseif(GetValueBoolean($Shutter50)) {
						ENO_ShutterStop($ENO_ID);
						}
					elseif(GetValueBoolean($Shutter75)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN25);
						SetValueBoolean($ShutterMovement ,true);
						}
					elseif(GetValueBoolean($ShutterOC)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN50);
						SetValueBoolean($ShutterMovement ,true);
						}
						else {
						ENO_ShutterMoveUpEx($ENO_ID, $UP50);
						SetValueBoolean($ShutterMovement ,false);
						}
					SetValueBoolean($Shutter25 ,false);
					SetValueBoolean($Shutter50 ,true);
					SetValueBoolean($Shutter75 ,false);
					SetValueBoolean($isRunning ,true);
					break;
				}
				
				case ENO_75: {
					if(GetValueBoolean($Shutter25)) {
						ENO_ShutterMoveUpEx($ENO_ID, $UP50);
						SetValueBoolean($ShutterMovement ,false);
						}
					elseif(GetValueBoolean($Shutter50)) {
						ENO_ShutterMoveUpEx($ENO_ID, $UP25);
						SetValueBoolean($ShutterMovement ,false);
						}
					elseif(GetValueBoolean($Shutter75)) {
						ENO_ShutterStop($ENO_ID);
						}
					elseif(GetValueBoolean($ShutterOC)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN25);
						SetValueBoolean($ShutterMovement ,true);
						}
						else {
						ENO_ShutterMoveUpEx($ENO_ID, $UP75);
						SetValueBoolean($ShutterMovement ,false);
						}
						SetValueBoolean($Shutter25 ,false);
						SetValueBoolean($Shutter50 ,false);
						SetValueBoolean($Shutter75 ,true);
						SetValueBoolean($isRunning ,true);
					break;
				}
				
// ShutterSlates				 
//				case ENO_L0: {
//					ENO_ShutterMoveUpEx($ENO_ID, $test2);
//					SetValueBoolean(56662 /*[Eltako FSB61\Shutter75]*/,true);
//				break;
		}
	}
}
}

$nowtime = time();
$oldtime = GetValueInteger(37742 /*[Eltako FSB61\Start Time]*/); //Startzeit

if(GetValueBoolean($isRunning)) {  // Beim Einschalten Timer setzten und Startzeit ablegen

	SetValue($starttimeid, time());
}
		elseif(GetValueBoolean($isRunning)) {
 			if(($diff = $nowtime - $oldtime) < 0) $diff =0; { 
				$timeprint = round($diff / 56 * 100)."% (".$diff.")";
				SetValue(57245 /*[Eltako FSB61\Time Elapsed]*/, $timeprint);
			}
		}
elseif(GetValueBoolean($isRunning)) {
 			if(($diff = $nowtime - $oldtime) == 10) { 
				SetValueBoolean($isRunning ,false);
			}
}
echo $nowtime - $oldtime . "\n";
// echo $ENO_ID . "\n";
?>
