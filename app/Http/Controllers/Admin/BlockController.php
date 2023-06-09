<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Block\StoreBlockRequest;
use App\Http\Requests\Block\UpdateBlockRequest;
use App\Models\Admin\Block;
use App\Models\Admin\Exercise;
use App\Models\Admin\Track;
use App\Models\Admin\User;
use App\Services\AverageMark\AverageMarkBlock;
use App\Services\Duration\DurationBlock;
use App\Services\ImageService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create($track_id)
    {

        $track = Track::where('id', $track_id)->first();

        return view('admin.blocks.create', [
            'track' => $track,
            'users' => User::where('role_id', 2)->orWhere('role_id', 3)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Block\StoreBlockRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBlockRequest $request, $track_id)
    {
        $track = Track::where('id', $track_id)->first();

        $data = $request->validated();
        $data['track_id'] = $track->id;
        $data['user_id'] = auth()->user()->id;
        $data['image'] = ImageService::make($request->file('image'), 'blocks/images');
        $block = Block::create($data);
        return redirect()->route('admin.tracks.blocks.show', [$track->id, $block->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Block $block
     * @return Application|Factory|View
     */
    public function show($track_id, $block_id)
    {
        $block = Block::where('id', $block_id)->first();
        $track = Track::where('id', $track_id)->first();

        $duration = DurationBlock::getNameDuration($block);
        $averageMarkBlock = AverageMarkBlock::getMark($block);
        $exercises = Exercise::where('block_id', $block->id)->get();

        return view('admin.blocks.show', compact('track', 'block', 'exercises','averageMarkBlock', 'duration'));
    }

    /**
     * @param Track $track
     * @param Block $block
     * @return Application|Factory|View
     */
    public function edit(Track $track, Block $block)
    {
        return view('admin.blocks.edit', compact('track', 'block'));
    }


    /**
     * @param UpdateBlockRequest $request
     * @param Track $track
     * @param Block $block
     * @return RedirectResponse|never
     * @throws \Throwable
     */
    public function update(UpdateBlockRequest $request, Track $track, Block $block)
    {
        $data = $request->validated();

        $image = $data['image'] ?? null;
        // dd($data['image']);
        if (!$image) {
            try {
                $block->updateOrFail($data);
                return redirect()->route('admin.tracks.blocks.show', [$track->id, $block->id]);
            } catch (\Exception $exception) {
                return abort(501);
            }
        }

        ImageService::deleteOld($block->image, 'blocks/images');
        unset($data['image']);
        $data['image'] = ImageService::make($image, 'blocks/images');
        try {
            $block->updateOrFail($data);
            return redirect()->route('admin.tracks.blocks.show', [$track->id, $block->id]);
        } catch (\Exception $exception) {
            return abort(501, $exception);
        }
    }


    /**
     * @param Track $track
     * @param Block $block
     * @return RedirectResponse|void
     * @throws \Throwable
     */
    public function destroy(Request $request, Track $track, Block $block)
    {

        if (!Hash::check($request->input('password'), auth()->user()->password)) {
            session()->flash('error', 'При удалении вы ввели неверный пароль, попробуйте снова');
            return back();
        }

        try {
            $block->deleteOrFail();
            return redirect()->route('admin.tracks.show', [$track->id]);
        } catch (\Exception $exception) {
            abort(501);
            // dd( $exception);
        }
    }
}
