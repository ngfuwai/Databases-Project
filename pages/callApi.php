<?php
function CallAPI($addedURL, $method, $data = false)
{
  $baseURL = "http://172.25.99.162:8000/";
  $url = $baseURL . $addedURL;
  $curl = curl_init();
  echo $url;

  switch ($method)
  {
    case "POST":
      curl_setopt($curl, CURLOPT_POST, 1);

      if ($data)
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      break;
    case "PUT":
      curl_setopt($curl, CURLOPT_PUT, 1);
      break;
    default:
      if($data)
        $url = sprintf("%s?%s", $url, http_build_query($data));
  }

  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $result = curl_exec($curl);

  curl_close($curl);

  return $result;
}


?>
