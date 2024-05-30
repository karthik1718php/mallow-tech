<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return view('products.billing');
    }

    public function generateInvoice(Request $request)
    {
        $invoiceData = [];

        foreach ($request->addMoreProduct as $key => $product) {

            $productData = $this->product::where('productID', $product['productID'])->toBase()->get(['price', 'tax', 'available_stocks']);
            $price = $productData[0]->price ?? 0;
            $tax = $productData[0]->tax ?? 0;
            $tax_payable_item = ($product['quantity'] * $price) * $tax / 100;

            $invoiceData[$key]['productID'] = $product['productID'];
            $invoiceData[$key]['price'] = $price;
            $invoiceData[$key]['quantity'] = $product['quantity'];
            $invoiceData[$key]['purchased-price'] = $product['quantity'] * $price;
            $invoiceData[$key]['tax'] = $tax;
            $invoiceData[$key]['tax-payable-item'] = $tax_payable_item;
            $invoiceData[$key]['total-price'] = ($product['quantity'] * $price) + $tax_payable_item;

            // Update available stocks count here
            $availableStocks = $productData[0]->available_stocks;
            $this->product::where('productID', $product['productID'])->update(['available_stocks' => $availableStocks - $product['quantity']]);

        }

        $invoiceData['email'] = $request->email;
        $invoiceData['paidAmountByCustomer'] = $request->paid_amount ?? 0;
        $totalprice = array_sum(array_column($invoiceData, 'total-price'));

        if ($request->paid_amount >= $totalprice) {
            SendEmailJob::dispatch($invoiceData);
            return view('products.invoice', compact('invoiceData'))->with('success', 'Invoice sent');

        } else {
            return redirect()->back()->with('error', 'Purchased cost is more higher than customer paid amount');
        }

    }

    public function productQuantity($pid)
    {
        $quantity = $this->product::where('productID', $pid)->value('available_stocks');
        return response()->json($quantity);

    }

}
