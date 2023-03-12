import{_ as u,r as c,o as n,a as r,b as i,d as o,w as a,e as s,f as d,g as p,h}from"./app-50876ac1.js";const f={data(){return{isLoading:!1}},methods:{logout(){this.isLoading=!0,this.$inertia.post("/logout").then(()=>{this.$inertia.visit("/login")})}}},v={class:"min-h-full"},g={class:"bg-gradient-to-r relative from-green-800 to-green-900 pb-24"},m=i("img",{src:"/assets/bg.jpg",class:"absolute w-full h-full object-cover opacity-20",alt:""},null,-1),$={class:"relative z-50 mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8"},b={class:"relative flex flex-wrap items-center justify-center lg:justify-between"},x={class:"w-full py-5 lg:border-t border-white border-opacity-20"},w={class:"grid grid-cols-3 items-center gap-y-8"},_={class:"col-span-2"},k={class:""},y={key:0},z={key:1},S={key:2},C={key:3},j={key:4},L={class:"px-12 lg:px-0"},O=h('<div class="absolute right-0 flex-shrink-0 lg:hidden"><button type="button" class="inline-flex items-center justify-center rounded-md bg-transparent p-2 text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" aria-expanded="false"><span class="sr-only">Open main menu</span><svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg><svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>',1),V={class:"relative -mt-24 pb-8"},B=i("footer",null,[i("div",{class:"mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8"},[i("div",{class:"border-t border-gray-200 py-8 text-center text-sm text-white sm:text-left"},[i("span",{class:"block sm:inline"},"© 2023 SKSU PROJECT .")])])],-1);function D(e,N,P,R,A,E){const l=c("SksuProfile"),t=c("DashboardLink");return n(),r("div",v,[i("header",g,[m,i("div",$,[i("div",b,[o(l),i("div",x,[i("div",w,[i("div",_,[i("nav",k,[e.$page.props.can.isOsas?(n(),r("div",y,[o(t,{href:e.route("schoolyear.index"),active:e.$page.component==="osas/schoolyear"},{default:a(()=>[s(" School Year ")]),_:1},8,["href","active"]),o(t,{href:e.route("campus.index"),active:e.$page.component==="osas/campusindex"},{default:a(()=>[s(" Campus ")]),_:1},8,["href","active"]),o(t,{href:e.route("account.userpassword.index"),active:e.$page.component==="osas/accountpasswordindex"||e.$page.component==="osas/campusadviserindex"||e.$page.component==="osas/campusdirectorindex"||e.$page.component==="osas/vpaindex"},{default:a(()=>[s(" Accounts & Roles ")]),_:1},8,["href","active"]),o(t,{href:e.route("requirement.index"),active:e.$page.component==="osas/requirementsindex"},{default:a(()=>[s(" Requirements ")]),_:1},8,["href","active"]),o(t,{href:e.route("osas.organization.index"),active:e.$page.component==="osas/organizationindex"},{default:a(()=>[s(" Review Documents ")]),_:1},8,["href","active"]),o(t,{href:e.route("osas.organization.endorsedindex"),active:e.$page.component==="osas/endorseindex"},{default:a(()=>[s(" Endorsed List ")]),_:1},8,["href","active"]),o(t,{href:e.route("osas.reports.index"),active:e.$page.component==="osas/reportindex"},{default:a(()=>[s(" Certificate & Printing ")]),_:1},8,["href","active"]),o(t,{href:e.route("osas.accreditation.index"),active:e.$page.component==="osas/accreditationindex"},{default:a(()=>[s(" Previous Accreditation ")]),_:1},8,["href","active"])])):d("",!0),e.$page.props.can.isSboAdviser?(n(),r("div",z,[o(t,{href:e.route("campusadviser.organization.index"),active:e.$page.component==="sboadviser/organizationindex"},{default:a(()=>[s(" Rewiew Submiited Documents ")]),_:1},8,["href","active"]),o(t,{href:e.route("campusadviser.organization.endorsedindex"),active:e.$page.component==="sboadviser/endorsedindex"},{default:a(()=>[s(" Endorsed List ")]),_:1},8,["href","active"])])):d("",!0),e.$page.props.can.isDirector?(n(),r("div",S,[o(t,{href:e.route("director.organization.index"),active:e.$page.component==="director/index"},{default:a(()=>[s(" Organizations ")]),_:1},8,["href","active"])])):d("",!0),e.$page.props.can.isSboStudent||e.$page.props.can.isGuest?(n(),r("div",C,[o(t,{href:e.route("application.index"),active:e.$page.component==="student/applicationindex"},{default:a(()=>[s(" Organizations ")]),_:1},8,["href","active"]),o(t,{href:e.route("template.index"),active:e.$page.component==="student/templateindex"},{default:a(()=>[s(" Apllication Templates ")]),_:1},8,["href","active"])])):d("",!0),e.$page.props.can.isVpa?(n(),r("div",j,[o(t,{href:e.route("vpa.organization.index"),active:e.$page.component==="vpa/organizationindex"},{default:a(()=>[s(" Organizations ")]),_:1},8,["href","active"])])):d("",!0)])]),i("div",L,[p(e.$slots,"search")])])]),O])])]),i("main",V,[p(e.$slots,"default")]),B])}const q=u(f,[["render",D]]);export{q as a};
