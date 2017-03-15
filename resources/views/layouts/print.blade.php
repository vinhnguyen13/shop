<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="invoice-title">
                <h2>Order #12345</h2>
                <hr>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        John Smith<br>
                        1234 Main<br>
                        Apt. 4B<br>
                        Springfield, ST 54321
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Shipped To:</strong><br>
                        Jane Smith<br>
                        1234 Main<br>
                        Apt. 4B<br>
                        Springfield, ST 54321
                    </address>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order placed on 01/23/2017</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                <h3 class="text-center">Order Summary</h3><hr>
                <div class="pull-left"><h4>Subtotal</h4> </div>
                <div class="pull-right"><h4 class="text-right">$11.99</h4></div>
                <div class="clearfix"></div>
                <div class="pull-left"><h4>Tax</h4> </div>
                <div class="pull-right"><h4 class="text-right">$1.99</h4></div>
                <div class="clearfix"></div>
                <div class="pull-left"><h4>Order Total</h4> </div>
                <div class="pull-right"><h4 class="text-right">$13.50</h4></div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-4 offset-md-1">
                <h3 class="text-center">Payment Type</h3><hr>
                <div class="text-center">
                    <strong>Paid by Credit Card</strong><br>
                </div>
            </div>
            <div class="col-md-4 offset-md-2">
                <h3 class="text-center">Other Info</h3><hr>
                <address>
                    <strong>Billed To:</strong><br>
                    John Smith<br>
                    1234 Main<br>
                    Apt. 4B<br>
                    Springfield, ST 54321
                </address>
            </div>
        </div>
    </div>
</div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
