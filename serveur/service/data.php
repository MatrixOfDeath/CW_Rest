<?php
	
class data {
    public $result;

    public function __construct(){
        session_start();
        if(empty($_SESSION["bdd"])){
            $_SESSION["bdd"] = array('Zelda', 'Toto', 'David', 'Mario');
        }
    }

    private function setResult($resultat, $errorMsg=null){
        $this->result = new stdClass();
        if ($resultat) {
            $this->result = $resultat;
            return $this->result;
        }else{
            return $errorMsg;
        }
    }

	function get_data($params){
        $result = $_SESSION["bdd"];
        //return count($params) ? $_SESSION["BDD"][$params[0]] : $_SESSION["BDD"];
        return $this->setResult($result);
    }
    /**function post_data($data) {
        $word = (empty($data["newValue"]))?null:$data["newValue"];
        array_push($_SESSION["BDD"], $word);
        return true;
    }**/
	function post_data($data){
        if(empty($data["content"]) || in_array($data["content"], $_SESSION["bdd"])){
            return $this->setResult(false,  "No content or exist already");
        }//END if $word
        array_push($_SESSION["bdd"], $data["content"]);
        return $this->setResult(true);

    }
	function put_data($data){
	    var_dump($data);
        if(empty($data["old_content"]) || empty($data["content"])){
            return $this->setResult(false, "oldWord or newWord empty");
        }

        $index = array_search($data["old_content"], $_SESSION["bdd"]);

        if($index === false || in_array($data["content"], $_SESSION["bdd"])){
            return $this->setResult(false, "oldWord not found or newWord already exist");
        }

        $_SESSION["bdd"][$index] = $data["content"];
        return $this->setResult(true);
    }
	function delete_data($data){
	   var_dump($data);
        if(empty($data["content"])){
            return $this->setResult(false, "Content Vide");
        }

        $index = array_search($data["content"], $_SESSION["bdd"]);

        if($index === false){
            return $this->setResult(false, "Content not found or already exist");
        }

        unset($_SESSION["bdd"][$index]);
        return $this->setResult(true);
    }
}