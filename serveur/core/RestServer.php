<?php


class RestServer {

	private $serviceName;
	private $classMethod;
	private $requestParam;
    private $userAgent;
	public 	$message;

	function __construct(){
		$this->message = new RestMessage();
	}

	public function loadService($serviceName){

		if($serviceName &&  class_exists($serviceName)){
			$this->serviceName = new $serviceName();
		} else {
			$this->showErrorServer(404, "Server Error, serviceName not found");
		}

		$D = array();
		switch ($this->message->request->httpMethod) {
			case "GET"		:
			case "DELETE"	:	$D = static::getParams(); break;
			case "POST"		:	$D = $_POST; break;
			case "PUT"		:	parse_str(file_get_contents("php://input"), $D); break;
			default 		:	$this->showErrorServer(404, "Server Error, HTTP Method not found");
		}

		if ($serviceName){
			$this->setClassMethod($serviceName);
			$this->requestParam = $D;
		}
		else {
			$this->showErrorServer(400, "Server Error, Param Method not found");
		}

    //var_dump($this->serviceName);
        if (!isset($this->message->response->serverError)) {
            $this->message->response->body = call_user_func(array($this->serviceName, $this->classMethod), $this->requestParam);
        }else{
            $this->message->response->body = '';
        }
	}

	private function showErrorServer($code, $msg){
		$this->message->response->serverError 			= $code;
		$this->message->response->serverErrorMessage 	= $msg;
	}
    private function showErrorService($code,  $msg){
        $this->message->response->serverError 			= $code;
        $this->message->response->serverErrorMessage 	= $msg;
    }

	private function setClassMethod($methodName){
        //echo $methodName;
		$this->classMethod = strtolower($this->message->request->httpMethod . "_" . $methodName);
		if(!method_exists($this->serviceName, $this->classMethod)){
			$this->showErrorServer(405, "Server Error, Method invalid");
		}
	}

	public static function getParams(){
	    $params = explode('/', $_GET['p']);

	    if (is_array($params))   { array_shift($params); }
	    if (!is_array($params))  { $params = array($params); }
	    if (!$params)            { $params = array(); }

	    return array_filter($params);

	}

	public function __destruct(){

        $this->message->send();

	}

}

class RestMessage {

	public $request;
	public $response;

	function __construct(){
       // header("Content-type", "application/json");

        $this->request 	= new stdClass();
		$this->response = new stdClass();
		$this->request->httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);
		$this->request->userAgent = strtoupper($_SERVER['HTTP_USER_AGENT']);

	}

    public function send(){
        if(isset($this->response->serverError)){
            http_response_code($this->response->serverError);
        }

        echo json_encode($this->response, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
    }

    public function getResponse(){
        return $this->response;
    }
    public function getRequest(){
        return $this->request;
    }

    public function setResponse(){
         return $this->response;
    }
    public function setRequest(){
        return  $this->request ;
    }
}