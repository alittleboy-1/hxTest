<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\ResourceTrait;

use function Termwind\render;
use Illuminate\Support\Facades\Redis;
use hg\apidoc\annotation as Apidoc;
use Illuminate\Support\Facades\Mail;

class CustomerController
{
    use ResourceTrait;

    public function get(Request $request)
    {
        $id = $request->input('id');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        return  $this->getService('customer')->getOneCustomer($id, $firstName, $lastName);
    }

    /**
     * @Apidoc\Title("添加customer")
     * @Apidoc\Method("GET")
     * @Apidoc\Header("token", type="string", require=true, desc="访问令牌")
     * @Apidoc\Header("Authorization", type="string", require=false, desc="")
     * @Apidoc\Param("first_name", type="string",require=true, desc="first_name")
     * @Apidoc\Param("last_name", type="string",require=true, desc="last_name")
     * @Apidoc\Returned("age", type="int", desc="age")
     * @Apidoc\Returned("email", type="int", desc="email")
     */
    public function create(Request $request)
    {
        $data = $request->all();
        if (!$request->has(['first_name', 'last_name', 'age', 'email'])) {
            return $this->formatError('参数不存在');
        }
        $user = [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "age" => $data['age'],
            "email" => $data['email']
        ];
        if ($user['first_name'] == '') {
            return $this->formatError('firstName参数不能为空');
        }
        if ($user['last_name'] == '') {
            return $this->formatError('last_name参数不能为空');
        }
        if ($user['age'] == '' || !is_numeric($user['age'])) {
            return $this->formatError('age参数错误');
        }
        if (!preg_match(
            '/^(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/i',
            $user['email']
        )) {
            return $this->formatError('邮箱格式不正确');
        }
        $res = $this->getService('customer')->add($user);
        if (!$res) {
            return $this->formatError('添加失败');
        }
        return  $this->success('添加成功');
    }

    /**
     * @Apidoc\Title("更新customer")
     * @Apidoc\Method("PUT")
     * @Apidoc\Header("token", type="string", require=true, desc="访问令牌")
     * @Apidoc\Header("Authorization", type="string", require=false, desc="")
     * @Apidoc\Param("first_name", type="string",require=true, desc="first_name")
     * @Apidoc\Param("last_name", type="string",require=true, desc="last_name")
     * @Apidoc\Returned("age", type="int", desc="age")
     * @Apidoc\Returned("email", type="int", desc="email")
     */

    public function update(Request $request)
    {
        $data = $request->all();
        $res = $this->getService("customer")->update($data);
        if (!$res) {
            return $this->formatError('更新失败');
        }
        return  $this->success('更新成功');
    }
    /**
     * @Apidoc\Title("删除customer")
     * @Apidoc\Method("delete")
     * @Apidoc\Header("token", type="string", require=true, desc="访问令牌")
     * @Apidoc\Header("Authorization", type="string", require=false, desc="")
     * @Apidoc\Returned("id", type="int", desc="age")
     */

    public function delete(Request $request)
    {
        if (!$request->id) {
            return $this->formatError('参数错误');
        }
        $res = $this->getService("customer")->delete($request->id);
        if (!$res) {
            return $this->formatError('删除失败');
        }

        return $this->success('删除成功');
    }


    /**
     * @Apidoc\Title("列表")
     * @Apidoc\Method("get")
     * @Apidoc\Header("token", type="string", require=true, desc="访问令牌")
     * @Apidoc\Header("Authorization", type="string", require=false, desc="")
     * @Apidoc\Param("str", type="string",require=false, desc="关键字")
     * @Apidoc\Returned("list", type="array", desc="列表")
     */
    public function list(Request $request)
    {
        $str = $request->input('str');
        $customer = $this->getService('customer')->list($str);

        return $this->success($customer);
    }


    public function index()
    {
        return view('index');
    }

    /**
     * @Apidoc\Title("登录")
     * @Apidoc\Method("POST")
     * @Apidoc\Param("username", type="string",require=true, desc="username")
     * @Apidoc\Param("password", type="string",require=true, desc="password")
     * @Apidoc\Returned("list", type="array", desc="用户信息和token")
     */

    public function login(Request $request)
    {
        // return view('login');
        // $user = $request->input('username');
        // $password = $request->input('password');
        $name = $request->string('username')->trim();
        $password = $request->string('password')->trim();
        if (!$name || !$password) {
            return $this->formatError('用户名或密码不能为空');
        }

        $user = $this->getService('users')->getOne($name, $password);

        if (!$user) {
            return $this->formatError('用户名或密码错误');
        }
        // 生成唯一token（32位16进制字符串）
        $token = bin2hex(random_bytes(16));

        // 存储token与用户关联（有效期50秒）
        Redis::setex($token, 50000, json_encode([$user]));

        return $this->success([
            'token' => $token,
            'user' => $user,
            'message' => '登录成功'
        ]);
    }

    public function send(Request $request)
    {
        try {
            Mail::raw('This is a test email!', function ($message) {
                $message->to('475361519@qq.com')
                    ->subject('Test Email');
            });
            return $this->success('邮件发送成功');
        } catch (\Exception $e) {
            return $this->formatError('邮件发送失败: ' . $e->getMessage());
        }
        return $this->success('测试成功');
    }
}
