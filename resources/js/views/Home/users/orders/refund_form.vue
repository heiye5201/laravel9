<template>
    <div class="user_user_info">
        <div class="user_main">
            <div class="block_title">
                {{$t('user_center.order.refund.refund_from')}}
            </div>
            <div class="x20"></div>

            <el-form class="el_form"  ref="addForm" label-position="right" :rules="dialogParams.rules||null" :model="data.formData" :label-width="dialogParams.labelWidth" :fullscreen="dialogParams.fullscreen">
                <el-row :gutter="20">
                    <el-col  :span="24"><div class="table-form-content">
                        <el-form-item :label="$t('user_center.order.refund.after_sales_type')">
                            {{data.info.refund_type==0?$t('user_center.order.refund.refund'):(data.info.refund_type==1?$t('user_center.order.refund.exchange'):$t('user_center.order.refund.after_end'))}}
                        </el-form-item>
                    </div></el-col>
                  <el-col  :span="24"><div class="table-form-content">
                    <el-form-item :label="$t('home.carts.order_sn')">
                      {{data.info.order.order_no}}
                    </el-form-item>
                  </div></el-col>

                  <el-col  :span="24"><div class="table-form-content">
                    <el-form-item :label="$t('user_center.order.refund.after_sales_reasons')">
                      {{data.info.refund_remark}}
                    </el-form-item>
                  </div></el-col>
                    <el-col  :span="24"><div class="table-form-content">
                        <el-form-item :label="$t('user_center.order.refund_from.after_status')">
                            <el-tag v-if="data.info.refund_verify==0">{{$t('user_center.order.refund_from.wait_apply')}}</el-tag>
                            <el-tag type="success" v-if="data.info.refund_verify==1">{{$t('user_center.order.refund_from.apply_success')}}</el-tag>
                            <el-tag type="danger" v-if="data.info.refund_verify==2">{{$t('user_center.order.refund_from.apply_refuse')}}</el-tag>
                        </el-form-item>
                    </div></el-col>
                    <el-col  :span="24"><div class="table-form-content">
                        <el-form-item :label="$t('user_center.order.refund_from.after_sales')">
                            <el-tag type="danger" v-if="data.info.refund_verify==0">{{$t('user_center.order.refund_from.wait_apply')}}</el-tag>
                            <el-tag type="danger" v-if="data.info.refund_verify==2">{{$t('user_center.order.refund_from.refuse_apply')}}</el-tag>
                            <el-tag type="warning" v-if="data.info.refund_step==0 && data.info.refund_verify==1">{{$t('user_center.order.refund_from.wait_user_send')}}</el-tag>
                            <el-tag type="warning" v-if="data.info.refund_step==1">{{$t('user_center.order.refund_from.wait_confirm_send')}}</el-tag>
                            <el-tag v-if="data.info.refund_step==2">{{$t('user_center.order.refund_from.wait_user_confirm')}}</el-tag>
                            <el-tag type="success" v-if="data.info.refund_step==3">{{$t('user_center.order.refund_from.after_complete')}}</el-tag>
                        </el-form-item>
                    </div></el-col>
                    <el-col  :span="24"><div class="table-form-content" v-if="data.info.refund_type==1 && data.info.refund_verify==1  && data.info.refund_step==0">
                        <el-form-item :label="$t('user_center.order.refund_from.delivery_no')">
                            <el-input v-model="data.formData.delivery_no" />
                        </el-form-item>
                    </div></el-col>
                    <el-col  :span="24"><div class="table-form-content" v-if="data.info.refund_verify==2">
                        <el-form-item :label="$t('user_center.order.refund_from.refuse_remark')">
                            {{data.info.refuse_remark}}
                        </el-form-item>
                    </div></el-col>
                    <el-col  :span="24"><div class="table-form-content" v-if="data.info.delivery_no!=''">
                        <el-form-item :label="$t('user_center.order.refund_from.user_delivery_no')">
                            {{data.info.delivery_no}}
                        </el-form-item>
                    </div></el-col>
                    <el-col  :span="24"><div class="table-form-content" v-if="data.info.re_delivery_no!=''">
                        <el-form-item :label="$t('user_center.order.refund_from.re_delivery_no')">
                            {{data.info.re_delivery_no}}
                        </el-form-item>
                    </div></el-col>
                </el-row>

                <!-- 按钮处理 -->
                <el-row :gutter="20">
                    <el-col :span="24">
                        <el-form-item>
                            <el-button color="#e50e19" :loading="loading" type="primary" v-if="data.info.refund_step==0 && data.info.refund_type==1 && data.info.refund_verify==1" @click="editData">{{$t('btn.determine')}}</el-button>
                            <el-button :loading="loading" type="success" v-if="data.info.refund_step==2" @click="editData2">{{$t('btn.determine')}}</el-button>
                        </el-form-item>
                    </el-col>
                </el-row>

            </el-form>

        </div>

    </div>
</template>

<script>
import {reactive,ref,onMounted,getCurrentInstance} from "vue"
import {useRoute,useRouter} from "vue-router"
export default {
    setup() {
        const {proxy} = getCurrentInstance()
        const route = useRoute()
        const router = useRouter()
        const loading = ref(false)
        const data = reactive({
            formData:{
                order_id:0,
            },
            info:{},

        })
        // 表单配置
        const addColumn = [

        ]
        const dialogParams = reactive({
            labelWidth:'180px',
            dictData:{
                refund_type:[{label:proxy.$t('user_center.order.refund.refund'),value:0},{label:proxy.$t('user_center.order.refund.return'),value:1}]
            },
            rules:{
                refund_type:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                refund_remark:[{required:true,message:proxy.$t('msg.requiredMsg')}],
            },
            add:{column:addColumn},
        })

        const editData = ()=>{
            proxy.$refs.addForm.validate( async (valid)=>{
                // 验证失败直接断点
                if (!valid) return false
                loading.value = true
                try {
                    const resp = await proxy.R.put('/user/order/refund/'+data.formData.order_id,data.formData)
                    if(!resp.code){
                        proxy.$message.success(proxy.$t('msg.success'))
                        router.push('/user/orders')
                    }
                    loading.value = false
                } catch (error) {
                    loading.value = false
                }
            })
        }
        const editData2 = ()=>{
           proxy.R.put('/user/order/refund/'+data.formData.order_id,{refund_step:3}).then(res=>{
               if(!res.code){
                    proxy.$message.success(proxy.$t('msg.success'))
                    router.push('/user/orders')
                }
           })
        }
        const loadData = async ()=>{
            data.formData.order_id = route.params.id
            proxy.R.get('/user/order/refund/'+data.formData.order_id).then(res=>{
                if(!res.code) data.info = res
            })
        }
        onMounted( async ()=>{
            await loadData()
        })
        return {dialogParams,loading,data,editData,editData2}
    },
};
</script>
<style lang="scss" scoped>

</style>
