import gsap from 'gsap'
import { ScrollToPlugin } from 'gsap/ScrollToPlugin'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { createGallery } from './gallery'
import { globalState } from './globalState'
import { lazyVideoObserver } from './lazyVideoObserver'
import { renderVideoSphere } from './videoSphere'

gsap.registerPlugin(ScrollToPlugin, ScrollTrigger)

document.addEventListener('DOMContentLoaded', () => {
  const sphereContainerElement = document.getElementById('sphere-container')
  renderVideoSphere(sphereContainerElement!)

  const mainElement = document.querySelector('main')

  const mql = window.matchMedia('(max-width: 700px)')

  function handleScreenChange(event: MediaQueryListEvent | MediaQueryList) {
    globalState.screen = event.matches ? 'mobile' : 'desktop'
    globalState.sphereRadius = event.matches ? 3 : 4
    setupScrollTrigger()
  }

  handleScreenChange(mql)
  mql.addEventListener('change', handleScreenChange)

  const scrollDownToMainButton = document.getElementById(
    'scroll-down-to-main-button',
  )

  if (scrollDownToMainButton && mainElement) {
    scrollDownToMainButton.addEventListener('click', () =>
      gsap.to(window, {
        duration: 1,
        scrollTo: mainElement,
        ease: 'power2.inOut',
      }),
    )
  }

  function showHideSelectedVideoContainer(isIntersecting: boolean) {
    gsap.to(['#selected-video-container', '#scroll-down-to-main-button'], {
      opacity: isIntersecting ? 0 : 1,
      duration: 0.4,
      ease: 'power2.inOut',
    })
  }

  function setupScrollTrigger() {
    ScrollTrigger.getAll().forEach((trigger) => trigger.kill())

    ScrollTrigger.create({
      trigger: mainElement,
      start: () => `top ${sphereContainerElement!.offsetHeight}px`,
      end: () => `bottom 100px`,

      onEnter: () => {
        showHideSelectedVideoContainer(true)
        globalState.isMainElementIntersecting = true
      },
      onLeave: () => {
        showHideSelectedVideoContainer(false)
        globalState.isMainElementIntersecting = false
      },

      onEnterBack: () => {
        showHideSelectedVideoContainer(true)
        globalState.isMainElementIntersecting = true
      },
      onLeaveBack: () => {
        showHideSelectedVideoContainer(false)
        globalState.isMainElementIntersecting = false
      },
    })
  }

  setupScrollTrigger()
  lazyVideoObserver()

  const galleryElements = document.querySelectorAll(
    '.gallery',
  ) as NodeListOf<HTMLElement>
  galleryElements.forEach(createGallery)
})
