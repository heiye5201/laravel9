<template>
    <div class="qwit">
        <table-view :handleHide="false" :options="options" :searchOption="searchOptions" :params="params" :btnConfig="btnConfigs" :dialogParam="dialogParam" >
            <template #lev="{scopeData}">
                <span class="lev_rate">{{scopeData.lev||0.00}} %</span>
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
            {label:proxy.$t('seller.distributions.log_name'),value:'name'},
            {label:proxy.$t('seller.distributions.store_name'),value:'store_name'},
            {label:proxy.$t('seller.distributions.log_goods_price'),value:'goods_price'},
            {label:proxy.$t('seller.distributions.lev'),value:'lev',type:'custom'},
            {label:proxy.$t('seller.distributions.commission'),value:'commission'},
            {label:proxy.$t('seller.distributions.status'),value:'status',type:'dict_tags'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
          {label:proxy.$t('seller.distributions.log_name'),value:'filter[name]',where:''},
        ])

        const btnConfigs = reactive({
            show:{show:false},
            store:{show:false},
            destroy:{show:false},
        })

        const dialogParam = reactive({
            dictData:{
                status:[{label:proxy.$t('btn.waitExamine'),value:0},{label:proxy.$t('btn.success'),value:1}]
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
