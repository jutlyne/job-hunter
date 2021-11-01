$(document).ready(function() {
    $("#toggle-event").change(function() {
        var status = $(this).prop("checked") === true ? 1 : 0;
        $("#toggle-event").attr("value", status);
    });

    $("#submit_sos").click(function(e) {
        $.ajax({
            type: "POST",
            url: url,
            data: $("#sos_form").serialize(),
            success: function(response) {
                $("#sos_form").submit();
            },
            error: function(errors) {
                if ($(".alert-danger").length) {
                    $(".alert-danger").remove();
                }

                $(".modal-header").after(
                    '<div class="alert alert-danger"><ul></ul></div>'
                );

                $.each(errors.responseJSON.errors, function(key, value) {
                    $(".alert-danger ul").append("<li>" + value + "</li>");
                });
            }
        });
    });
});
