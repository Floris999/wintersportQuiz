$(document).ready(function () {
  $(".answer-option").click(function () {
    $(".answer-option").removeClass("selected");

    $(this).addClass("selected");

    $(this).find('input[type="radio"]').prop("checked", true);
    $("#antwoord_index").val($(this).data("index"));
  });

  $(document).on("click", "#restart-button", function () {
    $.ajax({
      url: "",
      method: "POST",
      data: {
        action: "restart",
      },
      success: function (response) {
        location.reload();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error: " + status + error);
      },
    });
  });

  $(window).on("beforeunload", function () {
    localStorage.setItem("scrollPosition", $(window).scrollTop());
  });

  if (localStorage.getItem("scrollPosition") !== null) {
    $(window).scrollTop(localStorage.getItem("scrollPosition"));
    localStorage.removeItem("scrollPosition");
  }
});
