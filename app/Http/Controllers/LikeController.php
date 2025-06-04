<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LikeController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $type, int $id)
    {
        $likeable = $this->findLikeable($type, $id);

        Gate::authorize('create', [Like::class, $likeable]);
        
        $likeable->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        $likeable->increment('likes_count');

        return back();       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }

    private function findLikeable(string $type, int $id)
    {
        $modelName = Relation::getMorphedModel($type);

        if (!$modelName) {
            throw new NotFoundHttpException('Likeable not found');
        }

        return $modelName::findOrFail($id);
    }
}
