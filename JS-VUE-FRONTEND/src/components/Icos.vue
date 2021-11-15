<template>
  <div>
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
          Token Offerings
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
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Buy</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200" v-if="icos">
                    <tr v-for="ico in icos" :key="ico.near_price">
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
                        <div class="text-sm text-gray-900">{{ ico.available_supply }} {{ ico.token_spec.symbol }}</div>
                        <div class="text-sm animate-pulse inline-flex" v-if="nearPriceLoading">
                          <svg class="animate-spin -ml-1 mr-3 h-5 w-5" viewBox="0 0 24 24">
                            <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                          </svg>
                          Processing...
                        </div>
                        <div class="text-sm text-gray-500" v-else>≈ ${{ (Math.round(ico.available_supply * ico.near_price * near_price * 100) / 100).toFixed(2) }} USD </div>
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
                            {{ ico.near_price }} NEAR / {{ ico.token_spec.symbol }}
                          </div>
                          <div class="text-sm animate-pulse inline-flex" v-if="nearPriceLoading">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" viewBox="0 0 24 24">
                              <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                          </div>
                          <div class="text-sm text-gray-500" v-else>≈ ${{ (Math.round(ico.near_price * near_price * 100) / 100).toFixed(2) }} USD / {{ ico.token_spec.symbol }} </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" @click="!accountId ? handleLogin() : buy(ico.near_price)" v-if="ico.available_supply > 0" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                          <ThumbUpIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                          Buy Tokens
                        </button>
                      </td>
                    </tr>
                  </tbody>
                  <tbody class="bg-white divide-y divide-gray-200" v-else>
                    <tr>
                      <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">No ICOs available</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
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
  ThumbUpIcon,
} from '@heroicons/vue/solid'

export default {
  name: 'Icos',
  data() {
    return {
      icos: null,
      accountId: null,
      default_token_image: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
      near_price: null,
      contentLoading: false,
      nearPriceLoading: false
    };
  },
  setup() {
    return {}
  },
  components: {
    ThumbUpIcon,
  },
  computed: {

  },
  mounted() {
    this.accountId = this.$near.user && this.$near.user.accountId ? this.$near.user.accountId : null;
    this.contentLoading = true;
    this.nearPriceLoading = true;

    GatewayService.getAllOffers(0,20).then(
      (response) => {
        this.icos = response.data;
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
    async handleLogin() {
      await this.$near.loginAccount();
    },
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
    buy(ico_price) {
      this.$router.push({
        name: 'Buy',
        params: { price: ico_price }
      });
    }
  },
}
</script>