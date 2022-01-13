import { storiesOf } from '@storybook/html';
import PaginationHtml from './pagination.html';

storiesOf('Pagination', module)
    .add('Pagination default', () => PaginationHtml);
