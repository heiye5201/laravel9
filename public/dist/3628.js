"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[3628],{46397:(e,t,o)=>{o.r(t),o.d(t,{default:()=>r});const r="/dist/images/default.png?5c8a505ff72741ba3ad1f8a5fc71553e"},31352:(e,t,o)=>{o.d(t,{A:()=>a});var r=o(76798),n=o.n(r)()((function(e){return e[1]}));n.push([e.id,'.order_info_list[data-v-cbf49da8]{margin-bottom:20px}.order_item_list ul li[data-v-cbf49da8]{border-left:1px solid #efefef;border-right:1px solid #efefef;border-top:1px solid #efefef;padding:20px 15px}.order_item_list ul li[data-v-cbf49da8]:last-child{border-bottom:1px solid #efefef}.order_item_list ul li[data-v-cbf49da8]:after{clear:both;content:"";display:block}.order_item_list ul li .order_thumb[data-v-cbf49da8]{background:#efefef;border:1px solid #efefef;box-sizing:border-box;float:left;height:42px;margin-right:15px;overflow:hidden;width:42px}.order_item_list ul li .order_thumb img[data-v-cbf49da8]{height:40px;width:40px}.order_item_list ul li .order_list_title[data-v-cbf49da8]{float:left;font-size:12px;height:40px;line-height:20px;overflow:hidden;width:280px}.order_item_list ul li .order_list_attr[data-v-cbf49da8]{float:left;line-height:40px;text-align:center;width:190px}.order_item_list ul li .order_list_num[data-v-cbf49da8]{float:left;line-height:40px;text-align:center;width:140px}.order_item_list ul li .order_list_price[data-v-cbf49da8]{color:#ca151e;float:right;line-height:40px;text-align:center;width:90px}',""]);const a=n},93628:(e,t,o)=>{o.r(t),o.d(t,{default:()=>X});var r=o(74061),n=function(e){return(0,r.pushScopeId)("data-v-cbf49da8"),e=e(),(0,r.popScopeId)(),e},a={class:"user_main"},i={class:"block_title"},d=n((function(){return(0,r.createElementVNode)("div",{class:"x20"},null,-1)})),l={class:"admin_form"},s={class:"order_info_list"},c={class:"content"},u={class:"content"},f={style:{"margin-top":"40px"}},_={style:{"font-size":"14px","font-weight":"bold"}},p=n((function(){return(0,r.createElementVNode)("div",{class:"x20"},null,-1)})),m={class:"order_info_list"},g={class:"content"},x={class:"content"},h={class:"content"},y={class:"order_info_list"},N={class:"content"},V={style:{"margin-top":"40px"}},v={style:{"font-size":"14px","font-weight":"bold"}},S=n((function(){return(0,r.createElementVNode)("div",{class:"x20"},null,-1)})),w={class:"order_info_list"},E={class:"content"},b={class:"content"},D={class:"content"},k={style:{"margin-top":"40px"}},C={style:{"font-size":"14px","font-weight":"bold"}},$=n((function(){return(0,r.createElementVNode)("div",{class:"x20"},null,-1)})),T={class:"order_item_list"},B={class:"order_thumb"},I=["src","alt"],R={class:"order_list_title"},z={class:"order_list_attr"},A={class:"order_list_num"},F={class:"order_list_price"},L={class:"order_info_right_price"},H={"data-v-01d38243":""},M={style:{"margin-top":"40px"}},j={style:{"font-size":"14px","font-weight":"bold"}},q=n((function(){return(0,r.createElementVNode)("div",{class:"x20"},null,-1)})),G={class:"order_info_kd"},J=n((function(){return(0,r.createElementVNode)("br",null,null,-1)}));var K=o(43992);const O={components:{},setup:function(e){var t=(0,r.getCurrentInstance)().proxy,o=(0,K.useRoute)(),n=(0,r.reactive)({id:0,info:{order_status:0,order_goods:[]},columns:[{title:t.$t("user_center.order.info.goods_name"),key:"goods_name",dataIndex:"goods_name",fixed:"left",scopedSlots:{customRender:"goods_name"}},{title:t.$t("user_center.order.info.sku_name"),key:"sku_name",dataIndex:"sku_name",scopedSlots:{customRender:"sku_name"}},{title:t.$t("user_center.order.info.buy_num"),key:"buy_num",dataIndex:"buy_num",scopedSlots:{customRender:"buy_num"}},{title:t.$t("user_center.order.info.goods_price"),key:"goods_price",dataIndex:"goods_price",scopedSlots:{customRender:"goods_price"}},{title:t.$t("user_center.order.info.goods_image"),key:"goods_image",dataIndex:"goods_image",scopedSlots:{customRender:"goods_image"}}],list:[]});return(0,r.onMounted)((function(){t.R.isEmpty(o.params.id)||(n.id=o.params.id),t.R.get("/user/order/"+n.id+"?isResource=Home").then((function(e){e.code||(n.info=e),console.log(n)})).catch((function(e){console.log(e)}))})),{data:n}},methods:{loadData:function(){},addData:function(e){console.info(e)}}};var P=o(85072),Q=o.n(P),U=o(31352),W={insert:"head",singleton:!1};Q()(U.A,W);U.A.locals;const X=(0,o(66262).A)(O,[["render",function(e,t,n,K,O,P){var Q=(0,r.resolveComponent)("el-col"),U=(0,r.resolveComponent)("el-tag"),W=(0,r.resolveComponent)("el-row"),X=(0,r.resolveComponent)("el-timeline-item"),Y=(0,r.resolveComponent)("el-timeline"),Z=(0,r.resolveComponent)("el-empty");return(0,r.openBlock)(),(0,r.createElementBlock)("div",a,[(0,r.createElementVNode)("div",i,(0,r.toDisplayString)(e.$t("user_center.order.info.detail")),1),d,(0,r.createElementVNode)("div",l,[(0,r.createElementVNode)("div",s,[(0,r.createVNode)(W,null,{default:(0,r.withCtx)((function(){return[(0,r.createVNode)(Q,{span:12},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("home.carts.order_sn"))+"：",1),(0,r.createElementVNode)("span",c,(0,r.toDisplayString)(K.data.info.order_no||"-"),1)]})),_:1}),(0,r.createVNode)(Q,{span:12},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.status"))+"： ",1),(0,r.createElementVNode)("span",u,[(0,r.withDirectives)((0,r.createVNode)(U,{type:"danger"},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(K.data.info.order_status_cn),1)]})),_:1},512),[[r.vShow,0==K.data.info.order_status]]),(0,r.withDirectives)((0,r.createVNode)(U,{type:"warning"},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(K.data.info.order_status_cn),1)]})),_:1},512),[[r.vShow,1==K.data.info.order_status]]),(0,r.withDirectives)((0,r.createVNode)(U,null,{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(K.data.info.order_status_cn),1)]})),_:1},512),[[r.vShow,K.data.info.order_status>1&&K.data.info.order_status<6]]),(0,r.withDirectives)((0,r.createVNode)(U,{type:"info"},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(K.data.info.order_status_cn),1)]})),_:1},512),[[r.vShow,6==K.data.info.order_status]]),(0,r.withDirectives)((0,r.createVNode)(U,{type:"success"},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(K.data.info.order_status_cn),1)]})),_:1},512),[[r.vShow,K.data.info.order_status>=7]])])]})),_:1})]})),_:1})]),(0,r.createElementVNode)("div",f,[(0,r.createElementVNode)("span",_,(0,r.toDisplayString)(e.$t("user_center.order.info.order_pay")),1)]),p,(0,r.createElementVNode)("div",m,[(0,r.createVNode)(W,null,{default:(0,r.withCtx)((function(){return[(0,r.createVNode)(Q,{span:8},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.pay_type"))+"：",1),(0,r.createElementVNode)("span",g,(0,r.toDisplayString)(K.data.info.payment_name_cn||"-"),1)]})),_:1}),(0,r.createVNode)(Q,{span:8},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.pay_time"))+"：",1),(0,r.createElementVNode)("span",x,(0,r.toDisplayString)(K.data.info.pay_time||"-"),1)]})),_:1}),(0,r.createVNode)(Q,{span:8},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.tracking_number"))+"：",1),(0,r.createElementVNode)("span",h,(0,r.toDisplayString)(K.data.info.delivery_no||"-"),1)]})),_:1})]})),_:1})]),(0,r.createElementVNode)("div",y,[(0,r.createVNode)(W,null,{default:(0,r.withCtx)((function(){return[(0,r.createVNode)(Q,{span:24},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.remarks"))+"：",1),(0,r.createElementVNode)("span",N,(0,r.toDisplayString)(K.data.info.remark||"-"),1)]})),_:1})]})),_:1})]),(0,r.createElementVNode)("div",V,[(0,r.createElementVNode)("span",v,(0,r.toDisplayString)(e.$t("user_center.order.info.logistics_address")),1)]),S,(0,r.createElementVNode)("div",w,[(0,r.createVNode)(W,null,{default:(0,r.withCtx)((function(){return[(0,r.createVNode)(Q,{span:8},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.consignee"))+"：",1),(0,r.createElementVNode)("span",E,(0,r.toDisplayString)(K.data.info.receive_name),1)]})),_:1}),(0,r.createVNode)(Q,{span:8},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.phone"))+"：",1),(0,r.createElementVNode)("span",b,(0,r.toDisplayString)(K.data.info.receive_tel),1)]})),_:1}),(0,r.createVNode)(Q,{span:8},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.address"))+"：",1),(0,r.createElementVNode)("span",D,(0,r.toDisplayString)(K.data.info.receive_area+K.data.info.receive_address),1)]})),_:1})]})),_:1})]),(0,r.createElementVNode)("div",k,[(0,r.createElementVNode)("span",C,(0,r.toDisplayString)(e.$t("user_center.order.info.goods_info")),1)]),$,(0,r.createElementVNode)("div",T,[(0,r.createElementVNode)("ul",null,[((0,r.openBlock)(!0),(0,r.createElementBlock)(r.Fragment,null,(0,r.renderList)(K.data.info.order_goods,(function(e,t){return(0,r.openBlock)(),(0,r.createElementBlock)("li",{key:t},[(0,r.createElementVNode)("div",B,[(0,r.createElementVNode)("img",{src:e.goods_image||o(46397).default,alt:e.goods_name},null,8,I)]),(0,r.createElementVNode)("div",R,(0,r.toDisplayString)(e.goods_name||"-"),1),(0,r.createElementVNode)("div",z,(0,r.toDisplayString)(e.sku_name||"-"),1),(0,r.createElementVNode)("div",A,"x "+(0,r.toDisplayString)(e.buy_num||"1"),1),(0,r.createElementVNode)("div",F,"￥"+(0,r.toDisplayString)(e.goods_price||"0.00"),1)])})),128))])]),(0,r.createElementVNode)("div",L,[(0,r.createTextVNode)((0,r.toDisplayString)(e.$t("user_center.order.info.total"))+"：￥ "+(0,r.toDisplayString)(K.data.info.total_price),1),(0,r.createElementVNode)("span",H,"（"+(0,r.toDisplayString)(e.$t("user_center.order.info.freight_money"))+"："+(0,r.toDisplayString)(K.data.info.freight_money)+"）",1)]),(0,r.createElementVNode)("div",M,[(0,r.createElementVNode)("span",j,(0,r.toDisplayString)(e.$t("user_center.order.info.tracking")),1)]),q,(0,r.createElementVNode)("div",G,[K.data.info.delivery_list&&K.data.info.delivery_list.length>0?((0,r.openBlock)(),(0,r.createBlock)(Y,{key:0},{default:(0,r.withCtx)((function(){return[((0,r.openBlock)(!0),(0,r.createElementBlock)(r.Fragment,null,(0,r.renderList)(K.data.info.delivery_list,(function(e,t){return(0,r.openBlock)(),(0,r.createBlock)(X,{key:t,timestamp:e.time,color:0==t?"red":"gray"},{default:(0,r.withCtx)((function(){return[(0,r.createTextVNode)((0,r.toDisplayString)(e.context),1)]})),_:2},1032,["timestamp","color"])})),128))]})),_:1})):((0,r.openBlock)(),(0,r.createBlock)(Z,{key:1}))]),J])])}],["__scopeId","data-v-cbf49da8"]])}}]);