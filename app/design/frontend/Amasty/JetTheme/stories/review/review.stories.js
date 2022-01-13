import { storiesOf } from '@storybook/html';
import ReviewSummaryHtml from './review-summary.html';
import ReviewLitsHtml from './review-list.html';
import ReviewFormHtml from './review-form.html';

storiesOf('Review', module)
    .add('Review Summary', () => ReviewSummaryHtml)
    .add('Review List', () => ReviewLitsHtml)
    .add('Review Form', () => ReviewFormHtml);
