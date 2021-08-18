<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/8/18
 * @createTime: 23:58
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */
namespace think\filesystem\driver;
use JellyBool\Flysystem\Upyun\UpyunAdapter;
use Obs\ObsAdapter;
use Obs\ObsClient;
use Qcloud\Cos\Client;

/**
 * 华为云 obs thinkphp filesystem驱动
 * Class Huawei
 * @package think\filesystem\driver
 */
class Huawei extends \think\filesystem\Driver
{
    protected function createAdapter (): \League\Flysystem\AdapterInterface
    {
        $config = $this->config;
        $debug = $config['debug'] ?? false;
        $endpoint = $config['endpoint'] ?? '';
        $cdn_domain = $config['cdn_domain'] ?? '';
        $ssl_verify = $config['ssl_verify'] ?? false;
        $prefix = $config['prefix']??'';
        if ($debug) {
            \think\Log::debug('OBS config:', $config);
        }
        $client = new ObsClient($config);
        $bucket = $config['bucket'] ?? '';
        return new ObsAdapter($client,$bucket,$endpoint,$cdn_domain,$ssl_verify,$prefix);
    }
}