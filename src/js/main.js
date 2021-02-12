import accordions from './components/accordion'
import { initSliders } from './components/slider'
import baguetteBox from 'baguettebox.js';

baguetteBox.run('.bmcb-gallery:not(.bmcb-slider) .bmcb-gallery__items')

accordions();

initSliders();
