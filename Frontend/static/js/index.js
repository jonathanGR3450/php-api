$(document).ready(function () {
    let url = 'http://localhost:80/';
    let url2 = 'http://localhost:8080/';

    // datatable orders
    let ordersTable = $('#ordersTable').DataTable({
        "processing": true,
        "serverSide": true,
        ajax: {
            url: url + "orders",
            type: 'GET',
            async: false,
            data: function (d) {
                // Obtener el valor del input de customerNumber
                d.customerNumber = $('#customerNumber').val();
            }
        },
        "columns": [
            { "data": "orderNumber" },
            { "data": "orderDate" },
            { "data": "requiredDate" },
            { "data": "shippedDate" },
            { "data": "status" },
            { "data": "comments" },
            { "data": "customerNumber" },
            { // Definir cómo se renderizará la columna "Editar"
                data: null,
                defaultContent: '<button class="btn btn-primary edit">Edit</button>'
            },
            { // Definir cómo se renderizará la columna "Eliminar"
                data: null,
                defaultContent: '<button class="btn btn-danger delete">Delete</button>'
            },
            { // Definir cómo se renderizará la columna "print"
                data: null,
                defaultContent: '<button class="btn btn-info print">Print</button>'
            }
        ]
    });

    // datatable orders
    let paymentsTable = $('#paymentsTable').DataTable({
        "processing": true,
        "serverSide": true,
        ajax: {
            url: url + "payments",
            type: 'GET',
            async: false,
            data: function (d) {
                // Obtener el valor del input de customerNumber
                d.customerNumber = $('#customerNumber').val();
            }
        },
        "columns": [
            { "data": "customerNumber" },
            { "data": "checkNumber" },
            { "data": "paymentDate" },
            { "data": "amount" },
            { "data": "orderNumber" },
            { // Definir cómo se renderizará la columna "Editar"
                data: null,
                defaultContent: '<button class="btn btn-primary edit-pay">Edit</button>'
            },
            { // Definir cómo se renderizará la columna "Eliminar"
                data: null,
                defaultContent: '<button class="btn btn-danger delete-pay">Delete</button>'
            },
            { // Definir cómo se renderizará la columna "print"
                data: null,
                defaultContent: '<button class="btn btn-info print-pay">Print</button>'
            }
        ]
    });

    // boton editar
    $('#paymentsTable tbody').on('click', 'button.print-pay', function () {
        var fila = $(this).closest('tr');
        var datos = paymentsTable.row(fila).data();
        // Lógica para editar los datos de la fila
        console.log('Editar fila', datos);
        window.open(`${url}paymentpdf/${datos.orderNumber}/${datos.checkNumber}`, '_blank');
    });

    // boton editar
    $('#ordersTable tbody').on('click', 'button.edit', function () {
        var fila = $(this).closest('tr');
        var datos = ordersTable.row(fila).data();
        // Lógica para editar los datos de la fila
        console.log('Editar fila', datos);
        let customerNumber = $("#customerNumber").val();
        location.href = `${url2}/orders/?customerNumber=${customerNumber}&orderNumber=${datos.orderNumber}`;
    });

    // boton editar
    $('#ordersTable tbody').on('click', 'button.print', function () {
        var fila = $(this).closest('tr');
        var datos = ordersTable.row(fila).data();
        // Lógica para editar los datos de la fila
        console.log('Editar fila', datos);
        window.open(`${url}orderpdf/${datos.orderNumber}`, '_blank');
        // location.href = `${url2}/orderpdf/?orderNumber=${datos.orderNumber}`;
    });

    // boton eliminar
    $('#ordersTable tbody').on('click', 'button.delete', function () {
        var fila = $(this).closest('tr');
        var datos = ordersTable.row(fila).data();
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
                    url: url + 'orders/' + datos.orderNumber,
                    type: 'DELETE',
                    async: false,
                    success: function (resp) {
                        ordersTable.ajax.reload();
                        paymentsTable.ajax.reload();
                        Swal.fire(
                            'Deleted!',
                            'Your order has been deleted.',
                            'success'
                        )
                    },
                });
            }
        })

    });
    $("#btn-new-order").on('click', function () {
        let customerNumber = $("#customerNumber").val();
        location.href = `${url2}orders/?customerNumber=${customerNumber}`;
    });


    $('#btn-search').click(function () {
        let customerNumberSearch = $("#customerNumberSearch").val();
        clearFormCustomer();
        if (!customerNumberSearch) {
            Swal.fire(
                'Error?',
                'Customer Number is Empty!',
            )
            return;
        }
        $.ajax({
            url: url + 'customers',
            type: 'GET',
            async: false,
            data: {
                customerNumber: customerNumberSearch
            },
            success: function (resp) {
                $("#div-customer-form").show();
                if (resp['data'].length > 0) {
                    let result = resp['data'][0];
                    $("#customerNumber").val(result.customerNumber);
                    console.log($("#customerNumber").val());

                    Object.entries(result).forEach(function (item) {
                        var clave = item[0];
                        var valor = item[1];
                        $("#" + clave).val(valor);
                    });
                }
            },
            complete: function (params) {
                ordersTable.ajax.reload();
                paymentsTable.ajax.reload();
            }
        });
    });

    // select
    $('#salesRepEmployeeNumber').select2({
        placeholder: 'select a employee',
        ajax: {
            url: url + 'employees',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    lastName: params.term // buscar término
                };
            },
            processResults: function (data) {
                var results = [];

                $.each(data['data'], function (index, item) {
                    results.push({
                        id: item.employeeNumber, // propiedad del objeto JSON que se utilizará como id
                        text: item.lastName + " " + item.firstName // propiedad del objeto JSON que se utilizará como texto
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
    $("#customer-form").on('submit', function (e) { //use on if jQuery 1.7+
        e.preventDefault();  //prevent form from submitting
        var data = $("#customer-form").serializeArray();
        let formData = {};
        data.forEach(element => {
            formData[element.name] = element.value;
        });

        let id = $("#customerNumber").val();
        let method = '';
        let uri = '';
        if (id < 0) {
            method = "POST";
            uri = 'customers';
        } else {
            method = "PUT";
            uri = 'customers/' + id;
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
                $("#customerNumber").val(response.data.customerNumber);

            }

        }).fail(function (msg) {
            console.log('FAIL', msg);
        });

    });

    function clearFormCustomer() {
        $('#customer-form :input').val('');
        $("#customerNumber").val(-1);
    }

})