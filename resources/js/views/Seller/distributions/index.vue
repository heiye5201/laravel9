<template>
    <div class="qwit">
        <table-view :handleWidth="'80px'" :options="options" :params="params" :btnConfig="btnConfigs" :dialogParam="dialogParam" >
            <template #lev="{scopeData}">
                <span class="lev_rate">{{$t('seller.distributions.lev_1_rate')}} {{scopeData.lev_1||0.00}} %</span>
                <span class="lev_rate">{{$t('seller.distributions.lev_2_rate')}} {{scopeData.lev_2||0.00}} %</span>
                <span class="lev_rate">{{$t('seller.distributions.lev_3_rate')}} {{scopeData.lev_3||0.00}} %</span>
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
            {label:proxy.$t('seller.distributions.goods_master_image'),value:'goods_master_image',type:'avatar'},
            {label:proxy.$t('seller.distributions.goods_name'),value:'goods_name'},
            {label:proxy.$t('seller.distributions.lev'),value:'lev',type:'custom'},
            {label:proxy.$t('seller.distributions.is_type'),value:'is_type',type:'tags'},
            {label:proxy.$t('seller.distributions.is_belong'),value:'is_belong',type:'tags'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);
        // 表单配置
        const addColumn = [
            {label:proxy.$t('seller.distributions.goods_id'),value:'goods_id',type:'table_select',params:{},
            pageUrl:'/Seller/goods',
            options:[
                {label:proxy.$t('seller.distributions.master_image'),value:'goods_master_image',type:'avatar'},
                {label:proxy.$t('seller.distributions.name'),value:'goods_name'},
                {label:proxy.$t('seller.distributions.brand_name'),value:'brand_name',type:'tags'},
                {label:proxy.$t('seller.distributions.class_name'),value:'class_name',type:'tags'},
                {label:proxy.$t('seller.distributions.goods_price'),value:'goods_price'},
                {label:proxy.$t('seller.distributions.goods_stock'),value:'goods_stock'},
                {label:proxy.$t('seller.distributions.goods_sale'),value:'goods_sale'},
                {label:proxy.$t('common.created_at'),value:'created_at'},
            ]},
            {label:proxy.$t('seller.distributions.lev_1'),value:'lev_1',type:'number'},
            {label:proxy.$t('seller.distributions.lev_2'),value:'lev_2',type:'number'},
            {label:proxy.$t('seller.distributions.lev_3'),value:'lev_3',type:'number'},
        ]


        const btnConfigs = reactive({
            show:{show:false},
        })

        const dialogParam = reactive({
            rules:{
                goods_id:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                lev_1:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                lev_2:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                lev_3:[{required:true,message:proxy.$t('msg.requiredMsg')}],
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
