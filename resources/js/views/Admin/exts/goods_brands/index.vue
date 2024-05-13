<template>
    <table-view :options="options" :searchOption="searchOptions" :dialogParam="dialogParam"></table-view>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import tableView from "@/components/common/table"
export default {
    components:{tableView},
    setup(props) {
        const {ctx,proxy} = getCurrentInstance()
        const options = reactive([
            {label:'品牌图标',value:'thumb',type:'avatar'},
            {label:'品牌名称',value:'name'},
            {label:'排序',value:'is_sort'},
            {label:'推荐',value:'recommend',type:'dict_tags'},
            {label:'wap品牌图标',value:'wap_logo',type:'avatar'},
            {label:'创建时间',value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
            {label:'品牌名称',value:'name',where:'likeRight'},
        ])

        // 表单配置
        const addColumn = [
            {label:'品牌名称',value:'name'},
            {label:'排序',value:'is_sort',type:'number'},
            {label:'推荐',value:'recommend',type:'select',viewType:'dict_tags'},
            {label:'品牌图标',value:'thumb',type:'avatar',span:24},
            {label:'wap品牌图标',value:'wap_logo',type:'avatar',span:24},
        ]

        const dialogParam = reactive({
            rules:{
                name:[{required:true,message:'不能为空'}]
            },
            dictData:{
                recommend:[{label:proxy.$t('config.web.open'),value:1},{label:proxy.$t('config.web.close'),value:0}],
            },
            view:{column:addColumn},
            add:{column:addColumn},
            edit:{column:addColumn},
        })
        return {options,searchOptions,dialogParam}
    }
}
</script>

<style>

</style>
