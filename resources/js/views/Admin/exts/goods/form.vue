<template>
    <div class="goods_form">
        <div class="goods_form_item" v-if="data.step == 1">
            <el-form ref="addForm" label-position="right" :model="data.form" :rules="data.rules" label-width="80px">
                <el-row :gutter="20">
                    <el-col :span="24">
                        <el-form-item :label="'商品分类'">
                            <el-breadcrumb style="line-height:28px;background:#f4f4f4;padding-left:10px;">
                                <el-breadcrumb-item v-for="(v,k) in data.choseItem" :key="k">{{v.name}}</el-breadcrumb-item>
                            </el-breadcrumb>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item :label="'商品标题'" prop="goods_name"><el-input v-model="data.form.goods_name" /></el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item :label="'副标题'" prop="goods_subname"><el-input type="textarea" v-model="data.form.goods_subname" show-word-limit maxlength="120" /></el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="'商品编号'" prop="goods_no"><el-input v-model="data.form.goods_no" placeholder="A123456789" /></el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="'商品品牌'" prop="brand_id">
                            <q-input :params="{value:'brand_id',type:'select',labelName:'name',valueName:'id'}" v-model:formData="data.form.brand_id" :dictData="{brand_id:data.goodsBrands}" />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :span="24">
                        <el-form-item :label="'商品图片'" prop="goods_images">
                            <div class="goods_image">
                                <div class="item" v-if="data.form.goods_images">
                                    <div class="item_img" v-for="(v,k) in data.form.goods_images" :key="k" >
                                        <div class="item_master" v-if="data.form.goods_master_image==v"><el-icon><CircleCheck /></el-icon>&nbsp;主图展示</div>
                                        <img :src="v" />
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="item noimg" v-else><el-icon ><CameraFilled /></el-icon></div>
                            </div>
                        </el-form-item>
                    </el-col>

                    <el-col :span="12">
                        <el-form-item :label="'平台价格'" prop="goods_price">
                            <el-input type="number" v-model="data.form.goods_price" >
                                <template #suffix>{{$t('btn.money')}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="'市场价格'" prop="goods_market_price">
                            <el-input type="number" v-model="data.form.goods_market_price" >
                                <template #suffix>{{$t('btn.money')}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="'商品重量'" prop="goods_weight">
                            <el-input type="number" v-model="data.form.goods_weight" >
                                <template #suffix>Kg</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="'商品库存'" prop="goods_stock">
                            <el-input type="number" v-model="data.form.goods_stock" :suffix-icon="PieChart" />
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item :label="'商品详情'" prop="goods_content">
                            <q-input :params="{value:'goods_content',type:'editor'}" v-model:formData="data.form.goods_content" />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :span="24">
                        <el-form-item >
                            <!-- 规格SKU start -->
                            <div class="goods_specs" v-if="data.form.skuList && data.form.skuList.length>0">
                                <div class="row_th">
                                    <el-row :gutter="16">
                                        <el-col class="col_th thc" :span="4">SKU</el-col>
                                        <el-col class="col_th thc" :span="4">市场价</el-col>
                                        <el-col class="col_th thc" :span="4">平台价</el-col>
                                        <el-col class="col_th thc" :span="4">重量</el-col>
                                        <el-col class="col_th thc" :span="4">库存</el-col>
                                        <el-col class="col_th thc" :span="4">图片</el-col>
                                    </el-row>
                                </div>
                                <div class="row_td">
                                    <el-row :gutter="16" v-for="(v,k) in data.form.skuList" :key="k">
                                        <el-col class="col_th" :span="4">{{v.sku_name.join(' ')}}</el-col>
                                        <el-col class="col_th" :span="4">
                                            <el-input v-model="v.goods_market_price" type="number" >
                                                <template #suffix>{{$t('btn.money')}}</template>
                                            </el-input>
                                        </el-col>
                                        <el-col class="col_th" :span="4">
                                            <el-input v-model="v.goods_price" type="number" >
                                                <template #suffix>{{$t('btn.money')}}</template>
                                            </el-input>
                                        </el-col>
                                        <el-col class="col_th" :span="4">
                                            <el-input v-model="v.goods_weight" type="number" >
                                                <template #suffix>Kg</template>
                                            </el-input>
                                        </el-col>
                                        <el-col class="col_th" :span="4">
                                            <el-input type="number" v-model="v.goods_stock" :suffix-icon="PieChart" />
                                        </el-col>
                                        <el-col class="col_th" :span="4">-</el-col>
                                    </el-row>
                                </div>
                            </div>
                                <!-- 规格sku end -->
                        </el-form-item>
                    </el-col>

                    <el-col :span="12">
                        <el-form-item :label="'是否上架'" prop="goods_status">
                            <q-input :params="{value:'goods_status',type:'radio'}" v-model:formData="data.form.goods_status" :dictData="{goods_status:[{label:$t('btn.yes'),value:1},{label:$t('btn.no'),value:0}]}" />
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="'推荐位'" prop="is_master">
                            <q-input :params="{value:'is_master',type:'radio'}" v-model:formData="data.form.is_master" :dictData="{is_master:[{label:$t('btn.yes'),value:1},{label:$t('btn.no'),value:0}]}" />
                        </el-form-item>
                    </el-col>

                    <el-col :span="24">
                        <el-form-item >
                            <el-button :icon="CircleCheck" type="success" :loading="loading" @click="nextStep(2)">{{$t('btn.release')}}</el-button>
                        </el-form-item>
                    </el-col>
                    
                </el-row>
            </el-form>
        </div>

    </div>
