<template>
  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img class="mx-auto h-12 w-auto" src="/assets/sksu1.png" alt="Your Company" />
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
        Sign in to your account
      </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700"
              >Email address</label
            > 

            <div class="mt-1">
              <Authfield1 type="email" autocomplete="email" v-model="form.email" />
              <!-- <input id="email" v-model="form.email" name="email" type="email" autocomplete="email"  class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"> -->
            </div>
            <p class="text-red-700 text-sm" v-if="$page.props.errors.email">
              {{ $page.props.errors.email }}
            </p>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700"
              >Password</label
            >
            <div class="mt-1">
              <Authfield v-model="form.password" />
              <!-- <input  v-model="form.password" id="password" name="password" type="password" autocomplete="current-password"  class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"> -->
            </div>
            <p class="text-red-700 text-sm" v-if="$page.props.errors.password">
              {{ $page.props.errors.password }}
            </p>
          </div>

          <div>
            <SkButton type="submit" :processing="form.processing" > Signin </SkButton>
          </div>
        </form>

        <div class="mt-4">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="bg-white px-2 text-gray-500">Or </span>
            </div>
          </div>

          <div class="mt-4">
            <div>
              <a
                href="/authorize/google/redirect"
                class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50"
              >
                <img src="/assets/google.svg" class="w-5 h-5 mr-2" alt="" /> Continue with
                with Google
              </a>
            </div>
            <div class="mt-2 text-sm flex items-center justify-center">
              <SksuLink
                href="/register"
                preserve-scroll
                class="font-medium text-indigo-600 hover:text-indigo-500 underline"
              >
                Dont have an acount? Signup
              </SksuLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <SkDialog
    :isOpen="hasWarning != null"
    :dialogClass="'shadow-xl rounded-lg'"
    :contentClass="'bg-red-500'"
  >
    {{ hasWarning }}
  </SkDialog>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
const hasWarning = ref(null);
const showPassword = ref(false);

let form = useForm({
  email: "@gmail.com",
  password: "@password2!!",
});

function submit() {
  form.post("user/login"),
    {
      preserveScroll: true,
      onSuccess: () => {
        // handle success

        form.reset("email");
        form.reset("password");
      },
      onError: (error) => {
        console.log(`Error: ${err.response.status}`);
      },
      hasError: (err) => {
        console.log(err);
      },
    };
}
</script>

<style lang="scss" scoped></style>
