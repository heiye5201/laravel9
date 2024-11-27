<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/26 17:57
 * description:
 */

namespace App\Services\Study\Entity;

class ProductStatusService
{
    public function handleStatus($product)
    {
        return "Product {$product} status handled.";
    }
}
