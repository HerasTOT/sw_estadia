<?php

namespace App\Http\Controllers;

use App\Models\calendar_announcement;
use App\Http\Requests\Storecalendar_announcementRequest;
use App\Http\Requests\Updatecalendar_announcementRequest;

class CalendarAnnouncementController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storecalendar_announcementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storecalendar_announcementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\calendar_announcement  $calendar_announcement
     * @return \Illuminate\Http\Response
     */
    public function show(calendar_announcement $calendar_announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\calendar_announcement  $calendar_announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(calendar_announcement $calendar_announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatecalendar_announcementRequest  $request
     * @param  \App\Models\calendar_announcement  $calendar_announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Updatecalendar_announcementRequest $request, calendar_announcement $calendar_announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\calendar_announcement  $calendar_announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(calendar_announcement $calendar_announcement)
    {
        //
    }
}
