INSERT INTO dnd_race
	(name) VALUES
		("Dwarf"), ("Elf"), ("Halfling"), ("Human"), ("Dragonborn"), 
		("Gnome"), ("Half-Elf"), ("Half-Orc"), ("Tiefling");

INSERT INTO dnd_class
	(name) VALUES
		("Barbarian"), ("Bard"), ("Cleric"), ("Druid"), ("Fighter"), 
		("Monk"), ("Paladin"), ("Ranger"), ("Rogue"), ("Sorcerer"),
		("Warlock"), ("Wizard");
		
INSERT INTO dnd_character 
	(name, race, class, level, strength, dexterity, constitution, intelligence, 
	wisdom, charisma, HP, ac) VALUES
		("Colin", 9, 8, 5, 14, 12, 12, 12, 12, 12, 24, 17),
		("Nick", 7, 11, 3, 10, 14, 12, 12, 14, 11, 22, 19),
		("Mike", 6, 2, 13, 8, 15, 12, 14, 10, 13, 30, 23),
		("Rauf", 5, 1, 17, 15, 14, 14, 10, 10, 8, 35, 25),
		("Indy", 4, 4, 1, 8, 15, 8, 15, 8, 15, 13, 10),
		("Autumn", 8, 3, 8, 14, 10, 13, 10, 12, 14, 25, 15),
		("Gil", 1, 1, 3, 15, 8, 15, 8, 8, 15, 749, 2),
		("Daniela", 2, 10, 6, 12, 10, 12, 12, 14, 13, 24, 18);

INSERT INTO dnd_skill
	(name, ability) VALUES
		("Acrobatics", "dexterity"),
		("Arcana", "intelligence"),
		("Athletics","strength"),
		("Bluff", "charisma"),
		("Diplomacy", "charisma"),
		("Dungeoneering", "wisdom"),
		("Endurance", "constitution"),
		("Heal", "wisdom"),
		("History", "intelligence"),
		("Insight", "wisdom"),
		("Intimidate", "charisma"),
		("Nature", "wisdom"),
		("Perception", "widsom"),
		("Religion", "intelligence"),
		("Stealth", "dexterity"),
		("Streetwise", "charisma"),
		("Thievery", "dexterity");
		
INSERT INTO dnd_character_skill
	(character_id, skill_id) VALUES
		(1, 6), (1, 16), (1, 7), (2, 2), (2, 13), (2, 14), (3, 11), (3, 4), (3, 17), (5, 15), (5, 17),
		(5, 1), (4, 11), (4, 3), (4, 7), (4, 9), (4, 16), (6, 2), (6, 8), (6, 10), (6, 12), (6, 6),
		(7, 7), (7, 11), (7, 5), (7, 3), (8, 14), (8, 13), (8, 12); 	


INSERT INTO dnd_feat
	(name, description, prerequisite) VALUES
		("Acrobatic", "You get a +2 bonus on all Jump checks and Tumble checks.", NULL),
		("Animal Affinity", "You get a +2 bonus on all Handle Animal checks and Ride checks.", NULL),
		("Athletic", "You get a +2 bonus on all Climb checks and Swim checks.", NULL),
		("Combat Reflexes", "You may make a number of additional attacks of opportunity equal to your Dexterity bonus. With this feat, you may also make attacks of opportunity while flat-footed.", NULL),
		("Dodge", "During your action, you designate an opponent and receive a +1 dodge bonus to Armor Class against attacks from that opponent. You can select a new opponent on any action. A condition that makes you lose your Dexterity bonus to Armor Class (if any) also makes you lose dodge bonuses. Also, dodge bonuses stack with each other, unlike most other types of bonuses.", NULL),
		("Iron Will", "You get a +2 bonus on all Will saving throws.", NULL),
		("Mounted Combat", "Once per round when your mount is hit in combat, you may attempt a Ride check (as a reaction) to negate the hit. The hit is negated if your Ride check result is greater than the opponent’s attack roll. (Essentially, the Ride check result becomes the mount’s Armor Class if it’s higher than the mount’s regular AC.)","Ride 1 rank."),
		("Power Attack", "On your action, before making attack rolls for a round, you may choose to subtract a number from all melee attack rolls and add the same number to all melee damage rolls. This number may not exceed your base attack bonus. The penalty on attacks and bonus on damage apply until your next turn.", "Str 13"),
		("Quick Draw", "You can draw a weapon as a free action instead of as a move action. You can draw a hidden weapon (see the Sleight of Hand skill) as a move action. A character who has selected this feat may throw weapons at his full normal rate of attacks (much like a character with a bow).", "Base attack bonus +1"),
		("Run", "When running, you move five times your normal speed (if wearing medium, light, or no armor and carrying no more than a medium load) or four times your speed (if wearing heavy armor or carrying a heavy load). If you make a jump after a running start (see the Jump skill description), you gain a +4 bonus on your Jump check. While running, you retain your Dexterity bonus to AC.", NULL),
		("Toughness", "You gain +3 hit points.", NULL),
		("Kip Up", "You can get up from prone as a free action that do not provoke an attack of opportunity.", "Balance 4 Ranks");

INSERT INTO dnd_character_feat
	(character_id, feat_id) VALUES
		(1, 4), (2, 6), (3, 12), (4, 8), (5, 7), (6, 3), (7, 11), (8, 2); 
		
INSERT INTO dnd_weapon
	(name, damage, damage_type, weapon_type) VALUES
		("Club", "1d4", "bludgeoning", "melee"),
		("Dagger", "1d4", "piercing", "melee"),
		("Mace", "1d6", "bludgeoning", "melee"),
		("Sickle", "1d4", "slashing", "melee"),
		("Crossbow, light", "1d8", "piercing", "ranged"),
		("Shortbow", "1d6", "piercing", "ranged"),
		("Sling", "1d4", "bludgeoning", "ranged"),
		("Battlexe", "1d8", "slashing", "melee"),
		("Flail", "1d8", "bludgeoning", "melee"),
		("Rapier", "1d8", "piercing", "melee"),
		("Whip", "1d4", "slashing", "melee"),
		("Crossbow, heavy", "1d10", "piercing", "ranged"),
		("Longbow", "1d8", "piercing", "ranged");
		
INSERT INTO dnd_character_weapon
	(character_id, weapon_id) VALUES
		(1, 10), (2, 9), (3, 7), (4, 8), (5, 11), (6, 13), (7, 1), (8, 4); 
		
		