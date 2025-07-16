<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use Carbon\Carbon;
use App\Constant\AgreementConstant;
use App\Meedu\ServiceV2\Dao\AgreementDaoInterface;

class AgreementService implements AgreementServiceInterface
{
    protected $agreementDao;

    public function __construct(AgreementDaoInterface $agreementDao)
    {
        $this->agreementDao = $agreementDao;
    }

    public function checkUserRequiredAgreements(int $userId): bool
    {
        $requiredAgreements = $this->agreementDao->getActiveAgreementsByTypes(AgreementConstant::REQUIRED_AGREEMENT_TYPES);

        if (empty($requiredAgreements)) {
            return true;
        }

        $agreementIds = array_column($requiredAgreements, 'id');
        $userAgreedCount = $this->agreementDao->getUserAgreementRecordCountByAgreementIds($userId, $agreementIds);

        return $userAgreedCount === count($requiredAgreements);
    }

    public function getActiveAgreement(string $type): array
    {
        return $this->agreementDao->getActiveAgreementByType($type);
    }

    public function getActiveAgreementId(string $type): int
    {
        $agreement =  $this->agreementDao->getActiveAgreementByType($type, ['id']);
        return $agreement ? $agreement['id'] : 0;
    }

    public function recordUserAgreement(int $userId, int $agreementId, string $ip, string $userAgent, string $platform): array
    {
        $agreement = $this->agreementDao->findAgreementById($agreementId);
        if (!$agreement) {
            throw new \Exception(__('协议不存在'));
        }

        $data = [
            'user_id' => $userId,
            'agreement_id' => $agreementId,
            'agreement_type' => $agreement['type'],
            'agreement_version' => $agreement['version'],
            'agreed_at' => Carbon::now(),
            'ip' => $ip,
            'user_agent' => $userAgent,
            'platform' => $platform,
        ];

        return $this->agreementDao->createOrUpdateUserAgreementRecord($data);
    }

    public function getUserAgreementStatus(int $userId): array
    {
        // 获取当前生效的协议
        $activeAgreements = $this->agreementDao->getActiveAgreementsByTypes(AgreementConstant::REQUIRED_AGREEMENT_TYPES);
        $agreementIds = array_column($activeAgreements, 'id');

        // 获取用户已同意的协议
        $userAgreedAgreements = $this->agreementDao->getUserAgreementRecordsByAgreementIds($userId, $agreementIds);

        $data = [];
        foreach (AgreementConstant::TYPES as $type => $typeName) {
            if (!in_array($type, AgreementConstant::REQUIRED_AGREEMENT_TYPES)) {
                continue;
            }
            $agreed = isset($userAgreedAgreements[$type]);
            $data[$type . '_agreed'] = $agreed;
        }

        return $data;
    }

    public function getRequiredAgreements(): array
    {
        return $this->agreementDao->getActiveAgreementsByTypes(AgreementConstant::REQUIRED_AGREEMENT_TYPES);
    }
}
