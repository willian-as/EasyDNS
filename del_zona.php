<?php

	session_start();

	// Abrindo conexão novamente ssh //
	$connect_ssh = ssh2_connect($_SESSION['ipserver'], 22);
	if(ssh2_auth_password($connect_ssh, $_SESSION['login'], $_SESSION['password'])){
    		echo "Conectado..."."<br>";
    	}

	// Iniciando Deletagem das linha... //

	$remote_file = "/etc/bind/named.conf.local";		//way arq a ser copiado
	$local_file = "/tmp/named.conf.local.cpy";		//way arq copiado
	$local_file_modif = "/tmp/named.conf.local.cpy.alt";	//way arq alterado

	// Copiando arquivo do server remote e testando se houver falha...returna false
	if(!ssh2_scp_recv($connect_ssh, $remote_file, $local_file)){
		return false;
	}

	//Abrir file
	$file_original = fopen($local_file, 'r');	//abri arq para leitura
	$file_alterado = fopen($local_file_modif, 'w');	//cria um arq zerado

	// Var. para avisar se deve copiar ou não linha atual do laço
	$delete_line = false;

	//var. para ir increment. ate chegar a 4, q deve ser quando deve parar de excluir as linhas
	$cont = 0;
	for($i=0;;$i++) {

		$linha = fgets($file_original);
		if(strstr($linha, $_GET['domain']) || $delete_line ){
			//Foi localizado aqui a linha q deve ser deletada
			// Juntamente com as 2 seguintes portanto...
			$delete_line = true;
			$cont++;
			//Ele cont++ porq precisa deletar 4 linhas entao testa no if
			// Se chegar a 4 linhas deletadas $delete_line = false para parar de excluir
			// Ou seja, continuar a copiar..
			if($cont == 4){
				// Recebe para false, pq eh quando deve parar de excluir,  ou 
				// no caso agora comecar a copiar as linha restantes do file original
				$delete_line = false;
			}
		}else{
			//escreve linha do arq original
			fwrite($file_alterado, $linha); 
		}
		if ($linha==null) break;
	}

	//fechando arquivos
	fclose($file_original);
	fclose($file_alterado);

	ssh2_scp_send($connect_ssh, $local_file_modif, $remote_file);

	// retornando para page zonas-diretas...
	header('Location:index.php?page=zonas-diretas');

?>
