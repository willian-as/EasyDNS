<?php

	session_start();

	$connect_ssh = ssh2_connect($_SESSION['ipserver'], 22);
	if(ssh2_auth_password($connect_ssh, $_SESSION['login'], $_SESSION['password'])){
    		echo "Conectado..."."<br>";
    	}

	$remote_file = "/etc/bind/named.conf.local";	
	$local_file = "/tmp/named.conf.local.cpy";	
	$local_file_modif = "/tmp/named.conf.local.cpy.alt";	

	// Copiando arquivo do server remote e testando se houver falha...retorna false
	if(!ssh2_scp_recv($connect_ssh, $remote_file, $local_file)){
		return false;
	}

	//Abrir file
	$file_original = fopen($local_file, 'r');	//abri arq. para leitura
	$file_alterado = fopen($local_file_modif, 'w');	//cria um arq. zerado

	$delete_line = false;

	$cont = 0;
	for($i=0;;$i++) {

		$linha = fgets($file_original);
		if(strstr($linha, $_GET['domain']) || $delete_line ){
			$delete_line = true;
			$cont++;
			if($cont == 4){
				$delete_line = false;
			}
		}else{
			fwrite($file_alterado, $linha); 
		}
		if ($linha==null) break;
	}

	//fechando arquivos
	fclose($file_original);
	fclose($file_alterado);

	ssh2_scp_send($connect_ssh, $local_file_modif, $remote_file);

	header('Location:index.php?page=zonas-diretas');

?>
