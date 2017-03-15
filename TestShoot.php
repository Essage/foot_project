<?php
include_once("Player.php");

$array_attaquant=array("name"=>"coco",
"type"=>"attaquant",
"position"=>array("X"=>32,"Y"=>8),
"speed"=>80,
"skills"=>80,
"defenseSkills"=>40,
"attackSkills"=>85,
"strength"=>80,
"onField"=>true);

$array_trapper=array("name"=>"nico",
"type"=>"middle",
"position"=>array("X"=>10,"Y"=>20),
"speed"=>70,
"skills"=>60,
"defenseSkills"=>70,
"attackSkills"=>50,
"strength"=>80,
"onField"=>true);

$array_badGuy=array("name"=>"badGuy",
"type"=>"middle",
"position"=>array("X"=>20,"Y"=>14),
"speed"=>70,
"skills"=>60,
"defenseSkills"=>70,
"attackSkills"=>50,
"strength"=>80,
"onField"=>true);

$array_goalKeeper=array("name"=>"loulou",
"type"=>"GoalKeeper",
"position"=>array("X"=>0,"Y"=>0),
"speed"=>70,
"skills"=>60,
"defenseSkills"=>70,
"attackSkills"=>30,
"strength"=>70,
"onField"=>true);


srand(time());

$coco = new Player($array_attaquant);
$nico = new Player($array_trapper);
$badguy= new Player($array_badGuy);
$lou = new Player($array_goalKeeper);
$array_team1=array($badguy);
$coco->setGetTheBall(true);
$coco->passOnGround($nico,$array_team1);
$nico->shoot($lou);




 ?>
