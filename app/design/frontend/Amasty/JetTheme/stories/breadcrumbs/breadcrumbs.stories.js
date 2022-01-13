import { storiesOf } from '@storybook/html';
import BreadHtml from './breadcrumbs.html';

storiesOf('Breadcrumbs', module)
    .addParameters({ a11y: {
          element: '.breadcrumbs li:last-child'
    }})
    .add('Breadcrumbs', () => BreadHtml);
