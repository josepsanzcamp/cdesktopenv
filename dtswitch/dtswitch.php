#!/bin/php -q
<?php
if(!isset($argv[1])) die("Unknown action\n");
$action=$argv[1];

chdir(dirname($_SERVER["SCRIPT_NAME"]));

function mypassthru($cmd) {
	ob_start();
	passthru($cmd);
	$buffer=ob_get_clean();
	$buffer=trim($buffer);
	return $buffer;
}

function dtgetallws() {
	return mypassthru("./dtgetallws.sh");
}

function dtgetcurws() {
	return mypassthru("./dtgetcurws.sh");
}

function dtsetws($workspace) {
	mypassthru("./dtsetws.sh ${workspace}");
}

function dtmovews($windowid,$workspace) {
	mypassthru("./dtmovews.sh ${windowid} ${workspace}");
}

function getwindowname() {
	return mypassthru("xdotool getwindowfocus getwindowname");
}

function getwindowid() {
	return mypassthru("xdotool getwindowfocus");
}

function dtsearch($arg) {
	return mypassthru("xdotool search ${arg}");
}

function dtfocus($windowid) {
	mypassthru("xdotool windowfocus ${windowid}");
}

function addlog($msg) {
	file_put_contents("dtswitch.log",date("Y-m-d H:i:s").": ".$msg."\n",FILE_APPEND);
}

$buffer=dtgetallws();
$buffer=explode("\n",$buffer);
$atom2title=array();
$title2atom=array();
$total=count($buffer);
foreach($buffer as $key=>$val) {
	$val=explode("|",$val);
	$atom2title[$val[0]]=$val[2];
	$title2atom[$val[2]]=$val[0];
}
//~ print_r($atom2title);
//~ print_r($title2atom);
//~ die();

$buffer=dtgetcurws();
$buffer=explode("|",$buffer);
$prev=$buffer[2];
//~ print_r($prev);
//~ die();

if(isset($title2atom[$action])) {
	dtsetws($title2atom[$action]);
	die();
}

if(substr($action,-1,1)=="2") {
	$windowname=getwindowname();
	if($windowname=="") die();
	if(isset($title2atom[$windowname])) die();
	$windowid=getwindowid();
	if($windowid=="") die();
	$action=substr($action,0,-1);
}

$maps=array(
	4=>array(
		// VERTICAL
		"One|down"=>"Three",
		"Two|down"=>"Four",
		"Three|up"=>"One",
		"Four|up"=>"Two",
		// HORIZONTAL
		"One|right"=>"Two",
		"Three|right"=>"Four",
		"Two|left"=>"One",
		"Four|left"=>"Three",
		// CONTINUOUS
		"Two|right"=>"Three",
		"Three|left"=>"Two",
		"Two|up"=>"Three",
		"Three|down"=>"Two",
	),
	6=>array(
		// VERTICAL
		"One|down"=>"Four",
		"Two|down"=>"Five",
		"Three|down"=>"Six",
		"Four|up"=>"One",
		"Five|up"=>"Two",
		"Six|up"=>"Three",
		// HORIZONTAL
		"One|right"=>"Two",
		"Two|right"=>"Three",
		"Four|right"=>"Five",
		"Five|right"=>"Six",
		"Six|left"=>"Five",
		"Five|left"=>"Four",
		"Three|left"=>"Two",
		"Two|left"=>"One",
		// CONTINUOUS
		"Three|right"=>"Four",
		"Four|left"=>"Three",
		"Four|down"=>"Two",
		"Five|down"=>"Three",
		"Three|up"=>"Five",
		"Two|up"=>"Four",
	),
);

if(isset($maps[$total])) $map=$maps[$total];
if(isset($map[$prev."|".$action])) {
	$next=$map[$prev."|".$action];
	if(isset($windowid)) {
		dtmovews($windowid,$title2atom[$next]);
	}
	dtsetws($title2atom[$next]);
	if(isset($windowid)) {
		dtfocus(dtsearch($next));
		dtfocus($windowid);
	}
}
?>