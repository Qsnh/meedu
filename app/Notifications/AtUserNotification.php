<?php

namespace App\Notifications;

use App\Models\CourseComment;
use App\Models\VideoComment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AtUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $fromUser;

    protected $fromType;

    protected $fromId;

    protected $fromComment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $fromUser, $fromType, $fromId)
    {
        $this->fromUser = $fromUser;
        $this->fromType = $fromType;
        $this->fromId = $fromId;

        $method = 'get' . ucfirst($this->fromType);
        if (method_exists($this, $method)) {
            $this->fromComment = $this->$method($fromId);
        }
    }

    protected function getVideoComment($id)
    {
        return VideoComment::whereId($id)->first();
    }

    protected function getCourseComment($id)
    {
        return CourseComment::whereId($id)->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("用户{$this->fromUser->nick_name}@您啦，快来看看吧")
            ->view('emails.at', [
                'fromUser' => $this->fromUser,
                'comment' => $this->fromComment,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'from_user_id' => $this->fromUser->id,
            'from_type' => $this->fromType,
            'from_id' => $this->fromId,
        ];
    }
}
