<?php

namespace App\Http\Controllers;

use App\Http\Model\TaskModel;
use App\Services\GuzzleResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $data = json_decode(current(config('guahao')),true)['data'];

        $task_list = TaskModel::all();

        return view('welcome', ['data' => json_encode($data), 'task_list' => $task_list]);
    }
    public function add(Request $request)
    {
        $filter = $request->except(['_token']);
        $filter['hospital_id'] = 1;
        TaskModel::create($filter);
        return redirect()->action('TaskController@index');
    }

    public function msecTime() {

        list($msec, $sec) = explode(' ', microtime());

        return (int)((floatval($msec) + floatval($sec)) * 1000);

    }

    public function sendCode(Request $request)
    {
        $phone = $request->input(['phone']);

        $requestBody = [
            '_time' => strval($this->msecTime()),
            'mobile' => $phone,
            'smsKey' => 'LOGIN',
        ];

        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36',
            'Content-Type' => 'application/json; charset=UTF-8',
            'Accept' => 'application/json, text/plain, */*',
            'Accept-Encoding' => 'gzip,deflate,br',
            'Accept-Language' => 'zh-CN, zh;q = 0.9',
            'Connection' => 'keep-alive',
            'Host' => 'www.114yygh.com',
            'Referer' => 'https://www.114yygh.com/',
            'Request-Source' => 'PC',
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-origin'
        ];

        $result = self::get('https://www.114yygh.com/web/common/verify-code/get', $requestBody, $headers);
        $data = $result->getData();
        if ($data && $data['resCode'] === 0){
            return $this->success();
        }

        return $this->error($data['resCode'], $data['msg']);
    }

    public static function get($uri, $parameters = [], $headers = null, $timeOut = 0) {
        $client = new Client([
            "base_uri" => $uri,
            "timeout" => $timeOut,
            RequestOptions::VERIFY => false,
        ]);
        $guzzleResponse = new GuzzleResponse();
        try {
            $beginTime = microtime(true);
            // 打印info 级别日志

            $response = $client->request("get", $uri, [
                RequestOptions::FORCE_IP_RESOLVE => 'v4', // 由于国内ipv6 网络不完善，所以强制使用ipv4
                RequestOptions::VERIFY => false,
                RequestOptions::HEADERS => $headers,
                RequestOptions::QUERY => $parameters
            ]);

            // 封装返回对象
            $guzzleResponse->setSuccess(true);
            $guzzleResponse->setHeaders($response->getHeaders());
            $guzzleResponse->setCode($response->getStatusCode());
            $guzzleResponse->setData($response->getBody()->getContents());
            // 打印日志，包括返回数据，
            // 响应时间，其中响应时间是指从发送请求开始到接受到response 对象结束
            // 返回类型是json，直接解析json字符串返回
            if (!is_null(json_decode($guzzleResponse->getData()))) {
                $guzzleResponse->setData(json_decode($guzzleResponse->getData(), true));
            }
        } catch (GuzzleException $e) {
            // 出错 打印错误详细日志，错误可以定位到指定文件，指定行
            $guzzleResponse->setData([]);
            $guzzleResponse->setCode($e->getCode());
            $guzzleResponse->setSuccess(false);
            $guzzleResponse->setMessage($e->getMessage());
        }
        return $guzzleResponse;
    }

}
