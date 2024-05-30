
//Add more product dynamic
var i = 0;
$("#dynamic-ar").click(function () {
    ++i;
    $("#addRemove").append('<tr class="product product-' + i + '" data-row="' + i + '"><td><input type="text" name="addMoreProduct[' + i +
        '][productID]" placeholder="Enter ProductID" class="form-control pid-' + i + '" /></td><td><input type="number" name="addMoreProduct[' + i +
        '][quantity]" placeholder="Enter quantity" min="0" class="form-control qty-' + i + '" /><span class="error-' + i + '" style="color:red"></span></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
    );
});

// Remove dynamic row
$(document).on('click', '.remove-input-field', function () {
    $(this).parents('tr').remove();
});

//Check available stocks from database
$(document.body).on('change keyup', '.product', function (event) {
    let currentRow = $(this).data('row');

    let productID = $('.pid-' + currentRow).val();
    let qtyVal = $('.qty-' + currentRow).val();

    $('.qty-' + currentRow).prop('max', qtyVal);

    var url = "{{route('product-quantity', ':id')}}";   
    url = url.replace(':id', productID);
    console.log('productID: ',productID);
    if(productID){

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function (availableStocks) {

            $('.error-' + currentRow).text("");
            if (parseInt(qtyVal) > parseInt(availableStocks)) {
                $('.error-' + currentRow).text("Available stocks " + availableStocks + " only");
            }

        }
    });
}

});

//Adding denominations values
$(document).ready(function () {

    $('.denominations').blur(function () {
        var total = 0;
        $('.denominations').each(function () {
            quantity = Number($(this).val());
            denom = Number($(this).data('denom'));
            total += quantity * denom;
        });
        $('.paid-amount').val(total);
    });
    $('.generate-bill').click(function (e) {
        $('#paid-amount').val($('.paid-amount').val());
    });

});
