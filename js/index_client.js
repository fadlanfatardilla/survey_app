document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".btn-view-details").forEach((button) => {
    button.addEventListener("click", function () {
      const surveyId = this.getAttribute("data-id");
      fetchSurveyDetails(surveyId);
    });
  });

  document
    .getElementById("createSurveyIcon")
    .addEventListener("click", function () {
      window.location.href = "create_survey.php";
    });

  document.getElementById("logoutIcon").addEventListener("click", function () {
    Swal.fire({
      title: "Are you sure?",
      text: "You will be logged out!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, logout!",
      cancelButtonText: "No, cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "../auth/logout.php";
      }
    });
  });
});

function fetchSurveyDetails(id) {
  fetch(`view_survey.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const modalBody = document.querySelector("#surveyModal .modal-body");
        modalBody.innerHTML = `
                            <h5>${data.survey.title}</h5>
                            <p>${data.survey.description}</p>
                            <h6>Admin Answers:</h6>
                            <ul class="list-group">
                                ${
                                  data.answers.length > 0
                                    ? data.answers
                                        .map(
                                          (answer) => `
                                    <li class="list-group-item">${answer.answer}</li>
                                `
                                        )
                                        .join("")
                                    : '<li class="list-group-item">No answers from admin yet.</li>'
                                }
                            </ul>
                        `;
        const surveyModal = new bootstrap.Modal(
          document.getElementById("surveyModal")
        );
        surveyModal.show();
      } else {
        Swal.fire("Error", "Unable to fetch survey details", "error");
      }
    });
}
