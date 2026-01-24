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



//Esses são apenas uns dados de teste que eu usei, pode apagar tudo depois que o banco de dados estiver pronto
/*
const grafo = {
    INF05508: ['INF01088', 'INF05005'],
    INF01202: ['INF01088', 'INF01203'],
    INF05008: ['INF01203'],
    INF01088: [],
    INF05005: [],
    MAT01375: ['INF05005', 'INF05027'],
    INF05027: [],
    INF01203: ['INF01145', 'INF01120', 'INF05027'],
    INF01145: [],
    INF01120: []
}

const ordemTopo = ['INF05508', 'INF01202', 'INF05008', 'MAT01375', 'INF01088', 'INF05005', 'INF01203', 'INF01145', 'INF01120', 'INF05027']

const disciplinas = {
    INF05508: {
        cod: 'INF05508',
        nome: 'LÓGICA PARA COMPUTAÇÃO',
        credito: 4,
        etapa: 1,
        responsavel: 'INT',
        descricao: 'Histórico da Lógica. Lógica Proposicional (sintaxe e semântica). Lógica de Predicados (sintaxe e semântica). Sistemas Dedutivos (dedução natural, árvores de refutação, consistência e completude). Aplicações de Lógica em Computação.'
    },
    INF01202: {
        cod: 'INF01202',
        nome: 'ALGORÍTMOS E PROGRAMAÇÃO - CIC',
        credito: 6,
        etapa: 1,
        responsavel: 'INA',
        descricao: 'Definição e solução de problemas, desenvolvimento de algoritmos e pensamento computacional. Fundamentos de programação imperativa: variáveis, tipos de dados, operadores, entrada e saída. Introdução a ambientes de programação e ao uso de ferramentas de desenvolvimento. Técnicas de depuração. Estruturas de controle de fluxo: sequência, seleção e iteração. Estruturas de dados básicas: arranjos, strings, matrizes e registros (tipos definidos pelo usuário). Geração e uso de números pseudo aleatórios. Princípios da programação estruturada: subprogramas, funções, ponteiros, passagem de parâmetros por valor e referência. Compilação e execução de programas na linha de comando. Boas práticas de programação. Modularização de programas em múltiplos arquivos. Manipulação básica de arquivos: arquivos binários e texto. Funções recursivas.'
    },
    INF05008: {
        cod: 'INF05008',
        nome: 'PENSAMENTO COMPUTACIONAL N',
        credito: 4,
        etapa: 1,
        responsavel: 'INT',
        descricao: 'Definição de problemas, algoritmos e pensamento computacional. Projeto e implementação de soluções algorítmicas para problemas usando o paradigma funcional. Principais técnicas de resolução de problemas: generalização, decomposição e transformação. Resolução de problemas usando recursão e meta-programação. Introdução às principais formas de organizar a informação: registros, listas, árvores, grafos. Fundamentos da sistematização da construção de soluções computacionais: documentação, boas práticas, projeto e análise (testes e correção).'
    },
    INF01088: {
        cod: 'INF01088',
        nome: 'TESTE E VERIFICAÇÃO DE SOFTWARE',
        credito: 2,
        etapa: 2,
        responsavel: 'INA',
        descricao: 'Introdução à verificação e validação de software. Requisitos de software. Fundamentos de teste de software. Fundamentos de verificação formal de software.'
    },
    INF05005: {
        cod: 'INF05005',
        nome: 'TEORIA DA COMPUTAÇÃO I',
        credito: 4,
        etapa: 3,
        responsavel: 'INT',
        descricao: 'Conceitos básicos de linguagens (alfabeto, palavra, concatenação, linguagem formal). Linguagens regulares, autômatos finitos e expressões regulares. Linguagens livres de contexto, autômatos com pilha e gramáticas livres de contexto. Máquinas de Turing e suas variantes (não determinismo, múltiplas fitas). Linguagens Recursivas e Recursivamente Enumeráveis. Hierarquia de Chomsky.'
    },
    MAT01375: {
        cod: 'MAT01375',
        nome: 'MATEMÁTICA DISCRETA B',
        credito: 4,
        etapa: 2,
        responsavel: 'MAT',
        descricao: 'Conjuntos, Relações e Funções. Indução Matemática. Teoria dos Números. Análise Combinatória. Recorrências.'
    },
    INF05027: {
        cod: 'INF05027',
        nome: 'PROJETO E ANÁLISE DE ALGORITMOS I',
        credito: 4,
        etapa: 3,
        responsavel: 'INT',
        descricao: 'Análise e corretude de algoritmos. Notação assintótica. Teoria dos Grafos. Projeto e implementação de algoritmos: Grafos e Algoritmos Gulosos. Estruturas de dados para algoritmos gulosos.'
    },
    INF01203: {
        cod: 'INF01203',
        nome: 'ESTRUTURAS DE DADOS',
        credito: 4,
        etapa: 2,
        responsavel: 'INA',
        descricao: 'Tipos abstratos de dados. Alocação dinâmica de memória. Listas, Pilhas e Filas. Algoritmos de ordenação. Árvores (Binárias, Balanceadas e de Busca), Strings. Hash. Estruturas de indexação e compressão.'
    },
    INF01145: {
        cod: 'INF01145',
        nome: 'BANCOS DE DADOS',
        credito: 4,
        etapa: 3,
        responsavel: 'INA',
        descricao: 'Sistemas de gerência de banco de dados. Abordagem relacional: modelo de dados e restrições de integridade; formas normais; álgebra relacional; SQL (DDL, DML); visões, gatilhos, procedimentos armazenados. Plano de consultas. Transações. Controle de concorrência e bloqueio. Recuperação. Autorização.'
    },
    INF01120: {
        cod: 'INF01120',
        nome: 'DESENVOLVIMENTO DE SOFTWARE',
        credito: 4,
        etapa: 3,
        responsavel: 'INA',
        descricao: 'Projeto de Software: Fundamentos de design, arquitetura, padrões e introdução à linguagem de modelagem unificada (UML). Construção de Software: Boas práticas de codificação, frameworks, desenvolvimento guiado por testes (TDD), integração contínua e programação orientada a objetos (OOP). Qualidade e Testes: Métricas, code smells, testes unitários/integração/sistema/aceitação. Refatoração e Depuração: Técnicas de melhoria de código e resolução de defeitos. Manutenção e Ferramentas: Gestão de mudanças, versionamento e ambientes de desenvolvimento. Trabalho em Equipe: Colaboração e comunicação em projetos de grupo.'
    }
}
*/

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
