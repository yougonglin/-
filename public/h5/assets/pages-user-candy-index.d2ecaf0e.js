import{r as a,Q as t,o as e,c as i,w as n,i as s,a as o,g as u,h as l,u as r,F as p,G as d,b as c,U as m,n as f}from"./index-dd065053.js";import{_ as g}from"./uni-list-chat.419d2c33.js";import{a as h,r as j}from"./uni-app.es.ce8d824d.js";import{_}from"./uni-list.1c7d20cf.js";import{_ as b}from"./uni-pagination.5591698a.js";import{_ as v,a as x}from"./uni-popup.4b06af63.js";import{c as k,b as C}from"./user.1d8bbf71.js";import"./uni-cloud.es.a358b7b6.js";import"./uni-icons.721cc791.js";import"./request.d55298d6.js";const w={__name:"index",setup(w){let y=a([]),q=a(1),z=a(0),T=a(null),D=t({data:{}}),F=a(0);function G(a){q.value=a.current,I()}function I(){k(0,q.value).then((a=>{z.value=a.data.data.c,y.value=a.data.data.result}))}function L(a,t){D.data.status=a,D.data.mark=t||"提现成功,请在支付宝中查看",C(D.data).then((a=>{"操作成功"==a.data.data?(T.value.close(),y.value.splice(F.value,1)):d({title:"更新失败",icon:"error"})}))}return h((a=>{I()})),(a,t)=>{const d=j(c("uni-list-chat"),g),h=j(c("uni-list"),_),k=j(c("uni-pagination"),b),C=j(c("uni-popup-dialog"),v),w=j(c("uni-popup"),x),q=s;return e(),i(q,{class:""},{default:n((()=>[o(h,{border:!0},{default:n((()=>[(e(!0),u(p,null,l(r(y),((a,t)=>(e(),i(d,{clickable:!0,onClick:t=>function(a,t){m({itemList:["查看用户信息","提现审核"],success:t=>{t.tapIndex?(D.data.id=a.id,D.data.uid=a.uid,D.data.num=a.jinbi_num,D.data.price=a.price,F.value=t,T.value.open()):f({url:"/pages/user/info/index?phone="+a.phone})}})}(a),key:a.id,title:a.name,avatar:"https://web-assets.dcloud.net.cn/unidoc/zh/unicloudlogo.png",note:a.phone,time:"金币:"+a.jinbi_num,"badge-text":"提现金额:"+a.price},null,8,["onClick","title","note","time","badge-text"])))),128))])),_:1}),o(k,{onChange:G,class:"n-ms-top-ll n-ms-bottom-ll",total:r(z),pageSize:"30"},null,8,["total"]),o(w,{ref_key:"inputDialog",ref:T,type:"dialog","is-mask-click":!0},{default:n((()=>[o(C,{confirmText:"拒绝提现",cancelText:"同意提现",mode:"input",title:"提现审核",placeholder:"请输入备注内容",onClose:t[0]||(t[0]=a=>L(1)),onConfirm:t[1]||(t[1]=a=>L(-1,a))})])),_:1},512)])),_:1})}}};export{w as default};