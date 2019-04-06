<?php

// Requires the connection and all the dependencies.
require_once("connection.php");
require_once "../Controller/connection.php";
require_once "../Controller/arangodb-php/lib/ArangoDBClient/EdgeHandler.php";
require_once "../Controller/arangodb-php/lib/ArangoDBClient/Edge.php";

// Uses the functions of ArangoDB.
use ArangoDBClient\CollectionHandler as ArangoCollectionHandler;
use ArangoDBClient\EdgeHandler;
use ArangoDBClient\Edge;

// This function gets two parameters and associates them in an edge.
// They must be their usernames.
function follow($fromUser, $toUser){

    // All the variables that we need to manage the function.
    $connection         = connect();
    $collectionHandler  = new ArangoCollectionHandler($connection);
    $edgeHandler        = new EdgeHandler($connection);

    // We create two cursor to make the consults with the data.
    $cursorFrom = $collectionHandler->byExample('user', ['username' => $fromUser]);
    $cursorTo   = $collectionHandler->byExample('user', ['username' => $toUser]);

    // Now, we get the documents iterating over the cursors.
    $idFromUser         = null;
    $idToUser           = null;
    $resultingDocument  = array();

    foreach ($cursorFrom as $key => $value) {
        $resultingDocument[$key] = $value;

        // Gets the id of the FromUser.
        $idFromUser = $resultingDocument[$key]->getHandle();
    }

    foreach ($cursorTo as $key => $value) {
        $resultingDocument[$key] = $value;

        // Gets the id of the ToUser.
        $idToUser = $resultingDocument[$key]->getHandle();
    }

    // Now insert a link between them.
    $linkBetween = Edge::createFromArray([]);
    $edgeHandler->saveEdge('follows', $idFromUser, $idToUser, $linkBetween);
}

// follow('Jorgebv02', "JuanEscobar066");