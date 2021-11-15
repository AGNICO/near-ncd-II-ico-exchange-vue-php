<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div>
    <div class="bg-indigo-600">
      <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between flex-wrap">
          <div class="w-0 flex-1 flex items-center">
            <span class="flex p-2 rounded-lg bg-indigo-800">
              <SpeakerphoneIcon class="h-6 w-6 text-white" aria-hidden="true" />
            </span>
            <p class="ml-3 font-medium text-white truncate">
              <span class="md:hidden">
                This is DEMO only!
              </span>
              <span class="hidden md:inline">
                This is DEMO only! This app was built only for demonstration purposes during <a href="https://www.near.university/learn/with-our-team" class="underline" target="_blank">Near Certified Developer II</a> course.
              </span>
            </p>
          </div>
          <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
            <a href="https://github.com/AGNICO/near-ncd-II-ico-exchange-vue-php" target="_blank" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50">
              Learn more
            </a>
          </div>
          <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3 md:hidden">
            <div type="button" class="-mr-1 flex p-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
            </div>
          </div>
        </div>
      </div>
    </div>
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center">
              <router-link to="/">
                <img class="block lg:hidden h-8 w-auto" src="@/assets/near_icon_wht.svg" alt="NEAR" />
                <img class="hidden lg:block h-8 w-auto" src="@/assets/near_logo_wht.svg" alt="NEAR" />
              </router-link>
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <router-link v-for="item in navigation" :key="item.name" :to="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</router-link>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6" v-if="accountId">
              <!-- Profile dropdown -->
              <Menu as="div" class="ml-3 relative">
                <div>
                  <MenuButton class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" src="@/assets/user.jpg" alt="" />
                  </MenuButton>
                </div>
                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                      <router-link :to="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</router-link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                      <a href="#" @click.prevent="handleLogout" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Sign Out</a>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
            <div class="ml-4 flex items-center md:ml-6" v-else>
              <button @click="handleLogin" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <LockClosedIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                Sign In
              </button>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">Open main menu</span>
              <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <router-link v-for="item in navigation" :key="item.name" :to="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</router-link>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700" v-if="accountId">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full" src="@/assets/user.jpg" alt="" />
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">{{ accountId }}</div>
              <div class="text-sm font-medium leading-none text-gray-400 py-1">{{ balance }}</div>
            </div>
          </div>
          <div class="mt-3 px-2 space-y-1">
            <router-link :to="item.href" v-for="item in userNavigation" :key="item.name" :href="item.href" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">{{ item.name }}</router-link>
            <a href="#" @click.prevent="handleLogout" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Sign Out</a>
          </div>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700 flex justify-center" v-else>
          <button @click="handleLogin" class="group relative w-1/2 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <LockClosedIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
            Sign In
          </button>
        </div>
      </DisclosurePanel>
    </Disclosure>
  </div>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { MenuIcon, XIcon, LockClosedIcon, SpeakerphoneIcon } from '@heroicons/vue/outline'
/* import {computed} from 'vue'
import {useRoute} from 'vue-router' */

const user = {
  name: 'Tom Cook',
  email: 'tom@example.com',
  imageUrl:'',
}

const userNavigation = [
  { name: 'Your Profile', href: '/profile' },
]

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    MenuIcon,
    XIcon,
    LockClosedIcon,
    SpeakerphoneIcon,
  },
  setup() {
    //const route=useRoute();
    //const path = computed(() =>route.path)

    //console.log(this.$router)
    return {
      user,
      userNavigation,
    }
  },
  data() {
    return {
      accountId: null,
      balance: null,
      navigation: [
        { name: 'Token Offerings', href: '/', current: false },
      ]
    }
  },
  computed: {

  },
  methods: {
    async handleLogin() {
      await this.$near.loginAccount();
    },
    async handleLogout() {
      await this.$near.logoutAccount();
      this.setAccount();
      await this.$router.push({ path: '/' });
      window.location.reload();
    },
    setAccount() {
      this.accountId = this.$near.user && this.$near.user.accountId ? this.$near.user.accountId : null
      this.balance = this.$near.user && this.$near.user.accountId ? this.$near.nearApi.utils.format.formatNearAmount(this.$near.user.balance, 5) + ' NEAR' : null
    },
  },
  mounted() {
    // Just needs to wait for next tick
    setTimeout(() => {
      this.setAccount()
    }, 40)
    setTimeout(() => {
      this.setAccount()
    }, 4000)
  },
  watch: {
    '$route' () {
      if (this.$route.name === 'Home') {
        this.navigation[0].current = true
      }
      else {
        this.navigation[0].current = false
      }
    }
  }
}
</script>