<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Http\Request;
use Mockery as m;
use App\Http\Controllers\CustomerController;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */

    public function testGetCustomerWithAllParameters()
    {
        // 创建模拟请求
        $request = new Request([
            'id' => 123,
            'firstName' => 'John',
            'lastName' => 'Doe'
        ]);

        // 创建模拟服务
        $mockService = m::mock('overload:App\Services\CustomerService');
        $mockService->shouldReceive('getOneCustomer')
            ->with(123, 'John', 'Doe')
            ->once()
            ->andReturn(['id' => 123, 'name' => 'John Doe']);

        // 调用方法
        $controller = new CustomerController();
        $response = $controller->get($request);

        // 断言
        $this->assertEquals(['id' => 123, 'name' => 'John Doe'], $response);
    }


    public function testUpdateSuccess()
    {
        // 模拟请求数据
        $requestData = ['id' => 1, 'name' => 'John Doe'];

        // 创建模拟服务
        $customerServiceMock = m::mock('overload:App\Services\CustomerService');
        $customerServiceMock->shouldReceive('update')
            ->with($requestData)
            ->andReturn(1); // 返回受影响行数

        // 调用控制器方法
        $controller = new CustomerController();
        $response = $controller->update(new Request($requestData));

        // 断言返回数组结构
        $this->assertEquals(200, $response['code']);
        // $this->assertEquals('更新成功', $response['msg']);
    }

    public function testListWithValidString()
    {
        // 创建模拟分页对象
        $paginatedData = (object)[
            'current_page' => 1,
            'data' => [
                (object)[
                    'id' => 1,
                    'first_name' => 'Test',
                    'last_name' => 'User'
                ]
            ],
            'links' => [
                (object)['url' => null, 'label' => '« Previous', 'active' => false],
                (object)['url' => 'http://localhost/list?page=1', 'label' => '1', 'active' => true]
            ]
        ];

        // 创建模拟服务
        $mockService = m::mock('overload:App\Services\CustomerService');
        $mockService->shouldReceive('list')
            ->with('test-string')
            ->andReturn($paginatedData);

        $this->app->instance('customer', $mockService);

        // 创建请求对象
        $request = new Request(['str' => 'test-string']);

        // 调用控制器方法
        $controller = new CustomerController();
        $response = $controller->list($request);
        print_r($response);
        // return $this->assertEquals($paginatedData, $response);
    }
}
