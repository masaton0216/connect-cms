<?php

// �f�[�^URL
//$request_url = "http://opensource-workshop.jp";
$request_url = "https://opensource-workshop.jp";
//$request_url = "http://opensource-workshop.jp/service";

// Github ����f�[�^�擾�iHTTP ���X�|���X�� gzip ���k����Ă���j
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");

//���N�G�X�g�w�b�_�o�͐ݒ�
curl_setopt($ch,CURLINFO_HEADER_OUT, true);
$page = curl_exec($ch);

//echo curl_getinfo($ch, CURLINFO_HEADER_OUT);
$ret = curl_getinfo($ch);
print_r($ret);


//$json = json_decode($page);
//echo $json->tls_version;


echo "<pre>";
//var_dump($page);
echo "</pre>";

