$('#insertForm').on('submit', function (e) {
    e.preventDefault();

    $('#loadingIcon').removeClass('d-none');
    $('#result').html('');

    var formData = new FormData(this);

    setTimeout(function () {
  $.ajax({
  type: 'POST',
  url: 'controller.php',
  data: formData,
  contentType: false,
  processData: false,
  dataType: 'json', // مهم جدًا!
  success: function (response) {
    $('#loadingIcon').addClass('d-none');

    if (response.status === 'success') {
      $('#result').html("<div class='alert alert-success'>" + response.message + "</div>");
    } else if (response.status === 'error') {
      $('#result').html("<div class='alert alert-danger'>" + response.message + "</div>");
      }
  },
  error: function () {
    $('#loadingIcon').addClass('d-none');
    $('#result').html("<div class='alert alert-danger mt-4'>تعذر الاتصال بالخادم.</div>");
  }
});
}, 2000);
  });
