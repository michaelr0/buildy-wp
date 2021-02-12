import accordions from './components/accordion'
import { initSliders } from './components/slider'
import baguetteBox from 'baguettebox.js';
import Macy from 'macy';


(function () {
  let gallerySelector = '.bmcb-gallery:not(.bmcb-slider) .bmcb-gallery__items'
  let galleries = document.querySelectorAll(gallerySelector);

  // Create Lightbox
  baguetteBox.run(gallerySelector);

  [...galleries].forEach(gallery => {
    let dataAtts = gallery.dataset || {},
      marginX = dataAtts?.marginx || 10,
      marginY = dataAtts?.marginy || 5;

    console.log({ dataAtts })

    // Convert layout to masonry
    if (gallery.classList.contains('is-masonry')) {
      let macyInstance = new Macy({
        container: gallery,
        columns: dataAtts?.columnCount || 3,
        margin: {
          x: parseInt(marginX),
          y: parseInt(marginY)
        }
      })
    }

  })


})()

accordions();

initSliders();
