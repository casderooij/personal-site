import { globalState } from './globalState'
import { renderVideoSphere } from './videoSphere'
import gsap from 'gsap'
import { ScrollToPlugin } from 'gsap/ScrollToPlugin'

gsap.registerPlugin(ScrollToPlugin)

document.addEventListener('DOMContentLoaded', () => {
  renderVideoSphere()

  const mql = window.matchMedia('(max-width: 700px)')

  function handleScreenChange(event: MediaQueryListEvent | MediaQueryList) {
    globalState.screen = event.matches ? 'mobile' : 'desktop'
  }

  handleScreenChange(mql)
  mql.addEventListener('change', handleScreenChange)

  const scrollDownToMainButton = document.getElementById(
    'scroll-down-to-main-button',
  )
  const mainElement = document.querySelector('main')
  if (scrollDownToMainButton && mainElement) {
    scrollDownToMainButton.addEventListener('click', () =>
      gsap.to(window, {
        duration: 1,
        scrollTo: mainElement,
        ease: 'power2.inOut',
      }),
    )
  }
})
