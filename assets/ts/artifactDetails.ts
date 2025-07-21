import { Stack } from './stack'

const artifactDetailContainer = document.querySelector(
  '#artifact-detail',
) as HTMLDivElement

const artifactDetailAnchorElements = document.querySelectorAll(
  '.artifact__expand-link',
) as NodeListOf<HTMLAnchorElement>

artifactDetailAnchorElements.forEach((anchor) => {
  anchor.addEventListener('click', async (e) => {
    e.preventDefault()

    const html = await fetchArtifact(anchor.href)
    if (html && artifactDetailContainer) {
      const artifactDetailsElement = parseArtifactDetails(html)
      artifactDetailContainer.appendChild(artifactDetailsElement)

      // const slug = anchor.getAttribute('data-slug') || ''
      // history.pushState({ page: 'artifact' }, '', `/artifacts/${slug}`)

      const stackElements = document.querySelectorAll(
        '.stack',
      ) as NodeListOf<HTMLElement>
      stackElements.forEach((stackElement) => new Stack(stackElement))

      const closeButtonElement = artifactDetailsElement.querySelector(
        '#close-details',
      ) as HTMLButtonElement
      if (closeButtonElement) {
        closeButtonElement.addEventListener('click', closeOnClickListener)
      }

      function escKeyListener(event: KeyboardEvent) {
        if (event.key === 'Escape') {
          closeOnClickListener()
        }
      }

      function closeOnClickListener() {
        artifactDetailContainer.removeChild(artifactDetailsElement)
        removeEventListeners()
        // history.replaceState({ page: 'home' }, '', '/')
      }

      function removeEventListeners() {
        document.removeEventListener('keydown', escKeyListener)
      }

      artifactDetailsElement.addEventListener('click', (event) => {
        if (event.target === artifactDetailsElement) {
          closeOnClickListener()
        }
      })

      document.addEventListener('keydown', escKeyListener)
    }
  })
})

async function fetchArtifact(url: string) {
  const data = await fetch(url)
  const html = await data.text()
  return html
}

function parseArtifactDetails(html: string) {
  const parser = new DOMParser()
  const snippet = parser.parseFromString(html, 'text/html')

  return snippet.body.firstChild as HTMLDivElement
}
