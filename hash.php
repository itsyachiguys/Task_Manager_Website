<?php // start php code block
// utility functions for password hashing
function hashPassword($password) { // define function to hash password
    return password_hash($password, PASSWORD_DEFAULT); // return hashed password using default algorithm
}

function verifyPassword($password, $hash) { // define function to verify password
    return password_verify($password, $hash); // return true if password matches hash
}
?> // end php code block
