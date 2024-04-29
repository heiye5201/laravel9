<template>
    <div class="user_user_info">
        <div class="user_main">
            <div class="block_title">
                <span style="float:right;font-size:12px;color:#999;padding-right:10px;padding-left:20px;line-height:22px">{{$t('user_center.articles.update_time')}}：{{data.info.updated_at}}</span>
                <span style="float:right;font-size:12px;color:#999;padding-right:20px;line-height:22px;border-right:1px solid #efefef;">{{$t('user_center.articles.hits')}}：{{data.info.click}}</span>
                {{data.info.name||$t('user_center.articles.help')}}
            </div>
            <div class="x20"></div>
            <div v-html="editorHtml(data.info.content)"></div>
        </div>

    </div>
</template>

<script>
import {reactive,getCurrentInstance} from "vue"
import {useRoute} from "vue-router"
import {editorHandle} from '@/plugins/config'

export default {
    setup(props) {
        const {proxy} = getCurrentInstance()
        const route = useRoute()
        const data = reactive({
            info:{}
        })

        // editor
        const editorHtml = (e)=>{
            return editorHandle(e)
        }

        const loadData = ()=>{
            proxy.R.get('/article/'+route.params.name).then(res=>{
                if(!res.code) data.info = res
            })
        }

        loadData()

        return {
            data,editorHtml
        }
    }
}
</script>

<style scoped>
.user_main{
    min-height: 650px;
}
</style>
