<template>
    <div class="goods_form">
        <div class="step_bar">
            <div class="step">
                <div :class="{item:true,check:data.step == 0,success:data.step>0} "><el-icon :size="16"><Reading /></el-icon>{{$t('seller.goods.select_category')}}</div>
                <div :class="{item:true,check:data.step == 1,success:data.step>1}"><el-icon :size="16"><List /></el-icon>{{$t('seller.goods.edit_goods')}}</div>
                <div :class="{item:true,check:data.step == 3,success:data.step>3}"><el-icon :size="16"><SetUp /></el-icon>{{$t('seller.goods.edit_attr')}}</div>
                <div class="item"><el-icon :size="16"><CircleCheckFilled /></el-icon>{{$t('seller.goods.add_goods')}}</div>
            </div>
        </div>

        <div class="goods_chose" v-if="data.step == 0">
            <div class="goods_add_chose_class_bg">
                <div class="chose_class_bg_item">
                    <ul><li @click="chose(v,0,k)" v-for="(v,k) in data.classList" :key="k" :class="data.choseId[0] == v.id?'checked':''">{{v.name}}<el-icon><ArrowRight /></el-icon></li></ul>
                </div>
                <div :class="data.choseId[0]==0?'chose_class_bg_item disabled':'chose_class_bg_item'">
                    <ul><li @click="chose(v,1,k)" v-for="(v,k) in data.choseId[0]==0?[]:data.classList[data.index[0]].children" :key="k" :class="data.choseId[1] == v.id?'checked':''">{{v.name}}<el-icon><ArrowRight /></el-icon></li></ul>
                </div>
                <div :class="data.choseId[1]==0?'chose_class_bg_item disabled':'chose_class_bg_item'">
                    <ul><li @click="chose(v,2,k)" v-for="(v,k) in data.choseId[1]==0?[]:data.classList[data.index[0]].children[data.index[1]].children" :key="k" :class="data.choseId[2] == v.id?'checked':''">{{v.name}}<el-icon><ArrowRight /></el-icon></li></ul>
                </div>
            </div>

            <div class="chose_class_btn">
                <el-button type="primary" :disabled="data.choseId[0]==0 || data.choseId[1]==0 || data.choseId[2]==0" @click="nextStep(1)">{{$t('btn.goodsNext')}}</el-button>
                <el-button @click="goodsBack">{{$t('btn.back')}}</el-button>
            </div>
        </div>

        <div class="goods_form_item" v-if="data.step == 1">
            <el-form ref="addForm" label-position="right" :model="data.form" :rules="data.rules" label-width="80px">
                <el-row :gutter="20">
                    <el-col :span="24">
                        <el-form-item :label="$t('seller.goods.category')">
                            <el-breadcrumb style="line-height:28px;background:#f4f4f4;padding-left:10px;">
                                <el-breadcrumb-item v-for="(v,k) in data.choseItem" :key="k">{{v.name}}</el-breadcrumb-item>
                                <el-breadcrumb-item >
                                    <el-button size="small" @click="data.step=0" >{{$t('btn.edit')}}</el-button>
                                </el-breadcrumb-item>
                            </el-breadcrumb>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item :label="$t('seller.goods.goods_name')" prop="goods_name"><el-input v-model="data.form.goods_name" /></el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item :label="$t('seller.goods.goods_subname')" prop="goods_subname"><el-input type="textarea" v-model="data.form.goods_subname" show-word-limit maxlength="120" /></el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.goods_no')" prop="goods_no"><el-input v-model="data.form.goods_no" placeholder="A123456789" /></el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.brand_id')" prop="brand_id">
                            <q-input :params="{value:'brand_id',type:'select',labelName:'name',valueName:'id'}" v-model:formData="data.form.brand_id" :dictData="{brand_id:data.goodsBrands}" />
                        </el-form-item>
                    </el-col>

                    <el-col :span="24">
                        <el-form-item :label="$t('seller.goods.goods_images')" prop="goods_images">
                            <div class="goods_image">
                                <div class="item" v-if="data.form.goods_images">
                                    <div class="item_img" v-for="(v,k) in data.form.goods_images" :key="k"  @click="setMaster(k)">
                                        <div class="item_bg"><el-icon @click="deleteImg(k)" ><Delete /></el-icon></div>
                                        <div class="item_master" v-if="data.form.goods_master_image==v"><el-icon><CircleCheck /></el-icon>&nbsp;{{$t('seller.goods.show_images')}}</div>
                                        <img :src="v" />
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="item noimg" v-else><el-icon ><CameraFilled /></el-icon></div>
                            </div>
                            <div class="goods_upload_btn">
                                <el-upload
                                    class="goods_upload_btns"
                                    :action="'/api'+uploadPath+'uploads'"
                                    :headers="{Authorization:Token}"
                                    :data="data.uploadOptions"
                                    :multiple="true"
                                    :on-success="handleSuccess"
                                >
                                    <el-button :icon="Upload" type="primary">{{$t('seller.goods.uploads')}}</el-button>
                                </el-upload>
                                <el-button :icon="Picture" @click="$message.info('暂未开发')">{{$t('seller.goods.space')}}</el-button>
                            </div>
                        </el-form-item>
                    </el-col>

                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.goods_price')" prop="goods_price">
                            <el-input type="number" v-model="data.form.goods_price" >
                                <template #suffix>{{$t('btn.money')}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.goods_market_price')" prop="goods_market_price">
                            <el-input type="number" v-model="data.form.goods_market_price" >
                                <template #suffix>{{$t('btn.money')}}</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.goods_weight')" prop="goods_weight">
                            <el-input type="number" v-model="data.form.goods_weight" >
                                <template #suffix>Kg</template>
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.goods_stock')" prop="goods_stock">
                            <el-input type="number" v-model="data.form.goods_stock" :suffix-icon="PieChart" />
                        </el-form-item>
                    </el-col>
                    <!-- <el-form-item :label="'规格属性(SKU)'" prop="name"><el-input v-model="data.form.name" /></el-form-item> -->
                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.freight_id')" prop="freight_id">
                            <!-- ,addSelect:{name:proxy.$t('btn.default'),id:0} -->
                            <q-input :params="{value:'freight_id',type:'select',labelName:'name',valueName:'id'}" v-model:formData="data.form.freight_id" :dictData="{freight_id:data.freight}" />
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item :label="$t('seller.goods.goods_content')" prop="goods_content">
                            <q-input :params="{value:'goods_content',type:'editor'}" v-model:formData="data.form.goods_content" />
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.goods_status')" prop="goods_status">
                            <q-input :params="{value:'goods_status',type:'radio'}" v-model:formData="data.form.goods_status" :dictData="{goods_status:[{label:$t('btn.yes'),value:1},{label:$t('btn.no'),value:0}]}" />
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item >
                            <el-button type="primary" @click="nextStep(3)">{{$t('btn.attrNext')}}</el-button>
                            <el-button :icon="CircleCheck" type="success" :loading="loading" @click="nextStep(2)">{{$t('btn.release')}}</el-button>
                            <el-button @click="goodsBack">{{$t('btn.back')}}</el-button>
                        </el-form-item>
                    </el-col>



                </el-row>
            </el-form>
        </div>

        <div class="goods_form_attr" v-if="data.step == 3">
            <el-form ref="addForm" label-position="right" :model="data.form" :rules="data.rules" label-width="80px">
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-form-item :label="$t('seller.goods.attr_sku')" >
                            <el-button type="primary" @click="openAttrWin">{{$t('seller.goods.select_attr')}}</el-button>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item >
                            <div class="attr_item" v-for="(v,k) in data.goodsAttr" :key="k">
                                <span style="margin-right:10px;">{{v.name}}：</span>
                                <el-checkbox v-for="(vo,key) in v.specs" :key="key" @change="specChange(v,vo)" :value="vo.check||false" :checked="vo.check||false">{{vo.name}}</el-checkbox>
                            </div>
                            <!-- 规格SKU start -->
                            <div class="goods_specs" v-if="data.form.skuList && data.form.skuList.length>0">
                                <div class="row_th">
                                    <el-row :gutter="16">
                                        <el-col class="col_th thc" :span="4">SKU</el-col>
                                        <el-col class="col_th thc" :span="4">{{$t('seller.goods.market_price')}}</el-col>
                                        <el-col class="col_th thc" :span="4">{{$t('seller.goods.platform_price')}}</el-col>
                                        <el-col class="col_th thc" :span="4">{{$t('seller.goods.weight')}}</el-col>
                                        <el-col class="col_th thc" :span="4">{{$t('seller.goods.stock')}}</el-col>
                                        <el-col class="col_th thc" :span="4">{{$t('seller.goods.images')}}</el-col>
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
                    <el-col :span="24">
                        <el-form-item >
                            <el-button :icon="CircleCheck" type="success" :loading="loading" @click="nextStep(2)">{{$t('btn.release')}}</el-button>
                            <el-button @click="data.step=1">{{$t('btn.back')}}</el-button>
                        </el-form-item>
                    </el-col>

                </el-row>
            </el-form>
        </div>

        <!-- 选择属性 -->
        <el-dialog v-model="data.centerDialogVisible" :title="$t('seller.goods.select_attr')" width="40%" center>
            <el-checkbox-group v-model="data.attrListCheck">
                <el-row :gutter="10">
                    <el-col  v-for="(v,k) in data.attrList" :key="k" :span="6" style="margin-bottom:10px;"><el-checkbox :label="v.id" border >{{v.name}}</el-checkbox></el-col>
                </el-row>
            </el-checkbox-group>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="data.centerDialogVisible = false">{{$t('btn.cancel')}}</el-button>
                    <el-button type="primary" @click="attrChose">{{$t('btn.determine')}}</el-button>
                </span>
            </template>
        </el-dialog>

    </div>
