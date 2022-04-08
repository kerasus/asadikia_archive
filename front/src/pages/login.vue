<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>

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

    <q-page-container>
      <q-page class="flex flex-center">
        <q-card class="q-ma-md">
          <q-linear-progress v-if="loading" indeterminate />
          <q-card-section>
            <q-input v-model="user" label="نام کاربری" />
            <q-input v-model="pass" label="کلمه عبور" type="password"/>
          </q-card-section>
          <q-card-actions>
            <q-btn class="full-width" color="primary" label="ورود" :loading="loading" :disable="loading" @click="login"/>
          </q-card-actions>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  name: 'LoginPage',
  data() {
    return {
      loading: false,
      user: null,
      pass: null
    }
  },
  methods: {
    validate () {
      if (!this.user || !this.pass) {
        this.$q.notify({
          type: 'info',
          message: 'تمام موارد را پر کنید.'
        })

        return false
      }

      return true
    },
    login () {
      if (!this.validate()) {
        return
      }
      this.loading = true
      this.$axios.get('http://www.tikatest.ir/asadikia/api/auth.php', {
        params: {
          user: this.user,
          pass: this.pass
        }
      })
      .then( (resp) => {
        this.loading = false
        if (resp.data.authenticated) {
          window.localStorage.setItem('authenticated', '1')
          window.localStorage.setItem('role', resp.data.role)
          this.$q.notify({
            type: 'info',
            message: 'خوش آمدید'
          })
          this.$router.push({name: 'Archives'})
        } else {
          this.$q.notify({
            type: 'info',
            message: 'نام کاربری و یا رمز عبور اشتباه است.'
          })
        }
      })
      .catch( () => {
        this.loading = false
        this.result.enable = false
        this.$q.notify({
          type: 'info',
          message: 'مشکلی رخ داده است.'
        })
      })
    }
  }
}
</script>
