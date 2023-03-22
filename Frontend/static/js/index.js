$( document ).ready( function() {
    let url = '';

    $('#btn-search').click(function () {
        $.get('/users.php', { userId : 1234 }, function(resp) {
            console.log(resp);
        });
    });

} )