<?PHP
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2010 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
//Give Player XP and Skill point
function grant_xp_skill($playerdata,$skill_id,$xp = 0) {
	if (intval($skill_id) == 0) return false;
	if (intval($xp) == 0) return true;

	$sth = SQL_QUERY("select * from race_data where race_id='".$playerdata['race_id']."' and class_id='".$playerdata['class_id']."' and skill_id='".$skill_id."' limit 1");
	print mysql_error();
	if (mysql_num_rows($sth) == 0) return false;

	$data = mysql_fetch_array($sth);
	$xp = $xp + $data['xp_success'];

	SQL_QUERY("update user_skills set xp=xp+'".$xp."' where player_id=".$playerdata['player_id']." and skill_id=".$skill_id);
	return true;
}

//Drop item
function spawn_item($item_id,$x,$y,$zone_id,$player_id = 0) {
	$sth = mysql_query("select * from items_base where item_id='".$item_id."'");
	if (mysql_num_rows($sth) == 0) return false;
	$data = mysql_fetch_array($sth);

	if ($data['defined'] == "Y") {
		$al = $data['defined_al'];
		$damage_mod = $data['defined_damagemod'];
		$attack_bonus = $data['defined_attackbonus'];
		$melee_bonus = $data['defined_meleebonus'];
		$value = $data['defined_value'];
		$min_dam = $data['defined_mindam'];
		$max_dam = $data['defined_maxdam'];
		$skill_req = $data['skill_req'];
	} else {
		$al = rand(ceil($data['max_al'] * .5),$data['max_al']);
		$min_dam = ceil($data['defined_mindam'] * .5);
		$max_dam = rand($min_dam,$data['defined_maxdam']);
		$value = $data['defined_value'];
		$melee_bonus = 0;
		$attack_bonus = 0;
		$damage_mod = 0;
		$skill_req = 0;
	}

	if ($player_id > 0) {
		$sth = SQL_QUERY("select i.object_id from items as i left join items_base as ib on ib.item_id=i.item_id where player_id=".$player_id." and ib.stackable='Y' and ib.item_id={$item_id}");
	} else {
		$sth = SQL_QUERY("select i.object_id from items as i left join items_base as ib on ib.item_id=i.item_id where i.x=$x and i.y=$y and i.zone_id=$zone_id and player_id=0 and ib.stackable='Y' and ib.item_id={$item_id}");
	}
	if (mysql_num_rows($sth) == 0) {
		SQL_QUERY("insert into items (item_id,item_stack,al,damage_mod,attack_bonus,melee_bonus,min_dam,max_dam,skill_req,value,decay_time,x,y,zone_id,player_id,equiped,banked) values ('{$item_id}','1','{$al}','{$damage_mod}','{$attack_bonus}','{$melee_bonus}','{$min_dam}','{$max_dam}','{$skill_req}','{$value}',DATE_ADD(NOW(),INTERVAL 10 MINUTE),'{$x}','{$y}','{$zone_id}','".$player_id."','N','N')");
		$obj_id = SQL_INSERT_ID();
		return $obj_id;
	} else {
		list($obj_id) = mysql_fetch_row($sth);
		SQL_QUERY("update items set item_stack=item_stack+1 where object_id={$obj_id}");
		print mysql_error();
		return $obj_id;
	}

}

