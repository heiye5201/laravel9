<template>
    <div class="qwit">
        <table-view :handleHide="false" :options="options" :params="params" :searchOption="searchOptions" :btnConfig="btnConfigs" :dialogParam="dialogParam" ></table-view>
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
            {label:proxy.$t('seller.coupons.log_name'),value:'name'},
            {label:proxy.$t('seller.coupons.nickname'),value:'nickname'},
            {label:proxy.$t('seller.coupons.money'),value:'money'},
            {label:proxy.$t('seller.coupons.log_status'),value:'status',type:'dict_tags'},
            {label:proxy.$t('seller.coupons.created_at'),value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
          {label:proxy.$t('seller.coupons.log_name'),value:'filter[name]',where:''},
        ])

        const btnConfigs = reactive({
            show:{show:false},
            store:{show:false},
            destroy:{show:false},
        })

        const dialogParam = reactive({
            dictData:{
                status:[{label:proxy.$t('btn.waitUse'),value:0},{label:proxy.$t('btn.used'),value:1}]
            },
        })

        const params = reactive({
            // is_belong:'0|gt',
        })
        return {options,btnConfigs,dialogParam,params,searchOptions}
    }
}
</script>

<style lang="scss" scoped>
.lev_rate{font-size: 12px;color:#999;display: inline-block;}
</style>
