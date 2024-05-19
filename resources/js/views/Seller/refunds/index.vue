<template>
    <div class="qwit">
        <table-view pageUrl='/Seller/orders'  :params="params" :btnConfig="btnConfigs" :options="options" :searchOption="searchOptions" :dialogParam="dialogParam">
            <template #table_topleft_hook="{dialogParams}">
                <el-button type="primary" :icon="Finished" @click="openAddDialog(dialogParams)">{{$t('seller.refunds.refund_title')}}</el-button>
            </template>
        </table-view>
        <el-dialog custom-class="table_dialog_class" v-model="data.vis" :title="$t('seller.refunds.order_title')">
            <div class="order_list" v-for="(v,k) in data.order" :key="k">
                <div class="order_title">
                    <span class="order_no">{{$t('seller.refunds.order_no')}}：{{v.order_no}}</span>
                </div>
                <div class="order_goods">
                    <el-row :gutter="20" v-for="(vo,key) in v.order_goods" :key="key">
                        <el-col :span="4">
                            <el-image :style="{width:'30px',height:'30px'}" :fit="'cover'" :hide-on-click-modal="true" :src="vo.goods_image" lazy >
                                <template #error>
                                    <el-icon :color="'#888'" :size="26"><Picture /></el-icon>
                                </template>
                            </el-image>
                        </el-col>
                        <el-col :span="4">{{vo.goods_name||'-'}}</el-col>
                        <el-col :span="4">{{vo.sku_name||'-'}}</el-col>
                        <el-col :span="4">{{$t('btn.money')}}{{vo.goods_price||'-'}}</el-col>
                        <el-col :span="4">x {{vo.buy_num||'-'}}</el-col>
                        <el-col :span="4" style="color:red">{{$t('btn.money')}}{{vo.total_price||'0.00'}}</el-col>
                    </el-row>
                </div>
                <div class="delivery_input">
                    <el-form label-position="right" :label-width="'70px'">
                        <el-row :gutter="20" >
                            <el-col :span="12">
                                <el-form-item :label="$t('seller.refunds.delivery_code')">{{v.delivery_code||'-'}}</el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item :label="$t('seller.refunds.delivery_no_label')">{{v.delivery_no||'-'}}</el-form-item>
                            </el-col>
                            <el-col :span="24">
                                <el-form-item :label="$t('seller.refunds.refuse_remark')"><el-input type="textarea" v-model="data.order[k].refuse_remark" /></el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </div>
            </div>
            <div class="dialog_btn">
                <el-button type="primary" :loading="data.loading" @click="postDelivery(1)" :icon="Finished" >{{$t('btn.determine')}}</el-button>
                <el-button type="danger" :loading="data.loading" @click="postDelivery(2)" :icon="CircleClose" >{{$t('btn.rejecte')}}</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import { Promotion,Printer,Picture,Finished,CircleClose  } from '@element-plus/icons'
