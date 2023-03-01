import{i as p,p as X,q as Z,o as l,a as f,F as $,m as j,t as w,v as ee,j as se,O as B,c as _,w as a,b as e,k as D,l as te,e as i,f as x,d as n,z as ae,u as k,r as d}from"./app-27aba34c.js";import{l as le}from"./lodash-9b6c9e44.js";import z from"./accounts-bf52f28a.js";import{_ as M}from"./schoolYearSelect-c9eee8d5.js";import{_ as N}from"./guestUserSelect-5783e346.js";import"./adminlayout-4b9d6a69.js";const oe=["value"],ne={key:1,class:"p-2 rounded bg-rose-600 animate-pulse text-white"},re={},Y=Object.assign(re,{__name:"campusSelect",emits:["selectItem","setDefaultValue"],setup(b,{emit:v}){const m=p([]);X(async()=>{const{data:c}=await Z.get(route("public.campus"));c.data.length>0&&(m.value=c.data,v("setDefaultValue",m.value[0].id))});function h(c){v("selectItem",parseInt(c.target.value))}return(c,g)=>m.value.length>0?(l(),f("select",{key:0,onChange:g[0]||(g[0]=r=>h(r)),autocomplete:"country-name",class:"block w-full max-w-lg h-10 px-2 rounded-md border shadow-sm uppercase focus:border-purple-500 focus:ring-purple-500 sm:text-sm"},[(l(!0),f($,null,j(m.value,r=>(l(),f("option",{key:r.id,value:r.id},w(r.name),9,oe))),128))],32)):(l(),f("div",ne," Empty"))}}),ce={class:"mx-auto w-full max-w-xs lg:max-w-md"},ue=e("label",{for:"search",class:"sr-only"},"Search",-1),ie={class:"relative text-white focus-within:text-gray-600"},de=e("div",{class:"pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"},[e("svg",{class:"h-5 w-5",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[e("path",{"fill-rule":"evenodd",d:"M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z","clip-rule":"evenodd"})])],-1),me={class:"flex items-center justify-end"},pe={class:"flex items-center"},_e=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2 text-rose-700"},[e("path",{"fill-rule":"evenodd",d:"M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z","clip-rule":"evenodd"})],-1),fe=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2"},[e("path",{"fill-rule":"evenodd",d:"M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z","clip-rule":"evenodd"})],-1),ve=["value"],he={key:2,class:"mt-6 py-4 bg-white"},ge={class:"p-2"},xe={class:"mb-4"},we=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"},"School Year",-1),ye={class:"mt-1"},ke={class:"mb-4"},be=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"},"Campus ",-1),Se={class:"mt-1"},Ce={class:"mb-4"},Ve=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"}," User ",-1),Oe={class:"mt-1"},Be={class:"mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3"},De={class:"p-2"},$e=e("div",{class:"sm:flex sm:items-start"},[e("div",{class:"mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"},[e("svg",{class:"h-6 w-6 text-red-600",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor","aria-hidden":"true"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"})])]),e("div",{class:"mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"},[e("h3",{class:"text-lg font-medium leading-6 text-gray-900",id:"modal-title"}," Delete campus adviser/s "),e("div",{class:"mt-2"},[e("p",{class:"text-sm text-gray-500"}," Are you sure you want to delete advisers/es ? All of your data will be permanently removed from our servers forever. This action cannot be undone. ")])])],-1),je={class:"mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"},ze={components:{accounts:z,schoolYearSelect:M,campusSelect:Y,guestUserSelect:N}},Ie=Object.assign(ze,{__name:"campusadviserindex",props:{campus_advisers:Object,filters:Object},setup(b){const v=b,m=p(v.filters.search),h=p(!1),c=p(!1),g=p(!1),r=p([]),T=p(null),S=p(null),o=ee({school_year_id:null,campus_id:null,user_id:null,id:null});function A(s){o.school_year_id=s}function E(s){s!=null&&(o.school_year_id=s)}function I(s){o.campus_id=s}function U(s){s!=null&&(o.campus_id=s)}function L(s){o.user_id=s}function F(s){s!=null&&(o.user_id=s)}async function H(){T.value=null,g.value=!0;try{const s=await B.post(route("campusadviser.deleteselected"),{ids:r.value});c.value=!1,r.value=[]}catch(s){S.value=s.message}finally{g.value=!1}}se(m,le.throttle(s=>{B.get(route("campusadviser.index"),{search:s},{preserveState:!0,replace:!0})},500));function G(){o.reset(),h.value=!0}function P(){o.post(route("campusadviser.create"),{preserveState:!0,onSuccess:()=>{h.value=!1,o.reset()},onError:s=>{S.value=s}})}return(s,u)=>{const C=d("sk-button2"),y=d("Tcell"),q=d("SkTable"),J=d("EmptyCard"),K=d("Pagination"),V=d("SkButtonGray"),Q=d("SkButton"),O=d("sk-dialog"),R=d("SkDeleteButton");return l(),_(z,null,{search:a(()=>[e("div",ce,[ue,e("div",ie,[de,D(e("input",{"onUpdate:modelValue":u[0]||(u[0]=t=>m.value=t),class:"block w-full rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm",placeholder:"Name, Campus, Shool Year",type:"search",name:"search"},null,512),[[te,m.value,void 0,{number:!0}]])])])]),default:a(()=>[e("div",me,[e("div",pe,[r.value.length>0?(l(),_(C,{key:0,onClick:u[1]||(u[1]=t=>c.value=!0),c:"bg-white border ",class:"w-40 flex items-center justify-center mr-2 h-10"},{default:a(()=>[_e,i(" Delete Selected ")]),_:1})):x("",!0),n(C,{onClick:G,class:"min-w-40 px-4 flex items-center justify-center h-10"},{default:a(()=>[fe,i(" Add Campus Adviser ")]),_:1})])]),v.campus_advisers.data.length>0?(l(),_(q,{key:0,headers:["","Name","Campus","School Year"]},{default:a(()=>[(l(!0),f($,null,j(v.campus_advisers.data,t=>(l(),f("tr",{class:"divide-x divide-gray-200",key:t},[n(y,{c:"whitespace-nowrap align-center text-center text-sm items-center  font-medium text-gray-900"},{default:a(()=>[D(e("input",{"onUpdate:modelValue":u[2]||(u[2]=W=>r.value=W),value:t.id,type:"checkbox",class:"h-4 w-4 accent-green-600 text-white rounded border-gray-200"},null,8,ve),[[ae,r.value]])]),_:2},1024),t.user!=null?(l(),_(y,{key:0,class:"uppercase"},{default:a(()=>[i(w(t.user.first_name)+" - "+w(t.user.first_name),1)]),_:2},1024)):x("",!0),n(y,{class:"uppercase"},{default:a(()=>[i(w(t.campus!=null?t.campus.name:"None"),1)]),_:2},1024),n(y,null,{default:a(()=>[i(w(t.school_year!=null?"SY."+t.school_year.from+" - "+t.school_year.to:"None"),1)]),_:2},1024)]))),128))]),_:1})):(l(),_(J,{key:1,class:"flex items-center justify-center h-64"})),s.$props.campus_advisers.links.length>0?(l(),f("div",he,[s.$props.campus_advisers.data.length>0?(l(),_(K,{key:0,class:"block",links:s.$props.campus_advisers.links},null,8,["links"])):x("",!0)])):x("",!0),n(O,{transition:"slide-down",persistent:!0,isOpen:h.value},{default:a(()=>[e("main",ge,[e("div",xe,[we,e("div",ye,[n(M,{onSelectItem:A,onSetDefaultValue:E})])]),e("div",ke,[be,e("div",Se,[n(Y,{onSelectItem:I,onSetDefaultValue:U})])]),e("div",Ce,[Ve,e("div",Oe,[n(N,{onSelectItem:L,onSetDefaultValue:F})])]),e("div",Be,[n(V,{onClick:u[3]||(u[3]=t=>h.value=!1)},{default:a(()=>[i(" Close ")]),_:1}),e("div",null,[k(o).school_year_id!=null&&k(o).campus_id!=null&&k(o).user_id!=null?(l(),_(Q,{key:0,onClick:P,processing:k(o).processing},{default:a(()=>[i(" Save")]),_:1},8,["processing"])):x("",!0)])])])]),_:1},8,["isOpen"]),n(O,{transition:"slide-down",persistent:!0,isOpen:c.value},{default:a(()=>[e("main",De,[$e,e("div",je,[n(R,{onClick:H,processing:g.value,class:"w-24"},{default:a(()=>[i(" Yes ")]),_:1},8,["processing"]),n(V,{onClick:u[4]||(u[4]=t=>c.value=!1),c:"w-24"},{default:a(()=>[i(" No ")]),_:1})])])]),_:1},8,["isOpen"])]),_:1})}}});export{Ie as default};