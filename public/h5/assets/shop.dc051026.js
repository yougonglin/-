import{r as e}from"./request.d55298d6.js";function t(t){return e.request({url:"/admin/mall/goods_save",method:"POST",data:t})}function a(t,a){return e.request({url:`/app/mall/goods_list?page=${t}&cate_id=${a}`,method:"GET"})}function r(t){return e.request({url:"/app/mall/goods_details?id="+t,method:"GET"})}function d(t){return e.request({url:"/admin/mall/goods_del",method:"POST",data:{ids:t}})}function u(t,a){return e.request({url:"/admin/mall/goods_deliver",method:"POST",data:{id:t,tracking_number:a}})}function n(t){return e.request({url:"/admin/mall/goods_deliver_list?page="+t,method:"GET"})}function l(t){return e.request({url:"/admin/mall/classification_creation",method:"POST",data:t})}function o(t){return e.request({url:"/admin/mall/get_category",method:"POST",data:{pid:t}})}function i(){return e.request({url:"/app/mall/get_category_all",method:"GET"})}function s(t){return e.request({url:"/admin/mall/goods_deliver_by_id",method:"POST",data:{id:t}})}function m(t,a){return e.request({url:"/admin/mall/goods_deliver_refund",method:"POST",data:{id:t,num:a}})}export{i as a,a as b,r as c,t as d,s as e,n as f,d as g,m as h,u as i,o as j,l as k};
