<?php

namespace App\Http\Middleware;

use App\Repositories\Contracts\RoundRepositoryInterface;
use Closure;

class RoundOwnerMiddleware
{
    /**
     * @var RoundRepositoryInterface
     */
    private $round;

    /**
     * Create a new filter instance.
     *
     * @param RoundRepositoryInterface $round
     */
    public function __construct(RoundRepositoryInterface $round)
    {
        $this->round = $round;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = $request->user()->id;
        $roundId = $request->route('rounds');

        if (!$this->round->checkRoundBelongsToUser($userId, $roundId)) {
            abort(403);
        }

        return $next($request);
    }

}
