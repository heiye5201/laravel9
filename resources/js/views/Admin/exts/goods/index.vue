<template>
    <div class="admin_goods_form">
        <table-view :options="options" :searchOption="searchOptions" :btnConfig="btnConfigs" :params="params" :dialogParam="dialogParam" handleWidth='80px'>
            <template #table_handleright_hook="row">
                <el-button :title="$t('btn.edit')"  type="primary" @click="editGoods(row)" :icon="Edit" />
            </template>

            <template #table_topleft_hook="{dialogParams}">
              <el-button type="primary" :icon="Promotion" @click="openAddDialog(dialogParams)">商品审核</el-button>
            </template>
        </table-view>
        <el-dialog v-model="tableVis" :title="$t('btn.edit')">
            <goods-form ref="goods_form"  />
        </el-dialog>

        <el-dialog custom-class="table_dialog_class" v-model="data.vis" title="商品审核">
          <div class="order_list" >
            <div class="order_title">
              <span class="order_no">确定通过审核？</span>
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
            <el-button type="primary" :loading="data.loading" @click="postCancelApplyStatus" :icon="Promotion" >驳回</el-button>
          </div>
        </el-dialog>
    </div>
    
</template>

<script>
import {reactive,ref,getCurrentInstance} from "vue"
import { Edit } from '@element-plus/icons'
import tableView from "@/components/common/table"
import goodsForm from "./form"
export default {
    components:{tableView,goodsForm},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const tableVis = ref(false)
        const data = reactive({
          express:[]
        })
        const params = {
            isWith:'goods_class,goods_brand'
        }
        const options = reactive([
            {label:'图片',value:'goods_master_image',type:'avatar'},
            {label:'名称',value:'goods_name'},
            {label:'品牌',value:'brand_name',type:'tags'},
            {label:'分类',value:'class_name',type:'tags'},
            {label:'价格',value:'goods_price'},
            {label:'库存',value:'goods_stock'},
            {label:'销量',value:'goods_sale'},
            {label:'上架状态',value:'goods_status',type:'dict_tags'},
            {label:'审核状态',value:'goods_verify',type:'dict_tags'},
            // {label:'排序',value:'is_sort'},
            {label:'创建时间',value:'created_at'},
        ]);

        // 搜索字段
        const searchOptions = reactive([
            {label:'名称',value:'filter[goods_name]',where:''},
            {label:'上架状态',value:'filter[goods_status]',type:'select',data:{goods_status:[{label:proxy.$t('btn.yes'),value:1},{label:proxy.$t('btn.no'),value:0}]}},
            {label:'审核状态',value:'filter[goods_verify]',type:'select',data:{goods_verify:[{label:proxy.$t('btn.waitExamine'),value:2},{label:proxy.$t('btn.passExamine'),value:1},{label:proxy.$t('btn.rejected'),value:0}]}},
        ])

        const dialogParam = reactive({
            rules:{
                pid:[{required:true,message:'不能为空'}],
                name:[{required:true,message:'不能为空'}]
            },
            dictData:{
                goods_status:[{label:proxy.$t('btn.yes'),value:1},{label:proxy.$t('btn.no'),value:0}],
                goods_verify:[{label:proxy.$t('btn.waitExamine'),value:2},{label:proxy.$t('btn.passExamine'),value:1},{label:proxy.$t('btn.rejected'),value:0}],
                'filter[goods_verify]':[{label:proxy.$t('btn.waitExamine'),value:2},{label:proxy.$t('btn.passExamine'),value:1},{label:proxy.$t('btn.rejected'),value:0}],
                'filter[goods_status]':[{label:proxy.$t('btn.yes'),value:1},{label:proxy.$t('btn.no'),value:0}],
            },
            addForm:{},
        })
        const btnConfigs = reactive({
            show:{show:false},
            store:{show:false},
            update:{show:false},
        })

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
          let base64Code = window.btoa(JSON.stringify({goods_id:data.selected,apply_status:1}))
          const loading = ElementPlus.ElLoading.service({
            lock: true,
            text: proxy.$t('order.sendDelivery')+' - '+sucNum+'/'+allNum,
            background: 'rgba(0, 0, 0, 0.7)',
          })
          proxy.R.put('/Admin/goods/status/edit',{params:base64Code}).then(res=>{
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
          let base64Code = window.btoa(JSON.stringify({goods_id:data.selected,apply_status:2}))
          const loading = ElementPlus.ElLoading.service({
            lock: true,
            text: proxy.$t('order.sendDelivery')+' - '+sucNum+'/'+allNum,
            background: 'rgba(0, 0, 0, 0.7)',
          })
          proxy.R.put('/Admin/goods/status/edit',{params:base64Code}).then(res=>{
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

        const editGoods = async (e)=>{
            tableVis.value = true
            const editForm = await proxy.R.get('/Admin/goods/'+e.rows.id)
            proxy.$refs.goods_form.editGoods(editForm)
        }
        return {options,searchOptions,dialogParam,btnConfigs,params,tableVis,Edit,editGoods,data,openAddDialog, postAgreeApplyStatus,postCancelApplyStatus}
    }
}
</script>

<style>

</style>