import { storiesOf } from '@storybook/html';
import ProductPrimary from './product-primary.html';
import ProductSecondary from './product-secondary.html';
import './product.css';

storiesOf('Product item', module)
    .add('Primary item', () => ProductPrimary)
    .add('Secondary item', () => ProductSecondary);
