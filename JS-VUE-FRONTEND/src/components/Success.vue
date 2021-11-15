<template>
  <div>
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
          Success!
        </h1>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div class="shadow overflow-hidden sm:rounded-lg bg-white">
          <div class="bg-green-50 p-4 border-b border-gray-200 ">
            <div class="flex">
              <div class="flex-shrink-0">
                <CheckIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">
                  Transaction is successfully completed.
                </h3>
              </div>
            </div>
          </div>
          <div class="bg-white p-4 ">
            View transaction in Eplorer: <a :href="'https://explorer.testnet.near.org/transactions/'+success" target="_blank" class="underline">{{ success }}</a>
          </div>
          <div class="py-6 text-center border-t border-gray-200">
            <router-link to="/" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <ChevronDoubleRightIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
              Buy more
            </router-link>
          </div>
        </div>
        <!-- /End replace -->
      </div>
    </main>
  </div>
</template>

<script>
import {
  CheckIcon,
  ChevronDoubleRightIcon } from '@heroicons/vue/solid'

export default {
  name: 'Success',
  props: [
    'success'
  ],
  components: {
    CheckIcon,
    ChevronDoubleRightIcon
  },
  computed: {

  },
  methods: {

  },
}
</script>