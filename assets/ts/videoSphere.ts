import gsap from 'gsap'
import * as THREE from 'three'
import { TrackballControls } from 'three/addons/controls/TrackballControls.js'
import { proxy, subscribe } from 'valtio/vanilla'
import { globalState } from './globalState'

interface SphereVideo {
  url: string
  aspectratio: number
  title: string
}

function handleResize(
  element: HTMLElement,
  camera: THREE.PerspectiveCamera,
  renderer: THREE.WebGLRenderer,
) {
  const { width, height } = element.getBoundingClientRect()
  camera.aspect = width / height
  camera.updateProjectionMatrix()
  renderer.setSize(width, height)

  return { width, height }
}

function calculateSpherePositions(total: number, radius: number) {
  const PHI = Math.PI * (3 - Math.sqrt(5))
  const points = []

  for (let i = 0; i < total; i++) {
    const y = 1 - (i / (total - 1)) * 2
    const r = Math.sqrt(1 - y * y)
    const theta = PHI * i
    const x = Math.cos(theta) * r
    const z = Math.sin(theta) * r
    points.push(new THREE.Vector3(x, y, z).multiplyScalar(radius))
  }
  return points
}

function renderSelectedVideoTitle(videoElements: HTMLVideoElement[]) {
  const selectedVideoTitle = document.getElementById('selected-video-title')

  if (selectedVideoTitle) {
    subscribe(state, () => {
      if (!state.selectedVideoTitle) return

      selectedVideoTitle.innerHTML = state.selectedVideoTitle

      const videoElement = document.getElementById(
        state.selectedVideoId || '',
      ) as HTMLVideoElement

      if (videoElement) {
        // Pause all videos
        videoElements.forEach((videoElement) => videoElement.pause())
        videoElement.play()
      }
    })
  }
}

function updateSphereRadius(
  totalNumberOfVideos: number,
  radius: number,
  meshes: THREE.Mesh[],
) {
  const positions = calculateSpherePositions(totalNumberOfVideos, radius)

  meshes.forEach((mesh, index) => {
    const { x, y, z } = positions[index]
    gsap.to(mesh.position, {
      x,
      y,
      z,
      duration: 1,
      ease: 'power2.inOut',
    })
  })
}

function getSphereRadius() {
  const radius = globalState.screen === 'desktop' ? 4 : 3
  const subtractiveRadiusSize = globalState.screen === 'desktop' ? 1 : 2

  return globalState.isMainElementIntersecting
    ? radius - subtractiveRadiusSize
    : radius
}

const state = proxy<{
  selectedVideoTitle?: string
  selectedVideoId?: string
}>({ selectedVideoTitle: undefined, selectedVideoId: undefined })

