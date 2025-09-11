import { globalState } from './globalState'
import { renderVideoSphere } from './videoSphere'

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
      mainElement.scrollIntoView({ behavior: 'smooth' }),
    )
  }
})
