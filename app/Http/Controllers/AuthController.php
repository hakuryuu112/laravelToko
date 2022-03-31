<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function auth()
    {
        $authheader = \request()->header('Authorization'); //Basic base64 encode
        $keyauth = substr($authheader, 6); //Hilangkan text basic

        $plainauth = base64_decode($keyauth); //Decode text info login
        $tokenauth = explode(':', $plainauth); //Pisahkan Email:Password

        $email = $tokenauth[0];
        $pass = $tokenauth[1];

        $data = (new Customers())->newQuery()
                ->where(['email' => $email])
                ->get(['id', 'first_name', 'last_name', 'email', 'password'])->first();

        if ($data == null) //Jika data Customers tidak ditemukan
        {
            return $this->out (status : 'Gagal', code : 404, error : ['Pengguna tidak ditemukan']);
        }
        else //Jika data Customers ditemukan
        {
            if (Hash::check($pass, $data->password))
            {
                $data->token = hash('sha256', Str::random(10));
                unset($data->password);
                $data->update();

                return $this->out (daata : $data, status : 'OK');
            }
            else
            {
                return $this->out (status : 'Gagal', code : 401, error : ['Anda tidak memiliki wewenang']);
            }
        }

    }
}
