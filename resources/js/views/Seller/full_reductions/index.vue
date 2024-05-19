<template>
    <div class="qwit">
        <table-view :handleWidth="'80px'" :options="options" :params="params" :searchOption="searchOptions" :btnConfig="btnConfigs" :dialogParam="dialogParam" ></table-view>
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
            {label:proxy.$t('seller.full_reductions.name'),value:'name'},
            {label:proxy.$t('seller.full_reductions.money'),value:'money'},
            {label:proxy.$t('seller.full_reductions.use_money'),value:'use_money'},
            {label:proxy.$t('seller.full_reductions.status'),value:'status',type:'dict_tags'},
            {label:proxy.$t('common.start_time'),value:'start_time'},
            {label:proxy.$t('common.end_time'),value:'end_time'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);
        // 表单配置
        const addColumn = [
            {label:proxy.$t('seller.full_reductions.name'),value:'name'},
            {label:proxy.$t('seller.full_reductions.money'),value:'money',type:'number'},
            {label:proxy.$t('seller.full_reductions.use_money'),value:'use_money',type:'number',span:24},
            {label:proxy.$t('common.start_time'),value:'start_time',type:'datetime'},
            {label:proxy.$t('common.end_time'),value:'end_time',type:'datetime'},
        ]

        // 搜索字段
        const searchOptions = reactive([
          {label:proxy.$t('seller.full_reductions.name'),value:'filter[name]',where:''},
        ])

        const btnConfigs = reactive({
            show:{show:false},
        })

        const dialogParam = reactive({
            dictData:{
                status:[{label:proxy.$t('btn.notStarted'),value:0},{label:proxy.$t('btn.haveInHand'),value:1},{label:proxy.$t('btn.HasEnded'),value:2}]
            },
            rules:{
                name:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                money:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                use_money:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                start_time:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                end_time:[{required:true,message:proxy.$t('msg.requiredMsg')}],
            },
            add:{column:addColumn},
            edit:{column:addColumn},
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
