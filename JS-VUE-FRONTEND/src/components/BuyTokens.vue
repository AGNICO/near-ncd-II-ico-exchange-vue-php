<template>
  <div>
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
          Buy Tokens
        </h1>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div class="px-6 py-4 justify-center animate-pulse inline-flex w-full" v-if="contentLoading">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5" viewBox="0 0 24 24">
                  <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
              </div>
              <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" v-else>
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Token Details
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Offer Supply
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Price in NEAR per 1 Token
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200" v-if="ico">
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-14 w-14">
                            <img class="h-14 w-14 rounded-full" :src="ico.token_spec.icon ? ico.token_spec.icon : default_token_image" alt="" />
                          </div>
                          <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                              {{ ico.token_spec.contract_id }}
                            </div>
                            <div class="text-sm text-gray-500">
                              Name: {{ ico.token_spec.name }}
                            </div>
                            <div class="text-sm text-gray-500">
                              Spec: {{ ico.token_spec.spec }}
                            </div>
                            <div class="text-sm text-gray-500">
                              Total Supply: {{ ico.token_spec.total_supply }} {{ ico.token_spec.symbol }}
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ ico.available_supply ? ico.available_supply : 0 }} {{ ico.token_spec.symbol }}</div>
                        <div class="text-sm animate-pulse inline-flex" v-if="nearPriceLoading">
                          <svg class="animate-spin -ml-1 mr-3 h-5 w-5" viewBox="0 0 24 24">
                            <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                          </svg>
                          Processing...
                        </div>
                        <div class="text-xs text-gray-500" v-else>≈ ${{ (Math.round(ico.available_supply * ico.near_price * near_price * 100) / 100).toFixed(2) }} USD </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" v-if="ico.available_supply > 0">
                          Active
                        </span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" v-else>
                          Sold Out
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          <div class="text-sm text-gray-900 flex items-center">
                            <svg width="16" height="16" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2"><circle cx="16" cy="16" r="16" fill="#111618"></circle><g clip-path="url(#clip0000000003)"><path d="M20.8422 8.84471L17.4978 13.776C17.4501 13.847 17.43 13.9328 17.4411 14.0174C17.4522 14.102 17.4938 14.1798 17.5582 14.2363C17.6225 14.2928 17.7053 14.3243 17.7913 14.3249C17.8772 14.3254 17.9604 14.2951 18.0256 14.2395L21.3178 11.4036C21.3371 11.3865 21.361 11.3753 21.3866 11.3714C21.4122 11.3675 21.4383 11.3711 21.4619 11.3818C21.4855 11.3924 21.5054 11.4096 21.5193 11.4314C21.5331 11.4531 21.5403 11.4783 21.54 11.504V20.3824C21.54 20.4095 21.5316 20.4361 21.5158 20.4583C21.5001 20.4806 21.4779 20.4975 21.4522 20.5068C21.4265 20.516 21.3985 20.5172 21.3721 20.5102C21.3456 20.5031 21.322 20.4882 21.3044 20.4673L11.3533 8.63726C11.1933 8.44956 10.994 8.29873 10.7693 8.19525C10.5446 8.09178 10.2999 8.03815 10.0522 8.03809H9.70444C9.2524 8.03809 8.81887 8.21642 8.49922 8.53386C8.17957 8.8513 8 9.28185 8 9.73078V22.2351C8 22.684 8.17957 23.1145 8.49922 23.432C8.81887 23.7494 9.2524 23.9277 9.70444 23.9277V23.9277C9.99591 23.9278 10.2825 23.8537 10.537 23.7125C10.7914 23.5713 11.0051 23.3677 11.1578 23.1211L14.5022 18.1898C14.5499 18.1188 14.57 18.033 14.5589 17.9484C14.5478 17.8638 14.5062 17.7861 14.4418 17.7295C14.3775 17.673 14.2947 17.6415 14.2087 17.641C14.1228 17.6404 14.0396 17.6707 13.9744 17.7264L10.6822 20.5622C10.6629 20.5794 10.639 20.5906 10.6134 20.5944C10.5878 20.5983 10.5617 20.5947 10.5381 20.5841C10.5145 20.5734 10.4946 20.5562 10.4807 20.5345C10.4669 20.5128 10.4597 20.4875 10.46 20.4618V11.5813C10.46 11.5541 10.4684 11.5276 10.4842 11.5053C10.4999 11.483 10.5221 11.4661 10.5478 11.4568C10.5735 11.4476 10.6015 11.4464 10.6279 11.4534C10.6544 11.4605 10.678 11.4755 10.6956 11.4963L20.6456 23.3286C20.8056 23.5163 21.0049 23.6671 21.2296 23.7706C21.4543 23.874 21.699 23.9277 21.9467 23.9277H22.2944C22.5184 23.9279 22.7401 23.8842 22.947 23.7992C23.154 23.7142 23.342 23.5895 23.5004 23.4324C23.6588 23.2752 23.7844 23.0885 23.8702 22.8831C23.9559 22.6776 24 22.4574 24 22.2351V9.73078C24 9.28185 23.8204 8.8513 23.5008 8.53386C23.1811 8.21642 22.7476 8.03809 22.2956 8.03809C22.0041 8.03801 21.7175 8.11211 21.4631 8.25332C21.2086 8.39453 20.9949 8.59814 20.8422 8.84471V8.84471Z" fill="white"></path></g><defs><clipPath id="clip00033"><rect width="16" height="16" fill="white" transform="translate(8 7.9834)"></rect></clipPath></defs></svg>
                            {{ ico.near_price ? ico.near_price : 0 }} NEAR / {{ ico.token_spec.symbol }}
                          </div>
                          <div class="text-sm animate-pulse inline-flex" v-if="nearPriceLoading">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" viewBox="0 0 24 24">
                              <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                          </div>
                          <div class="text-xs text-gray-500" v-else>≈ ${{ (Math.round(ico.near_price * near_price * 100) / 100).toFixed(2) }} USD / {{ ico.token_spec.symbol }} </div>
                      </td>
                    </tr>
                  </tbody>
                  <tbody class="bg-white divide-y divide-gray-200" v-else>
                    <tr>
                      <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">No Offer Available</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6" v-if="!contentLoading && ico.available_supply">
          <div class="bg-gray-50 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
            Buyer
          </div>
          <div class="p-6 lg:flex lg:items-center lg:justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0 h-14 w-14">
                <img class="h-14 w-14 rounded-full" src="@/assets/user.jpg" alt="" />
              </div>
              <div class="ml-4">
                <div class="flex-1 min-w-0">
                  <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    {{ accountId }}
                  </h2>
                  <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm">
                      <svg width="16" height="16" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2"><circle cx="16" cy="16" r="16" fill="#111618"></circle><g clip-path="url(#clip0000000003)"><path d="M20.8422 8.84471L17.4978 13.776C17.4501 13.847 17.43 13.9328 17.4411 14.0174C17.4522 14.102 17.4938 14.1798 17.5582 14.2363C17.6225 14.2928 17.7053 14.3243 17.7913 14.3249C17.8772 14.3254 17.9604 14.2951 18.0256 14.2395L21.3178 11.4036C21.3371 11.3865 21.361 11.3753 21.3866 11.3714C21.4122 11.3675 21.4383 11.3711 21.4619 11.3818C21.4855 11.3924 21.5054 11.4096 21.5193 11.4314C21.5331 11.4531 21.5403 11.4783 21.54 11.504V20.3824C21.54 20.4095 21.5316 20.4361 21.5158 20.4583C21.5001 20.4806 21.4779 20.4975 21.4522 20.5068C21.4265 20.516 21.3985 20.5172 21.3721 20.5102C21.3456 20.5031 21.322 20.4882 21.3044 20.4673L11.3533 8.63726C11.1933 8.44956 10.994 8.29873 10.7693 8.19525C10.5446 8.09178 10.2999 8.03815 10.0522 8.03809H9.70444C9.2524 8.03809 8.81887 8.21642 8.49922 8.53386C8.17957 8.8513 8 9.28185 8 9.73078V22.2351C8 22.684 8.17957 23.1145 8.49922 23.432C8.81887 23.7494 9.2524 23.9277 9.70444 23.9277V23.9277C9.99591 23.9278 10.2825 23.8537 10.537 23.7125C10.7914 23.5713 11.0051 23.3677 11.1578 23.1211L14.5022 18.1898C14.5499 18.1188 14.57 18.033 14.5589 17.9484C14.5478 17.8638 14.5062 17.7861 14.4418 17.7295C14.3775 17.673 14.2947 17.6415 14.2087 17.641C14.1228 17.6404 14.0396 17.6707 13.9744 17.7264L10.6822 20.5622C10.6629 20.5794 10.639 20.5906 10.6134 20.5944C10.5878 20.5983 10.5617 20.5947 10.5381 20.5841C10.5145 20.5734 10.4946 20.5562 10.4807 20.5345C10.4669 20.5128 10.4597 20.4875 10.46 20.4618V11.5813C10.46 11.5541 10.4684 11.5276 10.4842 11.5053C10.4999 11.483 10.5221 11.4661 10.5478 11.4568C10.5735 11.4476 10.6015 11.4464 10.6279 11.4534C10.6544 11.4605 10.678 11.4755 10.6956 11.4963L20.6456 23.3286C20.8056 23.5163 21.0049 23.6671 21.2296 23.7706C21.4543 23.874 21.699 23.9277 21.9467 23.9277H22.2944C22.5184 23.9279 22.7401 23.8842 22.947 23.7992C23.154 23.7142 23.342 23.5895 23.5004 23.4324C23.6588 23.2752 23.7844 23.0885 23.8702 22.8831C23.9559 22.6776 24 22.4574 24 22.2351V9.73078C24 9.28185 23.8204 8.8513 23.5008 8.53386C23.1811 8.21642 22.7476 8.03809 22.2956 8.03809C22.0041 8.03801 21.7175 8.11211 21.4631 8.25332C21.2086 8.39453 20.9949 8.59814 20.8422 8.84471V8.84471Z" fill="white"></path></g><defs><clipPath id="clip00033"><rect width="16" height="16" fill="white" transform="translate(8 7.9834)"></rect></clipPath></defs></svg>
                      {{ (nearAccount.amount * 1).toFixed(5) }} NEAR
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                      <CurrencyDollarIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                      ≈ ${{ (nearAccount.amount * near_price).toFixed(2) }} USD
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="border-t border-gray-200">
            <dl>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                  <label for="amount" class="block text-sm font-medium text-gray-700">Amount ({{ ico.token_spec.name }})</label>
                  <div class="mt-1 relative flex items-center">
                    <input type="number" min="1" step="1" name="amount" id="amount" v-model="amount" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-5xl font-bold border-gray-300 rounded-md" placeholder="0" aria-describedby="amount-description" />
                    <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5" v-if="ico.token_spec.symbol">
                      <kbd class="inline-flex items-center border border-gray-200 rounded px-2 text-sm font-sans font-medium text-gray-400  bg-white">
                        {{ ico.token_spec.symbol }}
                      </kbd>
                    </div>
                  </div>
                  <div class="inline-flex justify-between w-full mt-2 items-center">
                    <button type="button" @click="amount = maxAvailable" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-full text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      Use Max Available
                    </button>
                    <span class="text-lg font-medium flex items-center">
                      <svg width="16" height="16" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2"><circle cx="16" cy="16" r="16" fill="#111618"></circle><g clip-path="url(#clip0000000003)"><path d="M20.8422 8.84471L17.4978 13.776C17.4501 13.847 17.43 13.9328 17.4411 14.0174C17.4522 14.102 17.4938 14.1798 17.5582 14.2363C17.6225 14.2928 17.7053 14.3243 17.7913 14.3249C17.8772 14.3254 17.9604 14.2951 18.0256 14.2395L21.3178 11.4036C21.3371 11.3865 21.361 11.3753 21.3866 11.3714C21.4122 11.3675 21.4383 11.3711 21.4619 11.3818C21.4855 11.3924 21.5054 11.4096 21.5193 11.4314C21.5331 11.4531 21.5403 11.4783 21.54 11.504V20.3824C21.54 20.4095 21.5316 20.4361 21.5158 20.4583C21.5001 20.4806 21.4779 20.4975 21.4522 20.5068C21.4265 20.516 21.3985 20.5172 21.3721 20.5102C21.3456 20.5031 21.322 20.4882 21.3044 20.4673L11.3533 8.63726C11.1933 8.44956 10.994 8.29873 10.7693 8.19525C10.5446 8.09178 10.2999 8.03815 10.0522 8.03809H9.70444C9.2524 8.03809 8.81887 8.21642 8.49922 8.53386C8.17957 8.8513 8 9.28185 8 9.73078V22.2351C8 22.684 8.17957 23.1145 8.49922 23.432C8.81887 23.7494 9.2524 23.9277 9.70444 23.9277V23.9277C9.99591 23.9278 10.2825 23.8537 10.537 23.7125C10.7914 23.5713 11.0051 23.3677 11.1578 23.1211L14.5022 18.1898C14.5499 18.1188 14.57 18.033 14.5589 17.9484C14.5478 17.8638 14.5062 17.7861 14.4418 17.7295C14.3775 17.673 14.2947 17.6415 14.2087 17.641C14.1228 17.6404 14.0396 17.6707 13.9744 17.7264L10.6822 20.5622C10.6629 20.5794 10.639 20.5906 10.6134 20.5944C10.5878 20.5983 10.5617 20.5947 10.5381 20.5841C10.5145 20.5734 10.4946 20.5562 10.4807 20.5345C10.4669 20.5128 10.4597 20.4875 10.46 20.4618V11.5813C10.46 11.5541 10.4684 11.5276 10.4842 11.5053C10.4999 11.483 10.5221 11.4661 10.5478 11.4568C10.5735 11.4476 10.6015 11.4464 10.6279 11.4534C10.6544 11.4605 10.678 11.4755 10.6956 11.4963L20.6456 23.3286C20.8056 23.5163 21.0049 23.6671 21.2296 23.7706C21.4543 23.874 21.699 23.9277 21.9467 23.9277H22.2944C22.5184 23.9279 22.7401 23.8842 22.947 23.7992C23.154 23.7142 23.342 23.5895 23.5004 23.4324C23.6588 23.2752 23.7844 23.0885 23.8702 22.8831C23.9559 22.6776 24 22.4574 24 22.2351V9.73078C24 9.28185 23.8204 8.8513 23.5008 8.53386C23.1811 8.21642 22.7476 8.03809 22.2956 8.03809C22.0041 8.03801 21.7175 8.11211 21.4631 8.25332C21.2086 8.39453 20.9949 8.59814 20.8422 8.84471V8.84471Z" fill="white"></path></g><defs><clipPath id="clip00033"><rect width="16" height="16" fill="white" transform="translate(8 7.9834)"></rect></clipPath></defs></svg>
                    {{ amount * price ? amount * price : 0 }} NEAR
                    </span>
                    <div class="text-sm font-medium text-gray-400">
                      ≈ ${{ amount * price * near_price ? (amount * price * near_price).toFixed(2) : 0 }} USD
                    </div>
                  </div>
                </dd>
              </div>
              <div class="px-4 py-6 bg-white text-center sm:px-6 border-t border-gray-200">
                <button @click="checkStorage()"
                class="mb-6 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                v-bind:class="{ disabled: amount && amount > 0 && amount%1 == 0 && amount <= maxAvailable ? false : true }"
                >
                <CheckIcon class="-ml-1 mr-2 h-7 w-7" aria-hidden="true" />
                  Confirm Transaction
                </button>
                <router-link to="/">Cancel</router-link>
              </div>
            </dl>
          </div>
        </div>
        <!-- /End replace -->
      </div>
    </main>
  </div>
