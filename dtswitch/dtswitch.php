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
		"One|Down"=>"Three",
		"Two|Down"=>"Four",
		"Three|Up"=>"One",
		"Four|Up"=>"Two",
		// HORIZONTAL
		"One|Right"=>"Two",
		"Three|Right"=>"Four",
		"Two|Left"=>"One",
		"Four|Left"=>"Three",
		// CONTINUOUS
		"Two|Right"=>"Three",
		"Three|Left"=>"Two",
		"Two|Up"=>"Three",
		"Three|Down"=>"Two",
	),
	6=>array(
		// VERTICAL
		"One|Down"=>"Four",
		"Two|Down"=>"Five",
		"Three|Down"=>"Six",
		"Four|Up"=>"One",
		"Five|Up"=>"Two",
		"Six|Up"=>"Three",
		// HORIZONTAL
		"One|Right"=>"Two",
		"Two|Right"=>"Three",
		"Four|Right"=>"Five",
		"Five|Right"=>"Six",
		"Six|Left"=>"Five",
		"Five|Left"=>"Four",
		"Three|Left"=>"Two",
		"Two|Left"=>"One",
		// CONTINUOUS
		"Three|Right"=>"Four",
		"Four|Left"=>"Three",
		"Four|Down"=>"Two",
		"Five|Down"=>"Three",
		"Three|Up"=>"Five",
		"Two|Up"=>"Four",
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