$(document).ready(function() {
    var container = $("#artist_name");
    var pageLoading = $("#page_loading");
    $("#shuffle").on('click', function(e) {
        pageLoading.show();
        container.html("&nbsp;");
        e.preventDefault();
        console.log('clicked!');
        var genre = $("#form_genre").val();
        $.ajax({
            method: "POST",
            url: "/shuffle",
            data: { genre },
            success: function(result) {
                pageLoading.hide();
                container.html(result);
                container.show();
            },
            error: function() {
                pageLoading.hide();
                container.html('No Artists Available');
                container.show();
            }
        });
    });
});