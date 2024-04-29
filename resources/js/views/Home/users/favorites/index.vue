<template>
    <div class="user_main table_lists">
        <div class="block_title">
            {{$t('user_center.favorites.index')}}
            <span><div class="btn" @click="openAdd">{{data.isGoods?$t('user_center.favorites.shop_follow'):$t('user_center.favorites.goods_collection')}}</div></span>
        </div>
        <div class="x20 clear_line"></div>
        <table-view v-if="data.isGoods" :params="{is_type:0}" :handleWidth="150" :options="options" :btnConfig="btnConfigs" >
            <template #table_handleright_hook="{rows}">
                <el-button :title="$t('btn.view')"  :icon="View" @click="$router.push((rows.is_type==0?'/goods/':'/store/')+rows.id)" />
            </template>
        </table-view>
        <table-view v-if="!data.isGoods" :params="{is_type:1}" :handleWidth="150" :options="options2" :btnConfig="btnConfigs" >
            <template #table_handleright_hook="{rows}">
                <el-button :title="$t('btn.view')"  :icon="View" @click="$router.push((rows.is_type==0?'/goods/':'/store/')+rows.id)" />
            </template>
        </table-view>
    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import { View  } from '@element-plus/icons'
import tableView from "@/components/common/table"
export default {
    components:{tableView},
    setup(props) {
        const {proxy} = getCurrentInstance()
        const data = reactive({
            isGoods:true,
        })

        // 配置字段
        const options = reactive([
            {label:proxy.$t('user_center.favorites.goods_master_image'),value:'goods_master_image',type:'avatar'},
            {label:proxy.$t('user_center.favorites.goods_name'),value:'goods_name',overFlow:true},
            {label:proxy.$t('user_center.favorites.goods_price'),value:'goods_price'},
            {label:proxy.$t('user_center.favorites.created_at'),value:'created_at'},
        ]);
        const options2 = reactive([
            {label:proxy.$t('user_center.favorites.store_logo'),value:'store_logo',type:'avatar'},
            {label:proxy.$t('user_center.favorites.store_name'),value:'store_name',overFlow:true},
            {label:proxy.$t('user_center.favorites.created_at'),value:'created_at'},
        ]);


        const btnConfigs = reactive({
            store:{show:false},
            update:{show:false},
            show:{show:false},
            search:{show:false},
            export:{show:false},
            destroy:{show:false},
            destroy:{show:false},
            deletes:{show:true},
        })

        const openAdd = async ()=>{
            data.isGoods = !data.isGoods
        }

        return {View,options,options2,btnConfigs,data,openAdd}
    }
}
</script>
<style lang="scss" scoped>

</style>
