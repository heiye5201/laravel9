<template>
    <div class="user_main table_lists">
        <div class="block_title">
            {{$t('user_center.oauth.third_login')}}
        </div>
        <div class="x20"></div>
        <div class="safe_block" >
            <ul>
                <li>
                    <div class="safe_icon "><img :src="require('@/assets/Home/wechat.png').default" alt=""></div>
                    <div class="safe_text">{{$t('user_center.oauth.wechat_binding')}}<p>{{$t('user_center.oauth.bind_wechat')}}</p></div>
                    <div class="safe_btn2" v-if="data.userInfo.oauthCheck">{{$t('user_center.oauth.wechat_bind')}}</div>
                        <div class="safe_btn" v-else>{{$t('user_center.oauth.bind_now')}}</div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import {reactive,onMounted,getCurrentInstance} from "vue"
import { useStore } from 'vuex'
export default {
    components:{},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const store = useStore()

        const data = reactive({
            userInfo:{
                oauthCheck:false,
            }
        })


        const loadData = async ()=>{
            let user = await store.dispatch('login/getUserSer')
            data.userInfo = user
        }

        onMounted( async ()=>{
            loadData()
        })

        return {data}
    }
}
</script>
<style lang="scss" scoped>
.safe_block{
    min-height: 600px;
    li{clear:both;border-bottom: 1px solid #f1f1f1;}
    ul li:after{
        clear:both;
        display: block;
        content:'';
    }
    &:after{
        clear:both;
        display: block;
        content:'';
    }
    .safe_icon{
        line-height: 90px;
        margin-right: 40px;
        margin-left: 15px;
        margin-top: 10px;
        float: left;
        img{
            text-align: center;
            margin-top: 10px;
        }
    }
    .safe_text{
        float: left;
        font-size: 16px;
        font-weight: bold;
        padding-top: 20px;
        line-height: 25px;
        p{
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }
    }
    .safe_btn{
        border: 1px solid #efefef;
        width: 100px;
        line-height: 30px;
        background: #fff;
        text-align: center;
        float: right;
        margin-top: 28px;
        margin-right: 15px;
        cursor: pointer;
        &:hover{
            color:#ca151e;
            border-color: #ca151e;
        }
    }
}
</style>
