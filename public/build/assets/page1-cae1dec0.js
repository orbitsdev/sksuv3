import{i,j as p,o as t,a,k as d,l as f,u as m,b as u,A as _,F as h,m as x,t as c,O as g}from"./app-544d6b58.js";const b={class:"px-6 lg:px-8"},O={},v=Object.assign(O,{__name:"page1",props:{users:Object,filters:Object},setup(n){const r=n;let e=i(r.filters.search);return p(e,l=>{g.get(route("users"),{search:l},{preserveScroll:!0,replace:!0})}),(l,o)=>(t(),a("div",b,[d(u("input",{type:"text","onUpdate:modelValue":o[0]||(o[0]=s=>_(e)?e.value=s:e=s),placeholder:"seearch",class:"mt-20 h-12 border w-full px-4"},null,512),[[f,m(e)]]),u("ul",null,[(t(!0),a(h,null,x(r.users.data,s=>(t(),a("li",null,c(s.first_name)+" "+c(s.email),1))),256))])]))}});export{v as default};
