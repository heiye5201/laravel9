<template>
    <div class="store_join w1200">
        <div class="step_bar">
            <div class="step">
                <div class="item success"><el-icon :size="16"><Reading /></el-icon>{{$t('home.store.agree_message')}}</div>
                <div class="item success"><el-icon :size="16"><List /></el-icon>{{$t('home.store.write_message')}}</div>
                <div :class="{item:true,check:data.info.store_verify==2,success:data.info.store_verify==3 ||data.info.store_verify==4 }"><el-icon :size="16"><SetUp /></el-icon>{{$t('home.store.apply_status')}}</div>
                <div :class="{item:true,check:data.info.store_verify==3  ,success:data.info.store_verify==4}"><el-icon :size="16"><CircleCheckFilled /></el-icon>{{data.info.store_verify==3?$t('home.store.apply_failed'):$t('home.store.apply_agree')}}</div>
            </div>
        </div>
        <el-result
            :icon="data.resultIcon"
            :title="data.resultText"
            :sub-title="data.subTitle"
        >
        </el-result>
        <div class="agreement_btn" v-if="data.info.store_verify==3"><el-button color="#e50e19" type="primary" @click="nextStep">{{$t('home.store.update_join_message')}}</el-button></div>
        <div class="agreement_btn" v-if="data.info.store_verify==4"><el-button color="#e50e19" type="primary" @click="nextStep">{{$t('home.store.update_setting_store')}}</el-button></div>
    </div>
</template>

<script>
import {reactive,onMounted,getCurrentInstance} from "vue"
import { Reading,CircleCheckFilled,List,SetUp } from '@element-plus/icons'
export default {
    components: {Reading,CircleCheckFilled,List,SetUp},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const data = reactive({
            info:{},
            resultIcon:'success',
            subTitle:null,
            resultText:proxy.$t('home.store.apply_success'),
        })
        onMounted( async ()=>{
            data.info = await proxy.R.get('/store')
            if(data.info.store_verify == 2){
                data.resultText = proxy.$t('home.store.apply_store_verify')
                data.resultIcon = 'warning'
            }
            if(data.info.store_verify == 3){
                data.resultText = proxy.$t('home.store.fail_store_verify')
                data.subTitle = data.info.store_refuse_info
                data.resultIcon = 'error'
            }
            if(data.info.store_verify == 4){
                data.resultText = proxy.$t('home.store.apply_success')
                data.resultIcon = 'success'
            }
        })
        const nextStep = ()=>{

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
</style>>

