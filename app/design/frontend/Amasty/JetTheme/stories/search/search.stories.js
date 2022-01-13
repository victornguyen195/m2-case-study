import { storiesOf } from '@storybook/html';
import searchHtml from './search.html';
import searchAutocompleteHtml from './search-autocomplete.html';
import searchHeaderHtml from './search-header.html';
import searchHeaderAutocompleteHtml from './search-header-autocomplete.html';
import searchTermsHtml from './search-terms.html';

storiesOf('Search', module)
    .add('Search default', () => searchHtml)
    .add('Search autocomplete', () => searchAutocompleteHtml)
    .add('Search Header', () => searchHeaderHtml)
    .add('Search Header autocomplete', () => searchHeaderAutocompleteHtml)
    .add('Search Terms', () => searchTermsHtml);
