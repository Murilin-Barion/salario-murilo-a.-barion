<html>
	<head>
		<title>Salário</title>
	</head>
	<body>
		
		<h1>Salário</h1>

		<form action="exemplo02.php" method="post" name="form1">

		<p>Nome do funcionário: </p>
		<input type="text" name="nomeFunc">

		<p>Salário base: </p>
		<input type="text" name="sBase">

		<p>Horas extras: </p>
		<input type="text" name="nHrExtra">

		<p>Valor de horas extras: </p>
		<input type="text" name="vHrExtra">

		<p>Nº de dependentes: </p>
		<input type="text" name="nDependentes"> <br> <br>

		<input type="submit" value="Enviar" name="enviar">
		</form>
		<?php

			require_once "conexao.php";

			if(isset($_REQUEST["enviar"]))
			{
				$sBase = $_REQUEST["sBase"];
				$nHrExtra = $_REQUEST["nHrExtra"];
				$vHrExtra = $_REQUEST["vHrExtra"];
				$nDependentes = $_REQUEST["nDependentes"];
				$nomeFunc = $_REQUEST["nomeFunc"];
				$sBruto = $sBase + $nHrExtra * $vHrExtra + $nDependentes * 45;

				if ($sBruto < 1659.39) 
				{
					$inss = $sBruto * (0.08);
				}
				elseif ($sBruto < 2765.67)
				{
					$inss = $sBruto * (0.09);
				}
				elseif ($sBruto < 5531.32) 
				{
					$inss = $sBruto * (0.11);
				}
				elseif ($sBruto >= 5531.32) 
				{
					$inss = $sBruto - 608.44;
				}

				if ($sBruto < 1903.99)
				{
					$iR = 0;
				}
				elseif ($sBruto < 2826.66)
				{
					$aliquota = $sBruto * 0.075;
					$iR = ($sBruto * 0.075) - 142.8;
				}
				elseif ($sBruto < 3751.06)
				{
					$aliquota = $sBruto * 0.15;
					$iR = ($sBruto * 0.15) - 354.8;
				}
				elseif ($sBruto < 4664.69)
				{
					$aliquota = $sBruto * (0.225);
					$iR = $sBruto - ($aliquota - 638.13);
				}
				elseif ($sBruto >= 4464.69)
				{
					$aliquota = $sBruto * (0.275);
					$iR = $sBruto - ($aliquota - 869.39);
				}

				$sLiquido = $sBruto - $inss - $iR;
				
			try{
				$sql = $conn->prepare("INSERT INTO tb_funcionario(cod_salario, nome, salario_base, hrs_extra, n_dependentes, salario_bruto, inss, ir, salario_liquido, vlr_hr_extra, ativo)
										VALUES (:cod_salario, :nome, :salario_base, :hrs_extra, :n_dependentes, :salario_bruto, :inss, :ir, :salario_liquido, :vlr_hr_extra, :ativo)");

				$sql->bindValue(':cod_salario', null);
				$sql->bindValue(':nome', $nomeFunc);
				$sql->bindValue(':salario_base', $sBase);
				$sql->bindValue(':hrs_extra', $nHrExtra);
				$sql->bindValue(':vlr_hr_extra', $vHrExtra);
				$sql->bindValue(':n_dependentes', $nDependentes);
				$sql->bindValue(':salario_bruto', $sBruto);
				$sql->bindValue(':inss', $inss);
				$sql->bindValue(':ir', $iR);
				$sql->bindValue(':salario_liquido', $sLiquido);
				$sql->bindValue(':ativo', 1);

				$sql->execute();

				echo "Dados gravados com sucesso!";
			}
			catch (PDOException $erro){
                echo $erro->getMessage();
            }
			}
		?>

		<table border=1>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Salário Base</th>
                <th scope="col">Números de Horas extra</th>
                <th scope="col">Valor das horas extras</th>
                <th scope="col">Dependentes</th>
				<th scope="col">Salário Bruto</th>
				<th scope="col">Desconto do inss</th>
				<th scope="col">Imposto de Renda</th>
				<th scope="col">Salário Liquido</th>
				<th scope="col">Ações</th>
			</tr>
        <?php
            try{
                $consulta = $conn->prepare("SELECT * FROM tb_funcionario tb_ WHERE ativo= 1");
                $consulta->execute();

                while($row = $consulta->fetch(PDO::FETCH_ASSOC)){
                ?>
                    <tr>
                        <td><?php echo $row["nome"]?></td>
                        <td><?php echo $row["salario_base"]?></td>
                        <td><?php echo $row["hrs_extra"]?></td>
                        <td><?php echo $row["vlr_hr_extra"]?></td>
                        <td><?php echo $row["n_dependentes"]?></td>
						<td><?php echo $row["salario_bruto"]?></td>
						<td><?php echo $row["inss"]?></td>
						<td><?php echo $row["ir"]?></td>
						<td><?php echo $row["salario_liquido"]?></td>
                        <td>
                            <a href="exemplo02.php?id=<?php echo $row["cod_salario"]; ?>">Detalhes</a>
                            <a href="editar.php?ed=<?php echo $row["cod_salario"]; ?>">Alterar</a>
                            <a href="exemplo02.php?ex=<?php echo $row["cod_salario"]; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php
                }
            }
            catch (PDOException $erro){
                echo $erro->getMessage();
            }

            try{
                if(ISSET($_REQUEST["ex"])){
                    $cod_salario = $_REQUEST["ex"];
                    //$delete = $conn->prepare("DELETE FROM tb_boletim WHERE cod_boletim=:cod_boletim;");
                    $delete = $conn->prepare("UPDATE tb_funcionario SET ativo = 0 WHERE cod_salario=:cod_salario;");
                    $delete->bindValue(':cod_salario', $cod_salario);
                    $delete->execute();

                    echo"Dados excluidos com sucesso";
                    header("location:exemplo02.php"); //atualizar página
                }
            }
            catch (PDOException $erro){
                echo $erro->getMessage();
            }
                ?>
        </table>
	</body>
</html>