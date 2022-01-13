import { storiesOf } from '@storybook/html';
import ButtonHtml from './button.html';
import ButtonPrimaryHtml from './button-primary.html';
import ButtonTertiaryHtml from './button-outline.html';
import ButtonLinkHtml from './link-as-button.html';
import ButoonAsLink from './button-as-link.html';
import ButtonBack from './button-back.html';

storiesOf('Buttons', module)
    .add('Button default', () => ButtonHtml)
    .add('Button primary', () => ButtonPrimaryHtml)
    .add('Button outline', () => ButtonTertiaryHtml)
    .add('Link as button', () => ButtonLinkHtml)
    .add('Button as link', () => ButoonAsLink)
    .add('Button Back', () => ButtonBack);
