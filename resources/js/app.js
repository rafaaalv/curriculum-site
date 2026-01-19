import './bootstrap';
import Panzoom from '@panzoom/panzoom';

//função que cria o mapa interativo
document.addEventListener('DOMContentLoaded', () => {
    const elem = document.getElementById('mapa')

    //precisa pensar em uma função melhor para poder centralizar o conteúdo do mapa
    const initialX = elem.getBoundingClientRect().width / 2;
    const initialY = elem.getBoundingClientRect().height / 2;

    const panzoom = Panzoom(elem, {
        maxScale: 5,        //maximo de zoomIN
        minScale: 0.1,      //maximo de zoomOUT
        contain: 'outside',
        cursor: 'graber',
        canvas: true,
        startX: initialX,   //X inicial
        StartY: initialY,   //Y inicial
        startScale: 0.55,   //Zoom inicial
        step: 0.5           //quantida de zoom ao scrollar
    })

    elem.parentElement.addEventListener('wheel', panzoom.zoomWithWheel) //cria o evento de zoom ao utilizar scroll
})

const hideInfo = document.getElementById('hideInfo')
const info = document.getElementById('information')

//função que esconde as informações laterais ao visualizar uma cadeira
hideInfo.addEventListener('click', () => {
    if(info.style.display === 'none'){
        info.style.display = 'block'
        hideInfo.classList.replace('infoInativa', 'infoAtiva')   
    }
    else{
        info.style.display = 'none'
        hideInfo.classList.replace('infoAtiva', 'infoInativa')     
    }
})


