<template>
    <div class="head">
        <div class="head_in">
            <div class="top_shop_left">
                <ul>
                    <li><router-link to="/">{{$t('home.store_index.home')}}</router-link></li>
                    <li>|</li>
                    <li><router-link to="/">{{$t('home.store_index.contact_address')}}</router-link></li>
                    <li>|</li>
                    <li><router-link to="/">{{$t('home.store_index.about')}}</router-link></li>
<!--                    <li>|</li>-->
<!--                    <li><router-link style="color:#ca151e;display:flex;align-items: center;" to="/"><img width="16" style="margin-top:4px;margin-right:4px;" :src="require('@/assets/order/address_pos3.png').default" >{{' '+data.city+' '||' - '}}</router-link></li>-->
                </ul>
            </div>
            <div class="top_shop_right">
                <ul>
                    <li v-show="!isLogin"><router-link to="/login">{{$t('home.store_index.login')}}</router-link></li>
                    <li v-show="!isLogin"><router-link to="/register">{{$t('home.store_index.register')}}</router-link></li>
                    <li v-show="isLogin">{{$t('home.store_index.welcome')}}，<router-link to="/" style="color:#ca151e">{{data.users.nickname||'-'}}</router-link></li>
                    <li v-show="isLogin">|</li>
                    <li v-show="isLogin"><router-link to="/user" >{{$t('home.store_index.personal_center')}}</router-link></li>
                    <li v-show="isLogin">|</li>
                    <li v-show="isLogin" @click="logout()">{{$t('home.store_index.cancel_account')}}</li>
                    <li>|</li>
                    <li><router-link to="/store/join" style="color:#ca151e">{{$t('home.store_index.merchant_settlement')}}</router-link></li>
                    <li>|</li>
                    <li>
                        <el-select style="width: 87px;border: 0;" size="mini" v-model="lang" @change="toggleLang" :placeholder="$t('btn.selected')">
                            <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                            >
                            </el-option>
                        </el-select>

                    </li>
<!--                    <li>|</li>-->
<!--                    <li><router-link to="/">APP下载</router-link></li>-->
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { useStore } from 'vuex'
import {ref,reactive,watch,computed,onMounted,getCurrentInstance} from "vue"
export default {
    setup(props) {
        const {proxy} = getCurrentInstance()
        const store = useStore()
        const routeUriIndex = store.state.load.routeUriIndex
        const data = reactive({
            users:computed( () => store.state.login.userData[routeUriIndex]),
            city:'北京市',
        })

        const options = [
            {
                value:'en',
                label: 'English'
            },
            {
                value:'zh-cn',
                label: '中文'
            },
            {
                value:'tha',
                label: 'THA'
            },
        ];

        const lang = computed( () => localStorage.getItem('language')==null?'zh-cn':localStorage.getItem('language') )


        const isLogin = computed( () => store.state.login.loginData[routeUriIndex].isLogin )
        const amapKey = computed( () => store.state.init.common.common.amap.key )
        const ip = computed( () => store.state.init.common.ip )

        let localCity = localStorage.getItem('city')
        if(!proxy.R.isEmpty(localCity)) data.city = localCity

        const logout = ()=>{
            store.commit('login/logout')
        }


        const toggleLang = (value)=>{
            localStorage.setItem('language', value);
            setLocationData()
            location.reload();
        }

        const setLocationData = async ()=>{
            const local = localStorage.getItem('language');
            const resp = await proxy.R.get('/set_lang',{lang:local})
            if(!resp.code){
                console.log(resp.data)
            } else {
                console.log(resp.data)
            }
        }


        const toggle = ()=>{
            const curLang = localStorage.getItem('language');
            const setLang = curLang == 'zh-cn' ? curLang : 'zh-cn';
            localStorage.setItem('language', setLang);
            location.reload();
        }

        const loadCity = ()=>{
            try{
                const ipLocal = localStorage.getItem('ip')
                const city = localStorage.getItem('city')
                if(ip.value == ipLocal && city) return
                localStorage.setItem('ip',ip.value)
                // if(!navigator.geolocation) return console.log('geolocation not allow')
                if(!amapKey) return
                const amapUrl = 'https://restapi.amap.com/v3/ip?parameters'
                proxy.R.get(amapUrl,{key:amapKey.value,ip:ip.value,type:4},true).then(res=>{
                    if(res.data.status == 0){
                        return console.log(res.data.info)
                    }
                    localStorage.setItem('city',res.data.city)
                    localStorage.setItem('lonlat',res.data.location)
                    data.city = res.data.city
                })
            }catch(error){
                console.error(error)
            }
        }

        onMounted(()=>{
            setTimeout(()=>{
                loadCity()
            },1000)
        })

        return {
            lang,
            options,
            isLogin,
            data,
            toggleLang,
            logout
        }
    },


};
</script>
<style lang="scss" scoped>
.head{
  border-bottom: 1px solid #efefef;
  height: 30px;
  background: #f9f9f9;
  font-size: 12px;
  line-height: 30px;
  position: fixed;
  z-index: 666;
  width: 100%;

  .head_in{
      width: 1200px;
      margin:0 auto;
      .top_shop_left{
          float: left;
          ul li{
              float: left;
              padding:0 5px;
          }
      }
      .top_shop_right{
          float: right;
          ul li{
              float: left;
              padding:0 5px;
          }
          li:hover{
              color:#ca151e;
          }
      }
  }
  .head_in:after{
      display: block;
      clear: both;
      content:'';
  }
  .head_in a:hover{
      color:#ca151e;
  }
}
</style>
