export function lazyVideoObserver() {
  const videoIntersectionObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const videoElement = entry.target as HTMLVideoElement
          const src = videoElement.getAttribute('data-src')
          if (src) {
            videoElement.src = src
            videoIntersectionObserver.unobserve(videoElement)
          }
        }
      })
    },
    { rootMargin: '50px 0px' },
  )

  const videoElements = document.querySelectorAll('video[data-src]')
  videoElements.forEach((videoElement) => {
    videoIntersectionObserver.observe(videoElement)
  })
}
