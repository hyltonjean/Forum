<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Discussion;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ForumController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    switch (request('filter')) {
      case 'me':
        $results = Discussion::where('user_id', auth()->user()->id)->paginate(3);
        break;

      case 'solved':
        $answered = array();
        foreach (Discussion::all() as $d) {
          if ($d->hasBestAnswer()) {
            array_push($answered, $d);
          }
        }
        $results = new Paginator($answered, 3);
        break;

      case 'unsolved':
        $unanswered = array();
        foreach (Discussion::all() as $d) {
          if (!$d->hasBestAnswer()) {
            array_push($unanswered, $d);
          }
        }
        $results = new Paginator($unanswered, 3);
        break;

      default:
        $results = Discussion::orderBy('created_at', 'desc')->paginate(3);
        break;
    }

    return view('forum')->with('discussions', $results);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function channel(Channel $channel)
  {
    return view('channel')->with('discussions', $channel->discussions()->paginate(3));
  }
}
