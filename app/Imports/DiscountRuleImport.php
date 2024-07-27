<?php

namespace App\Imports;

use App\Models\DiscountRule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DiscountRuleImport implements ToModel, WithBatchInserts, WithChunkReading
{
    private $startRow = 1; // 跳过第一行

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 在这里检查是否需要跳过行
        if ($this->startRow > 0) {
            $this->startRow--;
            return null;
        }
        return new DiscountRule([
            'store_name' => $row[0],
            'enabled' => $row[2],
            'combining' => $row[3],
            'is_code' => $row[4],
            'title' => $row[5],
            'description' => $row[6],
            // 'starts_at' => $row[7],
            // 'ends_at' => $row[8],
            'allocation_method' => $row[9],
            'discount_class' => $row[10],
            'discount_type' => $row[11],
            'filters' => $row[12],
            'conditions' => $row[13],
            'adjustments' => $row[14],
            'created_at' => $row[15],
            'updated_at' => $row[16],
            'usage_counts' => $row[18],
            'usage_limit_per_user' => $row[19],
            'usage_limit' => $row[20],
            // 'show_message' => $row[21],
            'exclusive' => $row[22],
            'max_discount_sum' => $row[23],
            'preference_type' => $row[24],
            'adjustment_type' => $row[25],
            'real_bulk_discount' => $row[26],
            'total_sales' => $row[27],
            'total_discount' => $row[28],
            // 'no_expiration' => $row[29],
            'is_new_rule' => $row[30],
        ]);
    }

    public function startRow(): int
    {
        return $this->startRow;
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
