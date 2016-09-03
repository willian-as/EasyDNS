<?php

// Classe Zona, adiciona, remove, .......

	class Zona{

		public $domain;
		public $type;


		//Contrutor passa 2 paramentros
		public function __construct($domain, $type){
			$this->domain = $domain;
			$this->type = $type;
		}

		public function dominioInvertido($reverse){
		//Recebe: empresa.com.br
		//Retorna: br.com.empresa
			$array = explode(".", $reverse);
	        	$array_reverse = array_reverse($array);
		        $invert = implode(".", $array_reverse);
			return $invert;
		}

		public function getDomain(){
			return "Valor domain: $this->domain";
		}

		public function add($conection){
			$remote_file = "/etc/bind/named.conf.local";	
			$local_file = "/tmp/named.conf.local.cpy"; 	

			// Copiando arquivo do server remote
			if(!ssh2_scp_recv($conection, $remote_file, $local_file)){
				echo "nao copiou..";
				return false;
		}

		ssh2_exec($conection, "echo 'zone $this->domain {' >> $remote_file");
		ssh2_exec($conection, "echo '	type $this->type;' >> $remote_file");
		ssh2_exec($conection, "echo '	file /etc/bind/db.$this->domain;' >> $remote_file");
		ssh2_exec($conection, "echo '};' >> $remote_file");
		return true;
		}

		public function addreverse($conection){
			$remote_file = "/etc/bind/named.conf.local";	
			$local_file = "/tmp/named.conf.local.cpy"; 	
			if(!ssh2_scp_recv($conection, $remote_file, $local_file)){
				echo "nao copiou..";
				return false;
		}

		$revert= dominioInvertido($this->domain);
		ssh2_exec($conection, "echo 'zone $revert.in.addr.arpa {' >> $remote_file");
		ssh2_exec($conection, "echo '	type $this->type;' >> $remote_file");
		ssh2_exec($conection, "echo '	file /etc/bind/db.$revert;' >> $remote_file");
		ssh2_exec($conection, "echo '};' >> $remote_file");
		return true;
		}


		//Registros de Recursos Dominio - Hosts cadastrados no dominio
		public function getRRDominio($conection, $domain){
			$remote_file = "/etc/bind/db.$domain";
			$local_file = "/tmp/db.$domain.cpy";

			// Copiando arquivo do server remote
			if(!ssh2_scp_recv($conection, $remote_file, $local_file)){
				return false;
			}

			// Transforma o arquivo na string e guarda...
			$convert = explode("\n", $file);

			$array = array(); //array para guardar dados resgatados..
			for ($i=8, $k=0; $i<count($convert); $i++, $k++) {
				$array[$k] = explode("	", $convert[$i]);
			}

			return $array;
		}

		// Pesquisa zona pelo seu domain(que deve ser passado como parametro)
		// retornar array com dados da zona
		public function pesquisaZona($conection, $domain){

			$remote_file = "/etc/bind/named.conf.local";	
			$local_file = "/tmp/named.conf.local.cpy"; 	

			// Copiando arquivo do server remote
			if(!ssh2_scp_recv($conection, $remote_file, $local_file)){
				return false;
			}

			$file = file_get_contents($local_file);
			$convert = explode("\n", $file);
			$encontrado = false;

			for ($i=0; $i < count($convert); $i++) {
				if(strstr($convert[$i], $domain)){
					$type = explode(" ", $convert[$i+1]);
					$file = explode(" ", $convert[$i+2]);
					$encontrado = true;
					break;

				}
			}

			if(!$encontrado){
				return false;
			}

			$array = array('0' => $type[1], '1' => $file[1]);

			return $array;
		}


		public function toString(){
			return "domain:$this->domain; type:$this->type";
		}


	}

?>