//Make clan seed
function make_seed() {
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}
//Enable battle
function touch_battle($battle_id) {
	mysql_query("update battle_info set action_date=NOW() where battle_id=".$battle_id);
}
//Display Chat
function get_chat($lines = 6) {
	global $playerdata;
	if ($_POST['chatter']) write_chat($_POST['chatter']);
	$sql =  "
		select
		C.target_id,
		C.player_id,
		U.player_name,
		C.message,
		C.clan_id,
		DATE_FORMAT(ts,'%h:%i %p') as msg_date,
		T.player_name as target_name
		from
		chatter as C
		left join
		users as U on U.player_id=C.player_id
		left join
		users as T on T.player_id=C.target_id
		where
		(C.clan_id='0' or C.clan_id='".$playerdata['clan_id']."') and
		(C.target_id=0 or C.target_id=".$playerdata['player_id']." or C.player_id=".$playerdata['player_id'].")
		order by C.ts DESC limit $lines
	";
	$sth = mysql_query($sql);
	print mysql_error();
	$chat_messages = array();
	for ($i = mysql_num_rows($sth) - 1; $i >= 0; $i--) {
		if (!mysql_data_seek($sth, $i)) continue;
		if (!$data = mysql_fetch_array($sth)) continue;
		$data['message'] = str_replace("\\","",$data['message']);
		$chatline = array();
		$chatline['chat_to_user'] = $data['target_name'];
		$chatline['chat_date'] = $data['msg_date'];
		$chatline['chat_from'] = $data['player_name'];
		$chatline['chat_from_player_id'] = $data['player_id'];
		$chatline['chat_to_player_id'] = $data['target_id'];
		$chatline['chat_to_clan_id'] = $data['clan_id'];
		$chatline['chat_message'] = $data['message'];

		if ($chatline['chat_to_player_id'] != "0") { $chatline['chat_to'] = "Private"; } elseif ($chatline['chat_to_clan_id'] != "0") { $chatline['chat_to'] = "Clan";   } else { $chatline['chat_to'] = "Public"; }
		$chatline['chat_message'] = wordwrap($chatline['chat_message'],60," ",1);
		if (stristr($chatline['chat_message'],"/me")) {
			$chatline['action'] = "Y";
			$chatline['chat_message'] = ereg_replace("/me","",$chatline['chat_message']);
		}
		array_push($chat_messages,$chatline);
	}
	return $chat_messages;
}



//Send Chat
function write_chat($Chatter) {
	global $playerdata;

	if ($Chatter != "" and strlen($Chatter) <= 255) {
		$Chatter = ereg_replace("<","&lt;",$Chatter);
		$Chatter = addslashes($Chatter);
		$Chatter = ereg_replace(">","&gt;",$Chatter);
		if (preg_match("/^\/msg (.+?),\s?(.+)/i",$Chatter,$Matches) == 1) {
			$sth = mysql_query("select player_id from users where player_name=\"$Matches[1]\"");
			print mysql_error();
			list ($TargetID) = mysql_fetch_row($sth);
			if ($TargetID == "") { $TargetID = 0; $Chatter = "";} else { $Chatter = $Matches[2]; }
		} else $TargetID = 0;
		if ($TargetID < 1) {
			if (preg_match("/^\/tell (.+?),\s?(.+)/i",$Chatter,$Matches) == 1) {
				$sth = mysql_query("select player_id from users where player_name=\"$Matches[1]\"");
				print mysql_error();
				list ($TargetID) = mysql_fetch_row($sth);
				if ($TargetID == "") { $TargetID = 0; $Chatter = "";} else { $Chatter = $Matches[2]; }
			} else $TargetID = 0;
		}

		if ($TargetID > 0 && $TargetID != $playerdata['last_tell']) {
			$sth = mysql_query("update users set last_tell=$TargetID where player_id=".$playerdata['player_id']);
			print mysql_error();
		}

		if (preg_match("/^\/clan (.+)/i",$Chatter,$Matches) == 1) {
			$ChatClan = $playerdata['clan_id'];
			$Chatter = $Matches[1];
		} elseif (preg_match("/^\/c (.+)/i",$Chatter,$Matches) == 1) {
			$ChatClan = $playerdata['clan_id'];
			$Chatter = $Matches[1];
		} else $ChatClan = "0";

		if (preg_match("/^\/reply (.+)/i",$Chatter,$Matches) == 1) {
			$sth = mysql_query("select player_id from chatter where target_id=".$kuser['player_id']." order by ts DESC limit 1");
			if (mysql_num_rows($sth) == 1) {
				list($TargetID) = mysql_fetch_row($sth);
			}
			$Chatter = $Matches[1];
		}

		if (preg_match("/^\/r (.+)/i",$Chatter,$Matches) == 1) {
			$TargetID = $playerdata['last_tell'];
			$Chatter = $Matches[1];
		} elseif (preg_match("/^\/retell (.+)/i",$Chatter,$Matches) == 1) {
			$TargetID = $playerdata['last_tell'];
			$Chatter = $Matches[1];
		}

		if ($Chatter != "") {
			$sth = mysql_query("select message from chatter where player_id='".$playerdata['player_id']."' order by ts DESC limit 1");
			if (mysql_num_rows($sth) > 0) {
				list($Message) = mysql_fetch_row($sth);
				if ($Message != $Chatter) {
					if (stristr($Chatter,"/sysmsg")) {
						$Chatter = ereg_replace("/sysmsg","",$Chatter);
						$sth = mysql_query("insert into chatter (target_id,player_id,message,ts) values (0,0,\"$Chatter\",now())");
						print mysql_error();
					} else {
						$sth = mysql_query("insert into chatter (target_id,player_id,message,clan_id,ts) values ($TargetID,'".$playerdata['player_id']."',\"$Chatter\",\"$ChatClan\",NOW())");
						print mysql_error();
					}
				}
			} else {
				$sth = mysql_query("insert into chatter (target_id,player_id,message,clan_id,ts) values ($TargetID,'".$playerdata['player_id']."',\"$Chatter\",\"$ChatClan\",NOW())");
				print mysql_error();
			}
		}
	}
	header("Location: ".$_SERVER['SCRIPT_NAME']);
	exit;
}

