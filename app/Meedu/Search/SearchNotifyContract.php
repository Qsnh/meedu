<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Search;

interface SearchNotifyContract
{
    public function create(int $resourceId, array $data);

    public function update(int $resourceId, array $data);

    public function delete(int $resourceId);

    public function deleteBatch(array $ids);
}
