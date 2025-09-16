import gsap from 'gsap'

export function createGallery(containerElement: HTMLElement) {
  const mediaItems = Array.from(
    containerElement.querySelectorAll('.media-wrapper'),
  ) as HTMLDivElement[]

  mediaItems.forEach((item, index) => {
    if (index !== 0) {
      gsap.set(item, { opacity: 0 })
    }
  })

  const DURATION = 0.3

  function shiftItems() {
    const bottomElement = mediaItems.shift()! // Take the first element
    mediaItems.push(bottomElement) // Move it to the end of the array

    gsap.fromTo(
      bottomElement,
      { opacity: 1 },
      {
        opacity: 0,
        duration: DURATION,
        onComplete: () => {
          containerElement.appendChild(bottomElement) // Move the element in the DOM
        },
      },
    )

    gsap.fromTo(
      mediaItems[0], // The new first element
      { opacity: 0 },
      {
        opacity: 1,
        duration: DURATION,
        delay: DURATION / 2, // Delay for overlapping
      },
    )
  }

  return shiftItems
}
