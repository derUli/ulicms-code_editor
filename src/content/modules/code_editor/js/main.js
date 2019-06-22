$(function () {
    $("#code-form").ajaxForm({
        beforeSubmit: function () {
            $("#message").html("");
            $("#msgcontainer, #loading").show();
        },
        success: function () {
            $("#loading").hide();
            $("#message").html(
                    '<span style="color:green;">' + Translation.ChangesWasSaved + "</span>"
                    );
            $("#msgcontainer, #loading").hide();
        }
    });
});
