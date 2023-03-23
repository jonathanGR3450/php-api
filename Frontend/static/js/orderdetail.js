$(document).ready(function () {
    let url = 'http://localhost:80/';
    let url2 = 'http://localhost:8080/';

    if ($("#orderNumber").val() > 0 && $("#productCode").val() > 0 ) {
        let orderNumber = $("#orderNumber").val();
        $.ajax({
            url: url + 'orders',
            type: 'GET',
            async: false,
            data: {
                orderNumber: orderNumber
            },
            success: function (resp) {
                console.log(resp);
                if (resp['data'].length > 0) {
                    let result = resp['data'][0];
                    $("#customerNumber").val(result.customerNumber);

                    Object.entries(result).forEach(function (item) {
                        var clave = item[0];
                        var valor = item[1];
                        $("#" + clave).val(valor);
                    });
                }
            },
        });
    }

    // select
    $('#productCode').select2({
        placeholder: 'select a product code',
        ajax: {
            url: url + 'products',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    productName: params.term // buscar término
                };
            },
            processResults: function (data) {
                var results = [];

                $.each(data['data'], function (index, item) {
                    results.push({
                        id: item.productCode, // propiedad del objeto JSON que se utilizará como id
                        text: item.productName // propiedad del objeto JSON que se utilizará como texto
                    });
                });

                return {
                    results: results
                };
            },
            cache: true
        }
    });

    // submit event
    $("#order-form-detail").on('submit', function (e) { //use on if jQuery 1.7+
        e.preventDefault();  //prevent form from submitting
        var data = $("#order-form-detail").serializeArray();
        let formData = {};
        data.forEach(element => {
            formData[element.name] = element.value;
        });

        formData['orderNumber'] = $("#orderNumber").val();


        let id = $("#orderNumber").val();
        let productCode = $("#productCodeId").val();
        console.log(productCode);
        let method = '';
        let uri = '';
        if (productCode < 1) {
            method = "POST";
            uri = 'ordersdetail';
        } else {
            method = "PUT";
            uri = `ordersdetail/${id}/${productCode}`;
        }

        $.ajax({
            type: method,
            url: url + uri,
            contentType: 'application/json',
            data: JSON.stringify(formData), // access in body
        }).done(function (response) {
            if (response.status == "success") {

                Swal.fire({
                    icon: 'success',
                    title: `order detail ${method == "POST" ? "create" : "update"} successfull`,
                    showConfirmButton: false,
                    timer: 1500
                })
                $("#orderNumber").val(response.data.orderNumber);
                $("#productCodeId").val(response.data.productCode);

            }

        }).fail(function (msg) {
            console.log('FAIL', msg);
        });

    });

    $("#quantityOrdered").keyup(calculate);
    $("#priceEach").keyup(calculate);

    function calculate() {
        let quantityOrdered = $("#quantityOrdered").val() || 0;
        let priceEach = $("#priceEach").val() || 0;
        let total = quantityOrdered*priceEach;
        $('#total').text(total.toFixed(2));
    }
})