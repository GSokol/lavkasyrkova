function showMessage(message) {
    var modal = $('#message');
    modal.find('h3').html(message);
    modal.modal('show');
}