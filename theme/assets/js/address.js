$(function () {
    $("#editAddress").submit(function (e) {
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
                utilities.ajax_load("open");
            },
            success: function (response) {
                utilities.ajax_load("close");

                if (response.message.length > 0) {
                    var view = utilities.generateMessage(response.message);
                    $(".form_ajax").html(view);
                    $(".form_ajax").show();
                }

                address.addEditAddress(true);
            }
        }).fail(function () {
            utilities.ajax_load("close");
            alert("Erro ao processar a requisição !");
        });
    });

    $("#btnEditAddress").on('click', address.editAddress)
});

let address = {
    addEditAddress: function (option = false) {
        document.getElementById("street").readOnly = option;
        document.getElementById("number").readOnly = option;
        document.getElementById("district").readOnly = option;

        if ($("#zip_code").langht > 0) {
            document.getElementById("zip_code").readOnly = option;
        }

        document.getElementById("number").readOnly = option;
        document.getElementById("city").readOnly = option;
        $("#state").attr('disabled', option);

        if (option) {
            document.getElementById("address").className = 'border-success rounded';
            $("#btnEditAddress").show();
            $("#btnSaveAddress").hide();
        } else {
            document.getElementById("address").className = 'border-danger rounded';
            $("#btnEditAddress").hide();
            $("#btnSaveAddress").show();
        }
    },
    editAddress: function () {
        address.addEditAddress(false)
    }
};