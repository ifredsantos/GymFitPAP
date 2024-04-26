<?php
    // ==================================================
    // Classe para gestão da base de dados
    // ==================================================
    class BDGestor
    {
        private $host;
        private $user;
        private $psw;
        private $db;
        private $charset;

        public function __construct($server, $bdUtilizador, $bdPsw, $bdNome, $charset = "utf8")
        {
            $this->host = $server;
            $this->user = $bdUtilizador;
            $this->psw = $bdPsw;
            $this->db = $bdNome;
            $this->charset = $charset;
        }

        function exe_query($query, $param = null) {
            $result = null;

            $connect = new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset='.$this->charset,$this->user,$this->psw,array(PDO::ATTR_PERSISTENT => TRUE));
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if($param != null) {
                $gest = $connect->prepare($query);
                $gest->execute($param);
                $result = $gest->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $gest = $connect->prepare($query);
                $gest->execute();
                $result = $gest->fetchAll(PDO::FETCH_ASSOC);
            }

            $connect = null;

            return $result;
        }

        function exe_non_query($query, $param = null) {
            $success = false;

            $connect = new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset='.$this->charset,$this->user,$this->psw,array(PDO::ATTR_PERSISTENT => TRUE));
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $connect->beginTransaction();

            try {
                if($param != null) {
                    $gest = $connect->prepare($query);
                    $gest->execute($param);
                } else {
                    $gest = $connect->prepare($query);
                    $gest->execute();
                }
                $connect->commit();

                $success = true;

            } catch (PDOException $e) {
                echo '<p>'.$e.'</p>';
                $connect->rollBack();
                $success = false;
            }
            
            $connect = null;
            return($success);
        }
    }
?>