<template>
    <div class="create_order_1 w1200">
        <div class="step_bar">
            <div class="step">
                <div class="item check"><el-icon><Shop /></el-icon>  {{$t('home.store_index.my_cart')}}</div>
                <div class="item check"><el-icon><MessageBox /></el-icon>{{$t('home.carts.address')}}</div>
                <div class="item check"><el-icon><Money /></el-icon>{{$t('home.carts.select_pay')}}</div>
                <div class="item"><el-icon><CircleCheckFilled /></el-icon>{{$t('home.carts.pay_success')}}</div>
            </div>
        </div>

        <!-- 当前用户余额 S -->
        <div class="block">
            <div class="title"><div class="now_money">{{$t('home.carts.now_my_money')}}：￥{{data.userInfo.money||0.00}}</div></div>

        </div>
        <!-- 当前用户余额 E -->

        <!-- 选择支付方式 S -->
        <div class="block">
            <div class="title">{{$t('home.carts.select_pay_type')}}</div>
            <div class="pay">
                <ul>
                    <li @click="data.visible=true;"><img :src="require('@/assets/Home/pc_money_pay.png').default" alt="mpay"></li>
                    <li @click="pay('wechat')"><img :src="require('@/assets/Home/pc_wxpay.jpg').default" alt="wechatpay"></li>
                    <li @click="pay('alipay')"><img :src="require('@/assets/Home/pc_alipay.jpg').default" alt="alipay"></li>
                    <li id="paypal-button-container"></li>
                </ul>
            </div>
        </div>
        <!-- 选择支付方式 E -->

        <!-- 预生成订单信息 S -->
        <div class="block">
            <div class="title">{{$t('home.carts.order_goods_detail')}}</div>
            <div class="goods_list">
                <div class="goods_th">
                    <el-row>
                        <el-col :span="10">{{$t('home.carts.goods_detail1')}}</el-col>
                        <el-col :span="4">{{$t('home.carts.attr_detail')}}</el-col>
                        <el-col :span="4">{{$t('home.carts.price')}}</el-col>
                        <el-col :span="2">{{$t('home.carts.number')}}</el-col>
                        <el-col :span="2">{{$t('home.carts.discount')}}</el-col>
                        <el-col :span="2">{{$t('home.carts.total')}}</el-col>
                    </el-row>
                </div>

                <div class="store_list" v-for="(v,k) in data.order" :key="k">
                    <div class="store_title">
                        <div>
                            <span class="float_left">{{$t('home.carts.order_sn')}}：{{v.order_no}}</span>
                            <div class="float_right" v-if="v.coupon_money && v.coupon_money>0"><span style="font-size:14px;color:#666;">{{$t('home.carts.discount_price')}}：</span> <font color="#ca151e">-{{v.coupon_money}}</font></div>
                            <div class="clear"></div>
                        </div>

                        <!-- <font color="#ca151e">订单统计：￥{{v.total_price}}</font> -->

                        <div class="og_list">
                            <ul>
                                <li v-for="(vo,key) in v.order_goods" :key="key">
                                    <el-row>
                                        <el-col :span="10">
                                            <dl>
                                                <dt><img :src="vo.goods_image" :alt="vo.goods_name"></dt>
                                                <dd :title="vo.goods_name">{{vo.goods_name}}</dd>
                                            </dl>
                                        </el-col>
                                        <el-col :span="4"><div class="goods_info_th">{{vo.sku_name}}</div></el-col>
                                        <el-col :span="4"><div class="goods_info_th">{{vo.goods_price}}</div></el-col>
                                        <el-col :span="2"><div class="goods_info_th">{{vo.buy_num}}</div></el-col>
                                        <el-col :span="2"><div class="goods_info_th">-</div></el-col>
                                        <el-col :span="2"><div class="goods_info_th red">￥{{vo.total_price}}</div></el-col>
                                    </el-row>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sum_block">
                <div class="total">{{$t('home.carts.total_amount')}}：<span>￥{{data.total}}</span>( {{data.freight_money>0?$t('home.carts.contain_freight')+data.freight_money+$t('home.carts.price_unit'):$t('freight.free')}} )</div>
                <div class="clear"></div>
            </div>
        </div>
        <!-- 预生成订单信息 E -->

        <!-- 支付密码输入 pay('balance') -->
        <el-dialog width="30%" v-model="data.visible" :title="$t('enter_password')" >
            <input class="pay_password" type="password" v-model="data.pay_password" placeholder="pay password" />
            <div style="padding:25px 0 10px 0;text-align:center">
                <div class="error_btn" @click="pay('balance')">{{$t('home.carts.confirm_pay')}}</div>
            </div>
        </el-dialog>

        <!-- 二维码扫描 -->
        <el-dialog destroy-on-close  v-model="data.dialogVisible" width="30%" :title="$t('payment_code')"  @closed="qrcodeClose" style="text-align:center;" >
            <qrcode-vue style="margin-bottom:30px" :value="data.qr_code" :size="200" class="qrcode_class" />
        </el-dialog>
    </div>
