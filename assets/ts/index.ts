import * as THREE from 'three'
import { TrackballControls } from 'three/addons/controls/TrackballControls.js'
import { proxy, subscribe } from 'valtio/vanilla'
import gsap from 'gsap'

interface SphereVideo {
  url: string
  aspect: number
  title: string
}

const videos: SphereVideo[] = [
  {
    url: '/assets/videos/diffusion.mp4',
    aspect: 1,
    title: 'Diffusion algorithm',
  },
  {
    url: '/assets/videos/falling-words.mp4',
    aspect: 1.75,
    title: 'Falling words',
  },
  {
    url: '/assets/videos/green-hills.mp4',
    aspect: 1,
    title: 'Green hills',
  },
  {
    url: '/assets/videos/grid.mp4',
    aspect: 1,
    title: 'Pattern generator',
  },
  {
    url: '/assets/videos/idomeneo.mp4',
    aspect: 1.77,
    title: 'Idomeneo digital poster',
  },
  {
    url: '/assets/videos/marching-squares-lowres.mp4',
    aspect: 1,
    title: 'Marching squares lowres',
  },
  {
    url: '/assets/videos/marching-squares.mp4',
    aspect: 1,
    title: 'Marching squares',
  },
  {
    url: '/assets/videos/noise-gallery.mp4',
    aspect: 1,
    title: 'Noise gallery',
  },
  {
    url: '/assets/videos/number-grid.mp4',
    aspect: 1,
    title: 'Number grid',
  },
  {
    url: '/assets/videos/organic-chart.mp4',
    aspect: 1,
    title: 'Organic chart',
  },
  {
    url: '/assets/videos/sliding-ui.mp4',
    aspect: 1,
    title: 'Sliding UI',
  },
  {
    url: '/assets/videos/window.mp4',
    aspect: 1,
    title: 'CSS window',
  },
]

function handleResize(
  element: HTMLElement,
  camera: THREE.PerspectiveCamera,
  renderer: THREE.WebGLRenderer,
) {
  const { width, height } = element.getBoundingClientRect()
  camera.aspect = width / height
  camera.updateProjectionMatrix()
  renderer.setSize(width, height)
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

document.addEventListener('DOMContentLoaded', () => {
  const state = proxy<{
    selectedVideoTitle: string | null
    selectedVideoId: string | null
  }>({ selectedVideoTitle: null, selectedVideoId: null })

  const sphereContainerElement = document.getElementById('sphere-container')
  const selectedVideoContainer = document.getElementById(
    'selected-video-container',
  )

  if (selectedVideoContainer) {
    function pauseAllVideos() {
      const videoElements =
        document.querySelectorAll<HTMLVideoElement>('.sphere-video')

      videoElements.forEach((videoElement) => videoElement.pause())
    }

    subscribe(state, () => {
      gsap.to(selectedVideoContainer, {
        opacity: 0,
        duration: 0.3,
        ease: 'power2.in',
        onComplete: () => {
          selectedVideoContainer.innerHTML = state.selectedVideoTitle || ''

          gsap.to(selectedVideoContainer, {
            opacity: 1,
            duration: 0.3,
            ease: 'power2.out',
          })
        },
      })

      const videoElement = document.getElementById(
        state.selectedVideoId || '',
      ) as HTMLVideoElement

      if (videoElement) {
        pauseAllVideos()
        videoElement.play()
      }
    })
  }

  if (!sphereContainerElement) return

  const { width, height } = sphereContainerElement.getBoundingClientRect()

  const scene = new THREE.Scene()
  scene.background = new THREE.Color(0xf6f3ea)

  const camera = new THREE.PerspectiveCamera(75, width / height)
  camera.position.setZ(7)

  const renderer = new THREE.WebGLRenderer({ antialias: true })
  renderer.setPixelRatio(window.devicePixelRatio)
  renderer.setSize(width, height)
  sphereContainerElement.appendChild(renderer.domElement)

  window.addEventListener('resize', () =>
    handleResize(sphereContainerElement, camera, renderer),
  )

  const spherePositions = calculateSpherePositions(videos.length, 4)

  const videoMeshes = videos.map((video, index) => {
    const geometry = new THREE.PlaneGeometry(video.aspect, 1)
    const videoElement = document.createElement('video')
    document.body.appendChild(videoElement)

    const videoId = `video-${index}`
    videoElement.src = video.url
    videoElement.loop = true
    videoElement.muted = true
    videoElement.classList.add('sphere-video')
    videoElement.id = videoId

    const texture = new THREE.VideoTexture(videoElement)
    const material = new THREE.MeshBasicMaterial({ map: texture })
    const mesh = new THREE.Mesh(geometry, material)

    mesh.userData.videoTitle = video.title
    mesh.userData.videoId = videoId

    const [x, y, z] = spherePositions[index].toArray()
    mesh.position.set(x, y, z)

    return mesh
  })

  videoMeshes.forEach((videoMesh) => scene.add(videoMesh))

  const controls = new TrackballControls(camera, renderer.domElement)

  let activeVideoMesh: THREE.Mesh | null = null

  function animate() {
    requestAnimationFrame(animate)

    let minDistance = Infinity
    let closestMesh: THREE.Mesh | null = null

    for (const videoMesh of videoMeshes) {
      videoMesh.quaternion.copy(camera.quaternion)
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

    controls.update()

    renderer.render(scene, camera)
  }
  animate()
})
