$(document).ready(function () {
    $('.addDirectorBtn').click(function () {
        $('<p><input type="text" name="director[]"></p>').appendTo('.directorContainer');
    });
});
