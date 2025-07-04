import { Stack } from './ts/project-stack'

document.addEventListener('DOMContentLoaded', () => {
  const stackElements = document.querySelectorAll(
    '.stack',
  ) as NodeListOf<HTMLElement>
  stackElements.forEach((stackElement) => new Stack(stackElement))
})
