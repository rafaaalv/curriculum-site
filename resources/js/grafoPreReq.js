export default class GrafoPreReq{

    constructor(grafo, ordemTopo, disciplinas){
        this.grafo = grafo;
        this.ordemTopo = ordemTopo;
        this.disciplinas = disciplinas;

        //elementos do html
        this.mapa = document.getElementById('mapa');
        this.svg = document.getElementById('linhas');
        this.information = document.getElementById('information');

        this.tamCol = 500;
        this.tamLin = 300;

        this.pos = this.calculaPos();
        this.coordInicial = this.calculaCoordInicial();
    }

    //Objetivo: monta a visualização do grafo de pré-requisitos
    montaGrafo(){
        //para cada disciplina da ordem topológica
        this.ordemTopo.forEach(disciplina => {
            //adiciona a disciplina a disciplina ao html
            this.insereDisciplina(disciplina);

            //cria o arco entre a disciplina e cada disciplina liberada por ela
            this.grafo[disciplina].forEach(liberada => {
                    this.criaArco(disciplina, liberada);
            })
        });
    }

    //Objetivo: verifica se a disciplina já foi adicionada ao html, caso contrário, insere a disciplina no html
    insereDisciplina(disciplina){
        //verifica se a disciplina existe no documento
        if(document.getElementById(disciplina) === null)
        {
            //se ela não existe no documento, adiciona no documento

            //cria os conteúdos da disciplina
            const novaDisciplina = document.createElement('div')
            const codigo = document.createElement('h4')
            const nome = document.createElement('h3')
            const creditos = document.createElement('h4')

            //insere o codigo da disciplina no texto de código
            codigo.className = 'codigo'
            codigo.innerText = this.disciplinas[disciplina].codigo

            //insere o nome da disciplina no texto de nome
            nome.className = 'nome'
            nome.innerText = this.disciplinas[disciplina].nome

            //insere o crédito da disciplina no texto de crédito
            creditos.className = 'creditos'
            creditos.innerText = `${this.disciplinas[disciplina].creditos} créditos`

            //monta o div
            novaDisciplina.id = disciplina
            novaDisciplina.className = 'disciplina'
            novaDisciplina.appendChild(codigo)
            novaDisciplina.appendChild(nome)
            novaDisciplina.appendChild(creditos)

            //calcula a posição onde o elemento deve estar
            const posX = this.coordInicial.x + (this.pos[disciplina].col * this.tamCol);
            const posY = this.coordInicial.y + (this.pos[disciplina].lin * this.tamLin);

            novaDisciplina.style.position = `absolute`;
            novaDisciplina.style.left = `${posX}px`;
            novaDisciplina.style.top = `${posY}px`;        

            //adiciona o a nova disciplina ao documento
            this.mapa.appendChild(novaDisciplina)
        }
    }

    //Objetivo: cria os arcos entre a disciplina de entrada e as disciplina liberada por ela
     criaArco(disciplina, liberada){
        //adiciona a disciplina liberada ao documento
        this.insereDisciplina(liberada);

        const origem = document.getElementById(disciplina);
        const destino = document.getElementById(liberada);

        //cria a representação visual do arco
        //calcula as coordenadas de inicio e fim da linha
        const x1 = origem.offsetLeft + origem.offsetWidth;
        const x2 = destino.offsetLeft;
        const y1 = origem.offsetTop + origem.offsetHeight/2;
        const y2 = destino.offsetTop + destino.offsetHeight/2;

        //cria a linha
        const linha = document.createElementNS("http://www.w3.org/2000/svg", "line");
        linha.setAttribute('x1', x1);
        linha.setAttribute('x2', x2);
        linha.setAttribute('y1', y1);
        linha.setAttribute('y2', y2);
        linha.setAttribute('stroke', '#2b2b2b');
        linha.setAttribute('stroke-width', 2.5);
        linha.classList.add(`pos-${disciplina}`)
        linha.classList.add(`pre-${liberada}`)

        //coloca a seta na ponta da linha
        linha.setAttribute('marker-end', 'url(#seta)');
        linha.classList.add('linha');

        this.svg.appendChild(linha);
    }

    //Objetivo: calcula a posição (linha e coluna) no grid em que todas as disciplinas devem ser inseridas no grafo
    calculaPos(){
        let elementosPorColuna = {};
        let posicoes = {}; //{codigo: {col, lin}}
        const grafoInv = this.inverteGrafo();

        this.ordemTopo.forEach(disciplina => {
            //inicializa o nivel atual da disciplina em 0
            let nivel = 0;
            let linha;

            const pais = grafoInv[disciplina];

            //verifica se a disciplina tem pré-requisito
            if(pais.length > 0){
                //se possui pré-requisito, o nível da disciplina é o maior nível entre pré-requisitos + 1
                let maxNivelPai = 0;
                pais.forEach(pai => {
                    maxNivelPai = Math.max(maxNivelPai, posicoes[pai].col);
                })
                nivel = maxNivelPai + 1;
            }
            //se não possui pré-requisito, o nível é 0

            //limite de linhas por coluna
            const limiteLin = 5;
            while(elementosPorColuna[nivel] > limiteLin){nivel++;}

            //determina a linha com base no número de elementos existentes na coluna
            if(elementosPorColuna[nivel] === undefined){
                elementosPorColuna[nivel] = 0;
            }
            else{
                elementosPorColuna[nivel]++;
            }

            linha = elementosPorColuna[nivel];

            posicoes[disciplina] = {
                col: nivel,
                lin: linha
            }
        })

        return posicoes;
    }
    
    //Objetivo: inverte e retorna o grafo inverso
    inverteGrafo(){
    let grafoInv = {};

    //inicializa o grafo vazio
    Object.keys(this.grafo).forEach(cod => {
        grafoInv[cod] = [];
    })

    //inverte o grafo
    Object.keys(this.grafo).forEach(origem => {
        this.grafo[origem].forEach(destino => {
            grafoInv[destino].push(origem)
        })
    })
    
    return grafoInv;
    }

    //Objetivo: calcula a coordenada inicial do grafo baseado no número de linhas e colunas que a representação do grafo no grid possui
    calculaCoordInicial(){
        let xInicial = 0;
        let yInicial = 0;

        //encontra coluna e linha de maior valor
        Object.keys(this.pos).forEach(key => {
            xInicial = Math.max(xInicial, this.pos[key].col);
            yInicial = Math.max(yInicial, this.pos[key].lin);
        })

        //retorna um objeto com o as coordenadas x e y 
        return {
            x: (this.mapa.offsetLeft + this.mapa.offsetWidth)/2 - (xInicial * this.tamCol)/2,
            y: (this.mapa.offsetTop + this.mapa.offsetHeight)/2 - (yInicial * this.tamLin)/2
        }
    }

    //Objetivo: dado um nodo, destaca seus arcos de pré-requisitos e liberações
    destacaNodo(nodo){
    
        const id = nodo.id;
        //seleciona todos os arcos que conectam com o nodo
        const preNodo = document.querySelectorAll(`.pre-${id}`);
        const posNodo = document.querySelectorAll(`.pos-${id}`);
        const atual = document.querySelector('.disciplinaAtiva');

        //se existe uma disciplina ativa atualmente
        if(atual){
            //troca a classe, indicando que não é mais a disciplina ativa
            atual.classList.remove('disciplinaAtiva')
            atual.classList.add('disciplina')

            //seleciona todos os arcos que conectam com o nodo atual
            const idAtual = atual.id;
            const preAtual = document.querySelectorAll(`.pre-${idAtual}`);
            const posAtual = document.querySelectorAll(`.pos-${idAtual}`);

            //muda a cor dos arcos
            preAtual.forEach(arco => {
                arco.setAttribute('stroke', '#2b2b2b');
                arco.setAttribute('stroke-width', 2.5)
                arco.setAttribute('marker-end', 'url(#seta)');
            })
            posAtual.forEach(arco => {
                arco.setAttribute('stroke', '#2b2b2b');
                arco.setAttribute('stroke-width', 2.5)
                arco.setAttribute('marker-end', 'url(#seta)');
            })
        }

        //troca a classe do nodo, indicando que agora é a disciplina ativa
        nodo.classList.remove('disciplina')
        nodo.classList.add('disciplinaAtiva');

        //muda a cor dos arcos
        preNodo.forEach(arco => {
            arco.setAttribute('stroke', '#c71313');
            arco.setAttribute('stroke-width', 3)
            arco.setAttribute('marker-end', 'url(#setaVermelha)');
        })
        posNodo.forEach(arco => {
            arco.setAttribute('stroke', '#45ec11');
            arco.setAttribute('stroke-width', 3)
            arco.setAttribute('marker-end', 'url(#setaVerde)');
        })

        this.mudaInformacao(id);
    }

    //Objetivo, dado código da disciplina exibe suas informações na barra lateral
    mudaInformacao(codigo){
        const conteudo = Array.from(this.information.children);

        conteudo[0].textContent = this.disciplinas[codigo].codigo;
        conteudo[1].textContent = this.disciplinas[codigo].nome;
        conteudo[2].textContent = `${this.disciplinas[codigo].creditos} créditos`;
        conteudo[3].textContent = this.disciplinas[codigo].etapa === 0 ? 'eletiva' : `${this.disciplinas[codigo].etapa}ª etapa`;
        conteudo[4].textContent = this.disciplinas[codigo].responsavel;
        conteudo[6].textContent = this.disciplinas[codigo].descricao;
        
        const lista = document.getElementById('preReq');
        lista.innerHTML = "";
        const prerequisitos = JSON.parse(this.disciplinas[codigo].prerequisitos);
        const titulo = document.getElementById('titulo-preReq');

        if(Object.keys(prerequisitos).length === 0){
            titulo.style.display = 'none';
        }
        else
        {
            titulo.style.display = 'block';

            prerequisitos.forEach(cod => {
            const li = document.createElement('li');

            if(cod.startsWith('#cred')){
                const cred = cod.match(/\d+/);
                li.textContent = `${cred} créditos`
            }
            else if(this.disciplinas[cod]){
                const nomeDisciplina = this.disciplinas[cod].nome;
                li.textContent = nomeDisciplina;
            }
            else{
                li.textContent = cod;
            }
            
            li.style.fontSize = '1.2em';
            lista.appendChild(li);
        })
        }
    }
}