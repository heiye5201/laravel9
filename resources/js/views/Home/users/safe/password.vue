<template>
    <div class="user_main table_lists">
        <div class="block_title">
            {{$t('user_center.safe.user_password')}}
        </div>
        <div class="x20"></div>
        <el-form class="el_form" v-if="dialogParams.add && dialogParams.add.column.length>0" ref="addForm" label-position="right" :rules="dialogParams.rules||null" :model="formData" :label-width="dialogParams.labelWidth" :fullscreen="dialogParams.fullscreen">
            <el-row :gutter="20">
                <el-col v-for="(v,k) in dialogParams.add.column" :key="k" :span="v.span || dialogParams.span"><div class="table-form-content">
                    <el-form-item :label="v.label" :prop="v.value">
                        <q-input :params="v" :dictData="dialogParams.dictData||[]" v-model:formData="formData[v.value]" />
                    </el-form-item>
                </div></el-col>
            </el-row>

            <!-- 按钮处理 -->
            <el-row :gutter="20">
                <el-col :span="24">
                    <el-form-item>
                        <el-button  color="#e50e19" :loading="loading" type="primary" @click="editData">{{$t('btn.determine')}}</el-button>
                        <el-button @click="$refs['addForm'].resetFields()">{{$t('btn.reset')}}</el-button>
                    </el-form-item>
                </el-col>
            </el-row>

        </el-form>
        <el-empty v-else />
    </div>
</template>

<script>
import {reactive,ref,getCurrentInstance} from "vue"
import { useStore } from 'vuex'
export default {
    components:{},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const store = useStore()
        const loading = ref(false)
        const formData = reactive({

        })
        // 表单配置
        const addColumn = [
             {label:proxy.$t('user_center.safe.new_password'),value:'password',type:'password'},
             {label:proxy.$t('user_center.safe.duplicate_password'),value:'re_password',type:'password'},
        ]

        const dialogParams = reactive({
            labelWidth:'180px',
            rules:{
                password:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                re_password:[{required:true,message:proxy.$t('msg.requiredMsg')}],
            },
            add:{column:addColumn},
        })

        const editData = ()=>{
            proxy.$refs.addForm.validate( async (valid)=>{
                // 验证失败直接断点
                if (!valid) return false
                if(formData.password != formData.re_password) return proxy.$message.error(proxy.$t('msg.reInputError'))
                loading.value = true
                try {
                    let formDatas = {password:formData.password}
                    const servUser = await store.dispatch('login/editUserSer',formDatas)
                    if(!servUser.code){
                        proxy.$refs.addForm.resetFields()
                        proxy.$message.success(proxy.$t('msg.success'))
                    }else{
                        proxy.$message.error(servUser.msg)
                    }
                    editUserVis.value = false
                    loading.value = false
                } catch (error) {
                    loading.value = false
                }
            })
        }
        return {dialogParams,loading,formData,editData}
    }
}
</script>
<style lang="scss" scoped>
.el_form{
    width: 529px;
}
</style>
