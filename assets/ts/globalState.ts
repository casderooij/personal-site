import { proxy } from 'valtio/vanilla'

export const globalState = proxy<{
  screen: 'mobile' | 'desktop'
  sphereRadius: number
  isMainElementIntersecting: boolean
}>({
  screen: 'mobile',
  sphereRadius: 3,
  isMainElementIntersecting: false,
})
