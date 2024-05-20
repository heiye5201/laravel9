<template>
    <div class="user_main table_lists">
        <div class="block_title">
            {{$t('user_center.coupon.index')}}
        </div>
        <div class="x20 clear_line"></div>
        <table-view :handleWidth="80" :options="options" :handleHide="false" pageUrl="/user/coupons"  :btnConfig="btnConfigs"></table-view>
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
            {label:proxy.$t('user_center.coupon.name'),value:'name'},
            {label:proxy.$t('user_center.coupon.money'),value:'money',type:'tags'},
            {label:proxy.$t('user_center.coupon.use_money'),value:'use_money',type:'tags'},
            {label:proxy.$t('user_center.coupon.end_time'),value:'end_time',overFlow:true},
            {label:proxy.$t('user_center.coupon.created_at'),value:'created_at'},
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
