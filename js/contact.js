jQuery(document).ready(function ($) {
    $('.delete-button').on('click', function () {
        const Id = $(this).data('id');

        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_data',
                    nonce: ajax_object.nonce,
                    id: Id,
                },
                success: function (response) {
                    if (response.success) {
                        $(`#row-${Id}`).fadeOut(300, function () {
                            $(this).remove(); 
                        });
                        alert(response.data);
                    } else {
                        alert(response.data);
                    }
                },
                error: function () {
                    alert('An error occurred.');
                },
            });
        }
        
    });
});
