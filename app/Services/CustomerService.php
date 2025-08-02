<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;



class CustomerService
{

    public function getOneCustomer($id, $firstName, $lastName)
    {

        $customer = DB::table('customer')
            ->when($id, function ($query, $str) {
                return $query->where('id', $str);
            })
            ->when($firstName, function ($query, $str) {
                return $query->where('first_name', $str);
            })
            ->when($lastName, function ($query, $str) {
                return $query->where('last_name', $str);
            })
            ->first();
        return $customer;
    }

    public function add($data)
    {
        return DB::table('customer')->insert([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'age' => $data['age'],
            'dob' => now(),
            'email' => $data['email'],
            'creation_date' => now()
        ]);
    }

    public function update($data)
    {

        $customer =  $this->getOneCustomer($data['id'], '', '');
        if (!$customer) {
            return false;
        }

        return DB::table('customer')->where('id', $data['id'])->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'age' => $data['age'],
            'dob' => now(),
            'email' => $data['email'],
            'creation_date' => now()
        ]);
    }

    public function delete($id)
    {
        $customer = $this->getOneCustomer($id, '', '');
        if (!$customer) {
            return false;
        }
        return DB::table('customer')->where('id', $id)->delete();
    }


    public function list($str)
    {
        $customer = DB::table('customer')
            ->when($str, function ($query, $st) {
                return $query->whereAny([
                    'first_name',
                    'last_name',
                ], 'LIKE', '%' . $st . '%');
            })
            ->paginate(2);
        return $customer;
    }
}
