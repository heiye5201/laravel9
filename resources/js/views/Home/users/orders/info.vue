<template>
    <div class="user_main">
        <div class="block_title">
            {{$t('user_center.order.info.detail')}}
        </div>
        <div class="x20"></div>

        <div class="admin_form">
            <div class="order_info_list">
                <el-row>
                    <el-col :span="12">
                        {{$t('home.carts.order_sn')}}：<span class="content">{{data.info.order_no||'-'}}</span>
                    </el-col>
                    <el-col :span="12">
                        {{$t('user_center.order.info.status')}}：
                        <span class="content">
                            <el-tag type="danger" v-show="data.info.order_status==0">{{data.info.order_status_cn}}</el-tag>
                            <el-tag type="warning" v-show="data.info.order_status==1">{{data.info.order_status_cn}}</el-tag>
                            <el-tag v-show="data.info.order_status>1 && data.info.order_status<6">{{data.info.order_status_cn}}</el-tag>
                            <el-tag type="info" v-show="data.info.order_status==6">{{data.info.order_status_cn}}</el-tag>
                            <el-tag type="success" v-show="data.info.order_status>=7">{{data.info.order_status_cn}}</el-tag>
                        </span>
                    </el-col>
                </el-row>
            </div>

            <div style="margin-top:40px"><span style="font-size: 14px;font-weight: bold;">{{$t('user_center.order.info.order_pay')}}</span></div>
            <div class="x20"></div>

            <div class="order_info_list">
                <el-row>
                    <el-col :span="8">
                        {{$t('user_center.order.info.pay_type')}}：<span class="content">{{data.info.payment_name_cn||'-'}}</span>
                    </el-col>
                    <el-col :span="8">
                        {{$t('user_center.order.info.pay_time')}}：<span class="content">{{data.info.pay_time||'-'}}</span>
                    </el-col>
                    <el-col :span="8">
                        {{$t('user_center.order.info.tracking_number')}}：<span class="content">{{data.info.delivery_no||'-'}}</span>
                    </el-col>
                </el-row>
            </div>
            <div class="order_info_list">
                <el-row>
                    <el-col :span="24">
                        {{$t('user_center.order.info.remarks')}}：<span class="content">{{data.info.remark||'-'}}</span>
                    </el-col>
                </el-row>
            </div>

            <div style="margin-top:40px"><span style="font-size: 14px;font-weight: bold;">{{$t('user_center.order.info.logistics_address')}}</span></div>
            <div class="x20"></div>

            <div class="order_info_list">
                <el-row>
                    <el-col :span="8">
                        {{$t('user_center.order.info.consignee')}}：<span class="content">{{data.info.receive_name}}</span>
                    </el-col>
                    <el-col :span="8">
                        {{$t('user_center.order.info.phone')}}：<span class="content">{{data.info.receive_tel}}</span>
                    </el-col>
                    <el-col :span="8">
                        {{$t('user_center.order.info.address')}}：<span class="content">{{data.info.receive_area+data.info.receive_address}}</span>
                    </el-col>
                </el-row>
            </div>

            <div style="margin-top:40px"><span style="font-size: 14px;font-weight: bold;">{{$t('user_center.order.info.goods_info')}}</span></div>
            <div class="x20"></div>

            <div class="order_item_list">
                <ul>
                    <li v-for="(vo,key) in data.info.order_goods" :key="key">
                        <div class="order_thumb"><img :src="vo.goods_image||require('@/assets/Home/default.png').default" :alt="vo.goods_name"></div>
                        <div class="order_list_title">{{vo.goods_name||'-'}}</div>
                        <div class="order_list_attr">{{vo.sku_name||'-'}}</div>
                        <div class="order_list_num">x {{vo.buy_num||'1'}}</div>
                        <div class="order_list_price">￥{{vo.goods_price||'0.00'}}</div>
                    </li>
                </ul>
            </div>

            <div class="order_info_right_price">{{$t('user_center.order.info.total')}}：￥ {{data.info.total_price}}<span data-v-01d38243="">（{{$t('user_center.order.info.freight_money')}}：{{data.info.freight_money}}）</span></div>

            <div style="margin-top:40px"><span style="font-size: 14px;font-weight: bold;">{{$t('user_center.order.info.tracking')}}</span></div>
            <div class="x20"></div>

            <div class="order_info_kd">
                <el-timeline v-if="data.info.delivery_list && data.info.delivery_list.length>0">
                    <el-timeline-item  v-for="(v,k) in data.info.delivery_list" :key="k" :timestamp="v.time" :color="k==0?'red':'gray'">
                        {{v.context}}
                    </el-timeline-item>
                </el-timeline>
                <el-empty v-else />
            </div>
            <br>
        </div>
    </div>
</template>

<script>
import {reactive,onMounted,getCurrentInstance} from "vue"
import {useRouter,useRoute} from 'vue-router'

export default {
    components: {},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const route = useRoute()
        const data = reactive({
            id:0,
            info:{
                order_status:0,
                order_goods:[],
            },
            columns:[
                {title:proxy.$t('user_center.order.info.goods_name'),key:'goods_name',dataIndex:'goods_name',fixed:'left',scopedSlots: { customRender: 'goods_name' }},
                {title:proxy.$t('user_center.order.info.sku_name'),key:'sku_name',dataIndex:'sku_name',scopedSlots: { customRender: 'sku_name'}},
                {title:proxy.$t('user_center.order.info.buy_num'),key:'buy_num',dataIndex:'buy_num',scopedSlots: { customRender: 'buy_num'}},
                {title:proxy.$t('user_center.order.info.goods_price'),key:'goods_price',dataIndex:'goods_price',scopedSlots: { customRender: 'goods_price'} },
                {title:proxy.$t('user_center.order.info.goods_image'),key:'goods_image',dataIndex:'goods_image',scopedSlots: { customRender: 'goods_image'} },
            ],
            list:[],
        })

        const loadData = ()=>{
            if(!proxy.R.isEmpty(route.params.id)) data.id = route.params.id
            proxy.R.get('/user/order/'+data.id+'?isResource=Home').then(res=>{
                if(!res.code) data.info = res
                console.log(data);
            }).catch(error=>{
                console.log(error)
            })
        }

        onMounted(() => {
            loadData()
        })

        return {
            data,
        }
    },
    methods:{
        loadData(){

        },
        addData(item) {
            console.info(item);
        }
    }
};
</script>
<style lang="scss" scoped>
.order_info_list{
    margin-bottom: 20px;
}


.order_item_list{
    ul li{
        padding:20px 15px;
        border-top: 1px solid #efefef;
        border-left: 1px solid #efefef;
        border-right: 1px solid #efefef;
        &:last-child{
            border-bottom: 1px solid #efefef;
        }
        &:after{
            clear:both;
            display: block;
            content:'';
        }
        .order_thumb{
            width: 42px;
            height: 42px;
            background: #efefef;
            border:1px solid #efefef;
            box-sizing: border-box;
            float: left;
            margin-right: 15px;
            overflow: hidden;
            img{
                width: 40px;
                height: 40px;
            }
        }
        .order_list_title{
            width: 280px;
            float: left;
            font-size: 12px;
            line-height: 20px;
            height: 40px;
            overflow: hidden;
        }

        .order_list_attr{
            float: left;
            text-align: center;
            width: 190px;
            line-height: 40px;
        }
        .order_list_num{
            float: left;
            text-align: center;
            width: 140px;
            line-height: 40px;
        }
        .order_list_price{
            float: right;
            color:#ca151e;
            text-align: center;
            width: 90px;
            line-height: 40px;
            // font-weight: bold;
        }
    }
}

</style>
