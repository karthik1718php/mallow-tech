<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Billing</title>
    <!-- CSS -->
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        .container {
            max-width: 900px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card-header bg-primary">
            <h3 class="text-white text-center">Billing Page</h3>
        </div>
        <form action="{{ route('invoice') }}" method="POST">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @session('error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $value }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession

            <div class="row">
                <div class="col-10 mb-2 mt-1">
                    <div class="form-group">
                        <strong>Email<span style="color:red">*</span></strong>
                        <input type="text" required name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-10 mb-1">
                    <table class="table table-bordered" id="addRemove">
                        <tr>
                            <th>ProductID<span style="color:red">*</span></th>
                            <th>Quantity<span style="color:red">*</span></th>
                            <th>Action</th>
                        </tr>
                        <tr class="product product-0" data-row="0">
                            <td><input type="text" name="addMoreProduct[0][productID]" required
                                    placeholder="Enter ProductID" class="form-control pid-0" />
                            </td>
                            <td><input type="number" name="addMoreProduct[0][quantity]" required
                                    placeholder="Enter quantity" min="0" class="form-control qty-0" /><span
                                    class="error-0" style="color:red"></span>
                            </td>
                            <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add
                                    more</button></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-10 mb-1">
                    <div class="form-group">
                        <strong>Denominations</strong>
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-3 text-end"><strong>500</strong></div>
                <div class="col-6 col-sm-3"> <input type="number" min="0" data-denom="500"
                        class="form-control denominations contact">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3 text-end"><strong>100</strong></div>
                <div class="col-6 col-sm-3"> <input type="number" min="0" data-denom="100"
                        class="form-control denominations">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3 text-end"><strong>50</strong></div>
                <div class="col-6 col-sm-3"> <input type="number" min="0" data-denom="50"
                        class="form-control denominations">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3 text-end"><strong>20</strong></div>
                <div class="col-6 col-sm-3"> <input type="number" min="0" data-denom="20"
                        class="form-control denominations">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3 text-end"><strong>10</strong></div>
                <div class="col-6 col-sm-3"> <input type="number" min="0" data-denom="10"
                        class="form-control denominations">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3 text-end"><strong>5</strong></div>
                <div class="col-6 col-sm-3"> <input type="number" min="0" data-denom="5"
                        class="form-control denominations">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3 text-end"><strong>2</strong></div>
                <div class="col-6 col-sm-3"> <input type="number" min="0" data-denom="2"
                        class="form-control denominations">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3 text-end"><strong>1</strong></div>
                <div class="col-3"> <input type="number" data-denom="1" min="0" class="form-control denominations">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-3 text-end"><strong>Cash Paid by customer</strong></div>
                <div class="col-3"> <input type="number" class="form-control paid-amount"></div>
            </div>
            <input type="hidden" name="paid_amount" class="form-control" id="paid-amount">
            <div class="row mb-2">
                <div class="col-9"></div>
                <div class="col-3"> <a class="btn btn-danger" href="{{ url('/') }}">Cancel</a>
                    <button type="submit" class="btn btn-outline-success btn-block generate-bill">Generate Bill</button>
                </div>
            </div>
        </form>
    </div>
</body>
<!-- JavaScript -->
<script src="{{asset('/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/customscript.js')}}"></script>

</html>