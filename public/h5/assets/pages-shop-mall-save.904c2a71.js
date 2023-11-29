import{r as a,Q as e,d as t,o as l,c as s,w as o,i,a as n,u as d,R as u,G as r,b as m,Y as c}from"./index-dd065053.js";import{_ as p}from"./uni-section.1e3d76cc.js";import{a as f,r as _}from"./uni-app.es.ce8d824d.js";import{_ as g}from"./n-cell.b6cef899.js";import{_ as b}from"./cl-upload.0a80f3fb.js";import{_ as h}from"./uni-easyinput.e534a72b.js";import{_ as y}from"./n-button.b3507bff.js";import{_ as v}from"./n-picker.dfe42975.js";import{c as V}from"./request.d55298d6.js";import{a as j,c as x,d as T}from"./shop.dc051026.js";import"./n-icon.66eb4db5.js";import"./uni-cloud.es.a358b7b6.js";import"./uni-icons.721cc791.js";import"./system.bd116065.js";const U={__name:"save",setup(U){let k=a([]),R=e({data:{}}),S=a(V.HTTP_REQUEST_URL+"/app/index/upload"),w=a(!1),C=a([]);const E={s1:{label:"name",value:"id"},s2:{label:"name",value:"id",tag:"category"}};let O=a([]),P=t((()=>{if(!R.data.cate_id)return"请选择分类";for(let a=0;a<C.value.length;a++)if(C.value[a].id==R.data.cate_id)return C.value[a].name}));function Q(a){k.value.push(V.HTTP_REQUEST_URL+"/storage/"+a.data[0])}function z(a){a.checkValue[1]?(R.data.cate_id=a.checkValue[1],w.value=!1):r({title:"没有选择子分类",icon:"error"})}function D(){Reflect.set(R.data,"image",JSON.stringify(k.value)),T(R.data).then((a=>{a.data.data?(r({title:"添加/更新成功"}),R.data={},k.value=[]):r({title:"添加/更新失败",icon:"error"})})).catch((a=>{r({title:"保存更新失败!",icon:"error"})}))}function H(){w.value=!0}return f((a=>{j().then((e=>{C.value=e.data.data;let t=[];for(let a=0;a<e.data.data.length;a++)0==e.data.data[a].pid&&t.push(e.data.data[a]);for(let a=0;a<t.length;a++){let l=[];for(let s=0;s<e.data.data.length;s++)e.data.data[s].pid==t[a].id&&l.push(e.data.data[s]);t[a]={...t[a],category:l}}O.value=t,a.id&&x(a.id).then((a=>{R.data=a.data.data,k.value=JSON.parse(a.data.data.image)}))}))})),(a,e)=>{const t=_(m("uni-section"),p),r=_(m("n-cell"),g),f=i,V=_(m("cl-upload"),b),j=_(m("uni-easyinput"),h),x=c,T=_(m("n-button"),y),U=_(m("n-picker"),v);return l(),s(f,{class:""},{default:o((()=>[n(t,{class:"mb-10",title:"商品分类","sub-title":"",type:"line"}),n(f,{class:"n-ms-ll uni-mt-5"},{default:o((()=>[n(r,{onCellClicked:H,title:d(P),bgType:"inverse",boxStyle:"padding-left:32rpx;",indicator:"arrow-right"},null,8,["title"])])),_:1}),n(t,{class:"mb-10",title:"图片轮播","sub-title":"",type:"line"}),n(V,{style:{margin:"26rpx"},imageFormData:{compress:!0},modelValue:d(k),"onUpdate:modelValue":e[0]||(e[0]=a=>u(k)?k.value=a:k=a),action:d(S),onOnSuccess:Q},null,8,["modelValue","action"]),n(t,{class:"mb-10",title:"商品标题","sub-title":"",type:"line"}),n(f,{class:"n-ms-ll uni-mt-5"},{default:o((()=>[n(j,{trim:"all",modelValue:d(R).data.goods_name,"onUpdate:modelValue":e[1]||(e[1]=a=>d(R).data.goods_name=a),placeholder:"请输入内容"},null,8,["modelValue"])])),_:1}),n(t,{class:"mb-10",title:"商品价格","sub-title":"",type:"line"}),n(f,{class:"n-ms-ll uni-mt-5"},{default:o((()=>[n(j,{trim:"all",modelValue:d(R).data.price,"onUpdate:modelValue":e[2]||(e[2]=a=>d(R).data.price=a),type:"number",placeholder:"请输入内容"},null,8,["modelValue"])])),_:1}),n(t,{class:"mb-10",title:"商品地址","sub-title":"",type:"line"}),n(f,{class:"n-ms-ll uni-mt-5"},{default:o((()=>[n(j,{trim:"all",modelValue:d(R).data.goods_url,"onUpdate:modelValue":e[3]||(e[3]=a=>d(R).data.goods_url=a),placeholder:"请输入抖音商品地址"},null,8,["modelValue"])])),_:1}),n(t,{class:"mb-10",title:"商品详情","sub-title":"",type:"line"}),n(f,{class:"n-ms-ll uni-mt-5 n-flex-row"},{default:o((()=>[n(x,{maxlength:"-1",modelValue:d(R).data.goods_details,"onUpdate:modelValue":e[4]||(e[4]=a=>d(R).data.goods_details=a),"auto-height":"",class:"n-flex-1",style:{border:"1px solid gainsboro","font-size":"16rpx",padding:"6rpx"}},null,8,["modelValue"])])),_:1}),n(f,{class:"n-ms-ll uni-mt-5 n-ps-top-ll"},{default:o((()=>[n(T,{onButtonClicked:D,bgType:"error",textType:"inverse",border:"none",text:"新增/更新商品"})])),_:1}),n(U,{title:"分类选择",show:d(w),selections:d(O),mode:"s2",labelProps:E,onCancel:e[5]||(e[5]=a=>u(w)?w.value=!1:w=!1),onConfirm:z},null,8,["show","selections"])])),_:1})}}};export{U as default};
