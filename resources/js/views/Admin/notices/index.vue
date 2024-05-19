<template>
    <div class="qwit">
        <table-view :options="options" :searchOption="searchOptions" :dialogParam="dialogParam"></table-view>
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
            {label:'标题',value:'name'},
            {label:'标签',value:'tag',type:"tags"},
            {label:'创建时间',value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
            {label:'标题',value:'filter[name]',where:''},
            {label:'标签',value:'filter[tag]',where:''},
            {label:'内容',value:'filter[content]',where:''},
        ])

        // 表单配置 
        const addColumn = [
            {label:'标题',value:'name',type:'text'},
            {label:'标签',value:'tag', type:'text'},
            {label:'内容',value:'content',type:'editor',span:24,viewType:'html'},
        ]
        const dialogParam = reactive({
            rules:{
                name:[{required:true, message:'不能为空'}]
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