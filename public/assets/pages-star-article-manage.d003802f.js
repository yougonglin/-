import{r as e,l as a,o as t,c as s,w as l,i,a as n,b as o,d as u,u as r,F as c,g as p,E as d,j as m,W as _,h as g,Q as v}from"./index-93e08a2b.js";import{_ as f,a as h}from"./n-list.b9d584d3.js";import{a as j,r as b}from"./uni-app.es.4a85af97.js";import{a as k}from"./albumCommentCell.1861fcfc.js";import"./usePager.62d200ee.js";import"./_plugin-vue_export-helper.1b428a4d.js";import"./system.0fbb2200.js";import"./props.e7779fd1.js";import"./n-icon.3d1c4127.js";import"./z-image.699da878.js";/* empty css                                                                */const y={__name:"manage",setup(y){let E=e(!1),x=e("");const C=a((()=>e=>e.length?e[0]:"/static/ui/bg.jpeg")),D=a((()=>(e,a,t)=>{let s=[];return e.price&&s.push({title:"含付费内容",action:1}),""!=a&&s.push({title:"含音频",action:1}),""!=t&&s.push({title:"含视频",action:1}),s}));let w=e([]);let z=e(0),B=e(null);function I(){p().globalData.userBaseInfo?(z.value++,v(1,z.value,p().globalData.userBaseInfo.uid,E.value,x.value).then((e=>{e.data.data.length?(z.value>1?w.value=w.value.concat(e.data.data):w.value=e.data.data,B.value.nEndSuccess(!0)):B.value.nEndSuccess(!1)})).catch((e=>{console.log(e),B.value.nEndError()}))):d({url:"/pages/user/login/phoneCodeLogin"})}return j((e=>{E.value=1==e.self,x.value=["article_file","","favorite_posts"][e.self]})),(e,a)=>{const p=i,v=b(m("n-list-cell"),f),j=b(m("n-list"),h);return t(),s(p,{class:""},{default:l((()=>[n(j,{ref_key:"nlist",ref:B,autoUpdate:!0,onDown:I,onUp:I},{default:l((()=>[(t(!0),o(c,null,u(r(w),((e,a)=>(t(),s(v,{key:e.id},{default:l((()=>[n(k,{"is-self":r(E),onRight_btn_click:e=>function(e){let a=E?w.value[e].id:w.value[e].uid;E.value?_({id:a}).then((a=>{w.value.splice(e,1)})):g({title:"无法关注匿名用户",icon:"none"})}(a),onContent_click:a=>{return t=e.id,void d({url:"/pages/star/article/details?id="+t});var t},cover:"",username:"匿名用户",createTime:e.create_time,img:r(C)(e.imgs),title:e.content,tags:r(D)(e.file_info,e.audio,e.video)},null,8,["is-self","onRight_btn_click","onContent_click","createTime","img","title","tags"]),n(p,{style:{height:"16rpx"}})])),_:2},1024)))),128))])),_:1},512)])),_:1})}}};export{y as default};