</template>

<script>
import {reactive,ref,getCurrentInstance} from "vue"
import {ArrowRight,Delete,Upload,CameraFilled,PieChart,Picture,CircleCheck, Reading,CircleCheckFilled,List,SetUp } from '@element-plus/icons'
export default {
    components: {ArrowRight,Upload,CameraFilled,PieChart,Picture,Delete,CircleCheck, Reading,CircleCheckFilled,List,SetUp},
    setup(props) {
        const {ctx,proxy} = getCurrentInstance()
        const loading = ref(false)
        const data = reactive({
            centerDialogVisible:false,
            isEdit:false,
            classList:[],
            attrList:[],
            attrListCheck:[],
            goodsAttr:[],
            goodsBrands:[],
            choseId:[0,0,0],
            choseItem:[{},{},{}],
            index:[0,0,0],
            step:1,
            form:{},
            rules:{
                goods_name:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                goods_images:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                goods_price:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                goods_market_price:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                goods_weight:[{required:true,message:proxy.$t('msg.requiredMsg')}],
            },
        })
        const nextStep = (e)=>{
            if(e == 2){
                proxy.$refs.addForm.validate((valid)=>{
                    // 验证失败直接断点
                    if (!valid) return false
                    loading.value = true
                    try {
                        // 插入栏目Id
                        data.form.class_id = data.choseId[2]
                        let url = '/Admin/goods'
                        let method = 'post'

                        if(data.isEdit){
                            url += '/'+data.form.id
                            method = 'put'
                        }
                        proxy.R[method](url,data.form).then(res=>{
                            if(!res.code){
                                goodsBack();
                                proxy.$message.success(proxy.$t('msg.success'))
                            }
                        }).catch((err)=>{
                            console.log(err)
                        }).finally(()=>{
                            loading.value = false
                        })
                    } catch (error) {
                        loading.value = false
                    }
                })
                return
            }
            if(data.step == 1){
                let status = false
                proxy.$refs.addForm.validate((valid)=>{
                    status = valid
                })
                if (!status) return false
            }
            data.step = e
        }

        // 获取品牌信息
        const goodsBrand = async ()=>{
            data.goodsBrands = await proxy.R.get('/Admin/goods_brands?isAll=true')
        }

        const editGoods = (e)=>{
            data.step = 1
            data.isEdit = true
            data.choseItem = e.classList
            data.form = e
            data.goodsAttr = e.attrList
            data.attrListCheck = e.attrList?.map(item=>item.id)
        }

        // 公共返回列表页面
        const goodsBack = ()=>{
            location.reload();
        }

        goodsBrand()

        return {
            nextStep,
            goodsBack,editGoods,data,
            Picture,PieChart,Upload,CircleCheck,loading
        }
    }
}
</script>

