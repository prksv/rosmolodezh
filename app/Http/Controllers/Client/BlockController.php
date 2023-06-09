<?php

namespace App\Http\Controllers\Client;

use App\Models\Block;
use App\Models\Track;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Block\StoreBlockRequest;
use App\Http\Requests\Block\UpdateBlockRequest;

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
     * @return \Illuminate\Http\Response
     */
    public function create(Track $track)
    {
        $this->authorize('create', [Block::class, $track]);
        return view('profile.blocks.create', ['track' => $track]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlockRequest $request, Track $track)
    {
        $this->authorize('create', [Block::class, $track]);

        $data = $request->validated();
        $data['track_id'] = $track->id;
        $data['user_id'] = auth()->user()->id;
        $data['image'] = ImageService::make($request->file('image'), 'blocks/images');
        $priority = Block::where('track_id', $track->id)->get()->sortByDesc('id')->first() !== null
            ? Block::where('track_id', $track->id)->get()->sortByDesc('id')->first()->priority
            : 0;
        $priority++;
        $data['priority'] = $priority;
        $block = Block::create($data);

        return redirect()->route('profile.tracks.blocks.show', [$block->track->slug,$block->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Track $track, Block $block)
    {

        if(auth()->user()->role->name === 'student') {
            if ($block->exercises_count > 0 && !auth()->user()->started_blocks->where('block_id', $block->id)->first()) {
                auth()->user()->started_blocks()->attach($block);
            }

            return view('profile.blocks.student.show',compact('block', 'track'));
        } else {
            return view('profile.blocks.teacher.show',compact('block', 'track'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Track $track, Block $block)
    {
        $this->authorize('update', $block);
        return view('profile.blocks.teacher.edit',compact('block', 'track'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlockRequest $request,Track $track,  Block $block)
    {
        $this->authorize('update', [$block]);
        $data = $request->validated();

        $image = $data['image'] ?? null;
        if (!$image) {
            try {
                $block->updateOrFail($data);
                return redirect()->route('profile.tracks.blocks.show', [$block->track->slug, $block->slug]);
            } catch (\Exception $exception) {
                return abort(501);
            }
        }

        ImageService::deleteOld($block->image, 'blocks/images');
        unset($data['image']);
        $data['image'] = ImageService::make($image, 'blocks/images');
        try {
            $block->updateOrFail($data);
            return redirect()->route('profile.tracks.blocks.show', [$block->track->slug, $block->slug]);
        } catch (\Exception $exception) {
            return abort(501, $exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Track $track, Block $block)
    {
        $this->authorize('delete', $block);

        if (!Hash::check($request->input('password'), auth()->user()->password)) {
            session()->flash('error', 'При удалении вы ввели неверный пароль, попробуйте снова');
            return back();
        }

        try {
            $block->deleteOrFail();
            return redirect()->route('profile.track.show',$track->slug);
        } catch (\Exception $exception) {
            abort(501);
            // dd( $exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function start(Track $track, Block $block)
    {
        auth()->user()->started_blocks()->toggle($block);
        return redirect()->route('profile.tracks.block.show',[$track->slug, $block->slug]);
    }
}
