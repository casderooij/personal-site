export default function initProjectStack() {
  const stack = document.querySelector('.project-thumbnails-stack')
  const indicator = document.getElementById('project-stack-indicator')

  if (stack && indicator) {
    const mediaElements = Array.from(
      stack.querySelectorAll('.stack-item'),
    ) as HTMLElement[]
    const totalItems = mediaElements.length

    let currentTopElement: HTMLElement | null = null

    // Prime all videos except the top one to avoid iOS Safari glitches
    const primeVideos = () => {
      mediaElements.forEach((el, idx) => {
        const video = el.querySelector('video') as HTMLVideoElement | null
        if (!video) return
        // Skip the top element (stack-i: 0)
        const stackIndex = parseInt(el.style.getPropertyValue('--stack-i'))
        if (stackIndex === 0) return
        // Only prime if not already ready
        if (video.readyState >= 2) return
        video.muted = true
        try {
          video.currentTime = 0.01
        } catch (e) {
          // Some browsers may throw if not enough data
        }
        const playPromise = video.play()
        if (playPromise !== undefined) {
          playPromise.then(() => {
            setTimeout(() => {
              video.pause()
              try {
                video.currentTime = 0
              } catch (e) {}
            }, 50)
          }).catch(() => {})
        } else {
          // Fallback: pause after short delay
          setTimeout(() => {
            video.pause()
            try {
              video.currentTime = 0
            } catch (e) {}
          }, 50)
        }
      })
    }

    // Prime videos before first update
    primeVideos()

    const updateTopElement = () => {
      // Pause all videos first
      mediaElements.forEach((el) => {
        const videoInside = el.querySelector('video')
        if (videoInside) {
          videoInside.pause()
        }
      })

      if (currentTopElement) {
        currentTopElement.classList.remove('is-top')
      }

      currentTopElement = mediaElements.find(
        (el) => parseInt(el.style.getPropertyValue('--stack-i')) === 0,
      ) as HTMLElement | null

      if (currentTopElement) {
        currentTopElement.classList.add('is-top')
        const videoInside = currentTopElement.querySelector('video')
        if (videoInside) {
          console.log('Video found for top element.')
          

          // Add a small delay for initial playback
          setTimeout(() => {
            const playPromise = videoInside.play()
            if (playPromise !== undefined) {
              playPromise
                .then(() => {
                  console.log('Initial video playback started successfully.')
                })
                .catch((error) => {
                  console.error('Initial video playback failed:', error)
                })
            }
          }, 100) // 100ms delay for initial playback
        }
        const originalIndex = parseInt(
          currentTopElement.dataset.originalIndex || '0',
        )
        indicator.textContent = `${originalIndex + 1} / ${totalItems}`
      }
    }

    // Initial update
    updateTopElement()

    stack.addEventListener('click', (event) => {
      const target = event.target as HTMLElement
      if (!target) return

      const clickedElement = target.closest('.stack-item') as HTMLElement | null
      if (!clickedElement) return

      const clickedIndex = parseInt(
        clickedElement.style.getPropertyValue('--stack-i'),
      )

      // Only proceed if the clicked element is the one on top
      if (clickedElement !== currentTopElement) {
        return
      }

      // Pause the current top video if it's a video
      const videoInsideCurrentTop = currentTopElement?.querySelector('video')
      if (videoInsideCurrentTop) {
        videoInsideCurrentTop.pause()
      }

      clickedElement.classList.add('fading-out')

      clickedElement.addEventListener(
        'transitionend',
        () => {
          clickedElement.classList.add('no-transition')

          // Move the clicked element to the bottom and shift others up
          mediaElements.forEach((el) => {
            const currentIndex = parseInt(
              el.style.getPropertyValue('--stack-i'),
            )
            if (currentIndex === clickedIndex) {
              // Move to the bottom
              el.style.setProperty('--stack-i', (totalItems - 1).toString())
            } else {
              // Shift up
              el.style.setProperty('--stack-i', (currentIndex - 1).toString())
            }
          })

          // Update the top element and play/pause videos
          updateTopElement()

          // Re-introduce a small delay for video playback after the new top element is set
          const newTopVideo = currentTopElement?.querySelector('video')
          if (newTopVideo) {
            setTimeout(() => {
              const playPromise = newTopVideo.play()
              if (playPromise !== undefined) {
                playPromise
                  .then(() => {
                    console.log(
                      'Video playback started successfully after transition.',
                    )
                  })
                  .catch((error) => {
                    console.error(
                      'Video playback failed after transition:',
                      error,
                    )
                  })
              }
            }, 100) // 100ms delay for playback
          }

          // Allow the DOM to update before removing the class
          setTimeout(() => {
            clickedElement.classList.remove('fading-out')
            clickedElement.classList.remove('no-transition')
          }, 0)
        },
        { once: true },
      )
    })
  }
}
