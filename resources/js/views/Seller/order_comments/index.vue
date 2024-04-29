<template>
    <div class="qwit">
        <table-view  :options="options" :params="params" :btnConfig="btnConfigs" :dialogParam="dialogParam" ></table-view>
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
            {label:proxy.$t('seller.order_comments.avatar'),value:'avatar',type:'avatar'},
            {label:proxy.$t('seller.order_comments.nickname'),value:'nickname'},
            {label:proxy.$t('seller.order_comments.goods_master_image'),value:'goods_master_image',type:'avatar'},
            {label:proxy.$t('seller.order_comments.goods_name'),value:'goods_name'},
            {label:proxy.$t('seller.order_comments.score'),value:'score',type:'tags'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);
        // 表单配置
        const addColumn = [
            {label:proxy.$t('seller.order_comments.reply'),value:'reply',type:'textarea',span:24},
        ]
        const viewColumn = [
            {label:proxy.$t('seller.order_comments.avatar'),value:'avatar',type:'avatar'},
            {label:proxy.$t('seller.order_comments.nickname'),value:'nickname'},
            {label:proxy.$t('seller.order_comments.goods_master_image'),value:'goods_master_image',type:'avatar'},
            {label:proxy.$t('seller.order_comments.goods_name'),value:'goods_name'},
            {label:proxy.$t('seller.order_comments.score'),value:'score'},
            {label:proxy.$t('seller.order_comments.image'),value:'image',viewType:'images',perView:true,span:24},
            {label:proxy.$t('seller.order_comments.content'),value:'content',viewType:'html',span:24},
            {label:proxy.$t('seller.order_comments.reply'),value:'reply',viewType:'html',span:24},
        ]

        const btnConfigs = reactive({
            store:{show:false},
            destroy:{show:false},
        })

        const dialogParam = reactive({
            view:{column:viewColumn},
            edit:{column:addColumn},
        })

        const params = reactive({
        })
        return {options,btnConfigs,dialogParam,params}
    }
}
</script>

<style>

</style>
