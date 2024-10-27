$(document).ready(function() {
    $.ajax({
        url: 'fetch_documents.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.documents) {
                $.each(data.documents, function(index, document) {
                    $('#documentType').append(
                        $('<option></option>').val(document.type).text(document.type)
                    );
                });
            }
        },
        error: function() {
            alert('Error fetching document types.');
        }
    });

    $('#documentType').change(function() {
        const selectedDoc = $(this).val();
        $.ajax({
            url: 'fetch_documents.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#purpose').empty();
                $('#purpose').append('<option value="">Select purpose</option>');
                
                if (data.documents) {
                    const purpose = data.documents.find(doc => doc.type === selectedDoc);
                    if (purpose) {
                        $('#purpose').append(
                            $('<option></option>').val(purpose.purpose).text(purpose.purpose)
                        );
                    }
                }
            },
            error: function() {
                alert('Error fetching purposes.');
            }
        });
    });
});
