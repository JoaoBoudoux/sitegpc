<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

// Verifica se a faixa etária foi selecionada
if (!isset($_POST["faixa_etaria"])) {
    header("Location: dashboard.php");
    exit();
}

$faixa_etaria = $_POST["faixa_etaria"];

$faixas_etarias_legiveis = [
    "0-1a6m"   => "0 a 1 ano e 6 meses",
    "1a7m-3a11m" => "1 ano e 7 meses - 3 anos e 11 meses",
    "4a-5a11m" => "4 anos - 5 anos e 11 meses"
];

$faixa_etaria_legivel = isset($faixas_etarias_legiveis[$faixa_etaria]) ? $faixas_etarias_legiveis[$faixa_etaria] : $faixa_etaria;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planejamento Anual</title>
    <link rel="stylesheet" href="./estiloplanejamento.css">
    <script>
        function atualizarConteudo() {
        var bimestre = document.getElementById("bimestre").value;
        var campoAprendizado = document.getElementById("campo_aprendizado").value;
        var conteudo = document.getElementById("conteudo_dinamico");

        if (bimestre === "1" && campoAprendizado === "tracos") {
            conteudo.innerHTML = `
                <h3>Traços, sons, cores e formas - 1º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS01"> (EI01TS01) Explorar sons produzidos com o próprio corpo e com objetos do ambiente.</li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS02"> (EI01TS02) Traçar marcas gráficas, em diferentes suportes, usando instrumentos riscantes e tintas.</li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS03"> (EI01TS03) Explorar diferentes fontes sonoras e materiais para acompanhar brincadeiras cantadas, canções, músicas e melodias.</li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS04"> (EI01TS04) Perceber a intensidade dos sons e dos ritmos, movimentando-se de acordo com a melodia.</li>
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Explorar de diversos instrumentos musicais, relacionando-os com sua origem. <br> <br> 
                        - Brincadeiras, como formas de perceber, reconhecer e significar as diversas experiências com texturas e elementos, como água e terra, barro, tintas, feitas de alimentos e plantas, e outros. <br> <br> 
                        - Criação de sons com as mãos, papel amassado, bater na água, o balançar de objetos dentre outros. <br> <br> 
                        - Experimentação de brincadeiras que explorem movimentos e sons com o próprio corpo. <br> <br> 
                        - Utilização de móbiles com materiais sonoros (chaves, colheres, chocalhos, entre outros). <br> <br> 
                        - Brincadeira do Cesto de tesouros com objetos sonoros (chocalhos, panela, colher de pau, copos, sacolas, plástico bolha, apitos, lata, bacia, concha, caixas, tampa de panelas, rolo de papel toalha, garrafas PET). <br> <br> 
                        - Realização de pintura em diversos suportes (parede, cartaz, papel, chão, entre outros), utilizando instrumentos variados (pincel de barbear, buchas, trinchas, buchas vegetais, rolinhos, entre outros). <br> <br> 
                        - Vivências culturais musicais de acordo com as festividades regionais (Carnaval – Frevo, Maracatu, Caboclinho, São João – Xaxado, Coco, Quadrilha, forró). <br> <br>
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes"></textarea>
            `;
        } else if (bimestre === "2" && campoAprendizado === "tracos") {
            conteudo.innerHTML = `
                <h3>Traços, sons, cores e formas - 2º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS03"> (EI01TS03) Explorar diferentes fontes sonoras e materiais para acompanhar brincadeiras cantadas, canções, músicas e melodias; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS02"> (EI01TS02) Traçar marcas gráficas, em diferentes suportes, usando instrumentos riscantes e tintas; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS03"> (EI01TS03) Utilizar materiais variados com possibilidades de manipulação (argila, massa de modelar), criando objetos tridimensionais; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS05"> (EI01TS05) Imitar gestos, movimentos, sons, palavras de outras crianças e adultos, animais, objetos e fenômenos da natureza.</li>
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Brincadeiras, cantadas com diferentes ritmos. <br> <br> 
                        -  Valorização das produções das produções das crianças, a partir das marcas feitas com objetos e texturas (massinha, folhas, argila, desenho e colagem com serragem, folhas de plantas e tintas); <br> <br> 
                        - Ateliê de pinturas, usando diferentes suportes (papéis, panos, telas, gizão de cera, tintas a dedo, pincel de rolinho, carimbos com tinta, caixas de pizza, pratos de papelão fixados na parede na altura da criança, moldes vazados, molde das mãos, dos pés entre outros; sementes rasgar e colar papéis, entre outros; <br> <br> 
                        - Atividades exploratórias e produções criativas utilizando serragem, folhas secas de plantas, imagens, <br> <br> 
                        - Vivências de modelagem com massinha, argila, entre outros; <br> <br> 
                        - Brincadeiras cantadas com diferentes ritmos (A dona aranha, O sítio do seu Lobato, A canoa virou, Pirulito que bate, bate Formiguinha, entre outras). <br> <br> 
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        }  else if (bimestre === "3" && campoAprendizado === "tracos") {
            conteudo.innerHTML = `
                <h3>Traços, sons, cores e formas - 3º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS03"> (EI01TS03) Explorar diferentes fontes sonoras e materiais para acompanhar brincadeiras cantadas, canções, músicas e melodias; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS01"> (EI01TS01) Explorar sons produzidos com o próprio corpo e com objetos do ambiente; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS05"> (EI01TS05) Imitar gestos, movimentos, sons, palavras de outras crianças e adultos, animais, objetos e fenômenos da natureza; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS04"> (EI01TS04) Perceber a intensidade dos sons e dos ritmos, movimentando-se de acordo com a melodia.</li>
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Brincadeiras, cantadas com diferentes ritmos. <br> <br>
                        - Escuta de músicas de diferentes estilos, épocas e étnicas;  <br> <br>
                        - Explorar de diversos instrumentos musicais, relacionando-os com sua origem;  <br> <br> 
                        - Experimentação de brincadeiras que explorem movimentos e sons com o próprio corpo <br> <br>
                        - Criação de sons com as mãos, papel amassado, bater na água, o balançar de objetos dentre outros; <br> <br>
                        - (EI01TS05) Imitar gestos, movimentos, sons, palavras de outras crianças e adultos, animais, objetos e fenômenos da natureza; <br> <br>
                        - Promoção de situações em que as crianças também possam rabiscar, no chão, na areia, na terra ou na argila com gravetos, produzindo marcas nessas superfícies; <br> <br>
                        - Utilização de fontes sonoras, recursos tecnológicos, audiovisuais e multimídia como: CD’s, DVD’s, TV’s, vídeos, gravador, internet, entre outros. <br> <br>
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        }  else if (bimestre === "4" && campoAprendizado === "tracos") {
            conteudo.innerHTML = `
                <h3>Traços, sons, cores e formas - 4º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS01"> (EI01TS03) Explorar diferentes fontes sonoras e materiais para acompanhar brincadeiras cantadas, canções, músicas e melodias; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS02"> (EI01TS02) Traçar marcas gráficas, em diferentes suportes, usando instrumentos riscantes e tintas; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS03"> (EI01TS03) Utilizar materiais variados com possibilidades de manipulação (argila, massa de modelar), criando objetos tridimensionais; </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01TS02"> (EI01TS02) Traçar marcas gráficas, em diferentes suportes, usando instrumentos riscantes e tintas; </li>
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Explorar de diversos instrumentos musicais, relacionando-os com sua origem.  <br> <br>
                        - Criação de sons com as mãos, papel amassado, bater na água, o balançar de objetos dentre outros. <br> <br>
                        - Experimentação de brincadeiras que explorem movimentos e sons com o próprio corpo.  <br> <br> 
                        - Incentivo ao interesse pelas próprias produções dos seus pares e artistas dentre outros.  <br> <br>
                        - Experimentação de diferentes suportes (papelão, tecido, areia, lixa, entre outros), e instrumentos (bastão de cera, pincel atômico, carvão, gravetos, entre outros) na produção artística.  <br> <br>
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "1" && campoAprendizado === "eu") {
            conteudo.innerHTML = `
                <h3>Eu, o outro e o nós - 1º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EO03"> (EI01EO03) Interagir com crianças da mesma faixa etária e adultos ao explorar espaços, materiais, objetos, brinquedos;  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EO01"> (EI01EO01) Perceber que suas ações têm efeitos nas outras crianças e nos adultos;  </li>
                    
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Observação de suas características físicas, e das outras crianças com respeito às diferenças;  <br> <br>
                        - Brincadeiras e jogos que proporcionem regras de convivência em grupo;  <br> <br>
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "2" && campoAprendizado === "eu") {
            conteudo.innerHTML = `
                <h3>Eu, o outro e o nós - 2º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EO04"> (EI01EO04) Comunicar necessidades, desejos e emoções, utilizando gestos, balbucios, palavras;  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EO06"> (EI01EO06) Interagir com outras crianças da mesma faixa etária e adultos, adaptando-se ao convívio social;  </li>
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Contação de histórias de diferentes povos, e dos objetivos por eles utilizados;  <br> <br>
                        - Imersão da linguagem de sinais, através de atividades que expressem situações cotidianas da rotina em sala de aula, como chamada, músicas e roda de conversa;  <br> <br>
                        - Experiências sensoriais e visuais, com objetos de diversas texturas e cores;  <br> <br> 
                        
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "3" && campoAprendizado === "eu") {
            conteudo.innerHTML = `
                <h3>Eu, o outro e o nós - 3º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EO02"> (EI01EO02) Perceber as possibilidades e os limites de seu corpo nas brincadeiras e interações das quais participa;  </li>
                    
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Tocar seu próprio corpo, brincando com as mãos, pés e dedos; <br> <br>
                        - Brincadeiras com jogos que proporcionem regras de convivência em grupo;  <br> <br>
                        - Ambientes com brinquedos, materiais e jogos, organizados à altura das crianças; <br> <br> 
                        
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "4" && campoAprendizado === "eu") {
            conteudo.innerHTML = `
                <h3>Eu, o outro e o nós - 4º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EO05"> (EI01EO05) Reconhecer seu corpo e expressar suas sensações em momentos de alimentação, higiene, brincadeira e descanso;  </li>
                    
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Brincadeiras que proporcionem o prazer do banho, como, por exemplo, o uso do livro de banho, músicas, relacionadas ao tema, e outro;  <br> <br>
                        - Contação de história de diferentes povos, e dos objetos por eles utilizados;  <br> <br>
                        - Disponibilização de bonecos (a), com características raciais diferentes, e adereços de diversos agrupamentos culturais, nas brincadeiras de faz de conta;  <br> <br> 

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "1" && campoAprendizado === "corpo") {
            conteudo.innerHTML = `
                <h3>Corpo, gestos e movimentos - 1º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01CG01"> (EI01CG01) Movimentar as partes do corpo para exprimir corporalmente emoções, necessidades e desejos;  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01CG03"> (EI01CG03) Imitar gestos e movimentos de outras crianças, adultos e animais;  </li>
        
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Brincadeiras corporais que propiciem desafios motores, como subir em almofadas, pegar um brinquedo colocado à certa distância, ou pegar vários materiais com as mãos;  <br> <br>
                        - Conhecimentos do mundo físico com brincadeiras de entrar puxar e empurrar caixas; martelar pinos; encaixar; empilhar; passar em túneis, com colchonetes e blocos de borracha;  <br> <br>
                        
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "2" && campoAprendizado === "corpo") {
            conteudo.innerHTML = `
                <h3>Corpo, gestos e movimentos - 2º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01CG02"> (EI01CG02) Experimentar as possibilidades corporais nas brincadeiras e interações em ambientes acolhedores e desafiantes;  </li>

                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Lançamentos de desafios de percurso com subidas e descidas: andar sobre linhas e almofadas; pegar vários objetos com as mãos, os pés e os dedos; rolar no chão; dá cambalhota; engatinhar; subir, e outros;  <br> <br>
                        - Favorecimento de diferentes formas de expressão, utilizando a imitação, a dança, a música, a pintura, o desenho e a representação;  <br> <br>
                        - Brincadeiras corporais que proporcionem desafios motores, como subir em almofadas, pegar um brinquedo, colocado à certa distância, ou pegar vários materiais com as mãos;  <br> <br> 

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "3" && campoAprendizado === "corpo") {
            conteudo.innerHTML = `
                <h3>Corpo, gestos e movimentos - 3º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01CG04"> (EI01CG04) Participar do cuidado do seu corpo e da promoção do seu bem-estar;  </li>

                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Brincadeiras corporais que propiciem desafios motores, como subir em almofadas, pegar um brinquedo, colocado à certa distância, ou pegar vários materiais com as mãos;  <br> <br>
                        - Identificação da imagem no espelho favorecendo a distinção entre si, os objetos, os outros e o mundo;  <br> <br>
                        - Brincadeiras, como forma de expressão, e oportunidade de manifestação da individualidade e construção da identidade da criança, sem restrições em relação a gênero; <br> <br> 

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "4" && campoAprendizado === "corpo") {
            conteudo.innerHTML = `
                <h3>Corpo, gestos e movimentos - 4º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01CG05"> (EI01CG05) Utilizar os movimentos de preensão, encaixe e lançamento, ampliando suas possibilidades de manuseio de diferentes materiais e objetos;  </li>

                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Conhecimento do mundo físico com brincadeiras de entrar, puxar e empurrar caixas; empilhar; passar em túneis, com colchonetes e blocos de borracha;  <br> <br>
                        - Exploração e conhecimento do mundo, com os órgãos sensoriais, através da manipulação de brinquedos com diferentes formas e textura, cores odores, sabores e sons; montar cestos com pente, escovas, sinos, bonecos (a) de plástico e pano, e argola; chaveiros com chaves, bolas de tecido, borracha e madeira; sacos aromáticos de ervas;  <br> <br> 

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "1" && campoAprendizado === "escuta") {
            conteudo.innerHTML = `
                <h3>Escuta, fala, pensamento e imaginação - 1º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF01"> (EI01EF01) Reconhecer quando é chamado por seu nome e reconhecer os nomes de pessoas com quem convive;  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF02"> (EI01EF02) Demonstrar interesse ao ouvir a leitura de poemas e a apresentação de músicas;  </li>

                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Vivências que possibilitem o conhecimento dos nomes das crianças e o seu próprio, através de cantigas de rodas, chamadinhas e fotos;  <br> <br>
                        - Realização de leitura de diferentes gêneros textuais, com destaque em imagens e letras;  <br> <br>
                        - Utilização das crianças especialmente em rodas de conversas com leituras e cantigas;  <br> <br> 

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "2" && campoAprendizado === "escuta") {
            conteudo.innerHTML = `
                <h3>Escuta, fala, pensamento e imaginação - 2º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF03"> (EI01EF03) Demonstrar interesse ao ouvir histórias lidas ou contadas, observando ilustrações e os movimentos de leitura do adulto-leitor (modo de segurar o portador e de virar as páginas);  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF07"> (EI01EF07) Conhecer e manipular materiais impressos e audiovisuais em diferentes portadores (livro, revista, gibi, jornal, cartaz, CD, tablet etc.);  </li>

                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Valorização da cultura das crianças deixando-as contar o que gostam de fazer em suas casas, respeitando as experiências vividas, ampliando assim suas narrativas;  <br> <br>
                        - Participar de roda de conversa com interação entre crianças e adultos; <br> <br>
                        - Demonstrar interesse em histórias lidas e contadas inseridas no contexto da aula observando o movimento das páginas;  <br> <br> 
                        - Praticar leitura visual em grupo com livros diversos observando imagens e reconhecendo personagens a qual histórias se refere; <br> <br>

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "3" && campoAprendizado === "escuta") {
            conteudo.innerHTML = `
                <h3>Escuta, fala, pensamento e imaginação - 3º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF04"> (EI01EF04) Reconhecer elementos das ilustrações de histórias, apontando-os, a pedido do adulto-leitor;  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF05"> (EI01EF05) Imitar as variações de entonação e gestos realizados pelos adultos, ao ler histórias e ao cantar;  </li>
                    
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Escuta das crianças, deixando-as falar de situações ou brincadeiras que aprenderam nos ambientes, pelos quais circularam antes de sua vinda a escola;  <br> <br>
                        - Identificação por meio de imagens, pinturas e/ ou produções de desenhos, quais os brinquedos, materiais e brincadeiras, preferidos pelas crianças, construindo, coletivamente, gráficos, listas, painéis, jogos, entre outros;  <br> <br> 
                        - Reconto das histórias, a partir da apreciação delas;  <br> <br>
        
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "4" && campoAprendizado === "escuta") {
            conteudo.innerHTML = `
                <h3>Escuta, fala, pensamento e imaginação - 4º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF06"> (EI01EF06) Comunicar-se com outras pessoas usando movimentos, gestos, balbucios, fala e outras formas de expressão;  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF08"> (EI01EF08) Participar de situações de escuta de textos em diferentes gêneros textuais (poemas, fábulas, contos, receitas, quadrinhos, anúncios etc.);  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01EF09"> (EI01EF09) Conhecer e manipular diferentes instrumentos e suportes de escrita;  </li>
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Produção de desenhos e pinturas livres e com temas sugeridos de interesse das crianças, com diferentes tipos de materiais, criando oportunidades para ampliar experiências;  <br> <br>
                        - Realização de atividades coletivas com a utilização de letras, e outros sinais gráficos, para que sejam agrupados, de acordo com suas características; <br> <br>
                        - Expressão oral de histórias e outros gêneros, contados e interpretados por meio de desenhos ou pinturas;  <br> <br> 

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "1" && campoAprendizado === "espacos") {
            conteudo.innerHTML = `
                <h3>Espaços, tempos, quantidades, relações e transformações - 1º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01ET01"> (EI01ET01) Explorar e descobrir as propriedades de objetos e materiais (odor, cor, sabor, temperatura);  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01ET02">(EI01ET02) Explorar relações de causa e efeito (transbordar, tingir, misturar, mover e remover etc.) na interação com o mundo físico;  </li>

                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Exploração dos ambientes naturais (jardim da escola);  <br> <br>
                        - Experiência de cuidados com os recursos naturais (água, plantas, entre outros.);  <br> <br>
                        - Manipulação e exploração de diversos objetos, alimentos, plantas que permitam descobertas sensoriais: cheirar, morder, ouvir, olhar, ouvir, degustar e outras;  <br> <br> 
                        - Brincadeiras com areia água, argila, barro, pedrinhas, gravetos e folhas, experimentando transformações com esses elementos;  <br> <br>
                        - Resolução de situações problemas que mobilizem as noções de tirar, acrescentar, dividir ou outras;  <br> <br>
                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "2" && campoAprendizado === "espacos") {
            conteudo.innerHTML = `
                <h3>Espaços, tempos, quantidades, relações e transformações - 2º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01ET03"> (EI01ET03) Explorar o ambiente pela ação e observação, manipulando, experimentando e fazendo descobertas;  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01ET05"> (EI01ET05) Manipular materiais diversos e variados para comparar as diferenças e semelhanças entre eles;  </li>
                    
                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Exploração que favoreça as descobertas de objetos, quanto à possibilidade de encaixá-los, empilhá-los, fazê-los rolar, e outras;  <br> <br>
                        - Participação em brincadeiras e jogos que incentivem a descoberta da noção de quantidade/número;  <br> <br>
                        - Representação por desenhos de características do ambiente natural e social do entorno da criança;  <br> <br> 

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "3" && campoAprendizado === "espacos") {
            conteudo.innerHTML = `
                <h3>Espaços, tempos, quantidades, relações e transformações - 3º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01ET04"> (EI01ET04) Manipular, experimentar, arrumar e explorar o espaço por meio de experiências de deslocamentos de si e dos objetos;  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01ET03"> (EI01ET03) Explorar o ambiente pela ação e observação, manipulando, experimentando e fazendo descobertas;  </li>

                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Realização de brincadeiras ao guardar objetos com destaque para posições e distâncias nos percursos realizados;  <br> <br>
                        - Comparação e classificação de objetos com características, relacionadas ao peso (leve/pesado); ao volume (cheio/vazio); à espessura (grosso/fino) à textura(liso/áspero/macio); cor e forma;  <br> <br> 
                        - Brincadeiras com areia água, argila, barro, pedrinhas, gravetos e folhas, experimentando transformações com esses elementos;  <br> <br>

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        } else if (bimestre === "4" && campoAprendizado === "espacos") {
            conteudo.innerHTML = `
                <h3>Espaços, tempos, quantidades, relações e transformações - 4º Bimestre</h3>
                <p>Selecione os conteúdos explorados:</p>
                <ul>
                    <li><input type="checkbox" name="conteudos[]" value="EI01ET06"> (EI01ET06) Vivenciar diferentes ritmos, velocidades e fluxos nas interações e brincadeiras (em danças, balanços, escorregadores etc.);  </li>
                    <li><input type="checkbox" name="conteudos[]" value="EI01ET02"> (EI01ET02) Explorar relações de causa e efeito (transbordar, tingir, misturar, mover e remover etc.) na interação com o mundo físico;  </li>

                </ul>
                <h4>Propostas de Exploração</h4>

                <p>
                        - Experiências com o uso dos brinquedos (escorrego, cavalinhos, velocípedes e labirintos) para sentir as velocidades;  <br> <br>
                        - Manipulação e exploração de objetos com características, relacionadas ao peso (leve/pesado); ao volume (cheio/vazio); à espessura (grosso/fino); à textura (liso/áspero/macio), cor e forma;  <br> <br>

                </p>

                <label for="observacoes">Avaliação do Professor:</label>
                <textarea id="observacoes" name="observacoes" required></textarea>
            `;
        }
        
        else {
            conteudo.innerHTML = "<p>Selecione um bimestre e um campo de aprendizado para exibir os conteúdos.</p>";
        }
    }
    </script>
