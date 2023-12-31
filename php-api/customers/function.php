<?php
require '../inc/dbcon.php';

function error422($message){
    $data = [
        'status' => 422,
        'message' => $message,

         ];
         header("HTTP/1.0 422 unprocessable entity");
         echo json_encode($data);
         exit();

    
}


function storeCustomer($customerInput){
global $conn;
$name = mysqi_real_escape_string($conn,$customerInput['name']);
$email = mysqi_real_escape_string($conn,$customerInput['email']);

$phone = mysqi_real_escape_string($conn,$customerInput['phone']);
if(empty(trim($name))){
    return error422('enter your name');

}elseif(empty(trim($email))){
    return error422('enter your email');


}elseif(empty(trim($phone))){
    return error422('enter your phone');


}
else{
    $query = "INSERT INTO customers (name,email,phone) VALUES('$name','$email','$phone')";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 201,
        'message' => 'Customer Created Successfully',

         ];
         header("HTTP/1.0 500 created");
         return json_encode($data);

    }else{
        $data = [
            'status' => 500,
        'message' => 'Internal Server Error',

         ];
         header("HTTP/1.0 500 Internal Server Error");
         return json_encode($data);
        
    }
}

}







function getCustomerList(){



    global $conn;
    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
            'status' => 200,
             'message' => 'Customer List Fetched Successfully',
            'data' => $res
            ];
            header("HTTP/1.0 200 Ok");
            return json_encode($data);
           



        }else{

             $data = [
            'status' => 404,
            'message' => 'No Customer Found',

             ];
             header("HTTP/1.0 404 No Customer Found");
             return json_encode($data);

   }
}
else{

    $data=[
        'status' => 500,
        'message' => 'Internal Server Error',

    ];
    header("HTTP/1.0 500 Internal Server Error");
    return json_encode($data);
}

}
function getCustomer($customerParams){
    global $conn;
    if($customerParams['id'] == null){
        return error422('Enter your customer id');
    }
    $customerid = mysqli_rea_escape_string($conn,$customerParams['id']);
    $query = "SELECT * FROM customers WHERE id='$customerid' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if($result){
        if(mysqli_num_rows($result) == 1)
        {
            $res = mysqli_fetch_assoc($resut);
            $data=[
                'status' => 200,
                'message' => 'customer fetched successfully',
                'data' => $res
        
            ];
            header("HTTP/1.0 200 ok");
            return json_encode($data);

        }
        else
        {
            $data=[
                'status' => 404,
                'message' => 'No customer Found',
        
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data); 
        }

    }else{
        $data=[
            'status' => 500,
            'message' => 'Internal Server Error',
    
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);

    }
}
function updateCustomer($customerInput,$customerParams){
       global $conn;
       if(!isset($customerParams['id'])){
               return error422('customer id not found in url');

       }elseif($customerParams['id'] == null){
           return error422('enter the customer id');
       }
       
$customerId = mysqli_real_escape_string($conn,$customerParams['id']);

$name = mysqi_real_escape_string($conn,$customerInput['name']);
$email = mysqi_real_escape_string($conn,$customerInput['email']);

$phone = mysqi_real_escape_string($conn,$customerInput['phone']);
if(empty(trim($name))){
    return error422('enter your name');

}elseif(empty(trim($email))){
    return error422('enter your email');


}elseif(empty(trim($phone))){
    return error422('enter your phone');


}
else{
    $query = "UPDATE customers SET name='$name',email='$email',phone='$phone WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
        'message' => 'Customer updated Successfully',

         ];
         header("HTTP/1.0 200 updated");
         return json_encode($data);

    }else{
        $data = [
            'status' => 500,
        'message' => 'Internal Server Error',

         ];
         header("HTTP/1.0 500 Internal Server Error");
         return json_encode($data);
        
    }
}

}










function deleteCustomer($customerParams){
    global $conn;
    if(!isset($customerParams['id]'])){
        return error422('customer id not found in URL');
    }elseif($customerParams['id'] == null){
        return error422('Enter the customer id');

    }
    $customerId = mysqli_real_escape_string($conn,$customerParams['id']);
    $query ="DELETE FROM customers WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn,$query) ;
    if($result){

        $data = [
            'status' => 204,
            'message' =>'customer deleted successfully',
         ];
         header("HTTP/1.0 204 Deleted");
         return json_encode($data);

    }else{
        $data = [
            'status' => 404,
            'message' =>'customer not found',
         ];
         header("HTTP/1.0 404 customer not found");
         return json_encode($data);
    }
}



?>