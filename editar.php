<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php
    require_once "conexao.php";

    try{
        if(isset($_REQUEST["ed"])){
            $cod_salario = $_REQUEST["ed"];
            $consulta = $conn->prepare("SELECT * FROM tb_funcionario WHERE cod_salario = :cod_salario");
            $consulta->bindValue(':cod_salario', $cod_salario);
            $consulta->execute();
            $row=$consulta -> fetch(PDO::FETCH_ASSOC);
        }
    }catch(PDOException $erro){
        echo $erro->getMessage();
    }
?>
<fieldset>
    <form action="editar.php" method="post">
        <label> Id da folha: </label><br>
        <input type="text" name="cod_salario" value="<?php if(isset($row['cod_salario'])){ echo $row['cod_salario'];}?>" readonly required><br><br>

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php if(isset($row['nome'])){echo $row['nome'];}?>" required><br><br>

        <label>Salário _base</label><br>
        <input type="text" name="salario_base" value="<?php if(isset($row['salario_base'])){echo $row['salario_base'];}?>" required><br><br>

        <label>Número de horas extras</label><br>
        <input type="text" name="hrs_extra" value="<?php if(isset($row['hrs_extra'])){echo $row['hrs_extra'];}?>" required><br><br>

        <label>vlr de horas extras</label><br>
        <input type="text" name="vlr_hr_extra" value="<?php if(isset($row['vlr_hr_extra'])){echo $row['vlr_hr_extra'];}?>" required><br><br>

        <label>Número de dependentes:</label><br>
        <input type="text" name="n_dependentes" value="<?php if(isset($row['n_dependentes'])){echo $row['n_dependentes'];}?>" required><br><br>

        <input type="submit" name="bt_alterar" value="Alterar">
    </form>

    <p><a href="exemplo02.php">Voltar para a página de cadastro/consulta</a></p>

</fieldset>
<body>
    <?php
        
        try{
    
            if(ISSET($_REQUEST["bt_alterar"]))
            {
                /* recebe os dados do formulário */
                $cod_salario = $_REQUEST["cod_salario"];
                $nome = $_REQUEST["nome"];
                $salario_base = $_REQUEST["salario_base"];
                $hrs_extra = $_REQUEST["hrs_extra"];
                $vlr_hr_extra = $_REQUEST["vlr_hr_extra"];
                $n_dependentes = $_REQUEST["n_dependentes"];
        
                $salariobruto = $salario_base + ( $hrs_extra * $vlr_hr_extra) + ( $n_dependentes * 45);
        
                if ( $salariobruto <= 1659.38){
                    $perdesc = 0.08;
                }
                if ( $salariobruto <= 2765.31){
                    $perdesc = 0.09;
                }
                if ( $salariobruto <= 5531.31){
                    $perdesc = 0.11;
                }
                else{
                    $perdesc = 608.44;
                }
        
                $inss = $salariobruto * $perdesc;
        
                /* ir */
        
                if ( $salariobruto <= 1903.98 ){
                    $ir = 0;
                }
        
                if (($salariobruto >= 1903.99 ) && ($salariobruto <= 2826.65 )){
                    $ir = ($salariobruto * 0.075) - 142.80;
                }
        
                if (($salariobruto >= 2826.66 ) && ($salariobruto <= 3751.05 )){
                    $ir = ($salariobruto * 0.15) - 354.80;
                }
        
                if (($salariobruto >= 3751.06 ) && ( $salariobruto <= 4664.68 )){ 
                    $ir = ($salariobruto * 0.225) - 636.13;
                }
        
                if ( $salariobruto > 4664.69 ){
                    $ir = ($salariobruto * 0.275) - 869.36;
                }
        
                $salario = $salariobruto - $inss - $ir;
        
        
                //aqui faz a alteração na tabela
                $sql = $conn->prepare("UPDATE tb_funcionario SET nome = :nome, salario_base = :salario_base, hrs_extra = :hrs_extra, n_dependentes = :n_dependentes, salario_bruto = :salario_bruto, inss = :inss, ir = :ir, salario_liquido = :salario_liquido, vlr_hr_extra = :vlr_hr_extra
                                        WHERE cod_salario = :cod_salario");
        
                $sql->bindValue(':cod_salario', $cod_salario);
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':salario_base',  $salario_base);
                $sql->bindValue(':hrs_extra', $hrs_extra);
                $sql->bindValue(':n_dependentes', $n_dependentes);
                $sql->bindValue(':salario_bruto', $salariobruto);
                $sql->bindValue(':inss', $inss);
                $sql->bindValue(':ir', $ir);
                $sql->bindValue(':salario_liquido', $salario);
                $sql->bindValue(':vlr_hr_extra', $vlr_hr_extra);

                $sql->execute();
        
                echo"<script language=javascript>alert('Alteração efetuada com Sucesso !!'); location.href = 'exemplo02.php';</script>";
            }
        }catch (PDOException $erro){
            echo $erro->getMessage();
        }
    ?>
</body>
</html>