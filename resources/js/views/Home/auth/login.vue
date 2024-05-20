<template>
    <div class="home_login" :style="'background: url('+ require('@/assets/Home/user_login__bgs.png').default +');'">
        <div class="login_block w1200">
            <div class="login_item">
                <div class="login_title">
                    <ul>
                        <li class="red">{{$t('home.auth.account_login')}}</li>
                        <li>|</li>
                        <li>{{$t('home.auth.code_login')}}</li>
                    </ul>
                </div>
                <div class="login_input">
                    <div class="input_block"><input type="text" v-model="data.username" :placeholder="$t('home.auth.user_name')" @keyup.enter="login"></div>
                    <div class="input_block"><input type="password" v-model="data.password" :placeholder="$t('home.auth.password')" @keyup.enter="login"></div>
                </div>

                <div class="login_btn" @click="login">{{$t('home.auth.login')}}</div>

                <div class="login_btn_b">
                    <router-link to="/register">{{$t('home.auth.register')}}</router-link>|<router-link to="/forget_password">{{$t('home.auth.forge_pass')}}？</router-link>
                </div>

<!--                <el-divider>其他登录方式</el-divider>-->
<!--                <div class="other_login_block" @click="wechatLogin()">-->
<!--                    <img width="35" :src="require('@/assets/Home/wechat.png').default" alt="">-->
<!--                    <p>微信登录</p>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
import {reactive,onMounted,getCurrentInstance} from "vue"
import { useStore } from 'vuex'
import { useRouter,useRoute } from 'vue-router'
export default {
    setup(props) {
        const {proxy} = getCurrentInstance()
        const store = useStore()
        const router = useRouter()
        const route = useRoute()
        const data = reactive({
            username:"",
            password:"",
            provider:"users"
        })

        const login = async ()=>{
            if (data.username == "" || data.password == "") {
                proxy.$message.error(proxy.$t('msg.loginAbn'));
                return;
            }

            let loginData = await proxy.R.post('/login',data)
            loginData.routeUriIndex = store.state.load.routeUriIndex
            loginData.path = '/login'
            if(!loginData.code){
                await store.commit('login/loginAfter',loginData)
                router.push('/')
            }

        }

        const wechatLogin = ()=>{
            window.location.href="/api/oauth/weixinweb"
        }

        // onMounted
        onMounted(()=>{
            let inviterId = route.query.inviter_id||0
            let inviterIdSession = sessionStorage.getItem('inviterId')
            if(inviterId == 0 && !proxy.R.isEmpty(inviterIdSession)) inviterId = inviterIdSession
            sessionStorage.setItem('inviterId',inviterId)
            if(!proxy.R.isEmpty(route.query.code)){
                proxy.R.get('/callback/oauth/weixinweb',{code:route.query.code,inviter_id:route.query.inviter_id||0}).then( async res=>{
                    if(!res.code && res.access_token){
                        await store.commit('login/loginAfter',res)
                        router.push('/')
                    }
                })
            }
        })

        return {
            data,
            wechatLogin,login
        }
    },

    methods: {


    }
};
</script>
<style lang="scss" scoped>
.login_block{
    text-align: right;
    .login_btn_b{
        text-align: right;
        font-size: 12px;
        margin-top: 15px;
        margin-bottom: 40px;
        a{
            margin:0 8px;
            color:#999;
        }
    }
    .other_login_block{
        cursor: pointer;
        text-align: center;
        line-height: 30px;
        i{
            font-size: 30px;
        }
    }
    .login_item{
        width: 400px;
        background: #fff;
        height: 450px;
        float: right;
        box-sizing: border-box;
        padding: 40px;
        margin-top: 50px;
        text-align: left;
        .login_btn{
            cursor: pointer;
            color:#fff;
            background: #ca151e;
            line-height: 35px;
            width: 100%;
            text-align: center;
            font-size: 16px;
        }
        .login_input{
            margin-top: 30px;
            .input_block{
                margin: 15px auto;
                width: 320px;
                input{
                    width: 100%;
                    border:1px solid #e1e1e1;
                    height: 35px;
                    text-indent: 6px;
                    outline: none;
                }
            }
        }
        .login_title{
            ul{
                margin-left: 55px;
                &:after{
                    content:'';
                    display: block;
                    clear:both;
                }
            }
            ul li{
                cursor: pointer;
                float: left;
                margin-right: 20px;
                font-size: 20px;
                &.red{
                    color:#ca151e;
                }
                &:hover{
                    color:#ca151e;
                }
            }
        }
    }
}
.home_login{
    height: 550px;
}
</style>
