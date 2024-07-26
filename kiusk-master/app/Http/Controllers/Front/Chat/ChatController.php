<?php

namespace App\Http\Controllers\Front\Chat;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use App\Services\Chat\CustomChatify as Chat;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $chatify;
    protected $perPage = 30;

    public function __construct(Chat $chatify)
    {
        $this->chatify = $chatify;
    }

    public function index(Request $request, $id = null)
    {
        if( $id == Auth::id()){
            return back()->with(['message' => __('messages.self_chat_restriction')]);
        }
        $request = $request->merge(['id' => $id]);
        return $this->chatify->index($id);
    }

    /**
     * Get shared photos
     *
     * @param Request $request
     * @return JsonResponse|void
     */
    public function sharedPhotos(Request $request)
    {
        $shared = Chatify::getSharedPhotos($request['user_id']);
        $sharedPhotos = null;

        // shared with its template
        for ($i = 0; $i < count($shared); $i++) {
            $sharedPhotos .= view('Chatify::layouts.listItem', [
                'get' => 'sharedPhoto',
                'image' => Chatify::getAttachmentUrl($shared[$i]),
            ])->render();
        }
        // send the response
        return Response::json([
            'shared' => count($shared) > 0 ? $sharedPhotos : '<p class="message-hint"><span>Nothing to shared yet</span></p>',
        ], 200);
    }

    /**
     * fetch [user/group] messages from database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request)
    {
        $query = Chatify::fetchMessagesQuery($request['id'])->latest();
        $messages = $query->paginate($request->per_page ?? $this->perPage);
        $totalMessages = $messages->total();
        $lastPage = $messages->lastPage();
        $response = [
            'total' => $totalMessages,
            'last_page' => $lastPage,
            'last_message_id' => collect($messages->items())->last()->id ?? null,
            'messages' => '',
        ];

        // if there is no messages yet.
        if ($totalMessages < 1) {
            $response['messages'] ='<p class="message-hint center-el"><span>Say \'Hello\' and start messaging</span></p>';
            return Response::json($response);
        }
        if (count($messages->items()) < 1) {
            $response['messages'] = '';
            return Response::json($response);
        }
        $allMessages = null;
        foreach ($messages->reverse() as $message) {
            $allMessages .= Chatify::messageCard(
                Chatify::parseMessage($message)
            );
        }
        $response['messages'] = $allMessages;
        return Response::json($response);
    }

    public function sendMessage(Request $request)
    {
        return $this->chatify->send($request);
    }
}
