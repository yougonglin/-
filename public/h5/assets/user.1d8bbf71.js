import{r as e}from"./request.d55298d6.js";function t(){return e.request({url:"/admin/grade/grade_list",method:"GET"})}function a(t){return e.request({url:"/admin/grade/grade_save",method:"POST",data:t})}function r(t,a){return e.request({url:"/admin/candy/list",method:"POST",data:{status:t,page:a}})}function n(t){return e.request({url:"/admin/candy/update",method:"POST",data:t})}function u(t,a,r,n){return e.request({url:"/admin/info/integral_log",method:"POST",data:{uid:t,page:a,integralType:r,type:n}})}function d(t){return e.request({url:"/admin/info/userinfo",method:"POST",data:{phone:t}})}export{a,n as b,r as c,t as g,u as i,d as u};