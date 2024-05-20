<template>
    <div class="user_default">
        <div class="user_default_in w1200">
            <!-- 用户左侧栏目 -->
            <div class="user_left">
                <div class="user_info_block">
                    <dl>
                        <dt><img :src="data.user_info.avatar||require('@/assets/Home/user_default.png').default" alt=""></dt>
                        <dd class="nickname">{{data.user_info.nickname||$t('home.loading')}}</dd>
                        <dd class="edit_user_info"><router-link to="/user/info">{{$t('default.edit_user')}}</router-link></dd>
                    </dl>
                    <div class="user_stepbar">
                        <span>{{$t('default.user_detail')}}：</span><el-progress class="progress" :stroke-width="7" :status="data.user_info.check?'success':'warning'" :percentage="!data.user_info.check?50:100" />
                    </div>
                    <div class="user_safe">
                        <span>{{$t('default.user_safe')}}：</span>
                        <span class="safe_icon">
                            <i :class="data.user_info.phone==''?'fa fa-phone-square':'fa fa-phone-square success'" />
                            <i :class="!data.user_info.check?'fa fa-id-card-o':'fa fa-id-card-o success'" />
                        </span>
                    </div>
                </div>

                <div class="user_nav">
                    <div class="block" v-for="(v,k) in data.nav" :key="k">
                        <div class="title">
                            <img :src="require('@/assets/Home/usericon/'+v.icon).default" alt="">
                            <!-- <i :type="v.icon" :class="'fa '+v.icon" /> -->
                            <span>{{v.name}}</span>
                        </div>
                        <div class="nav_item" v-for="(vo,key) in v.children" :key="key"><router-link :to="vo.url">{{vo.name}}</router-link></div>
                    </div>
                </div>
            </div>

            <div class="user_right">
                <router-view></router-view>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</template>

<script>
import {reactive,onMounted,getCurrentInstance} from "vue"
import { useStore } from 'vuex'
export default {
    setup(props) {
        const {proxy} = getCurrentInstance()
        const store = useStore()
        const data = reactive({
            nav:[
                {
                    name:proxy.$t('default.order_center'),
                    icon:'order.png',
                    children:[
                        {name:proxy.$t('default.my_orders'),url:'/user/orders'},
                        {name:proxy.$t('default.address_list'),url:'/user/address'},
                        {name:proxy.$t('default.comments_list'),url:'/user/comments'},
                    ],
                },
                {
                    name:proxy.$t('default.user_center'),
                    icon:'user.png',
                    children:[
                        {name:proxy.$t('default.my_center'),url:'/user'},
                        {name:proxy.$t('default.user_info_detail'),url:'/user/info'},
                        {name:proxy.$t('default.user_safe'),url:'/user/safe'},
                        {name:proxy.$t('default.user_oauth'),url:'/user/oauth'},
                        {name:proxy.$t('default.cashes'),url:'/user/cashes'},
                        {name:proxy.$t('default.favorites'),url:'/user/favorites'},
                        {name:proxy.$t('default.user_coupons'),url:'/user/coupons'},
                    ],
                },
                {
                    name:proxy.$t('default.integral_store'),
                    icon:'inte.png',
                    children:[
                        {name:proxy.$t('default.integral_order'),url:'/user/integral_order'},
                    ],
                },
                {
                    name:proxy.$t('default.asset_records'),
                    icon:'money.png',
                    children:[
                        {name:proxy.$t('default.platform_money'),url:'/user/money'},
                        {name:proxy.$t('default.freezing_money'),url:'/user/frozen_money'},
                        {name:proxy.$t('default.platform_integral'),url:'/user/integral'},
                    ],
                },
                {
                    name:proxy.$t('default.distribution'),
                    icon:'vip.png',
                    children:[
                        {name:proxy.$t('default.distribution_detail'),url:'/user/distribution'},
                        {name:proxy.$t('default.distribution_user'),url:'/user/distribution_users'},
                        {name:proxy.$t('default.distribution_money'),url:'/user/distribution_logs'},
                    ],
                },
                {
                    name:proxy.$t('default.help_center'),
                    icon:'help.png',
                    children:[
                        {name:proxy.$t('default.web_notice'),url:'/user/article/web_notice'},
                        {name:proxy.$t('default.other_cooperate'),url:'/user/article/other_cooperate'},
                        {name:proxy.$t('default.help_center'),url:'/user/article/help_center'},
                        {name:proxy.$t('default.about'),url:'/user/article/about'},
                    ],
                },
            ],
            user_info:{},
            isLogin:false,
        })
        onMounted( async ()=>{
            const token = localStorage.getItem('token')
            if(!proxy.R.isEmpty(token)) data.isLogin = true
            let user = await store.dispatch('load/getUser')
            Object.assign(data.user_info,user)
        })
        return {data}
    },
};
</script>
<style lang="scss" scoped>
.user_default{
    background: #f1f1f1;
    padding-bottom: 30px;
}
.user_left{
    float: left;
    width: 234px;
    margin-right: 20px;
    padding-top: 20px;
    .user_nav{
        margin-top: 20px;
        background: #fff;
        padding: 20px;
        .block{
            border-bottom: 1px solid #efefef;
            padding-bottom: 15px;
            margin-bottom: 15px;
            .nav_item{
                line-height: 35px;
                margin-left: 55px;
                cursor: pointer;
                color:#666;
                &:hover{
                    color:#ca151e;
                }
            }
            &:last-child{
                border-bottom: none;
            }
        }
        .title{
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: bold;
            img{
                margin-left: 26px;
                margin-right: 10px;
            }
            // i{
            //     color:#ca151e;
            //     margin:0 6px 0 24px;
            //     font-size: 14px;
            // }
        }
    }
    .user_info_block{
        background: #fff;
        padding: 20px;
        .nickname{
            width: 110px;
            overflow: hidden;
            height: 19px;
        }
        .user_stepbar{
            margin-top: 20px;
        }
        .user_safe{
            margin-top: 6px;
            i{
                margin-right: 6px;
            }
            .safe_icon .success{
                color:#67c23a;
            }
        }
        .progress{
            width: 124px;
            display: inline-flex;
        }
        dl{
            &:after{
                clear:both;
                display: block;
                content:'';
            }
            dt{
                float: left;
                margin-right: 15px;
                width: 60px;
                height: 60px;
                border: 1px solid #f4f4f4;
                border-radius: 50%;
                img{
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                }
            }
            dd{
                font-size: 14px;
                float: left;
                margin-top: 6px;
                &.edit_user_info{
                    border: 1px solid #ca151e;
                    line-height: 20px;
                    text-align: center;
                    padding: 0 15px;
                    margin-top: 5px;
                    a{
                        color: #ca151e;
                    }
                }
            }
        }
    }
}
.user_right{
    float: left;
    width: 946px;
    padding-top: 20px;
}

</style>
<style >
.user_stepbar .el-progress__text{
    min-width: 20px;
}
</style>
