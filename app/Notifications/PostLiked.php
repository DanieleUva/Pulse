<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostLiked extends Notification
{
    use Queueable;

    protected $userWhoLiked;
    protected $post;

    public function __construct($userWhoLiked, $post)
    {
        $this->userWhoLiked = $userWhoLiked;
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'follower_id' => $this->userWhoLiked->id, // Usiamo la stessa chiave per compatibilità con la vista
            'follower_name' => $this->userWhoLiked->name,
            'follower_username' => $this->userWhoLiked->username,
            'follower_avatar' => $this->userWhoLiked->getAvatarUrl(),
            'message' => 'ha messo like al tuo post!',
            'post_id' => $this->post->id,
        ];
    }
}