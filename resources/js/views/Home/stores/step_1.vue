<template>
    <div class="store_join w1200">
        <div class="step_bar">
            <div class="step">
                <div class="item check"><el-icon :size="16"><Reading /></el-icon>{{$t('home.store.agree_message')}}</div>
                <div class="item"><el-icon :size="16"><List /></el-icon>{{$t('home.store.write_message')}}</div>
                <div class="item"><el-icon :size="16"><SetUp /></el-icon>{{$t('home.store.apply_status')}}</div>
                <div class="item"><el-icon :size="16"><CircleCheckFilled /></el-icon>{{$t('home.store.apply_agree')}}</div>
            </div>
        </div>
        <el-divider style="width:420px;margin:0 auto;"><em style="font-size:20px;">{{$t('home.store.join_message')}}</em></el-divider>
        <el-scrollbar class="agreement_content"  v-html="data.info.content||''"></el-scrollbar>
        <div class="agreement_btn"><el-checkbox v-model="data.checked">{{$t('home.store.agree_join_message')}}</el-checkbox></div>
        <div class="agreement_btn"><el-button color="#e50e19" type="primary" @click="nextStep">{{$t('home.store.agree_message_next')}}</el-button></div>
    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import router from '@/plugins/router'
import { Reading,CircleCheckFilled,List,SetUp } from '@element-plus/icons'
export default {
    components: {Reading,CircleCheckFilled,List,SetUp},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const data = reactive({
            checked:false,
            info:{}
        })
        const nextStep = async ()=>{
            if(!data.checked) return proxy.$message.error(proxy.$t('msg.readAgreement'))
            let joinData = await proxy.R.post('/store/join',{})
            router.push('/store/step_2')
        }
        return {nextStep,data}
    }
}
</script>

<style lang="scss" scoped>
.store_join{
    margin-top:40px;
}
.agreement_btn{
    margin:20px 0 10px 0;
    text-align: center;
}
.agreement_content{
    padding:20px;
    height: 600px;
}
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
        // float: left;
        // width: 25%;
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
        &:last-child{
            margin-right: 0px;
        }
    }
}
</style>>

