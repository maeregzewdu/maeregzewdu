<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Http\Controllers\DashboardController;

class ContactMessageController extends Controller
{
    private $dashboardController;

    public function __construct(DashboardController $dashboardController)
    {
        $this->dashboardController = $dashboardController;
    }
    /**
     * Store a new contact message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate with custom rules
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'subject' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string', 'max:5000'],
            ]);

            // Set default status
            $validatedData['status'] = 'unread';

            // Use transaction to ensure data integrity
            DB::beginTransaction();
            try {
                $message = ContactMessage::create($validatedData);
                DB::commit();

                // Clear relevant caches
                $this->clearMessageCaches();

                $response = [
                    'success' => true, 
                    'message' => 'Thank you for your message! I will get back to you as soon as possible.'
                ];

                $this->dashboardController->clearCache();

                return $request->expectsJson() 
                    ? response()->json($response)
                    : redirect()->back()->with('success', $response['message']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to create contact message: ' . $e->getMessage());
                Log::error($e->getTraceAsString());
                
                return $request->expectsJson()
                    ? response()->json([
                        'success' => false, 
                        'message' => 'Failed to save message.',
                        'error' => config('app.debug') ? $e->getMessage() : null
                    ], 500)
                    : redirect()->back()->with('error', 'Failed to save message.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $request->expectsJson()
                ? response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422)
                : redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error in contact message submission: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return $request->expectsJson()
                ? response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500)
                : redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }

    /**
     * Update message status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactMessage  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMessageStatus(Request $request, ContactMessage $message)
    {
        $validatedData = $request->validate([
            'status' => ['required', Rule::in(['read', 'unread', 'archived', 'unarchived', 'deleted'])],
        ]);

        DB::beginTransaction();
        try {
            // Use a switch statement for better performance and readability
            switch ($validatedData['status']) {
                case 'read':
                    $message->markAsRead();
                    break;
                case 'unread':
                    $message->markAsUnread();
                    break;
                case 'archived':
                    $message->markAsArchived();
                    break;
                case 'unarchived':
                    $message->markAsUnarchived();
                    break;
                case 'deleted':
                    $message->markAsDeleted();
                    break;
            }
            
            DB::commit();
            
            // Clear relevant caches
            $this->clearMessageCaches();
            $this->dashboardController->clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Message status updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update message status'
            ], 500);
        }
    }

    /**
     * Delete a message permanently.
     *
     * @param  \App\Models\ContactMessage  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMessage(ContactMessage $message)
    {
        DB::beginTransaction();
        try {
            $message->permanentlyDelete();
            DB::commit();

            // Clear relevant caches
            $this->clearMessageCaches();
            $this->dashboardController->clearCache();

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete message'
            ], 500);
        }
    }

    /**
     * Clear all message-related caches.
     *
     * @return void
     */
    private function clearMessageCaches()
    {
        // Clear specific cache keys instead of using tags
        Cache::forget('dashboard.messages');
        Cache::forget('dashboard.recent_messages');
        Cache::forget('dashboard.message_counts');
        Cache::forget('messages.all');
    }
}
