let utilities = {
    ajax_load: function (action) {
        var load_div = $(".ajax_load");
        if (action === "open") {
            load_div.fadeIn().css("display", "flex");
        } else {
            load_div.fadeOut();
        }
    },
    generateMessage: function (data) {
        return '<div class="alert alert-' + data.type + ' alert-dismissible fade show" role="alert">' +
            data.message +
            '</div>';
    }
};
