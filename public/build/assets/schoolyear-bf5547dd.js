import{i as u,j as U,O as B,v as G,o as r,a as v,d as s,w as a,b as e,k as V,l as P,c as _,e as i,f as w,F as j,m as q,z as I,t as z,u as h,r as n}from"./app-45d61a46.js";import{l as J}from"./lodash-469ed60a.js";import{a as D}from"./adminlayout-96c64984.js";const K=e("title",null,"My app",-1),Q=e("meta",{"head-key":"description",name:"description",content:"This is the default description"},null,-1),R=e("link",{rel:"icon",type:"image/svg+xml",href:"/favicon.svg"},null,-1),W={class:"mx-auto w-full max-w-xs lg:max-w-md"},X=e("label",{for:"search",class:"sr-only"},"Search",-1),Z={class:"relative text-white focus-within:text-gray-600"},ee=e("div",{class:"pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"},[e("svg",{class:"h-5 w-5",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[e("path",{"fill-rule":"evenodd",d:"M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z","clip-rule":"evenodd"})])],-1),te={class:"bg-white rounded-xl shadow-xl mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8"},se={class:"rounded pb-6"},oe={class:"pt-4 flex items-center justify-between"},le=e("p",{class:"text-xl text-green-800 font-bold font-rubik uppercase"}," Manage School Year ",-1),ae={class:"flex items-center"},ne=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2 text-rose-700"},[e("path",{"fill-rule":"evenodd",d:"M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z","clip-rule":"evenodd"})],-1),re=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2"},[e("path",{"fill-rule":"evenodd",d:"M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z","clip-rule":"evenodd"})],-1),ie=["value"],ce={key:2,class:"mt-6 bg-white"},de={class:""},ue={class:"grid grid-cols-2 gap-x-2"},me={class:"col-span-1"},pe=e("p",{class:"block text-sm font-medium mb-1"},"From",-1),fe={class:"col-span-1"},he=e("p",{class:"block text-sm font-medium mb-1"},"To",-1),ve=e("div",{class:"rounded mt-4 h-40 bg-gradient-to-r"},null,-1),_e={class:"mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3"},ge={class:"p-2"},xe=e("div",{class:"sm:flex sm:items-start"},[e("div",{class:"mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"},[e("svg",{class:"h-6 w-6 text-red-600",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor","aria-hidden":"true"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"})])]),e("div",{class:"mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"},[e("h3",{class:"text-lg font-medium leading-6 text-gray-900",id:"modal-title"}," Delete school years "),e("div",{class:"mt-2"},[e("p",{class:"text-sm text-gray-500"}," Are you sure you want to delete school year ? All of your data will be permanently removed from our servers forever. This action cannot be undone. ")])])],-1),ye={class:"mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"},we={components:{adminlayout:D}},Ye=Object.assign(we,{__name:"schoolyear",props:{years:Object,filters:Object},setup(M){const g=M,m=u(!1),k=u(null),c=u(!1),x=u(!1),y=u(g.filters.search),p=u([]);U(y,J.throttle(o=>{B.get(route("schoolyear.index"),{search:o},{preserveState:!0,replace:!0})},500));let d=G({fromYear:new Date,toYear:new Date});async function O(){try{x.value=!0,await B.post(route("schoolyear.delete-selected"),{ids:p.value}),x.value=!1,p.value=[],m.value=!1,c.value=!1}catch(o){k.value=o.message}}function T(){d.transform(o=>({fromYear:o.fromYear.getFullYear(),toYear:o.toYear.getFullYear()})).post(route("schoolyear.create"),{preserveState:!0,onSuccess:()=>{m.value=!1},onError:o=>{k.value=o,console.log("on error"),c.value=!1},hasError:o=>{console.log("has  error"),c.value=!1,console.log(o)}})}return(o,t)=>{const F=n("Head"),b=n("sk-button2"),f=n("Tcell"),$=n("SkTable"),E=n("EmptyCard"),A=n("Pagination"),S=n("Datepicker"),Y=n("SkButtonGray"),H=n("SkButton"),C=n("sk-dialog"),N=n("SkDeleteButton");return r(),v(j,null,[s(F,null,{default:a(()=>[K,Q,R]),_:1}),s(D,null,{search:a(()=>[e("div",W,[X,e("div",Z,[ee,V(e("input",{"onUpdate:modelValue":t[0]||(t[0]=l=>y.value=l),class:"block w-full rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm",placeholder:"Search Year",type:"search",name:"search"},null,512),[[P,y.value,void 0,{number:!0}]])])])]),default:a(()=>[e("div",te,[e("div",se,[e("div",oe,[le,e("div",ae,[p.value.length>0?(r(),_(b,{key:0,onClick:t[1]||(t[1]=l=>c.value=!0),c:"bg-white border ",class:"w-40 flex items-center justify-center mr-2 h-10"},{default:a(()=>[ne,i(" Delete Selected ")]),_:1})):w("",!0),s(b,{onClick:t[2]||(t[2]=l=>m.value=!0),class:"w-40 flex items-center justify-center h-10"},{default:a(()=>[re,i(" Add School Year")]),_:1})])]),g.years.data.length>0?(r(),_($,{key:0,headers:["","School Year","","",""]},{default:a(()=>[(r(!0),v(j,null,q(g.years.data,l=>(r(),v("tr",{class:"divide-x divide-gray-200",key:l.id},[s(f,{c:"whitespace-nowrap align-center text-center text-sm items-center  font-medium text-gray-900"},{default:a(()=>[V(e("input",{"onUpdate:modelValue":t[3]||(t[3]=L=>p.value=L),value:l.id,type:"checkbox",class:"h-4 w-4 accent-green-600 text-white rounded border-gray-200"},null,8,ie),[[I,p.value]])]),_:2},1024),s(f,null,{default:a(()=>[i(" SY."+z(l.from)+" - "+z(l.to),1)]),_:2},1024),s(f),s(f),s(f)]))),128))]),_:1})):(r(),_(E,{key:1,class:"flex items-center justify-center h-64"})),o.$props.years.links.length>0?(r(),v("div",ce,[o.$props.years.data.length>0?(r(),_(A,{key:0,class:"block",links:o.$props.years.links},null,8,["links"])):w("",!0)])):w("",!0)])]),s(C,{transition:"slide-down",width:"640",persistent:!0,isOpen:m.value},{default:a(()=>[e("main",de,[e("section",ue,[e("aside",me,[pe,s(S,{class:"px-2 py-1 w-full text-sm border",modelValue:h(d).fromYear,"onUpdate:modelValue":t[4]||(t[4]=l=>h(d).fromYear=l),inputFormat:"yyyy","minimum-view":"year"},null,8,["modelValue"])]),e("aside",fe,[he,s(S,{class:"px-2 py-1 w-full text-sm border",modelValue:h(d).toYear,"onUpdate:modelValue":t[5]||(t[5]=l=>h(d).toYear=l),inputFormat:"yyyy","minimum-view":"year"},null,8,["modelValue"])])]),ve,e("div",_e,[s(Y,{onClick:t[6]||(t[6]=l=>m.value=!1)},{default:a(()=>[i(" Close ")]),_:1}),s(H,{onClick:T,processing:h(d).processing},{default:a(()=>[i(" Save")]),_:1},8,["processing"])])])]),_:1},8,["isOpen"]),s(C,{transition:"slide-down",persistent:!0,isOpen:c.value},{default:a(()=>[e("main",ge,[xe,e("div",ye,[s(N,{onClick:O,processing:x.value,class:"w-24"},{default:a(()=>[i(" Yes ")]),_:1},8,["processing"]),s(Y,{onClick:t[7]||(t[7]=l=>c.value=!1),c:"w-24"},{default:a(()=>[i(" No ")]),_:1})])])]),_:1},8,["isOpen"])]),_:1})],64)}}});export{Ye as default};
