<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-4">
        <div class="row text-center">
            <div class="col">
                <h1>Make Buy Client</h1>
            </div>
        </div>
        <div class="mt-4"></div>
        <div class="row">
            <div class="col-12">
                <h3>Search User By Customer Number</h3>
            </div>
            <div class="col-12 text-center">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Search By</span>
                    </div>
                    <input id="customerNumberSearch" name="customerNumberSearch" type="number" class="form-control" placeholder="Customer Number" aria-label="Customer Number" aria-describedby="basic-addon1">
                </div>
                <button id="btn-search" type="button" class="btn btn-primary">Search</button>
            </div>
        </div>
        <div class="row mt-4" id="customer-form" style="display: none;">
            <div class="col-12">
                <h3>Customer Form</h3>
            </div>
            <div class="col-12">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="customerName">Customer Name</label>
                            <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Customer Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contactLastName">Contact LastName</label>
                            <input type="text" class="form-control" id="contactLastName" name="contactLastName" placeholder="Contact LastName">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="contactFirstName">Contact First Name</label>
                            <input type="text" class="form-control" id="contactFirstName" name="contactFirstName" placeholder="Contact First Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="addressLine1">Address Line 1</label>
                            <input type="text" class="form-control" id="addressLine1" name="addressLine1" placeholder="Address Line 1">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="addressLine2">Address Line 2</label>
                            <input type="text" class="form-control" id="addressLine2" name="addressLine2" placeholder="Address Line 2">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="City">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="State">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="postalCode">Postal Code</label>
                            <input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="Postal Code">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="salesRepEmployeeNumber">Sales RepEmployee Number</label>
                            <select id="salesRepEmployeeNumber" name="salesRepEmployeeNumber" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="creditLimit">Credit Limit</label>
                            <input type="number" class="form-control" id="creditLimit" name="creditLimit" placeholder="Credit Limit">
                        </div>
                    </div>
                    <input type="hidden" name="customerNumber" value="0">
                    <button type="submit" id="btn-customer" name="btn-customer" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="./static/js/index.js"></script>
</body>

</html>