<?php
namespace Digitalcloud\NovaMailchimp\Http;

use Illuminate\Routing\Controller;

class MailChimpController extends Controller
{
    public function lists()
    {
        $data = $this->send("lists");

        return $this->format($data,
            true,
            $data['total_items'],
            request('page')
        );
    }

    public function showList($id)
    {
        $members = $this->send("lists/{$id}/members");

        return $this->format([
            'list' => $this->send("lists/{$id}"),
            "members" => $members['members']],
            true,
            $members['total_items'],
            request('page')
        );
    }

    public function campaigns()
    {
        $data = $this->send("campaigns");

        return $this->format($data,
            true,
            $data['total_items'],
            request('page')
        );
    }

    public function ShowCampaign($id)
    {
        return $this->format($this->send("campaigns/{$id}"));
    }

    private function send($url)
    {
        $page = request('page') ?? 1;
        $perPage = request('per_page') ?? 10;

        $parmas = [
            "offset" => ($page - 1) * $perPage,
            "count" => $perPage
        ];

        return (\Newsletter::getApi())->get($url, $parmas);
    }

    private function format($data, $is_collection = false, $total = 0, $page = 1, $perPage = 10)
    {
        if (!$is_collection)
            response()->json($data);

        $next_page = null;
        $last_page = null;

        if (!$page)
            $page = 1;

        if (ceil($total / $perPage) > $page) {
            $next_page = $page + 1;
        }

        if ($page > 1) {
            $last_page = $page - 1;
        }

        return response()->json(array_merge(["data" => $data], [
            "paging" => [
                "total" => $total,
                "per_page" => $perPage,
                "current_page" => $page,
                "next_page" => $next_page,
                "last_page" => $last_page
            ]
        ]));
    }
}
