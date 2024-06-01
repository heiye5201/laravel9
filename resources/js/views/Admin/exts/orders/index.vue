<template>
    <table-view :params="params" :searchOption="searchOptions" :btnConfig="btnConfigs" :options="options" :dialogParam="dialogParam">

        <template #table_topleft_hook="{dialogParams}">
            <el-button type="primary" :icon="Promotion" @click="openAddDialog(dialogParams)">订单审核</el-button>
        </template>

        <!-- 物流信息 -->
        <template #table_show_bottom_hook="{formData}">
            <div class="delivery_list" v-if="!R.isEmpty(formData.view.delivery_no) && !R.isEmpty(formData.view.delivery_code)">
                <el-collapse accordion @change="(activeName)=>{collapseChange(formData,activeName)}">
                    <el-collapse-item name="1">
                        <template #title>
                            <el-icon><List /></el-icon>
                            <span style="margin-left:10px">物流信息</span>
                        </template>
                        <el-timeline v-if="data.express.length && data.express.length>0">
                            <el-timeline-item v-for="(v, k) in data.express" :key="k" :timestamp="v.time" :color="k==0?'#0bbd87':null">
                                {{ v.context }}
                            </el-timeline-item>
                        </el-timeline>
                        <el-empty v-else />
                    </el-collapse-item>
                </el-collapse>
            </div>
        </template>
    </table-view>

    <el-dialog custom-class="table_dialog_class" v-model="data.vis" title="订单审核">
        <div class="order_list" >
            <div class="order_title">
                <span class="order_no">确定订单支付成功？</span>
            </div>
            <div class="order_goods">
                <el-row :gutter="20" >
                    <el-col :span="4"></el-col>
                </el-row>
            </div>
        </div>
        <br />
        <div class="dialog_btn">
            <el-button type="primary" :loading="data.loading" @click="postAgreeApplyStatus" :icon="Promotion" >确定</el-button>
            <el-button type="primary" :loading="data.loading" @click="postCancelApplyStatus" :icon="Promotion" >未收到</el-button>

        </div>
    </el-dialog>

