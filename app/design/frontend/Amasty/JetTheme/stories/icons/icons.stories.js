import { storiesOf } from '@storybook/html';
import iconsTemplate from './icons.html';
import iconsData from '../../web/svg/sprite/svg-sprite.json';
import '@StaticMage/Magento_Theme/js/utils/svg-sprite.min.js';
import './icons.css';

const twoColorIcons = [
    'icon-cart',
    'icon-compare',
    'icon-mail',
    'icon-review-star',
    'icon-wishlist'
];

const generateIcons = (template) => {
    let iconsName = iconsData,
        id,
        svg,
        icon,
        iconsHtml;

    iconsHtml = document.createElement('div');
    iconsHtml.classList.add('amtheme-icons-pack');

    iconsName.forEach(iconName => {
        id = '#' + iconName;
        icon = template.cloneNode(true);
        icon.querySelector('[data-amtheme-js="id"]').setAttribute('xlink:href', id);
        icon.querySelector('[data-amtheme-js="label"]').innerText = iconName;
        svg = icon.querySelector('[data-amtheme-js="svg"]');

        twoColorIcons.includes(iconName) ? svg.classList.add('-hover-bg') : svg.classList.add('-hover');

        iconsHtml.append(icon);
    });

    return iconsHtml;
};

const generateHtml = () => {
    let iconsBox = document.createElement('div'),
        template,
        iconsHtml;

    iconsBox.innerHTML = iconsTemplate;
    template = iconsBox.querySelector('[data-amtheme-js="icon"]');
    iconsHtml = generateIcons(template);

    return iconsHtml;
};

storiesOf('Icons', module)
    .add('Icons', generateHtml);
