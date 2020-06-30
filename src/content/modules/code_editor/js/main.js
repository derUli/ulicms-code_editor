$(function () {
    $("#code-form").ajaxForm({
        beforeSubmit: function () {
            $("#message").html("");
            $("#loading").show();
        },
        success: function () {
            $("#loading").hide();
            $("#message").html(
                    '<span style="color:green;">' + Translation.ChangesWasSaved + "</span>"
                    );
            $("#loading").hide();
        }
    });
});
