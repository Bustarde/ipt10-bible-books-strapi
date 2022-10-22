<?php
require "vendor/autoload.php";

use GuzzleHttp\Client;

function getBooks() {
    $token = '3208ae3cb5f6f6a2b90407cf2eb4193acfc0ba5a5f849fbceace89a755db1ab6d2c5e2fee77be4d2a7ed2d3720eea6d437f70522c0b8a63cd94011c7c3948e5a8e811af0c7c80a8258b0a4557fa3412ad58f5dcc47996e70a88d85a9d1ba30441369a39fde6f92cd78bba63c3e95a3214d229c9fb56ef224599a803cda8c392c';

    try {
        $client = new Client([
            'base_uri' => 'http://localhost:1337/api/'
        ]);
    
        $headers = [
            'Authorization' => 'Bearer ' . $token,        
            'Accept'        => 'application/json',
        ];
  
      $response = $client->request('GET', 'books?pagination[pageSize]=66', [
            'headers' => $headers
        ]);
    
        $body = $response->getBody();
        $decoded_response = json_decode($body);
        return $decoded_response;
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo '<pre>';
        var_dump($e);
    }
    return null; 
}

$books = getBooks();
?>

<html>
    <head>
        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <title>Books of the Bible</title>
    </head>
    <body>
        <div class = "container">
            <h1 style = "padding-bottom: 20px;">Scripture Books List</h1>
            <div class = "row">
                <div class = "col-10">
                    <table class = "table table-bordered table-striped">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Author</th>
                            <th scope="col">Category</th>
                        </tr>
                        <?php
                            foreach ($books->data as $bookData) {
                            $book = $bookData->attributes;
                        ?>
                        <tr>
                            <th scope="row"><?php echo $bookData->id; ?></th>
                            <td><?php echo $book->name; ?></td>
                            <td><?php echo $book->author; ?></td>
                            <td><?php echo $book->category; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>