</head>
<body>
    <header>
        <img src="planetinha.png" alt="Logo do Colégio" class="logo">
        <div class="user-area">
            <span class="user-info">Bem-vindo: <?php echo htmlspecialchars($_SESSION['login']); ?></span>
            <button onclick="history.back()" class="back-button">Voltar</button>
            <button class="logout-button" onclick="window.location.href='logout.php'">Sair</button>
        </div>
    </header>
    
    <main>
        <h2>Planejamento Anual - Faixa Etária: <?php echo htmlspecialchars($faixa_etaria_legivel); ?></h2>

        <form action="salvar_planejamento.php" method="POST">
            <input type="hidden" name="faixa_etaria" value="<?php echo htmlspecialchars($faixa_etaria); ?>">

            <label for="bimestre">Selecione o Bimestre:</label>
            <select id="bimestre" name="bimestre" onchange="atualizarConteudo()" required>
                <option value="">Selecione...</option>
                <option value="1">1º Bimestre</option>
                <option value="2">2º Bimestre</option>
                <option value="3">3º Bimestre</option>
                <option value="4">4º Bimestre</option>
            </select>

            <label for="campo_aprendizado">Selecione o Campo de Aprendizado:</label>
            <select id="campo_aprendizado" name="campo_aprendizado" onchange="atualizarConteudo()" required>
                <option value="">Selecione...</option>
                <option value="tracos">Traço, sons, cores e formas</option>
                <option value="eu">Eu, o outro e o nós</option>
                <option value="corpo">Corpo, gestos e movimentos</option>
                <option value="escuta">Escuta, fala, pensamento e imaginação</option>
                <option value="espacos">Espaços, tempos, quantidades, relações e transformações</option>
            </select>

            <div id="conteudo_dinamico">
                <p>Selecione um bimestre e um campo de aprendizado para exibir os conteúdos.</p>
            </div>

            <button type="submit">Salvar Planejamento</button>
        </form>
    </main>
</body>
</html>
