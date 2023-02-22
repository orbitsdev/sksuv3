

<template>
   <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
<div class="flex min-h-full">
    <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
      <div class="mx-auto w-full max-w-sm lg:w-96">
        <div>
          <img class="h-12 w-auto" src="/assets/sksu1.png" alt="Your Company">
          <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
       
        </div>
        
        <div class="mt-8">
          <div>
            <div>
  
              <div class="mt-1 ">
                <button href="#" class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50">
                    <img src="/assets/google.svg"  class="w-5    h-5 mr-2 " alt=""> Signup with Google                
                  </button>
              </div>
            </div>

            
  
           
          </div>
  
          <div class="mt-6">
            <form  @submit.prevent="submit" class="space-y-6">
              <div>


                <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                <div class="mt-1">
                                   <Authfield1 type="text" v-model="form.first_name" />
                </div>

                <p class="text-red-700 text-sm" v-if="$page.props.errors.first_name"> {{$page.props.errors.first_name }}</p>
              </div>
              <div>
                <label for="lastname" class="block text-sm font-medium text-gray-700">Last name</label>
                <div class="mt-1">
                   <Authfield1 type="text" v-model="form.last_name" />
                </div>

                <p class="text-red-700 text-sm" v-if="$page.props.errors.last_name"> {{$page.props.errors.last_name }}</p>
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                   <Authfield1 type="email" autocomplete="email" v-model="form.email" />
                </div>
                <p class="text-red-700 text-sm" v-if="$page.props.errors.email"> {{$page.props.errors.email }} </p>
              </div>
  
              <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1">
                  <Authfield v-model="form.password" />
                </div>
                <p class="text-red-700 text-sm" v-if="$page.props.errors.password"> {{$page.props.errors.password }} </p>

              </div>
              
  
              <div>
                     <SkButton type="submit" :processing="form.processing" > Signup </SkButton>

              </div>

              <div class=" text-sm flex items-center justify-center">
                <SksuLink  href="/login" preserve-scroll class="font-medium text-indigo-600 hover:text-indigo-500 underline"> All ready have an account ? </SksuLink>
              </div>
           
            </form>

          
            
            
          </div>
        </div>
      </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
      <img class="absolute inset-0 h-full w-full object-cover" src="/assets/sksu.jpg" alt="">
    </div>
  </div>
  
</template>

<script>
    export default {
        
    }
</script>


<script setup>
import { useForm } from "@inertiajs/vue3"


let form =  useForm({
  'first_name': '',
  'last_name': '',
  'email': '',
  'password': '',
});


  
  function submit(){
    form.post('user/create'), {
        preserveScroll: true,
        onSuccess: () => {
          // handle success

          form.reset('email');
          form.reset('password');
        },
        onError: (error) => {
          console.log(`Error: ${err.response.status}`)
        },
        hasError:(err)=>{
          console.log(err);
        }
      }
  }

</script>


<style lang="scss" scoped>

</style>