</template>

<script>
import {reactive,ref,getCurrentInstance} from "vue"
import {getToken,getUploadPath} from '@/plugins/config'
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
            step:0,
            form:{},
            freight:[],
            rules:{
                goods_name:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                goods_images:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                goods_price:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                goods_market_price:[{required:true,message:proxy.$t('msg.requiredMsg')}],
                goods_weight:[{required:true,message:proxy.$t('msg.requiredMsg')}],
            },
            uploadOptions:{option:JSON.stringify({width:800,height:800,thumb:[[400,400],[300,300],[150,150]]}),name:'goods'},
        })
        const nextStep = (e)=>{
            data.step = e
            if(e == 2){
                proxy.$refs.addForm.validate((valid)=>{
                    // 验证失败直接断点
                    if (!valid) return false
                    loading.value = true
                    try {
                        // 插入栏目Id
                        data.form.class_id = data.choseId[2]
                        let url = '/Seller/goods'
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
        }

        // 获取店铺分类
        const storeClass = async ()=>{
            data.classList = await proxy.R.get('/Seller/store_classes')
        }
        // 获取品牌信息
        const goodsBrand = async ()=>{
            data.goodsBrands = await proxy.R.get('/Seller/goods_brands?isAll=true')
        }

        // 获取运费配置
        const loadFreght = ()=>{
            proxy.R.get('/Seller/freights',{isAll:true}).then(res=>{
                if(!res.code) data.freight = res
                data.freight.unshift({name:proxy.$t('freight.free'),id:0})
            })
        }
        const chose = (v,deep,index)=>{
            data.choseId[deep] = v.id
            data.choseItem[deep] = v
            data.index[deep] = index
        }
        // 图片处理
        const setMaster = (e)=>{
            data.form.goods_master_image = data.form.goods_images[e]
        }
        const deleteImg = (e)=>{
            let imgUrl = data.form.goods_images[e]
            data.form.goods_images.splice(e,1)
            if(data.form.goods_images &&
                data.form.goods_master_image == imgUrl &&
                data.form.goods_images.length>0
            ){
                data.form.goods_master_image = data.form.goods_images[0]
            }
        }
        // 上传图片
        const handleSuccess = (e)=>{
            if(e.code != 200) return proxy.$message.error(e.msg)
            if(!data.form.goods_master_image) data.form.goods_master_image = e.data
            if(!data.form.goods_images) data.form.goods_images = []
            data.form.goods_images.push(e.data)
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

        // 打开属性选择
        const openAttrWin = async ()=>{
            data.attrList = await proxy.R.get('/Seller/goods_attrs?isAll=true&isWith=specs')
            data.centerDialogVisible = true
        }

        // 确定属性选择
        const attrChose = ()=>{
            // data.goodsAttr = []
            data.centerDialogVisible = false
            if(data.attrListCheck.length<=0) return
            if(!data.goodsAttr) data.goodsAttr = []
            data.attrListCheck.map(items=>{
                let attrId = items
                let status = false
                data.goodsAttr.map((attrItems)=>{
                    // console.log(attrItems.id,items.id)
                    if(attrItems.id == items){
                        status = true
                        attrId = items.id
                    }
                })
                if(!status){
                    data.attrList.map((item,index)=>{
                        if(attrId == item.id) data.goodsAttr.push(data.attrList[index])
                    })
                }
            })
        }

        const specChange = (attrs,specs)=>{
            let index = -1;
            data.goodsAttr.map((items,key)=>{
                if(items.id == attrs.id){
                    index = key;
                }
            })
            data.goodsAttr[index].specs.map((items,itemsKey)=>{
                if(items.id == specs.id){
                    // console.log(items.check)
                    if(items.check == undefined ){
                        data.goodsAttr[index].specs[itemsKey].check = true
                    }else{
                        data.goodsAttr[index].specs[itemsKey].check = !data.goodsAttr[index].specs[itemsKey].check
                    }
                    console.log(items.check)

                }
            })
            structureSku();
        }

        const structureSku = ()=>{
            let skuList = [];
            let attrList = [];
            let attrListName = [];
            let i=0;
            data.goodsAttr.map((items,key)=>{
                let canPlus = false;
                items.specs.map(specItem=>{
                    if(specItem.check){
                        if(proxy.R.isEmpty(attrList[i])){
                            attrList[i] = [];
                            attrListName[i] = [];
                        }
                        attrList[i].push(specItem.id);
                        attrListName[i].push(specItem.name);
                        canPlus = true;
                    }
                })
                if(canPlus){
                    i++;
                }
            })
            if(attrList.length<=0){
                return data.form.skuList = [];
            }

            // 判断是否单选一个属性
            let attrName = []
            let attrId = [];
            if(attrList.length!=1){
                attrName = cartesianProduct(attrListName);
                attrId = cartesianProduct(attrList);
                attrId.map((items,key)=>{
                    skuList.push({spec_id:items,sku_name:attrName[key],goods_market_price:0,goods_price:0,goods_stock:0,goods_weight:0});
                })
            }else{
                attrName = attrListName[0];
                attrId = attrList[0];
                attrId.map((items,key)=>{
                    skuList.push({spec_id:[items],sku_name:[attrName[key]],goods_market_price:0,goods_price:0,goods_stock:0,goods_weight:0});
                })
                 }

            // 判断是否有已经设置过金额的则不改变内容
            // console.log(skuList.length,data.form.skuList.length)
            if(data.form.skuList && !proxy.R.isEmpty(data.form.skuList[0]) && skuList[0].spec_id.length==data.form.skuList[0].spec_id.length){ // 如果规格数量不一致了则不变了直接替换
                // 判断是否是规格减少了
                if(skuList.length<data.form.skuList.length){

                    let skuListLength = data.form.skuList.length;
                    let strList = [];
                    for(let i=0;i<skuListLength;i++){
                        let ngt = false
                        skuList.map(skuItem=>{
                            if(skuItem.spec_id.sort().toString() == data.form.skuList[i].spec_id.sort().toString()){
                                ngt = true
                            }
                        })
                        if(!ngt){
                            strList.push(data.form.skuList[i].spec_id.sort().toString());
                        }
                    }
                    for(let i=0;i<strList.length;i++){
                        let ngt = false;
                        data.form.skuList.map((skuItem,key)=>{
                            if(strList[i] == skuItem.spec_id.sort().toString()){
                                ngt = true
                            }
                            if(ngt){
                                data.form.skuList.splice(key,1)
                            }
                        })

                    }
                }else{
                    skuList.forEach(item=>{
                        let gt = false;
                        data.form.skuList.map(skuItem=>{
                            if(skuItem.spec_id.sort().toString() == item.spec_id.sort().toString()){
                                gt = true;
                            }
                        })
                        if(!gt){
                            data.form.skuList.push(item)
                        }
                    })
                }
            }else{
                data.form.skuList = skuList
            }
        }

        const cartesianProduct = (array)=>{
            if(array.length==1){
                return array
            }
            return array.reduce(function(a,b){
                return a.map(function(x){
                    return b.map(function(y){
                        return x.concat(y)
                    })
                }).reduce(function(a,b){ return a.concat(b) },[])
            }, [[]])
        }
        storeClass()
        goodsBrand()
        loadFreght()
        const Token = getToken()
        const uploadPath = getUploadPath()
        return {
            nextStep,chose,handleSuccess,setMaster,deleteImg,specChange,
            attrChose,openAttrWin,goodsBack,editGoods,data,
            Picture,PieChart,Upload,CircleCheck,Token,uploadPath,loading
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
<style lang="scss">
.goods_form .goods_form_item .el-upload-list{
    display: none;
}
</style>
