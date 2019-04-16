<?php

use ArangoDBCLient\DocumentHandler as ArangoDocumentHandler;
use ArangoDBClient\CollectionHandler as ArangoCollectionHandler;
use ArangoDBClient\Document as ArangoDocument;
use function ArangoDBClient\readCollection;


require_once "../Controller/readCollection.php";
require_once "../Controller/createEdges.php";
require_once "../Controller/connection.php";
require_once "../Controller/arangodb-php/lib/ArangoDBClient/CollectionHandler.php";
require_once "../Controller/arangodb-php/lib/ArangoDBClient/Cursor.php";
require_once "../Controller/arangodb-php/lib/ArangoDBClient/DocumentHandler.php";


class UserQuery
{
    static function register($username, $email, $password, $name, $birthday)
    {
        $database = new ArangoDocumentHandler(connect());
        $user = new ArangoDocument();
        $user->set("username", $username);
        $user->set("email", $email);
        $user->set("password", $password);
        $user->set("name", $name);
        $user->set("birthday", $birthday);

        // Insert him in the collection user.
        $database->save("user", $user);
        return 'You have been successfully registered';
    }

    static function isUsernameTaken($username)
    {
        $document = new ArangoCollectionHandler(connect());
        $cursorUser = $document->byExample('user', ['username' => $username]);
        if ($cursorUser->getCount() == 0) {
            return false;
        }
        return true;
    }

    static function isEmailTaken($email)
    {
        $document = new ArangoCollectionHandler(connect());
        $cursorEmail = $document->byExample('user', ['email' => $email]);
        if ($cursorEmail->getCount() == 0) {
            return false;
        }
        return true;
    }

    static function getInformation($email)
    {

        $query = ['
        FOR x IN user 
        FILTER x.email == @email 
        RETURN {password: x.password, key: x._key, username: x.username, name: x.name, email: x.email}' => ['email' => $email]];
        $cursor = readCollection($query);
        return $cursor;
    }

}