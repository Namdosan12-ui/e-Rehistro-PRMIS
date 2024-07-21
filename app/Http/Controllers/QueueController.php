<?php
// app/Http/Controllers/QueueController.php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Releasing;

class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::with('transaction.patient')->where('status', 'pending')->get();
        return view('queues.index', compact('queues'));
    }

    public function show($id)
    {
        $queue = Queue::with('transaction.patient')->findOrFail($id);
        return view('queues.show', compact('queue'));
    }

    public function markAsDone($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->status = 'done';
        $queue->save();
    
        // Automatically create a releasing record
        Releasing::create([
            'transaction_id' => $queue->transaction_id,
        ]);
    
        return redirect()->route('queue.index')->with('success', 'Transaction marked as done and forwarded to releasing.');
    }

    public function display()
    {
        // Fetch queues from your model or wherever they are stored
        $queues = Queue::all(); // Example query, adjust as per your actual data retrieval logic

        return view('queue_display', [
            'queues' => $queues, // Pass $queues to the view
        ]);
    }

}