</template>

<script>
import {reactive,onMounted,onBeforeUnmount,getCurrentInstance} from "vue"
import { Shop,CircleCheckFilled,Money,MessageBox,Check} from '@element-plus/icons'
import { useStore } from 'vuex'
import {useRouter,useRoute} from 'vue-router'
import QrcodeVue from 'qrcode.vue'
export default {
    components: {Shop,CircleCheckFilled,Money,MessageBox,Check,QrcodeVue},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const store = useStore()
        const router = useRouter()
        const route = useRoute()
        const data = reactive({
            order:[],
            total:0,
            freight_money:0,
            visible:false,
            dialogVisible:false,
            qr_code:'',
            pay_password:'',
            userInfo:{},
            loading: false,
            timeObj:null,
        })

        // 引入 PayPal 的 JavaScript SDK
        const loadPaypalSDK = () => {
          const script = document.createElement('script');
          script.src = 'https://www.paypal.com/sdk/js?client-id=test&currency=USD&intent=capture&enable-funding=venmo';
          script.setAttribute('data-source', 'integrationbuilder');
          script.async = true;
          script.onload = renderPaypalButton; // 在 SDK 加载完成后调用渲染函数
          document.body.appendChild(script);
        };

        const loadData = async ()=>{
            createOrderBefore()
            data.userInfo = await store.dispatch('login/getUserSer')
        }

        // 下单前数据处理
        const createOrderBefore = ()=>{
            proxy.R.post('/user/order/after',{params:route.params.params}).then(res=>{
                if(!res.code){
                    res.map(item=>{
                        data.total += parseFloat(item.total_price);
                        data.freight_money += parseFloat(item.freight_money);
                    })
                    data.order = res;
                }else{
                    router.go(-1)
                }
            }).catch(error=>{
                console.log(error)
            })
        }

        const pay = (payment_name)=>{
            const params = JSON.parse(window.atob(route.params.params));
            let order_id = params.order_id.join(',');
            let sendData = {order_id:order_id,payment_name:payment_name,device:'scan',pay_password:''};
            if(payment_name == 'balance'){
                sendData.pay_password = data.pay_password;
            }
            proxy.R.post('/user/order/pay',sendData).then(res=>{
                if(res.qr_code || res.code_url){
                    if(payment_name == 'alipay') data.qr_code = res.qr_code
                    if(payment_name == 'wechat') data.qr_code = res.code_url
                    data.dialogVisible = true;
                    if(data.timeObj != null ) qrcodeClose()
                    data.timeObj = setInterval(()=>{
                        proxy.R.post('/user/order/check',{order_id:params.order_id[0]||0}).then((checkRes)=>{
                            if(!checkRes.code){
                                qrcodeClose()
                                router.push('/order/success')
                            }
                        })
                    },1000)
                }else{
                    if(payment_name == 'balance' && !res.code) return router.push('/order/success')
                }

            })
        }

        const qrcodeClose = ()=>{
            if(data.timeObj != null) clearInterval(data.timeObj);
        }

        const renderPaypalButton = () => {
          if (typeof paypal === 'undefined') {
            console.error('PayPal SDK 未加载或加载失败');
            return;
          }
          // optional styling for buttons
          // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
          paypal.Buttons({
            style: {
              color: "gold",
              shape: "rect",
              label: "paypal",
              layout: "vertical" // horizontal vertical
            },
            createOrder: function(data, actions) {
              // pass in any options from the v2 orders create call:
              // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
              // 创建订单逻辑
              console.log('创建订单')
              const createOrderPayload = {
                purchase_units: [
                  {
                    amount: {
                      value: "1.44"
                    }
                  }
                ]
              };
              return actions.order.create(createOrderPayload);
            },
            onApprove: function(data, actions) {
              // 订单批准逻辑
              console.log('支付')
              const captureOrderHandler = (details) => {
                const payerName = details.payer.name.given_name;
                const params = JSON.parse(window.atob(route.params.params));
                let order_id = params.order_id.join(',');
                console.log('Transaction completed');
                console.log(details)
                console.log(order_id)
                let sendData = {order_id:order_id,payment_name:'paypal'};
                proxy.R.post('/user/order/pay',sendData).then(res=>{
                  if(res.code){
                    // location.reload();
                    return router.push('/order/success')
                  }
                })
              };
              return actions.order.capture().then(captureOrderHandler);
            },
            onError: function(err) {
              // 处理错误逻辑
              console.error('An error prevented the buyer from checking out with PayPal');
            }
          }).render('#paypal-button-container') // 这里的 #paypal-button-container 是你要渲染 PayPal 按钮的容器元素的 id
          .catch((err) => {
              console.error('PayPal Buttons failed to render');
            });
        };

        onMounted(()=>{
            loadPaypalSDK();
            renderPaypalButton(); // 调用 PayPal 按钮渲染函数
            loadData()
        })

        onBeforeUnmount(()=>{
            qrcodeClose()
            const script = document.querySelector('script[data-source="integrationbuilder"]');
            if (script) {
              document.body.removeChild(script);
            }
        })

        return {
            data,
            pay,qrcodeClose
        }
    },

};
</script>

