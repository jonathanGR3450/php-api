$(document).ready(function () {
    let url = 'http://localhost:80/';
    let url2 = 'http://localhost:8080/';

    if ($("#customerNumber").val() < 1) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Not selected customer number!',
        }).then((result) => {
            window.history.go(-1);
        })
    }
    // datatable orders
    let ordersDetailTable = $('#ordersDetailTable').DataTable({
        "processing": true,
        "serverSide": true,
        ajax: {
            url: url + "ordersdetail",
            type: 'GET',
            async: false,
            data: function (d) {
                // Obtener el valor del input de orderNumber
                d.orderNumber = $('#orderNumber').val();
            }
        },
        "columns": [
            { "data": "orderNumber" },
            { "data": "productCode" },
            { "data": "quantityOrdered" },
            { "data": "priceEach" },
            { "data": "orderLineNumber" },
            { // Definir cómo se renderizará la columna "Editar"
                data: null,
                defaultContent: '<button class="btn btn-primary edit">Edit</button>'
            },
            { // Definir cómo se renderizará la columna "Eliminar"
                data: null,
                defaultContent: '<button class="btn btn-danger delete">Delete</button>'
            }
        ]
    });

    if ($("#orderNumber").val() > 0) {
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
            complete: function (params) {
                ordersDetailTable.ajax.reload();
            }
        });
    }

    // boton eliminar
    $('#ordersDetailTable tbody').on('click', 'button.delete', function () {
        var fila = $(this).closest('tr');
        var datos = ordersDetailTable.row(fila).data();
        // Lógica para editar los datos de la fila
        console.log('Editar fila', datos);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${url}ordersdetail/${datos.orderNumber}/${datos.productCode}`,
                    type: 'DELETE',
                    async: false,
                    success: function (resp) {
                        ordersDetailTable.ajax.reload();
                        Swal.fire(
                            'Deleted!',
                            'Your order detail has been deleted.',
                            'success'
                        )
                    },
                });
            }
        })

    });

    // submit event
    $("#order-form").on('submit', function (e) { //use on if jQuery 1.7+
        e.preventDefault();  //prevent form from submitting
        var data = $("#order-form").serializeArray();
        let formData = {};
        data.forEach(element => {
            formData[element.name] = element.value;
        });

        formData['customerNumber'] = $("#customerNumber").val();

        let id = $("#orderNumber").val();
        let method = '';
        let uri = '';
        if (id < 1) {
            method = "POST";
            uri = 'orders';
        } else {
            method = "PUT";
            uri = 'orders/' + id;
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
                    title: `Customer ${method == "POST" ? "create" : "update"} successfull`,
                    showConfirmButton: false,
                    timer: 1500
                })
                $("#orderNumber").val(response.data.orderNumber);

            }

        }).fail(function (msg) {
            console.log('FAIL', msg);
        });

    });

    $("#btn-new-order-detail").on('click', function () {
        let orderNumber = $("#orderNumber").val();
        location.href = `${url2}orderdetail/?orderNumber=${orderNumber}`;
    });
})