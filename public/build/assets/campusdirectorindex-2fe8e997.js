import{i as u,v as J,j as K,O as D,o as r,c as d,w as s,b as e,k as O,l as Q,e as i,f as _,d as n,a as x,m as R,z as W,t as y,F as X,u as k,r as c}from"./app-544d6b58.js";import{l as Z}from"./lodash-ade73c30.js";import V from"./accounts-c2c5dc13.js";import{_ as j}from"./schoolYearSelect-aa65a4c6.js";import{_ as z}from"./guestUserSelect-517d9360.js";import"./adminlayout-10455c20.js";const ee={class:"mx-auto w-full max-w-xs lg:max-w-md"},te=e("label",{for:"search",class:"sr-only"},"Search",-1),se={class:"relative text-white focus-within:text-gray-600"},oe=e("div",{class:"pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"},[e("svg",{class:"h-5 w-5",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[e("path",{"fill-rule":"evenodd",d:"M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z","clip-rule":"evenodd"})])],-1),le={class:"flex items-center justify-end"},ae={class:"flex items-center"},re=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2 text-rose-700"},[e("path",{"fill-rule":"evenodd",d:"M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z","clip-rule":"evenodd"})],-1),ne=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2"},[e("path",{"fill-rule":"evenodd",d:"M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z","clip-rule":"evenodd"})],-1),ce=["value"],ie={key:2,class:"mt-6 py-4 bg-white"},ue={class:"p-2"},de={class:"mb-4"},me=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"},"School Year",-1),_e={class:"mt-1"},fe={class:"mb-4"},pe=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"}," User ",-1),ve={class:"mt-1"},he={class:"mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3"},ge={class:"p-2"},we=e("div",{class:"sm:flex sm:items-start"},[e("div",{class:"mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"},[e("svg",{class:"h-6 w-6 text-red-600",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor","aria-hidden":"true"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"})])]),e("div",{class:"mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"},[e("h3",{class:"text-lg font-medium leading-6 text-gray-900",id:"modal-title"}," Delete campus Director/s "),e("div",{class:"mt-2"},[e("p",{class:"text-sm text-gray-500"}," Are you sure you want to delete Directors/es ? All of your data will be permanently removed from our servers forever. This action cannot be undone. ")])])],-1),xe={class:"mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"},ye={components:{accounts:V,schoolYearSelect:j,guestUserSelect:z}},Oe=Object.assign(ye,{__name:"campusdirectorindex",props:{campus_directors:Object,filters:Object},setup(M){const v=M,h=u(v.filters.search),f=u(!1),p=u(!1),g=u(!1),m=u([]),N=u(null),b=u(null),l=J({school_year_id:null,user_id:null,id:null});function Y(t){l.school_year_id=t}function $(t){t!=null&&(l.school_year_id=t)}function T(t){l.user_id=t}function U(t){t!=null&&(l.user_id=t)}async function A(){N.value=null,g.value=!0;try{const t=await D.post(route("campusdirector.deleteselected"),{ids:m.value});p.value=!1,m.value=[]}catch(t){b.value=t.message}finally{g.value=!1}}K(h,Z.throttle(t=>{D.get(route("campusdirector.index"),{search:t},{preserveState:!0,replace:!0})},500));function E(){l.reset(),f.value=!0}function L(){l.post(route("campusdirector.create"),{preserveState:!0,onSuccess:()=>{f.value=!1,l.reset()},onError:t=>{b.value=t}})}return(t,a)=>{const S=c("sk-button2"),w=c("Tcell"),F=c("SkTable"),H=c("EmptyCard"),G=c("Pagination"),C=c("SkButtonGray"),I=c("SkButton"),B=c("sk-dialog"),P=c("SkDeleteButton");return r(),d(V,null,{search:s(()=>[e("div",ee,[te,e("div",se,[oe,O(e("input",{"onUpdate:modelValue":a[0]||(a[0]=o=>h.value=o),class:"block w-full rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm",placeholder:"Name, Campus, Shool Year",type:"search",name:"search"},null,512),[[Q,h.value,void 0,{number:!0}]])])])]),default:s(()=>[e("div",le,[e("div",ae,[m.value.length>0?(r(),d(S,{key:0,onClick:a[1]||(a[1]=o=>p.value=!0),c:"bg-white border ",class:"w-40 flex items-center justify-center mr-2 h-10"},{default:s(()=>[re,i(" Delete Selected ")]),_:1})):_("",!0),n(S,{onClick:E,class:"min-w-40 px-4 flex items-center justify-center h-10"},{default:s(()=>[ne,i(" Add Campus Director ")]),_:1})])]),v.campus_directors.data.length>0?(r(),d(F,{key:0,headers:["","Name","Campus","School Year"]},{default:s(()=>[(r(!0),x(X,null,R(v.campus_directors.data,o=>(r(),x("tr",{class:"divide-x divide-gray-200",key:o},[n(w,{c:"whitespace-nowrap align-center text-center text-sm items-center  font-medium text-gray-900"},{default:s(()=>[O(e("input",{"onUpdate:modelValue":a[2]||(a[2]=q=>m.value=q),value:o.id,type:"checkbox",class:"h-4 w-4 accent-green-600 text-white rounded border-gray-200"},null,8,ce),[[W,m.value]])]),_:2},1024),o.user!=null?(r(),d(w,{key:0,class:"uppercase"},{default:s(()=>[i(y(o.user.first_name)+" - "+y(o.user.first_name),1)]),_:2},1024)):_("",!0),n(w,null,{default:s(()=>[i(y(o.school_year!=null?"SY."+o.school_year.from+" - "+o.school_year.to:"None"),1)]),_:2},1024)]))),128))]),_:1})):(r(),d(H,{key:1,class:"flex items-center justify-center h-64"})),t.$props.campus_directors.links.length>0?(r(),x("div",ie,[t.$props.campus_directors.data.length>0?(r(),d(G,{key:0,class:"block",links:t.$props.campus_directors.links},null,8,["links"])):_("",!0)])):_("",!0),n(B,{transition:"slide-down",persistent:!0,isOpen:f.value},{default:s(()=>[e("main",ue,[e("div",de,[me,e("div",_e,[n(j,{onSelectItem:Y,onSetDefaultValue:$})])]),e("div",fe,[pe,e("div",ve,[n(z,{onSelectItem:T,onSetDefaultValue:U})])]),e("div",he,[n(C,{onClick:a[3]||(a[3]=o=>f.value=!1)},{default:s(()=>[i(" Close ")]),_:1}),e("div",null,[k(l).school_year_id!=null&&k(l).user_id!=null?(r(),d(I,{key:0,onClick:L,processing:k(l).processing},{default:s(()=>[i(" Save")]),_:1},8,["processing"])):_("",!0)])])])]),_:1},8,["isOpen"]),n(B,{transition:"slide-down",persistent:!0,isOpen:p.value},{default:s(()=>[e("main",ge,[we,e("div",xe,[n(P,{onClick:A,processing:g.value,class:"w-24"},{default:s(()=>[i(" Yes ")]),_:1},8,["processing"]),n(C,{onClick:a[4]||(a[4]=o=>p.value=!1),c:"w-24"},{default:s(()=>[i(" No ")]),_:1})])])]),_:1},8,["isOpen"])]),_:1})}}});export{Oe as default};