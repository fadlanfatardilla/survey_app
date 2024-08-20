$(document).ready(function () {
  $(".btn-view").on("click", function () {
    var surveyId = $(this).data("id");

    $.ajax({
      url: "view_survey.php",
      type: "GET",
      data: {
        id: surveyId,
      },
      success: function (response) {
        $("#modalBody").html(response);
        var surveyModal = new bootstrap.Modal(
          document.getElementById("surveyModal")
        );
        surveyModal.show();
      },
    });
  });
});
