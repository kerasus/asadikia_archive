<template>
  <q-page>
    <q-card class="q-ma-md">
      <q-card-section>
        <q-select v-model="selectedGrade" :options="grades" label="پایه" />
        <q-select v-model="selectedLesson" :options="lessons" label="درس" />
        <q-input v-model="fileId" label="کد فایل" />
      </q-card-section>
      <q-card-actions>
        <q-btn class="full-width" color="primary" label="ثبت" @click="sendData" :loading="loading" :disable="loading" />
      </q-card-actions>
    </q-card>
    <q-card v-if="result.enable" class="q-ma-md">
      <q-card-section>
        <q-input v-model="result.name" label="نام فایل" />
        <q-input v-model="result.mime_type" label="نوع فایل" />
        <q-input v-model="result.url" label="آدرس فایل" />
      </q-card-section>
      <q-card-actions>
        <q-btn class="full-width" color="primary" label="کپی کردن آدرس فایل" @click="copyUrl"/>
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script>
import { copyToClipboard } from 'quasar'
export default {
  name: 'IndexPage',
  data() {
    return {
      result: {
        enable: false,
        name: '',
        mime_type: '',
        url: ''
      },
      loading: false,
      lessons: [
        {
          label: 'ریاضی',
          value: 'math'
        },
        {
          label: 'علوم',
          value: 'science'
        },
      ],
      grades: [
        {
          label: 'پنجم',
          value: '5'
        },
        {
          label: 'ششم',
          value: '6'
        },
        {
          label: 'هفتم',
          value: '7'
        },
        {
          label: 'هشتم',
          value: '8'
        },
        {
          label: 'نهم',
          value: '9'
        },
        {
          label: 'دهم',
          value: '10'
        },
        {
          label: 'یازدهم',
          value: '11'
        },
        {
          label: 'دوازدهم',
          value: '12'
        },
      ],
      fileId: null,
      selectedGrade: null,
      selectedLesson: null
    }
  },
  methods: {
    validate () {
      if (!this.fileId || this.selectedLesson.value || this.selectedGrade.value) {
        this.$q.notify({
          type: 'info',
          message: 'تمام موارد را انتخاب کنید.'
        })

        return false
      }

      return true
    },
    sendData () {
      if (!this.validate()) {
        return
      }
      // http://www.tikatest.ir/asadikia/api
      // /asadikia/archive/api
      // console.log({file_id: this.fileId, lesson: this.selectedLesson, grade: this.selectedGrade})
      this.result.enable = false
      this.loading = true
      this.$axios.get('http://www.tikatest.ir/asadikia/api/save_file.php', {
        params: {
          file_id: this.fileId,
          lesson: this.selectedLesson.value,
          grade: this.selectedGrade.value
        }
      })
      .then( (resp) => {
        this.loading = false
        this.result = resp.data
        this.result.enable = true
        this.$q.notify({
          type: 'info',
          message: 'ذخیره فایل با موفقیت انجام شد.'
        })
        // console.log('resp', resp.data.url)
      })
      .catch( () => {
        this.loading = false
        this.result.enable = false
        this.$q.notify({
          type: 'info',
          message: 'مشکلی در ذخیره فایل رخ داده است.'
        })
      })
    },
    copyUrl () {
      copyToClipboard(this.result.url)
        .then(() => {
          this.$q.notify({
            type: 'info',
            message: 'آدرس فایل کپی شد.'
          })
        })
        .catch(() => {
          // fail
        })
    }
  }
}
</script>
