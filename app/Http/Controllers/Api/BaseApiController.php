<?php

namespace App\Http\Controllers\Api;

use App\Models\App;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    use Helpers;
    protected $app_id;
    protected $app_info;

    public function __construct()
    {
        $this->app_id = request(['app_id']);
        if ($this->app_id) {
            try {
                $this->app_info = App::where('status',1)->findOrFail($this->app_id)->toArray()[0];
            } catch (\Exception $exception) {
                $this->app_info = [];
            }
        }
        if (!$this->app_info || !$this->app_info['status']) {
            return $this->response->error('app not exits.', 404);
        }

    }
}
