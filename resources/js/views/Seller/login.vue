<template>
    <div class="admin_login">
        <div class="login_block">
            <div class="left_block"><img :src="require('@/assets/Admin/login/login_left_img.png').default" /></div>
            <div class="right_block">
                <div class="title">{{$t('seller.login.title')}}</div>
                <div class="sub_title">management system</div>
                <el-divider class="login_divder"></el-divider>
                <el-form ref="forms" class="login_form">
                    <el-form-item>
                        <el-input size="medium" :prefix-icon="User" v-model="data.form.username" :placeholder="$t('seller.login.username')" />
                    </el-form-item>
                    <el-form-item>
                        <el-input size="medium" :prefix-icon="Key" v-model="data.form.password" @keyup.enter.native="data.onsubmit" :placeholder="$t('seller.login.password')" show-password />
                    </el-form-item>
                    <el-form-item>
                        <el-button style="width:100%" size="medium" type="primary" @click="data.onsubmit">{{$t('seller.login.login')}}</el-button>
                    </el-form-item>
                    <el-form-item class="disclaimers"><el-checkbox v-model="data.disclaimers" :label="$t('seller.login.desc')"></el-checkbox></el-form-item>
                </el-form>
            </div>
        </div>
    </div>
</template>
<script>
import { Key,User } from '@element-plus/icons'
import { useStore } from 'vuex'
import {reactive,toRefs,getCurrentInstance} from "vue"
import { useRouter, useRoute } from 'vue-router'
export default ({
    setup() {
        const {ctx,proxy} = getCurrentInstance()
        const store = useStore()
        const router = useRouter()
        const data = reactive({
            disclaimers:true,
            form:{},
            onsubmit:async ()=>{
                let {disclaimers,form} = data
                if(!disclaimers){
                    return ElementPlus.ElMessage.error(proxy.$t('seller.login.desc'))
                }
                form.provider = 'users'
                let loginData = await proxy.R.post('/login',form)
                loginData.routeUriIndex = store.state.load.routeUriIndex
                // loginData.isTo = true // 是否跳转
                loginData.path = '/Seller/login'

                if(!loginData.code){
                    await store.commit('login/loginAfter',loginData)
                    const routeUrl = await store.dispatch('load/loadRoute')
                    window.location.href=routeUrl
                }
                // console.log(proxy.$i18n.locale)
            }
        })

        return {data,Key,User}
    },
})
</script>
<style lang="scss" scoped>
.admin_login{
    background: url("@/assets/Admin/login/login_bg.jpg") ;
    background-size: cover;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    .login_block{
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 2px 12px 0 rgba(85, 85, 85, 0.1);
        height: 500px;
        width: 45%;
        display: flex;
        box-sizing: border-box;
        .left_block{
            box-sizing: border-box;
            padding: 20px 20px;
            flex: 1;
            background: linear-gradient(#f6faff, #ecf5ff);
            display: flex;
            align-items: center;
            justify-content: center;
            img{width: 100%;}
        }
        .right_block{
            flex: 1;
            box-sizing: border-box;
            padding: 0 0px;
            text-align: center;
            .title{
                margin-top: 80px;
                font-size: 35px;
            }
            .sub_title{
                font-size: 12px;
                color:#999;
                text-transform:Uppercase ;
                margin-top: 8px;
            }
            .login_form{
                width: 80%;
                margin:0 auto;
            }
            .login_divder{
                width: 80%;
                margin:0 auto;
                margin-top: 30px;
                margin-bottom: 30px;
            }
            .disclaimers{
                margin:0;
            }

        }
    }
}
</style>
<style>
.admin_login .el-input--medium .el-input__icon{
    line-height: 40px;
}
</style>
