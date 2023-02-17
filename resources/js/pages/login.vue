


<template>


<div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img class="mx-auto h-12 w-auto" src="/assets/sksu1.png" alt="Your Company">
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
     
    </div>
  
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" action="#" method="POST">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <div class="mt-1">
              <input id="email" name="email" type="email" autocomplete="email" required class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
            </div>
          </div>
  
          <div>
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
  
        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="bg-white px-2 text-gray-500">Or </span>
            </div>
          </div>
  
          <div class="mt-6 ">
            <div>
              <button href="#" class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50">
                <img src="/assets/google.svg"  class="w-5    h-5 mr-2 " alt=""> Continue with with Google                
              </button>
            </div>
  
            
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <SkDialog  :isOpen="hasWarning" 
  
  :dialogClass="'shadow-xl rounded-lg'"
  :contentClass="'bg-red-500' ">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat, minima? Laborum, ab. Asperiores fuga ratione architecto est possimus nesciunt enim necessitatibus eligendi at iusto hic, porro explicabo odit earum non.
    </SkDialog>
  
</template>

<script>

    export default {
        data() {
            return {
                hasWarning: false
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>