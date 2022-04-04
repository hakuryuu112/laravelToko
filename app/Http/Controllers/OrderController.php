<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Products;

class OrderController extends BaseController
{
    public function store()
    {
        $product = Products::find( \request('product_id'));

        if ($product == null)
        {
            return $this->out(status: 'Gagal', code: 404, error: ['Produk Tidak Ditemukan']);
        }

        $order = new Orders();
        $order->order_date = Carbon::now('Asia/Jakarta');
        $order->product_id = $product->id;
        $order->customer_id = request('customer_id');
        $order->qty = request('qty');
        $order->price = $product->price;

        if ($order->save() == true)
        {
            return $this->out(data:$order, status: 'OK', code: 201);
        }
        else
        {
            return $this->out(status: 'Gagal', error: ['Order Gagal Disimpan'], code: 504);
        }
    }

    public function findAll()
    {
        $order = Orders::query()
                    ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
                    ->leftJoin('products', 'products.id', '=', 'orders.product_id');

        if (request()->has('q'))
        {
            $q = request('q');
            $order->where('products.title', 'like', "%$q%");
        }

        $data = $order->paginate(10,
        [
            'orders.*',
            'customers.fisrt_name',
            'customers.last_name', 'customers.address', 'customers.city',
            'products.title as product_title'
        ]);

        return $this->out(data: $data, status: 'OK');
    }
}