</template>

<script>
import GatewayService from "../services/gateway.service";

import {
  CurrencyDollarIcon,
  CheckIcon,
} from '@heroicons/vue/solid'

export default {
  name: 'BuyTokens',
  props: ['price'],
  components: {
    CurrencyDollarIcon,
    CheckIcon,
  },
  data() {
    return {
      ico: {
        token_spec: {}
      },
      accountId: null,
      default_token_image: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
      default_buyer_image: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      near_price: null,
      contentLoading: false,
      nearPriceLoading: false,
      amount: null,
      nearAccount: {
          amount: null
      },
    };
  },
  computed: {
    maxAvailable: function () {
      if(this.ico.available_supply * this.ico.near_price <= this.nearAccount.amount) return this.ico.available_supply;
      if(this.ico.available_supply * this.ico.near_price > this.nearAccount.amount) return Math.floor(this.nearAccount.amount/this.ico.near_price);
      return null
    }
  },
  mounted() {
    if(this.$route.query.errorCode) {
      this.$router.push({
        name: 'Error',
        params: {
          error: decodeURIComponent(this.$route.query.errorCode + '. ' + this.$route.query.errorMessage)
        }
      });
    }

    if(this.$route.query.transactionHashes) {
      this.$router.push({
        name: 'Success',
        params: {
          success: decodeURIComponent(this.$route.query.transactionHashes)
        }
      });
    }

    this.accountId = this.$near.user && this.$near.user.accountId ? this.$near.user.accountId : null;
    this.contentLoading = true;
    this.nearPriceLoading = true;

    GatewayService.getNearAccount(this.accountId).then(
      (response) => {
        this.nearAccount.amount = this.$near.nearApi.utils.format.formatNearAmount(response.data.result.amount);
      },
      (error) => {
        console.log(error);
      }
    );

    GatewayService.getOffer(this.price).then(
      (response) => {
        this.ico = response.data;
        this.contentLoading = false;
        this.getNearPrice();
      },
      (error) => {
        this.contentLoading = false;
        console.log(error);
      }
    );
  },
  methods: {
    getNearPrice() {
      GatewayService.getNearPrice().then(
        (response) => {
          this.near_price = response.data.near.usd
          this.nearPriceLoading = false;
        },
        (error) => {
            console.log(error);
            this.nearPriceLoading = false;
        }
      );
    },
    checkStorage() {
      GatewayService.getStorageBalance(this.accountId).then(
        (response) => {
            if(response.data == 'null'){
              this.buyStorage()
              console.log('No Storage');

            } else {
              this.transferTokens()
              console.log('Has Storage');
            }
        },
        (error) => {
          console.log(error);
          this.$router.push({
            name: 'Error',
            params: { error: error }
          });
        }
      );
    },
    buyStorage() {
      this.$near.user.account().functionCall({
          contractId: process.env.VUE_APP_ICO_CONTRACT,
          methodName: "storage_deposit",
          args: {
            account_id: this.accountId,
          },
          attachedDeposit: '1250000000000000000000'
      }).then(() => {
        this.checkStorage()
      }, (error) => {
        console.log(error)
        this.$router.push({
          name: 'Error',
          params: { error: error }
        });
      });
    },
    transferTokens() {
      this.$near.user.account().functionCall({
          contractId: process.env.VUE_APP_EXCHANGE_CONTRACT,
          methodName: "transfer_tokens",
          args: {
            ico_account_id: process.env.VUE_APP_ICO_CONTRACT,
            buyer_account_id: this.accountId,
            near_price: this.ico.near_price,
            tokens: this.amount,
            msg: 'Test transfer',
          },
          gas: 300000000000000/2
      });
    }

  },
}
</script>