import { storiesOf } from '@storybook/html';
import SwatchesText from './text.html';
import SwatchesColor from './color.html';

storiesOf('Swatches', module)
    .add('Swatch text', () => SwatchesText)
    .add('Swatch color', () => SwatchesColor);
