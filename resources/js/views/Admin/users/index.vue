<template>
    <div class="qwit">
        <table-view :options="options" :handleWidth="210" :searchOption="searchOptions" :dialogParam="dialogParam">
            <template #table_handleright_hook="{rows}">
                <el-button type="success" @click="moneyOpen(rows.id)" :title="$t('btn.add')" :icon="Coin"  />
            </template>
        </table-view>

        <!-- 资金处理 -->
        <el-dialog destroy-on-close  custom-class="table_dialog_class" v-model="editVis" :title="$t('btn.edit')" :width="'30%'">
                <el-row :gutter="20">
                    <el-col :span="24"><div class="table-form-content_money">
                            <el-input v-model="money" type="number">
                                <template #prepend>
                                    <el-select v-model="selectType" placeholder="Select" style="width: 110px">
                                    <el-option :label="$t('user.money')" :value="0"></el-option>
                                    <el-option :label="$t('user.frozen_money')" :value="1"></el-option>
                                    <el-option :label="$t('user.integral')" :value="2"></el-option>
                                    </el-select>
                                </template>
                                <template #append>
                                    {{$t('btn.money')}}
                                </template>
                            </el-input>
                    </div></el-col>
                </el-row>
                <!-- 按钮处理 -->
                <el-row :gutter="20">
                    <el-col :span="24"  style="margin-top:20px;">
                        <div style="text-align:center">
                            <el-button :loading="loading" type="primary" @click="updateData">{{$t('btn.determine')}}</el-button>
                            <el-button @click="editVis = false">{{$t('btn.cancel')}}</el-button>
                        </div>
                    </el-col>
                </el-row>
        </el-dialog>
    </div>
</template>

<script>
import {reactive,ref,getCurrentInstance} from "vue"
import { Coin } from '@element-plus/icons'
import tableView from "@/components/common/table"
export default {
    components:{tableView},
    setup(props) {
        const {ctx,proxy} = getCurrentInstance()
        const editVis = ref(false)
        const loading = ref(false)
        const selectType = ref(0)
        const money = ref(1)
        const id = ref(0)
        // 配置字段
        const options = reactive([
            {label:'头像',value:'avatar',type:'avatar',perView:true},
            {label:'昵称',value:'nickname'},
            {label:'用户名',value:'username',type:'tags'},
            {label:'邮箱',value:'email',type:'tags'},
            {label:'余额',value:'money',type:'tags'},
            {label:'冻结资金',value:'frozen_money',type:'tags'},
            {label:'积分',value:'integral',type:'tags'},
            {label:'登陆时间',value:'last_login_time'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
            {label:'昵称',value:'filter[nickname]',where:''},
            {label:'用户名',value:'filter[username]',where:''},
            {label:'邮箱',value:'filter[email]',where:''}
        ])

        // 表单配置 
        const addColumn = [
             {label:'昵称',value:'nickname'},
             {label:'用户名',value:'username'},
             {label:'邮箱',value:'email'},
             {label:'密码',value:'password',type:'password'},
             {label:'头像',value:'avatar',type:'avatar',perView:true,option:JSON.stringify({width:150,height:150})},
        ]
        let viewColumn = _.cloneDeep(addColumn)
        viewColumn = viewColumn.filter(item=>!item.type || item.type.indexOf('password') == -1)
        viewColumn.push({label: '创建时间', value: 'created_at'});
        const dialogParam = reactive({
            rules:{
                username:[{required:true,message:proxy.$t('msg.requiredMsg')}],
            },
            view:{column:viewColumn},
            add:{column:addColumn},
            edit:{column:addColumn},
        })

        // 金额处理
        const moneyOpen = (e)=>{
            id.value = e
            editVis.value = !editVis.value
        }
        const updateData = ()=>{
            loading.value = true
            proxy.R.post('/Admin/users/money/handle',{id:id.value,is_type:selectType.value,money:money.value}).then(res=>{
                if(!res.code) location.reload()
            }).finally(()=>{
                loading.value = false
                editVis.value = false
            })
        }
        return {options,searchOptions,dialogParam,Coin,editVis,selectType,money,loading,moneyOpen,updateData}
    }
}
</script>

