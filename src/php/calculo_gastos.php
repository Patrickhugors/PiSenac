<?php
session_start();

// Obtém o ID do usuário ativo na sessão
$idUsuario = $_SESSION['id_usuario'];

// Função para obter o último valor da tarifa
function obterUltimoValorTarifa($conexao) {
  $query = "SELECT valor FROM tarifa ORDER BY id DESC LIMIT 1";
  $resultado = $conexao->query($query);

  if ($resultado && $resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    return $row['valor'];
  }

  return 0; // Valor padrão se não houver registros
}

// Função para calcular o gasto de um eletrodoméstico
function calcularGastoEletrodomestico($conexao, $potencia, $horas, $quantidade, $tarifa) {
  $consumoDiario = $potencia * $horas * $quantidade;
  $consumoMensal = $consumoDiario * 30;
  $gastoMensal = $consumoMensal * $tarifa;

  return $gastoMensal;
}

$mysqli = new mysqli("localhost", "root", "", "clientes");

if ($mysqli->connect_error) {
    die('A conexão falhou: ' . $mysqli->connect_error);
} else {
    // Obtém o último valor da tarifa
    $tarifa = obterUltimoValorTarifa($mysqli);

    // Consulta os eletrodomésticos do usuário ativo na sessão
    $query = "SELECT * FROM eletro WHERE id_usuario = $idUsuario";
    $resultado = $mysqli->query($query);

    // Inicializa uma variável para armazenar o total de gastos
    $totalGastos = 0;

    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $nome = $row['nome'];
            $consumo = $row['consumo'];
            $horas = $row['horas'];
            $quantidade = $row['quantidade'];

            // Calcula o gasto do eletrodoméstico atual
            $gastoEletrodomestico = calcularGastoEletrodomestico($mysqli, $consumo, $horas, $quantidade, $tarifa);

            // Incrementa o gasto ao total
            $totalGastos += $gastoEletrodomestico;

            // Exibe o nome e o gasto do eletrodoméstico atual
            echo "<li>
                    <span class='item-name'>$nome</span>
                    <span class='item-usage'>R$" . number_format($gastoEletrodomestico, 2, ',', '') . "</span>
                  </li>";
        }
    }
    // Exibe o total de gastos no mês
    echo "<li class='total'>
            <span class='item-name'>Total</span>
            <span class='item-usage'>R$" . number_format($totalGastos, 2, ',', '') . "</span>
          </li>";

    $mysqli->close();
}
?>
