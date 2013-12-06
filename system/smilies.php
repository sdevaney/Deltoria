<?
/**************************************************************************************
* Deltoria.com                                                                        *
* (c)1999-2009 Scott Devaney, All rights reserved                                     *
* Distribution Prohibited                                                             *
**************************************************************************************/
// Emotes go here, you can add new ones to the list just follow the format
	global $PlayerData, $CoreUserData;
	function smilies ($body) {
		//return $body;

		if (preg_match("/Deltoria/",$_SERVER['REQUEST_URI'])) return $body;

                $body = preg_replace("/!bazooka!/","<IMG SRC=./images/emotes/bazooka.gif>",$body,3);
                $body = preg_replace("/!guns!/","<IMG SRC=./images/emotes/gunz.gif>",$body,3);
                $body = preg_replace("/!penguin!/","<IMG SRC=./images/emotes/penguin.gif>",$body,3);
                $body = preg_replace("/!argh!/","<IMG SRC=./images/emotes/argh.gif>",$body,3);
                $body = preg_replace("/!bang!/","<IMG SRC=./images/emotes/bang.gif>",$body,3);

                $body = preg_replace("/\^_\^/","<IMG SRC=./images/emotes/animesmile.gif>",$body,3);
                $body = preg_replace("/!blackeye!/","<IMG SRC=./images/emotes/blackeye.gif>",$body,3);
                $body = preg_replace("/!devil!/","<IMG SRC=./images/emotes/devil.gif>",$body,3);
                $body = preg_replace("/!kiss!/","<IMG SRC=./images/emotes/kiss.gif>",$body,3);
                $body = preg_replace("/!supermad!/","<IMG SRC=./images/emotes/supermad.gif>",$body,3);
                $body = preg_replace("/!dead!/","<IMG SRC=./images/emotes/dead.gif>",$body,3);
		$body = preg_replace("/!poke!/","<IMG SRC=./images/emotes/poke.gif>",$body,3);
                $body = preg_replace("/:\(/","<IMG SRC=./images/emotes/frown.gif>",$body,3);
		$body = preg_replace("/:-\(/","<IMG SRC=./images/emotes/frown.gif>",$body,3);
		$body = preg_replace("/:\)/","<IMG SRC=./images/emotes/smile.gif>",$body,3);
		$body = preg_replace("/=\)/","<IMG SRC=./images/emotes/smile.gif>",$body,3);
		$body = preg_replace("/:-\)/","<IMG SRC=./images/emotes/smile.gif>",$body,3);
		$body = preg_replace("/!smile!/","<IMG SRC=./images/emotes/smile.gif>",$body,3);
		$body = preg_replace("/!smile2!/","<IMG SRC=./images/emotes/smile2.gif>",$body,3);
		$body = preg_replace("/!smile3!/","<IMG SRC=./images/emotes/biggrin.gif>",$body,3);
		$body = preg_replace("/:-D/","<IMG SRC=./images/emotes/biggrin.gif>",$body,3);
		$body = preg_replace("/:D/","<IMG SRC=./images/emotes/biggrin.gif>",$body,3);
		$body = preg_replace("/!wink!/","<IMG SRC=./images/emotes/wink.gif>",$body,3);
		$body = preg_replace("/;\)/","<IMG SRC=./images/emotes/wink.gif>",$body,3);
		$body = preg_replace("/;-\)/","<IMG SRC=./images/emotes/wink.gif>",$body,3);
		$body = preg_replace("/!tongue!/","<IMG SRC=./images/emotes/tongue.gif>",$body,3);
		$body = preg_replace("/:p/","<IMG SRC=./images/emotes/tongue.gif>",$body,3);
		$body = preg_replace("/!mad!/","<IMG SRC=./images/emotes/mad.gif>",$body,3);
		$body = preg_replace("/!frown!/","<IMG SRC=./images/emotes/frown.gif>",$body,3);
		$body = preg_replace("/!cool!/","<IMG SRC=./images/emotes/cool.gif>",$body,3);
		$body = preg_replace("/!eek!/","<IMG SRC=./images/emotes/eek.gif>",$body,3);
		$body = preg_replace("/:o/","<IMG SRC=./images/emotes/eek.gif>",$body,3);
		$body = preg_replace("/!confused!/","<IMG SRC=./images/emotes/confused.gif>",$body,3);
		$body = preg_replace("/!whatever!/","<IMG SRC=./images/emotes/rolleyes.gif>",$body,3);

		$body = preg_replace("/!help!/","<IMG SRC=./images/emotes/smileys/help.gif>",$body,3);
		$body = preg_replace("/!eh!/","<IMG SRC=./images/emotes/smileys/eh.gif>",$body,3);
		$body = preg_replace("/!heybaby!/","<IMG SRC=./images/emotes/smileys/heybaby.gif>",$body,3);
		$body = preg_replace("/!lol!/","<IMG SRC=./images/emotes/lol.gif>",$body,3);
		$body = preg_replace("/!love!/","<IMG SRC=/images/emotes/love.gif>",$body,3);
		$body = preg_replace("/!no!/","<IMG SRC=./images/emotes/no.gif>",$body,3);
		$body = preg_replace("/!rofl!/","<IMG SRC=./images/emotes/rofl.gif>",$body,3);
		$body = preg_replace("/!shh!/","<IMG SRC=./images/emotes/shh.gif>",$body,3);
		$body = preg_replace("/!dunno!/","<IMG SRC=./images/emotes/shrug.gif>",$body,3);
		$body = preg_replace("/!sleep!/","<IMG SRC=./images/emotes/sleep.gif>",$body,3);
		$body = preg_replace("/!whip!/","<IMG SRC=./images/emotes/whip.gif>",$body,3);
		$body = preg_replace("/!yup!/","<IMG SRC=./images/emotes/yup.gif>",$body,3);
		$body = preg_replace("/!yawn!/","<IMG SRC=./images/emotes/yawn.gif>",$body,3);

		$body = preg_replace("/!blahblah!/","<IMG SRC=./images/emotes/blabla.gif>",$body,3);
		$body = preg_replace("/!crazy!/","<IMG SRC=./images/emotes/crazy.gif>",$body,3);
		$body = preg_replace("/!cry!/","<IMG SRC=./images/emotes/cry.gif>",$body,3);
		$body = preg_replace("/!doh!/","<IMG SRC=./images/emotes/doh.gif>",$body,3);
		$body = preg_replace("/!drool!/","<IMG SRC=./images/emotes/drool.gif>",$body,3);
		$body = preg_replace("/!depressed!/","<IMG SRC=./images/emotes/depressed.gif>",$body,3);
		$body = preg_replace("/!grr!/","<IMG SRC=./images/emotes/grr.gif>",$body,3);
		$body = preg_replace("/!geek!/","<IMG SRC=./images/emotes/happy_geek.gif>",$body,3);
		$body = preg_replace("/!suspicious!/","<IMG SRC=./images/emotes/suspicious.gif>",$body,3);

		$body = ereg_replace("\%color=red%","<FONT COLOR=RED>",$body);
		$body = ereg_replace("\%/color%","</FONT>",$body);
		$body = ereg_replace("\%color=green%","<FONT COLOR=GREEN>",$body);
		$body = ereg_replace("\%color=blue%","<FONT COLOR=BLUE>",$body);
		$body = ereg_replace("\%b%","<B>",$body);
		$body = ereg_replace("\%/b%","</B>",$body);
		$body = ereg_replace("\%i%","<I>",$body);
		$body = ereg_replace("\%/i%","</I>",$body);
		$body = ereg_replace("\%u%","<U>",$body);
		$body = ereg_replace("\%/u%","</U>",$body);
		return $body;

		$sth = mysql_query("select EmoteID,PicType,Keyword from HTTPGames.emotes");
		while (list ($EmoteID,$PicType,$Keyword) = mysql_fetch_row($sth)) {
			$Keyword = str_replace("|","\\|",str_replace("[","\\[",str_replace("]","\\]",str_replace("%","\\%",str_replace("!","\\!",$Keyword)))));
			// if ($PlayerData->Username == "RazM") { print "$Keyword<BR>"; }
			if ($CoreUserData[Emotes] == "N") {
				$body = preg_replace("/$Keyword/i","",$body,3);
			} else {
				$body = preg_replace("/$Keyword/i","<IMG SRC=\"./images/emotes/$EmoteID.$PicType\">",$body,3);
			}
		}


		return $body;
	}

?>