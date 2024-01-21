<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'header' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/event-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Event gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 3;

        $ok = Event::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data event gagal disimpan');
        }

        return redirect('/events')->with('success', 'Data event berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['event'] = Event::find($id);

        return view('events.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['event'] = Event::find($id);

        return view('events.edit', $datas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'header' => 'required',
            'description' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/event-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Event gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Event::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data event gagal disimpan');
        }

        return redirect('/events')->with('success', 'Data event berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Event::find($id)->delete();

        if (!$ok) {
            return redirect()->back()->with('error', 'Event gagal dihapus');
        }

        return redirect()->back()->with('success', 'Event berhasil dihapus');
    }

    public function eventDatatable(Request $request)
    {
        $verified = $request->verified ?? 1;

        if ($verified == 1) {
            $events = Event::where('status_id', 3)->orderBy('id', 'desc')->get();
        } else {
            $events = Event::where('status_id', '!=', 3)->orderBy('id', 'desc')->get();
        }


        foreach ($events as $event) {
            $event['date_string'] = $event->start_date.' - '.$event->end_date;
            $event['time_string'] = $event->start_time.' - '.$event->end_time;
            $event['status_string'] = $event->status->name;
        }

        return datatables()->of($events)->addIndexColumn()->toJson();
    }
}
