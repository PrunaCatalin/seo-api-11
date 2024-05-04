<?php
/*
 * seo-api | OrderProblemService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/28/2024 9:07 PM
*/

namespace Modules\Tenants\App\Services\Order;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Order\Order;
use Modules\Tenants\App\Models\Order\OrderProblem;

class OrderProblemService implements CrudMicroService
{
    /**
     * Create a new order problem and associate it with an order.
     * @throws ServiceException
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($data['order_id']);
            $orderProblem = new OrderProblem([
                'type' => $data['type'],
                'description' => $data['description'],
                'status' => $data['status']
            ]);

            $order->problems()->save($orderProblem);
            DB::commit();
            return $orderProblem;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new ServiceException('Failed to create order problem: ' . $exception->getMessage(), []);
        }
    }

    /**
     * Update an existing order problem.
     * @throws ServiceException
     */
    public function update(array $data)
    {
        try {
            $orderProblem = OrderProblem::find($data['problemId']);
            if (!$orderProblem) {
                throw new ServiceException('Order problem not found', []);
            }

            $orderProblem->update($data);
            return $orderProblem;
        } catch (Exception $exception) {
            throw new ServiceException('Failed to update order problem: ' . $exception->getMessage(), []);
        }
    }

    /**
     * Delete an order problem.
     * @throws ServiceException
     */
    public function delete(array $data)
    {
        try {
            $orderProblem = OrderProblem::find($data['problemId']);
            if (!$orderProblem) {
                throw new ServiceException('Order problem not found', []);
            }

            $orderProblem->delete();
            return true;
        } catch (Exception $exception) {
            throw new ServiceException('Failed to delete order problem: ' . $exception->getMessage(), []);
        }
    }

    /**
     * Find an order problem by ID.
     * @throws ServiceException
     */
    public function find(int $problemId)
    {
        $orderProblem = OrderProblem::find($problemId);
        if (!$orderProblem) {
            throw new ServiceException('Order problem not found', []);
        }

        return $orderProblem;
    }

}
