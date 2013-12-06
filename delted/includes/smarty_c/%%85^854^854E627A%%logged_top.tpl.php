<?php /* Smarty version 2.6.9, created on 2010-01-26 22:23:49
         compiled from ./includes/logged_top.tpl */ ?>
<TABLE WIDTH="100%">
	<TR><TD HEIGHT="36px" STYLE="VERTICAL-ALIGN: TOP; PADDING-TOP: 7PX; PADDING-LEFT: 3px;" BACKGROUND="images/topbar_left.gif">
		<A HREF="index.php">Home</A> | 
		<A HREF="items.php">Items</A> | 
		<A HREF="monsters.php">Monsters</A> | 
		<A HREF="map.php?X=311&Y=311&MapID=1">Map</A> | 
		<A HREF="tiles.php">Tiles</A> | 
		<A HREF="zones.php">Zones</A> | 
		<A HREF="merchant.php">Merchant</A> | 
		<A HREF="quests.php">Quests</A> | 
		<A HREF="portals.php">Portals</A> | 
		<A HREF="spawns.php">Spawns</A> | 
		<A HREF="news.php">News</A> | 
		<A HREF="spells.php">Spells</A> | 
		<A HREF="lootgroup.php">Loot Groups</A> | 
		<A HREF="merge.php">Merges</A> | 
		<A HREF="skills.php">Skills</A> |
		<A HREF="buildings.php">Clan Buildings</A> |
		<A HREF="warriors.php">Clan Warriors</A>
	</TD>
	<TD HEIGHT="36px" STYLE="VERTICAL-ALIGN: TOP; PADDING-TOP: 7PX; PADDING-LEFT: 3px; TEXT-ALIGN: RIGHT;" BACKGROUND="images/topbar_left.gif">
    <?php if ($this->_tpl_vars['userdata']['administrator'] == 'Y'): ?>
		<A HREF="admin_index.php">Administration</A>&nbsp;
	<?php endif; ?>
	</TD>
	<TD WIDTH="136px"><A HREF="http://forums.gamecater.com"><IMG BORDER=0 SRC="images/topbar_right.gif"></A></TD>
	</TR>
</TABLE>