<template>
    <table-view :handleWidth="'80px'" :options="options" :searchOption="searchOptions" :dialogParam="dialogParam" :btnConfig="btnConfigs"></table-view>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import tableView from "@/components/common/table"
export default {
    components:{tableView},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const options = reactive([
            {label:proxy.$t('seller.order_settlements.settlement_no'),value:'settlement_no'},
            {label:proxy.$t('seller.order_settlements.total_price'),value:'total_price',type:'tags'},
            {label:proxy.$t('seller.order_settlements.settlement_price'),value:'settlement_price',type:'tags'},
            {label:proxy.$t('seller.order_settlements.status'),value:'status',type:'dict_tags'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
            {label:proxy.$t('seller.order_settlements.status'),value:'status',type:'select'},
        ])

        // 表单配置
        const viewColumn = [
            {label:proxy.$t('seller.order_settlements.settlement_no'),value:'settlement_no'},
            {label:proxy.$t('seller.order_settlements.total_price'),value:'total_price'},
            {label:proxy.$t('seller.order_settlements.settlement_price'),value:'settlement_price'},
            {label:proxy.$t('seller.order_settlements.status'),value:'status',viewType:'dict_tags'},
            {label:proxy.$t('seller.order_settlements.info'),value:'info'},
        ]
        const dialogParam = reactive({
            view:{column:viewColumn},
            dictData:{
                status:[{label:proxy.$t('btn.waitExamine'),value:0},{label:proxy.$t('btn.success'),value:1},{label:proxy.$t('btn.rejected'),value:2}],
            },
        })

        const btnConfigs = reactive({
            store:{show:false},
            update:{show:false},
            destroy:{show:false},
        })
        return {
            options,searchOptions,dialogParam,btnConfigs,
        }
    }
}
</script>

<style>

</style>
