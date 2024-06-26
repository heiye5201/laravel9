<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 21:47
 * description:
 */

namespace App\Services;

use App\Http\Resources\Home\FavoriteHomeCollection;
use App\Http\Resources\Home\FollowHomeCollection;
use App\Models\Favorite;

class FavoriteService extends BaseService
{
    public function fav($reqData)
    {
        $type = $reqData['is_type'] ?? 0;
        $userId = $this->getUserId('users');
        $model = Favorite::query()->where(['user_id' => $userId, 'is_type' => $type]);
        if ($type == 0) {
            $model = $model->with(['goods' => function ($q) {
                return $q->select('id', 'goods_master_image', 'goods_price', 'goods_name', 'goods_subname')->with('goods_skus');
            }]);
            $fav_list = $model->paginate($reqData['per_page'] ?? 30);
            return $this->format(new FavoriteHomeCollection($fav_list));
        } else {
            $model = $model->with(['store' => function ($q) {
                return $q->select('id', 'store_name', 'store_logo');
            }]);
            $fav_list = $model->paginate($reqData['per_page'] ?? 30);
            return $this->format(new FollowHomeCollection($fav_list));
        }
    }

    // 添加收藏和关注
    public function add($reqData)
    {
        $out_id = $reqData['out_id'] ?? 0;
        if (!in_array($reqData['is_type'], [0, 1])) {
            return $this->formatError(__('tip.error'));
        }
        $userId = $this->getUserId('users');
        $fav_info = Favorite::query()->where(['user_id' => $userId, 'out_id' => $out_id, 'is_type' => $reqData['is_type']])->first();
        if (!empty($fav_info)) {
            Favorite::query()->where(['user_id' => $userId, 'out_id' => $out_id, 'is_type' => $reqData['is_type']])->delete();
            return $this->format([], __('tip.success'));
        }
        $model = new Favorite();
        $model->user_id = $userId;
        $model->out_id = $out_id;
        $model->is_type = $reqData['is_type'];
        $model->save();
        return $this->format([], __('tip.success'));
    }

    // 判断是否有收藏
    public function isFav($reqData)
    {
        $out_id = $reqData['out_id'] ?? 0;
        if (!in_array($reqData['is_type'], [0, 1])) {
            return $this->formatError(__('tip.error'));
        }
        try {
            $userId = $this->getUserId('users');
        } catch (\Exception $e) {
            return $this->format(false, $e->getMessage());
        }
        $fav_info = Favorite::query()->where(['user_id' => $userId, 'out_id' => $out_id, 'is_type' => $reqData['is_type']])->exists();
        if (empty($fav_info)) {
            return $this->format(false);
        }
        return $this->format(true);
    }


    public function destroy($id)
    {
        $userId = $this->getUserId('users');
        $fav_info = Favorite::query()->where(['user_id' => $userId, 'id' => $id])->delete();
        if (empty($fav_info)) {
            return $this->formatError('删除失败！');
        }
        return $this->format([]);
    }
}
