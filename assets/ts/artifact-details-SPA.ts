let lastFocusedElement: HTMLElement | null = null

function setupArtifactLinks() {
  document.querySelectorAll('[data-artifact-link]').forEach((link) => {
    const artifactLink = link as HTMLAnchorElement
    artifactLink.addEventListener('click', function (event) {
      event.preventDefault()
      const artifactId = artifactLink.dataset.slug
      if (artifactId) {
        loadArtifactDetails(artifactId)
      }
    })
  })
}

function loadArtifactDetails(artifactId: string, pushState = true) {
  const url = `/artifact-details/${artifactId}`

  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error('Network response was not OK')
      }
      return response.text()
    })
    .then((html) => {
      const artifactDetailElement = document.getElementById(
        'artifact-detail',
      ) as HTMLDivElement

      artifactDetailElement.innerHTML = html

      setupCloseButton()

      lastFocusedElement = document.activeElement as HTMLElement

      document.body.classList.add('no-scroll')

      const container = document.querySelector(
        '.artifact-details__container',
      ) as HTMLDivElement
      if (container) {
        container.addEventListener('click', handleClickOutside)
        trapFocus(container)
      }

      const artifactDetails = document.querySelector(
        '.artifact-details',
      ) as HTMLDivElement
      if (artifactDetails) {
        artifactDetails.addEventListener(
          'focus',
          () => trapFocus(artifactDetails),
          false,
        )
      }

      if (pushState) {
        history.pushState(
          { artifactId: artifactId },
          '',
          '/artifacts/' + artifactId,
        )
      }
    })
    .catch((error) => {
      console.error('Error fetching artifact details:', error)
    })
}

function trapFocus(element: HTMLElement) {
  const focusableElements = element.querySelectorAll<HTMLElement>(
    'a[href], [tabindex]:not([tabindex="-1"])',
  )
  const firstFocusableElement = focusableElements[0]
  const lastFocusableElement = focusableElements[focusableElements.length - 1]

  function handleFocus(event: KeyboardEvent) {
    if (event.key === 'Tab') {
      if (event.shiftKey) {
        if (document.activeElement === firstFocusableElement) {
          event.preventDefault()
          lastFocusableElement.focus()
        }
      } else {
        if (document.activeElement === lastFocusableElement) {
          event.preventDefault()
          firstFocusableElement.focus()
        }
      }
    }
  }

  element.addEventListener('keydown', handleFocus)

  firstFocusableElement?.focus()
}

function closeArtifactDetails() {
  const artifactDetailElement = document.getElementById('artifact-detail')
  if (artifactDetailElement) {
    artifactDetailElement.innerHTML = ''
    history.pushState(null, '', '/')
  }

  if (lastFocusedElement) {
    lastFocusedElement.focus()
  }

  document.body.classList.remove('no-scroll')
}

function handleClickOutside(event: MouseEvent) {
  const artifactDetails = document.querySelector(
    '.artifact-details__content',
  ) as HTMLDivElement | null
  if (artifactDetails && !artifactDetails.contains(event.target as Node)) {
    closeArtifactDetails()
  }
}

function handlePopState(event: PopStateEvent) {
  const artifactDetailElement = document.getElementById('artifact-detail')
  if (event.state && event.state.artifactId) {
    loadArtifactDetails(event.state.artifactId, false)
  } else if (artifactDetailElement) {
    artifactDetailElement.innerHTML = ''
    document.body.classList.remove('no-scroll')
  }
}

function handleEscapeKey(event: KeyboardEvent) {
  if (event.key === 'Escape') {
    closeArtifactDetails()
  }
}

function setupCloseButton() {
  const closeButton = document.getElementById('close')
  if (closeButton) {
    closeButton.addEventListener('click', function (event) {
      event.preventDefault()
      closeArtifactDetails()
    })
  }
}

export function initializeArtifactDetailsSPA() {
  setupArtifactLinks()
  const pathParts = window.location.pathname.split('/')
  if (pathParts[1] === 'artifacts' && pathParts[2]) {
    loadArtifactDetails(pathParts[2], false)
  }

  window.addEventListener('popstate', handlePopState)
  window.addEventListener('keydown', handleEscapeKey)
}
