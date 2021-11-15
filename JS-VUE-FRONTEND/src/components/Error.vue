<template>
  <div>
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
          Oops! Something went wrong.
        </h1>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div class="shadow overflow-hidden sm:rounded-lg bg-white">
          <div class="bg-red-50 p-4 border-b border-gray-200 ">
            <div class="flex">
              <div class="flex-shrink-0">
                <ExclamationIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                  There was a problem with your transaction.
                </h3>
              </div>
            </div>
          </div>
          <div class="bg-white p-4 ">
            {{ error }}
          </div>
          <div class="py-6 text-center border-t border-gray-200">
            <router-link to="/" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <ChevronDoubleRightIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
              Try again
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
  ExclamationIcon,
  ChevronDoubleRightIcon } from '@heroicons/vue/solid'

export default {
  name: 'Error',
  props: [
    'error'
  ],
  components: {
    ExclamationIcon,
    ChevronDoubleRightIcon
  },
  computed: {

  },
  methods: {

  },
}
</script>