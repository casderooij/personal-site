type StackItem = HTMLElement

const getStackIndex = (el: HTMLElement): number =>
  parseInt(el.style.getPropertyValue('--stack-i'))

const isTopStackItem = (el: HTMLElement): boolean => getStackIndex(el) === 0

const primeVideos = async (mediaElements: StackItem[]) => {
  // Hide all non-top stack-items before priming
  mediaElements.forEach((el) => {
    if (!isTopStackItem(el)) {
      el.classList.add('is-hidden')
    }
  })

  const primingPromises = mediaElements.map(async (el) => {
    const video = el.querySelector('video') as HTMLVideoElement | null
    if (!video || isTopStackItem(el) || video.readyState >= 2) return
    video.muted = true
    try {
      video.currentTime = 0.01
    } catch {}
    try {
      await video.play()
      await new Promise((resolve) => setTimeout(resolve, 50))
      video.pause()
      try {
        video.currentTime = 0
      } catch {}
    } catch {}
  })

  await Promise.all(primingPromises)

  // Show all stack-items after priming
  mediaElements.forEach((el) => {
    if (!isTopStackItem(el)) {
      el.classList.remove('is-hidden')
    }
  })
}

const setTopStackItem = (
  mediaElements: StackItem[],
  indicator: HTMLElement,
): StackItem | null => {
  // Pause all videos
  mediaElements.forEach((el) => {
    const video = el.querySelector('video') as HTMLVideoElement | null
    if (video) video.pause()
    el.classList.remove('is-top')
  })

  const topEl = mediaElements.find(isTopStackItem) || null
  if (topEl) {
    topEl.classList.add('is-top')
    const video = topEl.querySelector('video') as HTMLVideoElement | null
    if (video) {
      setTimeout(() => {
        video.play().catch(() => {})
      }, 100)
    }
    const originalIndex = parseInt(topEl.dataset.originalIndex || '0')

    const indicatorString = Array.from({ length: mediaElements.length }, (_, i) => i === originalIndex ? '#' : '-').join('')
    indicator.textContent = indicatorString
  }
  return topEl
}

const handleStackClick = (
  event: MouseEvent,
  mediaElements: StackItem[],
  currentTopElement: StackItem | null,
  updateTop: () => void,
) => {
  const target = event.target as HTMLElement
  if (!target) return
  const clickedElement = target.closest('.stack-item') as StackItem | null
  if (!clickedElement || clickedElement !== currentTopElement) return

  const clickedIndex = getStackIndex(clickedElement)
  const totalItems = mediaElements.length

  // Pause the current top video if it's a video
  const videoInsideCurrentTop = currentTopElement?.querySelector('video') as HTMLVideoElement | null
  if (videoInsideCurrentTop) videoInsideCurrentTop.pause()

  clickedElement.classList.add('fading-out')
  clickedElement.addEventListener(
    'transitionend',
    () => {
      clickedElement.classList.add('no-transition')
      // Move the clicked element to the bottom and shift others up
      mediaElements.forEach((el) => {
        const currentIndex = getStackIndex(el)
        if (currentIndex === clickedIndex) {
          el.style.setProperty('--stack-i', (totalItems - 1).toString())
        } else {
          el.style.setProperty('--stack-i', (currentIndex - 1).toString())
        }
      })
      updateTop()
      // Allow DOM to update before removing the class
      setTimeout(() => {
        clickedElement.classList.remove('fading-out')
        clickedElement.classList.remove('no-transition')
      }, 0)
    },
    { once: true },
  )
}

export default async function initProjectStack() {
  const stack = document.querySelector('.project-thumbnails-stack')
  const indicator = document.getElementById('project-stack-indicator')
  if (!stack || !indicator) return

  const mediaElements = Array.from(
    stack.querySelectorAll('.stack-item'),
  ) as StackItem[]

  // Prime videos before showing stack
  await primeVideos(mediaElements)

  let currentTopElement: StackItem | null = null
  const updateTop = () => {
    currentTopElement = setTopStackItem(mediaElements, indicator)
  }

  // Initial update
  updateTop()

  stack.addEventListener('click', (event) => {
    handleStackClick(event as MouseEvent, mediaElements, currentTopElement, updateTop)
  })
}
