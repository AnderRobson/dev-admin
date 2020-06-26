$(function () {
    $("form").submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let action = form.attr("action");
        let data = form.serialize();

        $.ajax({
            url: action,
            data: data,
            type: "post",
            dataType: "json",
            beforeSend: function (load) {
                ajax_load("open");
            },
            success: function (response) {
                ajax_load("close");

                if (response.message) {
                    var view = generateMessage(response.message);
                    $(".form_ajax").html(view);
                    $(".form_ajax").show();
                    return;
                }

                if (response.redirect) {
                    window.location.href = response.redirect.url;
                }
            }
        });
    });

    function ajax_load(action) {
        var load_div = $(".ajax_load");
        if (action === "open") {
            load_div.fadeIn().css("display", "flex");
        } else {
            load_div.fadeOut();
        }
    }

    function generateMessage(data) {
        return '<div class="alert alert-' + data.type + ' alert-dismissible fade show" role="alert">' +
                    data.message +
                '</div>';
    }
})