import{_ as t}from"./n-tabs-h.5c030a13.js";import{r as a,l as e,o as i,c as s,w as r,bb as l,i as n,a as o,u,G as c,b as p,d,F as m,j as v}from"./index-93e08a2b.js";import{a as h,d as x,r as b}from"./uni-app.es.4a85af97.js";import{_ as f}from"./n-check-static.db256b0c.js";import{_ as g}from"./uni-list-chat.b2b5c8a2.js";import{_ as j}from"./uni-list.59733bbb.js";import"./n-badge.17d08f78.js";import"./props.e7779fd1.js";import"./system.0fbb2200.js";import"./_plugin-vue_export-helper.1b428a4d.js";import"./n-icon.3d1c4127.js";const _={__name:"integral",setup(_){let y=a(1),k=a(0);function T(t){k.value=t,y.value=1,z()}function w(){y.value=1,z()}let F=a([1]);const L=a([{value:1,text:"收入"},{value:2,text:"支出"}]);let S=a([]);const B=e((()=>t=>2==t?"/static/ui/zhichu.png":"/static/ui/shouru.png")),C=e((()=>t=>2==t?"支出":"收入"));function z(t){l(y.value,k.value,F.value[0]).then((a=>{S.value=t?S.value.concat(a.data.data):a.data.data}))}return h((t=>{z()})),x((()=>{y.value++,z(!0)})),(a,e)=>{const l=b(v("n-tabs-h"),t),h=b(v("n-check-static"),f),x=b(v("uni-list-chat"),g),_=b(v("uni-list"),j),y=n;return i(),s(y,{class:""},{default:r((()=>[o(l,{tabsStyle:"width: 100% !important;width:750rpx;",class:"pc-tabs-h",justify:"center",isTap:!0,delay:50,value:u(k),items:["金币记录","银币记录","余额记录"],width:"250rpx",indicatorWidth:"250rpx",indicatorHeight:"6rpx",onChange:T,indicatorType:"error",activeTextType:"error"},null,8,["value"]),o(h,{onChange:w,limits:1,valueLabel:"value",textLabel:"text",value:u(F),"onUpdate:value":e[0]||(e[0]=t=>c(F)?F.value=t:F=t),icon:"circle",checkedIcon:"check-solid",items:L.value,direction:"right",isBetween:!0,itemBoxStyle:"background-color:#F5F7F9;padding-left:32rpx;padding-right:32rpx;",boxStyle:"border-radius:16rpx;overflow:hidden;"},null,8,["value","items"]),o(y,{class:""},{default:r((()=>[o(_,{border:!1},{default:r((()=>[(i(!0),p(m,null,d(u(S),((t,a)=>(i(),s(x,{key:t.id,clickable:!0,title:u(C)(t.type),note:t.mark,time:t.create_time,badgeText:t.num,avatar:u(B)(t.type)},null,8,["title","note","time","badgeText","avatar"])))),128))])),_:1})])),_:1})])),_:1})}}};export{_ as default};
