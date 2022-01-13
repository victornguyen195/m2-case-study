import { storiesOf } from '@storybook/html';
import NewsletterHtml from './newsletter.html';

storiesOf('Newsletter', module)
    .add('Newsletter', () => NewsletterHtml);
