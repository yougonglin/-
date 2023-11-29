import{o as e,c as o,w as r,v as l,q as t,t as s,i as n,al as a,r as i,l as d,m as h,b as g,u,e as c,F as f,N as p,a as x,j as T}from"./index-93e08a2b.js";import{u as S,a as b,b as y,_ as m,c as w}from"./usePager.62d200ee.js";import{r as C}from"./uni-app.es.4a85af97.js";import{b as R}from"./system.0fbb2200.js";import{m as M}from"./props.e7779fd1.js";const v={__name:"n-list-cell",props:{renderReverse:{type:Boolean,default:!1},keepScrollPosition:{type:Boolean,default:!1},flex:{type:String,default:""},justify:{type:String,default:""},align:{type:String,default:""},bgType:{type:String,default:""},border:{type:String,default:""},radius:{type:String,default:""},boxStyle:{type:String,default:""},boxClass:{type:String,default:""},hover:{type:String,default:""}},emits:["cellClicked"],setup(a,{emit:i}){function d(e){i("cellClicked",e)}return(i,h)=>{const g=n;return e(),o(g,{class:t(["n-bg-"+a.bgType,"n-flex-"+a.flex,"n-justify-"+a.justify,"n-align-"+a.align,"n-border-"+a.border,"n-radius-"+a.radius,a.boxClass]),"hover-class":"n-hover-"+a.hover,style:s(a.boxStyle),onClick:d},{default:r((()=>[l(i.$slots,"default")])),_:3},8,["class","hover-class","style"])}}},k={__name:"n-list",props:M([["scrollable",!0],["enableBackToTop",!1],["useLoading",!1],["loadMoreOffset",60],["pagingEnabled",!1],["bounce",!0],["renderReverse",!1],["autoUpdate",!1],["down",{use:!0,offset:a(140),inRate:.8,outRate:.2}],["up",{use:!0,offset:80}],["hasScroll",!0],["showScrollbar",!0],["bgType","page"],["position","static"],["top","0"],["bottom","0"],"boxStyle",["height","window-!status-!nav"],"reverse",["loadMainText","继续加载更多"],["loadingText","正在加载"],["noMoreText","没有更多啦"],["showNoMore",!0],["loadingSrc","/static/ui/loading-small.gif"],"loadingStyle","loadingImgStyle","loadingTextStyle",["refreshMainText","下拉即可刷新..."],["pullingText","释放即可刷新..."],["refreshingText","正在努力加载..."],"refreshStyle","refreshTextStyle","boxClass","loadingClass","loadingImgClass","loadingTextClass","refreshClass","refreshTextClass",["upperThreshold",50],["lowerThreshold",50],["scrollWithAnimation",!0],["refresherEnabled",!1],["refresherThreshold",45],["refresherDefaultStyle","black"],["refresherBackground","#FFFFFF"],["refresherTriggered",!1],["enableFlex",!1],["scrollAnchoring",!1],["isParent",!1],["isChild",!1],["headerHeight",0],["listId",""],["parentId",""]]),emits:["inited","scroll","down","up","upper","lower","pulling","refresh","restore","abort","toggle","move"],setup(M,{expose:v,emit:k}){const L=M,j=i(null),E=i(null),_=i(null),{nCurrentView:F,nScrollTop:N,nScrollTo:B,nScrollToTop:I,nScrollToBottom:U}=S(),{pagerState:A,nInitContentList:O,nScroll:$,nLoad:H,nReload:D,nRefresh:P,nEndSuccess:W,nEndError:Y,nTouchstartEvent:q,nTouchmoveEvent:V,nTouchendEvent:z}=b(L,k,j,E,_,F,N),{onScrollToUpper:G,onScrollToLower:J,onRefresherPulling:K,onRefresherRefresh:Q,onRefresherRestore:X,onRefresherAbort:Z}=y(k);v({nLoad:H,nReload:D,nRefresh:P,nEndSuccess:W,nEndError:Y,nScrollTo:B,nScrollToTop:I,nScrollToBottom:U});const ee=d((()=>{let e="";return"-1"!=L.height&&(e+="height:"+R(L.height)+"px;"),"-1"!=L.top&&(e+="top:"+R(L.top)+"px;"),"-1"!=L.bottom&&(e+="bottom:"+R(L.bottom)+"px;"),e+L.boxStyle})),oe=d((()=>{let e="";return e+=A.isDownReset?"transition-property: transform; transition-duration: 300ms;":"",e+=A.downHeight>0?`transform: translateY(${A.downHeight}px);`:"transform: translateY(0px);",e})),re=d((()=>A.downHeight>=(A.down.offset||80))),le=d((()=>A.downHeight/(A.down.offset||80)));return A.down=Object.assign({use:!0,offset:a(140),inRate:.8,outRate:.2},L.down||{use:!1}),A.up=Object.assign({use:!0,offset:80},L.up||{use:!1}),A.scrollable=L.scrollable,setTimeout((()=>{k("inited")}),0),L.autoUpdate&&setTimeout((()=>{O()}),10),h((()=>L.down),(e=>{A.down=Object.assign({use:!0,offset:a(140),inRate:.8,outRate:.2},e||{use:!1})})),h((()=>L.up),(e=>{A.up=Object.assign({use:!0,offset:80},e||{use:!1})})),h((()=>L.scrollable),(e=>{A.scrollable=e})),h((()=>A.scrollable),(e=>{k("toggle",e)})),(a,i)=>{const d=C(T("n-refresher"),m),h=n,S=C(T("n-loader"),w),b=p;return e(),g(f,null,[a.hasScroll?(e(),o(b,{key:0,class:t(["n-bg-"+a.bgType,a.boxClass]),style:s(a.reverse+u(ee)),"upper-threshold":a.upperThreshold,"lower-threshold":a.lowerThreshold,"scroll-into-view":u(F),"scroll-top":u(N),"scroll-with-animation":a.scrollWithAnimation,"scroll-y":u(A).scrollable,"show-scrollbar":a.showScrollbar,"enable-back-to-top":a.enableBackToTop,"refresher-enabled":a.refresherEnabled,"refresher-threshold":a.refresherThreshold,"refresher-default-style":a.refresherDefaultStyle,"refresher-background":a.refresherBackground,"refresher-triggered":a.refresherTriggered,"enable-flex":a.enableFlex,"scroll-anchoring":a.scrollAnchoring,onScroll:u($),onScrolltoupper:u(G),onScrolltolower:u(J),onRefresherpulling:u(K),onRefresherrefresh:u(Q),onRefresherrestore:u(X),onRefresherabort:u(Z)},{default:r((()=>[x(h,{style:s(u(oe)),class:"n-position-relative",onTouchstart:u(q),onTouchmove:u(V),onTouchend:u(z),onTouchcancel:u(z)},{default:r((()=>[u(A).down.use?(e(),o(h,{key:0,class:"n-position-absolute n-left-0 n-translate-y100_"},{default:r((()=>[x(d,{refreshing:u(A).isDownLoading,couldUnLash:u(re),rate:u(le),mainText:a.refreshMainText,pullingText:a.pullingText,refreshingText:a.refreshingText,boxStyle:a.reverse+a.refreshStyle,textStyle:a.refreshTextStyle,boxClass:a.refreshClass,textClass:a.refreshTextClass},null,8,["refreshing","couldUnLash","rate","mainText","pullingText","refreshingText","boxStyle","textStyle","boxClass","textClass"])])),_:1})):c("",!0),x(h,{id:"nlisttop"}),l(a.$slots,"default"),l(a.$slots,"token"),x(h,{id:"nlistbottom"}),u(A).up.use?(e(),o(S,{key:1,isLoading:u(A).isUpLoading,hasMore:u(A).hasMore,showNoMore:a.showNoMore,mainText:a.loadMainText,loadingText:a.loadingText,noMoreText:a.noMoreText,loadingSrc:a.loadingSrc,boxStyle:a.reverse+a.loadingStyle,imgStyle:a.loadingImgStyle,textStyle:a.loadingTextStyle,boxClass:a.loadingClass,imgClass:a.loadingImgClass,textClass:a.loadingTextClass},null,8,["isLoading","hasMore","showNoMore","mainText","loadingText","noMoreText","loadingSrc","boxStyle","imgStyle","textStyle","boxClass","imgClass","textClass"])):c("",!0)])),_:3},8,["style","onTouchstart","onTouchmove","onTouchend","onTouchcancel"])])),_:3},8,["class","style","upper-threshold","lower-threshold","scroll-into-view","scroll-top","scroll-with-animation","scroll-y","show-scrollbar","enable-back-to-top","refresher-enabled","refresher-threshold","refresher-default-style","refresher-background","refresher-triggered","enable-flex","scroll-anchoring","onScroll","onScrolltoupper","onScrolltolower","onRefresherpulling","onRefresherrefresh","onRefresherrestore","onRefresherabort"])):c("",!0),a.hasScroll?c("",!0):(e(),o(h,{key:1},{default:r((()=>[x(h,{id:"nlisttop"}),l(a.$slots,"default"),l(a.$slots,"token"),x(h,{id:"nlistbottom"}),u(A).up.use?(e(),o(S,{key:0,isLoading:u(A).isUpLoading,hasMore:u(A).hasMore,showNoMore:a.showNoMore,mainText:a.loadMainText,loadingText:a.loadingText,noMoreText:a.noMoreText,loadingSrc:a.loadingSrc,boxStyle:a.reverse+a.loadingStyle,imgStyle:a.loadingImgStyle,textStyle:a.loadingTextStyle},null,8,["isLoading","hasMore","showNoMore","mainText","loadingText","noMoreText","loadingSrc","boxStyle","imgStyle","textStyle"])):c("",!0)])),_:3}))],64)}}};export{v as _,k as a};
