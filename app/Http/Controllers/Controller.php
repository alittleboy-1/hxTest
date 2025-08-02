<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\ResourceTrait;

use function Termwind\render;
use Illuminate\Support\Facades\Redis;
use hg\apidoc\annotation as Apidoc;


class Controller
{
    use ResourceTrait;

    // public function get(Request $request)
    // {
    //     $id = $request->input('id');
    //     $firstName = $request->input('firstName');
    //     $lastName = $request->input('lastName');
    //     return  $this->getService('customer')->getOneCustomer($id, $firstName, $lastName);
    // }

    // /**
    //  * @Apidoc\Title("添加customer")
    //  * @Apidoc\Method("GET")
    //  * @Apidoc\Param("first_name", type="string",require=true, desc="first_name")
    //  * @Apidoc\Param("last_name", type="string",require=true, desc="last_name")
    //  * @Apidoc\Returned("age", type="int", desc="age")
    //  * @Apidoc\Returned("email", type="int", desc="email")
    //  */
    // public function create(Request $request)
    // {
    //     $data = $request->all();
    //     if (!$request->has(['first_name', 'last_name', 'age', 'email'])) {
    //         return $this->formatError('参数不存在');
    //     }
    //     $user = [
    //         "first_name" => $data['first_name'],
    //         "last_name" => $data['last_name'],
    //         "age" => $data['age'],
    //         "email" => $data['email']
    //     ];
    //     if ($user['first_name'] == '') {
    //         return $this->formatError('firstName参数不能为空');
    //     }
    //     if ($user['last_name'] == '') {
    //         return $this->formatError('last_name参数不能为空');
    //     }
    //     if ($user['age'] == '' || !is_numeric($user['age'])) {
    //         return $this->formatError('age参数错误');
    //     }
    //     if (!preg_match(
    //         '/^(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/i',
    //         $user['email']
    //     )) {
    //         return $this->formatError('邮箱格式不正确');
    //     }
    //     $res = $this->getService('customer')->add($user);
    //     if (!$res) {
    //         return $this->formatError('添加失败');
    //     }
    //     return  $this->success('添加成功');
    // }

    // public function update(Request $request)
    // {
    //     $data = $request->all();
    //     $res = $this->getService("customer")->update($data);
    //     if (!$res) {
    //         return $this->formatError('更新失败');
    //     }
    //     return  $this->success('更新成功');
    // }

    // public function delete(Request $request)
    // {
    //     if (!$request->id) {
    //         return $this->formatError('参数错误');
    //     }
    //     $res = $this->getService("customer")->delete($request->id);
    //     if (!$res) {
    //         return $this->formatError('删除失败');
    //     }

    //     return $this->success('删除成功');
    // }


    // public function list(Request $request)
    // {
    //     $str = $request->input('str');
    //     $customer = $this->getService('customer')->list($str);

    //     return $this->success($customer);
    // }


    // public function index()
    // {
    //     return view('index');
    // }
    // public function login(Request $request)
    // {
    //     // return view('login');
    //     // $user = $request->input('username');
    //     // $password = $request->input('password');
    //     $name = $request->string('username')->trim();
    //     $password = $request->string('password')->trim();


    //     if (!$name || !$password) {
    //         return $this->formatError('用户名或密码不能为空');
    //     }

    //     $user = $this->getService('users')->getOne($name, $password);

    //     if (!$user) {
    //         return $this->formatError('用户名或密码错误');
    //     }
    //     // 生成唯一token（32位16进制字符串）
    //     $token = bin2hex(random_bytes(16));

    //     // 存储token与用户关联（有效期50秒）
    //     Redis::setex($token, 5000, json_encode([$user]));

    //     return $this->success([
    //         'token' => $token,
    //         'user' => $user,
    //         'message' => '登录成功'
    //     ]);
    //     // return 11;
    // }

    public function create(Request $request)
    {
    }
}