//Check to see if player has required skill
function skill_check ($Skill, $SkillReq) {
	if ($SkillReq == 0) { $SkillReq = 1; }
	$SkillDiff = ($Skill / $SkillReq) * 100 - 100;
	mt_srand(make_seed());
	$Perc = rand(-100,100);
	if ($SkillDiff > $Perc) { return true; } else { return false; }
}
//Detect hostel target
function detect_hostile($x,$y,$zone_id) {
	global $playerdata;
	$sth = mysql_query("select m.monster_id,mb.monster_name from monster as m left join monster_base as mb on mb.monster_id=m.monster_id where m.x=$x and m.y=$y and m.zone_id=$zone_id and mb.hostile='Y' and m.health_cur > 0");
	if (mysql_num_rows($sth) >= 1) {
		$mon = mysql_fetch_array($sth);
		$sth = mysql_query("select * from battle_info where x=$x and y=$y and zone_id=$zone_id");
		if (mysql_num_rows($sth) == 0) {
			mysql_query("insert into battle_info (x,y,zone_id,battle_text) values ($x,$y,$zone_id,'".$playerdata['player_name']." was startled by ".$mon['monster_name']."!')");
			print mysql_error();
		}
		return true;
	} else {
		return false;
	}
}
//Generate attack
function gen_attack ($x,$y,$zone_id,$danger) {
	global $playerdata;

	if (detect_hostile($x,$y,$zone_id)) return true;

	if (rand(1,100) < $danger) {
		$sth = mysql_query("select * from monster where x=$x and y=$y and zone_id=$zone_id and health_cur > 0");
		print mysql_error();
		if (mysql_num_rows($sth) == 0) {
			// We need to clear out any battle_info from previous battles that haven't been cleaned up yet.
			mysql_query("delete from battle_info where x=$x and y=$y and zone_id=$zone_id");
	
			$sth = mysql_query("select sp.max_spawn,m.spawn_id,abs(x-$x)+abs(y-$y) as distance from map as m left join spawns as sp on sp.spawn_id=m.spawn_id where abs(x-$x)+abs(y-$y) and zone_id=$zone_id and m.spawn_id > 0 and hostile = 'Y' order by distance limit 1");
			print mysql_error();
			if (mysql_num_rows($sth) > 0) {
				list($max_spawn,$spawn_id,$distance) = mysql_fetch_row($sth);
				for ($CurMon = 0; $CurMon < rand(1,$MaxSpawn); $CurMon++) {
					$sth_mon = mysql_query("select m.monster_id,m.health,m.monster_name from monster_spawns as ms left join monster_base as m on m.monster_id=ms.monster_id where m.hostile='Y' and ms.spawn_id=$spawn_id order by rand() limit 1");
					print mysql_error();
					if (mysql_num_rows($sth_mon) > 0) {
						list($MonsterID,$BaseHealth,$MonName) = mysql_fetch_row($sth_mon);

						mysql_query("insert into monster (monster_id,health_cur,x,y,zone_id,spawn_time,decay_time,create_date) values ($MonsterID,$BaseHealth,$x,$y,$zone_id,NOW(),NOW(),NOW())");
						print mysql_error();

						mysql_query("insert into battle_info (x,y,zone_id,battle_text) values ($x,$y,$zone_id,'".$playerdata['player_name']." was startled by ".$MonName."!')");
						print mysql_error();
						return true;
					}
				}
			}
		}
	}
	return false;
}


