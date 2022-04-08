<template>
  <q-item
    clickable
    :to="{ name: item.routeName }"
  >
    <q-item-section
      v-if="item.icon"
      avatar
    >
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ item.title }}</q-item-label>
      <q-item-label v-if="item.caption" caption>{{ caption }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'EssentialLink',
  props: {
    item: {
      type: Object,
      default: () => {
        return {
          icon: '',
          title: '',
          caption: '',
          routeName: ''
        }
      },
      required: true
    },

    caption: {
      type: String,
      default: ''
    },

    link: {
      type: String,
      default: '#'
    },

    icon: {
      type: String,
      default: ''
    }
  }
})
</script>