</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import { Promotion} from '@element-plus/icons'
import tableView from "@/components/common/table"
import { List  } from '@element-plus/icons'
export default {
    components:{tableView,List},
    setup(props) {
        const {ctx,proxy} = getCurrentInstance()
        const data = reactive({
            express:[]
        })
        const options = reactive([
            {label:'订单图片',value:'order_image',type:'avatar'},
            {label:'订单名称',value:'order_name'},
            {label:'店铺名称',value:'store_name'},
            {label:'买家昵称',value:'buyer_name'},
            {label:'订单总额',value:'total_price'},
            {label:'订单状态',value:'order_status_cn',type:'tags'},
            {label:'审核状态',value:'apply_status_cn',type:'tags'},
            {label:'创建时间',value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
            {label:'订单号',value:'filter[order_no]',where:''},
            {label:'订单名称',value:'filter[order_name]',where:''},
            {label:'订单状态',value:'filter[order_status]',type:'select',data:{
                'filter[order_status]':[
                    {label:proxy.$t('order.orderCancel'),value:0},
                    {label:proxy.$t('order.waitPay'),value:1},
                    {label:proxy.$t('order.waitSend'),value:2},
                    {label:proxy.$t('order.orderConfirm'),value:3},
                    {label:proxy.$t('order.waitComment'),value:4},
                    {label:proxy.$t('order.orderRefund'),value:5},
                    {label:proxy.$t('order.orderCompletion'),value:6},
                ]
            }},
            {label:'审核状态',value:'filter[apply_status]',type:'select',data:{
              'filter[apply_status]':[
                {label:'待审核',value:0},
                {label:'审核通过',value:1},
                {label:'审核拒绝',value:2},
              ]
            }},
        ])

        const params = {
            isWith:'store,user,refund'
        }

        const btnConfigs = reactive({
            store:{show:false},
        })

        // 表单配置
        const viewColumn = [
            {label:'订单图片',value:'order_image',type:'avatar',span:24},
            {label:'订单名称',value:'order_name'},
            {label:'店铺名称',value:'store_name'},
            {label:'买家昵称',value:'buyer_name'},
            {label:'订单总额',value:'total_price'},
            {label:'商品总额',value:'order_price'},
            {label:'优惠价格',value:'coupon_money'},
            {label:'收件人名',value:'receive_name'},
            {label:'收件人手机',value:'receive_tel'},
            {label:'地址信息',value:'receive_area'},
            {label:'详细地址',value:'receive_address'},
            {label:'快递单号',value:'delivery_no'},
            {label:'订单状态',value:'order_status_cn'},
            {label:'审核状态',value:'apply_status_cn'},
            {label:'商品详情',value:'order_goods',type:'array'},
        ]

        const addColumn = [
            {label:'订单名称',value:'order_name'},
            {label:'店铺名称',value:'store_name'},
            {label:'买家昵称',value:'buyer_name'},
            {label:'订单总额',value:'total_price'},
            {label:'商品总额',value:'order_price'},
            {label:'优惠价格',value:'coupon_money'},
            {label:'收件人名',value:'receive_name'},
            {label:'收件人手机',value:'receive_tel'},
            {label:'地址信息',value:'receive_area'},
            {label:'详细地址',value:'receive_address'},
            {label:'快递单号',value:'delivery_no'},
        ]

        const dialogParam = reactive({
            view:{column:viewColumn},
            edit:{column:addColumn},
        })

        // 物流查询
        const collapseChange = (formData,activeName)=>{
            data.express = []
            if(proxy.R.isEmpty(activeName)) return
            const orderId = formData.view.id
            proxy.R.post('/Admin/orders/express/find',{id:orderId}).then(res=>{
                if(!res.code) data.express = res
            })
        }

        const loadData = async ()=>{
            let base64Code = window.btoa(JSON.stringify({order_id:data.selected}))
            const res = await proxy.R.get('/Admin/orders/find/all',{params:base64Code})
            if(!res.code) data.order = res
        }

        const openAddDialog = async (dialogParams)=>{
            const selected = dialogParams.multipleSelection()
            if(!selected) return proxy.$message.error(proxy.$t('msg.selectErr'))
            data.selected = selected
            console.log(data);
            data.vis = true
        }

        const postAgreeApplyStatus = async ()=>{
            data.loading = true
            let sucNum = 0;
            let allNum = data.selected.length
            let base64Code = window.btoa(JSON.stringify({order_id:data.selected,apply_status:1}))
            const loading = ElementPlus.ElLoading.service({
                lock: true,
                text: proxy.$t('order.sendDelivery')+' - '+sucNum+'/'+allNum,
                background: 'rgba(0, 0, 0, 0.7)',
            })
            proxy.R.put('/Admin/orders/status/edit',{params:base64Code}).then(res=>{
                if(!res.code){
                    sucNum = res.update_total;
                    loading.setText(proxy.$t('order.sendDelivery')+' - '+sucNum+'/'+allNum)
                    if(sucNum >= allNum){
                        loading.close()
                        data.loading = false
                        data.vis = false
                        location.reload()
                    }
                } else {
                    loading.setText(res.msg)
                    loading.close()
                    data.loading = false
                    data.vis = false
                }
            }).catch(error=>{
                console.log(error)
            })
        }

        const postCancelApplyStatus = async ()=>{
            data.loading = true
            let sucNum = 0;
            let allNum = data.selected.length
            let base64Code = window.btoa(JSON.stringify({order_id:data.selected,apply_status:2}))
            const loading = ElementPlus.ElLoading.service({
                lock: true,
                text: proxy.$t('order.sendDelivery')+' - '+sucNum+'/'+allNum,
                background: 'rgba(0, 0, 0, 0.7)',
            })
            proxy.R.put('/Admin/orders/status/edit',{params:base64Code}).then(res=>{
                if(!res.code){
                    sucNum = res.update_total;
                    loading.setText(proxy.$t('order.sendDelivery')+' - '+sucNum+'/'+allNum)
                    if(sucNum >= allNum){
                        loading.close()
                        data.loading = false
                        data.vis = false
                        location.reload()
                    }
                } else {
                    loading.setText(res.msg)
                    loading.close()
                    data.loading = false
                    data.vis = false
                }
            }).catch(error=>{
                console.log(error)
            })
        }
        return {options,searchOptions,dialogParam,btnConfigs,params,data,openAddDialog,postAgreeApplyStatus,postCancelApplyStatus,collapseChange}
    }
}
</script>

<style>

</style>
