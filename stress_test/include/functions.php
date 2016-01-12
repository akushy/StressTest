<?php

function cleaner($input_value){
    return trim(strip_tags($input_value));
}

function loginExists( $connexion, $login )
{
    $query = $connexion->prepare( 'SELECT COUNT(*) AS total FROM user WHERE login = :login' );
    $query->bindValue( ':login', $login );
    $query->execute();
    if ( $result = $query->fetch() ) {
        return !empty( $result['total'] );
    }
    return false;
}

function getConnectedUser( $connexion )
{

    if ( empty( $_SESSION['user_secret'] ) ) {
        return false;
    }
    $secret = $_SESSION['user_secret'];
    $query = $connexion->prepare( 'SELECT * FROM user WHERE secret = :secret' );
    $query->bindValue( ':secret', $secret );
    $query->execute();
    if ( $user = $query->fetch() ) {
        return $user;
    }
    else {
        return false;
    }
}

function getUserTasks( PDO $connexion, $userId )
{
    $query = $connexion->prepare( 'SELECT * FROM task WHERE user_id = :user_id' );
    $query->bindValue( ':user_id', $userId );
    $query->execute();
    $tasks = $query->fetchAll();
    return $tasks;
}

function postTask( PDO $connexion, $userId, $content, $deadline, $done )
{
    $sql = 'INSERT INTO task(user_id, content, deadline, done) VALUES(:user_id, :content, :deadline, :done)';
    $query = $connexion->prepare( $sql );
    $result = $query->execute(
        [
            ':user_id'  => $userId,
            ':content'  => $content,
            ':deadline' => $deadline,
            ':done'     => $done,
        ]
    );
}

function redirectTo( $url )
{
    header( 'Location: ' . $url );
    exit;
}

function validateDate( $input, $format = 'Y-m-d H:i:s' )
{
    $date = DateTime::createFromFormat( $format, $input );
    return $date && $date->format( $format ) == $input;
}

function displayTasks( $tasks )
{
    include( 'tasks.view.php' );
}

function extract_specefic( array $keys_to_extract, array $arr )
{
    foreach ( $keys_to_extract as $key ) {
        global ${$key};
        ${$key} = isset( $arr[$key] ) ? $arr[$key] : "";
    }
}
