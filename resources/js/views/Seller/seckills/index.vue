<template>
    <div class="qwit">
        <table-view :handleWidth="'80px'" :options="options" :params="params" :btnConfig="btnConfigs" :dialogParam="dialogParam" >
            <template #discount="{scopeData}">
                <span class="lev_rate">{{scopeData.discount||0.00}} %</span>
            </template>
        </table-view>
    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import tableView from "@/components/common/table"
export default {
    components:{tableView},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const options = reactive([
            {label:proxy.$t('seller.seckills.goods_master_image'),value:'goods_master_image',type:'avatar'},
            {label:proxy.$t('seller.seckills.goods_name'),value:'goods_name'},
            {label:proxy.$t('seller.seckills.discount'),value:'discount',type:'custom'},
            {label:proxy.$t('common.start_time'),value:'start_time'},
            {label:proxy.$t('common.end_time'),value:'end_time'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);
        // 表单配置
        const addColumn = [
            {label:proxy.$t('seller.seckills.goods_id'),value:'goods_id',type:'table_select',params:{},
            pageUrl:'/Seller/goods',
            options:[
                {label:proxy.$t('seller.seckills.goods_master_image'),value:'goods_master_image',type:'avatar'},
                {label:proxy.$t('seller.seckills.goods_name'),value:'goods_name'},
                {label:proxy.$t('seller.seckills.brand_name'),value:'brand_name',type:'tags'},
                {label:proxy.$t('seller.seckills.class_name'),value:'class_name',type:'tags'},
                {label:proxy.$t('seller.seckills.goods_price'),value:'goods_price'},
                {label:proxy.$t('seller.seckills.goods_stock'),value:'goods_stock'},
                {label:proxy.$t('seller.seckills.goods_sale'),value:'goods_sale'},
                {label:proxy.$t('common.created_at'),value:'created_at'},
            ]},
            {label:proxy.$t('seller.seckills.discount'),value:'discount',type:'number'},
            {label:proxy.$t('common.start_time'),value:'start_time',type:'datetime'},
            {label:proxy.$t('common.end_time'),value:'end_time',type:'datetime'},
        ]
        const btnConfigs = reactive({
            show:{show:false},
        })

        const dialogParam = reactive({
            rules:{
                goods_id:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                discount:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                start_time:[{required:true,message:proxy.$t('msg.requiredMsg')}],
            },
            add:{column:addColumn},
            edit:{column:addColumn},
        })

        const params = reactive({
            // is_belong:'0|gt',
        })
        return {options,btnConfigs,dialogParam,params}
    }
}
</script>

<style lang="scss" scoped>
.lev_rate{font-size: 12px;color:#999;display: inline-block;}
</style>
