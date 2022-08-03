<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\AdministratorLog;
use App\Http\Requests\Backend\ImageUploadRequest;

class UploadController extends BaseController
{
    public function tinymceImageUpload(ImageUploadRequest $request)
    {
        $file = $request->filldata();

        $data = save_image($file);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMIN_MEDIA_IMAGE,
            AdministratorLog::OPT_STORE,
            $data
        );

        return ['location' => $data['url'], 'path' => $data['path']];
    }
}
