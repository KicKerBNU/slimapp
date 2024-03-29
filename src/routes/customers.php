<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Get All Customers
$app->get('/api/customers', function(Request $request, Response $resposse){
    $sql = "SELECT * from customers";

    try {
        //get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt =  $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);
    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});
//Get a Single Customer
$app->get('/api/customers/{id}', function(Request $request, Response $resposse){
    $id = $request->getAttribute('id');
    
    $sql = "SELECT * FROM customers WHERE id = $id";

    try {
        //get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();
        $stmt =  $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customer);
    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});
//Add Customer
$app->post('/api/customers/add', function(Request $request, Response $resposse){
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $adress = $request->getParam('adress');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    
    
    $sql = "INSERT INTO customers (first_name,last_name,phone,email,adress,city,state) 
    VALUES(:first_name,:last_name,:phone,:email,:adress,:city,:state)";

    try {
        //get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();
        $stmt =  $db->prepare($sql);

        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':adress',$adress);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        $stmt->execute();

        echo '{"notice": {"text": "Customer Added"}';
        
    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});
//Update Customer
$app->put('/api/customer/update/{id}', function(Request $request, Response $resposse){
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $adress = $request->getParam('adress');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    
    
    $sql = "UPDATE customers SET
                first_name = :first_name,
                last_name = :last_name,
                phone = :phone,
                email = :email,
                adress = :adress,
                city = :city,
                state = :state
            WHERE id = $id";

    try {
        //get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        $stmt =  $db->prepare($sql);

        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':adress',$adress);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);
        
        $stmt->execute();

        echo '{"notice": {"text": "Customer Update"}';
        
    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});
//Delete a Single Customer
$app->delete('/api/customers/delete/{id}', function(Request $request, Response $resposse){
    $id = $request->getAttribute('id');
    
    $sql = "DELETE FROM customers WHERE id = $id";

    try {
        //get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();
        $stmt =  $db->prepare($sql);
        $stmt->execute();
        $db = null;
        
        echo '{"notice": {"text": "Customer Deleted"}';
        
    } catch (PDOException $e) {
        echo '{"error": {"text":'.$e->getMessage().'}';
    }
});
