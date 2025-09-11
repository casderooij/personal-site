import { renderVideoSphere } from './videoSphere'

document.addEventListener('DOMContentLoaded', () => {
  renderVideoSphere()

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
