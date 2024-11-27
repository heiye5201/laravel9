<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/26 17:58
 * description:
 */

namespace App\Services\Study\Entity;

class OrderStatusService
{
    public function handleStatus($order)
    {
        return "Order {$order} status handled.";
    }
}
