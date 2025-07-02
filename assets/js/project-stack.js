export default function initProjectStack() {
  const stack = document.querySelector('.project-thumbnails-stack');

  if (stack) {
    const images = Array.from(stack.querySelectorAll('img'));
    const totalItems = images.length;

    stack.addEventListener('click', (event) => {
      const clickedImage = event.target.closest('img');
      if (!clickedImage) return;

      const clickedIndex = parseInt(clickedImage.style.getPropertyValue('--stack-i'));

      // Find the index of the image at the top of the stack
      let topIndex = 0;

      // Only proceed if the clicked image is the one on top
      if (clickedIndex !== topIndex) {
        return;
      }

      clickedImage.classList.add('fading-out');

      clickedImage.addEventListener('transitionend', () => {
        clickedImage.classList.add('no-transition');

        // Move the clicked image to the bottom and shift others up
        images.forEach(img => {
          const currentIndex = parseInt(img.style.getPropertyValue('--stack-i'));
          if (currentIndex === clickedIndex) {
            // Move to the bottom
            img.style.setProperty('--stack-i', totalItems - 1);
          } else {
            // Shift up
            img.style.setProperty('--stack-i', currentIndex - 1);
          }
        });

        // Allow the DOM to update before removing the class
        setTimeout(() => {
          clickedImage.classList.remove('fading-out');
          clickedImage.classList.remove('no-transition');
        }, 0);

      }, { once: true });
    });
  }
}