export function createGallery(containerElement: HTMLElement) {
  const galleryMediaContainer = containerElement.querySelector(
    '.gallery-media-container',
  ) as HTMLDivElement
  const mediaItems = Array.from(
    galleryMediaContainer.querySelectorAll('.media-wrapper'),
  )
  const indicatorElement = containerElement.querySelector(
    '.gallery-indicator',
  ) as HTMLDivElement
  const prevButton = containerElement.querySelector(
    '.gallery-prev-button',
  ) as HTMLButtonElement
  const nextButton = containerElement.querySelector(
    '.gallery-next-button',
  ) as HTMLButtonElement

  let currentIndex = 0

  function updateIndicator() {
    const indicator = mediaItems
      .map((_, index) => (index === currentIndex ? '*' : '-'))
      .join('')
    indicatorElement.textContent = indicator
  }

  function showItem(index: number) {
    mediaItems.forEach((item, i) => {
      item.classList.toggle('active', i === index)
    })
    updateIndicator()
  }

  function prevItem() {
    currentIndex = (currentIndex - 1 + mediaItems.length) % mediaItems.length
    showItem(currentIndex)
  }

  function nextItem() {
    currentIndex = (currentIndex + 1) % mediaItems.length
    showItem(currentIndex)
  }

  prevButton.addEventListener('click', prevItem)
  nextButton.addEventListener('click', nextItem)

  showItem(0)
}