export function renderVideoSphere(sphereContainerElement: HTMLElement) {
  const videoElements: HTMLVideoElement[] = []

  const sphereVideosContainerElement = document.getElementById(
    'sphere-videos-container',
  )

  const videos = JSON.parse(sphereContainerElement.dataset.videos!)
    .data as SphereVideo[]

  const selectedVideoContainerElement = document.getElementById(
    'selected-video-container',
  ) as HTMLDivElement

  let { width, height } = sphereContainerElement.getBoundingClientRect()
  let halfWidth = width / 2
  let halfHeight = height / 2

  const scene = new THREE.Scene()
  scene.fog = new THREE.Fog(0xe5e7eb, 4, 10)

  const sphere = new THREE.Group()
  scene.add(sphere)

  const camera = new THREE.PerspectiveCamera(75, width / height)
  camera.position.setX(2)
  camera.position.setY(-2)
  camera.position.setZ(7)

  const renderer = new THREE.WebGLRenderer({ alpha: true })
  renderer.outputColorSpace = THREE.SRGBColorSpace
  renderer.setPixelRatio(window.devicePixelRatio)
  renderer.setSize(width, height)
  sphereContainerElement.appendChild(renderer.domElement)

  const controls = new TrackballControls(camera, renderer.domElement)
  controls.noZoom = true
  controls.enabled = false
  controls.panSpeed = globalState.screen === 'mobile' ? 1 : 2

  window.addEventListener('resize', () => {
    const newSizes = handleResize(sphereContainerElement, camera, renderer)
    width = newSizes.width
    halfWidth = newSizes.width / 2
    height = newSizes.height
    halfHeight = newSizes.height / 2
  })

  const positions = calculateSpherePositions(videos.length, getSphereRadius())

  const videoMeshes = videos.map((video, index) => {
    const geometry = new THREE.PlaneGeometry(video.aspectratio, 1)
    const videoElement = document.createElement('video')
    videoElements.push(videoElement)
    if (sphereVideosContainerElement) {
      sphereVideosContainerElement.appendChild(videoElement)
    }

    const videoId = `video-${index}`
    videoElement.src = video.url
    videoElement.loop = true
    videoElement.muted = true
    videoElement.autoplay = true
    videoElement.playsInline = true
    videoElement.pause()
    videoElement.id = videoId

    const texture = new THREE.VideoTexture(videoElement)
    texture.colorSpace = THREE.SRGBColorSpace
    const material = new THREE.MeshBasicMaterial({
      map: texture,
    })
    const mesh = new THREE.Mesh(geometry, material)

    mesh.userData.videoTitle = video.title
    mesh.userData.videoId = videoId

    const { x, y, z } = positions[index]
    mesh.position.set(x, y, z)

    sphere.add(mesh)

    return mesh
  })

  subscribe(globalState, () => {
    updateSphereRadius(videos.length, getSphereRadius(), videoMeshes)

    if (globalState.screen === 'mobile') {
      controls.panSpeed = 1
    } else {
      controls.panSpeed = 2
    }

    if (
      globalState.isMainElementIntersecting &&
      globalState.screen === 'mobile'
    ) {
      controls.disconnect()
    } else {
      controls.connect(renderer.domElement)
    }

    if (globalState.screen === 'desktop') {
      gsap.to(sphereContainerElement, {
        x: globalState.isMainElementIntersecting ? '25%' : '0%',
        duration: 1.4,
        ease: 'power2.inOut',
      })
    } else {
      gsap.to(sphereContainerElement, {
        x: '0%',
        duration: 1.4,
        ease: 'power2.inOut',
      })
    }
  })

  const videoLoadPromises = videoElements.map((videoElement) => {
    return new Promise<void>((resolve) => {
      videoElement.addEventListener('canplaythrough', () => resolve())
    })
  })

  Promise.all(videoLoadPromises).then(() => {
    gsap.to([sphereContainerElement, selectedVideoContainerElement], {
      opacity: 1,
      duration: 1,
      ease: 'power2.out',
    })
    gsap.to(camera.position, {
      x: -2,
      y: -1,
      duration: 1,
      ease: 'power2.out',
      onComplete: () => {
        controls.enabled = true
      },
    })
  })

  let activeVideoMesh: THREE.Mesh | null = null

  let frameCount = 0

  function animate() {
    requestAnimationFrame(animate)
    frameCount++

    for (const videoMesh of videoMeshes) {
      videoMesh.quaternion.copy(camera.quaternion)
    }

    if (activeVideoMesh) {
      const position = activeVideoMesh.position.clone()
      position.project(camera)

      gsap.to(selectedVideoContainerElement, {
        x: position.x * halfWidth + halfWidth,
        y: -(position.y * halfHeight) + halfHeight,
      })
    }

    if (frameCount % 10 === 0) {
      let minDistance = Infinity
      let closestMesh: THREE.Mesh | null = null

      for (const videoMesh of videoMeshes) {
        const worldPosition = new THREE.Vector3()
        videoMesh.getWorldPosition(worldPosition)
        const distance = camera.position.distanceTo(worldPosition)

        if (distance < minDistance) {
          minDistance = distance
          closestMesh = videoMesh
        }
      }

      if (closestMesh && closestMesh !== activeVideoMesh) {
        if (activeVideoMesh) {
          gsap.to(activeVideoMesh.scale, {
            x: 1,
            y: 1,
            z: 1,
            duration: 0.5,
            ease: 'power2.out',
          })
        }

        gsap.to(closestMesh.scale, {
          x: 2,
          y: 2,
          z: 1,
          duration: 0.5,
          ease: 'power2.out',
        })

        activeVideoMesh = closestMesh
        state.selectedVideoTitle = activeVideoMesh.userData.videoTitle
        state.selectedVideoId = activeVideoMesh.userData.videoId
      }
    }

    controls.update()

    renderer.render(scene, camera)
  }
  animate()

  renderSelectedVideoTitle(videoElements)
}
