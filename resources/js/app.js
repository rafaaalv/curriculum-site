import './bootstrap';
import Panzoom from '@panzoom/panzoom';

document.addEventListener('DOMContentLoaded', () => {
    const elem = document.getElementById('mapa')

    //precisa pensar em uma função melhor para poder centralizar o conteúdo do mapa
    const initialX = elem.getBoundingClientRect().width / 2;
    const initialY = elem.getBoundingClientRect().height / 2;

    const panzoom = Panzoom(elem, {
        maxScale: 5,
        minScale: 0.1,
        contain: 'outside',
        cursor: 'graber',
        canvas: true,
        startX: initialX,
        StartY: initialY,
        startScale: 0.55,
        step: 0.5
    })

    elem.parentElement.addEventListener('wheel', panzoom.zoomWithWheel)
})


