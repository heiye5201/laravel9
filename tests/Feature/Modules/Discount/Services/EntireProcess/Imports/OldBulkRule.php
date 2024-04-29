<?php
namespace Tests\Feature\Modules\Discount\Services\EntireProcess\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class OldBulkRule implements ToCollection
{
    /**
     * 使用 ToCollection
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {
        unset($rows[0]);
        foreach ($rows as $row)
        {
            $adjustment = json_decode($row[4], true);
            $typeCount = collect($adjustment['ranges'])->pluck('type')->unique()->count();
            $info = [
                'name' => $row[0],
                'id' => $row[1],
                'title' => $row[2],
                'type_count' => $typeCount,
                'data_to' => $row[6],
            ];
            if ($typeCount>1) {
                $file = 'sites.txt';
                $site = "\n ".json_encode($info);
                file_put_contents($file, $site, FILE_APPEND | LOCK_EX);
            }
        }
    }
}
