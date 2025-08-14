<?php

namespace App\Http\Controllers;

use App\Models\GetTicket;
use App\Services\GetTicketOmieService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $getTicketService;

    public function __construct(GetTicketOmieService $getTicketService)
    {
        $this->getTicketService = $getTicketService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GetTicket $getTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GetTicket $getTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GetTicket $getTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GetTicket $getTicket)
    {
        //
    }
}
