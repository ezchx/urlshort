<?

$param = str_replace("/urlshort/","",$_SERVER['REQUEST_URI']);

// check if valid url
if (filter_var($param, FILTER_VALIDATE_URL)) {

  mysql_connect(localhost,$username,$pw);
  @mysql_select_db($database) or die( "Unable to select database");

  $query = "INSERT INTO url_short VALUES (
    '',
    '$param')";
  mysql_query($query);

  $query2 = "SELECT ref FROM url_short WHERE url_long = '$param'";
  $result2 = mysql_query($query2);
  $ref = mysql_result($result2,0);

  mysql_close();

  // output results
  $url_key = array("original_url" => "$param","short_url" => "http://ezchx.com/urlshort/$ref");
  echo json_encode($url_key, JSON_UNESCAPED_SLASHES);

} else if (is_numeric($param)) {

  mysql_connect(localhost,$username,$pw);
  @mysql_select_db($database) or die( "Unable to select database");

  $query = "SELECT url_long FROM url_short WHERE ref = '$param'";
  $result = mysql_query($query);
  $num = mysql_numrows($result);

  mysql_close();

  if ($num == 1) {

    $url_long = mysql_result($result,0);

    // redirect user
    header('Location: '.$url_long);
    die();

  } else {

    echo "{error}";

  }

} else {

  echo "{error}";

}


?>