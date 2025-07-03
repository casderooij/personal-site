import { initializeStack } from './ts/project-stack'

document.addEventListener('DOMContentLoaded', () => {
  const stackElement = document.querySelector('.stack') as HTMLElement
  initializeStack(stackElement)
})