//Remove old battle
function sanitize($text) {
	$text = str_replace(">","&gt;",$text);
	$text = str_replace("<","&lt;",$text);
	return $text;
}
//Get user id
function get_user($user_id) {
	$sql = "
		select
			u.*,
			IF (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(last_accessed) <= 900,'Y','N') as logged_in
		from 
			users_base as u
		where
			user_id='".$user_id."' limit 1
	";
	$sth = mysql_query($sql);
	print mysql_error();
	if (mysql_num_rows($sth) == 0) return;
	if (mysql_num_rows($sth) == 1) $user = mysql_fetch_array($sth);

	return $user;
}
//Get player ID
function get_player($player_id) {
	global $gamedata;

	$sql = "select t.image as tile_image,u.*,r.race_name,c.class_name from users as u left join tiles as t on t.tile_id=u.tile_id left join classes as c on c.class_id=u.class_id left join races as r on r.race_id=u.race_id where u.player_id='".$player_id."' limit 1";
	$sth = mysql_query($sql);
	print mysql_error();
	if (mysql_num_rows($sth) == 0) return;
	if (mysql_num_rows($sth) == 1) $user = mysql_fetch_array($sth);

	/* Load Skills */
	$sth = mysql_query("select *,IFNULL((select max(level) from skill_curve where xp between 0 and us.xp order by level limit 1),1) as skill_level from user_skills as us where us.player_id=".$player_id);
	$skills = array();
	while ($data = mysql_fetch_assoc($sth)) {
		$skills[] = $data;
	}
	$user['skills'] = $skills;

	/* Load Armor */
	$sql = "select avg(if(ib.defined='Y',ib.defined_al,i.al)) as al from items as i left join items_base as ib on ib.item_id=i.item_id where i.equiped='Y' and ib.item_type='Armor' and i.player_id=".$player_id;
	$sth = mysql_query($sql);
	list($al) = mysql_fetch_row($sth);
	if (intval($al) == 0) $al = 1;
	$al = ceil($al);
	$user['al'] = $al;

	/* Load Weapon */
	$sth = mysql_query("select if(ib.defined='Y',ib.defined_damagemod,i.damage_mod) as damage_mod,if(ib.defined='Y',ib.defined_attackbonus,i.attack_bonus) as attack_bonus,if(ib.defined='Y',ib.defined_meleebonus,i.min_dam) as melee_bonus,if(ib.defined='Y',ib.defined_mindam,i.min_dam) as min_dam,if(ib.defined='Y',ib.defined_maxdam,i.max_dam) as max_dam, ib.skill_id as skill_id from items as i left join items_base as ib on ib.item_id=i.item_id where i.equiped='Y' and ib.item_type='Weapon' and i.player_id=".$player_id);
	print mysql_error();
	if (mysql_num_rows($sth) == 1) {
		$wea = mysql_fetch_array($sth);
	} else {
		$wea = array('damage_mod' => 0, 'attack_bonus' => 0, 'melee_bonus' => 0, 'min_dam' => 1, 'max_dam' => 5, 'skill_id' => $gamedata['attack_skill_id']);
	}
	$user['weapon'] = $wea;

	/* Set weapon / armor skill levels */
	while (list($k,$v) = each($user['skills'])) {
		if ($v['skill_id'] == $user['weapon']['skill_id']) {
			$user['weapon_skill'] = $v['skill_level'];
			$user['weapon_skill_id'] = $v['skill_id'];
		}

		if ($v['skill_id'] == $gamedata['defence_skill_id']) {
			$user['defence_skill'] = $v['skill_level'];
			$user['defence_skill_id'] = $v['skill_id'];
		}
	}
	reset($user['skills']);
	if (intval($user['weapon_skill']) == 0) $user['weapon_skill'] = 1;
	if (intval($user['defence_skill']) == 0) $user['defence_skill'] = 1;
	
	return $user;
}
//Go if player has skill
function has_skill($player,$skill_id) {
	while (list($k,$v) = each($player['skills'])) {
		if ($v['skill_id'] == $skill_id) return true;
	}
	return false;
}
//Skill levels not implimented yet
function skill_level($player,$skill_id) {
	while (list($k,$v) = each($player['skills'])) {
		if ($v['skill_id'] == $skill_id) return $v['skill_level'];
	}
	return false;
}

