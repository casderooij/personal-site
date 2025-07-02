export default function initProjectStack() {
  const stack = document.querySelector('.project-thumbnails-stack')
  const indicator = document.getElementById('project-stack-indicator')

  if (stack && indicator) {
    const mediaElements = Array.from(stack.querySelectorAll('.stack-item')) as HTMLElement[]
    const totalItems = mediaElements.length

    let currentTopElement: HTMLElement | null = null

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
          videoInside.currentTime = 0; // Reset video to beginning

          // Check if video is already ready to play
          if (videoInside.readyState >= 4) { // HTMLMediaElement.HAVE_ENOUGH_DATA
            videoInside.play();
          } else {
            // Wait for the video to be ready to play through
            const playWhenReady = () => {
              videoInside.play();
              videoInside.removeEventListener('canplaythrough', playWhenReady);
            };
            videoInside.addEventListener('canplaythrough', playWhenReady);
          }
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
