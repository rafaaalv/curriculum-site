import './bootstrap';
import Panzoom from '@panzoom/panzoom';
import GrafoPreReq from './grafoPreReq';

//=============================
//MAPA
//=============================
//função que cria o mapa interativo
document.addEventListener('DOMContentLoaded', () => {
    const elem = document.getElementById('mapa')

    //se o mapa existir cria o ambiente panzoom
    if(elem){
         //precisa pensar em uma função melhor para poder centralizar o conteúdo do mapa
    const initialX = (elem.offsetLeft + elem.offsetWidth)/2;
    const initialY = (elem.offsetTop + elem.offsetHeight)/2;

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
    }
})

//=============================
//BOTÕES
//=============================
const hideInfo = document.getElementById('hideInfo')
const info = document.getElementById('information')

//função que esconde as informações laterais ao visualizar uma cadeira
if(hideInfo){
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
}

//=============================
//GRAFO DE PRÉ-REQUISITOS
//=============================
//Grafo = {cod: []} (objeto)
//Ordem Topológica = [] (lista)
//Disciplinas = {cod: {}}
//Inicial = string (nodo inicial do grafo/ o codigo da disciplina do url)
//Objetivo: dados um grafo de pré-requisitos representado por lista de adjacência e sua ordem topológica gera a vizualização do grafo
function criaGrafo(grafo, ordemTopo, disciplinas, inicial){
    const preReq = new GrafoPreReq(grafo, ordemTopo, disciplinas);

    preReq.montaGrafo();

    const nodos = document.querySelectorAll('.disciplina');

    //destaca o nodo inicial
    const nodoInicial = document.getElementById(inicial);
    preReq.destacaNodo(nodoInicial);

    //cria um evento acionado ao clicar nos outros nodos
    nodos.forEach(nodo => {
        nodo.addEventListener('click', ()=> {preReq.destacaNodo(nodo)});
    })
}

window.criaGrafo = criaGrafo;