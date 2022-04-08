<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          آموزشگاه علمی اسدی کیا
        </q-toolbar-title>

        <div>
          <q-img
            :src="appRoot+'/icons/asadiia_logo.png'"
            spinner-color="white"
            style="width: 50px"
          />
        </div>
      </q-toolbar>
    </q-header>
    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label
          header
        >
          آموزشگاه علمی اسدی کیا
        </q-item-label>

        <EssentialLink
          v-for="item in items"
          :key="item.routeName"
          :item="item"
        />

        <q-item clickable @click="logout">
          <q-item-section>
            <q-item-label>
              خروج
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable>
          <q-item-section>
            <q-item-label caption>
              نسخه:
              {{ version }}
            </q-item-label>
          </q-item-section>
        </q-item>

      </q-list>
    </q-drawer>
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

export default {
  name: 'MainLayout',
  components: {
    EssentialLink
  },
  data() {
    return {
      version: '1.0.0',
      leftDrawerOpen: false,
      appRoot: 'http://www.tikatest.ir/asadikia',
      items: [
        {
          title: 'ثبت ویدیو',
          icon: 'school',
          routeName: 'SaveVideo'
        },
        {
          title: 'آرشیوها',
          icon: 'chat',
          routeName: 'Archives'
        },
        // {
        //   title: 'Github',
        //   caption: 'github.com/quasarframework',
        //   icon: 'code',
        //   link: 'https://github.com/quasarframework'
        // },
        // {
        //   title: 'Discord Chat Channel',
        //   caption: 'chat.quasar.dev',
        //   icon: 'chat',
        //   link: 'https://chat.quasar.dev'
        // },
        // {
        //   title: 'Forum',
        //   caption: 'forum.quasar.dev',
        //   icon: 'record_voice_over',
        //   link: 'https://forum.quasar.dev'
        // },
        // {
        //   title: 'Twitter',
        //   caption: '@quasarframework',
        //   icon: 'rss_feed',
        //   link: 'https://twitter.quasar.dev'
        // },
        // {
        //   title: 'Facebook',
        //   caption: '@QuasarFramework',
        //   icon: 'public',
        //   link: 'https://facebook.quasar.dev'
        // },
        // {
        //   title: 'Quasar Awesome',
        //   caption: 'Community Quasar projects',
        //   icon: 'favorite',
        //   link: 'https://awesome.quasar.dev'
        // }
      ]
    }
  },
  methods: {
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    },
    logout () {
      window.localStorage.setItem('authenticated', '0')
      this.$router.push({name: 'Login'})
    }
  }
}
</script>