<style lang="scss" scoped>
.step_bar{
    margin:40px 0;
    .step{
        height: 46px;
        line-height: 46px;
        background: #F5F7FA;
        margin-bottom: 50px;
        display: flex;
    }
    .step .item{
        font-size: 16px;
        color:#C0C4CC;
        flex: 1;
        justify-content: center;
        align-items: center;
        display: flex;
        i{
            margin-right: 10px;
        }
        text-align: center;
        border-right: 4px solid #fff;
    }
    .step .item.check{
        color:#333;
        font-weight: bold;
    }
}
.qrcode_class{
    width: 200px;
    height: 200px;
    margin: 0 auto;
    display: block;
}
.pay_password{
    width: 100%;
    border:1px solid #efefef;
    border-radius: 3px;
    height: 40px;
    box-sizing: border-box;
    padding:15px;
    outline: #ccc;
}

.error_btn{
    background: #ca151e;
    color:#fff;
    border-radius: 3px;
    box-sizing: border-box;
    font-size: 14px;
    padding: 5px 15px;
    margin-right: 10px;
    display: inline;
    cursor: pointer;
    box-shadow: 0 2px 0 rgba(0,0,0,.015);
}
.block{
    .title{
        font-size: 16px;
        clear: both;
        font-weight: bold;
        padding-bottom: 20px;
    }
    .pay{
        margin-bottom: 30px;
        ul:after{
            content:'';
            display: block;
            clear:both;
        }
        ul li{
            float: left;
            cursor: pointer;
            width: 294px;
            height: 107px;
            border-radius: 3px;
            border: 1px solid #efefef;
            margin-right: 20px;
            transition: all 0.2s linear;
            &:hover{
                box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
            }
        }
    }
    .store_list{
        margin-top: 20px;
        .og_list{
            margin-top: 10px;
            color: #666;
            font-size: 12px;
            border: 1px solid #efefef;
            padding: 20px 0;
            line-height: 40px;
            li{
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid #efefef;
                &:last-child{
                    margin-bottom: 0;
                    padding-bottom: 0;
                    border-bottom: none;
                }
            }
            .red{
                color:#ca151e;
            }
            dl{
                &:after{
                    clear:both;
                    display: block;
                    content:''
                }
                dt{
                    width: 40px;
                    height: 40px;
                    display: block;
                    float: left;
                    background: #f8f8f8;
                    margin-right: 15px;
                    margin-left: 20px;
                    border:1px solid #efefef;
                    img{
                        margin:0;
                        width: 100%;
                        height: 100%;
                        border-radius: 0;
                        vertical-align:unset;
                    }
                }
                dd{
                    float: left;
                    width: 400px;
                    height: 40px;
                    text-overflow: hidden;
                    line-height: 20px;
                }
            }
            .goods_info_th{
                text-indent: 20px;
            }
        }
        .store_title{
            img{
                width: 35px;
                height: 35px;
                margin-right: 10px;
                margin-left: 20px;
                border-radius: 50%;
            }
            span{
                line-height: 35px;
                font-size: 15px;
                float: left;
            }
            font{
                float:right;
                line-height: 35px;
                padding-right: 15px;
            }

        }
    }
    .sum_block{
        text-align: right;
        .total{
            line-height: 60px;
            span{
                font-size: 28px;
                color: #ca151e;
                margin-right: 16px;
            }
        }
        .btn{
            background: #ca151e;
            color:#fff;
            border-radius: 3px;
            width: 80px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            display: block;
            float:right;
        }
    }
    .goods_th{
        background: #f2f2f2;
        line-height: 40px;
        text-indent: 20px;
    }



}
.now_money{
    font-size: 16px;
    background: #333;
    color:#fff;
    margin-bottom: 20px;
    border:1px solid #fff;
    display: inline-block;
    padding:4px 15px;
    font-weight: normal;
}
</style>
