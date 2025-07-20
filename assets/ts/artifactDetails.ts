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
    console.log(html)
    if (html && artifactDetailContainer) {
      artifactDetailContainer.innerHTML = html
    }
  })
})

async function fetchArtifact(url: string) {
  const data = await fetch(url)
  const html = await data.text()
  return html
}
