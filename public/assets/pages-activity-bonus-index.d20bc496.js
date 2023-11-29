import{ak as e,B as t,r as n,l as a,X as s,o as r,c as o,w as l,i,a as c,x as d,y as u,u as f,t as g,e as _,Z as m,h as p,I as x,E as b,A as h,j as y}from"./index-93e08a2b.js";import{_ as w}from"./uni-card.cdd0fff8.js";import{o as v,r as k}from"./uni-app.es.4a85af97.js";import{_ as T}from"./n-button.3162a993.js";import{_ as j}from"./vaptcha-v3.76b405fa.js";import{b as C}from"./bulletinBoard.bc6e3929.js";import{_ as q}from"./_plugin-vue_export-helper.1b428a4d.js";import"./n-icon.3d1c4127.js";import"./props.e7779fd1.js";import"./n-bg-view.98391b2e.js";const z=q({__name:"index",setup(q){let z=t({data:{sign_time_morning:"1684969200",sign_time_noon:"1684987200",sign_time_afternoon:"1685008800"}}),B=n(""),E=n(!1),$=t({data:{signed_days:0}}),D=n(0),R=n(!1);const S=a((()=>e=>1==z.data[`${e}_sign`]?"#fef7ec":"white"));let M=n(m.HTTP_REQUEST_URL+"/tcaptcha.html");function O(e){B.value=e}const P=a((()=>e=>{switch(e){case 0:return"上午";case 1:return"中午";case 2:return"下午"}})),G=a((()=>{let e=new Date(1e3*z.data.sign_time_morning);const t=e.getFullYear(),n=e.getMonth()+1<10?"0"+(e.getMonth()+1):e.getMonth()+1,a=e.getDate();return e=`${t}年${n}月${a}日`,"2023年05月25日"==e?"未报名活动":e})),H=a((()=>e=>{switch(e){case 0:return A(z.data.sign_time_morning);case 1:return A(z.data.sign_time_noon);case 2:return A(z.data.sign_time_afternoon)}}));function A(e){const t=new Date(1e3*e);let n=t.getHours();n=n<10?"0"+n:n;let a=t.getMinutes();return a=a<10?"0"+a:a,`${n}:${a}`}function I(){if($.data.id){if(z.data[B.value+"_sign"])return void p({title:"当前时间已签到",icon:"error"});if(Date.parse(new Date)/1e3<z.data["sign_time_"+B.value])return void p({title:"还未到签到时间,请稍后重试!",icon:"error"});R.value=!0}else e.request({url:"/app/bonus/build_order",method:"GET"}).then((e=>{uni.report("bonusBuildOrder","分红订单创建"),e.data.data?F():x({title:"支付提示",content:"您的余额不足10元，请先充值",confirmText:"充值余额",success:e=>{e.confirm&&b({url:"/pages/user/recharge/index"})}})}))}function L(){var t;(t=$.data.id,e.request({url:"/app/bonus/countersign",method:"POST",data:{id:t}})).then((e=>{"ok"==e.data.data?F():x({title:"支付提示",content:"补签所需花费"+e.data.data+"元，您的余额不足,请先充值",confirmText:"充值余额",success:e=>{e.confirm&&b({url:"/pages/user/recharge/index"})}})}))}function U(){e.request({url:"/app/bonus/close_order",method:"GET"}).then((e=>{z.data={sign_time_morning:"1684969200",sign_time_noon:"1684987200",sign_time_afternoon:"1685008800"},E.value=!1,$.data={signed_days:0}}))}function F(){e.request({url:"/app/bonus/get_order",method:"GET"}).then((t=>{var n;t.data.data&&($.data=t.data.data,(n=$.data.id,e.request({url:"/app/bonus/get_task",method:"POST",data:{id:n}})).then((e=>{e.data.data?(z.data=e.data.data,E.value=!1):E.value=!0})))}))}function J(t){var n,a,s;R.value=!1,0==t.ret&&(n=$.data.id,a=t.ticket,s=t.randstr,e.request({url:"/app/bonus/sign",method:"POST",data:{id:n,Ticket:a,Randstr:s}})).then((e=>{switch(e.data.data){case 1:F(),x({title:"提示",content:"签到成功，任务已更新，请查看后准时完成！",showCancel:!1});break;case 2:x({title:"提示",content:"本次签到成功",showCancel:!1}),F();break;case 3:x({title:"提示",content:"签到时间还未到，请稍后重试!",showCancel:!1});break;case 4:E.value=!0,x({title:"提示",content:"您错过了签到时间，任务失败!可选择补签或重新开始签到",showCancel:!1});break;case 5:p({title:"图形验证码错误,请重新输入!",icon:"error"});break;case 6:$.data={signed_days:0},z.data={sign_time_morning:"1684969200",sign_time_noon:"1684987200",sign_time_afternoon:"1685008800"},x({title:"提示",content:"恭喜您成功签到365天，奖励已发放!",confirmText:"立即提现",success:function(e){e.confirm&&b({url:"/pages/user/candy/withdrawal"})}})}}))}return v((()=>{D.value=s().windowHeight,F()})),(e,t)=>{const n=h,a=i,s=k(y("uni-card"),w),m=k(y("n-button"),T),p=k(y("vaptcha-v3"),j);return r(),o(a,{class:""},{default:l((()=>[c(s,null,{default:l((()=>[c(a,{class:"n-flex-column n-justify-center n-ps-top-ll n-ps-bottom-ll"},{default:l((()=>[c(n,{class:"n-weight-8 n-ms-bottom-ll n-text-align-center n-size-ll",style:{}},{default:l((()=>[d("剩余签到天数")])),_:1}),c(n,{class:"n-weight-8 n-text-align-center n-size-ll"},{default:l((()=>[d(u(365-f($).data.signed_days),1)])),_:1})])),_:1})])),_:1}),c(s,{title:"签到时间",extra:f(G)},{default:l((()=>[c(a,{class:"n-ps-top-ll n-flex-row n-justify-between n-ms-bottom-ll",style:{width:"606rpx"}},{default:l((()=>[f(E)?(r(),o(a,{key:0,class:"n-flex-column n-justify-center n-flex-1"},{default:l((()=>[c(n,{class:"n-weight-8 n-text-align-center n-size-ll"},{default:l((()=>[d("签到失败")])),_:1})])),_:1})):(r(),o(a,{key:1,class:"n-flex-row n-justify-between n-flex-1"},{default:l((()=>[c(a,{style:g({"background-color":f(S)("morning")}),class:"n-flex-column n-radius-base price-card",onClick:t[0]||(t[0]=e=>O("morning"))},{default:l((()=>[c(n,{class:"n-text-align-center",style:{color:"#754e19","margin-bottom":"26rpx"}},{default:l((()=>[d(u(f(P)(0)),1)])),_:1}),c(a,{class:"n-flex-row n-align-center"},{default:l((()=>[c(n,{class:"n-text-align-center",style:{color:"#754e19","font-size":"48rpx","font-weight":"800"}},{default:l((()=>[d(u(f(H)(0)),1)])),_:1})])),_:1})])),_:1},8,["style"]),c(a,{style:g({"background-color":f(S)("noon")}),class:"n-flex-column n-radius-base price-card",onClick:t[1]||(t[1]=e=>O("noon"))},{default:l((()=>[c(n,{class:"n-text-align-center",style:{color:"#754e19","margin-bottom":"26rpx"}},{default:l((()=>[d(u(f(P)(1)),1)])),_:1}),c(a,{class:"n-flex-row n-align-center"},{default:l((()=>[c(n,{class:"n-text-align-center",style:{color:"#754e19","font-size":"48rpx","font-weight":"800"}},{default:l((()=>[d(u(f(H)(1)),1)])),_:1})])),_:1})])),_:1},8,["style"]),c(a,{style:g({"background-color":f(S)("afternoon")}),class:"n-flex-column n-radius-base price-card",onClick:t[2]||(t[2]=e=>O("afternoon"))},{default:l((()=>[c(n,{class:"n-text-align-center",style:{color:"#754e19","margin-bottom":"26rpx"}},{default:l((()=>[d(u(f(P)(2)),1)])),_:1}),c(a,{class:"n-flex-row n-align-center"},{default:l((()=>[c(n,{class:"n-text-align-center",style:{color:"#754e19","font-size":"48rpx","font-weight":"800"}},{default:l((()=>[d(u(f(H)(2)),1)])),_:1})])),_:1})])),_:1},8,["style"])])),_:1}))])),_:1}),c(a,{slot:"actions",class:"card-actions n-ms-bottom-ll"},{default:l((()=>[f(E)?(r(),o(a,{key:0,class:"",style:{padding:"26rpx"}},{default:l((()=>[c(m,{bgType:"error",textType:"inverse",border:"none",radius:"ll",text:"补签",onButtonClicked:L}),c(m,{bgType:"error",textType:"inverse",border:"none",radius:"ll",text:"退出任务,重新签到",onButtonClicked:U,style:{"margin-top":"26rpx"}})])),_:1})):(r(),o(a,{key:1,class:"",style:{padding:"26rpx"}},{default:l((()=>[c(m,{bgType:"error",textType:"inverse",border:"none",radius:"ll",text:"立即签到",onButtonClicked:I})])),_:1}))])),_:1})])),_:1},8,["extra"]),c(C,{title:"活动规则",description:"轻松签到,每日白嫖一顿外卖<br><br>只需要连续签到365天,即可获得10000金币<br><br>金币可提现约等于10000元.<br><br>每日需签到3次,签到时间随机分别为上午,中午,下午.<br><br>签到时间限制为开始签到时间往后10分钟以内<br><br>参与活动需缴纳30元报名费,签到失败,报名费不退还"}),f(R)?(r(),o(p,{key:0,style:g([{position:"fixed",top:"0",left:"0",width:"750rpx","min-width":"100%"},{height:f(D)+"px"}]),url:f(M),onReceive:J},null,8,["style","url"])):_("",!0)])),_:1})}}},[["__scopeId","data-v-8345a1eb"]]);export{z as default};
