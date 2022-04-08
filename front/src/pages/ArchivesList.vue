<template>
  <q-page>
    <q-linear-progress v-if="loading" indeterminate />
    <div v-else>
      <q-card
        v-for="archive in archives"
        :key="archive"
        class="q-ma-md"
      >
        <q-card-section>
          <div class="row">
            <div class="col-md-3 q-pa-md">
              آرشیو:
              {{ archive }}
            </div>
            <div class="col-md-3 q-pa-md">
              <q-select v-model="selectedGrade" :options="grades" label="پایه" />
            </div>
            <div class="col-md-3 q-pa-md">
              <q-select v-model="selectedLesson" :options="lessons" label="درس" />
            </div>
            <div class="col-md-3 q-pa-md">
              <q-btn class="full-width" color="primary" label="مشاهده" @click="showArchive(archive)"/>
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
      archives: [
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
    this.getArchives()
  },
  methods: {
    getArchives () {
      this.loading = true
      this.$axios.get('http://www.tikatest.ir/asadikia/api/get_archives.php')
      .then( (resp) => {
        this.loading = false
        this.archives = resp.data
      })
      .catch( () => {
        this.loading = false
      })
    },
    showArchive (archive) {
      this.$router.push({
        name: 'ShowArchive',
        params: {
          archive: archive,
          lesson: this.selectedLesson.value,
          grade: this.selectedGrade.value
        }
      })
    }
  }
}
</script>
