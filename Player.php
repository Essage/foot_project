<?php
include_once("IPlayer.php");
class Player //implements IPlayer
{
//general
  private $name;
  private static $id;
//team player
  private $type;
  private $position;
//skills
  private $speed;
  private $skills;
  private $defenseSkills;
  private $attackSkills;
  private $strength;
  private $getTheBall;

//status
  private $onField;

//***** construct

  public function __construct($s_player="")//arrays send as parameter
  {
    $this->errorEmpty($s_player[name],"construc");//block if empty
    $this->errorEmpty($s_player[position],"construct");//block if empty
    $this->errorEmpty($s_player[type],"construct");//block if empty

    $this->name=$s_player[name];
    $this->type=$s_player[type];
    $this->position=$s_player[position];
    $this->speed = $s_player[speed];
    $this->skills = $s_player[skills];
    $this->defenseSkills = $s_player[defenseSkills];
    $this->attackSkills = $s_player[attackSkills];
    $this->strength = $s_player[strength];
    $this->onField=$s_player[onField];
    $this->getTheBall=false;


    echo $this->getName().": I am alive.\n";
  }

//***** ACTION METHOD

public function shoot($s_goalKeeper)
{

  if($this->getTheBall==false)
    return -1;

  //***** attaquant
  //clacul probabilité de tir cadré
  // ajout chance 100% marqué
  $probaOf100 = rand(0,20+(100-$this->attackSkills));
  // chance par rapport à la distance
  $distanceOfChanceNull=60;
  $distanceOfShoot=abs(($s_goalKeeper->position[X]-$this->position[X]))+abs(($s_goalKeeper->position[Y]-$this->position[Y]));
  if($distanceOfShoot>=60 || abs(($s_goalKeeper->position[Y]-$this->position[Y]))>25 )
    $chanceOFshoot=0;
  else
    $chanceOFshoot=($distanceOfChanceNull-$distanceOfShoot)/$distanceOfChanceNull;
  //calcul power of shoot
  $powerOfShoot=$this->attackSkills*$this->skills*$this->strength;
  if($probaOf100 == 12)
    $shoot=$powerOfShoot*$chanceOFshoot*100;
  else
    $shoot=$powerOfShoot*$chanceOFshoot;
  echo $this->name." shoot with the range of ".$distanceOfShoot." and power of shoot".$shoot."\n";
  echo $chanceOFshoot."\n";
  //***** Goal
  // proba arret 100%
    $probaOf100 = rand(0,10+(100-$s_goalKeeper->skills));
  //***ecart avec l'attaquant
  $ecart = ($s_goalKeeper->skills-$this->attackSkills)+2;
  if($ecart <= 0)
    $ecart =10;

    $chanceOfStop=rand($ecart,10+$ecart)*2.5;

  if($probaOf100 == 15)
    $stop=$s_goalKeeper->strength*$s_goalKeeper->skills*$chanceOfStop*100;
  else
    $stop=$s_goalKeeper->strength*$s_goalKeeper->skills*$chanceOfStop;

  echo $chanceOfStop."\n";
  echo $stop."\n";

  if ($stop>=$shoot)
  {
    echo $s_goalKeeper->getName().": stop the shoot.\n";
    $s_goalKeeper->setGetTheBall(true);
    $this->setGetTheBall(false);
    return 1;
  }else
  {
    $this->getTheBall(false);
    echo "GOALLLLLL of ".$this->getName()." !!!!\n";
    return 0;
  }


    //reduction endurance de 0.5 pour le joueur et 1 pour le goal
  $this->strength=$this->strength-0.5;
  $s_goalKeeper->strength = $s_goalKeeper->strength-1;
}

  public function passOnGround($s_player,$s_allPlayerOtherTeam)
  {
    echo "coucou";
    if($this->getTheBall==false)
      return -1;

    //probabilité passes réussi
      //en fonction de la distance
      $distance =abs(($s_player->position[X]-$this->position[X]))+abs(($s_player->position[Y]-$this->position[Y]));
      $chanceBDistance = abs($distance-30)/30;
      echo "chance -- distance ".$chanceBDistance."\n";
      //en fonction skills
      $goodPass =(100-$this->skills)/100;
      echo "chance -- goodPassnce ".$goodPass."\n";
      $goodTrap=(100 - $s_player->skills)/100;
      echo "chance -- goodTrap ".$goodTrap."\n";
      //chance of pass
      $chanceOfPass=$goodTrap+$goodPass+$chanceBDistance;
      echo "chance -- chanceOfPass ".$chanceOfPass."\n";

    // direction
      $m= ($s_player->position[Y]-$this->position[Y])/($s_player->position[X]-$this->position[X]);
      $p=$this->position[Y]-($m*$this->position[X]);
    //probalité interception
      foreach ($s_allPlayerOtherTeam as $player) {
        //var_dump($player);
        if($player->position[Y] <= ($m*$player->position[X]+$p)+5 && $player->position[Y] >= ($m*$player->position[X]+$p)-5)
        //  echo $player->name." tries to intercept the ball !!\n";
          $chanceOfIntercept=$chanceOfPass-(100-$player->skills)/100;
          //  print "chance -- chanceOfInterceptfPass ".$chanceOfIntercept."\n";

          if ($chanceOfIntercept>=0.7)
          {
            echo $player->name." interceptes the ball !!\n";
            $player->getTheBall(true);
            $this->getTheBall(false);
            //reduction endurance
            return 1;
          }else{
            //si une tentative echou la chance de la passe est reduit par la moitié d ela chance d'intercepeté.
            $chanceOfPass=$chanceOfPass-$chanceOfIntercept/2;
          }
      }

      echo $this->name."makes a pass to ".$s_player->name.", who traps the ball.\n";
      $this->setGetTheBall(false);
      $s_player->setGetTheBall(true);
      return 0;
  }

//*****Error method
  private function errorEmpty($test="",$method)
  {
    if(!$test)
    {
      throw new Exception("Error. Field empty in class Player ".$method.".");
    }

  }

//***** GETTER
  public function getName()
  {
    return $this->name;
  }
  public function getType()
  {
    return $this->type;
  }
  public function getPosition()
  {
    return $this->position;
  }
  public function getSpeed()
  {
    return $this->speed;
  }
  public function getSkills()
  {
    return $this->skills;
  }
  public function getDefenseSkills()
  {
    return $this->$defenseSkills;
  }
  public function getAttackSkills()
  {
    return $this->$attackSkills;
  }
  public function getStrength()
  {
    return $this->$strength;
  }
//******* SETTER

public function setName($s_name)
{
   $this->name = $s_name;
}
public function setType($s_type)
{
   $this->type=$s_type;
}
public function setPosition($s_position)
{
   $this->position=$s_position;
}
public function setSpeed($s_speed)
{
  $this->speed=$s_speed;
}
public function setSkills($s_skills)
{
   $this->skills=$s_skills;
}
public function setDefenseSkills($s_defenseSkills)
{
  $this->$defenseSkills=$s_defenseSkills;
}
public function setAttackSkills($s_attackSkills)
{
   $this->$attackSkills=$s_attackSkills;
}
public function setStrength($s_strength)
{
  return $this->$strength=$s_strength;
}

public function setGetTheBall($s_getTheBall)
{
  $this->getTheBall=$s_getTheBall;
}

}



 ?>
