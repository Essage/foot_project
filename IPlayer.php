<?php

interface IPlayer 
{
  public function run($s_position_x,$s_position_y);
  public function runAway($s_player_other_team,$s_position_x,$s_position_y);
  public function makeAPass($s_player);
  public function tackle($s_player);
  public function shoot($s_goalKeeper);
}


 ?>
