import{i as g,v as b,o as d,a as m,b as e,y as k,d as t,u as o,t as c,f as _,w as u,e as n,F as S,h as V,r as a}from"./app-75b9c162.js";const C={class:"flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8"},B=e("div",{class:"sm:mx-auto sm:w-full sm:max-w-md"},[e("img",{class:"mx-auto h-12 w-auto",src:"/assets/sksu1.png",alt:"Your Company"}),e("h2",{class:"mt-6 text-center text-3xl font-bold tracking-tight text-gray-900"}," Sign in to your account ")],-1),N={class:"mt-8 sm:mx-auto sm:w-full sm:max-w-md"},j={class:"bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10"},A=["onSubmit"],D=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"},"Email address",-1),$={class:"mt-1"},O={key:0,class:"text-red-700 text-sm"},E=e("label",{for:"password",class:"block text-sm font-medium text-gray-700"},"Password",-1),F={class:"mt-1"},L={key:0,class:"text-red-700 text-sm"},U={class:"mt-4"},z=V('<div class="relative"><div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-300"></div></div><div class="relative flex justify-center text-sm"><span class="bg-white px-2 text-gray-500">Or </span></div></div>',1),G={class:"mt-4"},M=e("div",null,[e("a",{href:"/authorize/google/redirect",class:"inline-flex w-full justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50"},[e("img",{src:"/assets/google.svg",class:"w-5 h-5 mr-2",alt:""}),n(" Continue with with Google ")])],-1),P={class:"mt-2 text-sm flex items-center justify-center"},Y={__name:"login",setup(T){const p=g(null);g(!1);let s=b({email:"",password:""});function f(){s.post("user/login")}return(l,i)=>{const h=a("Authfield1"),x=a("Authfield"),v=a("SkButton"),w=a("SksuLink"),y=a("SkDialog");return d(),m(S,null,[e("div",C,[B,e("div",N,[e("div",j,[e("form",{onSubmit:k(f,["prevent"]),class:"space-y-6"},[e("div",null,[D,e("div",$,[t(h,{type:"email",autocomplete:"email",modelValue:o(s).email,"onUpdate:modelValue":i[0]||(i[0]=r=>o(s).email=r)},null,8,["modelValue"])]),l.$page.props.errors.email?(d(),m("p",O,c(l.$page.props.errors.email),1)):_("",!0)]),e("div",null,[E,e("div",F,[t(x,{modelValue:o(s).password,"onUpdate:modelValue":i[1]||(i[1]=r=>o(s).password=r)},null,8,["modelValue"])]),l.$page.props.errors.password?(d(),m("p",L,c(l.$page.props.errors.password),1)):_("",!0)]),e("div",null,[t(v,{type:"submit",processing:o(s).processing},{default:u(()=>[n(" Signin ")]),_:1},8,["processing"])])],40,A),e("div",U,[z,e("div",G,[M,e("div",P,[t(w,{href:"/register","preserve-scroll":"",class:"font-medium text-indigo-600 hover:text-indigo-500 underline"},{default:u(()=>[n(" Dont have an acount? Signup ")]),_:1})])])])])])]),t(y,{isOpen:p.value!=null,dialogClass:"shadow-xl rounded-lg",contentClass:"bg-red-500"},{default:u(()=>[n(c(p.value),1)]),_:1},8,["isOpen"])],64)}}};export{Y as default};