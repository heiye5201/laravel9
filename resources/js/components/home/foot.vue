<template>
    <div class="shop_foot center1200">
<!--        <ul>-->
<!--            <li><router-link to="">500强企业 品质保证</router-link></li>-->
<!--            <li><router-link to="">7天退货 15天换货</router-link></li>-->
<!--            <li><router-link to="">99元起免运费</router-link></li>-->
<!--            <li><router-link to="">448家维修网点 全国联保</router-link></li>-->
<!--        </ul>-->
        <div class="foot_copyright">
            <p>隐私政策 服务协议 Copyright © 2022-2023 {{common.web_name}} 版权所有 保留一切权利</p>
            <p> {{common.icp}} | ICP备案号：闽ICP备2022004862号</p>
        </div>
        <el-backtop />
    </div>
</template>

<script>
import { useStore } from 'vuex'
import {reactive,computed,getCurrentInstance} from "vue"
export default {
    setup() {
        const store = useStore()
        const common = reactive(computed(()=>store.state.init.common.common))
        return {common}
    }
};
</script>
<style lang="scss" scoped>
.shop_foot{
    padding-top: 10px;
    text-align: center;
    ul{
        margin:40px auto 0 auto;
        width: 664px;
        border-top: 1px solid #efefef;
        padding-top: 40px;
    }
    ul li{
        float: left;
        margin-right: 40px;
        margin-bottom: 60px;
        font-size: 14px;
        a:hover{
            color:#ca151e;
        }
    }
    ul li:last-child{
        margin-right: 0px;
    }
    .foot_copyright{
        clear: both;
        font-size: 12px;
        line-height: 35px;
        padding-bottom: 20px;
    }
}
</style>
