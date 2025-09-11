import { proxy } from 'valtio/vanilla'

export const globalState = proxy<{ screen: 'mobile' | 'desktop' }>({
  screen: 'mobile',
})
