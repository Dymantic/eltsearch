<?php

namespace App\Notifications;

use App\Purchasing\Package;
use App\Purchasing\Purchase;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseComplete extends Notification implements ActionableNotification, ShouldQueue
{
    use Queueable;

    protected $trans_key = "notifications.purchase_complete.";


    public function __construct(public Package $package, public Purchase $purchase, public User $buyer)
    {}

    protected function transKeyFor($field): string
    {
        return sprintf("%s%s", $this->trans_key, $field);
    }

    private function lang($notifiable)
    {
        return $notifiable->preferred_lang ?? 'en';
    }


    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->subject($this->getSubjectFor($notifiable))
            ->markdown('email.schools.purchase-complete', [
                'body' => $this->getMessageFor($notifiable),
                'action' => $this->actionTextFor($notifiable),
                'url' => $this->actionUrl($notifiable),
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'requires_translation' => true,
            'subject' => [
                'text' => $this->transKeyFor('subject'),
                'params' => [],
            ],
            'message' => [
                'text' => $this->transKeyFor('message'),
                'params' => [
                    'name' => $notifiable->name,
                    'package' => $this->package->getName(),
                    'price' => sprintf("$%.2f", $this->purchase->price / 100),
                    'buyer' => $this->buyerName($notifiable)
                ],
            ],
            'action' => ['text' => $this->transKeyFor('action'), 'params' => []],
            'action_url' => $this->actionUrl($notifiable),
            'extra_fields' => []
        ];
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
            //
        ];
    }

    public function getSubjectFor($notifiable): string
    {
        return trans($this->transKeyFor('subject'), [], $this->lang($notifiable));
    }

    public function getMessageFor($notifiable): string
    {
        return trans($this->transKeyFor('message'), [
            'name' => $notifiable->name,
            'package' => $this->package->getName(),
            'price' => sprintf("$%.2f", $this->purchase->price / 100),
            'buyer' => $this->buyerName($notifiable)
        ], $this->lang($notifiable));
    }

    private function buyerName($notifiable)
    {
        if($notifiable->is($this->buyer)) {
            return trans($this->transKeyFor('you'), [], $this->lang($notifiable));
        }

        return $this->buyer->name;
    }

    public function actionTextFor($notifiable): string
    {
        return trans($this->transKeyFor('action'), [], $this->lang($notifiable));
    }

    public function actionUrl($notifiable): string
    {
        return url("/schools#/purchases/{$this->purchase->id}");
    }
}
