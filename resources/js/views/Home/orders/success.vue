<template>
    <div class="create_order_1 w1200">
        <div class="step_bar">
            <div class="step">
                <div class="item check"><el-icon><Shop /></el-icon>  {{$t('home.store_index.my_cart')}}</div>
                <div class="item check"><el-icon><MessageBox /></el-icon>{{$t('home.carts.address')}}</div>
                <div class="item check"><el-icon><Money /></el-icon>{{$t('home.carts.select_pay')}}</div>
                <div class="item check"><el-icon><CircleCheckFilled /></el-icon>{{$t('home.carts.pay_success')}}</div>
            </div>
        </div>

        <el-result
            icon="success"
            :title="$t('home.order_pay_success')"
            :sub-title="$t('home.more_view_order')"
        >
            <template #extra>
            <router-link to="/user">{{$t('home.go_to_user_center')}}</router-link>
            </template>
        </el-result>
    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import { Shop,CircleCheckFilled,Money,MessageBox,Check} from '@element-plus/icons'
export default {
    components: {Shop,CircleCheckFilled,Money,MessageBox,Check},
    setup() {
        const {proxy} = getCurrentInstance()
    }

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
a{
    border:1px solid #ddd;
    padding:6px 15px;
    border-radius: 3px;
}
a:hover{
    border-color:var(--el-color-primary);
    color:var(--el-color-primary);
}
</style>
