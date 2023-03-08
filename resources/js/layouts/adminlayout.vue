

<template>


<!-- //logoutlaoding -->



<div class="min-h-full ">
  <header class="bg-gradient-to-r relative from-green-800 to-green-900   pb-24">
<img src="/assets/bg.jpg" class="absolute w-full h-full object-cover opacity-20" alt="">
  
    <div class="relative z-50 mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <div class="relative flex flex-wrap items-center justify-center lg:justify-between">
        <SksuProfile/>
        <div class="w-full py-5 lg:border-t border-white border-opacity-20">
          <div class="grid grid-cols-3 items-center gap-y-8 ">
            <!-- Left nav -->
            <div class="col-span-2 ">


       
              <nav class="">

              <div v-if="$page.props.can.isOsas">
              <DashboardLink :href="route('schoolyear.index')" :active="$page.component=== 'osas/schoolyear'"> School Year </DashboardLink>
              <DashboardLink :href="route('campus.index')" :active="($page.component === 'osas/campusindex')"> Campus </DashboardLink>
              <DashboardLink :href="route('account.userpassword.index')" :active="($page.component === 'osas/accountpasswordindex' || $page.component === 'osas/campusadviserindex' || $page.component === 'osas/campusdirectorindex' || $page.component === 'osas/vpaindex' ) "> Accounts & Roles </DashboardLink>
              <DashboardLink :href="route('requirement.index')" :active="$page.component=== 'osas/requirementsindex' "> Requirements  </DashboardLink>
              <DashboardLink :href="route('osas.organization.index')" :active="$page.component=== 'osas/organizationindex' "> Review Documents  </DashboardLink>
              <DashboardLink   :href="route('osas.organization.endorsedindex')" :active="$page.component=== 'osas/endorseindex' "> Endorsed List  </DashboardLink>
              <!-- <DashboardLink :href="route('osas.generatecerticate.index')" :active="$page.component=== 'osas/generatecertificateindex' "> Generate Certificate  </DashboardLink> -->
              <DashboardLink   :href="route('osas.accreditation.index')" :active="$page.component=== 'osas/accreditationindex' "> Accreditation  </DashboardLink>
            
              <DashboardLink   :href="route('osas.reports.index')" :active="$page.component=== 'osas/reportindex' "> Certificate & Printing  </DashboardLink>
              </div>
              <div v-if="$page.props.can.isSboAdviser">
              <!-- <DashboardLink :href="route('officers.index')" :active="$page.component=== 'sboadviser/officerindex'"> Officers </DashboardLink> -->
              <DashboardLink :href="route('campusadviser.organization.index')" :active="$page.component=== 'sboadviser/organizationindex'"> Rewiew Submiited Documents </DashboardLink>
              <DashboardLink :href="route('campusadviser.organization.endorsedindex')" :active="$page.component=== 'sboadviser/endorsedindex'"> Endorsed List </DashboardLink>
  
              </div>
              <div v-if="$page.props.can.isDirector">
              <!-- <DashboardLink :href="route('officers.index')" :active="$page.component=== 'sboadviser/officerindex'"> Officers </DashboardLink> -->
              <DashboardLink :href="route('director.organization.index')" :active="$page.component=== 'director/index'"> Organizations </DashboardLink>
  
              </div>
              <div v-if="($page.props.can.isSboStudent || $page.props.can.isGuest )">
              <!-- <DashboardLink :href="route('officers.index')" :active="$page.component=== 'sboadviser/officerindex'"> Officers </DashboardLink> -->
          
              <DashboardLink :href="route('application.index')" :active="$page.component=== 'student/applicationindex'"> Organizations </DashboardLink>
  
          
              </div>
              <div v-if="$page.props.can.isVpa">
              <!-- <DashboardLink :href="route('officers.index')" :active="$page.component=== 'sboadviser/officerindex'"> Officers </DashboardLink> -->
          
              <DashboardLink :href="route('vpa.organization.index')" :active="$page.component=== 'vpa/organizationindex'"> Organizations </DashboardLink>
  
          
              </div>

              </nav>
            </div>
            <div class="px-12 lg:px-0">
                <slot name="search">
                             
                </slot>
             
            </div>
          </div>
        </div>

        <!-- Menu button -->
        <div class="absolute right-0 flex-shrink-0 lg:hidden">
          <!-- Mobile menu button -->
          <button type="button" class="inline-flex items-center justify-center rounded-md bg-transparent p-2 text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <!-- Menu open: "hidden", Menu closed: "block" -->
            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Menu open: "block", Menu closed: "hidden" -->
            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

   
    
  </header>
  
  <main class="relative -mt-24 pb-8">
 
  <slot >
        

  </slot>
       
  </main>
  <footer>
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <div class="border-t border-gray-200 py-8 text-center text-sm text-white sm:text-left"><span class="block sm:inline">&copy; 2023 SKSU PROJECT .</span> </div>
    </div>
  </footer>
</div>

    <!-- <div>
        <SksuLink  href="/logout"  method="post" > Logout </SksuLink>
    </div> -->
</template>

<script>
    export default {
         data() {
    return {
      isLoading: false,
    };
  },

  methods: {
    logout() {
      this.isLoading = true;
      this.$inertia.post('/logout').then(() => {
        // Redirect to login page after logout
        this.$inertia.visit('/login');
      });
    },
  },
        
    }
</script>

<style  scoped>

</style>