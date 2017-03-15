<?php

include_once("Player.php");

class GoalKeeper extends Player
{
  private $skillsGoalKeeper;

  public function __construct($skills)
  {
    parent::__construc($skills);
    if (!$skills[skillsGoalKeeper])
      throw new Exception("Error: GoalKeeper need skillsGoalKeeper to not be empty!");
      
    $this->skillsGoalKeep=$skills[skillsGoalKeeper];
  }


  public function stop($s_player)
  {
    $probaOf100 = rand(0,10+(100-$this->skills));
  //***ecart avec l'attaquant
  $ecart = ($this->skills - $s_player->attackSkills)+2;
  if($ecart <= 0)
    $ecart = 10;

    $chanceOfStop=rand($ecart,10+$ecart)*2.5;

  if($probaOf100 == 15)
    $stop=$this->strength*$this->skills*$chanceOfStop*100;
  else
    $stop=$this->strength*$this->skills*$chanceOfStop;

  echo $chanceOfStop."\n";
  echo $stop."\n";

  return $stop;
  }
}
 ?>
