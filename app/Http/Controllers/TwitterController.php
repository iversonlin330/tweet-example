<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Atymic\Twitter\Facades\Twitter;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    //
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * LoginController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createTwitter(Request $request)
    {
        $data = $request->all();
        $result = Twitter::postTweet(['status' => $data['status'], 'response_format' => 'json']);
        return "success";
    }

    public function timeline()
    {
        $data = Twitter::getHomeTimeline();
        return response()->json($data);
    }

    public function friends()
    {
        $data = Twitter::getFriends();
        return response()->json($data);
    }

}
