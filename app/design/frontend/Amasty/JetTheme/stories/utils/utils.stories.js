import { storiesOf } from '@storybook/html';
import HelpersHtml from './helpers.html';
import MixinsHtml from './mixins.html';
import './styles.css';

storiesOf('Utils', module)
    .add('Helpers', () => HelpersHtml)
    .add('Mixins', () => MixinsHtml);
