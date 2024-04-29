<template>
    <div class="user_main table_lists">
        <div class="block_title">
            {{$t('user_center.comments.my_info')}}
        </div>
        <div class="x20 clear_line"></div>
        <table-view :handleWidth="80" :options="options" :params="{isResource:'HomeUser',isWith:'goods,user'}" :btnConfig="btnConfigs" :dialogParam="dialogParam"></table-view>
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
            {label:proxy.$t('user_center.comments.goods_image'),value:'goods_master_image',type:'avatar'},
            {label:proxy.$t('user_center.comments.goods_name'),value:'goods_name',overFlow:true},
            {label:proxy.$t('user_center.comments.synthesize_score'),value:'score',overFlow:true},
            {label:proxy.$t('user_center.comments.description_match'),value:'agree',overFlow:true},
            {label:proxy.$t('user_center.comments.service_state'),value:'service',overFlow:true},
            {label:proxy.$t('user_center.comments.delivery_speed'),value:'speed',overFlow:true},
            {label:proxy.$t('user_center.comments.content'),value:'content',overFlow:true},
            {label:proxy.$t('user_center.comments.created_at'),value:'created_at'},
        ]);
        // 表单配置
        const addColumn = [
             {label:proxy.$t('user_center.comments.nickname'),value:'nickname'},
             {label:proxy.$t('user_center.comments.username'),value:'username'},
             {label:proxy.$t('user_center.comments.password'),value:'password',type:'password'},
             {label:proxy.$t('user_center.comments.role'),value:'role_id',type:'select',multiple:true,labelName:'name',valueName:'id',viewType:'tags_array'},
             {label:proxy.$t('user_center.comments.avatar'),value:'avatar',type:'avatar',perView:true,option:JSON.stringify({width:150,height:150})},
        ]

        const btnConfigs = reactive({
            store:{show:false},
            show:{show:false},
            search:{show:false},
            export:{show:false},
            destroy:{show:false},
            update:{show:false},
        })
        const dialogParam = reactive({
            view:{column:addColumn},
            add:{column:addColumn},
            edit:{column:addColumn},
        })

        return {options,dialogParam,btnConfigs}
    }
}
</script>
<style lang="scss" scoped>

</style>
