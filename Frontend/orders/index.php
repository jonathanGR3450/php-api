<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.js"></script>


</head>

<body>
    <div class="container my-4">
        <div class="row text-center">
            <div class="col">
                <h1>Order Customer Number <?php echo $_GET['customerNumber'] ?? 0 ?></h1>
            </div>
        </div>

        <div class="row mt-4" id="div-order-form" >
            <div class="col-12">
                <h3>Order Form</h3>
            </div>
            <div class="col-12">
                <form id="order-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="orderDate">Order Date</label>
                            <input type="date" class="form-control" id="orderDate" name="orderDate" placeholder="Order Date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="requiredDate">Required Date</label>
                            <input type="date" class="form-control" id="requiredDate" name="requiredDate" placeholder="Required Date">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="Status">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="shippedDate">Shipped Date</label>
                            <input type="date" class="form-control" id="shippedDate" name="shippedDate" placeholder="Shipped Date">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                        </div>
                    </div>
                    <button type="submit" id="btn-customer" name="btn-customer" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row mt-4" id="div-table-orders">
            <div class="col-12">
                <table class="table table-striped" id="ordersDetailTable">
                    <thead>
                        <tr>
                            <th scope="col">Order Number</th>
                            <th scope="col">Product Code</th>
                            <th scope="col">Quantity Ordered</th>
                            <th scope="col">Price Each</th>
                            <th scope="col">Order Line Number</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <button type="button" id="btn-new-order-detail" class="btn btn-primary">New Order Detail</button>
            </div>
        </div>
        <input type="hidden" name="orderNumber" id="orderNumber" value="<?php echo $_GET['orderNumber'] ?? -1 ?>">
        <input type="hidden" name="customerNumber" id="customerNumber" value="<?php echo $_GET['customerNumber'] ?? -1 ?>">
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.css">


    <script src="../static/js/orders.js"></script>
</body>

</html>