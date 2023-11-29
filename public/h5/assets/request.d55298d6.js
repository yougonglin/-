import{ah as e,a7 as t,ar as s,a6 as r,G as n}from"./index-dd065053.js";function a(e,t){t.forEach((t=>{t&&t(e)}))}function o(e,t,s,r,n,o,i){return s.success=s=>{let c=s;n&&(c=n(s,r)),c&&c.nReqToReject?(delete c.nReqToReject,a(c,i),t&&t(c)):(a(c,o),e&&e(c))},s.fail=e=>{let s=e;n&&(s=n({nFail:!0,response:e},r)),delete s.nReqToReject,a(s,i),t&&t(s)},s}function i(r){return"request"===r?e:"upload"===r?t:s}const c={HTTP_REQUEST_URL:"https://shop.supernova98.com",OSS_URL:"https://oss.supernova98.com/app/index/get_file?path="};let l=r("admin-supernova-token");const p={baseUrl:c.HTTP_REQUEST_URL,header:{"content-type":"application/x-www-form-urlencoded","admin-supernova-token":l}},h=new class{constructor(e={},t,s,r,n,a){this.baseUrl=e.baseUrl,e.header?this.header=Object.assign({},e.header):this.header={"content-type":"application/json;charset=UTF-8"},this.success=r||null,this.fail=n||null,this.complete=a||null,this.requestInterceptor=t||null,this.responseInterceptor=s||null,this.waitList=[]}async request(e,t,s,r){const n=e.task||!1,c=e.type||"request";let l=null;try{l=await async function(e,t){const s=Object.assign({},t.header||e.header);let r={url:(t.baseUrl||e.baseUrl)+t.url,header:s},n=null;if(e.requestInterceptor){try{const s=JSON.parse(JSON.stringify(Object.assign({},t||{},r)));n=await e.requestInterceptor(s)}catch(o){return{nReqToCancel:!0,error:o}}if(n.nReqToCancel||n.nReqToWait)return n;r.url=n.url,r.header=n.header}const a=t.type||"request";return"request"===a?(r.data=n.data||{},r.method=n.method||"GET",r.dataType=n.dataType||"json",r.responseType=n.responseType||"text"):"upload"===a&&(r.filePath=n.filePath,r.name=n.name,r.method=n.method||"POST",r.formData=n.formData||{},r.fileType=n.fileType||"image",delete r.header["Content-Type"],delete r.header["content-type"]),r}(this,e)}catch(p){const t=this.responseInterceptor&&this.responseInterceptor({nError:!0,response:p},e)||{nError:!0,response:p};return a(t,[this.fail,s,this.complete,r]),Promise.reject(t)}if(l.nReqToWait)return new Promise(((n,a)=>{this.waitList.push((()=>{this.request(e,t,s,r).then((e=>{n(e)})).catch((e=>{a(e)}))}))}));if(l.nReqToCancel){const t=this.responseInterceptor&&this.responseInterceptor({nCancel:!0,response:l},e)||{nCancel:!0,response:l};return a(t,[this.fail,s,this.complete,r]),Promise.reject(t)}if(n){const n=o(null,null,l,e,this.responseInterceptor,[this.success,t,this.complete,r],[this.fail,s,this.complete,r]);return i(c)(n)}return new Promise(((n,a)=>{const p=o(n,a,l,e,this.responseInterceptor,[this.success,t,this.complete,r],[this.fail,s,this.complete,r]);i(c)(p)}))}clearWaitList(){this.waitList=[]}}(p,(async e=>e),((e,t={})=>(200!=e.statusCode&&n({title:"错误!",icon:"error"}),e.nFail||e.nCancel?e.response:e)));export{c,h as r};