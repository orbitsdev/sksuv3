

<template>


<!-- //logoutlaoding -->



<div class="min-h-full">
  <header class="bg-gradient-to-r from-green-800 to-green-900 pb-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <div class="relative flex flex-wrap items-center justify-center lg:justify-between">
        <SksuProfile/>
        <div class="w-full py-5 lg:border-t lg:border-white lg:border-opacity-20">
          <div class="lg:grid lg:grid-cols-3 lg:items-center lg:gap-8">
            <!-- Left nav -->
            <div class=" lg:col-span-2 lg:block">
              <nav class="flex space-x-4">
              <DashboardLink :href="route('schoolyear.index')" :active="$page.component=== 'osas/schoolyear'"> School Year </DashboardLink>
              <DashboardLink :href="route('campus.index')" :active="$page.component === 'osas/campusindex'"> Campuses </DashboardLink>
              <DashboardLink :href="route('account.userpassword.index')" :active="($page.component === 'osas/accountpasswordindex' || $page.component === 'osas/campusadviserindex'  ) "> Accounts & Roles </DashboardLink>
              <DashboardLink href="#" :active="$page.component=== 'organizations'"> Organizations </DashboardLink>
              <DashboardLink href="#" :active="$page.component=== 'campusDirector' "> Applications </DashboardLink>
              <DashboardLink href="#" :active="$page.component=== 'campusDirector' "> Endoresed </DashboardLink>


<!--               
<SksuLink href="/page1"> Page1</SksuLink>
<SksuLink href="/page2"> Page2</SksuLink>
<SksuLink href="/page3"> Page3</SksuLink> -->

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
  
  <main class="-mt-24 pb-8">
 
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