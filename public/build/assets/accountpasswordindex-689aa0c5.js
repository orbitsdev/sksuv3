import{i as m,j as U,O as z,v as A,o as r,a as f,d as a,w as t,b as e,k as D,l as P,F as B,m as F,e as d,t as c,u as w,c as k,f as _,r as n}from"./app-7d944f90.js";import{l as G}from"./lodash-0f52f8ae.js";import C from"./accounts-94af5708.js";import"./adminlayout-3fad6a20.js";const H={class:"mx-auto w-full max-w-xs lg:max-w-md"},L=e("label",{for:"search",class:"sr-only"},"Search",-1),W={class:"relative text-white focus-within:text-gray-600"},Y=e("div",{class:"pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"},[e("svg",{class:"h-5 w-5",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[e("path",{"fill-rule":"evenodd",d:"M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z","clip-rule":"evenodd"})])],-1),q=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2"},[e("path",{d:"M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z"}),e("path",{d:"M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"})],-1),I=e("span",{class:""}," Update ",-1),J={key:0,class:"mt-6 py-4 bg-white"},K={class:"p-2"},Q=e("aside",{class:"rounded-lg flex item-center"},[e("div",{class:"rounded-l flex items-center justify-center w-36 bg-gradient-to-r from-blue-500 to-blue-600"},[e("i",{class:"fa-solid fa-triangle-exclamation text-4xl text-white"})]),e("div",{class:"rounded-r bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-4"},[e("p",{class:"font-rubik text leading-5 text-white"}," We recommend to change password only if user are unable to access account or have forgotten password. ")])],-1),R={class:"mb-4 mt-4 bg-green-700 text-white px-4 py-2 rounded flex items-center"},X={class:"text-sm leading-6"},Z=e("p",{class:"text-sm"}," Selected Account ",-1),ee={class:"font-semibold uppercase"},se=e("label",{for:"password",class:"block text-sm font-medium text-gray-700"},"Password",-1),te={class:"mt-1"},oe={key:0,class:"text-red-700 text-sm"},ae={class:"sm:flex sm:items-start"},le={class:"mt-5 w-full flex justify-end sm:flex-row-reverse"},re={class:"p-2"},ne=e("div",null,[e("div",{class:"mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100"},[e("svg",{class:"h-6 w-6 text-green-600",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor","aria-hidden":"true"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M4.5 12.75l6 6 9-13.5"})])]),e("div",{class:"mt-3 text-center sm:mt-5"},[e("h3",{class:"text-lg font-medium leading-6 text-gray-900",id:"modal-title"},"Are you sure?"),e("div",{class:"mt-2"},[e("p",{class:"text-sm text-gray-500"},"Do you wan to update user password")])])],-1),ie={class:"mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"},de={components:{accounts:C}},_e=Object.assign(de,{__name:"accountpasswordindex",props:{users:Object,filters:Object},setup(V){const b=V,v=m(!0);m(!1);const i=m(null),u=m(!1),y=m(null),g=m(b.filters.search);U(g,G.throttle(s=>{z.get(route("account.userpassword.index"),{search:s},{preserveState:!0,replace:!0})},500));let p=A({password:"",id:i.value});function j(s){i.value=s,v.value=!0}function O(){p.transform(s=>({password:p.password,id:i.value.id})).post(route("account.userpassword.update"),{preserveState:!0,onSuccess:()=>{u.value=!1,v.value=!1,p.reset()},onError:s=>{y.value=s,console.log("on error"),u.value=!1},hasError:s=>{console.log("has warnung error"),u.value=!1,y.value=s}})}return(s,l)=>{const h=n("Tcell"),x=n("SkButtonGray"),$=n("SkTable"),M=n("Pagination"),N=n("Authfield"),E=n("SkButton"),S=n("sk-dialog"),T=n("SkDeleteButton");return r(),f(B,null,[a(C,null,{search:t(()=>[e("div",H,[L,e("div",W,[Y,D(e("input",{"onUpdate:modelValue":l[0]||(l[0]=o=>g.value=o),class:"block w-full rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm",placeholder:"Name, Email",type:"search",name:"search"},null,512),[[P,g.value,void 0,{number:!0}]])])])]),default:t(()=>[a($,{headers:["Name","Email","Password",""]},{default:t(()=>[(r(!0),f(B,null,F(w(b).users.data,o=>(r(),f("tr",{class:"divide-x divide-gray-200",key:o},[a(h,{class:"uppercase"},{default:t(()=>[d(c(o.first_name)+" - "+c(o.last_name),1)]),_:2},1024),a(h,null,{default:t(()=>[d(c(o.email),1)]),_:2},1024),a(h,null,{default:t(()=>[d(c(o.password),1)]),_:2},1024),a(h,{class:"flex items-center justify-center"},{default:t(()=>[a(x,{class:"max-w-40",onClick:ce=>j(o)},{default:t(()=>[q,I]),_:2},1032,["onClick"])]),_:2},1024)]))),128))]),_:1}),s.$props.users.links.length>0?(r(),f("div",J,[s.$props.users.data.length>0?(r(),k(M,{key:0,class:"block",links:s.$props.users.links},null,8,["links"])):_("",!0)])):_("",!0)]),_:1}),i.value!=null?(r(),k(S,{key:0,transition:"slide-down",persistent:!0,isOpen:v.value},{default:t(()=>[e("main",K,[Q,e("figcaption",R,[e("div",X,[Z,e("div",ee,c(i.value.first_name)+" - "+c(i.value.last_name),1)])]),e("div",null,[se,e("div",te,[a(N,{modelValue:w(p).password,"onUpdate:modelValue":l[1]||(l[1]=o=>w(p).password=o)},null,8,["modelValue"])]),s.$page.props.errors.password?(r(),f("p",oe,c(s.$page.props.errors.password),1)):_("",!0)]),e("div",ae,[e("div",le,[a(E,{onClick:l[2]||(l[2]=o=>u.value=!0),processing:!1,class:"w-24"},{default:t(()=>[d(" Update ")]),_:1}),a(x,{onClick:l[3]||(l[3]=o=>v.value=!1),c:"w-24 mr-2"},{default:t(()=>[d(" Cancel ")]),_:1})])])])]),_:1},8,["isOpen"])):_("",!0),i.value!=null?(r(),k(S,{key:1,transition:"slide-down",persistent:!0,isOpen:u.value},{default:t(()=>[e("main",re,[ne,e("div",ie,[a(T,{onClick:O,processing:w(p).processing,class:"w-24"},{default:t(()=>[d(" Yes ")]),_:1},8,["processing"]),a(x,{onClick:l[4]||(l[4]=o=>u.value=!1),c:"w-24"},{default:t(()=>[d(" No ")]),_:1})])])]),_:1},8,["isOpen"])):_("",!0)],64)}}});export{_e as default};