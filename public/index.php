<?php

error_reporting(E_ALL);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = array();
$routes["/help/integrations/stripe"] = "../app/integrations/stripe.php";
$routes["/help/integrations/mailchimp"] = "../app/integrations/mailchimp.php";
$routes["/\/numbersonly\/([0-9]+)/"] = "../app/numbers/*/index.php";
$routes["/contact"] = "../app/pages/contact.php";

# First try a simple match
$current_route = $routes[$path];

# Try a wildcard match
if(!$current_route) {
  foreach ($routes as $regex => &$route) {
    $matches = array();
    preg_match($regex, $path, $matches);
    if($matches[1]) {
      $current_route = str_replace("*", $matches[1], $route);
      break;
    }
  }
}

# Try dynamic landing
if(!$current_route) {
  $potential_route = "../app/landing" . $path . "/index.php";
  if(file_exists($potential_route)) {
    $current_route = $potential_route;
  }
}

# No matches, page not found
if(!$current_route) {
  echo "page not found";
  exit;
}

// include($current_route);

print("We should do this: include('".$current_route."');");
