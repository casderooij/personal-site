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

      const closeButtonElement = artifactDetailsElement.querySelector(
        '#close-details',
      ) as HTMLButtonElement
      if (closeButtonElement) {
        closeButtonElement.addEventListener('click', closeOnClickListener)
      }

      function escKeyListener(event: KeyboardEvent) {
        if (event.key === 'Escape') {
          artifactDetailContainer.removeChild(artifactDetailsElement)
          removeEventListeners()
        }
      }

      function closeOnClickListener() {
        artifactDetailContainer.removeChild(artifactDetailsElement)
        removeEventListeners()
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
