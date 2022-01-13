import { storiesOf } from '@storybook/html';
import colorsVariables from './colors.json';
import colorsHtml from './colors.html';
import './style.css';

const createColorRow = (colorRow,  key) => {
    let row = colorRow.cloneNode(true);
    let variableNode = row.querySelector('[data-amtheme-js="variable"]');
    let colorNode = row.querySelector('[data-amtheme-js="color"]');
    let colorPaletteNode = row.querySelector('[data-amtheme-js="color-palette"]');

    variableNode.innerHTML = key;
    colorNode.innerHTML = colorsVariables[key];
    colorPaletteNode.classList.add(key.slice(1));
    colorPaletteNode.setAttribute('aria-label', key.slice(1));
    colorPaletteNode.style.background = colorsVariables[key];

    return row;
};

const colorsStory = () => {
    let fragment = document.createElement('div');
    fragment.classList.add('amtheme-palette');
    fragment.innerHTML = colorsHtml;
    let colorRow = fragment.querySelector('[data-amtheme-js="row"]');
    let nodes = Object.keys(colorsVariables).map(createColorRow.bind(null, colorRow));
    fragment.innerHTML ='';
    fragment.append(...nodes);

    return fragment;
};

storiesOf('Colors scheme', module)
    .add('Colors variables', colorsStory);
