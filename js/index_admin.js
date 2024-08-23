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

  $("#logoutIcon").on("click", function () {
    Swal.fire({
      title: "Are you sure you want to logout?",
      text: "You will be redirected to the login page.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#007bff",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, logout",
      cancelButtonText: "Cancel",
      customClass: {
        title: "swal2-title-custom",
        popup: "swal2-popup-custom",
        confirmButton: "swal2-confirm-custom",
        cancelButton: "swal2-cancel-custom",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "../auth/logout.php";
      }
    });
  });
});
