<template>
    <div class="user_main table_lists">
        <div class="block_title">
            {{$t('user_center.frozen_money.pc_money')}}
        </div>
        <div class="x20 clear_line"></div>
        <table-view :handleWidth="80" :options="options" :handleHide="false" pageUrl="/user/money_logs" :params="{is_type:0}" :btnConfig="btnConfigs"></table-view>
    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import tableView from "@/components/common/table"
export default {
    components:{tableView},
    setup(props) {
        const {ctx,proxy} = getCurrentInstance()
        // 配置字段
        const options = reactive([
            {label:proxy.$t('user_center.frozen_money.name'),value:'name'},
            {label:proxy.$t('user_center.frozen_money.money'),value:'money',type:'money'},
            {label:proxy.$t('user_center.frozen_money.info'),value:'info',overFlow:true},
            {label:proxy.$t('user_center.frozen_money.created_at'),value:'created_at'},
        ]);
        const btnConfigs = reactive({
            store:{show:false},
            show:{show:false},
            search:{show:false},
            export:{show:false},
            destroy:{show:false},
            update:{show:false},
        })
        return {options,btnConfigs}
    }
}
</script>
<style lang="scss" scoped>

</style>
