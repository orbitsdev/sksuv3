<script setup></script>

<template>
  <adminlayout>
    <template v-slot:search>
      <slot name="search"> </slot>
    </template>
    <div
      class="bg-white rounded-xl shadow-xl mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8"
    >
      <div>
        <div class="block"> 
          <TableTitle class="pt-4"> Accounts & Roles </TableTitle>


          <div>
            <div class="block">
              <div class="border-b border-gray-200">
                <nav class="flex space-x-8 mb-4" aria-label="Tabs ">
                  <AccountLink
                    :href="route('account.userpassword.index')"
                    :active="this.$page.component === 'osas/accountpasswordindex'"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="-ml-0.5 mr-2 h-5 w-5"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                        clip-rule="evenodd"
                      />
                    </svg>

                    <span>Account Password</span>
                  </AccountLink>

                  <AccountLink
                    :href="route('campusadviser.index')"
                    :active="this.$page.component === 'osas/campusadviserindex'"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="-ml-0.5 mr-2 h-5 w-5"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                        clip-rule="evenodd"
                      />
                    </svg>

                    <span>Campus Advisers</span>
                  </AccountLink>
                  <AccountLink
                    :href="route('campusdirector.index')"
                    :active="this.$page.component === 'osas/campusdirectorindex'"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="-ml-0.5 mr-2 h-5 w-5"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                        clip-rule="evenodd"
                      />
                    </svg>

                    <span>Campus Directors </span>
                  </AccountLink>
                  <AccountLink
                    :href="route('vpa.index')"
                    :active="this.$page.component === 'osas/vpaindex'"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="-ml-0.5 mr-2 h-5 w-5"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                        clip-rule="evenodd"
                      />
                    </svg>

                    <span>Vpaa </span>
                  </AccountLink>
                </nav>

                <main>
                  <slot> </slot>
                </main>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </adminlayout>
</template>

<script>
import adminlayout from "../../layouts/adminlayout.vue";
export default {
  components: {
    adminlayout,
  },
};
</script>

<style lang="scss" scoped></style>
