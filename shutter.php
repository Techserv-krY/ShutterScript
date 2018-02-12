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

	array(46612 /*[Eltako FSB61]*/,56,55,3.3,3.3,"test"),
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




switch ($_IPS['SENDER']) {

	case "WebFront": {

		switch($_IPS['VALUE']) {

// ShutterMove.OC
				case ENO_STOP:{
					ENO_ShutterStop($ENO_ID);
					SetValueBoolean(46916 /*[Eltako FSB61\ShutterStop]*/,true);
					SetValueBoolean(17347 /*[Eltako FSB61\Shutter25]*/,false);
					SetValueBoolean(15897 /*[Eltako FSB61\Shutter50]*/,false);
					SetValueBoolean(56662 /*[Eltako FSB61\Shutter75]*/,false);
					break;
				}
				case ENO_UP:{
					ENO_ShutterMoveUp($ENO_ID);
					SetValueBoolean(37212 /*[Eltako FSB61\ShutterOC]*/,true);
					SetValueBoolean(46916 /*[Eltako FSB61\ShutterStop]*/,false);
					SetValueBoolean(17347 /*[Eltako FSB61\Shutter25]*/,false);
					SetValueBoolean(15897 /*[Eltako FSB61\Shutter50]*/,false);
					SetValueBoolean(56662 /*[Eltako FSB61\Shutter75]*/,false);
					break;
				}
				case ENO_DOWN: {
					ENO_ShutterMoveDown($ENO_ID);
					SetValueBoolean(37212 /*[Eltako FSB61\ShutterOC]*/,false);
					SetValueBoolean(46916 /*[Eltako FSB61\ShutterStop]*/,false);
					SetValueBoolean(17347 /*[Eltako FSB61\Shutter25]*/,false);
					SetValueBoolean(15897 /*[Eltako FSB61\Shutter50]*/,false);
					SetValueBoolean(56662 /*[Eltako FSB61\Shutter75]*/,false);
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
						}
					elseif(GetValueBoolean($Shutter75)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN50);
						}
					elseif(GetValueBoolean($ShutterOC)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN75);
						}
						else {
						ENO_ShutterMoveUpEx($ENO_ID, $UP25);
						}
					SetValueBoolean($Shutter25 ,true);
					SetValueBoolean($Shutter50 ,false);
					SetValueBoolean($Shutter75 ,false);
					break;
				}
				
				case ENO_50: {
					if(GetValueBoolean($Shutter25)) {
						ENO_ShutterMoveUpEx($ENO_ID, $UP25);
						}
					elseif(GetValueBoolean($Shutter50)) {
						ENO_ShutterStop($ENO_ID);
						}
					elseif(GetValueBoolean($Shutter75)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN25);
						}
					elseif(GetValueBoolean($ShutterOC)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN50);
						}
						else {
						ENO_ShutterMoveUpEx($ENO_ID, $UP50);
						}
					SetValueBoolean($Shutter25 ,false);
					SetValueBoolean($Shutter50 ,true);
					SetValueBoolean($Shutter75 ,false);
					break;
				}
				
				case ENO_75: {
					if(GetValueBoolean($Shutter25)) {
						ENO_ShutterMoveUpEx($ENO_ID, $UP50);
						}
					elseif(GetValueBoolean($Shutter50)) {
						ENO_ShutterMoveUpEx($ENO_ID, $UP25);
						}
					elseif(GetValueBoolean($Shutter75)) {
						ENO_ShutterStop($ENO_ID);
						}
					elseif(GetValueBoolean($ShutterOC)) {
						ENO_ShutterMoveDownEx($ENO_ID, $DOWN25);
						}
						else {
						ENO_ShutterMoveUpEx($ENO_ID, $UP75);
						}
						SetValueBoolean($Shutter25 ,false);
						SetValueBoolean($Shutter50 ,false);
						SetValueBoolean($Shutter75 ,true);
					break;
				}

// ShutterSlates				 
//				case ENO_LAM50:
//					ENO_ShutterMoveUpEx($ENO_ID, $test2);
//					SetValueBoolean(56662 /*[Eltako FSB61\Shutter75]*/,true);
//				break;

		}
	}
}
}
// echo $ENO_ID . "\n";
?>