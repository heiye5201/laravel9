<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 22:04
 * description:
 */

namespace App\Services;

use App\Http\Resources\Seller\GoodsHomeCollection;
use App\Http\Resources\Seller\GoodsHomeSearchCollection;
use App\Models\Goods;
use App\Models\GoodsAttr;
use App\Models\GoodsClass;
use App\Models\GoodsSku;
use App\Models\GoodsSpecs;
use Illuminate\Support\Facades\DB;

class GoodsService extends BaseService
{

    protected $status = ['goods_status' => 1, 'goods_verify' => 1];

    public function addGoods($auth = 'users')
    {
        $goodsModel = new Goods();
        $storeId = 0;
        if ($auth == 'users') {
            $storeId = app(StoreService::class)->getStoreId()['data'];
        }
        $data = [
            'store_id' => $storeId ?? 0,
            'goods_name' => request()->goods_name,                         // 商品名
            'goods_subname' => request()->goods_subname ?? '',                  // 副标题
            'goods_no' => request()->goods_no ?? '',                       // 商品编号
            'brand_id' => request()->brand_id ?? 0,                           // 商品品牌
            'class_id' => request()->class_id ?? 0,                        // 商品分类
            'goods_master_image' => request()->goods_master_image,                 // 商品主图
            'goods_price' => abs(request()->goods_price ?? 0),                // 商品价格
            'goods_market_price' => abs(request()->goods_market_price ?? 0),         // 商品市场价
            'goods_weight' => abs(request()->goods_weight ?? 0),               // 商品重量
            'goods_stock' => abs(request()->goods_stock ?? 0),                // 商品库存
            'goods_content' => request()->goods_content ?? '',                  // 商品内容详情
            'goods_content_mobile' => request()->goods_content_mobile ?? '',           // 商品内容详情（手机）
            'goods_status' => abs(request()->goods_status) ?? 0,               // 商品上架状态
            'freight_id' => abs(request()->freight_id) ?? 0,                 // 运费模版ID
            'goods_images' => implode(',', request()->goods_images ?? []),
        ];
        // 判断是否开启添加商品审核
        $storeConfig = app(ConfigsService::class)->getFormatConfig('store');
        if (!empty($storeConfig)) {
            if ($storeConfig['goods_verify']) {
                $data['goods_verify'] = 0;
            }
        }
        try {
            DB::beginTransaction();
            $goodsModel = $goodsModel->create($data);
            // 规格处理
            if (isset(request()->skuList) && !empty(request()->skuList)) {
                $skuData = [];
                foreach (request()->skuList as $k => $v) {
                    $skuData[$k]['goods_image'] = $v['goods_image'] ?? ''; // sku图片
                    $skuData[$k]['spec_id'] = implode(',', $v['spec_id']); // sku 属性
                    $skuData[$k]['sku_name'] = implode(',', $v['sku_name']); // sku名称
                    $skuData[$k]['goods_price'] = abs($v['goods_price'] ?? 0); // sku价格
                    $skuData[$k]['goods_market_price'] = abs($v['goods_market_price'] ?? 0); // sku市场价
                    $skuData[$k]['goods_stock'] = abs($v['goods_stock'] ?? 0); // sku库存
                    $skuData[$k]['goods_weight'] = abs($v['goods_weight'] ?? 0); // sku 重量
                }
                $goodsModel->goods_skus()->createMany($skuData);
            }
            DB::commit();
            return $this->format([], __('tip.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->formatError(__('tip.error'), $e->getMessage());
        }
    }


    // 修改商品
    public function editGoods($goodsId, $auth = 'users')
    {
        $storeId = 0;
        if ($auth == 'users') {
            $storeId = app(StoreService::class)->getStoreId()['data'];
        }
        $goodsModel = Goods::query()->where('id', $goodsId);
        if ($auth == 'users') $goodsModel = $goodsModel->where('store_id', $storeId);
        $goodsModel = $goodsModel->first();
        if (!$goodsModel) {
            return $this->formatError(__('tip.error'));
        }
        // 商品名
        if (isset(request()->goods_name) && !empty(request()->goods_name)) {
            $goodsModel->goods_name = request()->goods_name;
        }
        // 副标题
        if (isset(request()->goods_subname) && !empty(request()->goods_subname)) {
            $goodsModel->goods_subname = request()->goods_subname;
        }
        // 商品编号
        if (isset(request()->goods_no) && !empty(request()->goods_no)) {
            $goodsModel->goods_no = request()->goods_no;
        }
        // 商品品牌
        if (isset(request()->brand_id) && !empty(request()->brand_id)) {
            $goodsModel->brand_id = request()->brand_id;
        }
        // 商品分类
        if (isset(request()->class_id) && !empty(request()->class_id)) {
            $goodsModel->class_id = request()->class_id;
        }
        // 商品主图
        if (isset(request()->goods_master_image) && !empty(request()->goods_master_image)) {
            $goodsModel->goods_master_image = request()->goods_master_image;
        }
        // 商品价格
        if (isset(request()->goods_price) && !empty(request()->goods_price)) {
            $goodsModel->goods_price = abs(request()->goods_price ?? 0);
        }
        // 商品市场价
        if (isset(request()->goods_market_price) && !empty(request()->goods_market_price)) {
            $goodsModel->goods_market_price = abs(request()->goods_market_price ?? 0);
        }
        // 商品重量
        if (isset(request()->goods_weight) && !empty(request()->goods_weight)) {
            $goodsModel->goods_weight = abs(request()->goods_weight ?? 0);
        }
        // 商品库存
        if (isset(request()->goods_stock) && !empty(request()->goods_stock)) {
            $goodsModel->goods_stock = abs(request()->goods_stock ?? 0);
        }
        // 商品内容详情
        if (isset(request()->goods_content) && !empty(request()->goods_content)) {
            $goodsModel->goods_content = request()->goods_content;
        }
        // 商品内容详情（手机）
        if (isset(request()->goods_content_mobile) && !empty(request()->goods_content_mobile)) {
            $goodsModel->goods_content_mobile = request()->goods_content_mobile;
        }
        // 商品上架状态
        if (isset(request()->goods_status)) {
            $goodsModel->goods_status = abs(request()->goods_status ?? 0);
        }
        // 商品推荐状态
        if (isset(request()->is_master)) {
            $goodsModel->is_master = abs(request()->is_master ?? 0);
        }
        // 商品快递情况状态
        if (isset(request()->freight_id)) {
            $goodsModel->freight_id = abs(request()->freight_id ?? 0);
        }
        // 商品图片
        if (isset(request()->goods_images) && !empty(request()->goods_images)) {
            $goodsModel->goods_images = implode(',', request()->goods_images ?? []);
        }
        // 判断是否开启添加商品审核
        $configs = app(ConfigsService::class)->getFormatConfig('store');
        if (!empty($configs) && isset($configs['goods_verify'])) {
            // 如果是内容标题修改则进行审核（暂时不写）
            if ($configs['goods_verify'] && $auth == 'users') $goodsModel->goods_verify = 2;
        }
        try {
            DB::beginTransaction();
            $goodsModel = $goodsModel->save();
            // 规格处理
            if (isset(request()->skuList) && !empty(request()->skuList)) {
                $skuData = [];
                $skuId = []; // 修改的skuID 不存在则准备删除
                foreach (request()->skuList as $k => $v) {
                    if (isset($v['id']) && !empty($v['id'])) {
                        // 如果ID不为空则代表存在此sku 进行修改
                        $skuId[] = $v['id'];
                        GoodsSku::query()->where('goods_id', $goodsId)->where('id', $v['id'])->update([
                            'goods_image' => $v['goods_image'] ?? '', // sku图片
                            'spec_id' => implode(',', $v['spec_id']), // sku 属性
                            'sku_name' => implode(',', $v['sku_name']), // sku名称
                            'goods_price' => abs($v['goods_price'] ?? 0), // sku价格
                            'goods_market_price' => abs($v['goods_market_price'] ?? 0), // sku市场价
                            'goods_stock' => abs($v['goods_stock'] ?? 0), // sku库存
                            'goods_weight' => abs($v['goods_weight'] ?? 0), // sku 重量
                        ]);
                    } else {
                        // 否则进行插入数据库
                        $skuData[$k]['goods_image'] = $v['goods_image'] ?? ''; // sku图片
                        $skuData[$k]['spec_id'] = implode(',', $v['spec_id']); // sku 属性
                        $skuData[$k]['sku_name'] = implode(',', $v['sku_name']); // sku名称
                        $skuData[$k]['goods_price'] = abs($v['goods_price'] ?? 0); // sku价格
                        $skuData[$k]['goods_market_price'] = abs($v['goods_market_price'] ?? 0); // sku市场价
                        $skuData[$k]['goods_stock'] = abs($v['goods_stock'] ?? 0); // sku库存
                        $skuData[$k]['goods_weight'] = abs($v['goods_weight'] ?? 0); // sku 重量
                    }
                }
                // 如果ID不为空则代表存在此sku 进行修改
                if (!empty($skuId)) {
                    GoodsSku::query()->where('goods_id', $goodsId)->whereNotIn('id', $skuId)->delete();
                }
                // 新建不存在sku进行插入数据库
                if (!empty($skuData)) {
                    $goodsModel = Goods::query()->find($goodsId);
                    $goodsModel->goods_skus()->createMany($skuData);
                }
            } else {
                // 清空所有sku
                GoodsSku::query()->where('goods_id', $goodsId)->delete();
            }
            DB::commit();
            return $this->format([], __('tip.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->formaterror(__('tip.error'), $e->getMessage());
        }
    }

    // 修改商品的状态审核
    public function editGoodsVerify($goodsId, $status = 1, $msg = '')
    {
        $goodsModel = Goods::query()->where('id', $goodsId);
        $data = [
            'goods_verify' => $status,
        ];
        if ($status == 2) {
            $data['refuse_info'] = $msg;
        }
        $rs = $goodsModel->update($data);
        return $this->format($rs);
    }

    // 获取商品详情
    public function getGoodsInfo($goodsId)
    {
        $goodsInfo = Goods::query()->find($goodsId);
        if (!$goodsInfo) {
            return $this->formatError(__('tip.error'));
        }
        // 获取商品分类信息
        if ($goodsInfo->class_id == 0) {
            return $this->formatError(__('tip.error') . 'c');
        }
        $classData = [];
        $classData[] = GoodsClass::query()->find($goodsInfo->class_id);
        $classData[] = GoodsClass::query()->find($classData[0]->pid);
        $classData[] = GoodsClass::query()->find($classData[1]->pid);
        $goodsInfo['classList'] = $classData;

        // 图片转化
        if (!empty($goodsInfo->goods_images)) {
            $goodsInfo['goods_images'] = explode(',', $goodsInfo->goods_images);
            $goodsInfo['goods_images_thumb_150'] = app(ToolService::class)->thumb_array($goodsInfo['goods_images'], 150);
            $goodsInfo['goods_images_thumb_400'] = app(ToolService::class)->thumb_array($goodsInfo['goods_images'], 400);
        }

        // 获取处理后的规格信息
        $sku = GoodsSku::query()->where('goods_id', $goodsId)->get()->toArray();
        if (!empty($sku)) {
            $skuList = [];
            $spec_id = [];
            foreach ($sku as $v) {
                $v['spec_id'] = explode(',', $v['spec_id']);
                $v['sku_name'] = explode(',', $v['sku_name']);
                $spec_id = array_merge($spec_id, $v['spec_id']);
                $skuList[] = $v;
            }
            $spec_id = array_unique($spec_id);
            $goods_spec = GoodsSpecs::query()->whereIn('id', $spec_id)->orderBy('id', 'desc')->get()->toArray();
            $attr_id = [];
            foreach ($goods_spec as $v) {
                if (!in_array($v['attr_id'], $attr_id)) {
                    $attr_id[] = $v['attr_id'];
                }
            }
            $goods_attr = GoodsAttr::query()->whereIn('id', $attr_id)->with('specs')->orderBy('id', 'desc')->get()->toArray();
            foreach ($goods_attr as $k => $v) {
                foreach ($v['specs'] as $key => $vo) {
                    if (in_array($vo['id'], $spec_id)) {
                        $goods_attr[$k]['specs'][$key]['check'] = true;
                    } else {
                        if (request()->saveCheck) {
                            unset($goods_attr[$k]['specs'][$key]);
                        }
                    }
                }
            }
            $goodsInfo['attrList'] = $goods_attr;
            $goodsInfo['skuList'] = $skuList;
        }
        return $this->format($goodsInfo);
    }


    // 获取商品详情
    public function getGoodsInfoApp($goodsId)
    {
        $goodsInfo = Goods::query()->find($goodsId);
        if (!$goodsInfo) {
            return $this->formatError(__('tip.error'));
        }
        // 获取商品分类信息
        if ($goodsInfo->class_id == 0) {
            return $this->formatError(__('tip.error') . 'c');
        }
        $classData = [];
        $classData[] = GoodsClass::query()->find($goodsInfo->class_id);
        $classData[] = GoodsClass::query()->find($classData[0]->pid);
        $classData[] = GoodsClass::query()->find($classData[1]->pid);
        $goodsInfo['classList'] = $classData;
        // 图片转化
        if (!empty($goodsInfo->goods_images)) {
            $goods_images = explode(',', $goodsInfo->goods_images);
            $images = [];
            foreach ($goods_images as $key => $val) {
                $images[] = [
                    'file_id' => $key + 1,
                    'preview_url' => getUrlByPath($val),
                    'domain' => '',
                    'external_url' => getUrlByPath($val),
                ];
            }
            $goodsInfo['goods_images'] = $images;
        }
        // 获取处理后的规格信息
        $sku = GoodsSku::query()->where('goods_id', $goodsId)->get()->toArray();
        if (!empty($sku)) {
            $spec_id = [];
            foreach ($sku as $v) {
                $v['spec_id'] = explode(',', $v['spec_id']);
                $spec_id = array_merge($spec_id, $v['spec_id']);
            }
            $spec_id = array_unique($spec_id);
            $spec_id = array_values($spec_id);
            $goods_spec = GoodsSpecs::query()->whereIn('id', $spec_id)->orderBy('id', 'desc')->get()->toArray();
            $attr_id = collect($goods_spec)->pluck('attr_id')->toArray();
            $goods_attr = GoodsAttr::query()->whereIn('id', $attr_id)->orderBy('id', 'desc')->get()->toArray();
            $specList = [];
            foreach ($goods_attr as $key => $val) {
                $specInfo = [
                    'spec_id' => $val['id'],
                    'spec_name' => $val['name'],
                    'key' => $key,
                ];
                $specData = collect($goods_spec)->where('attr_id', $val['id'])->values();
                $specValue = [];
                foreach ($specData as $k => $va) {
                    $specValue[] = [
                        'key' => $k,
                        'groupKey' => $key,
                        'spec_value_id' => $va['id'],
                        'spec_value' => $va['name']
                    ];
                }
                $specInfo['valueList'] = $specValue;
                $specList[] = $specInfo;
            }
            $goodsInfo['specList'] = $specList;
            $skuList = [];
            foreach ($sku as $key => $value) {
                $info = [
                    'id' => $value['id'],
                    'goods_sku_id' => $value['id'],
                    'goods_id' => $value['goods_id'],
                    'image_id' => 0,
                    'goods_sku_no' => '',
                    'goods_price' => $value['goods_market_price'],
                    'line_price' => $value['goods_price'],
                    'stock_num' => $value['goods_stock'],
                    'goods_weight' => $value['goods_weight'],
                    'image_url' => $value['goods_image'],
                ];
                $goods_props = [];
                $spec_value_ids = explode(',', $value['spec_id']);
                $goodsSpecData = collect($goods_spec)->whereIn('id', $spec_value_ids)->values()->toArray();
                $info['spec_value_ids'] = collect($goodsSpecData)->pluck('id');
                foreach ($goodsSpecData as $val1) {
                    $attr = collect($goods_attr)->where('id', $val1['attr_id'])->first();
                    $spec = [
                        'group' => ['name' => $attr['name'], 'id' => $attr['id']],
                        'value' => ['name' => $val1['name'], 'id' => $val1['id']],
                    ];
                    $goods_props[] = $spec;
                }
                $info['goods_props'] = $goods_props;
                $skuList[] = $info;
            }
            $goodsInfo['skuList'] = $skuList;
        } else {
            $skuList = [
                'goods_id' => $goodsInfo['id'],
                'goods_price' => $goodsInfo['goods_price'],
                'goods_props' => '',
                'goods_sku_id' => 0,
                'goods_sku_no' => '',
                'goods_weight' => $goodsInfo['goods_weight'],
                'id' => $goodsInfo['id'],
                'image_id' => 0,
                'image_url' => '',
                'line_price' => $goodsInfo['goods_market_price'],
                'spec_value_ids' => '',
                'stock_num' => $goodsInfo['goods_stock'],
            ];
            $goodsInfo['skuList'] = [$skuList];
            $goodsInfo['specList'] = [];
        }
        $goodsInfo['goods_image'] = '';
        return $this->format($goodsInfo);
    }


    // 搜索 和 商品列表
    public function all()
    {
        $goodsModel = new Goods();
        $params = request('params');
        try {
            if (!empty($params)) {
                $params_array = json_decode(base64_decode($params), true);
                // 品牌
                if (isset($params_array['brand_id']) && !empty($params_array['brand_id'])) {
                    $goodsModel = $goodsModel->where('brand_id', $params_array['brand_id']);
                }
                // 栏目
                if (isset($params_array['class_id']) && !empty($params_array['class_id'])) {
                    if (is_array($params_array['class_id'])) {
                        $goodsModel = $goodsModel->whereIn('class_id', $params_array['class_id']);
                    } else {
                        $goodsModel = $goodsModel->where('class_id', $params_array['class_id']);
                    }
                }
                // 商家
                if (isset($params_array['store_id']) && !empty($params_array['store_id'])) {
                    $goodsModel = $goodsModel->where('store_id', $params_array['store_id']);
                }
                // 关键词
                if (isset($params_array['keywords']) && !empty($params_array['keywords'])) {
                    $params_array['keywords'] = urldecode($params_array['keywords']);
                    $goodsModel = $goodsModel->where('goods_name', 'like', '%' . $params_array['keywords'] . '%');
                }
                // 排序
                if (isset($params_array['sort_type']) && !empty($params_array['sort_type'])) {
                    $goodsModel = $goodsModel->orderBy($params_array['sort_type'], $params_array['sort_order']);
                } else {
                    $goodsModel = $goodsModel->orderBy('id', 'desc')->orderBy('goods_sale', 'desc');
                }
            }
            // 是否是拼团产品
            if (!empty(request('is_collective'))) {
                $goodsModel = $goodsModel->whereHas('collective');
            }
            // 是否是分销产品
            if (!empty(request('is_distribution'))) {
                $goodsModel = $goodsModel->whereHas('distribution');
            }
            $list = $goodsModel->where($this->status)
                ->with(['goods_skus' => function ($q) {
                    return $q->select('goods_id', 'goods_price', 'goods_stock')->orderBy('goods_price', 'asc');
                }])
                ->withCount('order_comment')
                ->whereHas('store', function ($q) {
                    return $q->where(app(StoreService::class)->storeStatus);
                })
                ->paginate(intval(request('per_page')));
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
        return $this->format(new GoodsHomeSearchCollection($list));
    }


    // 搜索 和 商品列表
    public function appAll($params)
    {
        $goodsModel = new Goods();
        try {
            if (!empty($params)) {
                $params_array = $params;
                // 品牌
                if (isset($params_array['brand_id']) && !empty($params_array['brand_id'])) {
                    $goodsModel = $goodsModel->where('brand_id', $params_array['brand_id']);
                }
                // 栏目
                if (isset($params_array['categoryId']) && !empty($params_array['categoryId'])) {
                    if (is_array($params_array['categoryId'])) {
                        $goodsModel = $goodsModel->whereIn('class_id', $params_array['categoryId']);
                    } else {
                        $goodsModel = $goodsModel->where('class_id', $params_array['categoryId']);
                    }
                }
                // 商家
                if (isset($params_array['store_id']) && !empty($params_array['store_id'])) {
                    $goodsModel = $goodsModel->where('store_id', $params_array['store_id']);
                }
                // 关键词
                if (isset($params_array['goodsName']) && !empty($params_array['goodsName'])) {
                    $params_array['keywords'] = urldecode($params_array['goodsName']);
                    $goodsModel = $goodsModel->where('goods_name', 'like', '%' . $params_array['keywords'] . '%');
                }
                // 排序
                if (isset($params_array['sortType']) && !empty($params_array['sortType'])) {
                    $sortPrice = $params_array['sortPrice'] ? 'desc' : 'asc';
                    switch ($params_array['sortType']) {
                        case 'all':
                            $goodsModel = $goodsModel->orderBy('id', $sortPrice);
                            break;
                        case 'sales':
                            $goodsModel = $goodsModel->orderBy('goods_sale', $sortPrice);
                            break;
                        case 'price':
                            $goodsModel = $goodsModel->orderBy('goods_market_price', $sortPrice);
                            break;
                    }
                } else {
                    $goodsModel = $goodsModel->orderBy('id', 'desc')->orderBy('goods_sale', 'desc');
                }
            }
            // 是否是拼团产品
            if (!empty(request('is_collective'))) {
                $goodsModel = $goodsModel->whereHas('collective');
            }
            // 是否是分销产品
            if (!empty(request('is_distribution'))) {
                $goodsModel = $goodsModel->whereHas('distribution');
            }
            $list = $goodsModel->where($this->status)
                ->with(['goods_skus' => function ($q) {
                    return $q->select('goods_id', 'goods_price', 'goods_stock')->orderBy('goods_price', 'asc');
                }])
                ->withCount('order_comment')
                ->whereHas('store', function ($q) {
                    return $q->where(app(StoreService::class)->storeStatus);
                })
                ->paginate(intval(request('per_page')));
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
        return $this->format(new GoodsHomeSearchCollection($list));
    }


    public function master($goodsNum = 6)
    {
        $goodsModel = new Goods();
        $goodsClass = app(ToolService::class)->getChildren(GoodsClass::query()->orderBy('is_sort', 'asc')->get()->toArray());
        $class = [];
        foreach ($goodsClass as $k => $v) {
            $class[$k]['name'] = $v['name'];
            $class[$k]['classLeftAdv'] = getUrlByPath($v['thumb']);
            $class[$k]['id'] = $v['id'];
            $class[$k]['goods'] = [];
            $class[$k]['class_id'] = [];
            foreach ($v['children'] as $vo) {
                if (isset($vo['children'])) {
                    foreach ($vo['children'] as $item) {
                        $class[$k]['class_id'][] = $item['id'];
                    }
                }
            }
        }
        foreach ($class as $k => $v) {
            $class[$k]['goods'] = new GoodsHomeCollection($goodsModel->whereHas('store', function ($q) {
                return $q->where(app(StoreService::class)->storeStatus);
            })->with(['goods_skus' => function ($q) {
                return $q->orderBy('goods_price', 'asc');
            }])->where($this->status)->whereIn('class_id', $v['class_id'])->orderBy('is_master', 'desc')->take($goodsNum)->get());
            unset($class[$k]['class_id']);
        }
        return $this->format($class);
    }

    // 获取排序数量的商品
    public function sortGoods($id, $whereName = 'store_id', $take = 6, $where = [])
    {
        $model = new Goods();
        if (!empty($where)) {
            $model = $model->where($where);
        }
        $list = $model->whereHas('store', function ($q) {
            return $q->where(app(StoreService::class)->storeStatus);
        })->with(['goods_skus' => function ($q) {
            return $q->orderBy('goods_price', 'asc');
        }])->where($whereName, $id)->where($this->status)->take($take)->orderBy('goods_sale', 'desc')->get();
        return $this->format(new GoodsHomeCollection($list));
    }

    // 获取首页秒杀商品
    public function getHomeSeckillGoods()
    {
        try {
            $list = Goods::query()->where($this->status)
                ->whereHas('store', function ($q) {
                    return $q->where(app(StoreService::class)->storeStatus);
                })
                ->with(['goods_skus' => function ($q) {
                    return $q->orderBy('goods_price', 'asc');
                }])
                ->whereHas('seckill', function ($q) {
                    if (empty(request()->start_time)) {
                        return $q->where('start_time', '<', now()->format('Y-m-d H') . ':00:00')->where('end_time', '>', now()->addHours(1)->format('Y-m-d H') . ':00:00');
                    }
                    return $q->where('start_time', '>', now()->addHours(request()->start_time)->format('Y-m-d H') . ':00:00')->where('end_time', '<', now()->addHours(request()->start_time + 1)->format('Y-m-d H') . ':00:00');
                })
                ->orderBy('goods_sale', 'desc')
                ->paginate(request()->per_page ?? 30);
        } catch (\Exception $e) {
            return $this->formatError($e->getMessage());
        }
        return $this->format(new GoodsHomeSearchCollection($list));
    }
}

