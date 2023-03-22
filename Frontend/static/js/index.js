$(document).ready(function () {
    let url = 'http://localhost:80/';

    $('#btn-search').click(function () {
        let customerNumberSearch = $("#customerNumberSearch").val();
        if (!customerNumberSearch) {
            alert('input is empty!');
            return;
        }

        $.getJSON(url + 'customers', { customerNumber: 103 }, function (resp) {
            $("#customer-form").show();
            if (resp['data'].length > 0) {
                let result = resp['data'][0];

                Object.entries(result).forEach(function (item) {
                    var clave = item[0];
                    var valor = item[1];
                    $("#" + clave).val(valor);
                    console.log(clave + ": " + valor);
                });
            }
        });
    });

})