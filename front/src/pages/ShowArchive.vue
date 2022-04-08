<template>
  <q-page>
    <q-linear-progress v-if="loading" indeterminate />
    <div v-else>
      <q-card
        v-for="file in files"
        :key="file.name"
        class="q-ma-md"
      >
        <q-card-section>
          <div class="row">
            <div class="col-md-9 q-pa-md">
              {{ file.name }}
            </div>
            <div class="col-md-3 q-pa-md">
              <q-btn class="full-width" color="primary" label="مشاهده" :href="file.url" target="_blank"/>
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script>
export default {
  name: 'IndexPage',
  data() {
    return {
      loading: false,
      files: [
        '1400-01',
        '1400-06'
      ],
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
      selectedArchive: null,
      selectedGrade: null,
      selectedLesson: null
    }
  },
  created() {
    this.getArchiveFiles()
  },
  methods: {
    getArchiveFiles () {
      this.loading = true
      this.$axios.get('http://www.tikatest.ir/asadikia/api/get_archive_files.php', {
        params: {
          archive: this.$route.params.archive,
          lesson: this.$route.params.lesson,
          grade: this.$route.params.grade
        }
      })
      .then( (resp) => {
        this.loading = false
        this.files = resp.data
      })
      .catch( () => {
        this.loading = false
      })
    }
  }
}
</script>
