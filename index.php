<!doctype html>
<html>
<head>
 <title>
   CALENDARIO
 </title>

 <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #ccc;
        }

        td {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        h2 {
            margin-top: 30px;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        select {
            margin: 10px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>

</head>
<body>
 
  <h1>Calendário</h1>

  <form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <label for="mes">Selecione o mês:</label>
    <select name="mes" id="mes">

  <?php

  $mesAtual = date('m');
  $meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
  
  foreach ($meses as $indice => $mes){ 
   $selected = ($indice + 1 == $mesAtual) ? 'selected' : '';
   echo "<option value='". ($indice + 1) ."' $selected>$mes</option>";
  }

  ?>

</select>

<label for="ano">Selecione o ano:</label>
<select name="ano" id="ano">
  <?php

  $anoAtual = date('Y');
  $anoInicial = $anoAtual - 2000;
  $anoFinal = $anoAtual + 1000;

  for ($ano = $anoInicial; $ano <= $anoFinal; $ano++){
   $selected = ($ano == $anoAtual) ? 'selected' : '';
   echo "<option value='". $ano ."' $selected>$ano</option>";
  }
  ?>
</select>

   <input type="submit" value="Mostrar">
  </form>

  <?php

  if (isset($_GET['mes']) && isset($_GET['ano'])) {
   $mesSelecionado = $_GET['mes'];
   $anoSelecionado = $_GET['ano'];

   //Define o primeiro dia do mês selecionado
   
   $primeiroDia = mktime(0, 0, 0, $mesSelecionado, 1, $anoSelecionado);

   //Obtém o número de dias no mês selecionado

   $numeroDias = date('t', $primeiroDia);

   //Obtém o índice do dia da semana do primeiro dia do mês
   // (0 - domingo, 1 - segunda, ..., 6 - sábado)

   $indiceDiaSemana = date('w', $primeiroDia);

   //Define um array com os nomes dos dias da semana

   $diasSemana = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado');

   //Exibe o mês e o ano selecionado 

   echo "<h2>{$meses[$mesSelecionado - 1]} {$anoSelecionado}</h2>";

   //Cria a tabela do calendário

   echo "<table>";
   echo "<tr>";

   //Exibe os nomes dos dias da semana

   foreach ($diasSemana as $dia) {
     echo "<th>{$dia}</th>";
   }
   echo "</tr>";

   //Calcula o número total de células da tabela

   $totalCelulas = $numeroDias + $indiceDiaSemana;

   //Calcula o número de linhas necessárias 

   $numeroLinhas = ceil($totalCelulas / 7);

   //Variável para controlar o dia atual

   $diaAtual = 1;

   //Cria as células da tabela
   for ($linha = 1; $linha <= $numeroLinhas; $linha++) {
    echo "<tr>";
    for ($coluna = 0; $coluna < 7; $coluna++) {
     echo "<td class='celula' onclick='adicionarAnotacao(this)'>";
     if ($linha == 1 && $coluna < $indiceDiaSemana) {
       //Células vazias antes do primeiro dia do mês
       echo "&nbsp;";
     } else {
       //Exibe o número do dia atual
       if ($diaAtual <= $numeroDias) {
         echo $diaAtual;
         $diaAtual++;
       }
     }
     echo "</td>";
    }
    echo "</tr>";
   }
   echo "</table>";
  }
  ?>

<script>
        function adicionarAnotacao(celula) {
            var anotacao = prompt("Digite a anotação:");
            celula.innerHTML += "<br><span class='anotacao'>" + anotacao + " <a href='#' onclick='apagarAnotacao(this)'>Apagar</a></span>";
        }

        function apagarAnotacao(link) {
            var anotacao = link.parentNode;
            anotacao.parentNode.removeChild(anotacao);
        }
    </script>

    <style>
        .anotacao {
            font-size: 12px;
            color: #888;
        }

        .anotacao a {
            color: red;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
 


</body>
</html>