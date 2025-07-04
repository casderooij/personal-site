import { primeVideos } from './prime-videos'

export async function initializeStack(stackElement: HTMLElement) {
  const observer = new IntersectionObserver((entries) => {
    const { isIntersecting } = entries[0]

    const topItem = getTopItem()
    if (!topItem) return
    const topItemVideo = getItemVideo(topItem)
    if (!topItemVideo) return

    if (isIntersecting && topItemVideo.paused) {
      topItemVideo.play()
    } else if (!isIntersecting) {
      topItemVideo.pause()
    }
  })
  observer.observe(stackElement)

  const stackItems = Array.from(
    stackElement.querySelectorAll('.stack-item'),
  ) as HTMLElement[]
  const numberOfStackItems = stackItems.length
  const indicatorElement = stackElement.querySelector(
    '.indicator',
  ) as HTMLElement | null

  await primeVideos(stackItems)

  stackItems.forEach((item) => {
    if (item.dataset.index !== '0') {
      item.classList.remove('is-hidden')
    } else {
      const video = getItemVideo(item)
      if (video) {
        video.play()
      }
    }
  })

  function getCurrentStackIndex() {
    return parseInt(stackElement.dataset.index || '0')
  }

  function updateStackIndex() {
    const nextIndex = (getCurrentStackIndex() + 1) % numberOfStackItems
    stackElement.dataset.index = nextIndex.toString()
  }

  function getTopItem() {
    return stackItems.find((item) => parseInt(item.dataset.index || '0') === 0)
  }

  function getItemVideo(item: HTMLElement) {
    return item.querySelector('video')
  }

  function pauseAndHideTopItem() {
    const topItem = getTopItem()

    if (topItem) {
      topItem.classList.add('fading-out')
      topItem.addEventListener(
        'transitionend',
        () => {
          topItem.classList.add('no-transition')

          const video = getItemVideo(topItem)
          if (!video) return
          video.pause()

          shiftItems()
          playTopItem()

          // Allow DOM to update before removing the class
          setTimeout(() => {
            topItem.classList.remove('fading-out')
            topItem.classList.remove('no-transition')
          }, 0)
        },
        { once: true },
      )
    }
  }

  function shiftItems() {
    stackItems.forEach((item) => {
      const itemIndex = parseInt(item.dataset.index || '0')

      const nextIndex =
        (itemIndex - 1 + numberOfStackItems) % numberOfStackItems

      item.dataset.index = nextIndex.toString()
      item.style.setProperty('--stack-i', nextIndex.toString())
    })
  }

  function playTopItem() {
    const topItem = getTopItem()
    if (!topItem) return

    const video = topItem.querySelector('video')
    if (!video) return
    video.play()
  }

  function updateIndicator() {
    if (!indicatorElement) return

    const index = getCurrentStackIndex()
    const indicatorString = Array.from({ length: stackItems.length }, (_, i) =>
      i === index ? '#' : '-',
    ).join('')

    indicatorElement.textContent = indicatorString
  }

  stackElement.addEventListener('click', () => {
    updateStackIndex()
    pauseAndHideTopItem()
    updateIndicator()
  })
}
