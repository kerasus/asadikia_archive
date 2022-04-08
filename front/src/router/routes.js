import { auth } from './middleware/middleware'

const routes = [
  { path: '/login', name: 'Login', component: () => import('pages/login.vue') },
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    meta: {
      middlewares: [auth]
    },
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      { path: 'save-video', name: 'SaveVideo', component: () => import('pages/SaveVideo.vue') },
      { path: 'archives', name: 'Archives', component: () => import('pages/ArchivesList.vue') },
      { path: 'archives/:archive/:lesson/:grade', name: 'ShowArchive', component: () => import('pages/ShowArchive.vue') }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
