import { storiesOf } from '@storybook/html';
import FormHtml from './form.html';
import FormSelect from './form-select.html';
import FormRadioCheckbox from './form-radio-checkbox.html';
import FormFields from './form-fields.html';
import './styles.css';

storiesOf('Form', module)
    .add('Form', () => FormHtml)
    .add('Select', () => FormSelect)
    .add('Radio and Checkbox', () => FormRadioCheckbox)
    .add('Fields', () => FormFields);
