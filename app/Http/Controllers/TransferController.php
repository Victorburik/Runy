<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Jobs\SendNotificationJob;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = Auth::user();
        $transfers = $user->sentTransfers()->with('toUser')->get()
            ->merge($user->receivedTransfers()->with('fromUser')->get());

        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        
        return view('transfers.create');
    }
}