//Get monster info
function get_monster($spawn_id) {
	global $gamedata;
	$sth = mysql_query("select *,mb.armor_level as al,(select xp from skill_curve where level=mb.weapon_skill limit 1) as weapon_skill_xp,(select xp from skill_curve where level=mb.melee_defence limit 1) as melee_defence_xp,mb.monster_name as player_name,m.spawn_id as player_id,m.x,m.y,m.zone_id,m.health_cur,mb.health as health_max from monster as m left join monster_base as mb on mb.monster_id=m.monster_id where m.spawn_id=".$spawn_id);
	print mysql_error();
	if (mysql_num_rows($sth) == 0) return 0;
	$data = mysql_fetch_assoc($sth);

	$data['weapon'] = array('skill_id' => $gamedata['attack_skill_id'], 'damage_mod' => 0, 'attack_bonux' => 0, 'melee_bonus' => 0, 'min_dam' => $data['weapon_min'], 'max_dam' => $data['weapon_max'], 'skill' => $gamedata['attack_skill_id']);
	$data['skills'] = array();
	$data['skills'][] = array('skill_id' => $gamedata['attack_skill_id'],'xp' => $data['weapon_skill_xp'],'skill_level' => $data['weapon_skill']);
	$data['skills'][] = array('skill_id' => $gamedata['defence_skill_id'],'xp' => $data['melee_defence_xp'],'skill_level' => $data['melee_defence']);
	$data['weapon_skill'] = $data['weapon_skill'];
	$data['defence_skill'] = $data['melee_defence'];
	return $data;
}








//Save edits
function editor_save($sections, $table, $column, $value, $refresh = 1) {
    $columns = array();
  
    if ($value == "new" || $value == "0") {
        foreach ($sections as $data) {
            if ($data == "NEW" || $data['NEW'] != "") continue(0);
            if ($data['edtype'] == "CHECKBOX" && $_POST[$data['db_column']] == "" ){
                $_POST[$data['db_column']] = "N";
            }
            $keys .= ",".$data['db_column'];
            $values .= ",'".$_POST[$data['db_column']]."'";
        }
        $keys = preg_replace("/^,/","",$keys);
        $values = preg_replace("/^,/","",$values);

        reset($columns);

        $sql = "insert into ".$table." (".$keys.") values (".$values.")";
        SQL_QUERY($sql);
		$id = SQL_INSERT_ID();

		if ($refresh) {
			header("location: ".$_SERVER['SCRIPT_NAME']."?".$column."=".$id);
			exit;
		}
        print mysql_error();
		return($id);
    } else {
        foreach ($sections as $data) {
            if ($data == "NEW" || $data['NEW'] != "") continue(0);
            if ($data['edtype'] == "CHECKBOX" && $_POST[$data['db_column']] == "" ){
                $_POST[$data['db_column']] = "N";
            }
            $columns[] = array("key" => $data['db_column'], "value" => $_POST[$data['db_column']]);
        }
        reset($columns);

        $sql = "update ".$table." set ";
        foreach ($columns as $data) {
            $sql .= $data['key']."='".$data['value']."', ";
        }
        $sql = preg_replace("/, $/"," ",$sql);
        $sql .= "where ".$column."='".$value."'";
        SQL_QUERY($sql);
		return ($value);
    }
}
//Cannot save errors
function manytomany_save($selected, $cor_table, $parent_fk, $child_fk, $current) {
    $selected = explode(",",$selected);

    $sql = "delete from ".$cor_table." where ".$parent_fk."=".$current;
    SQL_QUERY($sql);

    foreach ($selected as $data) {
        $sql = "insert into ".$cor_table." (".$parent_fk.",".$child_fk.") values ('".$current."','".$data."')";
        SQL_QUERY($sql);
    }
}