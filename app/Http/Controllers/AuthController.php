<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
    private function getEmailPass()
    {
        $authheader = \request()->header('Authorization');//Basic base64 encode
        $keyauth = substr($authheader, 6); //Hilangkan text basic
        $plainauth = base64_decode($keyauth); //Decode text info login

        return explode(':', $plainauth); //Pisahkan Email:Password
    }


    public function auth()
    {
        [$email, $pass] = $this->getEmailPass();

        $data = Customers::where('email', $email)
                        ->get(['id', 'email', 'first_name', 'last_name', 'password'])
                        ->first();

        if ($data == null) //Jika data Customers tidak ditemukan
        {
            //return response("aaaa");
            return $this->out(status:'Gagal', code:404, error:['Pengguna tidak ditemukan']);
        }
        else //Jika data Customers ditemukan
        {
            if (Hash::check($pass, $data->password))
            {
                $data->token = hash('sha256', Str::random(60));
                unset($data->password);
                $data->update();

                //return response("aaaa");
                return $this->out (data:$data, status:'OK');
            }
            else
            {
                //return response("aaaa");
                return $this->out (status:'Gagal', code:401, error:['Anda tidak memiliki wewenang']);
            }
        }

    }
}
