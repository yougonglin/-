import{r as e,aP as t,o as a,c as o,w as s,i as r,a as n,g as i,f as l,E as u,ac as p,aN as c,h as b,aQ as d,I as m,ae as g,j as f,s as h}from"./index-93e08a2b.js";import{_ as x}from"./n-button.3162a993.js";import{a as v,r as j}from"./uni-app.es.4a85af97.js";import{t as _}from"./util.84ba036b.js";import{b as T}from"./bulletinBoard.bc6e3929.js";import{w as y,g as w}from"./gps.2d861f2d.js";import{g as k}from"./common.b5c70975.js";import"./n-icon.3d1c4127.js";import"./props.e7779fd1.js";import"./_plugin-vue_export-helper.1b428a4d.js";import"./n-bg-view.98391b2e.js";const B={__name:"leaflet",setup(B){let S=e([]);function C(){_(i().globalData.config.shop.leafletShop)}function D(){_("/pages/user/help/kefu")}function I(){let e=l("wxScheme_supernova_uid");console.log(e),e&&(e=JSON.parse(e),e.expire_time>Math.ceil((new Date).getTime()/1e3))?_(e.url):i().globalData.userBaseInfo?k("/pages/index/gps","uid="+i().globalData.userBaseInfo.uid).then((t=>{console.log(t);let a=JSON.parse(t.data.data);"ok"==a.errmsg?(e='{"url" : "'+a.openlink+'","expire_time" : '+(Math.ceil((new Date).getTime()/1e3)+2505600)+"}",h("wxScheme_supernova_uid",e),_(a.openlink)):b({title:"打开微信小程序失败,请联系客服反馈",icon:"none",duration:5e3})})):u({url:"/pages/user/login/phoneCodeLogin"})}function J(){p({title:"请开启GPS定位服务"}),c({type:"wgs84",altitude:!0,isHighAccuracy:!0,success:e=>{let t=y(e.longitude,e.latitude),a=0;for(let o=0;o<S.value.length;o++){w(S.value[o].latitude,S.value[o].longitude,t[1],t[0]).m<=3e3&&S.value[o].id!=i().globalData.userBaseInfo.uid&&(a=S.value[o].id)}0!=a?b({title:"您的派发范围和他人的重叠了,请重新选择位置!",icon:"none"}):d(t[0],t[1]).then((e=>{1==e.data.data||0==e.data.data?b({title:"处理完毕,请开始发放传单吧!",icon:"none"}):m({title:"提示",content:e.data.data,confirmText:"立即充值",success:function(e){e.confirm&&u({url:"/pages/user/recharge/index"})}})}))},fail(e){m({title:"开启定位失败！",content:"请开启手机定位并同意软件使用其权限后重试!",showCancel:!1})},complete(){g()}})}return v((e=>{t().then((e=>{let t=[];for(let a=0;a<e.data.data.length;a++){let o=JSON.parse(e.data.data[a]);t.push(o)}S.value=t}))})),(e,t)=>{const i=j(f("n-button"),x),l=r;return a(),o(l,{class:""},{default:s((()=>[n(T,{title:"活动规则",description:"发一张传单给新用户，新用户得到传单并在您的派发范围内扫码登陆后，您就能得到1元的分红。<br><br>适合在人流量多的地方进行操作，比如：地铁门口，工厂门口，学校门口，小区门口,菜鸟驿站，步行街等<br><br>为避免浪费,传单需要购买，1万张800元,发完可得10000元<br><br>工作轻松，只需要伸手有人拿就有钱。您可以计算下，比如：一趟地铁有多少人可以发多少张？<br><br>禁止无效推广,如刻意引导用户扫码注册.违规将封禁账号且不予结算<br><br>最终解释权归本公司所有"}),n(i,{class:"n-ms-bottom-base",onButtonClicked:I,bgType:"error",textType:"inverse",border:"none",text:"查看派发范围"}),n(i,{class:"n-ms-bottom-base",onButtonClicked:J,bgType:"error",textType:"inverse",border:"none",text:"开始发放传单"}),n(i,{class:"n-ms-bottom-base",onButtonClicked:D,bgType:"error",textType:"inverse",border:"none",text:"咨询客服了解详情"}),n(i,{class:"n-ms-bottom-base n-ms-top-base",onButtonClicked:C,bgType:"error",textType:"inverse",border:"none",text:"购买传单"}),n(T,{title:"活动教程",description:"只需要购买传单,然后点击开始发放传单并正常派发传单即可获得收入.<br><br>查看派发范围<br>查看自己发放传单的所在位置以及新用户注册成功后能够让您获得分红的范围<br><br>开始发放传单<br>每次派发传单前必须点击(开始发放传单)进行定位,定位区域每天0点清空<br>为避免用户恶意开始发放传单占用他人正常派发,每次定位需支付3元(发3张传单赚的钱)<br>"})])),_:1})}}};export{B as default};
