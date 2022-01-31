$(document).ready(function (e) {
    $('#remove_from_playlist').click(function(){
        $.ajax({
            type: "GET",
            url: removeFilmUrl,
            data: {
                uuid: roomUuid,
                id: $(this).data('id'),
            },
            success: function (data) {
                $('#playlist_block').html(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});
