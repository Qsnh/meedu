<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Dao;

interface OrderDaoInterface
{

    public function findById(int $orderId): array;

    public function getOrderGoodsListById($id): array;

    public function getOrderPaidRecordsById($id): array;

    public function updateData(array $where, array $data): int;

    public function findPromoCode($promoCode): array;

    public function incrementPromoCodeUsedTimes(int $id): int;

    public function storeOrderGoodsItem(array $data): void;

    public function storeOrderPaidRecord(array $data): void;

    public function store(array $data): array;

    public function findByOrderNo(string $orderNo): array;
}
