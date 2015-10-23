$(document).ready(function() {
    var container = $("#artist_name");
    $("#shuffle").on('click', function(e) {
        e.preventDefault();
        console.log('clicked!');
        var genre = $("#form_genre").val();
        $.ajax({
            method: "GET",
            url: "/shuffle",
            data: { genre },
            success: function(result) {
                console.log(result);
                container.html(result);
                container.show();
            }
        });
    });
});