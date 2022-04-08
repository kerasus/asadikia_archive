/**
 * Auth middleware example.
 */
export default function auth (/* { to, from, next, store } */ { next, store }) {
  if (window.localStorage.getItem('authenticated') !== '1') {
    return next({ name: 'Login' })
  }
  return next()
}
