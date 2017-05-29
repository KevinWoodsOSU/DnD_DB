$(document).on('click', 'button', function() {
    console.log('button ' + this.id.substring(10) + ' clicked');

    //Get dnd_character id from button id
    var id = this.id.substring(10);

    //Use get ajax call to stats.php to return json of character stats assigned to id
    $.ajax({
    url: 'stats.php?id=' + id,
    type: "GET",
    dataType: "json",
    //json is stored in response variable
    success: function (response) {
        console.log(response);
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

});