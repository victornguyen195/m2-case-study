import { storiesOf } from '@storybook/html';
import ProductTabsHtml from './product-tabs.html';
import SocialLinksHtml from './social-links.html';
import QtyHtml from './qty.html';

storiesOf('Product page', module)
    .add('Product Tabs', () => ProductTabsHtml)
    .add('Social links', () => SocialLinksHtml)
    .add('Qty', () => QtyHtml);
