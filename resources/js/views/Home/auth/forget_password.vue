<template>
       <div class="home_login" :style="'background: url('+ require('@/assets/Home/user_login__bgs.png').default +');'">
        <div class="login_block w1200">
            <div class="login_item">
                <div class="login_title">
                    <ul>
                        <li class="red">{{$t('home.auth.forge_pass')}}</li>
                        <li>|</li>
                        <li @click="$router.push('/login')">{{$t('home.auth.account_login')}}</li>
                    </ul>
                </div>
                <div class="login_input">
                    <div class="input_block"><input type="text" v-model="data.username" :placeholder="$t('home.auth.user_name')" @keyup.enter="register"></div>
                    <div class="input_block"><input type="password" v-model="data.password" :placeholder="$t('home.auth.new_password')" @keyup.enter="register"></div>
                    <div class="input_block"><input type="password" v-model="data.re_password" :placeholder="$t('home.auth.confirm_password')" @keyup.enter="register"></div>
                    <div class="input_block">
                        <input class="yzm" type="code" v-model="data.code" :placeholder="$t('btn.code')" @keyup.enter="register">
                        <span :class="data.math>0?'yzmbtn dis':'yzmbtn'" @click="sendSms">{{data.code_text}}</span>
                    </div>
                </div>

                <div class="login_btn" @click="register">{{$t('home.auth.login')}}</div>

                <div class="login_btn_b">
                    <router-link to="/forget_password">{{$t('home.auth.forge_pass')}}？</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"

export default {

    setup(props) {
        const {ctx,proxy} = getCurrentInstance()
        const data = reactive({
            username: "",
            password: "",
            re_password: "",
            code: "",
            code_text:'发送验证码',
            timeObj:null,
            math:0,
        })

        const register = ()=>{
            if (data.username == "" || data.password == "") {
                proxy.$message.error(proxy.$t('msg.loginAbn'));
                return;
            }
        }

        // 发送短信
        const sendSms = ()=>{

        }

        return {
            data,
            register,sendSms
        }
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
                .yzmbtn{
                    cursor: pointer;
                    width: 140px;
                    height: 35px;
                    line-height: 35px;
                    display: inline-block;
                    text-align: center;
                    background: #333;
                    color:#fff;
                    &.dis{
                        background: #ccc;
                        color:#666;
                    }
                }
                input{
                    width: 100%;
                    border:1px solid #e1e1e1;
                    height: 35px;
                    text-indent: 6px;
                    outline: none;
                    &.yzm{
                        width: 50%;
                        margin-right: 5%;
                    }
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
