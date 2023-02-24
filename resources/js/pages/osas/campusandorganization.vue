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
          <TableTitle class="pt-4"> Campus & Organizations</TableTitle>

          <div>
            <div class="block">
              <div class="border-b border-gray-200">
                <nav class="flex space-x-8 mb-4" aria-label="Tabs ">
                  <AccountLink
                    :href="route('campus.index')"
                    :active="this.$page.component === 'osas/campusindex'"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="-ml-0.5 mr-2 h-5 w-5"
                    >
                      <path
                        d="M11.584 2.376a.75.75 0 01.832 0l9 6a.75.75 0 11-.832 1.248L12 3.901 3.416 9.624a.75.75 0 01-.832-1.248l9-6z"
                      />
                      <path
                        fillRule="evenodd"
                        d="M20.25 10.332v9.918H21a.75.75 0 010 1.5H3a.75.75 0 010-1.5h.75v-9.918a.75.75 0 01.634-.74A49.109 49.109 0 0112 9c2.59 0 5.134.202 7.616.592a.75.75 0 01.634.74zm-7.5 2.418a.75.75 0 00-1.5 0v6.75a.75.75 0 001.5 0v-6.75zm3-.75a.75.75 0 01.75.75v6.75a.75.75 0 01-1.5 0v-6.75a.75.75 0 01.75-.75zM9 12.75a.75.75 0 00-1.5 0v6.75a.75.75 0 001.5 0v-6.75z"
                        clipRule="evenodd"
                      />
                      <path
                        d="M12 7.875a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z"
                      />
                    </svg>

                    <span>Campus</span>
                  </AccountLink>

                  <AccountLink
                    :href="route('organization.index')"
                    :active="this.$page.component === 'osas/organizationindex'"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 24 24"
                      fill="currentColor"
                      class="-ml-0.5 mr-2 h-5 w-5"
                    >
                      <path
                        d="M5.566 4.657A4.505 4.505 0 016.75 4.5h10.5c.41 0 .806.055 1.183.157A3 3 0 0015.75 3h-7.5a3 3 0 00-2.684 1.657zM2.25 12a3 3 0 013-3h13.5a3 3 0 013 3v6a3 3 0 01-3 3H5.25a3 3 0 01-3-3v-6zM5.25 7.5c-.41 0-.806.055-1.184.157A3 3 0 016.75 6h10.5a3 3 0 012.683 1.657A4.505 4.505 0 0018.75 7.5H5.25z"
                      />
                    </svg>

                    <span>Organizations</span>
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
