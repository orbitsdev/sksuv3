import{i as d,v as R,j as W,O as D,o as a,c as u,w as l,b as e,k as O,l as X,e as c,f as m,d as n,a as y,m as Z,z as ee,t as v,F as te,u as k,r as i}from"./app-619bd0ce.js";import{l as se}from"./lodash-74a09375.js";import B from"./accounts-50b97991.js";import{_ as j}from"./schoolYearSelect-32f3c101.js";import{_ as z}from"./guestUserSelect-74c4f40a.js";import{_ as N}from"./campusSelect-bf3462b0.js";import"./adminlayout-02f5365f.js";const le={class:"mx-auto w-full max-w-xs lg:max-w-md"},oe=e("label",{for:"search",class:"sr-only"},"Search",-1),ae={class:"relative text-white focus-within:text-gray-600"},ne=e("div",{class:"pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"},[e("svg",{class:"h-5 w-5",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[e("path",{"fill-rule":"evenodd",d:"M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z","clip-rule":"evenodd"})])],-1),re={class:"flex items-center justify-end"},ce={class:"flex items-center"},ie=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2 text-rose-700"},[e("path",{"fill-rule":"evenodd",d:"M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z","clip-rule":"evenodd"})],-1),ue=e("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor",class:"w-5 h-5 mr-2"},[e("path",{"fill-rule":"evenodd",d:"M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z","clip-rule":"evenodd"})],-1),de=["value"],me={key:2,class:"mt-6 py-4 bg-white"},_e={class:"p-2"},pe={class:"mb-4"},fe=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"},"School Year",-1),he={class:"mt-1"},ve={class:"mb-4"},ge=e("label",{for:"campus",class:"block text-sm font-medium text-gray-700"},"Campus",-1),xe={class:"mt-1"},we={class:"mb-4"},ye=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"}," User ",-1),ke={class:"mt-1"},be={class:"mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3"},Se={class:"p-2"},Ce=e("div",{class:"sm:flex sm:items-start"},[e("div",{class:"mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"},[e("svg",{class:"h-6 w-6 text-red-600",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor","aria-hidden":"true"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"})])]),e("div",{class:"mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"},[e("h3",{class:"text-lg font-medium leading-6 text-gray-900",id:"modal-title"}," Delete campus Director/s "),e("div",{class:"mt-2"},[e("p",{class:"text-sm text-gray-500"}," Are you sure you want to delete Directors/es ? All of your data will be permanently removed from our servers forever. This action cannot be undone. ")])])],-1),Ve={class:"mt-5 sm:mt-4 sm:flex sm:flex-row-reverse"},De={components:{accounts:B,schoolYearSelect:j,campusSelect:N,guestUserSelect:z}},Ye=Object.assign(De,{__name:"campusdirectorindex",props:{campus_directors:Object,filters:Object},setup($){const g=$,x=d(g.filters.search),p=d(!1),f=d(!1),w=d(!1),_=d([]),M=d(null),b=d(null),o=R({school_year_id:null,campus_id:null,user_id:null,id:null});function Y(t){o.school_year_id=t}function T(t){t!=null&&(o.school_year_id=t)}function U(t){o.user_id=t}function A(t){t!=null&&(o.user_id=t)}function E(t){o.campus_id=t}function L(t){t!=null&&(o.campus_id=t)}async function F(){M.value=null,w.value=!0;try{const t=await D.post(route("campusdirector.deleteselected"),{ids:_.value});f.value=!1,_.value=[]}catch(t){b.value=t.message}finally{w.value=!1}}W(x,se.throttle(t=>{D.get(route("campusdirector.index"),{search:t},{preserveState:!0,replace:!0})},500));function H(){o.reset(),p.value=!0}function I(){o.post(route("campusdirector.create"),{preserveState:!0,onSuccess:()=>{p.value=!1,o.reset()},onError:t=>{b.value=t}})}return(t,r)=>{const S=i("sk-button2"),h=i("Tcell"),G=i("SkTable"),P=i("EmptyCard"),q=i("Pagination"),C=i("SkButtonGray"),J=i("SkButton"),V=i("sk-dialog"),K=i("SkDeleteButton");return a(),u(B,null,{search:l(()=>[e("div",le,[oe,e("div",ae,[ne,O(e("input",{"onUpdate:modelValue":r[0]||(r[0]=s=>x.value=s),class:"block w-full rounded-md border border-transparent bg-white bg-opacity-20 py-2 pl-10 pr-3 leading-5 text-white placeholder-white focus:border-transparent focus:bg-opacity-100 focus:text-gray-900 focus:placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm",placeholder:"Name, Campus, Shool Year",type:"search",name:"search"},null,512),[[X,x.value,void 0,{number:!0}]])])])]),default:l(()=>[e("div",re,[e("div",ce,[_.value.length>0?(a(),u(S,{key:0,onClick:r[1]||(r[1]=s=>f.value=!0),c:"bg-white border ",class:"w-40 flex items-center justify-center mr-2 h-10"},{default:l(()=>[ie,c(" Delete Selected ")]),_:1})):m("",!0),n(S,{onClick:H,class:"min-w-40 px-4 flex items-center justify-center h-10"},{default:l(()=>[ue,c(" Add Campus Director ")]),_:1})])]),g.campus_directors.data.length>0?(a(),u(G,{key:0,headers:["","Name","Campus","School Year"]},{default:l(()=>[(a(!0),y(te,null,Z(g.campus_directors.data,s=>(a(),y("tr",{class:"divide-x divide-gray-200",key:s},[n(h,{c:"whitespace-nowrap align-center text-center text-sm items-center  font-medium text-gray-900"},{default:l(()=>[O(e("input",{"onUpdate:modelValue":r[2]||(r[2]=Q=>_.value=Q),value:s.id,type:"checkbox",class:"h-4 w-4 accent-green-600 text-white rounded border-gray-200"},null,8,de),[[ee,_.value]])]),_:2},1024),s.user!=null?(a(),u(h,{key:0,class:"uppercase"},{default:l(()=>[c(v(s.user.first_name)+" - "+v(s.user.last_name),1)]),_:2},1024)):m("",!0),s.campus!=null?(a(),u(h,{key:1,class:"uppercase"},{default:l(()=>[c(v(s.campus!=null?s.campus.name:"None"),1)]),_:2},1024)):m("",!0),n(h,null,{default:l(()=>[c(v(s.school_year!=null?"SY."+s.school_year.from+" - "+s.school_year.to:"None"),1)]),_:2},1024)]))),128))]),_:1})):(a(),u(P,{key:1,class:"flex items-center justify-center h-64"})),t.$props.campus_directors.links.length>0?(a(),y("div",me,[t.$props.campus_directors.data.length>0?(a(),u(q,{key:0,class:"block",links:t.$props.campus_directors.links},null,8,["links"])):m("",!0)])):m("",!0),n(V,{transition:"slide-down",persistent:!0,isOpen:p.value},{default:l(()=>[e("main",_e,[e("div",pe,[fe,e("div",he,[n(j,{onSelectItem:Y,onSetDefaultValue:T})])]),e("div",ve,[ge,e("div",xe,[n(N,{onSelectItem:E,onSetDefaultValue:L})])]),e("div",we,[ye,e("div",ke,[n(z,{onSelectItem:U,onSetDefaultValue:A})])]),e("div",be,[n(C,{onClick:r[3]||(r[3]=s=>p.value=!1)},{default:l(()=>[c(" Close ")]),_:1}),e("div",null,[k(o).school_year_id!=null&&k(o).user_id!=null?(a(),u(J,{key:0,onClick:I,processing:k(o).processing},{default:l(()=>[c(" Save")]),_:1},8,["processing"])):m("",!0)])])])]),_:1},8,["isOpen"]),n(V,{transition:"slide-down",persistent:!0,isOpen:f.value},{default:l(()=>[e("main",Se,[Ce,e("div",Ve,[n(K,{onClick:F,processing:w.value,class:"w-24"},{default:l(()=>[c(" Yes ")]),_:1},8,["processing"]),n(C,{onClick:r[4]||(r[4]=s=>f.value=!1),c:"w-24"},{default:l(()=>[c(" No ")]),_:1})])])]),_:1},8,["isOpen"])]),_:1})}}});export{Ye as default};
