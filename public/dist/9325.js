"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[9325],{39325:(e,a,l)=>{l.r(a),l.d(a,{default:()=>o});var t=l(74061),n={class:"qwit"};const r={components:{tableView:l(38392).A},setup:function(e){var a=(0,t.getCurrentInstance)(),l=(a.ctx,a.proxy),n=[{label:"协议名称",value:"name"},{label:"调用名称",value:"ename"},{label:"发送内容",value:"content",type:"editor",viewType:"html",span:24}];return{options:(0,t.reactive)([{label:"协议名称",value:"name"},{label:"调用名称",value:"ename",type:"tags"},{label:"创建时间",value:"created_at"}]),searchOptions:(0,t.reactive)([{label:"协议名称",value:"name",where:"likeRight"},{label:"调用名称",value:"ename",where:"likeRight"}]),dialogParam:(0,t.reactive)({rules:{name:[{required:!0,message:l.$t("msg.requiredMsg")}],ename:[{required:!0,message:l.$t("msg.requiredMsg")}]},destroyOnClose:null,view:{column:n},add:{column:n},edit:{column:n}})}}};const o=(0,l(66262).A)(r,[["render",function(e,a,l,r,o,s){var i=(0,t.resolveComponent)("table-view");return(0,t.openBlock)(),(0,t.createElementBlock)("div",n,[(0,t.createVNode)(i,{options:r.options,searchOption:r.searchOptions,dialogParam:r.dialogParam},null,8,["options","searchOption","dialogParam"])])}]])}}]);