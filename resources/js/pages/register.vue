

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
  
            <div class="relative mt-6">
              <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="bg-white px-2 text-gray-500">Or continue with</span>
              </div>
            </div>
          </div>
  
          <div class="mt-6">
            <form action="#" method="POST" class="space-y-6">
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <div class="mt-1">
                  <input id="email" name="email" type="email" autocomplete="email" required class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                </div>
              </div>
  
              <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1">
                  <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                </div>
              </div>
  
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                  <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
  
                <div class="text-sm">
                  <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot your password?</a>
                </div>
              </div>
  
              <div>
                <button type="submit" class="sk-bg-green flex w-full justify-center rounded-md border border-transparent sk-bg-green py-2 px-4 text-sm font-medium text-white shadow-sm  focus:outline-none focus:ring-2 focus:green--500 focus:ring-offset-2">Sign in</button>

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

<style lang="scss" scoped>

</style>