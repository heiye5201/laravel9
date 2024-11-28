<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 14:55
 * description:
 */
namespace App\Validators\Goods;

use Illuminate\Validation\Validator;

class GoodsRepositoryValidator
{
    public function validate($data)
    {
        // 定义验证规则
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // 假设 category_id 是外键
        ];
        // 使用 Laravel 的 Validator 来验证数据
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            // 如果验证失败，可以抛出异常或返回错误信息
            throw new \Exception($validator->errors()->first());
        }
        return true;
    }
}