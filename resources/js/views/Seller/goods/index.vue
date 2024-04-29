<template>
    <div class="seller_goods">
        <table-view v-if="tableVis" :options="options" :searchOption="searchOptions" :btnConfig="btnConfigs" :params="params" :dialogParam="dialogParam" handleWidth='80px'>
            <template #table_topleft_hook>
                <el-button type="primary" :icon="Plus" @click="addGoods">{{$t('btn.add')}}</el-button>
            </template>
            <template #table_handleright_hook="row">
                <el-button :title="$t('btn.edit')"  type="primary" @click="editGoods(row)" :icon="Edit" />
            </template>
        </table-view>
        <div v-if="!tableVis" class="goods_form">
            <goods-form ref="goods_form"  />
        </div>
    </div>
</template>

<script>
import {reactive,ref,getCurrentInstance} from "vue"
import { Plus,Edit } from '@element-plus/icons'
import tableView from "@/components/common/table"
import goodsForm from "./form"
export default {
    components:{tableView,goodsForm},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const tableVis = ref(true)

        const params = {
            isWith:'goods_class,goods_brand'
        }
        const options = reactive([
            {label:proxy.$t('seller.goods.images'),value:'goods_master_image',type:'avatar'},
            {label:proxy.$t('seller.goods.name'),value:'goods_name'},
            {label:proxy.$t('seller.goods.brand_name'),value:'brand_name',type:'tags'},
            {label:proxy.$t('seller.goods.class_name'),value:'class_name',type:'tags'},
            {label:proxy.$t('seller.goods.price'),value:'goods_price'},
            {label:proxy.$t('seller.goods.stock'),value:'goods_stock'},
            {label:proxy.$t('seller.goods.goods_sale'),value:'goods_sale'},
            {label:proxy.$t('seller.goods.status'),value:'goods_status',type:'dict_tags'},
            {label:proxy.$t('seller.goods.goods_verify'),value:'goods_verify',type:'dict_tags'},
            // {label:'排序',value:'is_sort'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
            {label:proxy.$t('seller.goods.name'),value:'goods_name',where:'likeRight'},
            {label:proxy.$t('seller.goods.status'),value:'goods_status',type:'select',data:{goods_status:[{label:proxy.$t('btn.yes'),value:1},{label:proxy.$t('btn.no'),value:0}]}},
            {label:proxy.$t('seller.goods.goods_verify'),value:'goods_verify',type:'select',data:{goods_verify:[{label:proxy.$t('btn.waitExamine'),value:2},{label:proxy.$t('btn.passExamine'),value:1},{label:proxy.$t('btn.rejected'),value:0}]}},
        ])

        const dialogParam = reactive({
            // dict:[{name:'pid',url:'/load_goods_classes?deep=2'}],
            rules:{
                pid:[{required:true,message:proxy.$t('common.not_null')}],
                name:[{required:true,message:proxy.$t('common.not_null')}]
            },
            dictData:{
                goods_status:[{label:proxy.$t('btn.yes'),value:1},{label:proxy.$t('btn.no'),value:0}],
                goods_verify:[{label:proxy.$t('btn.waitExamine'),value:2},{label:proxy.$t('btn.passExamine'),value:1},{label:proxy.$t('btn.rejected'),value:0}]
            },
            addForm:{},
        })
        const btnConfigs = reactive({
            show:{show:false},
            store:{show:false},
            update:{show:false},
        })
        const addGoods = ()=>{
            tableVis.value = false
        }

        const editGoods = async (e)=>{
            tableVis.value = false
            const editForm = await proxy.R.get('/Seller/goods/'+e.rows.id)
            proxy.$refs.goods_form.editGoods(editForm)
        }

        return {
            options,searchOptions,dialogParam,btnConfigs,tableVis,params,
            Plus,Edit,
            addGoods,editGoods,
        }
    }
}
</script>

<style lang="scss" scoped>
.goods_form{
    width: 90%;
    margin:0 auto;
}
</style>
