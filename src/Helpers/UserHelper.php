<?php

namespace App\Helpers; // Define the namespace for the helper

// Define the buildActivationQuery function
function buildActivationQuery($activationToken)
{
    // Construct the SQL query
    return "UPDATE users SET status = 'active' WHERE activation_token = '$activationToken'";
}
