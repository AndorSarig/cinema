$(document).ready(function () {
    setInterval(function () {
        jQuery.ajax({
            type: "GET",
            url: "http://cinema.local/ajax/free",
            dataType: "json",
            success: function (response) {
                $.each(response, function (k, v) {
                    $("span#" + v.id).html(v.free_seats)
                });
                jQuery('.jqueryResponse').text()
            }
        })
    }, 1000)
});
