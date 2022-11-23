<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingStatusRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $booking = auth()->user()->bookings();

        if($request->get('status', null))
            $booking->where('status', $request->get('status'));
        if($request->get('limit', null)) {
            $booking->take($request->get('limit'));
            if ($request->get('offset', null))
                $booking->skip($request->get('offset'));
        }

        return response(BookingResource::collection($booking->get()), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        $booking = auth()->user()->bookings()->create($request->validated());
        return response(BookingResource::make($booking), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return response(BookingResource::make($booking), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingRequest  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        if($booking->user()->id != auth()->id())
            return response()->noContent(403);
        $booking->update($request->validated());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        if($booking->user()->id != auth()->id())
            return response()->noContent(403);
        $booking->delete();
        return response()->noContent(410);
    }

    /**
     * Edit status booking
     *
     * @param BookingStatusRequest $request
     * @param Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function status(BookingStatusRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        return response()->noContent(202);
    }
}
