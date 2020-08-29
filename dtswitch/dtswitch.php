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

function dtatom2title($arg) {
	return mypassthru("./dtatom2title ${arg}");
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
	file_put_contents("/home/sanz/cdecode/dtswitch/dtswitch.log",date("Y-m-d H:i:s").": ".$msg."\n",FILE_APPEND);
}

$buffer=dtgetallws();
$buffer=explode("\n",$buffer);
$atom2title=array();
$title2atom=array();
foreach($buffer as $key=>$val) {
	$val=explode("|",$val);
	$val=dtatom2title($val[0]);
	$val=explode("|",$val);
	$atom2title[$val[0]]=$val[2];
	$title2atom[$val[2]]=$val[0];
}
//~ print_r($atom2title);
//~ print_r($title2atom);

$buffer=dtgetcurws();
$buffer=explode("|",$buffer);
$prev=$atom2title[$buffer[0]];
//~ print_r($prev);

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

$map=array(
	// VERTICAL
	"One|Down"=>"Three",
	"Two|Down"=>"Four",
	"Three|Up"=>"One",
	"Four|Up"=>"Two",
	// VERTICAL
	"One|Right"=>"Two",
	"Three|Right"=>"Four",
	"Two|Left"=>"One",
	"Four|Left"=>"Three",
	// CONTINUOUS
	"Two|Right"=>"Three",
	"Three|Left"=>"Two",
	"Two|Up"=>"Three",
	"Three|Down"=>"Two",
);

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