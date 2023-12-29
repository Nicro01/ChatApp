<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\RoomUserPivot;

class ChatController extends Controller
{
    public function rooms(Request $request)
    {
        $pivot = RoomUserPivot::where('user_id', Auth::id())->get();

        $rooms = [];
        foreach ($pivot as $p) {
            $room = ChatRoom::where('id', $p->room_id)->first();
            array_push($rooms, $room);
        }

        return $rooms;
    }

    public function messages(Request $request, $roomId)
    {
        return ChatMessage::where('chat_room_id', $roomId)
            ->with('user')
            ->orderByDesc('created_at')
            ->get();
    }

    public function loggedUser(Request $request)
    {
        return Auth::user();
    }

    public function newMessage(Request $request, $roomId)
    {
        $newMessage = new ChatMessage();
        $newMessage->user_id = Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();

        broadcast(new NewChatMessage($newMessage))->toOthers();

        return $newMessage;
    }

    public function newRoom(Request $request)
    {
        $roomName = $request->name;
        $userId = Auth::id();

        $existingRoom = ChatRoom::where('name', $roomName)->first();

        if ($existingRoom) {
            $userInRoom = RoomUserPivot::where('user_id', $userId)
                ->where('room_id', $existingRoom->id)
                ->exists();

            if ($userInRoom) {
                return ['error' => 'Room name already exists - already in room'];
            }

            $this->createRoomUserPivot($userId, $existingRoom->id);

            return ['error' => 'Room name already exists - joined room'];
        }

        $newRoom = ChatRoom::create(['name' => $roomName]);

        $this->createRoomUserPivot($userId, $newRoom->id);

        return $newRoom;
    }

    private function createRoomUserPivot($userId, $roomId)
    {
        RoomUserPivot::create([
            'user_id' => $userId,
            'room_id' => $roomId
        ]);
    }
}
