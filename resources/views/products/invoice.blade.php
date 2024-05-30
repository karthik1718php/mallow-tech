<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generate Invoice</title>
    <!-- CSS -->
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card-header bg-primary">
            <h3 class="text-white text-center">Billing Page</h3>
        </div>
        <div class="row">
            <div class="col-5 mb-3">

                <div class="form-group">
                    <strong>Customer Email:</strong> {{$invoiceData['email'] ?? ''}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3">

                <div class="form-group">
                    <strong>Bill section:</strong>
                </div>

                @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>

                            <th scope="col">Product ID</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Purchase Price</th>
                            <th scope="col">Tax % for Item</th>
                            <th scope="col">Tax payable for item</th>
                            <th scope="col">Total price of the item</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($invoiceData))

                            @foreach($invoiceData as $key => $product)
                                @if(is_int($key))
                                    <tr>
                                        <th scope="row"><input type="text" value="{{$product['productID']}}" readonly
                                                class="form-control" /></th>
                                        <td><input type="text" value="{{$product['price']}}" readonly class="form-control" /></td>
                                        <td><input type="text" value="{{$product['quantity']}}" readonly class="form-control" />
                                        </td>
                                        <td><input type="text" value="{{$product['purchased-price']}}" readonly
                                                class="form-control" /></td>
                                        <td><input type="text" value="{{$product['tax']}}" readonly class="form-control" /></td>
                                        <td><input type="text" value="{{$product['tax-payable-item']}}" readonly
                                                class="form-control" /></td>
                                        <td><input type="text" value="{{$product['total-price']}}" readonly class="form-control" />
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif

                        @php
                            $totalpricewithoutprice = array_sum(array_column($invoiceData, 'purchased-price'));
                            $taxpayable = array_sum(array_column($invoiceData, 'tax-payable-item'));
                            $totalprice = array_sum(array_column($invoiceData, 'total-price'));

                            $returnAmount = 0;
                            $paidAmountByCustomer = $invoiceData['paidAmountByCustomer'] ?? 0;
                            if ($paidAmountByCustomer >= (int) $totalprice) {
                                $returnAmount = $paidAmountByCustomer - (int) $totalprice;
                            }

                            //default denominations
                            $denominations = [500, 100, 50, 20, 10, 5, 2, 1];

                            $payableToCustomerAmount = [];

                            foreach ($denominations as $denomination) {
                                if ($returnAmount >= $denomination) {
                                    $payableToCustomerAmount[$denomination] = (int) ($returnAmount / $denomination);
                                    $returnAmount = $returnAmount % $denomination;
                                }
                            }

                        @endphp
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-end">Total price without tax : {{$totalpricewithoutprice}} </div>
        <div class="text-end">Total tax payable : {{$taxpayable}}</div>
        <div class="text-end">Net price of the purchased item : {{$totalprice}}</div>
        <div class="text-end">Customer Paid Amount : {{$paidAmountByCustomer}}</div>
        <div class="text-end">Rounded down value of the purchased items net price : {{(int) $totalprice}}</div>
        <div class="text-end">Balance payable to the customer : {{$paidAmountByCustomer - (int) $totalprice}}</div>
        <hr>
        <div class="row mb-1">
            <div class="col-4 offset-md-8 mb-2"><strong>Balance Denominations:</strong></div>

            @if(!empty($payableToCustomerAmount))
                @foreach($payableToCustomerAmount as $denomination => $payable)
                    <div class="col-4 offset-md-6 text-end"><strong>{{$denomination}} : </strong>{{$payable}}</div>
                @endforeach
            @else
                <div class="col-4 offset-md-6 text-end">0</div>
            @endif

        </div>

    </div>
</body>

</html>