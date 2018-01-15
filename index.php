<?php
 //Dùng cURL tạo truy vấn, kiểm tra mã trạng thái sau đó bóc tách liên kết đích từ header trả về là xong.
echo getRedirectUrl('http://fb.com/groups/j2team.community');
 
function getRedirectUrl($url)
{
  $options = array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HEADER         => TRUE,
    CURLOPT_FOLLOWLOCATION => FALSE,
    CURLOPT_NOBODY         => TRUE,
    CURLOPT_ENCODING       => '',
    CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',
    CURLOPT_AUTOREFERER    => TRUE,
    CURLOPT_CONNECTTIMEOUT => 15,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_MAXREDIRS      => 5,
    CURLOPT_SSL_VERIFYHOST => 2,
    CURLOPT_SSL_VERIFYPEER => 0
  );
 
  $ch = curl_init();
  curl_setopt_array($ch, $options);
  $response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  unset($options);
 
  if ($http_code === 301 OR $http_code === 302) {
    if (preg_match('/location: (.+)/i', $response, $regs)) {
      return $regs[1];
    }
  }
 
  return $http_code === 200 ? $url : FALSE;
}

