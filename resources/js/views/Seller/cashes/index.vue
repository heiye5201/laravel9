<template>
    <div class="qwit">
        <table-view :options="options" :handleWidth="'80px'" :params="params" :btnConfig="btnConfigs" :dialogParam="dialogParam" ></table-view>
    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import tableView from "@/components/common/table"
export default {
    components:{tableView},
    setup(props) {
        const {ctx,proxy} = getCurrentInstance()
        const options = reactive([
            {label:proxy.$t('seller.cashes.name'),value:'name'},
            {label:proxy.$t('seller.cashes.money'),value:'money',type:'tags'},
            {label:proxy.$t('seller.cashes.commission'),value:'commission',type:"tags"},
            {label:proxy.$t('seller.cashes.bank_name'),value:'bank_name'},
            {label:proxy.$t('seller.cashes.card_no'),value:'card_no'},
            {label:proxy.$t('seller.cashes.cash_status'),value:'cash_status',type:'dict_tags'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);
        // 表单配置
        const addColumn = [
            {label:proxy.$t('seller.cashes.name'),value:'name'},
            {label:proxy.$t('seller.cashes.bank_name'),value:'bank_name'},
            {label:proxy.$t('seller.cashes.card_no'),value:'card_no'},
            {label:proxy.$t('seller.cashes.money'),value:'money'},
        ]

        let viewColumn = _.cloneDeep(addColumn)
        viewColumn.push({label:proxy.$t('seller.cashes.commission'),value:'commission'})

        const btnConfigs = reactive({
            update:{show:false},
        })

        const dialogParam = reactive({
            dictData:{
                cash_status:[{label:proxy.$t('btn.waitExamine'),value:0},{label:proxy.$t('btn.success'),value:1},{label:proxy.$t('btn.rejected'),value:2}]
            },
            rules:{
                name:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                bank_name:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                card_no:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                money:[{required:true,message:proxy.$t('msg.requiredMsg')}],
            },
            view:{column:viewColumn},
            add:{column:addColumn},
        })

        const params = reactive({
            store_id:'0|gt'
        })
        return {options,btnConfigs,dialogParam,params}
    }
}
</script>

<style>

</style>
