<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get all
$app->get('/api/customers', function (Request $request, Response $response) {
    $sql = "SELECT * FROM customers";

    try{
        //GET DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $response->write(json_encode($customers));
        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }catch(PDOException $e){
        echo '{"error": {"text":'.$e.getMessage().'}';
    }
});

//Get single customer
$app->get('/api/customers/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM customers WHERE id = $id";

    try{
        //GET DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $response->write(json_encode($customer));
        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }catch(PDOException $e){
        echo '{"error": {"text":'.$e.getMessage().'}';
    }
});

//Add customer
$app->post('/api/customers/add', function (Request $request, Response $response) {
    
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "INSERT INTO customers (first_name, last_name, phone, email, address, city, state) VALUES (:first_name, :last_name, :phone, :email, :address, :city, :state)";

    try{
        //GET DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        $result = $db->lastInsertId();
        $db=null;

        $response->write(json_encode($result));
        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }catch(PDOException $e){
        echo '{"error": {"text":'.$e.getMessage().'}';
    }
});

//Update customer
$app->put('/api/customers/upd/{id}', function (Request $request, Response $response) {
    echo 'hola';
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');

    $sql = "UPDATE customers SET 
                first_name  =   :first_name, 
                last_name   =   :last_name, 
                phone       =   :phone, 
                email       =   :email, 
                address     =   :address, 
                city        =   :city, 
                state       =   :state
            WHERE id = $id";

    try{
        //GET DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();
        $db=null;

        $response->write(json_encode('{"notice":{"text": "Customer Update", "id": '.$id.'}}'));
        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }catch(PDOException $e){
        echo '{"error": {"text":'.$e.getMessage().'}';
    }
});

//Delete single customer
$app->delete('/api/customers/delete/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM customers WHERE id = $id";

    try{
        //GET DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;

        $response->write(json_encode('{"notice":{"text": "Customer Delete", "id": '.$id.'}}'));
        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }catch(PDOException $e){
        echo '{"error": {"text":'.$e.getMessage().'}';
    }
});