import { Stack } from './stack'

const artifactDetailContainer = document.querySelector(
  '#artifact-detail',
) as HTMLDivElement
const artifactDetailAnchorElements = document.querySelectorAll(
  '[data-artifact-link]',
) as NodeListOf<HTMLAnchorElement>

artifactDetailAnchorElements.forEach(setupArtifactLink)

window.addEventListener('popstate', handlePopState)

/**
 * Sets up click event for each artifact link to handle dialog rendering and history management.
 * @param anchor HTMLAnchorElement representing the artifact link.
 */
function setupArtifactLink(anchor: HTMLAnchorElement) {
  anchor.addEventListener('click', async (e) => {
    e.preventDefault()
    const slug = anchor.getAttribute('data-slug') || ''
    await renderAndShowArtifactDetails(anchor.href, slug)
  })
}

/**
 * Fetches and appends the artifact details to the container, and manages history state.
 * @param url The URL to fetch artifact details.
 * @param slug The identifier for the artifact.
 */
async function renderAndShowArtifactDetails(url: string, slug: string) {
  const details = await renderArtifactDetail(url)
  if (details && artifactDetailContainer) {
    artifactDetailContainer.appendChild(details)
    history.pushState({ page: 'artifact', slug }, '', `/artifacts/${slug}`)
    setupDetailsCloseListeners(details)
    initializeStackElements()
  }
}

/**
 * Fetches and parses the artifact details.
 * @param url The URL to fetch artifact details.
 * @returns Parsed HTMLDivElement of artifact details.
 */
async function renderArtifactDetail(
  url: string,
): Promise<HTMLDivElement | null> {
  const html = await fetchArtifact(url)
  return parseArtifactDetails(html)
}

/**
 * Sets up event listeners to manage dialog closing.
 * @param details The element containing artifact details.
 */
function setupDetailsCloseListeners(details: HTMLDivElement) {
  const closeButtonElement = details.querySelector(
    '#close-details',
  ) as HTMLButtonElement

  const closeDialog = () => {
    if (artifactDetailContainer.contains(details)) {
      artifactDetailContainer.removeChild(details)
    }
    removeCloseEventListeners()
    history.replaceState({ page: 'home' }, '', '/')
  }

  closeButtonElement?.addEventListener('click', closeDialog)

  details.addEventListener('click', (event) => {
    if (event.target === details) {
      closeDialog()
    }
  })

  document.addEventListener('keydown', (event: KeyboardEvent) => {
    if (event.key === 'Escape') {
      closeDialog()
    }
  })

  function removeCloseEventListeners() {
    document.removeEventListener('keydown', closeDialog)
  }
}

/**
 * Initializes stack elements after rendering details.
 */
function initializeStackElements() {
  const stackElements = document.querySelectorAll(
    '.stack',
  ) as NodeListOf<HTMLElement>
  stackElements.forEach((stackElement) => new Stack(stackElement))
}

/**
 * Fetches artifact HTML from a given URL.
 * @param url The URL to fetch the artifact from.
 * @returns The fetched HTML as a string.
 */
async function fetchArtifact(url: string): Promise<string> {
  const response = await fetch(url)
  return response.text()
}

/**
 * Parses HTML string into a HTMLDivElement.
 * @param html The HTML string to parse.
 * @returns The parsed HTMLDivElement.
 */
function parseArtifactDetails(html: string): HTMLDivElement | null {
  const parser = new DOMParser()
  const snippet = parser.parseFromString(html, 'text/html')
  return snippet.body.firstChild as HTMLDivElement
}

/**
 * Handles `popstate` event to manage browser navigation and dialog display.
 * @param event The PopStateEvent triggered by navigation.
 */
async function handlePopState(event: PopStateEvent) {
  const state = event.state
  const artifactDetails = artifactDetailContainer.querySelector(
    '.artifact-details__container',
  )

  if (artifactDetails) {
    artifactDetailContainer.removeChild(artifactDetails)
  }

  if (state?.page === 'artifact' && state.slug) {
    const url = `/artifact-details/${state.slug}`
    const details = await renderArtifactDetail(url)
    if (details) {
      artifactDetailContainer.appendChild(details)
      initializeStackElements()
    }
  }
}
