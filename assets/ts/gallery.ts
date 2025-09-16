import gsap from 'gsap'

export function createGallery(containerElement: HTMLElement) {
  const galleryMediaContainerElement = containerElement.querySelector(
    '.gallery-media-container',
  ) as HTMLDivElement
  const indicatorElement = containerElement.querySelector(
    '.gallery-indicator',
  ) as HTMLDivElement

  const mediaItems = Array.from(
    galleryMediaContainerElement.querySelectorAll('.media-wrapper'),
  ) as HTMLDivElement[]

  let currentIndex = 0

  mediaItems.forEach((item, index) => {
    if (index !== 0) {
      gsap.set(item, { opacity: 0 })
    }
  })

  const DURATION = 0.3

  function updateIndicator() {
    const indicator = mediaItems
      .map((_, index) => (index === currentIndex ? '*' : '-'))
      .join('')
    indicatorElement.textContent = indicator
  }

  function shiftItems() {
    currentIndex = (currentIndex + 1) % mediaItems.length
    updateIndicator()

    const bottomElement = mediaItems.shift()!
    mediaItems.push(bottomElement)

    gsap.fromTo(
      bottomElement,
      { opacity: 1 },
      {
        opacity: 0,
        duration: DURATION,
        onComplete: () => {
          galleryMediaContainerElement.appendChild(bottomElement)
        },
      },
    )

    gsap.fromTo(
      mediaItems[0],
      { opacity: 0 },
      {
        opacity: 1,
        duration: DURATION,
        delay: DURATION / 2,
      },
    )
  }

  return shiftItems
}
