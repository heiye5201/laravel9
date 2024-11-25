<?php
/**
 * autor      : jiweijian
 * createTime : 2024/10/31 11:14
 * description:
 */

namespace App\Imports\Order;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class OrderProductSheetImport implements ToCollection
{

    public $collection; // 添加这个属性

    public function collection(Collection $rows)
    {
        $productData = [];
        foreach ($rows as $key => $row) {
            // 这里可以处理每一行的数据
            // 示例：获取列数据 $row[0], $row[1], 等
            if ($key > 0) {
                $discountInfo = [
                    'rule_id' => $row[0],
                    'store_name' => $row[1],
                    'order_item_id' => $row[2],
                    'order_id' => $row[3],
                    'product_id' => $row[4],
                    'variation_id' => $row[5],
                    'product_gross_revenue' => $row[10],
                    'coupon_amount' => $row[11],
                    'price' => $row[21],
                ];
                $productData[] = $discountInfo;
            }
        }
        $this->collection = $productData; // 将数据存储到属性中
    }
}