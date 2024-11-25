<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DiscountImport implements ToCollection
{

    public $collection; // 添加这个属性

    public function collection(Collection $rows)
    {
        $discountData = [];
        foreach ($rows as $key => $row) {
            // 这里可以处理每一行的数据
            // 示例：获取列数据 $row[0], $row[1], 等
            if ($key >0 ) {
                $discountInfo = [
                    'store_name' => $row[0],
                    'id' => $row[1],
                    'filters' => $row[6],
                    'buy_x_get_y_adjustments' => $row[7],
                ];
                $discountData[] = $discountInfo;
            }
        }
        $this->collection = $discountData; // 将数据存储到属性中
    }
}
