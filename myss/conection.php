<?php
/**
 * Created by PhpStorm.
 * User: Simastir_da
 * Date: 24/03/2019
 * Time: 13:09
 */

// use the following line when using Composer
// require __DIR__ . '/vendor/composer/autoload.php';

// use the following line when using git
require __DIR__ . '/arangodb-php/autoload.php';

// set up some aliases for less typing later
use ArangoDBClient\Collection as ArangoCollection;
use ArangoDBClient\CollectionHandler as ArangoCollectionHandler;
use ArangoDBClient\Connection as ArangoConnection;
use ArangoDBClient\ConnectionOptions as ArangoConnectionOptions;
use ArangoDBClient\DocumentHandler as ArangoDocumentHandler;
use ArangoDBClient\Document as ArangoDocument;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Export as ArangoExport;
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\ClientException as ArangoClientException;
use ArangoDBClient\ServerException as ArangoServerException;
use ArangoDBClient\Statement as ArangoStatement;
use ArangoDBClient\UpdatePolicy as ArangoUpdatePolicy;

// set up some basic connection options



// turn on exception logging (logs to whatever PHP is configured)
ArangoException::enableLogging();

function conect(){
    try{
        $connectionOptions = [
            // database name
            ArangoConnectionOptions::OPTION_DATABASE => 'myss',
            // server endpoint to connect to
            ArangoConnectionOptions::OPTION_ENDPOINT => 'tcp://127.0.0.1:8529',
            // authorization type to use (currently supported: 'Basic')
            ArangoConnectionOptions::OPTION_AUTH_TYPE => 'Basic',
            // user for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_USER => 'root',
            // password for basic authorization
            ArangoConnectionOptions::OPTION_AUTH_PASSWD => '1234',
            // connection persistence on server. can use either 'Close' (one-time connections) or 'Keep-Alive' (re-used connections)
            ArangoConnectionOptions::OPTION_CONNECTION => 'Keep-Alive',
            // connect timeout in seconds
            ArangoConnectionOptions::OPTION_TIMEOUT => 3,
            // whether or not to reconnect when a keep-alive connection has timed out on server
            ArangoConnectionOptions::OPTION_RECONNECT => true,
            // optionally create new collections when inserting documents
            ArangoConnectionOptions::OPTION_CREATE => true,
            // optionally create new collections when inserting documents
            ArangoConnectionOptions::OPTION_UPDATE_POLICY => ArangoUpdatePolicy::LAST,
        ];
        $connection = new ArangoConnection($connectionOptions);
    } catch (Exception $exception){
        echo "No funcionó";
    }
    return $connection;
}