import { primeVideos } from './prime-videos'

export class Stack {
  stackElement: HTMLElement
  stackItems: HTMLElement[]
  numberOfStackItems: number
  topStackItem: HTMLElement
  indicatorElement: HTMLElement | null

  constructor(stackElement: HTMLElement) {
    this.stackElement = stackElement
    this.stackItems = Array.from(
      stackElement.querySelectorAll('.stack-item'),
    ) as HTMLElement[]
    this.numberOfStackItems = this.stackItems.length
    this.topStackItem = this.stackItems[0]
    this.indicatorElement = stackElement.querySelector('.indicator')

    this.intialize()
  }

  async intialize() {
    const observer = new IntersectionObserver((entries) => {
      const { isIntersecting } = entries[0]

      const topItemVideo = this.getVideo(this.topStackItem)
      if (!topItemVideo) return

      if (isIntersecting && topItemVideo.paused) {
        topItemVideo.play()
      } else if (!isIntersecting) {
        topItemVideo.pause()
      }
    })
    observer.observe(this.stackElement)

    this.stackElement.addEventListener('click', () => {
      this.updateStackIndex()
      this.pauseAndHideTopItem()
      this.updateIndicator()
    })

    await primeVideos(this.stackItems)

    this.stackItems.forEach((item) => {
      if (item.dataset.index !== '0') {
        item.classList.remove('is-hidden')
      } else {
        const video = this.getVideo(item)
        if (video) {
          video.play()
        }
      }
    })
  }

  getVideo(stackItem: HTMLElement) {
    return stackItem.querySelector('video')
  }

  getTopItem() {
    return this.stackItems.find(
      (item) => parseInt(item.dataset.index || '0') === 0,
    )
  }

  getCurrentStackIndex() {
    return parseInt(this.stackElement.dataset.index || '0')
  }

  shiftItems() {
    this.stackItems.forEach((item) => {
      const itemIndex = parseInt(item.dataset.index || '0')

      const nextIndex =
        (itemIndex - 1 + this.numberOfStackItems) % this.numberOfStackItems

      item.dataset.index = nextIndex.toString()
      item.style.setProperty('--stack-i', nextIndex.toString())
    })
  }

  playTopItem() {
    const topItem = this.getTopItem()
    if (!topItem) return

    const video = topItem.querySelector('video')
    if (!video) return
    video.play()
  }

  updateStackIndex() {
    const nextIndex =
      (this.getCurrentStackIndex() + 1) % this.numberOfStackItems
    this.stackElement.dataset.index = nextIndex.toString()
  }

  pauseAndHideTopItem() {
    const topItem = this.getTopItem()

    if (topItem) {
      topItem.classList.add('fading-out')
      topItem.addEventListener(
        'transitionend',
        () => {
          topItem.classList.add('no-transition')

          const video = this.getVideo(topItem)
          if (!video) return
          video.pause()

          this.shiftItems()
          this.playTopItem()

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

  updateIndicator() {
    if (!this.indicatorElement) return

    const index = this.getCurrentStackIndex()
    const indicatorString = Array.from(
      { length: this.stackItems.length },
      (_, i) => (i === index ? '#' : '-'),
    ).join('')

    this.indicatorElement.textContent = indicatorString
  }
}
