<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateChatAPIRequest;
use App\Http\Requests\API\UpdateChatAPIRequest;
use App\Http\Requests\API\GetChatAPIRequest;
use App\Models\Chat;
use App\Repositories\ChatRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\JsonResponse;
/**
 * Class ChatController
 * @package App\Http\Controllers\API
 */

class ChatAPIController extends AppBaseController
{
    /** @var  ChatRepository */
    private $chatRepository;

    public function __construct(ChatRepository $chatRepo)
    {
        $this->chatRepository = $chatRepo;
    }

    /**
     * Display a listing of the Chat.
     * GET|HEAD /chats
     *
     * @param Request $request
     * @return Response
     */
    public function index(GetChatAPIRequest $request): JsonResponse
    {
       $data = $request->validated();
       $isPrivate = 1;

       //private chat
       if($request->has('is_private')){

           $isPrivate = (int)$data['is_private'];

           //chats
           $chats = Chat::where('is_private',$isPrivate)->
           hasParticipants(auth()->user()->id)->
           whereHas('messages')-with('lastMessage.user','participants.user')
           ->latest('updated_at')->get();

           return $this->success($chats);

      }
    }

    /**
     * Store a newly created Chat in storage.
     * POST /chats
     *
     * @param CreateChatAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateChatAPIRequest $request):JsonResponse
    {
        $data = $this->perpareStoreData($request);
        if($data['userId'] == $data['otherUserId']){

            $response = [
                'success'=>false,
                'message'=> 'You cannot create a chat with yourself'
             ];
             return response()->json($response,200);
        }
        $previousChat = $this->getPreviousChat($data['otherUserId']);

        if($previousChat){
            $chat = Chat::create($data['data']);
            $chat->participants->createMany([

                ['user_id' => $data['userId']],
                ['user_id' => $data['otherUserId']]

            ]);
            $chat->refresh()->load('lastMessage.user','participants.user');
            return $this->success($chat);

        }
        return $this->success($previousChat->load('lastMessage.user','participants.user'));
    }



    public function getPreviousChat(int $otherUserId):bool{

        $userId = auth()->user()->id;
        return Chat::where('is_private',1)
        ->whereHas('participants',function($query) use($userId){
            $query->where('user_id',$userId);

        })
        ->whereHas('participants',function($query) use($otherUserId){
            $query->where('user_id',$otherUserId);
           })->first();

    }




    public function perpareStoreData(CreateChatAPIRequest $request)
    {
        $data = $request->validated();
        $otherUserId = (int)$data['user_id'];
        unset($data['user_id']);
        $data['created_by'] = auth()->user()->id;

        return [
            'otherUserId'=> $otherUserId,
            'userId'=> auth()->user()->id,
            'data' =>$data
        ];
    }

    /**
     * Display the specified Chat.
     * GET|HEAD /chats/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Chat $chat):JsonResponse
    {

       $chat->load('lastMessage.user','participants.user');
       return $this->success($chats);
        // /** @var Chat $chat */
        // $chat = $this->chatRepository->find($id);

        // if (empty($chat)) {
        //     return $this->sendError('Chat not found');
        // }

        // return $this->sendResponse($chat->toArray(), 'Chat retrieved successfully');
    }

    /**
     * Update the specified Chat in storage.
     * PUT/PATCH /chats/{id}
     *
     * @param int $id
     * @param UpdateChatAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateChatAPIRequest $request)
    {
        $input = $request->all();

        /** @var Chat $chat */
        $chat = $this->chatRepository->find($id);

        if (empty($chat)) {
            return $this->sendError('Chat not found');
        }

        $chat = $this->chatRepository->update($input, $id);

        return $this->sendResponse($chat->toArray(), 'Chat updated successfully');
    }

    /**
     * Remove the specified Chat from storage.
     * DELETE /chats/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Chat $chat */
        $chat = $this->chatRepository->find($id);

        if (empty($chat)) {
            return $this->sendError('Chat not found');
        }

        $chat->delete();

        return $this->sendSuccess('Chat deleted successfully');
    }
}
