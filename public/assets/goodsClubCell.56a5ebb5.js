import{l as e,o as t,c as s,w as a,q as l,t as r,u as i,i as n,b as o,d as p,F as c,v as u,L as g,z as d,j as m,a as f,x,y as h,A as y}from"./index-93e08a2b.js";import{m as v}from"./props.e7779fd1.js";import{r as b}from"./uni-app.es.4a85af97.js";import{z as w}from"./z-image.699da878.js";import{_}from"./_plugin-vue_export-helper.1b428a4d.js";const z={__name:"n-avatars",props:v([["items",[]],"label",["reverse",!1],["size","66rpx"],["space","-16rpx"],"itemStyle","itemClass","boxStyle","boxClass"]),emits:["itemClicked"],setup(m,{emit:f}){const x=m,h=e((()=>x.reverse&&parseInt(x.space)<0)),y=e((()=>h.value?x.items.slice().reverse():x.items)),v=e((()=>parseFloat(x.size))),b=e((()=>parseFloat(x.space))),w=e((()=>x.space.indexOf("rpx")>=0||x.space.indexOf("upx")>=0?"rpx":"px")),_=e((()=>h.value?`width:${(v.value+b.value)*x.items.length-b.value}${w.value};height:${x.size};`:""));function z(e){let t=`width:${x.size};height:${x.size};border-radius:${x.size};`;return h.value?t+=`position:absolute;right:${e*(v.value+b.value)}${w.value};`:t+=e>0?`margin-left:${x.space};`:"margin-left:0;",t}return(e,m)=>{const x=d,h=n;return t(),s(h,{class:l(["n-flex-row","n-align-center","n-position-relative",e.boxClass]),style:r(i(_)+e.boxStyle),bubble:"true"},{default:a((()=>[(t(!0),o(c,null,p(i(y),((a,i)=>(t(),s(x,{key:i,src:e.label?a[e.label]:a,style:r(z(i)+e.itemStyle),class:l([e.itemClass]),mode:"aspectFill",onClick:g((e=>{return s=a,(t=e)&&(t.item=s),f("itemClicked",t),void(t&&t.stopPropagation&&t.stopPropagation());var t,s}),["stop"])},null,8,["src","style","class","onClick"])))),128)),u(e.$slots,"default")])),_:3},8,["class","style"])}}},S=_({__name:"goodsClubCell",props:{cache:{type:Boolean,default:!1},cover:{type:String,default:""},label:{type:String,default:""},name:{type:String,default:""},topic:{type:String,default:""},tags:{type:String,default:""},sale:{type:String,default:0},price:{type:String,default:0},height:{type:Number,default:0},width:{type:Number,default:0},members:{type:Array,default:[{avatar:"/static/ui/hot.png"},{avatar:"/static/ui/hot.png"},{avatar:"/static/ui/hot.png"}]}},setup(r){const u=r;e((()=>{const e=350*u.height/u.width;return e>400?400:e<100?100:e}));const g=e((()=>u.tags?u.tags.split(","):[]));return(e,u)=>{const v=d,_=y,S=n,C=b(m("n-avatars"),z);return t(),s(S,{class:"n-position-relative",style:{"padding-bottom":"30rpx"},bubble:"true"},{default:a((()=>[r.cache?(t(),s(w,{key:0,src:r.cover,class:"gc-cover",style:{height:"400rpx",width:"336rpx"},mode:"aspectFill"},null,8,["src"])):(t(),s(v,{key:1,src:r.cover,class:"gc-cover",style:{width:"336rpx",height:"400rpx"},mode:"aspectFill"},null,8,["src"])),f(_,{class:"n-color-text n-lh-s n-lines-2",style:{"margin-top":"10rpx","margin-left":"12rpx",width:"336rpx","min-height":"80rpx","font-size":"28rpx"}},{default:a((()=>[x(h(r.name),1)])),_:1}),f(_,{class:"n-color-third n-size-ss n-lh-ss",style:{"margin-left":"12rpx"}},{default:a((()=>[x(h(r.topic),1)])),_:1}),f(S,{class:"n-flex-row n-wrap-nowrap n-justify-between n-align-center",style:{"margin-left":"12rpx","margin-top":"10rpx"}},{default:a((()=>[f(S,{class:"n-flex-row n-wrap-nowrap n-align-center"},{default:a((()=>[(t(!0),o(c,null,p(i(g),((e,r)=>(t(),s(S,{key:r,class:l(["gc-tag","n-flex-row","n-align-center",r%2==1?"gc-tag-yellow":"gc-tag-red"])},{default:a((()=>[f(_,{class:l(["n-color-"+(r%2==1?"warning":"error"),"n-size-ss"])},{default:a((()=>[x(h(e),1)])),_:2},1032,["class"])])),_:2},1032,["class"])))),128))])),_:1}),f(C,{items:r.members,label:"avatar",reverse:!0,size:"32rpx",space:"-12rpx",boxStyle:"margin-right:24rpx;"},null,8,["items"])])),_:1}),f(S,{class:"n-flex-row n-align-center n-wrap-nowrap n-justify-between",style:{"margin-left":"12rpx","margin-top":"24rpx"}},{default:a((()=>[f(S,{class:"n-flex-row n-align-center n-wrap-nowrap"},{default:a((()=>[f(_,{class:"n-color-error n-size-base n-weight-9",style:{"line-height":"38rpx"}},{default:a((()=>[x("¥"+h(r.sale),1)])),_:1}),f(_,{class:"n-color-third n-size-ss",style:{"margin-left":"12rpx","text-decoration":"line-through","margin-top":"10rpx","line-height":"28rpx"}},{default:a((()=>[x(h(r.price),1)])),_:1})])),_:1}),f(_,{class:"n-size-ll n-color-third n-weight-7",style:{"line-height":"32rpx"}},{default:a((()=>[x("...")])),_:1})])),_:1})])),_:1})}}},[["__scopeId","data-v-9bf1b106"]]);export{S as g};
