<?php

// 检查是否有文件上传
if (isset($_FILES['file'])) {
    // 文件信息
    $file = $_FILES['file'];

    // 构建POST请求数据
    $postData = array(
        'media' => new CURLFile($file['tmp_name'], $file['type'], $file['name'])
    );

    // 目标URL
    $url = 'https://openai.weixin.qq.com/weixinh5/webapp/h774yvzC2xlB4bIgGfX2stc4kvC85J/cos/upload';

    // 初始化cURL会话
    $curl = curl_init();

    // 设置cURL选项
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // 执行cURL请求
    $response = curl_exec($curl);

    // 检查是否有错误发生
    if ($response === false) {
        echo 'Error: ' . curl_error($curl);
    } else {
        // 修改返回值格式
        $responseData = json_decode($response, true);
        $responseData['name'] = $file['name'];
        $responseData['os'] = 'zixi';
        echo json_encode($responseData);
    }

    // 关闭cURL会话
    curl_close($curl);
} else {
    echo 'No file uploaded.';
}
?>
