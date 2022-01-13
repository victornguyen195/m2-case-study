import { storiesOf } from '@storybook/html';
import Modal from './modal.html';
import SlideModal from './slide-modal.html';
storiesOf('Modals', module)
    .add('Modal', () => Modal)
    .add('Slide Modal', () => SlideModal);