import tableView from "@/components/common/table"
import {useRoute} from "vue-router"
export default {
    components:{tableView},
    setup(props) {
        const {ctx,proxy} = getCurrentInstance()
        const route  = useRoute()
        const data = reactive({
            selected:[],
            vis:false,
            order:[],
            delivery:[],
            loading:false,
        })
        const options = reactive([
            {label:proxy.$t('seller.refunds.order_image'),value:'order_image',type:'avatar'},
            {label:proxy.$t('seller.refunds.order_name'),value:'order_name'},
            {label:proxy.$t('seller.refunds.store_name'),value:'store_name'},
            {label:proxy.$t('seller.refunds.buyer_name'),value:'buyer_name'},
            {label:proxy.$t('seller.refunds.total_price'),value:'total_price'},
            {label:proxy.$t('seller.refunds.order_status_cn'),value:'order_status_cn',type:'tags'},
            {label:proxy.$t('common.created_at'),value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
            {label:proxy.$t('seller.refunds.order_no'),value:'filter[order_no]',where:''},
            {label:proxy.$t('seller.refunds.order_name'),value:'filter[order_name]',where:''},
        ])

        const params = {
            isWith:'store,user,refund',
            'filter[order_status]':5,
            'filter[refund_status]':0
        }

        const btnConfigs = reactive({
            store:{show:false},
            destroy:{show:false},
        })


        // 表单配置
        const addColumn = [
            {label:proxy.$t('seller.refunds.order_image'),value:'order_image',type:'avatar',span:24},
            {label:proxy.$t('seller.refunds.order_name'),value:'order_name'},
            {label:proxy.$t('seller.refunds.store_name'),value:'store_name'},
            {label:proxy.$t('seller.refunds.buyer_name'),value:'buyer_name'},
            {label:proxy.$t('seller.refunds.total_price'),value:'total_price'},
            {label:proxy.$t('seller.refunds.order_price'),value:'order_price'},
            {label:proxy.$t('seller.refunds.coupon_money'),value:'coupon_money'},
            {label:proxy.$t('seller.refunds.receive_name'),value:'receive_name'},
            {label:proxy.$t('seller.refunds.receive_tel'),value:'receive_tel'},
            {label:proxy.$t('seller.refunds.receive_area'),value:'receive_area'},
            {label:proxy.$t('seller.refunds.receive_address'),value:'receive_address'},
            {label:proxy.$t('seller.refunds.delivery_no'),value:'delivery_no'},
            {label:proxy.$t('seller.refunds.order_status_cn'),value:'order_status_cn'},
        ]
        const editColumn = [
            {label:proxy.$t('seller.refunds.receive_name'),value:'receive_name'},
            {label:proxy.$t('seller.refunds.receive_tel'),value:'receive_tel'},
            {label:proxy.$t('seller.refunds.receive_area'),value:'receive_area'},
            {label:proxy.$t('seller.refunds.receive_address'),value:'receive_address'},
            {label:proxy.$t('seller.refunds.delivery_no'),value:'delivery_no'},
        ]
        const dialogParam = reactive({
            rules:{
                name:[{required:true,message:proxy.$t('common.not_null')}]
            },
            view:{column:addColumn},
            edit:{column:editColumn},
        })

        const loadData = async ()=>{
            delivery() // 加载物流公司
            let base64Code = window.btoa(JSON.stringify({order_id:data.selected}))
            const res = await proxy.R.get('/Seller/orders/find/all',{params:base64Code})
            if(!res.code) data.order = res
        }

        const delivery = ()=>{
            if(data.delivery.length != 0) return
            proxy.R.get('/expresses',{isAll:true}).then(res=>{
                if(!res.code) data.delivery = res
            })
        }

        const openAddDialog = async (dialogParams)=>{
            const selected = dialogParams.multipleSelection()
            if(!selected) return proxy.$message.error(proxy.$t('msg.selectErr'))
            data.selected = selected
            await loadData()
            data.order.forEach((item,key)=>{
                item.status = 5
                item.refund_status = 2
            })
            data.vis = true
        }

        const postDelivery = async (e)=>{
            data.loading = true
            let sucNum = 0;
            let allNum = data.order.length
            const loading = ElementPlus.ElLoading.service({
                lock: true,
                text: proxy.$t('order.sendDelivery')+' - '+sucNum+'/'+allNum,
                background: 'rgba(0, 0, 0, 0.7)',
            })
            data.order.map(item=>{
                let putData = {
                    refund_verify:e,
                    refuse_remark:item.refuse_remark??''
                }
                proxy.R.put('/Seller/refunds/'+item.id,putData).then(()=>{
                }).finally(()=>{
                    sucNum++
                    loading.setText(proxy.$t('order.sendDelivery')+' - '+sucNum+'/'+allNum)
                    if(sucNum >= allNum){
                        loading.close()
                        data.loading = false
                        data.vis = false
                        location.reload()
                    }
                })
            })

        }


        return {
            Promotion,Printer,Picture,Finished,CircleClose,
            options,searchOptions,dialogParam,btnConfigs,params,data,
            openAddDialog,postDelivery
        }
    }
}
</script>

<style lang="scss" scoped>
.order_title{
    border-bottom: 1px solid #efefef;
    padding-bottom: 15px;
    .order_no{
        border-left: 4px solid var(--el-color-primary);
        padding-left: 10px;
    }
}
.order_goods{
    margin-top: 15px;
    line-height: 30px;
    border-bottom: 1px solid #efefef;
}
.delivery_input{
    margin-top: 15px;
    margin-bottom: 15px;
}
.dialog_btn{
    padding-top: 15px;
    border-top: 1px solid #efefef;
    text-align: center;
}
</style>
