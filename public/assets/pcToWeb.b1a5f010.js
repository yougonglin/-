import{r as e,f as a,Z as s,aA as t,j as r,u as o,o as n,c as i,w as A,b as l,F as u,a as c,x as d,e as p,z as f,i as b,A as Q}from"./index-93e08a2b.js";import{_ as m}from"./u-qrcode.710744ab.js";import{r as w}from"./uni-app.es.4a85af97.js";import{b as G}from"./bulletinBoard.bc6e3929.js";import{_ as M}from"./_plugin-vue_export-helper.1b428a4d.js";const g=M({__name:"pcToWeb",props:{redirectUrl:{type:String,default:""},pcCanUse:{type:Boolean,default:!1}},setup(M){const g=M;let v=e(!1),y=e(!1);const D=a("loginToken");let S=e(s.HTTP_REQUEST_URL+"/pages/user/invite/transfer#"+encodeURIComponent(g.redirectUrl)+"(*-.-*)"+encodeURIComponent(D)),U=navigator.userAgent.toLowerCase();return U.includes("micromessenger")||U.includes("alipayclient")?v.value=!0:0==g.pcCanUse&&(y.value="pc"==t().deviceType),(e,a)=>{const s=f,t=b,M=Q,g=w(r("u-qrcode"),m);return o(v)||o(y)?(n(),i(t,{key:0,class:"n-position-fixed h5tip"},{default:A((()=>[o(v)?(n(),l(u,{key:0},[c(t,{class:"acea-row row-between-wrapper"},{default:A((()=>[c(t,null,{default:A((()=>[c(s,{style:{margin:"auto"},src:"data:image/png;base64,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"})])),_:1}),c(t,{class:"h5tip-text"},{default:A((()=>[c(M,null,{default:A((()=>[d("点击右上角···，选择在默认浏览器中打开\\n即可查看")])),_:1})])),_:1})])),_:1}),c(G,{title:"应用功能介绍",description:"0.找对象必备神器,资料最全面的约会工具<br><br>1.购物返利,买了东西花了29元,返还20元.<br><br>2.199元薅笔记本电脑,机会人人都有<br><br>3.连续签到365天,领5000元现金红包<br><br>4.发传单得分红,发一张传单就能收入1元,一天随便薅几百!<br><br>5.大额外卖红包无限领,教你9.9元吃炸鸡"})],64)):p("",!0),o(y)?(n(),i(t,{key:1,style:{margin:"auto"}},{default:A((()=>[c(M,{class:"n-text-align-center n-size-ll n-weight-8 n-ms-bottom-base"},{default:A((()=>[d("本功能只能手机上使用")])),_:1}),c(M,{class:"n-text-align-center n-size-l n-weight-8 n-ms-bottom-base"},{default:A((()=>[d("请用手机浏览器(不要用微信)扫描下方二维码后重试")])),_:1}),c(g,{style:{margin:"auto"},start:!0,ref:"uqrcodes",canvasId:"qrcode",value:o(S),options:{margin:10}},null,8,["value"])])),_:1})):p("",!0)])),_:1})):p("",!0)}}},[["__scopeId","data-v-4e4a03be"]]);export{g as p};
