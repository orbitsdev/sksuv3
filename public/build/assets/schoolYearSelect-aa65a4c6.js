import{i as c,p as d,q as i,o as s,a as o,F as p,m,t as r}from"./app-544d6b58.js";const _=["value"],f={key:1,class:"p-2 rounded bg-rose-600 animate-pulse text-white"},g={},y=Object.assign(g,{__name:"schoolYearSelect",emits:["selectItem","setDefaultValue"],setup(h,{emit:l}){const a=c([]);d(async()=>{const{data:t}=await i.get(route("public.schoolyear"));t.data.length>0&&(a.value=t.data,l("setDefaultValue",a.value[0].id))});function u(t){l("selectItem",parseInt(t.target.value))}return(t,n)=>a.value.length>0?(s(),o("select",{key:0,onChange:n[0]||(n[0]=e=>u(e)),autocomplete:"country-name",class:"block w-full max-w-lg h-10 px-2 rounded-md border shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"},[(s(!0),o(p,null,m(a.value,e=>(s(),o("option",{key:e.id,value:e.id},"SY "+r(e.from)+" - "+r(e.to),9,_))),128))],32)):(s(),o("div",f," Empty"))}});export{y as _};
