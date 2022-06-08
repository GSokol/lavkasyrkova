$(document).ready(function() {
    $('a.img-preview').fancybox({
        padding: 3
    });

    $('input[name=phone]').mask("+7(999)999-99-99");

    // Preview upload image
    $('input[type=file]').change(function () {
        var input = $(this)[0];
        var imagePreview = $(this).parents('.edit-image-preview').find('img');

        if (input.files[0].type.match('image.*')) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            imagePreview.attr('src', '/images/placeholder.jpg');
        }
    });

    // Click to delete items
    $('.glyphicon-remove-circle, .delete-button').click(function () {
        if ($(this).attr('del-data') != 'add') deleteItem($(this));
        else $(this).parents('.add-block').fadeOut();
    });

    // Click YES on delete modal
    $('.delete-yes').click(function () {
        $('#'+localStorage.getItem('delete_modal')).modal('hide');
        addLoaderScreen();

        $.post('/dashboard/'+localStorage.getItem('delete_function'), {
            '_token': $('input[name=_token]').val(),
            'id': localStorage.getItem('delete_id'),
            'row_id': localStorage.getItem('row_id'),
        }, function (data) {
            if (data.success) {
                removeLoaderScreen();
                var row = localStorage.getItem('delete_row');
                $('#'+row).remove();
            }
        });
    });

    // Click add button
    $('button.add-button').click(function () {
        $('.add-block').each(function () {
            if (!$(this).is(':visible')) {
                $(this).fadeIn();
                return false;
            }
        });
    });

    // Click to submit button on complex-form
    $('form.complex-form').submit(function () {
        removeHiddenAddBlocks();
    });

    if (window.showMessage) $('#message').modal('show');
});

function deleteItem(obj) {
    var deleteModal = $('#'+obj.attr('modal-data'));

    localStorage.clear();
    localStorage.setItem('delete_id',obj.attr('del-data'));
    localStorage.setItem('delete_function',deleteModal.find('.modal-body').attr('del-function'));
    localStorage.setItem('delete_row', (obj.parents('tr').length ? obj.parents('tr').attr('id') : obj.parents('.col-xs-12').attr('id')));
    localStorage.setItem('delete_modal',obj.attr('modal-data'));

    deleteModal.modal('show');
}

function removeHiddenAddBlocks() {
    $('.add-block:hidden').remove();
}
