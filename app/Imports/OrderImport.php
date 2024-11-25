<?php

namespace App\Imports;

use App\Imports\Order\OrderProductSheetImport;
use App\Imports\Order\OrderSheetImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrderImport implements WithMultipleSheets
{

    public $orderSheetImport;
    public $orderProductSheetImport;

    public function __construct()
    {
        $this->orderSheetImport = new OrderSheetImport();
        $this->orderProductSheetImport = new OrderProductSheetImport();
    }

    public function sheets(): array
    {
        return [
            // 定义每个 sheet 的导入逻辑
            0 => $this->orderSheetImport,
            1 => $this->orderProductSheetImport,
        ];
    }
}
