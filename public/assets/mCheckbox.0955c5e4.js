import{r as e,m as s,o as a,c as l,w as t,u as i,e as d,a as u,x as r,y as p,v as o,z as c,i as n,A as x}from"./index-93e08a2b.js";const f={__name:"mCheckbox",props:{modelValue:{type:Array,default:[]},isCheck:{type:Number,default:0},title:{type:String,default:""},image:{type:String,default:""},id:{type:Number,default:"",required:!0},isCheckList:{type:Boolean,default:!0}},emits:["update:modelValue"],setup(f,{emit:m}){const h=f,y=e(["/static/ui/checkbox_nol.png","/static/ui/checkbox_sel.png"]);let g=e(0);function k(){let e=h.modelValue;g.value?(g.value=0,e.splice(e.indexOf(h.id),1)):(e.push(h.id),g.value=1),m("update:modelValue",e)}return s((()=>h.isCheck),((e,s)=>{let a=h.modelValue;g.value=h.isCheck,h.isCheck?-1==a.indexOf(h.id)&&a.push(h.id):a.splice(a.indexOf(h.id),1),m("update:modelValue",a)}),{deep:!0}),s((()=>h.item),((e,s)=>{g.value=0})),(e,s)=>{const m=c,h=n,_=x;return a(),l(h,{class:"n-radius-base",style:{padding:"26rpx","box-shadow":"0 0 3px 2px #f1f0f0",margin:"26rpx","background-color":"white"},onClick:k},{default:t((()=>[f.isCheckList?(a(),l(m,{key:0,src:y.value[i(g)],mode:"",style:{width:"88rpx",height:"88rpx"}},null,8,["src"])):d("",!0),u(h,{class:"",style:{display:"flex","flex-flow":"row"}},{default:t((()=>[u(h,{class:"",style:{width:"256rpx",margin:"26rpx"}},{default:t((()=>[u(m,{src:f.image,mode:"",style:{width:"256rpx",height:"256rpx"}},null,8,["src"])])),_:1}),u(h,{class:"",style:{padding:"26rpx"}},{default:t((()=>[u(_,{style:{"font-size":"32rpx",width:"300rpx"},class:"n-lines-4"},{default:t((()=>[r(p(f.title),1)])),_:1}),o(e.$slots,"body")])),_:3})])),_:3})])),_:3})}}};export{f as _};