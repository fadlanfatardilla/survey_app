document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("loginForm");
  const loadingAnimation = document.getElementById("loadingAnimation");
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");

  togglePassword.addEventListener("click", function () {
    const type =
      password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    this.querySelector("i").classList.toggle("fa-eye");
    this.querySelector("i").classList.toggle("fa-eye-slash");
  });

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    // Show loading animation
    loadingAnimation.style.display = "flex";

    const formData = new FormData(form);

    fetch("", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        setTimeout(() => {
          // Simulate network delay
          loadingAnimation.style.display = "none";

          if (data.status === "success") {
            // Show SweetAlert2 success alert
            Swal.fire({
              icon: "success",
              title: "Login Successful",
              text: "Redirecting you to your dashboard...",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading();
              },
            }).then(() => {
              if (data.role === "admin") {
                window.location.href = "/admin/index.php";
              } else {
                window.location.href = "/client/index.php";
              }
            });
          } else {
            // Show SweetAlert2 error alert
            Swal.fire({
              icon: "error",
              title: "Login Failed",
              text: data.message || "Please check your username and password",
              confirmButtonColor: "#ffcc00",
              confirmButtonText: "Try Again",
            });
          }
        }, 2000); // Adjust delay to control animation duration
      })
      .catch((error) => {
        loadingAnimation.style.display = "none";
        console.error("Error:", error);
      });
  });
});