<style lang="scss" scoped>
.step{
    height: 46px;
    line-height: 46px;
    background: #F5F7FA;
    margin-bottom: 50px;
    display: flex;
    .item{
        flex: 1;
        font-size: 16px;
        color:#C0C4CC;
        text-align: center;
        border-right: 4px solid #fff;
        justify-content: center;
        align-items: center;
        display: flex;
        i{
            margin-right: 10px;
        }
        &.check{
            color:#333;
            font-weight: bold;
        }
        &.success{
            color:#67C23A;
            font-weight: bold;
        }
        &:last-child{
            margin-right: 0px;
        }
    }
}
.goods_chose{
    .chose_class_btn{
        margin:40px 0;
        display: block;
        text-align: center;
    }
    .chose_class_bg_item{
        width: 30%;
        background: #fff;
        box-sizing: border-box;
        padding:10px;
        border: 1px solid #efefef;
        border-radius: 4px;
        float: left;
        margin-right: 5%;
        height: 398px;
        &:last-child{
            margin-right: 0;
        }
        &.disabled{
            background: #fafafa;
        }
        ul li{
            cursor: pointer;
            padding:4px 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #fff;
            i{
                float:right;
                line-height: 24px;
                margin-top: 3px;
            }
            &.checked{
                border: 1px solid #d9ecff;
                background: #ecf5ff;
                color: #409eff;
                border-radius: 3px;
            }
            &:hover{
                border: 1px solid #d9ecff;
                background: #ecf5ff;
                color: #409eff;
                border-radius: 3px;
            }
        }
    }

    .goods_add_chose_class_bg{
        box-sizing: border-box;
        background: #fafafa;
        padding: 40px;
        width: 100%;
        margin: 0 auto;
        border: 1px solid #eee;
        border-radius: 5px;
        &:after{
            content:'';
            clear:both;
            display: block;
        }
    }
}
.goods_image{
    width: 100%;
    .item{
        &.noimg{
            width:160px;
            height: 160px;
            background: #efefef;
            text-align: center;
            border-radius: 4px;
            i{
                font-size: 40px;
                line-height: 160px;
                margin-top: 60px;
                color:#999;
            }
        }
        .item_img{
            width: 160px;
            height: 160px;
            display: block;
            float: left;
            box-sizing: border-box;
            margin-right: 10px;
            margin-bottom: 10px;
            position: relative;
            border:1px solid #efefef;
            .item_bg{
                border-radius: 4px;
                text-align: center;
                line-height: 160px;
                display: none;
                width: 100%;
                height: 100%;
                position: absolute;
                color:#fff;
                top:0;
                left:0;
                background: rgba(0,0,0,0.5);/* IE9、标准浏览器、IE6和部分IE7内核的浏览器(如QQ浏览器)会读懂 */
                i{
                    padding: 0 14px;
                    font-size: 16px;
                    cursor: pointer;
                }
            }
            @media \0screen\,screen\9 {/* 只支持IE6、7、8 */
                .item_bg{
                    background-color:#000;
                    filter:Alpha(opacity=50);
                    position:static; /* IE6、7、8只能设置position:static(默认属性) ，否则会导致子元素继承Alpha值 */
                    *zoom:1; /* 激活IE6、7的haslayout属性，让它读懂Alpha */
                }
                .item_bg span{
                    position: relative;/* 设置子元素为相对定位，可让子元素不继承Alpha值 */
                }  
            }
            img{
                width: 100%;
                height: 100%;
                border-radius: 4px;
            }
            .item_master{
                position: absolute;
                left:0;
                bottom: 0;
                border-radius: 0 0 4px 4px;
                background: #000;
                line-height: 26px;
                height: 26px;
                width: 100%;
                z-index: 3;
                background: rgba(0,0,0,0.5);
                color:#fff;
                text-align: center;
                font-size: 12px;
            }
            &:hover .item_bg{
                display: block;
            }
        }
    }
    
    
}
.goods_image_class{
}
.goods_upload_btn{
    padding-top: 15px;
    display: flex;
}
.goods_upload_btns{
    margin-right: 10px;
}
.goods_specs{
    border:1px solid #efefef;
    margin-top: 10px;
    padding-bottom: 10px;
}
.row_th{
    background: #efefef;
}
.col_th{
    text-align: center;
    padding-top: 10px;
    &.thc{
        padding-top: 0;
    }
}
.goods_form_attr{
    .attr_item{
        width: 100%;
    }
}
</style>
e>