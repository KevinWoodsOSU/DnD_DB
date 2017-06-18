
$(document).ready(function() {

    //Apply to all buttons with name = "display_stats"
    $('button[name="display_stats"]').click(function() {
        
        //Get dnd_character id from button id
        var id = this.id.substring(13);

        //Log the ID of the character selected
        console.log('button ' + id + ' clicked');

        //Use get ajax call to stats.php to return json of character stats assigned to id
        $.ajax({
        url: 'getStats.php?id=' + id,
        type: "GET",
        dataType: "json",
        //json is stored in response variable
        success: function (response) {
            console.log(response);

            //Clear previous content 
            $('#stats-table').empty();

            //append header rows table via thHTML 
            var thHTML = '<tr><th>Str</th>' + 
            '<th>Dex</th>' +
            '<th>Con</th>' + 
            '<th>Int</th>' +
            '<th>Wis</th>' + 
            '<th>Cha</th>' + 
            '<th>HP</th>' + 
            '<th>AC</th></tr>';

            $('#stats-table').append(thHTML);

            //append stats from dnd_character of id 
            var trHTML = '<tr><td>' + response.str + 
            '</td><td>' + response.dex + 
            '</td><td>' + response.con + 
            '</td><td>' + response.int +
            '</td><td>' + response.wis + 
            '</td><td>' + response.cha + 
            '</td><td>' + response.hp + 
            '</td><td>' + response.ac +
            '</td></tr>';

            $('#stats-table').append(trHTML);

            }
        });

        //Ajax call to display skills in table
        $.ajax({
        url: 'getSkills.php?id=' + id,
        type: "GET",
        dataType: "json",
        //json is stored in response variable
        success: function (response) {
            console.log(response);

            //Clear previous content 
            $('#skills-table').empty();

            //append header rows table via thHTML 
            var thHTML = '<tr><th>Skill</th>' + 
            '<th>Ability Modifier</th>/tr>';

            $('#skills-table').append(thHTML);

            //append stats from dnd_character of id 
            var trHTML = ''

            if (jQuery.isEmptyObject(response)) {
                trHTML += '<tr><td>' + "No skill" + 
                    '</td><td>' + "N/A" + 
                    '</td></tr>';
            } else {
                $(response.name).each(function(i) {
                    trHTML += '<tr><td>' + response.name[i] + 
                    '</td><td>' + response.ability[i] + 
                    '</td></tr>';
                });
            };      

            $('#skills-table').append(trHTML);
            
        }

        //Ajax closed
        });

        //Ajax call to display feats in table
        $.ajax({
        url: 'getFeats.php?id=' + id,
        type: "GET",
        dataType: "json",
        //json is stored in response variable
        success: function (response) {
            console.log(response);

            //Clear previous content 
            $('#feats-table').empty();

            //append header rows table via thHTML 
            var thHTML = '<tr><th>Feat</th>' + 
            '<th>Description</th>' + 
            '<th>Prerequisite</th></tr>';

            $('#feats-table').append(thHTML);

            //append stats from dnd_character of id 
            var trHTML = ''

            if (jQuery.isEmptyObject(response)) {
                trHTML += '<tr><td>' + "No feat" + 
                    '</td><td>' + "N/A" + 
                    '</td><td>' + "N/A" +
                    '</td></tr>';
            } else {
                $(response.name).each(function(i) {

                    //Change null fields to read "None"
                    if(response.prerequisite[i] == null)
                        response.prerequisite[i] = "None"; 
                    
                    trHTML += '<tr><td>' + response.name[i] + 
                    '</td><td>' + response.description[i] +
                    '</td><td>' + response.prerequisite[i] +
                    '</td></tr>';
                });
            };      

            $('#feats-table').append(trHTML);
            
        }

        //Ajax closed
        });

        //Ajax call to display weapons in table
        $.ajax({
        url: 'getWeapons.php?id=' + id,
        type: "GET",
        dataType: "json",
        //json is stored in response variable
        success: function (response) {
            console.log(response);

            //Clear previous content 
            $('#weapons-table').empty();

            //append header rows table via thHTML 
            var thHTML = '<tr><th>Weapon</th>' + 
            '<th>Damage</th>' + 
            '<th>Damage Type</th>' + 
            '<th>Weapon Type</th></tr>';

            $('#weapons-table').append(thHTML);

            //append stats from dnd_character of id 
            var trHTML = ''

            if (jQuery.isEmptyObject(response)) {
                trHTML += '<tr><td>' + "No weapon" + 
                    '</td><td>' + "N/A" + 
                    '</td><td>' + "N/A" +
                    '</td><td>' + "N/A" +
                    '</td></tr>';
            } else {
                $(response.name).each(function(i) {
                    trHTML += '<tr><td>' + response.name[i] + 
                    '</td><td>' + response.damage[i] +
                    '</td><td>' + response.damage_type[i] +
                    '</td><td>' + response.weapon_type[i] +
                    '</td></tr>';
                });
            };      

            $('#weapons-table').append(trHTML);
            
        }

        //Ajax closed
        });

    //Stats click closed    
    });
    

    //Delete character button
    $('button[name="delete_char"]').click(function() {

        //Get dnd_character id from button id
        var id = this.id.substring(11);

        //Log the ID of the character selected
        console.log('button ' + id + ' clicked');

        //Use get ajax call to deleteChar.php
        $.ajax({
        url: 'deleteChar.php?id=' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response);
            }
        });

        //Wait for .5 seconds to allow the database to update
        setTimeout (
            function() {
              window.location.reload(true);  
          }, 500);

    //Delete click closed
    });

    //Reset database button
    $('button[name="reset_database"]').click(function() {

        //Log the button click
        console.log('reset button clicked');

        //Use get ajax call to resetDatabase.php
        $.ajax({
        url: 'resetDatabase.php',
        type: "GET",
        });

        //Wait for .5 seconds to allow the database to update
        setTimeout (
            function() {
              window.location.reload(true);  
          }, 500);
        

    //Reset database click closed
    });

    //Ajax post request for filtering characters by level
    $('#char_filter').submit(function() {
        
        $.ajax({
        url: 'filterChar.php',
        type: "POST",
        dataType: { limit: $(this).limit.value}
                    
        });

        return false;
        
    //Character level filter submit button close
    });

     //Ajax post request for filtering characters by class
    $('#char_filter_class').submit(function() {
        
        $.ajax({
        url: 'filterCharClass.php',
        type: "POST",
        dataType: { class: $(this).class.value}
                    
        });

        return false;
        
    //Character class filter submit button close
    });

    //No Filter button returns to main page
    $('button[name="return"]').click(function() {
        window.location.href='http://web.engr.oregonstate.edu/~woodske/CS340/FinalProject/main.php';        

    //Close filter button     
    });

    //Ajax post request for creating new character
    $('#char_submit').submit(function() {
        
        $.ajax({
        url: 'addChar.php',
        type: "POST",
        dataType: { name: $(this).name.value,
                    race: $(this).race.value,
                    class: $(this).class.value,
                    level: $(this).level.value,
                    strength: $(this).strength.value,
                    dexterity: $(this).dexterity.value,
                    constitution: $(this).constitution.value,
                    intelligence: $(this).intelligence.value,
                    wisdom: $(this).wisdom.value,
                    charisma: $(this).charisma.value,
                    HP: $(this).hp.value,
                    AC: $(this).ac.value}
        });

        return false;
        
    //New character submit button close
    });

    //Ajax post request for updating an existing character
    $('#update_char').submit(function() {
        
        $.ajax({
        url: 'updateChar.php',
        type: "POST",
        dataType: { id: $(this).id.value,
                    level: $(this).level.value,
                    strength: $(this).strength.value,
                    dexterity: $(this).dexterity.value,
                    constitution: $(this).constitution.value,
                    intelligence: $(this).intelligence.value,
                    wisdom: $(this).wisdom.value,
                    charisma: $(this).charisma.value,
                    HP: $(this).hp.value,
                    AC: $(this).ac.value}
        });
        return false;
        
    //Update character submit button close
    });




    //Ajax post request for submitting new race
    $('#race_submit').submit(function() {
        
        $.ajax({
        url: 'addRace.php',
        type: "POST",
        dataType: {name: $(this).name.value},
        });
        return false;

    //Race submit button close
    });

    //Ajax post request for submitting new class
    $('#class_submit').submit(function() {
        
        $.ajax({
        url: 'addClass.php',
        type: "POST",
        dataType: { name: $(this).name.value}
        });
        return false;

    //Class submit button close
    });

    //Ajax post request for submitting new skill
    $('#skill_submit').submit(function() {
        
        $.ajax({
        url: 'addSkill.php',
        type: "POST",
        dataType: { name: $(this).name.value,
                    ability: $(this).ability.value}
        });
        return false;
        
    //Skill submit button close
    });

    //Ajax post request for submitting new weapon
    $('#weapon_submit').submit(function() {
        
        $.ajax({
        url: 'addWeapon.php',
        type: "POST",
        dataType: { name: $(this).name.value,
                    damage: $(this).damage.value,
                    damage_type: $(this).damage_type.value,
                    weapon_type: $(this).weapon_type.value}
        });
        return false;
        
    //Weapon submit button close
    });

    //Ajax post request for submitting new feat
    $('#feat_submit').submit(function() {

        $.ajax({
        url: 'addFeat.php',
        type: "POST",
        dataType: { name: $(this).name.value,
                    description: $(this).description.value,
                    prerequisite: $(this).prerequisite.value}
        });
        return false;
        
    //Feat submit button close
    });

    //Ajax post request for giving a character a skill
    $('#give_skill').submit(function() {

        $.ajax({
        url: 'giveSkill.php',
        type: "POST",
        dataType: { character_id: $(this).character_id.value,
                    skill_id: $(this).skill_id.value}
        });
        return false;
        
    //Skill give button close
    });

    //Ajax post request for giving a character a feat
    $('#give_feat').submit(function() {

        $.ajax({
        url: 'giveFeat.php',
        type: "POST",
        dataType: { character_id: $(this).character_id.value,
                    feat_id: $(this).feat_id.value}
        });
        return false;
        
    //Feat give button close
    });

    //Ajax post request for giving a character a weapon
    $('#give_weapon').submit(function() {

        $.ajax({
        url: 'giveWeapon.php',
        type: "POST",
        dataType: { character_id: $(this).character_id.value,
                    weapon_id: $(this).weapon_id.value}
        });
        return false;
        
    //Weapon give button close
    });

     //Ajax post request for removing a skill from a character
    $('#remove_skill').submit(function() {

        $.ajax({
        url: 'removeSkill.php',
        type: "POST",
        dataType: { character_id: $(this).character_id.value,
                    skill_id: $(this).skill_id.value}
        });
        return false;
        
    //Skill remove button close
    });

    //Ajax post request for removing a feat from a character
    $('#remove_feat').submit(function() {

        $.ajax({
        url: 'removeFeat.php',
        type: "POST",
        dataType: { character_id: $(this).character_id.value,
                    feat_id: $(this).feat_id.value}
        });
        return false;
        
    //Feat remove button close
    });

    //Ajax post request for removing a weapon from a character
    $('#remove_weapon').submit(function() {

        $.ajax({
        url: 'removeWeapon.php',
        type: "POST",
        dataType: { character_id: $(this).character_id.value,
                    weapon_id: $(this).weapon_id.value}
        });
        return false;
        
    //Weapon remove button close
    });

//Document closed    
});