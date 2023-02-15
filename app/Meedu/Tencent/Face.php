<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Tencent;

use Illuminate\Support\Facades\Log;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Faceid\V20180301\FaceidClient;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Faceid\V20180301\Models\DetectAuthRequest;
use TencentCloud\Faceid\V20180301\Models\GetDetectInfoEnhancedRequest;

class Face
{
    private $secretId;
    private $secretKey;
    private $ruleID;

    public const ENDPOINT = 'faceid.tencentcloudapi.com';

    public function __construct(ConfigServiceInterface $configService)
    {
        $config = $configService->getTencentFaceConfig();
        $this->secretId = $config['secret_id'];
        $this->secretKey = $config['secret_key'];
        $this->ruleID = (string)$config['rule_id'];
    }

    /**
     * @return array|null
     */
    public function create(string $redirectUrl)
    {
        try {
            $client = $this->getClient();
            $req = new DetectAuthRequest();
            $req->setRuleId($this->ruleID);
            $req->setRedirectUrl($redirectUrl);

            $resp = $client->DetectAuth($req);

            return [
                'url' => $resp->getUrl(),
                'rule_id' => $this->ruleID,
                'biz_token' => $resp->getBizToken(),
                'request_id' => $resp->getRequestId(),
            ];
        } catch (TencentCloudSDKException $e) {
            Log::error(__METHOD__ . '|发起腾讯云实名认证错误|错误信息:' . $e->getMessage());
            return null;
        }
    }

    public function query(string $ruleId, string $bizToken)
    {
        try {
            $client = $this->getClient();
            $req = new GetDetectInfoEnhancedRequest();

            $params = [
                'BizToken' => $bizToken,
                'RuleId' => $ruleId,
            ];
            $req->fromJsonString(json_encode($params));

            $resp = $client->GetDetectInfoEnhanced($req);

            $info = [
                'best_frame' => $resp->getBestFrame()->getBestFrame(),
                'info' => [
                    'name' => $resp->getText()->getName(),
                    'id_number' => $resp->getText()->getIdCard(),
                    'gender' => $resp->getText()->getOcrGender(),
                ],
                'id_card_data' => $resp->getIdCardData(),
                'id_card' => [
                    'front_image' => $resp->getIdCardData()->getProcessedFrontImage(),
                    'back_image' => $resp->getIdCardData()->getProcessedBackImage(),
                    'front_warn_infos' => $resp->getIdCardData()->getWarnInfos(),
                    'back_warn_infos' => $resp->getIdCardData()->getBackWarnInfos(),
                ],
                'video_data' => $resp->getVideoData()->getLivenessVideo(),
                'request_id' => $resp->getRequestId(),
            ];

            if ($info['id_card']['front_warn_infos'] || $info['id_card']['back_warn_infos']) {//身份证识别失败
                return null;
            }

            if (!$info['info']['name'] || !$info['best_frame'] || !$info['video_data']) {//还没有拿到全部的结果
                return null;
            }

            return $info;
        } catch (TencentCloudSDKException $e) {
            Log::error(__METHOD__ . '|腾讯云实名认证结果查询错误|错误信息:' . $e->getMessage());
            return null;
        }
    }

    private function getClient()
    {
        $cred = new Credential($this->secretId, $this->secretKey);
        $httpProfile = new HttpProfile();
        $httpProfile->setEndpoint(self::ENDPOINT);
        $clientProfile = new ClientProfile();
        $clientProfile->setHttpProfile($httpProfile);
        return new FaceidClient($cred, '', $clientProfile);
    }
}
