export const primeVideos = async (mediaElements: HTMLElement[]) => {
  const primingPromises = mediaElements.map(async (el, index) => {
    const video = el.querySelector('video') as HTMLVideoElement | null
    if (!video || index === 0 || video.readyState >= 2) return

    video.muted = true
    video.currentTime = 0.01

    await video.play()
    await new Promise((resolve) => setTimeout(resolve, 50))
    video.pause()

    video.currentTime = 0
  })

  return Promise.allSettled(primingPromises)
}
