
<script setup>
// import Echo from 'laravel-echo';
import pusher from '@/plugins/pusher.js';
// const pusher  = require('pusher-js');
// require ('pusher-js/dist/web/pusher');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.VITE_PUSHER_APP_KEY,
//     cluster: process.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: false,
//     wsHost: window.location.hostname,
//     wsPort: 6001,
// });

import { ref, onMounted, onBeforeUnmount } from "vue";

import { router } from "@inertiajs/core";
const isOpen = ref(false);
const isNotif = ref(false);
const is_singning_out = ref(false);


const closeOnClickOutside = (event) => {
  if (document.getElementById("logout-dropdown").contains(event.target)) {

    isOpen.value = !isOpen.value;
  } else {
    if (isOpen.value == true) {
      isOpen.value = false;
    }
  }
};
onMounted(() => {
  document.addEventListener("click", closeOnClickOutside);

  // require

  // window.Echo.private("App.User." + $page.props.auth.user.id)
  //   .notification((notification) => {

  //     console.log("whashdhasdw ahdasd d");
  //     // isNotif.value = true;req
  //   });
});
onBeforeUnmount(() => {
  document.removeEventListener("click", closeOnClickOutside);
});

function logout() {
  is_singning_out.value = true;
  router.post("/logout", {
    onSuccess: () => {
      is_singning_out.value = false;
    },
    onError: (err) => {
      is_singning_out.value = false;
    },
    onFinish: () => {
      is_singning_out.value = false;
    },
  });
}
</script>

<template>
  <div class="py-5 lg:static flex items-center">
    <div class="mr-2">
      <span class="sr-only">Your Company</span>
      <img class="h-12 w-12" src="/assets/sksu1.png" alt="" />
    </div>
    <p class="text-2xl text-gray-100 font-bold">WRMS-ACCREDITATION</p>
  </div>

  <div class="lg:ml-4 lg:flex lg:items-center lg:py-5 lg:pr-0.5">
    <div
      class="text-2xl font-extrabold mr-6 text-white px-4"
      v-if="$page.props.can.isSboAdviser"
    >
      {{ $page.props.sbocurrentschool }}
    </div>
    <div class="relative ">

  <!-- <div class="'cursor-pointer flex-shrink-0 rounded-full p-1 text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none relative ">
    <svg
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        aria-hidden="true"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
        />
      </svg>

           <div class="bg-red-500 flex items-center p-0.5 absolute -top-2 px-1.5 -right-0.5 z-100 justify-center text-white rounded-full text-xs"> {{$page.props.unreadNotification }} </div>
<div>
 <li  class="cursor-pointer flex py-4 z-0 hover:bg-gray-50">
       
         <div class="ml-3 ">
            <div class="border-b mb-1  flex items-center justify-between  ">
            <p class="text-sm font-medium inline-block  text-gray-900 capitalize mr-2"> </p>
              <p class="text-xs inline-block ">
                    <time datetime="2020-01-07  "></time>
            </p>
            </div>
         
             <p :class="['text-sm font-medium   inline-block px-2 roundedd text-white rounded capitalizebg-green-400' ]" > </p>
            <p class="text-sm text-gray-500 whitespace-normal mt-1">

            Aprova
            </p>
          </div>
        </li>
</div>
  </div> -->
      
    
      
      <button
      @click="isNotif = !isNotif"
      
      :class=" ['cursor-pointer flex-shrink-0 rounded-full p-1 text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none relative ', isNotif ? 'focus:ring-2 focus:ring-white' :'' ]"
    >
     <div v-if="$page.props.unreadNotification > 0 " class="bg-red-500 flex items-center w-6 h-6 absolute -top-2  -right-1.5 z-100 justify-center text-white rounded-full text-sm"> {{ $page.props.unreadNotification }}</div>
      <svg
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        aria-hidden="true"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
        />
      </svg>
    </button>
     
        <NotificationList     v-if="isNotif"
        role="list"
        class="w-96 absolute mt-4 right-0 transition-all ease-in-out z-50 origin-top-right bg-white  shadow-lg rounded-md"/>
    
    </div>

    <!-- Profile dropdown -->
    <div class="relative ml-4 flex-shrink-0">
      <div class="relative">
        <button
         id="logout-dropdown" 
          type="button"
          class="flex rounded-full bg-white text-sm ring-2 ring-white ring-opacity-20 focus:outline-none focus:ring-opacity-100"
          aria-expanded="false"
          aria-haspopup="true"
        >
          <span class="sr-only">Open user menu</span>
          <img
            class="h-8 w-8 rounded-full"
            src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
            alt=""
          />
        </button>
      </div>

      <div
        v-show="isOpen"
        class="transition-all ease-in-out absolute -right-2 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu-button"
        tabindex="-1"
      >
        <!-- Active: "bg-gray-100", Not Active: "" -->
        <!-- <SksuLink href="#" class="hover:scale-x-110 hover:bg-gray-200 rounded-lg transition-all ease-inoute block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</SksuLink>

              <SksuLink href="#" class="hover:scale-x-110 hover:bg-gray-200 rounded-lg transition-all ease-inoute block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</SksuLink> -->

        <SksuLink
          href="#"
          as="button"
          class="text-left w-full hover:scale-x-110 hover:bg-gray-200 rounded-lg transition-all ease-inoute block px-4 py-2 text-sm text-gray-700"
          role="menuitem"
          tabindex="-1"
          id="user-menu-item-2"
        >
          {{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }}
        </SksuLink>
        <SksuLink
          href="#"
          as="button"
          @click="logout"
          class="text-left w-full hover:scale-x-110 hover:bg-gray-200 rounded-lg transition-all ease-inoute block px-4 py-2 text-sm text-gray-700"
          role="menuitem"
          tabindex="-1"
          id="user-menu-item-2"
          >Sign out</SksuLink
        >
      </div>
    </div>
  </div>

  <SkDialog :persistent="true" :isOpen="is_singning_out" :width="'260'">
    <div class="flex items-center justify-center">
      <w-progress
        :size="'24'"
        class="text-green-900 mr-8"
        color="green"
        circle
      ></w-progress>
      <p class="">Signing out ....</p>
    </div>
  </SkDialog>
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
      this.$inertia.post("/logout").then(() => {
        // Redirect to login page after logout
        this.$inertia.visit("/login");
      });
    },
  },
};
</script>

<style lang="scss" scoped></style>
